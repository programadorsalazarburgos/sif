<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_grupo_sanguineo'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbGrupoSanguineo 
{
	
	private $fk_grupo_sanguineo;
	private $vc_nom_gsanguineo;


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
	 * Obtiene el valor de FK_Grupo_Sanguineo
	 * @return mixed
	 */
	public function getFkGrupoSanguineo()
	{
			return $this->fk_grupo_sanguineo;
	}

	/**
	 * Asigna el valor para FK_Grupo_Sanguineo
	 * @param mixed $fk_grupo_sanguineo 
	 */
	public function setFkGrupoSanguineo($fk_grupo_sanguineo)
	{
			$this->fk_grupo_sanguineo=$fk_grupo_sanguineo;
	}

	/**
	 * Obtiene el valor de VC_Nom_GSanguineo
	 * @return mixed
	 */
	public function getVcNomGsanguineo()
	{
			return $this->vc_nom_gsanguineo;
	}

	/**
	 * Asigna el valor para VC_Nom_GSanguineo
	 * @param mixed $vc_nom_gsanguineo 
	 */
	public function setVcNomGsanguineo($vc_nom_gsanguineo)
	{
			$this->vc_nom_gsanguineo=$vc_nom_gsanguineo;
	}


}
