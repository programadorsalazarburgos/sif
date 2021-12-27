<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_grupo_poblacional'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbGrupoPoblacional 
{
	
	private $pk_gpoblacional;
	private $vc_nom_gpoblacional;


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
	 * Obtiene el valor de PK_GPoblacional
	 * @return mixed
	 */
	public function getPkGpoblacional()
	{
			return $this->pk_gpoblacional;
	}

	/**
	 * Asigna el valor para PK_GPoblacional
	 * @param mixed $pk_gpoblacional 
	 */
	public function setPkGpoblacional($pk_gpoblacional)
	{
			$this->pk_gpoblacional=$pk_gpoblacional;
	}

	/**
	 * Obtiene el valor de VC_Nom_GPoblacional
	 * @return mixed
	 */
	public function getVcNomGpoblacional()
	{
			return $this->vc_nom_gpoblacional;
	}

	/**
	 * Asigna el valor para VC_Nom_GPoblacional
	 * @param mixed $vc_nom_gpoblacional 
	 */
	public function setVcNomGpoblacional($vc_nom_gpoblacional)
	{
			$this->vc_nom_gpoblacional=$vc_nom_gpoblacional;
	}


}
