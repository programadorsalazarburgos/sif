<?php 

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_nidos_Jardin'
 *
 * @author: Juan Torres, gracias a http://phpdao.com
 * @date: 2018-04-05 11:05
 */
class TbNidosExperiencia
{
	private $pk_id_experiencia;
	private $fk_id_lugar_atencion;
	private $fk_id_dupla;
	private $fk_id_grupo;
	private $vc_nombre_experiencia;
	private $dt_fecha_encuentro;
	private $hr_hora_inicio;
	private $hr_hora_finalizacion;
	private $in_cuidadores;
	private $dt_fecha_registro;
	private $in_id_persona;
	private $in_tipo_suplencia;
	private $in_aprobacion;
	private $dt_fecha_aprobacion;
    private $beneficiario_array;
	private $in_modalidad;

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
	 * Obtiene el valor de pk_id_experiencia
	 * @return mixed
	 */
	public function getPkIdExperiencia()
	{
			return $this->pk_id_experiencia;
	}
	/**
	 * Asigna el valor para pk_id_experiencia
	 * @param mixed $pk_id_experiencia
	 */
	public function setPkIdExperiencia($pk_id_experiencia)
	{
			$this->pk_id_experiencia=$pk_id_experiencia;
	}

	/**
	 * Obtiene el valor de fk_id_lugar_atencion
	 * @return mixed
	 */
	public function getFkIdLugarAtencion()
	{
			return $this->fk_id_lugar_atencion;
	}
	/**
	 * Asigna el valor para fk_id_lugar_atencion
	 * @param mixed $fk_id_lugar_atencion
	 */
	public function setFkIdLugarAtencion($fk_id_lugar_atencion)
	{
			$this->fk_id_lugar_atencion=$fk_id_lugar_atencion;
	}

	/**
	 * Obtiene el valor de fk_id_dupla
	 * @return mixed
	 */
	public function getFkIdDupla()
	{
			return $this->fk_id_dupla;
	}
	/**
	 * Asigna el valor para fk_id_dupla
	 * @param mixed $fk_id_dupla
	 */
	public function setFkIdDupla($fk_id_dupla)
	{
			$this->fk_id_dupla=$fk_id_dupla;
	}

	/**
	 * Obtiene el valor de fk_id_grupo
	 * @return mixed
	 */
	public function getFkIdGrupo()
	{
			return $this->fk_id_grupo;
	}
	/**
	 * Asigna el valor para fk_id_grupo
	 * @param mixed $fk_id_grupo
	 */
	public function setFkIdGrupo($fk_id_grupo)
	{
			$this->fk_id_grupo=$fk_id_grupo;
	}

	/**
	 * Obtiene el valor de vc_nombre_experiencia
	 * @return mixed
	 */
	public function getVcNombreExperiencia()
	{
			return $this->vc_nombre_experiencia;
	}
	/**
	 * Asigna el valor para vc_nombre_experiencia
	 * @param mixed $vc_nombre_experiencia
	 */
	public function setVcNombreExperiencia($vc_nombre_experiencia)
	{
			$this->vc_nombre_experiencia=$vc_nombre_experiencia;
	}

	/**
 	* Obtiene el valor de dt_fecha_encuentro
 	* @return mixed
 	*/
	public function getDtFechaEncuentro()
	{
			return $this->dt_fecha_encuentro;
	}
 /**
  * Asigna el valor para dt_fecha_encuentro
  * @param mixed $dt_fecha_encuentro
  */
	public function setDtFechaEncuentro($dt_fecha_encuentro)
  {
	 		$this->dt_fecha_encuentro=$dt_fecha_encuentro;
  }

	/**
	* Obtiene el valor de hr_hora_inicio
	* @return mixed
	*/
	public function getHrHoraInicio()
	{
			return $this->hr_hora_inicio;
	}
	/**
	* Asigna el valor para hr_hora_inicio
	* @param mixed $hr_hora_inicio
	*/
	public function setHrHoraInicio($hr_hora_inicio)
	{
			$this->hr_hora_inicio=$hr_hora_inicio;
	}

