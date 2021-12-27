<?php

namespace Administracion\Controlador;

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";

use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\AparienciaDAO;
use General\Persistencia\Entidades\TbApariencia;
use General\Vista\Vista;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
use ReCaptcha\ReCaptcha;  
class AparienciaController extends ControladorBase
{ 
	/**
	 * @var Container
	 *
	 */
	//// private /*static*/ $contenedor;

	function __construct()
	{

		parent::__construct();
		$this->contenedor=$this->getContenedor();
		$this->contenedor['AparienciaDAO'] = function ($c) {
			return new AparienciaDAO();
		};
		$this->contenedor['TbApariencia'] = function ($c) {
			return new TbApariencia(); 
		};	

		$variables=array();
		$this->contenedor['vista'] = function ($c) use ($variables) {
			return new Vista($variables);
		};

		if(isset($_POST['p1'])) $this->p1=$_POST['p1']; else $this->p1=null;
		if(isset($_POST['p2'])) $this->p2=$_POST['p2']; else $this->p2=null;
		if(isset($_POST['p3'])) $this->p3=$_POST['p3']; else $this->p3=null;
		if(isset($_POST['p4'])) $this->p4=$_POST['p4']; else $this->p4=null;
		if(isset($_POST['p5'])) $this->p5=$_POST['p5']; else $this->p5=null;
		if(isset($_FILES) && sizeof($_FILES)>0) {
			if($this->p1===null) {
				$this->p1=$_POST;
				unset($this->p1["funcion"]);
			}
			$this->p2=$_FILES;
		}

		$this->{$_POST["funcion"]}($this->p1,$this->p2,$this->p3,$this->p4,$this->p5);
	}

