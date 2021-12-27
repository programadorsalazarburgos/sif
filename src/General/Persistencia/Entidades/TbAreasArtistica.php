<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_areas_artisticas'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbAreasArtistica 
{
	
	private $pk_area_artistica;
	private $vc_nom_area;
	private $vc_descripcion_area;


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
	 * Obtiene el valor de PK_Area_Artistica
	 * @return mixed
	 */
	public function getPkAreaArtistica()
	{
			return $this->pk_area_artistica;
	}

	/**
	 * Asigna el valor para PK_Area_Artistica
	 * @param mixed $pk_area_artistica 
	 */
	public function setPkAreaArtistica($pk_area_artistica)
	{
			$this->pk_area_artistica=$pk_area_artistica;
	}

	/**
	 * Obtiene el valor de VC_Nom_Area
	 * @return mixed
	 */
	public function getVcNomArea()
	{
			return $this->vc_nom_area;
	}

	/**
	 * Asigna el valor para VC_Nom_Area
	 * @param mixed $vc_nom_area 
	 */
	public function setVcNomArea($vc_nom_area)
	{
			$this->vc_nom_area=$vc_nom_area;
	}

	/**
	 * Obtiene el valor de VC_Descripcion_Area
	 * @return mixed
	 */
	public function getVcDescripcionArea()
	{
			return $this->vc_descripcion_area;
	}

	/**
	 * Asigna el valor para VC_Descripcion_Area
	 * @param mixed $vc_descripcion_area 
	 */
	public function setVcDescripcionArea($vc_descripcion_area)
	{
			$this->vc_descripcion_area=$vc_descripcion_area;
	}


}
