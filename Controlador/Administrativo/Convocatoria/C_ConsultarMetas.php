<?php
header ('Content-type: text/html; charset=utf-8');

include_once('../../../Modelo/Administrativo/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.

/**
* El NIT la organización enviado por post mediante ajax con la clave "TXT_NIT"
*/
 $id_proyecto=$_POST["id_proyecto"];

	if ($id_proyecto == "") {
 		$id_proyecto = "NULL";
 	}

/**
* Almacena la informacion de la propuesta almacenada en la Base de Datos.
*/
$respuesta = Convocatoria::consultarMetas($id_proyecto);

$vector = array();
foreach ($respuesta as $array) {
	$vector[]= $array;
}
echo json_encode($vector);

?>