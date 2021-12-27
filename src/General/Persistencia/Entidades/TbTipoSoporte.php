<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_tipo_soporte'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbTipoSoporte 
{
	
	private $fk_id_soporte;
	private $vc_nom_soporte;


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
	 * Obtiene el valor de Fk_Id_Soporte
	 * @return mixed
	 */
	public function getFkIdSoporte()
	{
			return $this->fk_id_soporte;
	}

	/**
	 * Asigna el valor para Fk_Id_Soporte
	 * @param mixed $fk_id_soporte 
	 */
	public function setFkIdSoporte($fk_id_soporte)
	{
			$this->fk_id_soporte=$fk_id_soporte;
	}

	/**
	 * Obtiene el valor de VC_Nom_Soporte
	 * @return mixed
	 */
	public function getVcNomSoporte()
	{
			return $this->vc_nom_soporte;
	}

	/**
	 * Asigna el valor para VC_Nom_Soporte
	 * @param mixed $vc_nom_soporte 
	 */
	public function setVcNomSoporte($vc_nom_soporte)
	{
			$this->vc_nom_soporte=$vc_nom_soporte;
	}


}
