<?php
$return = "";
foreach ($this->getVariables()['equipoCentral'] as $ec){
  $return .="<tr>";
  $return .="<td><center>". $ec['IDENTIFICACION']."</center></td>";
  $return .="<td><center>". $ec['NOMBRE']."</center></td>";
  $return .="<td><center>". $ec['TERRITORIO']."</center></td>";
  $return .="<td><center>". $ec['IDPERSONA']."</center></td>";
 /* $return .="<td><center><input id='id_beneficiario' data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-id_beneficiario='".$at['IDPERSONA']."' data-on='SI' data-off='NO' type='checkbox' class='asistencia_experiencia' checked></center></td>";
   $return .="</tr>"; */
}
echo $return;
