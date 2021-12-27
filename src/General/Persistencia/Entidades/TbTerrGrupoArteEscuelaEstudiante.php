<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_terr_grupo_arte_escuela_estudiante'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbTerrGrupoArteEscuelaEstudiante 
{
	
	private $fk_grupo;
	private $fk_estudiante;
	private $dt_fecha_ingreso;
	private $fk_usuario_ingreso;
	private $dt_fecha_retiro;
	private $fk_usuario_retiro;
	private $estado;
	private $tx_observaciones;


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
	 * Obtiene el valor de FK_grupo
	 * @return mixed
	 */
	public function getFkGrupo()
	{
			return $this->fk_grupo;
	}

	/**
	 * Asigna el valor para FK_grupo
	 * @param mixed $fk_grupo 
	 */
	public function setFkGrupo($fk_grupo)
	{
			$this->fk_grupo=$fk_grupo;
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
	 * Obtiene el valor de DT_fecha_ingreso
	 * @return mixed
	 */
	public function getDtFechaIngreso()
	{
			return $this->dt_fecha_ingreso;
	}

	/**
	 * Asigna el valor para DT_fecha_ingreso
	 * @param mixed $dt_fecha_ingreso 
	 */
	public function setDtFechaIngreso($dt_fecha_ingreso)
	{
			$this->dt_fecha_ingreso=$dt_fecha_ingreso;
	}

	/**
	 * Obtiene el valor de FK_usuario_ingreso
	 * @return mixed
	 */
	public function getFkUsuarioIngreso()
	{
			return $this->fk_usuario_ingreso;
	}

	/**
	 * Asigna el valor para FK_usuario_ingreso
	 * @param mixed $fk_usuario_ingreso 
	 */
	public function setFkUsuarioIngreso($fk_usuario_ingreso)
	{
			$this->fk_usuario_ingreso=$fk_usuario_ingreso;
	}

	/**
	 * Obtiene el valor de DT_fecha_retiro
	 * @return mixed
	 */
	public function getDtFechaRetiro()
	{
			return $this->dt_fecha_retiro;
	}

	/**
	 * Asigna el valor para DT_fecha_retiro
	 * @param mixed $dt_fecha_retiro 
	 */
	public function setDtFechaRetiro($dt_fecha_retiro)
	{
			$this->dt_fecha_retiro=$dt_fecha_retiro;
	}

	/**
	 * Obtiene el valor de FK_usuario_retiro
	 * @return mixed
	 */
	public function getFkUsuarioRetiro()
	{
			return $this->fk_usuario_retiro;
	}

	/**
	 * Asigna el valor para FK_usuario_retiro
	 * @param mixed $fk_usuario_retiro 
	 */
	public function setFkUsuarioRetiro($fk_usuario_retiro)
	{
			$this->fk_usuario_retiro=$fk_usuario_retiro;
	}

	/**
	 * Obtiene el valor de estado
	 * @return mixed
	 */
	public function getEstado()
	{
			return $this->estado;
	}

	/**
	 * Asigna el valor para estado
	 * @param mixed $estado 
	 */
	public function setEstado($estado)
	{
			$this->estado=$estado;
	}

	/**
	 * Obtiene el valor de TX_observaciones
	 * @return mixed
	 */
	public function getTxObservaciones()
	{
			return $this->tx_observaciones;
	}

	/**
	 * Asigna el valor para TX_observaciones
	 * @param mixed $tx_observaciones 
	 */
	public function setTxObservaciones($tx_observaciones)
	{
			$this->tx_observaciones=$tx_observaciones;
	}


}
