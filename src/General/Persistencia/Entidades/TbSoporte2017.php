<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_soporte_2017'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbSoporte2017 
{
	
	private $fk_persona;
	private $fk_tipo_soporte;
	private $tx_solicitud;
	private $dt_fecha_creacion;
	private $tx_solucion;
	private $dt_fecha_solucion;
	private $estado;


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
	 * Obtiene el valor de FK_persona
	 * @return mixed
	 */
	public function getFkPersona()
	{
			return $this->fk_persona;
	}

	/**
	 * Asigna el valor para FK_persona
	 * @param mixed $fk_persona 
	 */
	public function setFkPersona($fk_persona)
	{
			$this->fk_persona=$fk_persona;
	}

	/**
	 * Obtiene el valor de FK_tipo_soporte
	 * @return mixed
	 */
	public function getFkTipoSoporte()
	{
			return $this->fk_tipo_soporte;
	}

	/**
	 * Asigna el valor para FK_tipo_soporte
	 * @param mixed $fk_tipo_soporte 
	 */
	public function setFkTipoSoporte($fk_tipo_soporte)
	{
			$this->fk_tipo_soporte=$fk_tipo_soporte;
	}

	/**
	 * Obtiene el valor de TX_solicitud
	 * @return mixed
	 */
	public function getTxSolicitud()
	{
			return $this->tx_solicitud;
	}

	/**
	 * Asigna el valor para TX_solicitud
	 * @param mixed $tx_solicitud 
	 */
	public function setTxSolicitud($tx_solicitud)
	{
			$this->tx_solicitud=$tx_solicitud;
	}

	/**
	 * Obtiene el valor de DT_fecha_creacion
	 * @return mixed
	 */
	public function getDtFechaCreacion()
	{
			return $this->dt_fecha_creacion;
	}

	/**
	 * Asigna el valor para DT_fecha_creacion
	 * @param mixed $dt_fecha_creacion 
	 */
	public function setDtFechaCreacion($dt_fecha_creacion)
	{
			$this->dt_fecha_creacion=$dt_fecha_creacion;
	}

	/**
	 * Obtiene el valor de TX_solucion
	 * @return mixed
	 */
	public function getTxSolucion()
	{
			return $this->tx_solucion;
	}

	/**
	 * Asigna el valor para TX_solucion
	 * @param mixed $tx_solucion 
	 */
	public function setTxSolucion($tx_solucion)
	{
			$this->tx_solucion=$tx_solucion;
	}

	/**
	 * Obtiene el valor de DT_fecha_solucion
	 * @return mixed
	 */
	public function getDtFechaSolucion()
	{
			return $this->dt_fecha_solucion;
	}

	/**
	 * Asigna el valor para DT_fecha_solucion
	 * @param mixed $dt_fecha_solucion 
	 */
	public function setDtFechaSolucion($dt_fecha_solucion)
	{
			$this->dt_fecha_solucion=$dt_fecha_solucion;
	}

	/**
	 * Obtiene el valor de estado
	 * @return mixed
	 */
	public function getEstado()
	{
			return $this->estado;
	}

	/**
	 * Asigna el valor para estado
	 * @param mixed $estado 
	 */
	public function setEstado($estado)
	{
			$this->estado=$estado;
	}


}
