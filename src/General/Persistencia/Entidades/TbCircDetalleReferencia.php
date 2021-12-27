<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_circ_detalle_referencia'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbCircDetalleReferencia 
{
	
	private $pk_id_detalle;
	private $vc_descripcion;
	private $fk_id_referencia;


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
	 * Obtiene el valor de PK_Id_Detalle
	 * @return mixed
	 */
	public function getPkIdDetalle()
	{
			return $this->pk_id_detalle;
	}

	/**
	 * Asigna el valor para PK_Id_Detalle
	 * @param mixed $pk_id_detalle 
	 */
	public function setPkIdDetalle($pk_id_detalle)
	{
			$this->pk_id_detalle=$pk_id_detalle;
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
	 * Obtiene el valor de FK_Id_Referencia
	 * @return mixed
	 */
	public function getFkIdReferencia()
	{
			return $this->fk_id_referencia;
	}

	/**
	 * Asigna el valor para FK_Id_Referencia
	 * @param mixed $fk_id_referencia 
	 */
	public function setFkIdReferencia($fk_id_referencia)
	{
			$this->fk_id_referencia=$fk_id_referencia;
	}


}
