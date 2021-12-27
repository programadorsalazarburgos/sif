<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_historial_asistencia'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbHistorialAsistencia 
{
	
	private $pk_id_historial_asistencia;
	private $fk_id_grupo;
	private $fk_id_sesion;
	private $vc_identificacion;
	private $vc_asistencia;
	private $dd_fechaclase;
	private $dt_fecharegistro;


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
	 * Obtiene el valor de PK_Id_Historial_Asistencia
	 * @return mixed
	 */
	public function getPkIdHistorialAsistencia()
	{
			return $this->pk_id_historial_asistencia;
	}

	/**
	 * Asigna el valor para PK_Id_Historial_Asistencia
	 * @param mixed $pk_id_historial_asistencia 
	 */
	public function setPkIdHistorialAsistencia($pk_id_historial_asistencia)
	{
			$this->pk_id_historial_asistencia=$pk_id_historial_asistencia;
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
	 * Obtiene el valor de FK_Id_Sesion
	 * @return mixed
	 */
	public function getFkIdSesion()
	{
			return $this->fk_id_sesion;
	}

	/**
	 * Asigna el valor para FK_Id_Sesion
	 * @param mixed $fk_id_sesion 
	 */
	public function setFkIdSesion($fk_id_sesion)
	{
			$this->fk_id_sesion=$fk_id_sesion;
	}

	/**
	 * Obtiene el valor de VC_Identificacion
	 * @return mixed
	 */
	public function getVcIdentificacion()
	{
			return $this->vc_identificacion;
	}

	/**
	 * Asigna el valor para VC_Identificacion
	 * @param mixed $vc_identificacion 
	 */
	public function setVcIdentificacion($vc_identificacion)
	{
			$this->vc_identificacion=$vc_identificacion;
	}

	/**
	 * Obtiene el valor de VC_Asistencia
	 * @return mixed
	 */
	public function getVcAsistencia()
	{
			return $this->vc_asistencia;
	}

	/**
	 * Asigna el valor para VC_Asistencia
	 * @param mixed $vc_asistencia 
	 */
	public function setVcAsistencia($vc_asistencia)
	{
			$this->vc_asistencia=$vc_asistencia;
	}

	/**
	 * Obtiene el valor de DD_FechaClase
	 * @return mixed
	 */
	public function getDdFechaclase()
	{
			return $this->dd_fechaclase;
	}

	/**
	 * Asigna el valor para DD_FechaClase
	 * @param mixed $dd_fechaclase 
	 */
	public function setDdFechaclase($dd_fechaclase)
	{
			$this->dd_fechaclase=$dd_fechaclase;
	}

	/**
	 * Obtiene el valor de DT_FechaRegistro
	 * @return mixed
	 */
	public function getDtFecharegistro()
	{
			return $this->dt_fecharegistro;
	}

	/**
	 * Asigna el valor para DT_FechaRegistro
	 * @param mixed $dt_fecharegistro 
	 */
	public function setDtFecharegistro($dt_fecharegistro)
	{
			$this->dt_fecharegistro=$dt_fecharegistro;
	}


}
