<?php
  $return = "";

  $localidadActual = "";
  $aux1 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  $aux3 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  $total = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];


  $encabezado = "<thead><tr style='background-color: #EAECEE; font-weight: bold;' class='text-center'><td>Localidad</td><td>UPZ</td><td>Barrios</td><td>Lugares</td><td>Tipo de Atención</td><td>Número Encuentros</td><td>Número de artistas</td><td>Madres Gestantes</td><td>Total 1 mes a 3 años</td><td>Total 4 a 5 años</td><td>Número Cuidadores</td><td>Afro descendientes</td><td>Indígenas</td><td>Raizales</td><td>ROM</td><td>Comunidad Campesina</td><td>Discapacidad</td><td>Víctimas del Conflicto</td><td>Privados de la Libertad</td><td>Ninguno</td><td>Total Asistentes</td></tr></thead><tbody>";
  $final_tabla="</tr></tbody></table></div></div>";

  $return .='<div class="panel panel-success">';
  $return .='<div class="panel-heading"><center><h4>ENCUENTROS GRUPALES POR UPZ</h4></center></div>';
  $return .='<div class="panel-body">';
  $return .='<table id="table_Consolidado_Upz" class="table table-striped table-bordered table-hover">';
  $return .= $encabezado;

  foreach ($this->getVariables()['TotalEncuentrosUpz'] as $clave => $c)
  {

  $cambiolocalidad =  $c['Localidad'];

    $aux3[0] += $c['EXPERIENCIA'];
    $aux3[1] += $c['ARTISTAS'];
    $aux3[2] += $c['GESTANTES_R'];
    $aux3[3] += $c['TOTAL_DE_0_3_ANIOS_R'];
    $aux3[4] += $c['TOTAL_DE_4_6_ANIOS_R'];
    $aux3[5] += $c['CUIDADORES'];
    $aux3[6] += $c['AFRODESCENDIENTE_R'];
    $aux3[7] += $c['INDIGENA_R'];
    $aux3[8] += $c['RAIZALES_R'];
    $aux3[9] += $c['ROM_R'];
    $aux3[10] += $c['CAMPESINA_R'];
    $aux3[11] += $c['DISCAPACIDAD_R'];
    $aux3[12] += $c['CONFLICTO_R'];
    $aux3[13] += $c['PRIVADOS_R'];
    $aux3[14] += $c['NINGUNO_R'];
    $aux3[15] += $c['TOTAL_R'];



    if ($localidadActual != $c['Localidad'] && $clave != 0){

      $return .="<tr style='background-color: #52BE80;' class='text-center'>";
      $return .="<td colspan='5' style='color: white;'><strong> TOTAL ENCUENTROS ". $localidadActual ."</strong></td>";
      $return .='	<td hidden></td>';
      $return .='	<td hidden></td>';
      $return .=' <td hidden></td>';
      $return .=' <td hidden></td>';
      for($i=0; $i<= 15; $i++){
        $return .="	<td>". $aux1[$i]."</td>";
      }
      $aux1 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
      $return .="</tr>";
    }
    $localidadActual = $c['Localidad'];



    if($c['Localidad'] == $cambiolocalidad){

      $aux1[0] += $c['EXPERIENCIA'];
      $aux1[1] += $c['ARTISTAS'];
      $aux1[2] += $c['GESTANTES_R'];
      $aux1[3] += $c['TOTAL_DE_0_3_ANIOS_R'];
      $aux1[4] += $c['TOTAL_DE_4_6_ANIOS_R'];
      $aux1[5] += $c['CUIDADORES'];
      $aux1[6] += $c['AFRODESCENDIENTE_R'];
      $aux1[7] += $c['INDIGENA_R'];
      $aux1[8] += $c['RAIZALES_R'];
      $aux1[9] += $c['ROM_R'];
      $aux1[10] += $c['CAMPESINA_R'];
      $aux1[11] += $c['DISCAPACIDAD_R'];
      $aux1[12] += $c['CONFLICTO_R'];
      $aux1[13] += $c['PRIVADOS_R'];
      $aux1[14] += $c['NINGUNO_R'];
      $aux1[15] += $c['TOTAL_R'];

      $return .="<tr>";
      $return .="	<td style='background-color: #E5E8E8'><center>". $c['Localidad']."</center></td>";
      $return .="	<td style='background-color: #E5E8E8'><center>". $c['UPZ']."</center></td>";
      $return .="	<td style='background-color: #E5E8E8'><center>". $c['BARRIO']."</center></td>";
      $return .="	<td style='background-color: #E5E8E8'><center>". $c['LUGAR_ATENCION']."</center></td>";
      $return .=" <td style='background-color: #E5E8E8'><center>". $c['TIPOGRUPO']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['EXPERIENCIA']."</center></td>";
      $return .=" <td style='background-color: #D1F2EB'><center>". $c['ARTISTAS']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['GESTANTES_R']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['TOTAL_DE_0_3_ANIOS_R']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['TOTAL_DE_4_6_ANIOS_R']."</center></td>";
      $return .=" <td style='background-color: #D1F2EB'><center>". $c['CUIDADORES']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['AFRODESCENDIENTE_R']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['INDIGENA_R']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['RAIZALES_R']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['ROM_R']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['CAMPESINA_R']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['DISCAPACIDAD_R']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['CONFLICTO_R']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['PRIVADOS_R']."</center></td>";
      $return .="	<td style='background-color: #D1F2EB'><center>". $c['NINGUNO_R']."</center></td>";
      $return .="	<td style='background-color: #76D7C4'><center><strong>". $c['TOTAL_R']."</strong></center></td>";
      $return .="</tr>";
    }

  }
  if (sizeof($this->getVariables()['TotalEncuentrosUpz']) != 0){

    $return .="<tr style='background-color: #52BE80;' class='text-center'>";
    $return .="<td colspan='5' style='color: white;'><strong> TOTAL ENCUENTROS ". $localidadActual ."</strong></td>";
    $return .=' <td hidden></td>';
    $return .=' <td hidden></td>';
    $return .=' <td hidden></td>';
    $return .=' <td hidden></td>';
    for($i=0; $i<= 15; $i++){
      $return .=" <td>". $aux1[$i]."</td>";
    }
    $return .="</tr>";

    $return .="<tr style='background-color: #0B5345; color: white;' class='text-center'>";
    $return .="<td colspan='5'>TOTAL ENCUENTROS GRUPALES EN EL MES </td>";
    $return .=" <td hidden></td>";
    $return .=' <td hidden></td>';
    $return .=" <td hidden></td>";
    $return .=' <td hidden></td>';
    for($i=0; $i<= 15; $i++){
      $return .=" <td>". $aux3[$i]."</td>";
      $total[$i] = ($total[$i] + $aux3[$i]);
    }

  }
  $return .= $final_tabla;

  echo $return;
?>
