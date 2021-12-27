<?php
header ('Content-type: text/html; charset=utf-8');
include_once('../../Modelo/Administracion/Acceso_Datos.php');
if (isset($_POST['opcion'])){
	switch ($_POST['opcion']) {
		case 'getTiposUsuario':
		echo getTiposUsuario();
		break;
		default:
		echo "opcion no valida: (".$_POST['opcion'].")";
		break;
	}
}
/***************************************************************************
/* getTiposUsuario() retorna la lista de todos los tipos de usuario existentes
***************************************************************************/
function getTiposUsuario(){
	$tiposUsuario = getTiposUsuarioData();
	return json_encode($tiposUsuario);
}
?>