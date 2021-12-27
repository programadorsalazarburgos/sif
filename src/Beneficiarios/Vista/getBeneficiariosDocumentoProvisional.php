<?php
$return = "";
foreach ($this->getVariables()['beneficiariosAsistencia'] as $b){

  $fecha_atencion =   DateTime::createFromFormat("Y-m-d", date("Y-m-d"));
  $fecha_nacimiento = DateTime::createFromFormat("Y-m-d", $b['FECHANACIMIENTO']);
  $edad = $fecha_atencion->diff($fecha_nacimiento);

  $return .="<tr>";
  $return .="	<td><center>". $b['IDENTIFICACION']."</center></td>";
  $return .="	<td><center>". $b['TIPO']."</center></td>";
  $return .="	<td><center>". $b['BENEFICIARIO']."</center></td>";
  $return .="	<td><center>". $b['FECHANACIMIENTO']."</center></td>";
  $return .="<td><center>";
  if($edad->y == 1){
    $return .=$edad->y. " año ";
  }
  if($edad->y > 1){
    $return .=$edad->y. " años ";
  }
  if($edad->m == 1){
    $return .= $edad->m." mes ";
  }
  if($edad->m > 1){
    $return .= $edad->m." meses ";
  }
  if($edad->d == 1){
    $return .= $edad->d." día";
  }
  if($edad->d > 1){
    $return .= $edad->d." días";
  }
  $return .="</td></center>";
  $return .="	<td><center>". $b['GENERO']."</center></td>";
  $return .="	<td><center>". $b['ENFOQUE']."</center></td>";
  $return .="</tr>";
}
echo $return;
