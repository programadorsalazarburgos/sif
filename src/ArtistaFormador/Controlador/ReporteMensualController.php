<?php

namespace ArtistaFormador\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use ArtistaFormador\Controlador\ArtistaFormadorFactory;


class ReporteMensualController extends ArtistaFormadorFactory
{
	/**
	 * @var Container
	 *
	 */
	// private /*static*/ $contenedor;

	function __construct()
	{

 		parent::__construct();
		$this->initializeFactory();
 	}


  public function guardarHTMLInDB($datos){
    $TbAdminPdfCodigoVerificacion = $this->contenedor['TbAdminPdfCodigoVerificacion'];
     var_dump($datos);
  }

  	public function consultarNuevoCodigoVerificacion($datos){
  		// var_dump($datos);
  		$ReporteDAO = $this->contenedor['ReporteDAO'];
  		$reporte = $ReporteDAO->consultarJSONReporte($datos['codigo']);
  		echo json_encode($reporte);
  	}

	public function consultarCodigoVerificacion($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$TbAdminPdfCodigoVerificacion = $this->contenedor['TbAdminPdfCodigoVerificacion'];
		$TbAdminPdfCodigoVerificacion->setId($datos['codigo']);
		$resultado = $ReporteDAO->consultarCodigoVerificacion($TbAdminPdfCodigoVerificacion);
		if (isset($resultado[0]['html'])){
			echo $resultado[0]['html'];
		}else{
			echo "<h1>No se ha encontrado o no pertenece al año 2018</h1>";
		}
	}

	public function consultarGruposRegistroMiAsistenciaMes($datos){
		$return = "<optgroup label='Mis Grupos'>";
		$mis_grupos = "";
		$grupos_suplencia = "";
		$grupos_evento = "";
		$return = "<optgroup label='Mis Sesiones de clase'>";
		$mis_grupos = "";
		$grupos_suplencia = "";
		$tipo_grupo = ['arte_escuela','emprende_clan','laboratorio_clan'];
		$tipo_grupo_acronimo = ['AE','IC','CV'];
		$SesionClaseDAO = $this->contenedor['SesionClaseDAO'];
		for ($i=0; $i < sizeof($tipo_grupo); $i++) {
			$grupo = $SesionClaseDAO->consultarGruposMisSesionesMes($datos['id_usuario'],($datos['mes'].'-01'),$tipo_grupo[$i]);
			foreach ($grupo as $g){
				if ($g['suplencia'] == 0) {
					$mis_grupos .= "<option value='".$g['FK_Grupo']."' data-tipo_grupo='".$tipo_grupo[$i]."'>".$tipo_grupo_acronimo[$i]."-".$g['FK_Grupo']."</option>";
				}else{
					$grupos_suplencia .= "<option value='".$g['FK_Grupo']."' data-tipo_grupo='".$tipo_grupo[$i]."'>".$tipo_grupo_acronimo[$i]."-".$g['FK_Grupo']."</option>";
				}
			}

			$grupo_evento = $SesionClaseDAO->consultarGruposMisSesionesEventoMes($datos['id_usuario'],($datos['mes'].'-01'),$tipo_grupo[$i]);
			foreach ($grupo_evento as $g) {
				$grupos_evento .= "<option value='".$g['FK_grupo']."' data-tipo_grupo='".$tipo_grupo[$i]."'>".$tipo_grupo_acronimo[$i]."-".$g['FK_grupo']."</option>";
			}
		}

		$return .= $mis_grupos;
		$return .= "</optgroup><optgroup label='Suplencias'>";
		$return .= $grupos_suplencia;
		$return .= "</optgroup><optgroup label='Eventos'>";
		$return .= $grupos_evento;
		$return .= "</optgroup>";
		if(($mis_grupos=="")&&($grupos_suplencia=="")&&($grupos_evento=="")){
			echo "0";
		}
		else{
			echo $return;
		}
	}

	public function consultarOrganizacionSesionClaseMesGrupo($datos){
		$SesionClaseDAO = $this->contenedor['SesionClaseDAO'];
		$organizacion = $SesionClaseDAO->consultarOrganizacionSesionClaseMesGrupo($datos);
		foreach ($organizacion as $o) {
			echo "<option value=".$o['FK_organizacion'].">".$o['VC_Nom_Organizacion']."</option>";
		}
	}

