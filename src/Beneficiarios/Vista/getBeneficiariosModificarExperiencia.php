<?php 
$return = "";
foreach ($this->getVariables()['Beneficiarios'] as $b){

  $fecha_atencion = DateTime::createFromFormat("Y-m-d", $b['FECHAATENCION']);
  $fecha_nacimiento = DateTime::createFromFormat("Y-m-d", $b['FECHANACIMIENTO']);
  $edad = $fecha_atencion->diff($fecha_nacimiento);

  if($b['IDASISTENCIA'] == null){
    $return .="<tr style='background-color:  #f7dc6f;'>";
  }else{
    $return .="<tr>";
  }
  $return .="<td><center>". $b['IDENTIFICACION']."</center></td>";
  $return .="<td><center>". $b['BENEFICIARIO']."</center></td>";
  $return .="<td><center>". $b['GENERO']."</center></td>";
  $return .="<td><center>". $b['ENFOQUE']."</center></td>";
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
  if($edad->y >= 0 && $edad->y < 4){
    if($b['GENERO'] == "MASCULINO"){
      $return .= "<td><center>Niño de 1 mes a 3 años</center></td>";
    }else{
      $return .= "<td><center>Niña de 1 mes a 3 años</center></td>";
    }
  }
  if($edad->y >= 4 && $edad->y < 6){
    if($b['GENERO'] == "MASCULINO"){
      $return .= "<td><center>Niño de 4 años a 6 años</center></td>";
    }else{
      $return .= "<td><center>Niño de 4 años a 6 años</center></td>";
    }
  }
  if($edad->y >= 6 && $edad->y < 7){
    if($b['GENERO'] == "MASCULINO"){
      $return .= "<td><center>Niño superó la edad permitida</center></td>";
    }else{
      $return .= "<td><center>Niña superó la edad permitida</center></td>";
    }
  }
  if($edad->y >= 7){
    if($b['GENERO'] == "MASCULINO"){
      $return .= "<td><center>Niño superó la edad permitida</center></td>";
    }else{
      $return .= "<td><center>Madre gestante</center></td>";
    }
  }
  if($b['IDASISTENCIA'] == null){
    $return .= "<td><center><input data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_beneficiario='".$b['IDBENEFICIARIO']."' data-id_experiencia='".$b['IDEXPERIENCIA']."'></center></td>";
  }else{
    if($b['ASISTENCIA'] == 1){
      $return .="<td><center><input checked data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_asistencia='".$b['IDASISTENCIA']."'></center></td>";
    }else{
      $return .="<td><center><input data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_asistencia='".$b['IDASISTENCIA']."'></center></td>";
    }
  }
  $return .="</tr>";
}
echo $return;
