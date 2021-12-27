<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_propuesta_organizacion_precontractual'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPropuestaOrganizacionPrecontractual 
{
	
	private $pk_id_organizacion;
	private $fk_id_usuario;
	private $vc_nombre_entidad;
	private $vc_nit;
	private $vc_direccion;
	private $in_id_localidad;
	private $vc_objeto_social;
	private $vc_telefono;
	private $vc_correo;
	private $in_estrato_sede;
	private $vc_representante_legal;
	private $vc_cedula_rl;
	private $vc_direccion_rl;
	private $vc_telefono_rl;
	private $vc_correo_rl;


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
	 * Obtiene el valor de PK_Id_Organizacion
	 * @return mixed
	 */
	public function getPkIdOrganizacion()
	{
			return $this->pk_id_organizacion;
	}

	/**
	 * Asigna el valor para PK_Id_Organizacion
	 * @param mixed $pk_id_organizacion 
	 */
	public function setPkIdOrganizacion($pk_id_organizacion)
	{
			$this->pk_id_organizacion=$pk_id_organizacion;
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
	 * Obtiene el valor de VC_Nombre_Entidad
	 * @return mixed
	 */
	public function getVcNombreEntidad()
	{
			return $this->vc_nombre_entidad;
	}

	/**
	 * Asigna el valor para VC_Nombre_Entidad
	 * @param mixed $vc_nombre_entidad 
	 */
	public function setVcNombreEntidad($vc_nombre_entidad)
	{
			$this->vc_nombre_entidad=$vc_nombre_entidad;
	}

	/**
	 * Obtiene el valor de VC_Nit
	 * @return mixed
	 */
	public function getVcNit()
	{
			return $this->vc_nit;
	}

	/**
	 * Asigna el valor para VC_Nit
	 * @param mixed $vc_nit 
	 */
	public function setVcNit($vc_nit)
	{
			$this->vc_nit=$vc_nit;
	}

	/**
	 * Obtiene el valor de VC_Direccion
	 * @return mixed
	 */
	public function getVcDireccion()
	{
			return $this->vc_direccion;
	}

	/**
	 * Asigna el valor para VC_Direccion
	 * @param mixed $vc_direccion 
	 */
	public function setVcDireccion($vc_direccion)
	{
			$this->vc_direccion=$vc_direccion;
	}

	/**
	 * Obtiene el valor de IN_Id_Localidad
	 * @return mixed
	 */
	public function getInIdLocalidad()
	{
			return $this->in_id_localidad;
	}

	/**
	 * Asigna el valor para IN_Id_Localidad
	 * @param mixed $in_id_localidad 
	 */
	public function setInIdLocalidad($in_id_localidad)
	{
			$this->in_id_localidad=$in_id_localidad;
	}

	/**
	 * Obtiene el valor de VC_Objeto_Social
	 * @return mixed
	 */
	public function getVcObjetoSocial()
	{
			return $this->vc_objeto_social;
	}

	/**
	 * Asigna el valor para VC_Objeto_Social
	 * @param mixed $vc_objeto_social 
	 */
	public function setVcObjetoSocial($vc_objeto_social)
	{
			$this->vc_objeto_social=$vc_objeto_social;
	}

	/**
	 * Obtiene el valor de VC_Telefono
	 * @return mixed
	 */
	public function getVcTelefono()
	{
			return $this->vc_telefono;
	}

	/**
	 * Asigna el valor para VC_Telefono
	 * @param mixed $vc_telefono 
	 */
	public function setVcTelefono($vc_telefono)
	{
			$this->vc_telefono=$vc_telefono;
	}

	/**
	 * Obtiene el valor de VC_Correo
	 * @return mixed
	 */
	public function getVcCorreo()
	{
			return $this->vc_correo;
	}

	/**
	 * Asigna el valor para VC_Correo
	 * @param mixed $vc_correo 
	 */
	public function setVcCorreo($vc_correo)
	{
			$this->vc_correo=$vc_correo;
	}

	/**
	 * Obtiene el valor de IN_Estrato_Sede
	 * @return mixed
	 */
	public function getInEstratoSede()
	{
			return $this->in_estrato_sede;
	}

	/**
	 * Asigna el valor para IN_Estrato_Sede
	 * @param mixed $in_estrato_sede 
	 */
	public function setInEstratoSede($in_estrato_sede)
	{
			$this->in_estrato_sede=$in_estrato_sede;
	}

	/**
	 * Obtiene el valor de VC_Representante_Legal
	 * @return mixed
	 */
	public function getVcRepresentanteLegal()
	{
			return $this->vc_representante_legal;
	}

	/**
	 * Asigna el valor para VC_Representante_Legal
	 * @param mixed $vc_representante_legal 
	 */
	public function setVcRepresentanteLegal($vc_representante_legal)
	{
			$this->vc_representante_legal=$vc_representante_legal;
	}

	/**
	 * Obtiene el valor de VC_Cedula_RL
	 * @return mixed
	 */
	public function getVcCedulaRl()
	{
			return $this->vc_cedula_rl;
	}

	/**
	 * Asigna el valor para VC_Cedula_RL
	 * @param mixed $vc_cedula_rl 
	 */
	public function setVcCedulaRl($vc_cedula_rl)
	{
			$this->vc_cedula_rl=$vc_cedula_rl;
	}

	/**
	 * Obtiene el valor de VC_Direccion_RL
	 * @return mixed
	 */
	public function getVcDireccionRl()
	{
			return $this->vc_direccion_rl;
	}

	/**
	 * Asigna el valor para VC_Direccion_RL
	 * @param mixed $vc_direccion_rl 
	 */
	public function setVcDireccionRl($vc_direccion_rl)
	{
			$this->vc_direccion_rl=$vc_direccion_rl;
	}

	/**
	 * Obtiene el valor de VC_Telefono_RL
	 * @return mixed
	 */
	public function getVcTelefonoRl()
	{
			return $this->vc_telefono_rl;
	}

	/**
	 * Asigna el valor para VC_Telefono_RL
	 * @param mixed $vc_telefono_rl 
	 */
	public function setVcTelefonoRl($vc_telefono_rl)
	{
			$this->vc_telefono_rl=$vc_telefono_rl;
	}

	/**
	 * Obtiene el valor de VC_Correo_RL
	 * @return mixed
	 */
	public function getVcCorreoRl()
	{
			return $this->vc_correo_rl;
	}

	/**
	 * Asigna el valor para VC_Correo_RL
	 * @param mixed $vc_correo_rl 
	 */
	public function setVcCorreoRl($vc_correo_rl)
	{
			$this->vc_correo_rl=$vc_correo_rl;
	}


}
