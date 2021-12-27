<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_lineas_atencion'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbLineasAtencion 
{
	
	private $pk_id_linea;
	private $vc_linea_atencion;
	private $vc_descripcion_linea;


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
	 * Obtiene el valor de PK_Id_Linea
	 * @return mixed
	 */
	public function getPkIdLinea()
	{
			return $this->pk_id_linea;
	}

	/**
	 * Asigna el valor para PK_Id_Linea
	 * @param mixed $pk_id_linea 
	 */
	public function setPkIdLinea($pk_id_linea)
	{
			$this->pk_id_linea=$pk_id_linea;
	}

	/**
	 * Obtiene el valor de VC_Linea_Atencion
	 * @return mixed
	 */
	public function getVcLineaAtencion()
	{
			return $this->vc_linea_atencion;
	}

	/**
	 * Asigna el valor para VC_Linea_Atencion
	 * @param mixed $vc_linea_atencion 
	 */
	public function setVcLineaAtencion($vc_linea_atencion)
	{
			$this->vc_linea_atencion=$vc_linea_atencion;
	}

	/**
	 * Obtiene el valor de VC_Descripcion_Linea
	 * @return mixed
	 */
	public function getVcDescripcionLinea()
	{
			return $this->vc_descripcion_linea;
	}

	/**
	 * Asigna el valor para VC_Descripcion_Linea
	 * @param mixed $vc_descripcion_linea 
	 */
	public function setVcDescripcionLinea($vc_descripcion_linea)
	{
			$this->vc_descripcion_linea=$vc_descripcion_linea;
	}


}
