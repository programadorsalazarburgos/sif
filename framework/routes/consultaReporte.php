<?php


Route::group(['prefix' => 'reportes'], function(){
    
    $controller = "\\App\\Modulos\\Reportes\\Controllers\\";
    Route::post('guardarObservacion',  $controller.'ConsultaReporteController@guardarObservacion');    
    Route::get('observaciones_linea',  $controller.'ConsultaReporteController@observaciones_linea');    
    Route::get('atendidos_inscritos',  $controller.'ConsultaReporteController@atendidos_inscritos');    
    Route::get('atendidos_inscritos_impulso',  $controller.'ConsultaReporteController@atendidos_inscritos_impulso');    
    Route::get('atendidos_inscritos_escuela',  $controller.'ConsultaReporteController@atendidos_inscritos_escuela');    
    Route::get('reportePDFImpulso',  $controller.'ConsultaReporteController@cargarPDFImpulso')->name('reporteImpulso.pdf');    
    Route::get('cargarPDFImpulso',  $controller.'ConsultaReporteController@cargarPDFImpulso');    
    Route::get('reportePDF',  $controller.'ConsultaReporteController@cargarPDF')->name('reporte.pdf');    
    Route::get('cargarPDF',  $controller.'ConsultaReporteController@cargarPDF');    
    Route::get('reportePDFEscuela',  $controller.'ConsultaReporteController@cargarPDFEscuela')->name('reporte.pdf');    
    Route::get('cargarPDFEscuela',  $controller.'ConsultaReporteController@cargarPDFEscuela');    
    Route::get('cargarColegios',  $controller.'ConsultaReporteController@cargarColegios');    
    Route::get('cargarAniosMeses',  $controller.'ConsultaReporteController@cargarAniosMeses');    
    Route::get('/monitoreo', function () {
        return view('reportes/general');
    });


}); 