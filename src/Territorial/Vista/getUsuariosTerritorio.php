<?php
$return = "";
foreach ($this->getVariables()['usuarios'] as $u)
{
  $return .="<tr>";
  $return .="	<td>". $u['Vc_Nom_Territorio']."</td>";
  $return .="	<td>". $u['VC_Identificacion']."</td>";
  $return .="	<td>". $u['Nombre']."</td>";
  $return .="	<td>". $u['VC_Nom_Tipo']."</td>";
  $return .="</tr>";
}
echo $return;
?>
