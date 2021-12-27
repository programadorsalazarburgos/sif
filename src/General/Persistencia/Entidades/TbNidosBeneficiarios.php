<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_nidos_BENEFICIARIOS'
 *
 * @author: Juan David Torres, gracias a http://phpdao.com
 * @date: 2018-03-20
 */
class TbNidosBeneficiarios
{

	private $pk_id_beneficiario;
	private $vc_identificacion;
	private $fk_tipo_identificacion;
	private $vc_primer_nombre;
	private $vc_segundo_nombre;
	private $vc_primer_apellido;
	private $vc_segundo_apellido;
	private $dd_f_nacimiento;
	private $fk_id_genero;
	private $in_grupo_poblacional;
	private $in_identificacion_poblacional;
	private $fk_id_usuario_registra;
	private $dt_fecha_registro;
	private $vc_observacion;
	private $vc_uso_imagen;





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
	 * Obtiene el valor de Pk_Id_Beneficiario
	 * @return mixed
	 */
	public function getPkIdBeneficiario()
	{
		return $this->pk_id_beneficiario;
	}

	/**
	 * Asigna el valor para Pk_Id_Beneficiario
	 * @param mixed $pk_id_beneficiario
	 */
	public function setPkIdBeneficiario($pk_id_beneficiario)
	{
		$this->pk_id_beneficiario=$pk_id_beneficiario;
	}

	/**
	 * Obtiene el valor de Vc_Identificacion
	 * @return mixed
	 */
	public function getVcIdentificacion()
	{
		return $this->vc_identificacion;
	}

	/**
	 * Asigna el valor para Vc_Identificacion
	 * @param mixed $vc_identificacion
	 */
	public function setVcIdentificacion($vc_identificacion)
	{
		$this->vc_identificacion=$vc_identificacion;
	}

	/**
	 * Obtiene el valor de Fk_Tipo_Identificacion
	 * @return mixed
	 */
	public function getFkTipoIdentificacion()
	{
		return $this->fk_tipo_identificacion;
	}

	/**
	 * Asigna el valor para Fk_Tipo_Identificacion
	 * @param mixed $fk_tipo_identificacion
	 */
	public function setFkTipoIdentificacion($fk_tipo_identificacion)
	{
		$this->fk_tipo_identificacion=$fk_tipo_identificacion;
	}

	/**
	 * Obtiene el valor de Vc_Primer_Nombre
	 * @return mixed
	 */
	public function getVcPrimerNombre()
	{
		return $this->vc_primer_nombre;
	}

	/**
	 * Asigna el valor para Vc_Primer_Nombre
	 * @param mixed $vc_primer_nombre
	 */
	public function setVcPrimerNombre($vc_primer_nombre)
	{
		$this->vc_primer_nombre=$vc_primer_nombre;
	}

	/**
	 * Obtiene el valor de Vc_Segundo_Nombre
	 * @return mixed
	 */
	public function getVcSegundoNombre()
	{
		return $this->vc_segundo_nombre;
	}

	/**
	 * Asigna el valor para Vc_Segundo_Nombre
	 * @param mixed $vc_segundo_nombre
	 */
	public function setVcSegundoNombre($vc_segundo_nombre)
	{
		$this->vc_segundo_nombre=$vc_segundo_nombre;
	}

	/**
	 * Obtiene el valor de Vc_Primer_Apellido
	 * @return mixed
	 */
	public function getVcPrimerApellido()
	{
		return $this->vc_primer_apellido;
	}

	/**
	 * Asigna el valor para Vc_Primer_Apellido
	 * @param mixed $vc_primer_apellido
	 */
	public function setVcPrimerApellido($vc_primer_apellido)
	{
		$this->vc_primer_apellido=$vc_primer_apellido;
	}

	/**
	 * Obtiene el valor de Vc_Segundo_Apellido
	 * @return mixed
	 */
	public function getVcSegundoApellido()
	{
		return $this->vc_segundo_apellido;
	}

