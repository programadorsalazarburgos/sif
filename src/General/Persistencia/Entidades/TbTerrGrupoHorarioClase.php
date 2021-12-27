<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa las tablas 'tb_terr_grupo_arte_escuela_horario_clase', 'tb_terr_grupo_emprende_clan_horario_clase' y 'tb_terr_grupo_laboratorio_clan_horario_clase'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:06	 
 */
class TbTerrGrupoHorarioClase 
{
	
	private $fk_grupo;
	private $in_dia;
	private $ti_hora_inicio_clase;
	private $ti_hora_fin_clase;

	private $tipo_grupo;


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
	 * Obtiene el valor de IN_dia
	 * @return mixed
	 */
	public function getInDia()
	{
			return $this->in_dia;
	}

	/**
	 * Asigna el valor para IN_dia
	 * @param mixed $in_dia 
	 */
	public function setInDia($in_dia)
	{
			$this->in_dia=$in_dia;
	}

	/**
	 * Obtiene el valor de TI_hora_inicio_clase
	 * @return mixed
	 */
	public function getTiHoraInicioClase()
	{
			return $this->ti_hora_inicio_clase;
	}

	/**
	 * Asigna el valor para TI_hora_inicio_clase
	 * @param mixed $ti_hora_inicio_clase 
	 */
	public function setTiHoraInicioClase($ti_hora_inicio_clase)
	{
			$this->ti_hora_inicio_clase=$ti_hora_inicio_clase;
	}

	/**
	 * Obtiene el valor de TI_hora_fin_clase
	 * @return mixed
	 */
	public function getTiHoraFinClase()
	{
			return $this->ti_hora_fin_clase;
	}

	/**
	 * Asigna el valor para TI_hora_fin_clase
	 * @param mixed $ti_hora_fin_clase 
	 */
	public function setTiHoraFinClase($ti_hora_fin_clase)
	{
			$this->ti_hora_fin_clase=$ti_hora_fin_clase;
	}

	public function getTipoGrupo()
    {
        return $this->tipo_grupo;
    }

    /**
     * @param mixed $tipo_grupo
     *
     * @return self
     */
    public function setTipoGrupo($tipo_grupo)
    {
        $this->tipo_grupo = $tipo_grupo;

        return $this;
    }
}
