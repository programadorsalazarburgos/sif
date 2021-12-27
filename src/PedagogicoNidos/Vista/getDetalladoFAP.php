<?php
$return = "";
foreach ($this->getVariables()['DetalladoFAP'] as $d)
{
  $return .="<tr>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $d['Identificacion']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $d['Artista']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $d['Localidad']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $d['Upz']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $d['Lugar']."</center></td>";
  $return .="	<td style='background-color: #FCF3CF'><center>". $d['NomEvento']."</center></td>";
  $return .="	<td style='background-color: #FCF3CF'><center>". $d['Fecha']."</center></td>";
  $return .="</tr>";
}
echo $return;
?>
