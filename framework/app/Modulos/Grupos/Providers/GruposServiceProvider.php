<?php

namespace App\Modulos\Grupo\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\Grupo\Repository\GruposRepository;

class GruposServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Modulos\Grupos\Interfaces\GruposInterface', function($app)
        {
            return new GruposRepository;
        });
    }
}