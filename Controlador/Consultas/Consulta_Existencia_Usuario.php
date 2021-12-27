<?php
header ('Content-type: text/html; charset=utf-8');

include_once('../../Modelo/Administracion/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.

$identificacion = $_POST["identificacion"];

/**
* Consulta si un usuario ya existe en la Base de Datos.
*/
$respuesta = getExistenciaUsuario($identificacion);


$vector = array();
foreach ($respuesta as $array) {
	$vector[]= $array;
}
echo json_encode($vector);

?>