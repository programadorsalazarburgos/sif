<?php

namespace SeguimientoContratistas\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_persona'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05
 */
class TbInformePagoPersona {

	private $pk_id_tabla;
	private $fk_persona;
	private $vc_fecha_informe;
	private $vc_periodo_inicio;
	private $vc_periodo_fin;
	private $vc_numero_contrato;
	private $vc_tipo_identificacion;
	private $vc_identificacion;
	private $vc_ciiu;
	private $vc_nombres_apellidos_cedente;
	private $vc_tipo_identificacion_cedente;
	private $vc_identificacion_cendete;
	private $vc_banco;
	private $vc_tipo_cuenta;
	private $vc_numero_cuenta;
	private $vc_objeto;
	private $vc_fecha_inicio;
	private $vc_plazo_inicial;
	private $vc_prorrogas;
	private $vc_fecha_plazo_fin;
	private $vc_fecha_fin;
	private $vc_numero_pagos;
	private $vc_pago_numero;
	private $vc_pago_de_total;
	private $tx_rp_json;
	private $vc_valor_inicial;
	private $vc_valor_adicion_1;
	private $vc_valor_adicion_2;
	private $vc_valor_adicion_3;
	private $vc_valor_total_contrato;
	private $vc_valor_pago_efectuar;
	private $vc_valor_letras;
	private $vc_giros_efectuados;
	private $vc_saldo_pediente;
	private $vc_valor_liberar;
	private $vc_numero_obligaciones;
	private $tx_obligaciones_json;
	private $vc_textarea_producto;
	private $vc_textarea_mecanismo_verificacion;
	private $tx_declaracion_json;
	private $vc_disminucion_retencion;
	private $vc_tomados_retencion;
	private $vc_mes_planilla;
	private $vc_numero_planilla;
	private $da_subida;
	private $sm_finalizado;
	private $sm_estado;
	private $vc_observacion;
	private $fk_persona_supervisor;
	private $fk_persona_apoyo_supervisor;
	private $fk_aprobacion_administrativo;
	private $da_revision;
	private $fk_persona_reviso;
	private $da_aprobo;
	private $fk_persona_aprobo;
	private $tx_planillas_extras;
	private $tx_suspension;
	private $fk_basico;

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
	public function getVcFechaInforme() {
		return $this->vc_fecha_informe;
	}