	public function consultarDatosNuevoReporteArtistaFormador($datos){
		$json_sesion = [];
		$json_sesion['datos_basicos'] = [];
		$json_sesion['detallado_sesiones_clase'] = [];
		$json_sesion['listado_participantes'] = [];
		$json_sesion['detallado_sesiones_clase_participante'] = [];
		$json_sesion['detallado_sesiones_evento'] = [];
		$json_sesion['detallado_novedades'] = [];
		$json_sesion['total_horas_sesiones_clase'] = 0;
		$json_sesion['total_horas_sesiones_evento'] = 0;

		$SesionClaseDAO = $this->contenedor['SesionClaseDAO'];
		$PersonaDAO = $this->contenedor['PersonaDAO'];
		$datos_artista = $PersonaDAO->consultarInformacionEncabezadoReporteArtista($datos['id_usuario']);
		$json_sesion['datos_basicos'] = $datos_artista[0];

		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$area_artistica = $GrupoDAO->consultarAreaArtisticaGrupo($datos);
		$nombre_colegio = $GrupoDAO->consultarColegioGrupo($datos);
		$coordinador_crea = $GrupoDAO->consultarEngargadoCREAGrupo($datos);
		$json_sesion['datos_basicos']['nombre_area_artistica'] = $area_artistica[0]['VC_Nom_Area'];
		$json_sesion['datos_basicos']['nombre_colegio'] = $nombre_colegio;
		$json_sesion['datos_basicos']['nombre_coordinador_crea'] = $coordinador_crea[0]['nombre_coordinador'];
		$json_sesion['datos_basicos']['id_coordinador_crea'] = $coordinador_crea[0]['PK_Id_Persona'];
		$json_sesion['datos_basicos']['nombre_crea'] = $coordinador_crea[0]['nombre_crea'];
		$json_sesion['datos_basicos']['id_crea'] = $coordinador_crea[0]['FK_clan'];
		$json_sesion['datos_basicos']['id_grupo'] = $datos['id_grupo'];
		$json_sesion['datos_basicos']['id_usuario'] = $datos['id_usuario'];
		$json_sesion['datos_basicos']['tipo_grupo'] = $datos['tipo_grupo'];
		$json_sesion['datos_basicos']['mes_reporte'] = $datos['fecha_mes'];

		if($json_sesion['datos_basicos']['tipo_grupo'] == 'laboratorio_clan'){
			$tipo_atencion = $GrupoDAO->consultarTipoAtencionGrupo($datos['id_grupo'],'laboratorio_clan');
			if ($tipo_atencion['tipo_grupo'] == 6) {
				$json_sesion['datos_basicos']['nombre_coordinador_crea'] = 'JULIAN FERNEY RODRIGUEZ CORTES';
				$json_sesion['datos_basicos']['id_coordinador_crea'] = '1987';
			}
		}

		if($datos['en_grupo'] == 1){
			$sesion_clase = $SesionClaseDAO->consultarSesionesRegistradasEnGrupo($datos);
		}else{
			$sesion_clase = $SesionClaseDAO->consultarSesionesRegistradas($datos);
		}

		for ($i=0; $i < sizeof($sesion_clase); $i++) { 
			$json_sesion['detallado_sesiones_clase'][$i]['fecha_clase'] = $sesion_clase[$i]['DA_fecha_clase'];
			$json_sesion['detallado_sesiones_clase'][$i]['horas_clase'] = $sesion_clase[$i]['IN_horas_clase'];
			$json_sesion['detallado_sesiones_clase'][$i]['tipo_atencion'] = $sesion_clase[$i]['tipo_atencion'];
			$json_sesion['detallado_sesiones_clase'][$i]['lugar_atencion'] = $sesion_clase[$i]['lugar_atencion'];
			$json_sesion['detallado_sesiones_clase'][$i]['material'] = $sesion_clase[$i]['material'];
			$json_sesion['detallado_sesiones_clase'][$i]['suplencia'] = $sesion_clase[$i]['suplencia'];
			$json_sesion['detallado_sesiones_clase'][$i]['id_usuario'] = $sesion_clase[$i]['FK_usuario'];
			$json_sesion['detallado_sesiones_clase'][$i]['observaciones'] = $sesion_clase[$i]['TX_observaciones'];
			$json_sesion['detallado_sesiones_clase'][$i]['VC_anexo'] = $sesion_clase[$i]['VC_anexo'];
			$json_sesion['detallado_sesiones_clase'][$i]['estudiantes_matriculados'] = $SesionClaseDAO->consultarTotalEstudiantesSesionClase($sesion_clase[$i]['PK_sesion_clase'],$datos['tipo_grupo']);
			$json_sesion['detallado_sesiones_clase'][$i]['estudiantes_con_asistencia'] = $SesionClaseDAO->consultarTotalEstudiantesAsistieronASesionClase($sesion_clase[$i]['PK_sesion_clase'],$datos['tipo_grupo']);
			$json_sesion['total_horas_sesiones_clase'] += $sesion_clase[$i]['IN_horas_clase'];

			$listado_asistencia_dia = $SesionClaseDAO->consultarEstudiantesAsistenciaSesionClase($sesion_clase[$i]['PK_sesion_clase'],$datos['tipo_grupo']);
			
			foreach($listado_asistencia_dia as $l){
				$datos_participante_temp = array('id' => $l['id'],'documento' => $l['IN_Identificacion'],'nombre'=> $l['VC_Primer_Nombre'].' '.$l['VC_Segundo_Nombre'].' '.$l['VC_Primer_Apellido'].' '.$l['VC_Segundo_Apellido']);
				if(!in_array($datos_participante_temp, $json_sesion['listado_participantes'], true)){
					array_push($json_sesion['listado_participantes'], $datos_participante_temp);
				}
				$json_sesion['detallado_sesiones_clase_participante'][''.$sesion_clase[$i]['DA_fecha_clase']][$l['id']] = $l['IN_estado_asistencia'];
			}
		}

		$sesion_evento = $SesionClaseDAO->consultarSesionesEventoRegistradas($datos);
		$json_sesion['detallado_sesiones_evento'] = $sesion_evento;
		for ($i=0; $i < sizeof($sesion_evento); $i++) { 
			$json_sesion['detallado_sesiones_evento'][$i]['fecha_clase'] = $sesion_evento[$i]['DA_fecha_sesion_clase'];
			//$json_sesion['detallado_sesiones_evento'][$i]['horas_clase'] = $sesion_evento[$i]['IN_horas_clase'];
			$json_sesion['detallado_sesiones_evento'][$i]['observaciones'] = $sesion_evento[$i]['TX_observaciones'];
			$json_sesion['detallado_sesiones_evento'][$i]['estudiantes_matriculados'] = $SesionClaseDAO->consultarTotalEstudiantesSesionEvento($sesion_evento[$i]['PK_sesion_clase']);
			$json_sesion['detallado_sesiones_evento'][$i]['estudiantes_con_asistencia'] = $SesionClaseDAO->consultarTotalEstudiantesAsistieronASesionEvento($sesion_evento[$i]['PK_sesion_clase']);
			$json_sesion['total_horas_sesiones_evento'] += $sesion_evento[$i]['IN_horas_clase'];
		}

		$json_sesion['detallado_novedades'] = $SesionClaseDAO->consultarNovedadesReporteGrupo($datos);
		$json_sesion['datos_basicos']['nombre_grupo'] = '';
		switch ($datos['tipo_grupo']) {
			case 'arte_escuela':
				$json_sesion['datos_basicos']['linea_atencion'] = 'Arte en la escuela';
				$json_sesion['datos_basicos']['nombre_grupo'] .= 'AE-';
				break;
			case 'emprende_clan':
				$json_sesion['datos_basicos']['linea_atencion'] = 'Impulso Colectivo';
				$json_sesion['datos_basicos']['nombre_grupo'] .= 'IC-';
				break;
			case 'laboratorio_clan':
				$json_sesion['datos_basicos']['linea_atencion'] = 'Converge';
				$json_sesion['datos_basicos']['nombre_grupo'] .= 'CV-';
				break;
			default:
				$json_sesion['datos_basicos']['linea_atencion'] = 'No existe';
				$json_sesion['datos_basicos']['nombre_grupo'] .= 'NN-';
				break;
		}
		$json_sesion['datos_basicos']['nombre_grupo'] .= $json_sesion['datos_basicos']['id_grupo'];
		$convenio = $GrupoDAO->consultarConvenioGrupo($datos);
		if($convenio[0]['convenio'] == "NO APLICA") $convenio[0]['convenio'] = "DIRECTO";
		$json_sesion['datos_basicos']['convenio'] = " (".$convenio[0]['convenio'].")";

		$datos_organizacion = $GrupoDAO->consultarOrganizacionGrupo($datos['id_grupo'],$datos['tipo_grupo']);
		$json_sesion['datos_basicos']['id_organizacion'] = $datos_organizacion[0]['FK_organizacion'];
		$json_sesion['datos_basicos']['nombre_organizacion'] = $datos_organizacion[0]['nombre_organizacion'];
		echo json_encode($json_sesion);
	}

