<?php

namespace App\Http\Controllers\GestionProduits;

use App\Models\Categorie;
use App\Http\Controllers\Controller;
use App\Http\Requests\GestionProduits\CategorieStoreRequest;
use App\Http\Requests\GestionProduits\CategorieUpdateRequest;
use App\Models\Photo;
use App\Services\StockManagement;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Categorie::all();

        return view('categorie.index', compact('categories'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Categorie::all();

        return view('categorie.create', compact('categories'));
    }

    /**
     * @param \App\Http\Requests\GestionProduits\CategorieStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorieStoreRequest $request)
    {
        $categorie = new Categorie([
            'libele' => $request->libele,
            'description' => $request->description,
        ]);

        $Photo = new Photo();

        $Photo->SaveOrUpdate($request, 'photo_id', $categorie, 'categorie');

        $result = $categorie->save();

        $result ?
            connectify('success', 'Category management', 'Category created with success') :
            notify()->warning('Creating category encoutered error.', 'Category management');
        return redirect()->route('categorie.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Categorie $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Categorie $categorie)
    {
        return view('categorie.show', compact('categorie'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Categorie $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Categorie $categorie)
    {
        return view('categorie.edit', compact('categorie'));
    }

    /**
     * @param \App\Http\Requests\GestionProduits\CategorieUpdateRequest $request
     * @param \App\Models\Categorie $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorie $categorie)
    {

        $result = (new StockManagement())->storeCategory($request,$categorie);

        $result ?
            connectify('success', 'Category management', 'Category updated with success') :
            notify()->warning('Updating category encoutered error.', 'Category management');
        return redirect()->route('categorie.index', [$categorie]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Categorie $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Categorie $categorie)
    {
        $result = (new StockManagement())->deleteCategory($categorie);
        $result ?
            connectify('success', 'Category management', 'Category deleted with success') :
            notify()->warning('Deleting category encoutered error.', 'Category management');
        return redirect()->route('categorie.index');
    }
}
