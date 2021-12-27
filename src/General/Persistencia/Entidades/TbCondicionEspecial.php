<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_condicion_especial'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbCondicionEspecial 
{
	
	private $pk_id_condicion;
	private $vc_condicion;


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
	 * Obtiene el valor de PK_Id_Condicion
	 * @return mixed
	 */
	public function getPkIdCondicion()
	{
			return $this->pk_id_condicion;
	}

	/**
	 * Asigna el valor para PK_Id_Condicion
	 * @param mixed $pk_id_condicion 
	 */
	public function setPkIdCondicion($pk_id_condicion)
	{
			$this->pk_id_condicion=$pk_id_condicion;
	}

	/**
	 * Obtiene el valor de VC_Condicion
	 * @return mixed
	 */
	public function getVcCondicion()
	{
			return $this->vc_condicion;
	}

	/**
	 * Asigna el valor para VC_Condicion
	 * @param mixed $vc_condicion 
	 */
	public function setVcCondicion($vc_condicion)
	{
			$this->vc_condicion=$vc_condicion;
	}


}
