<?php

namespace App\Http\Controllers\Configurations;

use App\Models\Tarif_Livraison;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TarifLivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Tarifs = Tarif_Livraison::all();
        $global = Tarif_Livraison::query()->where('couverture', '=', 'Global')->first();
        $km = Tarif_Livraison::query()->where('couverture', '=', '1 Km')->first();


        return view('deliveryFees.index')->with(
            [
                'Tarifs' => $Tarifs,
                'Global' => $global->frais,
                'Km' => $km->frais,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Fee = new Tarif_Livraison();

        $Fee->couverture = $request->couverture;
        $Fee->frais = $request->frais;
        $temp = Tarif_Livraison::query()->where('couverture', '=', $Fee->couverture);

        if ($temp) {
            $temp->update($request->except('_token'));
        } else {
            $Fee->save($request->all());
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Tarif_Livraison $tarif_Livraison
     * @return void
     */
    public function show(Tarif_Livraison $tarif_Livraison)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tarif_Livraison $tarif_Livraison
     * @return void
     */
    public function edit(Tarif_Livraison $tarif_Livraison)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Tarif_Livraison $tarif_Livraison
     * @return void
     */
    public function update(Request $request, Tarif_Livraison $tarif_Livraison)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tarif_Livraison $tarif_Livraison
     * @return void
     */
    public function destroy(Tarif_Livraison $tarif_Livraison)
    {
        //
    }
}
