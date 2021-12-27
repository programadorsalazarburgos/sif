<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_incidente_observacion'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-05-02 09:57	 
 */
class TbIncidenteObservacion 
{
	
	private $codigo; 
	private $incidente_codigo;
	private $servicio_codigo=1;
	private $sla_codigo=1;
	private $observaciones;
	private $tipo_observacion;
	private $fk_id_persona;
	private $fecha;


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
	 * Obtiene el valor de INCIDENTE_CODIGO
	 * @return mixed
	 */
	public function getIncidenteCodigo()
	{
			return $this->incidente_codigo;
	}

	/**
	 * Asigna el valor para INCIDENTE_CODIGO
	 * @param mixed $incidente_codigo 
	 */
	public function setIncidenteCodigo($incidente_codigo)
	{
			$this->incidente_codigo=$incidente_codigo;
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
	 * Obtiene el valor de OBSERVACIONES
	 * @return mixed
	 */
	public function getObservaciones()
	{
			return $this->observaciones;
	}

	/**
	 * Asigna el valor para OBSERVACIONES
	 * @param mixed $observaciones 
	 */
	public function setObservaciones($observaciones)
	{
			$this->observaciones=$observaciones;
	}

	/**
	 * Obtiene el valor de TIPO_OBSERVACION
	 * @return mixed
	 */
	public function getTipoObservacion()
	{
			return $this->tipo_observacion;
	}

	/**
	 * Asigna el valor para TIPO_OBSERVACION
	 * @param mixed $tipo_observacion 
	 */
	public function setTipoObservacion($tipo_observacion)
	{
			$this->tipo_observacion=$tipo_observacion;
	}

	/**
	 * Obtiene el valor de FK_Id_Persona
	 * @return mixed
	 */
	public function getFkIdPersona()
	{
			return $this->fk_id_persona;
	}

	/**
	 * Asigna el valor para FK_Id_Persona
	 * @param mixed $fk_id_persona 
	 */
	public function setFkIdPersona($fk_id_persona)
	{
			$this->fk_id_persona=$fk_id_persona;
	}

	
    /**
     * Gets the value of fecha.
     *
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Sets the value of fecha.
     *
     * @param mixed $fecha the fecha
     *
     * @return self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }
    public function setWhere($tabla)
    {
    	$where='';
    	foreach($this as $clave=>$valor)
    	{
    		if($valor!=null && $valor!='')
    			if($where==='')
    				$where.=$tabla.'.'.$clave.'='.$valor;
    			else
    				$where.=' AND '.$tabla.'.'.$clave.'='.$valor;
    	} 
    	return $where;
    }
}
