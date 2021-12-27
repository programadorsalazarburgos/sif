<?php

namespace ArtistaFormador\Controlador;
error_reporting(E_ERROR);
// ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use ArtistaFormador\Controlador\ArtistaFormadorFactory;

class RegistrarAsistenciaController extends ArtistaFormadorFactory
{
	/**
	 * @var Container
	 *
	 */
	// private /*static*/ $contenedor;
	function __construct()
	{
 		parent::__construct();
		$this->initializeFactory();
 	}

 	public function guardarSesionClase($datos,$tipo_grupo){
 		$sesionClaseDAO = $this->contenedor['SesionClaseDAO'];
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$tb_sesion_clase = $this->contenedor['TbTerrGrupoSesionClase'];

 		$horario_grupo = $GrupoDAO->consultarHorarioGrupo($datos['id_grupo'],$tipo_grupo["tipo_grupo"]);
 		$hora_inicio = "";
 		$hora_fin = "";
 		$dia_semana_actual = date("w",strtotime($datos['fecha_clase']));
 		foreach ($horario_grupo as $h) {
 			if($dia_semana_actual == $h['IN_dia']){	
 				$hora_inicio = $h['TI_hora_inicio_clase'];
 				$hora_fin = $h['TI_hora_fin_clase'];
 			}
 		}

 		$tb_sesion_clase->setPkSesionClase(0);
 		$tb_sesion_clase->setFkGrupo($datos['id_grupo']);
 		$tb_sesion_clase->setDaFechaClase($datos['fecha_clase']);
 		$tb_sesion_clase->setDtFechaCreacionRegistro(date('Y-m-d H:i:s'));
 		$tb_sesion_clase->setInHorasClase($datos['horas_sesion_clase']);
        $tb_sesion_clase->setFkSalon($datos['fk_salon']);
 		$tb_sesion_clase->setTxObservaciones($datos['observaciones']);
 		$tb_sesion_clase->setSuplencia($datos['suplencia']);
		$tb_sesion_clase->setinModalidadAtencion($datos['modalidad_atencion']);
		$tb_sesion_clase->setInTipoAtencion($datos['tipo_atencion']);
		$tb_sesion_clase->setInMaterial($datos['material']);
 		if($datos['suplencia'] == 1){
            $tb_sesion_clase->setFkOrganizacion($datos['organizacion_artista_formador']);
 			//$tb_sesion_clase->setFkOrganizacion($this->getOrganizacionUsuario($datos['id_usuario'],$datos['id_rol']));
 		}else{
 			$tb_sesion_clase->setFkOrganizacion($this->getOrganizacionGrupo($datos["id_grupo"],$tipo_grupo["tipo_grupo"]));
 		}
 		$tb_sesion_clase->setTipoGrupo($tipo_grupo['tipo_grupo']);
 		$tb_sesion_clase->setEstudianteArray(json_decode($datos["CH_asistencia_estudiante"]));
		$tb_sesion_clase->setAtencionArray(json_decode($datos["CH_tipo_atencion_estudiante"]));

 		$dato_adicional = $sesionClaseDAO->consultarDatosAdicionalesGrupo($datos['id_grupo'],$tipo_grupo['tipo_grupo'])[0];
 		$tb_sesion_clase->setFkClan($dato_adicional['FK_Clan']);
 		$tb_sesion_clase->setVcNomClan($dato_adicional['VC_Nom_Clan']);
 		$tb_sesion_clase->setFkAreaArtistica($dato_adicional['FK_area_artistica']);

 		// ARTE EN LA ESCUELA
 		@$tb_sesion_clase->setFkColegio($dato_adicional['FK_Colegio']);
 		@$tb_sesion_clase->setVcNomColegio($dato_adicional['VC_Nom_colegio']);
 		@$tb_sesion_clase->setInLugarAtencion($datos['lugar_atencion']);
 		// IMPULSO COLECTIVO
 		@$tb_sesion_clase->setFkModalidad($dato_adicional['FK_modalidad']);
 		// CONVERGE
 		@$tb_sesion_clase->setTipoPoblacion($dato_adicional['tipo_poblacion']);
 		@$tb_sesion_clase->setFkLugarAtencion($dato_adicional['FK_lugar_atencion']);
        @$tb_sesion_clase->setFkInstitucion($dato_adicional['FK_Institucion']);
        @$tb_sesion_clase->setFkAliado($dato_adicional['FK_Aliado']);
        @$tb_sesion_clase->setInTipoUbicacion($datos['lugar_atencion']);
        if($tipo_grupo['tipo_grupo'] == "laboratorio_clan"  && $datos['lugar_atencion'] == 4){
            @$tb_sesion_clase->setTxSitio("CREA EN CASA");
        }else{
            @$tb_sesion_clase->setTxSitio($dato_adicional['TX_Sitio']);
        }
 		/*******      PARA TODOS        ************/
            // Cuando es artista formador quien registra
            // if($datos['id_rol'] == 1 || $datos['id_rol'] == 15){
            if($datos['id_rol'] == 1){
                $PersonaDAO = $this->contenedor['PersonaDAO'];
                $tipo_artista_texto = $PersonaDAO->consultarIDUltimoTipoArtistaUsuario($datos['id_usuario']);
                $tb_sesion_clase->setFkUsuario($datos['id_usuario']);
                if($tipo_grupo["tipo_grupo"] != "laboratorio_clan"){
                    @$tb_sesion_clase->setTipoGrupoAtencion($tipo_artista_texto[0]['tipo_artista']);
                }else{
                    $tipo_grupo_ahora = $GrupoDAO->consultarTipoAtencionGrupo($datos['id_grupo'],'laboratorio_clan');
                    @$tb_sesion_clase->setTipoGrupoAtencion($tipo_grupo_ahora['tipo_grupo']);
                }
            } // Equipo CREAENCASA //
            else{
                $PersonaDAO = $this->contenedor['PersonaDAO'];
                $nombre_usuario_registra = $PersonaDAO->consultarNombrePersona($datos['id_usuario']);
                @$tb_sesion_clase->setTxSitio("CREA EN CASA");
                
                $tb_sesion_clase->setFkUsuario($datos['id_artista_formador_titular_grupo']);
                $tb_sesion_clase->setSuplencia('0');
                @$tb_sesion_clase->setTipoGrupoAtencion('DIRECTO');
                $tb_sesion_clase->setTxObservaciones('Basado en registro de asistencia creaencasa.idartes.gov.co - Usuario: '.$nombre_usuario_registra.' '.$tb_sesion_clase->getTxObservaciones());
            }
        /*if ($tipo_grupo["tipo_grupo"] == 'laboratorio_clan') {
            @$tb_sesion_clase->setTipoGrupoAtencion($dato_adicional['tipo_grupo']);
        }*/
 		@$tb_sesion_clase->setHoraInicio($hora_inicio);
 		@$tb_sesion_clase->setHoraFin($hora_fin);
        $datos_validacion = array('id_grupo' => $tb_sesion_clase->getFkGrupo(),'fecha_clase' => $tb_sesion_clase->getDaFechaClase());
        $datos_tipo_grupo = array('tipo_grupo' => $tb_sesion_clase->getTipoGrupo());
        if($tb_sesion_clase->getTipoGrupo() == 'arte_escuela'){
            $tb_sesion_clase->setHoraInicio('00:00');
            $tb_sesion_clase->setHoraFin('00:00');
		}
		@$tb_sesion_clase->setTxSitio("CREA EN CASA");
		switch($datos['tipo_grupo']){
			case 'arte_escuela':
			case 'laboratorio_clan':
				// $dato_adicional['id_lugar_atencion'] = 4;
				$tb_sesion_clase->setInLugarAtencion(4);
				$tb_sesion_clase->setInTipoUbicacion(4);
				break;
			case 'emprende_clan':
				$tb_sesion_clase->setInTipoUbicacion(3);
				// $dato_adicional['id_lugar_atencion'] = 3;
				break;
			default:
				break;
		}

        echo $sesionClaseDAO->crearRegistroSesionClase($tb_sesion_clase,$datos['id_usuario']);

    }

