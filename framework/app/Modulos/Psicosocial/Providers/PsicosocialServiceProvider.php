<?php

namespace App\Modulos\Psicosocial\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\Psicosocial\Repository\PsicosocialRepository;

class PsicosocialServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Modulos\Psicosocial\Interfaces\PsicosocialInterface', function($app)
        {
            return new PsicosocialRepository;
        });
    }
}