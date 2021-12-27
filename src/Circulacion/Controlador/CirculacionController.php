<?php

namespace Circulacion\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use Circulacion\Controlador\CirculacionFactory;

class CirculacionController extends CirculacionFactory
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

	public function guardarNuevoEvento($datos,$recursos_insumos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		$tb_circ_evento = $this->contenedor['TbCircEvento'];

		$tb_circ_evento->setFkTipoEvento($datos['id_tipo_evento']);
		$tb_circ_evento->setDtFechaInicio($datos['fecha_inicio_evento']);
		if($datos['fecha_fin_evento'] == ''){
			$tb_circ_evento->setDtFechaFin($datos['fecha_inicio_evento']);
		}else{
			$tb_circ_evento->setDtFechaFin($datos['fecha_fin_evento']);
		}
		$tb_circ_evento->setVcNombre($datos['nombre']);
		$tb_circ_evento->setFkOrganizador($datos['id_organizador']);
		$tb_circ_evento->setVcLugar($datos['lugar']);
		$tb_circ_evento->setVcObjetivo($datos['objetivo']);
		$tb_circ_evento->setInPublicoAsistente($datos['publico_asistente']);
		$tb_circ_evento->setDtFechaCreacion(date('Y-m-d H:i:s'));
		$tb_circ_evento->setArrayAreaArtistica($datos['area_artistica']);
		$tb_circ_evento->setArrayArtistaFormador($datos['artista_formador']);
		$tb_circ_evento->setArrayClan($datos['clan']);
		if(isset($datos['quien_invita'])){
			$tb_circ_evento->setVcQuienInvita($datos['quien_invita']);
		}else{
			$tb_circ_evento->setVcQuienInvita('PROPIO');
		}

		$tb_circ_evento->setVcTransporte($recursos_insumos['transporte']);
		$tb_circ_evento->setVcTecnicaProduccion($recursos_insumos['tecnica_produccion']);
		$tb_circ_evento->setVcVestuario($recursos_insumos['vestuario']);
		$tb_circ_evento->setVcEscenografia($recursos_insumos['escenografia']);
		$tb_circ_evento->setVcMaquillaje($recursos_insumos['maquillaje']);
		$tb_circ_evento->setVcAlimentacion($recursos_insumos['alimentacion']);
		$tb_circ_evento->setVcComunicaciones($recursos_insumos['comunicaciones_instrumentos']);
		$id_evento = $EventoDAO->crearObjeto($tb_circ_evento);
		echo $id_evento;
	}

	public function consultarEventosPorCrea($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		$tb_circ_evento = $this->contenedor['TbCircEvento'];
		$datos_evento = $EventoDAO->consultarEventosPorCrea($datos['id_crea']);
		$array_crea = array();
		foreach ($datos_evento as $e) {
			$array_crea[$e['PK_Id_Evento']] = $EventoDAO->consultarCreasEvento($e['PK_Id_Evento']);
		}
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('evento'=>$datos_evento,'array_crea'=>$array_crea));
		$vista->setPlantilla("tablaEventos");
		$vista->renderHtml();
	}

	public function consultarEventosCreadosPorUsuario($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		if($datos['solamente_activos']){
			$datos_evento = $EventoDAO->consultarEventosActivosCreadosPorUsuario($datos['id_usuario']);
		}else{
			$datos_evento = $EventoDAO->consultarEventosCreadosPorUsuario($datos['id_usuario']);
		}
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('evento'=>$datos_evento));
		$vista->renderHtml();
	}

	public function consultarDatosBasicosEvento($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		echo json_encode($EventoDAO->consultarObjetoPorId($datos['id_evento']));
	}

	public function consultarRecursosInsumosEvento($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		echo json_encode($EventoDAO->consultarRecursosInsumosEventoPorId($datos['id_evento']));
	}

	public function consultarDatosMultiplesEvento($datos){
		$datos_return = [];
		$EventoDAO = $this->contenedor['EventoDAO'];
		$datos_return['crea'] = $EventoDAO->consultarCreasEvento($datos['id_evento']);
		$datos_return['area_artistica'] = $EventoDAO->consultarAreasArtisticasEvento($datos['id_evento']);
		$datos_return['artista_formador'] = $EventoDAO->consultarArtistasFormadoresEvento($datos['id_evento']);
		echo json_encode($datos_return);
	}

	public function modificarEventoDatosBasicos($datos,$d2){
		$EventoDAO = $this->contenedor['EventoDAO'];
		$tb_circ_evento = $this->contenedor['TbCircEvento'];

		$tb_circ_evento->setPkIdEvento($d2['id_evento']);
		$tb_circ_evento->setFkTipoEvento($datos['id_tipo_evento']);
		$tb_circ_evento->setArrayClan($datos['id_crea']);
		$tb_circ_evento->setDtFechaInicio($datos['fecha_inicio_evento']);
		if($datos['id_tipo_evento'] == 14 || $datos['id_tipo_evento'] == 15){
			$tb_circ_evento->setDtFechaFin($datos['fecha_inicio_evento']);
		}else{
			$tb_circ_evento->setDtFechaFin($datos['fecha_fin_evento']);
		}
		$tb_circ_evento->setVcNombre($datos['nombre']);
		$tb_circ_evento->setFkOrganizador($d2['id_organizador']);
		$tb_circ_evento->setVcLugar($datos['lugar']);
		$tb_circ_evento->setVcObjetivo($datos['objetivo']);
		$tb_circ_evento->setInPublicoAsistente($datos['publico_asistente']);
		echo $EventoDAO->modificarEventoDatosBasicos($tb_circ_evento);
	}

	public function modificarEventoDatosMultiples($d1,$d2){
		$EventoDAO = $this->contenedor['EventoDAO'];
		$tb_circ_evento = $this->contenedor['TbCircEvento'];
		$tb_circ_evento->setArrayClan($d1['id_crea']);
		$tb_circ_evento->setArrayAreaArtistica($d1['id_area_artistica']);
		$tb_circ_evento->setArrayArtistaFormador($d1['id_artista_formador']);
		$tb_circ_evento->setPkIdEvento($d2['id_evento']);
		$tb_circ_evento->setFkOrganizador($d2['id_usuario']);
		echo $EventoDAO->modificarEventoDatosMultiples($tb_circ_evento);
	}

	public function modificarEventoRecursosInsumos($d1,$d2){
		$EventoDAO = $this->contenedor['EventoDAO'];
		$tb_circ_evento = $this->contenedor['TbCircEvento'];
		$tb_circ_evento->setVcQuienInvita($d1['quien_invita_modificar']);
		$tb_circ_evento->setVcTransporte($d1['transporte_modificar']);
		$tb_circ_evento->setVcTecnicaProduccion($d1['tecnica_produccion_modificar']);
		$tb_circ_evento->setVcVestuario($d1['vestuario_modificar']);
		$tb_circ_evento->setVcEscenografia($d1['escenografia_modificar']);
		$tb_circ_evento->setVcMaquillaje($d1['maquillaje_modificar']);
		$tb_circ_evento->setVcAlimentacion($d1['alimentacion_modificar']);
		$tb_circ_evento->setVcComunicaciones($d1['comunicaciones_instrumentos_modificar']);
		$tb_circ_evento->setVcQuienInvita($d1['quien_invita_modificar']);
		$tb_circ_evento->setPkIdEvento($d2['id_evento']);
		$tb_circ_evento->setFkOrganizador($d2['id_usuario']);
		echo $EventoDAO->modificarEventoRecursosInsumos($tb_circ_evento);
	}

	public function consultarTiposEvento($id_rol){
		$EventoDAO = $this->contenedor['EventoDAO'];
		$tipo_evento = $EventoDAO->consultarTiposEvento();
		$vista = $this->contenedor['vista'];
		$vista->setPlantilla('getOptionsTipoEvento');
		$vista->setVariables(array('tipo_evento'=>$tipo_evento,'id_rol'=>$id_rol));
		$vista->renderHtml();
	}

	public function cargarEstudiantesDeEventoDistrital($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		$estudiante_evento = $EventoDAO->consultarEstudiantesEvento($datos['id_evento']);
		$vista = $this->contenedor['vista'];
		$vista->setPlantilla('tablaEstudiantesEvento');
		$vista->setVariables(array('estudiante_evento'=>$estudiante_evento,'opcion'=>$datos['opcion']));
		$vista->renderHtml();
	}

	public function consultarEstudiantePorTexto($datos){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$estudiante = $BeneficiarioDAO->consultarObjeto($datos['texto']);
		$vista = $this->contenedor['vista'];
		$vista->setPlantilla('tablaDatosEstudiantes');
		$vista->setVariables(array('estudiante'=>$estudiante,'id_evento'=>$datos['id_evento']));
		$vista->renderHtml();
	}

	public function consultarUltimoGrupoActivoEstudiante($datos){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$dato = $BeneficiarioDAO->consultarUltimoGrupoActivoEstudiante($datos['id_estudiante'],'arte_escuela');
		echo json_encode($dato);
	}

	public function agregarEstudianteEventoDistrital($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		echo $EventoDAO->agregarEstudianteEventoDistrital($datos);
	}

	public function actualizarPermisoPadres($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		echo $EventoDAO->actualizarPermisoPadres($datos);
	}

	public function actualizarEstadoAsistenciaEstudianteEvento($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		echo $EventoDAO->actualizarEstadoAsistenciaEstudianteEvento($datos);
	}

	public function consultarEstudiantesGrupo($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$EventoDAO = $this->contenedor['EventoDAO'];
		$estudiante = $GrupoDAO->consultarEstudiantesPorEstadoGrupo($datos['id_grupo'],$datos['tipo_grupo'],1);
		$estudiante_evento = $EventoDAO->consultarEstudiantesEvento($datos['id_evento']);
		$estudiante_en_evento = array();
		foreach ($estudiante_evento as $e) {
			$estudiante_en_evento[$e['id']]=1;
		}
		$vista = $this->contenedor['vista'];
		$vista->setNamespace('GestionClan');
		$vista->setPlantilla('tableEstudiantesBase');
		$vista->setVariables(array('estudiante'=>$estudiante,'id_evento'=>$datos['id_evento'],'tipo_mostrar'=>'asignar_evento','estudiante_en_evento'=>$estudiante_en_evento));

		$vista->renderHtml();
	}

	public function consultarDatosGrupo($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$TbTerrGrupo = $this->contenedor['TbTerrGrupo'];
		$TbTerrGrupo->setPkGrupo($datos['id_grupo']);
		$TbTerrGrupo->setTipoGrupo($datos['tipo_grupo']);
		$datos_grupo = $GrupoDAO->consultarObjeto($TbTerrGrupo);
		echo json_encode($datos_grupo);
	}

	public function calendarioConsultarEventoMesAnio($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		$evento = $EventoDAO->consultarEventoMesAnio($datos);
		echo json_encode($evento);
	}

	public function calendarioConsultarDetallesEvento($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		$detalle_evento = $EventoDAO->consultarObjetoPorId($datos['id_evento']);
		$recursos_insumos = $EventoDAO->consultarRecursosInsumosEventoPorId($datos['id_evento']);
		$datos_multiples = [];
		$datos_multiples['crea'] = $EventoDAO->consultarCreasEvento($datos['id_evento']);
		$datos_multiples['area_artistica'] = $EventoDAO->consultarAreasArtisticasEvento($datos['id_evento']);
		$datos_multiples['artista_formador'] = $EventoDAO->consultarArtistasFormadoresEvento($datos['id_evento']);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('detalle'=>$detalle_evento,'recursos_insumos'=>$recursos_insumos,'datos_multiples'=>$datos_multiples));
		$vista->renderHtml();
	}

	public function getOptionsEventosDistritalesActivos(){
		$return = "";
		$EventoDAO = $this->contenedor['EventoDAO'];
		$evento = $EventoDAO->consultarEventosDistritalesActivos();
		foreach ($evento as $e) {
			$return .= "<option value='".$e['PK_Id_Evento']."'>".$e['VC_Nombre']."</option>";
		}
		echo $return;
	}

	public function getOptionsGrados(){
		$return = "";
		$EventoDAO = $this->contenedor['EventoDAO'];
		$evento = $EventoDAO->consultarGradosTablaAntigua();
		foreach ($evento as $e) {
			$return .= "<option value='".$e["FK_Value"]."'>".$e['VC_Descripcion']."</option>";
		}
		echo $return;
	}

	public function modificarEstudianteEventoDistrital($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		echo $EventoDAO->modificarEstudianteEventoDistrital($datos);
	}

	public function removerBeneficiarioEventoDistrital($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		echo $EventoDAO->removerBeneficiarioEventoDistrital($datos);
	}

	public function FinalizarEvento($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		echo $EventoDAO->FinalizarEvento($datos);
	}

	public function getOptionsEventosActivosMiCrea($id_usuario){
		$return = "";
		$EventoDAO = $this->contenedor['EventoDAO'];
		$evento = $EventoDAO->consultarsEventosActivosMiCrea($id_usuario);
		foreach ($evento as $e) {
			$return .= "<option value='".$e["PK_Id_Evento"]."'>".$e['VC_Nombre']."</option>";
		}
		echo $return;
	}

	public function cargarTablaArtistasFormadoresEvento($id_evento){
		$EventoDAO = $this->contenedor['EventoDAO'];
		$artista_formador = $EventoDAO->consultarArtistasFormadoresEvento($id_evento);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('artista_formador'=>$artista_formador));
		$vista->renderHtml();
	}

	public function consultarArtistasFormadoresNoAsociadosAEvento($datos){
		$return = "";
		$EventoDAO = $this->contenedor['EventoDAO'];
		$artista_formador = $EventoDAO->consultarArtistasFormadoresNoAsociadosAEvento($datos);
		foreach ($artista_formador as $a) {
			$return .= "<tr>";
			$return .= "<td>".$a["VC_Identificacion"]."</td>";
			$return .= "<td>".$a["Nombre"]."</td>";
			$return .= '<td><button data-id_artista_formador="'.$a["PK_Id_Persona"].'" class="btn btn-success form-control asignar_artista_evento"><span class="glyphicon glyphicon-plus"></span></button></td>';
			$return .= "</tr>";
		}
		echo $return;
	}

	public function AsignarArtistaEvento($datos){
		$EventoDAO = $this->contenedor['EventoDAO'];
		echo $EventoDAO->AsignarArtistaEvento($datos);
	}

	public function obtenerFormulario($datos){
		$vista = $this->contenedor['vista'];
		$vista->setPlantilla('Formulario'.$datos['tipo_formulario']);
		$vista->renderHtml();
	}

	public function consultarReporteAforos($tipo_evento){
		$EventoDAO = $this->contenedor['EventoDAO'];
		$evento = $EventoDAO->consultarReporteAforos($tipo_evento);
		$return = "<table id='table_eventos_".(($tipo_evento=='distrital')?'distritales':'locales')."'>";
		$return .= "<thead><tr>";
		$return .= "<td>Fecha Inicio</td>";
		$return .= "<td>Fecha Fin</td>";
		$return .= "<td>Nombre</td>";
		$return .= "<td>Ubicación</td>";
		$return .= "<td>Publico esperado</td>";
		$return .= "<td>Aforo</td>";
		$return .= "</tr></thead><tbody>";
		foreach($evento as $e){
			$return .= "<tr>";
			$return .= "<td>".$e['DT_Fecha_Inicio']."</td>";
			$return .= "<td>".$e['DT_Fecha_Fin']."</td>";
			$return .= "<td>".$e['VC_Nombre']."</td>";
			$return .= "<td>".$e['VC_Lugar']."</td>";
			$return .= "<td>".$e['IN_publico_asistente']."</td>";
			$return .= "<td>".($e['IN_asistencia_nna']+$e['IN_asistencia_padres']+$e['IN_asistencia_publico'])."</td>";
			$return .= "</tr>";
		}
		$return .= "</tbody></table>";
		echo $return;
	}
}

$objControlador = new CirculacionController();
unset($objControlador);
