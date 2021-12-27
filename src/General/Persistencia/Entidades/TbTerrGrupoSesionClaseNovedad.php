<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa las tabla 'tb_terr_grupo_emprende_clan_sesion_clase_novedad' y 'tb_terr_grupo_arte_escuela_sesion_clase_novedad'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbTerrGrupoSesionClaseNovedad 
{
	
	private $id;
	private $fk_grupo;
	private $da_fecha_sesion_clase;
	private $in_novedad;
	private $in_asistencia;
	private $tx_observacion;
	private $fk_artista_formador;
	private $fk_usuario_registro;
	private $dt_fecha_registro;
	private $tipo_grupo;


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
	 * Obtiene el valor de id
	 * @return mixed
	 */
	public function getId()
	{
			return $this->id;
	}

	/**
	 * Asigna el valor para id
	 * @param mixed $id 
	 */
	public function setId($id)
	{
			$this->id=$id;
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
	 * Obtiene el valor de DA_fecha_sesion_clase
	 * @return mixed
	 */
	public function getDaFechaSesionClase()
	{
			return $this->da_fecha_sesion_clase;
	}

	/**
	 * Asigna el valor para DA_fecha_sesion_clase
	 * @param mixed $da_fecha_sesion_clase 
	 */
	public function setDaFechaSesionClase($da_fecha_sesion_clase)
	{
			$this->da_fecha_sesion_clase=$da_fecha_sesion_clase;
	}

	/**
	 * Obtiene el valor de IN_novedad
	 * @return mixed
	 */
	public function getInNovedad()
	{
			return $this->in_novedad;
	}

	/**
	 * Asigna el valor para IN_novedad
	 * @param mixed $in_novedad 
	 */
	public function setInNovedad($in_novedad)
	{
			$this->in_novedad=$in_novedad;
	}

	/**
	 * Obtiene el valor de IN_asistencia
	 * @return mixed
	 */
	public function getInAsistencia()
	{
			return $this->in_asistencia;
	}

	/**
	 * Asigna el valor para IN_asistencia
	 * @param mixed $in_asistencia 
	 */
	public function setInAsistencia($in_asistencia)
	{
			$this->in_asistencia=$in_asistencia;
	}

	/**
	 * Obtiene el valor de TX_observacion
	 * @return mixed
	 */
	public function getTxObservacion()
	{
			return $this->tx_observacion;
	}

	/**
	 * Asigna el valor para TX_observacion
	 * @param mixed $tx_observacion 
	 */
	public function setTxObservacion($tx_observacion)
	{
			$this->tx_observacion=$tx_observacion;
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
	 * Obtiene el valor de FK_usuario_registro
	 * @return mixed
	 */
	public function getFkUsuarioRegistro()
	{
			return $this->fk_usuario_registro;
	}

	/**
	 * Asigna el valor para FK_usuario_registro
	 * @param mixed $fk_usuario_registro 
	 */
	public function setFkUsuarioRegistro($fk_usuario_registro)
	{
			$this->fk_usuario_registro=$fk_usuario_registro;
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
	 * Obtiene el valor de tipo_grupo
	 * @return mixed
	 */
	public function getTipoGrupo()
	{
			return $this->tipo_grupo;
	}

	/**
	 * Asigna el valor para tipo_grupo
	 * @param mixed $tipo_grupo 
	 */
	public function setTipoGrupo($tipo_grupo)
	{
			$this->tipo_grupo=$tipo_grupo;
	}
}
