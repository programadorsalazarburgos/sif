<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_servicio_calendario'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbServicioCalendario 
{
	
	private $dia_no_habil;
	private $servicio_codigo;
	private $sla_codigo;
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
	 * Obtiene el valor de DIA_NO_HABIL
	 * @return mixed
	 */
	public function getDiaNoHabil()
	{
			return $this->dia_no_habil;
	}

	/**
	 * Asigna el valor para DIA_NO_HABIL
	 * @param mixed $dia_no_habil 
	 */
	public function setDiaNoHabil($dia_no_habil)
	{
			$this->dia_no_habil=$dia_no_habil;
	}

	/**
	 * Obtiene el valor de SERVICIO_CODIGO
	 * @return mixed
	 */
	public function getServicioCodigo()
	{
			return $this->servicio_codigo;
	}

	/**
	 * Asigna el valor para SERVICIO_CODIGO
	 * @param mixed $servicio_codigo 
	 */
	public function setServicioCodigo($servicio_codigo)
	{
			$this->servicio_codigo=$servicio_codigo;
	}

	/**
	 * Obtiene el valor de SLA_CODIGO
	 * @return mixed
	 */
	public function getSlaCodigo()
	{
			return $this->sla_codigo;
	}

	/**
	 * Asigna el valor para SLA_CODIGO
	 * @param mixed $sla_codigo 
	 */
	public function setSlaCodigo($sla_codigo)
	{
			$this->sla_codigo=$sla_codigo;
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
