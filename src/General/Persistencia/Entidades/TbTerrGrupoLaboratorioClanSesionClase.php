<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_terr_grupo_laboratorio_clan_sesion_clase'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-09-14 21:52	 
 */
class TbTerrGrupoLaboratorioClanSesionClase 
{
	
	private $pk_sesion_clase;
	private $fk_grupo;
	private $da_fecha_clase;
	private $dt_fecha_creacion_registro;
	private $in_horas_clase;
	private $fk_usuario;
	private $fk_organizacion;
	private $tx_observaciones;
	private $suplencia;
	private $fk_clan;
	private $vc_nom_clan;
	private $tipo_poblacion;
	private $fk_area_artistica;
	private $fk_lugar_atencion;


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
	 * Obtiene el valor de PK_sesion_clase
	 * @return mixed
	 */
	public function getPkSesionClase()
	{
			return $this->pk_sesion_clase;
	}

	/**
	 * Asigna el valor para PK_sesion_clase
	 * @param mixed $pk_sesion_clase 
	 */
	public function setPkSesionClase($pk_sesion_clase)
	{
			$this->pk_sesion_clase=$pk_sesion_clase;
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
	 * Obtiene el valor de DA_fecha_clase
	 * @return mixed
	 */
	public function getDaFechaClase()
	{
			return $this->da_fecha_clase;
	}

	/**
	 * Asigna el valor para DA_fecha_clase
	 * @param mixed $da_fecha_clase 
	 */
	public function setDaFechaClase($da_fecha_clase)
	{
			$this->da_fecha_clase=$da_fecha_clase;
	}

	/**
	 * Obtiene el valor de DT_fecha_creacion_registro
	 * @return mixed
	 */
	public function getDtFechaCreacionRegistro()
	{
			return $this->dt_fecha_creacion_registro;
	}

	/**
	 * Asigna el valor para DT_fecha_creacion_registro
	 * @param mixed $dt_fecha_creacion_registro 
	 */
	public function setDtFechaCreacionRegistro($dt_fecha_creacion_registro)
	{
			$this->dt_fecha_creacion_registro=$dt_fecha_creacion_registro;
	}

	/**
	 * Obtiene el valor de IN_horas_clase
	 * @return mixed
	 */
	public function getInHorasClase()
	{
			return $this->in_horas_clase;
	}

	/**
	 * Asigna el valor para IN_horas_clase
	 * @param mixed $in_horas_clase 
	 */
	public function setInHorasClase($in_horas_clase)
	{
			$this->in_horas_clase=$in_horas_clase;
	}

	/**
	 * Obtiene el valor de FK_usuario
	 * @return mixed
	 */
	public function getFkUsuario()
	{
			return $this->fk_usuario;
	}

	/**
	 * Asigna el valor para FK_usuario
	 * @param mixed $fk_usuario 
	 */
	public function setFkUsuario($fk_usuario)
	{
			$this->fk_usuario=$fk_usuario;
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
	 * Obtiene el valor de suplencia
	 * @return mixed
	 */
	public function getSuplencia()
	{
			return $this->suplencia;
	}

	/**
	 * Asigna el valor para suplencia
	 * @param mixed $suplencia 
	 */
	public function setSuplencia($suplencia)
	{
			$this->suplencia=$suplencia;
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
	 * Obtiene el valor de VC_Nom_Clan
	 * @return mixed
	 */
	public function getVcNomClan()
	{
			return $this->vc_nom_clan;
	}

	/**
	 * Asigna el valor para VC_Nom_Clan
	 * @param mixed $vc_nom_clan 
	 */
	public function setVcNomClan($vc_nom_clan)
	{
			$this->vc_nom_clan=$vc_nom_clan;
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
	 * Asigna el valor para tipo_poblacion
	 * @param mixed $tipo_poblacion 
	 */
	public function setTipoPoblacion($tipo_poblacion)
	{
			$this->tipo_poblacion=$tipo_poblacion;
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


}
