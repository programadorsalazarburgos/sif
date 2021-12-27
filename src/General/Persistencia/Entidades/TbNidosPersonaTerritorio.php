<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_nidos_grupos'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05
 */
class TbNidosPersonaTerritorio
{

	private $pk_id_person_territo;
	private $fk_id_persona;
	private $fk_id_territorio;

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


		/* Tabla Persona Territorio*/
	/**
<<<<<<< HEAD
	 * Obtiene el valor de pk_id_person_territo
=======
	 * Obtiene el valor de pk_id_person_territo
	 * @return mixed
	 */
	public function getIdPersonTerrito()
	{
			return $this->pk_id_person_territo;
	}

	/**
	 * Asigna el valor para pk_id_person_territo
	 * @param mixed $pk_id_person_territo
	 */
	public function setIdPersonTerrito($pk_id_person_territo)
	{
			$this->pk_id_person_territo=$pk_id_person_territo;
	}

	/**
	 * Obtiene el valor de fk_id_persona
>>>>>>> desarrollo
	 * @return mixed
	 */
	public function getFkIdPersona()
	{
			return $this->fk_id_persona;
	}

	/**
	 * Asigna el valor para fk_id_persona
	 * @param mixed fk_id_persona
	 */
	public function setFkIdPersona($fk_id_persona)
	{
			$this->fk_id_persona=$fk_id_persona;
	}

	/**
	 * Obtiene el valor de fk_id_territorio
	 * @return mixed
	 */
	public function getFkIdTerritorio()
	{
			return $this->fk_id_territorio;
	}

	/**
	 * Asigna el valor para fk_id_territorio
	 * @param mixed $fk_id_territorio
	 */
	public function setFkIdTerritorio($fk_id_territorio)
	{
			$this->fk_id_territorio=$fk_id_territorio;
	}
}
