<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_salones'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbSalone 
{
	
	private $pk_id_salon;
	private $fk_id_clan;
	private $vc_nom_salon;
	private $vc_descripcion;
	private $in_capacidad;


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
	 * Obtiene el valor de PK_Id_Salon
	 * @return mixed
	 */
	public function getPkIdSalon()
	{
			return $this->pk_id_salon;
	}

	/**
	 * Asigna el valor para PK_Id_Salon
	 * @param mixed $pk_id_salon 
	 */
	public function setPkIdSalon($pk_id_salon)
	{
			$this->pk_id_salon=$pk_id_salon;
	}

	/**
	 * Obtiene el valor de FK_Id_Clan
	 * @return mixed
	 */
	public function getFkIdClan()
	{
			return $this->fk_id_clan;
	}

	/**
	 * Asigna el valor para FK_Id_Clan
	 * @param mixed $fk_id_clan 
	 */
	public function setFkIdClan($fk_id_clan)
	{
			$this->fk_id_clan=$fk_id_clan;
	}

	/**
	 * Obtiene el valor de VC_Nom_Salon
	 * @return mixed
	 */
	public function getVcNomSalon()
	{
			return $this->vc_nom_salon;
	}

	/**
	 * Asigna el valor para VC_Nom_Salon
	 * @param mixed $vc_nom_salon 
	 */
	public function setVcNomSalon($vc_nom_salon)
	{
			$this->vc_nom_salon=$vc_nom_salon;
	}

	/**
	 * Obtiene el valor de VC_Descripcion
	 * @return mixed
	 */
	public function getVcDescripcion()
	{
			return $this->vc_descripcion;
	}

	/**
	 * Asigna el valor para VC_Descripcion
	 * @param mixed $vc_descripcion 
	 */
	public function setVcDescripcion($vc_descripcion)
	{
			$this->vc_descripcion=$vc_descripcion;
	}

	/**
	 * Obtiene el valor de IN_Capacidad
	 * @return mixed
	 */
	public function getInCapacidad()
	{
			return $this->in_capacidad;
	}

	/**
	 * Asigna el valor para IN_Capacidad
	 * @param mixed $in_capacidad 
	 */
	public function setInCapacidad($in_capacidad)
	{
			$this->in_capacidad=$in_capacidad;
	}


}
