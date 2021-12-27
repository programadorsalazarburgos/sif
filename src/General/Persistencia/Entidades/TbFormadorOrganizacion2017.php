<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_formador_organizacion_2017'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbFormadorOrganizacion2017 
{
	
	private $pk_formador_organizacion;
	private $fk_id_persona;
	private $fk_id_organizacion;
	private $vc_perfil;
	private $vc_interventoria;
	private $da_fecha;
	private $dt_fecha_asignacion;


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
	 * Obtiene el valor de VC_Interventoria
	 * @return mixed
	 */
	public function getVcInterventoria()
	{
			return $this->vc_interventoria;
	}

	/**
	 * Asigna el valor para VC_Interventoria
	 * @param mixed $vc_interventoria 
	 */
	public function setVcInterventoria($vc_interventoria)
	{
			$this->vc_interventoria=$vc_interventoria;
	}

	/**
	 * Obtiene el valor de DA_Fecha
	 * @return mixed
	 */
	public function getDaFecha()
	{
			return $this->da_fecha;
	}

	/**
	 * Asigna el valor para DA_Fecha
	 * @param mixed $da_fecha 
	 */
	public function setDaFecha($da_fecha)
	{
			$this->da_fecha=$da_fecha;
	}



    /**
     * Gets the value of dt_fecha_asignacion.
     *
     * @return mixed
     */
    public function getDtFechaAsignacion()
    {
        return $this->dt_fecha_asignacion;
    }

    /**
     * Sets the value of dt_fecha_asignacion.
     *
     * @param mixed $dt_fecha_asignacion the dt fecha asignacion
     *
     * @return self
     */
    public function setDtFechaAsignacion($dt_fecha_asignacion)
    {
        $this->dt_fecha_asignacion = $dt_fecha_asignacion;

        return $this;
    }
}
