<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_tipo_persona'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbTipoPersona 
{
	
	private $pk_id_tipo_persona;
	private $vc_nom_tipo;


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

	/**
	 * Obtiene el valor de VC_Nom_Tipo
	 * @return mixed
	 */
	public function getVcNomTipo()
	{
			return $this->vc_nom_tipo;
	}

	/**
	 * Asigna el valor para VC_Nom_Tipo
	 * @param mixed $vc_nom_tipo 
	 */
	public function setVcNomTipo($vc_nom_tipo)
	{
			$this->vc_nom_tipo=$vc_nom_tipo;
	}


}
