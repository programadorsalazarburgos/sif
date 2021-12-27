<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_planeacion_grupo'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPlaneacionGrupo 
{
	
	private $pk_id_planeacion;
	private $fk_grupo;
	private $fk_id_linea_atencion;
	private $fk_ciclo;
	private $vc_objetivo;
	private $vc_pregunta;
	private $vc_descripcion;
	private $vc_metodologia;
	private $vc_temas;
	private $vc_recursos;
	private $vc_referentes;
	private $vc_propuesta_circulacion;
	private $vc_acciones;
	private $fk_id_usuario_registro;
	private $da_fecha_registro;
	private $vc_observacion;
	private $vc_resultados;
	private $vc_articulacion;
	private $vc_ciclo;
	private $in_estado;
	private $fk_id_afa_cambio;
	private $dt_afa_cambio;
	private $in_version;
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
	 * Obtiene el valor de PK_Id_Planeacion
	 * @return mixed
	 */
	public function getPkIdPlaneacion()
	{
		return $this->pk_id_planeacion;
	}

	/**
	 * Asigna el valor para PK_Id_Planeacion
	 * @param mixed $pk_id_planeacion 
	 */
	public function setPkIdPlaneacion($pk_id_planeacion)
	{
		$this->pk_id_planeacion=$pk_id_planeacion;
	}

	/**
	 * Obtiene el valor de FK_grupo
	 * @return mixed
	 */
	public function getFkGrupo()
	{
		return $this->fk_grupo;
	}

	/**
	 * Asigna el valor para FK_grupo
	 * @param mixed $fk_grupo 
	 */
	public function setFkGrupo($fk_grupo)
	{
		$this->fk_grupo=$fk_grupo;
	}

	/**
	 * Obtiene el valor de FK_Id_Linea_atencion
	 * @return mixed
	 */
	public function getFkIdLineaAtencion()
	{
		return $this->fk_id_linea_atencion;
	}

	/**
	 * Asigna el valor para FK_Id_Linea_atencion
	 * @param mixed $fk_id_linea_atencion 
	 */
	public function setFkIdLineaAtencion($fk_id_linea_atencion)
	{
		$this->fk_id_linea_atencion=$fk_id_linea_atencion;
	}

	/**
	 * Obtiene el valor de FK_Ciclo
	 * @return mixed
	 */
	public function getFkCiclo()
	{
		return $this->fk_ciclo;
	}

	/**
	 * Asigna el valor para FK_Ciclo
	 * @param mixed $fk_ciclo 
	 */
	public function setFkCiclo($fk_ciclo)
	{
		$this->fk_ciclo=$fk_ciclo;
	}

	/**
	 * Obtiene el valor de VC_Objetivo
	 * @return mixed
	 */
	public function getVcObjetivo()
	{
		return $this->vc_objetivo;
	}

	/**
	 * Asigna el valor para VC_Objetivo
	 * @param mixed $vc_objetivo 
	 */
	public function setVcObjetivo($vc_objetivo)
	{
		$this->vc_objetivo=$vc_objetivo;
	}

	/**
	 * Obtiene el valor de VC_Pregunta
	 * @return mixed
	 */
	public function getVcPregunta()
	{
		return $this->vc_pregunta;
	}

	/**
	 * Asigna el valor para VC_Pregunta
	 * @param mixed $vc_pregunta 
	 */
	public function setVcPregunta($vc_pregunta)
	{
		$this->vc_pregunta=$vc_pregunta;
	}

	/**
	 * Obtiene el valor de VC_Descripcion
	 * @return mixed
	 */
	public function getVcDescripcion()
	{
		return $this->vc_descripcion;
	}

	/**
	 * Asigna el valor para VC_Descripcion
	 * @param mixed $vc_descripcion 
	 */
	public function setVcDescripcion($vc_descripcion)
	{
		$this->vc_descripcion=$vc_descripcion;
	}

	/**
	 * Obtiene el valor de VC_Metodologia
	 * @return mixed
	 */
	public function getVcMetodologia()
	{
		return $this->vc_metodologia;
	}

	/**
	 * Asigna el valor para VC_Metodologia
	 * @param mixed $vc_metodologia 
	 */
	public function setVcMetodologia($vc_metodologia)
	{
		$this->vc_metodologia=$vc_metodologia;
	}

	/**
	 * Obtiene el valor de VC_Temas
	 * @return mixed
	 */
	public function getVcTemas()
	{
		return $this->vc_temas;
	}

	/**
	 * Asigna el valor para VC_Temas
	 * @param mixed $vc_temas 
	 */
	public function setVcTemas($vc_temas)
	{
		$this->vc_temas=$vc_temas;
	}

	/**
	 * Obtiene el valor de VC_Recursos
	 * @return mixed
	 */
	public function getVcRecursos()
	{
		return $this->vc_recursos;
	}

	/**
	 * Asigna el valor para VC_Recursos
	 * @param mixed $vc_recursos 
	 */
	public function setVcRecursos($vc_recursos)
	{
		$this->vc_recursos=$vc_recursos;
	}

	/**
	 * Obtiene el valor de VC_Referentes
	 * @return mixed
	 */
	public function getVcReferentes()
	{
		return $this->vc_referentes;
	}

	/**
	 * Asigna el valor para VC_Referentes
	 * @param mixed $vc_referentes 
	 */
	public function setVcReferentes($vc_referentes)
	{
		$this->vc_referentes=$vc_referentes;
	}

	/**
	 * Obtiene el valor de VC_Propuesta_Circulacion
	 * @return mixed
	 */
	public function getVcPropuestaCirculacion()
	{
		return $this->vc_propuesta_circulacion;
	}

	/**
	 * Asigna el valor para VC_Propuesta_Circulacion
	 * @param mixed $vc_propuesta_circulacion 
	 */
	public function setVcPropuestaCirculacion($vc_propuesta_circulacion)
	{
		$this->vc_propuesta_circulacion=$vc_propuesta_circulacion;
	}

	/**
	 * Obtiene el valor de VC_Acciones
	 * @return mixed
	 */
	public function getVcAcciones()
	{
		return $this->vc_acciones;
	}

	/**
	 * Asigna el valor para VC_Acciones
	 * @param mixed $vc_acciones 
	 */
	public function setVcAcciones($vc_acciones)
	{
		$this->vc_acciones=$vc_acciones;
	}

	/**
	 * Obtiene el valor de FK_Id_Usuario_Registro
	 * @return mixed
	 */
	public function getFkIdUsuarioRegistro()
	{
		return $this->fk_id_usuario_registro;
	}

	/**
	 * Asigna el valor para FK_Id_Usuario_Registro
	 * @param mixed $fk_id_usuario_registro 
	 */
	public function setFkIdUsuarioRegistro($fk_id_usuario_registro)
	{
		$this->fk_id_usuario_registro=$fk_id_usuario_registro;
	}

	/**
	 * Obtiene el valor de DA_Fecha_Registro
	 * @return mixed
	 */
	public function getDaFechaRegistro()
	{
		return $this->da_fecha_registro;
	}

	/**
	 * Asigna el valor para DA_Fecha_Registro
	 * @param mixed $da_fecha_registro 
	 */
	public function setDaFechaRegistro($da_fecha_registro)
	{
		$this->da_fecha_registro=$da_fecha_registro;
	}


	/**
	 * Obtiene el valor de DA_Fecha_Registro
	 * @return mixed
	 */
	public function getVcObservacion()
	{
		return $this->vc_observacion;
	}

	/**
	 * Asigna el valor para DA_Fecha_Registro
	 * @param mixed $da_fecha_registro 
	 */
	public function setVcObservacion($vc_observacion)
	{
		$this->vc_observacion=$vc_observacion;
	}


	/**
	 * Obtiene el valor de DA_Fecha_Registro
	 * @return mixed
	 */
	public function getVcResultados()
	{
		return $this->vc_resultados;
	}

	/**
	 * Asigna el valor para DA_Fecha_Registro
	 * @param mixed $da_fecha_registro 
	 */
	public function setVcResultados($vc_resultados)
	{
		$this->vc_resultados=$vc_resultados;
	}


	/**
	 * Obtiene el valor de DA_Fecha_Registro
	 * @return mixed
	 */
	public function getVcArticulacion()
	{
		return $this->vc_articulacion;
	}

	/**
	 * Asigna el valor para DA_Fecha_Registro
	 * @param mixed $da_fecha_registro 
	 */
	public function setVcArticulacion($vc_articulacion)
	{
		$this->vc_articulacion=$vc_articulacion;
	}


	/**
	 * Obtiene el valor de DA_Fecha_Registro
	 * @return mixed
	 */
	public function getVcCiclo()
	{
		return $this->vc_ciclo;
	}

	/**
	 * Asigna el valor para DA_Fecha_Registro
	 * @param mixed $da_fecha_registro 
	 */
	public function setVcCiclo($vc_ciclo)
	{
		$this->vc_ciclo=$vc_ciclo;
	}


	/**
	 * Obtiene el valor de DA_Fecha_Registro
	 * @return mixed
	 */
	public function getInEstado()
	{
		return $this->in_estado;
	}

	/**
	 * Asigna el valor para DA_Fecha_Registro
	 * @param mixed $da_fecha_registro 
	 */
	public function setInEstado($in_estado)
	{
		$this->in_estado=$in_estado;
	}


	/**
	 * Obtiene el valor de DA_Fecha_Registro
	 * @return mixed
	 */
	public function getFkIdAfaCambio()
	{
		return $this->fk_id_afa_cambio;
	}

	/**
	 * Asigna el valor para DA_Fecha_Registro
	 * @param mixed $da_fecha_registro 
	 */
	public function setFkIdAfaCambio($fk_id_afa_cambio)
	{
		$this->fk_id_afa_cambio=$fk_id_afa_cambio;
	}


	/**
	 * Obtiene el valor de DA_Fecha_Registro
	 * @return mixed
	 */
	public function getDtAfaCambio()
	{
		return $this->dt_afa_cambio;
	}

	/**
	 * Asigna el valor para DA_Fecha_Registro
	 * @param mixed $da_fecha_registro 
	 */
	public function setDtAfaCambio($dt_afa_cambio)
	{
		$this->dt_afa_cambio=$dt_afa_cambio;
	}


	/**
	 * Obtiene el valor de DA_Fecha_Registro
	 * @return mixed
	 */
	public function getInVersion()
	{
		return $this->in_version;
	}

	/**
	 * Asigna el valor para DA_Fecha_Registro
	 * @param mixed $da_fecha_registro 
	 */
	public function setInVersion($in_version)
	{
		$this->in_version=$in_version;
	}


	/**
	 * Obtiene el valor de DA_Fecha_Registro
	 * @return mixed
	 */
	public function getInFinalizado()
	{
		return $this->in_finalizado;
	}

	/**
	 * Asigna el valor para DA_Fecha_Registro
	 * @param mixed $da_fecha_registro 
	 */
	public function setInFinalizado($in_finalizado)
	{
		$this->in_finalizado=$in_finalizado;
	}
}
