<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_formador_zona'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbFormadorZona 
{
	
	private $pk_id_formador_zona;
	private $fk_id_persona;
	private $fk_id_zona;


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
	 * Obtiene el valor de PK_Id_Formador_Zona
	 * @return mixed
	 */
	public function getPkIdFormadorZona()
	{
			return $this->pk_id_formador_zona;
	}

	/**
	 * Asigna el valor para PK_Id_Formador_Zona
	 * @param mixed $pk_id_formador_zona 
	 */
	public function setPkIdFormadorZona($pk_id_formador_zona)
	{
			$this->pk_id_formador_zona=$pk_id_formador_zona;
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
	 * Obtiene el valor de FK_Id_Zona
	 * @return mixed
	 */
	public function getFkIdZona()
	{
			return $this->fk_id_zona;
	}

	/**
	 * Asigna el valor para FK_Id_Zona
	 * @param mixed $fk_id_zona 
	 */
	public function setFkIdZona($fk_id_zona)
	{
			$this->fk_id_zona=$fk_id_zona;
	}


}