	/**
	* Obtiene el valor de hr_hora_finalizacion
	* @return mixed
	*/
	public function getHrHoraFinalizacion()
	{
			return $this->hr_hora_finalizacion;
	}
	/**
	* Asigna el valor para hr_hora_finalizacion
	* @param mixed $hr_hora_finalizacion
	*/
	public function setHrHoraFinalizacion($hr_hora_finalizacion)
	{
			$this->hr_hora_finalizacion=$hr_hora_finalizacion;
	}

    /** 
	* Obtiene el valor de in_cuidadores
	* @return mixed
	*/
	public function getInCuidadores()  
	{
			return $this->in_cuidadores;
	}
	/**
	* Asigna el valor para in_cuidadores
	* @param mixed $in_cuidadores
	*/
	public function setInCuidadores($in_cuidadores)
	{
			$this->in_cuidadores=$in_cuidadores;
	}

	/**
	* Obtiene el valor de dt_fecha_registro
	* @return mixed
	*/
	public function getDtFechaRegistro()
	{
			return $this->dt_fecha_registro;
	}
	/**
	* Asigna el valor para dt_fecha_registro
	* @param mixed $dt_fecha_registro
	*/
	public function setDtFechaRegistro($dt_fecha_registro)
	{
			$this->dt_fecha_registro=$dt_fecha_registro;
	}

	/**
	* Obtiene el valor de in_id_persona
	* @return mixed
	*/
	public function getInIdPersona()
	{
			return $this->in_id_persona;
	}
	/**
	* Asigna el valor para in_id_persona
	* @param mixed $in_id_persona
	*/
	public function setInIdPersona($in_id_persona)
	{
			$this->in_id_persona=$in_id_persona;
	}

	/**
	* Obtiene el valor de in_tipo_suplencia
	* @return mixed
	*/
	public function getIntTipoSuplencia()
	{
			return $this->in_tipo_suplencia;
	}
	/**
	* Asigna el valor para $in_tipo_suplencia
	* @param mixed $in_tipo_suplencia
	*/
	public function setIntTipoSuplencia($in_tipo_suplencia)
	{
			$this->in_tipo_suplencia=$in_tipo_suplencia;
	}

/**
	* Obtiene el valor de IN_Aprobacion 
	* @return mixed
	*/
	public function getInAprobacion()
	{
			return $this->in_aprobacion;
	}
	/**
	* Asigna el valor para $IN_Aprobacion
	* @param mixed $IN_Aprobacion
	*/
	public function setInAprobacion($in_aprobacion)
	{
			$this->in_aprobacion=$in_aprobacion;
	}


/**
	* Obtiene el valor de dt_fecha_aprobacion 
	* @return mixed
	*/
	public function getFechaAprobacion()
	{
			return $this->dt_fecha_aprobacion;
	}
	/**
	* Asigna el valor para $dt_fecha_aprobacion
	* @param mixed $dt_fecha_aprobacion
	*/
	public function setFechaAprobacion($dt_fecha_aprobacion)
	{
			$this->dt_fecha_aprobacion=$dt_fecha_aprobacion;
	}

	/**
	 * @return mixed
	*/
	public function getBeneficiarioArray()
	{
	     return $this->beneficiario_array;
	}
	 /**
	 * @param mixed $beneficiario_array
	 */
  public function setBeneficiarioArray($beneficiario_array)
	{
	     $this->beneficiario_array = $beneficiario_array;
	}

	/**
	* Obtiene el valor de in_modalidad 
	* @return mixed
	*/
	public function getInModalidad()
	{
			return $this->in_modalidad;
	}
	/**
	* Asigna el valor para $in_modalidad
	* @param mixed $in_modalidad
	*/
	public function setInModalidad($in_modalidad)
	{
			$this->in_modalidad=$in_modalidad;
	}
}