	/**
	 * Asigna el valor para Vc_Segundo_Apellido
	 * @param mixed $vc_segundo_apellido
	 */
	public function setVcSegundoApellido($vc_segundo_apellido)
	{
		$this->vc_segundo_apellido=$vc_segundo_apellido;
	}

	/**
	 * Obtiene el valor de Dd_F_Nacimiento
	 * @return mixed
	 */
	public function getDdFNacimiento()
	{
		return $this->dd_f_nacimiento;
	}

	/**
	 * Asigna el valor para Dd_F_Nacimiento
	 * @param mixed $dd_f_nacimiento
	 */
	public function setDdFNacimiento($dd_f_nacimiento)
	{
		$this->dd_f_nacimiento=$dd_f_nacimiento;
	}

	/**
	 * Obtiene el valor de Fk_Id_Genero
	 * @return mixed
	 */
	public function getFkIdGenero()
	{
		return $this->fk_id_genero;
	}

	/**
	 * Asigna el valor para Fk_Id_Genero
	 * @param mixed $fk_id_genero
	 */
	public function setFkIdGenero($fk_id_genero)
	{
		$this->fk_id_genero=$fk_id_genero;
	}

	/**
	 * Obtiene el valor de In_Grupo_Poblacional
	 * @return mixed
	 */
	public function getInGrupoPoblacional()
	{
		return $this->in_grupo_poblacional;
	}

	/**
	 * Asigna el valor para In_Grupo_Poblacional
	 * @param mixed $in_grupo_poblacional
	 */
	public function setInGrupoPoblacional($in_grupo_poblacional)
	{
		$this->in_grupo_poblacional=$in_grupo_poblacional;
	}

	/**
	 * Obtiene el valor de In_Identificacion_Poblacional
	 * @return mixed
	 */
	public function getInIdentificacionPoblacional()
	{
		return $this->in_identificacion_poblacional;
	}

	/**
	 * Asigna el valor para In_Grupo_Poblacional
	 * @param mixed $in_identificacion_poblacional
	 */
	public function setInIdentificacionPoblacional($in_identificacion_poblacional)
	{
		$this->in_identificacion_poblacional=$in_identificacion_poblacional;
	}

	/**
	 * Obtiene el valor de Fk_Id_Usuario_Registra
	 * @return mixed
	 */
	public function getFkIdUsuarioRegistra()
	{
		return $this->fk_id_usuario_registra;
	}

	/**
	 * Asigna el valor para Fk_Id_Usuario_Registra
	 * @param mixed $fk_id_usuario_registra
	 */
	public function setFkIdUsuarioRegistra($fk_id_usuario_registra)
	{
		$this->fk_id_usuario_registra=$fk_id_usuario_registra;
	}

	/**
	 * Obtiene el valor de Dt_Fecha_Registro
	 * @return mixed
	 */
	public function getDtFechaRegistro()
	{
		return $this->dt_fecha_registro;
	}

	/**
	 * Asigna el valor para Dt_Fecha_Registro
	 * @param mixed $dt_fecha_registro
	 */
	public function setDtFechaRegistro($dt_fecha_registro)
	{
		$this->dt_fecha_registro=$dt_fecha_registro;
	}


		/**
		 * Obtiene el valor de VC_Observacion
		 * @return mixed
		 */
		public function getVcObservacion()
		{
			return $this->vc_observacion;
		}

		/**
		 * Asigna el valor para VC_Observacion
		 * @param mixed $vc_observacion
		 */
		public function setVcObservacion($vc_observacion)
		{
			$this->vc_observacion=$vc_observacion;
		}

		/**
		 * Obtiene el valor de VC_Uso_Imagen
		 * @return mixed
		 */
		public function getVcUsoImagen()
		{
			return $this->vc_uso_imagen;
		}

		/**
		 * Asigna el valor para VC_Uso_Iamgen
		 * @param mixed $vc_uso_imagen
		 */
		public function setVcUsoImagen($vc_uso_imagen)
		{
			$this->vc_uso_imagen=$vc_uso_imagen;
		}

	}
