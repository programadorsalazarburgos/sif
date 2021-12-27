<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_clan_colegio'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbClanColegio 
{
	
	private $pk_id_clan_colegio;
	private $fk_id_colegio;
	private $fk_id_clan;


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
	 * Obtiene el valor de PK_Id_Clan_Colegio
	 * @return mixed
	 */
	public function getPkIdClanColegio()
	{
			return $this->pk_id_clan_colegio;
	}

	/**
	 * Asigna el valor para PK_Id_Clan_Colegio
	 * @param mixed $pk_id_clan_colegio 
	 */
	public function setPkIdClanColegio($pk_id_clan_colegio)
	{
			$this->pk_id_clan_colegio=$pk_id_clan_colegio;
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


}
