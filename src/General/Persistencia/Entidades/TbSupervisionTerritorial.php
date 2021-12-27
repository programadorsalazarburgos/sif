<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_supervision_territorial'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbSupervisionTerritorial 
{
	
	private $pk_supervicion_territorio;
	private $in_fk_localidad;
	private $vc_iden_territorial;


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
	 * Obtiene el valor de PK_Supervicion_Territorio
	 * @return mixed
	 */
	public function getPkSupervicionTerritorio()
	{
			return $this->pk_supervicion_territorio;
	}

	/**
	 * Asigna el valor para PK_Supervicion_Territorio
	 * @param mixed $pk_supervicion_territorio 
	 */
	public function setPkSupervicionTerritorio($pk_supervicion_territorio)
	{
			$this->pk_supervicion_territorio=$pk_supervicion_territorio;
	}

	/**
	 * Obtiene el valor de IN_FK_Localidad
	 * @return mixed
	 */
	public function getInFkLocalidad()
	{
			return $this->in_fk_localidad;
	}

	/**
	 * Asigna el valor para IN_FK_Localidad
	 * @param mixed $in_fk_localidad 
	 */
	public function setInFkLocalidad($in_fk_localidad)
	{
			$this->in_fk_localidad=$in_fk_localidad;
	}

	/**
	 * Obtiene el valor de VC_Iden_Territorial
	 * @return mixed
	 */
	public function getVcIdenTerritorial()
	{
			return $this->vc_iden_territorial;
	}

	/**
	 * Asigna el valor para VC_Iden_Territorial
	 * @param mixed $vc_iden_territorial 
	 */
	public function setVcIdenTerritorial($vc_iden_territorial)
	{
			$this->vc_iden_territorial=$vc_iden_territorial;
	}


}
