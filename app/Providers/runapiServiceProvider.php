<?php

namespace App\Providers;

use App\Services\RunApi;
use Illuminate\Support\ServiceProvider;

class runapiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('RunApi',function (){
            return new RunApi();
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
