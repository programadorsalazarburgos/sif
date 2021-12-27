<?php

namespace Administracion\Controlador;

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";



class NotificacionController extends AdministracionFactory
{ 
	/**
	 * @var Container
	 *
	 */
	//// private /*static*/ $contenedor;
	private $mailerLiteKey='5cd045be32c9c39ae520b82442dd250b';

	function __construct()
	{

		parent::__construct();
		$this->initializeFactory();
		$this->prepareParameters($_POST,$_FILES);
	}

	public function getAllNotifications($idUsuario){
		$notificacionDAO=$this->contenedor['NotificacionDAO'];
		$notifications = $notificacionDAO->getAllNotificationsData($idUsuario);
		echo json_encode($notifications); 
	} 	
	public function setNotificationUser($idUsuario,$notificationId){
		$notificacionDAO=$this->contenedor['NotificacionDAO'];
		$return = $notificacionDAO->setNotificationUserView($idUsuario,$notificationId);
		echo json_encode($return);
	}	

	public function getNotificacionesData($idUsuario){    
		$notificacionDAO=$this->contenedor['NotificacionDAO'];
		$return = $notificacionDAO->getNotificacionesData($idUsuario);		
		echo json_encode($return);		
	}

	public function setNotificacionesLeidas($idUsuario){    
		$notificacionDAO=$this->contenedor['NotificacionDAO'];
		$return = $notificacionDAO->setNotificacionesLeidas($idUsuario);		
		echo json_encode($return);		
	}

	public function saveNotificationUser($notificacion,$userId,$email){
		$tbNotificacion=$this->contenedor['Notificacion'];
		$tbNotificacion->setVariables($notificacion);		
		$notificacionDAO=$this->contenedor['NotificacionDAO'];
		/*if ($email == true) {
			$tbPersona2017 = $this->contenedor['tbPersona2017'];
			$tbPersona2017->setPkIdPersona($userId);
			$tbPersonaDAO = $this->contenedor['tbPersonaDAO'];
			$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
			$correo = $datosPersona["correo"];
		    $this->sendNotificationEmail($correo,$notificacion["vc_contenido"],isset($notificacion["titulo"]) ? $notificacion["titulo"] : "Notificación SIF");
		}*/
		echo $notificacionDAO->saveNotificationUserData($tbNotificacion,$userId);    

	}

	public function saveNotificationRole($notificacion,$roleId,$email){ 

		$tbNotificacion=$this->contenedor['Notificacion'];
		$tbNotificacion->setVariables($notificacion); 
		$notificacionDAO=$this->contenedor['NotificacionDAO'];
		echo $notificacionDAO->saveNotificationRoleData($tbNotificacion,$roleId);
		/*if($email==1){
			$mailerliteClient = new MailerLite($mailerLiteKey);
			$campaignsApi = $mailerliteClient->campaigns();
			$campaignData = [
			  'subject' => 'Regular Campaign Subject',
			  'type' => 'regular',
			  'groups' => [2984475, 3237221]
			];

			$campaign = $campaignsApi->create($campaignData); // returns created $campaign object			
		}*/
	}

	public function getGroupsNotification($idNotificacion){
		$notificacionDAO=$this->contenedor['NotificacionDAO'];
		$notificaciones = $notificacionDAO->getNotificacionAnexo($idNotificacion);
		// print_r($notificaciones);
		if (sizeof($notificaciones) > 0)
			$notificacion = $notificaciones[sizeof($notificaciones)-1];
		else
			$notificacion = null;
		$lineaAtencion = explode("-",explode(",", $notificacion['TX_Datos_Extra'])[0])[0];
		$gruposArray = str_replace($lineaAtencion."-","",$notificacion['TX_Datos_Extra']);
		if ($lineaAtencion == 'EC') {
			$linea="Emprende Clan";
			$grupos = $notificacionDAO->getGruposEmprendeClan($gruposArray);
			foreach ($grupos as $key => $value) {
				$grupos[$key]['PK_Grupo'] = "EC-".$value['PK_Grupo'];
				$grupos[$key]['Horario'] = $this->getHorarioGrupoEmprendeClan($value['PK_Grupo']);
			}
		}else if ($lineaAtencion == 'AE') {
			$linea="Arte en la Escuela";
			$grupos = $notificacionDAO->getGruposArteEscuela($gruposArray);
			foreach ($grupos as $key => $value) {
				$grupos[$key]['PK_Grupo'] = "AE-".$value['PK_Grupo'];
				$grupos[$key]['Horario'] = $this->getHorarioGrupoArteEscuela($value['PK_Grupo']);
			}
		}
		$grupos['linea']=$linea;
		$grupos['fecha']=$notificacion['DT_Fecha'];
		echo json_encode($grupos);
	} 	

	public function getHorarioGrupoArteEscuela($id_grupo){
		$notificacionDAO=$this->contenedor['NotificacionDAO'];
		$return = "";
		$dia_semana = ["","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
		$horario_grupo = $notificacionDAO->consultarHorarioGrupoArteEscuela($id_grupo);
		foreach ($horario_grupo as $h) {
			$return .= $dia_semana[$h['IN_dia']]." (".$h['TI_hora_inicio_clase']." a ".$h['TI_hora_fin_clase'].").<br>";
		}
		return $return; 
	}

	public function getHorarioGrupoEmprendeClan($id_grupo){
		$notificacionDAO=$this->contenedor['NotificacionDAO'];
		$return = "";
		$dia_semana = ["","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
		$horario_grupo = $notificacionDAO->consultarHorarioGrupoEmprendeClan($id_grupo);
		foreach ($horario_grupo as $h) {
			$return .= $dia_semana[$h['IN_dia']]." (".$h['TI_hora_inicio_clase']." a ".$h['TI_hora_fin_clase'].").<br>";
		}
		return $return; 
	}

	public function getDate(){
		date_default_timezone_set('America/Bogota');
		echo  date('Y-m-d H:i:s');
	}		
}

$objControlador = new NotificacionController(); 
//Llamar metodo de clase Forma 1

unset($objControlador);
