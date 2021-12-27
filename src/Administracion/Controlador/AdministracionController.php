<?php

namespace Administracion\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\SoporteDAO;
use General\Persistencia\DAOS\TbSoporte2017TipoSoporteDAO;
use General\Persistencia\DAOS\TbPersona2017DAO;
use General\Persistencia\DAOS\TbMenuActividadUsuarioDAO;
use General\Persistencia\DAOS\TbIncidenteDAO;
use General\Persistencia\DAOS\TbIncidenteAdjuntoDAO;
use General\Persistencia\DAOS\TbIncidenteHistorialDAO;
use General\Persistencia\DAOS\TbIncidenteObservacionDAO;
use General\Persistencia\DAOS\TbTipoPersonaActividadDAO;
use General\Persistencia\DAOS\GrupoArteEscuelaSesionClase;
use General\Persistencia\DAOS\MenuDAO;
use General\Persistencia\DAOS\ColegioDAO;
use General\Persistencia\DAOS\ParametroDAO;
use General\Persistencia\Entidades\TbPersona2017;
use General\Persistencia\Entidades\TbMenuActividadUsuario;
use General\Persistencia\Entidades\TbIncidente;
use General\Persistencia\Entidades\TbIncidenteAdjunto;
use General\Persistencia\Entidades\TbIncidenteHistorial;
use General\Persistencia\Entidades\TbIncidenteObservacion;
use General\Vista\Vista;



class AdministracionController extends ControladorBase
{
	/**
	 * @var Container
	 *
	 */
	// private /*static*/ $contenedor;

