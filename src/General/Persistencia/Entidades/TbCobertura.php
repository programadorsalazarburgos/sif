<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_cobertura'
 *
 * @author: Diego Forero
 * @date: 2020-07-21 33:05	 
 */
class TbCobertura 
{
	
	private $id;

	private $anio;

	private $IN_linea_atencion;

	private $id_zona;

	private $id_colegio;

	private $id_clan;

	private $id_convenio;

	private $json_area_artistica;

	private $DT_fecha_creacion_edicion;

	private $FK_usuario_creacion_edicion;

	private $estado;

	
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

	 * Obtiene el valor de anio

	 * @return mixed

	 */

	public function getAnio()

	{

		return $this->anio;

	}


	/**

	 * Asigna el valor para anio

	 * @param mixed $anio 

	 */

	public function setAnio($anio)

	{

		$this->anio=$anio;

	}

	/**

	 * Obtiene el valor de Línea de Atención

	 * @return mixed

	 */

	public function getLineaAtencion()

	{

		return $this->IN_linea_atencion;

	}


	/**

	 * Asigna el valor para Línea de Atención

	 * @param mixed $IN_linea_atencion 

	 */

	public function setLineaAtencion($linea_atencion)

	{

		$this->IN_linea_atencion=$linea_atencion;

	}

	/**

	 * Obtiene el valor de id_zona

	 * @return mixed

	 */

	public function getIdZona()

	{

		return $this->id_zona;

	}


	/**

	 * Asigna el valor para id_zona

	 * @param mixed $id_zona

	 */

	public function setIdZona($id_zona)

	{

		$this->id_zona=$id_zona;

	}

	/**

	 * Obtiene el valor de id_colegio

	 * @return mixed

	 */

	public function getIdColegio()

	{

		return $this->id_colegio;

	}


	/**

	 * Asigna el valor para id_colegio

	 * @param mixed $id_colegio 

	 */

	public function setIdColegio($id_colegio)

	{

		$this->id_colegio=$id_colegio;

	}

	/**

	 * Obtiene el valor de id_clan

	 * @return mixed

	 */

	public function getIdClan()

	{

		return $this->id_clan;

	}


	/**

	 * Asigna el valor para id_clan

	 * @param mixed $id_clan

	 */

	public function setIdClan($id_clan)

	{

		$this->id_clan=$id_clan;

	}

	/**

	 * Obtiene el valor de id_convenio

	 * @return mixed

	 */

	public function getIdConvenio()

	{

		return $this->id_convenio;

	}


	/**

	 * Asigna el valor para id_convenio

	 * @param mixed $id_convenio

	 */

	public function setIdConvenio($id_convenio)

	{

		$this->id_convenio=$id_convenio;

	}
	/**

	 * Obtiene el valor de json_area_artistica

	 * @return mixed

	 */

	public function getJsonAreaArtistica()

	{

		return $this->json_area_artistica;

	}


	/**

	 * Asigna el valor para_area_artistica

	 * @param mixed $json_area_artistica 

	 */

	public function setJsonAreaArtistica($json_area_artistica)

	{

		$this->json_area_artistica=$json_area_artistica;

	}

	/**

	 * Obtiene el valor de DT_fecha_creacion_edicion

	 * @return mixed

	 */

	public function getDtFechaCreacionEdicion()

	{

		return $this->DT_fecha_creacion_edicion;

	}


	/**

	 * Asigna el valor para DT_fecha_creacion_edicion

	 * @param mixed $DT_fecha_creacion_edicion 

	 */

	public function setDtFechaCreacionEdicion($DT_fecha_creacion_edicion)

	{

		$this->DT_fecha_creacion_edicion=$DT_fecha_creacion_edicion;

	}

	/**

	 * Obtiene el valor de FK_usuario_creacion_edicion

	 * @return mixed

	 */

	public function getFkUsuarioCreacionEdicion()

	{

		return $this->FK_usuario_creacion_edicion;

	}


	/**

	 * Asigna el valor para FK_usuario_creacion_edicion

	 * @param mixed $FK_usuario_creacion_edicion 

	 */

	public function setFkUsuarioCreacionEdicion($FK_usuario_creacion_edicion)

	{

		$this->FK_usuario_creacion_edicion=$FK_usuario_creacion_edicion;

	}

	/**

	 * Obtiene el valor de estado

	 * @return mixed

	 */

	public function getEstado()

	{

		return $this->estado;

	}

	/**

	 * Asigna el valor para estado

	 * @param mixed $estado 

	 */

	public function setEstado($estado)

	{

		$this->estado=$estado;

	}
}
