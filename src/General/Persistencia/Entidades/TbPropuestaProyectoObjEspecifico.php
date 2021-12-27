<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_propuesta_proyecto_obj_especificos'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPropuestaProyectoObjEspecifico 
{
	
	private $in_id;
	private $fk_id_usuario;
	private $vc_objetivo_especifico;
	private $vc_actividades;


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
	 * Obtiene el valor de IN_Id
	 * @return mixed
	 */
	public function getInId()
	{
			return $this->in_id;
	}

	/**
	 * Asigna el valor para IN_Id
	 * @param mixed $in_id 
	 */
	public function setInId($in_id)
	{
			$this->in_id=$in_id;
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

	/**
	 * Obtiene el valor de VC_Objetivo_Especifico
	 * @return mixed
	 */
	public function getVcObjetivoEspecifico()
	{
			return $this->vc_objetivo_especifico;
	}

	/**
	 * Asigna el valor para VC_Objetivo_Especifico
	 * @param mixed $vc_objetivo_especifico 
	 */
	public function setVcObjetivoEspecifico($vc_objetivo_especifico)
	{
			$this->vc_objetivo_especifico=$vc_objetivo_especifico;
	}

	/**
	 * Obtiene el valor de VC_Actividades
	 * @return mixed
	 */
	public function getVcActividades()
	{
			return $this->vc_actividades;
	}

	/**
	 * Asigna el valor para VC_Actividades
	 * @param mixed $vc_actividades 
	 */
	public function setVcActividades($vc_actividades)
	{
			$this->vc_actividades=$vc_actividades;
	}


}
