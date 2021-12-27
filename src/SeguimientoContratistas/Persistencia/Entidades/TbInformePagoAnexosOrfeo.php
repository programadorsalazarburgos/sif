<?php

namespace SeguimientoContratistas\Persistencia\Entidades;

class TbInformePagoAnexosOrfeo {

	public $pk_id_tabla;
	public $fk_persona;
	public $fk_informe_pago_persona;
	public $fk_parametro_d;
	public $tx_anexo;
	public $dt_date;

	/**
	 * Asigna el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
	public function setVariables($objeto) {
		foreach ($objeto as $clave => $valor) {
			$clave = strtolower($clave);
			if ($valor == null) {
				$this->{$clave}= NULL;
			}
			else {
				$this->{$clave} = $valor;
			}
		}
	}

	/**
	 * Crea la sintaxis de SQL para el WHERE con el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
	public function setWhere($tabla) {
		$where = '';
		foreach ($this as $clave => $valor) {
			if ($valor['valor'] != null && $valor['valor'] != '') {
				if ($where === '') {
					$where .= $tabla.'.'.$clave.$valor['signo'].$valor['valor'];
				}
			} else {

				$where .= ' AND '.$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
			}
		}

		return $where;
	}

	/**
	 * Crea la sintaxis de SQL para el UPDATE con el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
	public function setUpdate($tabla) {
		$update = '';
		$where  = '';
		foreach ($this as $clave => $valor) {
			if ($valor['valor'] != null && $valor['valor'] != '') {
				if ($valor['llave']) {
					if ($where === '') {
						$where .= $tabla.'.'.$clave.$valor['signo'].$valor['valor'];
					} else {

						$where .= ' AND '.$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
					}
				} else {
					if ($update === '') {
						$update .= $tabla.'.'.$clave.'='.$valor['valor'];
					} else {

						$update .= ','.$tabla.'.'.$clave.'='.$valor['valor'];
					}

				}

			}
		}

		return $update.' WHERE '.$where;
	}

	/**
	 * @return mixed
	 */
	public function getPkIdTabla() {
		return $this->pk_id_tabla;
	}

	/**
	 * @param mixed $pk_id_tabla
	 *
	 * @return self
	 */
	public function setPkIdTabla($pk_id_tabla) {
		$this->pk_id_tabla = $pk_id_tabla;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFkPersona() {
		return $this->fk_persona;
	}

	/**
	 * @param mixed $fk_persona
	 *
	 * @return self
	 */
	public function setFkPersona($fk_persona) {
		$this->fk_persona = $fk_persona;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFkInformePagoPersona() {
		return $this->fk_informe_pago_persona;
	}

	/**
	 * @param mixed $fk_informe_pago_persona
	 *
	 * @return self
	 */
	public function setFkInformePagoPersona($fk_informe_pago_persona) {
		$this->fk_informe_pago_persona = $fk_informe_pago_persona;

		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getFkParametroD() {
		return $this->fk_parametro_d;
	}

	/**
	 * @param mixed $fk_parametro_d
	 *
	 * @return self
	 */
	public function setFkParametroD($fk_parametro_d) {
		$this->fk_parametro_d = $fk_parametro_d;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTxAnexo() {
		return $this->tx_anexo;
	}

	/**
	 * @param mixed $tx_anexo
	 *
	 * @return self
	 */
	public function setTxAnexo($tx_anexo) {
		$this->tx_anexo = $tx_anexo;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDtDate() {
		return $this->dt_date;
	}

	/**
	 * @param mixed $dt_date
	 *
	 * @return self
	 */
	public function setDtDate($dt_date) {
		$this->dt_date = $dt_date;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFkInformePagoBasico() {
		return $this->fk_informe_pago_basico;
	}

	/**
	 * @param mixed $fk_informe_pago_basico
	 *
	 * @return self
	 */
	public function setFkInformePagoBasico($fk_informe_pago_basico) {
		$this->fk_informe_pago_basico = $fk_informe_pago_basico;

		return $this;
	}

}
