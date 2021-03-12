<?php

namespace App\Providers;

use App\Services\OrdersManagement;
use Illuminate\Support\ServiceProvider;

class CommandeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Orders',function (){
            return new OrdersManagement();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
