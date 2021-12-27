<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_persona'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPersona 
{
	
	private $pk_id_persona;
	private $vc_identificacion;
	private $fk_tipo_identificacion;
	private $vc_primer_nombre;
	private $vc_segundo_nombre;
	private $vc_primer_apellido;
	private $vc_segundo_apellido;
	private $dd_f_nacimiento;
	private $fk_id_genero;
	private $vc_grupo_poblacional;
	private $vc_nee;
	private $vc_tipo_afiliacion;
	private $fk_id_eps;
	private $fk_grupo_sanguineo;
	private $vc_enfermedades;
	private $fk_id_localidad;
	private $fk_id_barrio;
	private $vc_direccion;
	private $vc_correo;
	private $vc_telefono;
	private $vc_celular;
	private $fk_tipo_persona;
	private $in_estado;


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
	 * Obtiene el valor de PK_Id_Persona
	 * @return mixed
	 */
	public function getPkIdPersona()
	{
			return $this->pk_id_persona;
	}

	/**
	 * Asigna el valor para PK_Id_Persona
	 * @param mixed $pk_id_persona 
	 */
	public function setPkIdPersona($pk_id_persona)
	{
			$this->pk_id_persona=$pk_id_persona;
	}

	/**
	 * Obtiene el valor de VC_Identificacion
	 * @return mixed
	 */
	public function getVcIdentificacion()
	{
			return $this->vc_identificacion;
	}

	/**
	 * Asigna el valor para VC_Identificacion
	 * @param mixed $vc_identificacion 
	 */
	public function setVcIdentificacion($vc_identificacion)
	{
			$this->vc_identificacion=$vc_identificacion;
	}

	/**
	 * Obtiene el valor de FK_Tipo_Identificacion
	 * @return mixed
	 */
	public function getFkTipoIdentificacion()
	{
			return $this->fk_tipo_identificacion;
	}

	/**
	 * Asigna el valor para FK_Tipo_Identificacion
	 * @param mixed $fk_tipo_identificacion 
	 */
	public function setFkTipoIdentificacion($fk_tipo_identificacion)
	{
			$this->fk_tipo_identificacion=$fk_tipo_identificacion;
	}

	/**
	 * Obtiene el valor de VC_Primer_Nombre
	 * @return mixed
	 */
	public function getVcPrimerNombre()
	{
			return $this->vc_primer_nombre;
	}

	/**
	 * Asigna el valor para VC_Primer_Nombre
	 * @param mixed $vc_primer_nombre 
	 */
	public function setVcPrimerNombre($vc_primer_nombre)
	{
			$this->vc_primer_nombre=$vc_primer_nombre;
	}

	/**
	 * Obtiene el valor de VC_Segundo_Nombre
	 * @return mixed
	 */
	public function getVcSegundoNombre()
	{
			return $this->vc_segundo_nombre;
	}

	/**
	 * Asigna el valor para VC_Segundo_Nombre
	 * @param mixed $vc_segundo_nombre 
	 */
	public function setVcSegundoNombre($vc_segundo_nombre)
	{
			$this->vc_segundo_nombre=$vc_segundo_nombre;
	}

	/**
	 * Obtiene el valor de VC_Primer_Apellido
	 * @return mixed
	 */
	public function getVcPrimerApellido()
	{
			return $this->vc_primer_apellido;
	}

	/**
	 * Asigna el valor para VC_Primer_Apellido
	 * @param mixed $vc_primer_apellido 
	 */
	public function setVcPrimerApellido($vc_primer_apellido)
	{
			$this->vc_primer_apellido=$vc_primer_apellido;
	}

	/**
	 * Obtiene el valor de VC_Segundo_Apellido
	 * @return mixed
	 */
	public function getVcSegundoApellido()
	{
			return $this->vc_segundo_apellido;
	}

	/**
	 * Asigna el valor para VC_Segundo_Apellido
	 * @param mixed $vc_segundo_apellido 
	 */
	public function setVcSegundoApellido($vc_segundo_apellido)
	{
			$this->vc_segundo_apellido=$vc_segundo_apellido;
	}

	/**
	 * Obtiene el valor de DD_F_Nacimiento
	 * @return mixed
	 */
	public function getDdFNacimiento()
	{
			return $this->dd_f_nacimiento;
	}

	/**
	 * Asigna el valor para DD_F_Nacimiento
	 * @param mixed $dd_f_nacimiento 
	 */
	public function setDdFNacimiento($dd_f_nacimiento)
	{
			$this->dd_f_nacimiento=$dd_f_nacimiento;
	}

	/**
	 * Obtiene el valor de FK_Id_Genero
	 * @return mixed
	 */
	public function getFkIdGenero()
	{
			return $this->fk_id_genero;
	}

	/**
	 * Asigna el valor para FK_Id_Genero
	 * @param mixed $fk_id_genero 
	 */
	public function setFkIdGenero($fk_id_genero)
	{
			$this->fk_id_genero=$fk_id_genero;
	}

	/**
	 * Obtiene el valor de VC_Grupo_Poblacional
	 * @return mixed
	 */
	public function getVcGrupoPoblacional()
	{
			return $this->vc_grupo_poblacional;
	}

	/**
	 * Asigna el valor para VC_Grupo_Poblacional
	 * @param mixed $vc_grupo_poblacional 
	 */
	public function setVcGrupoPoblacional($vc_grupo_poblacional)
	{
			$this->vc_grupo_poblacional=$vc_grupo_poblacional;
	}

	/**
	 * Obtiene el valor de VC_NEE
	 * @return mixed
	 */
	public function getVcNee()
	{
			return $this->vc_nee;
	}

	/**
	 * Asigna el valor para VC_NEE
	 * @param mixed $vc_nee 
	 */
	public function setVcNee($vc_nee)
	{
			$this->vc_nee=$vc_nee;
	}

	/**
	 * Obtiene el valor de VC_Tipo_Afiliacion
	 * @return mixed
	 */
	public function getVcTipoAfiliacion()
	{
			return $this->vc_tipo_afiliacion;
	}

	/**
	 * Asigna el valor para VC_Tipo_Afiliacion
	 * @param mixed $vc_tipo_afiliacion 
	 */
	public function setVcTipoAfiliacion($vc_tipo_afiliacion)
	{
			$this->vc_tipo_afiliacion=$vc_tipo_afiliacion;
	}

	/**
	 * Obtiene el valor de FK_Id_Eps
	 * @return mixed
	 */
	public function getFkIdEps()
	{
			return $this->fk_id_eps;
	}

	/**
	 * Asigna el valor para FK_Id_Eps
	 * @param mixed $fk_id_eps 
	 */
	public function setFkIdEps($fk_id_eps)
	{
			$this->fk_id_eps=$fk_id_eps;
	}

	/**
	 * Obtiene el valor de FK_Grupo_Sanguineo
	 * @return mixed
	 */
	public function getFkGrupoSanguineo()
	{
			return $this->fk_grupo_sanguineo;
	}

	/**
	 * Asigna el valor para FK_Grupo_Sanguineo
	 * @param mixed $fk_grupo_sanguineo 
	 */
	public function setFkGrupoSanguineo($fk_grupo_sanguineo)
	{
			$this->fk_grupo_sanguineo=$fk_grupo_sanguineo;
	}

	/**
	 * Obtiene el valor de VC_Enfermedades
	 * @return mixed
	 */
	public function getVcEnfermedades()
	{
			return $this->vc_enfermedades;
	}

	/**
	 * Asigna el valor para VC_Enfermedades
	 * @param mixed $vc_enfermedades 
	 */
	public function setVcEnfermedades($vc_enfermedades)
	{
			$this->vc_enfermedades=$vc_enfermedades;
	}

	/**
	 * Obtiene el valor de FK_Id_Localidad
	 * @return mixed
	 */
	public function getFkIdLocalidad()
	{
			return $this->fk_id_localidad;
	}

	/**
	 * Asigna el valor para FK_Id_Localidad
	 * @param mixed $fk_id_localidad 
	 */
	public function setFkIdLocalidad($fk_id_localidad)
	{
			$this->fk_id_localidad=$fk_id_localidad;
	}

	/**
	 * Obtiene el valor de FK_Id_Barrio
	 * @return mixed
	 */
	public function getFkIdBarrio()
	{
			return $this->fk_id_barrio;
	}

	/**
	 * Asigna el valor para FK_Id_Barrio
	 * @param mixed $fk_id_barrio 
	 */
	public function setFkIdBarrio($fk_id_barrio)
	{
			$this->fk_id_barrio=$fk_id_barrio;
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
	 * Obtiene el valor de VC_Celular
	 * @return mixed
	 */
	public function getVcCelular()
	{
			return $this->vc_celular;
	}

	/**
	 * Asigna el valor para VC_Celular
	 * @param mixed $vc_celular 
	 */
	public function setVcCelular($vc_celular)
	{
			$this->vc_celular=$vc_celular;
	}

	/**
	 * Obtiene el valor de FK_Tipo_Persona
	 * @return mixed
	 */
	public function getFkTipoPersona()
	{
			return $this->fk_tipo_persona;
	}

	/**
	 * Asigna el valor para FK_Tipo_Persona
	 * @param mixed $fk_tipo_persona 
	 */
	public function setFkTipoPersona($fk_tipo_persona)
	{
			$this->fk_tipo_persona=$fk_tipo_persona;
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


}
