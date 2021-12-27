<?php  
$return = "";
foreach ($this->getVariables()['Datos'] as $d){
	$return .="<tr>";
	$return .="<td>".$d["IDENTIFICACION"]."</td>";
	$return .="<td>".$d["CONTRATISTA"]."</td>";
	$return .="<td>".$d["CONTRATO"]."</td>";
	$return .="<td>".$d["MES_INFORME"]."</td>";
	$return .="<td>".$d["PERIODO"]."</td>";
	if($d['SM_Finalizado'] == 0){
		$return .="<td class='text-center' style='background-color: #F5B7B1;'><b>".$d["ENVIADO"]."</b></td>";
		$return .="<td class='text-center' style='background-color: #F5B7B1;'>".$d["FECHA"]."</td>";
		$return .="<td class='text-center' style='background-color: #F5B7B1;'>".$d["APROBACIONES"]."</td>";
	} else {
		$return .="<td class='text-center' style='background-color: #ABEBC6;'><b>".$d["ENVIADO"]."</b></td>";
		$return .="<td class='text-center' style='background-color: #ABEBC6;'>".$d["FECHA"]."</td>";
		$return .="<td class='text-center' style='background-color: #ABEBC6;'>".$d["APROBACIONES"]."</td>";
	}
	$return .="</tr>";
}
echo $return;
?>