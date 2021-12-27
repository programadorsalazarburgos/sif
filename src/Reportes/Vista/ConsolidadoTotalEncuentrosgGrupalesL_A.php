<?php
$return = "";

$entidadActual = "";
$aux1 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$aux2 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$aux3 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$total = [0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$encabezado = "<thead><tr style='background-color: #EAECEE; font-weight: bold;' class='text-center'><td>Tipo Lugar</td><td>Localidad</td><td>Upz</td><td>Barrio</td><td>Lugar</td><td>Atenciones</td><td>De 1 mes a 3 años</td><td>De 4 a 6 años</td><td>Gestantes</td><td>Afro descendientes</td><td>ROM</td><td>Indígenas</td><td>Víctimas del Conflicto</td><td>Discapacidad</td><td>Ninguno</td><td>Privados de la Libertad</td><td>Raizales</td><td>Comunidad Campesina</td><td>Total Asistentes</td></tr></thead><tbody>";
$final_tabla="</tr></tbody></table></div></div>";

$return .='<div class="panel panel-primary">';
$return .='<div class="panel-heading"><center><h4>ENTORNO FAMILIAR</h4></center></div>';
$return .='<div class="panel-body">';

$return .='<table id="table_Consolidado_Familiar" class="table table-striped table-bordered table-hover" width="100%">';
$return .= $encabezado;

foreach ($this->getVariables()['entornoFamiliar'] as $clave => $e){
  $aux3[0] += $e['EXPERIENCIA'];
  $aux3[1] += $e['TOTAL_DE_0_3_ANIOS_R'];
  $aux3[2] += $e['TOTAL_DE_4_6_ANIOS_R'];
  $aux3[3] += $e['GESTANTES_R'];
  $aux3[4] += $e['AFRODESCENDIENTE_R'];
  $aux3[5] += $e['ROM_R'];
  $aux3[6] += $e['INDIGENA_R'];
  $aux3[7] += $e['CONFLICTO_R'];
  $aux3[8] += $e['DISCAPACIDAD_R'];
  $aux3[9] += $e['NINGUNO_R'];
  $aux3[10] += $e['PRIVADOS_R'];
  $aux3[11] += $e['RAIZALES_R'];
  $aux3[12] += $e['CAMPESINA_R'];
  $aux3[13] += $e['ASISTENTES'];

  if ($entidadActual != $e['ENTIDAD'] && $clave != 0){
    $return .="<tr style='background-color: #5DADE2;' class='text-center'>";
    $return .="<td colspan='5' style='color: white;'> TOTAL ICBF</td>";
    $return .='	<td hidden></td>';
    $return .="	<td hidden></td>";
    $return .="	<td hidden></td>";
    $return .="	<td hidden></td>";
    for($i=0; $i<= 13; $i++){
      $return .="	<td>". $aux1[$i]."</td>";
    }
    $return .="</tr>";
  }
  $entidadActual = $e['ENTIDAD'];


  if($e['ENTIDAD'] == '1'){
    $aux1[0] += $e['EXPERIENCIA'];
    $aux1[1] += $e['TOTAL_DE_0_3_ANIOS_R'];
    $aux1[2] += $e['TOTAL_DE_4_6_ANIOS_R'];
    $aux1[3] += $e['GESTANTES_R'];
    $aux1[4] += $e['AFRODESCENDIENTE_R'];
    $aux1[5] += $e['ROM_R'];
    $aux1[6] += $e['INDIGENA_R'];
    $aux1[7] += $e['CONFLICTO_R'];
    $aux1[8] += $e['DISCAPACIDAD_R'];
    $aux1[9] += $e['NINGUNO_R'];
    $aux1[10] += $e['PRIVADOS_R'];
    $aux1[11] += $e['RAIZALES_R'];
    $aux1[12] += $e['CAMPESINA_R'];
    $aux1[13] += $e['ASISTENTES'];

    $return .="<tr style='background-color: #AED6F1;' class='text-center'>";
    $return .="	<td>". $e['TIPO']."</td>";
    $return .="	<td>". $e['Localidad']."</td>";
    $return .="	<td>". $e['UPZ']."</td>";
    $return .="	<td>". $e['Barrio']."</td>";
    $return .="	<td>". $e['Lugar']."</td>";
    $return .="	<td>". $e['EXPERIENCIA']."</td>";
    $return .="	<td>". $e['TOTAL_DE_0_3_ANIOS_R']."</td>";
    $return .="	<td>". $e['TOTAL_DE_4_6_ANIOS_R']."</td>";
    $return .="	<td>". $e['GESTANTES_R']."</td>";
    $return .="	<td>". $e['AFRODESCENDIENTE_R']."</td>";
    $return .="	<td>". $e['ROM_R']."</td>";
    $return .="	<td>". $e['INDIGENA_R']."</td>";
    $return .="	<td>". $e['CONFLICTO_R']."</td>";
    $return .="	<td>". $e['DISCAPACIDAD_R']."</td>";
    $return .="	<td>". $e['NINGUNO_R']."</td>";
    $return .="	<td>". $e['PRIVADOS_R']."</td>";
    $return .="	<td>". $e['RAIZALES_R']."</td>";
    $return .="	<td>". $e['CAMPESINA_R']."</td>";
    $return .="	<td>". $e['ASISTENTES']."</td>";
    $return .="</tr>";
  }else{
    $aux2[0] += $e['EXPERIENCIA'];
    $aux2[1] += $e['TOTAL_DE_0_3_ANIOS_R'];
    $aux2[2] += $e['TOTAL_DE_4_6_ANIOS_R'];
    $aux2[3] += $e['GESTANTES_R'];
    $aux2[4] += $e['AFRODESCENDIENTE_R'];
    $aux2[5] += $e['ROM_R'];
    $aux2[6] += $e['INDIGENA_R'];
    $aux2[7] += $e['CONFLICTO_R'];
    $aux2[8] += $e['DISCAPACIDAD_R'];
    $aux2[9] += $e['NINGUNO_R'];
    $aux2[10] += $e['PRIVADOS_R'];
    $aux2[11] += $e['RAIZALES_R'];
    $aux2[12] += $e['CAMPESINA_R'];
    $aux2[13] += $e['ASISTENTES'];

    $return .="<tr style='background-color: #AED6F1;' class='text-center'>";
    $return .="	<td>". $e['TIPO']."</td>";
    $return .="	<td>". $e['Localidad']."</td>";
    $return .="	<td>". $e['UPZ']."</td>";
    $return .="	<td>". $e['Barrio']."</td>";
    $return .="	<td>". $e['Lugar']."</td>";
    $return .="	<td>". $e['EXPERIENCIA']."</td>";
    $return .="	<td>". $e['TOTAL_DE_0_3_ANIOS_R']."</td>";
    $return .="	<td>". $e['TOTAL_DE_4_6_ANIOS_R']."</td>";
    $return .="	<td>". $e['GESTANTES_R']."</td>";
    $return .="	<td>". $e['AFRODESCENDIENTE_R']."</td>";
    $return .="	<td>". $e['ROM_R']."</td>";
    $return .="	<td>". $e['INDIGENA_R']."</td>";
    $return .="	<td>". $e['CONFLICTO_R']."</td>";
    $return .="	<td>". $e['DISCAPACIDAD_R']."</td>";
    $return .="	<td>". $e['NINGUNO_R']."</td>";
    $return .="	<td>". $e['PRIVADOS_R']."</td>";
    $return .="	<td>". $e['RAIZALES_R']."</td>";
    $return .="	<td>". $e['CAMPESINA_R']."</td>";
    $return .="	<td>". $e['ASISTENTES']."</td>";
    $return .="</tr>";
  }

  if (count($this->getVariables()['entornoFamiliar']) == ($clave + 1) ){
    $return .="<tr style='background-color: #5DADE2;' class='text-center'>";
    $return .="<td colspan='5' style='color: white;'> TOTAL SDIS</td>";
    $return .="	<td hidden></td>";
    $return .="	<td hidden></td>";
    $return .="	<td hidden></td>";
    $return .="	<td hidden></td>";
    for($i=0; $i<= 13; $i++){
      $return .="	<td>". $aux2[$i]."</td>";
    }
    $return .="</tr>";
    $entidadActual = $e['ENTIDAD'];
  }
}

$return .="<tr style='background-color: #2874A6; color: white;' class='text-center'>";
$return .="<td colspan='5'>TOTAL ENTORNO FAMILIAR</td>";
$return .="	<td hidden></td>";
$return .="	<td hidden></td>";
$return .="	<td hidden></td>";
$return .="	<td hidden></td>";
for($i=0; $i<= 13; $i++){
  $return .="	<td>". $aux3[$i]."</td>";
  $total[$i] = ($total[$i] + $aux3[$i]);
}
$return .= $final_tabla;

$return .='<div class="panel panel-warning">';
$return .='<div class="panel-heading"><center><strong><h4>ENTORNO INSTITUCIONAL</h4></strong></center></div>';
$return .='<div class="panel-body">';
$return .='<table id="table_Consolidado_Institucional" class="table table-striped table-bordered table-hover" width="100%">';
$return .= $encabezado;

$entidadActual = "";
$aux1 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$aux2 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$aux3 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0];

