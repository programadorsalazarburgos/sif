<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_estudiante_detalle_anio'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 * @update: 2018-05-08 13:48 add variable in_estrato
 * @update: 2018-06-07 13:48 add variable tx_observaciones
 */
class TbEstudianteDetalleAnio 
{
	
	private $fk_estudiante;
	private $anio;
	private $fk_clan;
	private $fk_colegio;
	private $fk_grado;
	private $fk_jornada;
	private $nombre_acudiente;
	private $identificacion_acudiente;
	private $telefono_acudiente;
	private $fk_grupo_poblacional;
	private $fk_eps;
	private $tx_tipo_afiliacion;
	private $tx_enfermedades;
	private $fk_localidad;
	private $tx_barrio;
	private $fk_tipo_poblacion_victima;
	private $fk_tipo_discapacidad;
	private $fk_etnia;
	private $da_fecha_creacion;
	private $fk_usuario_creacion;
	private $in_estrato;
	private $tx_observaciones;

	private $puntaje_sisben;
	private $fk_area_artistica_interes;
	private $in_experiencia;
	private $in_experiencia_empirica;
	private $in_experiencia_academica;
	private $in_experiencia_anios;


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
	 * Obtiene el valor de FK_estudiante
	 * @return mixed
	 */
	public function getFkEstudiante()
	{
			return $this->fk_estudiante;
	}

	/**
	 * Asigna el valor para FK_estudiante
	 * @param mixed $fk_estudiante 
	 */
	public function setFkEstudiante($fk_estudiante)
	{
			$this->fk_estudiante=$fk_estudiante;
	}

	/**
	 * Obtiene el valor de anio
	 * @return mixed
	 */
	public function getAnio()
	{
			return $this->anio;
	}