	function __construct()
	{

		parent::__construct();

 		//AdministracionController::contenedor=$this::getContenedor();
		$this->contenedor=$this->getContenedor();
		$this->contenedor['soporte'] = function ($c) {
			return new SoporteDAO();
		};

		/**
		  * Usado para Pruebas Render HTML en PHP vs JS
		  */
		$this->contenedor['asistencias'] = function ($c) {
			return new GrupoArteEscuelaSesionClase();
		};

		$this->contenedor['tipoSoporte'] = function ($c) {
			return new TbSoporte2017TipoSoporteDAO();
		};

		$variables=array();
		$this->contenedor['vista'] = function ($c) use ($variables) {
			return new Vista($variables);
		};

		$this->contenedor['personaDAO'] = function ($c) {
			return new TbPersona2017DAO();
		};

		$this->contenedor['persona'] = function ($c) {
			return new TbPersona2017();
		};

		$this->contenedor['incidente'] = function ($c) {
			return new TbIncidente();
		};

		$this->contenedor['incidenteAdjunto'] = function ($c) {
			return new TbIncidenteAdjunto();
		};

		$this->contenedor['incidenteHistorial'] = function ($c) {
			return new TbIncidenteHistorial();
		};

		$this->contenedor['incidenteObservacion'] = function ($c) {
			return new TbIncidenteObservacion();
		};

		$this->contenedor['menuActividadUsuarioDAO'] = function ($c) {
			return new TbMenuActividadUsuarioDAO();
		};

		$this->contenedor['menuActividadUsuario'] = function ($c) {
			return new TbMenuActividadUsuario();
		};

		$this->contenedor['incidenteDAO'] = function ($c) {
			return new TbIncidenteDAO();
		};

		$this->contenedor['incidenteAdjuntoDAO'] = function ($c) {
			return new TbIncidenteAdjuntoDAO();
		};

		$this->contenedor['incidenteHistorialDAO'] = function ($c) {
			return new TbIncidenteHistorialDAO();
		};

		$this->contenedor['incidenteObservacionDAO'] = function ($c) {
			return new TbIncidenteObservacionDAO();
		};

		$this->contenedor['incidenteObservacionDAO'] = function ($c) {
			return new TbIncidenteObservacionDAO();
		};

		$this->contenedor['tipoPersonaActividadDAO'] = function ($c) {
			return new TbTipoPersonaActividadDAO();
		};

		$this->contenedor['MenuDAO'] = function ($c) {
			return new MenuDAO();
		};

		$this->contenedor['ColegioDAO'] = function ($c) {
			return new ColegioDAO();
		};

		$this->contenedor['ParametroDAO'] = function ($c) {
			return new ParametroDAO();
		};
		//parent::__construct();

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

	/**
	  * Limpiar los caracteres especiales de una cadena.
	  *
	  */
	public function sanitizar($cadena)
	{
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array("a","e","i","o","u","A","E","I","O","U","n","N","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		$texto = str_replace($no_permitidas, $permitidas ,$cadena);
		return $texto;
	}
	/**
	  * @ejecutador Solucion_Soporte2.php
	  *
	  */
	public function getSoportesASolucionar($datos
	)
	{
		/*$soporte = $this->contenedor['soporte'];
		$soportes = $soporte->getSoportesASolucionar();
		//$vista= new Vista(array('soportes'=>$soportes));
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('soportes'=>$soportes));
		$vista->renderHtml(); */

		$datosWhere=array();
		foreach ($datos as $key => $value) {
			$signo='=';
			if($key=='estado')
				$signo='<>';
			$datosWhere[$key]=array('valor'=>$value,
				'signo'=>$signo);
		}
		$incidente = $this->contenedor['incidente'];
		$incidente->setVariables($datosWhere);
		$where=$incidente->setWhere("I");
		$incidenteDAO = $this->contenedor['incidenteDAO'];
		$soportesUsuario = $incidenteDAO->consultarHistoricoIncidente($where);
		//echo '<pre>'.print_r($soportesUsuario,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('soportes'=>$soportesUsuario));
		$vista->renderHtml();
	}

	/**
	  * @ejecutador Solucion_Soporte2.php
	  *
	  */
	public function setPrioridadIncidente($datos
	)
	{
		$datosUpdate=array();
		foreach ($datos as $key => $value) {
			$signo='=';
			$llave=false;
			if($key=='codigo')
				$llave=true;
			$datosUpdate[$key]=array('valor'=>$value,
				'signo'=>$signo,
				'llave'=>$llave);
		}
		$incidente = $this->contenedor['incidente'];
		//echo 'datosUpdate: <pre>'.print_r($datosUpdate,true).'</pre>';
		$incidente->setVariables($datosUpdate);
		$incidente->setPrioridad();
		//echo 'prioridad: <pre>'.print_r($incidente->getPrioridad(),true).'</pre>';
		$update=$incidente->setUpdate("I");
		$incidenteDAO = $this->contenedor['incidenteDAO'];
		$updateIncidente = $incidenteDAO->modificarObjeto($update);
		//echo 'r: '.print_r($updateIncidente,true);
		if($updateIncidente)
			echo $incidente->getPrioridad()['nombre'];

	}

	/**
	  * @ejecutador Solucion_Soporte2.php
	  *
	  */
	public function cambiarDatosIncidente($datos,$estado_actual,$usuario
	)
	{
		if(isset($datos['descripcion_solucion']))
		{
			$datos['descripcion_solucion']=str_replace("'","-",$datos['descripcion_solucion']);
			//$datos['descripcion_solucion']=str_replace("\"","-",substr($datos['descripcion_solucion'],1,strlen($datos['descripcion_solucion'])-2));
			$datos['descripcion_solucion']="'".$datos['descripcion_solucion']."'";
		}
		$datosUpdate=array();
		//echo print_r($datos,true);
		foreach ($datos as $key => $value) {
			$signo='=';
			$llave=false;
			if($key=='codigo')
				$llave=true;
			if($key=='estado' && $value==="'cerrado'")
				$datosUpdate['fecha_cierre']=array('valor'=>"'".date("Y-m-d H:i:s")."'",
					'signo'=>$signo,
					'llave'=>$llave);
			$datosUpdate[$key]=array('valor'=>$value,
				'signo'=>$signo,
				'llave'=>$llave);
		}
		$incidente = $this->contenedor['incidente'];
		//echo 'datosUpdate: <pre>'.print_r($datosUpdate,true).'</pre>';
		$incidente->setVariables($datosUpdate);
		$update=$incidente->setUpdate("I");
		//echo 'update: <pre>'.print_r($update,true).'</pre>';
		$incidenteDAO = $this->contenedor['incidenteDAO'];
		echo $incidenteDAO->modificarObjeto($update);
		//echo $incidente->getEstado()['valor'];
		if($incidente->getEstado()['valor']!=''){

			$incidenteHistorial = $this->contenedor['incidenteHistorial'];
			$incidenteHistorial->setVariables(array('fecha'=>array('valor'=>date("Y-m-d H:i:s")),
				'incidente_codigo'=>$incidente->getCodigo(),
				'servicio_codigo'=>$incidente->getServicioCodigo(),
				'sla_codigo'=>$incidente->getSlaCodigo(),
				'fk_id_usuario'=>array('valor'=>$usuario),
				'fk_Funcionario_Anterior'=>$incidente->getFkIdUsuarioFuncionario(),
				'estado_nuevo'=>str_replace("'", "", $incidente->getEstado()),
				'estado_anterior'=>array('valor'=>$estado_actual)
			)); 
			$incidenteHistorialDAO = $this->contenedor['incidenteHistorialDAO'];
			echo $incidenteHistorialDAO->crearObjeto($incidenteHistorial);
		}

		/*$updateIncidente = $incidenteDAO->modificarObjeto($update);
		//echo 'r: '.print_r($updateIncidente,true);
		if($updateIncidente)
		echo $incidente->getEstado()['valor'];*/
	}

	/**
	  * @ejecutador Solucion_Soporte2.php
	  *
	  */
	public function getEstadoIncidente($datos,$llamadoAjax
	)
	{
		$datosWhere=array();
		foreach ($datos as $key => $value) {
			$signo='=';
			$datosWhere[$key]=array('valor'=>$value,
				'signo'=>$signo);
		}
		$incidente = $this->contenedor['incidente'];
		$incidente->setVariables($datosWhere);
		$where=$incidente->setWhere("I");
		$incidenteDAO = $this->contenedor['incidenteDAO'];
		$incidenteResultado = $incidenteDAO->consultarHistoricoIncidente($where);
		if($llamadoAjax)
			echo $incidenteResultado[0]['estado'];
		else
			return $incidenteResultado;
		//consultarHistoricoIncidente en DAO recibe el Where

	}


	/**
	  * @ejecutador Solicitud_Soporte2.php
	  *
	  */
	public function getOptionsTipoSoporte(
	)
	{
		$tipoSoporte = $this->contenedor['tipoSoporte'];
		$tiposSoportes= $tipoSoporte->consultarObjeto();
		//echo "<pre>".print_r($tiposSoportes)."</pre>" ;
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('tipoSoportes'=>$tiposSoportes));
		$vista->renderHtml();
	}


	/**
	  * @ejecutador Solicitud_Soporte2.php
	  *
	  */
	public function getDatosUsuarioById($id_usuario
	)
	{
		$persona=$this->contenedor['persona'];
		$persona->setPkIdPersona($id_usuario);
		$personaDAO=$this->contenedor['personaDAO'];
		$datosPersona=$personaDAO->consultarObjeto($persona);
		echo json_encode($datosPersona);
	}

	/**
	  * @ejecutador Solicitud_Soporte2.php
	  *
	  */
	public function getActividadesUsuario($fk_persona,$vistaPersonalizada=null
	)
	{
		//echo '<pre>1: '.print_r($fk_persona,true).'</pre>';
		//echo '<pre>2: '.print_r($vistaPersonalizada,true).'</pre>';
		$actividadUsuario = $this->contenedor['menuActividadUsuario'];
		$actividadUsuario->setFkPersona($fk_persona);
		$actividadUsuarioDAO = $this->contenedor['menuActividadUsuarioDAO'];
		$menuActividades  = $actividadUsuarioDAO->consultarObjeto($actividadUsuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('menuActividades'=>$menuActividades));
		if($vistaPersonalizada!==null)
			$vista->setPlantilla($vistaPersonalizada);
		$vista->renderHtml();
	}


	/**
	  * @ejecutador Solicitud_Soporte2.php
	  *
	  */
	public function addSolicitudSoporte($datos
	)
	{
		$datosWhere=array();
		$datos['descripcion_sintomas']= str_replace("'", "-", $datos['descripcion_sintomas']);

		foreach ($datos as $key => $value) {
			$signo='=';
			$datosWhere[$key]=array('valor'=>$value,
				'signo'=>$signo);
			if($key=='sla_codigo')
				$datosWhere[$key]['llave']=true;  
		} 
		//echo print_r($datosWhere,true); 

		$incidente = $this->contenedor['incidente'];
		$incidente->setVariables($datosWhere);
		$incidente->setFechaCreacion(array('valor'=>date("Y-m-d H:i:s")));
		$incidenteDAO = $this->contenedor['incidenteDAO'];
		$codigo = $incidenteDAO->crearObjeto($incidente);

		//Creación de Incidente historial, donde se guarda el estado de abierto
		$incidenteHistorial = $this->contenedor['incidenteHistorial'];
		$incidenteHistorial->setVariables(array('fecha'=>$incidente->getFechaCreacion(),
			'incidente_codigo'=>array('valor'=>$codigo),
			'servicio_codigo'=>$incidente->getServicioCodigo(),
			'sla_codigo'=>$incidente->getSlaCodigo(),
			'fk_id_usuario'=>$incidente->getFkIdUsuario(),
			'fk_Funcionario_Anterior'=>$incidente-> getFkIdUsuarioFuncionario(),
			'estado_nuevo'=>array('valor'=>'abierto')
		)); 
		$incidenteHistorialDAO = $this->contenedor['incidenteHistorialDAO'];
		$incidenteHistorialDAO->crearObjeto($incidenteHistorial);

		echo $codigo;

	}


	/**
	  * @ejecutador Solicitud_Soporte2.php
	  *
	  */
	public function addAdjuntosSoporte($datos,$archivos
	)
	{
		$incidenteAdjunto = $this->contenedor['incidenteAdjunto'];
		//Sube Archivos y retorna la colección de objetos listos para ser insertados a la BD
		$incidenteAdjunto->setVariables($datos); 
		//echo '*1. '.$incidenteAdjunto->getIncidenteCodigo().'- 2. '.$incidenteAdjunto->getCarpeta().'- 3. '.$incidenteAdjunto->getServicioCodigo().' - 4. '.$incidenteAdjunto->getSlaCodigo().'<br>';  
		$objetos=$incidenteAdjunto->subirArchivos($archivos);
		//echo '<pre>Objetos: '.print_r($objetos,true).'</pre>';
		$incidenteAdjuntoDAO = $this->contenedor['incidenteAdjuntoDAO'];
		//$respuesta=$incidenteAdjuntoDAO->crearObjeto($objetos);
		//echo '<pre>'.print_r($respuesta,true).'</pre>';
		echo json_encode($incidenteAdjuntoDAO->crearObjeto($objetos)); 
	}

	/**
	  * @ejecutador Solicion_Soporte2.php, Solicitud_Soporte2.php
	  *
	  */
	public function consultarAdjuntosSoporte($datos
	)
	{
		$incidenteAdjunto = $this->contenedor['incidenteAdjunto'];
		$incidenteAdjunto->setVariables($datos);

		$incidenteAdjuntoDAO = $this->contenedor['incidenteAdjuntoDAO'];
		$adjuntos=$incidenteAdjuntoDAO->consultarObjeto($incidenteAdjunto);
		//echo '<pre>'.print_r($adjuntos,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('adjuntos'=>$adjuntos));
		$vista->renderHtml();

	}



	/**
	  * @ejecutador Solicitud_Soporte2.php
	  *
	  */
	public function getHistoricoSolicitudes($datos
	)
	{

		$incidente = $this->contenedor['incidente'];
		$incidente->setVariables($datos);
		$incidenteDAO = $this->contenedor['incidenteDAO'];
		$soportesUsuario = $incidenteDAO->consultaMiHistoricoIncidente($incidente); 
		//echo '<pre>'.print_r($soportesUsuario,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('soportesUsuario'=>$soportesUsuario));
		$vista->renderHtml();
	}

	/**
	  * @ejecutador Solicion_Soporte2.php
	  *
	  */
	public function getIncidentesCerrados($datos
	)
	{
		//echo '<pre>'.print_r($datos,true).'</pre>';

		$datosWhere=array();
		foreach ($datos as $key => $value) {
			$signo='=';
			if(is_array($value)){
				foreach ($value as $subKey => $subValue) {
					if($subKey=='menorque')
						$signo_="<=";
					if($subKey=='mayorque')
						$signo_=">=";
					$valores[]=array('valor'=>$subValue,'signo'=>$signo_);
				}
				$datosWhere[$key]=array('valor'=>$valores);
			} 
			else
				$datosWhere[$key]=array('valor'=>$value,
					'signo'=>$signo);
		}

		$incidente = $this->contenedor['incidente'];
		$incidente->setVariables($datosWhere);
		//echo '<pre>'.print_r($datosWhere,true).'</pre>';
		$where=$incidente->setWhere("I");
		//echo 'where: '.$where;
		$incidenteDAO = $this->contenedor['incidenteDAO'];
		$soportes = $incidenteDAO->consultarHistoricoIncidente($where);

		//echo '<pre>'.print_r($soportes,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('soportes'=>$soportes));
		$vista->renderHtml();
	}


	/**
	  * @ejecutador Solicitud_Soporte2.php
	  *
	  */
	public function getObservacionesIncidente($datos,$usuario)

	{
		$incidenteObservacion = $this->contenedor['incidenteObservacion'];
		$incidenteObservacion->setVariables($datos);
		//Obtener el tipo de Usuario
		$persona=$this->contenedor['persona'];
		$persona->setPkIdPersona($usuario['usuario']);
		//echo '*usuario*'.print_r($usuario,true);
		$personaDAO=$this->contenedor['personaDAO'];
		$datosPersona=$personaDAO->consultarObjeto($persona);
		//Añade la condición de observación solo publica
		//echo print_r($datosPersona,true);
		if($datosPersona[0]['TipoPersona']!=18) { 
			$incidenteObservacion->setTipoObservacion('0');
			$tipoObservacion=false;
		}
		else $tipoObservacion=true;

		$where=$incidenteObservacion->setWhere("IO");
		//echo 'where: '.print_r($where,true);
		$incidenteObservacionDAO = $this->contenedor['incidenteObservacionDAO'];
		$observaciones=$incidenteObservacionDAO->consultarObjeto($where);
		//echo 'observaciones: '.print_r($observaciones,true);
		echo json_encode(array('observaciones'=>$observaciones,
			'tipoObservacion'=>$tipoObservacion));
		/*$vista= $this->contenedor['vista'];
		$vista->setVariables(array('observaciones'=>$observaciones,
								   'TipoPersona'=>$datosPersona[0]['TipoPersona']));
								   $vista->renderHtml();  */
								}

								public function addObservacionesIncidente($datos
								)
								{
		//echo print_r($datos,true);
									$datos['observaciones']=str_replace("'","-",$datos['observaciones']);     
		//$datos['observaciones']=str_replace("\"","-",$datos['observaciones']); 

		//echo print_r($datos,true);
									$incidenteObservacion = $this->contenedor['incidenteObservacion'];
									$incidenteObservacion->setVariables($datos);
									$incidenteObservacion->setFecha(date("Y-m-d H:i:s"));
									$incidenteObservacionDAO = $this->contenedor['incidenteObservacionDAO'];
									$codigoObservacion=$incidenteObservacionDAO->crearObjeto($incidenteObservacion);
		//Si está cerrado abre el incidente:
		/*$datosIncidente=$this->getEstadoIncidente(array("codigo"=>$datos["incidente_codigo"]),false );
		$estadoIncidente=$datosIncidente[0]['estado'];
		if($estadoIncidente=='cerrado'){
		//Cambiar estado del incidente a Desarrollo cuando añade otra observación al incidente.
			$this->cambiarDatosIncidente(array('codigo'=>$datos["incidente_codigo"],
				'estado'=>'desarrollo',
				'fk_actividad_cierre'=>null,
				'fecha_cierre'=>null));
			}*/   
			echo $codigoObservacion;
		//echo print_r($datosIncidente,true);
		}

	/**
	  * Usado para pruebas de rendimiento Render PHP vs JS
	  *	Render en PHP
	  */
	public function getAsistenciasAE(
	)
	{

		$asistencia = $this->contenedor['asistencias'];
		$asistencias = $asistencia->getAsistenciasAE();
		$vista= new Vista(array('asistencias'=>$asistencias));
		$vista->renderHtml();

	}

	/**
	  * Usado para pruebas de rendimiento Render PHP vs JS
	  * Render en JS
	  */
	public function getAsistenciasAE2(
	)
	{

		$asistencia = $this->contenedor['asistencias'];
		$asistencias = $asistencia->getAsistenciasAE();
		echo json_encode($asistencias);
	}

	public function consultarObservacionesUsuario($datos
	)
	{
		$observaciones = $this->contenedor['personaDAO'];
		$historico_observaciones = $observaciones->consultarObservacionesPersona($datos);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('observacion'=>$historico_observaciones));
		$vista->renderHtml();
		/*$vista= $this->contenedor['vista'];
		$vista= new Vista(array('observacion'=>$historico_observaciones));
		$vista->renderHtml();*/
		//echo json_encode($historico_observaciones);
	}
  /**
	  * Almacena las cambios en permisos de rol
	  * Retorna el estado de la transacción
	  */
  public function saveActivityRol($activityId,$rolId
  )
  {

  	$asistencia = $this->contenedor['tipoPersonaActividadDAO'];
  	$resultado = $asistencia->saveActividadTipoUsuario($activityId,$rolId);
  	echo json_encode($resultado);
  }
	/**
	  * Almacena las cambios en permisos de rol
	  * Retorna el estado de la transacción
	  */
	public function deleteActivityRol($activityId,$rolId)
	{

		$asistencia = $this->contenedor['tipoPersonaActividadDAO'];
		$resultado = $asistencia->deleteActividadTipoUsuario($activityId,$rolId);
		echo json_encode($resultado);
	}
	public function consultarExistenciaUsuario($identificacion)
	{
		$persona = $this->contenedor['personaDAO'];
		$existencia = $persona->consultarExistenciaUsuario($identificacion);
		echo json_encode($existencia);
	}
	public function consultaInformacionUsuario($identificacion)
	{
		$persona = $this->contenedor['personaDAO'];
		$informacion_usuario = $persona->consultarInformacionUsuario($identificacion);
		echo json_encode($informacion_usuario);
	}
	public function consultaInformacionUsuarioById($id)
	{
		$persona = $this->contenedor['personaDAO'];
		$informacion_usuario = $persona->consultarInformacionUsuarioById($id);
		echo json_encode($informacion_usuario);
	}
	public function getInfoUsuarioContratoById($id)
	{
		$persona = $this->contenedor['personaDAO'];
		$informacion_usuario = $persona->getInfoUsuarioContratoById($id);
		echo json_encode($informacion_usuario);
	}
	public function registrarUsuario($formulario,$contador_areas_organizaciones,$contador_programa)
	{
		$persona = $this->contenedor['personaDAO'];
		$persona_object = $this->contenedor['persona'];
		session_start();
		$id_usuario_registro = $_SESSION["session_username"];
		date_default_timezone_set('America/Bogota');
		$fecha=date("Y-m-d H:i:s");

		if ($contador_programa == 1) {
			$indice = 0;
			$inicio = 12;
		}
		if ($contador_programa == 2) {
			$indice = 1;
			$inicio = 13;
		}
		if ($contador_programa == 3) {
			$indice = 2;
			$inicio = 14;
		}
		
		$persona_object->setFkTipoPersona($formulario[$indice+1]['value']);
		$persona_object->setVcIdentificacion($formulario[$indice+2]['value']);
		$persona_object->setFkTipoIdentificacion($formulario[$indice+3]['value']);
		$persona_object->setVcPrimerNombre($formulario[$indice+4]['value']);
		$persona_object->setVcSegundoNombre($formulario[$indice+5]['value']);
		$persona_object->setVcPrimerApellido($formulario[$indice+6]['value']);
		$persona_object->setVcSegundoApellido($formulario[$indice+7]['value']);
		$persona_object->setDdFNacimiento($formulario[$indice+8]['value']);
		$persona_object->setFkIdGenero($formulario[$indice+9]['value']);
		$persona_object->setVcCelular($formulario[$indice+10]['value']);
		$persona_object->setVcCorreo($formulario[$indice+11]['value']);
		$persona_object->setVcCargo($formulario[$indice+12]['value']);
		$persona_object->setDaFechaRegistro($fecha);
		$persona_object->setIdUsuarioRegistro($id_usuario_registro);
		//Guarda los datos en TABLA PERSONA 2017
		$credenciales = $persona->registrarUsuario($persona_object);

		$limite = sizeof($formulario)-1;
		$areas = "";
		$organizaciones = "";
		$tipo_artista = "";
		for($i=$inicio+1;$i<$limite;$i=$i+3){
			$areas .= $formulario[$i]['value'].";";
			$organizaciones .= $formulario[$i+1]['value'].";";
			$tipo_artista .= $formulario[$i+2]['value'].";";
		}
		//Guarda las Areas y Organizaciones en tb_af_organizaciones_area_artistica.
		if($contador_areas_organizaciones > 0){
			$persona->registrarAreasOrganizaciones($areas, $organizaciones, $tipo_artista, $persona_object->getVcIdentificacion(), $persona_object->getDaFechaRegistro());
		}
		return $credenciales;
	}
	
