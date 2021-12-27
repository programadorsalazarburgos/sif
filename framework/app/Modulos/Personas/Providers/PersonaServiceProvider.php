<?php

namespace App\Modulos\Personas\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\Personas\Repository\PersonaRepository;

class PersonaServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Modulos\Personas\Interfaces\PersonaInterface', function($app)
        {
            return new PersonaRepository;
        });
    }
}