<?php
header ('Content-type: text/html; charset=utf-8');
	// Incluir libreria de acceso a base de datos
require_once('../../Modelo/medoo/medoo.php');
require_once('../../Modelo/medoo/parametros_conexion.php');
error_reporting(E_ALL);

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
	/* getModalidades() selecciona los datos de las modalidades de clase que existen en el sistema.
	***************************************************************************/
	function getModalidades($id_area_artistica){
		global $db_siclan;
		$modalidad = $db_siclan->select("tb_modalidad",["PK_Id_Modalidad","VC_Nom_Modalidad"],["FK_Area_Atencion"=>$id_area_artistica]);
		return $modalidad;
	}

	/***************************************************************************
	/* consultarColegiosClan() consulta los colegios que estan en la misma localidad de un clan.
	***************************************************************************/
	function consultarColegiosClan($id_clan){
		global $db_siclan;
		$colegio = $db_siclan->query("SELECT C.*
			FROM tb_clan_colegio CC
			LEFT JOIN tb_colegios C ON CC.FK_Id_Colegio = C.PK_Id_Colegio
			WHERE CC.FK_Id_Clan = ".$id_clan);
		return $colegio;
	}

	/***************************************************************************
	/* saveNewGrupoArteEscuela() guarda un nuevo registro de grupo de la linea de atención arte en la escuela.
	***************************************************************************/
	function saveNewGrupoArteEscuela($id_clan,$id_area_artistica,$id_lugar_atencion,$id_colegio,$id_usuario,$observaciones,$tipo_grupo){
		global $db_siclan;
		$id_grupo = $db_siclan->max("tb_terr_grupo_arte_escuela","PK_Grupo");
		$id_grupo++;
		date_default_timezone_set('America/Bogota');
		$set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
		$set_id->execute([$id_usuario]);
		$db_siclan->insert("tb_terr_grupo_arte_escuela",[
			"PK_Grupo"=>$id_grupo,
			"FK_clan"=>$id_clan,
			"FK_area_artistica"=>$id_area_artistica,
			"IN_lugar_atencion"=>$id_lugar_atencion,
			"FK_colegio"=>$id_colegio,
			"DT_fecha_creacion"=>date('Y-m-d H:i:s'),
			"FK_creador"=>$id_usuario,
			"estado"=>1,
			"TX_observaciones"=>$observaciones,
			"tipo_grupo"=>$tipo_grupo
			]);
		return $id_grupo;
	}

	/***************************************************************************
	/* saveNewGrupoEmprendeClan() guarda un nuevo registro de grupo de la linea de atención emprende clan.
	***************************************************************************/
	function saveNewGrupoEmprendeClan($id_clan,$id_area_artistica,$id_modalidad,$id_usuario,$observaciones,$tipo_grupo){
		global $db_siclan;
		$id_grupo = $db_siclan->max("tb_terr_grupo_emprende_clan","PK_Grupo");
		$id_grupo++;
		date_default_timezone_set('America/Bogota');
		$db_siclan->insert("tb_terr_grupo_emprende_clan",[
			"PK_Grupo"=>$id_grupo,
			"FK_clan"=>$id_clan,
			"FK_area_artistica"=>$id_area_artistica,
			"FK_modalidad"=>$id_modalidad,
			"DT_fecha_creacion"=>date('Y-m-d H:i:s'),
			"FK_creador"=>$id_usuario,
			"estado"=>1,
			"TX_observaciones"=>$observaciones,
			"tipo_grupo"=>$tipo_grupo
			]);
		return $id_grupo;
	}

	/***************************************************************************
	/* getGruposActivosArteEnLaEscuelaByClan() consulta los grupos de la base de datos que estan activos en la linea de atención arte en la escuela según un clan.
	***************************************************************************/
	function getGruposActivosArteEnLaEscuelaByClan($id_clan){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_arte_escuela",
			[
			"[>]tb_colegios"=>["FK_colegio"=>"PK_Id_Colegio"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],
			[
			"tb_terr_grupo_arte_escuela.PK_Grupo",
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_organizaciones_2017.VC_Nom_Organizacion",
			"tb_terr_grupo_arte_escuela.FK_artista_formador",
			"tb_colegios.VC_Nom_Colegio",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido"
			],

			["AND"=>["FK_clan"=>$id_clan,"estado"=>1]]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposActivosEmprendeClanByClan() consulta los grupos de la base de datos que estan activos en la linea de atención emprende clan, según un clan.
	***************************************************************************/
	function getGruposActivosEmprendeClanByClan($id_clan){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_emprende_clan",
			[
			"[>]tb_modalidad"=>["FK_modalidad"=>"PK_Id_Modalidad"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],
			[
			"tb_terr_grupo_emprende_clan.PK_Grupo",
			"tb_terr_grupo_emprende_clan.tipo_grupo",
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_organizaciones_2017.VC_Nom_Organizacion",
			"tb_terr_grupo_emprende_clan.FK_artista_formador",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_modalidad.VC_Nom_Modalidad"
			],
			["AND"=>["FK_clan"=>$id_clan,"estado"=>1]]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposActivosLaboratorioClanByClan() consulta los grupos de la base de datos que estan activos en la linea de atención laboratorio clan, según un clan.
	***************************************************************************/
	function getGruposActivosLaboratorioClanByClan($id_clan){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_laboratorio_clan",
			[
			"[>]tb_terr_lugar_atencion_laboratorio_clan"=>["FK_lugar_atencion"=>"PK_lugar_atencion"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],
			[
			"tb_terr_grupo_laboratorio_clan.PK_Grupo",
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_organizaciones_2017.VC_Nom_Organizacion",
			"tb_terr_grupo_laboratorio_clan.FK_artista_formador",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_terr_lugar_atencion_laboratorio_clan.VC_Nombre_Lugar",
			"tb_terr_grupo_laboratorio_clan.tipo_poblacion"
			],
			["AND"=>["tb_terr_grupo_laboratorio_clan.FK_clan"=>$id_clan,"tb_terr_grupo_laboratorio_clan.estado"=>1]]);
		return $grupo;
	}

	/***************************************************************************
	/* buscaEstudiante() retorna todos los estudiantes en tb_acudientes con nombre o identificacion que coincide con el texto
	***************************************************************************/
	function buscaEstudianteEnMatricula2016($texto){
		global $db_siclan;
		$texto = strtoupper($texto);
		$estudiante = $db_siclan->query( "SELECT NRO_DOCUMENTO AS  IN_Identificacion_Estudiante,CONCAT(NOMBRE1,' ',NOMBRE2,' ',APELLIDO1,' ',APELLIDO2) AS NOMBRE
			FROM tb_2017_matricula
			WHERE (CONCAT(NOMBRE1,' ',NOMBRE2,' ',APELLIDO1,' ',APELLIDO2)
			LIKE '%".$texto."%' OR NRO_DOCUMENTO LIKE '%".$texto."%');"
			)->fetchAll(PDO::FETCH_ASSOC);
		return $estudiante;
	}

	/***************************************************************************
	/* buscaEstudianteEnTablaEstudiante() retorna todos los estudiantes en tb_estudiante registrados por FORMULARIO con nombre que coincide con el texto
	***************************************************************************/
	function buscaEstudianteEnTablaEstudiante($texto){
		global $db_siclan;
		$texto = strtoupper($texto);
		$estudiante = $db_siclan->query(
			"SELECT IN_Identificacion,CONCAT(VC_Primer_Nombre,' ',VC_Segundo_Nombre,' ',VC_Primer_Apellido,' ',VC_Segundo_Apellido) AS NOMBRE
			FROM tb_estudiante
			WHERE ((CONCAT(VC_Primer_Nombre,' ',VC_Segundo_Nombre,' ',VC_Primer_Apellido,' ',VC_Segundo_Apellido)
			LIKE '%".$texto."%' OR IN_Identificacion LIKE '%".$texto."%') AND VC_Tipo_Estudiante='FORMULARIO');"
			)->fetchAll(PDO::FETCH_ASSOC);
		return $estudiante;
	}


	function verificarExistenciaEstudiante($id_estudiante){
		global $db_siclan;
		$estudiante = $db_siclan->select("tb_estudiante","IN_Identificacion",["IN_Identificacion"=>$id_estudiante]);
		return $estudiante;
	}

	function getDatosEstudianteTablaMatricula($id_estudiante){
		global $db_siclan;
		$datos_estudiante = $db_siclan->select("tb_2017_matricula",[
			"TIPO_DOCUMENTO",
			"NOMBRE1",
			"NOMBRE2",
			"APELLIDO1",
			"APELLIDO2",
			"FECHA_NACIMIENTO",
			"GENERO",
			"DIRECCION_RESIDENCIA",
			"TEL",
			"POB_VICT_CONF",
			"ETNIA",
			"TIPO_DISCAPACIDAD"
			],["NRO_DOCUMENTO"=>$id_estudiante]);
		return $datos_estudiante;
	}

	function insertEstudianteNuevo($IN_Identificacion,$CH_Tipo_Identificacion,$VC_Primer_Nombre,$VC_Segundo_Nombre,$VC_Primer_Apellido,$VC_Segundo_Apellido,$DD_F_Nacimiento,$CH_Genero,$VC_Direccion,$VC_Correo,$VC_Telefono,$VC_Celular,$Id_Usuario_Registro){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$insert = $db_siclan->insert("tb_estudiante",[
			"IN_Identificacion" => $IN_Identificacion,
			"CH_Tipo_Identificacion" => $CH_Tipo_Identificacion,
			"VC_Primer_Nombre" => $VC_Primer_Nombre,
			"VC_Segundo_Nombre" => $VC_Segundo_Nombre,
			"VC_Primer_Apellido" => $VC_Primer_Apellido,
			"VC_Segundo_Apellido" => $VC_Segundo_Apellido,
			"DD_F_Nacimiento" => $DD_F_Nacimiento,
			"CH_Genero" => $CH_Genero,
			"VC_Direccion" => $VC_Direccion,
			"VC_Correo" => $VC_Correo,
			"VC_Telefono" => $VC_Telefono,
			"VC_Celular" => $VC_Celular,
			"VC_Tipo_Estudiante" => "matricula",
			"DA_Fecha_Registro"=> date('Y-m-d H:i:s'),
			"Id_Usuario_Registro" => $Id_Usuario_Registro
			]);
		return $insert;
	}

	function insertEstudianteNuevoDetalle(
		$id_estudiante,
		$id_clan,
		$id_colegio,
		$id_grado,
		$jornada,
		$nombre_acudiente,
		$identificacion_acudiente,
		$telefono_acudiente,
		$id_usuario,
		$id_poblacion_victima,
		$etnia,
		$id_tipo_discapacidad
		){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$insert = $db_siclan->insert("tb_estudiante_detalle_anio",[
			"FK_estudiante"=>$id_estudiante,
			"anio"=>2017,
			"FK_clan"=>$id_clan,
			"FK_colegio"=>$id_colegio,
			"FK_grado"=>$id_grado,
			"jornada"=>$jornada,
			"NOMBRE_ACUDIENTE"=>$nombre_acudiente,
			"IDENTIFICACION_ACUDIENTE"=>$identificacion_acudiente,
			"TELEFONO_ACUDIENTE"=>$telefono_acudiente,
			"FK_tipo_poblacion_victima" => $id_poblacion_victima,
			"TX_etnia" => $etnia,
			"FK_tipo_discapacidad" => $id_tipo_discapacidad,
			"DA_fecha_creacion"=>date('Y-m-d H:i:s'),
			"FK_usuario_creacion"=>$id_usuario
			]);
	}

	/***************************************************************************
	/* saveEstudianteGrupoArteEscuela() guarda un nuevo estudiante en el grupo de arte en la escuela especificado.
	***************************************************************************/
	function saveEstudianteGrupoArteEscuela($id_grupo,$id_estudiante,$id_usuario,$observaciones){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$insert = $db_siclan->insert("tb_terr_grupo_arte_escuela_estudiante",[
			"FK_grupo"=>$id_grupo,
			"FK_estudiante"=>$id_estudiante,
			"DT_fecha_ingreso"=>date('Y-m-d H:i:s'),
			"FK_usuario_ingreso"=>$id_usuario,
			"estado"=>1,
			"TX_observaciones"=>$observaciones
			]);
		return $insert;
	}

	/***************************************************************************
	/* saveEstudianteGrupoEmprendeClan() guarda un nuevo estudiante en el grupo de emprende clan especificado.
	***************************************************************************/
	function saveEstudianteGrupoEmprendeClan($id_grupo,$id_estudiante,$id_usuario,$observaciones){
		global $db_siclan;

		date_default_timezone_set('America/Bogota');
		$insert = $db_siclan->insert("tb_terr_grupo_emprende_clan_estudiante",[
			"FK_grupo"=>$id_grupo,
			"FK_estudiante"=>$id_estudiante,
			"DT_fecha_ingreso"=>date('Y-m-d H:i:s'),
			"FK_usuario_ingreso"=>$id_usuario,
			"estado"=>1,
			"TX_observaciones"=>$observaciones
			]);
		return $insert;
	}

	/***************************************************************************
	/* saveEstudianteGrupoLaboratorioClan() guarda un nuevo estudiante en el grupo de laboratorio clan especificado.
	***************************************************************************/
	function saveEstudianteGrupoLaboratorioClan($id_grupo,$id_estudiante,$id_usuario,$observaciones){
		global $db_siclan;

		date_default_timezone_set('America/Bogota');
		$insert = $db_siclan->insert("tb_terr_grupo_laboratorio_clan_estudiante",[
			"FK_grupo"=>$id_grupo,
			"FK_estudiante"=>$id_estudiante,
			"DT_fecha_ingreso"=>date('Y-m-d H:i:s'),
			"FK_usuario_ingreso"=>$id_usuario,
			"estado"=>1,
			"TX_observaciones"=>$observaciones
			]);
		return $insert;
	}

	/***************************************************************************
	/* getCountEstudiantesGrupoArteEscuela() consulta el número de estudiantes que se encuentran en un grupo especifico de arte en la escuela.
	***************************************************************************/
	function getCountEstudiantesGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$total_estudiantes_en_grupo = $db_siclan->query("SELECT COUNT(FK_estudiante) FROM tb_terr_grupo_arte_escuela_estudiante WHERE estado = 1 AND FK_grupo = ".$id_grupo)->fetchAll();
		return $total_estudiantes_en_grupo[0][0];
	}

	/***************************************************************************
	/* getCountAsistenciaGrupoArteEscuelaMesActual() consulta el número de estudiantes que se atendieron en el mes anterior a la fecha de la consulta.
	***************************************************************************/
	function getCountAsistenciaGrupoArteEscuelaMesActual($id_grupo){
		global $db_siclan;
		$total_estudiantes_en_grupo = $db_siclan->query("SELECT

			COUNT(DISTINCT SCA.FK_estudiante)
			FROM tb_terr_grupo_arte_escuela_sesion_clase SC
			JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA ON SCA.`FK_sesion_clase` = SC.`PK_sesion_clase`
			JOIN `tb_terr_grupo_arte_escuela_estudiante` GAEE ON GAEE.`FK_grupo` = SC.`FK_grupo` AND GAEE.`FK_estudiante` = SCA.`FK_estudiante`
			WHERE SCA.`IN_estado_asistencia`= 1 AND MONTH(SC.`DA_fecha_clase`) = MONTH(CURDATE())  AND SC.`FK_grupo` = ".$id_grupo)->fetchAll();
		return $total_estudiantes_en_grupo[0][0];
	}

	/***************************************************************************
	/* getCountAsistenciaGrupoEmprendeClanMesActual() consulta el número de estudiantes que se atendieron en el mes anterior a la fecha de la consulta.
	***************************************************************************/
	function getCountAsistenciaGrupoEmprendeClanMesActual($id_grupo){
		global $db_siclan;
		$total_estudiantes_en_grupo = $db_siclan->query("SELECT

			COUNT(DISTINCT SCA.FK_estudiante)
			FROM tb_terr_grupo_emprende_clan_sesion_clase SC
			JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA ON SCA.`FK_sesion_clase` = SC.`PK_sesion_clase`
			JOIN `tb_terr_grupo_emprende_clan_estudiante` GECE ON GECE.`FK_grupo` = SC.`FK_grupo` AND GECE.`FK_estudiante` = SCA.`FK_estudiante`
			WHERE SCA.`IN_estado_asistencia`= 1 AND MONTH(SC.`DA_fecha_clase`) = MONTH(CURDATE())  AND SC.`FK_grupo` = ".$id_grupo)->fetchAll();
		return $total_estudiantes_en_grupo[0][0];
	}

	/***************************************************************************
	/* getCountEstudiantesGrupoEmprendeClan() consulta el número de estudiantes que se encuentran en un grupo especifico de emprende Clan.
	***************************************************************************/
	function getCountEstudiantesGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$total_estudiantes_en_grupo = $db_siclan->query("SELECT COUNT(FK_estudiante) FROM tb_terr_grupo_emprende_clan_estudiante WHERE estado = 1 AND FK_grupo = ".$id_grupo)->fetchAll();
		return $total_estudiantes_en_grupo[0][0];
	}

	/***************************************************************************
	/* getCountEstudiantesGrupoLaboratorioClan() consulta el número de estudiantes que se encuentran en un grupo especifico de Laboratorio Clan.
	***************************************************************************/
	function getCountEstudiantesGrupoLaboratorioClan($id_grupo){
		global $db_siclan;
		$total_estudiantes_en_grupo = $db_siclan->query("SELECT COUNT(FK_estudiante) FROM tb_terr_grupo_laboratorio_clan_estudiante WHERE estado = 1 AND FK_grupo = ".$id_grupo)->fetchAll();
		return $total_estudiantes_en_grupo[0][0];
	}

	/***************************************************************************
	/* closeGrupoEmprendeClan() pone el registro del grupo en estado 0, con su respectiva justificación y el usuario que lo cierra.
	***************************************************************************/
	function closeGrupoEmprendeClan($id_grupo,$justificacion,$id_usuario){
		global $db_siclan;
		$observacion = $db_siclan->select("tb_terr_grupo_emprende_clan",["TX_observaciones"],["PK_Grupo"=>$id_grupo]);
		$observacion = $observacion[0]['TX_observaciones'];

		date_default_timezone_set('America/Bogota');
		$update = $db_siclan->update("tb_terr_grupo_emprende_clan",[
			"estado"=>0,
			"TX_observaciones"=>$observacion." - ".$justificacion,
			"FK_quien_cerro"=>$id_usuario,
			"DT_fecha_cierre"=>date('Y-m-d H:i:s')
			],
			[
			"PK_Grupo"=>$id_grupo
			]);
		closeEstudiantesGrupoEmprendeClan($id_grupo,$justificacion,$id_usuario);
		return $update;
	}

	/***************************************************************************
	/* closeGrupolaboratorioClan() pone el registro del grupo en estado 0, con su respectiva justificación y el usuario que lo cierra.
	***************************************************************************/
	function closeGrupoLaboratorioClan($id_grupo,$justificacion,$id_usuario){
		global $db_siclan;
		$observacion = $db_siclan->select("tb_terr_grupo_laboratorio_clan",["TX_observaciones"],["PK_Grupo"=>$id_grupo]);
		$observacion = $observacion[0]['TX_observaciones'];

		date_default_timezone_set('America/Bogota');
		$update = $db_siclan->update("tb_terr_grupo_laboratorio_clan",[
			"estado"=>0,
			"TX_observaciones"=>$observacion." - ".$justificacion,
			"FK_quien_cerro"=>$id_usuario,
			"DT_fecha_cierre"=>date('Y-m-d H:i:s')
			],
			[
			"PK_Grupo"=>$id_grupo
			]);
		closeEstudiantesGrupolaboratorioClan($id_grupo,$justificacion,$id_usuario);
		return $update;
	}

	/***************************************************************************
	/* closeGrupoArteEscuela() pone el registro del grupo en estado 0, con su respectiva justificación y el usuario que lo cierra.
	***************************************************************************/
	function closeGrupoArteEscuela($id_grupo,$justificacion,$id_usuario){
		global $db_siclan;
		$observacion = $db_siclan->select("tb_terr_grupo_arte_escuela",["TX_observaciones"],["PK_Grupo"=>$id_grupo]);
		$observacion = $observacion[0]['TX_observaciones'];

		date_default_timezone_set('America/Bogota');
		$update = $db_siclan->update("tb_terr_grupo_arte_escuela",[
			"estado"=>0,
			"TX_observaciones"=>$observacion." - ".$justificacion,
			"FK_quien_cerro"=>$id_usuario,
			"DT_fecha_cierre"=>date('Y-m-d H:i:s')
			],
			[
			"PK_Grupo"=>$id_grupo
			]);
		closeEstudiantesGrupoArteEscuela($id_grupo,$justificacion,$id_usuario);
		return $update;
	}

	/***************************************************************************
	/* closeEstudiantesGrupoArteEscuela() pone el registro del estudiante en estado 0, con su respectiva justificación y el usuario que lo cierra, tras haber cerrado un grupo de arte en la escuela satisfactoriamente.
	***************************************************************************/
	function closeEstudiantesGrupoArteEscuela($id_grupo,$justificacion,$id_usuario){
		global $db_siclan;

		date_default_timezone_set('America/Bogota');
		$update = $db_siclan->update("tb_terr_grupo_arte_escuela_estudiante",[
			"estado"=>0,
			"FK_usuario_retiro"=>$id_usuario,
			"DT_fecha_retiro"=>date('Y-m-d H:i:s'),
			"TX_observaciones"=>"Cierre de Grupo (".$justificacion.")"
			],[
			"FK_grupo"=>$id_grupo
			]);
		return $update;
	}

	/***************************************************************************
	/* closeEstudiantesGrupoEmprendeClan() pone el registro del estudiante en estado 0, con su respectiva justificación y el usuario que lo cierra, tras haber cerrado un grupo de emprende clan satisfactoriamente.
	***************************************************************************/
	function closeEstudiantesGrupoEmprendeClan($id_grupo,$justificacion,$id_usuario){
		global $db_siclan;

		date_default_timezone_set('America/Bogota');
		$update = $db_siclan->update("tb_terr_grupo_emprende_clan_estudiante",[
			"estado"=>0,
			"FK_usuario_retiro"=>$id_usuario,
			"DT_fecha_retiro"=>date('Y-m-d H:i:s'),
			"TX_observaciones"=>"Cierre de Grupo (".$justificacion.")"
			],[
			"FK_grupo"=>$id_grupo
			]);
		return $update;
	}

	/***************************************************************************
	/* closeEstudiantesGrupolaboratorioClan() pone el registro del estudiante en estado 0, con su respectiva justificación y el usuario que lo cierra, tras haber cerrado un grupo de laboratorio clan satisfactoriamente.
	***************************************************************************/
	function closeEstudiantesGrupoLaboratorioClan($id_grupo,$justificacion,$id_usuario){
		global $db_siclan;

		date_default_timezone_set('America/Bogota');
		$update = $db_siclan->update("tb_terr_grupo_laboratorio_clan_estudiante",[
			"estado"=>0,
			"FK_usuario_retiro"=>$id_usuario,
			"DT_fecha_retiro"=>date('Y-m-d H:i:s'),
			"TX_observaciones"=>"Cierre de Grupo (".$justificacion.")"
			],[
			"FK_grupo"=>$id_grupo
			]);
		return $update;
	}

	/***************************************************************************
	/* getDatosGrupoArteEscuela() Obtiene los datos de un grupo especifico de arte en la escuela.
	***************************************************************************/
	function getDatosGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_arte_escuela","*",["PK_Grupo"=>$id_grupo]);
		return $grupo;
	}

	/***************************************************************************
	/* getDatosGrupoEmprendeClan() Obtiene los datos de un grupo especifico de Emprende Clan.
	***************************************************************************/
	function getDatosGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_emprende_clan","*",["PK_Grupo"=>$id_grupo]);
		return $grupo;
	}

	/***************************************************************************
	/* getDatosEstudiantesGrupoArteEscuela() Obtiene los datos de los estudiantes que estan asociados a un grupo especifico de arte en la escuela.
	***************************************************************************/
	function getDatosEstudianteGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$estudiante = $db_siclan->select("tb_terr_grupo_arte_escuela_estudiante","*",[
			"AND"=>["FK_grupo"=>$id_grupo,
			"estado"=>1]]
			);
		return $estudiante;
	}

	/***************************************************************************
	/* getDatosEstudiantesGrupoEmprendeClan() Obtiene los datos de los estudiantes que estan asociados a un grupo especifico de Emprende Clan.
	***************************************************************************/
	function getDatosEstudianteGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$estudiante = $db_siclan->select("tb_terr_grupo_emprende_clan_estudiante","*",[
			"AND"=>["FK_grupo"=>$id_grupo,
			"estado"=>1]]
			);
		return $estudiante;
	}

	/***************************************************************************
	/* getEstudiantesGrupoEmprendeClan() consulta los estudiantes que se encuentran en un grupo especifico de emprende clan.
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
	/* getEstudiantesGrupoLaboratorioClan() consulta los estudiantes que se encuentran en un grupo especifico de laboratorio clan.
	***************************************************************************/
	function getEstudiantesGrupoLaboratorioClan($id_grupo){
		global $db_siclan;
		$estudiante = $db_siclan->select("tb_terr_grupo_laboratorio_clan_estudiante",
			[
			"[>]tb_estudiante"=>["FK_estudiante"=>"id"]
			],
			[
			"tb_estudiante.IN_Identificacion",
			"tb_estudiante.VC_Primer_Nombre",
			"tb_estudiante.VC_Segundo_Nombre",
			"tb_estudiante.VC_Primer_Apellido",
			"tb_estudiante.VC_Segundo_Apellido",
			"tb_terr_grupo_laboratorio_clan_estudiante.FK_estudiante",
			"tb_terr_grupo_laboratorio_clan_estudiante.FK_grupo",
			"tb_terr_grupo_laboratorio_clan_estudiante.DT_fecha_ingreso"
			],
			["AND"=>["FK_grupo"=>$id_grupo,"estado"=>1]]);
		return $estudiante;
	}

	/***************************************************************************
	/* getEstudiantesGrupoArteEscuela() consulta los estudiantes que se encuentran en un grupo especifico de arte en la escuela.
	***************************************************************************/
	function getEstudiantesGrupoArteEscuela($id_grupo){
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
			"tb_estudiante.VC_Telefono",
			"tb_estudiante.VC_Celular",
			"tb_terr_grupo_arte_escuela_estudiante.FK_estudiante",
			"tb_terr_grupo_arte_escuela_estudiante.FK_grupo",
			"tb_terr_grupo_arte_escuela_estudiante.DT_fecha_ingreso"
			],
			["AND"=>["FK_grupo"=>$id_grupo,"estado"=>1]]);
		return $estudiante;
	}

	/***************************************************************************
	/* getAllEstudiantesGrupoEmprendeClan() consulta los estudiantes que se encuentran en un grupo especifico de emprende clan.
	***************************************************************************/
	function getAllEstudiantesGrupoEmprendeClan($id_grupo){
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
			"tb_estudiante.VC_Telefono",
			"tb_estudiante.VC_Celular",
			"tb_terr_grupo_emprende_clan_estudiante.FK_estudiante",
			"tb_terr_grupo_emprende_clan_estudiante.FK_grupo",
			"tb_terr_grupo_emprende_clan_estudiante.DT_fecha_ingreso",
			"tb_terr_grupo_emprende_clan_estudiante.estado"
			],
			["AND"=>["FK_grupo"=>$id_grupo]]);
		return $estudiante;
	}

	/***************************************************************************
	/* getAllEstudiantesGrupoLaboratorioClan() consulta los estudiantes que se encuentran en un grupo especifico de laboratorio clan.
	***************************************************************************/
	function getAllEstudiantesGrupoLaboratorioClan($id_grupo){
		global $db_siclan;
		$estudiante = $db_siclan->select("tb_terr_grupo_laboratorio_clan_estudiante",
			[
			"[>]tb_estudiante"=>["FK_estudiante"=>"id"]
			],
			[
			"tb_estudiante.IN_Identificacion",
			"tb_estudiante.VC_Primer_Nombre",
			"tb_estudiante.VC_Segundo_Nombre",
			"tb_estudiante.VC_Primer_Apellido",
			"tb_estudiante.VC_Segundo_Apellido",
			"tb_estudiante.VC_Telefono",
			"tb_estudiante.VC_Celular",
			"tb_terr_grupo_laboratorio_clan_estudiante.FK_estudiante",
			"tb_terr_grupo_laboratorio_clan_estudiante.FK_grupo",
			"tb_terr_grupo_laboratorio_clan_estudiante.DT_fecha_ingreso",
			"tb_terr_grupo_laboratorio_clan_estudiante.estado"
			],
			["AND"=>["FK_grupo"=>$id_grupo]]);
		return $estudiante;
	}

	/***************************************************************************
	/* getAllEstudiantesGrupoArteEscuela() consulta los estudiantes que se encuentran en un grupo especifico de arte en la escuela.
	***************************************************************************/
	function getAllEstudiantesGrupoArteEscuela($id_grupo){
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
			"tb_terr_grupo_arte_escuela_estudiante.DT_fecha_ingreso",
			"tb_terr_grupo_arte_escuela_estudiante.estado"
			],
			["AND"=>["FK_grupo"=>$id_grupo]]);
		return $estudiante;
	}

	/***************************************************************************
	/* get_All_Caracterizaciones_Grupo_Arte_Escuela() consulta las caracterizaciones realizadas para un grupo de arte en la escuela.
	***************************************************************************/
	function get_All_Caracterizaciones_Grupo_Arte_Escuela($id_grupo){
		global $db_siclan;
		$caracterizacion = $db_siclan->query("SELECT * FROM tb_caracterizacion_grupo C WHERE C.FK_Id_Linea_Atencion='arte_escuela' AND FK_Grupo=".$id_grupo." AND YEAR(DA_Fecha_Registro) < 2019");
		return $caracterizacion;
	}

	/***************************************************************************
	/* get_All_Caracterizaciones_Grupo_Emprende_Clan() consulta las caracterizaciones realizadas para un grupo de Emprende Clan.
	***************************************************************************/
	function get_All_Caracterizaciones_Grupo_Emprende_Clan($id_grupo){
		global $db_siclan;
		$caracterizacion = $db_siclan->query("SELECT * FROM tb_caracterizacion_grupo C WHERE C.FK_Id_Linea_Atencion='emprende_clan' AND FK_Grupo=".$id_grupo." AND YEAR(DA_Fecha_Registro) < 2019");
		return $caracterizacion;
	}

	/***************************************************************************
	/* get_All_Caracterizaciones_Grupo_Laboratorio_Clan() consulta las caracterizaciones realizadas para un grupo de Laboratorio Clan.
	***************************************************************************/
	function get_All_Caracterizaciones_Grupo_Laboratorio_Clan($id_grupo){
		global $db_siclan;
		$caracterizacion = $db_siclan->query("SELECT * FROM tb_caracterizacion_grupo C WHERE C.FK_Id_Linea_Atencion='laboratorio_clan' AND FK_Grupo=".$id_grupo." AND YEAR(DA_Fecha_Registro) < 2019");
		return $caracterizacion;
	}

	/***************************************************************************
	/* getPlaneacionesGrupoArteEscuela() consulta las Planeacion realizadas para un grupo de arte en la escuela.
	***************************************************************************/
	function getPlaneacionesGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$planeacion = $db_siclan->query("SELECT * FROM tb_planeacion_grupo P WHERE P.FK_Id_Linea_Atencion='arte_escuela' AND FK_Grupo=".$id_grupo." AND YEAR(DA_Fecha_Registro) < 2019");
		return $planeacion;
	}

	/***************************************************************************
	/* getPlaneacionesGrupoEmprendeClan() consulta las Planeacion realizadas para un grupo de emprende clan.
	***************************************************************************/
	function getPlaneacionesGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$planeacion = $db_siclan->query("SELECT * FROM tb_planeacion_grupo P WHERE P.FK_Id_Linea_Atencion='emprende_clan' AND FK_Grupo=".$id_grupo." AND YEAR(DA_Fecha_Registro) < 2019");
		return $planeacion;
	}

	/***************************************************************************
	/* getPlaneacionesGrupoLaboratorioClan() consulta las Planeacion realizadas para un grupo de laboratorio crea.
	***************************************************************************/
	function getPlaneacionesGrupoLaboratorioClan($id_grupo){
		global $db_siclan;
		$planeacion = $db_siclan->query("SELECT * FROM tb_planeacion_grupo P WHERE P.FK_Id_Linea_Atencion='laboratorio_clan' AND FK_Grupo=".$id_grupo." AND YEAR(DA_Fecha_Registro) < 2019");
		return $planeacion;
	}

	/***************************************************************************
	/* getValoracionesList() consulta las valoraciones realizadas para un grupo de emprende clan.
	***************************************************************************/
	function getValoracionesList($id_grupo,$lineaAtencion){
		global $db_siclan;
		$valoracion = $db_siclan->select("tb_valoracion_grupo","*",["AND"=>["FK_Linea_Atencion"=>$lineaAtencion,"FK_Grupo"=>$id_grupo]]);
		return $valoracion;
	}

	/***************************************************************************
	/* desactivarEstudianteGrupoEmprendeClan() desactiva un estudiante de un grupo emprende clan.
	***************************************************************************/
	function desactivarEstudianteGrupoEmprendeClan($id_estudiante,$id_grupo,$id_usuario,$justificacion){
		global $db_siclan;
		$observacion = $db_siclan->select("tb_terr_grupo_emprende_clan_estudiante",["TX_observaciones"],["AND"=>["FK_grupo"=>$id_grupo,"FK_estudiante"=>$id_estudiante]]);
		$observacion = $observacion[0]['TX_observaciones']." - Retiro individual de estudiante realizado por: ".$justificacion;

		date_default_timezone_set('America/Bogota');

		$update = $db_siclan->update("tb_terr_grupo_emprende_clan_estudiante",[
			"estado"=>0,
			"FK_usuario_retiro"=>$id_usuario,
			"DT_fecha_retiro"=>date('Y-m-d H:i:s'),
			"TX_observaciones"=>$observacion
			],[
			"AND"=>["FK_grupo"=>$id_grupo,"FK_estudiante"=>$id_estudiante]
			]);
		return $update;
	}

	/***************************************************************************
	/* desactivarEstudianteGrupoLaboratorioClan() desactiva un estudiante de un grupo Laboratorio clan.
	***************************************************************************/
	function desactivarEstudianteGrupoLaboratorioClan($id_estudiante,$id_grupo,$id_usuario,$justificacion){
		global $db_siclan;
		$observacion = $db_siclan->select("tb_terr_grupo_laboratorio_clan_estudiante",["TX_observaciones"],["AND"=>["FK_grupo"=>$id_grupo,"FK_estudiante"=>$id_estudiante]]);
		$observacion = $observacion[0]['TX_observaciones']." - Retiro individual de estudiante realizado por: ".$justificacion;

		date_default_timezone_set('America/Bogota');

		$update = $db_siclan->update("tb_terr_grupo_laboratorio_clan_estudiante",[
			"estado"=>0,
			"FK_usuario_retiro"=>$id_usuario,
			"DT_fecha_retiro"=>date('Y-m-d H:i:s'),
			"TX_observaciones"=>$observacion
			],[
			"AND"=>["FK_grupo"=>$id_grupo,"FK_estudiante"=>$id_estudiante]
			]);
		return $update;
	}

	/***************************************************************************
	/* desactivarEstudianteGrupoArteEscuela() desactiva un estudiante de un grupo arte en la escuela.
	***************************************************************************/
	function desactivarEstudianteGrupoArteEscuela($id_estudiante,$id_grupo,$id_usuario,$justificacion){
		global $db_siclan;
		$observacion = $db_siclan->select("tb_terr_grupo_arte_escuela_estudiante",["TX_observaciones"],["AND"=>["FK_grupo"=>$id_grupo,"FK_estudiante"=>$id_estudiante]]);
		$observacion = $observacion[0]['TX_observaciones']." - Retiro individual de estudiante realizado por: ".$justificacion;

		date_default_timezone_set('America/Bogota');

		$update = $db_siclan->update("tb_terr_grupo_arte_escuela_estudiante",[
			"estado"=>0,
			"FK_usuario_retiro"=>$id_usuario,
			"DT_fecha_retiro"=>date('Y-m-d H:i:s'),
			"TX_observaciones"=>$observacion
			],[
			"AND"=>["FK_grupo"=>$id_grupo,"FK_estudiante"=>$id_estudiante]
			]);
		return $update;
	}

	/***************************************************************************
	/* getGruposActivosSinOrganizacionArteEscuela() selecciona todos los grupos de arte en la escuela que se encuentren activos y no tengan asignada una organización.
	***************************************************************************/
	function getGruposActivosSinOrganizacionArteEscuela(){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_arte_escuela",[
			"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"],
			"[>]tb_colegios"=>["FK_colegio"=>"PK_Id_Colegio"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],[

			"tb_clan.VC_Nom_Clan",
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_colegios.VC_Nom_Colegio",
			"tb_terr_grupo_arte_escuela.PK_grupo",
			"tb_terr_grupo_arte_escuela.DT_fecha_creacion",
			"tb_terr_grupo_arte_escuela.TX_observaciones",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_organizaciones_2017.VC_Nom_Organizacion"
			],["estado"=>1]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposActivosSinOrganizacionEmprendeClan() selecciona todos los grupos de emprende clan que se encuentren activos y no tengan asignada una organización.
	***************************************************************************/
	function getGruposActivosSinOrganizacionEmprendeClan(){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_emprende_clan",[
			"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"],
			"[>]tb_modalidad"=>["FK_modalidad"=>"PK_Id_Modalidad"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],[

			"tb_clan.VC_Nom_Clan",
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_modalidad.VC_Nom_Modalidad",
			"tb_terr_grupo_emprende_clan.PK_grupo",
			"tb_terr_grupo_emprende_clan.DT_fecha_creacion",
			"tb_terr_grupo_emprende_clan.TX_observaciones",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_organizaciones_2017.VC_Nom_Organizacion"
			],[
			"AND"=>["estado"=>1]
			]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposActivosSinOrganizacionLaboratorioClan() selecciona todos los grupos de laboratorio clan que se encuentren activos y no tengan asignada una organización.
	***************************************************************************/
	function getGruposActivosSinOrganizacionLaboratorioClan(){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_laboratorio_clan",[
			"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"],
			"[>]tb_terr_lugar_atencion_laboratorio_clan"=>["FK_lugar_atencion"=>"PK_lugar_atencion"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],[

			"tb_clan.VC_Nom_Clan",
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_terr_lugar_atencion_laboratorio_clan.VC_Nombre_Lugar",
			"tb_terr_grupo_laboratorio_clan.PK_grupo",
			"tb_terr_grupo_laboratorio_clan.DT_fecha_creacion",
			"tb_terr_grupo_laboratorio_clan.TX_observaciones",
			"tb_terr_grupo_laboratorio_clan.tipo_poblacion",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_organizaciones_2017.VC_Nom_Organizacion"
			],[
				"tb_terr_grupo_laboratorio_clan.estado"=>1
			]);
		return $grupo;
	}

	/***************************************************************************
	/* getOrganizaciones() selecciona las organizaciones que existen en el sistema.
	***************************************************************************/
	function getOrganizaciones(){
		global $db_siclan;
		$organizacion = $db_siclan->select("tb_organizaciones_2017","*");
		return ($organizacion);
	}

	/***************************************************************************
	/* setGrupoArteEscuelaOrganizacion() actualiza la organización de un grupo de arte en la escuela.
	***************************************************************************/
	function setGrupoArteEscuelaOrganizacion($id_grupo,$id_organizacion,$id_usuario){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$bitacora = $db_siclan->insert("tb_terr_grupo_arte_escuela_organizacion",[
			"FK_grupo"=>$id_grupo,
			"FK_organizacion"=>$id_organizacion,
			"FK_usuario_asigno"=>$id_usuario,
			"DT_fecha_asignacion_grupo"=>date('Y-m-d H:i:s')
			]);
		$update = $db_siclan->update("tb_terr_grupo_arte_escuela",[
			"FK_organizacion"=>$id_organizacion
			],[
			"PK_Grupo"=>$id_grupo
			]);
		return $update;
	}

	/***************************************************************************
	/* setGrupoEmprendeClanOrganizacion() actualiza la organización de un grupo emprende clan.
	***************************************************************************/
	function setGrupoEmprendeClanOrganizacion($id_grupo,$id_organizacion,$id_usuario){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$bitacora = $db_siclan->insert("tb_terr_grupo_emprende_clan_organizacion",[
			"FK_grupo"=>$id_grupo,
			"FK_organizacion"=>$id_organizacion,
			"FK_usuario_asigno"=>$id_usuario,
			"DT_fecha_asignacion_grupo"=>date('Y-m-d H:i:s')
			]);
		$update = $db_siclan->update("tb_terr_grupo_emprende_clan",[
			"FK_organizacion"=>$id_organizacion
			],[
			"PK_Grupo"=>$id_grupo
			]);
		return $update;
	}

	/***************************************************************************
	/* setGrupoLaboratorioClanOrganizacion() actualiza la organización de un grupo laboratorio clan.
	***************************************************************************/
	function setGrupoLaboratorioClanOrganizacion($id_grupo,$id_organizacion,$id_usuario){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$bitacora = $db_siclan->insert("tb_terr_grupo_laboratorio_clan_organizacion",[
			"FK_grupo"=>$id_grupo,
			"FK_organizacion"=>$id_organizacion,
			"FK_usuario_asigno"=>$id_usuario,
			"DT_fecha_asignacion_grupo"=>date('Y-m-d H:i:s')
			]);
		$update = $db_siclan->update("tb_terr_grupo_laboratorio_clan",[
			"FK_organizacion"=>$id_organizacion
			],[
			"PK_Grupo"=>$id_grupo
			]);
		return $update;
	}

	/***************************************************************************
	/* getOrganizacionGruposSinArtistaFormadorArteEscuela() consulta los datos de organizaciones que tienen grupos de arte en la escuela activos sin Artista formador asignado
	***************************************************************************/
	function getOrganizacionGruposSinArtistaFormadorArteEscuela(){
		global $db_siclan;
		$organizacion = $db_siclan->query("SELECT DISTINCT O.PK_Id_Organizacion, O.VC_Nom_Organizacion
			FROM tb_terr_grupo_arte_escuela GAE
			JOIN tb_organizaciones_2017 O ON GAE.FK_organizacion = O.PK_Id_Organizacion
			WHERE GAE.ESTADO = 1");
		return $organizacion;
	}

	/***************************************************************************
	/* getOrganizacionGruposSinArtistaFormadorEmprendeClan() consulta los datos de organizaciones que tienen grupos de emprende clan activos sin Artista formador asignado
	***************************************************************************/
	function getOrganizacionGruposSinArtistaFormadorEmprendeClan(){
		global $db_siclan;
		$organizacion = $db_siclan->query("SELECT DISTINCT O.PK_Id_Organizacion, O.VC_Nom_Organizacion
			FROM tb_terr_grupo_emprende_clan GEC
			JOIN tb_organizaciones_2017 O ON GEC.FK_organizacion = O.PK_Id_Organizacion
			WHERE GEC.ESTADO = 1");
		return $organizacion;
	}

	/***************************************************************************
	/* getOrganizacionGruposSinArtistaFormadorLaboratorioClan() consulta los datos de organizaciones que tienen grupos de laboratorio clan activos sin Artista formador asignado
	***************************************************************************/
	function getOrganizacionGruposSinArtistaFormadorLaboratorioClan(){
		global $db_siclan;
		$organizacion = $db_siclan->query("SELECT DISTINCT O.PK_Id_Organizacion, O.VC_Nom_Organizacion
			FROM tb_terr_grupo_laboratorio_clan GEC
			JOIN tb_organizaciones_2017 O ON GEC.FK_organizacion = O.PK_Id_Organizacion
			WHERE GEC.ESTADO = 1");
		return $organizacion;
	}

	/***************************************************************************
	/* getGruposActivosOrganizacionArteEscuela() consulta los grupos de arte en la escuela que se encuentran activos de una organización especifica.
	***************************************************************************/
	function getGruposActivosOrganizacionArteEscuela($id_organizacion){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_arte_escuela",[
			"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_colegios"=>["FK_colegio"=>"PK_Id_Colegio"],
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],
			[
			"tb_terr_grupo_arte_escuela.PK_Grupo",
			"tb_clan.VC_Nom_Clan",
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_colegios.VC_Nom_Colegio",
			"tb_terr_grupo_arte_escuela.DT_fecha_creacion",
			"tb_terr_grupo_arte_escuela.TX_observaciones",
			"tb_terr_grupo_arte_escuela.FK_artista_formador",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_organizaciones_2017.VC_Nom_Organizacion"
			],
			["AND"=>[
			"tb_terr_grupo_arte_escuela.FK_organizacion"=>$id_organizacion,
			"tb_terr_grupo_arte_escuela.estado"=>1
			]]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposActivosOrganizacionEmprendeClan() consulta los grupos de emprende clan que se encuentran activos de una organización especifica.
	***************************************************************************/
	function getGruposActivosOrganizacionEmprendeClan($id_organizacion){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_emprende_clan",[
			"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_modalidad"=>["FK_modalidad"=>"PK_Id_Modalidad"],
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],
			[
			"tb_terr_grupo_emprende_clan.PK_Grupo",
			"tb_clan.VC_Nom_Clan",
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_modalidad.VC_Nom_Modalidad",
			"tb_terr_grupo_emprende_clan.DT_fecha_creacion",
			"tb_terr_grupo_emprende_clan.TX_observaciones",
			"tb_terr_grupo_emprende_clan.FK_artista_formador",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_organizaciones_2017.VC_Nom_Organizacion"
			],
			["AND"=>[
			"tb_terr_grupo_emprende_clan.FK_organizacion"=>$id_organizacion,
			"tb_terr_grupo_emprende_clan.estado"=>1
			]]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposActivosOrganizacionLaboratorioClan() consulta los grupos de laboratorio clan que se encuentran activos de una organización especifica.
	***************************************************************************/
	function getGruposActivosOrganizacionLaboratorioClan($id_organizacion){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_laboratorio_clan",[
			"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_terr_lugar_atencion_laboratorio_clan"=>["FK_lugar_atencion"=>"PK_lugar_atencion"],
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],
			[
			"tb_terr_grupo_laboratorio_clan.PK_Grupo",
			"tb_clan.VC_Nom_Clan",
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_terr_grupo_laboratorio_clan.DT_fecha_creacion",
			"tb_terr_grupo_laboratorio_clan.TX_observaciones",
			"tb_terr_grupo_laboratorio_clan.FK_artista_formador",
			"tb_terr_grupo_laboratorio_clan.tipo_poblacion",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_organizaciones_2017.VC_Nom_Organizacion",
			"tb_terr_lugar_atencion_laboratorio_clan.VC_Nombre_Lugar"
			],
			["AND"=>[
			"tb_terr_grupo_laboratorio_clan.FK_organizacion"=>$id_organizacion,
			"tb_terr_grupo_laboratorio_clan.estado"=>1
			]]);
		return $grupo;
	}

	/***************************************************************************
	* trae toda la informacion de una planeacion de acuerdo al Id
	***************************************************************************/
	function getPlaneacionInfo($planeacionId)
	{
		global $db_siclan;
		$planeacion = $db_siclan->select("tb_planeacion_grupo","*",["PK_Id_Planeacion"=>$planeacionId]);
		return $planeacion;
	}
	/***************************************************************************
	* trae toda la informacion de una valoracion de acuerdo al Id
	***************************************************************************/
	function getValoracionInfo($valoracionId)
	{
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$fecha=date("Y-m-d H:i:s");
		$anio = $clan = explode("-", $fecha)[0];
		$valoracion = $db_siclan->query("SELECT
			COALESCE(tc.VC_Nom_Colegio,'NO APLICA') AS VC_Colegio,
			tcl.VC_Nom_Clan,
			CONCAT(tp.VC_Primer_Nombre,' ',tp.VC_Segundo_Nombre,' ',tp.VC_Primer_Apellido,' ',tp.VC_Segundo_Apellido)
			AS VC_Nombre_Artista_Formador,
			COALESCE(to2.VC_Nom_Organizacion,'Sin Organización') AS VC_Entidad,
			taa.VC_Nom_Area,
			tvg.FK_Periodo,
			tvg.FK_Ciclo,
			tvg.DA_Fecha,
			tvg.FK_Grupo,
			tvg.TX_Gesto_Cognitivo,
			tvg.FK_Linea_Atencion,
			tvg.VC_Nombre_Archivo,
			tvg.VC_URL,
			tvg.DA_Subida,
			tvg.TX_Observacion,
			tvg.IN_Estado,
			tve.FK_Estudiante,
			CONCAT(te.VC_Primer_Nombre,' ',te.VC_Segundo_Nombre,' ',te.VC_Primer_Apellido,' ',te.VC_Segundo_Apellido)
			AS VC_Nombre_Estudiante,
			COALESCE(COALESCE(tpd.VC_Descripcion,tpd2.VC_Descripcion),'') AS VC_Descripcion_Grado,
			tve.TX_Asistencia,
			tve.IN_Val_Cognitivo,
			tve.IN_Val_Actitudinal,
			tve.IN_Val_Convivencial,
			tve.TX_Recomendacion
			FROM
			tb_valoracion_grupo tvg
			LEFT JOIN tb_terr_grupo_arte_escuela ttgae ON ttgae.PK_Grupo = tvg.FK_Grupo AND tvg.FK_Linea_Atencion = 'arte_escuela'
			LEFT JOIN tb_colegios tc ON ttgae.FK_Colegio = tc.PK_Id_Colegio
			LEFT JOIN tb_terr_grupo_emprende_clan ttgec ON ttgec.PK_Grupo = tvg.FK_Grupo AND tvg.FK_Linea_Atencion = 'emprende_clan'
			LEFT JOIN tb_clan tcl ON tcl.PK_Id_Clan = ttgae.FK_clan OR  tcl.PK_Id_Clan = ttgec.FK_clan
			LEFT JOIN tb_persona_2017 tp ON tp.PK_Id_Persona =  tvg.FK_Formador
			LEFT JOIN tb_organizaciones_2017 to2 ON to2.PK_Id_Organizacion = ttgae.FK_organizacion OR to2.PK_Id_Organizacion = ttgec.FK_organizacion
			LEFT JOIN tb_areas_artisticas taa ON taa.PK_Area_Artistica = ttgae.FK_area_artistica OR taa.PK_Area_Artistica = ttgec.FK_area_artistica
			LEFT JOIN tb_valoracion_estudiante tve ON tvg.PK_Id_Valoracion = tve.FK_Valoracion /*AND (
			tve.FK_Estudiante IN (SELECT tgae.FK_estudiante FROM tb_terr_grupo_arte_escuela_estudiante tgae WHERE ttgae.PK_Grupo = tgae.FK_grupo AND tgae.estado = 1)
			OR
			tve.FK_Estudiante IN (SELECT tgee.FK_estudiante FROM tb_terr_grupo_emprende_clan_estudiante tgee WHERE ttgec.PK_Grupo = tgee.FK_grupo AND tgee.estado = 1))*/
			LEFT JOIN tb_estudiante te ON te.id = tve.FK_Estudiante
			LEFT JOIN tb_estudiante_simat tes ON tes.NRO_DOCUMENTO = te.IN_Identificacion
			LEFT JOIN tb_estudiante_detalle_anio teda ON teda.FK_estudiante = te.id AND teda.anio= '".$anio."'
			LEFT JOIN tb_parametro_detalle tpd ON tpd.FK_Id_Parametro = 18 AND (tpd.FK_Value = tes.GRADO)
			LEFT JOIN tb_parametro_detalle tpd2 ON tpd2.FK_Id_Parametro = 18 AND (teda.FK_grado = tpd2.FK_Value) WHERE tvg.PK_Id_Valoracion = ".$valoracionId." ORDER BY te.VC_Primer_Nombre;")->fetchAll(PDO::FETCH_ASSOC);
		
		return $valoracion;
	}
	/***************************************************************************
	* trae toda la informacion de un recurso de acuerdo al id
	***************************************************************************/
	function getRecursosList($recursos)
	{
		global $db_siclan;
		$recursos = $db_siclan->select("tb_recurso","*",["AND"=>["PK_Id_Recurso"=>$recursos]]);
		return $recursos;
	}

	/***************************************************************************
	/* getArtistaFormadorActivoOrganizacion() obtiene los datos de los artistas formadores que se encuentran activos en una organización especifica
	***************************************************************************/
	function getArtistaFormadorActivoOrganizacion($id_organizacion){
		global $db_siclan;
		$artista_formador = $db_siclan->query("SELECT P.PK_Id_Persona,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre
			FROM tb_persona_2017 P
			LEFT JOIN tb_formador_organizacion_2017 O ON P.PK_Id_Persona = O.FK_Id_Persona
			WHERE O.FK_Id_Organizacion = $id_organizacion
			AND (P.FK_Tipo_Persona = 1 OR P.FK_Tipo_Persona = 2)");
		return $artista_formador;
	}

	/***************************************************************************
	/* setArtistaFormadorGrupoEmprendeClan() actualiza la tabla emprende clan asignandole el artista formador y un registro en la bitacora de asignación de artistas formadores a grupos emprende clan
	***************************************************************************/
	function setArtistaFormadorGrupoEmprendeClan($id_grupo,$id_artista_formador,$id_usuario){
		global $db_siclan;
		$id_bitacora = $db_siclan->max("tb_terr_grupo_emprende_clan_artista_formador","PK_table");
		$id_bitacora++;
		date_default_timezone_set('America/Bogota');
		$bitacora = $db_siclan->insert("tb_terr_grupo_emprende_clan_artista_formador",[
			"PK_table"=>$id_bitacora,
			"FK_grupo"=>$id_grupo,
			"FK_artista_formador"=>$id_artista_formador,
			"FK_usuario_asigno"=>$id_usuario,
			"DT_fecha_asignacion_grupo"=>date('Y-m-d H:i:s')
			]);
		$update = $db_siclan->update("tb_terr_grupo_emprende_clan",[
			"FK_artista_formador"=>$id_artista_formador
			],
			[
			"PK_Grupo"=>$id_grupo
			]);
		return $update;
	}

	/***************************************************************************
	/* setArtistaFormadorGrupoLaboratorioClan() actualiza la tabla laboratorio clan asignandole el artista formador y un registro en la bitacora de asignación de artistas formadores a grupos emprende clan
	***************************************************************************/
	function setArtistaFormadorGrupoLaboratorioClan($id_grupo,$id_artista_formador,$id_usuario){
		global $db_siclan;
		$id_bitacora = $db_siclan->max("tb_terr_grupo_laboratorio_clan_artista_formador","PK_table");
		$id_bitacora++;
		date_default_timezone_set('America/Bogota');
		$bitacora = $db_siclan->insert("tb_terr_grupo_laboratorio_clan_artista_formador",[
			"PK_table"=>$id_bitacora,
			"FK_grupo"=>$id_grupo,
			"FK_artista_formador"=>$id_artista_formador,
			"FK_usuario_asigno"=>$id_usuario,
			"DT_fecha_asignacion_grupo"=>date('Y-m-d H:i:s')
			]);
		$update = $db_siclan->update("tb_terr_grupo_laboratorio_clan",[
			"FK_artista_formador"=>$id_artista_formador
			],
			[
			"PK_Grupo"=>$id_grupo
			]);
		return $update;
	}

	/***************************************************************************
	/* setArtistaFormadorGrupoArteEscuela() actualiza la tabla emprende clan asignandole el artista formador y un registro en la bitacora de asignación de artistas formadores a grupos arte en la escuela
	***************************************************************************/
	function setArtistaFormadorGrupoArteEscuela($id_grupo,$id_artista_formador,$id_usuario){
		global $db_siclan;
		$id_bitacora = $db_siclan->max("tb_terr_grupo_arte_escuela_artista_formador","PK_table");
		$id_bitacora++;
		date_default_timezone_set('America/Bogota');
		$bitacora = $db_siclan->insert("tb_terr_grupo_arte_escuela_artista_formador",[
			"PK_table"=>$id_bitacora,
			"FK_grupo"=>$id_grupo,
			"FK_artista_formador"=>$id_artista_formador,
			"FK_usuario_asigno"=>$id_usuario,
			"DT_fecha_asignacion_grupo"=>date('Y-m-d H:i:s')
			]);
		$update = $db_siclan->update("tb_terr_grupo_arte_escuela",[
			"FK_artista_formador"=>$id_artista_formador
			],
			[
			"PK_Grupo"=>$id_grupo
			]);
		return $update;
	}

	/***************************************************************************
	/* saveHorarioNuevoGrupoArteEscuela() guarda el horario establecido para un grupo que esta siendo creado en la línea de atención arte en la escuela.
	***************************************************************************/
	function saveHorarioNuevoGrupoArteEscuela($id_grupo,$dia_clase,$hora_inicio,$hora_fin){
		global $db_siclan;
		$insert = $db_siclan->insert("tb_terr_grupo_arte_escuela_horario_clase",[
			"FK_grupo"=>$id_grupo,
			"IN_dia"=>$dia_clase,
			"TI_hora_inicio_clase"=>$hora_inicio,
			"TI_hora_fin_clase"=>$hora_fin
			]);
		return $insert;
	}

	/***************************************************************************
	/* saveHorarioNuevoGrupoEmprendeClan() guarda el horario establecido para un grupo que esta siendo creado en la línea de atención emprende clan.
	***************************************************************************/
	function saveHorarioNuevoGrupoEmprendeClan($id_grupo,$dia_clase,$hora_inicio,$hora_fin){
		global $db_siclan;
		$insert = $db_siclan->insert("tb_terr_grupo_emprende_clan_horario_clase",[
			"FK_grupo"=>$id_grupo,
			"IN_dia"=>$dia_clase,
			"TI_hora_inicio_clase"=>$hora_inicio,
			"TI_hora_fin_clase"=>$hora_fin
			]);
		return $insert;
	}

	/***************************************************************************
	/* getGrupoActivoActualEstudianteArteEscuela() consulta el grupo actual de arte en la escuela que tiene asignado un estudiante con estado 1.
	***************************************************************************/
	function getGrupoActivoActualEstudianteArteEscuela($id_estudiante){
		global $db_siclan;
		$grupo_activo_actual = $db_siclan->select("tb_terr_grupo_arte_escuela_estudiante",["FK_grupo"],["AND"=>[
			"FK_estudiante"=>$id_estudiante,
			"estado"=>1
			]]);
		return $grupo_activo_actual;
	}

	/***************************************************************************
	/* getGrupoActivoActualEstudianteEmprendeClan() consulta el grupo actual de emprende clan que tiene asignado un estudiante con estado 1.
	***************************************************************************/
	function getGrupoActivoActualEstudianteEmprendeClan($id_estudiante){
		global $db_siclan;
		$grupo_activo_actual = $db_siclan->select("tb_terr_grupo_emprende_clan_estudiante",["[>]tb_terr_grupo_emprende_clan"=>["FK_grupo"=>"PK_grupo"]],["FK_grupo"],["AND"=>[
			"tb_terr_grupo_emprende_clan_estudiante.FK_estudiante"=>$id_estudiante,
			"tb_terr_grupo_emprende_clan_estudiante.estado"=>1,
			"tb_terr_grupo_emprende_clan.tipo_grupo[!]"=>"Ensamble"
			]]);
		return $grupo_activo_actual;
	}

	/***************************************************************************
	/* getGrupoActivoActualEstudianteLaboratorioClan() consulta el grupo actual de laboratorio clan que tiene asignado un estudiante con estado 1.
	***************************************************************************/
	function getGrupoActivoActualEstudianteLaboratorioClan($id_estudiante){
		global $db_siclan;
		$grupo_activo_actual = $db_siclan->select("tb_terr_grupo_laboratorio_clan_estudiante",["FK_grupo"],["AND"=>[
			"FK_estudiante"=>$id_estudiante,
			"estado"=>1
			]]);
		return $grupo_activo_actual;
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
	/* getIdEstudianteByIdentificacion() consulta el id de un estudiante segun su identificacion
	***************************************************************************/
	function getIdEstudianteByIdentificacion($identificacion){
		global $db_siclan;
		$id = $db_siclan->select("tb_estudiante","id",["IN_Identificacion"=>$identificacion]);
		return $id;
	}

	/***************************************************************************
	/* consultarFechaPrimerClaseGrupoArteEscuela() consulta la fecha de la Primer Clase del Grupo.
	***************************************************************************/
	function consultarFechaPrimerClaseGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$fecha_inicio = $db_siclan->min("tb_terr_grupo_arte_escuela_sesion_clase","DA_fecha_clase",["FK_grupo"=>$id_grupo]);
		return $fecha_inicio;
	}

	/***************************************************************************
	/* consultarFechaPrimerClaseGrupoEmprendeClan() consulta la fecha de la Primer Clase del Grupo.
	***************************************************************************/
	function consultarFechaPrimerClaseGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$fecha_inicio = $db_siclan->min("tb_terr_grupo_emprende_clan_sesion_clase","DA_fecha_clase",["FK_grupo"=>$id_grupo]);
		return $fecha_inicio;
	}

	/***************************************************************************
	/* consultarFechaPrimerClaseGrupoEmprendeClan() consulta la fecha de la Primer Clase del Grupo.
	***************************************************************************/
	function consultarFechaPrimerClaseGrupo($id_grupo,$tipo_grupo){
		global $db_siclan;
		$fecha_inicio = $db_siclan->min("tb_terr_grupo_".$tipo_grupo."_sesion_clase","DA_fecha_clase",["FK_grupo"=>$id_grupo]);
		return $fecha_inicio;
	}

	/***************************************************************************
	/* consultarPromedioAsistentesGrupoArteEscuela() obtiene el promedio de asistentes de un grupo de Arte en la Escuela
	***************************************************************************/
	function consultarPromedioAsistentesGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$promedio_asistentes = $db_siclan->query("SELECT COUNT(SCA.FK_estudiante) AS 'PROMEDIO'
			FROM tb_terr_grupo_arte_escuela_sesion_clase S
			JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=S.PK_sesion_clase
			WHERE S.FK_grupo=203 AND SCA.IN_estado_asistencia=1;");
		return $promedio_asistentes;
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
	/* consultarHorarioGrupoLaboratorioClan() consulta el (los) día(s) de clases que están habilitados en el sistema para las clases de un grupo de laboratorio clan.
	***************************************************************************/
	function consultarHorarioGrupoLaboratorioClan($id_grupo){
		global $db_siclan;
		$horario = $db_siclan->select("tb_terr_grupo_laboratorio_clan_horario_clase","*",["FK_grupo"=>$id_grupo]);
		return $horario;
	}

	/***************************************************************************
	/* getZonas() selecciona las zonas que existen en el sistema.
	***************************************************************************/
	function getZonas(){
		global $db_siclan;
		$area = $db_siclan->select("tb_zonas","*");
		return $area;
	}

	/***************************************************************************
	/* getGruposActivosSinOrganizacionArteEscuela() selecciona todos los grupos de arte en la escuela que se encuentren activos y no tengan asignada una organización.
	***************************************************************************/
	function getGruposTodosArteEscuela(){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_arte_escuela",[
			"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"],
			"[>]tb_colegios"=>["FK_colegio"=>"PK_Id_Colegio"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],[

			"tb_clan.VC_Nom_Clan",
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_colegios.VC_Nom_Colegio",
			"tb_terr_grupo_arte_escuela.PK_grupo",
			"tb_terr_grupo_arte_escuela.DT_fecha_creacion",
			"tb_terr_grupo_arte_escuela.TX_observaciones",
			"tb_terr_grupo_arte_escuela.estado",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_organizaciones_2017.VC_Nom_Organizacion",
			"tb_terr_grupo_arte_escuela.IN_lugar_atencion"
			]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposActivosSinOrganizacionEmprendeClan() selecciona todos los grupos de emprende clan que se encuentren activos y no tengan asignada una organización.
	***************************************************************************/
	function getGruposTodosEmprendeClan(){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_emprende_clan",[
			"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"],
			"[>]tb_modalidad"=>["FK_modalidad"=>"PK_Id_Modalidad"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],[

			"tb_clan.VC_Nom_Clan",
			"tb_areas_artisticas.VC_Nom_Area",
			"tb_modalidad.VC_Nom_Modalidad",
			"tb_terr_grupo_emprende_clan.PK_grupo",
			"tb_terr_grupo_emprende_clan.DT_fecha_creacion",
			"tb_terr_grupo_emprende_clan.TX_observaciones",
			"tb_terr_grupo_emprende_clan.estado",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_organizaciones_2017.VC_Nom_Organizacion",
			]);
		return $grupo;
	}

	/***************************************************************************
	/* getGrados() consulta la información completa de la tabla grados del sistema.
	***************************************************************************/
	function getGrados(){
		global $db_siclan;
		$grado = $db_siclan->select("tb_grado","*");
		return $grado;
	}

	/***************************************************************************
	/* consultarIDColegioGrupoArteEscuela() Consulta el id del colegio que se encuentra asociado a un grupo especifico de arte en la escuela
	***************************************************************************/
	function consultarIDColegioGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$id_grupo = $db_siclan->select("tb_terr_grupo_arte_escuela","FK_colegio",["PK_Grupo"=>$id_grupo]);
		return $id_grupo;
	}

	/***************************************************************************
	/* getGradosEstudianteMatricula2017() consulta el grado del estudiante en la tabla matricula estudiantil suministrada por la Secretaría de Educación
	***************************************************************************/
	function getGradoEstudianteMatricula2017($id_estudiante){
		global $db_siclan;
		$grado_estudiante = $db_siclan->select("tb_2017_matricula","GRADO",["NRO_DOCUMENTO"=>$id_estudiante]);
		return $grado_estudiante;
	}

	/***************************************************************************
	/* getJornadaEstudianteMatricula2017() consulta la jornada del estudiante en la tabla matricula estudiantel suministrada por la Secretaría de Educación.
	***************************************************************************/
	function getJornadaEstudianteMatricula2017($id_estudiante){
		global $db_siclan;
		$jornada_estudiante = $db_siclan->select("tb_2017_matricula","TIPO_JORNADA_DESCRIPCION_CAMPO",["NRO_DOCUMENTO"=>$id_estudiante]);
		return $jornada_estudiante;
	}

	/***************************************************************************
	/* getArtistaFormadorAsosciadosAZona() consulta los artistas formadores
	***************************************************************************/
	function getArtistaFormadorAsociadosAZona($id_zona){
		global $db_siclan;
		$artista_formador = $db_siclan->select("tb_formador_zona",[
			"[>]tb_persona_2017"=>["FK_Id_Persona"=>"PK_Id_Persona"]
			],[
			"tb_persona_2017.PK_Id_Persona",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre"
			],["FK_Id_Zona"=>$id_zona]);
		return $artista_formador;
	}

	/***************************************************************************
	/* getOrganizacionUusuario consulta el(los) id de la(s) organizacion(es) que tiene assignado un artista formador
	***************************************************************************/
	function getOrganizacionUsuario($id_usuario){
		global $db_siclan;
		$organizacion = $db_siclan->select("tb_formador_organizacion_2017",["FK_Id_Organizacion"],["FK_Id_Persona"=>$id_usuario]);
		return $organizacion;
	}

	/***************************************************************************
	/* deleteHorarioGrupoArteEscuela() Borra todos los registros de los días de clase de un grupo de arte en la escuela que se dicten clase.
	***************************************************************************/
	function deleteHorarioGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$delete = $db_siclan->delete("tb_terr_grupo_arte_escuela_horario_clase",["FK_grupo"=>$id_grupo]);
		return $delete;
	}

	/***************************************************************************
	/* deleteHorarioGrupoEmprendeClan() Borra todos los registros de los días de clase de un grupo de emprende clan que se dicten clase.
	***************************************************************************/
	function deleteHorarioGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$delete = $db_siclan->delete("tb_terr_grupo_emprende_clan_horario_clase",["FK_grupo"=>$id_grupo]);
		return $delete;
	}

	function getGruposArteEscuelaByClan($id_clan){
		global $db_siclan;
		$where = "";
		foreach ($id_clan as $key => $value) {
			if ($key == 0 ) {
				$where = $where ." tb_terr_grupo_arte_escuela.FK_clan = ".$value;
			}
			else
			{
				$where = $where ." OR tb_terr_grupo_arte_escuela.FK_clan = ".$value ;
			}

		}
		$grupo = $db_siclan->query("SELECT
			tb_clan.VC_Nom_Clan,
			tb_areas_artisticas.VC_Nom_Area,
			tb_colegios.VC_Nom_Colegio,
			tb_terr_grupo_arte_escuela.PK_grupo,
			tb_terr_grupo_arte_escuela.DT_fecha_creacion,
			tb_terr_grupo_arte_escuela.TX_observaciones,
			tb_terr_grupo_arte_escuela.estado,
			tb_persona_2017.VC_Primer_Nombre,
			tb_persona_2017.VC_Segundo_Nombre,
			tb_persona_2017.VC_Primer_Apellido,
			tb_persona_2017.VC_Segundo_Apellido,
			tb_organizaciones_2017.VC_Nom_Organizacion,
			tb_terr_grupo_arte_escuela.IN_lugar_atencion,
			tb_terr_grupo_arte_escuela.tipo_grupo,
			COUNT(tb_caracterizacion_grupo.FK_Grupo) AS CT_Caracterizacion,
			COUNT(tb_planeacion_grupo.FK_Grupo) AS CT_Planeacion,
			COUNT(tb_valoracion_grupo.FK_Grupo) AS CT_Valoracion,
			tb_terr_grupo_arte_escuela.DT_fecha_cierre,
			CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'CERRO'
			FROM
			tb_terr_grupo_arte_escuela
			LEFT JOIN tb_clan ON FK_clan=PK_Id_Clan
			LEFT JOIN tb_colegios ON FK_colegio=PK_Id_Colegio
			LEFT JOIN tb_areas_artisticas ON FK_area_artistica=PK_Area_Artistica
			LEFT JOIN tb_persona_2017 ON FK_artista_formador=PK_Id_Persona
			LEFT JOIN tb_persona_2017 AS P ON FK_quien_cerro=P.PK_Id_Persona
			LEFT JOIN tb_organizaciones_2017 ON FK_organizacion=PK_Id_Organizacion
			LEFT JOIN tb_caracterizacion_grupo ON FK_Grupo = PK_grupo AND tb_caracterizacion_grupo.FK_Id_Linea_Atencion= 'arte_escuela'
			LEFT JOIN tb_planeacion_grupo ON tb_planeacion_grupo.FK_Grupo = PK_grupo AND tb_planeacion_grupo.FK_Id_Linea_Atencion= 'arte_escuela'
			LEFT JOIN tb_valoracion_grupo ON tb_valoracion_grupo.FK_Grupo = PK_grupo AND tb_valoracion_grupo.FK_Linea_Atencion =  'arte_escuela'
			WHERE ".$where." GROUP BY tb_terr_grupo_arte_escuela.PK_grupo;")->fetchAll(PDO::FETCH_ASSOC);
		return $grupo;
	}

	function getGruposEmprendeClanByClan($id_clan){
		global $db_siclan;
		$where = "";
		foreach ($id_clan as $key => $value) {
			if ($key == 0 ) {
				$where = $where ." tb_terr_grupo_emprende_clan.FK_clan = ".$value;
			}
			else
			{
				$where = $where ." OR tb_terr_grupo_emprende_clan.FK_clan = ".$value ;
			}

		}
		$grupo = $db_siclan->query("SELECT
			tb_clan.VC_Nom_Clan,
			tb_areas_artisticas.VC_Nom_Area,
			tb_modalidad.VC_Nom_Modalidad,
			tb_terr_grupo_emprende_clan.PK_grupo,
			tb_terr_grupo_emprende_clan.DT_fecha_creacion,
			tb_terr_grupo_emprende_clan.TX_observaciones,
			tb_terr_grupo_emprende_clan.estado,
			tb_persona_2017.VC_Primer_Nombre,
			tb_persona_2017.VC_Segundo_Nombre,
			tb_persona_2017.VC_Primer_Apellido,
			tb_persona_2017.VC_Segundo_Apellido,
			tb_organizaciones_2017.VC_Nom_Organizacion,
			tb_terr_grupo_emprende_clan_tipo_grupo.tipo_grupo,
			COUNT(tb_caracterizacion_grupo.FK_Grupo) AS CT_Caracterizacion,
			COUNT(tb_planeacion_grupo.FK_Grupo) AS CT_Planeacion,
			COUNT(tb_valoracion_grupo.FK_Grupo) AS CT_Valoracion,
			tb_terr_grupo_emprende_clan.DT_fecha_cierre,
			CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'CERRO'
			FROM
			tb_terr_grupo_emprende_clan
			LEFT JOIN tb_clan ON FK_clan=PK_id_clan
			LEFT JOIN tb_modalidad ON FK_modalidad=PK_Id_Modalidad
			LEFT JOIN tb_areas_artisticas ON FK_area_artistica=PK_Area_Artistica
			LEFT JOIN tb_persona_2017 ON FK_artista_formador=PK_Id_Persona
			LEFT JOIN tb_persona_2017 AS P ON FK_quien_cerro=P.PK_Id_Persona
			LEFT JOIN tb_organizaciones_2017 ON FK_organizacion=PK_Id_Organizacion
			LEFT JOIN tb_caracterizacion_grupo ON FK_Grupo = PK_grupo AND tb_caracterizacion_grupo.FK_Id_Linea_Atencion= 'emprende_clan'
			LEFT JOIN tb_planeacion_grupo ON tb_planeacion_grupo.FK_Grupo = PK_grupo AND tb_planeacion_grupo.FK_Id_Linea_Atencion= 'emprende_clan'
			LEFT JOIN tb_valoracion_grupo ON tb_valoracion_grupo.FK_Grupo = PK_grupo AND tb_valoracion_grupo.FK_Linea_Atencion =  'emprende_clan'
			LEFT JOIN tb_terr_grupo_emprende_clan_tipo_grupo ON tb_terr_grupo_emprende_clan.PK_Grupo = tb_terr_grupo_emprende_clan_tipo_grupo.FK_grupo
			WHERE ".$where." GROUP BY tb_terr_grupo_emprende_clan.PK_grupo;")->fetchAll(PDO::FETCH_ASSOC);

		return $grupo;
	}

	function getGruposLaboratorioClanByClan($id_clan){
		global $db_siclan;
		$where = "";
		foreach ($id_clan as $key => $value) {
			if ($key == 0 ) {
				$where = $where ." tb_terr_grupo_laboratorio_clan.FK_clan = ".$value;
			}
			else
			{
				$where = $where ." OR tb_terr_grupo_laboratorio_clan.FK_clan = ".$value ;
			}

		}
		$grupo = $db_siclan->query("SELECT
			tb_clan.VC_Nom_Clan,
			tb_areas_artisticas.VC_Nom_Area,
			tb_terr_grupo_laboratorio_clan.PK_grupo,
			tb_terr_grupo_laboratorio_clan.DT_fecha_creacion,
			tb_terr_grupo_laboratorio_clan.TX_observaciones,
			tb_terr_grupo_laboratorio_clan.estado,
			tb_terr_lugar_atencion_laboratorio_clan.VC_Nombre_Lugar,
			tb_persona_2017.VC_Primer_Nombre,
			tb_persona_2017.VC_Segundo_Nombre,
			tb_persona_2017.VC_Primer_Apellido,
			tb_persona_2017.VC_Segundo_Apellido,
			tb_organizaciones_2017.VC_Nom_Organizacion,
			COUNT(tb_caracterizacion_grupo.FK_Grupo) AS CT_Caracterizacion,
			COUNT(tb_planeacion_grupo.FK_Grupo) AS CT_Planeacion,
			COUNT(tb_valoracion_grupo.FK_Grupo) AS CT_Valoracion,
			tb_terr_grupo_laboratorio_clan.DT_fecha_cierre,
			CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'CERRO'
			FROM
			tb_terr_grupo_laboratorio_clan
			LEFT JOIN tb_clan ON FK_clan=PK_id_clan
			LEFT JOIN tb_areas_artisticas ON FK_area_artistica=PK_Area_Artistica
			LEFT JOIN tb_terr_lugar_atencion_laboratorio_clan ON FK_lugar_atencion = PK_lugar_atencion
			LEFT JOIN tb_persona_2017 ON FK_artista_formador=PK_Id_Persona
			LEFT JOIN tb_persona_2017 AS P ON FK_quien_cerro=P.PK_Id_Persona
			LEFT JOIN tb_organizaciones_2017 ON FK_organizacion=PK_Id_Organizacion
			LEFT JOIN tb_caracterizacion_grupo ON FK_Grupo = PK_grupo AND tb_caracterizacion_grupo.FK_Id_Linea_Atencion= 'laboratorio_clan'
			LEFT JOIN tb_planeacion_grupo ON tb_planeacion_grupo.FK_Grupo = PK_grupo AND tb_planeacion_grupo.FK_Id_Linea_Atencion= 'laboratorio_clan'
			LEFT JOIN tb_valoracion_grupo ON tb_valoracion_grupo.FK_Grupo = PK_grupo AND tb_valoracion_grupo.FK_Linea_Atencion =  'laboratorio_clan'
			WHERE ".$where." GROUP BY tb_terr_grupo_laboratorio_clan.PK_grupo;")->fetchAll(PDO::FETCH_ASSOC);

		return $grupo;
	}

	function getEstudianteInactivoGrupoArteEscuela($id_estudiante,$id_grupo){
		global $db_siclan;
		$dato_registro = $db_siclan->select("tb_terr_grupo_arte_escuela_estudiante",[
			"DT_fecha_ingreso",
			"DT_fecha_retiro"
			],[
			"AND"=>[
			"FK_estudiante" => $id_estudiante,
			"FK_grupo" => $id_grupo,
			"estado" => 0
			]
			]);
		return $dato_registro;
	}

	function activarEstudianteGrupoArteEscuela($id_estudiante,$id_grupo,$observaciones){
		global $db_siclan;
		$observacion = $db_siclan->select("tb_terr_grupo_arte_escuela_estudiante",["TX_observaciones"],["AND"=>["FK_grupo"=>$id_grupo,"FK_estudiante"=>$id_estudiante]]);
		$observacion = $observacion[0]['TX_observaciones'].$observaciones;
		$update = $db_siclan->update("tb_terr_grupo_arte_escuela_estudiante",[
			"DT_fecha_ingreso" => date('Y-m-d H:i:s'),
			"DT_fecha_retiro" => NULL,
			"estado" => 1,
			"FK_usuario_retiro" => NULL,
			"TX_observaciones" => $observacion
			],
			["AND"=>[
			"FK_grupo" => $id_grupo,
			"FK_estudiante" => $id_estudiante,
			"estado" => 0
			]]);
		return $update;
	}

	function getEstudianteInactivoGrupoEmprendeClan($id_estudiante,$id_grupo){
		global $db_siclan;
		$dato_registro = $db_siclan->select("tb_terr_grupo_emprende_clan_estudiante",[
			"DT_fecha_ingreso",
			"DT_fecha_retiro"
			],[
			"AND"=>[
			"FK_estudiante" => $id_estudiante,
			"FK_grupo" => $id_grupo,
			"estado" => 0
			]
			]);
		return $dato_registro;
	}

	function getEstudianteInactivoGrupoLaboratorioClan($id_estudiante,$id_grupo){
		global $db_siclan;
		$dato_registro = $db_siclan->select("tb_terr_grupo_laboratorio_clan_estudiante",[
			"DT_fecha_ingreso",
			"DT_fecha_retiro"
			],[
			"AND"=>[
			"FK_estudiante" => $id_estudiante,
			"FK_grupo" => $id_grupo,
			"estado" => 0
			]
			]);
		return $dato_registro;
	}

	function activarEstudianteGrupoEmprendeClan($id_estudiante,$id_grupo,$observaciones){
		global $db_siclan;
		$observacion = $db_siclan->select("tb_terr_grupo_emprende_clan_estudiante",["TX_observaciones"],["AND"=>["FK_grupo"=>$id_grupo,"FK_estudiante"=>$id_estudiante]]);
		$observacion = $observacion[0]['TX_observaciones'].$observaciones;
		$update = $db_siclan->update("tb_terr_grupo_emprende_clan_estudiante",[
			"DT_fecha_ingreso" => date('Y-m-d H:i:s'),
			"DT_fecha_retiro" => NULL,
			"FK_usuario_retiro" => NULL,
			"estado" => 1,
			"TX_observaciones" => $observacion
			],
			["AND"=>[
			"FK_grupo" => $id_grupo,
			"FK_estudiante" => $id_estudiante,
			"estado" => 0
			]]);
		return $update;
	}

	function activarEstudianteGrupoLaboratorioClan($id_estudiante,$id_grupo,$observaciones){
		global $db_siclan;
		$observacion = $db_siclan->select("tb_terr_grupo_laboratorio_clan_estudiante",["TX_observaciones"],["AND"=>["FK_grupo"=>$id_grupo,"FK_estudiante"=>$id_estudiante]]);
		$observacion = $observacion[0]['TX_observaciones'].$observaciones;
		$update = $db_siclan->update("tb_terr_grupo_laboratorio_clan_estudiante",[
			"DT_fecha_ingreso" => date('Y-m-d H:i:s'),
			"DT_fecha_retiro" => NULL,
			"FK_usuario_retiro" => NULL,
			"estado" => 1,
			"TX_observaciones" => $observacion
			],
			["AND"=>[
			"FK_grupo" => $id_grupo,
			"FK_estudiante" => $id_estudiante,
			"estado" => 0
			]]);
		return $update;
	}

	function updateGrupoArteEscuela($id_grupo,$id_area_artistica,$id_lugar_atencion,$id_colegio,$observaciones){
		global $db_siclan;
		$update = $db_siclan->update("tb_terr_grupo_arte_escuela",[
			"FK_area_artistica" => $id_area_artistica,
			"IN_lugar_atencion" =>$id_lugar_atencion,
			"FK_colegio" =>$id_colegio,
			"TX_observaciones" => $observaciones
			],["PK_Grupo" => $id_grupo]);
		return $update;
	}

	function updateGrupoEmprendeClan($id_grupo,$id_area_artistica,$id_modalidad,$observaciones){
		global $db_siclan;
		$update = $db_siclan->update("tb_terr_grupo_emprende_clan",[
			"FK_area_artistica" => $id_area_artistica,
			"FK_modalidad" => $id_modalidad,
			"TX_observaciones" => $observaciones
			],["PK_Grupo" => $id_grupo]);
		return $update;
	}
		/***************************************************************************
	/* updateObservacion() actualiza la observacion de una caracterizacion especifica
	***************************************************************************/
	function updateObservacion($idCaracterizacion,$observacion,$estado,$idUsuario){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$update = $db_siclan->update("tb_caracterizacion_grupo",[
			"TX_Observacion" =>$observacion,
			"IN_Estado" =>$estado,
			"FK_Id_AFA_Cambio" =>$idUsuario,
			"DT_AFA_Cambio"=>date('Y-m-d H:i:s'),
			],[
			"PK_Id_Caracterizacion"=>$idCaracterizacion
			]);
		return $update;
	}
	/***************************************************************************
	/* getCaracterizacionData($caracterizacionId) carga todos los datos de una caracterzacion especifica
	***************************************************************************/
	function getCaracterizacionData($caracterizacionId){
		global $db_siclan;
		$caracterizacion = $db_siclan->select("tb_caracterizacion_grupo","*",["PK_Id_Caracterizacion"=>$caracterizacionId]);
		return $caracterizacion;
	}

	/***************************************************************************
	/* guardarTipoGrupoArteEscuela() guarda el tipo de grupo de arte en la escuela
	***************************************************************************/
	function guardarTipoGrupoArteEscuela($id_grupo,$tipo_grupo){
		global $db_siclan;
		$db_siclan->insert("tb_terr_grupo_arte_escuela_tipo_grupo",[
			"FK_grupo"=>$id_grupo,
			"tipo_grupo"=>$tipo_grupo
			]);
	}

	/***************************************************************************
	/* getArtistasFormadores() retorna el id, cedula y nombres de las personas que tienen el rol de artista formador.
	***************************************************************************/
	function getArtistasFormadores(){
		global $db_siclan;
		$artista_formador = $db_siclan->select("tb_persona_2017",["PK_Id_Persona","VC_Identificacion","VC_Primer_Apellido","VC_Segundo_Apellido","VC_Primer_Nombre","VC_Segundo_Nombre"],["FK_Tipo_Persona"=>[1,2]]);
		return $artista_formador;
	}

	/***************************************************************************
	/* getIDArtistaFormadorGrupoArteEscuela() consulta el identificador del artista formador que tiene asignado un grupo de la línea arte en la escuela
	***************************************************************************/
	function getIDArtistaFormadorGrupoArteEscuela($id_grupo){
		global $db_siclan;
		return $db_siclan->select("tb_terr_grupo_arte_escuela","FK_artista_formador",["PK_grupo"=>$id_grupo]);
	}

	/***************************************************************************
	/* getIDArtistaFormadorGrupoEmprendeClan() consulta el identificador del artista formador que tiene asignado un grupo de la línea emprende clan
	***************************************************************************/
	function getIDArtistaFormadorGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		return $db_siclan->select("tb_terr_grupo_emprende_clan","FK_artista_formador",["PK_grupo"=>$id_grupo]);
	}

	/***************************************************************************
	/* getIDArtistaFormadorGrupoLaboratorioClan() consulta el identificador del artista formador que tiene asignado un grupo de la línea laboratorio clan
	***************************************************************************/
	function getIDArtistaFormadorGrupoLaboratorioClan($id_grupo){
		global $db_siclan;
		return $db_siclan->select("tb_terr_grupo_laboratorio_clan","FK_artista_formador",["PK_grupo"=>$id_grupo]);
	}

	/***************************************************************************
	/* saveNovedadGrupoArteEscuela() guarda un nuevo registro de novedad respecto a la asistencia del artista formador en un grupo de la linea arte en la escuela
	***************************************************************************/
	function saveNovedadGrupoArteEscuela($id_grupo,$fecha_novedad,$id_novedad,$estado_asistencia,$observacion,$id_artista_formador,$id_usuario){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		return $db_siclan->insert("tb_terr_grupo_arte_escuela_sesion_clase_novedad",[
			"FK_grupo"=>$id_grupo,
			"DA_fecha_sesion_clase"=>$fecha_novedad,
			"IN_novedad"=>$id_novedad,
			"IN_asistencia"=>$estado_asistencia,
			"TX_observacion"=>$observacion,
			"FK_artista_formador"=>$id_artista_formador,
			"FK_usuario_registro"=>$id_usuario,
			"DT_fecha_registro"=>date('Y-m-d H:i:s')
			]);
	}

	/***************************************************************************
	/* saveNovedadGrupoEmprendeClan()  guarda un nuevo registro de novedad respecto a la asistencia del artista formador en un grupo de la linea emprende clan.
	***************************************************************************/
	function saveNovedadGrupoEmprendeClan($id_grupo,$fecha_novedad,$id_novedad,$estado_asistencia,$observacion,$id_artista_formador,$id_usuario){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		return $db_siclan->insert("tb_terr_grupo_emprende_clan_sesion_clase_novedad",[
			"FK_grupo"=>$id_grupo,
			"DA_fecha_sesion_clase"=>$fecha_novedad,
			"IN_novedad"=>$id_novedad,
			"IN_asistencia"=>$estado_asistencia,
			"TX_observacion"=>$observacion,
			"FK_artista_formador"=>$id_artista_formador,
			"FK_usuario_registro"=>$id_usuario,
			"DT_fecha_registro"=>date('Y-m-d H:i:s')
			]);
	}

	/***************************************************************************
	/* saveNovedadGrupoLaboratorioClan()  guarda un nuevo registro de novedad respecto a la asistencia del artista formador en un grupo de la linea laboratorio clan.
	***************************************************************************/
	function saveNovedadGrupoLaboratorioClan($id_grupo,$fecha_novedad,$id_novedad,$estado_asistencia,$observacion,$id_artista_formador,$id_usuario){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		return $db_siclan->insert("tb_terr_grupo_laboratorio_clan_sesion_clase_novedad",[
			"FK_grupo"=>$id_grupo,
			"DA_fecha_sesion_clase"=>$fecha_novedad,
			"IN_novedad"=>$id_novedad,
			"IN_asistencia"=>$estado_asistencia,
			"TX_observacion"=>$observacion,
			"FK_artista_formador"=>$id_artista_formador,
			"FK_usuario_registro"=>$id_usuario,
			"DT_fecha_registro"=>date('Y-m-d H:i:s')
			]);
	}

	/***************************************************************************
	/* consultarNovedadesRegistradasGrupoArteEscuela() consulta las novedades que han sido registradas en un mes especifico para un grupo de la linea arte en la escuela
	***************************************************************************/
	function consultarNovedadesRegistradasGrupoArteEscuela($id_grupo,$fecha){
		global $db_siclan;
		return $db_siclan->count("tb_terr_grupo_arte_escuela_sesion_clase_novedad",["AND"=>["FK_grupo"=>$id_grupo,"DA_fecha_sesion_clase"=>$fecha]]);
	}

	/***************************************************************************
	/* consultarNovedadesRegistradasGrupoEmprendeClan()  consulta las novedades que han sido registradas en un mes especifico para un grupo de la linea emprende clan.
	***************************************************************************/
	function consultarNovedadesRegistradasGrupoEmprendeClan($id_grupo,$fecha){
		global $db_siclan;
		return $db_siclan->count("tb_terr_grupo_emprende_clan_sesion_clase_novedad",["AND"=>["FK_grupo"=>$id_grupo,"DA_fecha_sesion_clase"=>$fecha]]);
	}

	/***************************************************************************
	/* consultarNovedadesRegistradasGrupoLaboratorioClan()  consulta las novedades que han sido registradas en un mes especifico para un grupo de la linea laboratorio clan.
	***************************************************************************/
	function consultarNovedadesRegistradasGrupoLaboratorioClan($id_grupo,$fecha){
		global $db_siclan;
		return $db_siclan->count("tb_terr_grupo_laboratorio_clan_sesion_clase_novedad",["AND"=>["FK_grupo"=>$id_grupo,"DA_fecha_sesion_clase"=>$fecha]]);
	}

	/***************************************************************************
	/* consultarNovedadesGrupoArteEscuela()  consulta todas las novedades y sus detalles historico de un grupo especifico de la linea arte en la escuela
	***************************************************************************/
	function consultarNovedadesGrupoArteEscuela($id_grupo){
		global $db_siclan;
		return $db_siclan->select("tb_terr_grupo_arte_escuela_sesion_clase_novedad",
			[
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"]
			],[
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_terr_grupo_arte_escuela_sesion_clase_novedad.id",
			"tb_terr_grupo_arte_escuela_sesion_clase_novedad.DA_fecha_sesion_clase",
			"tb_terr_grupo_arte_escuela_sesion_clase_novedad.IN_asistencia",
			"tb_terr_grupo_arte_escuela_sesion_clase_novedad.IN_novedad",
			"tb_terr_grupo_arte_escuela_sesion_clase_novedad.TX_observacion",
			"tb_terr_grupo_arte_escuela_sesion_clase_novedad.DT_fecha_registro"
			],[
			"tb_terr_grupo_arte_escuela_sesion_clase_novedad.FK_grupo"=>$id_grupo
			]);
	}

	/***************************************************************************
	/* consultarNovedadesGrupoEmprendeClan() consulta todas las novedades y sus detalles historico de un grupo especifico de la linea emprende clan
	***************************************************************************/
	function consultarNovedadesGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		return $db_siclan->select("tb_terr_grupo_emprende_clan_sesion_clase_novedad",
			[
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"]
			],[
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_terr_grupo_emprende_clan_sesion_clase_novedad.id",
			"tb_terr_grupo_emprende_clan_sesion_clase_novedad.DA_fecha_sesion_clase",
			"tb_terr_grupo_emprende_clan_sesion_clase_novedad.IN_asistencia",
			"tb_terr_grupo_emprende_clan_sesion_clase_novedad.IN_novedad",
			"tb_terr_grupo_emprende_clan_sesion_clase_novedad.TX_observacion",
			"tb_terr_grupo_emprende_clan_sesion_clase_novedad.DT_fecha_registro"
			],[
			"tb_terr_grupo_emprende_clan_sesion_clase_novedad.FK_grupo"=>$id_grupo
			]);
	}

	/***************************************************************************
	/* consultarNovedadesGrupoLaboratorioClan() consulta todas las novedades y sus detalles historico de un grupo especifico de la linea laboratorio clan
	***************************************************************************/
	function consultarNovedadesGrupoLaboratorioClan($id_grupo){
		global $db_siclan;
		return $db_siclan->select("tb_terr_grupo_laboratorio_clan_sesion_clase_novedad",
			[
			"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"]
			],[
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_terr_grupo_laboratorio_clan_sesion_clase_novedad.id",
			"tb_terr_grupo_laboratorio_clan_sesion_clase_novedad.DA_fecha_sesion_clase",
			"tb_terr_grupo_laboratorio_clan_sesion_clase_novedad.IN_asistencia",
			"tb_terr_grupo_laboratorio_clan_sesion_clase_novedad.IN_novedad",
			"tb_terr_grupo_laboratorio_clan_sesion_clase_novedad.TX_observacion",
			"tb_terr_grupo_laboratorio_clan_sesion_clase_novedad.DT_fecha_registro"
			],[
			"tb_terr_grupo_laboratorio_clan_sesion_clase_novedad.FK_grupo"=>$id_grupo
			]);
	}

	/***************************************************************************
	/* consultarIdRolUsuario() consulta el valor del identificador de rol que tiene asociado un usuario especifico.
	***************************************************************************/
	function consultarIdRolUsuario($id_usuario){
		global $db_siclan;
		return $db_siclan->select("tb_persona_2017","FK_Tipo_Persona",["PK_Id_Persona"=>$id_usuario]);
	}
	/***************************************************************************
	/* getAdministradorClanId() retorna el id del administrador del clan especificado
	***************************************************************************/
	function getAdministradorClanId($clanId){
		global $db_siclan;
		$clan = $db_siclan->select("tb_clan","FK_Persona_Administrador",["PK_Id_Clan"=>$clanId]);
		$coordinadorId = 0;
		if (sizeof($clan) > 0){
			$coordinadorId = $clan[0];
		}
		return $coordinadorId;
	}
	/***************************************************************************
	/* getAdministradorOrganizacionData() retorna el id del administrador del clan especificado
	***************************************************************************/
	function getAdministradorOrganizacionData($organizacionId){
		global $db_siclan;
		$organizacion = $db_siclan->select("tb_organizaciones_2017",["VC_Nom_Organizacion","FK_Coordinador"],["PK_Id_Organizacion"=>$organizacionId]);
		return $organizacion;
	}
	/***************************************************************************
	/* getCaracterizacionesObservaciones() retorna las observaciones y demas datos relevantes del formato
	***************************************************************************/
	function getCaracterizacionesObservaciones($grupoId,$lineaAtencion){
		global $db_siclan;
		return $db_siclan->select("tb_caracterizacion_grupo",
			[
			"[>]tb_persona_2017"=>["FK_Id_Usuario_Registro"=>"PK_Id_Persona"]
			],[
			"tb_caracterizacion_grupo.DA_Fecha_Registro (DA_Fecha_Registro)",
			"tb_caracterizacion_grupo.IN_Estado (IN_Estado)",
			"tb_caracterizacion_grupo.DT_AFA_Cambio (DT_AFA_Cambio)",
			"tb_caracterizacion_grupo.TX_Observacion (TX_Observacion)",
			"tb_caracterizacion_grupo.FK_grupo",
			"tb_caracterizacion_grupo.FK_Id_Linea_Atencion (FK_Id_Linea_atencion)",
			"tb_caracterizacion_grupo.FK_Ciclo",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido"
			],
			["AND"=>[
			"tb_caracterizacion_grupo.FK_grupo"=>$grupoId,
			"tb_caracterizacion_grupo.FK_Id_Linea_Atencion"=>$lineaAtencion
			]
			]);
	}
	/***************************************************************************
	/* getPlaneacionObservaciones() retorna las observaciones y demas datos relevantes del formato
	***************************************************************************/
	function getPlaneacionObservaciones($grupoId,$lineaAtencion){
		global $db_siclan;
		return $db_siclan->select("tb_planeacion_grupo",
			[
			"[>]tb_persona_2017"=>["FK_Id_Usuario_Registro"=>"PK_Id_Persona"]
			],[
			"tb_planeacion_grupo.DA_Fecha_Registro (DA_Fecha_Registro)",
			"tb_planeacion_grupo.IN_Estado (IN_Estado)",
			"tb_planeacion_grupo.DT_AFA_Cambio (DT_AFA_Cambio)",
			"tb_planeacion_grupo.VC_Observacion (TX_Observacion)",
			"tb_planeacion_grupo.FK_grupo",
			"tb_planeacion_grupo.FK_Id_Linea_atencion",
			"tb_planeacion_grupo.FK_Ciclo",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			],
			["AND"=>[
			"tb_planeacion_grupo.FK_grupo"=>$grupoId,
			"tb_planeacion_grupo.FK_Id_Linea_atencion"=>$lineaAtencion
			]
			]);
	}
	/***************************************************************************
	/* getValoracionObservaciones() retorna las observaciones y demas datos relevantes del formato
	***************************************************************************/
	function getValoracionObservaciones($grupoId,$lineaAtencion){
		global $db_siclan;
		return $db_siclan->select("tb_valoracion_grupo",
			[
			"[>]tb_persona_2017"=>["FK_Formador"=>"PK_Id_Persona"]
			],[
			"tb_valoracion_grupo.DA_Fecha  (DA_Fecha_Registro)",
			"tb_valoracion_grupo.IN_Estado  (IN_Estado)",
			"tb_valoracion_grupo.DT_AFA_Cambio  (DT_AFA_Cambio)",
			"tb_valoracion_grupo.TX_Observacion  (TX_Observacion)",
			"tb_valoracion_grupo.FK_grupo",
			"tb_valoracion_grupo.FK_Linea_Atencion (FK_Id_Linea_atencion)",
			"tb_valoracion_grupo.FK_Ciclo",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			],
			["AND"=>[
			"tb_valoracion_grupo.FK_grupo"=>$grupoId,
			"tb_valoracion_grupo.FK_Linea_Atencion"=>$lineaAtencion
			]
			]);
	}

	function saveTipoGrupoEmprendeClan($id_grupo,$es_vacacional){
		global $db_siclan;
		return $db_siclan->insert("tb_terr_grupo_emprende_clan_tipo_grupo",[
			"FK_grupo"=>$id_grupo,
			"tipo_grupo"=>$es_vacacional
		]);
	}

	function getLugaresAtencionLaboratorioClan(){
		global $db_siclan;
		return $db_siclan->select("tb_terr_lugar_atencion_laboratorio_clan","*");
	}

	/***************************************************************************
	/* saveNewGrupoLaboratorioClan() guarda un nuevo registro de grupo de la linea de atención laboratorio clan.
	***************************************************************************/
	function saveNewGrupoLaboratorioClan($id_clan,$id_area_artistica,$id_lugar_atencion,$tipo_poblacion,$id_usuario,$observaciones){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$id_grupo = $db_siclan->insert("tb_terr_grupo_laboratorio_clan",[
			"FK_clan"=>$id_clan,
			"FK_area_artistica"=>$id_area_artistica,
			"FK_lugar_atencion"=>$id_lugar_atencion,
			"tipo_poblacion"=>$tipo_poblacion,
			"DT_fecha_creacion"=>date('Y-m-d H:i:s'),
			"FK_creador"=>$id_usuario,
			"TX_observaciones"=>$observaciones
			]);
		return $id_grupo;
	}

	/***************************************************************************
	/* saveHorarioNuevoGrupoLaboratorioClan() guarda el horario establecido para un grupo que esta siendo creado en la línea de atención laboratorio clan.
	***************************************************************************/
	function saveHorarioNuevoGrupoLaboratorioClan($id_grupo,$dia_clase,$hora_inicio,$hora_fin){
		global $db_siclan;
		$insert = $db_siclan->insert("tb_terr_grupo_laboratorio_clan_horario_clase",[
			"FK_grupo"=>$id_grupo,
			"IN_dia"=>$dia_clase,
			"TI_hora_inicio_clase"=>$hora_inicio,
			"TI_hora_fin_clase"=>$hora_fin
			]);
		return $insert;
	}

	function ConsultarClanByGrupo($tipo_grupo,$id_grupo){
		global $db_siclan;
		return $db_siclan->select("tb_terr_grupo_".$tipo_grupo,"FK_clan",["PK_Grupo"=>$id_grupo]);
	}
?>