    public function guardarSesionClaseEvento($datos,$array_estudiante){
    	if(!($this->eventoEsDistrital($datos['tipo_evento']))){
			$array_ajustado = array();
			for ($i=0; $i < sizeof($array_estudiante); $i++) {
				if(($array_estudiante[$i][1]))
					array_push($array_ajustado, $array_estudiante[$i]);
			}
    	}else{
    		$array_ajustado = $array_estudiante;
            $EventoDAO = $this->contenedor['EventoDAO'];
            foreach ($array_estudiante as $e) {
                $datos_actualizar_estudiante_evento = array('id_estudiante' => $e[0],'id_evento' => $datos['id_evento'],'estado' => $e[1], 'observaciones' => $datos['observaciones'], 'id_usuario' => $datos['id_usuario']);
                $EventoDAO->actualizarEstadoAsistenciaEstudianteEvento($datos_actualizar_estudiante_evento);
            }
    	}
 		$sesionClaseDAO = $this->contenedor['SesionClaseDAO'];
 		echo $sesionClaseDAO->guardarSesionClaseEvento($datos,$array_ajustado);
    }

    public function modificarSesionClase($datos,$tipo_grupo){
    	$sesionClaseDAO = $this->contenedor['SesionClaseDAO'];
 		$tb_sesion_clase = $this->contenedor['TbTerrGrupoSesionClase'];
        $dato_adicional = $sesionClaseDAO->consultarDatosAdicionalesGrupo($datos['id_grupo'],$tipo_grupo['tipo_grupo'])[0];
 		$tb_sesion_clase->setPkSesionClase($datos['id_sesion_clase']);
 		$tb_sesion_clase->setFkGrupo(0);
 		$tb_sesion_clase->setDaFechaClase(0);
 		$tb_sesion_clase->setDtFechaCreacionRegistro(0);
 		$tb_sesion_clase->setInHorasClase(0);
 		$tb_sesion_clase->setFkUsuario($datos['id_usuario']);
 		$tb_sesion_clase->setTxObservaciones($datos['observaciones'].": (Asistencia modificada el ".date('Y-m-d H:i:s')." por usuario.)");
 		$tb_sesion_clase->setSuplencia(0);
 		$tb_sesion_clase->setTipoGrupo($tipo_grupo['tipo_grupo']);
 		$tb_sesion_clase->setEstudianteArray(json_decode($datos["CH_asistencia_estudiante"]));
		$tb_sesion_clase->setAtencionArray(json_decode($datos["CH_tipo_atencion_estudiante"]));
		$tb_sesion_clase->setinModalidadAtencion($datos['modalidad_atencion']);
		$tb_sesion_clase->setInTipoAtencion($datos['tipo_atencion']);
		$tb_sesion_clase->setInMaterial($datos['material']);
        if($tipo_grupo['tipo_grupo'] == "arte_escuela") $tb_sesion_clase->setInLugarAtencion($datos['lugar_atencion']);
        if($tipo_grupo['tipo_grupo'] == "emprende_clan") $tb_sesion_clase->setInTipoUbicacion($datos['lugar_atencion']);
        if($tipo_grupo['tipo_grupo'] == "laboratorio_clan") $tb_sesion_clase->setInTipoUbicacion($datos['lugar_atencion']);
        $tb_sesion_clase->setFkSalon($datos['fk_salon']);
        if($tipo_grupo['tipo_grupo'] == "laboratorio_clan"  && $datos['lugar_atencion'] == 4){
            $tb_sesion_clase->setTxSitio("REMOTO");
        }else{
            $tb_sesion_clase->setTxSitio($dato_adicional['TX_Sitio']);
        }
 		echo $sesionClaseDAO->modificarObjeto($tb_sesion_clase);
    }

