<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_acceso_usuario'
 *
 * @author: Javier Leon
 * @date: 2018-11-13	 
 */
class TbOrganizacionesProyeccionGasto 
{
	
	private $pk_seguimiento_gasto_id;
	private $fk_organizacion_id;
	private $tx_periodo;
	private $in_anio;
	private $tx_total_idartes; 
	private $tx_total_asociado;
	private $tx_caja;
	private $tx_egresos;
	private $tx_grupos;
	private $vc_rubros; 
	private $fk_persona_registro;
	private $dt_fecha_registro;
	private $tx_observaciones;
	private $in_aprobacion;
	private $fk_persona_revisa;
	private $da_cambio;
	private $in_estado_final;
	private $fk_id_seguimiento_propuesta;


    /**
     * @return mixed
     */
    public function getPkSeguimientoGastoId()
    {
        return $this->pk_seguimiento_gasto_id;
    }

    /**
     * @param mixed $pk_seguimiento_gasto_id
     *
     * @return self
     */
    public function setPkSeguimientoGastoId($pk_seguimiento_gasto_id)
    {
        $this->pk_seguimiento_gasto_id = $pk_seguimiento_gasto_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkOrganizacionId()
    {
        return $this->fk_organizacion_id;
    }

    /**
     * @param mixed $fk_organizacion_id
     *
     * @return self
     */
    public function setFkOrganizacionId($fk_organizacion_id)
    {
        $this->fk_organizacion_id = $fk_organizacion_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxPeriodo()
    {
        return $this->tx_periodo;
    }

    /**
     * @param mixed $tx_periodo
     *
     * @return self
     */
    public function setTxPeriodo($tx_periodo)
    {
        $this->tx_periodo = $tx_periodo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInAnio()
    {
        return $this->in_anio;
    }

    /**
     * @param mixed $in_anio
     *
     * @return self
     */
    public function setInAnio($in_anio)
    {
        $this->in_anio = $in_anio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxTotalIdartes()
    {
        return $this->tx_total_idartes;
    }

    /**
     * @param mixed $tx_total_idartes
     *
     * @return self
     */
    public function setTxTotalIdartes($tx_total_idartes)
    {
        $this->tx_total_idartes = $tx_total_idartes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxTotalAsociado()
    {
        return $this->tx_total_asociado;
    }

    /**
     * @param mixed $tx_total_asociado
     *
     * @return self
     */
    public function setTxTotalAsociado($tx_total_asociado)
    {
        $this->tx_total_asociado = $tx_total_asociado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxCaja()
    {
        return $this->tx_caja;
    }

    /**
     * @param mixed $tx_caja
     *
     * @return self
     */
    public function setTxCaja($tx_caja)
    {
        $this->tx_caja = $tx_caja;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxEgresos()
    {
        return $this->tx_egresos;
    }

    /**
     * @param mixed $tx_egresos
     *
     * @return self
     */
    public function setTxEgresos($tx_egresos)
    {
        $this->tx_egresos = $tx_egresos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxGrupos()
    {
        return $this->tx_grupos;
    }

    /**
     * @param mixed $tx_grupos
     *
     * @return self
     */
    public function setTxGrupos($tx_grupos)
    {
        $this->tx_grupos = $tx_grupos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcRubros()
    {
        return $this->vc_rubros;
    }

    /**
     * @param mixed $vc_rubros
     *
     * @return self
     */
    public function setVcRubros($vc_rubros)
    {
        $this->vc_rubros = $vc_rubros;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkPersonaRegistro()
    {
        return $this->fk_persona_registro;
    }

    /**
     * @param mixed $fk_persona_registro
     *
     * @return self
     */
    public function setFkPersonaRegistro($fk_persona_registro)
    {
        $this->fk_persona_registro = $fk_persona_registro;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaRegistro()
    {
        return $this->dt_fecha_registro;
    }

    /**
     * @param mixed $dt_fecha_registro
     *
     * @return self
     */
    public function setDtFechaRegistro($dt_fecha_registro)
    {
        $this->dt_fecha_registro = $dt_fecha_registro;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxObservaciones()
    {
        return $this->tx_observaciones;
    }

    /**
     * @param mixed $tx_observaciones
     *
     * @return self
     */
    public function setTxObservaciones($tx_observaciones)
    {
        $this->tx_observaciones = $tx_observaciones;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInAprobacion()
    {
        return $this->in_aprobacion;
    }

    /**
     * @param mixed $in_aprobacion
     *
     * @return self
     */
    public function setInAprobacion($in_aprobacion)
    {
        $this->in_aprobacion = $in_aprobacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkPersonaRevisa()
    {
        return $this->fk_persona_revisa;
    }

    /**
     * @param mixed $fk_persona_revisa
     *
     * @return self
     */
    public function setFkPersonaRevisa($fk_persona_revisa)
    {
        $this->fk_persona_revisa = $fk_persona_revisa;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDaCambio()
    {
        return $this->da_cambio;
    }

    /**
     * @param mixed $da_cambio
     *
     * @return self
     */
    public function setDaCambio($da_cambio)
    {
        $this->da_cambio = $da_cambio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInEstadoFinal()
    {
        return $this->in_estado_final;
    }

    /**
     * @param mixed $in_estado_final
     *
     * @return self
     */
    public function setInEstadoFinal($in_estado_final)
    {
        $this->in_estado_final = $in_estado_final;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdSeguimientoPropuesta()
    {
        return $this->fk_id_seguimiento_propuesta;
    }

    /**
     * @param mixed $fk_id_seguimiento_propuesta
     *
     * @return self
     */
    public function setFkIdSeguimientoPropuesta($fk_id_seguimiento_propuesta)
    {
        $this->fk_id_seguimiento_propuesta = $fk_id_seguimiento_propuesta;

        return $this;
    }
}
