<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_nidos_grupos'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05
 */
class TbNidosGrupos
{

	private $pk_id_grupo;
	private $fk_id_estrategia_atencion;
	private $fk_id_lugar_atencion;
	private $vc_nombre_grupo;
	private $fk_id_dupla;
	private $fk_id_nivel_escolaridad;
	private $vc_profesional;
	private $in_estado;
	private $dt_fecha_creacion;
	private $fk_id_usuario_creacion;
	private $fk_id_tipo_grupo;
	private $fk_id_entidad_grupo;
	private $fk_id_lugar_grupo_laboratorio;


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


		/* tabla grupos nidos*/

			/**
			 * Obtiene el valor de pk_id_grupo
			 * @return mixed
			 */
			public function getIdGrupo()
			{
					return $this->pk_id_grupo;
			}

			/**
			 * Asigna el valor para pk_id_grupo
			 * @param mixed $pk_id_grupo
			 */
			public function setIdGrupo($pk_id_grupo)
			{
					$this->pk_id_grupo=$pk_id_grupo;
			}

	/**
	 * Obtiene el valor de fk_id_estrategia_atencion
	 * @return mixed
	 */
	public function getFkEstrategiaAtencion()
	{
			return $this->fk_id_estrategia_atencion;
	}

	/**
	 * Asigna el valor para fk_id_estrategia_atencion
	 * @param mixed $fk_id_estrategia_atencion
	 */
	public function setFkEstrategiaAtencion($fk_id_estrategia_atencion)
	{
			$this->fk_id_estrategia_atencion=$fk_id_estrategia_atencion;
	}

	/**
	 * Obtiene el valor de fk_id_lugar_atencion
	 * @return mixed
	 */
	public function getFkLugarAtencion()
	{
			return $this->fk_id_lugar_atencion;
	}

	/**
	 * Asigna el valor para fk_id_lugar_atencion
	 * @param mixed fk_id_lugar_atencion
	 */
	public function setFkLugarAtencion($fk_id_lugar_atencion)
	{
			$this->fk_id_lugar_atencion=$fk_id_lugar_atencion;
	}

	/**
	 * Obtiene el valor de vc_nombre_grupo
	 * @return mixed
	 */
	public function getVcNombreGrupo()
	{
			return $this->vc_nombre_grupo;
	}

	/**
	 * Asigna el valor para $vc_nombre_grupo
	 * @param mixed $vc_nombre_grupo
	 */
	public function setVcNombreGrupo($vc_nombre_grupo)
	{
			$this->vc_nombre_grupo=$vc_nombre_grupo;
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
	 * Asigna el valor para $fk_id_dupla
	 * @param mixed $fk_id_dupla
	 */
	public function setFkIdDupla($fk_id_dupla)
	{
			$this->fk_id_dupla=$fk_id_dupla;
	}

	/**
	 * Obtiene el valor de $fk_id_nivel_escolaridad
	 * @return mixed
	 */
	public function getFkIdNivelEscolaridad()
	{
			return $this->fk_id_nivel_escolaridad;
	}

	/**
	 * Asigna el valor para $fk_id_nivel_escolaridad
	 * @param mixed $fk_id_nivel_escolaridad
	 */
	public function setFkIdNivelEscolaridad($fk_id_nivel_escolaridad)
	{
			$this->fk_id_nivel_escolaridad=$fk_id_nivel_escolaridad;
	}

	/**
	 * Obtiene el valor de vc_profesional
	 * @return mixed
	 */
	public function getVcProfesional()
	{
			return $this->vc_profesional;
	}

	/**
	 * Asigna el valor para $vc_profesional
	 * @param mixed $vc_profesional
	 */
	public function setVcProfesional($vc_profesional)
	{
			$this->vc_profesional=$vc_profesional;
	}

	/**
	 * Obtiene el valor de in_estado
	 * @return mixed
	 */
	public function getInEstado()
	{
			return $this->in_estado;
	}

	/**
	 * Asigna el valor para $in_estado
	 * @param mixed $in_estado
	 */
	public function setInEstado($in_estado)
	{
			$this->in_estado=$in_estado;
	}

	/**
	 * Obtiene el valor de dt_fecha_creacion
	 * @return mixed
	 */
	public function getDtFechaCreacion()
	{
			return $this->dt_fecha_creacion;
	}

	/**
	 * Asigna el valor $para dt_fecha_creacion
	 * @param mixed $dt_fecha_creacion
	 */
	public function setDtFechaCreacion($dt_fecha_creacion)
	{
			$this->dt_fecha_creacion=$dt_fecha_creacion;
	}

	/**
	 * Obtiene el valor de fk_id_usuario_creacion
	 * @return mixed
	 */
	public function getFkIdUsuarioCreacion()
	{
			return $this->fk_id_usuario_creacion;
	}

	/**
	 * Asigna el valor para fk_id_usuario_creacion
	 * @param mixed $fk_id_usuario_creacion
	 */
	public function setFkIdUsuarioCreacion($fk_id_usuario_creacion)
	{
			$this->fk_id_usuario_creacion=$fk_id_usuario_creacion;
	}

	/**
	 * Obtiene el valor de fk_id_tipo_grupo
	 * @return mixed
	 */
	public function getFkIdTipoGrupo()
	{
			return $this->fk_id_tipo_grupo;
	}

	/**
	 * Asigna el valor para fk_id_tipo_grupo
	 * @param mixed $fk_id_tipo_grupo
	 */
	public function setFkIdTipoGrupo($fk_id_tipo_grupo)
	{
			$this->fk_id_tipo_grupo=$fk_id_tipo_grupo;
	}

/**
	 * Obtiene el valor de $fk_id_entidad_grupo
	 * @return mixed
	 */
	public function getFkIdEntidadGrupo()
	{
			return $this->fk_id_entidad_grupo;
	}

	/**
	 * Asigna el valor para $fk_id_entidad_grupo
	 * @param mixed $fk_id_entidad_grupo
	 */
	public function setFkIdEntidadGrupo($fk_id_entidad_grupo)
	{
			$this->fk_id_entidad_grupo=$fk_id_entidad_grupo;
	}

/**
	 * Obtiene el valor de $fk_id_lugar_grupo_laboratorio
	 * @return mixed
	 */
	public function getFkIdLugarGrupoLaboratorio()
	{
			return $this->fk_id_lugar_grupo_laboratorio;
	}

	/**
	 * Asigna el valor para $fk_id_lugar_grupo_laboratorio
	 * @param mixed $fk_id_lugar_grupo_laboratorio
	 */
	public function setFkIdLugarGrupoLaboratorio($fk_id_lugar_grupo_laboratorio)
	{
			$this->fk_id_lugar_grupo_laboratorio=$fk_id_lugar_grupo_laboratorio;
	}	

}