    public function eliminarSesionClase($datos,$tipo_grupo){
 		$sesionClaseDAO = $this->contenedor['SesionClaseDAO'];
 		$tb_sesion_clase = $this->contenedor['TbTerrGrupoSesionClase'];
 		$tb_sesion_clase->setPkSesionClase($datos['id_sesion_clase']);
 		$tb_sesion_clase->setFkUsuario($datos['id_usuario']);
 		$tb_sesion_clase->setTipoGrupo($tipo_grupo['tipo_grupo']);
 		$sesionClaseDAO->eliminarObjeto($tb_sesion_clase);
 	}

 	public function consultarGruposUsuario($id_usuario,$tipo_grupo){
        $GrupoDAO = $this->contenedor['GrupoDAO'];
        $grupos = $GrupoDAO->consultarGruposUsuario($id_usuario['id_usuario'],$tipo_grupo['tipo_grupo']);
        $tipo_grupo_acronimo = '';
 		switch ($tipo_grupo['tipo_grupo']) {
 			case 'arte_escuela':
 				$tipo_grupo_acronimo = "AE";
 				$tipo_grupo_texto = "ARTE EN LA ESCUELA";
 				break;
 			case 'emprende_clan':
 				$tipo_grupo_acronimo = "IC";
 				$tipo_grupo_texto = "IMPULSO COLECTIVO";
 				break;
 			case 'laboratorio_clan':
 				$tipo_grupo_acronimo = "CV";
 				$tipo_grupo_texto = "CONVERGE";
 				break;
 			default:
 				$tipo_grupo_acronimo = "NN";
 				$tipo_grupo_texto = "No Conocido";
 				break;
 		}

        $vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupo'=>$grupos,
			'tipo_grupo_acronimo'=>$tipo_grupo_acronimo,
			'tipo_grupo'=>$tipo_grupo['tipo_grupo'],'tipo_grupo_texto'=>$tipo_grupo_texto));
		$vista->renderHtml();
    }

    public function validarFechaSesionClase($datos,$tipo_grupo){
    	$sesionClaseDAO = $this->contenedor['SesionClaseDAO'];
    	$fecha = $sesionClaseDAO->validarFechaSesionClase($datos['id_grupo'],$datos['fecha_clase'],$tipo_grupo['tipo_grupo']);
    	if(isset($fecha[0]['FK_grupo'])){
    		echo 1;
    	}else{
    		echo 0;
    	}
    }

    public function consultarEstudiantesAsistenciaSesionClase($datos,$tipo_grupo){
    	$SesionClaseDAO = $this->contenedor['SesionClaseDAO'];
    	$estudiante = $SesionClaseDAO->consultarEstudiantesActivosGrupoAsistenciaSesionClase($datos['id_sesion_clase'],$datos['id_grupo_modificar'],$tipo_grupo['tipo_grupo']);
    	$vista= $this->contenedor['vista'];
		$vista->setVariables(array('estudiante'=>$estudiante,'tipo_sesion_clase'=>$datos['tipo_sesion_clase']));
		$vista->setPlantilla("datosEstudianteBase");
		$vista->renderHtml();

    }

    public function consultarEstudiantesPorEstadoGrupo($datos,$tipo_grupo){
    	$grupo = $this->contenedor['GrupoDAO'];
 		$estudiante = $grupo->consultarEstudiantesPorEstadoGrupo($datos['id_grupo'],$tipo_grupo['tipo_grupo'],$datos['estado']);
 		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('estudiante'=>$estudiante,'tipo_sesion_clase'=>$datos['tipo_sesion_clase'],'id_grupo'=>$datos['id_grupo'],'tipo_grupo'=>$tipo_grupo['tipo_grupo']));
		$vista->setPlantilla("datosEstudianteBase");
		$vista->renderHtml();
    }

    public function consultarTodosEstudiantesGrupo($id_grupo,$tipo_grupo){
    	$grupo = $this->contenedor['GrupoDAO'];
 		$estudiante = $grupo->consultarTodosEstudiantesGrupo($id_grupo['id_grupo'],$tipo_grupo['tipo_grupo']);
 		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('estudiante'=>$estudiante));
		$vista->setPlantilla("datosEstudianteBase");
		$vista->renderHtml();
    }

    public function consultarObservacionSesionClase($id_sesion_clase,$tipo_grupo){
        $sesionClaseDAO = $this->contenedor['SesionClaseDAO'];
        $observacion = $sesionClaseDAO->consultarObservacionSesionClase($id_sesion_clase['id_sesion_clase'],$tipo_grupo['tipo_grupo']);
        echo $observacion[0]['TX_observaciones'];
    }

    public function consultarGruposParaModificar($id_usuario){
    	$return = "<optgroup label='Mis Grupos'>";
		$mis_grupos = "";
		$grupos_suplencia = "";
		$fecha = $this->obtenerFechaInicialGruposModificar();
		$return = "<optgroup label='Mis Sesiones de clase'>";
		$mis_grupos = "";
		$grupos_suplencia = "";
		$tipo_grupo = ['arte_escuela','emprende_clan','laboratorio_clan'];
		$tipo_grupo_acronimo = ['AE','IC','CV'];
		$sesionClaseDAO = $this->contenedor['SesionClaseDAO'];
		for ($i=0; $i < sizeof($tipo_grupo); $i++) {
			$grupo = $sesionClaseDAO->consultarGruposMisSesionesMes($id_usuario['id_usuario'],$fecha,$tipo_grupo[$i]);
            // echo ($id_usuario['id_usuario']."   ----   ".$fecha."   ----   ".$tipo_grupo[$i]);
			foreach ($grupo as $g){
				if ($g['suplencia'] == 0) {
					$mis_grupos .= "<option value='".$g['FK_Grupo']."' data-tipo_grupo='".$tipo_grupo[$i]."' data-tipo_ubicacion='".$g['tipo_ubicacion']."' data-crea='".$g['FK_clan']."'>".$tipo_grupo_acronimo[$i]."-".$g['FK_Grupo']."</option>";
				}else{
					$grupos_suplencia .= "<option value='".$g['FK_Grupo']."' data-tipo_grupo='".$tipo_grupo[$i]."' data-tipo_ubicacion='".$g['tipo_ubicacion']."' data-crea='".$g['FK_clan']."'>".$tipo_grupo_acronimo[$i]."-".$g['FK_Grupo']."</option>";
				}
			}
		}

		$return .= $mis_grupos;
		$return .= "</optgroup><optgroup label='Suplencias'>";
		$return .= $grupos_suplencia;
		$return .= "</optgroup>";

		echo $return;
    }

    public function consultarFechaSesionGrupoParaModificar($datos,$tipo_grupo){
    	$return = "";
		$fecha = $this->obtenerFechaInicialGruposModificar();

		$sesionClaseDAO = $this->contenedor['SesionClaseDAO'];
		$sesion_clase = $sesionClaseDAO->consultarFechaSesionGrupoParaModificar($datos['id_grupo'],$datos['id_usuario'],$tipo_grupo['tipo_grupo'],$fecha);
		foreach ($sesion_clase as $s) {
			$return .= "<option data-tipo_grupo='".$tipo_grupo['tipo_grupo']."' data-tipo_ubicacion='".$s['tipo_ubicacion']."' data-modalidad='".$s['IN_Modalidad_Atencion']."' data-tipo_atencion='".$s['IN_Tipo_Atencion']."' data-salon='".$s['FK_salon']."' value='".$s['PK_sesion_clase']."'>".$s['DA_fecha_clase']."</option>";
		}
		echo $return;
    }

    public function consultarHorasDeClaseDia($datos,$tipo_grupo){
 		$grupo = $this->contenedor['GrupoDAO'];
        $horas_clase = 0;
 		$horas_clase = $grupo->consultarHorasDeClaseDia($datos['id_grupo'],$datos['fecha_sesion'],$tipo_grupo['tipo_grupo'])[0]['HORAS'];
 		echo $horas_clase;
 	}

 	public function consultarHorarioGrupo($id_grupo,$tipo_grupo){
 		$horas_clase = 0;
		$horario_clase = "";
 		$grupo = $this->contenedor['GrupoDAO'];
 		$horario = $grupo->consultarHorarioGrupo($id_grupo['id_grupo'],$tipo_grupo['tipo_grupo']);
		foreach ($horario as $h) {
			$horas_clase += $h['TI_hora_fin_clase'] - $h['TI_hora_inicio_clase'];
			$horario_clase .= $this->extraerDatosHorarioClase($h['IN_dia'],$h['TI_hora_inicio_clase'],$h['TI_hora_fin_clase']);
		}
 		echo json_encode(array('horas_clase' => $horas_clase,'horario_clase' => $horario_clase));
 	}

 	public function consultarDiasClaseGrupo($id_grupo,$tipo_grupo){
 		$grupo = $this->contenedor['GrupoDAO'];
 		$horario = $grupo->consultarHorarioGrupo($id_grupo['id_grupo'],$tipo_grupo['tipo_grupo']);
 		$array = array();
		foreach ($horario as $h) {
			array_push($array, $h['IN_dia']);
		}
		echo json_encode($array);
 	}

 	public function consultarIDCoorinadorActualClanGrupo($datos){
 		$grupo = $this->contenedor['GrupoDAO'];
 		$id_coordinador = $grupo->consultarIDCoorinadorActualClanGrupo($datos['id_grupo'],$datos['tipo_grupo']);
 		echo $id_coordinador[0]['FK_Persona_Administrador'];
 	}

 	public function consultarArtistasFormadoresDeGruposActivos($datos){
 		$GrupoDAO = $this->contenedor['GrupoDAO'];
 		$artista_formador = $GrupoDAO->consultarArtistasFormadoresDeGruposActivos($datos['id_usuario_actual']);
 		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('artista_formador'=>$artista_formador));
		$vista->setPlantilla("getOptionsArtistasFormadoresConGruposActivos");
		$vista->renderHtml();
 	}

 	public function consultarDiaInicioHabilitarRegistroSesionClase(){
        $ParametroDAO = $this->contenedor['ParametroDAO'];;
        $dias_subsanacion = $ParametroDAO->getParametroDetalle(44);
        $dias_fin_mes = $dias_subsanacion[0]['FK_Value'];
        $dias_inicio_mes = $dias_subsanacion[1]['FK_Value'];
    	date_default_timezone_set('America/Bogota');
    	$fecha_ultimo_dia_mes = new \DateTime();
		$fecha_ultimo_dia_mes->modify('last day of this month');
        $fecha_inicio_subsancion_fin_mes = $fecha_ultimo_dia_mes->format('d') - $dias_fin_mes +1;
        $fecha = date('Y-m-d');
        // echo "subsanación al final desde el día: ".$fecha_inicio_subsancion_fin_mes;
        // echo "Días de mes al inicio para subsanar: ".$dias_inicio_mes;
        if((date("d") >= $fecha_inicio_subsancion_fin_mes) && ($dias_fin_mes != 0)){
            $fecha = strtotime( '-'.(intval(date("d")) - 1).' day' , strtotime( $fecha ) );
        }else if(date("d") <= $dias_inicio_mes){
            $fecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
            $fecha = date ( 'Y-m-d' , $fecha );
            $fecha = strtotime( '-'.(intval(date("d")) - 1).' day' , strtotime( $fecha ) );
        }else{
            $fecha = strtotime ( '-0 day' , strtotime ( $fecha ) ) ;
        }
        $fecha = date ( 'Y-m-d' , $fecha );
        // echo $fecha;
		echo "2021-09-01";
    }

    public function consultarFechaInicioYFechaFinEvento($datos){
    	$EventoDAO = $this->contenedor['EventoDAO'];
    	$fecha = $EventoDAO->consultarFechaInicioYFechaFinEvento($datos['id_evento']);
    	echo json_encode($fecha);
    }

    public function consultarEstudiantesGrupoActivosEnEvento($datos){
    	// Si el evento es tipo muestra
    	if(!$this->eventoEsDistrital($datos['tipo_evento'])){
    		$GrupoDAO = $this->contenedor['GrupoDAO'];
    		$estudiante = $GrupoDAO->consultarEstudiantesPorEstadoGrupo($datos['id_grupo'],$datos['tipo_grupo'],1);
        }else{
    	// Si el evento es grande - Distrital (Festival y Campus)
    		$EventoDAO = $this->contenedor['EventoDAO'];
	    	$estudiante = $EventoDAO->consultarEstudiantesGrupoActivosEnEvento($datos['tipo_grupo'],$datos['id_evento'],$datos['id_grupo']);
    	}
    	$vista= $this->contenedor['vista'];
		$vista->setVariables(array('estudiante'=>$estudiante,'tipo_sesion_clase'=>$datos['tipo_sesion_clase']));
		$vista->setPlantilla("datosEstudianteBase");
		$vista->renderHtml();
    }

    public function validarFechaSesionClaseEvento($datos){
    	$EventoDAO = $this->contenedor['EventoDAO'];
    	$fecha = $EventoDAO->validarFechaSesionClaseEvento($datos['id_evento'],$datos['id_grupo'],$datos['fecha_clase'],$datos['tipo_grupo']);
    	if(isset($fecha[0]['FK_grupo'])){
    		echo 1;
    	}else{
    		echo 0;
    	}
    }

    public function consultarOptionsSesionesRegistradasEnEventoPorArtistaFormador($datos){
    	$return = "";
    	$tipo_grupo_acronimo = array('arte_escuela' => 'AE','emprende_clan' => 'EC', 'laboratorio_clan' => 'LC' );
    	$EventoDAO = $this->contenedor['EventoDAO'];
    	$sesion_clase_evento = $EventoDAO->consultarFechaSesionClaseEventoMesUsuario($datos);
    	foreach ($sesion_clase_evento as $s) {
    		$return .= "<option value='".$s['PK_sesion_clase']."' data-tipo_grupo='".$s['tipo_grupo']."' data-id_grupo='".$s['FK_grupo']."' data-horas_clase='".$s['IN_horas_clase']."' data-tx_observaciones='".$s['TX_observaciones']."' >".$s['DA_fecha_sesion_clase']." en grupo ".$tipo_grupo_acronimo[$s['tipo_grupo']]."-".$s['FK_grupo']."</option>";
    	}
    	echo $return;
    }

    public function cargarDatosEstudiantesGrupoSesionEvento($id_sesion_clase_evento){
    	$EventoDAO = $this->contenedor['EventoDAO'];
    	$estudiante = $EventoDAO->consultarIDYEstadoEstudiantesSesionClaseEvento($id_sesion_clase_evento);
    	echo json_encode($estudiante);
    }

    public function eliminarAsistenciaSesionEvento($id_sesion_clase_evento,$id_usuario_actual){
    	$EventoDAO = $this->contenedor['EventoDAO'];
    	echo $EventoDAO->eliminarAsistenciaSesionEvento($id_sesion_clase_evento,$id_usuario_actual);
    }

    public function modificarAsistenciaSesionEvento($datos){
    	$EventoDAO = $this->contenedor['EventoDAO'];
    	echo $EventoDAO->modificarAsistenciaSesionEvento($datos);
    }

    public function getOrganizacionUsuario($datos){
    	$GrupoDAO = $this->contenedor['GrupoDAO'];
        $id_organizacion_actual = $GrupoDAO->consultarIDOrganizacionUsuario($datos['id_artista_formador']);
        if(empty($id_organizacion_actual)){
            echo "<option value='2'>IDARTES</option>";
        }
        foreach ($id_organizacion_actual as $i) {
            echo "<option value='".$i['FK_Organizacion']."'>".$i['VC_Nom_Organizacion']."</option>";
        }
    }

    public function consultarDiasDelMesFestivosYCanceladosPorCoordinador($datos){
        $fecha = date('Y-m-d');
        $datos['fecha_mes'] = $fecha;
        $NovedadSesionClaseDAO = $this->contenedor['NovedadSesionClaseDAO'];
        $fecha_cancelada = $NovedadSesionClaseDAO->consultarDiasMesCanceladosCoordinadorGrupo($datos);
        $dias_festivo = $NovedadSesionClaseDAO->consultarDiasFestivosMes($datos);
        echo json_encode( array_merge($fecha_cancelada,$dias_festivo));
    }

    public function verificarReporteEnRevision($datos){
        $ReporteDAO = $this->contenedor['ReporteDAO'];
        $datos['fecha_mes'] = substr($datos['fecha_mes'], 0,-3);
        $dato_reporte = $ReporteDAO->consultarExistenciaReporteMes($datos);
        if(!empty($dato_reporte)){
            if($dato_reporte[0]["SM_estado"] != 2){ // si es diferente a estado rechazado
                echo "1";
            }else{
                echo "0";
            }
        }else{
            echo "0";
        }
    }

    public function RegistrarAsistenciaGrupoTransicion($datos){
        $sesionClaseDAO = $this->contenedor['SesionClaseDAO'];
        $mayores = array();
        $menores = array();
        foreach ($datos['asistencia'] as $a) {
            if ($a[2] == 'mayor') {
                array_push($mayores, array('id_beneficiario' => $a[0],'estado' => $a[1]));
            }else if ($a[2] == 'menor') {
                array_push($menores, array('id_beneficiario' => $a[0],'estado' => $a[1]));
            }
        }
        $datos['mayores']=$mayores;
        $datos['menores']=$menores;
        // $datos['horas_clase'] = 20;
        $datos['nombre_crea'] = '';
        $datos['tipo_grupo'] = 'transicion';
        // var_dump($datos['asistencia']);
        // echo "---------------------------MENORES ----------------------";
        // var_dump($menores);
        // echo "---------------------------MAYORES ----------------------";
        // var_dump($mayores);
        echo $sesionClaseDAO->RegistrarAsistenciaGrupoTransicion($datos);
	}
	
	public function consultarEstudiantesParaAsistenciaMasiva($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$SesionClaseDAO = $this->contenedor['SesionClaseDAO'];
		$estudiante = $GrupoDAO->consultarEstudiantesPorEstadoGrupo($datos['id_grupo'],$datos['tipo_grupo'],$datos['estado']);
		$sesion_clase = $SesionClaseDAO->consultarSesionesRegistradasEnGrupoUsuario($datos);
		$dias_sesiones = [];
		$ids_sesiones = [];
		$anexos_sesiones = [];
		$detalle_dia_sesion_clase = [];
		foreach ($sesion_clase as $key => $value) {
			$sesion_clase_asistencia = $SesionClaseDAO->consultarDetalleAsistenciaSesionClase($value['PK_sesion_clase'],$datos['tipo_grupo']);
			array_push($dias_sesiones,intval(substr($value['DA_fecha_clase'], -2)));
			$ids_sesiones[intval(substr($value['DA_fecha_clase'], -2))]=$value['PK_sesion_clase'];
			$anexos_sesiones[intval(substr($value['DA_fecha_clase'], -2))]=$value['VC_anexo'];

			array_push($detalle_dia_sesion_clase,array("dia_".intval(substr($value['DA_fecha_clase'], -2)) => $sesion_clase_asistencia));
		}
		$vista= $this->contenedor['vista'];
		$datos_mes = array('estudiante'=>$estudiante,
							'id_grupo'=>$datos['id_grupo'],
							'tipo_grupo'=>$tipo_grupo['tipo_grupo'],
							'dias_sesiones'=>$dias_sesiones,
							'ids_sesiones'=>$ids_sesiones,
							'anexos_sesiones'=>$anexos_sesiones,
							'detalle_dia_sesion_clase'=>$detalle_dia_sesion_clase
						);
		$vista->setVariables($datos_mes);
		$vista->setPlantilla("registroAsistenciaMasiva");
		$vista->renderHtml();
	}
	
	public function actualizarEstadoAsistenciaBeneficiarioSesionClase($datos){
		$SesionClaseDAO = $this->contenedor['SesionClaseDAO'];
		echo $SesionClaseDAO->actualizarEstadoAsistenciaBeneficiarioSesionClase($datos);
	}

	public function crearDiaSesionClase($datos){
		$SesionClaseDAO = $this->contenedor['SesionClaseDAO'];
		$dato_adicional = $SesionClaseDAO->consultarDatosAdicionalesGrupo($datos['id_grupo'],$datos['tipo_grupo'])[0];
		// var_dump($datos_consulta);
		$dato_adicional['id_lugar_atencion'] = $datos['tipo_ubicacion'];
		$dato_adicional["id_salon"] = "-1";
		$dato_adicional["horas_sesion"] = "1";
		$dato_adicional["suplencia"] = "0";
		$dato_adicional["observacion"] = "";
		if($datos['id_formador_titular'] != $datos['id_usuario']){
			$dato_adicional["suplencia"] = "1";
			$dato_adicional["observacion"] = "Suplencia";
		}
		$fecha_sesion = $SesionClaseDAO->validarFechaSesionClase($datos['id_grupo'],$datos['fecha'],$datos['tipo_grupo']);
    	if(isset($fecha_sesion[0]['FK_grupo'])){
    		echo "Sesion ya existe";
    	}else{
    		echo $SesionClaseDAO->crearDiaSesionClase($datos,$dato_adicional);
    	}
	}

	public function subirAnexoSesion($datos,$archivos){
		$datos = json_decode($datos,true);
		try{
			$archivos = $this->subirArchivos($datos,$archivos);
			echo 1;
		}catch(Exception $e){
			echo 0;
		}
	}

	public function consultarGruposConSesionesEnMes($datos){
    	$return = "<optgroup label='Mis Grupos'>";
		$mis_grupos = "";
		$grupos_suplencia = "";
		$fecha = $datos['anio_mes']."-01";
		$return = "<optgroup label='Mis Sesiones de clase'>";
		$mis_grupos = "";
		$grupos_suplencia = "";
		$tipo_grupo = ['arte_escuela','emprende_clan','laboratorio_clan'];
		$tipo_grupo_acronimo = ['AE','EC','LC'];
		$sesionClaseDAO = $this->contenedor['SesionClaseDAO'];
		for ($i=0; $i < sizeof($tipo_grupo); $i++) {
			$grupo = $sesionClaseDAO->consultarGruposMisSesionesMes($datos['id_usuario'],$fecha,$tipo_grupo[$i]);
			foreach ($grupo as $g){
				if ($g['suplencia'] == 0) {
					$mis_grupos .= "<option value='".$g['FK_Grupo']."' data-tipo_grupo='".$tipo_grupo[$i]."' data-tipo_ubicacion='".$g['tipo_ubicacion']."' data-crea='".$g['FK_clan']."'>".$tipo_grupo_acronimo[$i]."-".$g['FK_Grupo']."</option>";
				}else{
					$grupos_suplencia .= "<option value='".$g['FK_Grupo']."' data-tipo_grupo='".$tipo_grupo[$i]."' data-tipo_ubicacion='".$g['tipo_ubicacion']."' data-crea='".$g['FK_clan']."'>".$tipo_grupo_acronimo[$i]."-".$g['FK_Grupo']."</option>";
				}
			}
		}

		$return .= $mis_grupos;
		$return .= "</optgroup><optgroup label='Suplencias'>";
		$return .= $grupos_suplencia;
		$return .= "</optgroup>";

		echo $return;
	}
	
	public function consultarTablaAnexosMes($datos){
		if($datos['id_grupo'] != ""){
			$return = "<table id='table_anexo' class='table'>";
			$SesionClaseDAO = $this->contenedor['SesionClaseDAO'];
			$sesion_clase = $SesionClaseDAO->consultarSesionesRegistradasEnGrupoUsuario($datos);
			$return .= "<thead>";
			$return .= "<tr>";
			$return .= "<th>Día</th>";
			$return .= "<th>Consultar Anexo</th>";
			$return .= "<th>Subir o cambiar anexo</th>";
			$return .= "</tr>";
			$return .= "</thead>";
			$return .= "<tbody>";
			foreach ($sesion_clase as $sc) {
				$return .= "<tr>";
				$return .= "<td>".$sc['DA_fecha_clase']."</td>";
				$return .= "<td>";
				if($sc['VC_anexo'] == ""){
					$return .= '<button type="button" title="No hay Anexo" class="btn btn-danger no_anexo" aria-label="Left Align">
							<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span> No anexo
						</button>';
				}else{
					$return .= '<button type="button" title="Ver Anexo" class="btn btn-info ver_anexo" data-vc_anexo="'.$sc['VC_anexo'].'" aria-label="Left Align">
							<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Ver Anexo
						</button>';
				}
				$return .= "</td>";
				$return .= "<td>";
				$return .= '<button type="button" title="Subir Anexo" class="btn btn-warning subir_anexo" data-id_sesion_clase="'.$sc['PK_sesion_clase'].'" data-tipo_grupo="'.$datos['tipo_grupo'].'" aria-label="Left Align">
							<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Subir nuevo anexo
						</button>';
				$return .= "</td>";
				$return .= "</tr>";
			}
			$return .= "</tbody>";
			$return .= "</table>";
			echo $return;
		}else{
			echo "<h2>No hay datos</h2>";
		}
	}

	public function encuestaBioseguridad($datos){
		var_dump($datos);
	}

    private function getOrganizacionGrupo($id_grupo,$tipo_grupo){
        return $this->contenedor['GrupoDAO']->consultarOrganizacionGrupo($id_grupo,$tipo_grupo)[0]['FK_organizacion'];
    }

 	private function extraerDatosHorarioClase($dia, $hora_inicio, $hora_fin){
		$dia_semana = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
		return $dia_semana[$dia - 1]." de ".$hora_inicio." a ".$hora_fin.", ";
	}

	private function obtenerFechaInicialGruposModificar(){
		$ParametroDAO = $this->contenedor['ParametroDAO'];;
        $dias_subsanacion = $ParametroDAO->getParametroDetalle(44);
        $dias_fin_mes = $dias_subsanacion[0]['FK_Value'];
        $dias_inicio_mes = $dias_subsanacion[1]['FK_Value'];
        date_default_timezone_set('America/Bogota');
        $fecha_ultimo_dia_mes = new \DateTime();
        $fecha_ultimo_dia_mes->modify('last day of this month');
        $fecha_inicio_subsancion_fin_mes = $fecha_ultimo_dia_mes->format('d') - $dias_fin_mes +1;
        $fecha = date('Y-m-d');
        if((date("d") >= $fecha_inicio_subsancion_fin_mes) && ($dias_fin_mes != 0)){
            $fecha = strtotime( '-'.(intval(date("d")) - 1).' day' , strtotime( $fecha ) );
        }else if(date("d") <= $dias_inicio_mes){
            $fecha = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
            $fecha = date ( 'Y-m-d' , $fecha );
            $fecha = strtotime( '-'.(intval(date("d")) - 1).' day' , strtotime( $fecha ) );
        }else{
            $fecha = strtotime ( '-0 day' , strtotime ( $fecha ) ) ;
        }
        $fecha = date ( 'Y-m-d' , $fecha );
		// return $fecha;
		return "2021-09-01";
	}

	private function eventoEsDistrital($tipo_evento){
		if($tipo_evento == 14 || $tipo_evento == 15 || $tipo_evento == 19)  // se agrega el 19 que corresponde a tipo_evento=virtual
			return false;
		else    
			return true;
	}

	private function subirArchivos($datos,$archivos)
	{
		$fecha_hora_actual = date('Y-m-d H:i:s');
		$anio_actual = date('Y');
		$backtrace = debug_backtrace()[1];
		$rutaBase =   substr($backtrace['file'],0, strpos($backtrace['file'],'src'));  
		$carpeta = $rutaBase.'uploadedFiles/documentosSesionClase/'.$datos['linea_atencion'].'/'.$datos['id_sesion_clase'].'/';
		$ubicacion = "../../uploadedFiles/documentosSesionClase/".$datos['linea_atencion'].'/'.$datos['id_sesion_clase'].'/';
		$url_archivo = "documentosSesionClase/".$id_sesion_clase.$datos['linea_atencion'].'/'.$datos['id_sesion_clase'].'/';
		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return 4;
		} 
		else{
			$rta = "";
			if(!empty($archivos)){
				foreach ($archivos as $clave => $archivo) {
					$ext = pathinfo($archivo["name"], PATHINFO_EXTENSION);
					$archivo['name'] = "anexo_sesion.".$ext;
					$ruta = $carpeta.$this->clean($archivo['name']);
					if ($rta != "4"){					
						if (move_uploaded_file($archivo['tmp_name'] , $ruta)){
							$url_completa = $url_archivo.$archivo['name'];
							$rta .= $ubicacion.$this->clean($archivo['name'])."///";

							$datos_table_db = array(
								'PK_sesion_clase' => $datos['id_sesion_clase'],
								'VC_anexo' => $url_completa,
								'linea_atencion' => $datos['linea_atencion']
							);
							$sesionClaseDAO = $this->contenedor['SesionClaseDAO'];
							$sesionClaseDAO->updateAnexo($datos_table_db);
						}
						else
							$rta = "4";
					}

				}
			}
			$rta = rtrim($rta,"///");
			return $rta;            
		} 
	}
	/**
	 * Limpia de tildes y caracteres extraños un string
	 * @param  string $string		  string que se quiere limpiar
	 * @return string         string limpio
	 */
	private function clean($string) {
		$utf8 = array(
			'/[áàâãªä]/u'   =>   'a',
			'/[ÁÀÂÃÄ]/u'    =>   'A',
			'/[ÍÌÎÏ]/u'     =>   'I',
			'/[íìîï]/u'     =>   'i',
			'/[éèêë]/u'     =>   'e',
			'/[ÉÈÊË]/u'     =>   'E',
			'/[óòôõºö]/u'   =>   'o',
			'/[ÓÒÔÕÖ]/u'    =>   'O',
			'/[úùûü]/u'     =>   'u',
			'/[ÚÙÛÜ]/u'     =>   'U',
			'/ç/'           =>   'c',
			'/Ç/'           =>   'C',
			'/ñ/'           =>   'n',
			'/Ñ/'           =>   'N',
			'/–/'           =>   '-',
			'/[#$!!#]/u'    =>   '',
			'/[’‘‹›‚]/u'    =>   ' ',
			'/[“”«»„]/u'    =>   ' ',
			'/ /'           =>   ' ',
		);
		return str_replace("?", "",utf8_decode(preg_replace(array_keys($utf8), array_values($utf8), $string)));      
	}

}

$objControlador = new RegistrarAsistenciaController();
unset($objControlador);