foreach ($this->getVariables()['entornoInstitucional'] as $clave => $e)
{

  $aux3[0] += $e['EXPERIENCIA'];
  $aux3[1] += $e['TOTAL_DE_0_3_ANIOS_R'];
  $aux3[2] += $e['TOTAL_DE_4_6_ANIOS_R'];
  $aux3[3] += $e['GESTANTES_R'];
  $aux3[4] += $e['AFRODESCENDIENTE_R'];
  $aux3[5] += $e['ROM_R'];
  $aux3[6] += $e['INDIGENA_R'];
  $aux3[7] += $e['CONFLICTO_R'];
  $aux3[8] += $e['DISCAPACIDAD_R'];
  $aux3[9] += $e['NINGUNO_R'];
  $aux3[10] += $e['PRIVADOS_R'];
  $aux3[11] += $e['RAIZALES_R'];
  $aux3[12] += $e['CAMPESINA_R'];
  $aux3[13] += $e['ASISTENTES'];


  if ($entidadActual != $e['ENTIDAD'] && $clave != 0) {
    $return .="<tr style='background-color: #F8C471;' class='text-center'>";
    $return .="<td colspan='5'> TOTAL ICBF</td>";
    $return .="	<td hidden></td>";
    $return .="	<td hidden></td>";
    $return .="	<td hidden></td>";
    $return .="	<td hidden></td>";
    for($i=0; $i<= 13; $i++){
      $return .="	<td>". $aux1[$i]."</td>";
    }
    $return .="</tr>";
  }
  $entidadActual = $e['ENTIDAD'];


  if($e['ENTIDAD'] == '1'){

    $aux1[0] += $e['EXPERIENCIA'];
    $aux1[1] += $e['TOTAL_DE_0_3_ANIOS_R'];
    $aux1[2] += $e['TOTAL_DE_4_6_ANIOS_R'];
    $aux1[3] += $e['GESTANTES_R'];
    $aux1[4] += $e['AFRODESCENDIENTE_R'];
    $aux1[5] += $e['ROM_R'];
    $aux1[6] += $e['INDIGENA_R'];
    $aux1[7] += $e['CONFLICTO_R'];
    $aux1[8] += $e['DISCAPACIDAD_R'];
    $aux1[9] += $e['NINGUNO_R'];
    $aux1[10] += $e['PRIVADOS_R'];
    $aux1[11] += $e['RAIZALES_R'];
    $aux1[12] += $e['CAMPESINA_R'];
    $aux1[13] += $e['ASISTENTES'];

    $return .="<tr style='background-color: #FAD7A0;' class='text-center'>";
    $return .="	<td>". $e['TIPO']."</td>";
    $return .="	<td>". $e['Localidad']."</td>";
    $return .="	<td>". $e['UPZ']."</td>";
    $return .="	<td>". $e['Barrio']."</td>";
    $return .="	<td>". $e['Lugar']."</td>";
    $return .="	<td>". $e['EXPERIENCIA']."</td>";
    $return .="	<td>". $e['TOTAL_DE_0_3_ANIOS_R']."</td>";
    $return .="	<td>". $e['TOTAL_DE_4_6_ANIOS_R']."</td>";
    $return .="	<td>". $e['GESTANTES_R']."</td>";
    $return .="	<td>". $e['AFRODESCENDIENTE_R']."</td>";
    $return .="	<td>". $e['ROM_R']."</td>";
    $return .="	<td>". $e['INDIGENA_R']."</td>";
    $return .="	<td>". $e['CONFLICTO_R']."</td>";
    $return .="	<td>". $e['DISCAPACIDAD_R']."</td>";
    $return .="	<td>". $e['NINGUNO_R']."</td>";
    $return .="	<td>". $e['PRIVADOS_R']."</td>";
    $return .="	<td>". $e['RAIZALES_R']."</td>";
    $return .="	<td>". $e['CAMPESINA_R']."</td>";
    $return .="	<td>". $e['ASISTENTES']."</td>";
    $return .="</tr>";

  }

  else {

    $aux2[0] += $e['EXPERIENCIA'];
    $aux2[1] += $e['TOTAL_DE_0_3_ANIOS_R'];
    $aux2[2] += $e['TOTAL_DE_4_6_ANIOS_R'];
    $aux2[3] += $e['GESTANTES_R'];
    $aux2[4] += $e['AFRODESCENDIENTE_R'];
    $aux2[5] += $e['ROM_R'];
    $aux2[6] += $e['INDIGENA_R'];
    $aux2[7] += $e['CONFLICTO_R'];
    $aux2[8] += $e['DISCAPACIDAD_R'];
    $aux2[9] += $e['NINGUNO_R'];
    $aux2[10] += $e['PRIVADOS_R'];
    $aux2[11] += $e['RAIZALES_R'];
    $aux2[12] += $e['CAMPESINA_R'];
    $aux2[13] += $e['ASISTENTES'];

    $return .="<tr style='background-color: #FAD7A0;' class='text-center'>";
    $return .="	<td>". $e['TIPO']."</td>";
    $return .="	<td>". $e['Localidad']."</td>";
    $return .="	<td>". $e['UPZ']."</td>";
    $return .="	<td>". $e['Barrio']."</td>";
    $return .="	<td>". $e['Lugar']."</td>";
    $return .="	<td>". $e['EXPERIENCIA']."</td>";
    $return .="	<td>". $e['TOTAL_DE_0_3_ANIOS_R']."</td>";
    $return .="	<td>". $e['TOTAL_DE_4_6_ANIOS_R']."</td>";
    $return .="	<td>". $e['GESTANTES_R']."</td>";
    $return .="	<td>". $e['AFRODESCENDIENTE_R']."</td>";
    $return .="	<td>". $e['ROM_R']."</td>";
    $return .="	<td>". $e['INDIGENA_R']."</td>";
    $return .="	<td>". $e['CONFLICTO_R']."</td>";
    $return .="	<td>". $e['DISCAPACIDAD_R']."</td>";
    $return .="	<td>". $e['NINGUNO_R']."</td>";
    $return .="	<td>". $e['PRIVADOS_R']."</td>";
    $return .="	<td>". $e['RAIZALES_R']."</td>";
    $return .="	<td>". $e['CAMPESINA_R']."</td>";
    $return .="	<td>". $e['ASISTENTES']."</td>";
    $return .="</tr>";

  }
  if (count($this->getVariables()['entornoInstitucional']) == ($clave + 1) ) {
    $return .="<tr style='background-color: #F8C471;' class='text-center'>";
    $return .="<td colspan='5'> TOTAL SDIS</td>";
    $return .="	<td hidden></td>";
    $return .="	<td hidden></td>";
    $return .="	<td hidden></td>";
    $return .="	<td hidden></td>";
    for($i=0; $i<= 13; $i++){
      $return .="	<td>". $aux2[$i]."</td>";
    }
    $return .="</tr>";
    $entidadActual = $e['ENTIDAD'];
  }
}
$return .="<tr style='background-color: #F39C12;' class='text-center'>";
$return .="<td colspan='5'>TOTAL ENTORNO INSTITUCIONAL</td>";
$return .="	<td hidden></td>";
$return .="	<td hidden></td>";
$return .="	<td hidden></td>";
$return .="	<td hidden></td>";
for($i=0; $i<= 13; $i++){
  $return .="	<td>". $aux3[$i]."</td>";
}
$return .= $final_tabla;

$return .="<br><br>";

$return .='<div class="panel panel-success">';
$return .='<div class="panel-heading"><center><strong><h4>TOTAL TERRITORIO ENCUENTROS GRUPALES</h4></strong></center></div>';
$return .='<div class="panel-body">';

$return .='<table id="total_encuentros_grupales" class="table table-striped table-bordered table-hover" width="100%">';
$return .= "<thead><tr style='background-color: #EAECEE; font-weight: bold;' class='text-center'><td>Items</td><td>Atenciones</td><td>De 1 mes a 3 años</td><td>De 4 a 6 años</td><td>Gestantes</td><td>Afro descendientes</td><td>ROM</td><td>Indígenas</td><td>Víctimas del Conflicto</td><td>Discapacidad</td><td>Ninguno</td><td>Privados de la Libertad</td><td>Raizales</td><td>Comunidad Campesina</td><td>Total Asistentes</td></tr></thead><tbody>";
$return .="<tr style='background-color: #82E0AA;' class='text-center'>";
$return .="<td>TOTAL</td>";
for($i=0; $i<= 13; $i++){
  $return .="<td><strong>".$total[$i] = ($total[$i] + $aux3[$i])."</strong></td>";
}
$return .= $final_tabla;

echo $return;
