<?php
$return = "";
if($this->getVariables()['tipo_consulta'] == "modificacion"){
	$return .= "<table class='table table-striped table-bordered table-hover' id='tabla-categorias' class='display' style='width:100%'>";
	$return .= "<thead><tr>";
	$return .= "<th>Categoria</th>";
	$return .= "<th>Modificar</th>";
	$return .= "<th>Estado</th>";
	$return .= "</tr></thead><tbody>";
	foreach ($this->getVariables()['categoria_contenido'] as $cc){
		$return .= "<tr>";
		$return .= "<td><span id='categoria-".$cc["PK_Id_Categoria_Contenido"]."'>".$cc['VC_Nombre_Categoria_Contenido']."</span></td>";
		$return .= "<td><button type='button' class='btn btn-block btn-warning edit' data-action='edit' data-type='categoria' data-id-categoria='".$cc['PK_Id_Categoria_Contenido']."'><i class='far fa-edit'></i></button></td>";

		$oculto = $cc["IN_Estado"] == 1 ? "btn-success" : "btn-danger";
		$icono = $cc["IN_Estado"] == 1 ? "<i class='far fa-eye'></i>" : "<i class='far fa-eye-slash'></i>";

		$return .= "<td><button type='button' id='estado-categoria-".$cc["PK_Id_Categoria_Contenido"]."' class='btn btn-block ".$oculto." edit' data-action='edit' data-hide='".$cc["IN_Estado"]."' data-type='categoria' data-id-categoria='".$cc['PK_Id_Categoria_Contenido']."'>".$icono."</button></td>";
		$return .= "</tr>";
	}
	$return .= "</tbody></table>";
}else{
	foreach ($this->getVariables()['categoria_contenido'] as $cc){
		$return .= "<option value='".$cc['PK_Id_Categoria_Contenido']."'>".$cc['VC_Nombre_Categoria_Contenido']."</option>";
	}
}

echo $return;