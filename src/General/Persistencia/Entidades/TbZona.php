<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_zonas'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbZona 
{
	
	private $pk_id_zona;
	private $vc_nombre_zona;
	private $vc_localidades;


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
	 * Obtiene el valor de PK_Id_Zona
	 * @return mixed
	 */
	public function getPkIdZona()
	{
			return $this->pk_id_zona;
	}

	/**
	 * Asigna el valor para PK_Id_Zona
	 * @param mixed $pk_id_zona 
	 */
	public function setPkIdZona($pk_id_zona)
	{
			$this->pk_id_zona=$pk_id_zona;
	}

	/**
	 * Obtiene el valor de VC_Nombre_Zona
	 * @return mixed
	 */
	public function getVcNombreZona()
	{
			return $this->vc_nombre_zona;
	}

	/**
	 * Asigna el valor para VC_Nombre_Zona
	 * @param mixed $vc_nombre_zona 
	 */
	public function setVcNombreZona($vc_nombre_zona)
	{
			$this->vc_nombre_zona=$vc_nombre_zona;
	}

	/**
	 * Obtiene el valor de VC_Localidades
	 * @return mixed
	 */
	public function getVcLocalidades()
	{
			return $this->vc_localidades;
	}

	/**
	 * Asigna el valor para VC_Localidades
	 * @param mixed $vc_localidades 
	 */
	public function setVcLocalidades($vc_localidades)
	{
			$this->vc_localidades=$vc_localidades;
	}


}