	/**
	 * Asigna el valor para anio
	 * @param mixed $anio 
	 */
	public function setAnio($anio)
	{
			$this->anio=$anio;
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
	 * Obtiene el valor de FK_grado
	 * @return mixed
	 */
	public function getFkGrado()
	{
			return $this->fk_grado;
	}

	/**
	 * Asigna el valor para FK_grado
	 * @param mixed $fk_grado 
	 */
	public function setFkGrado($fk_grado)
	{
			$this->fk_grado=$fk_grado;
	}

	/**
	 * Obtiene el valor de fk_jornada
	 * @return mixed
	 */
	public function getFkJornada()
	{
			return $this->fk_jornada;
	}

	/**
	 * Asigna el valor para fk_jornada
	 * @param mixed $fk_jornada 
	 */
	public function setFkJornada($fk_jornada)
	{
			$this->fk_jornada=$fk_jornada;
	}

	/**
	 * Obtiene el valor de NOMBRE_ACUDIENTE
	 * @return mixed
	 */
	public function getNombreAcudiente()
	{
			return $this->nombre_acudiente;
	}

	/**
	 * Asigna el valor para NOMBRE_ACUDIENTE
	 * @param mixed $nombre_acudiente 
	 */
	public function setNombreAcudiente($nombre_acudiente)
	{
			$this->nombre_acudiente=$nombre_acudiente;
	}

	/**
	 * Obtiene el valor de IDENTIFICACION_ACUDIENTE
	 * @return mixed
	 */
	public function getIdentificacionAcudiente()
	{
			return $this->identificacion_acudiente;
	}

	/**
	 * Asigna el valor para IDENTIFICACION_ACUDIENTE
	 * @param mixed $identificacion_acudiente 
	 */
	public function setIdentificacionAcudiente($identificacion_acudiente)
	{
			$this->identificacion_acudiente=$identificacion_acudiente;
	}

	/**
	 * Obtiene el valor de TELEFONO_ACUDIENTE
	 * @return mixed
	 */
	public function getTelefonoAcudiente()
	{
			return $this->telefono_acudiente;
	}

	/**
	 * Asigna el valor para TELEFONO_ACUDIENTE
	 * @param mixed $telefono_acudiente 
	 */
	public function setTelefonoAcudiente($telefono_acudiente)
	{
			$this->telefono_acudiente=$telefono_acudiente;
	}

	/**
	 * Obtiene el valor de FK_Grupo_Poblacional
	 * @return mixed
	 */
	public function getFkGrupoPoblacional()
	{
			return $this->fk_grupo_poblacional;
	}

	/**
	 * Asigna el valor para FK_Grupo_Poblacional
	 * @param mixed $fk_grupo_poblacional 
	 */
	public function setFkGrupoPoblacional($fk_grupo_poblacional)
	{
			$this->fk_grupo_poblacional=$fk_grupo_poblacional;
	}

	/**
	 * Obtiene el valor de FK_Eps
	 * @return mixed
	 */
	public function getFkEps()
	{
			return $this->fk_eps;
	}

	/**
	 * Asigna el valor para FK_Eps
	 * @param mixed $fk_eps 
	 */
	public function setFkEps($fk_eps)
	{
			$this->fk_eps=$fk_eps;
	}

	/**
	 * Obtiene el valor de TX_Tipo_Afiliacion
	 * @return mixed
	 */
	public function getTxTipoAfiliacion()
	{
			return $this->tx_tipo_afiliacion;
	}

	/**
	 * Asigna el valor para TX_Tipo_Afiliacion
	 * @param mixed $tx_tipo_afiliacion 
	 */
	public function setTxTipoAfiliacion($tx_tipo_afiliacion)
	{
			$this->tx_tipo_afiliacion=$tx_tipo_afiliacion;
	}

	/**
	 * Obtiene el valor de TX_Enfermedades
	 * @return mixed
	 */
	public function getTxEnfermedades()
	{
			return $this->tx_enfermedades;
	}

	/**
	 * Asigna el valor para TX_Enfermedades
	 * @param mixed $tx_enfermedades 
	 */
	public function setTxEnfermedades($tx_enfermedades)
	{
			$this->tx_enfermedades=$tx_enfermedades;
	}

	/**
	 * Obtiene el valor de FK_Localidad
	 * @return mixed
	 */
	public function getFkLocalidad()
	{
			return $this->fk_localidad;
	}

	/**
	 * Asigna el valor para FK_Localidad
	 * @param mixed $fk_localidad 
	 */
	public function setFkLocalidad($fk_localidad)
	{
			$this->fk_localidad=$fk_localidad;
	}

	/**
	 * Obtiene el valor de TX_Barrio
	 * @return mixed
	 */
	public function getTxBarrio()
	{
			return $this->tx_barrio;
	}

	/**
	 * Asigna el valor para TX_Barrio
	 * @param mixed $tx_barrio 
	 */
	public function setTxBarrio($tx_barrio)
	{
			$this->tx_barrio=$tx_barrio;
	}

	/**
	 * Obtiene el valor de FK_tipo_poblacion_victima
	 * @return mixed
	 */
	public function getFkTipoPoblacionVictima()
	{
			return $this->fk_tipo_poblacion_victima;
	}

	/**
	 * Asigna el valor para FK_tipo_poblacion_victima
	 * @param mixed $fk_tipo_poblacion_victima 
	 */
	public function setFkTipoPoblacionVictima($fk_tipo_poblacion_victima)
	{
			$this->fk_tipo_poblacion_victima=$fk_tipo_poblacion_victima;
	}

	/**
	 * Obtiene el valor de FK_tipo_discapacidad
	 * @return mixed
	 */
	public function getFkTipoDiscapacidad()
	{
			return $this->fk_tipo_discapacidad;
	}

	/**
	 * Asigna el valor para FK_tipo_discapacidad
	 * @param mixed $fk_tipo_discapacidad 
	 */
	public function setFkTipoDiscapacidad($fk_tipo_discapacidad)
	{
			$this->fk_tipo_discapacidad=$fk_tipo_discapacidad;
	}

	/**
	 * Obtiene el valor de fk_etnia
	 * @return mixed
	 */
	public function getFkEtnia()
	{
			return $this->fk_etnia;
	}

	/**
	 * Asigna el valor para fk_etnia
	 * @param mixed $fk_etnia 
	 */
	public function setFkEtnia($fk_etnia)
	{
			$this->fk_etnia=$fk_etnia;
	}

	/**
	 * Obtiene el valor de DA_fecha_creacion
	 * @return mixed
	 */
	public function getDaFechaCreacion()
	{
			return $this->da_fecha_creacion;
	}

	/**
	 * Asigna el valor para DA_fecha_creacion
	 * @param mixed $da_fecha_creacion 
	 */
	public function setDaFechaCreacion($da_fecha_creacion)
	{
			$this->da_fecha_creacion=$da_fecha_creacion;
	}

	/**
	 * Obtiene el valor de FK_usuario_creacion
	 * @return mixed
	 */
	public function getFkUsuarioCreacion()
	{
			return $this->fk_usuario_creacion;
	}

	/**
	 * Asigna el valor para FK_usuario_creacion
	 * @param mixed $fk_usuario_creacion 
	 */
	public function setFkUsuarioCreacion($fk_usuario_creacion)
	{
			$this->fk_usuario_creacion=$fk_usuario_creacion;
	}

	/**
	 * Obtiene el valor de IN_estrato
	 * @return mixed
	 */
	public function getInEstrato()
	{
			return $this->in_estrato;
	}

	/**
	 * Asigna el valor para IN_estrato
	 * @param mixed $in_estrato 
	 */
	public function setInEstrato($in_estrato)
	{
			$this->in_estrato=$in_estrato;
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

	/**
	 * Obtiene el valor de puntaje_sisben
	 * @return mixed
	 */
	public function getPuntajeSisben()
	{
			return $this->puntaje_sisben;
	}

	/**
	 * Asigna el valor para puntaje_sisben
	 * @param mixed $puntaje_sisben
	 */
	public function setPuntajeSisben($puntaje_sisben)
	{
			$this->puntaje_sisben=$puntaje_sisben;
	}

	/**
	 * Obtiene el valor de fk_area_artistica_interes
	 * @return mixed
	 */
	public function getFkAreaArtisticaInteres()
	{
			return $this->fk_area_artistica_interes;
	}

	/**
	 * Asigna el valor para fk_area_artistica_interes
	 * @param mixed $tx_observaciones
	 */
	public function setFkAreaArtisticaInteres($fk_area_artistica_interes)
	{
			$this->fk_area_artistica_interes=$fk_area_artistica_interes;
	}

	/**
	 * Obtiene el valor de in_experiencia
	 * @return mixed
	 */
	public function getInExperiencia()
	{
			return $this->in_experiencia;
	}

	/**
	 * Asigna el valor para in_experiencia
	 * @param mixed $in_experiencia
	 */
	public function setInExperiencia($in_experiencia)
	{
			$this->in_experiencia=$in_experiencia;
	}
	
	/**
	 * Obtiene el valor de in_experiencia_empirica
	 * @return mixed
	 */
	public function getInExperienciaEmpirica()
	{
			return $this->in_experiencia_empirica;
	}

	/**
	 * Asigna el valor para in_experiencia_empirica
	 * @param mixed $in_experiencia_empirica
	 */
	public function setInExperienciaEmpirica($in_experiencia_empirica)
	{
			$this->in_experiencia_empirica=$in_experiencia_empirica;
	}
	
	/**
	 * Obtiene el valor de in_experiencia_academica
	 * @return mixed
	 */
	public function getInExperienciaAcademica()
	{
			return $this->in_experiencia_academica;
	}

	/**
	 * Asigna el valor para in_experiencia_academica
	 * @param mixed $in_experiencia_academica
	 */
	public function setInExperienciaAcademica($in_experiencia_academica)
	{
			$this->in_experiencia_academica=$in_experiencia_academica;
	}
	
	/**
	 * Obtiene el valor de in_experiencia_anios
	 * @return mixed
	 */
	public function getInExperienciaAnios()
	{
			return $this->in_experiencia_anios;
	}

	/**
	 * Asigna el valor para in_experiencia_anios
	 * @param mixed $in_experiencia_anios
	 */
	public function setInExperienciaAnios($in_experiencia_anios)
	{
			$this->in_experiencia_anios=$in_experiencia_anios;
	}
}