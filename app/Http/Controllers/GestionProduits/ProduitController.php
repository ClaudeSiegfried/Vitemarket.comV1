<?php

namespace App\Http\Controllers\GestionProduits;

use App\Models\Categorie;
use App\Models\Etiquette;
use App\Models\Expiration;
use App\Models\Fournisseur;
use App\Http\Controllers\Controller;
use App\Http\Requests\GestionProduits\ProduitStoreRequest;
use App\Http\Requests\GestionProduits\ProduitUpdateRequest;
use App\Models\Marque;
use App\Models\Photo;
use App\Models\Produit;
use App\Models\Stock;
use App\Services\StockManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

class ProduitController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produits = Produit::all();

        return view('produit.index')->with('produits',$produits);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $produits = Produit::all();

        $categories = Categorie::all();

        $marques = Marque::all();

        $fournisseurs = Fournisseur::all();


        if($fournisseurs->isEmpty()){
            notify()->warning('Error !!! please create suppliers before.', 'Product management');
        }

        if($categories->isEmpty()){
            notify()->warning('Error !!! please create categories before.', 'Product management');
            return redirect()->route('categorie.create');
        }

        if($marques->isEmpty()){
            notify()->warning('Error !!! please create marques before.', 'Product management');
            return redirect()->route('marque.index');
        }
        return view('produit.create')->with([
            'produits' => $produits,
            'categories' => $categories,
            'marques' => $marques,
            'fournisseurs' => $fournisseurs,
            'etiquettes' => Etiquette::all()
        ]);
    }

    /**
     * @param \App\Http\Requests\GestionProduits\ProduitStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $Stock = new StockManagement();

        $result = $Stock->storeProduct($request);
        //return $result;
        $result ?
            connectify('success', 'Product management', 'Store Product return success') :
            notify()->warning('Creating product encoutered error.', 'Product management');

        return redirect()->route('produit.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Produit $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Produit $produit)
    {
        return view('produit.show', compact('produit'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Produit $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Produit $produit)
    {

        $categories = Categorie::all();

        $marques = Marque::all();

        $stock = Stock::query()->Getproduit($produit->id)->get()->first();

        $exp = Expiration::query()->GetExpirationDate($stock->expiration_id)->get()->first();

        $fournisseurs = Fournisseur::all();

        return view('produit.edit')->with([
            'produit' => $produit,
            'categories' => $categories,
            'marques' => $marques,
            'fournisseurs' => $fournisseurs,
            'stock' => $stock,
            'exp' => $exp,
            'etiquettes' => Etiquette::all()
        ]);

    }

    /**
     * @param Request $request
     * @param \App\Models\Produit $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {

        $Stock = new StockManagement();

        $result = $Stock->updateProduct($request, $produit);

        $result ?
            connectify('success', 'Product management', 'Product update with success') :
            notify()->warning('Updating product encoutered error.', 'Product management');

        return redirect()->route('produit.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Produit $produit
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Produit $produit)
    {
        $Stock = new StockManagement();

        $result = $Stock->deleteProduct($produit);
        $result ?
            connectify('success', 'Product management', 'Product deleted with success') :
            notify()->warning('Deleting product encoutered error.', 'Product management');

        //dd($result);

        return redirect()->route('produit.index');
    }

}
