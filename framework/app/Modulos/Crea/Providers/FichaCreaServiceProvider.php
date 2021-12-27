<?php

namespace App\Modulos\Crea\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\Crea\Repository\FichaCreaRepository;

class FichaCreaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Modulos\Crea\Interfaces\FichaCreaInterface', function($app)
        {
            return new FichaCreaRepository;
        });
    }
}