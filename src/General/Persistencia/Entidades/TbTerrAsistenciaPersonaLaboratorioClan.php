<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_terr_asistencia_persona_laboratorio_clan'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbTerrAsistenciaPersonaLaboratorioClan 
{
	
	private $fk_asistencia;
	private $ti_tiene_documento;
	private $vc_documento;
	private $vc_nombre;


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
	 * Obtiene el valor de FK_Asistencia
	 * @return mixed
	 */
	public function getFkAsistencia()
	{
			return $this->fk_asistencia;
	}

	/**
	 * Asigna el valor para FK_Asistencia
	 * @param mixed $fk_asistencia 
	 */
	public function setFkAsistencia($fk_asistencia)
	{
			$this->fk_asistencia=$fk_asistencia;
	}

	/**
	 * Obtiene el valor de TI_tiene_documento
	 * @return mixed
	 */
	public function getTiTieneDocumento()
	{
			return $this->ti_tiene_documento;
	}

	/**
	 * Asigna el valor para TI_tiene_documento
	 * @param mixed $ti_tiene_documento 
	 */
	public function setTiTieneDocumento($ti_tiene_documento)
	{
			$this->ti_tiene_documento=$ti_tiene_documento;
	}

	/**
	 * Obtiene el valor de VC_Documento
	 * @return mixed
	 */
	public function getVcDocumento()
	{
			return $this->vc_documento;
	}

	/**
	 * Asigna el valor para VC_Documento
	 * @param mixed $vc_documento 
	 */
	public function setVcDocumento($vc_documento)
	{
			$this->vc_documento=$vc_documento;
	}

	/**
	 * Obtiene el valor de VC_Nombre
	 * @return mixed
	 */
	public function getVcNombre()
	{
			return $this->vc_nombre;
	}

	/**
	 * Asigna el valor para VC_Nombre
	 * @param mixed $vc_nombre 
	 */
	public function setVcNombre($vc_nombre)
	{
			$this->vc_nombre=$vc_nombre;
	}


}
