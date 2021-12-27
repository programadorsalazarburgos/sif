<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_organizaciones_2017'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbOrganizaciones2017 
{
	
	private $pk_id_organizacion;
	private $vc_nom_organizacion;
	private $fk_id_localidad;
	private $vc_telefono;
	private $vc_direccion_organiz;
	private $vc_responsable_organi;
	private $vc_estado_organizacion;


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
	 * Obtiene el valor de VC_Nom_Organizacion
	 * @return mixed
	 */
	public function getVcNomOrganizacion()
	{
			return $this->vc_nom_organizacion;
	}

	/**
	 * Asigna el valor para VC_Nom_Organizacion
	 * @param mixed $vc_nom_organizacion 
	 */
	public function setVcNomOrganizacion($vc_nom_organizacion)
	{
			$this->vc_nom_organizacion=$vc_nom_organizacion;
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
	 * Obtiene el valor de VC_Direccion_Organiz
	 * @return mixed
	 */
	public function getVcDireccionOrganiz()
	{
			return $this->vc_direccion_organiz;
	}

	/**
	 * Asigna el valor para VC_Direccion_Organiz
	 * @param mixed $vc_direccion_organiz 
	 */
	public function setVcDireccionOrganiz($vc_direccion_organiz)
	{
			$this->vc_direccion_organiz=$vc_direccion_organiz;
	}

	/**
	 * Obtiene el valor de VC_Responsable_Organi
	 * @return mixed
	 */
	public function getVcResponsableOrgani()
	{
			return $this->vc_responsable_organi;
	}

	/**
	 * Asigna el valor para VC_Responsable_Organi
	 * @param mixed $vc_responsable_organi 
	 */
	public function setVcResponsableOrgani($vc_responsable_organi)
	{
			$this->vc_responsable_organi=$vc_responsable_organi;
	}

	/**
	 * Obtiene el valor de VC_Estado_Organizacion
	 * @return mixed
	 */
	public function getVcEstadoOrganizacion()
	{
			return $this->vc_estado_organizacion;
	}

	/**
	 * Asigna el valor para VC_Estado_Organizacion
	 * @param mixed $vc_estado_organizacion 
	 */
	public function setVcEstadoOrganizacion($vc_estado_organizacion)
	{
			$this->vc_estado_organizacion=$vc_estado_organizacion;
	}


}
