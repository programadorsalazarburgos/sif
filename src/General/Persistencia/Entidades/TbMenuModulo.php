<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_menu_modulo'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbMenuModulo 
{
	
	private $pk_id_modulo;
	private $vc_nom_modulo;
	private $vc_icono;


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
	 * Obtiene el valor de PK_Id_Modulo
	 * @return mixed
	 */
	public function getPkIdModulo()
	{
			return $this->pk_id_modulo;
	}

	/**
	 * Asigna el valor para PK_Id_Modulo
	 * @param mixed $pk_id_modulo 
	 */
	public function setPkIdModulo($pk_id_modulo)
	{
			$this->pk_id_modulo=$pk_id_modulo;
	}

	/**
	 * Obtiene el valor de VC_Nom_Modulo
	 * @return mixed
	 */
	public function getVcNomModulo()
	{
			return $this->vc_nom_modulo;
	}

	/**
	 * Asigna el valor para VC_Nom_Modulo
	 * @param mixed $vc_nom_modulo 
	 */
	public function setVcNomModulo($vc_nom_modulo)
	{
			$this->vc_nom_modulo=$vc_nom_modulo;
	}

	/**
	 * Obtiene el valor de VC_Icono
	 * @return mixed
	 */
	public function getVcIcono()
	{
			return $this->vc_icono;
	}

	/**
	 * Asigna el valor para VC_Icono
	 * @param mixed $vc_icono 
	 */
	public function setVcIcono($vc_icono)
	{
			$this->vc_icono=$vc_icono;
	}


}
