<?php
$return = "";
$return .= "<thead>";
	$return .= "<tr>";
	$return .= "<th>Fecha Registro</th>";
	$return .= "<th>Evaluador</th>";
	$return .= "<th>Area Artistica</th>";
	$return .= "<th>Artista Formador</th>";
	$return .= "<th>Cumplimiento entrega tareas</th>";
	$return .= "<th>Disposicion colaboracion trabajo equipo</th>";
	$return .= "<th>Aportes area artistica</th>";
	$return .= "<th>Evidencia calidad procesos formativas</th>";
	$return .= "<th>Evidencia resultados desempeño artistico</th>";
	$return .= "<th>Puntaje total</th>";
	$return .= "</tr>";
$return .= "</thead>";
$return .= "<tbody>";
foreach ($this->getVariables()['resultado_evaluacion'] as $a) {
	$return .= "<tr>";
	$return .= "<td>".$a['DT_fecha_registro']."</td>";
	$return .= "<td>".$a['nombre_evaluador']."</td>";
	$return .= "<td>".$a['VC_Nom_Area']."</td>";
	$return .= "<td>".$a['nombre_artista']."</td>";
	//$return .= "<td>".$a['IN_cumplimiento_entrega_tareas']."</td>";
	$return .= "<td>".$a['VC_cumplimiento_entrega_tareas']."</td>";
	//$return .= "<td>".$a['IN_disposicion_colaboracion_trabajo_equipo']."</td>";
	$return .= "<td>".$a['VC_disposicion_colaboracion_trabajo_equipo']."</td>";
	//$return .= "<td>".$a['IN_aportes_area_artistica']."</td>";
	$return .= "<td>".$a['VC_aportes_area_artistica']."</td>";
	//$return .= "<td>".$a['IN_evidencia_calidad_procesos_formativos']."</td>";
	$return .= "<td>".$a['VC_evidencia_calidad_procesos_formativos']."</td>";
	//$return .= "<td>".$a['IN_evidencia_resultados_desempenio_artistico']."</td>"; 
	$return .= "<td>".$a['VC_evidencia_resultados_desempenio_artistico']."</td>";
	$return .= "<td>".$a['IN_puntaje_total']."</td>";
	$return .= "</tr>";
}
$return .= "</tbody>";
echo $return;