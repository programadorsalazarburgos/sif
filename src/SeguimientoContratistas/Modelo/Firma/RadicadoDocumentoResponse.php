<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\InformePago;
use SeguimientoContratistas\Modelo\Firma\TipoDocumento;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;

class RadicadoDocumentoResponse
{
    private $codigo;
    private $ruta;
    private $descripcion;
    private $paginas;
    private $esPrincipal;
    private $soloLectura = "S";
    private $anexoId;
    private $tipoDocumento;

    public function __construct($ruta,$descripcion,$paginas,$esPrincipal,$tipoDocumento)
    {
        $this->ruta = $ruta;
        $this->descripcion = $descripcion;
        $this->paginas = $paginas;
        $this->esPrincipal = $esPrincipal;
        $this->tipoDocumento = $tipoDocumento;
    }
        

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of paginas
     */ 
    public function getPaginas()
    {
        return $this->paginas;
    }

    /**
     * Set the value of paginas
     *
     * @return  self
     */ 
    public function setPaginas($paginas)
    {
        $this->paginas = $paginas;

        return $this;
    }

    /**
     * Get the value of esPrincipal
     */ 
    public function getEsPrincipal()
    {
        return $this->esPrincipal;
    }

    /**
     * Set the value of esPrincipal
     *
     * @return  self
     */ 
    public function setEsPrincipal($esPrincipal)
    {
        $this->esPrincipal = $esPrincipal;

        return $this;
    }

    /**
     * Get the value of codigo
     */ 
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     *
     * @return  self
     */ 
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get the value of ruta
     */ 
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Set the value of ruta
     *
     * @return  self
     */ 
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * Get the value of soloLectura
     */ 
    public function getSoloLectura()
    {
        return $this->soloLectura;
    }

    /**
     * Get the value of anexoId
     */ 
    public function getAnexoId()
    {
        return $this->anexoId;
    }

    /**
     * Set the value of anexoId
     *
     * @return  self
     */ 
    public function setAnexoId($anexoId)
    {
        $this->anexoId = $anexoId;

        return $this;
    }

    /**
     * Get the value of orden
     */ 
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set the value of orden
     *
     * @return  self
     */ 
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get the value of tipoDocumento
     */ 
    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }

    /**
     * Set the value of tipoDocumento
     *
     * @return  self
     */ 
    public function setTipoDocumento(TipoDocumento $tipoDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;

        return $this;
    }
}