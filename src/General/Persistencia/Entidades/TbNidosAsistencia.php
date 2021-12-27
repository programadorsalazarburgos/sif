<?php
namespace  General\Persistencia\Entidades;

class TbNidosAsistencia{

    private $pk_id_asistencia;
    private $fk_id_experiencia;
    private $fk_id_evento;
    private $fk_id_llamada;
    private $fk_id_beneficiario;
    private $vc_asistencia;
    private $vc_nivel;
    private $fk_id_lugar_atencion_evento;


    /**
     * @return mixed
     */
    public function getPkIdAsistencia()
    {
        return $this->pk_id_asistencia;
    }

    /**
     * @param mixed $pk_id_asistencia
     *
     * @return self
     */
    public function setPkIdAsistencia($pk_id_asistencia)
    {
        $this->pk_id_asistencia = $pk_id_asistencia;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdExperiencia()
    {
        return $this->fk_id_experiencia;
    }

    /**
     * @param mixed $fk_id_experiencia
     *
     * @return self
     */
    public function setFkIdExperiencia($fk_id_experiencia)
    {
        $this->fk_id_experiencia = $fk_id_experiencia;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdEvento()
    {
        return $this->fk_id_evento;
    }

    /**
     * @param mixed $fk_id_evento
     *
     * @return self
     */
    public function setFkIdEvento($fk_id_evento)
    {
        $this->fk_id_evento = $fk_id_evento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdLlamada()
    {
        return $this->fk_id_llamada;
    }

    /**
     * @param mixed $fk_id_llamada
     *
     * @return self
     */
    public function setFkIdLlamada($fk_id_llamada)
    {
        $this->fk_id_llamada = $fk_id_llamada;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdBeneficiario()
    {
        return $this->fk_id_beneficiario;
    }

    /**
     * @param mixed $fk_id_beneficiario
     *
     * @return self
     */
    public function setFkIdBeneficiario($fk_id_beneficiario)
    {
        $this->fk_id_beneficiario = $fk_id_beneficiario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcAsistencia()
    {
        return $this->vc_asistencia;
    }

    /**
     * @param mixed $vc_asistencia
     *
     * @return self
     */
    public function setVcAsistencia($vc_asistencia)
    {
        $this->vc_asistencia = $vc_asistencia;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNivel()
    {
        return $this->vc_nivel;
    }

    /**
     * @param mixed $vc_nivel
     *
     * @return self
     */
    public function setVcNivel($vc_nivel)
    {
        $this->vc_nivel = $vc_nivel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdLugarAtencionEvento()
    {
        return $this->fk_id_lugar_atencion_evento;
    }

    /**
     * @param mixed $fk_id_lugar_atencion_evento
     *
     * @return self
     */
    public function setFkIdLugarAtencionEvento($fk_id_lugar_atencion_evento)
    {
        $this->fk_id_lugar_atencion_evento = $fk_id_lugar_atencion_evento;

        return $this;
    }
}
