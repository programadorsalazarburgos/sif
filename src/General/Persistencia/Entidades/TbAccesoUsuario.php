<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_acceso_usuario'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbAccesoUsuario 
{
	
	private $pk_id_acceso;
	private $fk_id_persona;
	private $vc_usuario;
	private $vc_password;


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
	 * Obtiene el valor de PK_Id_Acceso
	 * @return mixed
	 */
	public function getPkIdAcceso()
	{
			return $this->pk_id_acceso;
	}

	/**
	 * Asigna el valor para PK_Id_Acceso
	 * @param mixed $pk_id_acceso 
	 */
	public function setPkIdAcceso($pk_id_acceso)
	{
			$this->pk_id_acceso=$pk_id_acceso;
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
	 * Obtiene el valor de VC_Usuario
	 * @return mixed
	 */
	public function getVcUsuario()
	{
			return $this->vc_usuario;
	}

	/**
	 * Asigna el valor para VC_Usuario
	 * @param mixed $vc_usuario 
	 */
	public function setVcUsuario($vc_usuario)
	{
			$this->vc_usuario=$vc_usuario;
	}

	/**
	 * Obtiene el valor de VC_Password
	 * @return mixed
	 */
	public function getVcPassword()
	{
			return $this->vc_password;
	}

	/**
	 * Asigna el valor para VC_Password
	 * @param mixed $vc_password 
	 */
	public function setVcPassword($vc_password)
	{
			$this->vc_password=$vc_password;
	}


}
