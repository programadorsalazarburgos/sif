<?php
$return = "";
$return .= "<label>Contenidos creados</label>";
$return .= "<table class='table table-striped table-bordered table-hover' id='tabla-contenidos' class='display' style='width:100%'>";
$return .= "<thead><tr>";
$return .= "<th>Contenido</th>";
$return .= "<th>Modificar</th>";
$return .= "<th>Estado</th>";
$return .= "</tr></thead><tbody>";
foreach ($this->getVariables()['contenidos'] as $c){
	$return .= "<tr>";
	$return .= "<td><span id='contenido-".$c["PK_Id_Contenido"]."'>".$c['VC_Nombre_Contenido']."</span></td>";
	$return .= "<td><button type='button' class='btn btn-block btn-warning edit' data-action='edit' data-type='contenido' data-id-contenido='".$c['PK_Id_Contenido']."'><i class='far fa-edit'></i></button></td>";
	$oculto = $c["IN_Estado"] == 1 ? "btn-success" : "btn-danger";
	$icono = $c["IN_Estado"] == 1 ? "<i class='far fa-eye'></i>" : "<i class='far fa-eye-slash'></i>";

	$return .= "<td><button type='button' id='estado-contenido-".$c["PK_Id_Contenido"]."' class='btn btn-block ". $oculto ." edit' data-action='edit' data-hide='".$c["IN_Estado"]."' data-type='contenido' data-id-contenido='".$c['PK_Id_Contenido']."'>".$icono."</button></td>";
	$return .= "</tr>";
}
$return .= "</tbody></table>";

echo $return;