	/**
	 * @param mixed $vc_fecha_informe
	 *
	 * @return self
	 */
	public function setVcFechaInforme($vc_fecha_informe) {
		$this->vc_fecha_informe = $vc_fecha_informe;

		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getVcPeriodoInicio() {
		return $this->vc_periodo_inicio;
	}

	/**
	 * @param mixed $vc_periodo_inicio
	 *
	 * @return self
	 */
	public function setVcPeriodoInicio($vc_periodo_inicio) {
		$this->vc_periodo_inicio = $vc_periodo_inicio;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcPeriodoFin() {
		return $this->vc_periodo_fin;
	}

	/**
	 * @param mixed $vc_periodo_fin
	 *
	 * @return self
	 */
	public function setVcPeriodoFin($vc_periodo_fin) {
		$this->vc_periodo_fin = $vc_periodo_fin;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcNumeroContrato() {
		return $this->vc_numero_contrato;
	}

	/**
	 * @param mixed $vc_numero_contrato
	 *
	 * @return self
	 */
	public function setVcNumeroContrato($vc_numero_contrato) {
		$this->vc_numero_contrato = $vc_numero_contrato;

		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getVcTipoIdentificacion() {
		return $this->vc_tipo_identificacion;
	}

	/**
	 * @param mixed $vc_tipo_identificacion
	 *
	 * @return self
	 */
	public function setVcTipoIdentificacion($vc_tipo_identificacion) {
		$this->vc_tipo_identificacion = $vc_tipo_identificacion;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcIdentificacion() {
		return $this->vc_identificacion;
	}

	/**
	 * @param mixed $vc_identificacion
	 *
	 * @return self
	 */
	public function setVcIdentificacion($vc_identificacion) {
		$this->vc_identificacion = $vc_identificacion;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcCiiu() {
		return $this->vc_ciiu;
	}

	/**
	 * @param mixed $vc_ciiu
	 *
	 * @return self
	 */
	public function setVcCiiu($vc_ciiu) {
		$this->vc_ciiu = $vc_ciiu;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcNombresApellidosCedente() {
		return $this->vc_nombres_apellidos_cedente;
	}

	/**
	 * @param mixed $vc_nombres_apellidos_cedente
	 *
	 * @return self
	 */
	public function setVcNombresApellidosCedente($vc_nombres_apellidos_cedente) {
		$this->vc_nombres_apellidos_cedente = $vc_nombres_apellidos_cedente;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcTipoIdentificacionCedente() {
		return $this->vc_tipo_identificacion_cedente;
	}

	/**
	 * @param mixed $vc_tipo_identificacion_cedente
	 *
	 * @return self
	 */
	public function setVcTipoIdentificacionCedente($vc_tipo_identificacion_cedente) {
		$this->vc_tipo_identificacion_cedente = $vc_tipo_identificacion_cedente;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcIdentificacionCendete() {
		return $this->vc_identificacion_cendete;
	}

	/**
	 * @param mixed $vc_identificacion_cendete
	 *
	 * @return self
	 */
	public function setVcIdentificacionCendete($vc_identificacion_cendete) {
		$this->vc_identificacion_cendete = $vc_identificacion_cendete;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcBanco() {
		return $this->vc_banco;
	}

	/**
	 * @param mixed $vc_banco
	 *
	 * @return self
	 */
	public function setVcBanco($vc_banco) {
		$this->vc_banco = $vc_banco;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcTipoCuenta() {
		return $this->vc_tipo_cuenta;
	}

	/**
	 * @param mixed $vc_tipo_cuenta
	 *
	 * @return self
	 */
	public function setVcTipoCuenta($vc_tipo_cuenta) {
		$this->vc_tipo_cuenta = $vc_tipo_cuenta;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcNumeroCuenta() {
		return $this->vc_numero_cuenta;
	}

	/**
	 * @param mixed $vc_numero_cuenta
	 *
	 * @return self
	 */
	public function setVcNumeroCuenta($vc_numero_cuenta) {
		$this->vc_numero_cuenta = $vc_numero_cuenta;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcObjeto() {
		return $this->vc_objeto;
	}

	/**
	 * @param mixed $vc_objeto
	 *
	 * @return self
	 */
	public function setVcObjeto($vc_objeto) {
		$this->vc_objeto = $vc_objeto;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcFechaInicio() {
		return $this->vc_fecha_inicio;
	}

	/**
	 * @param mixed $vc_fecha_inicio
	 *
	 * @return self
	 */
	public function setVcFechaInicio($vc_fecha_inicio) {
		$this->vc_fecha_inicio = $vc_fecha_inicio;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcPlazoInicial() {
		return $this->vc_plazo_inicial;
	}

	/**
	 * @param mixed $vc_plazo_inicial
	 *
	 * @return self
	 */
	public function setVcPlazoInicial($vc_plazo_inicial) {
		$this->vc_plazo_inicial = $vc_plazo_inicial;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcProrrogas() {
		return $this->vc_prorrogas;
	}

	/**
	 * @param mixed $vc_prorrogas
	 *
	 * @return self
	 */
	public function setVcProrrogas($vc_prorrogas) {
		$this->vc_prorrogas = $vc_prorrogas;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcFechaPlazoFin() {
		return $this->vc_fecha_plazo_fin;
	}

	/**
	 * @param mixed $vc_fecha_plazo_fin
	 *
	 * @return self
	 */
	public function setVcFechaPlazoFin($vc_fecha_plazo_fin) {
		$this->vc_fecha_plazo_fin = $vc_fecha_plazo_fin;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcFechaFin() {
		return $this->vc_fecha_fin;
	}

	/**
	 * @param mixed $vc_fecha_fin
	 *
	 * @return self
	 */
	public function setVcFechaFin($vc_fecha_fin) {
		$this->vc_fecha_fin = $vc_fecha_fin;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcNumeroPagos() {
		return $this->vc_numero_pagos;
	}

	/**
	 * @param mixed $vc_numero_pagos
	 *
	 * @return self
	 */
	public function setVcNumeroPagos($vc_numero_pagos) {
		$this->vc_numero_pagos = $vc_numero_pagos;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcPagoNumero() {
		return $this->vc_pago_numero;
	}

	/**
	 * @param mixed $vc_pago_numero
	 *
	 * @return self
	 */
	public function setVcPagoNumero($vc_pago_numero) {
		$this->vc_pago_numero = $vc_pago_numero;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcPagoDeTotal() {
		return $this->vc_pago_de_total;
	}

	/**
	 * @param mixed $vc_pago_de_total
	 *
	 * @return self
	 */
	public function setVcPagoDeTotal($vc_pago_de_total) {
		$this->vc_pago_de_total = $vc_pago_de_total;

		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getTxRpJson() {
		return $this->tx_rp_json;
	}

	/**
	 * @param mixed $tx_rp_json
	 *
	 * @return self
	 */
	public function setTxRpJson($tx_rp_json) {
		$this->tx_rp_json = json_encode($tx_rp_json);

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcValorInicial() {
		return $this->vc_valor_inicial;
	}

	/**
	 * @param mixed $vc_valor_inicial
	 *
	 * @return self
	 */
	public function setVcValorInicial($vc_valor_inicial) {
		$this->vc_valor_inicial = $vc_valor_inicial;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcValorAdicion1() {
		return $this->vc_valor_adicion_1;
	}

	/**
	 * @param mixed $vc_valor_adicion_1
	 *
	 * @return self
	 */
	public function setVcValorAdicion1($vc_valor_adicion_1) {
		$this->vc_valor_adicion_1 = $vc_valor_adicion_1;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcValorAdicion2() {
		return $this->vc_valor_adicion_2;
	}

	/**
	 * @param mixed $vc_valor_adicion_2
	 *
	 * @return self
	 */
	public function setVcValorAdicion2($vc_valor_adicion_2) {
		$this->vc_valor_adicion_2 = $vc_valor_adicion_2;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcValorAdicion3() {
		return $this->vc_valor_adicion_3;
	}

	/**
	 * @param mixed $vc_valor_adicion_3
	 *
	 * @return self
	 */
	public function setVcValorAdicion3($vc_valor_adicion_3) {
		$this->vc_valor_adicion_3 = $vc_valor_adicion_3;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcValorTotalContrato() {
		return $this->vc_valor_total_contrato;
	}

	/**
	 * @param mixed $vc_valor_total_contrato
	 *
	 * @return self
	 */
	public function setVcValorTotalContrato($vc_valor_total_contrato) {
		$this->vc_valor_total_contrato = $vc_valor_total_contrato;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcValorPagoEfectuar() {
		return $this->vc_valor_pago_efectuar;
	}

	/**
	 * @param mixed $vc_valor_pago_efectuar
	 *
	 * @return self
	 */
	public function setVcValorPagoEfectuar($vc_valor_pago_efectuar) {
		$this->vc_valor_pago_efectuar = $vc_valor_pago_efectuar;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcValorLetras() {
		return $this->vc_valor_letras;
	}

	/**
	 * @param mixed $vc_valor_letras
	 *
	 * @return self
	 */
	public function setVcValorLetras($vc_valor_letras) {
		$this->vc_valor_letras = $vc_valor_letras;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcGirosEfectuados() {
		return $this->vc_giros_efectuados;
	}

	/**
	 * @param mixed $vc_giros_efectuados
	 *
	 * @return self
	 */
	public function setVcGirosEfectuados($vc_giros_efectuados) {
		$this->vc_giros_efectuados = $vc_giros_efectuados;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcSaldoPediente() {
		return $this->vc_saldo_pediente;
	}

	/**
	 * @param mixed $vc_saldo_pediente
	 *
	 * @return self
	 */
	public function setVcSaldoPediente($vc_saldo_pediente) {
		$this->vc_saldo_pediente = $vc_saldo_pediente;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcValorLiberar() {
		return $this->vc_valor_liberar;
	}

	/**
	 * @param mixed $vc_valor_liberar
	 *
	 * @return self
	 */
	public function setVcValorLiberar($vc_valor_liberar) {
		$this->vc_valor_liberar = $vc_valor_liberar;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcNumeroObligaciones() {
		return $this->vc_numero_obligaciones;
	}

	/**
	 * @param mixed $vc_numero_obligaciones
	 *
	 * @return self
	 */
	public function setVcNumeroObligaciones($vc_numero_obligaciones) {
		$this->vc_numero_obligaciones = $vc_numero_obligaciones;

		
	}

	/**
	 * @return mixed
	 */
	public function getTxObligacionesJson() {
		return $this->tx_obligaciones_json;
	}

	/**
	 * @param mixed $tx_obligaciones_json
	 *
	 * @return self
	 */
	public function setTxObligacionesJson($tx_obligaciones_json) {
		$this->tx_obligaciones_json = json_encode($tx_obligaciones_json);

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcTextareaProducto() {
		return $this->vc_textarea_producto;
	}

	/**
	 * @param mixed $vc_textarea_producto
	 *
	 * @return self
	 */
	public function setVcTextareaProducto($vc_textarea_producto) {
		$this->vc_textarea_producto = $vc_textarea_producto;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcTextareaMecanismoVerificacion() {
		return $this->vc_textarea_mecanismo_verificacion;
	}

	/**
	 * @param mixed $vc_textarea_mecanismo_verificacion
	 *
	 * @return self
	 */
	public function setVcTextareaMecanismoVerificacion($vc_textarea_mecanismo_verificacion) {
		$this->vc_textarea_mecanismo_verificacion = $vc_textarea_mecanismo_verificacion;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTxDeclaracionJson() {
		return $this->tx_declaracion_json;
	}

	/**
	 * @param mixed $tx_declaracion_json
	 *
	 * @return self
	 */
	public function setTxDeclaracionJson($tx_declaracion_json) {
		$this->tx_declaracion_json = json_encode($tx_declaracion_json);
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcDisminucionRetencion() {
		return $this->vc_disminucion_retencion;
	}

	/**
	 * @param mixed $vc_disminucion_retencion
	 *
	 * @return self
	 */
	public function setVcDisminucionRetencion($vc_disminucion_retencion) {
		$this->vc_disminucion_retencion = $vc_disminucion_retencion;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcTomadosRetencion() {
		return $this->vc_tomados_retencion;
	}

	/**
	 * @param mixed $vc_tomados_retencion
	 *
	 * @return self
	 */
	public function setVcTomadosRetencion($vc_tomados_retencion) {
		$this->vc_tomados_retencion = $vc_tomados_retencion;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcMesPlanilla() {
		return $this->vc_mes_planilla;
	}

	/**
	 * @param mixed $vc_mes_planilla
	 *
	 * @return self
	 */
	public function setVcMesPlanilla($vc_mes_planilla) {
		$this->vc_mes_planilla = $vc_mes_planilla;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVcNumeroPlanilla() {
		return $this->vc_numero_planilla;
	}

	/**
	 * @param mixed $vc_numero_planilla
	 *
	 * @return self
	 */
	public function setVcNumeroPlanilla($vc_numero_planilla) {
		$this->vc_numero_planilla = $vc_numero_planilla;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDaSubida() {
		return $this->da_subida;
	}

	/**
	 * @param mixed $da_subida
	 *
	 * @return self
	 */
	public function setDaSubida($da_subida) {
		$this->da_subida = $da_subida;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSmEstado() {
		return $this->sm_estado;
	}

	/**
	 * @param mixed $sm_estado
	 *
	 * @return self
	 */
	public function setSmEstado($sm_estado) {
		$this->sm_estado = $sm_estado;

		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getSmfinalizado() {
		return $this->sm_finalizado;
	}

	/**
	 * @param mixed $sm_finalizado
	 *
	 * @return self
	 */
	public function setSmfinalizado($sm_finalizado) {
		$this->sm_finalizado = $sm_finalizado;

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
	public function getDaRevision() {
		return $this->da_revision;
	}

	/**
	 * @param mixed $da_revision
	 *
	 * @return self
	 */
	public function setDaRevision($da_revision) {
		$this->da_revision = $da_revision;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFkPersonaReviso() {
		return $this->fk_persona_reviso;
	}

	/**
	 * @param mixed $fk_persona_reviso
	 *
	 * @return self
	 */
	public function setFkPersonaReviso($fk_persona_reviso) {
		$this->fk_persona_reviso = $fk_persona_reviso;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDaAprobo() {
		return $this->da_aprobo;
	}

	/**
	 * @param mixed $da_aprobo
	 *
	 * @return self
	 */
	public function setDaAprobo($da_aprobo) {
		$this->da_aprobo = $da_aprobo;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFkPersonaAprobo() {
		return $this->fk_persona_aprobo;
	}

	/**
	 * @param mixed $fk_persona_aprobo
	 *
	 * @return self
	 */
	public function setFkPersonaAprobo($fk_persona_aprobo) {
		$this->fk_persona_aprobo = $fk_persona_aprobo;

		return $this;
	}
	 /**
     * @return mixed
     */
	 public function getFkPersonaSupervisor()
	 {
	 	return $this->fk_persona_supervisor;
	 }

    /**
     * @param mixed $fk_persona_supervisor
     *
     * @return self
     */
    public function setFkPersonaSupervisor($fk_persona_supervisor)
    {
    	$this->fk_persona_supervisor = $fk_persona_supervisor;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getFkPersonaApoyoSupervisor()
    {
    	return $this->fk_persona_apoyo_supervisor;
    }

    /**
     * @param mixed $fk_persona_apoyo_supervisor
     *
     * @return self
     */
    public function setFkPersonaApoyoSupervisor($fk_persona_apoyo_supervisor)
    {
    	$this->fk_persona_apoyo_supervisor = $fk_persona_apoyo_supervisor;

    	return $this;
    }
    /**
     * @return mixed
     */
    public function getFkAprobacionAdministrativo()
    {
    	return $this->fk_aprobacion_administrativo;
    }

    /**
     * @param mixed $fk_aprobacion_administrativo
     *
     * @return self
     */
    public function setFkAprobacionAdministrativo($fk_aprobacion_administrativo)
    {
    	$this->fk_aprobacion_administrativo = $fk_aprobacion_administrativo;

    	return $this;
    }
    
    /**
     * @return mixed
     */
    public function getTxPlanillasExtras()
    {
    	return $this->tx_planillas_extras;
    }

    /**
     * @param mixed $tx_planillas_extras
     *
     * @return self
     */
    public function setTxPlanillasExtras($tx_planillas_extras)
    {
    	$this->tx_planillas_extras = $tx_planillas_extras;

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getTxSuspension()
    {
    	return $this->tx_suspension;
    }

    /**
     * @param mixed $tx_suspension
     *
     * @return self
     */
    public function setTxSuspension($tx_suspension)
    {
    	$this->tx_suspension = json_encode( $tx_suspension );

    	return $this;
    }

    /**
     * @return mixed
     */
    public function getFkBasico()
    {
    	return $this->fk_basico;
    }

    /**
     * @param mixed $fk_basico
     *
     * @return self
     */
    public function setFkBasico($fk_basico)
    {
    	$this->fk_basico = $fk_basico;

    	return $this;
    }
}
