<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_inf_control_inventario'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2018-04-17 18:47	 
 */
class TbInfControlInventario 
{
	
	private $pk_id_control_inventario;
	private $da_fecha;
	private $fk_id_inventario;
	private $fk_id_persona;
	private $vc_observacion;
	private $in_estado;


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
	 * Obtiene el valor de PK_Id_Control_Inventario
	 * @return mixed
	 */
	public function getPkIdControlInventario()
	{
			return $this->pk_id_control_inventario;
	}

	/**
	 * Asigna el valor para PK_Id_Control_Inventario
	 * @param mixed $pk_id_control_inventario 
	 */
	public function setPkIdControlInventario($pk_id_control_inventario)
	{
			$this->pk_id_control_inventario=$pk_id_control_inventario;
	}

	/**
	 * Obtiene el valor de DA_Fecha
	 * @return mixed
	 */
	public function getDaFecha()
	{
			return $this->da_fecha;
	}

	/**
	 * Asigna el valor para DA_Fecha
	 * @param mixed $da_fecha 
	 */
	public function setDaFecha($da_fecha)
	{
			$this->da_fecha=$da_fecha;
	}

	/**
	 * Obtiene el valor de FK_Id_Inventario
	 * @return mixed
	 */
	public function getFkIdInventario()
	{
			return $this->fk_id_inventario;
	}

	/**
	 * Asigna el valor para FK_Id_Inventario
	 * @param mixed $fk_id_inventario 
	 */
	public function setFkIdInventario($fk_id_inventario)
	{
			$this->fk_id_inventario=$fk_id_inventario;
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
	 * Obtiene el valor de VC_Observacion
	 * @return mixed
	 */
	public function getVcObservacion()
	{
			return $this->vc_observacion;
	}

	/**
	 * Asigna el valor para VC_Observacion
	 * @param mixed $vc_observacion 
	 */
	public function setVcObservacion($vc_observacion)
	{
			$this->vc_observacion=$vc_observacion;
	}

	/**
	 * Obtiene el valor de IN_Estado
	 * @return mixed
	 */
	public function getInEstado()
	{
			return $this->in_estado;
	}

	/**
	 * Asigna el valor para IN_Estado
	 * @param mixed $in_estado 
	 */
	public function setInEstado($in_estado)
	{
			$this->in_estado=$in_estado;
	}


}
