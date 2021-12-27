<?php
$return = "";
$return .= "<table class='table table-striped table-bordered table-hover' id='tabla-experiencias-eliminar' class='display' style='width:100%'>";
$return .= "<thead><tr>";
$return .= "<th>Id experiencia</th>";
$return .= "<th>Experiencia</th>";
$return .= "<th>Fecha del encuentro</th>";
$return .= "<th>Horario de atención</th>";
$return .= "<th>Asistentes</th>";
$return .= "<th>Acciones</th>";
$return .= "</tr></thead><tbody>";
foreach ($this->getVariables()['experiencias'] as $e){
	$return .="<tr>";
	$return .="<td>".$e["id_experiencia"]."</td>";
	$return .="<td>".$e["Experiencia"]."</td>";
	$return .="<td>".$e["Fecha"]."</td>";
	$return .="<td>".$e["Horario"]."</td>";
	$return .="<td>".$e["Asistentes"]."</td>";
	$return .="<td><button class='btn btn-block btn-danger' data-experiencia='".$e["id_experiencia"]."' data-nombre='".$e["Experiencia"]."' data-fecha='".$e["Fecha"]."'>Eliminar</button></td>";
	$return .="</tr>";
}
$return .= "</tbody></table>";
echo $return;