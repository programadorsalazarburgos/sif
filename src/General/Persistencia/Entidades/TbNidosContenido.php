<?php

namespace  General\Persistencia\Entidades;


class TbNidosContenido{

	private $pk_id_contenido;
	private $fk_id_categoria_contenido;
	private $vc_nombre_contenido;
	private $in_estado;

    /**
     * @return mixed
     */
    public function getPkIdContenido()
    {
        return $this->pk_id_contenido;
    }

    /**
     * @param mixed $pk_id_contenido
     *
     * @return self
     */
    public function setPkIdContenido($pk_id_contenido)
    {
        $this->pk_id_contenido = $pk_id_contenido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdCategoriaContenido()
    {
        return $this->fk_id_categoria_contenido;
    }

    /**
     * @param mixed $fk_id_categoria_contenido
     *
     * @return self
     */
    public function setFkIdCategoriaContenido($fk_id_categoria_contenido)
    {
        $this->fk_id_categoria_contenido = $fk_id_categoria_contenido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNombreContenido()
    {
        return $this->vc_nombre_contenido;
    }

    /**
     * @param mixed $vc_nombre_contenido
     *
     * @return self
     */
    public function setVcNombreContenido($vc_nombre_contenido)
    {
        $this->vc_nombre_contenido = $vc_nombre_contenido;

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
}