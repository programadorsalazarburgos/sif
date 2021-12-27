<?php

namespace SeguimientoContratistas\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_persona'
 *
 * @author: Javier Leon
 * @date: 2017-07-05 23:05
 */
class tbInformeDetalladoPersona {

	private $fk_id_informe_pago;
    private $fk_persona;
	private $in_tipo_territorial;
	private $vc_periodo_inicio;
	private $vc_periodo_fin;
	private $vc_numero_contrato;
	private $vc_numero_obligaciones;
    private $tx_obligaciones_json;
	private $vc_url_anexo;
	private $da_subida;
	private $sm_finalizado;
	private $sm_estado;
	private $vc_observacion;
	private $da_revision;
	private $fk_persona_reviso;
	private $da_aprobo;
	private $fk_persona_aprobo;


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
    public function getFkIdInformePago(){
        return $this->fk_id_informe_pago;
    }

    /**
     * @param mixed $fk_id_informe_pago
     *
     * @return self
     */
    public function setFkIdInformePago($fk_id_informe_pago){
        $this->fk_id_informe_pago = $fk_id_informe_pago;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkPersona(){
        return $this->fk_persona;
    }

    /**
     * @param mixed $fk_persona
     *
     * @return self
     */
    public function setFkPersona($fk_persona){
        $this->fk_persona = $fk_persona;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInTipoTerritorial(){
        return $this->in_tipo_territorial;
    }

    /**
     * @param mixed $in_tipo_territorial
     *
     * @return self
     */
    public function setInTipoTerritorial($in_tipo_territorial){
        $this->in_tipo_territorial = $in_tipo_territorial;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcPeriodoInicio(){
        return $this->vc_periodo_inicio;
    }

    /**
     * @param mixed $vc_periodo_inicio
     *
     * @return self
     */
    public function setVcPeriodoInicio($vc_periodo_inicio){
        $this->vc_periodo_inicio = $vc_periodo_inicio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcPeriodoFin(){
        return $this->vc_periodo_fin;
    }

    /**
     * @param mixed $vc_periodo_fin
     *
     * @return self
     */
    public function setVcPeriodoFin($vc_periodo_fin){
        $this->vc_periodo_fin = $vc_periodo_fin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNumeroContrato(){
        return $this->vc_numero_contrato;
    }

    /**
     * @param mixed $vc_numero_contrato
     *
     * @return self
     */
    public function setVcNumeroContrato($vc_numero_contrato){
        $this->vc_numero_contrato = $vc_numero_contrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNumeroObligaciones(){
        return $this->vc_numero_obligaciones;
    }

    /**
     * @param mixed $vc_numero_obligaciones
     *
     * @return self
     */
    public function setVcNumeroObligaciones($vc_numero_obligaciones){
        $this->vc_numero_obligaciones = $vc_numero_obligaciones;

        return $this;
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
    public function getVcUrlAnexo(){
        return $this->vc_url_anexo;
    }

    /**
     * @param mixed $vc_url_anexo
     *
     * @return self
     */
    public function setVcUrlAnexo($vc_url_anexo){
        $this->vc_url_anexo = $vc_url_anexo;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getDaSubida(){
        return $this->da_subida;
    }

    /**
     * @param mixed $da_subida
     *
     * @return self
     */
    public function setDaSubida($da_subida){
        $this->da_subida = $da_subida;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSmFinalizado(){
        return $this->sm_finalizado;
    }

    /**
     * @param mixed $sm_finalizado
     *
     * @return self
     */
    public function setSmFinalizado($sm_finalizado){
        $this->sm_finalizado = $sm_finalizado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSmEstado(){
        return $this->sm_estado;
    }

    /**
     * @param mixed $sm_estado
     *
     * @return self
     */
    public function setSmEstado($sm_estado){
        $this->sm_estado = $sm_estado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcObservacion(){
        return $this->vc_observacion;
    }

    /**
     * @param mixed $vc_observacion
     *
     * @return self
     */
    public function setVcObservacion($vc_observacion){
        $this->vc_observacion = $vc_observacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDaRevision(){
        return $this->da_revision;
    }

    /**
     * @param mixed $da_revision
     *
     * @return self
     */
    public function setDaRevision($da_revision){
        $this->da_revision = $da_revision;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkPersonaReviso(){
        return $this->fk_persona_reviso;
    }

    /**
     * @param mixed $fk_persona_reviso
     *
     * @return self
     */
    public function setFkPersonaReviso($fk_persona_reviso){
        $this->fk_persona_reviso = $fk_persona_reviso;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDaAprobo(){
        return $this->da_aprobo;
    }

    /**
     * @param mixed $da_aprobo
     *
     * @return self
     */
    public function setDaAprobo($da_aprobo){
        $this->da_aprobo = $da_aprobo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkPersonaAprobo(){
        return $this->fk_persona_aprobo;
    }

    /**
     * @param mixed $fk_persona_aprobo
     *
     * @return self
     */
    public function setFkPersonaAprobo($fk_persona_aprobo){
        $this->fk_persona_aprobo = $fk_persona_aprobo;

        return $this;
    }
}
