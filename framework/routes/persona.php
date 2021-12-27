<?php

Route::group(['prefix' => 'personas'], function(){

    $controller = "\\App\\Modulos\\Personas\\Controllers\\";

    Route::resource('user', $controller.'PersonaController');

    Route::post('/getApoyoSupervision', [
        'uses' => $controller.'PersonaController@getApoyoSupervision',
        'as' => 'obtener_apoyo_supervision'
    ]);

    Route::post('/getSupervision', [
        'uses' => $controller.'PersonaController@getSupervision',
        'as' => 'obtener_supervision'
    ]);

    Route::post('/getRolPersona', $controller.'PersonaController@getRolPersona');
    Route::post('/getArtistasPorLineaNidos', $controller.'PersonaController@getArtistasPorLineaNidos');
    Route::post('/getTerritorioPersonaNidos', $controller.'PersonaController@getTerritorioPersonaNidos');

}); 