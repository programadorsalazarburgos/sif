<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* Centro de Monitoreo */
Route::get('/centro-de-monitoreo', function () {
	return view('cdm/general');
});
Route::post('/centro-de-monitoreo/executeSQLIndicador', 'cdm\CDMController@executeSQLIndicador');
Route::post('/centro-de-monitoreo/getAlcanceCoberturaAnualCREA', 'cdm\CDMController@getAlcanceCoberturaAnualCREA');
Route::post('/centro-de-monitoreo/getAlcanceCoberturaAnualNIDOS', 'cdm\CDMController@getAlcanceCoberturaAnualNIDOS');
Route::post('/centro-de-monitoreo/executeSectionQueries', 'cdm\CDMController@executeSectionQueries');
Route::post('/centro-de-monitoreo/getEstadisticasAnioActual', 'cdm\CDMController@getEstadisticasAnioActual');
Route::post('/centro-de-monitoreo/getEstadisticasAnioAnterior', 'cdm\CDMController@getEstadisticasAnioAnterior');
Route::post('/centro-de-monitoreo/getListadoTipoIndicadores', 'cdm\CDMController@getListadoTipoIndicadores');
Route::post('/centro-de-monitoreo/getEstadisticasLocalidades', 'cdm\CDMController@getEstadisticasLocalidades');
Route::get('/centro-de-monitoreo/indicadores/{seccion}/{id_tipo_indicador}', 'cdm\CDMController@getVistaIndicadores');
Route::post('/centro-de-monitoreo/indicadores/getIndicadores', 'cdm\CDMController@getIndicadores');
Route::post('/centro-de-monitoreo/indicadores/getFiltrosIndicadores', 'cdm\CDMController@getFiltrosIndicadores');

Route::get('/centro-de-monitoreo/analytics/navegadores', 'cdm\CDMController@viewAnalyticsNavegadores');
Route::get('/centro-de-monitoreo/analytics/paginas', 'cdm\CDMController@viewAnalyticsPaginas');
Route::get('/centro-de-monitoreo/analytics/sesiones', 'cdm\CDMController@viewAnalyticsSesiones');
Route::get('/centro-de-monitoreo/analytics/ciudades', 'cdm\CDMController@viewAnalyticsCiudades');
Route::get('/centro-de-monitoreo/analytics/activos', 'cdm\CDMController@viewAnalyticsActivos');

Route::get('/administracion/proyectos', function () {
	return view('administracion/proyectos');
});
Route::post('/administracion/proyectos/getAll', 'cdm\CDMController@getProyectos');
Route::post('/administracion/proyectos/save', 'cdm\CDMController@saveProyecto');
Route::post('/administracion/proyectos/update', 'cdm\CDMController@updateProyecto');
Route::post('/administracion/proyectos/delete', 'cdm\CDMController@deleteProyecto');
Route::post('/administracion/indicadores/getAll', 'cdm\CDMController@getIndicadoresProyecto');
Route::post('/administracion/indicadores/save', 'cdm\CDMController@saveIndicador');
Route::post('/administracion/indicadores/update', 'cdm\CDMController@updateIndicador');
Route::post('/administracion/indicadores/updateAvance', 'cdm\CDMController@updateAvanceIndicador');
Route::post('/administracion/indicadores/delete', 'cdm\CDMController@deleteIndicador');

/**
 * Routes OPTIONS
 */
Route::post('/options/getParametroDetalle', 'OptionsController@getParametroDetalle');
Route::post('/options/getParametroDetalleNidos', 'OptionsController@getParametroDetalleNidos');
Route::post('/options/getCentrosCrea', 'OptionsController@getCentrosCrea');
Route::post('/options/getColegios', 'OptionsController@getColegios');
Route::post('/options/getLineasNidos', 'OptionsController@getLineasNidos');
Route::post('/options/getGruposAtendidosLineaAnio', 'OptionsController@getGruposAtendidosLineaAnio');
Route::post('/options/getConveniosActivosCREA', 'OptionsController@getConveniosActivosCREA');
Route::post('/options/getYearsTbEstadisticaAnio', 'OptionsController@getYearsEstadisticasAnio');
Route::post('/options/getBarrios', 'OptionsController@getBarrios');
Route::post('/options/getGruposPoblacionalesCulturas', 'OptionsController@getGruposPoblacionalesCulturas');

/**
 * Routes administración de Metas y Estadísticas CREA.
 */