	public function consultarFormularioReporteMensual(){
		$vista = $this->contenedor['vista'];
		$vista->setNamespace('ArtistaFormador');
		$vista->setPlantilla('formularioReporteMensual');
		$vista->renderHtml();
	}

	public function guardarReporteMensualRevision($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		echo $ReporteDAO->saveReporteMensual($datos);
	}

	public function consultarExistenciaReporteMes($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$id_informe = $ReporteDAO->consultarExistenciaReporteMes($datos);
		if(empty($id_informe)){
			echo 0;
		}else{
			echo 1;
		}
	}

	public function consultarMisReportes($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$reporte = $ReporteDAO->consultarMisReportes($datos);
		echo $this->construirHTMLTablalistadoReportes($reporte,false);
	}

	public function consultarJSONReporte($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$reporte = $ReporteDAO->consultarJSONReporte($datos['id_informe']);
		echo json_encode($reporte);
	}

	public function consultarReportesPorRevisar($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$reporte = $ReporteDAO->consultarReportesPendientesRevision($datos);
		echo $this->construirHTMLTablalistadoReportes($reporte,true);
	}

	public function consultarReportesAsignadosParaRevisar($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$reporte = $ReporteDAO->consultarReportesAsignadosParaRevisar($datos);
		echo $this->construirHTMLTablalistadoReportes($reporte,false,true);
	}

