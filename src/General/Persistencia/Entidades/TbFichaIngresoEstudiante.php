<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_ficha_ingreso_estudiante'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbFichaIngresoEstudiante 
{
	
	private $pk_id_estudiante;
	private $fk_id_persona;
	private $fk_id_colegio;
	private $fk_grado;
	private $vc_jornada;
	private $fk_id_clan;
	private $fk_id_linea;
	private $fk_id_area_artistica;
	private $fk_id_modalidad;
	private $vc_observaciones;
	private $dd_fecharegistro;


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
	 * Obtiene el valor de PK_Id_Estudiante
	 * @return mixed
	 */
	public function getPkIdEstudiante()
	{
			return $this->pk_id_estudiante;
	}

	/**
	 * Asigna el valor para PK_Id_Estudiante
	 * @param mixed $pk_id_estudiante 
	 */
	public function setPkIdEstudiante($pk_id_estudiante)
	{
			$this->pk_id_estudiante=$pk_id_estudiante;
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
	 * Obtiene el valor de FK_Id_Colegio
	 * @return mixed
	 */
	public function getFkIdColegio()
	{
			return $this->fk_id_colegio;
	}

	/**
	 * Asigna el valor para FK_Id_Colegio
	 * @param mixed $fk_id_colegio 
	 */
	public function setFkIdColegio($fk_id_colegio)
	{
			$this->fk_id_colegio=$fk_id_colegio;
	}

	/**
	 * Obtiene el valor de FK_Grado
	 * @return mixed
	 */
	public function getFkGrado()
	{
			return $this->fk_grado;
	}

	/**
	 * Asigna el valor para FK_Grado
	 * @param mixed $fk_grado 
	 */
	public function setFkGrado($fk_grado)
	{
			$this->fk_grado=$fk_grado;
	}

	/**
	 * Obtiene el valor de VC_Jornada
	 * @return mixed
	 */
	public function getVcJornada()
	{
			return $this->vc_jornada;
	}

	/**
	 * Asigna el valor para VC_Jornada
	 * @param mixed $vc_jornada 
	 */
	public function setVcJornada($vc_jornada)
	{
			$this->vc_jornada=$vc_jornada;
	}

	/**
	 * Obtiene el valor de FK_Id_Clan
	 * @return mixed
	 */
	public function getFkIdClan()
	{
			return $this->fk_id_clan;
	}

	/**
	 * Asigna el valor para FK_Id_Clan
	 * @param mixed $fk_id_clan 
	 */
	public function setFkIdClan($fk_id_clan)
	{
			$this->fk_id_clan=$fk_id_clan;
	}

	/**
	 * Obtiene el valor de FK_Id_Linea
	 * @return mixed
	 */
	public function getFkIdLinea()
	{
			return $this->fk_id_linea;
	}

	/**
	 * Asigna el valor para FK_Id_Linea
	 * @param mixed $fk_id_linea 
	 */
	public function setFkIdLinea($fk_id_linea)
	{
			$this->fk_id_linea=$fk_id_linea;
	}

	/**
	 * Obtiene el valor de FK_Id_Area_Artistica
	 * @return mixed
	 */
	public function getFkIdAreaArtistica()
	{
			return $this->fk_id_area_artistica;
	}

	/**
	 * Asigna el valor para FK_Id_Area_Artistica
	 * @param mixed $fk_id_area_artistica 
	 */
	public function setFkIdAreaArtistica($fk_id_area_artistica)
	{
			$this->fk_id_area_artistica=$fk_id_area_artistica;
	}

	/**
	 * Obtiene el valor de FK_Id_Modalidad
	 * @return mixed
	 */
	public function getFkIdModalidad()
	{
			return $this->fk_id_modalidad;
	}

	/**
	 * Asigna el valor para FK_Id_Modalidad
	 * @param mixed $fk_id_modalidad 
	 */
	public function setFkIdModalidad($fk_id_modalidad)
	{
			$this->fk_id_modalidad=$fk_id_modalidad;
	}

	/**
	 * Obtiene el valor de VC_Observaciones
	 * @return mixed
	 */
	public function getVcObservaciones()
	{
			return $this->vc_observaciones;
	}

	/**
	 * Asigna el valor para VC_Observaciones
	 * @param mixed $vc_observaciones 
	 */
	public function setVcObservaciones($vc_observaciones)
	{
			$this->vc_observaciones=$vc_observaciones;
	}

	/**
	 * Obtiene el valor de DD_FechaRegistro
	 * @return mixed
	 */
	public function getDdFecharegistro()
	{
			return $this->dd_fecharegistro;
	}

	/**
	 * Asigna el valor para DD_FechaRegistro
	 * @param mixed $dd_fecharegistro 
	 */
	public function setDdFecharegistro($dd_fecharegistro)
	{
			$this->dd_fecharegistro=$dd_fecharegistro;
	}


}
