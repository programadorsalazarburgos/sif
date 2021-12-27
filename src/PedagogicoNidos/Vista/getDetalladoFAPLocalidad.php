<?php
$return = "";
foreach ($this->getVariables()['FAPLocalidad'] as $l)
{
  $return .="<tr>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $l['Identificacion']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $l['Artista']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $l['Upz']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $l['Lugar']."</center></td>";
  $return .="	<td style='background-color: #FCF3CF'><center>". $l['NomEvento']."</center></td>";
  $return .="	<td style='background-color: #FCF3CF'><center>". $l['Fecha']."</center></td>";
  $return .="</tr>";
}
echo $return;
?>