<?php 

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_nidos_experiencia_soporte'
 *
 * @author: Juan Torres
 * @date: 2021-08-11 11:05
 */
class TbNidosExperienciaSoporte
{
	private $pk_id_soporte;
	private $fk_id_dupla;
	private $fk_id_lugar_atencion;
	private $in_mes;
	private $vc_documento_soporte;


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
	 * Obtiene el valor de pk_id_soporte
	 * @return mixed
	 */
	public function getPkIdSoporte()
	{
			return $this->pk_id_soporte;
	}
	/**
	 * Asigna el valor para pk_id_soporte
	 * @param mixed $pk_id_soporte
	 */
	public function setPkIdSoporte($pk_id_soporte)
	{
			$this->pk_id_soporte=$pk_id_soporte;
	}

	/**
	 * Obtiene el valor de fk_id_dupla
	 * @return mixed
	 */
	public function getFkIdDupla()
	{
			return $this->fk_id_dupla;
	}
	/**
	 * Asigna el valor para fk_id_dupla
	 * @param mixed $fk_id_dupla
	 */
	public function setFkIdDupla($fk_id_dupla)
	{
			$this->fk_id_dupla=$fk_id_dupla;
	}

	/**
	 * Obtiene el valor de fk_id_lugar_atencion
	 * @return mixed
	 */
	public function getFkIdLugarAtencion()
	{
			return $this->fk_id_lugar_atencion;
	}
	/**
	 * Asigna el valor para fk_id_lugar_atencion
	 * @param mixed $fk_id_lugar_atencion
	 */
	public function setFkIdLugarAtencion($fk_id_lugar_atencion)
	{
			$this->fk_id_lugar_atencion=$fk_id_lugar_atencion;
	}

	/**
	 * Obtiene el valor de in_mes
	 * @return mixed
	 */
	public function getInMes()
	{
			return $this->in_mes;
	}
	/**
	 * Asigna el valor para in_mes
	 * @param mixed $in_mes
	 */
	public function setInMes($in_mes)
	{
			$this->in_mes=$in_mes;
	}

		/**
	 * Obtiene el valor de vc_documento_soporte
	 * @return mixed
	 */
	public function getVcDocumentoSoporte()
	{
			return $this->vc_documento_soporte;
	}
	/**
	 * Asigna el valor para vc_documento_
	 * soporte
	 * @param mixed $vc_documento_soporte
	 */
	public function setVcDocumentoSoporte($vc_documento_soporte)
	{
			$this->vc_documento_soporte=$vc_documento_soporte;
	}


}
