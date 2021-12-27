<?php 
$return = "";
if($this->getVariables()['Beneficiarios'] ==  ""){
	$return .= "<div>Lo sentimos, no hay información disponible</div>";
}else{

	$return .= "<table id='tabla_beneficiarios_nuevos' class='table table-striped table-bordered table-hover' width='100%'>";
	$return .= "<thead>";
	$return .= "<th><center>Número de identificación</center></th>";
	$return .= "<th><center>Nombre beneficiario</center></th>";
	$return .= "<th><center>Primera Atención</center></th>";
	$return .= "</thead>";
	$return .= "<tbody>";
	foreach ($this->getVariables()['Beneficiarios'] as $b){
		$return .="<tr>";
		$return .="	<td><center>". $b['IDENTIFICACION']."</center></td>";
		$return .="	<td><center>". $b['NOMBRE']."</center></td>";
		$return .="	<td><center>". $b['P_ATENCION']."</center></td>";
		$return .="</tr>";
	}
	$return .= "</tbody>";
	$return .= "</table>";
}
echo $return;

