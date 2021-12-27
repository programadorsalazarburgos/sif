<?php
//header ('Content-type: text/html; charset=utf-8');
if (file_exists('../Modelo/Administracion/Acceso_Datos.php')) {
	include_once('../Modelo/Administracion/Acceso_Datos.php');
}
else {
	include_once('../../Modelo/Administracion/Acceso_Datos.php');
}
if (isset($_GET['opcion'])){
	switch ($_GET['opcion']) {
		case 'cargar_modulos_menu':
		echo cargarModulos($_GET['id_usuario']);
		break;
		default:
		echo "opcion invalida(".$_GET['opcion'].")";
		break;
	}
}
else{
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'getNotifiaciones':
			echo getNotifiaciones($_POST['idUsuario']);
			break;
			case 'setNotificationUser':
			echo setNotificationUser($_POST['idUsuario'],$_POST['notificationId']);
			break;
			case 'getNombreUsuario':
			echo getNombreUsuario($_POST['idUsuario']);
			break;
			default:
			echo "opcion invalida(".$_POST['opcion'].")";
			break;
		}
	}
} 

/***************************************************************************
/* cargarModulos() carga los modulos a los cuales tiene permiso el usuario que ha iniciado session.
***************************************************************************/
function cargarModulos($id_usuario){
	$modulo = getModulosUsuario($id_usuario);
	$return = "";
	foreach ($modulo as $m) {
		$return .= "<li><a href='#' title='Módulo: ".$m['VC_Nom_Modulo']."' class='moduloMenu'><span class='glyphicon glyphicon-".$m['VC_Icono']."' aria-hidden='true'> </span>".$m['VC_Nom_Modulo']."<i class='fas fa-angle-right flota-der'></i></a>".cargarActividadesModulo($id_usuario,$m['PK_Id_Modulo'])."</li>";
	}
	return $return;
}

/***************************************************************************
/* cargarActividadesModulo() carga las actividades de un  modulo a las cuales tiene permiso el usuario que ha iniciado session.
***************************************************************************/
function cargarActividadesModulo($id_usuario,$id_modulo){
	$actividad = getActividadesUsuarioModulo($id_usuario,$id_modulo);
	$return = "<ul class='nav nav-second-level'>";
	foreach ($actividad as $a) {
		$return .= "<li><a href='".$a['VC_Page']."' target='ventana_iframe' title='Actividad: ".$a['VC_Nom_Actividad']."' class='actividadMenu'>".$a['VC_Nom_Actividad']."</a></li>";
	}
	$return .= "</ul>";
	return $return;
}
/***************************************************************************
/* getNotifiaciones() carga las actividades de un  modulo a las cuales tiene permiso el usuario que ha iniciado session.
***************************************************************************/
function getNotifiaciones($idUsuario){
	$return = getNotifiacionesData($idUsuario);
	return json_encode($return);
	// return "return";
}
/***************************************************************************
/* setNotificationUser() actualiza el estado de una notificacion de un usuario
***************************************************************************/
function setNotificationUser($idUsuario,$notificationId){
	$return = setNotificationUserView($idUsuario,$notificationId);
	return json_encode($return);
	// return "return";
}
/***************************************************************************
/* getNombreUsuario() consulta el Nombre del Usuario que está Logueado.
***************************************************************************/
function getNombreUsuario($idUsuario){
	$return = getNombreDeUsuario($idUsuario);
	return json_encode($return);
	// return "return";
}
?>