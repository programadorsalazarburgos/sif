<?php
namespace SeguimientoContratistas\Modelo\Firma;

use stdClass;

class UsuarioResponse
{
    private  $idResponse;
    private  $idUsuario;
    private  $cc;
    private  $nombre;
    private  $email;
    private  $login;
    private  $esJefe;
    private  $dependencia;
    private  $estado;


    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    public function __construct1($parametro)
    {
        #var_dump(gettype($parametro));
        if(gettype($parametro) == 'object')
        {
            $this->mapearDesdeServicio($parametro);
        }else
        {
            $this->idResponse = $parametro;
        }
       
    }

    public function __construct2($idUsuario, $cc)
    {
        $this->idUsuario = $idUsuario;
        $this->cc = $cc;
    }
 
    
    public function mapearDesdeServicio(stdClass $usuarioResponse)
    {
        $this->idResponse = $usuarioResponse->id_usuario;
        $this->cc = $usuarioResponse->usuario_cc;
        $this->nombre = $usuarioResponse->usuario_nombre;
        $this->email = $usuarioResponse->usuario_email;
        $this->login = $usuarioResponse->usuario_login;
        $this->esJefe = $usuarioResponse->usuario_jefe;
        $this->dependencia = $usuarioResponse->codigo_dependencia;
        $this->estado = $usuarioResponse->usuario_estado;        
    }

    public function toArray() {
        return get_object_vars($this);
    }    
    
    /**
     * Get the value of idResponse
     */ 
    public function getIdResponse()
    {
        return $this->idResponse;
    }

    /**
     * Get the value of idUsuario
     */ 
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set the value of idUsuario
     *
     * @return  self
     */ 
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get the value of cc
     */ 
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the value of esJefe
     */ 
    public function getEsJefe()
    {
        return $this->esJefe;
    }

    /**
     * Get the value of dependencia
     */ 
    public function getDependencia()
    {
        return $this->dependencia;
    }

    /**
     * Get the value of estado
     */ 
    public function getEstado()
    {
        return $this->estado;
    }
}