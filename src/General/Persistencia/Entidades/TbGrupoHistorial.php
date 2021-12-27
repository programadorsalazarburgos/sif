<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_grupo_historial'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbGrupoHistorial 
{
	
	private $pk_id_grupo;
	private $fk_id_localidad;
	private $fk_id_colegio;
	private $fk_id_clan;
	private $fk_id_linea;
	private $pk_area_artistica;
	private $fk_id_modalidad;
	private $vc_nom_grupo;
	private $in_estado_grupo;
	private $vc_artista_formador;
	private $da_fecha_creacion;
	private $vc_atencion;
	private $in_num_sesiones;
	private $pk_tipo_grupo;
	private $vc_anio_grupo;
	private $da_fecha_cierre;
	private $in_organizacion;


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
	 * Obtiene el valor de PK_Id_Grupo
	 * @return mixed
	 */
	public function getPkIdGrupo()
	{
			return $this->pk_id_grupo;
	}

	/**
	 * Asigna el valor para PK_Id_Grupo
	 * @param mixed $pk_id_grupo 
	 */
	public function setPkIdGrupo($pk_id_grupo)
	{
			$this->pk_id_grupo=$pk_id_grupo;
	}

	/**
	 * Obtiene el valor de FK_Id_Localidad
	 * @return mixed
	 */
	public function getFkIdLocalidad()
	{
			return $this->fk_id_localidad;
	}

	/**
	 * Asigna el valor para FK_Id_Localidad
	 * @param mixed $fk_id_localidad 
	 */
	public function setFkIdLocalidad($fk_id_localidad)
	{
			$this->fk_id_localidad=$fk_id_localidad;
	}

	/**
	 * Obtiene el valor de FK_Id_Colegio
	 * @return mixed
	 */
	public function getFkIdColegio()
	{
			return $this->fk_id_colegio;
	}

	/**
	 * Asigna el valor para FK_Id_Colegio
	 * @param mixed $fk_id_colegio 
	 */
	public function setFkIdColegio($fk_id_colegio)
	{
			$this->fk_id_colegio=$fk_id_colegio;
	}

	/**
	 * Obtiene el valor de FK_Id_Clan
	 * @return mixed
	 */
	public function getFkIdClan()
	{
			return $this->fk_id_clan;
	}

	/**
	 * Asigna el valor para FK_Id_Clan
	 * @param mixed $fk_id_clan 
	 */
	public function setFkIdClan($fk_id_clan)
	{
			$this->fk_id_clan=$fk_id_clan;
	}

	/**
	 * Obtiene el valor de FK_Id_Linea
	 * @return mixed
	 */
	public function getFkIdLinea()
	{
			return $this->fk_id_linea;
	}

	/**
	 * Asigna el valor para FK_Id_Linea
	 * @param mixed $fk_id_linea 
	 */
	public function setFkIdLinea($fk_id_linea)
	{
			$this->fk_id_linea=$fk_id_linea;
	}

	/**
	 * Obtiene el valor de PK_Area_Artistica
	 * @return mixed
	 */
	public function getPkAreaArtistica()
	{
			return $this->pk_area_artistica;
	}

	/**
	 * Asigna el valor para PK_Area_Artistica
	 * @param mixed $pk_area_artistica 
	 */
	public function setPkAreaArtistica($pk_area_artistica)
	{
			$this->pk_area_artistica=$pk_area_artistica;
	}

	/**
	 * Obtiene el valor de FK_Id_Modalidad
	 * @return mixed
	 */
	public function getFkIdModalidad()
	{
			return $this->fk_id_modalidad;
	}

	/**
	 * Asigna el valor para FK_Id_Modalidad
	 * @param mixed $fk_id_modalidad 
	 */
	public function setFkIdModalidad($fk_id_modalidad)
	{
			$this->fk_id_modalidad=$fk_id_modalidad;
	}

	/**
	 * Obtiene el valor de VC_Nom_Grupo
	 * @return mixed
	 */
	public function getVcNomGrupo()
	{
			return $this->vc_nom_grupo;
	}

	/**
	 * Asigna el valor para VC_Nom_Grupo
	 * @param mixed $vc_nom_grupo 
	 */
	public function setVcNomGrupo($vc_nom_grupo)
	{
			$this->vc_nom_grupo=$vc_nom_grupo;
	}

	/**
	 * Obtiene el valor de IN_Estado_Grupo
	 * @return mixed
	 */
	public function getInEstadoGrupo()
	{
			return $this->in_estado_grupo;
	}

	/**
	 * Asigna el valor para IN_Estado_Grupo
	 * @param mixed $in_estado_grupo 
	 */
	public function setInEstadoGrupo($in_estado_grupo)
	{
			$this->in_estado_grupo=$in_estado_grupo;
	}

	/**
	 * Obtiene el valor de VC_Artista_Formador
	 * @return mixed
	 */
	public function getVcArtistaFormador()
	{
			return $this->vc_artista_formador;
	}

	/**
	 * Asigna el valor para VC_Artista_Formador
	 * @param mixed $vc_artista_formador 
	 */
	public function setVcArtistaFormador($vc_artista_formador)
	{
			$this->vc_artista_formador=$vc_artista_formador;
	}

	/**
	 * Obtiene el valor de DA_Fecha_Creacion
	 * @return mixed
	 */
	public function getDaFechaCreacion()
	{
			return $this->da_fecha_creacion;
	}

	/**
	 * Asigna el valor para DA_Fecha_Creacion
	 * @param mixed $da_fecha_creacion 
	 */
	public function setDaFechaCreacion($da_fecha_creacion)
	{
			$this->da_fecha_creacion=$da_fecha_creacion;
	}

	/**
	 * Obtiene el valor de VC_Atencion
	 * @return mixed
	 */
	public function getVcAtencion()
	{
			return $this->vc_atencion;
	}

	/**
	 * Asigna el valor para VC_Atencion
	 * @param mixed $vc_atencion 
	 */
	public function setVcAtencion($vc_atencion)
	{
			$this->vc_atencion=$vc_atencion;
	}

	/**
	 * Obtiene el valor de IN_Num_Sesiones
	 * @return mixed
	 */
	public function getInNumSesiones()
	{
			return $this->in_num_sesiones;
	}

	/**
	 * Asigna el valor para IN_Num_Sesiones
	 * @param mixed $in_num_sesiones 
	 */
	public function setInNumSesiones($in_num_sesiones)
	{
			$this->in_num_sesiones=$in_num_sesiones;
	}

	/**
	 * Obtiene el valor de PK_Tipo_Grupo
	 * @return mixed
	 */
	public function getPkTipoGrupo()
	{
			return $this->pk_tipo_grupo;
	}

	/**
	 * Asigna el valor para PK_Tipo_Grupo
	 * @param mixed $pk_tipo_grupo 
	 */
	public function setPkTipoGrupo($pk_tipo_grupo)
	{
			$this->pk_tipo_grupo=$pk_tipo_grupo;
	}

	/**
	 * Obtiene el valor de VC_Anio_Grupo
	 * @return mixed
	 */
	public function getVcAnioGrupo()
	{
			return $this->vc_anio_grupo;
	}

	/**
	 * Asigna el valor para VC_Anio_Grupo
	 * @param mixed $vc_anio_grupo 
	 */
	public function setVcAnioGrupo($vc_anio_grupo)
	{
			$this->vc_anio_grupo=$vc_anio_grupo;
	}

	/**
	 * Obtiene el valor de DA_Fecha_Cierre
	 * @return mixed
	 */
	public function getDaFechaCierre()
	{
			return $this->da_fecha_cierre;
	}

	/**
	 * Asigna el valor para DA_Fecha_Cierre
	 * @param mixed $da_fecha_cierre 
	 */
	public function setDaFechaCierre($da_fecha_cierre)
	{
			$this->da_fecha_cierre=$da_fecha_cierre;
	}

	/**
	 * Obtiene el valor de IN_Organizacion
	 * @return mixed
	 */
	public function getInOrganizacion()
	{
			return $this->in_organizacion;
	}

	/**
	 * Asigna el valor para IN_Organizacion
	 * @param mixed $in_organizacion 
	 */
	public function setInOrganizacion($in_organizacion)
	{
			$this->in_organizacion=$in_organizacion;
	}


}
