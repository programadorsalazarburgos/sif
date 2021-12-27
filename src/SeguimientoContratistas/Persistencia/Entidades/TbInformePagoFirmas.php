<?php

namespace SeguimientoContratistas\Persistencia\Entidades;

class TbInformePagoFirmas {

	public $pk_id_tabla;
	public $fk_persona;
	public $fk_informe_pago_persona;
	public $vc_token;
	public $i_aprobado;
	public $dt_date;
    public $vc_observacion;
	public $vc_transaccion;
	public $vc_sistema_operativo;
	public $vc_navegador;
	public $vc_navegador_version;
	public $vc_direccion_ip;
	public $fk_usuario_orfeo;

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
	public function getVcToken() {
		return $this->vc_token;
	}

	/**
	 * @param mixed $vc_token
	 *
	 * @return self
	 */
	public function setVcToken($vc_token) {
		$this->vc_token = $vc_token;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIAprobado() {
		return $this->i_aprobado;
	}

	/**
	 * @param mixed $i_aprobado
	 *
	 * @return self
	 */
	public function setIAprobado($i_aprobado) {
		$this->i_aprobado = $i_aprobado;

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
	public function getVcObservacion() {
		return $this->vc_observacion;
	}

	/**
	 * @param mixed $vc_observacion
	 *
	 * @return self
	 */
	public function setVcObservacion($vc_observacion) {
		$this->vc_observacion = $vc_observacion;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcTransaccion() {
		return $this->vc_transaccion;
	}

	/**
	 * @param mixed $vc_transaccion
	 *
	 * @return self
	 */
	public function setVctransaccion($vc_transaccion) {
		$this->vc_transaccion = $vc_transaccion;

		return $this;
	}


	/**
	 * Get the value of vc_sistema_operativo
	 */ 
	public function getVcSistemaOperativo()
	{
		return $this->vc_sistema_operativo;
	}

	/**
	 * Set the value of vc_sistema_operativo
	 *
	 * @return  self
	 */ 
	public function setVcSistemaOperativo($vc_sistema_operativo)
	{
		$this->vc_sistema_operativo = $vc_sistema_operativo;

		return $this;
	}

	/**
	 * Get the value of vc_navegador
	 */ 
	public function getVcNavegador()
	{
		return $this->vc_navegador;
	}

	/**
	 * Set the value of vc_navegador
	 *
	 * @return  self
	 */ 
	public function setVcNavegador($vc_navegador)
	{
		$this->vc_navegador = $vc_navegador;

		return $this;
	}

	/**
	 * Get the value of vc_navegador_version
	 */ 
	public function getVcNavegadorVersion()
	{
		return $this->vc_navegador_version;
	}

	/**
	 * Set the value of vc_navegador_version
	 *
	 * @return  self
	 */ 
	public function setVcNavegadorVersion($vc_navegador_version)
	{
		$this->vc_navegador_version = $vc_navegador_version;

		return $this;
	}

	/**
	 * Get the value of vc_direccion_ip
	 */ 
	public function getVcDireccionIp()
	{
		return $this->vc_direccion_ip;
	}

	/**
	 * Set the value of vc_direccion_ip
	 *
	 * @return  self
	 */ 
	public function setVcDireccionIp($vc_direccion_ip)
	{
		$this->vc_direccion_ip = $vc_direccion_ip;

		return $this;
	}

	/**
	 * Get the value of fk_usuario_orfeo
	 */ 
	public function getFkUsuarioOrfeo()
	{
		return $this->fk_usuario_orfeo;
	}

	/**
	 * Set the value of fk_usuario_orfeo
	 *
	 * @return  self
	 */ 
	public function setFkUsuarioOrfeo($fk_usuario_orfeo)
	{
		$this->fk_usuario_orfeo = $fk_usuario_orfeo;

		return $this;
	}
}
