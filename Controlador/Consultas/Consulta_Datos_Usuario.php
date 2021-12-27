<?php
header ('Content-type: text/html; charset=utf-8');

include_once('../../Modelo/Administracion/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.

$id_persona = $_POST["id_persona"];

/**
* almacena la informacion de los clanes almacenados en la Base de Datos.
*/
$respuesta = getDatosPerfil($id_persona);


$vector = array();
foreach ($respuesta as $array) {
	$vector[]= $array;
}
echo json_encode($vector);

?>