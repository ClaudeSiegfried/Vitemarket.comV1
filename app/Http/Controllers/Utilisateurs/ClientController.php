<?php

namespace App\Http\Controllers\Utilisateurs;

use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\Utilisateurs\ClientStoreRequest;
use App\Http\Requests\Utilisateurs\ClientUpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\StakeholdersManagement;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::all();

        return view('client.index', compact('clients'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $roles = Role::all();

        return view('client.create', compact('roles'));
    }

    /**
     * @param \App\Http\Requests\Utilisateurs\ClientStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $request)
    {
        $client = Client::create($request->all());

        $client?
            connectify('success', 'Clients Management', 'Client stored with success') :
            notify()->warning('Processing Client data encoutered error.', 'Clients Management');
        return redirect()->route('client.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Client $client)
    {
        return view('client.edit', compact('client'));
    }

    /**
     * @param \App\Http\Requests\Utilisateurs\ClientUpdateRequest $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUpdateRequest $request, Client $client)
    {
        $result = $client->update([]);

        $result?
            connectify('success', 'Clients Management', 'Client updated with success') :
            notify()->warning('Processing Client data encoutered error.', 'Clients Management');
        return redirect()->route('client.show', [$client]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Client $client)
    {
        $result = StakeholdersManagement::deleteClient($client);
        $result?
            connectify('success', 'Clients Management', 'Client deleted with success') :
            notify()->warning('Processing Client data encoutered error. (User must have client\'s role only)', 'Clients Management');

        return redirect()->route('client.index');
    }
}