Route::get('/administracion/metas-estadisticas', 'AdministracionController@view_AdministrarMetasEstadisticas'); 
Route::post('/administracion/metas-estadisticas/save', 'AdministracionController@saveMetasEstadisticas');
Route::post('/administracion/metas-estadisticas/get', 'AdministracionController@getMetasEstadisticas');
Route::post('/administracion/metas-estadisticas/getConveniosById', 'AdministracionController@getConveniosById');

/**
 * 
 * Routes Administración de Proyectos e Indicadores
 */
Route::get('/administracion/proyectos', function () {
	return view('administracion/proyectos');
});
Route::post('/administracion/proyectos/getAll', 'cdm\CDMController@getProyectos');
Route::post('/administracion/proyectos/save', 'cdm\CDMController@saveProyecto');
Route::post('/administracion/proyectos/update', 'cdm\CDMController@updateProyecto');
Route::post('/administracion/proyectos/delete', 'cdm\CDMController@deleteProyecto');
Route::post('/administracion/proyectos/indicadores/getAll', 'cdm\CDMController@getIndicadoresProyecto');
Route::post('/administracion/proyectos/indicadores/save', 'cdm\CDMController@saveIndicador');
Route::post('/administracion/proyectos/indicadores/update', 'cdm\CDMController@updateIndicador');
Route::post('/administracion/proyectos/indicadores/updateAvance', 'cdm\CDMController@updateAvanceIndicador');
Route::post('/administracion/proyectos/indicadores/delete', 'cdm\CDMController@deleteIndicador');
Route::post('/administracion/proyectos/indicadores/getAllAvances', 'cdm\CDMController@getAvancesIndicador');
Route::post('/administracion/proyectos/indicadores/deleteAvance', 'cdm\CDMController@deleteAvanceIndicador');


/**
 * Rutas generales nidos
 */

Route::post('/sendIdToLaravel', 'OptionsController@setIdpersona');
Route::post('/getIdPersona', 'OptionsController@getIdPersona');
Route::post('/getRolPersona', 'OptionsController@getRolPersona');
Route::post('/getMes', 'OptionsController@getMes');
Route::post('/getDuplaPersona', 'OptionsController@getDuplaPersona');
Route::post('/getBarriosLocalidad', 'OptionsController@getBarriosLocalidad');
Route::post('/getUpzBarrio', 'OptionsController@getUpzBarrio');
Route::post('/getUpzLocalidad', 'OptionsController@getUpzLocalidad');

/**
 * Routes categorias NIDOS
 */

Route::get('/nidos/contenidos/administracion-contenidos', 'nidos\contenidos\ContenidosController@viewAdministracionContenidos');
Route::post('/options/getCategorias', 'nidos\contenidos\ContenidosController@getCategorias');
Route::post('/nidos/categorias/guardarNuevaCategoria', 'nidos\contenidos\ContenidosController@guardarNuevaCategoria');
Route::post('/nidos/categorias/modificarCategoria', 'nidos\contenidos\ContenidosController@modificarCategoria');

/**
 * Routes contenidos NIDOS
 */

Route::post('/nidos/contenidos/getContenidosPorCategoria', 'nidos\contenidos\ContenidosController@getContenidosPorCategoria');
Route::post('/nidos/contenidos/guardarNuevoContenido', 'nidos\contenidos\ContenidosController@guardarNuevoContenido');
Route::post('/nidos/contenidos/modificarContenido', 'nidos\contenidos\ContenidosController@modificarContenido');
Route::get('/nidos/contenidos/entrega-contenidos', 'nidos\contenidos\ContenidosController@viewEntregaContenidos');

Route::post('/nidos/contenidos/getContenidos', 'nidos\contenidos\ContenidosController@getContenidos');
Route::post('/nidos/contenidos/guardarBeneficiariosSinInfo', 'nidos\contenidos\ContenidosController@guardarBeneficiariosSinInfo');
Route::post('/nidos/contenidos/getInformeBeneficiariosSinInfo', 'nidos\contenidos\ContenidosController@getInformeBeneficiariosSinInfo');
Route::post('/nidos/contenidos/guardarBeneficiariosConInfo', 'nidos\contenidos\ContenidosController@guardarBeneficiariosConInfo');
Route::post('/nidos/contenidos/getInformeBeneficiariosConInfo', 'nidos\contenidos\ContenidosController@getInformeBeneficiariosConInfo');
Route::post('/nidos/contenidos/getListadoCifras', 'nidos\contenidos\ContenidosController@getListadoCifras');
Route::post('/nidos/contenidos/getInfoCifras', 'nidos\contenidos\ContenidosController@getInfoCifras');
Route::post('/nidos/contenidos/modificarBeneficiariosSinInfo', 'nidos\contenidos\ContenidosController@modificarBeneficiariosSinInfo');

