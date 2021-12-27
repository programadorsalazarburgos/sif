<?php
$return = "";
foreach ($this->getVariables()['Consolidado'] as $c)
{
  $return .="<tr>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $c['LUGAR']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $c['NOMGRUPO']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $c['ENTIDAD']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $c['TLUGAR']."</center></td>";
  $return .="	<td style='background-color: #FDF2E9'><center>". $c['EXPERIENCIA']."</center></td>";
  $return .="	<td style='background-color: #D4E6F1'><center>". $c['TOTAL_N']."</center></td>";
  $return .="	<td style='background-color: #D1F2EB'><center>". $c['TOTAL_DE_0_3_ANIOS_R']."</center></td>";
  $return .="	<td style='background-color: #D1F2EB'><center>". $c['TOTAL_DE_4_6_ANIOS_R']."</center></td>";
  $return .="	<td style='background-color: #D1F2EB'><center>". $c['GESTANTES_R']."</center></td>";
  $return .="	<td style='background-color: #76D7C4'><center><strong>". $c['TOTAL_R']."</strong></center></td>";
  $return .="</tr>";
}
echo $return;
?>
