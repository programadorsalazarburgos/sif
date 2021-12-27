<?php
$opcion = $this->getVariables()['opcion'];
$tabla = "";
foreach ($this->getVariables()['estudiante_evento'] as $e) {
	$tabla .= "<tr>";
	$tabla .= "<td class='text-center'>";
	if (isset($opcion['tipo_estudiante'])){
		if($opcion['tipo_estudiante'] == 'con_permiso'){
			$tabla .= '<input '.(($e['TI_Asistencia_Dia1'] == 1)?'checked':' ').' type="checkbox" class="asistencia_evento" data-id_evento='.$e['FK_Evento'].' data-id_estudiante='.$e['id'].' data-dia="1">';
		}
	}else{
		if(isset($opcion['id_rol']) && $opcion['id_rol'] == 3){	// Cuando es Coordinador CREA permite cambiar permiso de los padres
			$tabla .= '<input ' . (($e['TI_Permiso_Padres'] == 1)?'checked':' ') . ' type="checkbox" class="permiso_padres eventoClic" data-id_evento='.$e['FK_Evento'].' data-id_estudiante='.$e['id'].'>';
		}
		else{
			if($e['TI_Permiso_Padres'] == 1)
				$tabla .= '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> SÍ';
			else
				$tabla .= '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> NO';
		}
	}
	$tabla .= "</td>";
	$tabla .= "<td>".$e['IN_Identificacion']."</td>";
	$tabla .= "<td>".$e['VC_Nombre']."</td>";
	//$tabla .= "<td>".$e['VC_Nom_Area']."</td>";
	//$tabla .= "<td>".$e['VC_Nom_Clan']."</td>";
	//$tabla .= "<td>".$e['VC_Nom_Colegio']."</td>";
	//$tabla .= "<td>".$e['VC_Descripcion_Grado']."</td>";
	//$tabla .= "<td>".$e['VC_Nom_Organizacion']."</td>";
	$tabla .= "<td>";
	if($opcion['id_rol'] == 5){ // Cuando es asesor pedagogico o coordinador CREA
		if(!isset($opcion['tipo_sesion_clase']))
		{
			//$tabla .= "<a type='button' class='eventoClic btn btn-default btn-sm editar_datos_estudiante_evento' data-id_estudiante='".$e['id']."' data-id_area_artistica='".$e['FK_Area_Artistica']."' data-id_crea='".$e['FK_clan']."' data-id_colegio='".$e['FK_Colegio']."' data-id_grado='".$e['FK_Grado']."' data-id_organizacion='".$e['FK_Organizacion']."' data-id_evento='".$e['FK_Evento']."' href='#' data-toggle='modal' data-target='#modal_editar_datos_estudiante'><span class='glyphicon glyphicon-pencil'></span></a>";
			$tabla .= "<a type='button' class='eventoClic btn btn-danger btn-sm remover_beneficiario_evento' data-id_beneficiario='".$e['id']."' data-id_evento='".$e['FK_Evento']."' href='#'><span class='glyphicon glyphicon-remove'></span></a>";
		}
		else // Cuando esta en la pestaña registrar asistencia de la actividad Administrar Eventos
		{
			$tabla .= '<input type="checkbox" name="CH_asistencia_estudiante_evento[]" class="asistencia_evento eventoClic" data-id_evento='.$e['FK_Evento'].' data-id_estudiante='.$e['id'].'>';
		}
	}
	if(isset($opcion['tipo_sesion_clase']['registrar_asistencia'])){
			$tabla .= '<input type="checkbox" name="CH_asistencia_estudiante_evento[]" class="asistencia_evento eventoClic" data-id_evento='.$e['FK_Evento'].' data-id_estudiante='.$e['id'].'>';
	}
	$tabla .= "</td>";
	$tabla .= "</tr>";
}
echo $tabla;