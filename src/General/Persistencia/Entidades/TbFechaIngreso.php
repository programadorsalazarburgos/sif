<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_fecha_ingreso'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbFechaIngreso 
{
	
	private $pk_id_fecha_ingreso;
	private $fk_id_estudiante;
	private $dd_fecha_ingreso;


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
	 * Obtiene el valor de PK_Id_Fecha_Ingreso
	 * @return mixed
	 */
	public function getPkIdFechaIngreso()
	{
			return $this->pk_id_fecha_ingreso;
	}

	/**
	 * Asigna el valor para PK_Id_Fecha_Ingreso
	 * @param mixed $pk_id_fecha_ingreso 
	 */
	public function setPkIdFechaIngreso($pk_id_fecha_ingreso)
	{
			$this->pk_id_fecha_ingreso=$pk_id_fecha_ingreso;
	}

	/**
	 * Obtiene el valor de FK_Id_Estudiante
	 * @return mixed
	 */
	public function getFkIdEstudiante()
	{
			return $this->fk_id_estudiante;
	}

	/**
	 * Asigna el valor para FK_Id_Estudiante
	 * @param mixed $fk_id_estudiante 
	 */
	public function setFkIdEstudiante($fk_id_estudiante)
	{
			$this->fk_id_estudiante=$fk_id_estudiante;
	}

	/**
	 * Obtiene el valor de DD_Fecha_Ingreso
	 * @return mixed
	 */
	public function getDdFechaIngreso()
	{
			return $this->dd_fecha_ingreso;
	}

	/**
	 * Asigna el valor para DD_Fecha_Ingreso
	 * @param mixed $dd_fecha_ingreso 
	 */
	public function setDdFechaIngreso($dd_fecha_ingreso)
	{
			$this->dd_fecha_ingreso=$dd_fecha_ingreso;
	}


}
