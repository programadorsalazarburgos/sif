<?php 
namespace  General\Persistencia\Entidades;
/**
 * Object que representa la tabla 'tb_nidos_evento_circulacion'
 *
 * @author: JUAN DAVID TORRES, gracias a http://phpdao.com
 * @date: 2018-06-12 04:33
 */
class TbNidosEventoCirculacion
{
	private $pk_id_evento;
	private $in_dia;
	private $dt_fecha_evento;
	private $vc_franja_atencion;
	private $vc_nombre_evento;
	private $fk_id_localidad;
	private $vc_entidad_dirigida;
	private $fk_id_usuario_solicita;
	private $fk_id_tipo_atencion;
	private $vc_otro_tipo_atencion;
	private $in_solicitud_equipos;
	private $in_cantidad_equipos;
	private $in_solicitud_informacion;
	private $in_tipo_poblacion;
	private $vc_tipo_atencion;
	private $fk_id_lugar_atencion;
	private $vc_contacto_lugar;
	private $in_gestor_asiste;
	private $fk_id_linea_atencion;
	private $vc_propuesta_atencion;
	private $in_ficha_tecnica;
	private $vc_transporte;
	private $vc_contacto_transporte;
	private $vc_hora_llegada_transporte;
	private $vc_artistas_locales;
	private $vc_particularidades_terreno;
	private $vc_acompanamiento_circulacion;
	private $vc_hora_llegada_artistas;
	private $vc_hora_montaje_nido;
	private $vc_hora_inicio_atencion;
	private $vc_hora_finalizacion;
	private $vc_ubicacion;
	private $vc_indicaciones_llegada;
	private $IN_Estado_Evento;
	private $vc_hora_montaje;
	private $vc_hora_desmontaje;
	private $vc_hora_experiencia_musical;
	private $in_num_ninos;
	private $in_num_adultos;
	private $in_num_artistas;
	private $in_num_grupos;
	private $in_espacio_publico;
	private $in_experiencias;
	private $in_cuidadores;
	private $vc_listado_asistencia;
	private $in_aprobacion;

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
	 * Obtiene el valor de pk_id_evento
	 * @return mixed
	 */
	public function getPkIdEvento()
	{
		return $this->pk_id_evento;
	}
	/**
	 * Asigna el valor para pk_id_evento
	 * @param mixed $pk_id_evento
	 */
	public function setPkIdEvento($pk_id_evento)
	{
		$this->pk_id_evento=$pk_id_evento;
	}
	/**
	 * Obtiene el valor de in_dia
	 * @return mixed
	 */
	public function getInDia()
	{
		return $this->in_dia;
	}
	/**
	 * Asigna el valor para in_dia
	 * @param mixed $in_dia
	 */
	public function setInDia($in_dia)
	{
		$this->in_dia=$in_dia;
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
	 * Obtiene el valor de vc_franja_atencion
	 * @return mixed
	 */
	public function getVcFranjaAtencion()
	{
		return $this->vc_franja_atencion;
	}
	/**
	 * Asigna el valor para vc_franja_atencion
	 * @param mixed $vc_franja_atencion
	 */
	public function setVcFranjaAtencion($vc_franja_atencion)
	{
		$this->vc_franja_atencion=$vc_franja_atencion;
	}
	/**
	 * Obtiene el valor de $vc_nombre_evento
	 * @return mixed
	 */
	public function getVcNombreEvento()
	{
		return $this->vc_nombre_evento;
	}
	/**
	 * Asigna el valor para $vc_nombre_evento
	 * @param mixed $vc_nombre_evento
	 */
	public function setVcNombreEvento($vc_nombre_evento)
	{
		$this->vc_nombre_evento=$vc_nombre_evento;
	}
	/**
	 * Obtiene el valor de $fk_id_localidad
	 * @return mixed
	 */
	public function getFkIdLocalidad()
	{
		return $this->fk_id_localidad;
	}
	/**
	 * Asigna el valor para $fk_id_localidad
	 * @param mixed $fk_id_localidad
	 */
	public function setFkIdLocalidad($fk_id_localidad)
	{
		$this->fk_id_localidad=$fk_id_localidad;
	}
	/**
	 * Obtiene el valor de vc_entidad_dirigida
	 * @return mixed
	 */
	public function getVcEntidadDirigida()
	{
		return $this->vc_entidad_dirigida;
	}
	/**
	 * Asigna el valor para vc_entidad_dirigida
	 * @param mixed $vc_entidad_dirigida
	 */
	public function setVcEntidadDirigida($vc_entidad_dirigida)
	{
		$this->vc_entidad_dirigida=$vc_entidad_dirigida;
	}

	/**
	 * Obtiene el valor de fk_id_usuario_solicita
	 * @return mixed
	 */
	public function getFkIdUsuarioSolicita()
	{
		return $this->fk_id_usuario_solicita;
	}
	/**
	 * Asigna el valor para fk_id_usuario_solicita
	 * @param mixed $fk_id_usuario_solicita
	 */
	public function setFkIdUsuarioSolicita($fk_id_usuario_solicita)
	{
		$this->fk_id_usuario_solicita=$fk_id_usuario_solicita;
	}
	/**
	 * Obtiene el valor de fk_id_tipo_atencion
	 * @return mixed
	 */
	public function getFkIdTipoAtencion()
	{
		return $this->fk_id_tipo_atencion;
	}
	/**
	 * Asigna el valor para fk_id_tipo_atencion
     * @param mixed $fk_id_tipo_atencion
     */
	public function setFkIdTipoAtencion($fk_id_tipo_atencion)
	{
		$this->fk_id_tipo_atencion=$fk_id_tipo_atencion;
	}
	/**
	 * Obtiene el valor de vc_otro_tipo_atencion
 	 * @return mixed
 	 */
	public function getVcOtroTipoAtencion()
	{
		return $this->vc_otro_tipo_atencion;
	}
	/**
 	* Asigna el valor para vc_otro_tipo_atencion
 	* @param mixed $vc_otro_tipo_atencion
 	*/
 	public function setVcOtroTipoAtencion($vc_otro_tipo_atencion)
 	{
 		$this->vc_otro_tipo_atencion=$vc_otro_tipo_atencion;
 	}
	/**
	 * Obtiene el valor de in_solicitud_equipos
	 * @return mixed
	 */
	public function getInSolicitudEquipos()
	{
		return $this->in_solicitud_equipos;
	}
	/**
	 * Asigna el valor para in_solicitud_equipos
	 * @param mixed $in_solicitud_equipos
	 */
	public function setInSolicitudEquipos($in_solicitud_equipos)
	{
		$this->in_solicitud_equipos=$in_solicitud_equipos;
	}
	/**
	 * Obtiene el valor de in_cantidad_equipos
	 * @return mixed
	 */
	public function getInCantidadEquipos()
	{
		return $this->in_cantidad_equipos;
	}
	/**
	 * Asigna el valor para in_cantidad_equipos
	 * @param mixed $in_cantidad_equipos
	 */
	public function setInCantidadEquipos($in_cantidad_equipos)
	{
		$this->in_cantidad_equipos=$in_cantidad_equipos;
	}
	/**
	 * Obtiene el valor de in_solicitud_informacion
	 * @return mixed
	 */
	public function getInSolicitudInformacion()
	{
		return $this->in_solicitud_informacion;
	}
	/**
	 * Asigna el valor para in_solicitud_informacion
	 * @param mixed $in_solicitud_informacion
	 */
	public function setInSolicitudInformacion($in_solicitud_informacion)
	{
		$this->in_solicitud_informacion=$in_solicitud_informacion;
	}
	/**
	 * Obtiene el valor de in_tipo_poblacion
	 * @return mixed
	 */
	public function getInTipoPoblacion()
	{
		return $this->in_tipo_poblacion;
	}
	/**
	 * Asigna el valor para in_tipo_poblacion
	 * @param mixed $in_tipo_poblacion
	 */
	public function setInTipoPoblacion($in_tipo_poblacion)
	{
		$this->in_tipo_poblacion=$in_tipo_poblacion;
	}
	/**
	 * Obtiene el valor de vc_tipo_atencion
	 * @return mixed
	 */
	public function getVcTipoAtencion()
	{
		return $this->vc_tipo_atencion;
	}
	/**
	 * Asigna el valor para vc_tipo_atencion
	 * @param mixed $vc_tipo_atencion
	 */
	public function setVcTipoAtencion($vc_tipo_atencion)
	{
		$this->vc_tipo_atencion=$vc_tipo_atencion;
	}
	/**
	 * Obtiene el valor de fk_id_lugar_atencion
	 * @return mixed
	 */
	public function getFkIdLugarAtencion()
	{
		return $this->fk_id_lugar_atencion;
	}
	/**
	 * Asigna el valor para fk_id_lugar_atencion
	 * @param mixed $fk_id_lugar_atencion
	 */
	public function setFkIdLugarAtencion($fk_id_lugar_atencion)
	{
		$this->fk_id_lugar_atencion=$fk_id_lugar_atencion;
	}
	/**
	 * Obtiene el valor de vc_contacto_lugar
	 * @return mixed
	 */
	public function getVcContactoLugar()
	{
		return $this->vc_contacto_lugar;
	}
	/**
	 * Asigna el valor para vc_contacto_lugar
	 * @param mixed $vc_contacto_lugar
	 */
	public function setVcContactoLugar($vc_contacto_lugar)
	{
		$this->vc_contacto_lugar=$vc_contacto_lugar;
	}
	/**
	 * Obtiene el valor de in_gestor_asiste
	 * @return mixed
	 */
	public function getInGestorAsiste()
	{
		return $this->in_gestor_asiste;
	}
	/**
	 * Asigna el valor para in_gestor_asiste
	 * @param mixed $in_gestor_asiste
	 */
	public function setInGestorAsiste($in_gestor_asiste)
	{
		$this->in_gestor_asiste=$in_gestor_asiste;
	}
	/**
	 * Obtiene el valor de fk_id_linea_atencion
	 * @return mixed
	 */
	public function getFkIdLineaAtencion()
	{
		return $this->fk_id_linea_atencion;
	}
	/**
	 * Asigna el valor para fk_id_linea_atencion
	 * @param mixed $fk_id_linea_atencion
	 */
	public function setFkIdLineaAtencion($fk_id_linea_atencion)
	{
		$this->fk_id_linea_atencion=$fk_id_linea_atencion;
	}
	/**
	 * Obtiene el valor de vc_propuesta_atencion
	 * @return mixed
	 */
	public function getVcPropuestaAtencion()
	{
		return $this->vc_propuesta_atencion;
	}
	/**
	 * Asigna el valor para vc_propuesta_atencion
	 * @param mixed $vc_propuesta_atencion
	 */
	public function setVcPropuestaAtencion($vc_propuesta_atencion)
	{
		$this->vc_propuesta_atencion=$vc_propuesta_atencion;
	}
	/**
	 * Obtiene el valor de in_ficha_tecnica
	 * @return mixed
	 */
	public function getInFichaTecnica()
	{
		return $this->in_ficha_tecnica;
	}
	/**
	 * Asigna el valor para in_ficha_tecnica
	 * @param mixed $in_ficha_tecnica
	 */
	public function setInFichaTecnica($in_ficha_tecnica)
	{
		$this->in_ficha_tecnica=$in_ficha_tecnica;
	}
	/**
	 * Obtiene el valor de vc_transporte
	 * @return mixed
	 */
	public function getVcTransporte()
	{
		return $this->vc_transporte;
	}
	/**
	 * Asigna el valor para vc_transporte
	 * @param mixed $vc_transporte
	 */
	public function setVcTransporte($vc_transporte)
	{
		$this->vc_transporte=$vc_transporte;
	}
	/**
	 * Obtiene el valor de vc_contacto_transporte
	 * @return mixed
	 */
	public function getVcContactoTransporte()
	{
		return $this->vc_contacto_transporte;
	}
	/**
	 * Asigna el valor para vc_contacto_transporte
	 * @param mixed $vc_contacto_transporte
	 */
	public function setVcContactoTransporte($vc_contacto_transporte)
	{
		$this->vc_contacto_transporte=$vc_contacto_transporte;
	}
	/**
	 * Obtiene el valor de vc_hora_llegada_transporte
	 * @return mixed
	 */
	public function getVcHoraLlegadaTransporte()
	{
		return $this->vc_hora_llegada_transporte;
	}
	/**
	 * Asigna el valor para vc_hora_llegada_transporte
	 * @param mixed $vc_hora_llegada_transporte
	 */
	public function setVcHoraLlegadaTransporte($vc_hora_llegada_transporte)
	{
		$this->vc_hora_llegada_transporte=$vc_hora_llegada_transporte;
	}
	/**
	 * Obtiene el valor de vc_artistas_locales
	 * @return mixed
	 */
	public function getvcArtistasLocales()
	{
		return $this->vc_artistas_locales;
	}
	/**
	 * Asigna el valor para vc_artistas_locales
	 * @param mixed $vc_artistas_locales
	 */
	public function setvcArtistasLocales($vc_artistas_locales)
	{
		$this->vc_artistas_locales=$vc_artistas_locales;
	}
	/**
	 * Obtiene el valor de vc_particularidades_terreno
	 * @return mixed
	 */
	public function getVcParticularidadesTerreno()
	{
		return $this->vc_particularidades_terreno;
	}
	/**
	 * Asigna el valor para vc_particularidades_terreno
	 * @param mixed $vc_particularidades_terreno
	 */
	public function setVcParticularidadesTerreno($vc_particularidades_terreno)
	{
		$this->vc_particularidades_terreno=$vc_particularidades_terreno;
	}
	/**
	 * Obtiene el valor de vc_acompanamiento_circulacion
	 * @return mixed
	 */
	public function getVcAcompanamientoCirculacion()
	{
		return $this->vc_acompanamiento_circulacion;
	}
	/**
	 * Asigna el valor para vc_acompanamiento_circulacion
	 * @param mixed $vc_acompanamiento_circulacion
	 */
	public function setVcAcompanamientoCirculacion($vc_acompanamiento_circulacion)
	{
		$this->vc_acompanamiento_circulacion=$vc_acompanamiento_circulacion;
	}
	/**
	 * Obtiene el valor de vc_hora_llegada_artistas
	 * @return mixed
	 */
	public function getVcHoraLlegadaArtistas()
	{
		return $this->vc_hora_llegada_artistas;
	}
	/**
	 * Asigna el valor para vc_hora_llegada_artistas
	 * @param mixed $vc_hora_llegada_artistas
	 */
	public function setVcHoraLlegadaArtistas($vc_hora_llegada_artistas)
	{
		$this->vc_hora_llegada_artistas=$vc_hora_llegada_artistas;
	}
	/**
	 * Obtiene el valor de vc_hora_montaje_nido
	 * @return mixed
	 */
	public function getVcHoraMontajeNido()
	{
		return $this->vc_hora_montaje_nido;
	}
	/**
	 * Asigna el valor para vc_hora_montaje_nido
	 * @param mixed $vc_hora_montaje_nido
	 */
	public function setVcHoraMontajeNido($vc_hora_montaje_nido)
	{
		$this->vc_hora_montaje_nido=$vc_hora_montaje_nido;
	}
	/**
	 * Obtiene el valor de vc_hora_inicio_atencion
	 * @return mixed
	 */
	public function getVcHoraInicioAtencion()
	{
		return $this->vc_hora_inicio_atencion;
	}
	/**
	 * Asigna el valor para vc_hora_inicio_atencion
	 * @param mixed $vc_hora_inicio_atencion
	 */
	public function setVcHoraInicioAtencion($vc_hora_inicio_atencion)
	{
		$this->vc_hora_inicio_atencion=$vc_hora_inicio_atencion;
	}
	/**
	 * Obtiene el valor de vc_hora_finalizacion
	 * @return mixed
	 */
	public function getVcHoraFinalizacion()
	{
		return $this->vc_hora_finalizacion;
	}
	/**
	 * Asigna el valor para vc_hora_finalizacion
	 * @param mixed $vc_hora_finalizacion
	 */
	public function setVcHoraFinalizacion($vc_hora_finalizacion)
	{
		$this->vc_hora_finalizacion=$vc_hora_finalizacion;
	}
	
	/**
	 * Obtiene el valor de vc_ubicacion
	 * @return mixed
	 */
	public function getVcUbicacion()
	{
		return $this->vc_ubicacion;
	}
	/**
	 * Asigna el valor para vc_ubicacion
	 * @param mixed vc_ubicacion
	 */
	public function setVcUbicacion($vc_ubicacion)
	{
		$this->vc_ubicacion=$vc_ubicacion;
	}
	
	/**
	 * Obtiene el valor de vc_indicaciones_llegada
	 * @return mixed
	 */
	public function getVcIndicacionesLlegada()  
	{
		return $this->vc_indicaciones_llegada;
	}
	/**
	 * Asigna el valor para vc_indicaciones_llegada
	 * @param mixed vc_indicaciones_llegada
	 */
	public function setVcIndicacionesLlegada($vc_indicaciones_llegada)
	{
		$this->vc_indicaciones_llegada=$vc_indicaciones_llegada;
	}
	
	/**
	 * Obtiene el valor de IN_Estado_Evento
	 * @return mixed
	 */
	public function getInEstadoEvento()
	{
		return $this->IN_Estado_Evento;
	}
	/**
	 * Asigna el valor para IN_Estado_Evento
	 * @param mixed IN_Estado_Evento
	 */
	public function setInEstadoEvento($IN_Estado_Evento)
	{
		$this->IN_Estado_Evento=$IN_Estado_Evento;
	}
	
	/**
	 * Obtiene el valor de vc_hora_montaje
	 * @return mixed
	 */
	public function getVcHoraMontaje()
	{
		return $this->vc_hora_montaje;
	}
	/**
	 * Asigna el valor para vc_hora_montaje
	 * @param mixed vc_hora_montaje
	 */
	public function setVcHoraMontaje($vc_hora_montaje)
	{
		$this->vc_hora_montaje=$vc_hora_montaje;
	}
	
	/**
	 * Obtiene el valor de vc_hora_desmontaje
	 * @return mixed
	 */
	public function getVcHoraDesmontaje()
	{
		return $this->vc_hora_desmontaje;
	}
	/**
	 * Asigna el valor para vc_hora_desmontaje
	 * @param mixed vc_hora_desmontaje
	 */
	public function setVcHoraDesmontaje($vc_hora_desmontaje)
	{
		$this->vc_hora_desmontaje=$vc_hora_desmontaje;
	}
	
	/**
	 * Obtiene el valor de vc_hora_experiencia_musical
	 * @return mixed
	 */
	public function getVcHoraExperienciaMusical()
	{
		return $this->vc_hora_experiencia_musical;
	}
	/**
	 * Asigna el valor para vc_hora_experiencia_musical
	 * @param mixed vc_hora_experiencia_musical
	 */
	public function setVcHoraExperienciaMusical($vc_hora_experiencia_musical)
	{
		$this->vc_hora_experiencia_musical=$vc_hora_experiencia_musical;
	}
	/**
	 * Obtiene el valor de $in_num_ninos
	 * @return mixed
	 */
	public function getInNumNinos()
	{
		return $this->in_num_ninos;
	}
	/**
	 * Asigna el valor para in_num_ninos
	 * @param mixed in_num_ninos
	 */
	public function setInNumNinos($in_num_ninos)
	{
		$this->in_num_ninos=$in_num_ninos;
	}
	/**
	 * Obtiene el valor de in_num_adultos
	 * @return mixed
	 */
	public function getInNumAdultos()
	{
		return $this->in_num_adultos;
	}
	/**
	 * Asigna el valor para in_num_adultos
	 * @param mixed in_num_adultos
	 */
	public function setInNumAdultos($in_num_adultos)
	{
		$this->in_num_adultos=$in_num_adultos;
	}
	/**
	 * Obtiene el valor de in_num_artistas
	 * @return mixed
	 */
	public function getInNumaAtistas()
	{
		return $this->in_num_artistas;
	}
	/**
	 * Asigna el valor para in_num_artistas
	 * @param mixed in_num_artistas
	 */
	public function setInNumaAtistas($in_num_artistas)
	{
		$this->in_num_artistas=$in_num_artistas;
	}
	/**
	 * Obtiene el valor de in_num_grupos
	 * @return mixed
	 */
	public function getInNumGrupos()
	{
		return $this->in_num_grupos;
	}
	/**
	 * Asigna el valor para in_num_grupos
	 * @param mixed in_num_grupos
	 */
	public function setInNumGrupos($in_num_grupos)
	{
		$this->in_num_grupos=$in_num_grupos;
	}
	/**
	 * Obtiene el valor de in_espacio_publico
	 * @return mixed
	 */
	public function getInEspacioPublico()
	{
		return $this->in_espacio_publico;
	}
	/**
	 * Asigna el valor para in_espacio_publico
	 * @param mixed in_espacio_publico
	 */
	public function setInEspacioPublico($in_espacio_publico)
	{
		$this->in_espacio_publico=$in_espacio_publico;
	}
	/**
	 * Obtiene el valor de in_experiencias
	 * @return mixed
	 */
	public function getInExperiencias()
	{
		return $this->in_experiencias;
	}
	/**
	 * Asigna el valor para in_experiencias
	 * @param mixed in_experiencias
	 */
	public function setInExperiencias($in_experiencias)
	{
		$this->in_experiencias=$in_experiencias;
	}
	
	/**
	 * Obtiene el valor de in_cuidadores
	 * @return mixed
	 */
	public function getInCuidadores()
	{
		return $this->in_cuidadores;
	}
	/**
	 * Asigna el valor para in_cuidadores
	 * @param mixed in_cuidadores
	 */
	public function setInCuidadores($in_cuidadores)
	{
		$this->in_cuidadores=$in_cuidadores;
	}
	
	/**
	 * Obtiene el valor de vc_listado_asistencia
	 * @return mixed
	 */
	public function getVcListadoAsistencia()
	{
		return $this->vc_listado_asistencia;
	}
	/**
	 * Asigna el valor para vc_listado_asistencia
	 * @param mixed vc_listado_asistencia
	 */
	public function setVcListadoAsistencia($vc_listado_asistencia)
	{
		$this->vc_listado_asistencia=$vc_listado_asistencia;
	}
	
	/**
	 * Obtiene el valor de in_aprobacion
	 * @return mixed
	 */
	public function getInAprobacion()
	{
		return $this->in_aprobacion;
	}
	/**
	 * Asigna el valor para in_aprobacion
	 * @param mixed in_aprobacion
	 */
	public function setInAprobacion($in_aprobacion)
	{
		$this->in_aprobacion=$in_aprobacion;
	}

}
