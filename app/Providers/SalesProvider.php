<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SalesManagement;

class SalesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Sales',function (){
            return new SalesManagement();
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
