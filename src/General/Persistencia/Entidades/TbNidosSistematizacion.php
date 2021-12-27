<?php

namespace  General\Persistencia\Entidades;


class TbNidosSistematizacion{

    private $pk_id_sistematizacion;
    private $fk_id_dupla;
    private $vc_nombre_experiencia;
    private $tx_tema;
    private $tx_materias;
    private $in_periodo;
    private $tx_intencion_artistica;
    private $tx_referentes;
    private $tx_aplicabilidad_referentes;
    private $tx_ambientacion;
    private $tx_dispositivos;
    private $tx_momentos;
    private $tx_ninos_ins;
    private $tx_agentes_ins;
    private $tx_ninos_fam;
    private $tx_agentes_fam;
    private $tx_familias_fam;
    private $tx_mujeres_fam;
    private $tx_ninos_com;
    private $tx_familias_com;
    private $tx_aprendizajes_creacion;
    private $tx_aprendizajes_personales;
    private $tx_otros_aspectos;
    private $tx_banco_imagenes;
    private $tx_observaciones;
    private $dt_fecha_envio_planeacion;
    private $dt_fecha_envio_sistematizacion;
    private $fk_id_artista_envio_planeacion;
    private $fk_id_artista_envio_sistematizacion;
    private $in_aprobacion_planeacion;
    private $in_aprobacion_sistematizacion;
    private $fk_id_eaat_aprobo;
    private $dt_fecha_aprobacion_planeacion;
    private $dt_fecha_aprobacion_sistematizacion;


    /**
     * @return mixed
     */
    public function getPkIdSistematizacion()
    {
        return $this->pk_id_sistematizacion;
    }

    /**
     * @param mixed $pk_id_sistematizacion
     *
     * @return self
     */
    public function setPkIdSistematizacion($pk_id_sistematizacion)
    {
        $this->pk_id_sistematizacion = $pk_id_sistematizacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdDupla()
    {
        return $this->fk_id_dupla;
    }

    /**
     * @param mixed $fk_id_dupla
     *
     * @return self
     */
    public function setFkIdDupla($fk_id_dupla)
    {
        $this->fk_id_dupla = $fk_id_dupla;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNombreExperiencia()
    {
        return $this->vc_nombre_experiencia;
    }

    /**
     * @param mixed $vc_nombre_experiencia
     *
     * @return self
     */
    public function setVcNombreExperiencia($vc_nombre_experiencia)
    {
        $this->vc_nombre_experiencia = $vc_nombre_experiencia;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxTema()
    {
        return $this->tx_tema;
    }

    /**
     * @param mixed $tx_tema
     *
     * @return self
     */
    public function setTxTema($tx_tema)
    {
        $this->tx_tema = $tx_tema;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxMaterias()
    {
        return $this->tx_materias;
    }

    /**
     * @param mixed $tx_materias
     *
     * @return self
     */
    public function setTxMaterias($tx_materias)
    {
        $this->tx_materias = $tx_materias;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInPeriodo()
    {
        return $this->in_periodo;
    }

    /**
     * @param mixed $in_periodo
     *
     * @return self
     */
    public function setInPeriodo($in_periodo)
    {
        $this->in_periodo = $in_periodo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxIntencionArtistica()
    {
        return $this->tx_intencion_artistica;
    }

    /**
     * @param mixed $tx_intencion_artistica
     *
     * @return self
     */
    public function setTxIntencionArtistica($tx_intencion_artistica)
    {
        $this->tx_intencion_artistica = $tx_intencion_artistica;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxReferentes()
    {
        return $this->tx_referentes;
    }

    /**
     * @param mixed $tx_referentes
     *
     * @return self
     */
    public function setTxReferentes($tx_referentes)
    {
        $this->tx_referentes = $tx_referentes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxAplicabilidadReferentes()
    {
        return $this->tx_aplicabilidad_referentes;
    }

    /**
     * @param mixed $tx_aplicabilidad_referentes
     *
     * @return self
     */
    public function setTxAplicabilidadReferentes($tx_aplicabilidad_referentes)
    {
        $this->tx_aplicabilidad_referentes = $tx_aplicabilidad_referentes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxAmbientacion()
    {
        return $this->tx_ambientacion;
    }

    /**
     * @param mixed $tx_ambientacion
     *
     * @return self
     */
    public function setTxAmbientacion($tx_ambientacion)
    {
        $this->tx_ambientacion = $tx_ambientacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxDispositivos()
    {
        return $this->tx_dispositivos;
    }

    /**
     * @param mixed $tx_dispositivos
     *
     * @return self
     */
    public function setTxDispositivos($tx_dispositivos)
    {
        $this->tx_dispositivos = $tx_dispositivos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxMomentos()
    {
        return $this->tx_momentos;
    }

    /**
     * @param mixed $tx_momentos
     *
     * @return self
     */
    public function setTxMomentos($tx_momentos)
    {
        $this->tx_momentos = $tx_momentos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxNinosIns()
    {
        return $this->tx_ninos_ins;
    }

    /**
     * @param mixed $tx_ninos_ins
     *
     * @return self
     */
    public function setTxNinosIns($tx_ninos_ins)
    {
        $this->tx_ninos_ins = $tx_ninos_ins;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxAgentesIns()
    {
        return $this->tx_agentes_ins;
    }

    /**
     * @param mixed $tx_agentes_ins
     *
     * @return self
     */
    public function setTxAgentesIns($tx_agentes_ins)
    {
        $this->tx_agentes_ins = $tx_agentes_ins;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxNinosFam()
    {
        return $this->tx_ninos_fam;
    }

    /**
     * @param mixed $tx_ninos_fam
     *
     * @return self
     */
    public function setTxNinosFam($tx_ninos_fam)
    {
        $this->tx_ninos_fam = $tx_ninos_fam;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxAgentesFam()
    {
        return $this->tx_agentes_fam;
    }

    /**
     * @param mixed $tx_agentes_fam
     *
     * @return self
     */
    public function setTxAgentesFam($tx_agentes_fam)
    {
        $this->tx_agentes_fam = $tx_agentes_fam;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxFamiliasFam()
    {
        return $this->tx_familias_fam;
    }

    /**
     * @param mixed $tx_familias_fam
     *
     * @return self
     */
    public function setTxFamiliasFam($tx_familias_fam)
    {
        $this->tx_familias_fam = $tx_familias_fam;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxMujeresFam()
    {
        return $this->tx_mujeres_fam;
    }

    /**
     * @param mixed $tx_mujeres_fam
     *
     * @return self
     */
    public function setTxMujeresFam($tx_mujeres_fam)
    {
        $this->tx_mujeres_fam = $tx_mujeres_fam;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxNinosCom()
    {
        return $this->tx_ninos_com;
    }

    /**
     * @param mixed $tx_ninos_com
     *
     * @return self
     */
    public function setTxNinosCom($tx_ninos_com)
    {
        $this->tx_ninos_com = $tx_ninos_com;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxFamiliasCom()
    {
        return $this->tx_familias_com;
    }

    /**
     * @param mixed $tx_familias_com
     *
     * @return self
     */
    public function setTxFamiliasCom($tx_familias_com)
    {
        $this->tx_familias_com = $tx_familias_com;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxAprendizajesCreacion()
    {
        return $this->tx_aprendizajes_creacion;
    }

    /**
     * @param mixed $tx_aprendizajes_creacion
     *
     * @return self
     */
    public function setTxAprendizajesCreacion($tx_aprendizajes_creacion)
    {
        $this->tx_aprendizajes_creacion = $tx_aprendizajes_creacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxAprendizajesPersonales()
    {
        return $this->tx_aprendizajes_personales;
    }

    /**
     * @param mixed $tx_aprendizajes_personales
     *
     * @return self
     */
    public function setTxAprendizajesPersonales($tx_aprendizajes_personales)
    {
        $this->tx_aprendizajes_personales = $tx_aprendizajes_personales;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxOtrosAspectos()
    {
        return $this->tx_otros_aspectos;
    }

    /**
     * @param mixed $tx_otros_aspectos
     *
     * @return self
     */
    public function setTxOtrosAspectos($tx_otros_aspectos)
    {
        $this->tx_otros_aspectos = $tx_otros_aspectos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxBancoImagenes()
    {
        return $this->tx_banco_imagenes;
    }

    /**
     * @param mixed $tx_banco_imagenes
     *
     * @return self
     */
    public function setTxBancoImagenes($tx_banco_imagenes)
    {
        $this->tx_banco_imagenes = $tx_banco_imagenes;

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
    public function getDtFechaEnvioPlaneacion()
    {
        return $this->dt_fecha_envio_planeacion;
    }

    /**
     * @param mixed $dt_fecha_envio_planeacion
     *
     * @return self
     */
    public function setDtFechaEnvioPlaneacion($dt_fecha_envio_planeacion)
    {
        $this->dt_fecha_envio_planeacion = $dt_fecha_envio_planeacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaEnvioSistematizacion()
    {
        return $this->dt_fecha_envio_sistematizacion;
    }

    /**
     * @param mixed $dt_fecha_envio_sistematizacion
     *
     * @return self
     */
    public function setDtFechaEnvioSistematizacion($dt_fecha_envio_sistematizacion)
    {
        $this->dt_fecha_envio_sistematizacion = $dt_fecha_envio_sistematizacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdArtistaEnvioPlaneacion()
    {
        return $this->fk_id_artista_envio_planeacion;
    }

    /**
     * @param mixed $fk_id_artista_envio_planeacion
     *
     * @return self
     */
    public function setFkIdArtistaEnvioPlaneacion($fk_id_artista_envio_planeacion)
    {
        $this->fk_id_artista_envio_planeacion = $fk_id_artista_envio_planeacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdArtistaEnvioSistematizacion()
    {
        return $this->fk_id_artista_envio_sistematizacion;
    }

    /**
     * @param mixed $fk_id_artista_envio_sistematizacion
     *
     * @return self
     */
    public function setFkIdArtistaEnvioSistematizacion($fk_id_artista_envio_sistematizacion)
    {
        $this->fk_id_artista_envio_sistematizacion = $fk_id_artista_envio_sistematizacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInAprobacionPlaneacion()
    {
        return $this->in_aprobacion_planeacion;
    }

    /**
     * @param mixed $in_aprobacion_planeacion
     *
     * @return self
     */
    public function setInAprobacionPlaneacion($in_aprobacion_planeacion)
    {
        $this->in_aprobacion_planeacion = $in_aprobacion_planeacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInAprobacionSistematizacion()
    {
        return $this->in_aprobacion_sistematizacion;
    }

    /**
     * @param mixed $in_aprobacion_sistematizacion
     *
     * @return self
     */
    public function setInAprobacionSistematizacion($in_aprobacion_sistematizacion)
    {
        $this->in_aprobacion_sistematizacion = $in_aprobacion_sistematizacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdEaatAprobo()
    {
        return $this->fk_id_eaat_aprobo;
    }

    /**
     * @param mixed $fk_id_eaat_aprobo
     *
     * @return self
     */
    public function setFkIdEaatAprobo($fk_id_eaat_aprobo)
    {
        $this->fk_id_eaat_aprobo = $fk_id_eaat_aprobo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaAprobacionPlaneacion()
    {
        return $this->dt_fecha_aprobacion_planeacion;
    }

    /**
     * @param mixed $dt_fecha_aprobacion_planeacion
     *
     * @return self
     */
    public function setDtFechaAprobacionPlaneacion($dt_fecha_aprobacion_planeacion)
    {
        $this->dt_fecha_aprobacion_planeacion = $dt_fecha_aprobacion_planeacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaAprobacionSistematizacion()
    {
        return $this->dt_fecha_aprobacion_sistematizacion;
    }

    /**
     * @param mixed $dt_fecha_aprobacion_sistematizacion
     *
     * @return self
     */
    public function setDtFechaAprobacionSistematizacion($dt_fecha_aprobacion_sistematizacion)
    {
        $this->dt_fecha_aprobacion_sistematizacion = $dt_fecha_aprobacion_sistematizacion;

        return $this;
    }
}