<?php

namespace App\Modulos\Oferta\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\Oferta\Repository\OfertaRepository;
use App\Modulos\Grupos\Repository\GruposRepository;

class OfertaServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Modulos\Oferta\Interfaces\OfertaInterface', function($app)
        {
            return new OfertaRepository;
        });

        $this->app->bind('App\Modulos\Grupos\Interfaces\GruposInterface', function($app)
        {
            return new GruposRepository;
        });
    }
}