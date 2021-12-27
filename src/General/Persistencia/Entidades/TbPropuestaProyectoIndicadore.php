<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_propuesta_proyecto_indicadores'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPropuestaProyectoIndicadore 
{
	
	private $pk_id;
	private $fk_id_usuario;
	private $vc_nombre_indicador;
	private $vc_formula;
	private $vc_estado_inicial;
	private $vc_valor_esperado;
	private $vc_periodo;


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
	 * Obtiene el valor de PK_Id
	 * @return mixed
	 */
	public function getPkId()
	{
			return $this->pk_id;
	}

	/**
	 * Asigna el valor para PK_Id
	 * @param mixed $pk_id 
	 */
	public function setPkId($pk_id)
	{
			$this->pk_id=$pk_id;
	}

	/**
	 * Obtiene el valor de FK_Id_Usuario
	 * @return mixed
	 */
	public function getFkIdUsuario()
	{
			return $this->fk_id_usuario;
	}

	/**
	 * Asigna el valor para FK_Id_Usuario
	 * @param mixed $fk_id_usuario 
	 */
	public function setFkIdUsuario($fk_id_usuario)
	{
			$this->fk_id_usuario=$fk_id_usuario;
	}

	/**
	 * Obtiene el valor de VC_Nombre_Indicador
	 * @return mixed
	 */
	public function getVcNombreIndicador()
	{
			return $this->vc_nombre_indicador;
	}

	/**
	 * Asigna el valor para VC_Nombre_Indicador
	 * @param mixed $vc_nombre_indicador 
	 */
	public function setVcNombreIndicador($vc_nombre_indicador)
	{
			$this->vc_nombre_indicador=$vc_nombre_indicador;
	}

	/**
	 * Obtiene el valor de VC_Formula
	 * @return mixed
	 */
	public function getVcFormula()
	{
			return $this->vc_formula;
	}

	/**
	 * Asigna el valor para VC_Formula
	 * @param mixed $vc_formula 
	 */
	public function setVcFormula($vc_formula)
	{
			$this->vc_formula=$vc_formula;
	}

	/**
	 * Obtiene el valor de VC_Estado_Inicial
	 * @return mixed
	 */
	public function getVcEstadoInicial()
	{
			return $this->vc_estado_inicial;
	}

	/**
	 * Asigna el valor para VC_Estado_Inicial
	 * @param mixed $vc_estado_inicial 
	 */
	public function setVcEstadoInicial($vc_estado_inicial)
	{
			$this->vc_estado_inicial=$vc_estado_inicial;
	}

	/**
	 * Obtiene el valor de VC_Valor_Esperado
	 * @return mixed
	 */
	public function getVcValorEsperado()
	{
			return $this->vc_valor_esperado;
	}

	/**
	 * Asigna el valor para VC_Valor_Esperado
	 * @param mixed $vc_valor_esperado 
	 */
	public function setVcValorEsperado($vc_valor_esperado)
	{
			$this->vc_valor_esperado=$vc_valor_esperado;
	}

	/**
	 * Obtiene el valor de VC_Periodo
	 * @return mixed
	 */
	public function getVcPeriodo()
	{
			return $this->vc_periodo;
	}

	/**
	 * Asigna el valor para VC_Periodo
	 * @param mixed $vc_periodo 
	 */
	public function setVcPeriodo($vc_periodo)
	{
			$this->vc_periodo=$vc_periodo;
	}


}
