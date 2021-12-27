<?php
header ('Content-type: text/html; charset=utf-8');

include_once('../../Modelo/ConsultasReportes/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.

/**
* almacena la informacion de las atenciones de los clanes almacenados en la Base de Datos.
*/
$respuesta = getAtencionClanes();

$vector = array();
foreach ($respuesta as $array) {
	$vector[]= $array;
}
echo json_encode($vector);

?>