	public function actualizarUsuario($formulario, $contador_areas_organizaciones, $id_persona, $contador_programa)
	{
		$persona = $this->contenedor['personaDAO'];
		$persona_object = $this->contenedor['persona'];
		session_start();
		$id_usuario_registro = $_SESSION["session_username"];

		if ($contador_programa == 1) {
			$indice = 0;
			$inicio = 12;
		}
		if ($contador_programa == 2) {
			$indice = 1;
			$inicio = 13;
		}
		if ($contador_programa == 3) {
			$indice = 2;
			$inicio = 14;
		}
		$persona_object->setPkIdPersona($id_persona);
		$persona_object->setFkTipoPersona($formulario[$indice+1]['value']);
		$persona_object->setVcIdentificacion($formulario[$indice+2]['value']);
		$persona_object->setFkTipoIdentificacion($formulario[$indice+3]['value']);
		$persona_object->setVcPrimerNombre($formulario[$indice+4]['value']);
		$persona_object->setVcSegundoNombre($formulario[$indice+5]['value']);
		$persona_object->setVcPrimerApellido($formulario[$indice+6]['value']);
		$persona_object->setVcSegundoApellido($formulario[$indice+7]['value']);
		$persona_object->setDdFNacimiento($formulario[$indice+8]['value']);
		$persona_object->setFkIdGenero($formulario[$indice+9]['value']);
		$persona_object->setVcCelular($formulario[$indice+10]['value']);
		$persona_object->setVcCorreo($formulario[$indice+11]['value']);
		$persona_object->setVcCargo($formulario[$indice+12]['value']);
		$persona_object->setIdUsuarioRegistro($id_usuario_registro);
		//Guarda los datos en TABLA PERSONA 2017
		$credenciales = $persona->actualizarUsuario($persona_object);
		
		$limite = sizeof($formulario)-1;
		$areas = "";
		$organizaciones = "";
		$tipo_artista = "";
		for($i=$inicio+1;$i<$limite;$i=$i+3){
			$areas .= $formulario[$i]['value'].";";
			$organizaciones .= $formulario[$i+1]['value'].";";
			$tipo_artista .= $formulario[$i+2]['value'].";";
		}
		// Actualiza las Areas y Organizaciones en tb_af_organizaciones_area_artistica.
		if($contador_areas_organizaciones > 0){
			$persona->desactivarAreasOrganizaciones($persona_object->getVcIdentificacion());
			$persona->registrarAreasOrganizaciones($areas, $organizaciones, $tipo_artista, $persona_object->getVcIdentificacion(), $persona_object->getDaFechaRegistro());
		}
		return $credenciales;
	}

