<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_salones_area'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbSalonesArea 
{
	
	private $pk_id_salon_area;
	private $fk_id_salon;
	private $pk_area_artistica;


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
	 * Obtiene el valor de PK_Id_Salon_Area
	 * @return mixed
	 */
	public function getPkIdSalonArea()
	{
			return $this->pk_id_salon_area;
	}

	/**
	 * Asigna el valor para PK_Id_Salon_Area
	 * @param mixed $pk_id_salon_area 
	 */
	public function setPkIdSalonArea($pk_id_salon_area)
	{
			$this->pk_id_salon_area=$pk_id_salon_area;
	}

	/**
	 * Obtiene el valor de FK_Id_Salon
	 * @return mixed
	 */
	public function getFkIdSalon()
	{
			return $this->fk_id_salon;
	}

	/**
	 * Asigna el valor para FK_Id_Salon
	 * @param mixed $fk_id_salon 
	 */
	public function setFkIdSalon($fk_id_salon)
	{
			$this->fk_id_salon=$fk_id_salon;
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


}
