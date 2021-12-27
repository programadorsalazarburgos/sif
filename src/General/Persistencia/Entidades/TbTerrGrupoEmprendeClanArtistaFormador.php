<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_terr_grupo_emprende_clan_artista_formador'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbTerrGrupoEmprendeClanArtistaFormador 
{
	
	private $pk_table;
	private $fk_grupo;
	private $fk_artista_formador;
	private $fk_usuario_asigno;
	private $dt_fecha_asignacion_grupo;


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
	 * Obtiene el valor de PK_table
	 * @return mixed
	 */
	public function getPkTable()
	{
			return $this->pk_table;
	}

	/**
	 * Asigna el valor para PK_table
	 * @param mixed $pk_table 
	 */
	public function setPkTable($pk_table)
	{
			$this->pk_table=$pk_table;
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
	 * Obtiene el valor de FK_usuario_asigno
	 * @return mixed
	 */
	public function getFkUsuarioAsigno()
	{
			return $this->fk_usuario_asigno;
	}

	/**
	 * Asigna el valor para FK_usuario_asigno
	 * @param mixed $fk_usuario_asigno 
	 */
	public function setFkUsuarioAsigno($fk_usuario_asigno)
	{
			$this->fk_usuario_asigno=$fk_usuario_asigno;
	}

	/**
	 * Obtiene el valor de DT_fecha_asignacion_grupo
	 * @return mixed
	 */
	public function getDtFechaAsignacionGrupo()
	{
			return $this->dt_fecha_asignacion_grupo;
	}

	/**
	 * Asigna el valor para DT_fecha_asignacion_grupo
	 * @param mixed $dt_fecha_asignacion_grupo 
	 */
	public function setDtFechaAsignacionGrupo($dt_fecha_asignacion_grupo)
	{
			$this->dt_fecha_asignacion_grupo=$dt_fecha_asignacion_grupo;
	}


}
