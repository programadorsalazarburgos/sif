<?php

namespace App\Modulos\FortalecimientoExterno\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\FortalecimientoExterno\Repository\FortalecimientoExternoRepository;

class FortalecimientoExternoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Modulos\FortalecimientoExterno\Interfaces\FortalecimientoExternoInterface', function($app)
        {
            return new FortalecimientoExternoRepository;
        });
    }
}