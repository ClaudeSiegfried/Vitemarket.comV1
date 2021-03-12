<?php

namespace App\Services;

use App\Models\Categorie;
use App\Models\Etiquette;
use App\Models\Expiration;
use App\Models\Fournisseur;
use App\Models\Marque;
use App\Models\Mmoney;
use App\Models\Photo;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\User;
use App\Http\Resources\Stocks as StocksRessource;
use App\Http\Resources\Stock as StockJson;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Throwable;

class StockManagement
{

    /*Associer un Produit aux classes*/

    public static function getModelAttribute(Model $model, string $attribute, $attribute_function)
    {
        try {
            return (string)implode('', $model->$attribute_function()->get()->pluck($attribute)->toArray());
        } catch (Throwable $e) {
            report($e);
            return report($e);
        }
    }

    /*get a model*/

    public static function getModel(Model $model, $attribute_function)
    {
        try {
            return $model->$attribute_function()->get()->first();
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    /*Dissocier un Produit des classes*/

    public static function UnLinkProduct(Produit $produit)
    {
        try {
            if (
                $produit->categorie()->dissociate()->exists &&
                $produit->marque()->dissociate()->exists &&
                $produit->fournisseur()->dissociate()->exists ||
                $produit->etiquette()->exists()
            )
            {
                $produit->categorie()->dissociate();
                $produit->marque()->dissociate();
                $produit->fournisseur()->dissociate();
                $produit->etiquette()->detach();
                return true;
            } else {
                return false;
            }

        } catch (Throwable $e) {
            report($e);
            return false;
        }

    }

    /*Return any model attribute to string*/

    public function storeProduct(Request $request)
    {

        try {
            $Photo = new Photo();

            $stock = new Stock();

            $produit = Produit::firstOrCreate($request->except(['photo_id', '_token', 'quantite_physique', 'expiration_id', 'etiquette']));

            $Photo->SaveOrUpdate($request, 'photo_id', $produit, 'produit');

            $exp = Expiration::firstOrCreate(['date_de_peremption' => $request->expiration_id]);

            $stock->firstOrCreate([
                'quantite_physique' => $request->quantite_physique > 0 ? $request->quantite_physique : 1,
                'quantite_predebite' => 0,
                'quantite_facture' => 0,
                'produit_id' => $produit->id,
                'expiration_id' => $exp->id,
            ]);

            $this->LinkProduct($request, $produit);

            return true;

        } catch (Throwable $e) {
            report($e);
            return false;
        }


    }

    /*Mettre a jour un produit et y associer le stock et la date d'expiration*/

    public function updateProduct(Request $request, Produit $produit)
    {
        try {

            $Photo = new Photo();

            $produit->update($request->except(['photo_id', '_token', 'quantite_physique', 'expiration_id']));

            $Photo->SaveOrUpdate($request, 'photo_id', $produit, 'produit');

            $exp = Expiration::firstOrCreate(['date_de_peremption' => $request->expiration_id]);

            $produit->stock()->update([
                'quantite_physique' => $request->quantite_physique > 0 ? $request->quantite_physique : 1,
                'produit_id' => $produit->id,
                'expiration_id' => $exp->id,
            ]);

            $this->UnLinkProduct($produit);
            $this->LinkProduct($request, $produit);

            return true;

        } catch (Throwable $e) {
            report($e);

            return false;
        }

    }

    /*delete a product*/

    public function deleteProduct(Produit $produit)
    {
        try {
            $Qte = (int)$this->getModelAttribute($produit, 'quantite_physique', 'stock');
            if ($Qte <= 1) {
                $this->UnLinkProduct($produit);
                $this->deletePhoto($produit);
                $produit->stock()->delete();
                try {
                    $produit->delete();
                    return true;
                } catch (\Exception $e) {
                    return false;
                }
            };

        } catch (Throwable $e) {
            report($e);

            return false;
        }

    }

    /*store a Category*/

    public function storeCategory(Request $request, Categorie $categorie)
    {
        try {
            $Photo = new Photo();

            $Photo->SaveOrUpdate($request, 'photo_id', $categorie, 'categorie');

            if ($categorie->update($request->except(['photo_id']))) {
                return true;
            };

        } catch (Throwable $e) {
            report($e);
            return false;
        }

    }

    /*delete a Category*/

    public function deleteCategory(Categorie $categorie): ?bool
    {

        if ($categorie->produits()->exists()) {
            return false;
        } else {
            try {
                if ($this->deletePhoto($categorie)) {
                    $categorie->delete();
                    return true;
                }
            } catch (\Exception $e) {
            }
        }
    }

    /*delete Marque*/

    public static function deleteMarque(Marque $marque): ?bool
    {

        if ($marque->produits()->exists()) {
            return false;
        } else {
            try {
                $marque->delete();
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    /*delete categories*/

    public static function deleteMmoney(Mmoney $mmoney): ?bool
    {

        if ($mmoney->paiements()->exists()) {
            return false;
        }

        try {
            $mmoney->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /*Delete a Photo*/

    public function deletePhoto(Model $model): bool
    {
        try {

            $photo = new  Photo();

            if ($model->belongsTo(Photo::class)) {

                $path = $model->photo()->get()->pluck('path')->first();

                if ((!empty($path)) && ($model->photo()->exists())) {

                    if (!$photo->deletePhoto($path)) {
                        $model->photo()->dissociate($model->photo()->get()->first());
                    };
                } else {
                    $model->photo()->dissociate($model->photo()->get()->first());
                }

                return true;
            }

        } catch (Throwable $e) {
            report($e);

            return false;
        }

    }

    /*Enregistrer un produit et y associer le stock et la date d'expiration*/

    public function LinkProduct(Request $request, Produit $produit): ?bool
    {

        try {
            $categorie = new Categorie();
            $marque = new Marque();
            $fournisseur = new Fournisseur();

            $categorie->id = $request->categorie_id;
            $marque->id = $request->marque_id;
            $fournisseur->id = $request->fournisseur_id;
            $marque->produits()->sync($produit);
            if ($request->etiquette){
                $produit->etiquette()->sync($request->etiquette);
            }
            return $produit->categorie()->associate($categorie) &&
                $produit->marque()->associate($marque) &&
                $produit->fournisseur()->associate($fournisseur) &&
                $marque->produits()->sync($produit);

        } catch (Throwable $e) {
            report($e);

            return false;
        }

    }

    /*return all stock data*/

    /**
     * @return Collection
     */
    public function allStock(): Collection
    {
        try {

            $stock = Stock::all();
            $result = new Collection();

            foreach ($stock as $s) {
                $exp = $s->expiration()->get('date_de_peremption')->first();
                $produit = $s->produit()->get()->first();

                if ($produit instanceof Produit) {

                    $path = collect([
                        'path' => url(route('photo.display', (self::getModelAttribute($produit, 'path', 'photo'))))
                    ]);
                    $categorie = collect([
                        'categorie' => self::getModelAttribute($produit, 'libele', 'categorie')
                    ]);
                    $marque = collect([
                        'marque' => self::getModelAttribute($produit, 'libele', 'marque')
                    ]);
                    $p = collect($produit);
                    $e = collect($exp);
                    $data = $p->merge($s)->merge($e)->merge($path)->merge($categorie)->merge($marque);

                    if ($result->isEmpty()) {
                        $result = ($result->push((object)$data->toArray()));
                    } else {
                        $result = ($result->push((object)$data->toArray()));
                    }
                }
            }

            return $result;

        } catch (Throwable $e) {
            report($e);
            return report($e);
        }

    }

    public function allStockV2($page = 1)
    {
        try {

            $result = StockJson::collection(Stock::all()->forPage($page,16)->sortByDesc('id'));

            if($result ->isEmpty()){
                return StockJson::collection(Stock::all()->forPage(1,16)->sortByDesc('id'));
            }

            return $result;
            //return new StocksRessource(StockJson::collection(Stock::paginate(10)->sortByDesc('id')));
            //return new StocksRessource(Categorie::paginate());

        } catch (Throwable $e) {
            report($e);
            return report($e);
        }

    }

    /*return aull products categories*/

    public static function allCategories(): Collection
    {
        try {

            $Categories = Categorie::all();
            $result = new Collection();
            foreach ($Categories as $s) {

                $path = collect([
                    'path' => url(route('photo.display', ((new self)::getModelAttribute($s, 'path', 'photo'))))
                ]);

                $data = (Collect($s))->merge($path);

                if ($result->isEmpty()) {
                    $result = ($result->push((object)$data->toArray()));
                } else {
                    $result = ($result->push((object)$data->toArray()));
                }
            }

            return $result;

        } catch (Throwable $e) {
            report($e);
            return report($e);
        }



    }

    /*get Token*/

    public static function getToken(){
        try {
            return (string) User::query()->where('remember_token','!=','' )->value('remember_token');
        } catch (Throwable $e) {

            return report($e);
        }
    }

    public static function SaveFcmToken(Request $request){
        try {
            $user = User::where('email',$request->email)->first();
            $user->fcm = $request->fcm;
            $user->update();
            return $user;
        } catch (Throwable $e) {

            return report($e);
        }
    }

}
