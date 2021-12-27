<?php

namespace Administracion\Controlador;

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";

use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\AuditoriaDAO;
use General\Persistencia\DAOS\BeneficiarioDAO;
use General\Persistencia\Entidades\TbAuditoria;
use General\Persistencia\Entidades\TbLogLogin;  
use General\Vista\Vista;
class AuditoriaController extends ControladorBase
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
		$this->contenedor['AuditoriaDAO'] = function ($c) {
		    return new AuditoriaDAO();
		};
		$this->contenedor['BeneficiarioDAO'] = function ($c) {
		    return new BeneficiarioDAO();
		};		
		$this->contenedor['TbAuditoria'] = function ($c) {
		    return new TbAuditoria();
		};
		$this->contenedor['logLogin'] = function ($c) {
		    return new TbLogLogin();
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

  public function consultarUsuariosQueTienenLogLogin(){
    $AuditoriaDAO = $this->contenedor['AuditoriaDAO'];
    $resultado = $AuditoriaDAO->consultarUsuariosQueTienenLogLogin();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('usuario'=>$resultado));
		$vista->setPlantilla('getOptionUsuarios');
		$vista->renderHtml();
  }

	public function consultarTablaLogLoginUsuario($datos){
		$AuditoriaDAO = $this->contenedor['AuditoriaDAO'];
    	$resultado = $AuditoriaDAO->consultarLogLoginUsuario($datos);
		$vista= $this->contenedor['vista'];
		//$vista->setVariables(array('log_login'=>$resultado));
		//$vista->setPlantilla('tableLogLogin');
		$vista->setVariables(array('datos'=>$resultado,'idTabla'=>"table_log_login"));
		$vista->setNamespace('ConsultasReportes');      
		$vista->setPlantilla('pintarDatatableGeneral');		
		$vista->renderHtml();
	}

 	public function consultarAuditoria($datos,$tabla,$idTabla)
 	{
	    $TbAuditoria = $this->contenedor['TbAuditoria'];
	    $AuditoriaDAO = $this->contenedor['AuditoriaDAO'];
	    $TbAuditoria->setTipo($tabla);
		$TbAuditoria->SetPkRegistro($datos['id_registro']);
		$TbAuditoria->setFecha($datos['mes_anio']);
	  	$resultado = $AuditoriaDAO->consultarTablaAuditoria($TbAuditoria);
		$vista= $this->contenedor['vista'];
		//$vista->setVariables(array('objeto'=>$resultado));
		//$vista->setPlantilla('tableLogObject');
		$vista->setVariables(array('datos'=>$resultado,'idTabla'=>$idTabla));
		$vista->setNamespace('ConsultasReportes');      
		$vista->setPlantilla('pintarDatatableGeneral');				
		$vista->renderHtml();
 	}

 	public function consultarTablaEstudiante($texto){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$estudiante = $BeneficiarioDAO->consultarEstudianteEnTbEstudiante($texto);
		$vista = $this->contenedor['vista'];
		/*$vista->setNamespace('GestionClan');
		$vista->setPlantilla('tableEstudiantesBase');
		$vista->setVariables(array('estudiante'=>$estudiante,'tipo_mostrar'=>'consultar_para_auditoria'));*/
		$vista->setVariables(array('datos'=>$estudiante,'idTabla'=>'table_estudiante'));
		$vista->setNamespace('ConsultasReportes');      
		$vista->setPlantilla('pintarDatatableGeneral');			
		$vista->renderHtml();
	} 

	public function guardarClickUsuario($datos)    
	{ 
		$fechaHora=date('Y-m-d H:i:s');
		$url=substr($datos['url'], strrpos($datos['url'],"/")+1);
		$auditoriaDAO = $this->contenedor['AuditoriaDAO']; 
		$logLogin=$this->contenedor['logLogin'];
		session_start();
		$_SESSION["clicks"][]=array("url"=>$url,"fecha"=>$fechaHora);
		$logLogin->setFkPersona($datos['usuario']);
		$logLogin->setTxUrl(json_encode($_SESSION["clicks"]));
		$logLogin->	setId($_SESSION['session_logLogin']);
		//var_dump($logLogin);
		echo $auditoriaDAO->agregarClickUsuario($logLogin);

		//$historicoClicks=$auditoriaDAO->obtenerHistorialClicks($logLogin);

		//$resultado = $auditoriaDAO->guardarClickUsuario($logLogin);	
		//echo $json;
		/*$vista= $this->contenedor['vista'];
		$vista->setVariables(array('clanes'=>$clanes));
		$vista->renderHtml();*/
	}	
}
$objControlador = new AuditoriaController();

unset($objControlador);
