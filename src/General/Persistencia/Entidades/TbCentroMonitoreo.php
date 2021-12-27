<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_centro_monitoreo'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2018-10-22 17:52	 
 */
class TbCentroMonitoreo 
{
	
	private $pk_id_centro_monitoreo;
	private $vc_numeral;
	private $in_seccion;
	private $fk_tipo_indicador;
	private $vc_titulo;
	private $tx_descripcion;
	private $vc_icono;
	private $vc_tipo_grafico;
	private $tx_sql;
	private $in_estado;
	private $vc_filtros;


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
	 * Obtiene el valor de PK_id_centro_monitoreo
	 * @return mixed
	 */
	public function getPkIdCentroMonitoreo()
	{
			return $this->pk_id_centro_monitoreo;
	}

	/**
	 * Asigna el valor para PK_id_centro_monitoreo
	 * @param mixed $pk_id_centro_monitoreo 
	 */
	public function setPkIdCentroMonitoreo($pk_id_centro_monitoreo)
	{
			$this->pk_id_centro_monitoreo=$pk_id_centro_monitoreo;
	}

	/**
	 * Obtiene el valor de VC_numeral
	 * @return mixed
	 */
	public function getVcNumeral()
	{
			return $this->vc_numeral;
	}

	/**
	 * Asigna el valor para VC_numeral
	 * @param mixed $vc_numeral 
	 */
	public function setVcNumeral($vc_numeral)
	{
			$this->vc_numeral=$vc_numeral;
	}

	/**
	 * Obtiene el valor de VC_titulo
	 * @return mixed
	 */
	public function getVcTitulo()
	{
			return $this->vc_titulo;
	}

	/**
	 * Asigna el valor para VC_titulo
	 * @param mixed $vc_titulo 
	 */
	public function setVcTitulo($vc_titulo)
	{
			$this->vc_titulo=$vc_titulo;
	}

	/**
	 * Obtiene el valor de VC_icono
	 * @return mixed
	 */
	public function getVcIcono()
	{
			return $this->vc_icono;
	}

	/**
	 * Asigna el valor para VC_icono
	 * @param mixed $vc_icono 
	 */
	public function setVcIcono($vc_icono)
	{
			$this->vc_icono=$vc_icono;
	}


	/**
	 * Obtiene el valor de TX_sql
	 * @return mixed
	 */
	public function getTxSql()
	{
			return $this->tx_sql;
	}

	/**
	 * Asigna el valor para TX_sql
	 * @param mixed $tx_sql 
	 */
	public function setTxSql($tx_sql)
	{
			$this->tx_sql=$tx_sql;
	}

	/**
	 * Obtiene el valor de IN_estado
	 * @return mixed
	 */
	public function getInEstado()
	{
			return $this->in_estado;
	}

	/**
	 * Asigna el valor para IN_estado
	 * @param mixed $in_estado 
	 */
	public function setInEstado($in_estado)
	{
			$this->in_estado=$in_estado;
	}


	/**
	 * Obtiene el valor de in_seccion
	 * @return mixed
	 */
	public function getInSeccion()
	{
			return $this->in_seccion;
	}

	/**
	 * Asigna el valor para IN_estado
	 * @param mixed $in_seccion 
	 */
	public function setInSeccion($in_seccion)
	{
			$this->in_seccion=$in_seccion;
	}	

	/**
	 * Obtiene el valor de Fk_Tipo_Indicador
	 * @return mixed
	 */
	public function getFkTipoIndicador()
	{
			return $this->fk_tipo_indicador;
	}

	/**
	 * Asigna el valor para Fk_Tipo_Indicador
	 * @param mixed $fk_tipo_indicador 
	 */
	public function setFkTipoIndicador($fk_tipo_indicador)
	{
			$this->fk_tipo_indicador=$fk_tipo_indicador;
	}	

	/**
	 * Obtiene el valor de vc_tipo_grafico
	 * @return mixed
	 */
	public function getVcTipoGrafico()
	{
			return $this->vc_tipo_grafico;
	}

	/**
	 * Asigna el valor para vc_tipo_grafico
	 * @param mixed $vc_tipo_grafico 
	 */
	public function setVcTipoGrafico($vc_tipo_grafico)
	{
			$this->vc_tipo_grafico=$vc_tipo_grafico;
	}	


	/**
	 * Obtiene el valor de Tx_Descripcion
	 * @return mixed
	 */
	public function getTxDescripcion()
	{
			return $this->tx_descripcion;
	}

	/**
	 * Asigna el valor para Tx_Descripcion
	 * @param mixed $tx_descripcion 
	 */
	public function setTxDescripcion($tx_descripcion)
	{
			$this->tx_descripcion=$tx_descripcion;
	}

	/**
	 * Obtiene el valor de vc_filtros
	 * @return mixed
	 */
	public function getVcFiltros()
	{
			return $this->vc_filtros;
	}

	/**
	 * Asigna el valor para vc_filtros
	 * @param mixed $vc_filtros 
	 */
	public function setVcFiltros($vc_filtros)
	{
			$this->vc_filtros=$vc_filtros; 
	}
 
}