	public function rechazarReporte($datos){
		$datos["tipo_accion"] = 'rechazar';
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		echo $reporte = $ReporteDAO->actualizarEstadoReporte($datos);
	}

	public function aprobarReporte($datos){
		$datos["tipo_accion"] = 'aprobar';
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		echo $reporte = $ReporteDAO->actualizarEstadoReporte($datos);
	}

	public function consultarJSONObservaciones($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$reporte = $ReporteDAO->consultarJSONObservaciones($datos);
		echo json_encode($reporte);
	}

	public function enviarReporteCorregido($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		echo $ReporteDAO->updateJSONReporte($datos);
	}

	public function consultarNovedadesGrupo($datos){
		$NovedadSesionClaseDAO = $this->contenedor['NovedadSesionClaseDAO'];
		$novedades_grupo = $NovedadSesionClaseDAO->consultarObjeto($datos);
		echo json_encode($novedades_grupo);
	}

	public function registrarNuevaNovedad($datos){
		$NovedadSesionClaseDAO = $this->contenedor['NovedadSesionClaseDAO'];
		$TbTerrGrupoSesionClaseNovedad  = $this->contenedor['TbTerrGrupoSesionClaseNovedad'];
		$TbTerrGrupoSesionClaseNovedad->setFkGrupo($datos['id_grupo']);
		$TbTerrGrupoSesionClaseNovedad->setTipoGrupo($datos['tipo_grupo']);
		$TbTerrGrupoSesionClaseNovedad->setDaFechaSesionClase($datos['fecha_novedad']);
		$TbTerrGrupoSesionClaseNovedad->setInNovedad($datos['id_novedad']);
		$TbTerrGrupoSesionClaseNovedad->setInAsistencia($datos['asistencia']);
		$TbTerrGrupoSesionClaseNovedad->setTxObservacion($datos['observacion']);
		$TbTerrGrupoSesionClaseNovedad->setFkArtistaFormador($datos['id_artista_formador']);
		$TbTerrGrupoSesionClaseNovedad->setFkUsuarioRegistro($datos['id_usuario']);
		$id_nueva_novedad = $NovedadSesionClaseDAO->crearObjeto($TbTerrGrupoSesionClaseNovedad);
		echo $id_nueva_novedad;
	}

	public function consultarMesesReporteAprobado($datos){
		echo json_encode($datos);
	}

