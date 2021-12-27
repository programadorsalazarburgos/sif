<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa las tablas de la base de datos 'siclango_matricula_simat_completa'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-10-03 17:39	 
 */
class TbAuditoria
{
	
	private $id;
	private $tipo;
	private $operacion_realizada;
	private $pk_registro;
	private $nombre_tabla;
	private $json_antes;
	private $json_despues;
	private $fecha;
	private $usuario;


	/**
	 * Asigna el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
	public function setVariables($objeto)
	{
		foreach ($objeto as $clave => $valor) {
			if($valor==null)
				$this->{$clave} = NULL; 
			else
				$this->{$clave} = $valor;  
		}
	}

	/**
	 * Crea la sintaxis de SQL para el WHERE con el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
    public function setWhere($tabla)
    {
    	$where='';
    	foreach($this as $clave=>$valor)
    	{
    		if($valor['valor']!=null && $valor['valor']!='')
    			if($where==='')
    				$where.=$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
    			else
    				$where.=' AND '.$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
    	} 
    	return $where;
    }	

	/**
	 * Crea la sintaxis de SQL para el UPDATE con el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
    public function setUpdate($tabla)
    {
    	$update='';
    	$where='';
    	foreach($this as $clave=>$valor)
    	{
    		if($valor['valor']!=null && $valor['valor']!='') {
    			if($valor['llave']) {
	    			if($where==='')
	    				$where.=$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
	    			else
	    				$where.=' AND '.$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
    			}
    			else {
	    			if($update==='')
	    				$update.=$tabla.'.'.$clave.'='.$valor['valor'];
	    			else
	    				$update.=','. $tabla.'.'.$clave.'='.$valor['valor'];    				
    			}

    		}
    		

    	} 
    	return $update.' WHERE '.$where;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     *
     * @return self
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperacionRealizada()
    {
        return $this->operacion_realizada;
    }

    /**
     * @param mixed $operacion_realizada
     *
     * @return self
     */
    public function setOperacionRealizada($operacion_realizada)
    {
        $this->operacion_realizada = $operacion_realizada;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPkRegistro()
    {
        return $this->pk_registro;
    }

    /**
     * @param mixed $pk_registro
     *
     * @return self
     */
    public function setPkRegistro($pk_registro)
    {
        $this->pk_registro = $pk_registro;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombreTabla()
    {
        return $this->nombre_tabla;
    }

    /**
     * @param mixed $nombre_tabla
     *
     * @return self
     */
    public function setNombreTabla($nombre_tabla)
    {
        $this->nombre_tabla = $nombre_tabla;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getJsonAntes()
    {
        return $this->json_antes;
    }

    /**
     * @param mixed $json_antes
     *
     * @return self
     */
    public function setJsonAntes($json_antes)
    {
        $this->json_antes = $json_antes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getJsonDespues()
    {
        return $this->json_despues;
    }

    /**
     * @param mixed $json_despues
     *
     * @return self
     */
    public function setJsonDespues($json_despues)
    {
        $this->json_despues = $json_despues;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     *
     * @return self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     *
     * @return self
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }
}