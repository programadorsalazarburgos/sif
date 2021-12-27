<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_inf_traslado'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2018-05-25 23:33	 
 */
class TbInfTraslado 
{
	
	private $pk_id_traslado;
	private $fk_id_inventario;
	private $fk_id_inventario_destino;
	private $da_fecha_solicitud;
	private $fk_persona_solicita;
	private $fk_origen;
	private $fk_destino;
	private $in_cantidad;
	private $vc_tipo_traslado;
	private $tx_argumento;
	private $in_estado;
	private $tx_numero_traslado;
	private $da_fecha_traslado;
	private $tx_consecutivo_salida;
	private $tx_observacion;
	private $fk_persona_revisa;
	private $da_fecha_revision;


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
	 * Obtiene el valor de PK_Id_Traslado
	 * @return mixed
	 */
	public function getPkIdTraslado()
	{
			return $this->pk_id_traslado;
	}

	/**
	 * Asigna el valor para PK_Id_Traslado
	 * @param mixed $pk_id_traslado 
	 */
	public function setPkIdTraslado($pk_id_traslado)
	{
			$this->pk_id_traslado=$pk_id_traslado;
	}

	/**
	 * Obtiene el valor de FK_Id_Inventario
	 * @return mixed
	 */
	public function getFkIdInventario()
	{
			return $this->fk_id_inventario;
	}

	/**
	 * Asigna el valor para FK_Id_Inventario
	 * @param mixed $fk_id_inventario 
	 */
	public function setFkIdInventario($fk_id_inventario)
	{
			$this->fk_id_inventario=$fk_id_inventario;
	}

	/**
	 * Obtiene el valor de FK_Id_Inventario_Destino
	 * @return mixed
	 */
	public function getFkIdInventarioDestino()
	{
			return $this->fk_id_inventario_destino;
	}

	/**
	 * Asigna el valor para FK_Id_Inventario_Destino
	 * @param mixed $fk_id_inventario_destino 
	 */
	public function setFkIdInventarioDestino($fk_id_inventario_destino)
	{
			$this->fk_id_inventario_destino=$fk_id_inventario_destino;
	}

	/**
	 * Obtiene el valor de DA_Fecha_Solicitud
	 * @return mixed
	 */
	public function getDaFechaSolicitud()
	{
			return $this->da_fecha_solicitud;
	}

	/**
	 * Asigna el valor para DA_Fecha_Solicitud
	 * @param mixed $da_fecha_solicitud 
	 */
	public function setDaFechaSolicitud($da_fecha_solicitud)
	{
			$this->da_fecha_solicitud=$da_fecha_solicitud;
	}

	/**
	 * Obtiene el valor de FK_Persona_Solicita
	 * @return mixed
	 */
	public function getFkPersonaSolicita()
	{
			return $this->fk_persona_solicita;
	}

	/**
	 * Asigna el valor para FK_Persona_Solicita
	 * @param mixed $fk_persona_solicita 
	 */
	public function setFkPersonaSolicita($fk_persona_solicita)
	{
			$this->fk_persona_solicita=$fk_persona_solicita;
	}

	/**
	 * Obtiene el valor de FK_Origen
	 * @return mixed
	 */
	public function getFkOrigen()
	{
			return $this->fk_origen;
	}

	/**
	 * Asigna el valor para FK_Origen
	 * @param mixed $fk_origen 
	 */
	public function setFkOrigen($fk_origen)
	{
			$this->fk_origen=$fk_origen;
	}

	/**
	 * Obtiene el valor de FK_Destino
	 * @return mixed
	 */
	public function getFkDestino()
	{
			return $this->fk_destino;
	}

	/**
	 * Asigna el valor para FK_Destino
	 * @param mixed $fk_destino 
	 */
	public function setFkDestino($fk_destino)
	{
			$this->fk_destino=$fk_destino;
	}

	/**
	 * Obtiene el valor de IN_Cantidad
	 * @return mixed
	 */
	public function getInCantidad()
	{
			return $this->in_cantidad;
	}

	/**
	 * Asigna el valor para IN_Cantidad
	 * @param mixed $in_cantidad 
	 */
	public function setInCantidad($in_cantidad)
	{
			$this->in_cantidad=$in_cantidad;
	}

