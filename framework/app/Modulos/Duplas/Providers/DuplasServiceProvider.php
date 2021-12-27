<?php

namespace App\Modulos\Duplas\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\Duplas\Repository\DuplasRepository;

class DuplasServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Modulos\Duplas\Interfaces\DuplasInterface', function($app)
        {
            return new DuplasRepository;
        });
    }
}