	public function actualizarDatosPerfilUsuario($formulario)
	{
		$persona = $this->contenedor['personaDAO'];
		$persona_object = $this->contenedor['persona'];
		$persona_object->setFkTipoIdentificacion($formulario[1]['value']);
		$persona_object->setVcPrimerNombre($formulario[2]['value']);
		$persona_object->setVcSegundoNombre($formulario[3]['value']);
		$persona_object->setVcPrimerApellido($formulario[4]['value']);
		$persona_object->setVcSegundoApellido($formulario[5]['value']);
		$persona_object->setDdFNacimiento($formulario[6]['value']);
		$persona_object->setFkIdGenero($formulario[7]['value']);
		$persona_object->setVcCelular($formulario[8]['value']);
		$persona_object->setVcCorreo($formulario[9]['value']);
		$persona_object->setPkIdPersona($formulario[10]['value']);
		$persona_object->setTxFotoPerfil($formulario[11]['value']);
		$persona_object->setIdUsuarioRegistro($formulario[10]['value']);
		//Actualiza los datos en tb_persona_2017
		$result = $persona->actualizarDatosPerfilUsuario($persona_object);
		echo $result;
	}

	public function consultarAreasOrganizacionesPersona($id_persona)
	{
		$persona = $this->contenedor['personaDAO'];
		$persona_object = $this->contenedor['persona'];
		
		$persona_object->setPkIdPersona($id_persona);
		//Consulta las áreas y organizaciones que estén asociadas a una persona.
		$areas_organizaciones = $persona->consultarAreasOrganizaciones($persona_object);
		echo json_encode($areas_organizaciones);
	}

