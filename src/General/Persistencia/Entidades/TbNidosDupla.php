<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_nidos_Jardin'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05
 */
class TbNidosDupla
{

	private $pk_id_dupla;
	private $fk_id_territorio;
	private $fk_id_gestor;
	private $fk_id_eaat;
	private $in_estado;
	private $dt_fecha_creacion;
	private $fk_id_tipo_dupla;
	private $vc_codigo_dupla;

 private $array_dupla;
 //private $fk_id_persona;


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


		/*  tabla nidos dupla artisto

			/**
			 * Obtiene el valor de dt_fecha_creacion
			 * @return mixed
			 */
			public function getArtistasDupla()
			{
					return $this->array_dupla;
			}

			/**
			 * Asigna el valor para dt_fecha_creacion
			 * @param mixed $dt_fecha_creacion
			 */
			public function setArtistasDupla($array_dupla)
			{
					$this->array_dupla=$array_dupla;
			}


	/**
	 * Obtiene el valor de Pk_Id_Dupla
	 * @return mixed
	 */
	public function getPkIdDupla()
	{
			return $this->pk_id_dupla;
	}

	/**
	 * Asigna el valor para Pk_Id_Dupla
	 * @param mixed $pk_id_dupla
	 */
	public function setPkIdDupla($pk_id_dupla)
	{
			$this->pk_id_dupla=$pk_id_dupla;
	}


	/**
	 * Obtiene el valor de Fk_Id_Territorio
	 * @return mixed
	 */
	public function getFkIdTerritorio()
	{
			return $this->fk_id_territorio;
	}


	/**
	 * Asigna el valor para Fk_Id_Territorio
	 * @param mixed Fk_Id_Territorio
	 */
	public function setFkIdTerritorio($fk_id_territorio)
	{
			$this->fk_id_territorio=$fk_id_territorio;
	}


	/**
	 * Obtiene el valor de $fk_id_gestor
	 * @return mixed
	 */
	public function getFkIdGestor()
	{
			return $this->fk_id_gestor;
	}

	/**
	 * Asigna el valor para $fk_id_gestor
	 * @param mixed $fk_id_gestor
	 */
	public function setFkIdGestor($fk_id_gestor)
	{
			$this->fk_id_gestor=$fk_id_gestor;
	}

	/**
	 * Obtiene el valor de fk_id_EAAT
	 * @return mixed
	 */
	public function getFkIdEaat()
	{
			return $this->fk_id_eaat;
	}

	/**
	 * Asigna el valor para fk_id_EAAT
	 * @param mixed $fk_id_EAAT
	 */
	public function setFkIdEaat($fk_id_eaat)
	{
			$this->fk_id_eaat=$fk_id_eaat;
	}

	/**
	 * Obtiene el valor de In_Estado
	 * @return mixed
	 */
	public function getInEstado()
	{
			return $this->in_estado;
	}

	/**
	 * Asigna el valor para In_Estado
	 * @param mixed $In_Estado
	 */
	public function setInEstado($in_estado)
	{
			$this->in_estado=$in_estado;
	}

	/**
	 * Obtiene el valor de dt_fecha_creacion
	 * @return mixed
	 */
	public function getDtFechaCreacion()
	{
			return $this->dt_fecha_creacion;
	}

	/**
	 * Asigna el valor para dt_fecha_creacion
	 * @param mixed $dt_fecha_creacion
	 */
	public function setDtFechaCreacion($dt_fecha_creacion)
	{
			$this->dt_fecha_creacion=$dt_fecha_creacion;
	}


	/**
	 * Obtiene el valor de dt_fecha_creacion
	 * @return mixed
	 */
	public function getTipoDupla()
	{
			return $this->fk_id_tipo_dupla;
	}

	/**
	 * Asigna el valor para dt_fecha_creacion
	 * @param mixed $dt_fecha_creacion
	 */
	public function setTipoDupla($fk_id_tipo_dupla)
	{
			$this->fk_id_tipo_dupla=$fk_id_tipo_dupla;
	}

	/**
	 * Obtiene el valor de vc_codigo_dupla
	 * @return mixed
	 */
	public function getCodigoDupla()
	{
			return $this->vc_codigo_dupla;
	}

	/**
	 * Asigna el valor para vc_codigo_dupla
	 * @param mixed $vc_codigo_dupla
	 */
	public function setCodigoDupla($vc_codigo_dupla)
	{
			$this->vc_codigo_dupla=$vc_codigo_dupla;
	}


}
