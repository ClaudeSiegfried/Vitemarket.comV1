<?php

namespace App\Http\Controllers\Utilisateurs;

use App\Models\Fournisseur;
use App\Http\Controllers\Controller;
use App\Http\Requests\Utilisateurs\FournisseurStoreRequest;
use App\Http\Requests\Utilisateurs\FournisseurUpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\StakeholdersManagement;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index(Request $request)
    {
        $fournisseurs = Fournisseur::all();

        return view('fournisseur.index', compact('fournisseurs'));
    }

    public function create(Request $request)
    {
        $fournisseurs = Fournisseur::all();

        return view('fournisseur.create', compact('fournisseurs'));
    }

    public function store(FournisseurStoreRequest $request)
    {
        $fournisseur = Fournisseur::create($request->all());

        return redirect()->route('fournisseur.create', [$fournisseur]);
    }

    public function show(Request $request, Fournisseur $fournisseur)
    {
        return view('fournisseur.show', compact('fournisseur'));
    }

    public function edit(Request $request, Fournisseur $fournisseur)
    {
        $user = User::find($fournisseur->user_id);

        $roles = Role::all();

        return view('fournisseur.edit')->with([
            'fournisseur' => $fournisseur,
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $fournisseur->update($request->all());

        $user = new User();

        $data = $fournisseur->user()->setModel($user)->get()->first();

        $result = $user->updateUser($request, $data);

        $result?
            connectify('success', 'Suppliers Management', 'Supplier data updated with success') :
            notify()->warning('Processing supplier data encoutered error.', 'Suppliers Management');
        return redirect()->route('fournisseur.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fournisseur $fournisseur
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Fournisseur $fournisseur)
    {
        $result = StakeholdersManagement::deleteSupplier($fournisseur);

        $result?
            connectify('success', 'Suppliers Management', 'Supplier deleted with success') :
            notify()->warning('Processing supplier data encoutered error. Supplier has active datas', 'Suppliers Management');

        return redirect()->route('fournisseur.index');
    }
}
