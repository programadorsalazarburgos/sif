<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_ped_evaluacion_artista_formador'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPedEvaluacionArtistaFormador 
{
	
	private $pk_evaluacion;
	private $fk_evaluador;
	private $fk_artista_formador_evaluado;
	private $fk_area_artistica;
	private $fk_linea_atencion;
	private $dt_fecha_registro;
	private $in_cumplimiento_entrega_tareas;
	private $vc_cumplimiento_entrega_tareas;
	private $in_disposicion_colaboracion_trabajo_equipo;
	private $vc_disposicion_colaboracion_trabajo_equipo;
	private $in_aportes_area_artistica;
	private $vc_aportes_area_artistica;
	private $in_evidencia_calidad_procesos_formativos;
	private $vc_evidencia_calidad_procesos_formativos;
	private $in_evidencia_resultados_desempenio_artistico;
	private $vc_evidencia_resultados_desempenio_artistico;
	private $in_puntaje_total;


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
	 * Obtiene el valor de PK_evaluacion
	 * @return mixed
	 */
	public function getPkEvaluacion()
	{
			return $this->pk_evaluacion;
	}

	/**
	 * Asigna el valor para PK_evaluacion
	 * @param mixed $pk_evaluacion 
	 */
	public function setPkEvaluacion($pk_evaluacion)
	{
			$this->pk_evaluacion=$pk_evaluacion;
	}

	/**
	 * Obtiene el valor de FK_evaluador
	 * @return mixed
	 */
	public function getFkEvaluador()
	{
			return $this->fk_evaluador;
	}

	/**
	 * Asigna el valor para FK_evaluador
	 * @param mixed $fk_evaluador 
	 */
	public function setFkEvaluador($fk_evaluador)
	{
			$this->fk_evaluador=$fk_evaluador;
	}

	/**
	 * Obtiene el valor de FK_artista_formador_evaluado
	 * @return mixed
	 */
	public function getFkArtistaFormadorEvaluado()
	{
			return $this->fk_artista_formador_evaluado;
	}

	/**
	 * Asigna el valor para FK_artista_formador_evaluado
	 * @param mixed $fk_artista_formador_evaluado 
	 */
	public function setFkArtistaFormadorEvaluado($fk_artista_formador_evaluado)
	{
			$this->fk_artista_formador_evaluado=$fk_artista_formador_evaluado;
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
	 * Obtiene el valor de FK_linea_atencion
	 * @return mixed
	 */
	public function getFkLineaAtencion()
	{
			return $this->fk_linea_atencion;
	}

	/**
	 * Asigna el valor para FK_linea_atencion
	 * @param mixed $fk_linea_atencion 
	 */
	public function setFkLineaAtencion($fk_linea_atencion)
	{
			$this->fk_linea_atencion=$fk_linea_atencion;
	}

	/**
	 * Obtiene el valor de DT_fecha_registro
	 * @return mixed
	 */
	public function getDtFechaRegistro()
	{
			return $this->dt_fecha_registro;
	}

	/**
	 * Asigna el valor para DT_fecha_registro
	 * @param mixed $dt_fecha_registro 
	 */
	public function setDtFechaRegistro($dt_fecha_registro)
	{
			$this->dt_fecha_registro=$dt_fecha_registro;
	}

	/**
	 * Obtiene el valor de IN_cumplimiento_entrega_tareas
	 * @return mixed
	 */
	public function getInCumplimientoEntregaTareas()
	{
			return $this->in_cumplimiento_entrega_tareas;
	}

	/**
	 * Asigna el valor para IN_cumplimiento_entrega_tareas
	 * @param mixed $in_cumplimiento_entrega_tareas 
	 */
	public function setInCumplimientoEntregaTareas($in_cumplimiento_entrega_tareas)
	{
			$this->in_cumplimiento_entrega_tareas=$in_cumplimiento_entrega_tareas;
	}

	/**
	 * Obtiene el valor de VC_cumplimiento_entrega_tareas
	 * @return mixed
	 */
	public function getVcCumplimientoEntregaTareas()
	{
			return $this->vc_cumplimiento_entrega_tareas;
	}

	/**
	 * Asigna el valor para VC_cumplimiento_entrega_tareas
	 * @param mixed $vc_cumplimiento_entrega_tareas 
	 */
	public function setVcCumplimientoEntregaTareas($vc_cumplimiento_entrega_tareas)
	{
			$this->vc_cumplimiento_entrega_tareas=$vc_cumplimiento_entrega_tareas;
	}

	/**
	 * Obtiene el valor de IN_disposicion_colaboracion_trabajo_equipo
	 * @return mixed
	 */
	public function getInDisposicionColaboracionTrabajoEquipo()
	{
			return $this->in_disposicion_colaboracion_trabajo_equipo;
	}

	/**
	 * Asigna el valor para IN_disposicion_colaboracion_trabajo_equipo
	 * @param mixed $in_disposicion_colaboracion_trabajo_equipo 
	 */
	public function setInDisposicionColaboracionTrabajoEquipo($in_disposicion_colaboracion_trabajo_equipo)
	{
			$this->in_disposicion_colaboracion_trabajo_equipo=$in_disposicion_colaboracion_trabajo_equipo;
	}

	/**
	 * Obtiene el valor de VC_disposicion_colaboracion_trabajo_equipo
	 * @return mixed
	 */
	public function getVcDisposicionColaboracionTrabajoEquipo()
	{
			return $this->vc_disposicion_colaboracion_trabajo_equipo;
	}

	/**
	 * Asigna el valor para VC_disposicion_colaboracion_trabajo_equipo
	 * @param mixed $vc_disposicion_colaboracion_trabajo_equipo 
	 */
	public function setVcDisposicionColaboracionTrabajoEquipo($vc_disposicion_colaboracion_trabajo_equipo)
	{
			$this->vc_disposicion_colaboracion_trabajo_equipo=$vc_disposicion_colaboracion_trabajo_equipo;
	}

	/**
	 * Obtiene el valor de IN_aportes_area_artistica
	 * @return mixed
	 */
	public function getInAportesAreaArtistica()
	{
			return $this->in_aportes_area_artistica;
	}

	/**
	 * Asigna el valor para IN_aportes_area_artistica
	 * @param mixed $in_aportes_area_artistica 
	 */
	public function setInAportesAreaArtistica($in_aportes_area_artistica)
	{
			$this->in_aportes_area_artistica=$in_aportes_area_artistica;
	}

	/**
	 * Obtiene el valor de VC_aportes_area_artistica
	 * @return mixed
	 */
	public function getVcAportesAreaArtistica()
	{
			return $this->vc_aportes_area_artistica;
	}

	/**
	 * Asigna el valor para VC_aportes_area_artistica
	 * @param mixed $vc_aportes_area_artistica 
	 */
	public function setVcAportesAreaArtistica($vc_aportes_area_artistica)
	{
			$this->vc_aportes_area_artistica=$vc_aportes_area_artistica;
	}

	/**
	 * Obtiene el valor de IN_evidencia_calidad_procesos_formativos
	 * @return mixed
	 */
	public function getInEvidenciaCalidadProcesosFormativos()
	{
			return $this->in_evidencia_calidad_procesos_formativos;
	}

	/**
	 * Asigna el valor para IN_evidencia_calidad_procesos_formativos
	 * @param mixed $in_evidencia_calidad_procesos_formativos 
	 */
	public function setInEvidenciaCalidadProcesosFormativos($in_evidencia_calidad_procesos_formativos)
	{
			$this->in_evidencia_calidad_procesos_formativos=$in_evidencia_calidad_procesos_formativos;
	}

	/**
	 * Obtiene el valor de VC_evidencia_calidad_procesos_formativos
	 * @return mixed
	 */
	public function getVcEvidenciaCalidadProcesosFormativos()
	{
			return $this->vc_evidencia_calidad_procesos_formativos;
	}

	/**
	 * Asigna el valor para VC_evidencia_calidad_procesos_formativos
	 * @param mixed $vc_evidencia_calidad_procesos_formativos 
	 */
	public function setVcEvidenciaCalidadProcesosFormativos($vc_evidencia_calidad_procesos_formativos)
	{
			$this->vc_evidencia_calidad_procesos_formativos=$vc_evidencia_calidad_procesos_formativos;
	}

	/**
	 * Obtiene el valor de IN_evidencia_resultados_desempenio_artistico
	 * @return mixed
	 */
	public function getInEvidenciaResultadosDesempenioArtistico()
	{
			return $this->in_evidencia_resultados_desempenio_artistico;
	}

	/**
	 * Asigna el valor para IN_evidencia_resultados_desempenio_artistico
	 * @param mixed $in_evidencia_resultados_desempenio_artistico 
	 */
	public function setInEvidenciaResultadosDesempenioArtistico($in_evidencia_resultados_desempenio_artistico)
	{
			$this->in_evidencia_resultados_desempenio_artistico=$in_evidencia_resultados_desempenio_artistico;
	}

	/**
	 * Obtiene el valor de VC_evidencia_resultados_desempenio_artistico
	 * @return mixed
	 */
	public function getVcEvidenciaResultadosDesempenioArtistico()
	{
			return $this->vc_evidencia_resultados_desempenio_artistico;
	}

	/**
	 * Asigna el valor para VC_evidencia_resultados_desempenio_artistico
	 * @param mixed $vc_evidencia_resultados_desempenio_artistico 
	 */
	public function setVcEvidenciaResultadosDesempenioArtistico($vc_evidencia_resultados_desempenio_artistico)
	{
			$this->vc_evidencia_resultados_desempenio_artistico=$vc_evidencia_resultados_desempenio_artistico;
	}

	/**
	 * Obtiene el valor de IN_puntaje_total
	 * @return mixed
	 */
	public function getInPuntajeTotal()
	{
			return $this->in_puntaje_total;
	}

	/**
	 * Asigna el valor para IN_puntaje_total
	 * @param mixed $in_puntaje_total 
	 */
	public function setInPuntajeTotal($in_puntaje_total)
	{
			$this->in_puntaje_total=$in_puntaje_total;
	}


}
