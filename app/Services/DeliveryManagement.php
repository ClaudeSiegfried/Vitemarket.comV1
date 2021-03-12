<?php
/**
 * Created by IntelliJ IDEA.
 * User: PC
 * Date: 19/09/2020
 * Time: 18:10
 */

namespace App\Services;


use App\Models\Livraison;
use App\Models\Localisation;
use App\Models\Produit;

class DeliveryManagement
{
    public static function Deliveries()
    {
        $list = Livraison::all();

        foreach ($list as $D) {

            $c = $D->commande()->get()->first();

            $livreur = $D->livreur()->get()->first();

            $Commande = $D->commande()->get()->first();

            $Client = $Commande->client()->get()->first();

            $livreur_name= StockManagement::getModelAttribute($livreur, 'name', 'user');

            $pr_list = Produit::query()->GetProduits($c->panier_id)->get();

            $loc = Localisation::query()->find($c->localisation_id);

            if ($livreur) {
                $D->livreur =  $livreur_name;
            } else {
                $D->livreur =  "";
            }

            if ($loc) {
                $D->localisation =  $loc->description;
                $D->localisation_info =  $loc;
            } else {
                $D->localisation =  "";
            }

            $Client ? $D->client = $Client->name : '';



            foreach ($pr_list as $p) {

                $produit = Produit::query()->find($p->produit_id)->get();

                foreach ($produit as $item) {

                    $panier = [];

                    if ($item->id == $p->produit_id) {
                        $p->produit_id = $p->produit;
                        $p->produit = $item;

                        $item->path = url(route('photo.display', (StockManagement::getModelAttribute($item, 'path', 'photo'))));
                        $item->marque = StockManagement::getModelAttribute($item, 'libele', 'marque');
                        $item->categorie = StockManagement::getModelAttribute($item, 'libele', 'categorie');

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

            $D->commande = $c;

            $D->livreur_id = $livreur_name;

            unset($D->livreur_id);

        }

        return $list;
    }

}
