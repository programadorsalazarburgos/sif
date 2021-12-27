<?php
header ('Content-type: text/html; charset=utf-8');

include_once('../../../Modelo/Administrativo/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.

/**
* El NIT la organización enviado por post mediante ajax con la clave "TXT_NIT"
*/
 $id_organizacion=$_POST["id_organizacion"];

	if ($id_organizacion == "") {
 		$id_organizacion = "NULL";
 	}

/**
* Almacena la informacion de la propuesta almacenada en la Base de Datos.
*/
$respuesta = Convocatoria::consultarInfoOrganizacion($id_organizacion);

$vector = array();
foreach ($respuesta as $array) {
	$vector[]= $array;
}
echo json_encode($vector);

?>