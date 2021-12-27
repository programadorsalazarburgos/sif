<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_notificacion_persona'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-10-09 16:29	 
 */
class TbNotificacionPersona 
{
	
	private $pk_notificacion_usuario_id;
	private $fk_notificacion;
	private $fk_persona;
	private $in_visto;
	private $dt_fecha_visto;


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
	 * Obtiene el valor de PK_Notificacion_Usuario_Id
	 * @return mixed
	 */
	public function getPkNotificacionUsuarioId()
	{
			return $this->pk_notificacion_usuario_id;
	}

	/**
	 * Asigna el valor para PK_Notificacion_Usuario_Id
	 * @param mixed $pk_notificacion_usuario_id 
	 */
	public function setPkNotificacionUsuarioId($pk_notificacion_usuario_id)
	{
			$this->pk_notificacion_usuario_id=$pk_notificacion_usuario_id;
	}

	/**
	 * Obtiene el valor de FK_Notificacion
	 * @return mixed
	 */
	public function getFkNotificacion()
	{
			return $this->fk_notificacion;
	}

	/**
	 * Asigna el valor para FK_Notificacion
	 * @param mixed $fk_notificacion 
	 */
	public function setFkNotificacion($fk_notificacion)
	{
			$this->fk_notificacion=$fk_notificacion;
	}

	/**
	 * Obtiene el valor de FK_Persona
	 * @return mixed
	 */
	public function getFkPersona()
	{
			return $this->fk_persona;
	}

	/**
	 * Asigna el valor para FK_Persona
	 * @param mixed $fk_persona 
	 */
	public function setFkPersona($fk_persona)
	{
			$this->fk_persona=$fk_persona;
	}

	/**
	 * Obtiene el valor de IN_Visto
	 * @return mixed
	 */
	public function getInVisto()
	{
			return $this->in_visto;
	}

	/**
	 * Asigna el valor para IN_Visto
	 * @param mixed $in_visto 
	 */
	public function setInVisto($in_visto)
	{
			$this->in_visto=$in_visto;
	}

	/**
	 * Obtiene el valor de DT_Fecha_Visto
	 * @return mixed
	 */
	public function getDtFechaVisto()
	{
			return $this->dt_fecha_visto;
	}

	/**
	 * Asigna el valor para DT_Fecha_Visto
	 * @param mixed $dt_fecha_visto 
	 */
	public function setDtFechaVisto($dt_fecha_visto)
	{
			$this->dt_fecha_visto=$dt_fecha_visto;
	}


}
