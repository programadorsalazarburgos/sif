<?php  
$return = ""; 
$aux3 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

foreach ($this->getVariables()['Datos'] as $d){

	$return .="<tr style='text-align: center;'>";
	$return .="<td style='background-color: #EAEDED;'>".$d["LOCALIDAD"]."</td>";
	$return .="<td style='background-color: #EAEDED;'>".$d["LUGAR"]."</td>";
	$return .="<td style='background-color: #EAEDED;'>".$d["ENTIDAD"]."</td>";
	$return .="<td style='background-color: #EAEDED;'>".$d["TOTAL_LUGAR"]."</td>";

	$return .="<td>".$d["GRUPALES_MAR"]."</td>";
	$return .="<td>".$d["LABORATORIO_MAR"]."</td>";
	$return .="<td style='background-color: #AEB6BF;'>".$d["TOTAL_MAR"]."</td>";
	$return .="<td>".$d["GRUPALES_ABR"]."</td>";
	$return .="<td>".$d["LABORATORIO_ABR"]."</td>";
	$return .="<td style='background-color: #AEB6BF;'>".$d["TOTAL_ABR"]."</td>";
	$return .="<td>".$d["GRUPALES_MAY"]."</td>";
	$return .="<td>".$d["LABORATORIO_MAY"]."</td>";
	$return .="<td style='background-color: #AEB6BF;'>".$d["TOTAL_MAY"]."</td>";
	$return .="<td>".$d["GRUPALES_JUN"]."</td>";
	$return .="<td>".$d["LABORATORIO_JUN"]."</td>";
	$return .="<td style='background-color: #AEB6BF;'>".$d["TOTAL_JUN"]."</td>";
	$return .="<td>".$d["GRUPALES_JUL"]."</td>";
	$return .="<td>".$d["LABORATORIO_JUL"]."</td>";
	$return .="<td style='background-color: #AEB6BF;'>".$d["TOTAL_JUL"]."</td>";
	$return .="<td>".$d["GRUPALES_AGO"]."</td>";
	$return .="<td>".$d["LABORATORIO_AGO"]."</td>";
	$return .="<td style='background-color: #AEB6BF;'>".$d["TOTAL_AGO"]."</td>";
	$return .="<td>".$d["GRUPALES_SEP"]."</td>";
	$return .="<td>".$d["LABORATORIO_SEP"]."</td>";
	$return .="<td style='background-color: #AEB6BF;'>".$d["TOTAL_SEP"]."</td>";
	$return .="<td>".$d["GRUPALES_OCT"]."</td>";
	$return .="<td>".$d["LABORATORIO_OCT"]."</td>";
	$return .="<td style='background-color: #AEB6BF;'>".$d["TOTAL_OCT"]."</td>";
	$return .="<td>".$d["GRUPALES_NOV"]."</td>";
	$return .="<td>".$d["LABORATORIO_NOV"]."</td>";
	$return .="<td style='background-color: #AEB6BF;'>".$d["TOTAL_NOV"]."</td>";
	$return .="<td>".$d["GRUPALES_DIC"]."</td>";
	$return .="<td>".$d["LABORATORIO_DIC"]."</td>";
	$return .="<td style='background-color: #AEB6BF;'>".$d["TOTAL_DIC"]."</td>";
	$return .="</tr>";


	$aux3[0] += $d['TOTAL_LUGAR']; 
	$aux3[1] += $d['GRUPALES_MAR']; 
	$aux3[2] += $d['LABORATORIO_MAR'];     
	$aux3[3] += $d['TOTAL_MAR'];
	$aux3[4] += $d['GRUPALES_ABR'];
	$aux3[5] += $d['LABORATORIO_ABR'];
	$aux3[6] += $d['TOTAL_ABR'];
	$aux3[7] += $d['GRUPALES_MAY'];
	$aux3[8] += $d['LABORATORIO_MAY'];
	$aux3[9] += $d['TOTAL_MAY'];
	$aux3[10] += $d['GRUPALES_JUN'];
	$aux3[11] += $d['LABORATORIO_JUN'];
	$aux3[12] += $d['TOTAL_JUN'];
	$aux3[13] += $d['GRUPALES_JUL'];
	$aux3[14] += $d['LABORATORIO_JUL'];
	$aux3[15] += $d['TOTAL_JUL'];
	$aux3[16] += $d['GRUPALES_AGO'];
	$aux3[17] += $d['LABORATORIO_AGO'];
	$aux3[18] += $d['TOTAL_AGO'];
	$aux3[19] += $d['GRUPALES_SEP'];
	$aux3[20] += $d['LABORATORIO_SEP'];
	$aux3[21] += $d['TOTAL_SEP'];
	$aux3[22] += $d['GRUPALES_OCT'];
	$aux3[23] += $d['LABORATORIO_OCT'];
	$aux3[24] += $d['TOTAL_OCT'];
	$aux3[25] += $d['GRUPALES_NOV'];
	$aux3[26] += $d['LABORATORIO_NOV'];
	$aux3[27] += $d['TOTAL_NOV'];
	$aux3[28] += $d['GRUPALES_DIC'];
	$aux3[29] += $d['LABORATORIO_DIC'];
	$aux3[30] += $d['TOTAL_DIC'];
 
}	
	$return .="<tr style='background-color: #A9DFBF; font-size: 18px;' class='text-center'>";   
	$return .='<td>-</td>';
	$return .="<td>TOTALES</td>";
	$return .='<td>-</td>';
	
	
	for($i=0; $i<= 30; $i++){
	  $return .=" <td>". $aux3[$i]."</td>";
	  
	}
	$return .="</tr>";
echo $return;
?>