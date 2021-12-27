<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_propuesta_usuarios'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPropuestaUsuario 
{
	
	private $pk_id_usuario;
	private $vc_nombre_usuario;
	private $vc_organizacion;
	private $vc_nit;
	private $vc_password;
	private $vc_convocatoria;
	private $in_bandera_pass;
	private $in_bandera_habilitantes;
	private $in_bandera_propuesta;
	private $in_estado;
	private $in_tipo;


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
	 * Obtiene el valor de PK_Id_Usuario
	 * @return mixed
	 */
	public function getPkIdUsuario()
	{
			return $this->pk_id_usuario;
	}

	/**
	 * Asigna el valor para PK_Id_Usuario
	 * @param mixed $pk_id_usuario 
	 */
	public function setPkIdUsuario($pk_id_usuario)
	{
			$this->pk_id_usuario=$pk_id_usuario;
	}

	/**
	 * Obtiene el valor de VC_Nombre_Usuario
	 * @return mixed
	 */
	public function getVcNombreUsuario()
	{
			return $this->vc_nombre_usuario;
	}

	/**
	 * Asigna el valor para VC_Nombre_Usuario
	 * @param mixed $vc_nombre_usuario 
	 */
	public function setVcNombreUsuario($vc_nombre_usuario)
	{
			$this->vc_nombre_usuario=$vc_nombre_usuario;
	}

	/**
	 * Obtiene el valor de VC_Organizacion
	 * @return mixed
	 */
	public function getVcOrganizacion()
	{
			return $this->vc_organizacion;
	}

	/**
	 * Asigna el valor para VC_Organizacion
	 * @param mixed $vc_organizacion 
	 */
	public function setVcOrganizacion($vc_organizacion)
	{
			$this->vc_organizacion=$vc_organizacion;
	}

	/**
	 * Obtiene el valor de VC_NIT
	 * @return mixed
	 */
	public function getVcNit()
	{
			return $this->vc_nit;
	}

	/**
	 * Asigna el valor para VC_NIT
	 * @param mixed $vc_nit 
	 */
	public function setVcNit($vc_nit)
	{
			$this->vc_nit=$vc_nit;
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
	 * Obtiene el valor de VC_Convocatoria
	 * @return mixed
	 */
	public function getVcConvocatoria()
	{
			return $this->vc_convocatoria;
	}

	/**
	 * Asigna el valor para VC_Convocatoria
	 * @param mixed $vc_convocatoria 
	 */
	public function setVcConvocatoria($vc_convocatoria)
	{
			$this->vc_convocatoria=$vc_convocatoria;
	}

	/**
	 * Obtiene el valor de IN_Bandera_Pass
	 * @return mixed
	 */
	public function getInBanderaPass()
	{
			return $this->in_bandera_pass;
	}

	/**
	 * Asigna el valor para IN_Bandera_Pass
	 * @param mixed $in_bandera_pass 
	 */
	public function setInBanderaPass($in_bandera_pass)
	{
			$this->in_bandera_pass=$in_bandera_pass;
	}

	/**
	 * Obtiene el valor de IN_Bandera_Habilitantes
	 * @return mixed
	 */
	public function getInBanderaHabilitantes()
	{
			return $this->in_bandera_habilitantes;
	}

	/**
	 * Asigna el valor para IN_Bandera_Habilitantes
	 * @param mixed $in_bandera_habilitantes 
	 */
	public function setInBanderaHabilitantes($in_bandera_habilitantes)
	{
			$this->in_bandera_habilitantes=$in_bandera_habilitantes;
	}

	/**
	 * Obtiene el valor de IN_Bandera_Propuesta
	 * @return mixed
	 */
	public function getInBanderaPropuesta()
	{
			return $this->in_bandera_propuesta;
	}

	/**
	 * Asigna el valor para IN_Bandera_Propuesta
	 * @param mixed $in_bandera_propuesta 
	 */
	public function setInBanderaPropuesta($in_bandera_propuesta)
	{
			$this->in_bandera_propuesta=$in_bandera_propuesta;
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
	 * Obtiene el valor de IN_Tipo
	 * @return mixed
	 */
	public function getInTipo()
	{
			return $this->in_tipo;
	}

	/**
	 * Asigna el valor para IN_Tipo
	 * @param mixed $in_tipo 
	 */
	public function setInTipo($in_tipo)
	{
			$this->in_tipo=$in_tipo;
	}


}
