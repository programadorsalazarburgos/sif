<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_nidos_Jardin'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05
 */
class TbNidosLugarAtencion
{

	private $pk_jardin;
	private $fk_localidad;
	private $fk_upz;
	private $vc_barrio;
	private $fk_id_entidad;
	private $vc_tipo_lugar;
	private $vc_nombre_lugar;
	private $vc_direccion;
	private $vc_telefono;
	private $vc_coordinador;
	private $vc_email;
	private $vc_celular;
	private $vc_estado;
	private $fk_usuario_crea;
  private $dt_fecha_creacion;


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
	 * Obtiene el valor de PK_Jardin
	 * @return mixed
	 */
	public function getPkJardin()
	{
			return $this->pk_jardin;
	}

	/**
	 * Asigna el valor para PK_Jardin
	 * @param mixed $Pk_Jardin
	 */
	public function setPkJardin($pk_jardin)
	{
			$this->pk_jardin=$pk_jardin;
	}

	/**
	 * Obtiene el valor de fk_Localidad
	 * @return mixed
	 */
	public function getFkLocalidad()
	{
			return $this->fk_localidad;
	}

	/**
	 * Asigna el valor para FK_localidad
	 * @param mixed fk_Localidad
	 */
	public function setFkLocalidad($fk_localidad)
	{
			$this->fk_localidad=$fk_localidad;
	}

	/**
	 * Obtiene el valor de FK_area_artistica
	 * @return mixed
	 */
	public function getFkUpz()
	{
			return $this->fk_upz;
	}

	/**
	 * Asigna el valor para FK_Upz
	 * @param mixed $fk_Upz
	 */
	public function setFkUpz($fk_upz)
	{
			$this->fk_upz=$fk_upz;
	}

	/**
	 * Obtiene el valor de Vc_Barrio
	 * @return mixed
	 */
	public function getVcBarrio()
	{
			return $this->vc_barrio;
	}

	/**
	 * Asigna el valor para Vc_Barrio
	 * @param mixed $Vc_Barrio
	 */
	public function setVcBarrio($vc_barrio)
	{
			$this->vc_barrio=$vc_barrio;
	}

	/**
	 * Obtiene el valor de Vc_Barrio
	 * @return mixed
	 */
	public function getFkIdEntidad()
	{
			return $this->fk_id_entidad;
	}

	/**
	 * Asigna el valor para Vc_Barrio
	 * @param mixed $Vc_Barrio
	 */
	public function setFkIdEntidad($fk_id_entidad)
	{
			$this->fk_id_entidad=$fk_id_entidad;
	}


	/**
	 * Obtiene el valor de Vc_Tipo_Lugar
	 * @return mixed
	 */
	public function getVcTipoLugar()
	{
			return $this->vc_tipo_lugar;
	}

	/**
	 * Asigna el valor para Vc_Tipo_Lugar
	 * @param mixed $Vc_Tipo_Lugar
	 */
	public function setVcTipoLugar($vc_tipo_lugar)
	{
			$this->vc_tipo_lugar=$vc_tipo_lugar;
	}

	/**
	 * Obtiene el valor de Vc_nombre_lugar
	 * @return mixed
	 */
	public function getVcNombreLugar()
	{
			return $this->vc_nombre_lugar;
	}

	/**
	 * Asigna el valor para Vc_nombre_lugar
	 * @param mixed $vc_nombre_lugar
	 */
	public function setVcNombreLugar($vc_nombre_lugar)
	{
			$this->vc_nombre_lugar=$vc_nombre_lugar;
	}

	/**
	 * Obtiene el valor de VC_Direccion
	 * @return mixed
	 */
	 public function getVcDireccion()
	 {
	 		return $this->vc_direccion;
	}

	/**
	 * Asigna el valor para vc_direccion
	 * @param mixed $vc_direccion
	 */
	public function setVcDireccion($vc_direccion)
	{
			$this->vc_direccion=$vc_direccion;
	}

	/**
	 * Obtiene el valor de vc_telefono
	 * @return mixed
	 */
	public function getVcTelefono()
	{
			return $this->vc_telefono;
	}

	/**
	 * Asigna el valor para Vc_Telefono
	 * @param mixed $vc_telefono
	 */
	public function setVcTelefono($vc_telefono)
	{
			$this->vc_telefono=$vc_telefono;
	}

	/**
	 * Obtiene el valor de Vc_Coordinador
	 * @return mixed
	 */
	public function getVcCoordinador()
	{
			return $this->vc_coordinador;
	}

	/**
	 * Asigna el valor para Vc_Coordinador
	 * @param mixed $Vc_Coordinador
	 */
	public function setVcCoordinador($vc_coordinador)
	{
			$this->vc_coordinador=$vc_coordinador;
	}

	/**
	 * Obtiene el valor de vc_email
	 * @return mixed
	 */
	public function getVcEmail()
	{
			return $this->vc_email;
	}

	/**
	 * Asigna el valor para vc_Email
	 * @param mixed $vc_Email
	 */
	public function setVcEmail($vc_email)
	{
			$this->vc_email=$vc_email;
	}

	/**
	 * Obtiene el valor de Vc_Celular
	 * @return mixed
	 */
	public function getVcCelular()
	{
			return $this->vc_celular;
	}

	/**
	 * Asigna el valor para Vc_Celular
	 * @param mixed $vc_celular
	 */
	public function setVcCelular($vc_celular)
	{
			$this->vc_celular=$vc_celular;
	}

	/**
	 * Obtiene el valor de Vc_Estado
	 * @return mixed
	 */
	public function getVcEstado()
	{
			return $this->vc_estado;
	}

	/**
	 * Asigna el valor para Vc_Estado
	 * @param mixed $vc_estado
	 */
	public function setVcEstado($vc_estado)
	{
			$this->vc_estado=$vc_estado;
	}

/**
 * Obtiene el valor de $fk_usuario_crea
 * @return mixed
 */
public function getUsuarioCrea()
{
		return $this->fk_usuario_crea;
}

/**
 * Asigna el valor para $fk_usuario_crea
 * @param mixed $fk_usuario_crea
 */
public function setUsuarioCrea($fk_usuario_crea)
{
		$this->fk_usuario_crea=$fk_usuario_crea;
}

	/**
	 * Obtiene el valor de Dt_Fecha_Creacion
	 * @return mixed
	 */
	public function getDtFechaCreacion()
	{
			return $this->dt_fecha_creacion;
	}

	/**
	 * Asigna el valor para Dt_Fecha_Creacion
	 * @param mixed $dt_fecha_creacion
	 */
	public function setDtFechaCreacion($dt_fecha_creacion)
	{
			$this->dt_fecha_creacion=$dt_fecha_creacion;
	}
}
