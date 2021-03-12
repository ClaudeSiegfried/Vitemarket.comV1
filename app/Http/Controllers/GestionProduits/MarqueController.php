<?php

namespace App\Http\Controllers\GestionProduits;

use App\Http\Controllers\Controller;
use App\Http\Requests\GestionProduits\MarqueStoreRequest;
use App\Http\Requests\GestionProduits\MarqueUpdateRequest;
use App\Models\Etiquette;
use App\Models\Marque;
use App\Services\StockManagement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MarqueController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $marques = Marque::all();
        $etiquettes = Etiquette::all();

        return view('marque.index', compact('marques'))->with([
            'Etiquettes' => $etiquettes,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $marques = Marque::all();

        return view('marque.create', compact('marques'));
    }

    /**
     * @param \App\Http\Requests\GestionProduits\MarqueStoreRequest $request
     * @return Response
     */
    public function store(MarqueStoreRequest $request)
    {
        $marque = Marque::create($request->all());

        $marque ?
            connectify('success', 'Marque management', 'creating new marque done with success') :
            notify()->warning('Processing marque encoutered error.', 'Marque management');

        return redirect()->route('marque.index', [$marque]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Marque $marque
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $marques = Marque::all();

        $marqueToEdit = Marque::find($id);

        return view('marque.index')->with(
            [
                'marqueToEdit' => $marqueToEdit,
                'marques' => $marques,
                'Etiquettes' => Etiquette::all(),

            ]
        );
    }

    /**
     * @param MarqueUpdateRequest $request
     * @param Marque $marque
     * @return Response
     */
    public function update(MarqueUpdateRequest $request, Marque $marque)
    {
        $RESULT = $marque->update($request->all());

        $RESULT ?
            connectify('success', 'Marque management', 'Updating marque done with success') :
            notify()->warning('Updating marque encoutered error.', 'Marque management');
        return redirect()->route('marque.index', [$marque]);
    }

    public function destroy(Request $request, Marque $marque)
    {
        $RESULT = StockManagement::deleteMarque($marque);
        $RESULT ?
            connectify('success', 'Marque management', 'Deleted') :
            notify()->warning('Deleting marque encoutered error. (Marque linked with a product)', 'Marque management');

        $request->session()->flash('marque', $marque);

        return redirect()->route('marque.index', [$marque]);
    }
}
