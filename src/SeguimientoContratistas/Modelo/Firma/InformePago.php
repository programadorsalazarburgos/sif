<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;

class InformePago
{
    private $id;
    private $numeroContrato;
    private $usuarioRadicador;
    private $numeroPago;
    private $totalPagos;
    private $expediente;


    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    public function __construct1(String $numeroContrato)
    {
        $this->numeroContrato = $numeroContrato;
    }  
    
    public function __construct2(int $id,String $numeroContrato)
    {
        $this->id = $id;
        $this->numeroContrato = $numeroContrato;
    }      
    
    public function __construct5(int $id,String $numeroContrato,UsuarioResponse $usuarioRadicador, int $numeroPago, int $totalPagos)
    {
        $this->id = $id;
        $this->numeroContrato = $numeroContrato;
        $this->usuarioRadicador = $usuarioRadicador;
        $this->numeroPago = $numeroPago;
        $this->totalPagos = $totalPagos;
    }
    /**
     * Get the value of numeroContrato
     */ 
    public function getNumeroContrato()
    {
        return $this->numeroContrato;
    }

    /**
     * Set the value of numeroContrato
     *
     * @return  self
     */ 
    public function setNumeroContrato($numeroContrato)
    {
        $this->numeroContrato = $numeroContrato;

        return $this;
    }

    /**
     * Get the value of numeroPago
     */ 
    public function getNumeroPago()
    {
        return $this->numeroPago;
    }

    /**
     * Set the value of numeroPago
     *
     * @return  self
     */ 
    public function setNumeroPago($numeroPago)
    {
        $this->numeroPago = $numeroPago;

        return $this;
    }

    /**
     * Get the value of totalPagos
     */ 
    public function getTotalPagos()
    {
        return $this->totalPagos;
    }

    /**
     * Set the value of totalPagos
     *
     * @return  self
     */ 
    public function setTotalPagos($totalPagos)
    {
        $this->totalPagos = $totalPagos;

        return $this;
    }

    /**
     * Get the value of usuarioRadicador
     */ 
    public function getUsuarioRadicador()
    {
        return $this->usuarioRadicador;
    }

    /**
     * Set the value of usuarioRadicador
     *
     * @return  self
     */ 
    public function setUsuarioRadicador($usuarioRadicador)
    {
        $this->usuarioRadicador = $usuarioRadicador;

        return $this;
    }

    public function getAsuntoRadicado()
    {
        return "Entrega de informe para pago del contrato No.".$this->numeroContrato." del contratista "
                .$this->usuarioRadicador->getNombre()." Cc ".$this->usuarioRadicador->getCc()." pago No. ".$this->numeroPago." de ".$this->totalPagos." ";
    }    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of expediente
     */ 
    public function getExpediente()
    {
        return $this->expediente;
    }

    /**
     * Set the value of expediente
     *
     * @return  self
     */ 
    public function setExpediente($expediente)
    {
        $this->expediente = $expediente;

        return $this;
    }
}