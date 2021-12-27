<?php

Route::group(['prefix' => 'parametros'], function(){

    $controller = "\\App\\Modulos\\Parametros\\Controllers\\ParametrosController";

    Route::resource('parametros', $controller);

    Route::post('/getParametroDetalle', $controller.'@getParametroDetalle');
}); 