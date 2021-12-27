<?php  
$baseurl = $_SERVER['DOCUMENT_ROOT'].'/sif/uploadedFiles/Territorial/Experiencia/';
$return = ""; 
foreach ($this->getVariables()['Datos'] as $d){
	$return .="<tr style='text-align: center;'>";	
	$return .="<td>".$d["IDENTIFICACION"]."</td>";
	$return .="<td>".$d["BENEFICIARIO"]."</td>";
	$return .="<td>".$d["GENERO"]."</td>";
	$return .="<td>".$d["NACIMIENTO"]."</td>";
	$return .="<td>".$d["ENFOQUE"]."</td>";
	$return .="</tr>";
}
echo $return;
?>