<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_planeacion_grupo'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbGrupoPropuestaProyecto 
{
	
	private $pk_id_propuesta_proyecto;
	private $fk_id_linea_atencion;
	private $vc_nombre_proyecto;
	private $vc_manos;
	private $vc_tipo_poblacion;
	private $vc_entidad_aliada;
	private $vc_proposito;
	private $vc_tipo_proyecto;
	private $vc_justificacion;
	private $vc_descripcion;
	private $vc_objetivo_general;
	private $vc_objetivos_especificos;
	private $vc_referentes;
	private $vc_resultados;
	private $vc_criterios;
	private $vc_otros_recursos;
	private $vc_planeador;
    private $vc_metodologia;
	private $vc_acciones;
	private $fk_grupo;
	private $vc_recursos;
	private $fk_id_usuario_registro;
	private $da_fecha_registro;
	private $vc_observacion;
	private $in_finalizado;

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
     * @return mixed
     */
    public function getPkIdPropuestaProyecto()
    {
    	return $this->pk_id_propuesta_proyecto;
    }

    /**
     * @param mixed $pk_id_propuesta_proyecto
     *
     * @return self
     */
    public function setPkIdPropuestaProyecto($pk_id_propuesta_proyecto)
    {
    	$this->pk_id_propuesta_proyecto = $pk_id_propuesta_proyecto;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdLineaAtencion()
    {
    	return $this->fk_id_linea_atencion;
    }

    /**
     * @param mixed $fk_id_linea_atencion
     *
     * @return self
     */
    public function setFkIdLineaAtencion($fk_id_linea_atencion)
    {
    	$this->fk_id_linea_atencion = $fk_id_linea_atencion;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNombreProyecto()
    {
    	return $this->vc_nombre_proyecto;
    }

    /**
     * @param mixed $vc_nombre_proyecto
     *
     * @return self
     */
    public function setVcNombreProyecto($vc_nombre_proyecto)
    {
    	$this->vc_nombre_proyecto = $vc_nombre_proyecto;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcManos()
    {
    	return $this->vc_manos;
    }

    /**
     * @param mixed $vc_manos
     *
     * @return self
     */
    public function setVcManos($vc_manos)
    {
    	$this->vc_manos = $vc_manos;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcTipoPoblacion()
    {
    	return $this->vc_tipo_poblacion;
    }

    /**
     * @param mixed $vc_tipo_poblacion
     *
     * @return self
     */
    public function setVcTipoPoblacion($vc_tipo_poblacion)
    {
    	$this->vc_tipo_poblacion = $vc_tipo_poblacion;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcEntidadAliada()
    {
    	return $this->vc_entidad_aliada;
    }

    /**
     * @param mixed $vc_entidad_aliada
     *
     * @return self
     */
    public function setVcEntidadAliada($vc_entidad_aliada)
    {
    	$this->vc_entidad_aliada = $vc_entidad_aliada;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcProposito()
    {
    	return $this->vc_proposito;
    }

    /**
     * @param mixed $vc_proposito
     *
     * @return self
     */
    public function setVcProposito($vc_proposito)
    {
    	$this->vc_proposito = $vc_proposito;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcTipoProyecto()
    {
    	return $this->vc_tipo_proyecto;
    }

    /**
     * @param mixed $vc_tipo_proyecto
     *
     * @return self
     */
    public function setVcTipoProyecto($vc_tipo_proyecto)
    {
    	$this->vc_tipo_proyecto = $vc_tipo_proyecto;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcJustificacion()
    {
    	return $this->vc_justificacion;
    }

    /**
     * @param mixed $vc_justificacion
     *
     * @return self
     */
    public function setVcJustificacion($vc_justificacion)
    {
    	$this->vc_justificacion = $vc_justificacion;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcDescripcion()
    {
    	return $this->vc_descripcion;
    }

    /**
     * @param mixed $vc_descripcion
     *
     * @return self
     */
    public function setVcDescripcion($vc_descripcion)
    {
    	$this->vc_descripcion = $vc_descripcion;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcObjetivoGeneral()
    {
    	return $this->vc_objetivo_general;
    }

    /**
     * @param mixed $vc_objetivo_general
     *
     * @return self
     */
    public function setVcObjetivoGeneral($vc_objetivo_general)
    {
    	$this->vc_objetivo_general = $vc_objetivo_general;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcObjetivosEspecificos()
    {
    	return $this->vc_objetivos_especificos;
    }

    /**
     * @param mixed $vc_objetivos_especificos
     *
     * @return self
     */
    public function setVcObjetivosEspecificos($vc_objetivos_especificos)
    {
    	$this->vc_objetivos_especificos = $vc_objetivos_especificos;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcReferentes()
    {
    	return $this->vc_referentes;
    }

    /**
     * @param mixed $vc_referentes
     *
     * @return self
     */
    public function setVcReferentes($vc_referentes)
    {
    	$this->vc_referentes = $vc_referentes;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcResultados()
    {
    	return $this->vc_resultados;
    }

    /**
     * @param mixed $vc_resultados
     *
     * @return self
     */
    public function setVcResultados($vc_resultados)
    {
    	$this->vc_resultados = $vc_resultados;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcCriterios()
    {
    	return $this->vc_criterios;
    }

    /**
     * @param mixed $vc_criterios
     *
     * @return self
     */
    public function setVcCriterios($vc_criterios)
    {
    	$this->vc_criterios = $vc_criterios;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcOtrosRecursos()
    {
    	return $this->vc_otros_recursos;
    }

    /**
     * @param mixed $vc_otros_recursos
     *
     * @return self
     */
    public function setVcOtrosRecursos($vc_otros_recursos)
    {
    	$this->vc_otros_recursos = $vc_otros_recursos;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcPlaneador()
    {
    	return $this->vc_planeador;
    }

    /**
     * @param mixed $vc_planeador
     *
     * @return self
     */
    public function setVcPlaneador($vc_planeador)
    {
    	$this->vc_planeador = $vc_planeador;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcMetodologia()
    {
        return $this->vc_metodologia;
    }

    /**
     * @param mixed $vc_metodologia
     *
     * @return self
     */
    public function setVcMetodologia($vc_metodologia)
    {
        $this->vc_metodologia = $vc_metodologia;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcAcciones()
    {
    	return $this->vc_acciones;
    }

    /**
     * @param mixed $vc_acciones
     *
     * @return self
     */
    public function setVcAcciones($vc_acciones)
    {
    	$this->vc_acciones = $vc_acciones;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getFkGrupo()
    {
    	return $this->fk_grupo;
    }

    /**
     * @param mixed $fk_grupo
     *
     * @return self
     */
    public function setFkGrupo($fk_grupo)
    {
    	$this->fk_grupo = $fk_grupo;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcRecursos()
    {
    	return $this->vc_recursos;
    }

    /**
     * @param mixed $vc_recursos
     *
     * @return self
     */
    public function setVcRecursos($vc_recursos)
    {
    	$this->vc_recursos = $vc_recursos;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdUsuarioRegistro()
    {
    	return $this->fk_id_usuario_registro;
    }

    /**
     * @param mixed $fk_id_usuario_registro
     *
     * @return self
     */
    public function setFkIdUsuarioRegistro($fk_id_usuario_registro)
    {
    	$this->fk_id_usuario_registro = $fk_id_usuario_registro;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getDaFechaRegistro()
    {
    	return $this->da_fecha_registro;
    }

    /**
     * @param mixed $da_fecha_registro
     *
     * @return self
     */
    public function setDaFechaRegistro($da_fecha_registro)
    {
    	$this->da_fecha_registro = $da_fecha_registro;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getVcObservacion()
    {
    	return $this->vc_observacion;
    }

    /**
     * @param mixed $vc_observacion
     *
     * @return self
     */
    public function setVcObservacion($vc_observacion)
    {
    	$this->vc_observacion = $vc_observacion;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getInFinalizado()
    {
    	return $this->in_finalizado;
    }

    /**
     * @param mixed $in_finalizado
     *
     * @return self
     */
    public function setInFinalizado($in_finalizado)
    {
    	$this->in_finalizado = $in_finalizado;

    	return $this;
    }
}
