<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_propuesta_historial_organizacion'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPropuestaHistorialOrganizacion 
{
	
	private $pk_id;
	private $fk_id_usuario;
	private $vc_entidad;
	private $vc_nombre_proyecto;
	private $vc_inicio;
	private $vc_fin;
	private $vc_actividad_desarrollada;
	private $vc_poblacion_beneficiada;
	private $fl_cantidad_beneficiados;


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
	 * Obtiene el valor de VC_Entidad
	 * @return mixed
	 */
	public function getVcEntidad()
	{
			return $this->vc_entidad;
	}

	/**
	 * Asigna el valor para VC_Entidad
	 * @param mixed $vc_entidad 
	 */
	public function setVcEntidad($vc_entidad)
	{
			$this->vc_entidad=$vc_entidad;
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
	 * Obtiene el valor de VC_Inicio
	 * @return mixed
	 */
	public function getVcInicio()
	{
			return $this->vc_inicio;
	}

	/**
	 * Asigna el valor para VC_Inicio
	 * @param mixed $vc_inicio 
	 */
	public function setVcInicio($vc_inicio)
	{
			$this->vc_inicio=$vc_inicio;
	}

	/**
	 * Obtiene el valor de VC_Fin
	 * @return mixed
	 */
	public function getVcFin()
	{
			return $this->vc_fin;
	}

	/**
	 * Asigna el valor para VC_Fin
	 * @param mixed $vc_fin 
	 */
	public function setVcFin($vc_fin)
	{
			$this->vc_fin=$vc_fin;
	}

	/**
	 * Obtiene el valor de VC_Actividad_Desarrollada
	 * @return mixed
	 */
	public function getVcActividadDesarrollada()
	{
			return $this->vc_actividad_desarrollada;
	}

	/**
	 * Asigna el valor para VC_Actividad_Desarrollada
	 * @param mixed $vc_actividad_desarrollada 
	 */
	public function setVcActividadDesarrollada($vc_actividad_desarrollada)
	{
			$this->vc_actividad_desarrollada=$vc_actividad_desarrollada;
	}

	/**
	 * Obtiene el valor de VC_Poblacion_Beneficiada
	 * @return mixed
	 */
	public function getVcPoblacionBeneficiada()
	{
			return $this->vc_poblacion_beneficiada;
	}

	/**
	 * Asigna el valor para VC_Poblacion_Beneficiada
	 * @param mixed $vc_poblacion_beneficiada 
	 */
	public function setVcPoblacionBeneficiada($vc_poblacion_beneficiada)
	{
			$this->vc_poblacion_beneficiada=$vc_poblacion_beneficiada;
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


}
