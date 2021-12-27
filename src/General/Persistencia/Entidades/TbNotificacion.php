<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_notificacion'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-10-09 16:29	 
 */
class TbNotificacion 
{
	
	private $pk_notificacion_id;
	private $fk_tipo_alcance;
	private $fk_tipo_notificacion;
	private $vc_contenido;
	private $vc_url;
	private $dt_fecha;
	private $vc_icon;
	private $tx_datos_extra;


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
	 * Obtiene el valor de PK_Notificacion_Id
	 * @return mixed
	 */
	public function getPkNotificacionId()
	{
			return $this->pk_notificacion_id;
	}

	/**
	 * Asigna el valor para PK_Notificacion_Id
	 * @param mixed $pk_notificacion_id 
	 */
	public function setPkNotificacionId($pk_notificacion_id)
	{
			$this->pk_notificacion_id=$pk_notificacion_id;
	}

	/**
	 * Obtiene el valor de FK_Tipo_Alcance
	 * @return mixed
	 */
	public function getFkTipoAlcance()
	{
			return $this->fk_tipo_alcance;
	}

	/**
	 * Asigna el valor para FK_Tipo_Alcance
	 * @param mixed $fk_tipo_alcance 
	 */
	public function setFkTipoAlcance($fk_tipo_alcance)
	{
			$this->fk_tipo_alcance=$fk_tipo_alcance;
	}

	/**
	 * Obtiene el valor de FK_Tipo_Notificacion
	 * @return mixed
	 */
	public function getFkTipoNotificacion()
	{
			return $this->fk_tipo_notificacion;
	}

	/**
	 * Asigna el valor para FK_Tipo_Notificacion
	 * @param mixed $fk_tipo_notificacion 
	 */
	public function setFkTipoNotificacion($fk_tipo_notificacion)
	{
			$this->fk_tipo_notificacion=$fk_tipo_notificacion;
	}

	/**
	 * Obtiene el valor de VC_Contenido
	 * @return mixed
	 */
	public function getVcContenido()
	{
			return $this->vc_contenido;
	}

	/**
	 * Asigna el valor para VC_Contenido
	 * @param mixed $vc_contenido 
	 */
	public function setVcContenido($vc_contenido)
	{
			$this->vc_contenido=$vc_contenido;
	}

	/**
	 * Obtiene el valor de VC_Url
	 * @return mixed
	 */
	public function getVcUrl()
	{
			return $this->vc_url;
	}

	/**
	 * Asigna el valor para VC_Url
	 * @param mixed $vc_url 
	 */
	public function setVcUrl($vc_url)
	{
			$this->vc_url=$vc_url;
	}

	/**
	 * Obtiene el valor de DT_Fecha
	 * @return mixed
	 */
	public function getDtFecha()
	{
			return $this->dt_fecha;
	}

	/**
	 * Asigna el valor para DT_Fecha
	 * @param mixed $dt_fecha 
	 */
	public function setDtFecha($dt_fecha)
	{
			$this->dt_fecha=$dt_fecha;
	}

	/**
	 * Obtiene el valor de VC_Icon
	 * @return mixed
	 */
	public function getVcIcon()
	{
			return $this->vc_icon;
	}

	/**
	 * Asigna el valor para VC_Icon
	 * @param mixed $vc_icon 
	 */
	public function setVcIcon($vc_icon)
	{
			$this->vc_icon=$vc_icon;
	}

	/**
	 * Obtiene el valor de TX_Datos_Extra
	 * @return mixed
	 */
	public function getTxDatosExtra()
	{
			return $this->tx_datos_extra;
	}

	/**
	 * Asigna el valor para TX_Datos_Extra
	 * @param mixed $tx_datos_extra 
	 */
	public function setTxDatosExtra($tx_datos_extra)
	{
			$this->tx_datos_extra=$tx_datos_extra;
	}


}
