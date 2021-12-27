<?php

namespace ConsultasReportes\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\ConsultasAdministrativoDAO;
use General\Vista\Vista;



class ReporteAdministrativoController extends ControladorBase
{
	/**
	 * @var Container
	 *
	 */
	// private /*static*/ $contenedor;

	function __construct()
	{

		parent::__construct();
		$this->contenedor=$this->getContenedor();
		$this->contenedor['ConsultasAdministrativoDAO'] = function ($c) {
			return new ConsultasAdministrativoDAO();
		};
		$variables=array();
		$this->contenedor['vista'] = function ($c) use ($variables) {
			return new Vista($variables);
		};
		if(isset($_POST['p1'])) $this->p1=$_POST['p1']; else $this->p1=null;
		if(isset($_POST['p2'])) $this->p2=$_POST['p2']; else $this->p2=null;
		if(isset($_POST['p3'])) $this->p3=$_POST['p3']; else $this->p3=null;
		if(isset($_POST['p4'])) $this->p4=$_POST['p4']; else $this->p4=null;
		if(isset($_POST['p5'])) $this->p5=$_POST['p5']; else $this->p5=null;
		if(isset($_FILES) && sizeof($_FILES)>0) {
			if($this->p1===null) {
				$this->p1=$_POST;
				unset($this->p1["funcion"]);		
			}	
			$this->p2=$_FILES; 
		} 

		$this->{$_POST["funcion"]}($this->p1,$this->p2,$this->p3,$this->p4,$this->p5);

	}

