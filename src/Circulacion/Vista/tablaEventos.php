<?php
$array_crea = $this->getVariables()['array_crea'];
$tabla = "";
foreach ($this->getVariables()['evento'] as $e) {
	$tabla .= "<tr>";
	$tabla .= "<td> Desde ".$e['DT_Fecha_Inicio']." hasta ".$e['DT_Fecha_Fin']."</td>";
	$tabla .= "<td>".$e['VC_Nombre']."</td>";
	$tabla .= "<td>".$e['VC_Lugar']."</td>";
	$tabla .= "<td>".$e['VC_Objetivo']."</td>";
	$tabla .= "<td>";
	foreach ($array_crea[$e['PK_Id_Evento']] as $c) {
		$tabla .= $c['VC_Nom_Clan'].",";
	}
	$tabla .= "</td>";
	$tabla .= "<td>".$e['IN_publico_asistente']."</td>";
	$tabla .= "</tr>";
}
echo $tabla;