	public function verificaPasswordActual($id, $password)
	{
		$persona = $this->contenedor['personaDAO'];
		$rowCount = $persona->verificaPasswordActual($id, $password);
		echo $rowCount;
	}

	public function actualizarPassword($datos)
	{
		$persona = $this->contenedor['personaDAO'];
		$id_persona = $datos['id_persona'];
		$password = $datos['password'];
		$id_session = $datos['id_session'];
		$rowCount = $persona->actualizarPassword($password, $id_persona, $id_session);
		echo $rowCount;
	}

	public function crearActividad($datos,$id_usuario_web)
	{
		$MenuDAO = $this->contenedor['MenuDAO'];
		echo $MenuDAO->crearActividad($datos,$id_usuario_web);
	}

	public function desactivarActividad($id_actividad,$id_usuario_web)
	{
		$MenuDAO = $this->contenedor['MenuDAO'];
		echo $MenuDAO->desactivarActividad($id_actividad,$id_usuario_web);
	}

	public function actualizarActividad($datos,$id_usuario_web)
	{
		$MenuDAO = $this->contenedor['MenuDAO'];
		echo $MenuDAO->actualizarActividad($datos,$id_usuario_web);
	}

	public function getOptionActividadesActivas()
	{
		$return = "";
		$MenuDAO = $this->contenedor['MenuDAO'];
		$actividad = $MenuDAO->getOptionActividadesPorEstado("1,2");
		foreach ($actividad as $a) {
			$return .= "<option value='".$a["PK_Id_Actividad"]."'>".$a["VC_Nom_Actividad"]."</option>";
		}
		echo $return;
	}

