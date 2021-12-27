<?php  
$return = ""; 
$aux3 = [0,0,0,0,0,0,0,0,0,0,0];

foreach ($this->getVariables()['Datos'] as $d){
	$return .="<tr style='text-align: center;'>";
	$return .="<td><b>".$d["LOCALIDAD"]."</b></td>";
	$return .="<td>".$d["TOTAL_MAR"]."</td>";
	$return .="<td>".$d["TOTAL_ABR"]."</td>";
	$return .="<td>".$d["TOTAL_MAY"]."</td>";
	$return .="<td>".$d["TOTAL_JUN"]."</td>";
	$return .="<td>".$d["TOTAL_JUL"]."</td>";
	$return .="<td>".$d["TOTAL_AGO"]."</td>";
	$return .="<td>".$d["TOTAL_SEP"]."</td>";
	$return .="<td>".$d["TOTAL_OCT"]."</td>";
	$return .="<td>".$d["TOTAL_NOV"]."</td>";
	$return .="<td>".$d["TOTAL_DIC"]."</td>";
	$return .="<td style='background-color: #AEB6BF;'>".$d["TOTAL_LUGAR"]."</td>";
	$return .="</tr>";

	$aux3[0] += $d['TOTAL_MAR'];
	$aux3[1] += $d['TOTAL_ABR']; 
	$aux3[2] += $d['TOTAL_MAY']; 
	$aux3[3] += $d['TOTAL_JUN'];     
	$aux3[4] += $d['TOTAL_JUL'];
	$aux3[5] += $d['TOTAL_AGO'];
	$aux3[6] += $d['TOTAL_SEP'];
	$aux3[7] += $d['TOTAL_OCT'];
	$aux3[8] += $d['TOTAL_NOV'];
	$aux3[9] += $d['TOTAL_DIC'];
	$aux3[10] += $d['TOTAL_LUGAR'];	

}	
	$return .="<tr style='background-color: #A9DFBF; font-size: 18px;' class='text-center'>";   
	$return .="<td>TOTALES</td>";	
	for($i=0; $i<= 10; $i++){
	  $return .=" <td>". $aux3[$i]."</td>";
	  
	}
	$return .="</tr>";
echo $return;
?>