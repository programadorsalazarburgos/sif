<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_formador_organizacion'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbFormadorOrganizacion 
{
	
	private $pk_formador_organizacion;
	private $vc_iden_formador;
	private $fk_id_organizacion;


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
	 * Obtiene el valor de PK_Formador_Organizacion
	 * @return mixed
	 */
	public function getPkFormadorOrganizacion()
	{
			return $this->pk_formador_organizacion;
	}

	/**
	 * Asigna el valor para PK_Formador_Organizacion
	 * @param mixed $pk_formador_organizacion 
	 */
	public function setPkFormadorOrganizacion($pk_formador_organizacion)
	{
			$this->pk_formador_organizacion=$pk_formador_organizacion;
	}

	/**
	 * Obtiene el valor de VC_Iden_Formador
	 * @return mixed
	 */
	public function getVcIdenFormador()
	{
			return $this->vc_iden_formador;
	}

	/**
	 * Asigna el valor para VC_Iden_Formador
	 * @param mixed $vc_iden_formador 
	 */
	public function setVcIdenFormador($vc_iden_formador)
	{
			$this->vc_iden_formador=$vc_iden_formador;
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


}
