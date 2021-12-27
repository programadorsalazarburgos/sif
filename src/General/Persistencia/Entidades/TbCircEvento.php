<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_circ_evento'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-10-03 17:39	 
 */
class TbCircEvento 
{
	
	private $pk_id_evento;
	private $fk_tipo_evento;
	private $estado_evento;
	private $dt_fecha_inicio;
	private $dt_fecha_fin;
	private $vc_nombre;
	private $fk_organizador;
	private $vc_lugar;
	private $vc_objetivo;
    private $in_publico_asistente;
	private $dt_fecha_creacion;
	private $vc_observaciones;
    private $vc_quien_invita;

    private $array_area_artistica;
    private $array_artista_formador;
    private $array_clan;

    private $fk_evento;
    private $vc_transporte;
    private $vc_tecnica_produccion;
    private $vc_vestuario;
    private $vc_escenografia;
    private $vc_maquillaje;
    private $vc_alimentacion;
    private $vc_comunicaciones;


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
     * @return mixed
     */
    public function getPkIdEvento()
    {
        return $this->pk_id_evento;
    }

    /**
     * @param mixed $pk_id_evento
     *
     * @return self
     */
    public function setPkIdEvento($pk_id_evento)
    {
        $this->pk_id_evento = $pk_id_evento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkTipoEvento()
    {
        return $this->fk_tipo_evento;
    }

    /**
     * @param mixed $fk_tipo_evento
     *
     * @return self
     */
    public function setFkTipoEvento($fk_tipo_evento)
    {
        $this->fk_tipo_evento = $fk_tipo_evento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEstadoEvento()
    {
        return $this->estado_evento;
    }

    /**
     * @param mixed $estado_evento
     *
     * @return self
     */
    public function setEstadoEvento($estado_evento)
    {
        $this->estado_evento = $estado_evento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaInicio()
    {
        return $this->dt_fecha_inicio;
    }

    /**
     * @param mixed $dt_fecha_inicio
     *
     * @return self
     */
    public function setDtFechaInicio($dt_fecha_inicio)
    {
        $this->dt_fecha_inicio = $dt_fecha_inicio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaFin()
    {
        return $this->dt_fecha_fin;
    }

    /**
     * @param mixed $dt_fecha_fin
     *
     * @return self
     */
    public function setDtFechaFin($dt_fecha_fin)
    {
        $this->dt_fecha_fin = $dt_fecha_fin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcNombre()
    {
        return $this->vc_nombre;
    }

    /**
     * @param mixed $vc_nombre
     *
     * @return self
     */
    public function setVcNombre($vc_nombre)
    {
        $this->vc_nombre = $vc_nombre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkOrganizador()
    {
        return $this->fk_organizador;
    }

    /**
     * @param mixed $fk_organizador
     *
     * @return self
     */
    public function setFkOrganizador($fk_organizador)
    {
        $this->fk_organizador = $fk_organizador;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcLugar()
    {
        return $this->vc_lugar;
    }

    /**
     * @param mixed $vc_lugar
     *
     * @return self
     */
    public function setVcLugar($vc_lugar)
    {
        $this->vc_lugar = $vc_lugar;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcObjetivo()
    {
        return $this->vc_objetivo;
    }

    /**
     * @param mixed $vc_objetivo
     *
     * @return self
     */
    public function setVcObjetivo($vc_objetivo)
    {
        $this->vc_objetivo = $vc_objetivo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInPublicoAsistente()
    {
        return $this->in_publico_asistente;
    }

    /**
     * @param mixed $in_publico_asistente
     *
     * @return self
     */
    public function setInPublicoAsistente($in_publico_asistente)
    {
        $this->in_publico_asistente = $in_publico_asistente;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaCreacion()
    {
        return $this->dt_fecha_creacion;
    }

    /**
     * @param mixed $dt_fecha_creacion
     *
     * @return self
     */
    public function setDtFechaCreacion($dt_fecha_creacion)
    {
        $this->dt_fecha_creacion = $dt_fecha_creacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcObservaciones()
    {
        return $this->vc_observaciones;
    }

    /**
     * @param mixed $vc_observaciones
     *
     * @return self
     */
    public function setVcObservaciones($vc_observaciones)
    {
        $this->vc_observaciones = $vc_observaciones;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getArrayAreaArtistica()
    {
        return $this->array_area_artistica;
    }

    /**
     * @param mixed $array_area_artistica
     *
     * @return self
     */
    public function setArrayAreaArtistica($array_area_artistica)
    {
        $this->array_area_artistica = $array_area_artistica;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getArrayArtistaFormador()
    {
        return $this->array_artista_formador;
    }

    /**
     * @param mixed $array_artista_formador
     *
     * @return self
     */
    public function setArrayArtistaFormador($array_artista_formador)
    {
        $this->array_artista_formador = $array_artista_formador;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getArrayClan()
    {
        return $this->array_clan;
    }

    /**
     * @param mixed $array_clan
     *
     * @return self
     */
    public function setArrayClan($array_clan)
    {
        $this->array_clan = $array_clan;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVCQuienInvita()
    {
        return ($this->vc_quien_invita == NULL ? 'PROPIO' : $this->vc_quien_invita);
    }

    /**
     * @param mixed $quien_invita
     *
     * @return self
     */
    public function setVcQuienInvita($vc_quien_invita)
    {
        $this->vc_quien_invita = $vc_quien_invita;

        return $this;
    }

    /**
     * Obtiene el valor de FK_Evento
     * @return mixed
     */
    public function getFkEvento()
    {
            return $this->fk_evento;
    }

    /**
     * Asigna el valor para FK_Evento
     * @param mixed $fk_evento 
     */
    public function setFkEvento($fk_evento)
    {
            $this->fk_evento=$fk_evento;
    }

    /**
     * Obtiene el valor de VC_transporte
     * @return mixed
     */
    public function getVcTransporte()
    {
            return $this->vc_transporte;
    }

    /**
     * Asigna el valor para VC_transporte
     * @param mixed $vc_transporte 
     */
    public function setVcTransporte($vc_transporte)
    {
            $this->vc_transporte=$vc_transporte;
    }

    /**
     * Obtiene el valor de VC_tecnica_produccion
     * @return mixed
     */
    public function getVcTecnicaProduccion()
    {
            return $this->vc_tecnica_produccion;
    }

    /**
     * Asigna el valor para VC_tecnica_produccion
     * @param mixed $vc_tecnica_produccion 
     */
    public function setVcTecnicaProduccion($vc_tecnica_produccion)
    {
            $this->vc_tecnica_produccion=$vc_tecnica_produccion;
    }

    /**
     * Obtiene el valor de VC_vestuario
     * @return mixed
     */
    public function getVcVestuario()
    {
            return $this->vc_vestuario;
    }

    /**
     * Asigna el valor para VC_vestuario
     * @param mixed $vc_vestuario 
     */
    public function setVcVestuario($vc_vestuario)
    {
            $this->vc_vestuario=$vc_vestuario;
    }

    /**
     * Obtiene el valor de VC_escenografia
     * @return mixed
     */
    public function getVcEscenografia()
    {
            return $this->vc_escenografia;
    }

    /**
     * Asigna el valor para VC_escenografia
     * @param mixed $vc_escenografia 
     */
    public function setVcEscenografia($vc_escenografia)
    {
            $this->vc_escenografia=$vc_escenografia;
    }

    /**
     * Obtiene el valor de VC_maquillaje
     * @return mixed
     */
    public function getVcMaquillaje()
    {
            return $this->vc_maquillaje;
    }

    /**
     * Asigna el valor para VC_maquillaje
     * @param mixed $vc_maquillaje 
     */
    public function setVcMaquillaje($vc_maquillaje)
    {
            $this->vc_maquillaje=$vc_maquillaje;
    }

    /**
     * Obtiene el valor de VC_alimentacion
     * @return mixed
     */
    public function getVcAlimentacion()
    {
            return $this->vc_alimentacion;
    }

    /**
     * Asigna el valor para VC_alimentacion
     * @param mixed $vc_alimentacion 
     */
    public function setVcAlimentacion($vc_alimentacion)
    {
            $this->vc_alimentacion=$vc_alimentacion;
    }

    /**
     * Obtiene el valor de VC_comunicaciones
     * @return mixed
     */
    public function getVcComunicaciones()
    {
            return $this->vc_comunicaciones;
    }

    /**
     * Asigna el valor para VC_comunicaciones
     * @param mixed $vc_comunicaciones 
     */
    public function setVcComunicaciones($vc_comunicaciones)
    {
            $this->vc_comunicaciones=$vc_comunicaciones;
    }
}
