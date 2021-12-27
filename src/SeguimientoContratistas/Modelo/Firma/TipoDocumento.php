<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\InformePago;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;

class TipoDocumento
{
    private $codigo;
    private $nombre;
    private $orden;
    private $extensiones;
    private $codigoInterno;


    public function __construct($codigo,$nombre,$orden,$extensiones,$codigoInterno)
    {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->orden = $orden;
        $this->extensiones = $extensiones;
        $this->codigoInterno = $codigoInterno;
    }

    /**
     * Get the value of orden
     */ 
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Get the value of codigoInterno
     */ 
    public function getCodigoInterno()
    {
        return $this->codigoInterno;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }
}