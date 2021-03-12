<?php


namespace App\Services;


use App\Models\Commande;
use App\Models\Localisation;
use App\Models\Mmoney;
use App\Models\Paiement;
use App\Models\Panier;
use App\Models\User;
use App\Models\Produit;
use App\Jobs\ProcessPaiementJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Str;

class OrdersManagement
{
    public static function NewBasket(Request $request)
    {
        try {

            if ($request->expectsJson()) {

                if (!$request->exists(['panier']) || !$request->exists(['user_id'])) {
                    return [
                        'panier' => 'required array of collection',
                        'user_id' => 'required id',
                    ];
                }

                $datas = json_decode(($request->get('panier')), true);

                if ($user = User::find($request->get('user_id'))) {
                    $panier = Panier::create();
                    $panier->user_id = $user->id;
                    $panier->save();
                    $panier_id = $panier->id;

                    foreach ($datas as $item) {
                        if ($Current_Product = Produit::find($item ['produit_id'])) {
                            //return $Current_Product->query()->VerifyStock($item ['quantite'], $Current_Product);
                            $Current_Product->panier()->attach($panier_id, ['quantite' => $item ['quantite']]);
                        }
                    }
                    return $panier_id;
                }

            }
        } catch (Throwable $e) {

            return report($e);
        }

    }

     public static function UpdateBasket(Request $request)
    {

        try {
            if ($request->expectsJson()) {
                $datas = json_decode(($request->get('panier')), true);
                $panier = Panier::find(($request->get('panier_id')));
                $panier_id = $panier->id;
                $relation = Produit::query()->GetPanierId($panier_id)->get();
                foreach ($relation as $r) {
                    $r->panier()->detach([$r->panier_id]);
                }

                foreach ($datas as $item) {
                    if ($Current_Product = Produit::find($item ['produit_id'])) {
                        $Current_Product->panier()->sync([$panier_id => ['quantite' => $item ['quantite']]]);
                    }
                }
            }
            return $panier_id;

        } catch (Throwable $e) {

            return report($e);
        }

    }

    public static function NewOrder(Request $request)
    {
        $data = [
            'panier_id' => 'required',
            'user_id' => 'required',
            'localisation_id' => 'required',
            'mmoney_id' => 'required|JSON:array',
            'total' => 'required',
            'phone_number' => 'nullable'
        ];

        $validator = $request->validate($data,($request->all()));

        try {

            if ($request->expectsJson() && $request->user_id) {

                $user = User::find($request->user_id)->get()->first();

                $Com = Commande::create([
                    'panier_id' => $request->panier_id,
                    'client_id' => $user->clients()->get('id')->first()->id,
                    'localisation_id' => $request->localisation_id,
                    'date_livraison' => Carbon::parse($request->date) ?? today(),
                    'code_commande' => Str::random(12)
                ]);

                ProcessPaiementJob::dispatchIf($Com, $Com, $request)->afterResponse();
                return $Com;

            }


        } catch (Throwable $e) {

            return report($e);
        }

    }

    public static function GetUserHistory(Request $request)
    {
        $data = [
            'user_id' => 'required',
        ];
        try {

            if ($request->expectsJson() && $request->user_id) {

                $result = [];
                $user = User::query()->findOrFail($request->user_id)->get()->first();
                if ($user && $user->clients()->get()->first()) {

                    $Client = $user->clients()->get()->first();

                    $Coms = $Client->commandes()->latest()->take(7)->get();

                    foreach ($Coms as $c) {

                        $pr_list = Produit::query()->GetProduits($c->panier_id)->get();

                        $loc = Localisation::find($c->localisation_id);

                        foreach ($pr_list as $p) {

                            $produit = Produit::find($p->produit_id)->get();

                            foreach ($produit as $item) {

                                $panier = [];

                                if ($item->id == $p->produit_id) {
                                    $p->produit_id = $p->produit;
                                    $p->produit = $item;

                                    $item->path = url(route('photo.display', (StockManagement::getModelAttribute($item, 'path', 'photo'))));
                                    $item->marque = StockManagement::getModelAttribute($item, 'libele', 'marque');
                                    $item->categorie = StockManagement::getModelAttribute($item, 'libele', 'categorie');
                                    if ($loc) {
                                        $item->localisation = $loc->description;
                                    } else {
                                        $item->localisation = "";
                                    }
                                    unset($p->produit_id);
                                    unset($item->photo_id);
                                    unset($item->marque_id);
                                    unset($item->categorie_id);
                                    unset($c->localisation_id);
                                    if (!empty($p)) {
                                        $panier[] = $p;
                                    }
                                }

                                if (!empty($panier)) {
                                    $result[] = $panier[0];
                                }
                            }
                        }

                        $c->panier = $result;
                    }

                    return $Coms;
                }

            }

        } catch (Throwable $e) {
            report($e);
            return report($e);
        }

    }

    public static function GetOrders()
    {

/*        try {*/

            //$Client = $user->clients()->get()->first();

            $Coms = Commande::all();

            foreach ($Coms as $c) {

                $pr_list = Produit::query()->GetProduits($c->panier_id)->get();

                $loc = Localisation::query()->find($c->localisation_id);

                $client = $c->client()->get()->first();

                $client_name = StockManagement::getModelAttribute($client, 'name', 'user');

                $c->client = $client_name;

                if ($loc){
                    $c->localisation = $loc->description;
                }else{
                    $c->localisation = '';
                }


                foreach ($pr_list as $p) {

                    $produit = Produit::find($p->produit_id)->get();

                    foreach ($produit as $item) {

                        $panier = [];

                        if ($item->id == $p->produit_id) {
                            $p->produit_id = $p->produit;
                            $p->produit = $item;

                            $item->path = url(route('photo.display', (StockManagement::getModelAttribute($item, 'path', 'photo'))));
                            $item->marque = StockManagement::getModelAttribute($item, 'libele', 'marque');
                            $item->categorie = StockManagement::getModelAttribute($item, 'libele', 'categorie');
                            if ($loc) {
                                $item->localisation = $loc->description;
                            } else {
                                $item->localisation = "";
                            }
                            unset($p->produit_id);
                            unset($item->photo_id);
                            unset($item->marque_id);
                            unset($item->categorie_id);
                            unset($c->localisation_id);
                            if (!empty($p)) {
                                $panier[] = $p;
                            }
                        }

                        if (!empty($panier)) {
                            $result[] = $panier[0];
                        }
                    }

                }

                $c->panier = $result;
            }

            return $Coms;


/*        } catch (Throwable $e) {
            report($e);
            return report($e);
        }*/

    }

    public static function GetPaymentProviders()
    {
        try {
            return Mmoney::all();
        } catch (Throwable $e) {
            return report($e);
        }
    }

}
