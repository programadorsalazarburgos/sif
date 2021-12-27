<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailPreinscripcion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $datos;
    public function __construct($datos){
        $this->datos = $datos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        $subject;
        if($this->datos->notificacion_email == "confirmacion_preinscripcion"){
            $subject = "Confirmación preinscripción oferta disponible crea";
        }
        if($this->datos->notificacion_email == "aprobar"){
            $subject = "Aprobación inscripción grupo ".$this->datos->modalidad." - Crea";
        }
        if($this->datos->notificacion_email == "rechazar"){
            $subject = "No has superado el proceso de inscripción para el grupo de ".$this->datos->modalidad." - Crea";
        }
        if($this->datos->notificacion_email == "crea"){
            $subject = "Se ha realizado un proceso de pre inscripción para el grupo de ".$this->datos->modalidad_area;
        }

        return $this->markdown('emails.territorial.crea.oferta.email_preinscripcion')
        ->subject($subject);
    }
}
