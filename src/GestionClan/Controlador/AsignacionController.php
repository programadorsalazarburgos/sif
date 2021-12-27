<?php

namespace GestionClan\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use GestionClan\Controlador\GestionClanFactory;

class AsignacionController extends GestionClanFactory
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

 	public function consultarIDUltimaOrganizacionUsuario($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
		 // echo $GrupoDAO->consultarIDUltimaOrganizacionUsuario($datos['id_usuario'])[0]['FK_Organizacion'];
		 echo 2;
 	}

 	public function consultarZonas(){
 		$AsignacionDAO = $this->contenedor['AsignacionDAO'];
		$zona = $AsignacionDAO->consultarZonas();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('zona'=>$zona));
		$vista->renderHtml();
 	}

 	public function getOptionArtistaPorOrganizacion($datos){
 		$AsignacionDAO = $this->contenedor['AsignacionDAO'];
		$artista_formador = $AsignacionDAO->getOptionArtistaPorOrganizacion($datos['id_organizacion']);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('artista_formador'=>$artista_formador));
		$vista->renderHtml();
 	}

 	public function consultarArtistasFormadoresDeZona($datos){
 		$AsignacionDAO = $this->contenedor['AsignacionDAO'];
		$artista_formador = $AsignacionDAO->consultarArtistasFormadoresDeZona($datos['id_zona']);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('artista_formador'=>$artista_formador));
		$vista->renderHtml();
 	}

 	public function consultarGruposActivosDeOrganizacion($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$grupo = $GrupoDAO->consultarGruposActivosOrganizacion($datos['id_organizacion'],$datos['tipo_grupo']);
 		$horario = array();
 		foreach ($grupo as $g) {
 			$horario[$g['PK_Grupo']] = $GrupoDAO->consultarHorarioGrupo($g['PK_Grupo'],$datos['tipo_grupo']);
 		}
 		$vista= $this->contenedor['vista'];
 		$vista->setVariables(array('grupo'=>$grupo, 'id_organizacion'=>$datos['id_organizacion'], 'tipo_grupo'=>$datos['tipo_grupo'], 'horario'=>$horario));
		$vista->renderHtml();
	 }
	 
	 public function consultarGruposFiltroSelect($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$ZonaDAO = $this->contenedor['ZonaDAO'];
		$grupo = $GrupoDAO->consultarGruposFiltroSelect($datos);
		$zona = $ZonaDAO->consultarObjeto(null);
		$clan_zona_array = [];
		foreach ($zona as $z){
			$id_clan = explode(",", $z['VC_Creas']);
			foreach($id_clan as $ic){
				$clan_zona_array[$ic] = $z['VC_Nombre_Zona'];
			}
		}
		$horario = array();
		foreach ($grupo as $g) {
			$horario[$g['PK_Grupo']] = $GrupoDAO->consultarHorarioGrupo($g['PK_Grupo'],$datos['tipo_grupo']);
		}
		$vista= $this->contenedor['vista'];
		$vista->setPlantilla("consultarGruposActivosDeOrganizacion");
		$vista->setVariables(array('grupo'=>$grupo, 'id_organizacion'=>$datos['id_organizacion'], 'tipo_grupo'=>$datos['tipo_grupo'], 'horario'=>$horario, 'clan_zona_array'=>$clan_zona_array));
	   $vista->renderHtml();
	}

 	public function asignarArtistaFormadorAGrupo($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$AsignacionDAO = $this->contenedor['AsignacionDAO'];
 		$tipo_grupo = $AsignacionDAO->consultarTipoArtistaFormador($datos);
 		if (isset($tipo_grupo[0]['VC_Descripcion'])) {
 			$datos['tipo_grupo_artista'] = $tipo_grupo[0]['VC_Descripcion'];
 		}else{
 			$datos['tipo_grupo_artista'] = 'ORGANIZACIÓN';
 		}
 		echo $GrupoDAO->asignarArtistaFormadorAGrupo($datos);
 	}

 	public function asignarEstudianteGrupo($datos,$tipo_grupo){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		if(!$GrupoDAO->consultarEstudianteYaExisteEnGrupo($datos,$tipo_grupo)){
 			// echo $GrupoDAO->agregarEstudianteGrupo($datos['id_grupo'],$datos['id_estudiante'],date('Y-m-d H:i:s'),$datos['id_usuario'],$datos['observacion'],$tipo_grupo,$datos['bioseguridad']);
			 echo $GrupoDAO->agregarEstudianteGrupo($datos['id_grupo'],$datos['id_estudiante'],date('Y-m-d H:i:s'),$datos['id_usuario'],$datos['observacion'],$tipo_grupo);
 		}else{
 			// echo $GrupoDAO->reactivarEstudianteGrupo($datos['id_grupo'],$datos['id_estudiante'],date('Y-m-d H:i:s'),$datos['id_usuario'],("Estudiante reintegrado al grupo, ".$datos['observacion']),$tipo_grupo,$datos['bioseguridad']);
			echo $GrupoDAO->reactivarEstudianteGrupo($datos['id_grupo'],$datos['id_estudiante'],date('Y-m-d H:i:s'),$datos['id_usuario'],("Estudiante reintegrado al grupo, ".$datos['observacion']),$tipo_grupo);
 		}
 	}

 	public function crearEstudiante($datos){
 		$fecha_hora_actual = date('Y-m-d H:i:s');
 		$anio_actual = date('Y');
 		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
 		$TbEstudiante = $this->contenedor['TbEstudiante'];
 		$TbEstudiante->setInIdentificacion($datos['nro_documento']);
 		$TbEstudiante->setChTipoIdentificacion($datos['tipo_documento']);
 		$TbEstudiante->setVcPrimerNombre(trim($datos['primer_nombre']));
 		$TbEstudiante->setVcSegundoNombre(trim($datos['segundo_nombre']));
 		$TbEstudiante->setVcPrimerApellido(trim($datos['primer_apellido']));
 		$TbEstudiante->setVcSegundoApellido(trim($datos['segundo_apellido']));
 		$TbEstudiante->setDdFNacimiento($datos['fecha_nacimiento']);
 		$TbEstudiante->setChGenero($datos['genero']);
 		$TbEstudiante->setVcDireccion($datos['direccion_residencia']);
 		$TbEstudiante->setVcCorreo($datos['correo']);
 		$TbEstudiante->setVcTelefono($datos['telefono']);
 		$TbEstudiante->setVcCelular($datos['celular']);
 		$TbEstudiante->setFkRh(isset($datos['rh'])? $datos['rh']:'9');
 		$TbEstudiante->setDaFechaRegistro($fecha_hora_actual);
 		$TbEstudiante->setIdUsuarioRegistro($datos['id_usuario']);
 		$TbEstudiante->setVcTipoEstudiante($datos['fuente']);

 		$TbEstudianteDetalleAnio = $this->contenedor['TbEstudianteDetalleAnio'];
 		$TbEstudianteDetalleAnio->setAnio($anio_actual);
 		$TbEstudianteDetalleAnio->setFkClan($datos['id_crea']);
 		$TbEstudianteDetalleAnio->setFkColegio($datos['id_colegio']);
 		$TbEstudianteDetalleAnio->setFkGrado($datos['id_grado']);
 		$TbEstudianteDetalleAnio->setFkJornada($datos['id_jornada']);
 		$TbEstudianteDetalleAnio->setNombreAcudiente($datos['nombre_acudiente']);
 		$TbEstudianteDetalleAnio->setIdentificacionAcudiente($datos['identificacion_acudiente']);
 		$TbEstudianteDetalleAnio->setTelefonoAcudiente($datos['telefono_acudiente']);
 		$TbEstudianteDetalleAnio->setFkGrupoPoblacional($datos['id_grupo_poblacional']);
 		$TbEstudianteDetalleAnio->setFkEps($datos['id_eps']);
 		$TbEstudianteDetalleAnio->setTxTipoAfiliacion($datos['tipo_afiliacion']);
 		$TbEstudianteDetalleAnio->setTxEnfermedades($datos['enfermedades']);
 		$TbEstudianteDetalleAnio->setFkLocalidad($datos['id_localidad']);
 		$TbEstudianteDetalleAnio->setTxBarrio($datos['barrio']);
 		$TbEstudianteDetalleAnio->setFkTipoPoblacionVictima($datos['id_tipo_poblacion_victima']);
 		$TbEstudianteDetalleAnio->setFkTipoDiscapacidad($datos['id_tipo_discapacidad']);
 		$TbEstudianteDetalleAnio->setFkEtnia($datos['id_etnia']);
 		$TbEstudianteDetalleAnio->setFkUsuarioCreacion($datos['id_usuario']);
 		$TbEstudianteDetalleAnio->setInEstrato($datos['estrato']);
 		$TbEstudianteDetalleAnio->setPuntajeSisben($datos['sisben']);
 		$TbEstudianteDetalleAnio->setTxObservaciones($datos['observaciones_detalle_anio']);

 		$TbEstudianteDetalleAnio->setFkAreaArtisticaInteres(0);
 		$TbEstudianteDetalleAnio->setInExperiencia(0);
 		$TbEstudianteDetalleAnio->setInExperienciaEmpirica(0);
 		$TbEstudianteDetalleAnio->setInExperienciaAcademica(0);
 		$TbEstudianteDetalleAnio->setInExperienciaAnios(0);


		$datos_encapsulados = array('TbEstudiante' => $TbEstudiante,'TbEstudianteDetalleAnio' =>$TbEstudianteDetalleAnio);
 		echo $BeneficiarioDAO->crearObjeto($datos_encapsulados);
 	}

 	public function consultarGruposActivosEstudiantePorDocumento($datos){
 		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
 		$id_grupo = $BeneficiarioDAO->consultarGruposActivosEstudiantePorDocumento($datos['nro_documento'],$datos['tipo_grupo']);
 		if(isset($id_grupo[0]["FK_grupo"])){
 			echo $id_grupo[0]["FK_grupo"];
 		}else{
 			echo 0;
 		}
 	}

  public function consultarGradoEstudiante($datos){
    $BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
    $id_grado = $BeneficiarioDAO->consultarGradoEstudiante($datos['id_estudiante']);
    var_dump($id_grado);
  }

  public function removerEstudianteGrupo($datos){
  	$GrupoDAO = $this->contenedor['GrupoDAO'];
  	$resultado = $GrupoDAO->removerEstudianteGrupo($datos);
  	//var_dump($resultado);
  }

  public function asignarOrganizacionGrupo($datos){
  	$GrupoDAO = $this->contenedor['GrupoDAO'];
  	echo $GrupoDAO->asignarOrganizacionGrupo($datos);
  }

  public function getAdministradorOrganizacion($id_organizacion){
  	$TbOrganizaciones2017DAO = $this->contenedor['TbOrganizaciones2017DAO'];
  	echo json_encode($TbOrganizaciones2017DAO->getAdministradorOrganizacion($id_organizacion));
  }

  public function validarEstudianteDetalleAnio($id_estudiante){
  	$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
  	$detalle_anio = $BeneficiarioDAO->consultarEstudianteDetalleAnio($id_estudiante,date('Y'));
  	if (empty($detalle_anio)) {
  		echo 0;
  	}else{
  		echo 1;
  	}
  }

  public function crearRegistroDetalleAnio($datos){
  	try{
  		$datos = json_decode($datos,true);
  	}catch(Exception $e){
  		echo "Error decodificando";
  	}
  	$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
	$TbEstudianteDetalleAnio = $this->contenedor['TbEstudianteDetalleAnio'];
	$TbEstudianteDetalleAnio->setFkLocalidad(isset($datos['id_localidad'])? $datos['id_localidad']:NULL);
	$TbEstudianteDetalleAnio->setFkEps(isset($datos['id_eps'])? $datos['id_eps']:NULL);
	$TbEstudianteDetalleAnio->setFkGrupoPoblacional(isset($datos['id_grupo_poblacional'])? $datos['id_grupo_poblacional']:NULL);
	$TbEstudianteDetalleAnio->setFkClan(isset($datos['id_crea'])? $datos['id_crea']:NULL);
	$TbEstudianteDetalleAnio->setFkColegio(isset($datos['id_colegio'])? $datos['id_colegio']:NULL);
	$TbEstudianteDetalleAnio->setFkJornada(isset($datos['id_jornada'])? $datos['id_jornada']:NULL);
	$TbEstudianteDetalleAnio->setFkGrado(isset($datos['id_grado'])? $datos['id_grado']:NULL);
	$TbEstudianteDetalleAnio->setFKTipoDiscapacidad(isset($datos['id_tipo_discapacidad'])? $datos['id_tipo_discapacidad']:NULL);
	$TbEstudianteDetalleAnio->setFkTipoPoblacionVictima(isset($datos['id_tipo_poblacion_victima'])? $datos['id_tipo_poblacion_victima']:NULL);
	$TbEstudianteDetalleAnio->setIdentificacionAcudiente(isset($datos['identificacion_acudiente'])? $datos['identificacion_acudiente']:NULL);
	$TbEstudianteDetalleAnio->setNombreAcudiente(isset($datos['nombre_acudiente'])? $datos['nombre_acudiente']:NULL);
	$TbEstudianteDetalleAnio->setTelefonoAcudiente(isset($datos['telefono_acudiente'])? $datos['telefono_acudiente']:NULL);
	$TbEstudianteDetalleAnio->setTXBarrio(isset($datos['barrio'])? $datos['barrio']:NULL);
	$TbEstudianteDetalleAnio->setInEstrato(isset($datos['estrato'])? $datos['estrato']:NULL);
	$TbEstudianteDetalleAnio->setPuntajeSisben(isset($datos['sisben'])? $datos['sisben']:NULL);
	$TbEstudianteDetalleAnio->setTxTipoAfiliacion(isset($datos['tipo_afiliacion'])? $datos['tipo_afiliacion']:NULL);
	$TbEstudianteDetalleAnio->setFkEtnia(isset($datos['id_etnia'])? $datos['id_etnia']:NULL);
	$TbEstudianteDetalleAnio->setTxEnfermedades(isset($datos['enfermedades'])? $datos['enfermedades']:NULL);
	$TbEstudianteDetalleAnio->setTxObservaciones(isset($datos['observaciones_detalle_anio'])? $datos['observaciones_detalle_anio']:NULL);
	$TbEstudianteDetalleAnio->setFkEstudiante(isset($datos['id_estudiante'])? $datos['id_estudiante']:NULL);
	$TbEstudianteDetalleAnio->setAnio(date('Y'));
	$TbEstudianteDetalleAnio->setFkUsuarioCreacion($datos['id_usuario']);

	$TbEstudianteDetalleAnio->setFkAreaArtisticaInteres($datos['id_area_artistica_interes']);
	$TbEstudianteDetalleAnio->setInExperiencia($datos['experiencia']);
	$TbEstudianteDetalleAnio->setInExperienciaEmpirica($datos['experiencia_empirica']);
	$TbEstudianteDetalleAnio->setInExperienciaAcademica($datos['experiencia_academia']);
	$TbEstudianteDetalleAnio->setInExperienciaAnios($datos['experiencia_anios']);
	$resultado = $BeneficiarioDAO->crearRegistroDetalleAnio($TbEstudianteDetalleAnio);
	echo $resultado;
  }

	public function consultarDocumentoEstudianteById($id_estudiante){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$datos_estudiante = $BeneficiarioDAO->consultarDatosBasicosEstudiante($id_estudiante);
		echo $datos_estudiante[0]['IN_Identificacion'];
	}

	public function validarZonificacionArtista($datos){
		$AsignacionDAO = $this->contenedor['AsignacionDAO'];
		$zona = $AsignacionDAO->consultarZonificacionArtista($datos);
		if(!empty($zona)){
			echo "1";
		}else{
			echo "0";
		}
	}

	public function validarHorarioDisponible($datos){
		$resultado = 0;
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$horario_grupo = $GrupoDAO->consultarHorarioGrupo($datos['id_grupo'],$datos['tipo_grupo']);
		$grupos_artista = $GrupoDAO->consultarGruposUsuario($datos['id_artista_formador'],$datos['tipo_grupo']);
		if($datos['id_artista_formador'] == 1715 || $datos['id_artista_formador'] == 0 || $datos['id_artista_formador'] == 2489 || empty($grupos_artista) || $this->grupoEsVacacional($datos)){
			$resultado = 0;
		}else{
			foreach ($grupos_artista as $g) {
				$horario_grupo_temp = $GrupoDAO->consultarHorarioGrupo($g['PK_Grupo'],$datos['tipo_grupo']);
				foreach ($horario_grupo_temp as $a) {
					foreach ($horario_grupo as $b) {
						if ($a['IN_dia'] == $b['IN_dia']) {
							if ((($b['TI_hora_inicio_clase'] >= $a['TI_hora_inicio_clase'])   &&
								 ($b['TI_hora_inicio_clase'] <  $a['TI_hora_fin_clase']))     ||
							    (($b['TI_hora_inicio_clase'] <  $a['TI_hora_inicio_clase'])   &&
							   	 ($b['TI_hora_fin_clase']    >  $a['TI_hora_inicio_clase']))) 
							{
								$resultado = 1;	
							}													
						}
					}
				}
			}
		}
		echo $resultado;
	}

	public function quitarArtistaFormadorGrupo($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$quitar_artista = $GrupoDAO->quitarArtistaFormadorGrupo($datos);
		echo ($quitar_artista);
	}

	private function grupoEsVacacional($datos){
		$es_vacacional = false;
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$TbTerrGrupo = $this->contenedor['TbTerrGrupo'];
		$TbTerrGrupo->setPkGrupo($datos['id_grupo']);
		$TbTerrGrupo->setTipoGrupo($datos['tipo_grupo']);
		$grupo = $GrupoDAO->consultarObjeto($TbTerrGrupo);
		if($grupo['tipo_grupo'] == 'VACACIONAL'){
			$es_vacacional = true;
		}
		return $es_vacacional;
	}
}

$objControlador = new AsignacionController();
unset($objControlador);
