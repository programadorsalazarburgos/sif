<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_areas_artisticas'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05
 */
class TbLocalidades
{

 private $FK_Id_Upz;
	private $FK_Id_Localidad;
	private $IN_Codigo_Upz;
 private $VC_Nombre_Upz;




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
	 * Obtiene el valor de Pk_Id_Localidad
	 * @return mixed
	 */
	public function getFKIdUpz()
	{
			return $this->$FK_Id_Upz;
	}

	/**
	 * Asigna el valor para FK_Id_Upz
	 * @param mixed $FK_Id_Upz
	 */
	public function setFKIdUpz($FK_Id_Upz)
	{
			$this->FK_Id_Upz=$FK_Id_Upz;
	}

	/**
	 * Obtiene el valor de FK_Id_Localidad
	 * @return mixed
	 */
	public function getFKIdLocalidad()
	{
			return $this->FK_Id_Localidad;
	}

	/**
	 * Asigna el valor para FK_Id_Localidad
	 * @param mixed $FK_Id_Localidad
	 */
	public function setFKIdLocalidad($FK_Id_Localidad)
	{
			$this->FK_Id_Localidad=$FK_Id_Localidad;
	}

	/**
	 * Obtiene el valor de IN_Codigo_Upz
	 * @return mixed
	 */
	public function getINCodigoUpz()
	{
			return $this->IN_Codigo_Upz;
	}

	/**
	 * Asigna el valor para IN_Codigo_Upz
	 * @param mixed $IN_Codigo_Upz
	 */
	public function setINCodigoUpz($IN_Codigo_Upz)
	{
			$this->IN_Codigo_Upz=$IN_Codigo_Upz;
	}

/**
	 * Obtiene el valor de VC_Nombre_Upz
	 * @return mixed
	 */
	public function getVCNombreUpz()
	{
			return $this->VC_Nombre_Upz;
	}
  /**
	 * Asigna el valor para VC_Nombre_Upz
	 * @param mixed $VC_Nombre_Upz
	 */
	public function setVCNombreUpz($VC_Nombre_Upz)
	{
			$this->VC_Nombre_Upz=$VC_Nombre_Upz;
	}

}
