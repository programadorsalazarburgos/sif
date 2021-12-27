<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_nidos_Fortalecimiento'
 *
 * @author: Juan David Torres, gracias a http://phpdao.com
 * @date: 2018-09-19 16:34
 */
class TbNidosFortalecimiento
{

	private $pk_id_fortalecimiento;
	private $fk_id_eaat;
	private $fk_id_territorio;
	private $fk_id_localidad;
	private $fk_id_upz;
	private $vc_lugar;
	private $vc_barrio;
	private $vc_nom_evento;
	private $vc_mes_evento;
	private $dt_fecha_evento;
	private $in_artistas_responsables;
	private $dt_fecha_registro;

	private $artistas_array;
	private $eaat_responsable;
	private $eaat_territorio;

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
	 * Obtiene el valor de pk_id_fortalecimiento
	 * @return mixed
	 */
	public function getpkidfortalecimiento()
	{
			return $this->pk_id_fortalecimiento;
	}
	/**
	 * Asigna el valor para pk_id_fortalecimiento
	 * @param mixed $pk_id_fortalecimiento
	 */
	public function setpkidfortalecimiento($pk_id_fortalecimiento)
	{
			$this->pk_id_fortalecimiento=$pk_id_fortalecimiento;
	}

	/**
	 * Obtiene el valor de fk_id_eaat
	 * @return mixed
	 */
	public function getfkideaat()
	{
			return $this->fk_id_eaat;
	}
	/**
	 * Asigna el valor para fk_id_eaat
	 * @param mixed $fk_id_eaat
	 */
	public function setfkideaat($fk_id_eaat)
	{
			$this->fk_id_eaat=$fk_id_eaat;
	}

	/**
	 * Obtiene el valor de fk_id_territorio
	 * @return mixed
	 */
	public function getfkidterritorio()
	{
			return $this->fk_id_territorio;
	}
	/**
	 * Asigna el valor para fk_id_territorio
	 * @param mixed $fk_id_territorio
	 */
	public function setfkidterritorio($fk_id_territorio)
	{
			$this->fk_id_territorio=$fk_id_territorio;
	}

	/**
	 * Obtiene el valor de fk_id_localidad
	 * @return mixed
	 */
	public function getfkidlocalidad()
	{
			return $this->fk_id_localidad;
	}
	/**
	 * Asigna el valor para fk_id_localidad
	 * @param mixed $fk_id_localidad
	 */
	public function setfkidlocalidad($fk_id_localidad)
	{
			$this->fk_id_localidad=$fk_id_localidad;
	}

	/**
	 * Obtiene el valor de fk_id_upz
	 * @return mixed
	 */
	public function getfkidupz()
	{
			return $this->fk_id_upz;
	}
	/**
	 * Asigna el valor para fk_id_upz
	 * @param mixed $fk_id_upz
	 */
	public function setfkidupz($fk_id_upz)
	{
			$this->fk_id_upz=$fk_id_upz;
	}

	/**
 	* Obtiene el valor de vc_lugar
 	* @return mixed
 	*/
	public function getvclugar()
	{
			return $this->vc_lugar;
	}
 /**
  * Asigna el valor para vc_lugar
  * @param mixed $vc_lugar
  */
	public function setvclugar($vc_lugar)
  {
	 		$this->vc_lugar=$vc_lugar;
  }

	/**
	* Obtiene el valor de vc_barrio
	* @return mixed
	*/
	public function getvcbarrio()
	{
			return $this->vc_barrio;
	}
	/**
	* Asigna el valor para vc_barrio
	* @param mixed $vc_barrio
	*/
	public function setvcbarrio($vc_barrio)
	{
			$this->vc_barrio=$vc_barrio;
	}

	/**
	* Obtiene el valor de vc_nom_evento
	* @return mixed
	*/
	public function getvcnomevento()
	{
			return $this->vc_nom_evento;
	}
	/**
	* Asigna el valor para vc_nom_evento
	* @param mixed $vc_nom_evento
	*/
	public function setvcnomevento($vc_nom_evento)
	{
			$this->vc_nom_evento=$vc_nom_evento;
	}

	/**
	* Obtiene el valor de vc_mes_evento
	* @return mixed
	*/
	public function getvcmesevento()
	{
			return $this->vc_mes_evento;
	}
	/**
	* Asigna el valor para vc_mes_evento
	* @param mixed $vc_mes_evento
	*/
	public function setvcmesevento($vc_mes_evento)
	{
			$this->vc_mes_evento=$vc_mes_evento;
	}

	/**
	* Obtiene el valor de dt_fecha_evento
	* @return mixed
	*/
	public function getDtFechaEvento()
	{
			return $this->dt_fecha_evento;
	}
	/**
	* Asigna el valor para dt_fecha_evento
	* @param mixed $dt_fecha_evento
	*/
	public function setDtFechaEvento($dt_fecha_evento)
	{
			$this->dt_fecha_evento=$dt_fecha_evento;
	}

	/**
	* Obtiene el valor de in_artistas_responsables
	* @return mixed
	*/
	public function getinartistasresponsables()
	{
			return $this->in_artistas_responsables;
	}
	/**
	* Asigna el valor para in_artistas_responsables
	* @param mixed $in_artistas_responsables
	*/
	public function setinartistasresponsables($in_artistas_responsables)
	{
			$this->in_artistas_responsables=$in_artistas_responsables;
	}

/**
 * Obtiene el valor de dt_fecha_registro
 * @return mixed
 */
	public function getdtfecharegistro()
	{
	     return $this->dt_fecha_registro;
	}
	 /**
	 * @param mixed dt_fecha_registro
	 */
  public function setdtfecharegistro($dt_fecha_registro)
	{
	     $this->dt_fecha_registro = $dt_fecha_registro;
	}

	/**
	* Obtiene el valor de $artistas_array
	 * @return mixed
	*/
	public function getArtistaArray()
	{
	     return $this->artistas_array;
	}
	 /**
	 * @param mixed $artistas_array
	 */
  public function setArtistaArray($artistas_array)
	{
	     $this->artistas_array = $artistas_array;
	}


	/**
	* Obtiene el valor de $eaat_responsable
	 * @return mixed
	*/
	public function getEaatResponsable()
	{
	     return $this->eaat_responsable;
	}
	 /**
	 * @param mixed $eaat_responsable
	 */
  public function setEaatResponsable($eaat_responsable)
	{
	     $this->eaat_responsable = $eaat_responsable;
	}

	/**
	* Obtiene el valor de $eaat_territorio
	 * @return mixed
	*/
	public function getEaatTerritorio()
	{
	     return $this->eaat_territorio;
	}
	 /**
	 * @param mixed $eaat_territorio
	 */
  public function setEaatTerritorio($eaat_territorio)
	{
	     $this->eaat_territorio = $eaat_territorio;
	}




}
