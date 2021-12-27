<?php
$return = "";
$return .= "<table class='table table-striped table-bordered table-hover' id='tabla-descarga-sistematizacion' class='display' style='width:100%'>";
$return .= "<thead><tr>";
$return .= "<th>Dupla</th>";
$return .= "<th>Mes</th>";
$return .= "<th>EAAT</th>";
$return .= "<th>Descarga</th>";
$return .= "<th>Banco de imágenes</th>";
$return .= "</tr></thead><tbody>";

foreach ($this->getVariables()['sistematizaciones'] as $s){
	$return .="<tr>";
	$return .="<td>".$s["Dupla"]."<div id='div-info-artistas'></div></td>";

	$return .="<td>".$s["Mes"]."</td>";
	$return .="<td>".$s["EAAT"]."</td>";
	$return .="<td>";
	if($s["IN_Aprobacion_Planeacion"] == 4 && $s["IN_Aprobacion_Sistematizacion"] != 4){
		$return .= "<button class='btn btn-block btn-success' type='button' data-sistematizacion='".$s["PK_Id_Sistematizacion"]."' data-parte='planeacion' data-total='".$s['TotalArtistas']."'>Descargar planeación</button></td>";
	}else{
		$return .= "<button class='btn btn-block btn-success' type='button' data-sistematizacion='".$s["PK_Id_Sistematizacion"]."' data-parte='sistematizacion' data-total='".$s['TotalArtistas']."'>Descargar sistematización</button></td>";
	}
	$return .="</td>";
	$return .="<td>";
	if($s["IN_Aprobacion_Sistematizacion"] == 4){
		$return .= "<button class='btn btn-block btn-success images' type='button' data-sistematizacion='".$s["PK_Id_Sistematizacion"]."' >Ver</button></td>";
	}else{
		$return .= "<button class='btn btn-block btn-default' type='button' disabled>No disponible</button></td>";
	}
	$return .="</td>";
	$return .="</tr>";
}

$return .= "</tbody></table>";

echo $return;