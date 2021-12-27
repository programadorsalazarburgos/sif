<?php  
$return = ""; 
$aux3 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

foreach ($this->getVariables()['Datos'] as $d){

	$return .="<tr style='background-color: #EAEDED; text-align: center;'>";
	$return .="<td>ABRIL</td>";
	$return .="<td>".$d["MODALIDAD"]."</td>";	
	$return .="<td>".$d["ACTIVIDADES"]."</td>";
	$return .="<td>".$d["FECHA"]."</td>";
	$return .="<td>".$d["LUGAR"]."</td>";
	$return .="<td>".$d["AFORO"]."</td>";
	$return .="<td>".$d["LOCALIDAD"]."</td>";
	$return .="<td>".$d["UPZ"]."</td>";
	$return .="<td>".$d["BARRIO"]."</td>";
	$return .="<td>".$d["ARTISTAS"]."</td>";
	$return .="<td>".$d["INSCRITOS"]."</td>";
	$return .="<td>".$d["HOMBRES"]."</td>";
	$return .="<td>".$d["MUJERES"]."</td>";
	$return .="<td>".$d["TOTAL"]."</td>";

	$return .="<td>".$d["PRIMERA"]."</td>";
	$return .="<td>".$d["INFANCIA"]."</td>";
	$return .="<td>".$d["ADOLESCENCIA"]."</td>";
	$return .="<td>".$d["JUVENTUD"]."</td>";
	$return .="<td>".$d["ADULTOS"]."</td>";
	$return .="<td>".$d["MAYORES"]."</td>";

	$return .="<td>".$d["CAMPESINOS"]."</td>";
	$return .="<td>".$d["GESTANTES"]."</td>";
	$return .="<td>".$d["ACTIVIDADES_SEXUALES"]."</td>";
	$return .="<td>".$d["HABITANTES_CALLE"]."</td>";
	$return .="<td>".$d["DISCAPACIDAD"]."</td>";
	$return .="<td>".$d["PRIVADOS_LIBERTAD"]."</td>";
	$return .="<td>".$d["PROFESIONALES_SECTOR"]."</td>";
	$return .="<td>".$d["LGBTIQ"]."</td>";
	$return .="<td>".$d["CONFLICTO_ARMADO"]."</td>";
	$return .="<td>".$d["MIGRANTE"]."</td>";
	$return .="<td>".$d["VICTIMAS_TRATA"]."</td>";
	$return .="<td>".$d["SOCIAL_CATASTROFICA"]."</td>";
	$return .="<td>".$d["DETERIORO_URBANO"]."</td>";
	$return .="<td>".$d["VULNERABILIDAD"]."</td>";
	$return .="<td>".$d["DESPLAZAMIENTO"]."</td>";
	$return .="<td>".$d["SUSTANCIAS_PSICOACTIVAS"]."</td>";

	$return .="<td>".$d["ROM_GITANO"]."</td>";
	$return .="<td>".$d["PRORROM"]."</td>";
	$return .="<td>".$d["INDIGENA"]."</td>";
	$return .="<td>".$d["COMUNIDADES_NEGRAS"]."</td>";
	$return .="<td>".$d["AFRODESCENDIENTE"]."</td>";
	$return .="<td>".$d["PALENQUERAS"]."</td>";
	$return .="<td>".$d["RAIZAL"]."</td>";
	$return .="</tr>";


$aux3[0] += $d["ARTISTAS"];
$aux3[1] += $d["INSCRITOS"];
$aux3[2] += $d["HOMBRES"];
$aux3[3] += $d["MUJERES"];
$aux3[4] += $d["TOTAL"];

$aux3[5] += $d["PRIMERA"];
$aux3[6] += $d["INFANCIA"];
$aux3[7] += $d["ADOLESCENCIA"];
$aux3[8] += $d["JUVENTUD"];
$aux3[9] += $d["ADULTOS"];
$aux3[10] += $d["MAYORES"];

$aux3[11] += $d["CAMPESINOS"];
$aux3[12] += $d["GESTANTES"];
$aux3[13] += $d["ACTIVIDADES_SEXUALES"];
$aux3[14] += $d["HABITANTES_CALLE"];
$aux3[15] += $d["DISCAPACIDAD"];
$aux3[16] += $d["PRIVADOS_LIBERTAD"];
$aux3[17] += $d["PROFESIONALES_SECTOR"];
$aux3[18] += $d["LGBTIQ"];
$aux3[19] += $d["CONFLICTO_ARMADO"];
$aux3[20] += $d["MIGRANTE"];
$aux3[21] += $d["VICTIMAS_TRATA"];
$aux3[22] += $d["SOCIAL_CATASTROFICA"];
$aux3[23] += $d["DETERIORO_URBANO"];
$aux3[24] += $d["VULNERABILIDAD"];
$aux3[25] += $d["DESPLAZAMIENTO"];
$aux3[26] += $d["SUSTANCIAS_PSICOACTIVAS"];

$aux3[27] += $d["ROM_GITANO"];
$aux3[28] += $d["PRORROM"];
$aux3[29] += $d["INDIGENA"];
$aux3[30] += $d["COMUNIDADES_NEGRAS"];
$aux3[31] += $d["AFRODESCENDIENTE"];
$aux3[32] += $d["PALENQUERAS"];
$aux3[33] += $d["RAIZAL"];

}	
	$return .="<tr style='background-color: #A9DFBF; font-size: 18px;' class='text-center'>";   
	$return .="<td></td>";
	$return .="<td></td>";
	$return .="<td></td>";
	$return .="<td></td>";
	$return .="<td></td>";
	$return .="<td></td>";
	$return .="<td></td>";
	$return .="<td></td>";
	$return .="<td></td>";
	
	for($i=0; $i<= 33; $i++){
	  $return .=" <td>". $aux3[$i]."</td>";	  
	}
	$return .="</tr>";
echo $return;
?>