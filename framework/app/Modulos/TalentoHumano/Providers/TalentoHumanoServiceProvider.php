<?php

namespace App\Modulos\TalentoHumano\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\TalentoHumano\Repository\TalentoHumanoRepository;

class TalentoHumanoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Modulos\TalentoHumano\Interfaces\TalentoHumanoInterface', function($app)
        {
            return new TalentoHumanoRepository;
        });
    }
}