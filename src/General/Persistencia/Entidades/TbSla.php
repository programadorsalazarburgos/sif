<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_sla'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbSla 
{
	
	private $codigo;
	private $titulo;
	private $descripcion;
	private $fecha_creacion;
	private $fk_id_usuario;


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
	 * Obtiene el valor de CODIGO
	 * @return mixed
	 */
	public function getCodigo()
	{
			return $this->codigo;
	}

	/**
	 * Asigna el valor para CODIGO
	 * @param mixed $codigo 
	 */
	public function setCodigo($codigo)
	{
			$this->codigo=$codigo;
	}

	/**
	 * Obtiene el valor de TITULO
	 * @return mixed
	 */
	public function getTitulo()
	{
			return $this->titulo;
	}

	/**
	 * Asigna el valor para TITULO
	 * @param mixed $titulo 
	 */
	public function setTitulo($titulo)
	{
			$this->titulo=$titulo;
	}

	/**
	 * Obtiene el valor de DESCRIPCION
	 * @return mixed
	 */
	public function getDescripcion()
	{
			return $this->descripcion;
	}

	/**
	 * Asigna el valor para DESCRIPCION
	 * @param mixed $descripcion 
	 */
	public function setDescripcion($descripcion)
	{
			$this->descripcion=$descripcion;
	}

	/**
	 * Obtiene el valor de FECHA_CREACION
	 * @return mixed
	 */
	public function getFechaCreacion()
	{
			return $this->fecha_creacion;
	}

	/**
	 * Asigna el valor para FECHA_CREACION
	 * @param mixed $fecha_creacion 
	 */
	public function setFechaCreacion($fecha_creacion)
	{
			$this->fecha_creacion=$fecha_creacion;
	}

	/**
	 * Obtiene el valor de FK_Id_Usuario
	 * @return mixed
	 */
	public function getFkIdUsuario()
	{
			return $this->fk_id_usuario;
	}

	/**
	 * Asigna el valor para FK_Id_Usuario
	 * @param mixed $fk_id_usuario 
	 */
	public function setFkIdUsuario($fk_id_usuario)
	{
			$this->fk_id_usuario=$fk_id_usuario;
	}


}
