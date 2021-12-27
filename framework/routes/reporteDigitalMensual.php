<?php


Route::group(['prefix' => 'reportes'], function () {

    $controller = "\\App\\Modulos\\Reportes\\Controllers\\";
    Route::get('getConvenios',  $controller . 'ReporteDigitalMensualController@getConvenios');
    Route::get('getColegios',  $controller . 'ReporteDigitalMensualController@getColegios');
    Route::get('getDataReporte',  $controller . 'ReporteDigitalMensualController@getDataReporte');
    Route::post('getDataReporte_digital',  $controller . 'ReporteDigitalMensualController@getDataReporte');
    Route::post('deleteColegioZip',  $controller . 'ReporteDigitalMensualController@deleteColegioZip');
    Route::post('consultarJSONReporte',  $controller . 'ReporteDigitalMensualController@consultarJSONReporte');
    Route::get('/digital', function () {
        return view('reportes/digitalMensual/general');
    });
});