<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_entidad_persona'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbEntidadPersona 
{
	
	private $pk_id_relacion;
	private $fk_id_colegio;
	private $fk_id_clan;
	private $fk_id_organizacion;
	private $fk_id_persona;
	private $pk_id_tipo_persona;


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

	

	/**
	 * Obtiene el valor de PK_Id_Relacion
	 * @return mixed
	 */
	public function getPkIdRelacion()
	{
			return $this->pk_id_relacion;
	}

	/**
	 * Asigna el valor para PK_Id_Relacion
	 * @param mixed $pk_id_relacion 
	 */
	public function setPkIdRelacion($pk_id_relacion)
	{
			$this->pk_id_relacion=$pk_id_relacion;
	}

	/**
	 * Obtiene el valor de FK_Id_Colegio
	 * @return mixed
	 */
	public function getFkIdColegio()
	{
			return $this->fk_id_colegio;
	}

	/**
	 * Asigna el valor para FK_Id_Colegio
	 * @param mixed $fk_id_colegio 
	 */
	public function setFkIdColegio($fk_id_colegio)
	{
			$this->fk_id_colegio=$fk_id_colegio;
	}

	/**
	 * Obtiene el valor de FK_Id_Clan
	 * @return mixed
	 */
	public function getFkIdClan()
	{
			return $this->fk_id_clan;
	}

	/**
	 * Asigna el valor para FK_Id_Clan
	 * @param mixed $fk_id_clan 
	 */
	public function setFkIdClan($fk_id_clan)
	{
			$this->fk_id_clan=$fk_id_clan;
	}

	/**
	 * Obtiene el valor de FK_Id_Organizacion
	 * @return mixed
	 */
	public function getFkIdOrganizacion()
	{
			return $this->fk_id_organizacion;
	}

	/**
	 * Asigna el valor para FK_Id_Organizacion
	 * @param mixed $fk_id_organizacion 
	 */
	public function setFkIdOrganizacion($fk_id_organizacion)
	{
			$this->fk_id_organizacion=$fk_id_organizacion;
	}

	/**
	 * Obtiene el valor de FK_Id_Persona
	 * @return mixed
	 */
	public function getFkIdPersona()
	{
			return $this->fk_id_persona;
	}

	/**
	 * Asigna el valor para FK_Id_Persona
	 * @param mixed $fk_id_persona 
	 */
	public function setFkIdPersona($fk_id_persona)
	{
			$this->fk_id_persona=$fk_id_persona;
	}

	/**
	 * Obtiene el valor de PK_Id_Tipo_Persona
	 * @return mixed
	 */
	public function getPkIdTipoPersona()
	{
			return $this->pk_id_tipo_persona;
	}

	/**
	 * Asigna el valor para PK_Id_Tipo_Persona
	 * @param mixed $pk_id_tipo_persona 
	 */
	public function setPkIdTipoPersona($pk_id_tipo_persona)
	{
			$this->pk_id_tipo_persona=$pk_id_tipo_persona;
	}


}
