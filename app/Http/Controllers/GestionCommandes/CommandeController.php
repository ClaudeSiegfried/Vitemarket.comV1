<?php

namespace App\Http\Controllers\GestionCommandes;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Services\OrdersManagement;
use Illuminate\Http\Request;
use Throwable;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commandes = OrdersManagement::GetOrders();
        return (view('commande.index')->with([
            'commandes' => $commandes
        ]));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        try{
            $result = $commande->delete();
            $result ?
                connectify('success', 'Order management', 'Order deleted with success') :
                notify()->warning('Deleting Order encoutered error.', 'Order management');
            return redirect()->route('commande.index');

        }catch(Throwable $e){
            notify()->warning('Deleting Order encoutered error.', 'Order management');
            return redirect()->route('commande.index');
        }

    }
}
