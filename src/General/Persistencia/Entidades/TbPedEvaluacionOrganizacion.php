<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_ped_evaluacion_organizacion'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPedEvaluacionOrganizacion 
{
	
	private $pk_evaluacion;
	private $fk_evaluador;
	private $fk_organizacion_evaluada;
	private $dt_fecha_registro;
	private $in_coherencia_propuesta_desarrollo_proyecto;
	private $vc_coherencia_propuesta_desarrollo_proyecto;
	private $in_apropiacion_orientacion_pedagogica;
	private $vc_apropiacion_orientacion_pedagogica;
	private $in_materiales_aportados;
	private $vc_materiales_aportados;
	private $in_desempenio;
	private $vc_desempenio;
	private $in_evidencia_valoracion_proceso_formativo;
	private $vc_evidencia_valoracion_proceso_formativo;
	private $in_evidencia_acompanamiento;
	private $vc_evidencia_acompanamiento;
	private $in_aportes_area_artistica;
	private $vc_aportes_area_artistica;
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
	 * Obtiene el valor de FK_organizacion_evaluada
	 * @return mixed
	 */
	public function getFkOrganizacionEvaluada()
	{
			return $this->fk_organizacion_evaluada;
	}

	/**
	 * Asigna el valor para FK_organizacion_evaluada
	 * @param mixed $fk_organizacion_evaluada 
	 */
	public function setFkOrganizacionEvaluada($fk_organizacion_evaluada)
	{
			$this->fk_organizacion_evaluada=$fk_organizacion_evaluada;
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
	 * Obtiene el valor de IN_coherencia_propuesta_desarrollo_proyecto
	 * @return mixed
	 */
	public function getInCoherenciaPropuestaDesarrolloProyecto()
	{
			return $this->in_coherencia_propuesta_desarrollo_proyecto;
	}

	/**
	 * Asigna el valor para IN_coherencia_propuesta_desarrollo_proyecto
	 * @param mixed $in_coherencia_propuesta_desarrollo_proyecto 
	 */
	public function setInCoherenciaPropuestaDesarrolloProyecto($in_coherencia_propuesta_desarrollo_proyecto)
	{
			$this->in_coherencia_propuesta_desarrollo_proyecto=$in_coherencia_propuesta_desarrollo_proyecto;
	}

	/**
	 * Obtiene el valor de VC_coherencia_propuesta_desarrollo_proyecto
	 * @return mixed
	 */
	public function getVcCoherenciaPropuestaDesarrolloProyecto()
	{
			return $this->vc_coherencia_propuesta_desarrollo_proyecto;
	}

	/**
	 * Asigna el valor para VC_coherencia_propuesta_desarrollo_proyecto
	 * @param mixed $vc_coherencia_propuesta_desarrollo_proyecto 
	 */
	public function setVcCoherenciaPropuestaDesarrolloProyecto($vc_coherencia_propuesta_desarrollo_proyecto)
	{
			$this->vc_coherencia_propuesta_desarrollo_proyecto=$vc_coherencia_propuesta_desarrollo_proyecto;
	}

	/**
	 * Obtiene el valor de IN_apropiacion_orientacion_pedagogica
	 * @return mixed
	 */
	public function getInApropiacionOrientacionPedagogica()
	{
			return $this->in_apropiacion_orientacion_pedagogica;
	}

	/**
	 * Asigna el valor para IN_apropiacion_orientacion_pedagogica
	 * @param mixed $in_apropiacion_orientacion_pedagogica 
	 */
	public function setInApropiacionOrientacionPedagogica($in_apropiacion_orientacion_pedagogica)
	{
			$this->in_apropiacion_orientacion_pedagogica=$in_apropiacion_orientacion_pedagogica;
	}

	/**
	 * Obtiene el valor de VC_apropiacion_orientacion_pedagogica
	 * @return mixed
	 */
	public function getVcApropiacionOrientacionPedagogica()
	{
			return $this->vc_apropiacion_orientacion_pedagogica;
	}

	/**
	 * Asigna el valor para VC_apropiacion_orientacion_pedagogica
	 * @param mixed $vc_apropiacion_orientacion_pedagogica 
	 */
	public function setVcApropiacionOrientacionPedagogica($vc_apropiacion_orientacion_pedagogica)
	{
			$this->vc_apropiacion_orientacion_pedagogica=$vc_apropiacion_orientacion_pedagogica;
	}

	/**
	 * Obtiene el valor de IN_materiales_aportados
	 * @return mixed
	 */
	public function getInMaterialesAportados()
	{
			return $this->in_materiales_aportados;
	}

	/**
	 * Asigna el valor para IN_materiales_aportados
	 * @param mixed $in_materiales_aportados 
	 */
	public function setInMaterialesAportados($in_materiales_aportados)
	{
			$this->in_materiales_aportados=$in_materiales_aportados;
	}

	/**
	 * Obtiene el valor de VC_materiales_aportados
	 * @return mixed
	 */
	public function getVcMaterialesAportados()
	{
			return $this->vc_materiales_aportados;
	}

	/**
	 * Asigna el valor para VC_materiales_aportados
	 * @param mixed $vc_materiales_aportados 
	 */
	public function setVcMaterialesAportados($vc_materiales_aportados)
	{
			$this->vc_materiales_aportados=$vc_materiales_aportados;
	}

	/**
	 * Obtiene el valor de IN_desempenio
	 * @return mixed
	 */
	public function getInDesempenio()
	{
			return $this->in_desempenio;
	}

	/**
	 * Asigna el valor para IN_desempenio
	 * @param mixed $in_desempenio 
	 */
	public function setInDesempenio($in_desempenio)
	{
			$this->in_desempenio=$in_desempenio;
	}

	/**
	 * Obtiene el valor de VC_desempenio
	 * @return mixed
	 */
	public function getVcDesempenio()
	{
			return $this->vc_desempenio;
	}

	/**
	 * Asigna el valor para VC_desempenio
	 * @param mixed $vc_desempenio 
	 */
	public function setVcDesempenio($vc_desempenio)
	{
			$this->vc_desempenio=$vc_desempenio;
	}

	/**
	 * Obtiene el valor de IN_evidencia_valoracion_proceso_formativo
	 * @return mixed
	 */
	public function getInEvidenciaValoracionProcesoFormativo()
	{
			return $this->in_evidencia_valoracion_proceso_formativo;
	}

	/**
	 * Asigna el valor para IN_evidencia_valoracion_proceso_formativo
	 * @param mixed $in_evidencia_valoracion_proceso_formativo 
	 */
	public function setInEvidenciaValoracionProcesoFormativo($in_evidencia_valoracion_proceso_formativo)
	{
			$this->in_evidencia_valoracion_proceso_formativo=$in_evidencia_valoracion_proceso_formativo;
	}

	/**
	 * Obtiene el valor de VC_evidencia_valoracion_proceso_formativo
	 * @return mixed
	 */
	public function getVcEvidenciaValoracionProcesoFormativo()
	{
			return $this->vc_evidencia_valoracion_proceso_formativo;
	}

	/**
	 * Asigna el valor para VC_evidencia_valoracion_proceso_formativo
	 * @param mixed $vc_evidencia_valoracion_proceso_formativo 
	 */
	public function setVcEvidenciaValoracionProcesoFormativo($vc_evidencia_valoracion_proceso_formativo)
	{
			$this->vc_evidencia_valoracion_proceso_formativo=$vc_evidencia_valoracion_proceso_formativo;
	}

	/**
	 * Obtiene el valor de IN_evidencia_acompanamiento
	 * @return mixed
	 */
	public function getInEvidenciaAcompanamiento()
	{
			return $this->in_evidencia_acompanamiento;
	}

	/**
	 * Asigna el valor para IN_evidencia_acompanamiento
	 * @param mixed $in_evidencia_acompanamiento 
	 */
	public function setInEvidenciaAcompanamiento($in_evidencia_acompanamiento)
	{
			$this->in_evidencia_acompanamiento=$in_evidencia_acompanamiento;
	}

	/**
	 * Obtiene el valor de VC_evidencia_acompanamiento
	 * @return mixed
	 */
	public function getVcEvidenciaAcompanamiento()
	{
			return $this->vc_evidencia_acompanamiento;
	}

	/**
	 * Asigna el valor para VC_evidencia_acompanamiento
	 * @param mixed $vc_evidencia_acompanamiento 
	 */
	public function setVcEvidenciaAcompanamiento($vc_evidencia_acompanamiento)
	{
			$this->vc_evidencia_acompanamiento=$vc_evidencia_acompanamiento;
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
