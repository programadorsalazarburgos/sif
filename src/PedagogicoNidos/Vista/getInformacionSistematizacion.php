<?php
$return = "";
$datos = $this->getVariables()['info'];
if (sizeof($datos) > 0) {
	$encabezado=array();
	foreach ($datos[0] as $clave => $valor){
		$encabezado[]=$clave;
	}
	$return .= "<table class='table table-striped table-bordered table-hover' id='tabla-info-sistematizacion' class='display' style='width:100%'><thead><tr>";
	foreach ($encabezado as $texto) {
		$return .= "<th>";
		$return .= $texto;
		$return .= "</th>";

	}
	$return .= "</tr></thead><tbody>";
	foreach($datos as $d){
		$return .= "<tr>";
		foreach ($d as $key => $value){
			if($key == "Referentes" || $key == "Aplicabilidad Referentes"){
				$value2="<ol>";
				$value = json_decode($value, true);
				foreach ($value as $item) {
					$value2 .= "<li>".$item."</li>";
				}
				$value2 .="</ol>";
				$value = $value2;
			}
			$return .="<td>".$value."</td>";
		}
		$return .= "</tr>";
	}
	echo $return."</tbody></table>";
}else{
	echo "No hay registros disponibles";
}