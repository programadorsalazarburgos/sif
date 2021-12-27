<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_estudiante_grupo'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbEstudianteGrupo 
{
	
	private $pk_id_estgru;
	private $fk_id_estudiante;
	private $fk_id_clan;
	private $fk_id_grupo;
	private $dd_fecha_ingreso;
	private $dd_fecha_retiro;
	private $vc_estado_est;


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
	 * Obtiene el valor de PK_Id_EstGru
	 * @return mixed
	 */
	public function getPkIdEstgru()
	{
			return $this->pk_id_estgru;
	}

	/**
	 * Asigna el valor para PK_Id_EstGru
	 * @param mixed $pk_id_estgru 
	 */
	public function setPkIdEstgru($pk_id_estgru)
	{
			$this->pk_id_estgru=$pk_id_estgru;
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
	 * Obtiene el valor de FK_Id_Clan
	 * @return mixed
	 */
	public function getFkIdClan()
	{
			return $this->fk_id_clan;
	}

	/**
	 * Asigna el valor para FK_Id_Clan
	 * @param mixed $fk_id_clan 
	 */
	public function setFkIdClan($fk_id_clan)
	{
			$this->fk_id_clan=$fk_id_clan;
	}

	/**
	 * Obtiene el valor de FK_Id_Grupo
	 * @return mixed
	 */
	public function getFkIdGrupo()
	{
			return $this->fk_id_grupo;
	}

	/**
	 * Asigna el valor para FK_Id_Grupo
	 * @param mixed $fk_id_grupo 
	 */
	public function setFkIdGrupo($fk_id_grupo)
	{
			$this->fk_id_grupo=$fk_id_grupo;
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

	/**
	 * Obtiene el valor de DD_Fecha_retiro
	 * @return mixed
	 */
	public function getDdFechaRetiro()
	{
			return $this->dd_fecha_retiro;
	}

	/**
	 * Asigna el valor para DD_Fecha_retiro
	 * @param mixed $dd_fecha_retiro 
	 */
	public function setDdFechaRetiro($dd_fecha_retiro)
	{
			$this->dd_fecha_retiro=$dd_fecha_retiro;
	}

	/**
	 * Obtiene el valor de VC_Estado_Est
	 * @return mixed
	 */
	public function getVcEstadoEst()
	{
			return $this->vc_estado_est;
	}

	/**
	 * Asigna el valor para VC_Estado_Est
	 * @param mixed $vc_estado_est 
	 */
	public function setVcEstadoEst($vc_estado_est)
	{
			$this->vc_estado_est=$vc_estado_est;
	}


}
