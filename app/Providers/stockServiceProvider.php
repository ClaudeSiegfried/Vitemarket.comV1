<?php

namespace App\Providers;

use App\Services\StockManagement;
use Illuminate\Support\ServiceProvider;

class stockServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Warehouse',function (){
            return new StockManagement();
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
