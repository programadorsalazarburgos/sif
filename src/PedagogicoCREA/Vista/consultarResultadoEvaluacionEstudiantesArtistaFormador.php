<?php
$return = "";
$return .= "<thead>";
	$return .= "<tr>";
	$return .= "<th>Fecha Registro</th>";
	$return .= "<th>Estudiante</th>";
	$return .= "<th>Area Artistica</th>";
	$return .= "<th>Artista Formador</th>";
	$return .= "<th>¿Le gusta la manera en que el formador hace el taller?</th>";
	$return .= "<th>¿Considera que ha aprendido desde el área?</th>";
	$return .= "<th>¿Dentro del taller se logran vincular sus intereses?</th>";
	$return .= "<th>¿El artista formador incentiva el trabajo en grupo?</th>";
	$return .= "<th>¿Hacen socializaciones entre el grupo sobre lo trabajado?</th>";
	$return .= "<th>¿El formador reconoce sus avances en el área?</th>";
	$return .= "<th>¿Hay espacios de dialogo en el taller?</th>";
	$return .= "<th>Observaciones</th>";
	$return .= "</tr>";
$return .= "</thead>";
$return .= "<tbody>";
foreach ($this->getVariables()['resultado_evaluacion'] as $a) {
	$return .= "<tr>";
	$return .= "<td>".$a['DT_fecha_registro']."</td>";
	$return .= "<td>".$a['VC_nombre_estudiante']."</td>";
	$return .= "<td>".$a['VC_Nom_Area']."</td>";
	$return .= "<td>".$a['VC_Primer_Nombre'].' '.$a['VC_Segundo_Nombre'].' '.$a['VC_Primer_Apellido'].' '.$a['VC_Segundo_Apellido']."</td>";
	$return .= "<td>".$a['RT_1']."</td>";
	$return .= "<td>".$a['RT_2']."</td>";
	$return .= "<td>".$a['RT_3']."</td>";
	$return .= "<td>".$a['RT_4']."</td>";
	$return .= "<td>".$a['RT_5']."</td>";
	$return .= "<td>".$a['RT_6']."</td>";
	$return .= "<td>".$a['RT_7']."</td>";
	$return .= "<td>".$a['VC_observaciones']."</td>";
	$return .= "</tr>";
}
$return .= "</tbody>";
echo $return;