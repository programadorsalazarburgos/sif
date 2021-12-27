<?php
$return = "";
foreach ($this->getVariables()['grupos'] as $g) {
	$return .= "<tr>";
	$return .= "<td>".$g['PK_Grupo']."</td>";
	$return .= "<td>".$g['VC_Nom_Organizacion']."</td>";
	$return .= "<td>".$g['Formador']."</td>";
	$return .= "<td>".$g['DA_fecha_clase']."</td>";
	
	$return .= "<td>";
	$return .= $g['PK_sesion_clase'] == '' ? "<i style='color:#c72522' class='fas fa-2x fa-times-circle'></i>NO":"<i style='color:#037b77' class='fas fa-2x fa-check-circle'></i>SI";
	$return .= "</td>";

	$return .= "<td>".$g['DT_fecha_creacion_registro']."</td>";
	$return .= "<td>".$g['Novedad']."</td>";
	$return .= "</tr>";
}
echo $return;