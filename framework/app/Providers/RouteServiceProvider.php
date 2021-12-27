<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
        $this->mapInformeGestionRoutes();
        $this->mapPersonas();
        $this->mapFortalecimientoExternoRoutes();
        $this->mapDuplasRoutes();
        $this->mapParametrosRoutes();
        $this->mapComponentePedagogico();
        $this->mapComponenteReporte();      
        $this->mapComponenteReporteDigitalMensual();      
        $this->mapOferta();
        $this->mapCreaRoutes();
        $this->mapTalentoHumanoRoutes();
        $this->mapSeguimientoPsicosocial();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
        ->middleware('api')
        ->namespace($this->namespace)
        ->group(base_path('routes/api.php'));
    }

    protected function mapInformeGestionRoutes()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/informeGestion.php'));
    }

    protected function mapPersonas()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/persona.php'));
    }

    protected function mapFortalecimientoExternoRoutes()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/fortalecimientoExterno.php'));
    }

    protected function mapDuplasRoutes()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/dupla.php'));
    }

    protected function mapParametrosRoutes()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/parametros.php'));
    }

    protected function mapComponentePedagogico()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/componentePedagogico.php'));
    }

    protected function mapComponenteReporte()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/consultaReporte.php'));
    }

    protected function mapComponenteReporteDigitalMensual()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/reporteDigitalMensual.php'));
    }

    protected function mapOferta()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/oferta.php'));
    }

    protected function mapCreaRoutes()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/crea.php'));
    }

    protected function mapTalentoHumanoRoutes()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/talentoHumano.php'));
    }
    protected function mapSeguimientoPsicosocial()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/seguimientoPsicosocial.php'));
    }
    
}