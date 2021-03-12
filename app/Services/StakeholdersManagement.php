<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Livreur;
use App\Models\Localisation;
use App\Models\Photo;
use App\Models\Role;
use App\Models\User;
use App\Notifications\AchatValideNotification;
use App\Notifications\OtpNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Rules\UserUpdateRule;
use Throwable;

class StakeholdersManagement
{
    private $apiToken;

    protected $resultat = array();

    public function setApiToken(): string
    {
        return hash('sha256', Str::random(80));

    }

    public static function ApiToken(): string
    {
        return hash('sha256', Str::random(80));

    }

    public function getApiToken(User $user): string
    {
        return (string)implode('', $user->get()->pluck('remember_token')->toArray());
    }

    public static function verifyToken(string $token = null)
    {
        if (!empty($token)) {
            $response = DB::table('users')->where('remember_token', $token)->count();

            return ($response == 1) ? true : false;
        }
    }

    public function updateUser(Request $request, User $user): bool
    {
        try {
            $Photo = new Photo();

            $user->roles()->sync($request->role);

            if ($user->update($request->all())) {
                return true;
            };

            return $Photo->SaveOrUpdate($request, 'photo_id', $user, 'user');

        } catch (Throwable $e) {
            report($e);
            return false;
        }


    }

    /*Update User */

    public static function updateRequestedUser(Request $request): ?bool
    {

        $Photo = new Photo();

        $user = new User();

        try {
            $user->fill($request->user->toArray());

            $Photo->SaveOrUpdate($request, 'photo_id', $user, 'user');

            if ($request->has('role')) {

                $user->roles()->sync($request->role);

                $id = $user->id;

                if (!empty($user)) {

                    if ($user->hasRole('fournisseur')) {
                        $user->suppliers()->updateOrCreate(['user_id' => $id]);
                    } else if ($user->suppliers()->exists()) {
                        $current = $user->clients()->get()->first();
                        if (isset($current)) (new self)->ManageDelete($current);
                    }

                    if ($user->hasRole('livreur')) {
                        $user->deliverers()->updateOrCreate(['user_id' => $id]);
                    } else if ($user->deliverers()->exists()) {
                        $current = $user->deliverers()->get()->first();
                        if (isset($current)) (new self)->ManageDelete($current);
                    }

                    if ($user->hasRole('client')) {
                        $user->clients()->updateOrCreate(['user_id' => $id]);
                    } else if ($user->clients()->exists()) {
                        $current = $user->clients()->get()->first();
                        if (isset($current)) (new self)->ManageDelete($current);
                    }
                }

            }

            if (($request->user)->update($request->except(['role', 'photo_id']))) {
                return true;
            } else {
                return false;
            }

        } catch (Throwable $e) {
            report($e);

            return false;
        }

    }

    public static function deleteUser(User $user): bool
    {
        try {
            $result = (new self)->ManageDelete($user);
            if (in_array('U_Case', $result, true)) {
                return false;
            }
            $user->roles()->detach();
            $user->delete();
            return true;

        } catch (Throwable $e) {
            report($e);

            return false;
        }


    }

    public static function deleteSupplier(Fournisseur $fournisseur): bool
    {
        try {

            $result = (new self())->ManageDelete($fournisseur);

            $F_user = $fournisseur->user()->get()->first();
            if (in_array('F_Case', $result, true)) {
                return false;
            }

            if (!$F_user->hasAnyRoles(['admin', 'client', 'livreur'])) {
                self::deleteUser($F_user);
            }
            ($F_user->roles()->detach(Role::Getidbyrole('fournisseur')));
            $fournisseur->delete();

            return true;

        } catch (Throwable $e) {
            report($e);

            return false;
        }

    }

    public static function deleteClient(Client $client): bool
    {
        try {
            $result = (new self())->ManageDelete($client);

            $F_user = $client->user()->get()->first();

            if (!$F_user->hasAnyRoles(['admin', 'fournisseur', 'livreur'])) {
                self::deleteUser($F_user);
                ($F_user->roles()->detach(Role::Getidbyrole('client')));
                $client->delete();
                return true;
            }
            if ($F_user->hasAnyRoles(['admin', 'fournisseur', 'livreur'])) {
                if (in_array('C_Case', $result, true)) {
                    return false;
                }
                return false;
            }

        } catch (Throwable $e) {

            return report($e);
        }

    }

    /*Manage user deletion*/

