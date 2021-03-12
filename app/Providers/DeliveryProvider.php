<?php

namespace App\Providers;

use App\Services\DeliveryManagement;
use Illuminate\Support\ServiceProvider;

class DeliveryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Delivery',function (){
            return new DeliveryManagement();
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
