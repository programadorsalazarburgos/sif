<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_propuesta_proyecto'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPropuestaProyecto 
{
	
	private $pk_id_proyecto;
	private $fk_id_usuario;
	private $da_fecha_radicacion;
	private $vc_nombre_proyecto;
	private $vc_tipo_proyecto;
	private $vc_nombre_director;
	private $vc_cedula_director;
	private $vc_direccion_director;
	private $vc_telefono_director;
	private $vc_correo_director;
	private $vc_dimension;
	private $vc_antecedentes;
	private $vc_objetivo_general;
	private $vc_descripcion_problema;
	private $vc_descripcion_proyecto;
	private $fl_cantidad_beneficiados;
	private $vc_beneficiarios;


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
	 * Obtiene el valor de PK_Id_Proyecto
	 * @return mixed
	 */
	public function getPkIdProyecto()
	{
			return $this->pk_id_proyecto;
	}

	/**
	 * Asigna el valor para PK_Id_Proyecto
	 * @param mixed $pk_id_proyecto 
	 */
	public function setPkIdProyecto($pk_id_proyecto)
	{
			$this->pk_id_proyecto=$pk_id_proyecto;
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
	 * Obtiene el valor de DA_Fecha_Radicacion
	 * @return mixed
	 */
	public function getDaFechaRadicacion()
	{
			return $this->da_fecha_radicacion;
	}

	/**
	 * Asigna el valor para DA_Fecha_Radicacion
	 * @param mixed $da_fecha_radicacion 
	 */
	public function setDaFechaRadicacion($da_fecha_radicacion)
	{
			$this->da_fecha_radicacion=$da_fecha_radicacion;
	}

	/**
	 * Obtiene el valor de VC_Nombre_Proyecto
	 * @return mixed
	 */
	public function getVcNombreProyecto()
	{
			return $this->vc_nombre_proyecto;
	}

	/**
	 * Asigna el valor para VC_Nombre_Proyecto
	 * @param mixed $vc_nombre_proyecto 
	 */
	public function setVcNombreProyecto($vc_nombre_proyecto)
	{
			$this->vc_nombre_proyecto=$vc_nombre_proyecto;
	}

	/**
	 * Obtiene el valor de VC_Tipo_Proyecto
	 * @return mixed
	 */
	public function getVcTipoProyecto()
	{
			return $this->vc_tipo_proyecto;
	}

	/**
	 * Asigna el valor para VC_Tipo_Proyecto
	 * @param mixed $vc_tipo_proyecto 
	 */
	public function setVcTipoProyecto($vc_tipo_proyecto)
	{
			$this->vc_tipo_proyecto=$vc_tipo_proyecto;
	}

	/**
	 * Obtiene el valor de VC_Nombre_Director
	 * @return mixed
	 */
	public function getVcNombreDirector()
	{
			return $this->vc_nombre_director;
	}

	/**
	 * Asigna el valor para VC_Nombre_Director
	 * @param mixed $vc_nombre_director 
	 */
	public function setVcNombreDirector($vc_nombre_director)
	{
			$this->vc_nombre_director=$vc_nombre_director;
	}

	/**
	 * Obtiene el valor de VC_Cedula_Director
	 * @return mixed
	 */
	public function getVcCedulaDirector()
	{
			return $this->vc_cedula_director;
	}

	/**
	 * Asigna el valor para VC_Cedula_Director
	 * @param mixed $vc_cedula_director 
	 */
	public function setVcCedulaDirector($vc_cedula_director)
	{
			$this->vc_cedula_director=$vc_cedula_director;
	}

	/**
	 * Obtiene el valor de VC_Direccion_Director
	 * @return mixed
	 */
	public function getVcDireccionDirector()
	{
			return $this->vc_direccion_director;
	}

	/**
	 * Asigna el valor para VC_Direccion_Director
	 * @param mixed $vc_direccion_director 
	 */
	public function setVcDireccionDirector($vc_direccion_director)
	{
			$this->vc_direccion_director=$vc_direccion_director;
	}

	/**
	 * Obtiene el valor de VC_Telefono_Director
	 * @return mixed
	 */
	public function getVcTelefonoDirector()
	{
			return $this->vc_telefono_director;
	}

	/**
	 * Asigna el valor para VC_Telefono_Director
	 * @param mixed $vc_telefono_director 
	 */
	public function setVcTelefonoDirector($vc_telefono_director)
	{
			$this->vc_telefono_director=$vc_telefono_director;
	}

	/**
	 * Obtiene el valor de VC_Correo_Director
	 * @return mixed
	 */
	public function getVcCorreoDirector()
	{
			return $this->vc_correo_director;
	}

	/**
	 * Asigna el valor para VC_Correo_Director
	 * @param mixed $vc_correo_director 
	 */
	public function setVcCorreoDirector($vc_correo_director)
	{
			$this->vc_correo_director=$vc_correo_director;
	}

	/**
	 * Obtiene el valor de VC_Dimension
	 * @return mixed
	 */
	public function getVcDimension()
	{
			return $this->vc_dimension;
	}

	/**
	 * Asigna el valor para VC_Dimension
	 * @param mixed $vc_dimension 
	 */
	public function setVcDimension($vc_dimension)
	{
			$this->vc_dimension=$vc_dimension;
	}

	/**
	 * Obtiene el valor de VC_Antecedentes
	 * @return mixed
	 */
	public function getVcAntecedentes()
	{
			return $this->vc_antecedentes;
	}

	/**
	 * Asigna el valor para VC_Antecedentes
	 * @param mixed $vc_antecedentes 
	 */
	public function setVcAntecedentes($vc_antecedentes)
	{
			$this->vc_antecedentes=$vc_antecedentes;
	}

	/**
	 * Obtiene el valor de VC_Objetivo_General
	 * @return mixed
	 */
	public function getVcObjetivoGeneral()
	{
			return $this->vc_objetivo_general;
	}

	/**
	 * Asigna el valor para VC_Objetivo_General
	 * @param mixed $vc_objetivo_general 
	 */
	public function setVcObjetivoGeneral($vc_objetivo_general)
	{
			$this->vc_objetivo_general=$vc_objetivo_general;
	}

	/**
	 * Obtiene el valor de VC_Descripcion_Problema
	 * @return mixed
	 */
	public function getVcDescripcionProblema()
	{
			return $this->vc_descripcion_problema;
	}

	/**
	 * Asigna el valor para VC_Descripcion_Problema
	 * @param mixed $vc_descripcion_problema 
	 */
	public function setVcDescripcionProblema($vc_descripcion_problema)
	{
			$this->vc_descripcion_problema=$vc_descripcion_problema;
	}

	/**
	 * Obtiene el valor de VC_Descripcion_Proyecto
	 * @return mixed
	 */
	public function getVcDescripcionProyecto()
	{
			return $this->vc_descripcion_proyecto;
	}

	/**
	 * Asigna el valor para VC_Descripcion_Proyecto
	 * @param mixed $vc_descripcion_proyecto 
	 */
	public function setVcDescripcionProyecto($vc_descripcion_proyecto)
	{
			$this->vc_descripcion_proyecto=$vc_descripcion_proyecto;
	}

	/**
	 * Obtiene el valor de FL_Cantidad_Beneficiados
	 * @return mixed
	 */
	public function getFlCantidadBeneficiados()
	{
			return $this->fl_cantidad_beneficiados;
	}

	/**
	 * Asigna el valor para FL_Cantidad_Beneficiados
	 * @param mixed $fl_cantidad_beneficiados 
	 */
	public function setFlCantidadBeneficiados($fl_cantidad_beneficiados)
	{
			$this->fl_cantidad_beneficiados=$fl_cantidad_beneficiados;
	}

	/**
	 * Obtiene el valor de VC_Beneficiarios
	 * @return mixed
	 */
	public function getVcBeneficiarios()
	{
			return $this->vc_beneficiarios;
	}

	/**
	 * Asigna el valor para VC_Beneficiarios
	 * @param mixed $vc_beneficiarios 
	 */
	public function setVcBeneficiarios($vc_beneficiarios)
	{
			$this->vc_beneficiarios=$vc_beneficiarios;
	}


}
