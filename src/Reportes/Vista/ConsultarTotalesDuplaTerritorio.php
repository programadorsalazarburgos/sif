<?php  
$return = ""; 
$aux3 = [0,0,0,0,0,0,0,0,0,0,0,0];

foreach ($this->getVariables()['Datos'] as $d){

$aux3[0] += $d['FEBRERO']; 
$aux3[1] += $d['MARZO'];     
$aux3[2] += $d['ABRIL'];
$aux3[3] += $d['MAYO'];
$aux3[4] += $d['JUNIO'];
$aux3[5] += $d['JULIO'];
$aux3[6] += $d['AGOSTO'];
$aux3[7] += $d['SEPTIEMBRE'];
$aux3[8] += $d['OCTUBRE'];
$aux3[9] += $d['NOVIEMBRE'];
$aux3[10] += $d['DICIEMBRE'];
$aux3[11] += $d['TOTAL'];

	$return .="<tr style='background-color: #EAEDED; text-align: center;'>";	
	$return .="<td>".$d["CODIGO"]."</td>";
	$return .="<td>".$d["FEBRERO"]."</td>";
	$return .="<td>".$d["MARZO"]."</td>";
	$return .="<td>".$d["ABRIL"]."</td>";
	$return .="<td>".$d["MAYO"]."</td>";
	$return .="<td>".$d["JUNIO"]."</td>";
	$return .="<td>".$d["JULIO"]."</td>";
	$return .="<td>".$d["AGOSTO"]."</td>";
	$return .="<td>".$d["SEPTIEMBRE"]."</td>";
	$return .="<td>".$d["OCTUBRE"]."</td>";
	$return .="<td>".$d["NOVIEMBRE"]."</td>";
	$return .="<td>".$d["DICIEMBRE"]."</td>";
	$return .="<td>".$d["TOTAL"]."</td>";
	$return .="</tr>";
}
$return .="<tr style='background-color: #D7BDE2; font-size: 18px;' class='text-center'>";   
$return .="<td>TOTALES</td>";

for($i=0; $i<= 11; $i++){
  $return .=" <td>". $aux3[$i]."</td>";
  
}
 
echo $return;
?>

