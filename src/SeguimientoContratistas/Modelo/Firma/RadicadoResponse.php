<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\InformePago;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;

class RadicadoResponse
{
    private $informePago;
    private $usuarioActual;
    private $historicoBorrador;
    private $descripcionAnexos = '';
    private $tipoRadicado = "4"; #4 informe de pago, 3 interno diferentes a informe de pago
    private $seguridadDocumento = 0;
    private $tipoDerivado = 1;
    private $tipologiaDocumental = 2656;
    private $referenciaCuenta = "PANDORA-IP";
    private $medioRecepcion = 5;
    private $tipoDestinatario = 4;
    private $statusResponse; 
    private $mensajeResponse;
    private $numeroRadicado; 
    private $codigoVerificacion; 
    private $fechaRadicado; 
    private $documentos;
    private $anexoId;
    private $entidad = "Instituto Distrital de las Artes IDARTES";
    private $nitEntidad = "900413030";
    private $webOficial = "www.idartes.gov.co";
    private $firmas = [];
    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    public function __construct5($numeroRadicado,$codigoVerificacion,$anexoId,$firmas,$fechaRadicado)
    {
        $this->numeroRadicado = $numeroRadicado;
        $this->codigoVerificacion = $codigoVerificacion;
        $this->anexoId = $anexoId;
        $this->firmas = $firmas;
        $this->fechaRadicado = $fechaRadicado;
    }

    public function __construct3(InformePago $informePago, UsuarioResponse $usuarioActual, $historicoBorrador)
    {
        $this->informePago = $informePago;
        $this->usuarioActual = $usuarioActual;
        $this->historicoBorrador = $historicoBorrador;
    }
                                             
    public function toArray() {

        return [
            'usuario_radicador_id'=>$this->getInformePago()->getUsuarioRadicador()->getIdResponse(),
            'asunto_documento'=>$this->getInformePago()->getAsuntoRadicado(),
            'seguridad_documento'=>$this->getSeguridadDocumento(),
            'descripcion_anexos'=>$this->getDescripcionAnexos(),
            'tipo_derivado'=>$this->getTipoDerivado(),
            'tipologia_documental'=>$this->getTipologiaDocumental(),
            'referencia_cuenta'=>$this->getReferenciaCuenta(),
            'medio_recepcion'=>$this->getMedioRecepcion(),
            'usuario_actual_id'=>$this->getUsuarioActual()->getIdResponse(),
            'usuario_contacto_id'=>$this->getInformePago()->getUsuarioRadicador()->getIdResponse(),
            'tipo_destinatario'=>$this->getTipoDestinatario(),
            'tipo_radicado'=>$this->getTipoRadicado(),
            'historico_borrador'=>$this->getHistoricoBorrador(),
        ];
    }

    public function firmasToArray()
    {
        $usuarios = [];
        foreach($this->firmas as $firma){
            $usuarios[] = $firma->toArray();
        }
        return [
            "radicado_padre"=>$this->numeroRadicado,
            "codigo_verificacion"=>$this->codigoVerificacion,
            "anexo_id"=>$this->anexoId,
            "cantidad_firmantes"=>count($usuarios),
            "usuarios"=>$usuarios,
            "entidad_largo"=>$this->entidad,
            "nit_entidad"=>$this->nitEntidad,
            "http_web_oficial"=>$this->webOficial        
        ];
    }


    /**
     * Get the value of tipoRadicado
     */ 
    public function getTipoRadicado()
    {
        return $this->tipoRadicado;
    }

    /**
     * Get the value of seguridadDocumento
     */ 
    public function getSeguridadDocumento()
    {
        return $this->seguridadDocumento;
    }

    /**
     * Get the value of descripcionAnexos
     */ 
    public function getDescripcionAnexos()
    {
        return $this->descripcionAnexos;
    }

    /**
     * Get the value of tipoDerivado
     */ 
    public function getTipoDerivado()
    {
        return $this->tipoDerivado;
    }

    /**
     * Get the value of tipologiaDocumental
     */ 
    public function getTipologiaDocumental()
    {
        return $this->tipologiaDocumental;
    }

    /**
     * Get the value of referenciaCuenta
     */ 
    public function getReferenciaCuenta()
    {
        return $this->referenciaCuenta;
    }

    /**
     * Get the value of medioRecepcion
     */ 
    public function getMedioRecepcion()
    {
        return $this->medioRecepcion;
    }

    /**
     * Get the value of tipoDestinatario
     */ 
    public function getTipoDestinatario()
    {
        return $this->tipoDestinatario;
    }

    /**
     * Get the value of historicoBorrador
     */ 
    public function getHistoricoBorrador()
    {
        return $this->historicoBorrador;
    }

    /**
     * Get the value of informePago
     */ 
    public function getInformePago()
    {
        return $this->informePago;
    }

    /**
     * Get the value of usuarioActual
     */ 
    public function getUsuarioActual()
    {
        return $this->usuarioActual;
    }

    public function completarRadicado($respuesta)
    {
        $this->statusResponse = $respuesta->error; 
        $this->mensajeResponse = $respuesta->message;        
        if(!$this->statusResponse)
        {
            $this->numeroRadicado = $respuesta->numero_radicado;
            $this->fechaRadicado = $respuesta->fecha_radicado;
            $this->codigoVerificacion = $respuesta->codigo_verificacion;
        }
    }
    
    public function obtenerRadicado()
    {
        $radicado = [];
        if(!$this->statusResponse)
        {
            $radicado = [
                "numeroRadicado"=>$this->numeroRadicado,
                "fechaRadicado"=>$this->fechaRadicado,
                "codigoVerificacion"=>$this->codigoVerificacion,
            ];
        } 
        $radicado["error"] = $this->statusResponse;
        $radicado["mensaje"] = $this->mensajeResponse;
        return $radicado;       
    }

    /**
     * Get the value of documentos
     */ 
    public function getDocumentos()
    {
        return $this->documentos;
    }

    /**
     * Set the value of documentos
     *
     * @return  self
     */ 
    public function setDocumentos($documentos)
    {
        $this->documentos = $documentos;

        return $this;
    }

    /**
     * Get the value of numeroRadicado
     */ 
    public function getNumeroRadicado()
    {
        return $this->numeroRadicado;
    }

    /**
     * Get the value of codigoVerificacion
     */ 
    public function getCodigoVerificacion()
    {
        return $this->codigoVerificacion;
    }

    /**
     * Get the value of fechaRadicado
     */ 
    public function getFechaRadicado()
    {
        return $this->fechaRadicado;
    }

    /**
     * Get the value of documentos
     */ 
    public function getAnexos()
    {
        $documentos = [];
        foreach($this->documentos as $documento){
            if(!$documento->getEsPrincipal())
            {
                $documentos[] = $documento;
            }
        }
        return $documentos;
    }    
}