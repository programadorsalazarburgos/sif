<?php
header ('Content-type: text/html; charset=utf-8');
include_once('../../Modelo/GestionClan/Acceso_Datos.php');
error_reporting(0);
ini_set('display_errors', 0);
if (isset($_POST['opcion'])){
	switch ($_POST['opcion']) {
		case 'get_grupo_arte_escuela':
		echo getGrupoArteEscuela($_POST['id_clan']);
		break;
		case 'get_grupo_emprende_clan':
		echo getGrupoEmprendeClan($_POST['id_clan']);
		break;
		case 'get_grupo_laboratorio_clan':
		echo getGrupoLaboratorioClan($_POST['id_clan']);
		break;
		case 'getHorarioGrupoArteEscuela':
		echo getHorarioGrupoArteEscuela($_POST['codigo_grupo']);
		break;
		case 'getHorarioGrupoEmprendeClan':
		echo getHorarioGrupoEmprendeClan($_POST['codigo_grupo']);
		break;
		case 'getHorarioGrupoLaboratorioClan':
		echo getHorarioGrupoLaboratorioClan($_POST['codigo_grupo']);
		break;
		case 'getFechaPrimerClaseGrupoArteEscuela':
		echo getFechaPrimerClaseGrupoArteEscuela($_POST['codigo_grupo']);
		break;
		case 'getFechaPrimerClaseGrupoEmprendeClan':
		echo getFechaPrimerClaseGrupoEmprendeClan($_POST['codigo_grupo']);
		break;
		case 'getFechaPrimerClaseGrupoLaboratorioClan':
		echo getFechaPrimerClaseGrupoLaboratorioClan($_POST['codigo_grupo']);
		break;
		case 'getPromedioAsistentesGrupoArteEscuela':
		echo getPromedioAsistentesGrupoArteEscuela($_POST['codigo_grupo']);
		break;
		case 'get_estudiantes_grupo_arte_escuela':
		echo getTableEstudiantesGrupoArteEscuela($_POST['id_grupo']);
		break;
		case 'get_estudiantes_grupo_emprende_clan':
		echo getTableEstudiantesGrupoEmprendeClan($_POST['id_grupo']);
		break;
		case 'get_estudiantes_grupo_laboratorio_clan':
		echo getTableEstudiantesGrupoLaboratorioClan($_POST['id_grupo']);
		break;
		case 'get_Catacterizaciones_Grupo_Arte_Escuela':
		echo get_Catacterizaciones_Grupo_Arte_Escuela($_POST['id_grupo']);
		break;
		case 'get_Catacterizaciones_Grupo_Emprende_Clan':
		echo get_Catacterizaciones_Grupo_Emprende_Clan($_POST['id_grupo']);
		break;
		case 'get_Catacterizaciones_Grupo_Laboratorio_Clan':
		echo get_Catacterizaciones_Grupo_Laboratorio_Clan($_POST['id_grupo']);
		break;
		case 'get_Planeaciones_Grupo_Arte_Escuela':
		echo get_Planeaciones_Grupo_Arte_Escuela($_POST['id_grupo']);
		break;
		case 'get_Planeaciones_Grupo_Emprende_Clan':
		echo get_Planeaciones_Grupo_Emprende_Clan($_POST['id_grupo']);
		break;
		case 'get_Planeaciones_Grupo_Laboratorio_Clan':
		echo get_Planeaciones_Grupo_Laboratorio_Clan($_POST['id_grupo']);
		break;
		case 'getValoraciones':
		echo getValoraciones($_POST['lineaAtencion'],$_POST['id_grupo']);
		break;
		case 'getPlaneacion':
		echo getPlaneacion($_POST['planeacionId']);
		break;
		case 'getValoracion':
		echo getValoracion($_POST['valoracionId']);
		break;
		case 'get_options_clan':
		echo getOptionsClan();
		break;
		case 'getRecursos':
		echo getRecursos($_POST['recursos']);
		break;
		case 'guardarObservacionCaracterizacion':
		echo guardarObservacionCaracterizacion();
		break;
		case 'getCaracterizacion':
		echo getCaracterizacion();
		break;
		case 'getObservaciones':
		echo getObservaciones();
		break;
		default:
		echo "opcion no valida en consultar grupos: (".$_POST['opcion'].")";
		break;
	}
}

	/***************************************************************************
	/* getTableGrupoArteEscuela() retorna una tabla con los grupos de arte en la escuela.
	***************************************************************************/
	function getGrupoArteEscuela($id_clan){
		$id_clan = explode(",",$id_clan);
		$grupo = getGruposArteEscuelaByClan($id_clan);
		$return = "";
		foreach ($grupo as $g){
			$return .= "<tr>";
			$return .= "<td>AE-".$g['PK_grupo']."</td>";
			$return .= "<td>".$g['VC_Nom_Clan']."</td>";
			$return .= "<td>".$g['VC_Nom_Area']."</td>";
			$return .= "<td>".$g['tipo_grupo']."</td>";
			$return .= "<td>".$g['VC_Nom_Colegio']."</td>";
			$return .= "<td>".$g['VC_Nom_Organizacion']."</td>";
			$return .= "<td class='text-center'>".$g["VC_Primer_Nombre"]." ".$g["VC_Segundo_Nombre"]." ".$g["VC_Primer_Apellido"]." ".$g["VC_Segundo_Apellido"]."</td>";
			switch ($g['IN_lugar_atencion']) {
				case '1':
				$return .= "<td>Solo Colegio</td>";
				break;
				case '2':
				$return .= "<td>Solo CLAN</td>";
				break;
				case '3':
				$return .= "<td>CLAN y Colegio</td>";
				break;
				default:
						# code...
				break;
			}
			$return .= "<td>".$g['DT_fecha_creacion']."</td>";
			$return .= "<td>".getHorarioGrupoArteEscuela($g['PK_grupo'])."</td>";
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_estudiantes_grupo' class='consultar_listado_estudiantes_grupo_arte_escuela btn btn-warning' data-id_grupo='".$g['PK_grupo']."'>".getCountEstudiantesGrupoArteEscuela($g['PK_grupo'])."</td>";
			$return .= "<td>".$g['TX_observaciones']."</td>";
			if($g['estado'] == 1){
				$return .= "<td class='bg-success'>Activo</td>";
			}else if($g['estado'] == 0){
				$return .= "<td class='bg-danger'>Inactivo</td>";
			}
			$return .= "<td>".$g["DT_fecha_cierre"]."</td>";
			$return .= "<td>".$g["CERRO"]."</td>";
			$disabled = 'btn-success ';
			$text = 'Descargar';
			$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='caracterizacion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones </a>";
			if ($g['CT_Caracterizacion'] == 0) {
				$disabled = 'btn-danger  disabled';
				$text = 'Sin Caracterizar';
				$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='caracterizacion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones </a>";
			}
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_caracterizaciones_grupo_ae' class='consultar_caracterizaciones_grupo_arte_escuela btn ".$disabled."' data-id_grupo='".$g['PK_grupo']."'>".$text."</a>".$observaciones."</td>";
			$disabled = 'btn-success ';
			$text = 'Descargar';
			$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='planeacion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones </a>";
			if ($g['CT_Planeacion'] == 0) {
				$disabled = 'btn-danger  disabled';
				$text = 'Sin Planeación';
				$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='planeacion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones </a>";
			}
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_planeacion_grupo_ae' class='btn consultar_planeacion_grupo_arte_escuela ".$disabled." '  data-id_grupo='".$g['PK_grupo']."'>".$text."</a>".$observaciones."</td>";

			$text = 'Descargar';
			$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='valoracion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones</a>";
			$disabled = 'btn-success ';
			if ($g['CT_Valoracion'] == 0) {
				$disabled = 'btn-danger  disabled';
				$text = 'Sin Valoración';
				$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='valoracion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones</a>";
			}
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_valoracion_grupo_ae' class='btn consultar_valoracion_grupo_arte_escuela ".$disabled." '  data-id_grupo='".$g['PK_grupo']."'>".$text."</a>".$observaciones."</td>";
			$return .= "</tr>";
		}
		return $return;
	}

	/***************************************************************************
	/* getTableGrupoEmprendeClan() retorna una tabla con los grupos de emprende clan
	***************************************************************************/
	function getGrupoEmprendeClan($id_clan){
		$id_clan = explode(",", $id_clan);
		$grupo = getGruposEmprendeClanByClan($id_clan);

		$return = "";
		foreach ($grupo as $g){
			$return .= "<tr>";
			$return .= "<td>EC-".$g['PK_grupo']."</td>";
			$return .= "<td>".$g['VC_Nom_Clan']."</td>";
			$return .= "<td>".$g['VC_Nom_Area']."</td>";
			if($g['tipo_grupo'] == 1){
				$return .= "<td>Vacacional</td>";
			}else{
				$return .= "<td>Normal</td>";
			}
			$return .= "<td>".$g['VC_Nom_Modalidad']."</td>";
			$return .= "<td>".$g['VC_Nom_Organizacion']."</td>";
			$return .= "<td class='text-center'>".$g["VC_Primer_Nombre"]." ".$g["VC_Segundo_Nombre"]." ".$g["VC_Primer_Apellido"]." ".$g["VC_Segundo_Apellido"]."</td>";
			$return .= "<td>".$g['DT_fecha_creacion']."</td>";
			$return .= "<td>".getHorarioGrupoEmprendeClan($g['PK_grupo'])."</td>";
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_estudiantes_grupo' class='consultar_listado_estudiantes_grupo_emprende_clan btn btn-warning' data-id_grupo='".$g['PK_grupo']."'>".getCountEstudiantesGrupoEmprendeClan($g['PK_grupo'])."</td>";
			$return .= "<td>".$g['TX_observaciones']."</td>";
			if($g['estado'] == 1){
				$return .= "<td class='bg-success'>Activo</td>";
			}else if($g['estado'] == 0){
				$return .= "<td class='bg-danger'>Inactivo</td>";
			}
			$return .= "<td>".$g["DT_fecha_cierre"]."</td>";
			$return .= "<td>".$g["CERRO"]."</td>";
			$disabled = 'btn-success ';
			$text = 'Descargar';
			$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='caracterizacion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones </a>";
			if ($g['CT_Caracterizacion'] == 0) {
				$disabled = 'btn-danger  disabled';
				$text = 'Sin Caracterizar';
				$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='caracterizacion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones </a>";
			}
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_caracterizaciones_grupo_ec' class='consultar_caracterizaciones_grupo_emprende_clan btn ".$disabled."' data-id_grupo='".$g['PK_grupo']."'>".$text."</a>".$observaciones."</td>";
			$disabled = 'btn-success ';
			$text = 'Descargar';
			$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='planeacion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones </a>";
			if ($g['CT_Planeacion'] == 0) {
				$disabled = 'btn-danger  disabled';
				$text = 'Sin Planeación';
				$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='planeacion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones </a>";
			}
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_planeacion_grupo_ec' class='btn consultar_planeacion_grupo_emprende_clan ".$disabled." '  data-id_grupo='".$g['PK_grupo']."'>".$text."</a>".$observaciones."</td>";
			$disabled = 'btn-success ';
			$text = 'Descargar';
			$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='valoracion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones</a>";
			if ($g['CT_Valoracion'] == 0) {
				$disabled = 'btn-danger  disabled';
				$text = 'Sin Valoración';
				$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='valoracion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones</a>";
			}
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_valoracion_grupo_ec' class='btn consultar_valoracion_grupo_emprende_clan ".$disabled." '  data-id_grupo='".$g['PK_grupo']."'>".$text."</a>".$observaciones."</td>";
			$return .= "</tr>";
		}

		return $return;
	}

	/***************************************************************************
	/* getTableGrupoLaboratorioClan() retorna una tabla con los grupos de laboratorio clan
	***************************************************************************/
	function getGrupoLaboratorioClan($id_clan){
		$id_clan = explode(",", $id_clan);
		$grupo = getGruposLaboratorioClanByClan($id_clan);

		$return = "";
		foreach ($grupo as $g){
			$return .= "<tr>";
			$return .= "<td>LC-".$g['PK_grupo']."</td>";
			$return .= "<td>".$g['VC_Nom_Clan']."</td>";
			$return .= "<td>".$g['VC_Nom_Area']."</td>";
			$return .= "<td>".$g['VC_Nombre_Lugar']."</td>";
			$return .= "<td>".$g['VC_Nom_Organizacion']."</td>";
			$return .= "<td class='text-center'>".$g["VC_Primer_Nombre"]." ".$g["VC_Segundo_Nombre"]." ".$g["VC_Primer_Apellido"]." ".$g["VC_Segundo_Apellido"]."</td>";
			$return .= "<td>".$g['DT_fecha_creacion']."</td>";
			$return .= "<td>".getHorarioGrupoLaboratorioClan($g['PK_grupo'])."</td>";
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_estudiantes_grupo' class='consultar_listado_estudiantes_grupo_laboratorio_clan btn btn-warning' data-id_grupo='".$g['PK_grupo']."'>".getCountEstudiantesGrupoLaboratorioClan($g['PK_grupo'])."</td>";
			$return .= "<td>".$g['TX_observaciones']."</td>";
			if($g['estado'] == 1){
				$return .= "<td class='bg-success'>Activo</td>";
			}else if($g['estado'] == 0){
				$return .= "<td class='bg-danger'>Inactivo</td>";
			}
			$return .= "<td>".$g["DT_fecha_cierre"]."</td>";
			$return .= "<td>".$g["CERRO"]."</td>";
			$disabled = 'btn-success ';
			$text = 'Descargar';
			$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='caracterizacion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones </a>";
			if ($g['CT_Caracterizacion'] == 0) {
				$disabled = 'btn-danger  disabled';
				$text = 'Sin Caracterizar';
				$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='caracterizacion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones </a>";
			}
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_caracterizaciones_grupo_lc' class='consultar_caracterizaciones_grupo_laboratorio_clan btn ".$disabled."' data-id_grupo='".$g['PK_grupo']."'>".$text."</a>".$observaciones."</td>";
			$disabled = 'btn-success ';
			$text = 'Descargar';
			$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='planeacion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones </a>";
			if ($g['CT_Planeacion'] == 0) {
				$disabled = 'btn-danger  disabled';
				$text = 'Sin Planeación';
				$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='planeacion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones </a>";
			}
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_planeacion_grupo_lc' class='btn consultar_planeacion_grupo_laboratorio_clan ".$disabled." '  data-id_grupo='".$g['PK_grupo']."'>".$text."</a>".$observaciones."</td>";
			$disabled = 'btn-success ';
			$text = 'Descargar';
			$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='valoracion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones</a>";
			if ($g['CT_Valoracion'] == 0) {
				$disabled = 'btn-danger  disabled';
				$text = 'Sin Valoración';
				$observaciones = "&nbsp&nbsp&nbsp<a href='#' data-id_grupo='".$g['PK_grupo']."' data-tipo='valoracion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones</a>";
			}
			$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_valoracion_grupo_lc' class='btn consultar_valoracion_grupo_laboratorio_clan ".$disabled." '  data-id_grupo='".$g['PK_grupo']."'>".$text."</a>".$observaciones."</td>";
			$return .= "</tr>";
		}

		return $return;
	}

	/***************************************************************************
	/* getHorarioGrupoArteEscuela() consulta el horario de un grupo de arte en la escuela.
	***************************************************************************/
	function getHorarioGrupoArteEscuela($id_grupo){
		$return = "";
		$dia_semana = ["","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
		$horario_grupo = consultarHorarioGrupoArteEscuela($id_grupo);
		foreach ($horario_grupo as $h) {
			$return .= $dia_semana[$h['IN_dia']]." (".$h['TI_hora_inicio_clase']." a ".$h['TI_hora_fin_clase'].").<br>";
		}
		return $return;
	}

	/***************************************************************************
	/* getHorarioGrupoEmprendeClan() consulta el (los) día(s) de clases que están habilitados en el sistema para las clases.
	***************************************************************************/
	function getHorarioGrupoEmprendeClan($id_grupo){
		$return = "";
		$dia_semana = ["","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
		$horario_grupo = consultarHorarioGrupoEmprendeClan($id_grupo);
		foreach ($horario_grupo as $h) {
			$return .= $dia_semana[$h['IN_dia']]." (".$h['TI_hora_inicio_clase']." a ".$h['TI_hora_fin_clase'].").<br>";
		}
		return $return;
	}

	/***************************************************************************
	/* getHorarioGrupoLaboratorioClan() consulta el (los) día(s) de clases que están habilitados en el sistema para las clases.
	***************************************************************************/
	function getHorarioGrupoLaboratorioClan($id_grupo){
		$return = "";
		$dia_semana = ["","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
		$horario_grupo = consultarHorarioGrupoLaboratorioClan($id_grupo);
		foreach ($horario_grupo as $h) {
			$return .= $dia_semana[$h['IN_dia']]." (".$h['TI_hora_inicio_clase']." a ".$h['TI_hora_fin_clase'].").<br>";
		}
		return $return;
	}

	/***************************************************************************
	/* getFechaPrimerClaseGrupoArteEscuela() consulta la fecha de la primer clase de grupo de arte en la escuela.
	***************************************************************************/
	function getFechaPrimerClaseGrupoArteEscuela($id_grupo){
		$return = "";
		$horario_grupo = consultarFechaPrimerClaseGrupoArteEscuela($id_grupo);
		return $horario_grupo;
	}

	/***************************************************************************
	/* getFechaPrimerClaseGrupoEmprendeClan() consulta la fecha de la primer clase de grupo de emprende clan.
	***************************************************************************/
	function getFechaPrimerClaseGrupoEmprendeClan($id_grupo){
		$return = "";
		$horario_grupo = consultarFechaPrimerClaseGrupoEmprendeClan($id_grupo);
		return $horario_grupo;
	}

	/***************************************************************************
	/* getFechaPrimerClaseGrupoEmprendeClan() consulta la fecha de la primer clase de grupo de emprende clan.
	***************************************************************************/
	function getFechaPrimerClaseGrupoLaboratorioClan($id_grupo,$tipo_grupo){
		$return = "";
		//$horario_grupo = consultarFechaPrimerClaseGrupoLaboratorioClan($id_grupo);
		$horario_grupo = consultarFechaPrimerClaseGrupo($id_grupo,$tipo_grupo);
		return $horario_grupo;
	}

	/***************************************************************************
	/* getPromedioAsistentesGrupo() consulta la el promedio de asistentes.
	***************************************************************************/
	function getPromedioAsistentesGrupoArteEscuela($id_grupo){
		$return = "";
		$promedio_asistentes = consultarPromedioAsistentesGrupoArteEscuela($id_grupo);
		return $promedio_asistentes;
	}

	function getTableEstudiantesGrupoArteEscuela($id_grupo){
		$return = "";
		$estudiante = getAllEstudiantesGrupoArteEscuela($id_grupo);
		foreach ($estudiante as $e) {
			$return .= "<tr>";
			$return .= "<td>".$e['IN_Identificacion']."</td>";
			$return .= "<td>".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']." ".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']."</td>";
			$return .= "<td>".$e['VC_Telefono']." - ".$e['VC_Celular']."</td>";
			$return .= "<td>".$e['DT_fecha_ingreso']."</td>";
			$return .= "<td><a class='btn btn-".(($e['estado'] == 1)? "info" : "danger")."'>".(($e['estado'] == 1)? "Activo" : "Inactivo")."</td>";
			$return .= "</tr>";
		}

		return $return;
	}

	function getTableEstudiantesGrupoEmprendeClan($id_grupo){
		$return = "";
		$estudiante = getAllEstudiantesGrupoEmprendeClan($id_grupo);
		foreach ($estudiante as $e) {
			$return .= "<tr>";
			$return .= "<td>".$e['IN_Identificacion']."</td>";
			$return .= "<td>".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']." ".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']."</td>";
			$return .= "<td>".$e['VC_Telefono']." - ".$e['VC_Celular']."</td>";
			$return .= "<td>".$e['DT_fecha_ingreso']."</td>";
			$return .= "<td><a class='btn btn-".(($e['estado'] == 1)? "info" : "danger")."'>".(($e['estado'] == 1)? "Activo" : "Inactivo")."</td>";
			$return .= "</tr>";
		}
		return $return;
	}

	function getTableEstudiantesGrupoLaboratorioClan($id_grupo){
		$return = "";
		$estudiante = getAllEstudiantesGrupoLaboratorioClan($id_grupo);
		foreach ($estudiante as $e) {
			$return .= "<tr>";
			$return .= "<td>".$e['IN_Identificacion']."</td>";
			$return .= "<td>".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']." ".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']."</td>";
			$return .= "<td>".$e['VC_Telefono']." - ".$e['VC_Celular']."</td>";
			$return .= "<td>".$e['DT_fecha_ingreso']."</td>";
			$return .= "<td><a class='btn btn-".(($e['estado'] == 1)? "info" : "danger")."'>".(($e['estado'] == 1)? "Activo" : "Inactivo")."</td>";
			$return .= "</tr>";
		}
		return $return;
	}

	/***************************************************************************
	/* get_Catacterizaciones_Grupo_Arte_Escuela() retorna en formato <option></option> las caracterizaciones que tiene el grupo de arte en la escuela.
	***************************************************************************/
	function get_Catacterizaciones_Grupo_Arte_Escuela($id_grupo){
		$return = "";
		$estudiante = get_All_Caracterizaciones_Grupo_Arte_Escuela($id_grupo);$return .= "<option>Seleccione la Caracterización</option>";
		foreach ($estudiante as $e) {
			$return .= "<option value='".$e['PK_Id_Caracterizacion']."'>Grupo ".$e['FK_Grupo'].' realizada el '.$e['DA_Fecha_Registro']."</option>";
		}

		return $return;
	}

	/***************************************************************************
	/* get_Catacterizaciones_Grupo_Emprende_Clan() retorna en formato <option></option> las caracterizaciones que tiene el grupo de emprende clan.
	***************************************************************************/
	function get_Catacterizaciones_Grupo_Emprende_Clan($id_grupo){
		$return = "";
		$estudiante = get_All_Caracterizaciones_Grupo_Emprende_Clan($id_grupo);$return .= "<option>Seleccione la Caracterización</option>";
		foreach ($estudiante as $e) {
			$return .= "<option value='".$e['PK_Id_Caracterizacion']."'>Grupo ".$e['FK_Grupo'].' realizada el '.$e['DA_Fecha_Registro']."</option>";
		}

		return $return;
	}

	/***************************************************************************
	/* get_Catacterizaciones_Grupo_Laboratorio_Clan() retorna en formato <option></option> las caracterizaciones que tiene el grupo de Laboratorio clan.
	***************************************************************************/
	function get_Catacterizaciones_Grupo_Laboratorio_Clan($id_grupo){
		$return = "";
		$estudiante = get_All_Caracterizaciones_Grupo_Laboratorio_Clan($id_grupo);$return .= "<option>Seleccione la Caracterización</option>";
		foreach ($estudiante as $e) {
			$return .= "<option value='".$e['PK_Id_Caracterizacion']."'>Grupo ".$e['FK_Grupo'].' realizada el '.$e['DA_Fecha_Registro']."</option>";
		}

		return $return;
	}
	/***************************************************************************
	/* get_Planeaciones_Grupo_Arte_Escuela() retorna en formato <option></option> las planeaciones que tiene el grupo de arte en la escuela.
	***************************************************************************/
	function get_Planeaciones_Grupo_Arte_Escuela($id_grupo){
		$return = "";
		$estudiante = getPlaneacionesGrupoArteEscuela($id_grupo);
		$return .= "<option>Seleccione la Planeación</option>";
		foreach ($estudiante as $e) {
			$return .= "<option value='".$e['PK_Id_Planeacion']."'>Grupo ".$e['FK_grupo'].' realizada el '.$e['DA_Fecha_Registro']."</option>";
		}

		return $return;
	}

	/***************************************************************************
	/* get_Planeaciones_Grupo_Emprende_Clan() retorna en formato <option></option> las planeaciones que tiene el grupo de emprende clan.
	***************************************************************************/
	function get_Planeaciones_Grupo_Emprende_Clan($id_grupo){
		$return = "";
		$estudiante = getPlaneacionesGrupoEmprendeClan($id_grupo);
		$return .= "<option>Seleccione la Planeación</option>";
		foreach ($estudiante as $e) {
			$return .= "<option value='".$e['PK_Id_Planeacion']."'>Grupo ".$e['FK_grupo'].' realizada el '.$e['DA_Fecha_Registro']."</option>";
		}

		return $return;
	}

	/***************************************************************************
	/* get_Planeaciones_Grupo_Laboratorio_Clan() retorna en formato <option></option> las planeaciones que tiene el grupo de laboratorio crea.
	***************************************************************************/
	function get_Planeaciones_Grupo_Laboratorio_Clan($id_grupo){
		$return = "";
		$estudiante = getPlaneacionesGrupoLaboratorioClan($id_grupo);
		$return .= "<option>Seleccione la Planeación</option>";
		foreach ($estudiante as $e) {
			$return .= "<option value='".$e['PK_Id_Planeacion']."'>Grupo ".$e['FK_grupo'].' realizada el '.$e['DA_Fecha_Registro']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getValoraciones() retorna las valoraciones realizadas por un grupo
	***************************************************************************/
	function getValoraciones($lineaAtencion,$id_grupo){
		$valoraciones = getValoracionesList($id_grupo,$lineaAtencion);
		$return = "<option>Seleccione la Valoración</option>";
		foreach ($valoraciones as $e) {
			$return .= "<option value='".$e['PK_Id_Valoracion']."'>Grupo ".$e['FK_Grupo'].' realizada el '.$e['DA_Fecha']."</option>";
		}

		return $return;
	}
	/***************************************************************************
	* trae toda la informacion de una planeacion de acuerdo al Id
	***************************************************************************/
	function getPlaneacion($planeacionId)
	{
		$planeacion = getPlaneacionInfo($planeacionId);
		return json_encode($planeacion);
	}
	/***************************************************************************
	* trae toda la informacion de una valoracion de acuerdo al Id
	***************************************************************************/
	function getValoracion($valoracionId)
	{
		$valoracion = getValoracionInfo($valoracionId);
		return json_encode($valoracion);
	}
	/***************************************************************************
	* trae toda la informacion de una planeacion de acuerdo al Id
	***************************************************************************/
	function getRecursos($recursos)
	{
		$recursosSplit = explode(";", $recursos);
		$recursosList = getRecursosList($recursosSplit);
		return json_encode($recursosList);
	}

	/***************************************************************************
	/* getOptionsClan() retorna en formato <option></option> los clanes registrados en el sistema.
	***************************************************************************/
	function getOptionsClan(){
		$clan = getClanes();
		$return = "";
		foreach ($clan as $c) {
			$return .= "<option value='".$c['PK_Id_Clan']."'>".$c['VC_Nom_Clan']."</option>";
		}
		return $return;
	}
	/***************************************************************************
	/* guardarObservacionCaracterizacion() guarda la observacion de la caracterizacion seleccionada
	***************************************************************************/
	function guardarObservacionCaracterizacion(){
		$idCaracterizacion = "";
		if(isset($_POST['SL_Caracterizaciones_Grupo_Arte_Escuela']))
			$idCaracterizacion = $_POST['SL_Caracterizaciones_Grupo_Arte_Escuela'];	
		if(isset($_POST['SL_Caracterizaciones_Grupo_Emprende_Clan']))
			$idCaracterizacion = $_POST['SL_Caracterizaciones_Grupo_Emprende_Clan'];	
		if(isset($_POST['SL_Caracterizaciones_Grupo_Laboratorio_Clan']))
			$idCaracterizacion = $_POST['SL_Caracterizaciones_Grupo_Laboratorio_Clan'];	

		$observacion = "";
		if(isset($_POST['TXT_Observacion_car_ae']))
			$observacion = $_POST['TXT_Observacion_car_ae'];	
		if(isset($_POST['TXT_Observacion_car_ec']))
			$observacion = $_POST['TXT_Observacion_car_ec'];	
		if(isset($_POST['TXT_Observacion_car_lc']))
			$observacion = $_POST['TXT_Observacion_car_lc'];	

		$estado = "";
		if (isset($_POST['IN_Estado_car_ae'])) {
			if ($_POST['IN_Estado_car_ae'] == "on")
				$estado = '1';
			else
				$estado = '0';
		}

		if (isset($_POST['IN_Estado_car_ec'])) {
			if ($_POST['IN_Estado_car_ec'] == "on")
				$estado = '1';
			else
				$estado = '0';
		}

		if (isset($_POST['IN_Estado_car_lc'])) {
			if ($_POST['IN_Estado_car_lc'] == "on")
				$estado = '1';
			else
				$estado = '0';
		}
		$idUsuario = $_POST['idUsuario'];

		if($idCaracterizacion != "")
			$rta = updateObservacion($idCaracterizacion,$observacion,$estado,$idUsuario);
		else 
			$rta = "false";
		return json_encode($rta);
	}
	/***************************************************************************
	/* getCaracterizacion() carga todos los datos de una caracterizacion especifica
	***************************************************************************/
	function getCaracterizacion(){
		$caracterizacionId = $_POST['caracterizacionId'];
		$rta = getCaracterizacionData($caracterizacionId);
		return json_encode($rta);
	}
	/***************************************************************************
	/* getObservaciones() carga todas las observaciones realizadas sobre valoraciones, planeaciones o caracterizaciones
	***************************************************************************/
	function getObservaciones(){
		$grupoId = $_POST['grupoId'];
		$tipo = $_POST['tipo'];
		$lineaAtencion = $_POST['lineaAtencion'];
		if ($tipo == 'caracterizacion') {
			$rta = getCaracterizacionesObservaciones($grupoId,$lineaAtencion);
		}
		if ($tipo == 'planeacion') {
			$rta = getPlaneacionObservaciones($grupoId,$lineaAtencion);
		}
		if ($tipo == 'valoracion') {
			$rta = getValoracionObservaciones($grupoId,$lineaAtencion);
		}
		return json_encode($rta);
	}
	?>
