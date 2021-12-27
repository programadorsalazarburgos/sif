<?php
header ('Content-type: text/html; charset=utf-8');

include_once('../../Modelo/Administracion/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.

$identificacion = $_POST["identificacion"];

/**
* almacena la informacion de los clanes almacenados en la Base de Datos.
*/
$respuesta = getExistenciaEstudiante($identificacion);


$vector = array();
foreach ($respuesta as $array) {
	$vector[]= $array;
}
echo json_encode($vector);

?>