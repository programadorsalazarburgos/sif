<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_sesiones_clase'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbSesionesClase 
{
	
	private $pk_id_sesion;
	private $fk_id_grupo;
	private $fk_id_persona;
	private $fk_horas_taller;
	private $dd_fecha_clase;
	private $in_num_clase;
	private $vc_observaciones;
	private $dt_fecharegistro;
	private $in_formador_suplente;
	private $vc_iden_suplente;


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
	 * Obtiene el valor de PK_Id_Sesion
	 * @return mixed
	 */
	public function getPkIdSesion()
	{
			return $this->pk_id_sesion;
	}

	/**
	 * Asigna el valor para PK_Id_Sesion
	 * @param mixed $pk_id_sesion 
	 */
	public function setPkIdSesion($pk_id_sesion)
	{
			$this->pk_id_sesion=$pk_id_sesion;
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
	 * Obtiene el valor de FK_Id_Persona
	 * @return mixed
	 */
	public function getFkIdPersona()
	{
			return $this->fk_id_persona;
	}

	/**
	 * Asigna el valor para FK_Id_Persona
	 * @param mixed $fk_id_persona 
	 */
	public function setFkIdPersona($fk_id_persona)
	{
			$this->fk_id_persona=$fk_id_persona;
	}

	/**
	 * Obtiene el valor de FK_Horas_Taller
	 * @return mixed
	 */
	public function getFkHorasTaller()
	{
			return $this->fk_horas_taller;
	}

	/**
	 * Asigna el valor para FK_Horas_Taller
	 * @param mixed $fk_horas_taller 
	 */
	public function setFkHorasTaller($fk_horas_taller)
	{
			$this->fk_horas_taller=$fk_horas_taller;
	}

	/**
	 * Obtiene el valor de DD_Fecha_Clase
	 * @return mixed
	 */
	public function getDdFechaClase()
	{
			return $this->dd_fecha_clase;
	}

	/**
	 * Asigna el valor para DD_Fecha_Clase
	 * @param mixed $dd_fecha_clase 
	 */
	public function setDdFechaClase($dd_fecha_clase)
	{
			$this->dd_fecha_clase=$dd_fecha_clase;
	}

	/**
	 * Obtiene el valor de IN_Num_Clase
	 * @return mixed
	 */
	public function getInNumClase()
	{
			return $this->in_num_clase;
	}

	/**
	 * Asigna el valor para IN_Num_Clase
	 * @param mixed $in_num_clase 
	 */
	public function setInNumClase($in_num_clase)
	{
			$this->in_num_clase=$in_num_clase;
	}

	/**
	 * Obtiene el valor de VC_Observaciones
	 * @return mixed
	 */
	public function getVcObservaciones()
	{
			return $this->vc_observaciones;
	}

	/**
	 * Asigna el valor para VC_Observaciones
	 * @param mixed $vc_observaciones 
	 */
	public function setVcObservaciones($vc_observaciones)
	{
			$this->vc_observaciones=$vc_observaciones;
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

	/**
	 * Obtiene el valor de IN_Formador_Suplente
	 * @return mixed
	 */
	public function getInFormadorSuplente()
	{
			return $this->in_formador_suplente;
	}

	/**
	 * Asigna el valor para IN_Formador_Suplente
	 * @param mixed $in_formador_suplente 
	 */
	public function setInFormadorSuplente($in_formador_suplente)
	{
			$this->in_formador_suplente=$in_formador_suplente;
	}

	/**
	 * Obtiene el valor de VC_Iden_Suplente
	 * @return mixed
	 */
	public function getVcIdenSuplente()
	{
			return $this->vc_iden_suplente;
	}

	/**
	 * Asigna el valor para VC_Iden_Suplente
	 * @param mixed $vc_iden_suplente 
	 */
	public function setVcIdenSuplente($vc_iden_suplente)
	{
			$this->vc_iden_suplente=$vc_iden_suplente;
	}


}
