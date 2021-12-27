<?php

namespace App\Modulos\Organizaciones\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\Organizaciones\Repository\InformeGestionRepository;

class InformeGestionServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Modulos\Organizaciones\Interfaces\InformeGestionInterface', function($app)
        {
            return new InformeGestionRepository;
        });
    }
}