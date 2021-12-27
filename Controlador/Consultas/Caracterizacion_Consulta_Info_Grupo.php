<?php
header ('Content-type: text/html; charset=utf-8');

include_once('../../Modelo/Territorial/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.

$codigo_grupo = $_POST["codigo_grupo"];
$tipo_grupo = $_POST["tipo_grupo"];

/**
* almacena la informacion de los clanes almacenados en la Base de Datos.
*/
$respuesta = getInformacionGrupo($codigo_grupo, $tipo_grupo);

$vector = array();
foreach ($respuesta as $array) {
	$vector[]= $array;
}
echo json_encode($vector);

?>