<?php
$return = "";
foreach ($this->getVariables()['Asistencia'] as $d)
{
  $return .="<tr>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $d['Id_Experiencia']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $d['Nom_Experiencia']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $d['Fecha']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $d['Hora']."</center></td>";
  $return .="	<td style='background-color: #D1F2EB'><center>". $d['Total_0_a_3']."</center></td>";
  $return .="	<td style='background-color: #D1F2EB'><center>". $d['Total_4_a_5']."</center></td>";
  $return .="	<td style='background-color: #D1F2EB'><center>". $d['Total_Gestantes']."</center></td>";
  $return .="	<td style='background-color: #76D7C4'><center><strong>". $d['Total']."</strong></center></td>";
  $return .="	<td><center> <a href='#' class='Consultar-Experiencia btn btn-success' data-idexperiencia='".$d['Id_Experiencia']."'>Consultar</a></center></td>";
  $return .="</tr>";
}
echo $return;
?>
