<?php
namespace Administracion\Controlador;
use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\TbNotificacionDAO;
use General\Persistencia\Entidades\TbNotificacion;
use General\Persistencia\DAOS\TbPersona2017DAO;
use General\Persistencia\Entidades\TbPersona2017;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
use General\Vista\Vista;

class AdministracionFactory extends ControladorBase
{
	protected function initializeFactory()
	{		
		$this->contenedor['NotificacionDAO'] = function ($c) {
			return new TbNotificacionDAO();
		};

		$this->contenedor['Notificacion'] = function ($c) {
			return new TbNotificacion();
		};

		$this->contenedor['tbPersonaDAO'] = function ($c) {
			return new TbPersona2017DAO();
		};
		$this->contenedor['tbPersona2017'] = function ($c) {
			return new TbPersona2017();
		};
	}
	public function sendNotificationEmail($email,$mensaje,$subject = "Notificación SIF")
	{
		$body= '<!DOCTYPE html><html><head><link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet"><script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JSQtIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"><title>Notificacion SIF</title><style type="text/css">body{font-family: \'Open Sans Condensed\', sans-serif;font-size: 25px;}</style></head><body><div class="container"><table class="table-responsive" style="background-color: #f3f3f3;"> <tbody><tr><td class="text-center"><img src="https://sif.idartes.gov.co/sif/public/imagenes/titulo_notificaciones.png" width="100%"></td></tr><tr><td style="padding-bottom: 10px; padding-top: 10px; padding-left: 20px;font-size: 15px; color: #334c70;"><b>Nueva notifición SIF,</b></td></tr><tr><td style="padding-bottom: 10px; padding-top: 10px; padding-left: 20px;font-size: 15px;">'.$mensaje.'</td></tr><tr><td style="padding-bottom: 10px; padding-top: 10px; padding-left: 20px;font-size: 15px; color: #334c70;"><b>Cordialmente,</b></td></tr><tr><td style="padding-bottom: 10px; padding-top: 10px; padding-left: 20px;font-size: 15px;">Equipo Informacion SIF</td></tr><tr><td style="padding-bottom: 10px; padding-top: 10px; padding-left: 20px;font-size: 15px;"></td></tr><tr><td style="padding-bottom: 10px; padding-top: 10px; padding-left: 20px;font-size: 15px;"></td></tr><tr><td class="text-center"><img src="https://sif.idartes.gov.co/sif/public/imagenes/footer_notificaciones.png" width="100%"></td></tr><tr><td class="text-center" style="padding: 15px;font-size: 20px;"><span>Institulo Distrital de las Artes - Idartes</span></td></tr><tr><td class="text-center"><img src="https://sif.idartes.gov.co/sif/public/imagenes/alcaldia.png"></td></tr><tr><td style="padding-bottom: 10px; padding-top: 10px; padding-left: 20px;font-size: 15px;"></td></tr></tbody></table></div></body></html>'; 


		$mail = new PHPMailer();
		$mail->isSMTP(); 
		$mail->SMTPAuth   = true;  
		$mail->SMTPSecure = 'ssl';
		$mail->Host =  'smtp.gmail.com';
		$mail->Port = '465';
		$mail->isHTML();
		$mail->CharSet = 'UTF-8'; 
		$mail->Username = 'nocontestarsif@idartes.gov.co';
		$mail->Password = 'Crea*2018';
		$mail->SetFrom('sif@idartes.gov.co');
		$mail->Subject = $subject; 
		$mail->Body = $body;
		$mail->AddAddress($email);
		echo $mail->Send();  
	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */