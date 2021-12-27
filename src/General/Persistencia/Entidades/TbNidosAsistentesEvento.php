<?php

namespace  General\Persistencia\Entidades;


class TbNidosAsistentesEvento {
	private $pk_id_asistentes_evento;
	private $fk_id_evento;
    private $fk_id_lugar_atencion;
	private $vc_ninos_0_3;
	private $vc_ninos_4_6;
	private $vc_ninos_6_10;
	private $vc_ninas_0_3;
	private $vc_ninas_4_6;
	private $vc_ninas_6_10;
	private $vc_madres;
	private $vc_cuidadores;
	private $vc_afrodecendientes;
	private $vc_campesinos;
	private $vc_discapacitados;
	private $vc_armados;
	private $vc_indigenas;
	private $vc_menores;
	private $vc_mujeres;
	private $vc_raizales;
	private $vc_roms;
    private $tx_observacion;
    private $dt_fecha_registro;
    private $fk_id_artista_registro;
    

    /**
     * @return mixed
     */
    public function getPkIdAsistentesEvento()
    {
        return $this->pk_id_asistentes_evento;
    }

    /**
     * @param mixed $pk_id_asistentes_evento
     *
     * @return self
     */
    public function setPkIdAsistentesEvento($pk_id_asistentes_evento)
    {
        $this->pk_id_asistentes_evento = $pk_id_asistentes_evento;

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
    public function getFkIdLugarAtencion()
    {
        return $this->fk_id_lugar_atencion;
    }

    /**
     * @param mixed $fk_id_lugar_atencion
     *
     * @return self
     */
    public function setFkIdLugarAtencion($fk_id_lugar_atencion)
    {
        $this->fk_id_lugar_atencion = $fk_id_lugar_atencion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNinos03()
    {
        return $this->vc_ninos_0_3;
    }

    /**
     * @param mixed $vc_ninos_0_3
     *
     * @return self
     */
    public function setVcNinos03($vc_ninos_0_3)
    {
        $this->vc_ninos_0_3 = $vc_ninos_0_3;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNinos46()
    {
        return $this->vc_ninos_4_6;
    }

    /**
     * @param mixed $vc_ninos_4_6
     *
     * @return self
     */
    public function setVcNinos46($vc_ninos_4_6)
    {
        $this->vc_ninos_4_6 = $vc_ninos_4_6;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNinos610()
    {
        return $this->vc_ninos_6_10;
    }

    /**
     * @param mixed $vc_ninos_6_10
     *
     * @return self
     */
    public function setVcNinos610($vc_ninos_6_10)
    {
        $this->vc_ninos_6_10 = $vc_ninos_6_10;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNinas03()
    {
        return $this->vc_ninas_0_3;
    }

    /**
     * @param mixed $vc_ninas_0_3
     *
     * @return self
     */
    public function setVcNinas03($vc_ninas_0_3)
    {
        $this->vc_ninas_0_3 = $vc_ninas_0_3;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNinas46()
    {
        return $this->vc_ninas_4_6;
    }

    /**
     * @param mixed $vc_ninas_4_6
     *
     * @return self
     */
    public function setVcNinas46($vc_ninas_4_6)
    {
        $this->vc_ninas_4_6 = $vc_ninas_4_6;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNinas610()
    {
        return $this->vc_ninas_6_10;
    }

    /**
     * @param mixed $vc_ninas_6_10
     *
     * @return self
     */
    public function setVcNinas610($vc_ninas_6_10)
    {
        $this->vc_ninas_6_10 = $vc_ninas_6_10;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcMadres()
    {
        return $this->vc_madres;
    }

    /**
     * @param mixed $vc_madres
     *
     * @return self
     */
    public function setVcMadres($vc_madres)
    {
        $this->vc_madres = $vc_madres;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcCuidadores()
    {
        return $this->vc_cuidadores;
    }

    /**
     * @param mixed $vc_cuidadores
     *
     * @return self
     */
    public function setVcCuidadores($vc_cuidadores)
    {
        $this->vc_cuidadores = $vc_cuidadores;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcAfrodecendientes()
    {
        return $this->vc_afrodecendientes;
    }

    /**
     * @param mixed $vc_afrodecendientes
     *
     * @return self
     */
    public function setVcAfrodecendientes($vc_afrodecendientes)
    {
        $this->vc_afrodecendientes = $vc_afrodecendientes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcCampesinos()
    {
        return $this->vc_campesinos;
    }

    /**
     * @param mixed $vc_campesinos
     *
     * @return self
     */
    public function setVcCampesinos($vc_campesinos)
    {
        $this->vc_campesinos = $vc_campesinos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcDiscapacitados()
    {
        return $this->vc_discapacitados;
    }

    /**
     * @param mixed $vc_discapacitados
     *
     * @return self
     */
    public function setVcDiscapacitados($vc_discapacitados)
    {
        $this->vc_discapacitados = $vc_discapacitados;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcArmados()
    {
        return $this->vc_armados;
    }

    /**
     * @param mixed $vc_armados
     *
     * @return self
     */
    public function setVcArmados($vc_armados)
    {
        $this->vc_armados = $vc_armados;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcIndigenas()
    {
        return $this->vc_indigenas;
    }

    /**
     * @param mixed $vc_indigenas
     *
     * @return self
     */
    public function setVcIndigenas($vc_indigenas)
    {
        $this->vc_indigenas = $vc_indigenas;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcMenores()
    {
        return $this->vc_menores;
    }

    /**
     * @param mixed $vc_menores
     *
     * @return self
     */
    public function setVcMenores($vc_menores)
    {
        $this->vc_menores = $vc_menores;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcMujeres()
    {
        return $this->vc_mujeres;
    }

    /**
     * @param mixed $vc_mujeres
     *
     * @return self
     */
    public function setVcMujeres($vc_mujeres)
    {
        $this->vc_mujeres = $vc_mujeres;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcRaizales()
    {
        return $this->vc_raizales;
    }

    /**
     * @param mixed $vc_raizales
     *
     * @return self
     */
    public function setVcRaizales($vc_raizales)
    {
        $this->vc_raizales = $vc_raizales;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcRoms()
    {
        return $this->vc_roms;
    }

    /**
     * @param mixed $vc_roms
     *
     * @return self
     */
    public function setVcRoms($vc_roms)
    {
        $this->vc_roms = $vc_roms;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTxObservacion()
    {
        return $this->tx_observacion;
    }

    /**
     * @param mixed $tx_observacion
     *
     * @return self
     */
    public function setTxObservacion($tx_observacion)
    {
        $this->tx_observacion = $tx_observacion;

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
    public function getFkIdArtistaRegistro()
    {
        return $this->fk_id_artista_registro;
    }

    /**
     * @param mixed $fk_id_artista_registro
     *
     * @return self
     */
    public function setFkIdArtistaRegistro($fk_id_artista_registro)
    {
        $this->fk_id_artista_registro = $fk_id_artista_registro;

        return $this;
    }
}