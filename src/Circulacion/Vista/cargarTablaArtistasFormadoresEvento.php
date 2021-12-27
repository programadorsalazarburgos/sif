<?php
$return = "";
foreach ($this->getVariables()['artista_formador'] as $a) {
	$return .= "<tr>";
	$return .= "<td>".$a['VC_Identificacion']."</td>";
	$return .= "<td>".$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']." ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido']." "."</td>";
	$return .= "<td></td>";
	$return .= "</tr>";
}
echo $return;