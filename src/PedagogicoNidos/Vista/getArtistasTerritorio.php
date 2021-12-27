<?php
$return = "";
foreach ($this->getVariables()['artistasTerritorio'] as $at){



  $return .="<tr>";
  $return .="<td><center>". $at['IDENTIFICACION']."</center></td>";
  $return .="<td><center>". $at['NOMBRE']."</center></td>";
  $return .="<td><center> - </center></td>";
  $return .="<td><center>". $at['DUPLA']."</center></td>";
  $return .="<td><center><input id='id_beneficiario' data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-id_beneficiario='".$at['IDPERSONA']."' data-on='SI' data-off='NO' type='checkbox' class='asistencia_experiencia' checked></center></td>";
   $return .="</tr>";
}
echo $return;
