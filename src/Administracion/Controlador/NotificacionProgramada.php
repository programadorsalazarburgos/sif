<?php

namespace Administracion\Controlador;

if(!isset($_SERVER['SHELL'])){
	$salida="\n\nIntento de Ejecución HTTP: ".getDates()."\nipEjecuta:".obtenerIP()."\n";  
	//$salida.= "IpServidor: ".$_SERVER['SERVER_ADDR'];
	$IpServidor = gethostbyname(gethostname());
	$salida.="IpServidor: ".$IpServidor;	
	$myfile = fopen("../../../log-notificacion.txt", "a+") or die("Unable to open file!");
	fwrite($myfile,$salida);
	fclose($myfile); 
	die("Termina Ejecución"); 
} 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";

use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\TbNotificacionDAO;
use General\Persistencia\Entidades\TbNotificacion;
class NotificacionProgramada extends ControladorBase
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
		$this->contenedor['TbNotificacionDAO'] = function ($c) {
		    return new TbNotificacionDAO();
		};
		$this->contenedor['TbNotificacion'] = function ($c) {
		    return new TbNotificacion();
		};	 
		$this->ejecutarProcedimiento();   
 	}

 	private function ejecutarProcedimiento(){
 		$notificacionDAO = $this->contenedor['TbNotificacionDAO'];
 		$resultado= $notificacionDAO->ejecutarProcedimiento(); 
 		//echo print_r($resultado,true);
		$myfile = fopen("../../../log-notificacion.txt", "a+") or die("Unable to open file!"); 
		fwrite($myfile,"\n\nEjecución desde SHELL: ".getDates()."\nresultado"); 
		fclose($myfile);   		
 	}

 

}

$objControlador = new NotificacionProgramada(); 
//Llamar metodo de clase Forma 1

unset($objControlador);


function obtenerIP() {

    //si utilizamos un CDN, por ejemplo Cloudflare, genera un header con la IP real del cliente que se conecta
  if( isset($_SERVER['HTTP_CF_CONNECTING_IP']) )
    return $_SERVER['HTTP_CF_CONNECTING_IP'];

    //dependiendo de la configuración de proxys o apache o nginx tenemos varias variables de servidor que PHP recibe. Al final del artículo hay una lista de posibles variables

  if( isset($_SERVER['HTTP_CLIENT_IP']) ) 
    return $_SERVER['HTTP_CLIENT_IP'];

  if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )
    return $_SERVER['HTTP_X_FORWARDED_FOR'];

  if( isset($_SERVER['<variable seteada por server>']) )
    return $_SERVER['<variable seteada por server>'];

    //ultimo recurso, lo que envía el navegador 
  if( isset($_SERVER['REMOTE_ADDR']) ) 
    return $_SERVER['REMOTE_ADDR']; 

    //no hay nada definido
  return null; 
} 

function getDates(){
	date_default_timezone_set('America/Bogota');
	$return = date('Y-m-d H:i:s');
	return $return;
}