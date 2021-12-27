<?php

Route::group(['prefix' => 'componentePedagogico'], function(){

    $controller = "\\App\\Modulos\\ComponentePedagogico\\Controllers\\";

    Route::resource('indexCaracterizacion', $controller.'formatoPedagogicoController');

    Route::post('/getGruposLinea', [
        'uses' => $controller.'formatoPedagogicoController@getGruposXLinea',
        'as' => 'obtener_grupos_linea'
    ]);

    Route::post('/getInformacionGrupo', [
        'uses' => $controller.'formatoPedagogicoController@getInformacionGrupo',
        'as' => 'obtener_info_grupo'
    ]);

    Route::post('/guardarCaracterizacionGrupo', [
        'uses' => $controller.'formatoPedagogicoController@guardarCaracterizacionGrupo',
        'as' => 'obtener_info_grupo'
    ]);

    Route::get('/indexPlaneacion', [
        'uses' => $controller.'formatoPedagogicoController@indexPlaneacion',
        'as' => 'index_planeacion'
    ]);

    Route::post('/getInfoTable', [
        'uses' => $controller.'formatoPedagogicoController@getInfoTable',
        'as' => 'obtener_info_tabla'
    ]);
    
    Route::post('/guardarPlaneacionGrupo', [
        'uses' => $controller.'formatoPedagogicoController@crear',
        'as' => 'save_planeacion'
    ]);

    Route::post('/obtenerParametro', [
        'uses' => $controller.'formatoPedagogicoController@obtenerParametro',
        'as' => 'obtener_parametro'
    ]);
    
    Route::post('/getInfoTableEdit', [
        'uses' => $controller.'formatoPedagogicoController@data',
        'as' => 'obtener_info_tabla_edit'
    ]);

    Route::post('/getInfoTableEditCaracterizacion', [
        'uses' => $controller.'formatoPedagogicoController@getCaracterizacion',
        'as' => 'obtener_info_tabla_edit_caracterizacion'
    ]);

    Route::post('/guardarPlaneacionIc', [
        'uses' => $controller.'formatoPedagogicoController@crearIc',
        'as' => 'save_planeacion_ic'
    ]);

    Route::post('/getPlaneacion', [
        'uses' => $controller.'formatoPedagogicoController@getPlaneacion',
        'as' => 'obtener_planeacion'
    ]);
    
    Route::post('/getCaracterizacionEdit', [
        'uses' => $controller.'formatoPedagogicoController@getCaracterizacionEdit',
        'as' => 'obtener_caracterizacion'
    ]);
    
    Route::post('/getPlaneacionIC', [
        'uses' => $controller.'formatoPedagogicoController@getPlaneacionIC',
        'as' => 'obtener_planeacion_ic'
    ]);

    Route::post('/guardarPlaneacionCv', [
        'uses' => $controller.'formatoPedagogicoController@crearCv',
        'as' => 'save_planeacion_cv'
    ]);

    Route::post('/registerApproval', [
        'uses' => $controller.'formatoPedagogicoController@registerApproval',
        'as' => 'registrar_aprobacion_ae'
    ]);
    
    Route::get('/indexAnalisis', [
        'uses' => $controller.'formatoPedagogicoController@indexAnalisis',
        'as' => 'index_analisis'
    ]);

    Route::post('/getInfoTableAnalisis', [
        'uses' => $controller.'formatoPedagogicoController@getInfoTableAnalisis',
        'as' => 'obtener_info_tabla_analisis'
    ]);

    Route::post('/guardarAnalisisGrupo', [
        'uses' => $controller.'formatoPedagogicoController@crearAnalisis',
        'as' => 'save_analisis'
    ]);

    Route::post('/getInfoTableEditAna', [
        'uses' => $controller.'formatoPedagogicoController@dataAnalisis',
        'as' => 'obtener_info_tabla_edit_ana'
    ]);

    Route::post('/getAnalisis', [
        'uses' => $controller.'formatoPedagogicoController@getAnalisis',
        'as' => 'obtener_analisis'
    ]);
    
    Route::post('/registerApprovalAnalisis', [
        'uses' => $controller.'formatoPedagogicoController@registerApprovalAnalisis',
        'as' => 'registrar_aprobacion_as'
    ]);

    Route::get('/pdfPlaneacion/{idInforme}/{idLinea}', [
        'uses' => $controller.'formatoPedagogicoController@pdfPlaneacion',
        'as' => 'pdf_planeacion'
    ]);

    Route::get('/pdfValoracion/{idInforme}/{idLinea}', [
        'uses' => $controller.'formatoPedagogicoController@pdfValoracion',
        'as' => 'pdf_valoracion'
    ]);

    Route::get('/pdfProceso/{idInforme}/{idLinea}', [
        'uses' => $controller.'formatoPedagogicoController@pdfProceso',
        'as' => 'pdf_proceso'
    ]);

    Route::post('/registerApprovalCaracter', [
        'uses' => $controller.'formatoPedagogicoController@registerApprovalCaracter',
        'as' => 'registrar_aprobacion_cz'
    ]);

    Route::get('/pdfCaracterizacion/{idInforme}/{idLinea}', [
        'uses' => $controller.'formatoPedagogicoController@pdfCaracterizacion',
        'as' => 'pdf_caracterizacion'
    ]);

}); 