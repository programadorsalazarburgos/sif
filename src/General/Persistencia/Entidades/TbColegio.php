<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_colegios'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbColegio 
{
	
	private $pk_id_colegio;
	private $vc_nom_colegio;
	private $fk_id_localidad;
	private $vc_dane_12;
	private $tx_zona_sdp;
	private $tx_direccion_colegio;
	private $tx_barrio;
	private $tx_telefono;
	private $tx_correo_colegio;
	private $vc_fecha_inicio;
	private $vc_espacio_atencion;
	private $vc_nom_rector;
	private $vc_nombre_upz;


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
	 * Obtiene el valor de PK_Id_Colegio
	 * @return mixed
	 */
	public function getPkIdColegio()
	{
			return $this->pk_id_colegio;
	}

	/**
	 * Asigna el valor para PK_Id_Colegio
	 * @param mixed $pk_id_colegio 
	 */
	public function setPkIdColegio($pk_id_colegio)
	{
			$this->pk_id_colegio=$pk_id_colegio;
	}

	/**
	 * Obtiene el valor de VC_Nom_Colegio
	 * @return mixed
	 */
	public function getVcNomColegio()
	{
			return $this->vc_nom_colegio;
	}

	/**
	 * Asigna el valor para VC_Nom_Colegio
	 * @param mixed $vc_nom_colegio 
	 */
	public function setVcNomColegio($vc_nom_colegio)
	{
			$this->vc_nom_colegio=$vc_nom_colegio;
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
	 * Obtiene el valor de VC_DANE_12
	 * @return mixed
	 */
	public function getVcDane12()
	{
			return $this->vc_dane_12;
	}

	/**
	 * Asigna el valor para VC_DANE_12
	 * @param mixed $vc_dane_12 
	 */
	public function setVcDane12($vc_dane_12)
	{
			$this->vc_dane_12=$vc_dane_12;
	}

	/**
	 * Obtiene el valor de TX_Zona_SDP
	 * @return mixed
	 */
	public function getTxZonaSdp()
	{
			return $this->tx_zona_sdp;
	}

	/**
	 * Asigna el valor para TX_Zona_SDP
	 * @param mixed $tx_zona_sdp 
	 */
	public function setTxZonaSdp($tx_zona_sdp)
	{
			$this->tx_zona_sdp=$tx_zona_sdp;
	}

	/**
	 * Obtiene el valor de TX_Direccion_Colegio
	 * @return mixed
	 */
	public function getTxDireccionColegio()
	{
			return $this->tx_direccion_colegio;
	}

	/**
	 * Asigna el valor para TX_Direccion_Colegio
	 * @param mixed $tx_direccion_colegio 
	 */
	public function setTxDireccionColegio($tx_direccion_colegio)
	{
			$this->tx_direccion_colegio=$tx_direccion_colegio;
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
	 * Obtiene el valor de TX_Telefono
	 * @return mixed
	 */
	public function getTxTelefono()
	{
			return $this->tx_telefono;
	}

	/**
	 * Asigna el valor para TX_Telefono
	 * @param mixed $tx_telefono 
	 */
	public function setTxTelefono($tx_telefono)
	{
			$this->tx_telefono=$tx_telefono;
	}

	/**
	 * Obtiene el valor de TX_Correo_Colegio
	 * @return mixed
	 */
	public function getTxCorreoColegio()
	{
			return $this->tx_correo_colegio;
	}

	/**
	 * Asigna el valor para TX_Correo_Colegio
	 * @param mixed $tx_correo_colegio 
	 */
	public function setTxCorreoColegio($tx_correo_colegio)
	{
			$this->tx_correo_colegio=$tx_correo_colegio;
	}

	/**
	 * Obtiene el valor de VC_Fecha_Inicio
	 * @return mixed
	 */
	public function getVcFechaInicio()
	{
			return $this->vc_fecha_inicio;
	}

	/**
	 * Asigna el valor para VC_Fecha_Inicio
	 * @param mixed $vc_fecha_inicio 
	 */
	public function setVcFechaInicio($vc_fecha_inicio)
	{
			$this->vc_fecha_inicio=$vc_fecha_inicio;
	}

	/**
	 * Obtiene el valor de VC_Espacio_Atencion
	 * @return mixed
	 */
	public function getVcEspacioAtencion()
	{
			return $this->vc_espacio_atencion;
	}

	/**
	 * Asigna el valor para VC_Espacio_Atencion
	 * @param mixed $vc_espacio_atencion 
	 */
	public function setVcEspacioAtencion($vc_espacio_atencion)
	{
			$this->vc_espacio_atencion=$vc_espacio_atencion;
	}

	/**
	 * Obtiene el valor de VC_Nom_Rector
	 * @return mixed
	 */
	public function getVcNomRector()
	{
			return $this->vc_nom_rector;
	}

	/**
	 * Asigna el valor para VC_Nom_Rector
	 * @param mixed $vc_nom_rector 
	 */
	public function setVcNomRector($vc_nom_rector)
	{
			$this->vc_nom_rector=$vc_nom_rector;
	}

	/**
	 * Obtiene el valor de VC_Nombre_UPZ
	 * @return mixed
	 */
	public function getVcNombreUpz()
	{
			return $this->vc_nombre_upz;
	}

	/**
	 * Asigna el valor para VC_Nombre_UPZ
	 * @param mixed $vc_nombre_upz 
	 */
	public function setVcNombreUpz($vc_nombre_upz)
	{
			$this->vc_nombre_upz=$vc_nombre_upz;
	}


}
