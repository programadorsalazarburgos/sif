<?php

namespace  General\Persistencia\Entidades;


class TbNidosHorariosAtencion{

    private $pk_id_horario;
    private $in_id_formulario;
    private $in_id_tipo_atencion;
    private $dt_fecha_atencion;
    private $vc_dia;
    private $vc_hora_inicio;
    private $vc_hora_fin;
    private $in_cupos;
    private $in_cupos_disponibles;
    private $dt_fecha_registro;
    private $fk_id_usuario_registro;


    /**
     * @return mixed
     */
    public function getPkIdHorario()
    {
        return $this->pk_id_horario;
    }

    /**
     * @param mixed $pk_id_Horario
     *
     * @return self
     */
    public function setPkIdHorario($pk_id_horario)
    {
        $this->pk_id_horario = $pk_id_horario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInIdFormulario()
    {
        return $this->in_id_formulario;
    }

    /**
     * @param mixed $in_id_formulario
     *
     * @return self
     */
    public function setInIdFormulario($in_id_formulario)
    {
        $this->in_id_formulario = $in_id_formulario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInIdTipoAtencion()
    {
        return $this->in_id_tipo_atencion;
    }

    /**
     * @param mixed $in_id_tipo_atencion
     *
     * @return self
     */
    public function setInIdTipoAtencion($in_id_tipo_atencion)
    {
        $this->in_id_tipo_atencion = $in_id_tipo_atencion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaAtencion()
    {
        return $this->dt_fecha_atencion;
    }

    /**
     * @param mixed $dt_fecha_atencion
     *
     * @return self
     */
    public function setDtFechaAtencion($dt_fecha_atencion)
    {
        $this->dt_fecha_atencion = $dt_fecha_atencion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcDia()
    {
        return $this->vc_dia;
    }

    /**
     * @param mixed $vc_dia
     *
     * @return self
     */
    public function setVcDia($vc_dia)
    {
        $this->vc_dia = $vc_dia;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcHoraInicio()
    {
        return $this->vc_hora_inicio;
    }

    /**
     * @param mixed $vc_hora_inicio
     *
     * @return self
     */
    public function setVcHoraInicio($vc_hora_inicio)
    {
        $this->vc_hora_inicio = $vc_hora_inicio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcHoraFin()
    {
        return $this->vc_hora_fin;
    }

    /**
     * @param mixed $vc_hora_fin
     *
     * @return self
     */
    public function setVcHoraFin($vc_hora_fin)
    {
        $this->vc_hora_fin = $vc_hora_fin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInCupos()
    {
        return $this->in_cupos;
    }

    /**
     * @param mixed $in_cupos
     *
     * @return self
     */
    public function setInCupos($in_cupos)
    {
        $this->in_cupos = $in_cupos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInCuposDisponibles()
    {
        return $this->in_cupos_disponibles;
    }

    /**
     * @param mixed $in_cupos_disponibles
     *
     * @return self
     */
    public function setInCuposDisponibles($in_cupos_disponibles)
    {
        $this->in_cupos_disponibles = $in_cupos_disponibles;

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
    public function getFkIdUsuarioRegistro()
    {
        return $this->fk_id_usuario_registro;
    }

    /**
     * @param mixed $fk_id_usuario_registro
     *
     * @return self
     */
    public function setFkIdUsuarioRegistro($fk_id_usuario_registro)
    {
        $this->fk_id_usuario_registro = $fk_id_usuario_registro;

        return $this;
    }
   
}