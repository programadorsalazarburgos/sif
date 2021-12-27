<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_log_login'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-10-26 23:05	 
 */
class TbLogLogin 
{
	private $id;
	private $fk_persona;
	private $dt_fecha_ingreso;
	private $tx_dispositivo;
	private $tx_ip;
	private $tx_mac;
	private $tx_url;


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

	public function getId()
	{
		return $this->id;
	}
	public function setId($id)
	{
		$this->id=$id;
	}	

	/**
	 * Obtiene el valor de FK_persona
	 * @return mixed
	 */
	public function getFkPersona()
	{
			return $this->fk_persona;
	}

	/**
	 * Asigna el valor para FK_persona
	 * @param mixed $fk_persona 
	 */
	public function setFkPersona($fk_persona)
	{
			$this->fk_persona=$fk_persona;
	}

	/**
	 * Obtiene el valor de DT_fecha_ingreso
	 * @return mixed
	 */
	public function getDtFechaIngreso()
	{
			return $this->dt_fecha_ingreso;
	}

	/**
	 * Asigna el valor para DT_fecha_ingreso
	 * @param mixed $dt_fecha_ingreso 
	 */
	public function setDtFechaIngreso($dt_fecha_ingreso)
	{
			$this->dt_fecha_ingreso=$dt_fecha_ingreso;
	}

	/**
	 * Obtiene el valor de TX_dispositivo
	 * @return mixed
	 */
	public function getTxDispositivo()
	{
			return $this->tx_dispositivo;
	}

	/**
	 * Asigna el valor para TX_dispositivo
	 * @param mixed $tx_dispositivo 
	 */
	public function setTxDispositivo($tx_dispositivo)
	{
			$this->tx_dispositivo=$tx_dispositivo;
	}

	/**
	 * Obtiene el valor de TX_IP
	 * @return mixed
	 */
	public function getTxIp()
	{
			return $this->tx_ip;
	}

	/**
	 * Asigna el valor para TX_IP
	 * @param mixed $tx_ip 
	 */
	public function setTxIp($tx_ip)
	{
			$this->tx_ip=$tx_ip;
	}

	/**
	 * Obtiene el valor de TX_MAC
	 * @return mixed
	 */
	public function getTxMac()
	{
			return $this->tx_mac;
	}

	/**
	 * Asigna el valor para TX_MAC
	 * @param mixed $tx_mac 
	 */
	public function setTxMac($tx_mac)
	{
			$this->tx_mac=$tx_mac;
	}

	/**
	 * Obtiene el valor de TX_Url
	 * @return mixed
	 */
	public function getTxUrl()
	{
			return $this->tx_url;
	}

	/**
	 * Asigna el valor para TX_Url
	 * @param mixed $tx_url 
	 */
	public function setTxUrl($tx_url)
	{
			$this->tx_url=$tx_url;
	}


}
