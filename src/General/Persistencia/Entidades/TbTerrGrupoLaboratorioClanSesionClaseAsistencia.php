<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbTerrGrupoLaboratorioClanSesionClaseAsistencia 
{
	
	private $fk_sesion_clase;
	private $fk_estudiante;
	private $in_estado_asistencia;


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
	 * Obtiene el valor de FK_sesion_clase
	 * @return mixed
	 */
	public function getFkSesionClase()
	{
			return $this->fk_sesion_clase;
	}

	/**
	 * Asigna el valor para FK_sesion_clase
	 * @param mixed $fk_sesion_clase 
	 */
	public function setFkSesionClase($fk_sesion_clase)
	{
			$this->fk_sesion_clase=$fk_sesion_clase;
	}

	/**
	 * Obtiene el valor de FK_estudiante
	 * @return mixed
	 */
	public function getFkEstudiante()
	{
			return $this->fk_estudiante;
	}

	/**
	 * Asigna el valor para FK_estudiante
	 * @param mixed $fk_estudiante 
	 */
	public function setFkEstudiante($fk_estudiante)
	{
			$this->fk_estudiante=$fk_estudiante;
	}

	/**
	 * Obtiene el valor de IN_estado_asistencia
	 * @return mixed
	 */
	public function getInEstadoAsistencia()
	{
			return $this->in_estado_asistencia;
	}

	/**
	 * Asigna el valor para IN_estado_asistencia
	 * @param mixed $in_estado_asistencia 
	 */
	public function setInEstadoAsistencia($in_estado_asistencia)
	{
			$this->in_estado_asistencia=$in_estado_asistencia;
	}


}
