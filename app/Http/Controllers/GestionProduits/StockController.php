<?php

namespace App\Http\Controllers\GestionProduits;

use App\Http\Controllers\Controller;
use App\Http\Requests\GestionProduits\StockStoreRequest;
use App\Http\Requests\GestionProduits\StockUpdateRequest;
use App\Models\Produit;
use App\Models\Stock;
use App\Facades\StockManagementFacade;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stocks = StockManagementFacade::allStock();

        return view('stock.index', compact('stocks'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $produits = Produit::all();

        return view('stock.create', compact('produits'));
    }

    /**
     * @param \App\Http\Requests\GestionProduits\StockStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockStoreRequest $request)
    {
        $stock = Stock::create($request->all());

        $request->session()->flash('stock', $stock);

        return redirect()->route('stock.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Stock $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Stock $stock)
    {
        return view('stock.show', compact('stock'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Stock $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Stock $stock)
    {
        return view('stock.edit', compact('stock'));
    }

    /**
     * @param \App\Http\Requests\GestionProduits\StockUpdateRequest $request
     * @param \App\Models\Stock $stock
     * @return \Illuminate\Http\Response
     */
    public function update(StockUpdateRequest $request, Stock $stock)
    {
        $stock->update([]);

        $request->session()->flash('stock', $stock);

        return redirect()->route('stock.show', [$stock]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Stock $stock
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Stock $stock)
    {
        $stock->produit()->dissociate();
        $stock->delete();

        return redirect()->route('stock.index');
    }
}