/**
 * Routes circulacion NIDOS
 */

Route::get('/nidos/formularios/arn', function(){
	return view('nidos/circulacion/formularios/arn');
});
Route::post('/nidos/formularios/arn/guardarSolicitud', 'nidos\circulacion\AtencionesVirtualesController@guardarSolicitud');
Route::post('/nidos/formularios/aulashospitalarias/guardarSolicitudAulaHospitalaria', 'nidos\circulacion\AtencionesVirtualesController@guardarSolicitudAulaHospitalaria');

Route::get('/nidos/formularios/aulas-hospitalarias', function(){
    return view('nidos/circulacion/formularios/aulas_hospitalarias');
});


/**
 * Routes Territorios NIDOS 
 */
Route::post('/nidos/territorios/getTerritorioPersona', 'nidos\territorial\TerritoriosController@getTerritorioPersona');

/**
 * Routes Lugares de atención NIDOS
 */
Route::get('/nidos/territorial/administracion-lugares-atencion', 'nidos\territorial\LugaresController@viewAdministracionLugaresAtencion');
Route::post('/nidos/lugares/getOptionLocalidadGestor', 'nidos\territorial\LugaresController@getOptionLocalidadGestor');
Route::post('/nidos/lugares/getLugaresTerritorio', 'nidos\territorial\LugaresController@getLugaresTerritorio');
Route::post('/nidos/lugares/getInfoLugar', 'nidos\territorial\LugaresController@getInfoLugar');

/**
 * Routes Grupos NIDOS
 */
Route::post('/nidos/grupos/getGruposLugar', 'nidos\territorial\GruposController@getGruposLugar');

/**
 * Routes Beneficiarios NIDOS
 */
Route::post('/nidos/beneficiarios/getTipoDocumento', 'OptionsController@getTipoDocumento');
Route::post('/nidos/beneficiarios/getGenero', 'OptionsController@getGenero');
Route::post('/nidos/beneficiarios/getEnfoque', 'OptionsController@getEnfoque');
Route::post('/nidos/beneficiarios/getEstrato', 'OptionsController@getEstrato');
Route::post('/nidos/beneficiarios/validarBeneficiarioRegistrado', 'nidos\territorial\BeneficiariosController@validarBeneficiarioRegistrado');


/**
 * Routes Culturas en Común.
 */
Route::get('/culturas/reporteMetasCuantitativas', 'culturas\territorial\TerritorialController@viewReporteMetasCuantitativas');
Route::post('/culturas/reporteMetasCuantitativas/save', 'culturas\territorial\TerritorialController@saveReporteMetasCuantitativas');
Route::post('/culturas/reporteMetasCuantitativas/update', 'culturas\territorial\TerritorialController@updateReporteMetasCuantitativas');
Route::post('/culturas/reporteMetasCuantitativas/saveRevision', 'culturas\territorial\TerritorialController@saveRevisionReporteMetasCuantitativas');
Route::post('/culturas/reporteMetasCuantitativas/getAllReportesByUser', 'culturas\territorial\TerritorialController@getAllReportesMetasCuantitativasByUser');
Route::post('/culturas/reporteMetasCuantitativas/getReportesByFilters', 'culturas\territorial\TerritorialController@getReportesMetasCuantitativasByFilters');
Route::post('/culturas/reporteMetasCuantitativas/getReporte', 'culturas\territorial\TerritorialController@getReporteMetasCuantitativas');

/**
 * 
 * Routes Mostrar ventana de mantenimiento actividad.
 */
Route::get('/errors/mantenimiento', function () {
	return view('errors/mantenimiento');
});

/**
 * Routes para la administración de Beneficiarios CREA 
 */