	public function consultarTotalAsignacionEstudiantes($datos){
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		$asignacion = $ConsultasAdministrativoDAO->consultarTotalAsignacionEstudiantes($datos);
		$asignacion_return = [];
		foreach ($asignacion as $a) {
			$nombre_completo_temp = $a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']." ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido'];
			$array_temp = array('total' => $a['count'],'nombre' => $nombre_completo_temp,'id_persona' => $a['FK_usuario_ingreso']);
			array_push($asignacion_return, $array_temp);
		}
		echo json_encode($asignacion_return);
	}

	public function consultarTotalRemocionEstudiantes($datos){
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		$remocion = $ConsultasAdministrativoDAO->consultarTotalRemocionEstudiantes($datos);
		$remocion_return = [];
		foreach ($remocion as $a) {
			$nombre_completo_temp = $a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']." ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido'];
			$array_temp = array('total' => $a['count'],'nombre' => $nombre_completo_temp,'id_persona' => $a['FK_usuario_retiro'],'color' => '#ff6666');
			array_push($remocion_return, $array_temp);
		}
		echo json_encode($remocion_return);
	}

	public function consultarTotalCreacionEstudiantes($datos,$color_graph){
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		$remocion = $ConsultasAdministrativoDAO->consultarTotalCreacionEstudiantes($datos);
		$remocion_return = [];
		foreach ($remocion as $a) {
			$nombre_completo_temp = $a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']." ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido'];
			$array_temp = array('total' => $a['count'],'nombre' => $nombre_completo_temp,'id_persona' => $a['Id_Usuario_Registro'],'color' => $color_graph);
			array_push($remocion_return, $array_temp);
		}
		echo json_encode($remocion_return);
	}

	public function consultarListadoAsignacionEstudiantes($datos){
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		$estudiante = $ConsultasAdministrativoDAO->consultarListadoAsignacionEstudiantes($datos);
		$vista = $this->contenedor['vista'];
 		$vista->setNamespace('GestionClan');
 		$vista->setPlantilla('tableEstudiantesBase');
		$vista->setVariables(array('estudiante'=>$estudiante,'tipo_mostrar'=>'administrado_por_usuario_a_grupo','tipo_accion'=>'asignacion'));
		$vista->renderHtml();
	}

	public function consultarListadoRemocionEstudiantes($datos){
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		$estudiante = $ConsultasAdministrativoDAO->consultarListadoRemocionEstudiantes($datos);
		$vista = $this->contenedor['vista'];
 		$vista->setNamespace('GestionClan');
 		$vista->setPlantilla('tableEstudiantesBase');
		$vista->setVariables(array('estudiante'=>$estudiante,'tipo_mostrar'=>'administrado_por_usuario_a_grupo','tipo_accion'=>'retiro'));
		$vista->renderHtml();
	}

	public function consultarListadoCreacionEstudiantes($datos){
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		$estudiante = $ConsultasAdministrativoDAO->consultarListadoCreacionEstudiantes($datos);
		$vista = $this->contenedor['vista'];
 		$vista->setNamespace('GestionClan');
 		$vista->setPlantilla('tableEstudiantesBase');
		$vista->setVariables(array('estudiante'=>$estudiante,'tipo_mostrar'=>'administrado_por_usuario_creacion','tipo_accion'=>'creado_'.$datos['tipo_estudiante']));
		$vista->renderHtml();
	}

	public function consultarDatosAsignacionLineaAtencion($datos){
		$linea_atencion = array('arte_escuela'=> 'Arte en la escuela','emprende_clan' => 'Emprende Crea','laboratorio_clan' => 'Laboratorio Crea');
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		$return = array();
		foreach ($linea_atencion as $key => $value) {
			$asignados = $ConsultasAdministrativoDAO->consultarTotalAsignacionEstudiantesPorUsuario($datos,$key);
			$removidos = $ConsultasAdministrativoDAO->consultarTotalRemocionEstudiantesPorUsuario($datos,$key);
			$grupos_creados = $ConsultasAdministrativoDAO->consultarTotalGruposCreadosPorUsuario($datos,$key);
			$grupos_cerrados = $ConsultasAdministrativoDAO->consultarTotalGruposCerradosPorUsuario($datos,$key);
			$resultado = array();
			$resultado['asignados'] = $asignados[0]["count"];
			$resultado['removidos'] = $removidos[0]["count"];
			$resultado['grupos_creados'] = $grupos_creados[0]["count"];
			$resultado['grupos_cerrados'] = $grupos_cerrados[0]["count"];
			$resultado['linea_atencion_mostrar'] = $value;
			$resultado['linea_atencion'] = $key;
			array_push($return, $resultado);
		}
		echo json_encode($return);
	}

	public function consultarTotalEstudiantesCreadosPorUsuario($datos){
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		$resultado = $ConsultasAdministrativoDAO->consultarTotalEstudiantesCreadosPorUsuario($datos);
		$return = [];
		$creados_simat = 0;
		$creados_formulario = 0;
		$creados_creaencasa = 0;
		for ($i=0; $i < sizeof($resultado) ; $i++) { 
			if ($resultado[$i]['VC_Tipo_Estudiante'] == 'FORMULARIO') {
				$creados_formulario = $resultado[$i]['count'];
			}else if($resultado[$i]['VC_Tipo_Estudiante'] == 'MATRICULA') {
				$creados_simat = $resultado[$i]['count'];
			}else if($resultado[$i]['VC_Tipo_Estudiante'] == 'CREAENCASA') {
				$creados_creaencasa = $resultado[$i]['count'];
			}
		}
		$return['matricula'] = $creados_simat;
		$return['formulario'] = $creados_formulario;
		$return['creaencasa'] = $creados_creaencasa;
		echo json_encode($return);
	}

	public function consultarTotalGruposAdministradosPorUsuario($datos){
		$linea_atencion = ['arte_escuela','emprende_clan','laboratorio_clan'];
		$return = [];
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		foreach ($linea_atencion as $l) {
			$creados = $ConsultasAdministrativoDAO->consultarTotalGruposCreadosPorUsuario($datos,$l);
			$cerrados = $ConsultasAdministrativoDAO->consultarTotalGruposCerradosPorUsuario($datos,$l);
			$return[$l]['creados']=$creados[0]['count'];
			$return[$l]['cerrados']=$cerrados[0]['count'];

		}
		echo json_encode($return);
	}

	public function consultarCreaDeAsistenteAdministrativo($id_usuario){
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		$resultado = $ConsultasAdministrativoDAO->consultarCreaDeAsistenteAdministrativo($id_usuario);
		echo json_encode($resultado);
	}

	public function consultarCreaDeCoordinador($id_usuario){
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		$resultado = $ConsultasAdministrativoDAO->consultarCreaDeCoordinador($id_usuario);
		echo $resultado[0]['VC_Nom_Clan'];
	}


	public function consultarDatosReporteDigitalMensual($datos){
		$ConsultasAdministrativoDAO = $this->contenedor['ConsultasAdministrativoDAO'];
		$resultado = $ConsultasAdministrativoDAO->consultarDatosReporteDigitalMensual($datos);
		$toReturn = array();
		$toReturn['arte_escuela']['pendientes'] = 0;
		$toReturn['arte_escuela']['aprobados'] = 0;
		$toReturn['arte_escuela']['rechazados'] = 0;
		$toReturn['arte_escuela']['total'] = 0;
		$toReturn['emprende_clan']['pendientes'] = 0;
		$toReturn['emprende_clan']['aprobados'] = 0;
		$toReturn['emprende_clan']['rechazados'] = 0;
		$toReturn['emprende_clan']['total'] = 0;
		$toReturn['laboratorio_clan']['pendientes'] = 0;
		$toReturn['laboratorio_clan']['aprobados'] = 0;
		$toReturn['laboratorio_clan']['rechazados'] = 0;
		$toReturn['laboratorio_clan']['total'] = 0;
		$toReturn['total']['pendientes'] = 0;
		$toReturn['total']['aprobados'] = 0;
		$toReturn['total']['rechazados'] = 0;
		$toReturn['total']['general'] = 0;
		foreach($resultado as $value) {
			$toReturn['total']['general'] += (int)$value['conteo'];
			switch($value['linea_atencion']) {
				case 'arte_escuela':
					//Arte
					$toReturn['arte_escuela']['total'] += (int)$value['conteo'];
					if($value['SM_estado'] == '0') {
						$toReturn['arte_escuela']['pendientes'] += (int)$value['conteo'];
						$toReturn['total']['pendientes'] += (int)$value['conteo'];
					} else if($value['SM_estado'] == '1') {
						$toReturn['arte_escuela']['aprobados'] += (int)$value['conteo'];
						$toReturn['total']['aprobados'] += (int)$value['conteo'];
					} else {
						$toReturn['arte_escuela']['rechazados'] += (int)$value['conteo'];
						$toReturn['total']['rechazados'] += (int)$value['conteo'];
					}
				break;
				
				case 'emprende_clan':
					//Emprende
					$toReturn['emprende_clan']['total'] += (int)$value['conteo'];
					if($value['SM_estado'] == '0') {
						$toReturn['emprende_clan']['pendientes'] += (int)$value['conteo'];
						$toReturn['total']['pendientes'] += (int)$value['conteo'];
					} else if($value['SM_estado'] == '1') {
						$toReturn['emprende_clan']['aprobados'] += (int)$value['conteo'];
						$toReturn['total']['aprobados'] += (int)$value['conteo'];
					} else {
						$toReturn['emprende_clan']['rechazados'] += (int)$value['conteo'];
						$toReturn['total']['rechazados'] += (int)$value['conteo'];
					}
				break;
				
				case 'laboratorio_clan':
					//Laboratorio
					$toReturn['laboratorio_clan']['total'] += (int)$value['conteo'];
					if($value['SM_estado'] == '0') {
						$toReturn['laboratorio_clan']['pendientes'] += (int)$value['conteo'];
						$toReturn['total']['pendientes'] += (int)$value['conteo'];
					} else if($value['SM_estado'] == '1') {
						$toReturn['laboratorio_clan']['aprobados'] += (int)$value['conteo'];
						$toReturn['total']['aprobados'] += (int)$value['conteo'];
					} else {
						$toReturn['laboratorio_clan']['rechazados'] += (int)$value['conteo'];
						$toReturn['total']['rechazados'] += (int)$value['conteo'];
					}
				break;
			}
		}
		
		echo json_encode($toReturn);
	}
}

$objControlador = new ReporteAdministrativoController();

if(isset($_POST['funcion']) && $_POST['funcion']==='addAdjuntosSoporte')
{
	//echo '<pre>'.print_r($GLOBALS,true).'</pre>';
	
}
unset($objControlador);
