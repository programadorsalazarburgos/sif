<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_recurso'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbRecurso 
{
	
	private $pk_id_recurso;
	private $vc_nombre;
	private $vc_tipo;


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
	 * Obtiene el valor de PK_Id_Recurso
	 * @return mixed
	 */
	public function getPkIdRecurso()
	{
			return $this->pk_id_recurso;
	}

	/**
	 * Asigna el valor para PK_Id_Recurso
	 * @param mixed $pk_id_recurso 
	 */
	public function setPkIdRecurso($pk_id_recurso)
	{
			$this->pk_id_recurso=$pk_id_recurso;
	}

	/**
	 * Obtiene el valor de VC_Nombre
	 * @return mixed
	 */
	public function getVcNombre()
	{
			return $this->vc_nombre;
	}

	/**
	 * Asigna el valor para VC_Nombre
	 * @param mixed $vc_nombre 
	 */
	public function setVcNombre($vc_nombre)
	{
			$this->vc_nombre=$vc_nombre;
	}

	/**
	 * Obtiene el valor de VC_Tipo
	 * @return mixed
	 */
	public function getVcTipo()
	{
			return $this->vc_tipo;
	}

	/**
	 * Asigna el valor para VC_Tipo
	 * @param mixed $vc_tipo 
	 */
	public function setVcTipo($vc_tipo)
	{
			$this->vc_tipo=$vc_tipo;
	}


}