	public function obtenerSitioAtencionGrupoLaboratorio($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$TbTerrGrupo = $this->contenedor['TbTerrGrupo'];
		$TbTerrGrupo->setTipoGrupo('laboratorio_clan');
		$TbTerrGrupo->setPkGrupo($datos['id_grupo']);
		$sitio_atencion = $GrupoDAO->consultarObjeto($TbTerrGrupo);
		$horario_grupo = $GrupoDAO->consultarHorarioGrupo($datos['id_grupo'],'laboratorio_clan');
		$datos_grupo = array('sitio_atencion' => $sitio_atencion['TX_Sitio'], 'horario_grupo' => $horario_grupo );
		echo json_encode($datos_grupo);
	}

	public function eliminarNovedad($datos){
		$NovedadSesionClaseDAO = $this->contenedor["NovedadSesionClaseDAO"];
		echo $NovedadSesionClaseDAO->eliminarNovedad($datos['id_novedad'],$datos['tipo_grupo']);
	}

	public function actualizarJSON($datos1,$datos2){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$resultado_update = $ReporteDAO->actualizarJSON($datos1['id_informe'],$datos2);
		echo $resultado_update;
	}

	public function actualizarNovedad($datos){
		$NovedadSesionClaseDAO = $this->contenedor["NovedadSesionClaseDAO"];
		echo $NovedadSesionClaseDAO->actualizarNovedad($datos);
	}

	public function consultarPeriodosReporteDigitalMensual(){
		$mostrar = "";
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$periodo = $ReporteDAO->consultarPeriodosReporteDigitalMensual();
		for ($i=0; $i < sizeof($periodo) ; $i++) { 
			$mostrar .= "<option value='".$periodo[$i]['VC_fecha_reporte']."'>".$periodo[$i]['VC_fecha_reporte']."</option>";
		}
		echo $mostrar;
	}

	public function consultarTodosLosReportesAprobados($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$reporte = $ReporteDAO->consultarTodosLosReportesAprobados($datos);
		$mostrar = "<table class='table' id='table_listado_informes'>";
		$mostrar .= "<thead><tr>";
		$mostrar .= "<th>Artista</th>";
		$mostrar .= "<th>Grupo</th>";
		$mostrar .= "<th>Periodo</th>";
		$mostrar .= "<th>Fecha de Registro/Edición</th>";
		$mostrar .= "<th>Fecha revisión</th>";
		$mostrar .= "<th>Informe</th>";
		$mostrar .= "</tr></thead><tbody>";
		foreach ($reporte as $r) {
			$mostrar .= "<tr>";
				$mostrar .= "<td>".$r['nombre_artista']."</td>";
				$mostrar .= "<td>".$r['nombre_grupo']."</td>";
				$mostrar .= "<td>".$r['VC_fecha_reporte']."</td>";
				$mostrar .= "<td>".$r['DT_fecha_creacion']."</td>";
				$mostrar .= "<td>".$r['DT_fecha_aprobacion']."</td>";
				$mostrar .= "<td><button data-fecha_reporte='".$r['VC_fecha_reporte']."' data-id_grupo='".$r['FK_grupo']."' data-tipo_linea_atencion='".$r['linea_atencion']."' data-id_organizacion='".$r['id_organizacion']."' data-id_informe='".$r['id']."' data-estado='".$r['SM_estado']."' class='btn btn-danger quitar_aprobado'>Quitar Aprobado</button></td>";
				$mostrar .= "</button></td>";
			$mostrar .= "</tr>";
		}
		$mostrar .= "</tbody></table>";
		echo $mostrar;
	}

	public function consultarUsuariosVerificanReporte($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$usuario = $ReporteDAO->consultarUsuariosVerificanReporte($datos);
		foreach ($usuario as $u) {
			echo '<option value="'.$u['id_usuario'].'">'.$u['nombre_usuario'].'</option>';
		}
	}

	public function consultarReportesAprobadosArtistaFormador($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$reporte = $ReporteDAO->consultarReportesAprobadosArtistaFormador($datos);
		echo $this->construirHTMLTablalistadoReportes($reporte,false, false);
	}

	public function consultarReportesAprobadosFiltros($datos){
		$ReporteDAO = $this->contenedor['ReporteDAO'];
		$reporte = $ReporteDAO->consultarReportesAprobadosFiltros($datos['year'], $datos['linea_atencion'], $datos['convenio'], $datos['colegio']);
		echo $this->construirHTMLTablalistadoReportes($reporte,false, false);
	}

