<?php

namespace App\Modulos\ComponentePedagogico\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\ComponentePedagogico\Repository\FormatoPedagogicoRepository;

class FormatoPedagogicoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Modulos\ComponentePedagogico\Interfaces\FormatoPedagogicoInterface', function($app)
        {
            return new FormatoPedagogicoRepository;
        });
    }
}