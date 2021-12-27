<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_formador_area_artistica'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbFormadorAreaArtistica 
{
	
	private $pk_formador_area;
	private $vc_formador;
	private $fk_area_artistica;


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
	 * Obtiene el valor de PK_Formador_Area
	 * @return mixed
	 */
	public function getPkFormadorArea()
	{
			return $this->pk_formador_area;
	}

	/**
	 * Asigna el valor para PK_Formador_Area
	 * @param mixed $pk_formador_area 
	 */
	public function setPkFormadorArea($pk_formador_area)
	{
			$this->pk_formador_area=$pk_formador_area;
	}

	/**
	 * Obtiene el valor de VC_Formador
	 * @return mixed
	 */
	public function getVcFormador()
	{
			return $this->vc_formador;
	}

	/**
	 * Asigna el valor para VC_Formador
	 * @param mixed $vc_formador 
	 */
	public function setVcFormador($vc_formador)
	{
			$this->vc_formador=$vc_formador;
	}

	/**
	 * Obtiene el valor de FK_Area_Artistica
	 * @return mixed
	 */
	public function getFkAreaArtistica()
	{
			return $this->fk_area_artistica;
	}

	/**
	 * Asigna el valor para FK_Area_Artistica
	 * @param mixed $fk_area_artistica 
	 */
	public function setFkAreaArtistica($fk_area_artistica)
	{
			$this->fk_area_artistica=$fk_area_artistica;
	}


}
