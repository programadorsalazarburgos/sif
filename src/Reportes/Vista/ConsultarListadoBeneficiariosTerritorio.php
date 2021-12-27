<?php   
$return = ""; 
foreach ($this->getVariables()['Datos'] as $d){
	$return .="<tr style='text-align: center;'>";
	$return .="<td>".$d["IDENTIFICACION"]."</td>";
	$return .="<td>".$d["TIPO_IDENTIFI"]."</td>";
	$return .="<td>".$d["BENEFICIARIO"]."</td>";
	$return .="<td>".$d["GENERO"]."</td>";
	$return .="<td>".$d["ENFOQUE"]."</td>";
	$return .="<td>".$d["USO_IMAGEN"]."</td>";
	$return .="<td>".$d["DUPLA"]."</td>";
	$return .="<td>".$d["LUGAR"]."</td>";
	$return .="<td>".$d["GRUPO"]."</td>";
	$return .="<td>".$d["FECHA"]."</td>";
	$return .="</tr>";
}	
echo $return;
?>