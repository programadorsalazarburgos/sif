<?php

namespace GestionClan\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use GestionClan\Controlador\GestionClanFactory;

class GestionClanController extends GestionClanFactory
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

	public function consultarAdjuntosPorDocumento($documento){
		$BeneficiarioDAO= $this->contenedor['BeneficiarioDAO'];
		echo $BeneficiarioDAO->consultarAdjuntosPorDocumento($documento)[0]['archivos'];
	}

	public function crearNuevoGrupo($datos){
		$TbTerrGrupo = $this->contenedor['TbTerrGrupo'];
		$GrupoDAO = $this->contenedor['GrupoDAO'];

		$TbTerrGrupo->setTipoGrupo($datos['SL_linea_atencion']);
		$TbTerrGrupo->setInLugarAtencion($datos['SL_lugar_atencion']);
		$TbTerrGrupo->setInModalidadAtencion($datos['SL_modalidad_atencion']); //Modalidad de atención del grupo
		$TbTerrGrupo->setInTipoAtencion($datos['SL_tipo_atencion']);
		$TbTerrGrupo->setInConvenio($datos['SL_convenio']);
		$TbTerrGrupo->setFkClan($datos['SL_clan']);
		$TbTerrGrupo->setFkAreaArtistica($datos['SL_area_artistica']);
		$TbTerrGrupo->setTxObservaciones($datos['TX_observaciones']);
		$TbTerrGrupo->setFkOrganizacion(2);
		$TbTerrGrupo->setFkCreador($datos['id_usuario']);
		$TbTerrGrupo->setEstado(1);

		switch ($datos['SL_linea_atencion']) {
			case 'arte_escuela':
			$TbTerrGrupo->setVcGrados($datos['SL_grados']);
			$TbTerrGrupo->setFkColegio($datos['SL_colegio_responsable']);
			$TbTerrGrupo->setTipoGrupoAtencion(null);
			break;
			case 'emprende_clan':
			$TbTerrGrupo->setFkModalidad($datos['SL_modalidad_area_artistica']); //Modalidad área artística emprende
			$TbTerrGrupo->setTipoGrupoAtencion($datos['SL_tipo_grupo_emprende_clan']);
			$TbTerrGrupo->setGrupoAbiertoPublico($datos['SL_oferta_disponible']);
			if($datos['TX_cantidad_cupos'] == "")
				$TbTerrGrupo->setInCupos(null);
			else
				$TbTerrGrupo->setInCupos($datos['TX_cantidad_cupos']);
			break;
			case 'laboratorio_clan':
			$TbTerrGrupo->setTipoGrupoAtencion($datos['SL_tipo_grupo_laboratorio_crea']);
			$TbTerrGrupo->setFkInstitucionLaboratorio($datos['SL_institucion_laboratorio_crea']);
			$TbTerrGrupo->setFkAliadoLaboratorio($datos['SL_aliado_laboratorio_crea']);
			$TbTerrGrupo->setTipoPoblacion($datos['SL_subcategoria_poblacion_laboratorio']);
			if($datos['SL_espacio_alterno_converge'] == "")
				$TbTerrGrupo->setInEspacioAlterno(null);
			else
				$TbTerrGrupo->setInEspacioAlterno($datos['SL_espacio_alterno_converge']);
			break;
		}
		$array_horario_dia = [];
		foreach ($datos as $key => $value) {
			if (strpos($key, 'SL_hora_inicio_dia_') !== false) {
				$dia_sesion_clase = explode("SL_hora_inicio_dia_", $key)[1];
				$array_temp_hora_inicio = array(
					'dia' => $dia_sesion_clase,
					'hora_inicio' => $datos[$key]
				);
				$array_horario_dia[$dia_sesion_clase] = $array_temp_hora_inicio;
			}
		}
		foreach ($array_horario_dia as $key => $value) {
			if('arte_escuela' == $datos['SL_linea_atencion']){
				$horas_por_dia = ($datos['SL_numero_horas']/$datos['SL_numero_sesiones']);
				$hora_fin = strtotime($datos['SL_hora_inicio_dia_'.$key]) + (3600 * $horas_por_dia);
				$hora_fin = date('H:i', $hora_fin);
				$array_horario_dia[$key]['hora_fin'] = $hora_fin;
			}else{
				$array_horario_dia[$key]['hora_fin'] = $datos['SL_hora_fin_dia_'.$key];
			}
		}
		$TbTerrGrupo->setHorarioArray($array_horario_dia);
		echo $GrupoDAO->crearObjeto($TbTerrGrupo);
	}
	
	public function EditarCobertura($datos){
		$json_area_artistica = array();
		foreach ($datos as $key => $value) {
			if (strpos($key, 'IN_numero_grupos_') !== false)
				$json_area_artistica[substr($key, -3, 1)]=array();
			if (strpos($key, 'IN_numero_beneficiarios_proyectados_area_artistica_') !== false)
				$json_area_artistica[substr($key, -1)]=array();
			if (strpos($key, 'TX_observaciones_beneficiarios_proyectados_area_artistica_') !== false)
				$json_area_artistica[substr($key, -1)]=array();
		}
		foreach ($datos as $key => $value) {
			if (strpos($key, 'IN_numero_grupos_') !== false) {
				$json_area_artistica[substr($key, -3, 1)]['grupos_lugar_atencion_'.substr($key, -1)]=$value;
			}
			if (strpos($key, 'IN_numero_beneficiarios_proyectados_area_artistica_') !== false) {
				$json_area_artistica[substr($key, -1)]['beneficiarios_proyectados']=$value;
			}
			if (strpos($key, 'TX_observaciones_beneficiarios_proyectados_area_artistica_') !== false) {
				$json_area_artistica[substr($key, -1)]['observaciones']=$value;
			}
		}
		$json_area_artistica=json_encode($json_area_artistica);
		$TbCobertura = $this->contenedor['TbCobertura'];
		$TbCobertura->setId($datos['id']);
		$TbCobertura->setAnio(date("Y"));
		$TbCobertura->setLineaAtencion($datos['SL_linea_atencion']);
		$TbCobertura->setIdZona($datos['SL_zona']);
		$TbCobertura->setIdColegio($datos['SL_colegio']);
		$TbCobertura->setIdClan($datos['SL_clan']);
		$TbCobertura->setIdConvenio($datos['SL_convenio']);
		$TbCobertura->setJsonAreaArtistica($json_area_artistica);
		$TbCobertura->setFkUsuarioCreacionEdicion($datos['id_usuario']);
		$TbCobertura->setEstado(1);
		$CoberturaDAO = $this->contenedor['CoberturaDAO'];
		$CoberturaDAO->modificarObjeto($TbCobertura);
	}

	
	public function EliminarCobertura($data){
		$CoberturaDAO = $this->contenedor['CoberturaDAO'];
		$CoberturaDAO->eliminarObjeto($data);
	}

	public function modificarGrupo($datos){
		$TbTerrGrupo = $this->contenedor['TbTerrGrupo'];
		$GrupoDAO = $this->contenedor['GrupoDAO'];

		$TbTerrGrupo->setPkGrupo($datos['id_grupo_modificar']);
		$TbTerrGrupo->setInLugarAtencion($datos['SL_lugar_atencion_modificar']);
		$TbTerrGrupo->setInModalidadAtencion($datos['SL_modalidad_atencion_modificar']);
		$TbTerrGrupo->setInTipoAtencion($datos['SL_tipo_atencion_modificar']);
		$TbTerrGrupo->setInConvenio($datos['SL_convenio_modificar']);
		$TbTerrGrupo->setFkAreaArtistica($datos['SL_area_artistica_modificar']);
		$TbTerrGrupo->setTxObservaciones($datos['TX_observaciones_modificar']);
		$TbTerrGrupo->setFkCreador($datos['id_usuario_modifica_grupo']);
		$TbTerrGrupo->setTipoGrupo($datos['linea_atencion']);

		switch ($datos['linea_atencion']) {
			case 'arte_escuela':
			$TbTerrGrupo->setVcGrados($datos['SL_grados_modificar']);
			break;
			case 'emprende_clan':
			$TbTerrGrupo->setFkModalidad($datos['SL_modalidad_area_artistica_modificar']); //Modalidad área artística emprende
			$TbTerrGrupo->setTipoGrupoAtencion($datos['SL_tipo_grupo_emprende_clan_modificar']);
			$TbTerrGrupo->setGrupoAbiertoPublico($datos['SL_oferta_disponible_modificar']);
			if($datos['TX_cantidad_cupos_modificar'] == "")
				$TbTerrGrupo->setInCupos(null);
			else
				$TbTerrGrupo->setInCupos($datos['TX_cantidad_cupos_modificar']);
			break;
			case 'laboratorio_clan':
			$TbTerrGrupo->setTipoGrupoAtencion($datos['SL_tipo_grupo_laboratorio_crea_modificar']);
			$TbTerrGrupo->setFkInstitucionLaboratorio($datos['SL_institucion_laboratorio_crea_modificar']);
			$TbTerrGrupo->setFkAliadoLaboratorio($datos['SL_aliado_laboratorio_crea_modificar']);
			$TbTerrGrupo->setTipoPoblacion($datos['SL_subcategoria_poblacion_laboratorio_modificar']);
			if($datos['SL_espacio_alterno_converge_modificar'] == "")
				$TbTerrGrupo->setInEspacioAlterno(null);
			else
				$TbTerrGrupo->setInEspacioAlterno($datos['SL_espacio_alterno_converge_modificar']);
			break;
			default:

			break;
		}
		$array_horario_dia = [];
		foreach ($datos as $key => $value) {
			if (strpos($key, 'SL_modificar_hora_inicio_dia_') !== false) {
				$dia_sesion_clase = explode("SL_modificar_hora_inicio_dia_", $key)[1];
				$array_temp_hora_inicio = array(
					'dia' => $dia_sesion_clase,
					'hora_inicio' => $datos[$key]
				);
				$array_horario_dia[$dia_sesion_clase] = $array_temp_hora_inicio;
			}
		}
		foreach ($array_horario_dia as $key => $value) {
			if('arte_escuela' == $datos['linea_atencion']){

				$horas_por_dia = ($datos['SL_numero_horas_modificar']/$datos['SL_numero_sesiones_modificar']);
				$hora_fin = strtotime($datos['SL_modificar_hora_inicio_dia_'.$key]) + (3600 * $horas_por_dia);
				$hora_fin = date('H:i', $hora_fin);
				$array_horario_dia[$key]['hora_fin'] = $hora_fin;
			}else{
				$array_horario_dia[$key]['hora_fin'] = $datos['SL_modificar_hora_fin_dia_'.$key];
			}
		}
		$TbTerrGrupo->setHorarioArray($array_horario_dia);
		echo $GrupoDAO->modificarObjeto($TbTerrGrupo);
	}

	public function deleteNovedad($datos){
		$NovedadSesionClaseDAO = $this->contenedor['NovedadSesionClaseDAO'];
		echo $NovedadSesionClaseDAO->eliminarNovedad($datos['id'],$datos['tipo_grupo']);
	}

	public function updateNovedad($datos,$tipo_grupo){
		$datosUpdate=array();
		foreach ($datos as $key => $value) {
			$signo='=';
			$llave=false;
			if($key=='id')
				$llave=true;
			$datosUpdate[$key]=array('valor'=>$value,
				'signo'=>$signo,
				'llave'=>$llave);
		}
		$novedad = $this->contenedor['TbTerrGrupoSesionClaseNovedad'];
		$novedad->setVariables($datosUpdate);
		$update=$novedad->setUpdate("N");
		$NovedadSesionClaseDAO = $this->contenedor['NovedadSesionClaseDAO'];
		$tipo_grupo = $tipo_grupo['tipo_grupo'];
		$updateNovedad = $NovedadSesionClaseDAO->modificarObjetoLineaAtencion($update,$tipo_grupo);
		if($updateNovedad)
			echo "un texto o no se";
		echo 'datosUpdateeeeeeee: <pre>'.print_r($datos,true).'</pre>';
	}

	public function consultarNovedadesGrupoMes($datos){
		$novedad = $this->contenedor['NovedadSesionClaseDAO']->consultarObjeto($datos);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('novedad'=>$novedad,'tipo_mostrar'=>'novedades_reporte'));
		$vista->setPlantilla('tableNovedadBase');
		$vista->renderHtml();
	}

	public function consultarEstudiantesPorEstadoGrupo($datos,$tipo_grupo){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$estudiante = $GrupoDAO->consultarEstudiantesPorEstadoGrupo($datos['id_grupo'],$tipo_grupo,$datos['estado']);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('estudiante'=>$estudiante,'tipo_mostrar'=>$datos['tipo_mostrar'],'id_grupo'=>$datos['id_grupo']));
		$vista->setPlantilla('tableEstudiantesBase');
		$vista->renderHtml();
	}

	public function asignarArtistaOrganizacion($datos){
		$formadorOrganizacion=$this->contenedor["formadorOrganizacion"];
		$formadorOrganizacionDAO=$this->contenedor["formadorOrganizacionDAO"];
		$formadorOrganizacion->setFkIdPersona($datos["artista"]);
		$formadorOrganizacion-> setFkIdOrganizacion($datos["organizacion"]);
		$formadorOrganizacion->setDtFechaAsignacion(date("Y-m-d H:i:s"));
		echo $formadorOrganizacionDAO->crearObjeto($formadorOrganizacion);
	}

	public function consultarEstudianteEnTbEstudiante($datosEstudiante,$datos){
		$BeneficiarioDAO = $this->contenedor["BeneficiarioDAO"];
		$tbEstudiante=$this->contenedor['TbEstudiante'];
		$tbEstudiante->setVariables($datosEstudiante);
		$estudiante = $BeneficiarioDAO->consultarEstudianteEnTbEstudiante($tbEstudiante);
		$array_grupo_actual = array();
		foreach ($estudiante as $e) {
			$id_grupo = 0;
			$id_grupo = $BeneficiarioDAO->consultarGruposActivosEstudiante($e['id'],$datos['tipo_grupo']);
			if (empty($id_grupo)) {
				$id_grupo = 0;
			}else{
				$id_grupo = $id_grupo[0]['FK_grupo'];
			}
			$array_grupo_actual[$e['id']] = $id_grupo;
		}

		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('estudiante'=>$estudiante,'tipo_mostrar'=>'consulta_estudiante_tb_estudiante','tipo_grupo'=>$datos['tipo_grupo'],'id_grupo'=>$datos['id_grupo'],'tipo_grupo_atencion'=>$datos['tipo_grupo_atencion'],'estudiante_grupo'=>$array_grupo_actual));
		$vista->setPlantilla('tableEstudiantesBase');
		$vista->renderHtml();
	}

	public function consultarLugaresAtencionGrupoArteEscuela(){
		$lugar_atencion = array(array('id'=>'1','descripcion'=>'SOLO COLEGIO'),
			array('id'=>'2','descripcion'=> 'SOLO CREA'),
			array('id'=>'3','descripcion'=>'CREA Y COLEGIO'),
			array('id'=>'4','descripcion'=>'CREA EN CASA (Página web)')
		);
		$vista = $this->contenedor['vista'];
		$vista->setPlantilla('getOptionsLugarAtencionGrupoArteEscuela');
		$vista->setVariables(array('lugar_atencion'=>$lugar_atencion));
		$vista->renderHtml();
	}

	public function getOptionModalidad($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$vista = $this->contenedor['vista'];
		$modalidad = $GrupoDAO->consultarModalidad($datos['id_area_artistica']);
		$vista->setVariables(array('modalidad'=>$modalidad));
		$vista->renderHtml();
	}

	public function getOptionColegiosCrea($datos){
		$ColegioDAO = $this->contenedor['ColegioDAO'];
		$vista = $this->contenedor['vista'];
		$colegio = $ColegioDAO->consultarColegiosDeCrea($datos['id_crea']);
		$vista->setVariables(array('colegio'=>$colegio));
		$vista->renderHtml();
	}

	public function getColegiosGrupo($datos){
		$ColegioDAO = $this->contenedor['ColegioDAO'];
		$colegio = $ColegioDAO->consultarColegiosPorGrupo($datos['id_grupo']);	 		
		/*echo $colegio[0]['VC_Nom_Colegio'];*/
		echo json_encode($colegio);
	}

	public function consultarDatosCompletosGrupo($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$TbTerrGrupo = $this->contenedor['TbTerrGrupo'];
		$TbTerrGrupo->setTipoGrupo($datos['tipo_grupo']);
		$TbTerrGrupo->setPkGrupo($datos['id_grupo']);

		$datos_grupo = $GrupoDAO->consultarObjeto($TbTerrGrupo);
		$datos_grupo['horario'] = $GrupoDAO->consultarHorarioGrupo($TbTerrGrupo->getPkGrupo(),$TbTerrGrupo->getTipoGrupo());

		echo json_encode($datos_grupo);
	}

	public function consultarDatosCompletosGrupoPorCrea($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$TbTerrGrupo = $this->contenedor['TbTerrGrupo'];
		$TbTerrGrupo->setTipoGrupo($datos['tipo_grupo']);
		$TbTerrGrupo->setFkClan($datos['id_crea']);

		$datos_grupo = $GrupoDAO->consultarGruposActivosCrea($TbTerrGrupo);

		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('grupo'=>$datos_grupo,'tipo_grupo'=>$datos['tipo_grupo'],'tipo_mostrar'=>$datos['tipo_mostrar']));
		$vista->setPlantilla('tableGrupoBase');
		$vista->renderHtml();
	}

	public function consultarTablaGruposAsignarOrganizacion($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$grupo = $GrupoDAO->consultarGruposActivos($datos['tipo_grupo']);
		$horario_grupo = array();
 		/*foreach ($grupo as $g) {
 			$horario_temp = $GrupoDAO->consultarHorarioGrupo($g['PK_Grupo'],$datos['tipo_grupo']);
 			$horario_grupo[$g['PK_Grupo']] = $horario_temp;
 		}*/

 		$vista = $this->contenedor['vista'];
 		$vista->setVariables(array('grupo'=>$grupo,'horario_grupo'=>$horario_grupo,'tipo_grupo'=>$datos['tipo_grupo'],'tipo_mostrar'=>$datos['tipo_mostrar']));
 		$vista->setPlantilla('tableGrupoBase');
 		$vista->renderHtml();
 	}

 	public function cerrarGrupo($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$TbTerrGrupo = $this->contenedor['TbTerrGrupo'];
 		$TbTerrGrupo->setTipoGrupo($datos['tipo_grupo']);
 		$TbTerrGrupo->setPkGrupo($datos['id_grupo']);
 		$TbTerrGrupo->setFKQuienCerro($datos['id_usuario']);
 		$TbTerrGrupo->setEstado(0);
 		$TbTerrGrupo->setTxObservaciones($datos['justificacion']);
 		echo $GrupoDAO->cerrarGrupo($TbTerrGrupo);
 	}

 	public function getOptionGruposDeUnCrea($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$vista = $this->contenedor['vista'];
 		$vista->setNamespace("General"); //Se cambia el namespace para poder utilizar la vista que se encuentra en general/vista/getOptionGruposDeUnCrea.php
 		$grupo = $GrupoDAO->consultarGruposClanPorEstado($datos["id_crea"], $datos["linea_atencion"], 1);
 		$vista->setVariables(array('grupo'=>$grupo,'tipo_grupo'=>$datos["linea_atencion"]));
 		$vista->renderHtml();
 	}

 	public function fusionarGrupos($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$TbTerrGrupo_1 = $this->contenedor['TbTerrGrupo'];

 		$TbTerrGrupo_2 = clone $this->contenedor['TbTerrGrupo'];
 		$TbTerrGrupo_1->setTipoGrupo($datos['linea_atencion']);
 		$TbTerrGrupo_2->setTipoGrupo($datos['linea_atencion']);
 		$TbTerrGrupo_1->setFkClan($datos['crea']);
 		$TbTerrGrupo_2->setFkClan($datos['crea']);
 		$TbTerrGrupo_1->setPkGrupo($datos['id_grupo_uno']);
 		$TbTerrGrupo_2->setPkGrupo($datos['id_grupo_dos']);
 		$TbTerrGrupo_1->setTxObservaciones($datos['justificacion']);

 		$datos_grupo_uno = $GrupoDAO->consultarObjeto($TbTerrGrupo_1);
 		$datos_grupo_dos = $GrupoDAO->consultarObjeto($TbTerrGrupo_2);

		$TbTerrGrupo_1->setInLugarAtencion($datos_grupo_uno['IN_lugar_atencion']);
		$TbTerrGrupo_2->setInLugarAtencion($datos_grupo_dos['IN_lugar_atencion']);
		$TbTerrGrupo_1->setInModalidadAtencion($datos_grupo_uno['IN_modalidad_atencion']);
		$TbTerrGrupo_2->setInModalidadAtencion($datos_grupo_dos['IN_modalidad_atencion']); //Modalidad de atención del grupo
		$TbTerrGrupo_1->setInTipoAtencion($datos_grupo_uno['IN_tipo_atencion']);
		$TbTerrGrupo_2->setInTipoAtencion($datos_grupo_dos['IN_tipo_atencion']);
		$TbTerrGrupo_1->setInConvenio($datos_grupo_uno['IN_convenio']);
		$TbTerrGrupo_2->setInConvenio($datos_grupo_dos['IN_convenio']);
		$TbTerrGrupo_1->setFkAreaArtistica($datos_grupo_uno['FK_area_artistica']);
		$TbTerrGrupo_2->setFkAreaArtistica($datos_grupo_dos['FK_area_artistica']);
		$TbTerrGrupo_1->setTxObservaciones($datos_grupo_uno['TX_observaciones']);
		$TbTerrGrupo_2->setTxObservaciones($datos_grupo_dos['TX_observaciones']);
		$TbTerrGrupo_1->setFkOrganizacion($datos_grupo_uno['FK_organizacion']);
		$TbTerrGrupo_2->setFkOrganizacion($datos_grupo_dos['FK_organizacion']);
		$TbTerrGrupo_1->setFkCreador($datos_grupo_uno['FK_creador']);
		$TbTerrGrupo_2->setFkCreador($datos_grupo_dos['FK_creador']);
		$TbTerrGrupo_1->setTipoGrupoAtencion($datos_grupo_uno['tipo_grupo']);		
		$TbTerrGrupo_2->setTipoGrupoAtencion($datos_grupo_dos['tipo_grupo']);
 
		 switch ($datos['linea_atencion']) {
			 case 'arte_escuela':
				$TbTerrGrupo_1->setFkColegio($datos_grupo_uno['FK_colegio']);
				$TbTerrGrupo_2->setFkColegio($datos_grupo_dos['FK_colegio']);		
			 break;
			 case 'emprende_clan':
				$TbTerrGrupo_1->setFkModalidad($datos_grupo_uno['FK_modalidad']);
				$TbTerrGrupo_2->setFkModalidad($datos_grupo_dos['FK_modalidad']); //Modalidad área artística emprende
				$TbTerrGrupo_1->setGrupoAbiertoPublico($datos_grupo_uno['abierto_publico']);
				$TbTerrGrupo_2->setGrupoAbiertoPublico($datos_grupo_dos['abierto_publico']);
				$TbTerrGrupo_1->setInCupos($datos_grupo_uno['IN_cupos']);
				$TbTerrGrupo_2->setInCupos($datos_grupo_dos['IN_cupos']);
			 break;
			 case 'laboratorio_clan':
				$TbTerrGrupo_1->setFkInstitucionLaboratorio($datos_grupo_uno['FK_Institucion']);
				$TbTerrGrupo_2->setFkInstitucionLaboratorio($datos_grupo_dos['FK_Institucion']);
				$TbTerrGrupo_1->setFkAliadoLaboratorio($datos_grupo_uno['FK_Aliado']);
				$TbTerrGrupo_2->setFkAliadoLaboratorio($datos_grupo_dos['FK_Aliado']);
				$TbTerrGrupo_1->setTipoPoblacion($datos_grupo_uno['tipo_poblacion']);
				$TbTerrGrupo_2->setTipoPoblacion($datos_grupo_dos['tipo_poblacion']);
				$TbTerrGrupo_1->setInEspacioAlterno($datos_grupo_uno['IN_espacio_alterno']);
				$TbTerrGrupo_2->setInEspacioAlterno($datos_grupo_uno['IN_espacio_alterno']);
			 break;
		}

 		$TbTerrGrupo_1->setFkArtistaFormador($datos_grupo_uno['FK_artista_formador']);
 		$TbTerrGrupo_1->setFkCreador($datos['id_usuario']);

 		$horario_grupo_uno = $GrupoDAO->consultarHorarioGrupo($datos['id_grupo_uno'],$datos['linea_atencion']);
 		$horario_grupo_uno_formato_bien = array();
 		foreach ($horario_grupo_uno as $h) {
 			$array_temp_horario = array('dia' => $h['IN_dia'],'hora_inicio' => $h['TI_hora_inicio_clase'], 'hora_fin' => $h['TI_hora_fin_clase'] );
 			array_push($horario_grupo_uno_formato_bien, $array_temp_horario);
 		}
 		$TbTerrGrupo_1->setHorarioArray($horario_grupo_uno_formato_bien);

 		$estudiantes_grupo_uno = $GrupoDAO->consultarEstudiantesPorEstadoGrupo($datos['id_grupo_uno'],$datos['linea_atencion'],1);
 		$TbTerrGrupo_1->setEstudianteArray($estudiantes_grupo_uno);
 		$estudiantes_grupo_dos = $GrupoDAO->consultarEstudiantesPorEstadoGrupo($datos['id_grupo_dos'],$datos['linea_atencion'],1);
 		$TbTerrGrupo_2->setEstudianteArray($estudiantes_grupo_dos);
 		$id_grupo_nuevo = $GrupoDAO->fusionarGrupos($TbTerrGrupo_1,$TbTerrGrupo_2);
 		$array_return = array('id_grupo' => $id_grupo_nuevo,'id_artista_formador' => $TbTerrGrupo_1->getFkArtistaFormador());
 		echo json_encode($array_return);
 	}

 	public function consultarIdEstudianteByDocumento($datos){
 		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
 		$id_estudiante = $BeneficiarioDAO->consultarIDEstudiantePorDocumento($datos['nro_documento']);
 		if(isset($id_estudiante[0]['id'])){
 			echo $id_estudiante[0]['id'];
 		}else{
 			echo 0;
 		}
 	}

 	public function consultarDatosAdministradorCrea($datos){
 		$CreaDAO = $this->contenedor['CreaDAO'];
 		$id_administrador_crea = $CreaDAO->consultarDatosAdministradorCrea($datos['id_crea']);
 		echo $id_administrador_crea[0]['FK_Persona_Administrador'];
 	}

 	public function consultarOptionsLugarAtencionLaboratorio(){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];;
 		$lugar_atencion = $GrupoDAO->consultarLugaresAtencionLaboratorio();
 		$vista = $this->contenedor['vista'];
 		$vista->setVariables(array('lugar_atencion' => $lugar_atencion));
 		$vista->setPlantilla('getOptionsLugarAtencionGrupoLaboratorio');
 		$vista->renderHtml();
 	}

 	public function consultarTablaGrupos($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$TbTerrGrupo = $this->contenedor['TbTerrGrupo'];
 		$TbTerrGrupo->setTipoGrupo($datos['tipo_grupo']);
 		$TbTerrGrupo->setFkClan($datos['id_crea']);
 		$grupo = $GrupoDAO->consultarGruposActivosCrea($TbTerrGrupo);
 		$total_estudiantes_grupo = array();
 		foreach ($grupo as $g) {
 			$total_estudiantes_grupo_temp = $GrupoDAO->contarEstudiantesActivosGrupo($g['PK_Grupo'],$datos['tipo_grupo']);
 			$total_estudiantes_grupo[$g['PK_Grupo']] = $total_estudiantes_grupo_temp[0]['total'];
 		}
 		$vista = $this->contenedor['vista'];
 		$vista->setVariables(array('tipo_grupo' => $datos['tipo_grupo'],'grupo' => $grupo,'tipo_mostrar' => 'asignar_estudiante','total_estudiantes'=>$total_estudiantes_grupo));
 		$vista->setPlantilla('tableGrupoBase');
 		$vista->renderHtml();
 	}

 	public function consultarOptionsPoblacionLaboratorio(){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$tipo_poblacion = $GrupoDAO->consultarOptionsPoblacionLaboratorio();
 		$vista = $this->contenedor['vista'];
 		$vista->setVariables(array('tipo_poblacion'=>$tipo_poblacion));
 		$vista->renderHtml();
 	}

 	public function consultarOptionsRazonesCierreGrupo(){
 		$option = "<option value='Por deserción de estudiantes'>Por deserción de estudiantes</option>";
 		$option .= "<option value='Por cambio de centro de interés'>Por cambio de centro de interés</option>";
 		$option .= "<option value='Por alta rotación de estudiantes de la institución educativa'>Por alta rotación de estudiantes de la institución educativa</option>";
 		$option .= "<option value='Porque no hay transporte para que los niños lleguen al Clan'>Porque no hay transporte para que los niños lleguen al Clan</option>";
 		$option .= "<option value='Finalización de actividades'>Finalización de actividades</option>";
 		$option .= "<option value='Otras razones'>Otras razones</option>";
 		echo $option;
 	}

 	public function eliminarArchivoEstudiante($idArchivo,$ruta)
 	{

 		$BeneficiarioDAO= $this->contenedor['BeneficiarioDAO'];
 		if($BeneficiarioDAO->eliminarArchivoEstudiante($idArchivo)){
 			$rutaArchivo="../../../uploadedFiles/".$ruta;
 			if(file_exists($rutaArchivo)){
 				if(unlink($rutaArchivo)){
	                //Eliminar registro
 					echo json_encode(array("estado"=>"ok","mensaje"=>"El adjunto fue eliminado con exito"));
 				}
 				else{
 					echo json_encode(array("estado"=>"error","mensaje"=>"No se pudo borrar el archivo en el servidor"));
 				}
 			}
 			else
 				echo json_encode(array("estado"=>"error","mensaje"=>"No se pudo encontrar el archivo en el servidor, es posible que ya no exista"));
 		}else{
 			echo json_encode(array("estado"=>"error","mensaje"=>"No se puedo eliminar el archivo en base de datos, es posible que ya no exista"));
 		}
 	}

 	public function consultarIDColegioPorCodigoDANE($codigo_dane){
 		$ColegioDAO = $this->contenedor['ColegioDAO'];
 		$id_colegio = $ColegioDAO->consultarIDColegioPorCodigoDANE($codigo_dane);
 		if (isset($id_colegio[0]["PK_Id_Colegio"])) {
 			echo ($id_colegio[0]["PK_Id_Colegio"]);
 		}else{
 			echo "0";
 		}
 	}

 	public function consultarIDCreaPorGrupo($datos){
 		$TbTerrGrupo = $this->contenedor['TbTerrGrupo'];
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$TbTerrGrupo->setTipoGrupo($datos['tipo_grupo']);
 		$TbTerrGrupo->setPkGrupo($datos['id_grupo']);
 		$id_crea = $GrupoDAO->consultarObjeto($TbTerrGrupo);
 		$id_crea = $id_crea['FK_clan'];
 		echo $id_crea;
 	}

 	public function consultarIdArtistaFormadorGrupo($datos){
 		$TbTerrGrupo = $this->contenedor['TbTerrGrupo'];
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$TbTerrGrupo->setTipoGrupo($datos['tipo_grupo']);
 		$TbTerrGrupo->setPkGrupo($datos['id_grupo']);
 		$id_artista_formador = $GrupoDAO->consultarObjeto($TbTerrGrupo);
 		$id_artista_formador = $id_artista_formador['FK_artista_formador'];
 		if($datos['retorna']==0)
 			echo $id_artista_formador;
 		else
 			return $id_artista_formador;
 	}

 	public function consultarNovedadGrupoDia($datos){
 		$NovedadSesionClaseDAO = $this->contenedor['NovedadSesionClaseDAO'];
 		$novedad = $NovedadSesionClaseDAO->consultarNovedadGrupoDia($datos);
 		//echo '<pre>'.print_r($novedad,true).'</pre>';
 		$r=0;
 		if(!empty($novedad)){
 			$r=1;
 			//var_dump($novedad);
 		}
 		if($datos['retorna']==0)
 			echo $r;
 		else
 			return $r;
 	}

 	public function cargarHistorialNovedadesGrupo($datos){
 		$NovedadSesionClaseDAO = $this->contenedor['NovedadSesionClaseDAO'];
 		$novedad = $NovedadSesionClaseDAO->cargarHistorialNovedadesGrupo($datos);
 		$vista= $this->contenedor['vista'];
 		$vista->setVariables(array('novedad'=>$novedad,'tipo_mostrar'=>'historial_novedades_grupo','tipo_grupo'=>$datos['tipo_grupo']));
 		$vista->setPlantilla('tableNovedadBase');
 		$vista->renderHtml();
 	}

 	public function crearNovedad($datos){
 		$NovedadSesionClaseDAO = $this->contenedor['NovedadSesionClaseDAO'];
 		$TbTerrGrupoSesionClaseNovedad = $this->contenedor['TbTerrGrupoSesionClaseNovedad'];

 		$TbTerrGrupoSesionClaseNovedad->setTipoGrupo($datos['tipo_grupo']);
 		$TbTerrGrupoSesionClaseNovedad->setFkGrupo($datos['id_grupo']);
 		$TbTerrGrupoSesionClaseNovedad->setDaFechaSesionClase($datos['fecha_novedad']);
 		$TbTerrGrupoSesionClaseNovedad->setInNovedad($datos['id_novedad']);
 		$TbTerrGrupoSesionClaseNovedad->setInAsistencia($datos['estado_asistencia']);
 		$TbTerrGrupoSesionClaseNovedad->setTxObservacion($datos['observacion']);
 		$TbTerrGrupoSesionClaseNovedad->setFkArtistaFormador($datos['id_artista_formador']);
 		$TbTerrGrupoSesionClaseNovedad->setFkUsuarioRegistro($datos['id_usuario']);
 		$insertado = '';
 		if(!empty($datos['id_artista_formador'])){
 			$insertado = $NovedadSesionClaseDAO->crearObjeto($TbTerrGrupoSesionClaseNovedad);
 		}
 		if($datos['retorna']==0)
 			echo $insertado;
 		else return $insertado;

 	}


 	public function registrarNovedadMasiva($datos){
 		//var_dump($datos);
 		$datosGuardar=$datos;
 		$nomenclatura= array('arte_escuela'=>'AE-','emprende_clan'=>'EC-','laboratorio_clan'=>'LC-');
 		$grupos = explode(",", $datos['id_grupo']);
 		$novedadesInsertadas=0;
 		$gruposConNovedad="";
 		foreach ($grupos as $grupo) {
 			$datosGuardar['id_grupo']=$grupo;
 			$datosGuardar['fecha_sesion_clase']=$datosGuardar['fecha_novedad'];
 			$datosGuardar['retorna']=1;

 			if(!$this->consultarNovedadGrupoDia($datosGuardar)){
 				$datosGuardar['id_artista_formador']=$this->consultarIdArtistaFormadorGrupo($datosGuardar);
 				$inserta =$this->crearNovedad($datosGuardar);
 				$novedadesInsertadas=$novedadesInsertadas+ $inserta;
 			}
 			else{
 				if($gruposConNovedad=="")
 					$gruposConNovedad.=$nomenclatura[$datosGuardar['tipo_grupo']].$grupo;
 				else
 					$gruposConNovedad.=', '.$nomenclatura[$datosGuardar['tipo_grupo']].$grupo;
 			}

 		}
 		$totalGruposConNovedad="";
 		if($gruposConNovedad!="")
 			$totalGruposConNovedad.="<br><br> Los siguientes grupos ya tenian novedades tipo <strong>".$datos['novedad']."</strong> para el día indicado: ".$gruposConNovedad;
 		echo "Se registraron las novedades exitosamente".$totalGruposConNovedad;
 	}

 	public function getTableAsistenciasSesionesClase($datos){
 		$tabla="";
 		if($datos['tipo_grupo'] == 'arte_escuela'){
 			$tabla= getTableAsistenciasSesionesClaseArteEscuela($datos['id_grupo'],$datos['mes_anio'],$datos['id_usuario'],$datos['id_organizacion']);
 		}else if($datos['tipo_grupo'] == 'emprende_clan'){
 			$tabla= getTableAsistenciasSesionesClaseEmprendeClan($datos['id_grupo'],$datos['mes_anio'],$datos['id_usuario']);
 		}else if($datos['tipo_grupo'] == 'laboratorio_clan'){
 			$tabla= getTableAsistenciasSesionesClaseLaboratorioClan($datos['id_grupo'],$datos['mes_anio'],$datos['id_usuario']);
 		}
 	}

 	public function consultarAliadosLaboratorioCrea($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$aliado = $GrupoDAO->consultarAliadosLaboratorioCrea($datos['id_institucion']);
 		$vista= $this->contenedor['vista'];
 		$vista->setVariables(array('aliado'=>$aliado));
 		$vista->renderHtml();
 	}

 	public function consultarTipoPoblacionLaboratorio($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$tipo_poblacion = $GrupoDAO->consultarTipoPoblacionLaboratorio($datos['id_categoria_poblacion']);
 		$vista= $this->contenedor['vista'];
 		$vista->setVariables(array('tipo_poblacion'=>$tipo_poblacion));
 		$vista->renderHtml();
 	}

 	public function crearRegistroOcupacionCREA($datos){
 		$OcupacionCreaDAO = $this->contenedor['OcupacionCreaDAO'];
 		echo $OcupacionCreaDAO->crearRegistroOcupacionCREA($datos);
		//var_dump($datos);
 	}

 	public function consultarRegistrosOcupacionCREA($id_crea){
 		$OcupacionCreaDAO = $this->contenedor['OcupacionCreaDAO'];
 		$ocupacion = $OcupacionCreaDAO->consultarRegistrosOcupacionCREA($id_crea);
 		echo json_encode($ocupacion);
 	}

 	public function modificarRegistroOcupacionCREA($datos){
 		$OcupacionCreaDAO = $this->contenedor['OcupacionCreaDAO'];
 		echo $OcupacionCreaDAO->modificarRegistroOcupacionCREA($datos);
		//var_dump($datos);
 	}

 	public function getSalonesCrea($datos){
 		$GestionCreaDAO = $this->contenedor['OcupacionCreaDAO'];
 		$vista = $this->contenedor['vista'];
 		$salones = $GestionCreaDAO->getSalonesCrea($datos);
 		$vista->setVariables(array('salones'=>$salones));
 		$vista->renderHtml();
 	}
 	
 	public function getSalonesOcupacion($datos){
 		$GestionCreaDAO = $this->contenedor['OcupacionCreaDAO'];
 		$vista = $this->contenedor['vista'];
 		$salones = $GestionCreaDAO->getSalonesOcupacion($datos);
 		$vista->setVariables(array('salones'=>$salones));
 		$vista->renderHtml();
 	}

 	public function consultarOcupacionesMesCrea($datos){
 		$GestionCreaDAO = $this->contenedor['OcupacionCreaDAO'];
 		$vista = $this->contenedor['vista'];
 		$ocupaciones = $GestionCreaDAO->getOcupacionesMesCrea($datos['id_crea'],$datos['anio'],$datos['mes']);
 		echo json_encode($ocupaciones);
 	}

 	public function removerBeneficiarioMasivo($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		foreach ($datos['CH_beneficiario'] as $b) {
 			if($b[1] == "true"){
 				$datos_remover = array('id_usuario' => $datos['id_usuario'],'id_grupo' => $datos['id_grupo'],'tipo_grupo' => $datos['tipo_grupo'],'justificacion' => $datos['justificacion'],'id_estudiante' => $b[0]);
 				$GrupoDAO->removerEstudianteGrupo($datos_remover);
 			}
 		}
 	}

 	public function crearGrupoTransicion($datos){
 		$array_horario_dia = [];
 		foreach ($datos as $key => $value) {
 			if (strpos($key, 'SL_hora_inicio_dia_') !== false) {
 				$dia_sesion_clase = explode("SL_hora_inicio_dia_", $key)[1];
 				$array_temp_hora_inicio = array(
 					'dia' => $dia_sesion_clase,
 					'hora_inicio' => $datos[$key]
 				);
 				$array_horario_dia[$dia_sesion_clase] = $array_temp_hora_inicio;
 			}
 		}
 		$horario_json = array();
 		foreach ($array_horario_dia as $key => $value) {
 			$array_horario_dia[$key]['hora_fin'] = $datos['SL_hora_fin_dia_'.$key];
 			array_push($horario_json, $array_horario_dia[$key]);
 		}
		// echo json_encode($horario_json);
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		echo $GrupoDAO->crearGrupoTransicion($datos,$horario_json);
		// var_dump($datos);
 	}

 	public function consultarTablaGruposTransicion(){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$grupo = $GrupoDAO->consultarGruposTransicion();
 		$total_estudiantes_grupo = array();
 		foreach ($grupo as $g) {
 			$total_estudiantes_grupo_temp = $GrupoDAO->contarEstudiantesActivosGrupo($g['id'],'transicion');
 			$total_estudiantes_grupo[$g['id']] = $total_estudiantes_grupo_temp[0]['total'];
 		}
 		$vista = $this->contenedor['vista'];
 		$vista->setVariables(array('grupo'=>$grupo,'tipo_mostrar'=>'transicion','total_estudiantes'=>$total_estudiantes_grupo));
 		$vista->setPlantilla('tableGrupoBase');
 		$vista->renderHtml();
 	}

 	public function consultarEstudianteEnTbBeneficiarioNidos($datos,$datos2){
 		// var_dump($datos);
 		$beneficiario = array();
 		$BeneficiarioDAO= $this->contenedor['BeneficiarioDAO'];
 		if ($datos['in_identificacion'] != null && $datos['in_identificacion'] != '') {
 			$beneficiario = $BeneficiarioDAO->consultarBeneficiarioNidosPorDocumento($datos['in_identificacion']);
 		}else{
 			$nombre_beneficiario = str_replace(' ', '', $datos['vc_primer_apellido']).str_replace(' ', '', $datos['vc_segundo_apellido']).str_replace(' ', '', $datos['vc_primer_nombre']).str_replace(' ', '', $datos['vc_segundo_nombre']);
 			$beneficiario = $BeneficiarioDAO->consultarBeneficiarioNidosPorNombres($datos);
 		}
 		$vista = $this->contenedor['vista'];
 		$vista->setVariables(array('estudiante'=>$beneficiario,'tipo_mostrar'=>'consulta_beneficiario_tb_nidos','id_grupo'=>$datos2['id_grupo']));
 		$vista->setPlantilla('tableEstudiantesBase');
 		$vista->renderHtml();
 		//var_dump($beneficiario);
 	}

 	public function asignarBeneficiarioGrupoTransicion($datos){
 		// var_dump($datos);
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		echo $GrupoDAO->agregarEstudianteGrupo($datos['id_grupo'],$datos['id_beneficario'],date('Y-m-d H:i:s'),$datos['id_usuario'],$datos['observaciones'],'transicion');
 	}

 	public function getOptionsMisGruposTransicion($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$grupo = $GrupoDAO->consultarMisGruposTransicion($datos['id_usuario']);
 		foreach ($grupo as $g) {
 			echo "<option data-horario='".$g['horario_json']."' data-id_crea='".$g['FK_crea']."' value='".$g['id']."'>TR-".$g['id']."</option>";
 		}
 	}

 	public function consultarListadoBeneficiariosGrupoTransicion($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$menores_6_años = $GrupoDAO->consultarBeneficiariosTransicionMenores($datos['id_grupo']);
 		$mayores_6_años = $GrupoDAO->consultarBeneficiariosTransicionMayores($datos['id_grupo']);
 		$beneficiarios = array('mayores' => $mayores_6_años, 'menores' => $menores_6_años);
 		echo json_encode($beneficiarios);
 	}

 	public function crearNuevaZona($datos){
 		$ZonaDAO = $this->contenedor['ZonaDAO'];
 		echo $ZonaDAO->crearNuevaZona($datos);
 	}
 	
 	public function modificarZona($datos,$id_zona){
 		$ZonaDAO = $this->contenedor['ZonaDAO'];
 		echo $ZonaDAO->modificarZona($datos,$id_zona);
 	}

 	public function consultarZonasFormador($datos){
 		$ZonaDAO = $this->contenedor['ZonaDAO'];
 		$zona = $ZonaDAO->consultarZonasFormador($datos);
 		echo json_encode($zona);
 	}

 	public function GuardarZonasUsuario($datos){
 		$ZonaDAO = $this->contenedor['ZonaDAO'];
 		if(empty($ZonaDAO->consultarZonasFormador($datos))){
 			echo $ZonaDAO->GuardarNuevasZonasFormador($datos);
 		}else{
 			echo $ZonaDAO->ActualizarZonasFormador($datos);
 		}
 	}

 	public function getAreasArtisticas($datos){
 		$OptionsDAO = $this->contenedor['OptionsDAO'];
 		$area_artistica = $OptionsDAO->getAreasArtisticas();
 		echo "<div class='row'><div class='col-xs-8 col-xs-offset-3 col-md-5 col-md-offset-4 centered'><h3>Artistas por area artistica</h3></div></div>";
 		foreach ($area_artistica as $a) {
 			echo "<div class='row'>
 			<div class='col-xs-6 col-md-3'>
 			<label for='IN_artistas_area_".(($datos['tipo_formulario']=='modificar')?'modificar_':'').$a['FK_Value']."'>No Artistas ".$a['VC_Descripcion'].":</label>
 			</div>
 			<div class='col-xs-12 col-md-9'>
 			<input class='form-control' required='required' type='number' name='IN_artistas_area_".(($datos['tipo_formulario']=='modificar')?'modificar_':'').$a['FK_Value']."' id='IN_artistas_area_".(($datos['tipo_formulario']=='modificar')?'modificar_':'').$a['FK_Value']."' min='0' max='25' value='1'>
 			</div>
 			</div>";
 		}
 	}
 	
 	public function ConsultarArtistasAreaPorZona($id_zona){
 		$ZonaDAO = $this->contenedor['ZonaDAO'];
 		$datos = $ZonaDAO->ConsultarArtistasAreaPorZona($id_zona);
 		echo json_encode($datos);
 	}

 	public function consultarDisponibilidadArtistas($datos){
 		$ZonaDAO = $this->contenedor['ZonaDAO'];
 		$ZonaDAO->consultarDisponibilidadArtistas($datos);
 		$vista= $this->contenedor['vista'];
 		$vista->setVariables(array('datos'=>$datos));
 		$vista->setPlantilla('tableDisponibilidadArtistas');
 		$vista->renderHtml();
 	}

 	public function crearNuevaCobertura($datos){
 		$json_area_artistica = array();
 		foreach ($datos as $key => $value) {
 			if (strpos($key, 'IN_numero_grupos_') !== false)
 				$json_area_artistica[substr($key, -3, 1)]=array();
 			if (strpos($key, 'IN_numero_beneficiarios_proyectados_area_artistica_') !== false)
 				$json_area_artistica[substr($key, -1)]=array();
 			if (strpos($key, 'TX_observaciones_beneficiarios_proyectados_area_artistica_') !== false)
 				$json_area_artistica[substr($key, -1)]=array();
 		}
 		foreach ($datos as $key => $value) {
 			if (strpos($key, 'IN_numero_grupos_') !== false) {
 				$json_area_artistica[substr($key, -3, 1)]['grupos_lugar_atencion_'.substr($key, -1)]=$value;
 			}
 			if (strpos($key, 'IN_numero_beneficiarios_proyectados_area_artistica_') !== false) {
 				$json_area_artistica[substr($key, -1)]['beneficiarios_proyectados']=$value;
 			}
 			if (strpos($key, 'TX_observaciones_beneficiarios_proyectados_area_artistica_') !== false) {
 				$json_area_artistica[substr($key, -1)]['observaciones']=$value;
 			}
 		}
 		$json_area_artistica=json_encode($json_area_artistica);
 		$TbCobertura = $this->contenedor['TbCobertura'];
 		$TbCobertura->setAnio(date("Y"));
 		$TbCobertura->setLineaAtencion($datos['SL_linea_atencion']);
 		$TbCobertura->setIdZona($datos['SL_zona']);
 		$TbCobertura->setIdColegio($datos['SL_colegio']);
 		$TbCobertura->setIdClan($datos['SL_clan']);
 		$TbCobertura->setIdConvenio($datos['SL_convenio']);
 		$TbCobertura->setJsonAreaArtistica($json_area_artistica);
 		$TbCobertura->setFkUsuarioCreacionEdicion($datos['id_usuario']);
 		$TbCobertura->setEstado(1);
 		$CoberturaDAO = $this->contenedor['CoberturaDAO'];
 		$CoberturaDAO->crearObjeto($TbCobertura);
 	}

 	public function getOptionAnioEstadistica(){
 		$CoberturaDAO = $this->contenedor['CoberturaDAO'];
 		$id_anio = $CoberturaDAO->consultarIdAnioEstadistica();
 		foreach ($id_anio as $a) {
 			echo '<option value="'.$a['id_anio'].'">'.$a['id_anio'].'</option>';
 		}
 	}

 	public function getJsonColegioAnioEstadistica($id_anio){
 		$CoberturaDAO = $this->contenedor['CoberturaDAO'];
 		$json_area_artistica = $CoberturaDAO->getJsonColegioAnioEstadistica($id_anio);
 		echo $json_area_artistica[0]['TX_Grupos_Area'];
 	}

 	public function consultarTablaBolsaArtistasZona($id_anio){
 		$CoberturaDAO = $this->contenedor['CoberturaDAO'];
 		$area_artistica = $CoberturaDAO->consultarAreasArtisticas();
 		$zona = $CoberturaDAO->consultarZonasIdAnioEstadistica($id_anio,1);

 		$json_artistas = $CoberturaDAO->consultarJSONFormadoresAnioEstadistica($id_anio);
		 
 		$json_artistas=($json_artistas[0]['json_formadores']);
 		$json_artistas = json_decode($json_artistas,true);
 		$total_artistas_disponibles=0;
 		$total_grupos_disponibles = array('ae' => 100,'ec' => 110,'lc' => 125,'convenio_1' => 0,'convenio_2' => 0);

 		$html="<table class='table table-bordered' id='table_bolsa_artistas'><thead>";
 		$html.="<tr><th>Área Artistíca</th>";
 		foreach ($zona as $z) {
 			$html.="<th class='bg-success' colspan='6' >".$z['VC_Nombre_Zona']."</th>";
 		}
 		$html.="<th class='bg-success' colspan='6' style='text-align:center;'>TOTALES</th>";
 		$html.="</tr>";
 		$html.="<tr>";
 		$html.="<th class='bg-active' rowspan='2'><span class='label label-default pull-right'>Asignados</span><br><span class='label btn-warning pull-right'>Pactados</span><br><span class='label label-info pull-right'>Proyectados</span></th>";
		//$html.="<th colspan='4' rowspan='2'><span class='label label-default'>Grupos con AF asignado</span></th>";
 		foreach ($zona as $z) {
 			$html.="<th class='bg-success' rowspan='2' style='vertical-align:middle; text-align:center;'>AF</th>";
 			$html.="<th class='bg-success' colspan='5' style='text-align:center'>GRUPOS</th>";
 		}
 		$html.="<th class='bg-success' rowspan='2' style='vertical-align:middle; text-align:center;'>AF</th>";
 		$html.="<th class='bg-success' colspan='5' style='text-align:center'>GRUPOS</th>";
 		$html.="</tr><tr>";
 		foreach ($zona as $z) {
 			$html.="<th>AE</th>";
 			$html.="<th>IC</th>";
 			$html.="<th>CV</th>";
 			$html.="<th>SED</th>";
 			$html.="<th>SDIS</th>";
 		}
 		
 		$html.="<th>AE</th>";
 		$html.="<th>IC</th>";
 		$html.="<th>CV</th>";
		 $html.="<th>SED</th>";
		 $html.="<th>SDIS</th>";
 		$html.="</tr>";
 		$html.="</thead>";

 		$html.="<tbody>";
 		$contador=0;
 		$total_grupos_asignados_zona = array('arte_escuela' => ['7'=>0, '8'=>0, '9'=>0, '10'=>0, '11'=>0], 'emprende_clan' => ['7'=>0, '8'=>0, '9'=>0, '10'=>0, '11'=>0], 'laboratorio_clan' => ['7'=>0, '8'=>0, '9'=>0, '10'=>0, '11'=>0], 'convenio_1' => ['7'=>0, '8'=>0, '9'=>0, '10'=>0, '11'=>0], 'convenio_2' => ['7'=>0, '8'=>0, '9'=>0, '10'=>0, '11'=>0] );
 		$total_grupos_pactados_zona = array('arte_escuela' => ['7'=>0, '8'=>0, '9'=>0, '10'=>0, '11'=>0], 'emprende_clan' => ['7'=>0, '8'=>0, '9'=>0, '10'=>0, '11'=>0], 'laboratorio_clan' => ['7'=>0, '8'=>0, '9'=>0, '10'=>0, '11'=>0], 'convenio_1' => ['7'=>0, '8'=>0, '9'=>0, '10'=>0, '11'=>0], 'convenio_2' => ['7'=>0, '8'=>0, '9'=>0, '10'=>0, '11'=>0] );
 		$artistas_asignados_area = 0;
 		$total_artistas_asignados_zona = array('7'=>0, '8'=>0, '9'=>0, '10'=>0, '11'=>0);
 		$totales_zonas_areas = array('1'=>['af'=>0,'ae'=>0, 'ic'=>0, 'cv'=>0, 'convenio_1'=>0, 'convenio_2'=>0], '2'=>['af'=>0,'ae'=>0, 'ic'=>0, 'cv'=>0, 'convenio_1'=>0, 'convenio_2'=>0], '3'=>['af'=>0,'ae'=>0, 'ic'=>0, 'cv'=>0, 'convenio_1'=>0, 'convenio_2'=>0], '4'=>['af'=>0,'ae'=>0, 'ic'=>0, 'cv'=>0, 'convenio_1'=>0, 'convenio_2'=>0], '5'=>['af'=>0,'ae'=>0, 'ic'=>0, 'cv'=>0, 'convenio_1'=>0, 'convenio_2'=>0], '6'=>['af'=>0,'ae'=>0, 'ic'=>0, 'cv'=>0, 'convenio_1'=>0, 'convenio_2'=>0], '7'=>['af'=>0,'ae'=>0, 'ic'=>0, 'cv'=>0, 'convenio_1'=>0, 'convenio_2'=>0], '8'=>['af'=>0,'ae'=>0, 'ic'=>0, 'cv'=>0, 'convenio_1'=>0, 'convenio_2'=>0]);

 		foreach ($area_artistica as $a) {
 			if($a['PK_Area_Artistica'] != 7){
 				$html.="<tr><th class='bg-success'>".$a['VC_Nom_Area']."</th>";
 				foreach ($zona as $z) {
 					$artistas_asignados_zona[$z['PK_Id_Zona']] = 0;
 					$artistas_asignados_area = 0;
 					$grupos_pactados_zona_area_linea = array('1' => 0,'2' => 0,'3' => 0,'4' => 0,'5' => 0, );;
 					$total_grupos_con_artista=array('arte_escuela' => 0,'emprende_clan' => 0,'laboratorio_clan' => 0,'convenio_1' => 0, 'convenio_2' => 0, );
 					$total_grupos_con_artista['arte_escuela'] += $CoberturaDAO->consultarTotalGruposActivosConArtistaArea($z['VC_Creas'],$a['PK_Area_Artistica'],'arte_escuela',0);
 					$total_grupos_con_artista['emprende_clan'] += $CoberturaDAO->consultarTotalGruposActivosConArtistaArea($z['VC_Creas'],$a['PK_Area_Artistica'],'emprende_clan',0);
 					$total_grupos_con_artista['laboratorio_clan'] += $CoberturaDAO->consultarTotalGruposActivosConArtistaArea($z['VC_Creas'],$a['PK_Area_Artistica'],'laboratorio_clan',0);
 					$total_grupos_con_artista['convenio_1'] += $CoberturaDAO->consultarTotalGruposActivosConArtistaArea($z['VC_Creas'],$a['PK_Area_Artistica'],'convenio_1',1);
 					$total_grupos_con_artista['convenio_2'] += $CoberturaDAO->consultarTotalGruposActivosConArtistaArea($z['VC_Creas'],$a['PK_Area_Artistica'],'convenio_2',2);

 					$artistas_asignados_area = $CoberturaDAO->consultarTotalArtistasAsignadosAreaZona($z['VC_Creas'],$a['PK_Area_Artistica']);

 					$grupos_pactados_zona_area_linea[1] = $CoberturaDAO->consultarGruposCoberturaZonaArea($z['PK_Id_Zona'],$a['PK_Area_Artistica'], 1);
 					$grupos_pactados_zona_area_linea[2] = $CoberturaDAO->consultarGruposCoberturaZonaArea($z['PK_Id_Zona'],$a['PK_Area_Artistica'], 2);
 					$grupos_pactados_zona_area_linea[3] = $CoberturaDAO->consultarGruposCoberturaZonaArea($z['PK_Id_Zona'],$a['PK_Area_Artistica'], 3);
 					$grupos_pactados_zona_area_linea[4] = $CoberturaDAO->consultarGruposCoberturaZonaArea($z['PK_Id_Zona'],$a['PK_Area_Artistica'], 4);
 					$grupos_pactados_zona_area_linea[5] = $CoberturaDAO->consultarGruposCoberturaZonaArea($z['PK_Id_Zona'],$a['PK_Area_Artistica'], 5);
 					$grupos_pactados_zona_area_linea[1] = $grupos_pactados_zona_area_linea[1] != '' ? $grupos_pactados_zona_area_linea[1] : 0;
 					$grupos_pactados_zona_area_linea[2] = $grupos_pactados_zona_area_linea[2] != '' ? $grupos_pactados_zona_area_linea[2] : 0;
 					$grupos_pactados_zona_area_linea[3] = $grupos_pactados_zona_area_linea[3] != '' ? $grupos_pactados_zona_area_linea[3] : 0;
 					$grupos_pactados_zona_area_linea[4] = $grupos_pactados_zona_area_linea[4] != '' ? $grupos_pactados_zona_area_linea[4] : 0;
 					$grupos_pactados_zona_area_linea[5] = $grupos_pactados_zona_area_linea[5] != '' ? $grupos_pactados_zona_area_linea[5] : 0;
 					$total_artistas_asignados_zona[$z['PK_Id_Zona']] += $artistas_asignados_area;

 					$total_grupos_asignados_zona['arte_escuela'][$z['PK_Id_Zona']]+=$total_grupos_con_artista['arte_escuela'];
 					$total_grupos_asignados_zona['emprende_clan'][$z['PK_Id_Zona']]+=$total_grupos_con_artista['emprende_clan'];
 					$total_grupos_asignados_zona['laboratorio_clan'][$z['PK_Id_Zona']]+=$total_grupos_con_artista['laboratorio_clan'];
 					$total_grupos_asignados_zona['convenio_1'][$z['PK_Id_Zona']]+=$total_grupos_con_artista['convenio_1'];
 					$total_grupos_asignados_zona['convenio_2'][$z['PK_Id_Zona']]+=$total_grupos_con_artista['convenio_2'];

 					$total_grupos_pactados_zona['arte_escuela'][$z['PK_Id_Zona']]+=$grupos_pactados_zona_area_linea[1];
 					$total_grupos_pactados_zona['emprende_clan'][$z['PK_Id_Zona']]+=$grupos_pactados_zona_area_linea[2];
 					$total_grupos_pactados_zona['laboratorio_clan'][$z['PK_Id_Zona']]+=$grupos_pactados_zona_area_linea[3];
 					$total_grupos_pactados_zona['convenio_1'][$z['PK_Id_Zona']]+=$grupos_pactados_zona_area_linea[4];
 					$total_grupos_pactados_zona['convenio_2'][$z['PK_Id_Zona']]+=$grupos_pactados_zona_area_linea[5];

 					$totales_zonas_areas[$a['PK_Area_Artistica']]['af'] += $artistas_asignados_area;
 					$totales_zonas_areas[$a['PK_Area_Artistica']]['ae'] += $grupos_pactados_zona_area_linea[1];
 					$totales_zonas_areas[$a['PK_Area_Artistica']]['ic'] += $grupos_pactados_zona_area_linea[2];
 					$totales_zonas_areas[$a['PK_Area_Artistica']]['cv'] += $grupos_pactados_zona_area_linea[3];
 					$totales_zonas_areas[$a['PK_Area_Artistica']]['convenio_1'] += $grupos_pactados_zona_area_linea[4];
 					$totales_zonas_areas[$a['PK_Area_Artistica']]['convenio_2'] += $grupos_pactados_zona_area_linea[5];
 					
 					
					// $html.="<td><label data-id_area_artistica='".$a['PK_Area_Artistica']."' data-id_zona='".$z['PK_Id_Zona']."' class='numero_artistas label label-warning' id='artistas_area_".$a['PK_Area_Artistica']."_zona_".$z['PK_Id_Zona']."'>0</label>
					// <br><span class='label label-default' id='artistas_asignados_zona_".$z['PK_Id_Zona']."_area_".$a['PK_Area_Artistica']."'>".$artistas_asignados_area."</span></td>";

 					$html.="<td><span class='label label-default' id='artistas_asignados_zona_".$z['PK_Id_Zona']."_area_".$a['PK_Area_Artistica']."'>".$artistas_asignados_area."</span></td>";

 					$html.="<td class='bg-danger'>";
 					$html.="<span data-id_area_artistica='".$a['PK_Area_Artistica']."' data-id_zona='".$z['PK_Id_Zona']."' class='numero_grupos_ae label label-warning' id='grupos_arte_escuela_area_".$a['PK_Area_Artistica']."_zona_".$z['PK_Id_Zona']."'>".$grupos_pactados_zona_area_linea[1]."</span>";
 					$html.="<br><span class='label label-default' id='grupos_con_artista_asignado_arte_escuela_".$z['PK_Id_Zona']."_".$a['PK_Area_Artistica']."'>".$total_grupos_con_artista['arte_escuela']."</span>";
 					$html.="</td>";
 					$html.="<td class='bg-warning'>";
 					$html.="<span data-id_area_artistica='".$a['PK_Area_Artistica']."' data-id_zona='".$z['PK_Id_Zona']."' class='numero_grupos_ec label label-warning' id='grupos_emprende_crea_area_".$a['PK_Area_Artistica']."_zona_".$z['PK_Id_Zona']."'>".$grupos_pactados_zona_area_linea[2]."</span>";
 					$html.="<br><span class='label label-default' id='grupos_con_artista_asignado_emprende_clan_".$z['PK_Id_Zona']."_".$a['PK_Area_Artistica']."'>".$total_grupos_con_artista['emprende_clan']."</span>";
 					$html.="</td>";
 					$html.="<td class='bg-info'>";
 					$html.="<span data-id_area_artistica='".$a['PK_Area_Artistica']."' data-id_zona='".$z['PK_Id_Zona']."' class='numero_grupos_lc label label-warning' id='grupos_laboratorio_crea_area_".$a['PK_Area_Artistica']."_zona_".$z['PK_Id_Zona']."'>".$grupos_pactados_zona_area_linea[3]."</span>";
 					$html.="<br><span class='label label-default' id='grupos_con_artista_asignado_laboratorio_clan_".$z['PK_Id_Zona']."_".$a['PK_Area_Artistica']."'>".$total_grupos_con_artista['laboratorio_clan']."</span>";
 					$html.="</td>";
 					$html.="<td class='active'>";
 					$html.="<span data-id_area_artistica='".$a['PK_Area_Artistica']."' data-id_zona='".$z['PK_Id_Zona']."' class='numero_grupos_lc label label-warning' id='grupos_convenio_1_area_".$a['PK_Area_Artistica']."_zona_".$z['PK_Id_Zona']."'>".$grupos_pactados_zona_area_linea[4]."</span>";
 					$html.="<br><span class='label label-default' id='grupos_con_artista_asignado_convenio_1_".$z['PK_Id_Zona']."_".$a['PK_Area_Artistica']."'>".$total_grupos_con_artista['convenio_1']."</span>";
 					$html.="</td>";
 					$html.="<td class='success'>";
 					$html.="<span data-id_area_artistica='".$a['PK_Area_Artistica']."' data-id_zona='".$z['PK_Id_Zona']."' class='numero_grupos_lc label label-warning' id='grupos_convenio_2_area_".$a['PK_Area_Artistica']."_zona_".$z['PK_Id_Zona']."'>".$grupos_pactados_zona_area_linea[5]."</span>";
 					$html.="<br><span class='label label-default' id='grupos_con_artista_asignado_convenio_2_".$z['PK_Id_Zona']."_".$a['PK_Area_Artistica']."'>".$total_grupos_con_artista['convenio_2']."</span>";
 					$html.="</td>";
 				}
 				$html.="<td>";
 				$html.="<span class='label label-default' id='artistas_usados_area_".$a['PK_Area_Artistica']."'>".$totales_zonas_areas[$a['PK_Area_Artistica']]['af']."</span><br>";
 				$html.="<span class='label label-info' id='artistas_disponibles_area_".$a['PK_Area_Artistica']."'>".$json_artistas[$a['PK_Area_Artistica']]."</span>";
 				$html.="</td>";
 				$html.="<td class='bg-danger'>";
 				$html.="<span class='label label-warning' id='grupos_usados_arte_escuela_".$a['PK_Area_Artistica']."'>".$totales_zonas_areas[$a['PK_Area_Artistica']]['ae']."</span><br>";
 				$html.="<span class='label label-info' id='grupos_disponibles_arte_escuela_".$a['PK_Area_Artistica']."'>".$json_artistas[$a['PK_Area_Artistica']]."</span>";
 				$html.="</td>";
 				$html.="<td class='bg-warning'>";
 				$html.="<span class='label label-warning' id='grupos_usados_emprende_clan_".$a['PK_Area_Artistica']."'>".$totales_zonas_areas[$a['PK_Area_Artistica']]['ic']."</span><br>";
 				$html.="<span class='label label-info' id='grupos_disponibles_emprende_clan_".$a['PK_Area_Artistica']."'>".$json_artistas[$a['PK_Area_Artistica']]."</span>";
 				$html.="</td>";
 				$html.="<td class='bg-info'>";
 				$html.="<span class='label label-warning' id='grupos_usados_laboratorio_clan_".$a['PK_Area_Artistica']."'>".$totales_zonas_areas[$a['PK_Area_Artistica']]['cv']."</span><br>";
 				$html.="<span class='label label-info' id='grupos_disponibles_laboratorio_clan_".$a['PK_Area_Artistica']."'>".$json_artistas[$a['PK_Area_Artistica']]."</span>";
 				$html.="</td>";
 				$html.="<td class='active'>";
 				$html.="<span class='label label-warning' id='grupos_usados_convenio_1_".$a['PK_Area_Artistica']."'>".$totales_zonas_areas[$a['PK_Area_Artistica']]['convenio_1']."</span><br>";
 				$html.="<span class='label label-info' id='grupos_disponibles_convenio_1_".$a['PK_Area_Artistica']."'>".$json_artistas[$a['PK_Area_Artistica']]."</span>";
 				$html.="</td>";
 				$html.="<td class='success'>";
 				$html.="<span class='label label-warning' id='grupos_usados_convenio_2_".$a['PK_Area_Artistica']."'>".$totales_zonas_areas[$a['PK_Area_Artistica']]['convenio_2']."</span><br>";
 				$html.="<span class='label label-info' id='grupos_disponibles_convenio_2_".$a['PK_Area_Artistica']."'>".$json_artistas[$a['PK_Area_Artistica']]."</span>";
 				$html.="</td>";
 				$html.="</tr>";
 				$total_artistas_disponibles+=$json_artistas[$a['PK_Area_Artistica']];
 			}
 		}
 		$html.="<tr><td class='bg-danger'><b>TOTALES<b></td>";
 		foreach ($zona as $z) {
 			$html.="<td><span class='label label-default' id='artistas_asignados_zona_".$z['PK_Id_Zona']."'>".$total_artistas_asignados_zona[$z['PK_Id_Zona']]."</span></td>";
 			$html.="<td class='bg-danger'><span class='label label-warning' id='grupos_usados_arte_escuela_zona_".$z['PK_Id_Zona']."'>".$total_grupos_pactados_zona['arte_escuela'][$z['PK_Id_Zona']]."</span>";
 			$html.="<br><span class='label label-default' id='grupos_asignados_arte_escuela_zona_".$z['PK_Id_Zona']."'>".$total_grupos_asignados_zona['arte_escuela'][$z['PK_Id_Zona']]."</span></td>";
 			$html.="<td class='bg-warning'><span class='label label-warning' id='grupos_usados_emprende_clan_zona_".$z['PK_Id_Zona']."'>".$total_grupos_pactados_zona['emprende_clan'][$z['PK_Id_Zona']]."</span>";
 			$html.="<br><span class='label label-default' id='grupos_asignados_emprende_clan_zona_".$z['PK_Id_Zona']."'>".$total_grupos_asignados_zona['emprende_clan'][$z['PK_Id_Zona']]."</span></td>";
 			$html.="<td class='bg-info'><span class='label label-warning' id='grupos_usados_laboratorio_clan_zona_".$z['PK_Id_Zona']."'>".$total_grupos_pactados_zona['laboratorio_clan'][$z['PK_Id_Zona']]."</span>";
 			$html.="<br><span class='label label-default' id='grupos_asignados_laboratorio_clan_zona_".$z['PK_Id_Zona']."'>".$total_grupos_asignados_zona['laboratorio_clan'][$z['PK_Id_Zona']]."</span></td>";
 			$html.="<td class='active'><span class='label label-warning' id='grupos_usados_convenio_1_zona_".$z['PK_Id_Zona']."'>".$total_grupos_pactados_zona['convenio_1'][$z['PK_Id_Zona']]."</span>";
 			$html.="<br><span class='label label-default' id='grupos_asignados_convenio_1_zona_".$z['PK_Id_Zona']."'>".$total_grupos_asignados_zona['convenio_1'][$z['PK_Id_Zona']]."</span></td>";
 			$html.="<td class='success'><span class='label label-warning' id='grupos_usados_convenio_2_zona_".$z['PK_Id_Zona']."'>".$total_grupos_pactados_zona['convenio_2'][$z['PK_Id_Zona']]."</span>";
 			$html.="<br><span class='label label-default' id='grupos_asignados_convenio_2_zona_".$z['PK_Id_Zona']."'>".$total_grupos_asignados_zona['convenio_2'][$z['PK_Id_Zona']]."</span></td>";
 		}
 		$html.="<td class='bg-success' id='total_artistas_disponibles'>".$total_artistas_disponibles."</td>";
 		$html.="<td class='bg-danger' id='total_grupos_arte_escuela_disponibles'>".$total_grupos_disponibles["ae"]."</td>";
 		$html.="<td class='bg-warning' id='total_grupos_emprende_clan_disponibles'>".$total_grupos_disponibles["ec"]."</td>";
 		$html.="<td class='bg-info' id='total_grupos_laboratorio_clan_disponibles'>".$total_grupos_disponibles["lc"]."</td>";
 		$html.="<td class='active' id='total_grupos_convenio_1_disponibles'>".$total_grupos_disponibles["convenio_1"]."</td>";
 		$html.="<td class='success' id='total_grupos_convenio_2_disponibles'>".$total_grupos_disponibles["convenio_2"]."</td>";
 		$html.="</tr>";
 		$html.="</tbody></table>";
 		echo $html;
 	}

 	public function actualizarMatrizAsignacion($matriz,$id_usuario,$id_anio){
 		$CoberturaDAO = $this->contenedor['CoberturaDAO'];
 		$update=$CoberturaDAO->setJsonBolsaArtistasGruposEstadisticaAnio(json_encode($matriz,true),$id_usuario,$id_anio);
 		echo $update;
 	}

 	public function consultarJsonMatrizAsignacion($id_anio){
 		$CoberturaDAO = $this->contenedor['CoberturaDAO'];
 		$json_grupos_artistas=$CoberturaDAO->consultarJsonMatrizAsignacion($id_anio);
 		echo($json_grupos_artistas[0]['JSON_bolsa_artistas_grupos']);
 	}

 	public function consultarCoberturasActivas($datos){
 		$CoberturaDAO = $this->contenedor['CoberturaDAO'];
		//echo $datos["SL_linea_atencion_consulta"].'-'.$datos["SL_zona_consulta"].'-'.$datos["SL_anio_consulta"].'fin';
 		$cobertura=$CoberturaDAO->consultarCoberturasActivas($datos);
 		echo json_encode($cobertura);
 	}

 	public function consultarCoberturasActivasbyid($id){
 		$CoberturaDAO = $this->contenedor['CoberturaDAO'];
		//echo $datos["SL_linea_atencion_consulta"].'-'.$datos["SL_zona_consulta"].'-'.$datos["SL_anio_consulta"].'fin';
 		$cobertura=$CoberturaDAO->consultarCoberturasActivasbyid($id);
 		echo json_encode($cobertura);
 	}
	
	 public function consultarDatosGestor($datos){
		$CreaDAO = $this->contenedor['CreaDAO'];
		$id_gestor_crea = $CreaDAO->consultarDatosGestor($datos['id_crea']);
		echo $id_gestor_crea[0]['FK_persona_responsable'];
	}

	public function consultarNombreCrea($datos){
		$CreaDAO = $this->contenedor['CreaDAO'];
		$crea = $CreaDAO->consultarNombreCrea($datos['id_crea']);
		echo $crea[0]['VC_Nom_Clan'];
	}

 }

 $objControlador = new GestionClanController();
 unset($objControlador);