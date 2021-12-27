<?php
header ('Content-type: text/html; charset=utf-8');

include_once('../modelo/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.
session_start();
/**
* El NIT la organización enviado por post mediante ajax con la clave "TXT_NIT"
*/
 $id_usuario=$_SESSION['id_usuario'];

/**
* Almacena la informacion de la propuesta almacenada en la Base de Datos.
*/
$respuesta = Convocatoria::obtenerBanderas($id_usuario);

$vector = array();
foreach ($respuesta as $array) {
	$vector[]= $array;
}
echo json_encode($vector);

?>