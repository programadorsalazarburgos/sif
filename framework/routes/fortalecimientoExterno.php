<?php

Route::group(['prefix' => 'nidos/fortalecimiento'], function(){

    $controller = "\\App\\Modulos\\FortalecimientoExterno\\Controllers\\FortalecimientoExternoController";

    Route::resource('fortalecimientoExterno', $controller);

    Route::get('administracion-oferta-fortalecimiento-externo',  function () {
        return view('nidos/fortalecimiento/administracion_oferta_fortalecimiento_externo');
    });
    Route::post('/getOfertaFortalecimientoExterno', $controller.'@getOfertaFortalecimientoExterno');
    Route::post('/procesarOferta', $controller.'@procesarOferta');
    Route::post('/cambiarEstadoOferta', $controller.'@cambiarEstadoOferta');
    Route::post('/getGruposOferta', $controller.'@getGruposOferta');
    Route::post('/getDuplaAsignada', $controller.'@getDuplaAsignada');
    Route::post('/asignarDuplaGrupo', $controller.'@asignarDuplaGrupo');
    Route::post('/getInformacionParticipantes', $controller.'@getInformacionParticipantes');
    Route::post('/getCuposGruposOferta', $controller.'@getCuposGruposOferta');
    Route::post('/getReportePandora', $controller.'@getReportePandora');

    Route::get('registro-asistencia-fortalecimiento-externo',  function () {
        return view('nidos/fortalecimiento/registro_asistencia_fortalecimiento_externo');
    });
    Route::post('/getSesionesGrupo', $controller.'@getSesionesGrupo');
    Route::post('/validarFechaSesion', $controller.'@validarFechaSesion');
    Route::post('/getParticipantesGrupo', $controller.'@getParticipantesGrupo');
    Route::post('/consultaEdicionAsistencia', $controller.'@consultaEdicionAsistencia');
    Route::post('/guardarAsistencia', $controller.'@guardarAsistencia');

    Route::get('registro-fortalecimiento-externo',  function () {
        return view('nidos/fortalecimiento/registro_fortalecimiento_externo');
    });
    Route::post('getOfertaActivaFortalecimientoExterno', $controller.'@getOfertaActivaFortalecimientoExterno');
    Route::post('guardarSolicitud', $controller.'@guardarSolicitud');
}); 



