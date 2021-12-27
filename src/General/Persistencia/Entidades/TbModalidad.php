<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_modalidad'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbModalidad 
{
	
	private $pk_id_modalidad;
	private $fk_area_atencion;
	private $vc_nom_modalidad;


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
	 * Obtiene el valor de PK_Id_Modalidad
	 * @return mixed
	 */
	public function getPkIdModalidad()
	{
			return $this->pk_id_modalidad;
	}

	/**
	 * Asigna el valor para PK_Id_Modalidad
	 * @param mixed $pk_id_modalidad 
	 */
	public function setPkIdModalidad($pk_id_modalidad)
	{
			$this->pk_id_modalidad=$pk_id_modalidad;
	}

	/**
	 * Obtiene el valor de FK_Area_Atencion
	 * @return mixed
	 */
	public function getFkAreaAtencion()
	{
			return $this->fk_area_atencion;
	}

	/**
	 * Asigna el valor para FK_Area_Atencion
	 * @param mixed $fk_area_atencion 
	 */
	public function setFkAreaAtencion($fk_area_atencion)
	{
			$this->fk_area_atencion=$fk_area_atencion;
	}

	/**
	 * Obtiene el valor de VC_Nom_Modalidad
	 * @return mixed
	 */
	public function getVcNomModalidad()
	{
			return $this->vc_nom_modalidad;
	}

	/**
	 * Asigna el valor para VC_Nom_Modalidad
	 * @param mixed $vc_nom_modalidad 
	 */
	public function setVcNomModalidad($vc_nom_modalidad)
	{
			$this->vc_nom_modalidad=$vc_nom_modalidad;
	}


}
