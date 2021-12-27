<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_propuesta_proyecto_equipo'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPropuestaProyectoEquipo 
{
	
	private $pk_id;
	private $fk_id_usuario;
	private $vc_nombre_persona;
	private $vc_perfil;
	private $vc_rol;
	private $vc_actividades;


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
	 * Obtiene el valor de PK_Id
	 * @return mixed
	 */
	public function getPkId()
	{
			return $this->pk_id;
	}

	/**
	 * Asigna el valor para PK_Id
	 * @param mixed $pk_id 
	 */
	public function setPkId($pk_id)
	{
			$this->pk_id=$pk_id;
	}

	/**
	 * Obtiene el valor de FK_Id_Usuario
	 * @return mixed
	 */
	public function getFkIdUsuario()
	{
			return $this->fk_id_usuario;
	}

	/**
	 * Asigna el valor para FK_Id_Usuario
	 * @param mixed $fk_id_usuario 
	 */
	public function setFkIdUsuario($fk_id_usuario)
	{
			$this->fk_id_usuario=$fk_id_usuario;
	}

	/**
	 * Obtiene el valor de VC_Nombre_Persona
	 * @return mixed
	 */
	public function getVcNombrePersona()
	{
			return $this->vc_nombre_persona;
	}

	/**
	 * Asigna el valor para VC_Nombre_Persona
	 * @param mixed $vc_nombre_persona 
	 */
	public function setVcNombrePersona($vc_nombre_persona)
	{
			$this->vc_nombre_persona=$vc_nombre_persona;
	}

	/**
	 * Obtiene el valor de VC_Perfil
	 * @return mixed
	 */
	public function getVcPerfil()
	{
			return $this->vc_perfil;
	}

	/**
	 * Asigna el valor para VC_Perfil
	 * @param mixed $vc_perfil 
	 */
	public function setVcPerfil($vc_perfil)
	{
			$this->vc_perfil=$vc_perfil;
	}

	/**
	 * Obtiene el valor de VC_Rol
	 * @return mixed
	 */
	public function getVcRol()
	{
			return $this->vc_rol;
	}

	/**
	 * Asigna el valor para VC_Rol
	 * @param mixed $vc_rol 
	 */
	public function setVcRol($vc_rol)
	{
			$this->vc_rol=$vc_rol;
	}

	/**
	 * Obtiene el valor de VC_Actividades
	 * @return mixed
	 */
	public function getVcActividades()
	{
			return $this->vc_actividades;
	}

	/**
	 * Asigna el valor para VC_Actividades
	 * @param mixed $vc_actividades 
	 */
	public function setVcActividades($vc_actividades)
	{
			$this->vc_actividades=$vc_actividades;
	}


}
