<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_ped_encuesta_estudiantes'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPedEncuestaEstudiante 
{
	
	private $pk_encuesta;
	private $dt_fecha_registro;
	private $vc_nombre_estudiante;
	private $fk_area_artistica;
	private $fk_artista_formador;
	private $rt_1;
	private $rt_2;
	private $rt_3;
	private $rt_4;
	private $rt_5;
	private $rt_6;
	private $rt_7;
	private $vc_observaciones;


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
	 * Obtiene el valor de PK_encuesta
	 * @return mixed
	 */
	public function getPkEncuesta()
	{
			return $this->pk_encuesta;
	}

	/**
	 * Asigna el valor para PK_encuesta
	 * @param mixed $pk_encuesta 
	 */
	public function setPkEncuesta($pk_encuesta)
	{
			$this->pk_encuesta=$pk_encuesta;
	}

	/**
	 * Obtiene el valor de DT_fecha_registro
	 * @return mixed
	 */
	public function getDtFechaRegistro()
	{
			return $this->dt_fecha_registro;
	}

	/**
	 * Asigna el valor para DT_fecha_registro
	 * @param mixed $dt_fecha_registro 
	 */
	public function setDtFechaRegistro($dt_fecha_registro)
	{
			$this->dt_fecha_registro=$dt_fecha_registro;
	}

	/**
	 * Obtiene el valor de VC_nombre_estudiante
	 * @return mixed
	 */
	public function getVcNombreEstudiante()
	{
			return $this->vc_nombre_estudiante;
	}

	/**
	 * Asigna el valor para VC_nombre_estudiante
	 * @param mixed $vc_nombre_estudiante 
	 */
	public function setVcNombreEstudiante($vc_nombre_estudiante)
	{
			$this->vc_nombre_estudiante=$vc_nombre_estudiante;
	}

	/**
	 * Obtiene el valor de FK_area_artistica
	 * @return mixed
	 */
	public function getFkAreaArtistica()
	{
			return $this->fk_area_artistica;
	}

	/**
	 * Asigna el valor para FK_area_artistica
	 * @param mixed $fk_area_artistica 
	 */
	public function setFkAreaArtistica($fk_area_artistica)
	{
			$this->fk_area_artistica=$fk_area_artistica;
	}

	/**
	 * Obtiene el valor de FK_artista_formador
	 * @return mixed
	 */
	public function getFkArtistaFormador()
	{
			return $this->fk_artista_formador;
	}

	/**
	 * Asigna el valor para FK_artista_formador
	 * @param mixed $fk_artista_formador 
	 */
	public function setFkArtistaFormador($fk_artista_formador)
	{
			$this->fk_artista_formador=$fk_artista_formador;
	}

	/**
	 * Obtiene el valor de RT_1
	 * @return mixed
	 */
	public function getRt1()
	{
			return $this->rt_1;
	}

	/**
	 * Asigna el valor para RT_1
	 * @param mixed $rt_1 
	 */
	public function setRt1($rt_1)
	{
			$this->rt_1=$rt_1;
	}

	/**
	 * Obtiene el valor de RT_2
	 * @return mixed
	 */
	public function getRt2()
	{
			return $this->rt_2;
	}

	/**
	 * Asigna el valor para RT_2
	 * @param mixed $rt_2 
	 */
	public function setRt2($rt_2)
	{
			$this->rt_2=$rt_2;
	}

	/**
	 * Obtiene el valor de RT_3
	 * @return mixed
	 */
	public function getRt3()
	{
			return $this->rt_3;
	}

	/**
	 * Asigna el valor para RT_3
	 * @param mixed $rt_3 
	 */
	public function setRt3($rt_3)
	{
			$this->rt_3=$rt_3;
	}

	/**
	 * Obtiene el valor de RT_4
	 * @return mixed
	 */
	public function getRt4()
	{
			return $this->rt_4;
	}

	/**
	 * Asigna el valor para RT_4
	 * @param mixed $rt_4 
	 */
	public function setRt4($rt_4)
	{
			$this->rt_4=$rt_4;
	}

	/**
	 * Obtiene el valor de RT_5
	 * @return mixed
	 */
	public function getRt5()
	{
			return $this->rt_5;
	}

	/**
	 * Asigna el valor para RT_5
	 * @param mixed $rt_5 
	 */
	public function setRt5($rt_5)
	{
			$this->rt_5=$rt_5;
	}

	/**
	 * Obtiene el valor de RT_6
	 * @return mixed
	 */
	public function getRt6()
	{
			return $this->rt_6;
	}

	/**
	 * Asigna el valor para RT_6
	 * @param mixed $rt_6 
	 */
	public function setRt6($rt_6)
	{
			$this->rt_6=$rt_6;
	}

	/**
	 * Obtiene el valor de RT_7
	 * @return mixed
	 */
	public function getRt7()
	{
			return $this->rt_7;
	}

	/**
	 * Asigna el valor para RT_7
	 * @param mixed $rt_7 
	 */
	public function setRt7($rt_7)
	{
			$this->rt_7=$rt_7;
	}

	/**
	 * Obtiene el valor de VC_observaciones
	 * @return mixed
	 */
	public function getVcObservaciones()
	{
			return $this->vc_observaciones;
	}

	/**
	 * Asigna el valor para VC_observaciones
	 * @param mixed $vc_observaciones 
	 */
	public function setVcObservaciones($vc_observaciones)
	{
			$this->vc_observaciones=$vc_observaciones;
	}


}
