<?php

namespace  General\Persistencia\Entidades;


class TbNidosCategoriaContenido{

    private $pk_id_categoria_contenido;
    private $vc_nombre_categoria_contenido;
    private $in_estado;

    /**
     * @return mixed
     */
    public function getPkIdCategoriaContenido()
    {
        return $this->pk_id_categoria_contenido;
    }

    /**
     * @param mixed $pk_id_categoria_contenido
     *
     * @return self
     */
    public function setPkIdCategoriaContenido($pk_id_categoria_contenido)
    {
        $this->pk_id_categoria_contenido = $pk_id_categoria_contenido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNombreCategoriaContenido()
    {
        return $this->vc_nombre_categoria_contenido;
    }

    /**
     * @param mixed $vc_nombre_categoria_contenido
     *
     * @return self
     */
    public function setVcNombreCategoriaContenido($vc_nombre_categoria_contenido)
    {
        $this->vc_nombre_categoria_contenido = $vc_nombre_categoria_contenido;

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