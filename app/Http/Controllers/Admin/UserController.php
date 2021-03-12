<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Role;
use App\Models\User;
use App\Services\StakeholdersManagement;
use App\Services\StockManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        //dd($users);
        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Gate::denies('edit-user')) {
            return redirect(route('admin.users.index'));
        }
        $roles = Role::all();

        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $result = StakeholdersManagement::updateRequestedUser($request);
        $result ?
            connectify('success', 'User management', 'Updating data done with success') :
            notify()->warning('Processing User encoutered error.', 'User management');

        $fournisseur = $user->suppliers()->get()->first();

        try{
            if ($user->hasRole('fournisseur')) {
                connectify('success', 'User management', 'Updating data done with success');
                connectify('success', 'User management', 'Update supplier\'s informations ');
                return redirect(route('fournisseur.edit', $fournisseur->id));
            }
        }catch (\Exception $e){
            notify()->warning('Processing User encoutered error.', 'User management');
        }

        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if (Gate::denies('delete-user')) {
            return redirect(route('admin.users.index'));
        }
        try {
            $result = StakeholdersManagement::deleteUser($user);
            $result ?
                connectify('success', 'User management', 'Deleting User data done with success') :
                notify()->warning('Processing User encoutered error. the user you use to delete have active data', 'User management');
            $request->session()->flash('success', 'User updated');
        } catch (\Exception $e) {
        }

        return redirect(route('admin.users.index'));
    }
}
