<?php
header ('Content-type: text/html; charset=utf-8');
include_once('../../Modelo/Administracion/Acceso_Datos.php');
if (isset($_POST['opcion'])){
	switch ($_POST['opcion']) {
		case 'getAllNotifications':
		echo getAllNotifications($_POST['idUsuario']);
		break;
		case 'setNotificationUser':
		echo setNotificationUser($_POST['idUsuario'],$_POST['notificationId']);
		break;
		case 'saveNotificationUser':
		echo saveNotificationUser($_POST['VC_Url'],$_POST['VC_Icon'],$_POST['VC_Contenido'],$_POST['userId']);
		break;
		case 'saveNotificationRole':
		echo saveNotificationRole($_POST['VC_Url'],$_POST['VC_Icon'],$_POST['VC_Contenido'],$_POST['roleId']);
		break;
		case 'getDate':
		echo getDates();
		break;
		case 'getGroupsNotification':
		echo getGroupsNotification($_POST['idNotificacion']);
		break;
		default:
		echo "opcion no valida: (".$_POST['opcion'].")";
		break;
	}
}
/***************************************************************************
/* setPermisosActividad() modifica el permiso de acceso a una actividad para un usuario especifico.
***************************************************************************/
function getAllNotifications($idUsuario){
	$notifications = getAllNotificationsData($idUsuario);
	return json_encode($notifications);
}

/***************************************************************************
/* setNotificationUser() cambia el estado de una notificacion a vista.
***************************************************************************/
function setNotificationUser($idUsuario,$notificationId){
	$return = setNotificationUserView($idUsuario,$notificationId);
	return json_encode($return);
}
/***************************************************************************
/* saveNotificationUser() guardar una notificacion  de acuerdo a un usuario
***************************************************************************/
function saveNotificationUser($url,$icon,$contenido,$userId){
	$return = saveNotificationUserData($url,$icon,$contenido,$userId);
	return $return;
}
/***************************************************************************
/* saveNotificationUser() guardar una notificacion de acuerdo a un rol
***************************************************************************/
function saveNotificationRole($url,$icon,$contenido,$roleId){
	$return = saveNotificationRoleData($url,$icon,$contenido,$roleId);
	return $return;
}
/***************************************************************************
/* 	getDate() retorna la fecha
***************************************************************************/
function getDates(){
	date_default_timezone_set('America/Bogota');
	$return = date('Y-m-d H:i:s');
	return $return;
}
/***************************************************************************
/*  getGroupsNotification(getGroupsNotification) retorna la informacion de 
*	los grupos que se encuentran en anexos de una notificacion
***************************************************************************/
function getGroupsNotification($idNotificacion){
	$notificaciones = getNotificacionAnexo($idNotificacion);
	// print_r($notificaciones);
	if (sizeof($notificaciones) > 0)
		$notificacion = $notificaciones[sizeof($notificaciones)-1];
	else
		$notificacion = null;
	$lineaAtencion = explode("-",explode(",", $notificacion['TX_Datos_Extra'])[0])[0];
	$gruposArray = str_replace($lineaAtencion."-","",$notificacion['TX_Datos_Extra']);
	if ($lineaAtencion == 'EC') {
		$linea="Emprende Clan";
		$grupos = getGruposEmprendeClan($gruposArray);
		foreach ($grupos as $key => $value) {
			$grupos[$key]['PK_Grupo'] = "EC-".$value['PK_Grupo'];
			$grupos[$key]['Horario'] = getHorarioGrupoEmprendeClan($value['PK_Grupo']);
		}
	}else if ($lineaAtencion == 'AE') {
		$linea="Arte en la Escuela";
		$grupos = getGruposArteEscuela($gruposArray);
		foreach ($grupos as $key => $value) {
			$grupos[$key]['PK_Grupo'] = "AE-".$value['PK_Grupo'];
			$grupos[$key]['Horario'] = getHorarioGrupoArteEscuela($value['PK_Grupo']);
		}
	}
	$grupos['linea']=$linea;
	$grupos['fecha']=$notificacion['DT_Fecha'];
	return json_encode($grupos);
}
/***************************************************************************
/* getHorarioGrupoArteEscuela() consulta el horario de un grupo de arte en la escuela.
***************************************************************************/
function getHorarioGrupoArteEscuela($id_grupo){
	$return = "";
	$dia_semana = ["","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
	$horario_grupo = consultarHorarioGrupoArteEscuela($id_grupo);
	foreach ($horario_grupo as $h) {
		$return .= $dia_semana[$h['IN_dia']]." (".$h['TI_hora_inicio_clase']." a ".$h['TI_hora_fin_clase'].").<br>";
	}
	return $return;
}

/***************************************************************************
/* getHorarioGrupoEmprendeClan() consulta el (los) día(s) de clases que están habilitados en el sistema para las clases.
***************************************************************************/
function getHorarioGrupoEmprendeClan($id_grupo){
	$return = "";
	$dia_semana = ["","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
	$horario_grupo = consultarHorarioGrupoEmprendeClan($id_grupo);
	foreach ($horario_grupo as $h) {
		$return .= $dia_semana[$h['IN_dia']]." (".$h['TI_hora_inicio_clase']." a ".$h['TI_hora_fin_clase'].").<br>";
	}
	return $return;
}

?>