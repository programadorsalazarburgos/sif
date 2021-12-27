<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_tipo_identificacion_simat'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbTipoIdentificacionSimat 
{
	
	private $pk_id_tipo;
	private $vc_descripcion;
	private $vc_abreviacion;


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
	 * Obtiene el valor de PK_Id_Tipo
	 * @return mixed
	 */
	public function getPkIdTipo()
	{
			return $this->pk_id_tipo;
	}

	/**
	 * Asigna el valor para PK_Id_Tipo
	 * @param mixed $pk_id_tipo 
	 */
	public function setPkIdTipo($pk_id_tipo)
	{
			$this->pk_id_tipo=$pk_id_tipo;
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

	/**
	 * Obtiene el valor de VC_Abreviacion
	 * @return mixed
	 */
	public function getVcAbreviacion()
	{
			return $this->vc_abreviacion;
	}

	/**
	 * Asigna el valor para VC_Abreviacion
	 * @param mixed $vc_abreviacion 
	 */
	public function setVcAbreviacion($vc_abreviacion)
	{
			$this->vc_abreviacion=$vc_abreviacion;
	}


}
