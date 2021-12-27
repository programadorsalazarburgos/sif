<?php
	header ('Content-type: text/html; charset=utf-8');
	// Incluir libreria de acceso a base de datos
	require_once('../../Modelo/medoo/medoo.php');
	require_once('../../Modelo/medoo/parametros_conexion.php');

	/***************************************************************************
	/* addRegistroAsistencia() agrega un nuevo de registro en la tabla de asistencia.
	***************************************************************************/
	function addRegistroAsistencia($id_clan,$id_area_artistica,$id_artista_formador,$fecha_taller,$id_lugar_atencion,$numero_personas,$observaciones){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$id_asistencia = getMaxIDAsistenciaLaboratorioClan() + 1;
		$db_siclan->insert("tb_terr_asistencia_laboratorio_clan",[
			"PK_Asistencia" => $id_asistencia,
			"VC_codigo_taller" => "LC-".$id_asistencia,
			"FK_Clan" => $id_clan,
			"FK_area_artistica" => $id_area_artistica,
			"FK_artista_formador" => $id_artista_formador,
			"DA_fecha_taller" => $fecha_taller,
			"FK_lugar_atencion" => $id_lugar_atencion,
			"IN_numero_personas" => $numero_personas,
			"VC_observaciones" => $observaciones,
			"DT_fecha_registro" => date('Y-m-d H:i:s')
		]);
		return ($id_asistencia);
	}

	/***************************************************************************
	/* guardarAsistenciaLaboratorioClan() inserta un nuevo registro indicando la asistencia del laboratorio CLAN.
	***************************************************************************/
	function guardarAsistenciaLaboratorioClan($id_registro_asistencia,$tiene_documento,$documento_persona,$nombre_persona){
		global $db_siclan;
		$insert = $db_siclan->insert("tb_terr_asistencia_persona_laboratorio_clan",[
			"FK_Asistencia" => $id_registro_asistencia,
			"TI_tiene_documento" => $tiene_documento,
			"VC_Documento" =>$documento_persona,
			"VC_Nombre" => $nombre_persona
		]);
		return $insert;
	}

	/***************************************************************************
	/* getMaxIDAsistenciaLaboratorioClan() selecciona el último id registrado en la tabla de asistencias a laboratorio CLAN.
	***************************************************************************/
	function getMaxIDAsistenciaLaboratorioClan(){
		global $db_siclan;
		$max = $db_siclan->max("tb_terr_asistencia_laboratorio_clan","PK_Asistencia");
		return $max;
	}

	/***************************************************************************
	/* getClanes() selecciona los clanes que existen en el sistema.
	***************************************************************************/
	function getClanes(){
		global $db_siclan;
		$clan = $db_siclan->select("tb_clan",["PK_Id_Clan","VC_Nom_Clan"]);
		return ($clan);
	}

	/***************************************************************************
	/* getAreasArtisticas() selecciona las areas artisticas que existen en el sistema.
	***************************************************************************/
	function getAreasArtisticas(){
		global $db_siclan;
		$area = $db_siclan->select("tb_areas_artisticas",["PK_Area_Artistica","VC_Nom_Area"]);
		return $area;
	}

	/***************************************************************************
	/* getLugaresAtencion() selecciona los lugares de atención que existen en el sistema establecidos para el programa de laboratorio clan
	***************************************************************************/
	function getLugaresAtencion(){
		global $db_siclan;
		$area = $db_siclan->select("tb_terr_lugar_atencion_laboratorio_clan",["PK_lugar_atencion","VC_Nombre_Lugar"]);
		return $area;
	}

	/***************************************************************************
	/* getUltimoDocumentoAsignadoLaboratorioClan() selecciona el último documento asignado por el sistema a una persona indocumentada.
	***************************************************************************/
	function getUltimoDocumentoAsignadoLaboratorioClan(){
		global $db_siclan;
		$ultimo_id = $db_siclan->query(
			"SELECT AP.VC_Documento
			FROM tb_terr_asistencia_persona_laboratorio_clan AP
			WHERE AP.VC_Documento LIKE 'PV_IDARTES_%'
			ORDER BY FK_Asistencia DESC LIMIT 1"
		)->fetchAll();
		return $ultimo_id;
	}

	/***************************************************************************
	/* getHistoricoArtistaFormador() consulta todos los registros de asistencias que ha ingresado un artista formador al sistema.
	***************************************************************************/
	function getHistoricoArtistaFormador($id_artista_formador){
		global $db_siclan;
		$registro_asitencia = $db_siclan->select("tb_terr_asistencia_laboratorio_clan",
			[
			"[>]tb_clan"=>["FK_Clan"=>"PK_Id_Clan"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_terr_lugar_atencion_laboratorio_clan"=>["FK_lugar_atencion"=>"PK_lugar_atencion"]
			],
			[
				"tb_terr_asistencia_laboratorio_clan.PK_Asistencia",
				"tb_terr_asistencia_laboratorio_clan.VC_codigo_taller",
				"tb_clan.VC_Nom_Clan",
				"tb_areas_artisticas.VC_Nom_Area",
				"tb_terr_asistencia_laboratorio_clan.DA_fecha_taller",
				"tb_terr_lugar_atencion_laboratorio_clan.VC_Nombre_Lugar",
				"tb_terr_asistencia_laboratorio_clan.IN_numero_personas",
				"tb_terr_asistencia_laboratorio_clan.VC_observaciones",
				"tb_terr_asistencia_laboratorio_clan.VC_extencion_archivo_soporte"
			],
			[
				"FK_artista_formador"=>$id_artista_formador,
				"ORDER"=>"tb_terr_asistencia_laboratorio_clan.DA_fecha_taller DESC"
			]);
		return $registro_asitencia;
	}

	/***************************************************************************
	/* getDatosArtistaFormador() selecciona los datos de identificacion, nombre completo y correo de una persona según el id.
	***************************************************************************/
	function getDatosArtistaFormador($id_artista_formador){
		global $db_siclan;
		$datos_artista = $db_siclan->select("tb_persona_2017",[
			"VC_Identificacion",
			"VC_Primer_Nombre",
			"VC_Segundo_Nombre",
			"VC_Primer_Apellido",
			"VC_Segundo_Apellido",
			"VC_Correo"
		],
		["PK_Id_Persona"=>$id_artista_formador]);
		return $datos_artista;
	}

	/***************************************************************************
	/* getCoordinadoresClanesClasesMes() consulta el nombre del coordinador del clan.
	***************************************************************************/
	function getCoordinadoresClanesClasesMes($id_artista_formador){
		global $db_siclan;
		$coordinador = $db_siclan->select("tb_clan",["VC_Nom_Administrador"]);
		return $coordinador;
	}

	/***************************************************************************
	/* getAnioMesSesionesClaseArtistaFormador() seleciona los meses en que un artista formador ha registrado asistencias.
	***************************************************************************/
	function getAnioMesSesionesClaseArtistaFormador($id_artista_formador){
		global $db_siclan;
		$mes_sesiones = $db_siclan->query("SELECT DISTINCT YEAR(A.DA_fecha_taller) AS anio,MONTH(A.DA_fecha_taller) AS mes
			FROM tb_terr_asistencia_laboratorio_clan A
			WHERE A.FK_artista_formador = ".$id_artista_formador." 
			ORDER BY A.DA_fecha_taller DESC");
		return $mes_sesiones;
	}

	/***************************************************************************
	/* getClasesMesArtistaFormador() selecciona las clases de un mes especifico que ha resgistrado un artista formador.
	***************************************************************************/
	function getClasesMesArtistaFormador($mes,$id_artista_formador){
		global $db_siclan;
		$clases_mes = $db_siclan->select("tb_terr_asistencia_laboratorio_clan",
			[
			"[>]tb_clan"=>["FK_Clan"=>"PK_Id_Clan"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_terr_lugar_atencion_laboratorio_clan"=>["FK_lugar_atencion"=>"PK_lugar_atencion"]
			],
			[
				"tb_terr_asistencia_laboratorio_clan.PK_Asistencia",
				"tb_terr_asistencia_laboratorio_clan.VC_codigo_taller",
				"tb_clan.VC_Nom_Clan",
				"tb_areas_artisticas.VC_Nom_Area",
				"tb_terr_asistencia_laboratorio_clan.DA_fecha_taller",
				"tb_terr_lugar_atencion_laboratorio_clan.VC_Nombre_Lugar",
				"tb_terr_asistencia_laboratorio_clan.IN_numero_personas",
				"tb_terr_asistencia_laboratorio_clan.VC_observaciones",
				"tb_terr_asistencia_laboratorio_clan.VC_extencion_archivo_soporte"
			],
			[
				"AND"=>[
					"FK_artista_formador"=>$id_artista_formador,
					"DA_fecha_taller[~]"=>$mes."%"
				],
				"ORDER"=>"tb_terr_asistencia_laboratorio_clan.DA_fecha_taller DESC"
			]);
		return $clases_mes;
	}

	/***************************************************************************
	/* getFirmasCoordinadoresClanClasesMes() selecciona el id de los clanes en que un artista formador ha registrado asistencia para un mes especifico.
	***************************************************************************/
	function getFirmasCoordinadoresClanClasesMes($mes,$id_artista_formador){
		global $db_siclan;
		$firma_coordinador = $db_siclan->select("tb_terr_asistencia_laboratorio_clan",
			[
			"[>]tb_clan"=>["FK_Clan"=>"PK_Id_Clan"]
			],
			[
				"tb_clan.VC_Nom_Clan",
				"tb_clan.VC_Nom_Administrador"
			],
			["AND"=>["FK_artista_formador"=>$id_artista_formador,
			"DA_fecha_taller[~]"=>$mes."%"]]);
		return $firma_coordinador;
	}

	/***************************************************************************
	/* updateExtencionArchivoSoporte() actualiza el registro de una asistencia con la extención del archivo soporte utilizado para esa clase.
	***************************************************************************/
	function updateExtencionArchivoSoporte($id_registro_asistencia,$extencion_archivo){
		global $db_siclan;
		$update = $db_siclan->update("tb_terr_asistencia_laboratorio_clan",["VC_extencion_archivo_soporte"=>$extencion_archivo],["PK_Asistencia"=>$id_registro_asistencia]);
		return $update;
	}

	/***************************************************************************
	/* getArtistasFormadoresLaboratorioClan() selecciona los datos de los artistas formadores que han registrado asistencia en laboratorio CLAN.
	***************************************************************************/
	function getArtistasFormadoresLaboratorioClan(){
		global $db_siclan;
		$artista_formador = $db_siclan->query("SELECT DISTINCT A.FK_artista_formador,
				P.VC_Identificacion,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre
			FROM tb_terr_asistencia_laboratorio_clan A
				LEFT JOIN tb_persona_2017 P ON A.FK_artista_formador = P.PK_Id_Persona");
		return $artista_formador;
	}

	/***************************************************************************
	/* consultarTaller() consulta los datos de un taller segun un criterio de busqueda, con el fin de verificar si un artista formador ya registro un taller para un día especifico, un clan especifico, un area artistica especifica, un lugar de atencion especifico.
	***************************************************************************/
	function consultarTaller($id_clan,$id_area_artistica,$id_artista_formador,$fecha_taller,$id_lugar_atencion){
		global $db_siclan;
		$taller = $db_siclan->select("tb_terr_asistencia_laboratorio_clan",
			[
			"VC_codigo_taller",
			"IN_numero_personas",
			"VC_observaciones"
			],
			[
			"AND"=>[
				"FK_Clan"=>$id_clan,
				"FK_area_artistica"=>$id_area_artistica,
				"FK_artista_formador"=>$id_artista_formador,
				"DA_fecha_taller"=>$fecha_taller,
				"FK_lugar_atencion"=>$id_lugar_atencion
				]
			]);
		return $taller;
	}

	/***************************************************************************
	/* getGruposActivosArteEscuelaByUsuario() consulta los datos de los grupos de arte en la escuela activos que estan asignados a un Artista Formador
	***************************************************************************/
	function getGruposActivosArteEscuelaByUsuario($id_usuario){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_arte_escuela","*",["AND"=>["FK_artista_formador"=>$id_usuario,"estado"=>1]]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposActivosEmprendeClanByUsuario() consulta los datos de los grupos de emprende clan activos que estan asignados a un Artista Formador
	***************************************************************************/
	function getGruposActivosEmprendeClanByUsuario($id_usuario){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_emprende_clan","*",["AND"=>["FK_artista_formador"=>$id_usuario,"estado"=>1]]);
		return $grupo;
	}

	/***************************************************************************
	/* consultarHorarioGrupoArteEscuela() consulta el (los) día(s) de clases que están habilitados en el sistema para las clases de un grupo de arte en la escuela.
	***************************************************************************/
	function consultarHorarioGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$horario = $db_siclan->select("tb_terr_grupo_arte_escuela_horario_clase","*",["FK_grupo"=>$id_grupo]);
		return $horario;
	}

	/***************************************************************************
	/* consultarHorarioGrupoEmprendeClan() consulta el (los) día(s) de clases que están habilitados en el sistema para las clases de un grupo de emprende clan.
	***************************************************************************/
	function consultarHorarioGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$horario = $db_siclan->select("tb_terr_grupo_emprende_clan_horario_clase","*",["FK_grupo"=>$id_grupo]);
		return $horario;
	}

	/***************************************************************************
	/* getEstudiantesGrupoArteEscuela() consulta los estudiantes que se encuentran activos en un grupo especifico de arte enla escuela
	***************************************************************************/
	function getEstudiantesGrupoArteEscuela($id_grupo){
		global $db_siclan;
		global $db_siclan;
		$estudiante = $db_siclan->select("tb_terr_grupo_arte_escuela_estudiante",
			[
				"[>]tb_estudiante"=>["FK_estudiante"=>"id"]
			],
			[
				"tb_estudiante.IN_Identificacion",
				"tb_estudiante.VC_Primer_Nombre",
				"tb_estudiante.VC_Segundo_Nombre",
				"tb_estudiante.VC_Primer_Apellido",
				"tb_estudiante.VC_Segundo_Apellido",
				"tb_terr_grupo_arte_escuela_estudiante.FK_estudiante",
				"tb_terr_grupo_arte_escuela_estudiante.FK_grupo",
				"tb_terr_grupo_arte_escuela_estudiante.DT_fecha_ingreso"
			],
			["AND"=>["FK_grupo"=>$id_grupo,"estado"=>1]]);
		return $estudiante;
	}

	/***************************************************************************
	/* getEstudiantesGrupoEmprendeClan() consulta los estudiantes que se encuentran activos en un grupo especifico de emprende clan
	***************************************************************************/
	function getEstudiantesGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$estudiante = $db_siclan->select("tb_terr_grupo_emprende_clan_estudiante",
			[
				"[>]tb_estudiante"=>["FK_estudiante"=>"id"]
			],
			[
				"tb_estudiante.IN_Identificacion",
				"tb_estudiante.VC_Primer_Nombre",
				"tb_estudiante.VC_Segundo_Nombre",
				"tb_estudiante.VC_Primer_Apellido",
				"tb_estudiante.VC_Segundo_Apellido",
				"tb_terr_grupo_emprende_clan_estudiante.FK_estudiante",
				"tb_terr_grupo_emprende_clan_estudiante.FK_grupo",
				"tb_terr_grupo_emprende_clan_estudiante.DT_fecha_ingreso"
			],
			["AND"=>["FK_grupo"=>$id_grupo,"estado"=>1]]);
		return $estudiante;
	}

	/***************************************************************************
	/* getArtistaFormadorConGrupoActivo() consulta los datos de los artistas formadores que tienen grupos activos de ambas lineas de atención (Arte Escuela y Emprende Clan)
	***************************************************************************/
	function getArtistaFormadorConGrupoActivo($id_usuario_actual){
		global $db_siclan;
		$artista_formador = $db_siclan->query("SELECT DISTINCT(FK_artista_formador), P.VC_Identificacion,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.PK_Id_Persona
			FROM tb_terr_grupo_arte_escuela GAE
			JOIN tb_persona_2017 P ON GAE.FK_artista_formador = P.PK_Id_Persona
			WHERE estado = 1 AND FK_Artista_Formador != $id_usuario_actual
			UNION SELECT DISTINCT(FK_artista_formador), P.VC_Identificacion,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.PK_Id_Persona
			FROM tb_terr_grupo_emprende_clan GEC
			JOIN tb_persona_2017 P ON GEC.FK_artista_formador = P.PK_Id_Persona
			WHERE estado = 1 AND FK_Artista_Formador != $id_usuario_actual")->fetchAll();
		return $artista_formador;
	}

	/***************************************************************************
	/* getInformaciónGrupo() consulta la información más relevante de un grupo especifico
	***************************************************************************/
	function getInformacionGrupo($id_grupo,$tipo_grupo){
		global $db_siclan;
		if ($tipo_grupo == 'arte_escuela') {
			$datos = $db_siclan->select("tb_terr_grupo_arte_escuela",[
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_colegios"=>["FK_colegio"=>"PK_Id_Colegio"],
			"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"]
			],[
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_colegios.VC_Nom_Colegio",
			"tb_clan.VC_Nom_Clan",
			"tb_terr_grupo_arte_escuela.IN_lugar_atencion",
			"tb_terr_grupo_arte_escuela.DT_fecha_creacion"
			],["PK_Grupo"=>$id_grupo]);
		return $datos;
		}
		if ($tipo_grupo == 'emprende_clan') {
			$datos = $db_siclan->select("tb_terr_grupo_emprende_clan",[
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_modalidad"=>["FK_modalidad"=>"PK_Id_Modalidad"],
			"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"]
			],[
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_modalidad.VC_Nom_Modalidad",
			"tb_clan.VC_Nom_Clan",
			"tb_terr_grupo_emprende_clan.DT_fecha_creacion"
			],["PK_Grupo"=>$id_grupo]);
		return $datos;
		}
		if ($tipo_grupo == 'laboratorio_clan') {
			$datos = $db_siclan->select("tb_terr_grupo_laboratorio_clan",[
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"]
			],[
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_clan.VC_Nom_Clan",
			"tb_terr_grupo_laboratorio_clan.DT_fecha_creacion"
			],["PK_Grupo"=>$id_grupo]);
		return $datos;
		}		
		
	}

	/***************************************************************************
	/* getSesionesClaseGrupoEmprendeClan() consulta todas las sesiones de clase que tiene un grupo de la línea de atención emprende clan
	***************************************************************************/
	function getSesionesClaseGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$sesion_clase = $db_siclan->select("tb_terr_grupo_emprende_clan_sesion_clase","*",["FK_grupo"=>$id_grupo]);
		return $sesion_clase;
	}

	/***************************************************************************
	/* getEstudiantesSesionClaseArteEscuela() Consulta la información de todos los estudiantes que tienen registro de asistencia para una sesión de clase de algun grupo
	***************************************************************************/
	function getEstudiantesSesionClaseArteEscuela($id_sesion_clase){
		global $db_siclan;
		$estudiante = $db_siclan->select("tb_terr_grupo_arte_escuela_sesion_clase_asistencia",[
				"[>]tb_estudiante" => ["FK_estudiante" => "id"]
			],[
				"tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_estudiante",
				"tb_estudiante.VC_Primer_Nombre",
				"tb_estudiante.VC_Segundo_Nombre",
				"tb_estudiante.VC_Primer_Apellido",
				"tb_estudiante.VC_Segundo_Apellido",
				"tb_terr_grupo_arte_escuela_sesion_clase_asistencia.IN_estado_asistencia"
			],
			["FK_sesion_clase"=>$id_sesion_clase]);
		return $estudiante;
	}

	/***************************************************************************
	/* getObservacionSesionClaseArteEscuela() consulta la observación realizada en una sesion de clase de algun grupo de arte en la escuela.
	***************************************************************************/
	function getObservacionSesionClaseArteEscuela($id_sesion_clase){
		global $db_siclan;
		$observacion = $db_siclan->select("tb_terr_grupo_arte_escuela_sesion_clase","TX_observaciones",["PK_sesion_clase"=>$id_sesion_clase]);
		return $observacion;
	}

	function getObservacionSesionClaseEmprendeClan($id_sesion_clase){
		global $db_siclan;
		$observacion = $db_siclan->select("tb_terr_grupo_emprende_clan_sesion_clase","TX_observaciones",["PK_sesion_clase"=>$id_sesion_clase]);
		return $observacion;
	}

	/***************************************************************************
	/* getIDGrupoSesionClaseArteEscuela() retorna el id del grupo al cual pertenece una sesión de clase de un grupo de arte en la escuela
	***************************************************************************/
	function getIDGrupoSesionClaseArteEscuela($id_sesion_clase){
		global $db_siclan;
		$id_grupo = $db_siclan->select("tb_terr_grupo_arte_escuela_sesion_clase","FK_grupo",["PK_sesion_clase"=>$id_sesion_clase]);
		return $id_grupo;
	}

	
?>