<?php
header ('Content-type: text/html; charset=utf-8');
	// Incluir libreria de acceso a base de datos
require_once('../../Modelo/medoo/medoo.php');
require_once('../../Modelo/medoo/parametros_conexion.php');

	/***************************************************************************
	/*getAreasArtisticas() retorna el id, y nombre de las areas artisticas que existen.
	***************************************************************************/
	function getAreasArtisticas(){
		global $db_siclan;
		$area = $db_siclan->select("tb_areas_artisticas",["PK_Area_Artistica","VC_Nom_Area"]);
		return $area;
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
	/* getOrganizacionYAreaArtisticaGrupoArteEscuela() consulta el nombre de la organización y area artistica de un grupo de arte en la escuela
	***************************************************************************/
	function getOrganizacionYAreaArtisticaGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$datos = $db_siclan->select("tb_terr_grupo_arte_escuela",[
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_organizacion"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"]
		],[
			"tb_organizaciones_2017.VC_Nom_Organizacion",
			"tb_areas_artisticas.VC_Nom_Area"
		],["PK_Grupo"=>$id_grupo]);
		return $datos;
	}

	/***************************************************************************
	/* getOrganizacionYAreaArtisticaGrupoEmprendeClan() consulta el nombre de la organización y area artistica de un grupo de emprende clan
	***************************************************************************/
	function getOrganizacionYAreaArtisticaGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$datos = $db_siclan->select("tb_terr_grupo_emprende_clan",[
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_organizacion"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"]
		],[
			"tb_organizaciones_2017.VC_Nom_Organizacion",
			"tb_areas_artisticas.VC_Nom_Area"
		],["PK_Grupo"=>$id_grupo]);
		return $datos;
	}

	/***************************************************************************
	/* getOrganizacionYAreaArtisticaGrupoLaboratorioCrea() consulta el nombre de la organización y area artistica de un grupo de laboratorio crea
	***************************************************************************/
	function getOrganizacionYAreaArtisticaGrupoLaboratorioCrea($id_grupo){
		global $db_siclan;
		$datos = $db_siclan->select("tb_terr_grupo_laboratorio_clan",[
			"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_organizacion"],
			"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"]
		],[
			"tb_organizaciones_2017.VC_Nom_Organizacion",
			"tb_areas_artisticas.VC_Nom_Area"
		],["PK_Grupo"=>$id_grupo]);
		return $datos;
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
				"tb_areas_artisticas.PK_Area_Artistica",
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
				"tb_areas_artisticas.PK_Area_Artistica",
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
				"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"],
				"[>]tb_terr_lugar_atencion_laboratorio_clan"=>["FK_lugar_atencion"=>"PK_lugar_atencion"]
			],[
				"tb_areas_artisticas.PK_Area_Artistica",
				"tb_areas_artisticas.VC_Nom_Area",
				"tb_clan.VC_Nom_Clan",
				"tb_terr_lugar_atencion_laboratorio_clan.VC_Nombre_Lugar",
				"tb_terr_grupo_laboratorio_clan.DT_fecha_creacion"
			],["AND"=>[
				"PK_Grupo"=>$id_grupo,
			]
		]);
			return $datos;
		}
	}
	/***************************************************************************
	/* getArtistasFormadores() retorna el id, cedula y nombres de las personas que tienen el rol de artista formador.
	***************************************************************************/
	function getArtistasFormadores(){
		global $db_siclan;
		$artista_formador = $db_siclan->select("tb_persona",["PK_Id_Persona","VC_Identificacion","VC_Primer_Apellido","VC_Segundo_Apellido","VC_Primer_Nombre","VC_Segundo_Nombre"],["FK_Tipo_Persona"=>[1,2]]);
		return $artista_formador;
	}

	/***************************************************************************
	/* getOrganizaciones() retorna el id, nombre de las organizaciones.
	***************************************************************************/
	function getOrganizaciones(){
		global $db_siclan;
		$organizacion = $db_siclan->select("tb_organizaciones",["PK_Id_Organizacion","VC_Nom_Organizacion"],["PK_Id_Organizacion[>]"=>1]);
		return $organizacion;
	}

	/***************************************************************************
	/* insertEvaluacionArtistaFormador() inserta un nuevo registro de evaluación a un artista formador.
	***************************************************************************/
	function insertEvaluacionArtistaFormador($id_usuario,$id_artista_formador,$id_area_artistica,$p1,$j1,$p2,$j2,$p3,$j3,$p4,$j4,$p5,$j5){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$ultimo_id = $db_siclan->max("tb_ped_evaluacion_artista_formador","PK_evaluacion");
		$ultimo_id++;
		$db_siclan->insert("tb_ped_evaluacion_artista_formador",[
			"PK_evaluacion" => $ultimo_id,
			"FK_evaluador" => $id_usuario,
			"FK_artista_formador_evaluado" => $id_artista_formador,
			"FK_area_artistica" => $id_area_artistica,
			"DT_fecha_registro" => date('Y-m-d H:i:s'),
			"IN_cumplimiento_entrega_tareas" => $p1,
			"VC_cumplimiento_entrega_tareas" => $j1,
			"IN_disposicion_colaboracion_trabajo_equipo" => $p2,
			"VC_disposicion_colaboracion_trabajo_equipo" => $j2,
			"IN_aportes_area_artistica" => $p3,
			"VC_aportes_area_artistica" => $j3,
			"IN_evidencia_calidad_procesos_formativos" => $p4,
			"VC_evidencia_calidad_procesos_formativos" => $j4,
			"IN_evidencia_resultados_desempenio_artistico" => $p5,
			"VC_evidencia_resultados_desempenio_artistico" => $j5,
			"IN_puntaje_total" => ($p1+$p2+$p3+$p4+$p5),
			"anio" => 2018
		]);
		return $ultimo_id;
	}

	/***************************************************************************
	/* insertEvaluacionOrganizacion() inserta un nuevo registro de evaluación a una organización
	***************************************************************************/
	function insertEvaluacionOrganizacion($id_usuario,$id_organizacion,$p1,$j1,$p2,$j2,$p3,$j3,$p4,$j4,$p5,$j5,$p6,$j6,$p7,$j7){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$ultimo_id = $db_siclan->max("tb_ped_evaluacion_organizacion","PK_evaluacion");
		$ultimo_id++;
		$db_siclan->insert("tb_ped_evaluacion_organizacion",[
			"PK_evaluacion" => $ultimo_id,
			"FK_evaluador" => $id_usuario,
			"FK_organizacion_evaluada" => $id_organizacion,
			"DT_fecha_registro" => date('Y-m-d H:i:s'),
			"IN_coherencia_propuesta_desarrollo_proyecto" => $p1,
			"VC_coherencia_propuesta_desarrollo_proyecto" => $j1,
			"IN_apropiacion_orientacion_pedagogica" => $p2,
			"VC_apropiacion_orientacion_pedagogica" => $j2,
			"IN_materiales_aportados" => $p3,
			"VC_materiales_aportados" => $j3,
			"IN_desempenio" => $p4,
			"VC_desempenio" => $j4,
			"IN_evidencia_valoracion_proceso_formativo" => $p5,
			"VC_evidencia_valoracion_proceso_formativo" => $j5,
			"IN_evidencia_acompanamiento" => $p6,
			"VC_evidencia_acompanamiento" => $j6,
			"IN_aportes_area_artistica" => $p7,
			"VC_aportes_area_artistica" => $j7,
			"IN_puntaje_total" => ($p1+$p2+$p3+$p4+$p5+$p6+$p7)

		]);
		return $ultimo_id;
	}

	/***************************************************************************
	/* addClanesEvaluacionArtistaFormdaor() inserta los clanes relacionados en la evaluación de un artista formador
	***************************************************************************/
	function addClanesEvaluacionArtistaFormador($clan,$id_evaluacion){
		global $db_siclan;
		$clan = split("-", $clan);
		foreach ($clan as $c) {
			$db_siclan->insert("tb_ped_evaluacion_artista_formador_su_clan",[
				"FK_clan" => $c,
				"FK_evaluacion" => $id_evaluacion
			]);
		}
	}

	/***************************************************************************
	/* addColegiosEvaluacionArtistaFormdaor() inserta los colegios relacionados en la evaluación de un artista formador
	***************************************************************************/
	function addColegiosEvaluacionArtistaFormador($colegio,$id_evaluacion){
		global $db_siclan;
		$colegio = split("-", $colegio);
		foreach ($colegio as $c) {
			$db_siclan->insert("tb_ped_evaluacion_artista_formador_su_colegio",[
				"FK_colegio" => $c,
				"FK_evaluacion" => $id_evaluacion
			]);
		}
	}

	/***************************************************************************
	/* addOrganizacionesEvaluacionArtistaFormdaor() inserta las organizaciones relacionadas en la evaluación de un artista formador
	***************************************************************************/
	function addOrganizacionesEvaluacionArtistaFormador($organizacion,$id_evaluacion){
		global $db_siclan;
		$organizacion = split("-", $organizacion);
		foreach ($organizacion as $o) {
			$db_siclan->insert("tb_ped_evaluacion_artista_formador_su_organizacion",[
				"FK_organizacion" => $o,
				"FK_evaluacion" => $id_evaluacion
			]);
		}
	}

	/***************************************************************************
	/* addOrganizacionesEvaluacionArtistaFormdaor() inserta las organizaciones relacionadas en la evaluación de un artista formador
	***************************************************************************/
	function addLineasAtencionEvaluacionArtistaFormador($linea_atencion,$id_evaluacion){
		global $db_siclan;
		$linea_atencion = split("-", $linea_atencion);
		foreach ($linea_atencion as $l) {
			$db_siclan->insert("tb_ped_evaluacion_artista_formador_su_linea_atencion",[
				"FK_linea_atencion" => $l,
				"FK_evaluacion" => $id_evaluacion
			]);
		}
	}

	/***************************************************************************
	/* insertEncuesta() inserta la encuesta realizada a un estudiante
	***************************************************************************/
	function insertEncuesta($nombre_estudiante,$id_area_artistica,$id_formador,$r1,$r2,$r3,$r4,$r5,$r6,$r7,$observaciones){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$ultimo_id = $db_siclan->max("tb_ped_encuesta_estudiantes","PK_encuesta");
		$ultimo_id++;
		$db_siclan->insert("tb_ped_encuesta_estudiantes",[
			"PK_encuesta" => $ultimo_id,
			"DT_fecha_registro" => date('Y-m-d H:i:s'),
			"VC_nombre_estudiante" => $nombre_estudiante,
			"FK_area_artistica" => $id_area_artistica,
			"FK_artista_formador" => $id_formador,
			"RT_1" => $r1,
			"RT_2" => $r2,
			"RT_3" => $r3,
			"RT_4" => $r4,
			"RT_5" => $r5,
			"RT_6" => $r6,
			"RT_7" => $r7,
			"VC_observaciones" => $observaciones,
			"anio" => 2018
		]);
		return $ultimo_id;
	}

	/***************************************************************************
	/* getArtistaFormadorEvaluadoPorFuncionario() retorna el nombre de los funcionarios que han sido evaluados por funcionarios
	***************************************************************************/
	function getArtistaFormadorEvaluadoPorFuncionario(){
		global $db_siclan;
		$artista_formador = $db_siclan->select("view_ped_resultado_evaluacion_artista_formador_por_funcionario",["Artista_Formador_Evaluado"]);
		return $artista_formador;
	}

	/***************************************************************************
	/* getArtistaFormadorEvaluadoPorEstudiante() retorna el nombre de los funcionarios que han sido evaluados por estudiantes
	***************************************************************************/
	function getArtistaFormadorEvaluadoPorEstudiante(){
		global $db_siclan;
		$artista_formador = $db_siclan->select("view_ped_resultado_evaluacion_artista_formador_por_estudiante",["Artista_Formador"]);
		return $artista_formador;
	}

	/***************************************************************************
	/* getOrganizacionEvaluadoPorFuncionario() retorna el nombre de las organizaciones que han sido evaluadas por los funcionarios.
	***************************************************************************/
	function getOrganizacionEvaluadoPorFuncionario(){
		global $db_siclan;
		$organizacion = $db_siclan->select("view_ped_resultado_evaluacion_organizacion_por_funcionario",["Organizacion"]);
		return $organizacion;
	}

	/***************************************************************************
	/* getResultadoEvaluacionArtistaFormadorPorFuncionario() consulta todas las evaluaciones realizadas por funcionarios a un artista formador especifico.
	***************************************************************************/
	function getResultadoEvaluacionArtistaFormadorPorFuncionario($nombre_artista_formador){
		global $db_siclan;
		$artista_formador = $db_siclan->select("view_ped_resultado_evaluacion_artista_formador_por_funcionario","*",["Artista_Formador_Evaluado"=>$nombre_artista_formador]);
		return $artista_formador;
	}

	/***************************************************************************
	/* getResultadoEvaluacionArtistaFormadorPorEstudiante() consulta todas las evaluaciones realizadas por los estudiantes a un artista formador especifico.
	***************************************************************************/
	function getResultadoEvaluacionArtistaFormadorPorEstudiante($nombre_artista_formador){
		global $db_siclan;
		$artista_formador = $db_siclan->select("view_ped_resultado_evaluacion_artista_formador_por_estudiante","*",["Artista_Formador"=>$nombre_artista_formador]);
		return $artista_formador;
	}

	/***************************************************************************
	/* getAllResultadoEvaluacionOrganizacionPorFuncionario() consulta todas las evaluaciones realizadas por los funcionarios a una organización especifica.
	***************************************************************************/
	function getResultadoEvaluacionOrganizacionPorFuncionario($nombre_organizacion){
		global $db_siclan;
		$organizacion = $db_siclan->select("view_ped_resultado_evaluacion_organizacion_por_funcionario","*",["Organizacion"=>$nombre_organizacion]);
		return $organizacion;
	}

	/***************************************************************************
	/* getAllResultadoEvaluacionArtistaFormadorPorFuncionario() consulta todas las evaluaciones realizadas por los funcionarios a todos los artistas formadores.
	***************************************************************************/
	function getAllResultadoEvaluacionArtistaFormadorPorFuncionario(){
		global $db_siclan;
		$artista_formador = $db_siclan->select("view_ped_resultado_evaluacion_artista_formador_por_funcionario","*");
		return $artista_formador;
	}

	/***************************************************************************
	/* getAllResultadoEvaluacionArtistaFormadorPorEstudiante() consulta todas las evaluaciones realizadas por los estudiantes a todos los artistas formadores.
	***************************************************************************/
	function getAllResultadoEvaluacionArtistaFormadorPorEstudiante(){
		global $db_siclan;
		$artista_formador = $db_siclan->select("view_ped_resultado_evaluacion_artista_formador_por_estudiante","*");
		return $artista_formador;
	}

	/***************************************************************************
	/* getAllResultadoEvaluacionOrganizacionPorFuncionario() consulta todas las evaluaciones realizadas por los funcionarios a todas las organizaciones.
	***************************************************************************/
	function getAllResultadoEvaluacionOrganizacionPorFuncionario(){
		global $db_siclan;
		$organizacion = $db_siclan->select("view_ped_resultado_evaluacion_organizacion_por_funcionario","*");
		return $organizacion;
	}
	/***************************************************************************
	/* guardarPlaneacion() guarda toda la informacion referente a la planeacion
	***************************************************************************/
	function guardarPlaneacion($grupo,$linea,$ciclo,$objetivo,$pregunta,$descripcion,$metodologia,$temas,$recursos,$referentes,$accionesJson,$usuarioRegistro,$fecha,$circulacion,$resultados,$articulacion,$ciclotext){
		global $db_siclan;
		$db_siclan->insert("tb_planeacion_grupo",[
			'FK_grupo'=>$grupo,
			'FK_Id_Linea_atencion'=>$linea,
			'FK_Ciclo'=>$ciclo,
			'VC_Objetivo'=>$objetivo,
			'VC_Pregunta'=>$pregunta,
			'VC_Descripcion'=>$descripcion,
			'VC_Metodologia'=>$metodologia,
			'VC_Temas'=>$temas,
			'VC_Recursos'=>$recursos,
			'VC_Referentes'=>$referentes,
			'VC_Acciones'=>$accionesJson,
			'FK_Id_Usuario_Registro'=>$usuarioRegistro,
			'DA_Fecha_Registro'=>$fecha,
			'VC_Propuesta_Circulacion'=>$circulacion,
			'VC_Resultados'=>$resultados,
			'VC_Articulacion'=>$articulacion,
			'VC_Ciclo'=>$ciclotext
		]);
	}


	/***************************************************************************
	/* updateObservacion() actualiza la observacion de una planificacion especifica
	***************************************************************************/
	function updateObservacion($idPlaneacion,$observacion,$estado,$idUsuario){
		global $db_siclan;
		$update = $db_siclan->update("tb_planeacion_grupo",[
			"VC_Observacion" =>$observacion,
			"IN_Estado" =>$estado,
			"FK_Id_AFA_Cambio" =>$idUsuario,
			"DT_AFA_Cambio"=>date('Y-m-d H:i:s')
		],[
			"PK_Id_Planeacion"=>$idPlaneacion
		]);
		return $update;
	}


	/***************************************************************************
	/* updateObservacionValoracion() actualiza la observacion de una valoracion especifica
	***************************************************************************/
	function updateObservacionValoracion($idValoracion,$observacion,$estado,$idUsuario){
		global $db_siclan;
		$update = $db_siclan->update("tb_valoracion_grupo",[
			"TX_Observacion" =>$observacion,
			"IN_Estado" =>$estado,
			"FK_Id_AFA_Cambio" =>$idUsuario,
			"DT_AFA_Cambio"=>date('Y-m-d H:i:s'),
		],[
			"PK_Id_Valoracion"=>$idValoracion
		]);
		return $update;
	}

	/***************************************************************************
	/* getRecursosActuales() retorna todos los recursos disponibles
	***************************************************************************/
	function getRecursosActuales(){
		global $db_siclan;
		$recursos = $db_siclan->select("tb_recurso","*");
		return $recursos;
	}
	/***************************************************************************
	/* getRecursosActuales() retorna todos los recursos disponibles
	***************************************************************************/
	function consultarPlaneaciones($codigoGrupo,$lineaAtencion){
		global $db_siclan;
		$planeacion = $db_siclan->select("tb_planeacion_grupo","*",[
			"AND"=>[
				"FK_grupo"=>$codigoGrupo,
				"FK_Id_Linea_atencion"=>$lineaAtencion
			]]);
		return $planeacion;
	}
	/***************************************************************************
	/* getValoraciones() retorna las valoraciones que cumplan con las condiciones de grupo
	/* y linea de atencion
	***************************************************************************/
	function consultarValoraciones($codigoGrupo,$lineaAtencion){
		global $db_siclan;
		$valoracion = $db_siclan->select("tb_valoracion_grupo","*",[
			"AND"=>[
				"FK_grupo"=>$codigoGrupo,
				"FK_Linea_Atencion"=>$lineaAtencion
			]]);
		return $valoracion;
	}
	/***************************************************************************
	/* getValoracionFromIdData($valoracionId)() retorna la valoracion de acuerdo al id especificado
	***************************************************************************/
	function getValoracionFromIdData($valoracionId){
		global $db_siclan;
		$valoracion = $db_siclan->select("tb_valoracion_grupo","*",[
			"AND"=>[
				"FK_grupo"=>$codigoGrupo,
				"FK_Linea_Atencion"=>$lineaAtencion
			]]);
		return $valoracion;
	}
	/***************************************************************************
	/* consultarEstudiantesGrupo() retorna los estudiantes y su asistencia deacuerdo al grupo, la linea de atencion y el mes
	***************************************************************************/
	function consultarEstudiantesGrupo($codigoGrupo,$lineaAtencion,$fecha){
		global $db_siclan;
		$anio = explode("-", $fecha)[0];
		$planeacion = null;
		if ($lineaAtencion == 'arte_escuela') {
			$planeacion = $db_siclan->query("
				SELECT te.id,CONCAT( te.VC_Primer_Nombre,' ',te.VC_Segundo_Nombre) AS Nombre,CONCAT( te.VC_Primer_Apellido,' ',te.VC_Segundo_Apellido) AS Apellido,
				COALESCE(tpd.VC_Descripcion,'No aplica') AS VC_Descripcion_Grado,CONCAT(COALESCE(FORMAT((SUM( tgasa.IN_estado_asistencia)/COUNT( tgas.PK_sesion_clase))*100,0),0),'%') AS Asistencias
				FROM tb_terr_grupo_arte_escuela tga
				LEFT JOIN tb_terr_grupo_arte_escuela_sesion_clase tgas ON tgas.FK_grupo = tga.PK_Grupo
				LEFT JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia tgasa ON tgasa.FK_sesion_clase = tgas.PK_sesion_clase
				JOIN tb_terr_grupo_arte_escuela_estudiante tgae ON tgasa.FK_estudiante = tgae.FK_estudiante AND tgae.estado = 1  AND tgae.FK_grupo = tga.PK_Grupo
				LEFT JOIN tb_estudiante te ON te.id = tgae.FK_estudiante
				LEFT JOIN tb_estudiante_simat tes ON tes.NRO_DOCUMENTO = te.IN_Identificacion
				LEFT JOIN tb_estudiante_detalle_anio teda ON teda.FK_estudiante = te.id AND teda.anio= '".$anio."'
				LEFT JOIN tb_parametro_detalle tpd ON tpd.FK_Id_Parametro = 18 AND (tpd.FK_Value = tes.GRADO OR teda.FK_grado = tpd.FK_Value)
				WHERE tga.PK_Grupo = ".$codigoGrupo."  GROUP BY tgae.FK_Estudiante
				ORDER BY te.VC_Primer_Nombre;")->fetchAll();
		}
		if ($lineaAtencion == 'emprende_clan') {
			$planeacion = $db_siclan->query("
				SELECT te.id,CONCAT( te.VC_Primer_Nombre,' ',te.VC_Segundo_Nombre) AS Nombre,CONCAT( te.VC_Primer_Apellido,' ',te.VC_Segundo_Apellido) AS Apellido,
				COALESCE(tpd.VC_Descripcion,'No aplica') AS VC_Descripcion_Grado,CONCAT(COALESCE(FORMAT((SUM( tgesa.IN_estado_asistencia)/COUNT( tges.PK_sesion_clase))*100,0),0),'%') AS Asistencias
				FROM tb_terr_grupo_emprende_clan tge
				LEFT JOIN tb_terr_grupo_emprende_clan_sesion_clase tges ON tges.FK_grupo = tge.PK_Grupo
				LEFT JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia tgesa ON tgesa.FK_sesion_clase = tges.PK_sesion_clase
				JOIN tb_terr_grupo_emprende_clan_estudiante tgee ON tgesa.FK_estudiante = tgee.FK_estudiante AND tgee.estado = 1 AND tgee.FK_grupo = tge.PK_Grupo
				LEFT JOIN tb_estudiante te ON te.id = tgee.FK_estudiante
				LEFT JOIN tb_estudiante_simat tes ON tes.NRO_DOCUMENTO = te.IN_Identificacion
				LEFT JOIN tb_estudiante_detalle_anio teda ON teda.FK_estudiante = te.id AND teda.anio= '".$anio."'
				LEFT JOIN tb_parametro_detalle tpd ON tpd.FK_Id_Parametro = 18 AND (tpd.FK_Value = tes.GRADO OR teda.FK_grado = tpd.FK_Value)
				WHERE tge.PK_Grupo = ".$codigoGrupo." GROUP BY tgee.FK_Estudiante
				ORDER BY te.VC_Primer_Nombre;
				")->fetchAll();
		}
		return $planeacion;
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
	/* getCaracterizacionData($codigoGrupo,$lineaAtencion) consulta los datos de los grupos de emprende clan activos que estan asignados a un Artista Formador
	***************************************************************************/
	function getCaracterizacionData($codigoGrupo,$lineaAtencion){
		global $db_siclan;
		$caracterizacion = $db_siclan->select("tb_caracterizacion_grupo","*",[
			"AND"=>[
				"FK_Grupo"=>$codigoGrupo,
				"FK_Id_Linea_Atencion"=>$lineaAtencion
			]]);
		return $caracterizacion;
	}
	/***************************************************************************
	/* insertEvaluacionOrganizacion() inserta un nuevo registro de evaluación a una organización
	***************************************************************************/
	function guardarCaracterizacionData($Id_Grupo,$Linea_Atencion,$Ciclo,$Descripcion_Grupo,$Slider_Convivencia,$Descripcion_Convivencia,$Intereses_Array,$Descripcion_Intereses,$Slider_Actitudinales,$Descripcion_Actitudinales,$Slider_Cognitivos,$Descripcion_Cognitivos,$Slider_Procedimentales,$Descripcion_Procedimentales,$Necesidades, $Etnias, $Descripcion_Particularidades, $Espacio, $Observaciones, $Id_Artista_Formador){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$Fecha=date("Y-m-d H:i:s");


		$rta = $db_siclan->insert("tb_caracterizacion_grupo",[
			"FK_Grupo" => $Id_Grupo,
			"FK_Id_Linea_Atencion" => $Linea_Atencion,
			"FK_Ciclo" => $Ciclo,
			"TX_Descripcion_Grupo" => $Descripcion_Grupo,
			"IN_Escala_Convivencia" => $Slider_Convivencia,
			"TX_Convivencia" => $Descripcion_Convivencia,
			"TX_Array_Intereses" => $Intereses_Array,
			"TX_Descripcion_Intereses" => $Descripcion_Intereses,
			"IN_Escala_Actitudinal" => $Slider_Actitudinales,
			"TX_Actitudinal" => $Descripcion_Actitudinales,
			"IN_Escala_Cognitiva" => $Slider_Cognitivos,
			"TX_Cognitiva" => $Descripcion_Cognitivos,
			"IN_Escala_Procedimental" => $Slider_Procedimentales,
			"TX_Procedimental" => $Descripcion_Procedimentales,
			"VC_Necesidades" => $Necesidades,
			"VC_Etnias" => $Etnias,
			"TX_Particularidades" => $Descripcion_Particularidades,
			"TX_Descripcion_Espacio" => $Espacio,
			"TX_Observaciones" => $Observaciones,
			"FK_Id_Usuario_Registro" => $Id_Artista_Formador,
			"DA_Fecha_Registro" => $Fecha
		]);
		return $rta;
	}
	/***************************************************************************
	/* guardarValoracion() inserta un nuevo registro de valoracion de un grupo
	***************************************************************************/
	function guardarValoracion($periodo,$ciclo,$artistaFormadorId,$codigoGrupo,$tipo_grupo,$gestoCognitivo){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$fecha=date("Y-m-d H:i:s");
		$db_siclan->insert("tb_valoracion_grupo",[
			"FK_Grupo" => $codigoGrupo,
			"FK_Linea_Atencion" => $tipo_grupo,
			"FK_Periodo" => $periodo,
			"FK_Ciclo" => $ciclo,
			"TX_Gesto_Cognitivo" => $gestoCognitivo,
			"FK_Formador" => $artistaFormadorId,
			"DA_Fecha" => $fecha
		]);
		$valoracion = $db_siclan->select("tb_valoracion_grupo","PK_Id_Valoracion",[
			"AND"=>[
				"DA_Fecha"=>$fecha,
				"FK_grupo"=>$codigoGrupo,
				"FK_Linea_Atencion"=>$tipo_grupo,
				"FK_Formador"=>$artistaFormadorId
			]]);

		if (sizeof($valoracion) > 0){
			$data = $valoracion[sizeof($valoracion)-1];
			$valoracionId = $data;
		}
		else{
			$valoracionId = null;
		}
		return $valoracionId;
	}
	/***************************************************************************
	/* guardarEstudianteValoracion() inserta un nuevo registro de valoracion de un estudiante
	***************************************************************************/
	function guardarEstudianteValoracion($idEstudiante,$cognitivo,$actitudinal,$convivencial,$observacion,$idValoracion,$asistencia){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$fecha=date("Y-m-d H:i:s");
		$rta = $db_siclan->insert("tb_valoracion_estudiante",[
			"FK_Valoracion" => $idValoracion,
			"FK_Estudiante" => $idEstudiante,
			"IN_Val_Actitudinal" => $actitudinal,
			"IN_Val_Convivencial" => $convivencial,
			"IN_Val_Cognitivo" => $cognitivo,
			"TX_Recomendacion" => $observacion,
			"DA_Fecha" => $fecha,
			"TX_Asistencia" => $asistencia
		]);
		return $rta;
	}

	/***************************************************************************
	/* guardarEstudianteValoracion() inserta un nuevo registro de valoracion de un estudiante
	***************************************************************************/
	function guardarValoracionAnexo($idValoracion,$Nombre_Archivo,$Url,$fecha){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$fecha=date("Y-m-d H:i:s");
		$update = $db_siclan->update("tb_valoracion_grupo",[
			"VC_Nombre_Archivo" =>$Nombre_Archivo,
			"VC_URL" =>$Url,
			"DA_Subida" =>$fecha
		],[
			"PK_Id_Valoracion"=>$idValoracion
		]);
		return $update;
	}


	?>
