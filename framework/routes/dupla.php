<?php

Route::group(['prefix' => 'nidos/duplas'], function(){

    $controller = "\\App\\Modulos\\Duplas\\Controllers\\DuplasController";

    Route::resource('duplas', $controller);


    Route::get('administracion-duplas',  function () {
        return view('nidos/duplas/administracion_duplas');
    });

    Route::post('/getDuplas', $controller.'@getDuplas');
    Route::post('/getDuplaAsignada', $controller.'@getDuplaAsignada');
    Route::post('/getDuplaPersona', $controller.'@getDuplaPersona');
    Route::post('/getDuplasGestor', $controller.'@getDuplasGestor');
    Route::post('/crearDupla', $controller.'@crearDupla');
    Route::post('/actualizarDupla', $controller.'@actualizarDupla');
    Route::post('/inactivarDupla', $controller.'@inactivarDupla');
});