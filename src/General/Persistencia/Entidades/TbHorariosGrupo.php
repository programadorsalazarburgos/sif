<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_horarios_grupos'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbHorariosGrupo 
{
	
	private $id_horario_grupo;
	private $fk_id_grupo;
	private $vc_dia;
	private $tm_hora_inicio;
	private $tm_hora_fin;
	private $pk_salon;


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
	 * Obtiene el valor de Id_Horario_Grupo
	 * @return mixed
	 */
	public function getIdHorarioGrupo()
	{
			return $this->id_horario_grupo;
	}

	/**
	 * Asigna el valor para Id_Horario_Grupo
	 * @param mixed $id_horario_grupo 
	 */
	public function setIdHorarioGrupo($id_horario_grupo)
	{
			$this->id_horario_grupo=$id_horario_grupo;
	}

	/**
	 * Obtiene el valor de FK_Id_Grupo
	 * @return mixed
	 */
	public function getFkIdGrupo()
	{
			return $this->fk_id_grupo;
	}

	/**
	 * Asigna el valor para FK_Id_Grupo
	 * @param mixed $fk_id_grupo 
	 */
	public function setFkIdGrupo($fk_id_grupo)
	{
			$this->fk_id_grupo=$fk_id_grupo;
	}

	/**
	 * Obtiene el valor de VC_Dia
	 * @return mixed
	 */
	public function getVcDia()
	{
			return $this->vc_dia;
	}

	/**
	 * Asigna el valor para VC_Dia
	 * @param mixed $vc_dia 
	 */
	public function setVcDia($vc_dia)
	{
			$this->vc_dia=$vc_dia;
	}

	/**
	 * Obtiene el valor de TM_Hora_Inicio
	 * @return mixed
	 */
	public function getTmHoraInicio()
	{
			return $this->tm_hora_inicio;
	}

	/**
	 * Asigna el valor para TM_Hora_Inicio
	 * @param mixed $tm_hora_inicio 
	 */
	public function setTmHoraInicio($tm_hora_inicio)
	{
			$this->tm_hora_inicio=$tm_hora_inicio;
	}

	/**
	 * Obtiene el valor de TM_Hora_Fin
	 * @return mixed
	 */
	public function getTmHoraFin()
	{
			return $this->tm_hora_fin;
	}

	/**
	 * Asigna el valor para TM_Hora_Fin
	 * @param mixed $tm_hora_fin 
	 */
	public function setTmHoraFin($tm_hora_fin)
	{
			$this->tm_hora_fin=$tm_hora_fin;
	}

	/**
	 * Obtiene el valor de PK_Salon
	 * @return mixed
	 */
	public function getPkSalon()
	{
			return $this->pk_salon;
	}

	/**
	 * Asigna el valor para PK_Salon
	 * @param mixed $pk_salon 
	 */
	public function setPkSalon($pk_salon)
	{
			$this->pk_salon=$pk_salon;
	}


}