	private function construirHTMLTablalistadoReportes($reporte,$es_coordinador,$solo_ver=false){
		$mostrar = "<table class='table' id='table_listado_informes'>";
		$mostrar .= "<thead><tr>";
		// if($es_coordinador){
		// 	$mostrar .= "<th>Artista</th>";
		// }
		// if($solo_ver){
		// 	$mostrar .= "<th>Artista</th>";
		// }
		$mostrar .= "<th>Grupo</th>";
		$mostrar .= "<th>Artista</th>";
		$mostrar .= "<th>Periodo</th>";
		$mostrar .= "<th>Fecha de Registro/Edición</th>";
		if(!$es_coordinador){
			$mostrar .= "<th>Fecha revisión</th>";
		}
		$mostrar .= "<th>Informe</th>";
		$mostrar .= "</tr></thead><tbody>";
		foreach ($reporte as $r) {
			$mostrar .= "<tr>";
				// if($es_coordinador){
				// 	$mostrar .= "<td>".$r['nombre_artista']."</td>";
				// }
				// if($solo_ver){
				// 	$mostrar .= "<td>".$r['nombre_artista']."</td>";
				// }
				$mostrar .= "<td>".$r['nombre_grupo']."</td>";
				$mostrar .= "<td>".$r['nombre_artista']."</td>";
				$mostrar .= "<td>".$r['VC_fecha_reporte']."</td>";
				$mostrar .= "<td>".$r['DT_fecha_creacion']."</td>";
				if(!$es_coordinador){
					$mostrar .= "<td>".$r['DT_fecha_aprobacion']."</td>";
				}
				$mostrar .= "<td><button data-fecha_reporte='".$r['VC_fecha_reporte']."' data-id_grupo='".$r['FK_grupo']."' data-tipo_linea_atencion='".$r['linea_atencion']."' data-id_organizacion='".$r['id_organizacion']."' data-id_informe='".$r['id']."' data-estado='".$r['SM_estado']."' class='btn ";
				if($solo_ver){
					$mostrar .= "btn_modal_reporte btn-info' data-toggle='modal' data-target='#modal_informe_mensual' data-tipo_visualizacion='consulta'>Ver";
					switch ($r['SM_estado']) {
						case '0':
							$mostrar .= " <span class='label label-warning'>Sin revisión</span>";
							break;
						case '1':
							$mostrar .= " <span class='label label-success'>Aprobado</span>";
							break;
						case '2':
							$mostrar .= " <span class='label label-warning'>Rechazado</span>";
							break;
						default:
							$mostrar .= " <span class='label label-danger'>Desconocido</span>";
							break;
					}
				}
				else{
					if($es_coordinador){
						$mostrar .= "btn_modal_reporte btn-warning' data-toggle='modal' data-target='#modal_informe_mensual' data-tipo_visualizacion='revisar'>Revisar";
					}else{
						switch ($r['SM_estado']) {
							case '0':
								$mostrar .= "btn_modal_reporte btn-info' data-toggle='modal' data-target='#modal_informe_mensual' data-tipo_visualizacion='consulta'>Ver";
								break;
							case '1':
								$mostrar .= "descargar_pdf btn-success'>Descargar PDF";
								break;
							case '2':
								$mostrar .= "btn_modal_reporte btn-warning' data-toggle='modal' data-target='#modal_informe_mensual' data-tipo_visualizacion='corregir'>Rechazado (Corregir)";
								break;
							default:
								$mostrar .= "btn-info'>Estado desconocido";
								break;
						}
					}
				}
				$mostrar .= "</button> <button class='btn btn-warning ver_anexos' data-fecha_reporte='".$r['VC_fecha_reporte']."' data-id_grupo='".$r['FK_grupo']."' data-tipo_linea_atencion='".$r['linea_atencion']."' data-id_organizacion='".$r['id_organizacion']."' data-id_informe='".$r['id']."' data-estado='".$r['SM_estado']."'>Anexos</button></td>";
			$mostrar .= "</tr>";
		}
		$mostrar .= "</tbody></table>";
		return $mostrar;
	}
}
$objControlador = new ReporteMensualController();
unset($objControlador);
