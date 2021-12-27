<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_centro_monitoreo'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2018-10-22 17:52	 
 */
class TbPsicoReporteCasos 
{
	
	private $pk_tabla;
	private $fk_beneficiario;
	private $fk_crea;
	private $tx_linea_atencion;
	private $fk_grupo;
	private $tx_datos;
	private $tx_origen_reporte;
	private $tx_descripcion_hechos;
	private $dt_fecha_registro;
	private $fk_usuario_registro;
	private $tx_observacion;
	private $dt_fecha_observacion;
	private $fk_usuario_observacion;
	private $in_finalizado;


	/**
	 * Asigna el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
	public function setVariables($objeto)
	{
		foreach ($objeto as $clave => $valor) {
			$clave=strtolower($clave);
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
	 * Obtiene el valor de PK_Tabla
	 * @return mixed
	 */
	public function getPkTabla()
	{
			return $this->pk_tabla;
	}

	/**
	 * Asigna el valor para PK_Tabla
	 * @param mixed $PK_Tabla 
	 */
	public function setPkTabla($pk_id_tabla)
	{
			$this->pk_tabla=$pk_id_tabla;
	}

	/**
	 * Obtiene el valor de fk_beneficiario
	 * @return mixed
	 */
	public function getFkBeneficiario()
	{
			return $this->fk_beneficiario;
	}

	/**
	 * Asigna el valor para fk_beneficiario
	 * @param mixed $fk_beneficiario 
	 */
	public function setFkBeneficiario($fk_beneficiario)
	{
			$this->fk_beneficiario=$fk_beneficiario;
	}

	/**
	 * Obtiene el valor de fk_crea
	 * @return mixed
	 */
	public function getFkCrea()
	{
			return $this->fk_crea;
	}

	/**
	 * Asigna el valor para fk_crea
	 * @param mixed $fk_crea 
	 */
	public function setFkCrea($fk_crea)
	{
			$this->fk_crea=$fk_crea;
	}

	/**
	 * Obtiene el valor de tx_linea_atencion
	 * @return mixed
	 */
	public function getTxLineaAtencion()
	{
			return $this->tx_linea_atencion;
	}

	/**
	 * Asigna el valor para tx_linea_atencion
	 * @param mixed $tx_linea_atencion 
	 */
	public function setTxLineaAtencion($tx_linea_atencion)
	{
			$this->tx_linea_atencion=$tx_linea_atencion;
	}


	/**
	 * Obtiene el valor de fk_grupo
	 * @return mixed
	 */
	public function getFkGrupo()
	{
			return $this->fk_grupo;
	}

	/**
	 * Asigna el valor para fk_grupo
	 * @param mixed $fk_grupo 
	 */
	public function setFkGrupo($fk_grupo)
	{
			$this->fk_grupo=$fk_grupo;
	}

	/**
	 * Obtiene el valor de tx_datos
	 * @return mixed
	 */
	public function getTxDatos()
	{
			return $this->tx_datos;
	}

	/**
	 * Asigna el valor para tx_datos
	 * @param mixed $tx_datos 
	 */
	public function setTxDatos($tx_datos)
	{
			$this->tx_datos=$tx_datos;
	}


	/**
	 * Obtiene el valor de tx_origen_reporte
	 * @return mixed
	 */
	public function getTxOrigenReporte()
	{
			return $this->tx_origen_reporte;
	}

	/**
	 * Asigna el valor para tx_origen_reporte
	 * @param mixed $tx_origen_reporte 
	 */
	public function setTxOrigenReporte($tx_origen_reporte)
	{
			$this->tx_origen_reporte=$tx_origen_reporte;
	}	

	/**
	 * Obtiene el valor de tx_descripcion_hechos
	 * @return mixed
	 */
	public function getTxDescripcionHechos()
	{
			return $this->tx_descripcion_hechos;
	}

	/**
	 * Asigna el valor para tx_descripcion_hechos
	 * @param mixed $tx_descripcion_hechos 
	 */
	public function setTxDescripcionHechos($tx_descripcion_hechos)
	{
			$this->tx_descripcion_hechos=$tx_descripcion_hechos;
	}	

	/**
	 * Obtiene el valor de dt_fecha_registro
	 * @return mixed
	 */
	public function getDtFechaRegistro()
	{
			return $this->dt_fecha_registro;
	}

	/**
	 * Asigna el valor para dt_fecha_registro
	 * @param mixed $dt_fecha_registro 
	 */
	public function setDtFechaRegistro($dt_fecha_registro)
	{
			$this->dt_fecha_registro=$dt_fecha_registro;
	}	


	/**
	 * Obtiene el valor de fk_usuario_registro
	 * @return mixed
	 */
	public function getFkUsuarioRegistro()
	{
			return $this->fk_usuario_registro;
	}

	/**
	 * Asigna el valor para fk_usuario_registro
	 * @param mixed $fk_usuario_registro 
	 */
	public function setFkUsuarioRegistro($fk_usuario_registro)
	{
			$this->fk_usuario_registro=$fk_usuario_registro;
	}

	/**
	 * Obtiene el valor de tx_observacion
	 * @return mixed
	 */
	public function getTxObservacion()
	{
			return $this->tx_observacion;
	}

	/**
	 * Asigna el valor para tx_observacion
	 * @param mixed $tx_observacion 
	 */
	public function setTxObservacion($tx_observacion)
	{
			$this->tx_observacion=$tx_observacion; 
	}

	/**
	 * Obtiene el valor de dt_fecha_observacion
	 * @return mixed
	 */
	public function getDtFechaObservacion()
	{
			return $this->dt_fecha_observacion;
	}

	/**
	 * Asigna el valor para dt_fecha_observacion
	 * @param mixed $dt_fecha_observacion 
	 */
	public function setDtFechaObservacion($dt_fecha_observacion)
	{
			$this->dt_fecha_observacion=$dt_fecha_observacion; 
	}

	/**
	 * Obtiene el valor de fk_usuario_observacion
	 * @return mixed
	 */
	public function getFkUsuarioObservacion()
	{
			return $this->fk_usuario_observacion;
	}

	/**
	 * Asigna el valor para fk_usuario_observacion
	 * @param mixed $fk_usuario_observacion 
	 */
	public function setFkUsuarioObservacion($fk_usuario_observacion)
	{
			$this->fk_usuario_observacion=$fk_usuario_observacion; 
	}

		/**
	 * Obtiene el valor de in_finalizado
	 * @return mixed
	 */
	public function getInFinalizado()
	{
			return $this->in_finalizado;
	}

	/**
	 * Asigna el valor para in_finalizado
	 * @param mixed $in_finalizado 
	 */
	public function setInFinalizado($in_finalizado)
	{
			$this->in_finalizado=$in_finalizado; 
	}
 
}
