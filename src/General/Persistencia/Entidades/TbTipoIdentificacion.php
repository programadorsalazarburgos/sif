<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_tipo_identificacion'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbTipoIdentificacion 
{
	
	private $fk_tipo_identificacion;
	private $vc_nom_identificacion;


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
	 * Obtiene el valor de FK_Tipo_Identificacion
	 * @return mixed
	 */
	public function getFkTipoIdentificacion()
	{
			return $this->fk_tipo_identificacion;
	}

	/**
	 * Asigna el valor para FK_Tipo_Identificacion
	 * @param mixed $fk_tipo_identificacion 
	 */
	public function setFkTipoIdentificacion($fk_tipo_identificacion)
	{
			$this->fk_tipo_identificacion=$fk_tipo_identificacion;
	}

	/**
	 * Obtiene el valor de VC_Nom_Identificacion
	 * @return mixed
	 */
	public function getVcNomIdentificacion()
	{
			return $this->vc_nom_identificacion;
	}

	/**
	 * Asigna el valor para VC_Nom_Identificacion
	 * @param mixed $vc_nom_identificacion 
	 */
	public function setVcNomIdentificacion($vc_nom_identificacion)
	{
			$this->vc_nom_identificacion=$vc_nom_identificacion;
	}


}
