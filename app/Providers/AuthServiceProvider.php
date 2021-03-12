<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization Rervices.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-users',function (User $user){
            return $user->hasAnyRoles(['admin','fournisseur','livreur']);
        });

        Gate::define('edit-user',function (User $user){
            return $user->hasRole('admin');
        });

        Gate::define('delete-user',function (User $user){
            return $user->hasRole('admin');
        });
        //
    }
}
