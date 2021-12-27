<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_admin_pdf_codigo_verificacion'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2018-02-23 21:48	 
 */
class TbAdminPdfCodigoVerificacion 
{
	
	private $id;
	private $html;


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
	 * Obtiene el valor de id
	 * @return mixed
	 */
	public function getId()
	{
			return $this->id;
	}

	/**
	 * Asigna el valor para id
	 * @param mixed $id 
	 */
	public function setId($id)
	{
			$this->id=$id;
	}

	/**
	 * Obtiene el valor de html
	 * @return mixed
	 */
	public function getHtml()
	{
			return $this->html;
	}

	/**
	 * Asigna el valor para html
	 * @param mixed $html 
	 */
	public function setHtml($html)
	{
			$this->html=$html;
	}


}
