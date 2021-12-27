<?php

$thead = "<thead>";
$tbody = "<tbody>";
$id_tabla = "";

switch ($this->getVariables()['tipo_sesion_clase']) {
	case 'titular':
		$id_tabla = "table_estudiantes_grupo";
		$thead .= "<tr><th>Asistencia</th><th>Nombres</th><th>Apellidos</th><th>Identificación</th><th>Opciones</th></tr>";
		break;
	case 'suplencia':
		$id_tabla = "table_estudiantes_grupo_suplencia";
		$thead .= "<tr><th>Asistencia</th><th>Nombres</th><th>Apellidos</th><th>Identificación</th></tr>";
		break;
	case 'modificar':
		$id_tabla = "table_estudiantes_sesion_modificar";
		$thead .= "<tr><th>Asistencia</th><th>Nombres</th><th>Apellidos</th><th>Identificación</th></tr>";
		break;
	case 'evento':
		$id_tabla = "table_estudiantes_grupo";
		$thead .= "<tr><th>Asistencia</th><th>Nombres</th><th>Apellidos</th><th>Identificación</th></tr>";
		break;
	default:
		break;
}

foreach ($this->getVariables()['estudiante'] as $e) {
	$tbody .= "<tr>";
	switch ($this->getVariables()['tipo_sesion_clase']) {
		case 'titular':
			$tbody .= '<td><input id=asistencia_estudiante_'.$e['id'].' data-toggle="toggle" data-onstyle="success" name= "CH_asistencia_estudiante[]" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" data-id_estudiante='.$e['id'].' class="asistencia_clase">';
			$tbody .= '<input id=atencion_estudiante_'.$e['id'].' data-toggle="toggle" data-onstyle="success" name="CH_tipo_atencion_estudiante[]" data-offstyle="danger" data-on="PRESENCIAL" data-off="VIRTUAL" type="checkbox" data-id_estudiante='.$e['id'].' class="tipo_atencion_estudiante"></td>';
			break;
		case 'suplencia':
			$tbody .= '<td><input id=asistencia_estudiante_suplencia_'.$e['id'].' data-toggle="toggle" data-onstyle="success" name= "CH_asistencia_estudiante_suplencia[]" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" data-id_estudiante='.$e['id'].' class="asistencia_clase_suplencia">';
			$tbody .= '<input id=atencion_estudiante_suplencia_'.$e['id'].' data-toggle="toggle" data-onstyle="success" name="CH_tipo_atencion_estudiante_suplencia[]" data-offstyle="danger" data-on="PRESENCIAL" data-off="VIRTUAL" type="checkbox" data-id_estudiante='.$e['id'].' class="tipo_atencion_estudiante_suplencia"></td>';
			break;
		case 'modificar':
			$tbody .= '<td><input id=asistencia_estudiante_modificar_'.$e['id'].' data-toggle="toggle" data-onstyle="success" name= "CH_asistencia_estudiante_modificar_sesion[]" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" '.(($e['IN_estado_asistencia'] == 1) ? 'checked="checked"' : ' ').' data-id_estudiante='.$e['id'].' data-tipo_atencion='.($e['IN_Tipo_Atencion'] == null ? 0:$e['IN_Tipo_Atencion']).' class="asistencia_clase_modificar">';
			$tbody .= '<input id=atencion_estudiante_modificar_'.$e['id'].' data-toggle="toggle" data-onstyle="success" name="CH_tipo_atencion_estudiante_modificar[]" data-offstyle="danger" data-on="PRESENCIAL" data-off="VIRTUAL" type="checkbox" data-id_estudiante='.$e['id'].' class="tipo_atencion_estudiante_modificar"></td>';
			break;
		case 'evento':
				$tbody .= '<td><center><input data-toggle="toggle" data-onstyle="success" name="CH_asistencia_estudiante_evento[]" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" data-id_estudiante='.$e['id'].' class="asistencia_evento"></center></td>';
			break;
		case 'editar_sesion_evento':
			$tbody .= '<td><center><input data-toggle="toggle" data-onstyle="success" name="CH_editar_asistencia_estudiante_evento[]" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" id="CH_asistencia_estudiante_evento_editar_'.$e['id'].'" data-id_estudiante='.$e['id'].' class="editar_sesion_evento"></center></td>';
			break;
		default:
		
			break;
	}
	$tbody .= "<td>".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']."</td>";
	$tbody .= "<td>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']."</td>";
	$tbody .= "<td>".$e['IN_Identificacion']."</td>";
	switch ($this->getVariables()['tipo_sesion_clase']) {
		case 'titular':
			$tbody .= '<td><a data-id_estudiante="'.$e['id'].'" data-id_grupo="'.$this->getVariables()['id_grupo'].'" data-tipo_grupo="'.$this->getVariables()['tipo_grupo'].'" data-identificacion_estudiante="'.$e['IN_Identificacion'].'" data-nombre_estudiante="'.$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']." ".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre'].'" class="btn btn-danger solicitar_remover_estudiante_grupo" title="Solicitar remover estudiante de grupo" data-toggle="modal" data-target="#modal_retirar_estudiante"><span class="glyphicon glyphicon-trash" aria-hidden="true" title="Solicitar remover estudiante."></span></a></td>';
			break;
		default:		
			break;
	}

	$tbody .= "</tr>";
}
$thead .= "</thead>";
$tbody .= "</tbody>";

echo "<table class='table' id='".$id_tabla."'>".$thead.$tbody."</table>";