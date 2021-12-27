<?php

namespace App\Modulos\Organizaciones\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modulos\Reportes\Repository\ConsultaReporteRepository;

class ConsultaReporteServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Modulos\Organizaciones\Interfaces\ConsultaReporteInterface', function($app)
        {
            return new ConsultaReporteRepository;
        });
    }
}