    public function ManageDelete(Model $model): array
    {
        $F_Case = 'F_Case';
        $L_Case = 'L_Case';
        $U_Case = 'U_Case';
        $C_Case = 'C_Case';

        try {

            if (is_a($model, User::class)) {
                if (($model->suppliers()->exists())) {
                    $Curent = $model->suppliers()->get()->first();
                    if (empty($this->ManageDelete($Curent))) {
                        $model->forceDelete();
                    }
                }
                if (($model->deliverers()->exists())) {
                    $Curent = $model->deliverers()->get()->first();
                    if (empty($this->ManageDelete($Curent))) {
                        $model->forceDelete();
                    }
                }
                if (($model->clients()->exists())) {
                    $Curent = $model->clients()->get()->first();
                    if (empty($this->ManageDelete($Curent))) {
                        $model->forceDelete();
                    }
                }
                if (!empty($this->resultat)) {
                    $this->resultat[] = $U_Case;
                }
            }

            if (is_a($model, Fournisseur::class) && $model->produits()->exists()) {
                $this->resultat[] = $F_Case;
            }

            if (is_a($model, Fournisseur::class) && $model->produits()->doesntExist()) {
                $model->delete();
            }

            if (is_a($model, Livreur::class) && $model->livraisons()->exists()) {
                $this->resultat[] = $L_Case;
            }

            if (is_a($model, Livreur::class) && $model->livraisons()->doesntExist()) {
                $model->delete();
            }

            if (is_a($model, Client::class) && $model->localisation()->exists()) {
                $this->resultat[] = $C_Case;
            }

            return $this->resultat;

        } catch (Throwable $e) {
            report($e);
            return [];
        }


    }

    public function apiLogin(Request $request)
    {
        try {
            if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {

                $user = auth()->user();

                return $user;
            }

        } catch (Throwable $e) {

            return report($e);
        }

    }

    public function apiLoginFirebase(Request $request)
    {
        try {

            $user = User::query()->WhereUid($request->uid)->first();

            if (auth()->loginUsingId($user->id)) {

                $user = auth()->user();

                return $user;
            }

        } catch (Throwable $e) {

            return report($e);
        }

    }

    public static function apiUserStore(Request $request)

    {

        try {

            if ($request->expectsJson()) {

                $user = User::query()->updateOrCreate([
                    'name' => $request->name,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'password' => Hash::make($request->password),
                    'uid' => $request->uid ?? null,
                    'remember_token' => (new StakeholdersManagement)->setApiToken()
                ]);
                if ($user) {
                    $role = Role::query()->select('id')->where('name', 'client')->first();

                    $user->roles()->attach($role);
                    $C = new Client();
                    $C->id = $user->id;
                    $user->clients()->save($C);
                }
                return $user;

            }

        } catch (Throwable $e) {

            return report($e);
        }

    }

    public static function NewAddress(Request $request)
    {

        try {

            if ($request->expectsJson()) {

                $user = User::query()->find($request->User_id)->first();

                //return $user;

                if ($localisation = $user->localisation()->firstOrNew([
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'user_id' => $request->user_id,
                    'description' => $request->description,
                    'proximite' => $request->proximite,
                ])) {
                    $l = $localisation->save();
                    $c = ($user->clients()->get()->first());
                    $c->localisation()->associate($l);

                    return self::UserAddress($request);
                }
            }

        } catch (Throwable $e) {
            report($e);
            return report($e);
        }
    }

    public static function UpdateAddress(Request $request)
    {
        try {

            if ($request->expectsJson()) {

                if ($request->user_id) {
                    $loc = Localisation::find($request->localisation_id)->first();
                }

                if ($localisation = $loc->update([
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'user_id' => $request->user_id,
                ])) {
                    return self::UserAddress($request);
                }
            }

        } catch (Throwable $e) {

            return report($e);
        }
        return false;
    }

    public static function UserAddress(Request $request)
    {
        $data = [
            'User_id' => 'required',
        ];

        try {

            if ($request->expectsJson()) {

                if ($request->User_id) {
                    $user = User::find($request->User_id)->first();
                    return $user->localisation()->get();
                }
            }

        } catch (Throwable $e) {

            return report($e);
        }

    }

    public static function DeleteAddress(Request $request)
    {
        $data = [
            'User_id' => 'required',
            'localisation_id' => 'required',
        ];

        try {
            if ($request->expectsJson()) {

                if ($request->user_id) {

                    $loc = Localisation::find($request->localisation_id)->first();
                }

                if ($loc->delete()) {
                    return self::UserAddress($request);
                }
            }
        } catch (Throwable $e) {

            return report($e);
        }

    }

}
