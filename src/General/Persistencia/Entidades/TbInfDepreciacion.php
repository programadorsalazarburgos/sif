<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_inf_depreciacion'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbInfDepreciacion 
{
	
	private $pk_id_depreciacion;
	private $fk_id_inventario;
	private $da_fecha;
	private $fl_valor_depreciado;


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
	 * Obtiene el valor de PK_Id_Depreciacion
	 * @return mixed
	 */
	public function getPkIdDepreciacion()
	{
			return $this->pk_id_depreciacion;
	}

	/**
	 * Asigna el valor para PK_Id_Depreciacion
	 * @param mixed $pk_id_depreciacion 
	 */
	public function setPkIdDepreciacion($pk_id_depreciacion)
	{
			$this->pk_id_depreciacion=$pk_id_depreciacion;
	}

	/**
	 * Obtiene el valor de FK_Id_Inventario
	 * @return mixed
	 */
	public function getFkIdInventario()
	{
			return $this->fk_id_inventario;
	}

	/**
	 * Asigna el valor para FK_Id_Inventario
	 * @param mixed $fk_id_inventario 
	 */
	public function setFkIdInventario($fk_id_inventario)
	{
			$this->fk_id_inventario=$fk_id_inventario;
	}

	/**
	 * Obtiene el valor de DA_Fecha
	 * @return mixed
	 */
	public function getDaFecha()
	{
			return $this->da_fecha;
	}

	/**
	 * Asigna el valor para DA_Fecha
	 * @param mixed $da_fecha 
	 */
	public function setDaFecha($da_fecha)
	{
			$this->da_fecha=$da_fecha;
	}

	/**
	 * Obtiene el valor de FL_Valor_Depreciado
	 * @return mixed
	 */
	public function getFlValorDepreciado()
	{
			return $this->fl_valor_depreciado;
	}

	/**
	 * Asigna el valor para FL_Valor_Depreciado
	 * @param mixed $fl_valor_depreciado 
	 */
	public function setFlValorDepreciado($fl_valor_depreciado)
	{
			$this->fl_valor_depreciado=$fl_valor_depreciado;
	}


}
