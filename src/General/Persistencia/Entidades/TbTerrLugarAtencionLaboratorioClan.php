<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_terr_lugar_atencion_laboratorio_clan'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbTerrLugarAtencionLaboratorioClan 
{
	
	private $pk_lugar_atencion;
	private $vc_nombre_lugar;


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
	 * Obtiene el valor de PK_lugar_atencion
	 * @return mixed
	 */
	public function getPkLugarAtencion()
	{
			return $this->pk_lugar_atencion;
	}

	/**
	 * Asigna el valor para PK_lugar_atencion
	 * @param mixed $pk_lugar_atencion 
	 */
	public function setPkLugarAtencion($pk_lugar_atencion)
	{
			$this->pk_lugar_atencion=$pk_lugar_atencion;
	}

	/**
	 * Obtiene el valor de VC_Nombre_Lugar
	 * @return mixed
	 */
	public function getVcNombreLugar()
	{
			return $this->vc_nombre_lugar;
	}

	/**
	 * Asigna el valor para VC_Nombre_Lugar
	 * @param mixed $vc_nombre_lugar 
	 */
	public function setVcNombreLugar($vc_nombre_lugar)
	{
			$this->vc_nombre_lugar=$vc_nombre_lugar;
	}


}
