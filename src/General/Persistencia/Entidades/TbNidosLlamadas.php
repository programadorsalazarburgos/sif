<?php

namespace  General\Persistencia\Entidades;


class TbNidosLlamadas{

    private $id;
    private $fk_atencion_virtual;
    private $fk_llamada_asignacion;
    private $fecha_llamada;
    private $quien_llamo;
    private $duracion_llamada;
    private $material_narrado;
    private $parecio_lectura;
    private $reaccion;
    private $observaciones;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkAtencionVirtual()
    {
        return $this->fk_atencion_virtual;
    }

    /**
     * @param mixed $fk_atencion_virtual
     *
     * @return self
     */
    public function setFkAtencionVirtual($fk_atencion_virtual)
    {
        $this->fk_atencion_virtual = $fk_atencion_virtual;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkLlamadaAsignacion()
    {
        return $this->fk_llamada_asignacion;
    }

    /**
     * @param mixed $fk_llamada_asignacion
     *
     * @return self
     */
    public function setFkLlamadaAsignacion($fk_llamada_asignacion)
    {
        $this->fk_llamada_asignacion = $fk_llamada_asignacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFechaLlamada()
    {
        return $this->fecha_llamada;
    }

    /**
     * @param mixed $fecha_llamada
     *
     * @return self
     */
    public function setFechaLlamada($fecha_llamada)
    {
        $this->fecha_llamada = $fecha_llamada;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuienLlamo()
    {
        return $this->quien_llamo;
    }

    /**
     * @param mixed $quien_llamo
     *
     * @return self
     */
    public function setQuienLlamo($quien_llamo)
    {
        $this->quien_llamo = $quien_llamo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDuracionLlamada()
    {
        return $this->duracion_llamada;
    }

    /**
     * @param mixed $duracion_llamada
     *
     * @return self
     */
    public function setDuracionLlamada($duracion_llamada)
    {
        $this->duracion_llamada = $duracion_llamada;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaterialNarrado()
    {
        return $this->material_narrado;
    }

    /**
     * @param mixed $material_narrado
     *
     * @return self
     */
    public function setMaterialNarrado($material_narrado)
    {
        $this->material_narrado = $material_narrado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParecioLectura()
    {
        return $this->parecio_lectura;
    }

    /**
     * @param mixed $parecio_lectura
     *
     * @return self
     */
    public function setParecioLectura($parecio_lectura)
    {
        $this->parecio_lectura = $parecio_lectura;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReaccion()
    {
        return $this->reaccion;
    }

    /**
     * @param mixed $reaccion
     *
     * @return self
     */
    public function setReaccion($reaccion)
    {
        $this->reaccion = $reaccion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param mixed $observaciones
     *
     * @return self
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }
}