	public function getOptionModulos()
	{
		$return = "";
		$MenuDAO = $this->contenedor['MenuDAO'];
		$modulo = $MenuDAO->getOptionModulosPorEstado(1);
		foreach ($modulo as $m) {
			$return .= "<option value='".$m["PK_Id_Modulo"]."'>".$m["VC_Nom_Modulo"]."</option>";
		}
		echo $return;
	}

	public function getOptionActividadesDeModulo($id_modulo)
	{
		$return = "";
		$MenuDAO = $this->contenedor['MenuDAO'];
		$actividad = $MenuDAO->getOptionActividadesDeModulo($id_modulo);
		foreach ($actividad as $a) {
			$return .= "<option value='".$a["PK_Id_Actividad"]."'>".$a["VC_Nom_Actividad"]."</option>";
		}
		echo $return;
	}

	public function consultarDatosActividad($id_actividad)
	{
		$MenuDAO = $this->contenedor['MenuDAO'];
		$actividad = $MenuDAO->consultarDatosActividad($id_actividad);
		echo json_encode($actividad);
	}

	public function consltarTablaUsuariosIndividualAsignadosActividad($id_actividad)
	{
		$return = "<tr><th>Identificacion</th><th>Nombre</th></tr>";
		$MenuDAO = $this->contenedor['MenuDAO'];
		$usuario = $MenuDAO->consultarUsuariosAsociadosIndividualActividad($id_actividad);
		foreach ($usuario as $u) {
			$return .= "<tr>";
			$return .= "<td>".$u['VC_Identificacion']."</td>";
			$return .= "<td>".$u['nombre']."</td>";
			$return .= "</tr>";
		}
		echo $return;
	}

