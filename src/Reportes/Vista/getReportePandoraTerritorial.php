<?php
$return = ""; 
foreach ($this->getVariables()['Datos'] as $d){
	$return .="<tr>";
	$return .="<td style='text-align: center;'><font size=3>".$d["ACTIVIDADES"]."</font></td>";
	$return .="<td><font size=3>".$d["FECHA"]."</font></td>";
	$return .="<td><font size=3>".$d["LUGAR"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["AFORO"]."</font></td>";
	$return .="<td><font size=3>".$d["LOCALIDAD"]."</font></td>";
	$return .="<td><font size=3>".$d["UPZ"]."</font></td>";
	$return .="<td><font size=3>".$d["BARRIO"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["ARTISTAS"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["INSCRITOS"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["TOTAL_NINAS"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["TOTAL_NINOS"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["TOTAL_BENEFICIARIOS"]."</font></td>";

	$return .="<td style='text-align: center;'><font size=3>".$d["PRIMERA"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["INFANCIA"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["ADOLENCENTES"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["JUVENTUD"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["ADULTAS"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["MAYORES"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["CAMPESINOS"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["GESTANTES"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["DISCAPACIDAD"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["PRIVADOS"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["CONFLICTO"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["MIGRANTE"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["VICTIMAS_TRATA"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["ROM_GITANO"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["INDIGENA"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["COMUNIDADES_NEGRAS"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["AFRODESCENDIENTES"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["PALENQUERAS"]."</font></td>";
	$return .="<td style='text-align: center;'><font size=3>".$d["RAIZAL"]."</font></td>";
	$return .="<td style='text-align: center;'></td>";
	$return .="</tr>";
}
echo $return;
?>