<?php


Route::group(['prefix' => 'seguimiento'], function(){
    
    
    $controller = "\\App\\Modulos\\Psicosocial\\Controllers\\";
    Route::get('getTipoIdentificaciones',  $controller.'PsicosocialController@getTipoIdentificaciones');    
    Route::get('getLineasEstrategicas',  $controller.'PsicosocialController@getLineasEstrategicas');    
    Route::get('getAreasArtisticas',  $controller.'PsicosocialController@getAreasArtisticas');    
    Route::get('getCreas',  $controller.'PsicosocialController@getCreas');    
    Route::get('getInsituciones',  $controller.'PsicosocialController@getInsituciones');    
    Route::get('atendidos_inscritos',  $controller.'PsicosocialController@atendidos_inscritos');    
    Route::post('guardarCasoPsicosocial',  $controller.'PsicosocialController@guardarCasoPsicosocial');    
    Route::post('guardarSeguimientoPsicosocial',  $controller.'PsicosocialController@guardarSeguimientoPsicosocial');    
    Route::post('guardarDocumentoPsicosocial',  $controller.'PsicosocialController@guardarDocumentoPsicosocial');    
    Route::post('cerrarActivarSeguimiento',  $controller.'PsicosocialController@cerrarActivarSeguimiento');    
    Route::get('getCasosSeguimientos',  $controller.'PsicosocialController@getCasosSeguimientos');    
    Route::get('getSeguimientosDocumentos',  $controller.'PsicosocialController@getSeguimientosDocumentos');    
    Route::get('getReporte',  $controller.'PsicosocialController@getReporte');    
    Route::get('getSeguimientos',  $controller.'PsicosocialController@getSeguimientos');    
    Route::post('/file-progress', [PermisoController::class, 'upload']);  
    Route::get('/psicosocial', function () {
        return view('seguimientos/general');
    });

}); 