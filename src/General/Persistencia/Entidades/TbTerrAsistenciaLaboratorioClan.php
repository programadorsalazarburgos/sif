<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_terr_asistencia_laboratorio_clan'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbTerrAsistenciaLaboratorioClan 
{
	
	private $pk_asistencia;
	private $vc_codigo_taller;
	private $fk_clan;
	private $fk_area_artistica;
	private $fk_artista_formador;
	private $da_fecha_taller;
	private $fk_lugar_atencion;
	private $in_numero_personas;
	private $vc_observaciones;
	private $vc_extencion_archivo_soporte;
	private $dt_fecha_registro;


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
	 * Obtiene el valor de PK_Asistencia
	 * @return mixed
	 */
	public function getPkAsistencia()
	{
			return $this->pk_asistencia;
	}

	/**
	 * Asigna el valor para PK_Asistencia
	 * @param mixed $pk_asistencia 
	 */
	public function setPkAsistencia($pk_asistencia)
	{
			$this->pk_asistencia=$pk_asistencia;
	}

	/**
	 * Obtiene el valor de VC_codigo_taller
	 * @return mixed
	 */
	public function getVcCodigoTaller()
	{
			return $this->vc_codigo_taller;
	}

	/**
	 * Asigna el valor para VC_codigo_taller
	 * @param mixed $vc_codigo_taller 
	 */
	public function setVcCodigoTaller($vc_codigo_taller)
	{
			$this->vc_codigo_taller=$vc_codigo_taller;
	}

	/**
	 * Obtiene el valor de FK_Clan
	 * @return mixed
	 */
	public function getFkClan()
	{
			return $this->fk_clan;
	}

	/**
	 * Asigna el valor para FK_Clan
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
	 * Obtiene el valor de DA_fecha_taller
	 * @return mixed
	 */
	public function getDaFechaTaller()
	{
			return $this->da_fecha_taller;
	}

	/**
	 * Asigna el valor para DA_fecha_taller
	 * @param mixed $da_fecha_taller 
	 */
	public function setDaFechaTaller($da_fecha_taller)
	{
			$this->da_fecha_taller=$da_fecha_taller;
	}

	/**
	 * Obtiene el valor de FK_lugar_atencion
	 * @return mixed
	 */
	public function getFkLugarAtencion()
	{
			return $this->fk_lugar_atencion;
	}

	/**
	 * Asigna el valor para FK_lugar_atencion
	 * @param mixed $fk_lugar_atencion 
	 */
	public function setFkLugarAtencion($fk_lugar_atencion)
	{
			$this->fk_lugar_atencion=$fk_lugar_atencion;
	}

	/**
	 * Obtiene el valor de IN_numero_personas
	 * @return mixed
	 */
	public function getInNumeroPersonas()
	{
			return $this->in_numero_personas;
	}

	/**
	 * Asigna el valor para IN_numero_personas
	 * @param mixed $in_numero_personas 
	 */
	public function setInNumeroPersonas($in_numero_personas)
	{
			$this->in_numero_personas=$in_numero_personas;
	}

	/**
	 * Obtiene el valor de VC_observaciones
	 * @return mixed
	 */
	public function getVcObservaciones()
	{
			return $this->vc_observaciones;
	}

	/**
	 * Asigna el valor para VC_observaciones
	 * @param mixed $vc_observaciones 
	 */
	public function setVcObservaciones($vc_observaciones)
	{
			$this->vc_observaciones=$vc_observaciones;
	}

	/**
	 * Obtiene el valor de VC_extencion_archivo_soporte
	 * @return mixed
	 */
	public function getVcExtencionArchivoSoporte()
	{
			return $this->vc_extencion_archivo_soporte;
	}

	/**
	 * Asigna el valor para VC_extencion_archivo_soporte
	 * @param mixed $vc_extencion_archivo_soporte 
	 */
	public function setVcExtencionArchivoSoporte($vc_extencion_archivo_soporte)
	{
			$this->vc_extencion_archivo_soporte=$vc_extencion_archivo_soporte;
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


}
