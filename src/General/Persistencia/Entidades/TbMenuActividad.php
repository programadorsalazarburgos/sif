<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_menu_actividad'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbMenuActividad 
{
	
	private $pk_id_actividad;
	private $vc_nom_actividad;
	private $vc_page;
	private $fk_modulo;


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
	 * Obtiene el valor de PK_Id_Actividad
	 * @return mixed
	 */
	public function getPkIdActividad()
	{
			return $this->pk_id_actividad;
	}

	/**
	 * Asigna el valor para PK_Id_Actividad
	 * @param mixed $pk_id_actividad 
	 */
	public function setPkIdActividad($pk_id_actividad)
	{
			$this->pk_id_actividad=$pk_id_actividad;
	}

	/**
	 * Obtiene el valor de VC_Nom_Actividad
	 * @return mixed
	 */
	public function getVcNomActividad()
	{
			return $this->vc_nom_actividad;
	}

	/**
	 * Asigna el valor para VC_Nom_Actividad
	 * @param mixed $vc_nom_actividad 
	 */
	public function setVcNomActividad($vc_nom_actividad)
	{
			$this->vc_nom_actividad=$vc_nom_actividad;
	}

	/**
	 * Obtiene el valor de VC_Page
	 * @return mixed
	 */
	public function getVcPage()
	{
			return $this->vc_page;
	}

	/**
	 * Asigna el valor para VC_Page
	 * @param mixed $vc_page 
	 */
	public function setVcPage($vc_page)
	{
			$this->vc_page=$vc_page;
	}

	/**
	 * Obtiene el valor de FK_Modulo
	 * @return mixed
	 */
	public function getFkModulo()
	{
			return $this->fk_modulo;
	}

	/**
	 * Asigna el valor para FK_Modulo
	 * @param mixed $fk_modulo 
	 */
	public function setFkModulo($fk_modulo)
	{
			$this->fk_modulo=$fk_modulo;
	}


}
