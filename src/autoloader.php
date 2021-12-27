<?php
define('BASEPATH', str_replace('\\', '/', __DIR__));
defined('BASEPATH') OR exit('No direct script access allowed');
//Autoloader cambia el nombre de clase con namespace Modelo\Conexion\ConexionBD() a Modelo/Conexion/ConexionBD.php
function create_load($class) {
	//$class = str_replace("\\", "/", $class);
	$routes = array(
		"/",
		"/General/",
		"/General/Controlador/",
		"/SeguimientoContratistas/Controlador/",
		"/SeguimientoContratistas/Persistencia/DAOS/",
		"/ArtistaFormador/Controlador/",
		"/Circulacion/Controlador/",
		"/Beneficiario/Controlador/",
		"/GestionClan/Controlador/",
		"/Organizaciones/Controlador/",
		"/PedagogicoCREA/Controlador/",
		"/General/Persistencia/DAOS/",
		"/Psicosocial/Controlador/",
		"/Infraestructura/Controlador/",
		"/AtencionesVirtuales/Controlador/",
	);
	try {
		foreach ($routes as $route) {
			$file = BASEPATH.$route."{$class}.php";
			if (file_exists($file)) {
				require_once $file;
				break;
			}
		}
/*		if (file_exists($file)) {
			require_once $file;
		} else {
			$file = BASEPATH."/General/Controlador/{$class}.php";
			if (file_exists($file)) {
				require_once $file;
			} else {
				$file = BASEPATH."/SeguimientoContratistas/Controlador/{$class}.php";
				if (file_exists($file)) {
					require_once $file;
				} else {
					throw new Exception("Requested Class file not found in the given path.");
				}
			}
		}*/
	}
	catch(Exception $e) {
		echo $e->getMessage();
	}
}
spl_autoload_register('create_load', TRUE);
require_once ('Routes.php');
