<?php
$return = "";
foreach ($this->getVariables()['Fortalecimiento'] as $f)
{
  $return .="<tr>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $f['ID']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $f['Localidad']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $f['Upz']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $f['Lugar']."</center></td>";
  $return .="	<td style='background-color: #FCF3CF'><center>". $f['Evento']."</center></td>";
  $return .="	<td style='background-color: #FCF3CF'><center>". $f['Fecha']."</center></td>";
  $return .="	<td style='background-color: #D1F2EB'><center>". $f['Artistas']."</center></td>";
  $return .="	<td><center> <a href='#' class='Consultar-Experiencia btn btn-success' data-idexperiencia='".$f['ID']."'>Consultar</a></center></td>";
  $return .="</tr>";
}
echo $return;
?>
