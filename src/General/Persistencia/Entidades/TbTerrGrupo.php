<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_terr_grupo_arte_escuela'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbTerrGrupo 
{

	private $pk_grupo;
	private $fk_clan;
	private $fk_area_artistica;
	private $in_lugar_atencion;
	private $fk_colegio;
	private $fk_modalidad;

	private $fk_institucion_laboratorio;
	private $fk_aliado_laboratorio;
	private $fk_tipo_ubicacion_laboratorio;
	private $tx_sitio_laboratorio;

	private $fk_lugar_atencion;
	private $tipo_poblacion;
	private $fk_artista_formador;
	private $dt_fecha_creacion;
	private $fk_creador;
	private $fk_organizacion;
	private $estado;
	private $dt_fecha_cierre;
	private $fk_quien_cerro;
	private $tx_observaciones;

	private $tipo_grupo;
	private $tipo_grupo_atencion;

	private $horario_array;
	private $estudiante_array;

	private $modalidad_atencion;
	private $in_modalidad_atencion;
	private $in_tipo_atencion;
	private $in_convenio;
	private $in_cupos;
	private $in_espacio_alterno;
	private $vc_grados;

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
	 * Obtiene el valor de PK_Grupo
	 * @return mixed
	 */
	public function getPkGrupo()
	{
		return $this->pk_grupo;
	}

	/**
	 * Asigna el valor para PK_Grupo
	 * @param mixed $pk_grupo 
	 */
	public function setPkGrupo($pk_grupo)
	{
		$this->pk_grupo=$pk_grupo;
	}

	/**
	 * Obtiene el valor de FK_clan
	 * @return mixed
	 */
	public function getFkClan()
	{
		return $this->fk_clan;
	}

	/**
	 * Asigna el valor para FK_clan
	 * @param mixed $fk_clan 
	 */
	public function setFkClan($fk_clan)
	{
		$this->fk_clan=$fk_clan;
	}

	/**
	 * Obtiene el valor de FK_area_artistica
	 * @return mixed
	 */
	public function getFkAreaArtistica()
	{
		return $this->fk_area_artistica;
	}

	/**
	 * Asigna el valor para FK_area_artistica
	 * @param mixed $fk_area_artistica 
	 */
	public function setFkAreaArtistica($fk_area_artistica)
	{
		$this->fk_area_artistica=$fk_area_artistica;
	}

	/**
	 * Obtiene el valor de IN_lugar_atencion_arte_escuela
	 * @return mixed
	 */
	public function getInLugarAtencion()
	{
		return $this->in_lugar_atencion;
	}

	/**
	 * Asigna el valor para IN_lugar_atencion_arte_escuela
	 * @param mixed $in_lugar_atencion_arte_escuela
	 */
	public function setInLugarAtencion($in_lugar_atencion)
	{
		$this->in_lugar_atencion=$in_lugar_atencion;
	}

	/**
	 * Obtiene el valor de FK_colegio
	 * @return mixed
	 */
	public function getFkColegio()
	{
		return $this->fk_colegio;
	}

	/**
	 * Asigna el valor para FK_colegio
	 * @param mixed $fk_colegio 
	 */
	public function setFkColegio($fk_colegio)
	{
		$this->fk_colegio=$fk_colegio;
	}

	/**
	 * Asigna el valor para fk_modalidad
	 * @param mixed $fk_modalidad 
	 */
	public function setFkModalidad($fk_modalidad)
	{
		$this->fk_modalidad=$fk_modalidad;
	}

	/**
	 * Obtiene el valor de FK_modalidad
	 * @return mixed
	 */
	public function getFkModalidad()
	{
		return $this->fk_modalidad;
	}

	/**
	 * Asigna el valor para fk_institucion_laboratorio
	 * @param mixed $fk_institucion_laboratorio
	 */
	public function setFkInstitucionLaboratorio($fk_institucion_laboratorio)
	{
		$this->fk_institucion_laboratorio=$fk_institucion_laboratorio;
	}

	/**
	 * Obtiene el valor de fk_institucion_laboratorio
	 * @return mixed
	 */
	public function getFkInstitucionLaboratorio()
	{
		return $this->fk_institucion_laboratorio;
	}

	/**
	 * Asigna el valor para fk_aliado_laboratorio
	 * @param mixed $fk_aliado_laboratorio
	 */
	public function setFkAliadoLaboratorio($fk_aliado_laboratorio)
	{
		$this->fk_aliado_laboratorio=$fk_aliado_laboratorio;
	}

	/**
	 * Obtiene el valor de fk_aliado_laboratorio
	 * @return mixed
	 */
	public function getFkAliadoLaboratorio()
	{
		return $this->fk_aliado_laboratorio;
	}

	/**
	 * Asigna el valor para fk_tipo_ubicacion_laboratorio
	 * @param mixed $fk_tipo_ubicacion_laboratorio
	 */
	public function setTipoUbicacionLaboratorio($fk_tipo_ubicacion_laboratorio)
	{
		$this->fk_tipo_ubicacion_laboratorio=$fk_tipo_ubicacion_laboratorio;
	}

	/**
	 * Obtiene el valor de fk_tipo_ubicacion_laboratorio
	 * @return mixed
	 */
	public function getTipoUbicacionLaboratorio()
	{
		return $this->fk_tipo_ubicacion_laboratorio;
	}

	/**
	 * Asigna el valor para tx_sitio_laboratorio
	 * @param mixed $tx_sitio_laboratorio
	 */
	public function setTxSitioLaboratorio($tx_sitio_laboratorio)
	{
		$this->tx_sitio_laboratorio=$tx_sitio_laboratorio;
	}

	/**
	 * Obtiene el valor de FK_modalidad
	 * @return mixed
	 */
	public function getTxSitioLaboratorio()
	{
		return $this->tx_sitio_laboratorio;
	}

	/**
	 * Asigna el valor para tipo_poblacion
	 * @param mixed $tipo_poblacion 
	 */
	public function setTipoPoblacion($tipo_poblacion)
	{
		$this->tipo_poblacion=$tipo_poblacion;
	}

	/**
	 * Obtiene el valor de tipo_poblacion
	 * @return mixed
	 */
	public function getTipoPoblacion()
	{
		return $this->tipo_poblacion;
	}

	/**
	 * Asigna el valor para fk_lugar_atencion
	 * @param mixed $fk_lugar_atencion
	 */
	public function setFkLugarAtencion($fk_lugar_atencion)
	{
		$this->fk_lugar_atencion=$fk_lugar_atencion;
	}

	/**
	 * Obtiene el valor de fk_lugar_atencion
	 * @return mixed
	 */
	public function getFkLugarAtencion()
	{
		return $this->fk_lugar_atencion;
	}

	/**
	 * Obtiene el valor de FK_artista_formador
	 * @return mixed
	 */
	public function getFkArtistaFormador()
	{
		return $this->fk_artista_formador;
	}

	/**
	 * Asigna el valor para FK_artista_formador
	 * @param mixed $fk_artista_formador 
	 */
	public function setFkArtistaFormador($fk_artista_formador)
	{
		$this->fk_artista_formador=$fk_artista_formador;
	}

	/**
	 * Obtiene el valor de DT_fecha_creacion
	 * @return mixed
	 */
	public function getDtFechaCreacion()
	{
		return $this->dt_fecha_creacion;
	}

	/**
	 * Asigna el valor para DT_fecha_creacion
	 * @param mixed $dt_fecha_creacion 
	 */
	public function setDtFechaCreacion($dt_fecha_creacion)
	{
		$this->dt_fecha_creacion=$dt_fecha_creacion;
	}

	/**
	 * Obtiene el valor de FK_creador
	 * @return mixed
	 */
	public function getFkCreador()
	{
		return $this->fk_creador;
	}

	/**
	 * Asigna el valor para FK_creador
	 * @param mixed $fk_creador 
	 */
	public function setFkCreador($fk_creador)
	{
		$this->fk_creador=$fk_creador;
	}

	/**
	 * Obtiene el valor de FK_organizacion
	 * @return mixed
	 */
	public function getFkOrganizacion()
	{
		return $this->fk_organizacion;
	}

	/**
	 * Asigna el valor para FK_organizacion
	 * @param mixed $fk_organizacion 
	 */
	public function setFkOrganizacion($fk_organizacion)
	{
		$this->fk_organizacion=$fk_organizacion;
	}

	/**
	 * Obtiene el valor de estado
	 * @return mixed
	 */
	public function getEstado()
	{
		return $this->estado;
	}

	/**
	 * Asigna el valor para estado
	 * @param mixed $estado 
	 */
	public function setEstado($estado)
	{
		$this->estado=$estado;
	}

	/**
	 * Obtiene el valor de DT_fecha_cierre
	 * @return mixed
	 */
	public function getDtFechaCierre()
	{
		return $this->dt_fecha_cierre;
	}

	/**
	 * Asigna el valor para DT_fecha_cierre
	 * @param mixed $dt_fecha_cierre 
	 */
	public function setDtFechaCierre($dt_fecha_cierre)
	{
		$this->dt_fecha_cierre=$dt_fecha_cierre;
	}

	/**
	 * Obtiene el valor de FK_quien_cerro
	 * @return mixed
	 */
	public function getFkQuienCerro()
	{
		return $this->fk_quien_cerro;
	}

	/**
	 * Asigna el valor para FK_quien_cerro
	 * @param mixed $fk_quien_cerro 
	 */
	public function setFkQuienCerro($fk_quien_cerro)
	{
		$this->fk_quien_cerro=$fk_quien_cerro;
	}

	/**
	 * Obtiene el valor de TX_observaciones
	 * @return mixed
	 */
	public function getTxObservaciones()
	{
		return $this->tx_observaciones;
	}

	/**
	 * Asigna el valor para TX_observaciones
	 * @param mixed $tx_observaciones 
	 */
	public function setTxObservaciones($tx_observaciones)
	{
		$this->tx_observaciones=$tx_observaciones;
	}

	public function getTipoGrupo()
	{
		return $this->tipo_grupo;
	}

    /**
     * @param mixed $tipo_grupo
     *
     * @return self
     */
    public function setTipoGrupo($tipo_grupo)
    {
    	$this->tipo_grupo = $tipo_grupo;

    	return $this;
    }

    public function getTipoGrupoAtencion()
    {
    	return $this->tipo_grupo_atencion;
    }

    /**
     * @param mixed $tipo_grupo_atencion
     *
     * @return self
     */
    public function setTipoGrupoAtencion($tipo_grupo_atencion)
    {
    	$this->tipo_grupo_atencion = $tipo_grupo_atencion;

    	return $this;
    }

    public function getGrupoAbiertoPublico()
    {
    	return $this->abierto_publico;
    }

    /**
     * @param mixed $tipo_grupo_atencion
     *
     * @return self
     */
    public function setGrupoAbiertoPublico($abierto_publico)
    {
    	$this->abierto_publico = $abierto_publico;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getHorarioArray()
    {
    	return $this->horario_array;
    }

    /**
     * @param mixed $horario_array
     *
     * @return self
     */
    public function setHorarioArray($horario_array)
    {
    	$this->horario_array = $horario_array;

    	return $this;
    }
    /**
     * @return mixed
     */
    public function getEstudianteArray()
    {
    	return $this->estudiante_array;
    }

    /**
     * @param mixed $estudiante_array
     *
     * @return self
     */
    public function setEstudianteArray($estudiante_array)
    {
    	$this->estudiante_array = $estudiante_array;

    	return $this;
    }

	/**
     * @return mixed
     */
	public function getModalidadAtencion()
	{
		return $this->modalidad_atencion;
	}

    /**
     * @param mixed $modalidad_atencion
     *
     * @return self
     */
    public function setModalidadAtencion($modalidad_atencion)
    {
    	$this->modalidad_atencion = $modalidad_atencion;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getInModalidadAtencion()
    {
    	return $this->in_modalidad_atencion;
    }

    /**
     * @param mixed $in_modalidad_atencion
     *
     * @return self
     */
    public function setInModalidadAtencion($in_modalidad_atencion)
    {
    	$this->in_modalidad_atencion = $in_modalidad_atencion;

    	return $this;
    }

	/**
     * @return mixed
     */
	public function getInTipoAtencion()
	{
		return $this->in_tipo_atencion;
	}

    /**
     * @param mixed $in_tipo_atencion
     *
     * @return self
     */
    public function setINTipoAtencion($in_tipo_atencion)
    {
    	$this->in_tipo_atencion = $in_tipo_atencion;

    	return $this;
    }


    /**
     * @return mixed
     */
    public function getInConvenio()
    {
    	return $this->in_convenio;
    }

    /**
     * @param mixed $in_convenio
     *
     * @return self
     */
    public function setInConvenio($in_convenio)
    {
    	$this->in_convenio = $in_convenio;

    	return $this;
    }


    /**
     * @return mixed
     */
    public function getInCupos()
    {
    	return $this->in_cupos;
    }

    /**
     * @param mixed $in_cupos
     *
     * @return self
     */
    public function setInCupos($in_cupos)
    {
    	$this->in_cupos = $in_cupos;

    	return $this;
    }


    /**
     * @return mixed
     */
    public function getInEspacioAlterno()
    {
    	return $this->in_espacio_alterno;
    }

    /**
     * @param mixed $in_espacio_alterno
     *
     * @return self
     */
    public function setInEspacioAlterno($in_espacio_alterno)
    {
    	$this->in_espacio_alterno = $in_espacio_alterno;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcGrados()
    {
    	return $this->vc_grados;
    }

    /**
     * @param mixed $vc_grados
     *
     * @return self
     */
    public function setVcGrados($vc_grados)
    {
    	$this->vc_grados = $vc_grados;

    	return $this;
    }
}