<?php
$return = "";
foreach ($this->getVariables()['ConsolidadoFAP'] as $c)
{
  $return .="<tr>";
  $return .=" <td style='background-color: #FCF3CF'><center>". $c['IDFortalecimiento']."</center></td>";
  $return .=" <td style='background-color: #FCF3CF'><center>". $c['Fecha']."</center></td>";
  $return .=" <td style='background-color: #FCF3CF'><center>". $c['Territorio']."</center></td>";
  $return .=" <td style='background-color: #FCF3CF'><center>". $c['EAAT']."</center></td>";
  $return .=" <td style='background-color: #FCF3CF'><center>". $c['NomEvento']."</center></td>";  
  $return .="	<td style='background-color: #FDF2E9'><center>". $c['Localidad']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $c['Upz']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $c['Barrio']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $c['Lugar']."</center></td>";  
  $return .="	<td style='background-color: #D1F2EB'><center>". $c['Artistas']."</center></td>";
  $return .="	<td><center> <a href='#' class='Consultar-Experiencia btn btn-success' data-idexperiencia='".$c['IDFortalecimiento']."'>Consultar</a></center></td>";
  $return .="</tr>";
}
echo $return;
?>
