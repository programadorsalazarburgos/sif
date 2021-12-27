<?php

Route::group(['prefix' => 'organizaciones'], function(){

    $controller = "\\App\\Modulos\\Organizaciones\\Controllers\\";

    Route::resource('informeGestion', $controller.'InformeGestionController');

    Route::post('/getOrganizaciones', [
        'uses' => $controller.'InformeGestionController@getOrganizaciones',
        'as' => 'obtener_organizacion'
    ]);
    
    Route::post('/saveInformeGestion', [
        'uses' => $controller.'InformeGestionController@crear',
        'as' => 'guardar_informe_gestion'
    ]);

    Route::post('/getInfoTableInformesGestion', [
        'uses' => $controller.'InformeGestionController@data',
        'as' => 'obtener_tabla_informe_gestion'
    ]);

    Route::post('/getInformeGestion', [
        'uses' => $controller.'InformeGestionController@getInformeGestion',
        'as' => 'obtener_tabla_informe_gestion'
    ]);

    Route::post('/obtenerParametro', [
        'uses' => $controller.'InformeGestionController@obtenerParametro',
        'as' => 'obtener_parametro'
    ]);

    Route::post('/registerApproval', [
        'uses' => $controller.'InformeGestionController@registerApproval',
        'as' => 'registrar_aprobacion'
    ]);
    
    Route::post('/validateDate', [
        'uses' => $controller.'InformeGestionController@validateDate',
        'as' => 'validar_fechas'
    ]);

    Route::post('/newReport', [
        'uses' => $controller.'InformeGestionController@newReport',
        'as' => 'nuevo_reporte'
    ]);

    Route::get('/pdfInformeGestion/{idInforme}', [
        'uses' => $controller.'InformeGestionController@pdfInformeGestion',
        'as' => 'pdf_informe'
    ]);
    
}); 