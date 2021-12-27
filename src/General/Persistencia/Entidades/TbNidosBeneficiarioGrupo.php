<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_nidos_BENEFICIARIOS'
 *
 * @author: Juan David Torres, gracias a http://phpdao.com
 * @date: 2018-03-20
 */
class TbNidosBeneficiarioGrupo
{

	private $pk_id_benefi_grupo;
	private $fk_id_grupo;
	private $fk_id_beneficiario;
	private $dt_fecha_ingreso;
	private $fk_usuario_ingreso;
	private $dt_fecha_retiro;
	private $fk_usuario_retiro;
	private $in_estado;
	private $vc_observaciones;

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
	 * Obtiene el valor de Pk_Id_Benefi_Grupo
	 * @return mixed
	 */
	public function getPkIdBenefiGrupo()
	{
			return $this->pk_id_benefi_grupo;
	}

	/**
	 * Asigna el valor para Pk_Id_Benefi_Grupo
	 * @param mixed $pk_id_benefi_grupo
	 */
	public function setPkIdBenefiGrupo($pk_id_benefi_grupo)
	{
			$this->pk_id_benefi_grupo=$pk_id_benefi_grupo;
	}

	/**
	 * Obtiene el valor de Fk_Id_Grupo
	 * @return mixed
	 */
	public function getFkIdGrupo()
	{
			return $this->fk_id_grupo;
	}

	/**
	 * Asigna el valor para Fk_Id_Grupo
	 * @param mixed $fk_id_grupo
	 */
	public function setFkIdGrupo($fk_id_grupo)
	{
			$this->fk_id_grupo=$fk_id_grupo;
	}

	/**
	 * Obtiene el valor de Fk_Id_Beneficiario
	 * @return mixed
	 */
	public function getFkIdBeneficiario()
	{
			return $this->fk_id_beneficiario;
	}

	/**
	 * Asigna el valor para Fk_Id_Beneficiario
	 * @param mixed $fk_id_beneficiario
	 */
	public function setFkIdBeneficiario($fk_id_beneficiario)
	{
			$this->fk_id_beneficiario=$fk_id_beneficiario;
	}

	/**
	 * Obtiene el valor de Dt_Fecha_Ingreso
	 * @return mixed
	 */
	public function getDtFechaIngreso()
	{
			return $this->dt_fecha_ingreso;
	}

	/**
	 * Asigna el valor para Dt_Fecha_Ingreso
	 * @param mixed $dt_fecha_ingreso
	 */
	public function setDtFechaIngreso($dt_fecha_ingreso)
	{
			$this->dt_fecha_ingreso=$dt_fecha_ingreso;
	}

	/**
	 * Obtiene el valor de Fk_Usuario_Ingreso
	 * @return mixed
	 */
	public function getFkUsuarioIngreso()
	{
			return $this->fk_usuario_ingreso;
	}

	/**
	 * Asigna el valor para Fk_Usuario_Ingreso
	 * @param mixed $fk_usuario_ingreso
	 */
	public function setFkUsuarioIngreso($fk_usuario_ingreso)
	{
			$this->fk_usuario_ingreso=$fk_usuario_ingreso;
	}

	/**
	 * Obtiene el valor de Dt_Fecha_Retiro
	 * @return mixed
	 */
	public function getDtFechaRetiro()
	{
			return $this->dt_fecha_retiro;
	}

	/**
	 * Asigna el valor para Dt_Fecha_Retiro
	 * @param mixed $dt_fecha_retiro
	 */
	public function setDtFechaRetiro($dt_fecha_retiro)
	{
			$this->dt_fecha_retiro=$dt_fecha_retiro;
	}

	/**
	 * Obtiene el valor de Fk_Usuario_Retiro
	 * @return mixed
	 */
	public function getFkUsuarioRetiro()
	{
			return $this->fk_usuario_retiro;
	}

	/**
	 * Asigna el valor para Fk_Usuario_Retiro
	 * @param mixed $fk_usuario_retiro
	 */
	public function setFkUsuarioRetiro($fk_usuario_retiro)
	{
			$this->fk_usuario_retiro=$fk_usuario_retiro;
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
	 * @param mixed $in_estado
	 */
	public function setInEstado($in_estado)
	{
			$this->in_estado=$in_estado;
	}

	/**
	 * Obtiene el valor de Vc_Observaciones
	 * @return mixed
	 */
	public function getVcObservaciones()
	{
			return $this->vc_observaciones;
	}

	/**
	 * Asigna el valor para Fk_Id_Genero
	 * @param mixed $vc_observaciones
	 */
	public function setVcObservaciones($vc_observaciones)
	{
			$this->vc_observaciones=$vc_observaciones;
	}

}