	public function getServicioRol($rol)
	{

	}

	public function getUsuariosOrganizacion($datos)
	{
		$usuario = $this->contenedor['personaDAO'];
		$usuarios_organizacion = $usuario->consultarUsuariosOrganizacion($datos['organizacion']);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('usuarios_organizacion'=>$usuarios_organizacion, 'organizacion'=>$datos['organizacion']));
		$vista->renderHtml();
	}

	public function cambiarEstadoUsuario($datos)
	{
		$persona = $this->contenedor['personaDAO'];
		$estado = $datos['estado'];
		$id_usuario_administrador = $datos['id_usuario_administrador'];
		$justificacion = "Cambio de estado para iniciar sesión a ".$estado." por razón: ".$datos['justificacion'];
		$usuariosActualizados = $persona->actualizarEstado($estado, $datos['id_usuario'], $id_usuario_administrador);
		$observacionesRegistradas = $persona->registrarObservacionPersona($datos['id_usuario'], $justificacion, $id_usuario_administrador, date('Y-m-d H:i:s'));
		$rowCount= $usuariosActualizados+$observacionesRegistradas;
		echo $rowCount;
	}

	public function consultarOrganizacionesFormador($datos)
	{
		$persona = $this->contenedor['personaDAO'];
		$id_usuario = $datos['id_usuario'];
		$organizaciones = $persona->getOrganizacionesUsuario($id_usuario);
		echo json_encode($organizaciones);
	}

	public function actualizarPerfilFormador($datos)
	{
		$persona = $this->contenedor['personaDAO'];
		$id_registro = $datos['id_registro'];
		$perfil = $datos['perfil'];
		$rowCount = $persona->actualizarPerfilDeFormador($id_registro, $perfil);
		echo $rowCount;
	}

	public function getIdColegiosCrea($datos)
	{
		$ColegioDAO = $this->contenedor['ColegioDAO'];
		$colegio = $ColegioDAO->consultarColegiosDeCrea($datos['id_crea']);
		echo json_encode($colegio);
	}

	public function asociarColegioCrea($datos)
	{
		$ColegioDAO = $this->contenedor['ColegioDAO'];
		echo $ColegioDAO->asociarColegioCrea($datos['id_crea'], $datos['id_colegio'], $datos['id_usuario']);
	}
	public function eliminarColegioCrea($datos)
	{
		$ColegioDAO = $this->contenedor['ColegioDAO'];
		echo $ColegioDAO->eliminarColegioCrea($datos['id_crea'], $datos['id_colegio'], $datos['id_usuario']);
	}
	public function actualizarEstadoParametroDetalle($datos)
	{
		$parametro = $this->contenedor['ParametroDAO'];
		$estado = $datos['estado'];
		$programa = $datos['programa'];
		$id_parametro = $datos['id_parametro'];
		$parametroActualizado = $parametro->actualizarEstadoParametroDetalle($estado, $programa, $id_parametro);
		$rowCount= $parametroActualizado;
		echo $rowCount;
	}
	public function saveNuevoParametro($datos)
	{
		$parametro = $this->contenedor['ParametroDAO'];
		echo $parametro->saveNuevoParametro($datos['parametro']);
	}
	public function crearParametroDetalle($datos)
	{
		$parametro_detalle = $this->contenedor['ParametroDAO'];
		$id_parametro = $datos['id_parametro'];
		$nombre_parametro_detalle = $datos['nombre_parametro_detalle'];
		$valor_parametro_detalle = $datos['valor_parametro_detalle'];
		$estado_crea = $datos['estado_crea'];
		$estado_nidos = $datos['estado_nidos'];
		echo $parametro_detalle->saveNuevoParametroDetalle($id_parametro,$nombre_parametro_detalle,$valor_parametro_detalle,$estado_crea,$estado_nidos);
	}

	public function consultarFormAdministrarDiasSubsanacion()
	{
		$ParametroDAO = $this->contenedor['ParametroDAO'];
		$dias_subsanacion = $ParametroDAO->getParametroDetalle(44);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('dias_subsanacion'=>$dias_subsanacion));

		$vista->renderHtml();
	}

	public function guardarNuevosDiasSubsanacion($datos)
	{
		$datos['id_parametro'] = 44;
		$ParametroDAO = $this->contenedor['ParametroDAO'];
		echo $ParametroDAO->guardarNuevosDiasSubsanacion($datos);
	}

	public function SubirFirmaUsuario($datos){
		$persona = $this->contenedor['personaDAO'];
		$persona_object = $this->contenedor['persona'];
		$persona_object->setPkIdPersona($datos['tx_id_persona']);                          
		$persona_object->setTxFirmaEscaneada($datos['tx_firma']);     
		echo $persona->subirFirmaUsuario($persona_object);
	}

	public function infoCompletaUsuarios(){
		$personaDAO = $this->contenedor['personaDAO'];
		$datos = $personaDAO->infoCompletaUsuarios();
		echo json_encode($datos[0]);
	}
}
$objControlador = new AdministracionController();
//Llamar metodo de clase Forma 1

if(isset($_POST['funcion']) && $_POST['funcion']==='addAdjuntosSoporte')
{
	//echo '<pre>'.print_r($GLOBALS,true).'</pre>';

}
unset($objControlador);