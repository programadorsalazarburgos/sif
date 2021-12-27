<?php

Route::group(['prefix' => 'crea'], function(){

    $controller = "\\App\\Modulos\\Crea\\Controllers\\";

    Route::get('/index', [
        'uses' => $controller.'FichaCreaController@index',
        'as' => 'index_ficha_crea'
    ]);

}); 