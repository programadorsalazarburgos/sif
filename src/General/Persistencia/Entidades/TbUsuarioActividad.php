<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_usuario_actividad'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbUsuarioActividad 
{
	
	private $pk_id_actividad;
	private $fk_id_persona;
	private $fk_id_actividad;
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
	 * Obtiene el valor de PK_Id_Actividad
	 * @return mixed
	 */
	public function getPkIdActividad()
	{
			return $this->pk_id_actividad;
	}

	/**
	 * Asigna el valor para PK_Id_Actividad
	 * @param mixed $pk_id_actividad 
	 */
	public function setPkIdActividad($pk_id_actividad)
	{
			$this->pk_id_actividad=$pk_id_actividad;
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
	 * Obtiene el valor de FK_Id_Actividad
	 * @return mixed
	 */
	public function getFkIdActividad()
	{
			return $this->fk_id_actividad;
	}

	/**
	 * Asigna el valor para FK_Id_Actividad
	 * @param mixed $fk_id_actividad 
	 */
	public function setFkIdActividad($fk_id_actividad)
	{
			$this->fk_id_actividad=$fk_id_actividad;
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
