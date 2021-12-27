<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_propuesta_proyecto_metas'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPropuestaProyectoMeta 
{
	
	private $pk_id;
	private $fk_id_usuario;
	private $vc_proceso;
	private $vc_magnitud;
	private $vc_unidad_medida;
	private $vc_descripcion;
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
	 * Obtiene el valor de VC_Proceso
	 * @return mixed
	 */
	public function getVcProceso()
	{
			return $this->vc_proceso;
	}

	/**
	 * Asigna el valor para VC_Proceso
	 * @param mixed $vc_proceso 
	 */
	public function setVcProceso($vc_proceso)
	{
			$this->vc_proceso=$vc_proceso;
	}

	/**
	 * Obtiene el valor de VC_Magnitud
	 * @return mixed
	 */
	public function getVcMagnitud()
	{
			return $this->vc_magnitud;
	}

	/**
	 * Asigna el valor para VC_Magnitud
	 * @param mixed $vc_magnitud 
	 */
	public function setVcMagnitud($vc_magnitud)
	{
			$this->vc_magnitud=$vc_magnitud;
	}

	/**
	 * Obtiene el valor de VC_Unidad_Medida
	 * @return mixed
	 */
	public function getVcUnidadMedida()
	{
			return $this->vc_unidad_medida;
	}

	/**
	 * Asigna el valor para VC_Unidad_Medida
	 * @param mixed $vc_unidad_medida 
	 */
	public function setVcUnidadMedida($vc_unidad_medida)
	{
			$this->vc_unidad_medida=$vc_unidad_medida;
	}

	/**
	 * Obtiene el valor de VC_Descripcion
	 * @return mixed
	 */
	public function getVcDescripcion()
	{
			return $this->vc_descripcion;
	}

	/**
	 * Asigna el valor para VC_Descripcion
	 * @param mixed $vc_descripcion 
	 */
	public function setVcDescripcion($vc_descripcion)
	{
			$this->vc_descripcion=$vc_descripcion;
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
