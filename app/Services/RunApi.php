<?php
/**
 * Created by IntelliJ IDEA.
 * User: PC
 * Date: 22/07/2020
 * Time: 05:14
 */

namespace App\Services;


use App\Models\OtpModel;
use App\Notifications\AchatValideNotification;
use App\Notifications\SendOtpNotification;
use App\Notifications\SuccessLoginNotificationFCM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Throwable;

class RunApi
{
    public $status_code = 200;

    public $unauthorized_code = 401;

    private function bearer(Request $request): bool
    {
        return StakeholdersManagement::verifyToken($request->bearerToken()) == true;
    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
            'tel' => ['required', 'numeric', 'min:8'],
            'uid' => ['nullable', 'unique:users'],
        ];

        $request->validate($rules, ($request->all()));

        $user = StakeholdersManagement::apiUserStore($request);

        $token = StockManagement::getToken();

        try {
            if ($user) {

                return $this->respondWithToken($token, $user, 'success', $this->status_code);
            }

            return $this->respondWithToken($token, $user, 'unauthorized', $this->unauthorized_code);

        } catch (Throwable $e) {

            return report($e);
        }


    }

    public function login(Request $request): ?\Illuminate\Http\JsonResponse
    {
        if ($user = (new StakeholdersManagement)->apiLogin($request)) {

            $token = $request->bearerToken();

            if ($user->fcm) {
                $user->notify(new SuccessLoginNotificationFCM($user));
            }

            return $this->respondWithToken($token, $user, 'success', $this->status_code);

        } else {

            return $this->respondWithToken(null, $user, 'unauthorized', $this->unauthorized_code);

        }
    }

    public function LoginFirebase(Request $request): ?\Illuminate\Http\JsonResponse
    {
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users'],
            'uid' => ['required', 'exists:users'],
        ];

        $request->validate($rules, ($request->all()));

        if ($user = (new StakeholdersManagement)->apiLoginFirebase($request)) {

            $token = $request->bearerToken();

            if ($user->fcm) {
                $user->notify(new SuccessLoginNotificationFCM($user));
            }

            return $this->respondWithToken($token, $user, 'success', $this->status_code);

        } else {

            return $this->respondWithToken(null, $user, 'unauthorized', $this->unauthorized_code);

        }
    }

    public function GetProductsCollection(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = (new StakeholdersManagement)->apiLogin($request);

        $token = $request->bearerToken();

        if ($this->bearer($request)) {

            $data = (new StockManagement)->allStock();

            return $this->respondWithToken($token, $data, 'success', $this->status_code);

        }

        return $this->respondWithToken($token, $user, 'unauthorized', $this->unauthorized_code);
    }

    public function GetProductsCollectionV2(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = (new StakeholdersManagement)->apiLogin($request);

        $token = $request->bearerToken();

        if ($this->bearer($request)) {

            $data = (new StockManagement)->allStockV2();

            return $this->respondWithToken($token, $data, 'success', $this->status_code);

        }

        return $this->respondWithToken($token, $user, 'unauthorized', $this->unauthorized_code);
    }

    public static function GetCategoriesCollection(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = (new StakeholdersManagement)->apiLogin($request);

        $token = $request->bearerToken();

        if ((new self)->bearer($request)) {

            $data = StockManagement::allCategories();

            return (new self)->respondWithToken($token, $data, 'success', (new self)->status_code);

        }
        return (new self)->respondWithToken($token, $user, 'unauthorized', (new self)->unauthorized_code);
    }

    public static function GetUserHistory(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = (new StakeholdersManagement)->apiLogin($request);

        $token = $request->bearerToken();

        if ((new self)->bearer($request)) {

            $data = OrdersManagement::GetUserHistory($request);

            return (new self)->respondWithToken($token, $data, 'success', (new self)->status_code);

        }
        return (new self)->respondWithToken($token, $user, 'unauthorized', (new self)->unauthorized_code);
    }

    public static function NewBasket(Request $request): \Illuminate\Http\JsonResponse
    {

        $user = (new StakeholdersManagement)->apiLogin($request);
        $data = null;
        $token = $request->bearerToken();

        if ((new self)->bearer($request)) {

            $data = array('panierId' => (OrdersManagement::NewBasket($request)));

            return (new self)->respondWithToken($token, $data, 'success', (new self)->status_code);

        }
        return (new self)->respondWithToken($token, $data, 'unauthorized', (new self)->unauthorized_code);
    }

    public static function UpdateBasket(Request $request): \Illuminate\Http\JsonResponse
    {

        $user = (new StakeholdersManagement)->apiLogin($request);
        $data = null;

        $token = $request->bearerToken();

        if ((new self)->bearer($request)) {

            $data = array('panierId' => (OrdersManagement::UpdateBasket($request)));

            return (new self)->respondWithToken($token, $data, 'success', (new self)->status_code);

        }
        return (new self)->respondWithToken($token, $data, 'unauthorized', (new self)->unauthorized_code);
    }

    public static function NewOrder(Request $request)
    {
        $user = (new StakeholdersManagement)->apiLogin($request);

        $data = [
            'panier_id' => 'required',
            'user_id' => 'required',
            'localisation_id' => 'required',
            'date_livraison' => 'required|nullable|date',
        ];

        $token = $request->bearerToken();

        if ((new self)->bearer($request)) {

            $data = OrdersManagement::NewOrder($request);

            return (new self)->respondWithToken($token, $data, 'success', (new self)->status_code);

        }

        return (new self)->respondWithToken($token, $data, 'unauthorized', (new self)->unauthorized_code);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function NewAddress(Request $request): \Illuminate\Http\JsonResponse
    {


        $user = (new StakeholdersManagement)->apiLogin($request);

        $data = [
            'User_id' => 'required',
            'Photo' => 'sometimes',
            'latitude' => 'required',
            'longitude' => 'required',
            'proximite' => 'sometimes',
            'description' => 'required'

        ];

        $request->validate($data, ($request->all()));

        $token = $request->bearerToken();

        if ((new self)->bearer($request)) {

            $data = StakeholdersManagement::NewAddress($request);

            return (new self)->respondWithToken($token, $data, 'success', (new self)->status_code);

        }

        return (new self)->respondWithToken($token, $data, 'unauthorized', (new self)->unauthorized_code);
    }

    public static function UpdateAddress(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = (new StakeholdersManagement)->apiLogin($request);

        $data = [
            'localisation_id' => 'required',
            'User_id' => 'required',
            'Photo' => 'optional',
            'latitude' => 'required',
            'longitude' => 'required',
        ];

        $token = $request->bearerToken();

        if ((new self)->bearer($request)) {

            $data = StakeholdersManagement::UpdateAddress($request);

            /** @var Array $data */
            return (new self)->respondWithToken($token, $data, 'success', (new self)->status_code);

        }

        return (new self)->respondWithToken($token, $user, 'unauthorized', (new self)->unauthorized_code);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function UserAddress(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = (new StakeholdersManagement)->apiLogin($request);

        /*        $data = [
                    'User_id'=>'required',
                ];*/

        $token = $request->bearerToken();

        if ((new self)->bearer($request)) {

            $data = StakeholdersManagement::UserAddress($request);

            return (new self)->respondWithToken($token, $data, 'success', (new self)->status_code);

        }

        return (new self)->respondWithToken($token, $user, 'unauthorized', (new self)->unauthorized_code);
    }

    public static function DeleteAddress(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = (new StakeholdersManagement)->apiLogin($request);

        /*        $data = [
                    'User_id'=>'required',
                ];*/

        $token = $request->bearerToken();

        if ((new self)->bearer($request)) {

            $data = StakeholdersManagement::DeleteAddress($request);

            return (new self)->respondWithToken($token, $data, 'success', (new self)->status_code);

        }

        return (new self)->respondWithToken($token, $user, 'unauthorized', (new self)->unauthorized_code);
    }

    public static function GetToken(): \Illuminate\Http\JsonResponse
    {

        $data = '';

        if (StockManagement::getToken()) {

            $data = StockManagement::getToken();

            return (new self)->respondWithToken($data, $data, 'success', (new self)->status_code);

        }

        return (new self)->respondWithToken($data, $data, 'unauthorized', (new self)->unauthorized_code);
    }

    public static function GetPaymentProviders(Request $request): \Illuminate\Http\JsonResponse
    {

        $user = (new StakeholdersManagement)->apiLogin($request);

        $token = $request->bearerToken();

        if ((new self)->bearer($request)) {

            $data = OrdersManagement::GetPaymentProviders();

            return (new self)->respondWithToken($token, $data, 'success', (new self)->status_code);

        }
        return (new self)->respondWithToken($token, $user, 'unauthorized', (new self)->unauthorized_code);
    }

    /*GetOtp*/

    public static function GetOtp(Request $request): ?\Illuminate\Http\JsonResponse
    {

        $rules = [
            'tel' => ['required'],
        ];

        $request->validate($rules, ($request->all()));


        if ($token = $request->bearerToken()) {
            try {
                $generateOtp = rand(0000, 9999);

                $tel = $request->tel;

                $otp = new OtpModel($generateOtp, $tel);

                Notification::sendNow($otp, new SendOtpNotification($generateOtp));

                return (new RunApi)->respondWithToken($token, $generateOtp, 'success', (new self)->status_code);

            } catch (Throwable $e) {

                return (new RunApi)->respondWithToken($token, report($e), 'success', (new self)->status_code);

            }
        }
        return (new RunApi)->respondWithToken($token, null, 'success', (new self)->status_code);

    }

    public static function SaveFcmToken(Request $request): ?\Illuminate\Http\JsonResponse
    {

        $rules = [
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users'],
            'fcm' => ['required', 'string'],
        ];

        $request->validate($rules, ($request->all()));

        if ($token = $request->bearerToken()) {

            $fcm = StockManagement::SaveFcmToken($request);

            return (new RunApi)->respondWithToken($token, $fcm, 'success', (new self)->status_code);

        }

        return null;
    }

    protected function respondWithToken($token, $data, string $status, $status_code): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'access_token' => $token,
            'token_type' => 'bearer',
            'data' => json_encode($data),
        ], $status_code);
    }

}
