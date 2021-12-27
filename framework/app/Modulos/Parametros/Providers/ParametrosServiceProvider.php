<?php

namespace App\Modulos\Parametros\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\Parametros\Repository\ParametrosRepository;

class ParametrosServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Modulos\Parametros\Interfaces\ParametrosInterface', function($app)
        {
            return new ParametrosRepository;
        });
    }
}