<?php

Route::group(['prefix' => 'crea/territorial/oferta'], function(){

    $controller = "\\App\\Modulos\\Oferta\\Controllers\\OfertaController";

    Route::resource('oferta', $controller);

    Route::get('oferta-disponible',  function () {
        return view('crea/territorial/oferta/oferta_disponible');
    });

    Route::get('administracion-oferta-disponible',  function () {
        return view('crea/territorial/oferta/administracion_oferta_disponible');
    });

    Route::post('/getLocalidadesOfertaDisponible', $controller.'@getLocalidadesOfertaDisponible');
    Route::post('/getOptionsOfertaDisponible', $controller.'@getOptionsOfertaDisponible');
    Route::post('/guardarPreinscripcion', $controller.'@guardarPreinscripcion');
    Route::post('/getGrupos', $controller.'@getGrupos');
    Route::post('/getPreinscritosGrupo', $controller.'@getPreinscritosGrupo');
    Route::post('/getCuposGrupo', $controller.'@getCuposGrupo');
    Route::post('/aprobarPreinscripcion', $controller.'@aprobarPreinscripcion');
    Route::post('/rechazarPreinscripcion', $controller.'@rechazarPreinscripcion');
}); 