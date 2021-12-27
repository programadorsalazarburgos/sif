<?php
  $return = "";

  $duplaActual = "";
  $aux3 = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  $total = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];


  $encabezado = "<thead>  <tr style='background-color: #EAECEE; font-weight: bold;' class='text-center'><td>No. DUPLA</td><td># de Encuentros</td><td># Adultos Cuidadores</td><td>Total de 1 mes a 3 años</td><td>Total de 4 a 6 años</td><td>Niños 1 mes a 3 años</td><td>Niñas 1 mes a 3 años</td><td>Niños 4 a 6 años</td><td>Niñas 4 a 6 años</td><td>Madres Gestantes</td><td>Afro descendientes</td><td>Indígenas</td><td>Raizales</td><td>ROM</td><td>Comunidad Campesina</td><td>Discapacidad</td><td>Víctimas del Conflicto</td><td>Privados de la Libertad</td><td>TOTAL</td></tr></thead><tbody>";
  $final_tabla="</tr></tbody></table></div></div>";

  $return .='<div class="panel panel-primary">';
  $return .='<div class="panel-heading"><center><h4>ATENCIÓN REAL POR DUPLA</h4></center></div>';
  $return .='<div class="panel-body">';
  $return .='<table id="table_Consolidado_Atencion" class="table table-striped table-bordered table-hover" width="100%">';
  $return .= $encabezado;

  foreach ($this->getVariables()['TotalLaboratorios'] as $clave => $c)
  {

  $cambiodupla =  $c['DUPLA'];

                $aux3[0] += $c['ENCUENTROS']; 
                $aux3[1] += $c['CUIDADORES'];     
                $aux3[2] += $c['TOTAL_DE_0_3_ANIOS_R'];
                $aux3[3] += $c['TOTAL_DE_4_6_ANIOS_R'];
                $aux3[4] += $c['NINOS_DE_0_A_3_R'];
                $aux3[5] += $c['NINAS_DE_0_A_3_R'];
                $aux3[6] += $c['NINOS_DE_4_A_6_R'];
                $aux3[7] += $c['NINAS_DE_4_A_6_R'];
                $aux3[8] += $c['GESTANTES_R'];
                $aux3[9] += $c['AFRODESCENDIENTE_R'];
                $aux3[10] += $c['ROM_R'];
                $aux3[11] += $c['INDIGENA_R'];
                $aux3[12] += $c['CONFLICTO_R'];
                $aux3[13] += $c['DISCAPACIDAD_R'];
                $aux3[14] += $c['PRIVADOS_R'];
                $aux3[15] += $c['RAIZALES_R'];
                $aux3[16] += $c['CAMPESINA_R'];
                $aux3[17] += $c['TOTAL_R'];

  $duplaActual = $c['DUPLA'];

    if($c['DUPLA'] == $cambiodupla){

      $return .="<tr>";
      $return .=" <td style='background-color: #16A085'><center>". $c['DUPLA']."</center></td>";
      $return .=" <td style='background-color: #ABEBC6'><center>". $c['ENCUENTROS']."</center></td>";
      $return .=" <td style='background-color: #ABEBC6'><center>". $c['CUIDADORES']."</center></td>";
      $return .=" <td style='background-color: #EBEDEF'><center>". $c['TOTAL_DE_0_3_ANIOS_R']."</center></td>";
      $return .=" <td style='background-color: #EBEDEF'><center>". $c['TOTAL_DE_4_6_ANIOS_R']."</center></td>";
      $return .=" <td style='background-color: #EBEDEF'><center>". $c['NINOS_DE_0_A_3_R']."</center></td>";
      $return .=" <td style='background-color: #EBEDEF'><center>". $c['NINAS_DE_0_A_3_R']."</center></td>";
      $return .=" <td style='background-color: #EBEDEF'><center>". $c['NINOS_DE_4_A_6_R']."</center></td>";
      $return .=" <td style='background-color: #EBEDEF'><center>". $c['NINAS_DE_4_A_6_R']."</center></td>";
      $return .=" <td style='background-color: #EBEDEF'><center>". $c['GESTANTES_R']."</center></td>";
      $return .=" <td style='background-color: #85C1E9'><center>". $c['AFRODESCENDIENTE_R']."</center></td>";
      $return .=" <td style='background-color: #85C1E9'><center>". $c['ROM_R']."</center></td>";
      $return .=" <td style='background-color: #85C1E9'><center>". $c['INDIGENA_R']."</center></td>";
      $return .=" <td style='background-color: #85C1E9'><center>". $c['CONFLICTO_R']."</center></td>";
      $return .=" <td style='background-color: #85C1E9'><center>". $c['DISCAPACIDAD_R']."</center></td>";
      $return .=" <td style='background-color: #85C1E9'><center>". $c['PRIVADOS_R']."</center></td>";
      $return .=" <td style='background-color: #85C1E9'><center>". $c['RAIZALES_R']."</center></td>";
      $return .=" <td style='background-color: #85C1E9'><center>". $c['CAMPESINA_R']."</center></td>";
      $return .=" <td style='background-color: #7FB3D5'><center><strong>". $c['TOTAL_R']."</strong></center></td>";
      $return .="</tr>";
    }
  }
  if (sizeof($this->getVariables()['TotalLaboratorios']) != 0){

    $return .="<tr style='background-color: #2471A3; color: white;' class='text-center'>";   
    $return .="<td>TOTALES</td>";
    
    for($i=0; $i<= 17; $i++){
      $return .=" <td>". $aux3[$i]."</td>";
      $total[$i] = ($total[$i] + $aux3[$i]);
    }
  }
  $return .= $final_tabla;

  echo $return;
?>
