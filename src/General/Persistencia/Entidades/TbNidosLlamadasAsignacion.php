<?php

namespace  General\Persistencia\Entidades;


class TbNidosLlamadasAsignacion{

	private $fk_atencion_virtual;
	private $fecha_llamada;
	private $quien_llama;
	private $fecha_asignacion;
	private $quien_asigno;

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
    public function getQuienLlama()
    {
        return $this->quien_llama;
    }

    /**
     * @param mixed $quien_llama
     *
     * @return self
     */
    public function setQuienLlama($quien_llama)
    {
        $this->quien_llama = $quien_llama;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFechaAsignacion()
    {
        return $this->fecha_asignacion;
    }

    /**
     * @param mixed $fecha_asignacion
     *
     * @return self
     */
    public function setFechaAsignacion($fecha_asignacion)
    {
        $this->fecha_asignacion = $fecha_asignacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuienAsigno()
    {
        return $this->quien_asigno;
    }

    /**
     * @param mixed $quien_asigno
     *
     * @return self
     */
    public function setQuienAsigno($quien_asigno)
    {
        $this->quien_asigno = $quien_asigno;

        return $this;
    }
}