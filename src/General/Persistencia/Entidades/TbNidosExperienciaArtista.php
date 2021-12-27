<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_nidos_experiencia_artista'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05
 */
class TbNidosExperienciaArtista
{

  private $pk_id_experiencia_artista;
  private $fk_id_experiencia;
  private $fk_id_artista;   // id artista - entidad
  private $fk_id_artistas; // array de artistas


	/**
	 * Asigna el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
	public function setVariables($objeto)
	{
		foreach ($objeto as $clave => $valor) {
			if($valor==null)
				$this->{$clave} = NULL;
			else
				$this->{$clave} = $valor;
		}
	}

	/**
	 * Crea la sintaxis de SQL para el WHERE con el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
    public function setWhere($tabla)
    {
    	$where='';
    	foreach($this as $clave=>$valor)
    	{
    		if($valor['valor']!=null && $valor['valor']!='')
    			if($where==='')
    				$where.=$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
    			else
    				$where.=' AND '.$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
    	}
    	return $where;
    }

	/**
	 * Crea la sintaxis de SQL para el UPDATE con el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
    public function setUpdate($tabla)
    {
    	$update='';
    	$where='';
    	foreach($this as $clave=>$valor)
    	{
    		if($valor['valor']!=null && $valor['valor']!='') {
    			if($valor['llave']) {
	    			if($where==='')
	    				$where.=$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
	    			else
	    				$where.=' AND '.$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
    			}
    			else {
	    			if($update==='')
	    				$update.=$tabla.'.'.$clave.'='.$valor['valor'];
	    			else
	    				$update.=','. $tabla.'.'.$clave.'='.$valor['valor'];
    			}

    		}


    	}
    	return $update.' WHERE '.$where;
    }


		/* tabla grupos nidos*/

			/**
			 * Obtiene el valor de pk_id_experiencia_artista
			 * @return mixed
			 */
			public function getPkIdExperienciaArtista()
			{
					return $this->pk_id_experiencia_artista;
			}

			/**
			 * Asigna el valor para pk_id_grupo
			 * @param mixed $pk_id_experiencia_artista
			 */
			public function setPkIdExperienciaArtista($pk_id_experiencia_artista)
			{
					$this->pk_id_experiencia_artista=$pk_id_experiencia_artista;
			}

	/**
	 * Obtiene el valor de fk_id_experiencia
	 * @return mixed
	 */
	public function getFkIdExperiencia()
	{
			return $this->fk_id_experiencia;
	}

	/**
	 * Asigna el valor para $fk_id_experiencia
	 * @param mixed $fk_id_experiencia
	 */
	public function setFkIdExperiencia($fk_id_experiencia)
	{
			$this->fk_id_experiencia=$fk_id_experiencia;
	}

	/**
	 * Obtiene el valor de fk_id_artista
	 * @return mixed
	 */
	public function getFkIdArtista()
	{
			return $this->fk_id_artista;
	}

	/**
	 * Asigna el valor para fk_id_artista
	 * @param mixed fk_id_artista
	 */
	public function setFkIdArtista($fk_id_artista)
	{
			$this->fk_id_artista=$fk_id_artista;
	}

	/**
	 * Obtiene el valor de fk_id_artistas
	 * @return mixed
	 */
	public function getFkIdArtistas()
	{
			return $this->fk_id_artistas;
	}

	/**
	 * Asigna el valor para fk_id_artistas
	 * @param mixed fk_id_artistas
	 */
	public function setFkIdArtistas($fk_id_artistas)
	{
			$this->fk_id_artistas=$fk_id_artistas;
	}

}
