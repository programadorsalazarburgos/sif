<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_soportesiclan'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbSoportesiclan 
{
	
	private $pk_soportesiclan;
	private $fk_identificacion;
	private $vc_nombre;
	private $vc_correo;
	private $vc_tiposoporte;
	private $vc_descripcion;
	private $dt_fechasoporte;
	private $vc_estado;
	private $vc_solucion;
	private $dt_fecharespuesta;


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
	 * Obtiene el valor de PK_SoporteSiclan
	 * @return mixed
	 */
	public function getPkSoportesiclan()
	{
			return $this->pk_soportesiclan;
	}

	/**
	 * Asigna el valor para PK_SoporteSiclan
	 * @param mixed $pk_soportesiclan 
	 */
	public function setPkSoportesiclan($pk_soportesiclan)
	{
			$this->pk_soportesiclan=$pk_soportesiclan;
	}

	/**
	 * Obtiene el valor de FK_Identificacion
	 * @return mixed
	 */
	public function getFkIdentificacion()
	{
			return $this->fk_identificacion;
	}

	/**
	 * Asigna el valor para FK_Identificacion
	 * @param mixed $fk_identificacion 
	 */
	public function setFkIdentificacion($fk_identificacion)
	{
			$this->fk_identificacion=$fk_identificacion;
	}

	/**
	 * Obtiene el valor de VC_Nombre
	 * @return mixed
	 */
	public function getVcNombre()
	{
			return $this->vc_nombre;
	}

	/**
	 * Asigna el valor para VC_Nombre
	 * @param mixed $vc_nombre 
	 */
	public function setVcNombre($vc_nombre)
	{
			$this->vc_nombre=$vc_nombre;
	}

	/**
	 * Obtiene el valor de VC_Correo
	 * @return mixed
	 */
	public function getVcCorreo()
	{
			return $this->vc_correo;
	}

	/**
	 * Asigna el valor para VC_Correo
	 * @param mixed $vc_correo 
	 */
	public function setVcCorreo($vc_correo)
	{
			$this->vc_correo=$vc_correo;
	}

	/**
	 * Obtiene el valor de VC_TipoSoporte
	 * @return mixed
	 */
	public function getVcTiposoporte()
	{
			return $this->vc_tiposoporte;
	}

	/**
	 * Asigna el valor para VC_TipoSoporte
	 * @param mixed $vc_tiposoporte 
	 */
	public function setVcTiposoporte($vc_tiposoporte)
	{
			$this->vc_tiposoporte=$vc_tiposoporte;
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
	 * Obtiene el valor de DT_FechaSoporte
	 * @return mixed
	 */
	public function getDtFechasoporte()
	{
			return $this->dt_fechasoporte;
	}

	/**
	 * Asigna el valor para DT_FechaSoporte
	 * @param mixed $dt_fechasoporte 
	 */
	public function setDtFechasoporte($dt_fechasoporte)
	{
			$this->dt_fechasoporte=$dt_fechasoporte;
	}

	/**
	 * Obtiene el valor de VC_Estado
	 * @return mixed
	 */
	public function getVcEstado()
	{
			return $this->vc_estado;
	}

	/**
	 * Asigna el valor para VC_Estado
	 * @param mixed $vc_estado 
	 */
	public function setVcEstado($vc_estado)
	{
			$this->vc_estado=$vc_estado;
	}

	/**
	 * Obtiene el valor de VC_Solucion
	 * @return mixed
	 */
	public function getVcSolucion()
	{
			return $this->vc_solucion;
	}

	/**
	 * Asigna el valor para VC_Solucion
	 * @param mixed $vc_solucion 
	 */
	public function setVcSolucion($vc_solucion)
	{
			$this->vc_solucion=$vc_solucion;
	}

	/**
	 * Obtiene el valor de DT_FechaRespuesta
	 * @return mixed
	 */
	public function getDtFecharespuesta()
	{
			return $this->dt_fecharespuesta;
	}

	/**
	 * Asigna el valor para DT_FechaRespuesta
	 * @param mixed $dt_fecharespuesta 
	 */
	public function setDtFecharespuesta($dt_fecharespuesta)
	{
			$this->dt_fecharespuesta=$dt_fecharespuesta;
	}


}
