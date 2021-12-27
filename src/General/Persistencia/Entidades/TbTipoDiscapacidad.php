<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_tipo_discapacidad'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbTipoDiscapacidad 
{
	
	private $pk_tipo;
	private $vc_descripcion;


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
	 * Obtiene el valor de PK_Tipo
	 * @return mixed
	 */
	public function getPkTipo()
	{
			return $this->pk_tipo;
	}

	/**
	 * Asigna el valor para PK_Tipo
	 * @param mixed $pk_tipo 
	 */
	public function setPkTipo($pk_tipo)
	{
			$this->pk_tipo=$pk_tipo;
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


}
