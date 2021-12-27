<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_menu_actividad_usuario'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbMenuActividadUsuario 
{
	
	private $fk_actividad;
	private $fk_persona;


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
	 * Obtiene el valor de FK_Actividad
	 * @return mixed
	 */
	public function getFkActividad()
	{
			return $this->fk_actividad;
	}

	/**
	 * Asigna el valor para FK_Actividad
	 * @param mixed $fk_actividad 
	 */
	public function setFkActividad($fk_actividad)
	{
			$this->fk_actividad=$fk_actividad;
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


}
