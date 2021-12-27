<?php

Route::group(['prefix' => 'nidos/talento_humano'], function(){

    $controller = "\\App\\Modulos\\TalentoHumano\\Controllers\\TalentoHumanoController";

    Route::resource('talentohumano', $controller);

    Route::get('inscripcion',  function () {
        return view('nidos/talentohumano/inscripcion');
    });

    Route::get('gestion_formularios',  function () {
        return view('nidos/talentohumano/gestion_formularios');
    });
    
    Route::post('/guardarHojadeVida', $controller.'@guardarHojadeVida');
    Route::post('/getHojasVida', $controller.'@getHojasVida');
    Route::post('/getEvaluacionHojasVida', $controller.'@getEvaluacionHojasVida');
    Route::post('/guardarEvaluacionHojasVida', $controller.'@guardarEvaluacionHojasVida');
}); 