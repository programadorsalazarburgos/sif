<?php

namespace  General\Persistencia\Entidades;

class TbNidosSistematizacionArtista{

	private $pk_id_sistematizacion_artista;
	private $fk_id_sistematizacion;
    private $fk_id_artista;   // id artista - entidad
    private $fk_id_artistas; // array de artistas

    /**
     * @return mixed
     */
    public function getPkIdSistematizacionArtista()
    {
        return $this->pk_id_sistematizacion_artista;
    }

    /**
     * @param mixed $pk_id_sistematizacion_artista
     *
     * @return self
     */
    public function setPkIdSistematizacionArtista($pk_id_sistematizacion_artista)
    {
        $this->pk_id_sistematizacion_artista = $pk_id_sistematizacion_artista;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdSistematizacion()
    {
        return $this->fk_id_sistematizacion;
    }

    /**
     * @param mixed $fk_id_sistematizacion
     *
     * @return self
     */
    public function setFkIdSistematizacion($fk_id_sistematizacion)
    {
        $this->fk_id_sistematizacion = $fk_id_sistematizacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdArtista()
    {
        return $this->fk_id_artista;
    }

    /**
     * @param mixed $fk_id_artista
     *
     * @return self
     */
    public function setFkIdArtista($fk_id_artista)
    {
        $this->fk_id_artista = $fk_id_artista;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdArtistas()
    {
        return $this->fk_id_artistas;
    }

    /**
     * @param mixed $fk_id_artistas
     *
     * @return self
     */
    public function setFkIdArtistas($fk_id_artistas)
    {
        $this->fk_id_artistas = $fk_id_artistas;

        return $this;
    }
}