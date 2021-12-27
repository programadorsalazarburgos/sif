<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/Administracion/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'getRoles':
				echo getRoles();
				break;
			case 'getActividadesRol':
				echo getActividadesRol();
				break;
			default:
				echo "opcion no valida: (".$_POST['id_modulo'].")";
				break;
		}
	}
	/***************************************************************************
	/* getRoles() trae los roles que existen.
	***************************************************************************/
	function getRoles(){
		return json_encode(getTiposUsuarioData());
	}
	/***************************************************************************
	/* getActividadesRol() trae las actividades de un rol
	***************************************************************************/
	function getActividadesRol(){
		$idRol = $_POST['idRol'];
		return json_encode($getActividadesRol());
	}
?>