<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_eps'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbEp 
{
	
	private $pk_id_eps;
	private $vc_nom_eps;


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
	 * Obtiene el valor de PK_Id_Eps
	 * @return mixed
	 */
	public function getPkIdEps()
	{
			return $this->pk_id_eps;
	}

	/**
	 * Asigna el valor para PK_Id_Eps
	 * @param mixed $pk_id_eps 
	 */
	public function setPkIdEps($pk_id_eps)
	{
			$this->pk_id_eps=$pk_id_eps;
	}

	/**
	 * Obtiene el valor de VC_Nom_Eps
	 * @return mixed
	 */
	public function getVcNomEps()
	{
			return $this->vc_nom_eps;
	}

	/**
	 * Asigna el valor para VC_Nom_Eps
	 * @param mixed $vc_nom_eps 
	 */
	public function setVcNomEps($vc_nom_eps)
	{
			$this->vc_nom_eps=$vc_nom_eps;
	}


}
