<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Client;
use App\Models\Livreur;
use App\Models\Fournisseur;
use App\Services\StakeholdersManagement;
use Illuminate\Support\ServiceProvider;

class StakeholdersServiceProvider extends ServiceProvider
{
    /**
     * Register Rervices.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Models\User',function ($app){
            return new User();
        });

        $this->app->bind('App\Models\Client',function ($app){
            return new Client();
        });

        $this->app->bind('App\Models\Livreur',function ($app){
            return new Livreur();
        });

        $this->app->bind('App\Models\Fournisseur',function ($app){
            return new Fournisseur();
        });

        $this->app->bind('App\Services\StakeholdersManagement',function ($app){
            return new StakeholdersManagement();
        });
    }

    /**
     * Bootstrap Rervices.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
