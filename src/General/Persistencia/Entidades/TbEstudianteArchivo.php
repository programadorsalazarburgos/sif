<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_estudiante_archivo'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbEstudianteArchivo 
{
	
	private $pk_estudiante_archivo;
	private $fk_id_estudiante;
	private $vc_nombre_archivo;
	private $vc_url;
	private $da_fecha_subida;
	private $fk_usuario_creacion;


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
	 * Obtiene el valor de PK_estudiante_archivo
	 * @return mixed
	 */
	public function getPkEstudianteArchivo()
	{
			return $this->pk_estudiante_archivo;
	}

	/**
	 * Asigna el valor para PK_estudiante_archivo
	 * @param mixed $pk_estudiante_archivo 
	 */
	public function setPkEstudianteArchivo($pk_estudiante_archivo)
	{
			$this->pk_estudiante_archivo=$pk_estudiante_archivo;
	}

	/**
	 * Obtiene el valor de FK_Id_Estudiante
	 * @return mixed
	 */
	public function getFkIdEstudiante()
	{
			return $this->fk_id_estudiante;
	}

	/**
	 * Asigna el valor para FK_Id_Estudiante
	 * @param mixed $fk_id_estudiante 
	 */
	public function setFkIdEstudiante($fk_id_estudiante)
	{
			$this->fk_id_estudiante=$fk_id_estudiante;
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
	 * Obtiene el valor de VC_Url
	 * @return mixed
	 */
	public function getVcUrl()
	{
			return $this->vc_url;
	}

	/**
	 * Asigna el valor para VC_Url
	 * @param mixed $vc_url 
	 */
	public function setVcUrl($vc_url)
	{
			$this->vc_url=$vc_url;
	}

	/**
	 * Obtiene el valor de DA_Fecha_Subida
	 * @return mixed
	 */
	public function getDaFechaSubida()
	{
			return $this->da_fecha_subida;
	}

	/**
	 * Asigna el valor para DA_Fecha_Subida
	 * @param mixed $da_fecha_subida 
	 */
	public function setDaFechaSubida($da_fecha_subida)
	{
			$this->da_fecha_subida=$da_fecha_subida;
	}

	/**
	 * Obtiene el valor de FK_Usuario_Creacion
	 * @return mixed
	 */
	public function getFkUsuarioCreacion()
	{
			return $this->fk_usuario_creacion;
	}

	/**
	 * Asigna el valor para FK_Usuario_Creacion
	 * @param mixed $fk_usuario_creacion 
	 */
	public function setFkUsuarioCreacion($fk_usuario_creacion)
	{
			$this->fk_usuario_creacion=$fk_usuario_creacion;
	}


}
