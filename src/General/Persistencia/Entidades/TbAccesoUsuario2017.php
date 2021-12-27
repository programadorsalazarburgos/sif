<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_acceso_usuario_2017'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbAccesoUsuario2017 
{
	
	private $pk_id_acceso;
	private $fk_id_persona;
	private $vc_usuario;
	private $vc_password;
	private $in_estado;
	private $in_acepta_terminos;
	private $dt_acepta_terminos;


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

	/**
	 * Obtiene el valor de IN_Estado
	 * @return mixed
	 */
	public function getInEstado()
	{
			return $this->in_estado;
	}

	/**
	 * Asigna el valor para IN_Estado
	 * @param mixed $in_estado 
	 */
	public function setInEstado($in_estado)
	{
			$this->in_estado=$in_estado;
	}

	/**
	 * Obtiene el valor de IN_Acepta_Terminos
	 * @return mixed
	 */
	public function getInAceptaTerminos()
	{
			return $this->in_acepta_terminos;
	}

	/**
	 * Asigna el valor para IN_Acepta_Terminos
	 * @param mixed $in_acepta_terminos 
	 */
	public function setInAceptaTerminos($in_acepta_terminos)
	{
			$this->in_acepta_terminos=$in_acepta_terminos;
	}

	/**
	 * Obtiene el valor de DT_Acepta_Terminos
	 * @return mixed
	 */
	public function getDtAceptaTerminos()
	{
			return $this->dt_acepta_terminos;
	}

	/**
	 * Asigna el valor para DT_Acepta_Terminos
	 * @param mixed $dt_acepta_terminos 
	 */
	public function setDtAceptaTerminos($dt_acepta_terminos)
	{
			$this->dt_acepta_terminos=$dt_acepta_terminos;
	}


}