	public function getApariencia($rol)
	{
		$apariencia = $this->contenedor['TbApariencia'];
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		$apariencia->setFkIdParametro($rol);
		$resultado = $aparienciaDAO->consultarObjeto($apariencia);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('apariencia'=>$resultado));
		$vista->renderHtml();	
	}

	public function getModulosRol($id_usuario)
	{
		$apariencia = $this->contenedor['TbApariencia'];
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		$apariencia->setFkIdParametro($id_usuario);
		$resultado = $aparienciaDAO->getModulosRol($apariencia);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('modulos'=>$resultado));
		$vista->renderHtml(); 		
	}

	public function getActividadesModuloUsuario($id_usuario,$id_modulo)
	{
		$apariencia = $this->contenedor['TbApariencia'];
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		$apariencia->setFkIdParametro($id_usuario);
		$apariencia->setId($id_modulo);
		$resultado = $aparienciaDAO->getActividadesModuloUsuario($apariencia);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('actividades'=>$resultado));
		$vista->renderHtml(); 	 		
	}
	public function getMenu($id_usuario){
		$apariencia = $this->contenedor['TbApariencia'];
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		$apariencia->setFkIdParametro($id_usuario);
		$resultado = $aparienciaDAO->getMenu($apariencia);
		$vista= $this->contenedor['vista']; 
		$vista->setVariables(array('menu'=>$resultado));
		$vista->renderHtml(); 	 
	} 

	public function getDatosPorNombre($username)	
	{
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		echo json_encode($aparienciaDAO->getDatosPorNombre($username)[0]);
	}
	public function enviarCorreoToken($email,$id)
	{
		$token = $this->generarToken($id);
		$body= '<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="format-detection" content="telephone=no"> <title>Respmail is a response HTML email designed to work on all major email platforms and smartphones</title><style type="text/css">body, #bodyTable, #bodyCell, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica, Arial, "Lucida Grande", sans-serif;}table{border-collapse:collapse;}table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}img, a img{border:0; outline:none; text-decoration:none;height:auto; line-height:100%;}a {text-decoration:none !important;border-bottom: 1px solid;}h1, h2, h3, h4, h5, h6{color:#5F5F5F; font-weight:normal; font-family:Helvetica; font-size:20px; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}.ReadMsgBody{width:100%;} .ExternalClass{width:100%;}.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%;} table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}#outlook a{padding:0;} img{-ms-interpolation-mode: bicubic;display:block;outline:none; text-decoration:none;} body, table, td, p, a, li, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; font-weight:normal!important;} .ExternalClass td[class="ecxflexibleContainerBox"] h3 {padding-top: 10px !important;} 
		1{display:block;font-size:26px;font-style:normal;font-weight:normal;line-height:100%;}h2{display:block;font-size:20px;font-style:normal;font-weight:normal;line-height:120%;}h3{display:block;font-size:17px;font-style:normal;font-weight:normal;line-height:110%;}h4{display:block;font-size:18px;font-style:italic;font-weight:normal;line-height:100%;}.flexibleImage{height:auto;}.linkRemoveBorder{border-bottom:0 !important;}table[class=flexibleContainerCellDivider] {padding-bottom:0 !important;padding-top:0 !important;}body, #bodyTable{background-color:#f0f1f3;}#emailHeader{background-color:#f0f1f3;}#emailBody{background-color:#FFFFFF;}#emailFooter{background-color:#f0f1f3;}.textContent, .textContentLast{color:#8B8B8B; font-family:Helvetica; font-size:16px; line-height:125%; text-align:Left;}.textContent a, .textContentLast a{color:#205478; text-decoration:underline;}.nestedContainer{background-color:#F8F8F8; border:1px solid #CCCCCC;}.emailButton{background-color:#205478; border-collapse:separate;}.buttonContent{color:#FFFFFF; font-family:Helvetica; font-size:18px; font-weight:bold; line-height:100%; padding:15px; text-align:center;}.buttonContent a{color:#FFFFFF; display:block; text-decoration:none!important; border:0!important;}.emailCalendar{background-color:#FFFFFF; border:1px solid #CCCCCC;}.emailCalendarMonth{background-color:#205478; color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; padding-top:10px; padding-bottom:10px; text-align:center;}.emailCalendarDay{color:#205478; font-family:Helvetica, Arial, sans-serif; font-size:60px; font-weight:bold; line-height:100%; padding-top:20px; padding-bottom:20px; text-align:center;}.imageContentText {margin-top: 10px;line-height:0;}.imageContentText a {line-height:0;}#invisibleIntroduction {display:none !important;} span[class=ios-color-hack] a {color:#275100!important;text-decoration:none!important;}span[class=ios-color-hack2] a {color:#205478!important;text-decoration:none!important;}span[class=ios-color-hack3] a {color:#8B8B8B!important;text-decoration:none!important;}*/.a[href^="tel"], a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important;}.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important;}@media only screen and (max-width: 480px){	body{width:100% !important; min-width:100% !important;} 	table[id="emailHeader"], table[id="emailBody"], table[id="emailFooter"], table[class="flexibleContainer"] {width:100% !important;}	td[class="flexibleContainerBox"], td[class="flexibleContainerBox"] table {display: block;width: 100%;text-align: left;}	td[class="imageContent"] img {height:auto !important; width:100% !important; max-width:100% !important;}	img[class="flexibleImage"]{height:auto !important; width:100% !important;max-width:100% !important;}	img[class="flexibleImageSmall"]{height:auto !important; width:auto !important;}	table[class="flexibleContainerBoxNext"]{padding-top: 10px !important;}	table[class="emailButton"]{width:100% !important;}	td[class="buttonContent"]{padding:0 !important;}	td[class="buttonContent"] a{padding:15px !important;}}
		media only screen and (-webkit-device-pixel-ratio:.75){	/* Put CSS for low density (ldpi) Android layouts in here */}@media only screen and (-webkit-device-pixel-ratio:1){	/* Put CSS for medium density (mdpi) Android layouts in here */}@media only screen and (-webkit-device-pixel-ratio:1.5){	/* Put CSS for high density (hdpi) Android layouts in here */}@media only screen and (min-device-width : 320px) and (max-device-width:568px) {}</style></head><body bgcolor="#f0f1f3" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<center style="background-color:#f0f1f3;"><table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;"><tbody><tr><td align="center" valign="top" id="bodyCell"><table bgcolor="#f0f1f3" border="0" cellpadding="0" cellspacing="0" width="500" id="emailHeader"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="10" cellspacing="0" width="500" class="flexibleContainer"><tbody><tr><td valign="top" width="500" class="flexibleContainerCell"><table align="left" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="left" valign="middle" id="invisibleIntroduction" class="flexibleContainerBox" style="display:none !important;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:100%;"><tbody><tr><td align="left" class="textContent"><div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;">Hola,Hemos generado el codigo: '.$token.' para que puedas restaurar tu contraseña.</div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody"><tbody><tr><td align="" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF; background: #dedede;"><tbody><tr><td align="" valign="top"> <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer"><tbody><tr><td align="" valign="top" width="500" class="flexibleContainerCell"><table border="0" cellpadding="30" cellspacing="0" width="100%"><tbody><tr><td align="" valign="top" class="textContent"><div style="text-align:  center;"><img src="https://sif.idartes.gov.co/sif/public/imagenes/logo-crea-header.png"></div><td align="" valign="top" class="textContent"><div style="text-align:  center;"><img src="https://sif.idartes.gov.co/sif/public/imagenes/logo-nidos-header.png"></div></td></tr><tr><td align="" valign="top" class="textContent" style="width: 150% !important; display: block;"><h1 style="color:#ffffff;text-shadow: 1px 1px 1px #646464;line-height:100%;font-family:Helvetica,Arial,sans-serif;font-size:40px;font-weight:normal;margin-bottom:5px;text-align:center;">Restaurar Contraseña</h1></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer"><tbody><tr><td align="center" valign="top" width="500" class="flexibleContainerCell"><table border="0" cellpadding="20" cellspacing="0" width="100%"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td valign="top" class="textContent"><h3 style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">Hola,</h3><br><div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">Recientemente solicitaste restaurar la contraseña de tu cuenta de SIF, puedes hacer uso del siguiente codigo: </div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer"><tbody><tr><td align="center" valign="top" width="500" class="flexibleContainerCell"><table border="0" cellpadding="0" cellspacing="0" width="50%" class="emailButton" style="background-color: #009f99;">  <tbody><tr><td align="center" valign="middle" class="buttonContent" style="padding-top:15px;padding-bottom:15px;padding-right:15px;padding-left:15px;"><a style="color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:135%;">'.$token.'</a></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer"><tbody><tr><td align="center" valign="top" width="500" class="flexibleContainerCell"><table border="0" cellpadding="30" cellspacing="0" width="100%"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td valign="top" class="textContent"><div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;"> Si no solicitaste restablecer tu contraseña, por favor ignora este mensaje o contáctanos a sif@idartes.gov.co.<br><br><br>Cordialmente,<br><br>Equipo Información SIF<br><br></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table bgcolor="#f0f1f3" border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer"><tbody><tr><td align="center" valign="top" width="500" class="flexibleContainerCell"><table border="0" cellpadding="30" cellspacing="0" width="100%"><tbody><tr><td valign="top" bgcolor="#f0f1f3"><div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;"><p class="copyright pull-right">INSTITUTO DISTRITAL DE LAS ARTES<img src="https://sif.idartes.gov.co/sif/public/imagenes/logo-alcaldia.png" style="display: inline-block;" /></p></div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><font size="1" style="color:rgb(97,97,97);font-family:&quot;Open Sans&quot;"><span style="background-color:transparent">El contenido de este correo electrónico institucional y los archivos adjuntos que contenga son de carácter confidencial, le solicitamos mantener en reserva la información en general. Al destinatario se le considera custodio de la información implícita y debe velar por su confidencialidad, integridad y privacidad. Si usted no es el destinatario o ha recibido este correo por error, por favor infórmelo a su remitente y borre el mensaje original y sus anexos. Está estrictamente prohibida su utilización, copia, descarga, distribución, modificación y/o reproducción total o parcial sin el permiso expreso del Instituto Distrital de las Artes - Idartes, pues de hacerlo, podría tener consecuencias legales de acuerdo con las normas vigentes.</span></font></td></tr></tbody></table></center></body></html>'; 


		if($token > 0){ 
			$mail = new PHPMailer();
			$mail->isSMTP();
			//$mail->SMTPDebug  = 2;  
			$mail->SMTPAuth   = true;  
			$mail->SMTPSecure = 'ssl';
			$mail->Host =  'smtp.gmail.com';
			$mail->Port = '465';
			$mail->isHTML();
			$mail->CharSet = 'UTF-8'; 
			$mail->Username = 'nocontestarsif@idartes.gov.co';
			$mail->Password = 'Crea*2018';
			$mail->SetFrom('sif@idartes.gov.co');
			$mail->Subject = 'Restablecer de contraseña de SIF'; 
			$mail->Body = $body;
			$mail->AddAddress($email);
			echo $mail->Send(); 
			/*
			Cpanel
						$mail = new PHPMailer();
			$mail->isSMTP();
			//$mail->SMTPDebug  = 2;  
			$mail->SMTPAuth   = true;  
			$mail->SMTPSecure = 'ssl';
			$mail->Host =  'sif.idartes.gov.co';
			$mail->Port = '465';
			$mail->isHTML();
			$mail->CharSet = 'UTF-8'; 
			$mail->Username = 'no_reply@sif.idartes.gov.co';
			$mail->Password = 'Sn[KI{o^t6rB';
			$mail->SetFrom('no_reply@sif.idartes.gov.co');
			$mail->Subject = 'Restablecer de contraseña de SIF'; 
			$mail->Body = $body;
			$mail->AddAddress($email);
			echo $mail->Send(); 
			 */

			/* Producción Contingencia */
			/*$mail = new PHPMailer();
			$mail->isSMTP();
			//$mail->SMTPDebug  = 2;   
			$mail->Host =  'mail.si.crea.gov.co';
			$mail->Port = '465';
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPAuth   = true;  
			$mail->isHTML(); 
			$mail->CharSet = 'UTF-8'; 
			$mail->Username = 'soporte@si.crea.gov.co';
			$mail->Password = '$1CR342018/*-+';
			$mail->SetFrom('soporte@si.crea.gov.co','SIF Idartes');
			$mail->Subject = 'Restablecer de contraseña de SIF'; 
			$mail->Body = $body; 
			$mail->AddAddress($email);
			echo $mail->Send();  			 */
		}
		else echo 0;     
	}

	public function generarToken($id)
	{
		$token = rand(100000,999999);
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		$actualizo=$aparienciaDAO->guardarToken($id,$token);
		if($actualizo)
			return $token; 
		else return 0;
	}

	public function cambiarPassword($password,$id)
	{
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		echo $aparienciaDAO->cambiarPassword($password,$id); 
	}
	public function getEstadisticas($anio)
	{
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		echo json_encode($aparienciaDAO->getEstadisticas($anio)); 		
	}

	public function getEstadisticasCREAAreasArtisticas($anio,$crea){
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		echo json_encode($aparienciaDAO->getEstadisticasCREAAreasArtisticas($anio,$crea)); 		
	}
	public function getEstadisticasEmprendeCreaTipoGrupo($anio,$crea){
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		echo json_encode($aparienciaDAO->getEstadisticasEmprendeCreaTipoGrupo($anio,$crea));		
	}
	public function getEstadisticasMesActual($anio)
	{
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		echo json_encode($aparienciaDAO->getEstadisticasMesActual($anio));  	
	}	
	public function getEstadisticasCreaActual($anio)
	{
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		echo json_encode($aparienciaDAO->getEstadisticasCreaActual($anio));  			
	}

	public function validarCaptcha($token)  
	{  
		$secret= "6Leao9gUAAAAAJnlBIAq53OKHyrdLKy_bhjyReOV";  
		$recaptcha = new ReCaptcha($secret);  
		$resp = $recaptcha->verify($token, $_SERVER['REMOTE_ADDR']);  
		if($resp->isSuccess()) {
			return '1';  
		}
		else{
			$errors = $resp->getErrorCodes();
			return $errors;
		}
	}

	public function consultarProgramaUsuario($id_usuario){
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		$programa = $aparienciaDAO->getProgramaDeUsuario($id_usuario);
		echo($programa['programa']);
	}
	
	public function validarEntrada($datos, $token)  
	{  
		session_start();
		$response = $this->validarCaptcha($token);
		/*$response = '1';*/
		if($response != '1')
		{
			echo json_encode(array("estado"=>"errorCaptcha","mensaje"=>"El proceso de validación ReCaptcha no ha sido exitoso, por favor intente de nuevo"));  
		}else{  
			$aparienciaDAO = $this->contenedor['AparienciaDAO'];  
			$persona=$aparienciaDAO->validarEntrada($datos['username'],$datos['password']);  
			if(sizeof($persona)==0){  
				echo json_encode(array("estado"=>"error","mensaje"=>"Usuario o Contraseña incorrectos"));  
			} else{  
				$idPersona = $persona[0]['FK_Id_Persona'];            
				$_SESSION['session_username'] = $idPersona;  
				$_SESSION['session_usertype'] = $persona[0]['FK_Tipo_Persona'];  
				$_SESSION['session_logLogin'] = $aparienciaDAO->saveLogInicioSesion($idPersona,$_SERVER['HTTP_USER_AGENT'],$this->obtenerIP(),$this->returnMacAddress());
				echo json_encode(array("estado"=>"1","mensaje"=>"Login Registrado"));        
			}  
		} 
	}  

	public function obtenerIP() {  

	  //si utilizamos un CDN, por ejemplo Cloudflare, genera un header con la IP real del cliente que se conecta  
		if( isset($_SERVER['HTTP_CF_CONNECTING_IP']) )  
			return $_SERVER['HTTP_CF_CONNECTING_IP'];  

	  //dependiendo de la configuración de proxys o apache o nginx tenemos varias variables de servidor que PHP recibe. Al final del artículo hay una lista de posibles variables  

		if( isset($_SERVER['HTTP_CLIENT_IP']) )   
			return $_SERVER['HTTP_CLIENT_IP'];  

		if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )  
			return $_SERVER['HTTP_X_FORWARDED_FOR'];  

		if( isset($_SERVER['<variable seteada por server>']) )  
			return $_SERVER['<variable seteada por server>'];  

	  //ultimo recurso, lo que envía el navegador   
		if( isset($_SERVER['REMOTE_ADDR']) )   
			return $_SERVER['REMOTE_ADDR'];   

	  //no hay nada definido  
		return null;   
	}  

	public function returnMacAddress() {  
		return false;  
	}

	public function getEstadisticasLocalidades($anio)
	{
		$aparienciaDAO = $this->contenedor['AparienciaDAO'];
		echo json_encode($aparienciaDAO->getEstadisticasLocalidades($anio)); 		
	}

}

$objControlador = new AparienciaController(); 
//Llamar metodo de clase Forma 1

unset($objControlador);
