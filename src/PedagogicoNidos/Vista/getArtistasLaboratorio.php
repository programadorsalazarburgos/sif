<?php
$return = "";
foreach ($this->getVariables()['artistasLaboratorio'] as $at){



  $return .="<tr>";
  $return .="<td><center>". $at['IDENTIFICACION']."</center></td>";
  $return .="<td><center>". $at['NOMBRE']."</center></td>";
  $return .="<td><center>". $at['TERRITORIO']."</center></td>";
  $return .="<td><center>". $at['DUPLA']."</center></td>";
  $return .="<td><center><input id='id_beneficiario' data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-id_artista='".$at['IDPERSONA']."' data-on='SI' data-off='NO' type='checkbox' class='asistencia_laboratorio' checked></center></td>";
   $return .="</tr>";
}
echo $return;
