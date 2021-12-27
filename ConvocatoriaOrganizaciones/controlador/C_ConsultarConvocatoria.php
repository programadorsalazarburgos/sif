<?php
header ('Content-type: text/html; charset=utf-8');

include_once('../modelo/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.
session_start();
/**
* El identificador de la convocatoria enviado por post mediante ajax con la clave "TXT_NIT"
*/
 $convocatoria=$_POST['convocatoria'];

/**
* Almacena la informacion de la propuesta almacenada en la Base de Datos.
*/
$respuesta = Convocatoria::obtenerConvocatoria($convocatoria);

$vector = array();
foreach ($respuesta as $array) {
	$vector[]= $array;
}
echo json_encode($vector);

?>