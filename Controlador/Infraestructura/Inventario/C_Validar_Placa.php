<?php
//header ('Content-type: text/html; charset=utf-8');

include_once('../../../Modelo/Infraestructura/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.

$id = $_POST['id'];
if ($id == "") {
	$id = NULL;
}
$placas_encontradas = [];
$placa = $_POST['placa'];
$cantidad_placas = count($placa);
for ($i=0; $i < $cantidad_placas; $i++) { 
	if ($placa[$i] != "S/P") {
		$respuesta = Inventario::validarPlaca($placa[$i],$id);
		if ($respuesta > 0) {
			$placas_encontradas[$i] = $placa[$i];
		}
	}
}

echo json_encode($placas_encontradas);
//echo json_encode($vector);

?>