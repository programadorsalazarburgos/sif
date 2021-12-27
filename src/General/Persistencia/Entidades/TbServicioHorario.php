<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_servicio_horario'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbServicioHorario 
{
	
	private $servicio_codigo;
	private $servicio_sla_codigo;
	private $dia;
	private $hora_inicio;
	private $hora_fin;


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
	 * Obtiene el valor de SERVICIO_SLA_CODIGO
	 * @return mixed
	 */
	public function getServicioSlaCodigo()
	{
			return $this->servicio_sla_codigo;
	}

	/**
	 * Asigna el valor para SERVICIO_SLA_CODIGO
	 * @param mixed $servicio_sla_codigo 
	 */
	public function setServicioSlaCodigo($servicio_sla_codigo)
	{
			$this->servicio_sla_codigo=$servicio_sla_codigo;
	}

	/**
	 * Obtiene el valor de DIA
	 * @return mixed
	 */
	public function getDia()
	{
			return $this->dia;
	}

	/**
	 * Asigna el valor para DIA
	 * @param mixed $dia 
	 */
	public function setDia($dia)
	{
			$this->dia=$dia;
	}

	/**
	 * Obtiene el valor de HORA_INICIO
	 * @return mixed
	 */
	public function getHoraInicio()
	{
			return $this->hora_inicio;
	}

	/**
	 * Asigna el valor para HORA_INICIO
	 * @param mixed $hora_inicio 
	 */
	public function setHoraInicio($hora_inicio)
	{
			$this->hora_inicio=$hora_inicio;
	}

	/**
	 * Obtiene el valor de HORA_FIN
	 * @return mixed
	 */
	public function getHoraFin()
	{
			return $this->hora_fin;
	}

	/**
	 * Asigna el valor para HORA_FIN
	 * @param mixed $hora_fin 
	 */
	public function setHoraFin($hora_fin)
	{
			$this->hora_fin=$hora_fin;
	}


}