Route::get('/administracion/beneficiarios/', function () {
	return view('administracion/beneficiarios');
});
Route::post('administracion/beneficiarios/getAll', 'crea\BeneficiariosController@getBeneficiarios');
Route::post('administracion/beneficiarios/get', 'crea\BeneficiariosController@getInformacionBeneficiario');
Route::post('administracion/beneficiarios/getAniosAdicionales', 'crea\BeneficiariosController@getInformacionAniosAdicionalBeneficiario');
Route::post('administracion/beneficiarios/getInfoAdicionalBeneficiario', 'crea\BeneficiariosController@getInformacionAdicionalBeneficiario');
Route::post('administracion/beneficiarios/getInfoGruposAnio', 'crea\BeneficiariosController@getInformacionGrupoAnio');
Route::post('administracion/beneficiarios/getAniosDocumentos', 'crea\BeneficiariosController@getAniosDocumentosBeneficiario');
Route::post('administracion/beneficiarios/getInfoArchivosBeneficiario', 'crea\BeneficiariosController@getDocumentosBeneficiarioAnio');
Route::post('administracion/beneficiarios/getInfoAdicionales', 'crea\BeneficiariosController@getInformacionAdicionalesActual');
Route::post('administracion/beneficiarios/getInfoColegios', 'crea\BeneficiariosController@GetInfoColegios');
Route::post('administracion/beneficiarios/saveBeneficiario', 'crea\BeneficiariosController@GuardarBeneficiario');
Route::post('administracion/beneficiarios/saveBeneficiarioAdicionales', 'crea\BeneficiariosController@GuardarAdicionalesBeneficiario');
Route::post('administracion/beneficiarios/saveArchivosAnioActual', 'crea\BeneficiariosController@GuardarArchivosBeneficiario');

/**
 * Routes para la administración de Beneficiarios CREA 
 */

Route::get('/crea/artistaFormador/ReporteRevisiones', function () {
	return view('crea/artistaFormador/reporte_revisiones');
});
Route::post('/crea/artistaFormador/ReporteRevisiones/getReportePrincipal', 'crea\ArtistaFormador\ReporteRevisionesController@getReporteInicial');
Route::post('/crea/artistaFormador/ReporteRevisiones/getReporteDetallado', 'crea\ArtistaFormador\ReporteRevisionesController@getReporteDetallado');

/**
 * Routes Módulo transición NIDOS
 */

Route::get('/nidos/transicion/administracion-colegios-convenio',  function () {
    return view('nidos/transicion/administracion_colegios_convenio');
});
Route::post('/nidos/transicion/getColegiosConvenioSED', 'nidos\transicion\AdministracionColegiosController@getColegiosConvenioSED');
Route::post('/nidos/transicion/guardarInstitucion', 'nidos\transicion\AdministracionColegiosController@guardarInstitucion');


Route::get('/nidos/transicion/administracion-grupos',  function () {
    return view('nidos/transicion/administracion_grupos');
});
Route::post('/nidos/transicion/getGruposDupla', 'nidos\transicion\AdministracionGruposController@getGruposDupla');
Route::post('/nidos/transicion/getLugaresAtenciontransicion', 'nidos\transicion\AdministracionColegiosController@getLugaresAtenciontransicion');
Route::post('/nidos/transicion/guardarGrupoDupla', 'nidos\transicion\AdministracionGruposController@guardarGrupoDupla');
Route::post('/nidos/transicion/getBeneficiariosSimat', 'nidos\transicion\AdministracionGruposController@getBeneficiariosSimat');
Route::post('/nidos/transicion/guardarBeneficiarioGrupo', 'nidos\transicion\AdministracionGruposController@guardarBeneficiarioGrupo');
Route::post('/nidos/transicion/getBeneficiariosGrupo', 'nidos\transicion\AdministracionGruposController@getBeneficiariosGrupo');
Route::post('getCodigoArtistasDupla', 'OptionsController@getCodigoArtistasDupla');

Route::get('/nidos/transicion/registro-experiencias',  function () {
    return view('nidos/transicion/registro_experiencias');
});

Route::post('/nidos/transicion/getGruposDuplaAsistencia',   'nidos\transicion\RegistroExperienciasController@getGruposDuplaAsistencia');
Route::post('/nidos/transicion/getLugarAtencionGrupo', 'nidos\transicion\AdministracionGruposController@getLugarAtencionGrupo');
Route::post('/nidos/transicion/guardarRegistroExperiencia', 'nidos\transicion\RegistroExperienciasController@guardarRegistroExperiencia');
Route::post('/nidos/transicion/getExperienciasRegistradasDupla', 'nidos\transicion\RegistroExperienciasController@getExperienciasRegistradasDupla');

Route::get('/culturas/refresh-csrf', function(){
    return csrf_token();
});
