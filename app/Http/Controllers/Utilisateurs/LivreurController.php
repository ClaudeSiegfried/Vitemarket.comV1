<?php

namespace App\Http\Controllers\Utilisateurs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Utilisateurs\LivreurStoreRequest;
use App\Http\Requests\Utilisateurs\LivreurUpdateRequest;
use App\Models\Livreur;
use Illuminate\Http\Request;

class LivreurController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $livreurs = Livreur::all();

        return view('livreur.index', compact('livreurs'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $livreurs = Livreur::all();

        return view('livreur.create', compact('livreurs'));
    }

    /**
     * @param \App\Http\Requests\Utilisateurs\LivreurStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LivreurStoreRequest $request)
    {
        $livreur = Livreur::create($request->all());

        $request->session()->flash('livreur', $livreur);

        return redirect()->route('livreur.create', [$livreur]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Livreur $livreur
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Livreur $livreur)
    {
        return view('livreur.show', compact('livreur'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Livreur $livreur
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Livreur $livreur)
    {
        return view('livreur.edit', compact('livreur'));
    }

    /**
     * @param \App\Http\Requests\Utilisateurs\LivreurUpdateRequest $request
     * @param \App\Models\Livreur $livreur
     * @return \Illuminate\Http\Response
     */
    public function update(LivreurUpdateRequest $request, Livreur $livreur)
    {
        $livreur->update([]);

        $request->session()->flash('livreur', $livreur);

        return redirect()->route('livreur.index', [$livreur]);
    }
}
