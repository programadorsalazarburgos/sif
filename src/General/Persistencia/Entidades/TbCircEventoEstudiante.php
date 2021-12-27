<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_circ_evento_estudiante'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbCircEventoEstudiante 
{
	
	private $fk_estudiante;
	private $fk_evento;
	private $ti_permiso_padres;
	private $fk_asesor_pedagogico;
	private $fk_area_artistica;
	private $fk_clan;
	private $fk_colegio;
	private $fk_grado;
	private $fk_organizacion;
	private $ti_asistencia_dia1;
	private $ti_asistencia_dia2;


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
	 * Obtiene el valor de FK_Estudiante
	 * @return mixed
	 */
	public function getFkEstudiante()
	{
			return $this->fk_estudiante;
	}

	/**
	 * Asigna el valor para FK_Estudiante
	 * @param mixed $fk_estudiante 
	 */
	public function setFkEstudiante($fk_estudiante)
	{
			$this->fk_estudiante=$fk_estudiante;
	}

	/**
	 * Obtiene el valor de FK_Evento
	 * @return mixed
	 */
	public function getFkEvento()
	{
			return $this->fk_evento;
	}

	/**
	 * Asigna el valor para FK_Evento
	 * @param mixed $fk_evento 
	 */
	public function setFkEvento($fk_evento)
	{
			$this->fk_evento=$fk_evento;
	}

	/**
	 * Obtiene el valor de TI_Permiso_Padres
	 * @return mixed
	 */
	public function getTiPermisoPadres()
	{
			return $this->ti_permiso_padres;
	}

	/**
	 * Asigna el valor para TI_Permiso_Padres
	 * @param mixed $ti_permiso_padres 
	 */
	public function setTiPermisoPadres($ti_permiso_padres)
	{
			$this->ti_permiso_padres=$ti_permiso_padres;
	}

	/**
	 * Obtiene el valor de FK_Asesor_Pedagogico
	 * @return mixed
	 */
	public function getFkAsesorPedagogico()
	{
			return $this->fk_asesor_pedagogico;
	}

	/**
	 * Asigna el valor para FK_Asesor_Pedagogico
	 * @param mixed $fk_asesor_pedagogico 
	 */
	public function setFkAsesorPedagogico($fk_asesor_pedagogico)
	{
			$this->fk_asesor_pedagogico=$fk_asesor_pedagogico;
	}

	/**
	 * Obtiene el valor de FK_Area_Artistica
	 * @return mixed
	 */
	public function getFkAreaArtistica()
	{
			return $this->fk_area_artistica;
	}

	/**
	 * Asigna el valor para FK_Area_Artistica
	 * @param mixed $fk_area_artistica 
	 */
	public function setFkAreaArtistica($fk_area_artistica)
	{
			$this->fk_area_artistica=$fk_area_artistica;
	}

	/**
	 * Obtiene el valor de FK_Clan
	 * @return mixed
	 */
	public function getFkClan()
	{
			return $this->fk_clan;
	}

	/**
	 * Asigna el valor para FK_Clan
	 * @param mixed $fk_clan 
	 */
	public function setFkClan($fk_clan)
	{
			$this->fk_clan=$fk_clan;
	}

	/**
	 * Obtiene el valor de FK_Colegio
	 * @return mixed
	 */
	public function getFkColegio()
	{
			return $this->fk_colegio;
	}

	/**
	 * Asigna el valor para FK_Colegio
	 * @param mixed $fk_colegio 
	 */
	public function setFkColegio($fk_colegio)
	{
			$this->fk_colegio=$fk_colegio;
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
	 * Obtiene el valor de FK_Organizacion
	 * @return mixed
	 */
	public function getFkOrganizacion()
	{
			return $this->fk_organizacion;
	}

	/**
	 * Asigna el valor para FK_Organizacion
	 * @param mixed $fk_organizacion 
	 */
	public function setFkOrganizacion($fk_organizacion)
	{
			$this->fk_organizacion=$fk_organizacion;
	}

	/**
	 * Obtiene el valor de TI_Asistencia_Dia1
	 * @return mixed
	 */
	public function getTiAsistenciaDia1()
	{
			return $this->ti_asistencia_dia1;
	}

	/**
	 * Asigna el valor para TI_Asistencia_Dia1
	 * @param mixed $ti_asistencia_dia1 
	 */
	public function setTiAsistenciaDia1($ti_asistencia_dia1)
	{
			$this->ti_asistencia_dia1=$ti_asistencia_dia1;
	}

	/**
	 * Obtiene el valor de TI_Asistencia_Dia2
	 * @return mixed
	 */
	public function getTiAsistenciaDia2()
	{
			return $this->ti_asistencia_dia2;
	}

	/**
	 * Asigna el valor para TI_Asistencia_Dia2
	 * @param mixed $ti_asistencia_dia2 
	 */
	public function setTiAsistenciaDia2($ti_asistencia_dia2)
	{
			$this->ti_asistencia_dia2=$ti_asistencia_dia2;
	}


}
