<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_grado'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbGrado 
{
	
	private $pk_id_grado;
	private $vc_descripcion_grado;


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
	 * Obtiene el valor de PK_Id_Grado
	 * @return mixed
	 */
	public function getPkIdGrado()
	{
			return $this->pk_id_grado;
	}

	/**
	 * Asigna el valor para PK_Id_Grado
	 * @param mixed $pk_id_grado 
	 */
	public function setPkIdGrado($pk_id_grado)
	{
			$this->pk_id_grado=$pk_id_grado;
	}

	/**
	 * Obtiene el valor de VC_Descripcion_Grado
	 * @return mixed
	 */
	public function getVcDescripcionGrado()
	{
			return $this->vc_descripcion_grado;
	}

	/**
	 * Asigna el valor para VC_Descripcion_Grado
	 * @param mixed $vc_descripcion_grado 
	 */
	public function setVcDescripcionGrado($vc_descripcion_grado)
	{
			$this->vc_descripcion_grado=$vc_descripcion_grado;
	}


}
