<?php

namespace PedagogicoCREA\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use PedagogicoCREA\Controlador\PedagogicoCREAFactory;

class PedagogicoCREAController extends PedagogicoCREAFactory
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

	/* consultarInformacionGrupo() obtiene la información principal del grupo.*/
	public function consultarInformacionGrupo($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$datos_grupo = $PedagogicoDAO->consultarInformacionGrupo($datos['id_grupo'], $datos['tipo_grupo']);
		echo json_encode($datos_grupo);
	}


	/* consultarPromedioAsistentesGrupo() obtiene el promedio de asistentes de un grupo de la linea indicada.*/
	function consultarPromedioAsistentesGrupo($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$promedio = $GrupoDAO->consultarPromedioAsistentesGrupo($datos['id_grupo'], $datos['tipo_grupo']);
		echo json_encode($promedio);
	}

	/* Metodo encargado de consultar la información de una caracterizacion específica de un grupo.*/
	function getCaracterizacion($datos)
	{
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$caracterizaciones = $PedagogicoDAO->consultarInfoCaracterizacion($datos['id_caracterizacion']);
		if (sizeof($caracterizaciones) > 0)
			$caracterizacion = $caracterizaciones[sizeof($caracterizaciones)-1];
		else
			$caracterizacion = null;
		echo json_encode($caracterizacion);
	}

	/* getHorarioGrupoArteEscuela() consulta el horario de un grupo de arte en la escuela.*/
	function consultarHorarioGrupo($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$horario_grupo = $GrupoDAO->consultarHorarioGrupo($datos['id_grupo'], $datos['tipo_grupo']);
		// echo json_encode($horario_grupo);
		$return = "";
		$dia_semana = ["","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo"];
		foreach ($horario_grupo as $h) {
			$return .= $dia_semana[$h['IN_dia']]." (".$h['TI_hora_inicio_clase']." a ".$h['TI_hora_fin_clase'].")";
		}
		echo $return;
	}

	
	/* consultarFechaPrimerClaseGrupo() consulta la fecha de la primer clase de un grupo.*/
	function consultarFechaPrimerClaseGrupo($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$fecha = $GrupoDAO->consultarFechaPrimerClaseGrupoFormador($datos['id_grupo'], $datos['tipo_grupo'], $datos['id_formador']);
		echo json_encode($fecha);
	}

	/* consultarFechaPrimerClaseGrupo() consulta la fecha de la primer clase de un grupo.*/
	function guardarCaracterizacion($datos, $bandera_existencia){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$caracterizacion =  $this->contenedor['caracterizacion'];
		$caracterizacion->setVariables($datos);
		$resultado = $PedagogicoDAO->guardarCaracterizacion($caracterizacion, $bandera_existencia);
		echo $resultado;
	}
	/* consultarFechaPrimerClaseGrupo() consulta la fecha de la primer clase de un grupo.*/
	function guardarPlaneacion($datos,$finalizado,$tipoform){
		$datos = json_decode($datos,true);
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$planeacion =  $this->contenedor['planeacion'];
		$planeacion->setVariables($datos);

		$planeacion->setVcObjetivo($datos["TX_OBJETO"]);
		$planeacion->setVcPregunta($datos["TX_PREGUNTA_ORIENTADORA"]);
		$planeacion->setVcDescripcion($datos["TX_DESCRIPCION"]);
		$planeacion->setVcTemas($datos["TX_TEMAS_PROPUESTOS"]);
		$acciones = array (
			"acciones_mes_1"=>$datos['TXT_acciones_mes_1'],"acciones_mes_2"=>$datos['TXT_acciones_mes_2'],"acciones_mes_3"=>$datos['TXT_acciones_mes_3'],"acciones_mes_4"=>$datos['TXT_acciones_mes_4'],"acciones_mes_5"=>$datos['TXT_acciones_mes_5'],"acciones_mes_6"=>$datos['TXT_acciones_mes_6'],"acciones_mes_7"=>$datos['TXT_acciones_mes_7'],"acciones_mes_8"=>$datos['TXT_acciones_mes_8'],"acciones_mes_9"=>$datos['TXT_acciones_mes_9'],"acciones_mes_10"=>$datos['TXT_acciones_mes_10'],"acciones_mes_11"=>$datos['TXT_acciones_mes_11'],"semana_1"=>$datos['TXT_semana_1'],"semana_2"=>$datos['TXT_semana_2'],"semana_3"=>$datos['TXT_semana_3'],"semana_4"=>$datos['TXT_semana_4'],"semana_5"=>$datos['TXT_semana_5'],"semana_6"=>$datos['TXT_semana_6'],"semana_7"=>$datos['TXT_semana_7'],"semana_8"=>$datos['TXT_semana_8'],"semana_9"=>$datos['TXT_semana_9'],"semana_10"=>$datos['TXT_semana_10'],"semana_11"=>$datos['TXT_semana_11'],"semana_12"=>$datos['TXT_semana_12'],"semana_13"=>$datos['TXT_semana_13'],"semana_14"=>$datos['TXT_semana_14'],"semana_15"=>$datos['TXT_semana_15'],"semana_16"=>$datos['TXT_semana_16'],"semana_17"=>$datos['TXT_semana_17'],"semana_18"=>$datos['TXT_semana_18'],"semana_19"=>$datos['TXT_semana_19'],"semana_20"=>$datos['TXT_semana_20'],"semana_21"=>$datos['TXT_semana_21'],"semana_22"=>$datos['TXT_semana_22'],"semana_23"=>$datos['TXT_semana_23'],"semana_24"=>$datos['TXT_semana_24'],"semana_25"=>$datos['TXT_semana_25'],"semana_26"=>$datos['TXT_semana_26'],"semana_27"=>$datos['TXT_semana_27'],"semana_28"=>$datos['TXT_semana_28'],"semana_29"=>$datos['TXT_semana_29'],"semana_30"=>$datos['TXT_semana_30'],"semana_31"=>$datos['TXT_semana_31'],"semana_32"=>$datos['TXT_semana_32'],"semana_33"=>$datos['TXT_semana_33'],"semana_34"=>$datos['TXT_semana_34'],"semana_35"=>$datos['TXT_semana_35'],"semana_36"=>$datos['TXT_semana_36'],"semana_37"=>$datos['TXT_semana_37'],"semana_38"=>$datos['TXT_semana_38'],"semana_39"=>$datos['TXT_semana_39'],"semana_40"=>$datos['TXT_semana_40'],"semana_41"=>$datos['TXT_semana_41'],"semana_42"=>$datos['TXT_semana_42'],"semana_43"=>$datos['TXT_semana_43'],"semana_44"=>$datos['TXT_semana_44']);
		$accionesJson = json_encode($acciones);
		$planeacion->setVcAcciones($accionesJson);
		$planeacion->setVcPropuestaCirculacion($datos["TXT_Circulacion"]);
		$planeacion->setVcArticulacion($datos["TXT_Articulacion"]);

		$planeacion->setFkGrupo($datos["codigoGrupo"]);
		$planeacion->setFkIdLineaAtencion($datos["tipo_grupo"]);
		$planeacion->setFkCiclo($datos["ciclos"]);
		$planeacion->setFkIdUsuarioRegistro($datos["usuario_id"]);
		$planeacion->setVcMetodologia($datos["metodologias"]);
		$planeacion->setVcReferentes($datos["referentes"]);
		$planeacion->setVcRecursos($datos["recursosSelec"].$datos['TX_OTROS_RECURSOS']);
		$planeacion->setInFinalizado($finalizado);
		$planeacion->setInEstado($datos['in_estado']);
		$resultado = $PedagogicoDAO->guardarPlaneacion($planeacion,$datos["planeacion_id"]);
		echo $resultado;
	}
	/* consultarFechaPrimerClaseGrupo() consulta la fecha de la primer clase de un grupo.*/
	function guardarProyecto($datos,$finalizado,$tipoform){
		$datos = json_decode($datos,true);
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$grupoPropuestaProyecto =  $this->contenedor['grupoPropuestaProyecto'];

		$grupoPropuestaProyecto->setVcNombreProyecto($datos["TX_NOMBRE_PROYECTO"]);
		$grupoPropuestaProyecto->setVcManos($datos["TX_MANOS"]);
		$grupoPropuestaProyecto->setVcTipoPoblacion($datos["TX_TIPO_POBLACION"]);
		$grupoPropuestaProyecto->setVcEntidadAliada($datos["TX_ENTIDAD_ALIADA"]);
		$grupoPropuestaProyecto->setVcProposito($datos["TX_PROPOSITO"]);
		$grupoPropuestaProyecto->setVcTipoProyecto($datos["TX_TIPO_PROYECTO"]);
		$grupoPropuestaProyecto->setVcJustificacion($datos["TX_JUSTIFICACION"]);
		$grupoPropuestaProyecto->setVcDescripcion($datos["TX_DESCRIPCION"]);
		$grupoPropuestaProyecto->setVcObjetivoGeneral($datos["TX_OBJETIVO_GENERAL"]);
		$grupoPropuestaProyecto->setVcObjetivosEspecificos($datos["TX_OBJETIVOS_ESPECIFICOS"]);
		$grupoPropuestaProyecto->setVcReferentes($datos["TX_REFERENTES"]);
		$grupoPropuestaProyecto->setVcResultados($datos["TX_RESULTADOS"]);
		$grupoPropuestaProyecto->setVcMetodologia($datos["TX_METODOLOGIA"]);
		$grupoPropuestaProyecto->setVcCriterios($datos["TX_CRITERIOS"]);
		$grupoPropuestaProyecto->setVcOtrosRecursos($datos["TX_OTROS_RECURSOS"]);
		$grupoPropuestaProyecto->setVcPlaneador($datos["TX_PLANEADOR"]);
		$acciones = array (
			"acciones_mes_1"=>$datos['TXT_acciones_mes_1'],"acciones_mes_2"=>$datos['TXT_acciones_mes_2'],"acciones_mes_3"=>$datos['TXT_acciones_mes_3'],"acciones_mes_4"=>$datos['TXT_acciones_mes_4'],"acciones_mes_5"=>$datos['TXT_acciones_mes_5'],"acciones_mes_6"=>$datos['TXT_acciones_mes_6'],"acciones_mes_7"=>$datos['TXT_acciones_mes_7'],"acciones_mes_8"=>$datos['TXT_acciones_mes_8'],"acciones_mes_9"=>$datos['TXT_acciones_mes_9'],"acciones_mes_10"=>$datos['TXT_acciones_mes_10'],"acciones_mes_11"=>$datos['TXT_acciones_mes_11'],"semana_1"=>$datos['TXT_semana_1'],"semana_2"=>$datos['TXT_semana_2'],"semana_3"=>$datos['TXT_semana_3'],"semana_4"=>$datos['TXT_semana_4'],"semana_5"=>$datos['TXT_semana_5'],"semana_6"=>$datos['TXT_semana_6'],"semana_7"=>$datos['TXT_semana_7'],"semana_8"=>$datos['TXT_semana_8'],"semana_9"=>$datos['TXT_semana_9'],"semana_10"=>$datos['TXT_semana_10'],"semana_11"=>$datos['TXT_semana_11'],"semana_12"=>$datos['TXT_semana_12'],"semana_13"=>$datos['TXT_semana_13'],"semana_14"=>$datos['TXT_semana_14'],"semana_15"=>$datos['TXT_semana_15'],"semana_16"=>$datos['TXT_semana_16'],"semana_17"=>$datos['TXT_semana_17'],"semana_18"=>$datos['TXT_semana_18'],"semana_19"=>$datos['TXT_semana_19'],"semana_20"=>$datos['TXT_semana_20'],"semana_21"=>$datos['TXT_semana_21'],"semana_22"=>$datos['TXT_semana_22'],"semana_23"=>$datos['TXT_semana_23'],"semana_24"=>$datos['TXT_semana_24'],"semana_25"=>$datos['TXT_semana_25'],"semana_26"=>$datos['TXT_semana_26'],"semana_27"=>$datos['TXT_semana_27'],"semana_28"=>$datos['TXT_semana_28'],"semana_29"=>$datos['TXT_semana_29'],"semana_30"=>$datos['TXT_semana_30'],"semana_31"=>$datos['TXT_semana_31'],"semana_32"=>$datos['TXT_semana_32'],"semana_33"=>$datos['TXT_semana_33'],"semana_34"=>$datos['TXT_semana_34'],"semana_35"=>$datos['TXT_semana_35'],"semana_36"=>$datos['TXT_semana_36'],"semana_37"=>$datos['TXT_semana_37'],"semana_38"=>$datos['TXT_semana_38'],"semana_39"=>$datos['TXT_semana_39'],"semana_40"=>$datos['TXT_semana_40'],"semana_41"=>$datos['TXT_semana_41'],"semana_42"=>$datos['TXT_semana_42'],"semana_43"=>$datos['TXT_semana_43'],"semana_44"=>$datos['TXT_semana_44']);
		$accionesJson = json_encode($acciones);
		$grupoPropuestaProyecto->setVcAcciones($accionesJson);
		$grupoPropuestaProyecto->setFkGrupo($datos["codigoGrupo"]);
		$grupoPropuestaProyecto->setFkIdLineaAtencion($datos["tipo_grupo"]);
		$grupoPropuestaProyecto->setFkIdUsuarioRegistro($datos["usuario_id"]);
		$grupoPropuestaProyecto->setVcRecursos($datos["recursosSelec"].$datos['TX_OTROS_RECURSOS']);
		$grupoPropuestaProyecto->setInFinalizado($finalizado);
		$resultado = $PedagogicoDAO->guardarGrupoPropuestaProyecto($grupoPropuestaProyecto,$datos["planeacion_id"]);
		echo $resultado;
	}

	/* getListadoCaracterizaciones() consulta el listado de caracterizaciones realizadas por el formador especificado.*/
	function getListadoCaracterizaciones($formador){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$caracterizaciones = $PedagogicoDAO->consultarCaracterizacionesFormador($formador);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('caracterizaciones'=>$caracterizaciones, 'userID'=>$formador));
		$vista->renderHtml();
	}
	/* getListadoPlaneaciones() consulta el listado de caracterizaciones realizadas por el formador especificado.*/
	function getListadoPlaneaciones($formador){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$planeaciones = $PedagogicoDAO->consultarPlaneacionesFormador($formador);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('planeaciones'=>$planeaciones, 'usuarioId'=>$formador));
		$vista->renderHtml();
	}

	/* getPlaneacion() consulta el listado de caracterizaciones realizadas por el formador especificado.*/
	function getPlaneacion($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$planeaciones = $PedagogicoDAO->consultarPlaneacionId($datos['id_planeacion']);
		if (sizeof($planeaciones) > 0){
			$planeacion = $planeaciones[sizeof($planeaciones)-1];
			$planeacionData = $this->convertionFormName($planeacion);
		}
		else
			$planeacionData = null;
		echo json_encode($planeacionData);
	}

	/* getGrupoPropuestaProyecto() consulta el listado de caracterizaciones realizadas por el formador especificado.*/
	function getGrupoPropuestaProyecto($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$propuestas = $PedagogicoDAO->consultarGrupoPropuestaProyectoId($datos['id_planeacion']);
		if (sizeof($propuestas) > 0){
			$propuesta = $propuestas[sizeof($propuestas)-1];
			if ($propuesta["VC_Acciones"] != "" && $propuesta["VC_Acciones"] != null) {
				$tx_acciones = json_decode($propuesta["VC_Acciones"]);
				foreach ($tx_acciones as $key => $value) {
					if (strpos($key, 'semana') !== false || strpos($key, 'mes') !== false) {
						$form["TXT_".$key]=$value;
					}
				}
			}
			foreach ($propuesta as $key => $value) {
				$form[strtoupper(str_replace("VC_","TX_",$key))] = $value;
			}
			$form["recursos"] = $propuesta["VC_Recursos"];
			$form["TX_Observacion"] = $propuesta["VC_Observacion"];
			$form["FK_Id_Usuario_Registro"] = $propuesta["FK_Id_Usuario_Registro"];
		}
		else
			$form = null;
		echo json_encode($form);
	}
	/* getPlaneacionBasic() retorna una planeacion sin convertir los nombres a campos de texto*/
	function getPlaneacionDetalle($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$planeaciones = $PedagogicoDAO->consultarPlaneacionId($datos['id_planeacion']);
		if (sizeof($planeaciones) > 0){
			$planeacion = $planeaciones[sizeof($planeaciones)-1];
			$persona = $this->contenedor['persona'];
			$persona->setPkIdPersona($planeacion['FK_Id_Usuario_Registro']);
			$personaDAO = $this->contenedor['personaDAO'];
			$datosPersona = $personaDAO->consultarObjeto($persona);
			$planeacion["nombre_usuario"] = $datosPersona[0]["nombre"];
			echo json_encode($planeacion);
		}
		else
			echo json_encode(null);
	}
	/* getGrupoPropuestaProyectoDetalle() retorna una planeacion sin convertir los nombres a campos de texto*/
	function getGrupoPropuestaProyectoDetalle($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$propuestas = $PedagogicoDAO->consultarGrupoPropuestaProyectoId($datos['id_planeacion']);
		if (sizeof($propuestas) > 0){
			$propuesta = $propuestas[sizeof($propuestas)-1];
			$persona = $this->contenedor['persona'];
			$persona->setPkIdPersona($propuesta['FK_Id_Usuario_Registro']);
			$personaDAO = $this->contenedor['personaDAO'];
			$datosPersona = $personaDAO->consultarObjeto($persona);
			$propuesta["nombre_usuario"] = $datosPersona[0]["nombre"];
			echo json_encode($propuesta);
		}
		else
			echo json_encode(null);


	}
	public function convertionFormName($planeacion)
	{
		$form["TX_Observacion"] = $planeacion["VC_Observacion"];
		$form["SL_CICLO"] = $planeacion["FK_Ciclo"];
		$form["TX_OBJETO"] = $planeacion["VC_Objetivo"];
		$form["TX_PREGUNTA_ORIENTADORA"] = $planeacion["VC_Pregunta"];
		$form["TX_DESCRIPCION"] = $planeacion["VC_Descripcion"];
		$form["metodologia"] = $planeacion["VC_Metodologia"];
		$form["TX_TEMAS_PROPUESTOS"] = $planeacion["VC_Temas"];
		$form["recursos"] = $planeacion["VC_Recursos"];
		$form["referentes"] = $planeacion["VC_Referentes"];
		$form["TXT_Circulacion"] = $planeacion["VC_Propuesta_Circulacion"];
		if ($planeacion["VC_Acciones"] != "" && $planeacion["VC_Acciones"] != null) {
			$tx_acciones = json_decode($planeacion["VC_Acciones"]);
			foreach ($tx_acciones as $key => $value) {
				if (strpos($key, 'semana') !== false || strpos($key, 'mes') !== false) {
					$form["TXT_".$key]=$value;
				}
			}
		}
		$form["TXT_Articulacion"] = $planeacion["VC_Articulacion"];
		$form["FK_Id_Usuario_Registro"] = $planeacion["FK_Id_Usuario_Registro"];
		return $form;
	}
	
	/* getRecursos() devuelve el listado de recursos fungibles y tecnologicos del sistema.*/
	function getRecursos(){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$recursos = $PedagogicoDAO->getRecursos();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$recursos));
		$vista->setPlantilla("getGeneralOptions");
		$vista->renderHtml("General");
	}

	/* getRecursosText() devuelve el listado de recursos fungibles y tecnologicos del sistema.*/
	function getRecursosText($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$recursos = $PedagogicoDAO->getRecursosText(str_replace(";", ",", $datos["recursos"]));
		echo json_encode($recursos);

	}

	function validarExistenciaCaracterizacion($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$existencia = $PedagogicoDAO->validarExistenciaCaracterizacion($datos['fk_grupo'], $datos['fk_id_linea_atencion'], $datos['fk_id_usuario_registro']);
		echo $existencia;
	}

	/* getListadoFormatosPedagogicos() consulta el listado del formato pedagógico especificado (Caracterizaciónes, Planeaciónes, Valoraciones), */
	function getListadoFormatosPedagogicos($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$formatos_pedagogicos = $PedagogicoDAO->consultarFormatosPegagogicos($datos['anio'], $datos['linea_atencion'], $datos['formato']);
		//var_dump($formatos_pedagogicos);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('formatos_pedagogicos'=>$formatos_pedagogicos));
		$vista->renderHtml();
	}

	public function guardarRevisionFormatoPedagogico($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$resultado = $PedagogicoDAO->guardarRevisionFormatoPedagogico($datos['pk_tabla'], $datos['tx_observacion'], $datos['formato'], $datos['aprobacion'], $datos['usuario'], $datos['linea_atencion']);
		echo $resultado;
	}
	
	/* consultarEstadoRegistroAsistencias() consulta el listado formadores que deben registrar asistencia el dia especificado. */
	public function consultarEstadoRegistroAsistencias($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$grupos = $PedagogicoDAO->consultarEstadoRegistroAsistencias($datos['FK_organizacion'], $datos['fecha'], $datos['linea_atencion'], $datos['crea']);
		//var_dump($grupos);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();
	}

	/* consultarUltimaCaracterizacionAprobada() consulta la ultima caracterizacion aprobada del grupo indicado. */
	public function consultarUltimaCaracterizacionAprobada($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$resultado = $PedagogicoDAO->consultarUltimaCaracterizacionAprobada($datos['fk_grupo'], $datos['fk_id_linea_atencion'], $datos['fk_id_usuario_registro']);
		if (sizeof($resultado) > 0)
			$caracterizacion = $resultado[sizeof($resultado)-1];
		else
			$caracterizacion = null;
		echo json_encode($caracterizacion);
	}

	/* consultarUltimaPlaneacionAprobada() consulta la ultima planeación aprobada del grupo indicado. */
	public function consultarUltimaPlaneacionAprobada($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$resultado = $PedagogicoDAO->consultarUltimaPlaneacionAprobada($datos['fk_grupo'], $datos['fk_id_linea_atencion'], $datos['fk_id_usuario_registro']);
		if (sizeof($resultado) > 0){
			$planeacion = $resultado[sizeof($resultado)-1];
			$planeacionData = $this->convertionFormName($planeacion);
		}
		else
			$planeacionData = null;
		echo json_encode($planeacionData);
	}

	/* consultarUltimaPropuestaProyectoAprobada() consulta la ultima propuesta_proyecto aprobada del grupo indicado. */
	public function consultarUltimaPropuestaProyectoAprobada($datos){
		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
		$resultado = $PedagogicoDAO->consultarUltimaPropuestaProyectoAprobada($datos['fk_grupo'], $datos['fk_id_linea_atencion'], $datos['fk_id_usuario_registro']);
		if (sizeof($resultado) > 0){
			$propuesta = $resultado[sizeof($resultado)-1];
			if ($propuesta["VC_Acciones"] != "" && $propuesta["VC_Acciones"] != null) {
				$tx_acciones = json_decode($propuesta["VC_Acciones"]);
				foreach ($tx_acciones as $key => $value) {
					if (strpos($key, 'semana') !== false || strpos($key, 'mes') !== false) {
						$form["TXT_".$key]=$value;
					}
				}
			}
			foreach ($propuesta as $key => $value) {
				$form[strtoupper(str_replace("VC_","TX_",$key))] = $value;
			}
			$form["recursos"] = $propuesta["VC_Recursos"];
			$form["TX_Observacion"] = $propuesta["VC_Observacion"];
			$form["FK_Id_Usuario_Registro"] = $propuesta["FK_Id_Usuario_Registro"];
		}
		else
			$form = null;
		echo json_encode($form);
	}
}

$objControlador = new PedagogicoCREAController();
unset($objControlador);
