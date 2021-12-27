<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_afiliacion'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbAfiliacion 
{
	
	private $pk_id_afiliacion;
	private $vc_nom_afiliacion;


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
	 * Obtiene el valor de PK_Id_Afiliacion
	 * @return mixed
	 */
	public function getPkIdAfiliacion()
	{
			return $this->pk_id_afiliacion;
	}

	/**
	 * Asigna el valor para PK_Id_Afiliacion
	 * @param mixed $pk_id_afiliacion 
	 */
	public function setPkIdAfiliacion($pk_id_afiliacion)
	{
			$this->pk_id_afiliacion=$pk_id_afiliacion;
	}

	/**
	 * Obtiene el valor de VC_Nom_Afiliacion
	 * @return mixed
	 */
	public function getVcNomAfiliacion()
	{
			return $this->vc_nom_afiliacion;
	}

	/**
	 * Asigna el valor para VC_Nom_Afiliacion
	 * @param mixed $vc_nom_afiliacion 
	 */
	public function setVcNomAfiliacion($vc_nom_afiliacion)
	{
			$this->vc_nom_afiliacion=$vc_nom_afiliacion;
	}


}
