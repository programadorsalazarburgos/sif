<?php
$return = "";
$mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
foreach ($this->getVariables()['grupos'] as $g) {
	if($g['estado']=='Activo') $colorEstado="class='bg-success'"; 
	else  $colorEstado="class='bg-danger'";
	$return .= 
"<tr>
	<td>IC-".$g['grupo']."</td>
	<td ".$colorEstado.">".$g['estado']."</td>
	<td>".$g['crea']."</td>
	<td>".$g['area']."</td>
	<td>".$g['modalidad_atencion']."</td>
	<td>".$g['CONVENIO']."</td>
	<td>".$g['tipo_grupo']."</td>
	<td>".$g['modalidad']."</td>
	<td>".$g['organizacion']."</td>
	<td>".$g['artista_formador']."</td>
	<td>".$g['fecha_creacion']."</td>
	<td>".$g['abrio']."</td>
	<td>".$g['horario']."</td>
	<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_estudiantes_grupo' class='consultar_listado_estudiantes_grupo_emprende_clan btn btn-warning' data-id_grupo='".$g['grupo']."'>".$g['estudiante']."</a></td>
	<td>".$g['observaciones']."</td>
	<td>".$g['fecha_cierre']."</td>
	<td>".$g['cerro']."</td>
	<td>".$g['total_atendidos']."</td>
	<td>".$g['atendidos_hombres']."</td>
	<td>".$g['atendidos_mujeres']."</td>
	<td>".$g['atendidos_sin_genero']."</td>
	<td>".$g['total_reportados']."</td>";
	for ($i=0; $i <= 11; $i++){
		$clave_atendidos = "Atendidos".$mes[$i];
		$clave_reportados = "TotalReportados".$mes[$i];
		$clave_porcentaje = "Porcentaje".$mes[$i];
		$return .= "<td class='bg-info'>".$g[$clave_atendidos]."</td>";
		$return .= "<td class='bg-warning'>".$g[$clave_reportados]."</td>";
		$return .= "<td class='bg-success'>".$g[$clave_porcentaje]."</td>";
	}
	
	$disabled = 'btn-success ';
	$text = 'Descargar';
	$observaciones = "&nbsp;&nbsp;&nbsp;<a href='#' data-id_grupo='".$g['grupo']."' data-tipo='caracterizacion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones </a>"; 
	/*if ($g['caracterizacion'] == 0) {
		$disabled = 'btn-danger  disabled';
		$text = 'Sin Caracterizar';
		$observaciones = "&nbsp;&nbsp;&nbsp;<a href='#' data-id_grupo='".$g['grupo']."' data-tipo='caracterizacion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones </a>";
	}
	$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_caracterizaciones_grupo_ec' class='consultar_caracterizaciones_grupo_emprende_clan btn ".$disabled."' data-id_grupo='".$g['grupo']."'>".$text."</a>".$observaciones."</td>";
	$disabled = 'btn-success ';
	$text = 'Descargar';
	$observaciones = "&nbsp;&nbsp;&nbsp;<a href='#' data-id_grupo='".$g['grupo']."' data-tipo='planeacion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones </a>";
	if ($g['planeacion'] == 0) {
		$disabled = 'btn-danger  disabled';
		$text = 'Sin Planeación';
		$observaciones = "&nbsp;&nbsp;&nbsp;<a href='#' data-id_grupo='".$g['grupo']."' data-tipo='planeacion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones </a>";
	}
	$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_planeacion_grupo_ec' class='btn consultar_planeacion_grupo_emprende_clan ".$disabled." '  data-id_grupo='".$g['grupo']."'>".$text."</a>".$observaciones."</td>";
	$disabled = 'btn-success ';
	$text = 'Descargar'; 
	$observaciones = "&nbsp;&nbsp;&nbsp;<a href='#' data-id_grupo='".$g['grupo']."' data-tipo='valoracion'  class='descargar_observaciones form-control btn btn-primary'>Descargar Observaciones</a>";
	if ($g['valoracion'] == 0) {
		$disabled = 'btn-danger  disabled';
		$text = 'Sin Valoración'; 
		$observaciones = "&nbsp;&nbsp;&nbsp;<a href='#' data-id_grupo='".$g['grupo']."' data-tipo='valoracion'  class='descargar_observaciones form-control btn btn-primary disabled'>Descargar Observaciones</a>";
	} 
	$return .= "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_valoracion_grupo_ec' class='btn consultar_valoracion_grupo_emprende_clan ".$disabled." '  data-id_grupo='".$g['grupo']."'>".$text."</a>".$observaciones."</td>";*/
															
$return .= "</tr>";
}
echo $return;
