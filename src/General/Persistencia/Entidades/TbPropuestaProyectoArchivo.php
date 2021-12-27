<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_propuesta_proyecto_archivos'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbPropuestaProyectoArchivo 
{
	
	private $pk_id;
	private $fk_id_usuario;
	private $vc_nombre_archivo;
	private $vc_ubicacion;
	private $vc_tipo;
	private $vc_fuente;


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
	 * Obtiene el valor de VC_Nombre_Archivo
	 * @return mixed
	 */
	public function getVcNombreArchivo()
	{
			return $this->vc_nombre_archivo;
	}

	/**
	 * Asigna el valor para VC_Nombre_Archivo
	 * @param mixed $vc_nombre_archivo 
	 */
	public function setVcNombreArchivo($vc_nombre_archivo)
	{
			$this->vc_nombre_archivo=$vc_nombre_archivo;
	}

	/**
	 * Obtiene el valor de VC_Ubicacion
	 * @return mixed
	 */
	public function getVcUbicacion()
	{
			return $this->vc_ubicacion;
	}

	/**
	 * Asigna el valor para VC_Ubicacion
	 * @param mixed $vc_ubicacion 
	 */
	public function setVcUbicacion($vc_ubicacion)
	{
			$this->vc_ubicacion=$vc_ubicacion;
	}

	/**
	 * Obtiene el valor de VC_Tipo
	 * @return mixed
	 */
	public function getVcTipo()
	{
			return $this->vc_tipo;
	}

	/**
	 * Asigna el valor para VC_Tipo
	 * @param mixed $vc_tipo 
	 */
	public function setVcTipo($vc_tipo)
	{
			$this->vc_tipo=$vc_tipo;
	}

	/**
	 * Obtiene el valor de VC_Fuente
	 * @return mixed
	 */
	public function getVcFuente()
	{
			return $this->vc_fuente;
	}

	/**
	 * Asigna el valor para VC_Fuente
	 * @param mixed $vc_fuente 
	 */
	public function setVcFuente($vc_fuente)
	{
			$this->vc_fuente=$vc_fuente;
	}


}