	/**
	 * Obtiene el valor de VC_Tipo_Traslado
	 * @return mixed
	 */
	public function getVcTipoTraslado()
	{
			return $this->vc_tipo_traslado;
	}

	/**
	 * Asigna el valor para VC_Tipo_Traslado
	 * @param mixed $vc_tipo_traslado 
	 */
	public function setVcTipoTraslado($vc_tipo_traslado)
	{
			$this->vc_tipo_traslado=$vc_tipo_traslado;
	}

	/**
	 * Obtiene el valor de TX_Argumento
	 * @return mixed
	 */
	public function getTxArgumento()
	{
			return $this->tx_argumento;
	}

	/**
	 * Asigna el valor para TX_Argumento
	 * @param mixed $tx_argumento 
	 */
	public function setTxArgumento($tx_argumento)
	{
			$this->tx_argumento=$tx_argumento;
	}

	/**
	 * Obtiene el valor de IN_Estado
	 * @return mixed
	 */
	public function getInEstado()
	{
			return $this->in_estado;
	}

	/**
	 * Asigna el valor para IN_Estado
	 * @param mixed $in_estado 
	 */
	public function setInEstado($in_estado)
	{
			$this->in_estado=$in_estado;
	}

	/**
	 * Obtiene el valor de TX_Numero_Traslado
	 * @return mixed
	 */
	public function getTxNumeroTraslado()
	{
			return $this->tx_numero_traslado;
	}

	/**
	 * Asigna el valor para TX_Numero_Traslado
	 * @param mixed $tx_numero_traslado 
	 */
	public function setTxNumeroTraslado($tx_numero_traslado)
	{
			$this->tx_numero_traslado=$tx_numero_traslado;
	}

	/**
	 * Obtiene el valor de DA_Fecha_Traslado
	 * @return mixed
	 */
	public function getDaFechaTraslado()
	{
			return $this->da_fecha_traslado;
	}

	/**
	 * Asigna el valor para DA_Fecha_Traslado
	 * @param mixed $da_fecha_traslado 
	 */
	public function setDaFechaTraslado($da_fecha_traslado)
	{
			$this->da_fecha_traslado=$da_fecha_traslado;
	}

	/**
	 * Obtiene el valor de TX_Consecutivo_Salida
	 * @return mixed
	 */
	public function getTxConsecutivoSalida()
	{
			return $this->tx_consecutivo_salida;
	}

	/**
	 * Asigna el valor para TX_Consecutivo_Salida
	 * @param mixed $tx_consecutivo_salida 
	 */
	public function setTxConsecutivoSalida($tx_consecutivo_salida)
	{
			$this->tx_consecutivo_salida=$tx_consecutivo_salida;
	}

	/**
	 * Obtiene el valor de TX_Observacion
	 * @return mixed
	 */
	public function getTxObservacion()
	{
			return $this->tx_observacion;
	}

	/**
	 * Asigna el valor para TX_Observacion
	 * @param mixed $tx_observacion 
	 */
	public function setTxObservacion($tx_observacion)
	{
			$this->tx_observacion=$tx_observacion;
	}

	/**
	 * Obtiene el valor de FK_Persona_Revisa
	 * @return mixed
	 */
	public function getFkPersonaRevisa()
	{
			return $this->fk_persona_revisa;
	}

	/**
	 * Asigna el valor para FK_Persona_Revisa
	 * @param mixed $fk_persona_revisa 
	 */
	public function setFkPersonaRevisa($fk_persona_revisa)
	{
			$this->fk_persona_revisa=$fk_persona_revisa;
	}

	/**
	 * Obtiene el valor de DA_Fecha_Revision
	 * @return mixed
	 */
	public function getDaFechaRevision()
	{
			return $this->da_fecha_revision;
	}

	/**
	 * Asigna el valor para DA_Fecha_Revision
	 * @param mixed $da_fecha_revision 
	 */
	public function setDaFechaRevision($da_fecha_revision)
	{
			$this->da_fecha_revision=$da_fecha_revision;
	}


}
