<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_clan'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbClan 
{
	
	private $pk_id_clan;
	private $vc_nom_clan;
	private $vc_descripcion;
	private $fk_id_localidad;
	private $vc_direccion_clan;
	private $vc_telefono_clan;
	private $dt_fecha_apertura;
	private $vc_horario_atencion;
	private $vc_areas_artisticas;
	private $vc_nom_administrador;
	private $vc_correo_administrador;
	private $vc_nom_asistente;
	private $vc_correo_asistente;
	private $vc_nom_operativo;
	private $vc_correo_operativo;
	private $vc_cuadrante;
	private $vc_hospitales;
	private $vc_bomberos;
	private $vc_vencimiento_arriendo;
	private $vc_contrato_arriendo;
	private $vc_imagen_fachada;


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
	 * Obtiene el valor de PK_Id_Clan
	 * @return mixed
	 */
	public function getPkIdClan()
	{
			return $this->pk_id_clan;
	}

	/**
	 * Asigna el valor para PK_Id_Clan
	 * @param mixed $pk_id_clan 
	 */
	public function setPkIdClan($pk_id_clan)
	{
			$this->pk_id_clan=$pk_id_clan;
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
	 * Obtiene el valor de VC_Direccion_Clan
	 * @return mixed
	 */
	public function getVcDireccionClan()
	{
			return $this->vc_direccion_clan;
	}

	/**
	 * Asigna el valor para VC_Direccion_Clan
	 * @param mixed $vc_direccion_clan 
	 */
	public function setVcDireccionClan($vc_direccion_clan)
	{
			$this->vc_direccion_clan=$vc_direccion_clan;
	}

	/**
	 * Obtiene el valor de VC_Telefono_Clan
	 * @return mixed
	 */
	public function getVcTelefonoClan()
	{
			return $this->vc_telefono_clan;
	}

	/**
	 * Asigna el valor para VC_Telefono_Clan
	 * @param mixed $vc_telefono_clan 
	 */
	public function setVcTelefonoClan($vc_telefono_clan)
	{
			$this->vc_telefono_clan=$vc_telefono_clan;
	}

	/**
	 * Obtiene el valor de DT_Fecha_Apertura
	 * @return mixed
	 */
	public function getDtFechaApertura()
	{
			return $this->dt_fecha_apertura;
	}

	/**
	 * Asigna el valor para DT_Fecha_Apertura
	 * @param mixed $dt_fecha_apertura 
	 */
	public function setDtFechaApertura($dt_fecha_apertura)
	{
			$this->dt_fecha_apertura=$dt_fecha_apertura;
	}

	/**
	 * Obtiene el valor de VC_Horario_Atencion
	 * @return mixed
	 */
	public function getVcHorarioAtencion()
	{
			return $this->vc_horario_atencion;
	}

	/**
	 * Asigna el valor para VC_Horario_Atencion
	 * @param mixed $vc_horario_atencion 
	 */
	public function setVcHorarioAtencion($vc_horario_atencion)
	{
			$this->vc_horario_atencion=$vc_horario_atencion;
	}

	/**
	 * Obtiene el valor de VC_Areas_Artisticas
	 * @return mixed
	 */
	public function getVcAreasArtisticas()
	{
			return $this->vc_areas_artisticas;
	}

	/**
	 * Asigna el valor para VC_Areas_Artisticas
	 * @param mixed $vc_areas_artisticas 
	 */
	public function setVcAreasArtisticas($vc_areas_artisticas)
	{
			$this->vc_areas_artisticas=$vc_areas_artisticas;
	}

	/**
	 * Obtiene el valor de VC_Nom_Administrador
	 * @return mixed
	 */
	public function getVcNomAdministrador()
	{
			return $this->vc_nom_administrador;
	}

	/**
	 * Asigna el valor para VC_Nom_Administrador
	 * @param mixed $vc_nom_administrador 
	 */
	public function setVcNomAdministrador($vc_nom_administrador)
	{
			$this->vc_nom_administrador=$vc_nom_administrador;
	}

	/**
	 * Obtiene el valor de VC_Correo_Administrador
	 * @return mixed
	 */
	public function getVcCorreoAdministrador()
	{
			return $this->vc_correo_administrador;
	}

	/**
	 * Asigna el valor para VC_Correo_Administrador
	 * @param mixed $vc_correo_administrador 
	 */
	public function setVcCorreoAdministrador($vc_correo_administrador)
	{
			$this->vc_correo_administrador=$vc_correo_administrador;
	}

	/**
	 * Obtiene el valor de VC_Nom_Asistente
	 * @return mixed
	 */
	public function getVcNomAsistente()
	{
			return $this->vc_nom_asistente;
	}

	/**
	 * Asigna el valor para VC_Nom_Asistente
	 * @param mixed $vc_nom_asistente 
	 */
	public function setVcNomAsistente($vc_nom_asistente)
	{
			$this->vc_nom_asistente=$vc_nom_asistente;
	}

	/**
	 * Obtiene el valor de VC_Correo_Asistente
	 * @return mixed
	 */
	public function getVcCorreoAsistente()
	{
			return $this->vc_correo_asistente;
	}

	/**
	 * Asigna el valor para VC_Correo_Asistente
	 * @param mixed $vc_correo_asistente 
	 */
	public function setVcCorreoAsistente($vc_correo_asistente)
	{
			$this->vc_correo_asistente=$vc_correo_asistente;
	}

	/**
	 * Obtiene el valor de VC_Nom_Operativo
	 * @return mixed
	 */
	public function getVcNomOperativo()
	{
			return $this->vc_nom_operativo;
	}

	/**
	 * Asigna el valor para VC_Nom_Operativo
	 * @param mixed $vc_nom_operativo 
	 */
	public function setVcNomOperativo($vc_nom_operativo)
	{
			$this->vc_nom_operativo=$vc_nom_operativo;
	}

	/**
	 * Obtiene el valor de VC_Correo_Operativo
	 * @return mixed
	 */
	public function getVcCorreoOperativo()
	{
			return $this->vc_correo_operativo;
	}

	/**
	 * Asigna el valor para VC_Correo_Operativo
	 * @param mixed $vc_correo_operativo 
	 */
	public function setVcCorreoOperativo($vc_correo_operativo)
	{
			$this->vc_correo_operativo=$vc_correo_operativo;
	}

	/**
	 * Obtiene el valor de VC_Cuadrante
	 * @return mixed
	 */
	public function getVcCuadrante()
	{
			return $this->vc_cuadrante;
	}

	/**
	 * Asigna el valor para VC_Cuadrante
	 * @param mixed $vc_cuadrante 
	 */
	public function setVcCuadrante($vc_cuadrante)
	{
			$this->vc_cuadrante=$vc_cuadrante;
	}

	/**
	 * Obtiene el valor de VC_Hospitales
	 * @return mixed
	 */
	public function getVcHospitales()
	{
			return $this->vc_hospitales;
	}

	/**
	 * Asigna el valor para VC_Hospitales
	 * @param mixed $vc_hospitales 
	 */
	public function setVcHospitales($vc_hospitales)
	{
			$this->vc_hospitales=$vc_hospitales;
	}

	/**
	 * Obtiene el valor de VC_Bomberos
	 * @return mixed
	 */
	public function getVcBomberos()
	{
			return $this->vc_bomberos;
	}

	/**
	 * Asigna el valor para VC_Bomberos
	 * @param mixed $vc_bomberos 
	 */
	public function setVcBomberos($vc_bomberos)
	{
			$this->vc_bomberos=$vc_bomberos;
	}

	/**
	 * Obtiene el valor de VC_Vencimiento_Arriendo
	 * @return mixed
	 */
	public function getVcVencimientoArriendo()
	{
			return $this->vc_vencimiento_arriendo;
	}

	/**
	 * Asigna el valor para VC_Vencimiento_Arriendo
	 * @param mixed $vc_vencimiento_arriendo 
	 */
	public function setVcVencimientoArriendo($vc_vencimiento_arriendo)
	{
			$this->vc_vencimiento_arriendo=$vc_vencimiento_arriendo;
	}

	/**
	 * Obtiene el valor de VC_Contrato_Arriendo
	 * @return mixed
	 */
	public function getVcContratoArriendo()
	{
			return $this->vc_contrato_arriendo;
	}

	/**
	 * Asigna el valor para VC_Contrato_Arriendo
	 * @param mixed $vc_contrato_arriendo 
	 */
	public function setVcContratoArriendo($vc_contrato_arriendo)
	{
			$this->vc_contrato_arriendo=$vc_contrato_arriendo;
	}

	/**
	 * Obtiene el valor de VC_Imagen_Fachada
	 * @return mixed
	 */
	public function getVcImagenFachada()
	{
			return $this->vc_imagen_fachada;
	}

	/**
	 * Asigna el valor para VC_Imagen_Fachada
	 * @param mixed $vc_imagen_fachada 
	 */
	public function setVcImagenFachada($vc_imagen_fachada)
	{
			$this->vc_imagen_fachada=$vc_imagen_fachada;
	}


}
