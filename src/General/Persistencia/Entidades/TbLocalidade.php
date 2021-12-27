<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_localidades'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbLocalidade 
{
	
	private $pk_id_localidad;
	private $vc_nom_localidad;
	private $in_num_localidad;


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
	 * Obtiene el valor de Pk_Id_Localidad
	 * @return mixed
	 */
	public function getPkIdLocalidad()
	{
			return $this->pk_id_localidad;
	}

	/**
	 * Asigna el valor para Pk_Id_Localidad
	 * @param mixed $pk_id_localidad 
	 */
	public function setPkIdLocalidad($pk_id_localidad)
	{
			$this->pk_id_localidad=$pk_id_localidad;
	}

	/**
	 * Obtiene el valor de VC_Nom_Localidad
	 * @return mixed
	 */
	public function getVcNomLocalidad()
	{
			return $this->vc_nom_localidad;
	}

	/**
	 * Asigna el valor para VC_Nom_Localidad
	 * @param mixed $vc_nom_localidad 
	 */
	public function setVcNomLocalidad($vc_nom_localidad)
	{
			$this->vc_nom_localidad=$vc_nom_localidad;
	}

	/**
	 * Obtiene el valor de IN_Num_Localidad
	 * @return mixed
	 */
	public function getInNumLocalidad()
	{
			return $this->in_num_localidad;
	}

	/**
	 * Asigna el valor para IN_Num_Localidad
	 * @param mixed $in_num_localidad 
	 */
	public function setInNumLocalidad($in_num_localidad)
	{
			$this->in_num_localidad=$in_num_localidad;
	}


}
