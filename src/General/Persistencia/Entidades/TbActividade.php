<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_actividades'
 *
 * @author: Camilo CalderÃ³n, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbActividade 
{
	
	private $fk_id_actividad;
	private $vc_nom_actividad;
	private $vc_descripción;


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
	 * Obtiene el valor de VC_Nom_Actividad
	 * @return mixed
	 */
	public function getVcNomActividad()
	{
			return $this->vc_nom_actividad;
	}

	/**
	 * Asigna el valor para VC_Nom_Actividad
	 * @param mixed $vc_nom_actividad 
	 */
	public function setVcNomActividad($vc_nom_actividad)
	{
			$this->vc_nom_actividad=$vc_nom_actividad;
	}

	/**
	 * Obtiene el valor de VC_Descripción
	 * @return mixed
	 */
	public function getVcDescripción()
	{
			return $this->vc_descripción;
	}

	/**
	 * Asigna el valor para VC_Descripción
	 * @param mixed $vc_descripción 
	 */
	public function setVcDescripción($vc_descripción)
	{
			$this->vc_descripción=$vc_descripción;
	}


}
