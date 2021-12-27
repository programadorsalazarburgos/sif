<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_genero'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbGenero 
{
	
	private $fk_id_genero;
	private $vc_nom_genero;


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
	 * Obtiene el valor de FK_Id_Genero
	 * @return mixed
	 */
	public function getFkIdGenero()
	{
			return $this->fk_id_genero;
	}

	/**
	 * Asigna el valor para FK_Id_Genero
	 * @param mixed $fk_id_genero 
	 */
	public function setFkIdGenero($fk_id_genero)
	{
			$this->fk_id_genero=$fk_id_genero;
	}

	/**
	 * Obtiene el valor de VC_Nom_Genero
	 * @return mixed
	 */
	public function getVcNomGenero()
	{
			return $this->vc_nom_genero;
	}

	/**
	 * Asigna el valor para VC_Nom_Genero
	 * @param mixed $vc_nom_genero 
	 */
	public function setVcNomGenero($vc_nom_genero)
	{
			$this->vc_nom_genero=$vc_nom_genero;
	}


}
