<?php

namespace App\Providers;
use App\Models\Photo;
use Illuminate\Support\ServiceProvider;

class photoServiceProvider extends ServiceProvider
{
    /**
     * Register Rervices.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Models\Photo',function ($app){
           return new Photo();
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
