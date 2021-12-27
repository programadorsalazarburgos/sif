<?php

namespace  General\Persistencia\Entidades;


class TbNidosFormulariosAtencionesVirtuales{

	private $pk_id_formulario;
	private $vc_nombre_formulario;
	private $in_estado;
	private $vc_contenido_cerrado;
	private $dt_fecha_modificacion;

    /**
     * @return mixed
     */
    public function getPkIdFormulario()
    {
        return $this->pk_id_formulario;
    }

    /**
     * @param mixed $pk_id_formulario
     *
     * @return self
     */
    public function setPkIdFormulario($pk_id_formulario)
    {
        $this->pk_id_formulario = $pk_id_formulario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNombreFormulario()
    {
        return $this->vc_nombre_formulario;
    }

    /**
     * @param mixed $vc_nombre_formulario
     *
     * @return self
     */
    public function setVcNombreFormulario($vc_nombre_formulario)
    {
        $this->vc_nombre_formulario = $vc_nombre_formulario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInEstado()
    {
        return $this->in_estado;
    }

    /**
     * @param mixed $in_estado
     *
     * @return self
     */
    public function setInEstado($in_estado)
    {
        $this->in_estado = $in_estado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcContenidoCerrado()
    {
        return $this->vc_contenido_cerrado;
    }

    /**
     * @param mixed $vc_contenido_cerrado
     *
     * @return self
     */
    public function setVcContenidoCerrado($vc_contenido_cerrado)
    {
        $this->vc_contenido_cerrado = $vc_contenido_cerrado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaModificacion()
    {
        return $this->dt_fecha_modificacion;
    }

    /**
     * @param mixed $dt_fecha_modificacion
     *
     * @return self
     */
    public function setDtFechaModificacion($dt_fecha_modificacion)
    {
        $this->dt_fecha_modificacion = $dt_fecha_modificacion;

        return $this;
    }
}