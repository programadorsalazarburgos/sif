<?php
  $dato = $this->getVariables();

  $return = "<font size='4'><center><strong>Artistas de la Dupla:" . $dato['ARTISTAS']."</strong></center></font>";
  $return .= "<br>";
  $return .= "<div class='row'>";
  $return .= "<br>";
  $return .= "<div class='total_lugares col-xs-8 col-xs-offset-2 col-md-2 col-md-offset-1 alert alert-info' role='alert'>";
  $return .= "<center><strong>Grupos Atendidos</strong><br>" . $dato['GRUPOS']."</center>";
  $return .= "</div>";
  $return .= "<div class='total_duplas col-xs-8 col-xs-offset-2 col-md-2 col-md-offset-2 alert alert-success' role='alert'>";
  $return .= "<center><strong>Atenciones Realizadas</strong><br>" . $dato['ATENCIONES']."</center>";
  $return .= "</div>";
  $return .= "<div class='total_grupos col-xs-8 col-xs-offset-2 col-md-2 col-md-offset-2 alert alert-danger' role='alert'>";
  $return .= "<center><strong>Beneficiarios Atendidos</strong><br>" . $dato['BENEFICIARIOS']."</center>";
  $return .= "</div>";
  $return .= "</div>";

  $return .="<table id='table_grupos_dupla_".$dato['id_dupla']."' class='table table-hover table-striped' width='50%' border='1'>";
  $return .="<thead>";
  $return .="<tr>";
  $return .="<th><center>ITEM</center></th>";
  $return .="<th><center>SDIS FAMILIAR</center></th>";
  $return .="<th><center>ICBF FAMILIAR</center></th>";
  $return .="<th><center>SDIS INSTITUCIONAL</center></th>";
  $return .="<th><center>ICBF INSTITUCIONAL</center></th>";
  $return .="<th><center>LABORATORIOS E INTERVENCIONES</center></th>";
  $return .="<th><center>TOTAL</center></th>";
  $return .="</tr>";
  $return .="</thead>";

  $return .="<tbody>";
 foreach ($dato['tablainfo'] as $gd)
  {
    $return .="<tr>";
    $return .="<td><center>". $gd['GRUPOS']."</center></td>";
    $return .="<td><center>". $gd['SDIS_FAMILIAR']."</center></td>";
    $return .="<td><center>". $gd['ICBF_FAMILIAR']."</center></td>";
    $return .="<td><center>". $gd['SDIS_INSTITUCIONAL']."</center></td>";
    $return .="<td><center>". $gd['ICBF_INSTITUCIONAL']."</center></td>";
    $return .="<td><center>". $gd['LABORATORIOS']."</center></td>";
    $return .="<td><center>". $gd['TOTAL']."</center></td>";
    $return .="</tr>";
  }

$return .="</tbody>";
$return .="</table>";


$return .="<table id='table_lugar_dupla_".$dato['id_dupla']."' class='table table-hover table-striped' width='50%' border='1'>";
$return .="<thead>";
$return .="<tr>";
$return .="<th style='background-color: #F2D7D5;'><center>Tipo Lugar</center></th>";
$return .="<th style='background-color: #FADBD8;'><center>Localidad</center></th>";
$return .="<th style='background-color: #FADBD8;'><center>Upz</center></th>";
$return .="<th style='background-color: #FADBD8;'><center>Barrio</center></th>";
$return .="<th style='background-color: #FADBD8;'><center>Lugar</center></th>";
$return .="<th style='background-color: #D1F2EB;'><center>Atenciones</center></th>";
$return .="<th style='background-color: #D1F2EB;'><center>Total Asistentes</center></th>";
$return .="<th style='background-color: #D4E6F1;'><center>De 1 mes a 3 años</center></th>";
$return .="<th style='background-color: #D4E6F1;'><center>De 4 a 6 años</center></th>";
$return .="<th style='background-color: #D4E6F1;'><center>Gestantes</center></th>";
$return .="<th style='background-color: #F6DDCC;'><center>Afro descendientes</center></th>";
$return .="<th style='background-color: #F6DDCC;'><center>ROM</center></th>";
$return .="<th style='background-color: #F6DDCC;'><center>Indígenas</center></th>";
$return .="<th style='background-color: #F6DDCC;'><center>Víctimas del Conflicto</center></th>";
$return .="<th style='background-color: #F6DDCC;'><center>Discapacidad</center></th>";
$return .="<th style='background-color: #F6DDCC;'><center>Ninguno</center></th>";
$return .="<th style='background-color: #F6DDCC;'><center>Privados de la Libertad</center></th>";
$return .="<th style='background-color: #F6DDCC;'><center>Raizales</center></th>";
$return .="<th style='background-color: #F6DDCC;'><center>Comunidad Campesina</center></th>";

$return .="</tr>";
$return .="</thead>";

$return .="<tbody>";
foreach ($dato['tablainfolugares'] as $tl)
{
  $return .="<tr>";
  $return .="<td style='background-color: #F9EBEA;'><center>". $tl['TIPO']."</center></td>";
  $return .="<td style='background-color: #FDEDEC;'><center>". $tl['Localidad']."</center></td>";
  $return .="<td style='background-color: #FDEDEC;'><center>". $tl['UPZ']."</center></td>";
  $return .="<td style='background-color: #FDEDEC;'><center>". $tl['Barrio']."</center></td>";
  $return .="<td style='background-color: #FDEDEC;'><center>". $tl['Lugar']."</center></td>";
  $return .="<td style='background-color: #E8F8F5;'><center>". $tl['EXPERIENCIA']."</center></td>";
  $return .="<td style='background-color: #E8F8F5;'><center>". $tl['ASISTENTES']."</center></td>";
  $return .="<td style='background-color: #EBF5FB;'><center>". $tl['TOTAL_DE_0_3_ANIOS_R']."</center></td>";
  $return .="<td style='background-color: #EBF5FB;'><center>". $tl['TOTAL_DE_4_6_ANIOS_R']."</center></td>";
  $return .="<td style='background-color: #EBF5FB;'><center>". $tl['GESTANTES_R']."</center></td>";
  $return .="<td style='background-color: #FBEEE6;'><center>". $tl['AFRODESCENDIENTE_R']."</center></td>";
  $return .="<td style='background-color: #FBEEE6;'><center>". $tl['ROM_R']."</center></td>";
  $return .="<td style='background-color: #FBEEE6;'><center>". $tl['INDIGENA_R']."</center></td>";
  $return .="<td style='background-color: #FBEEE6;'><center>". $tl['CONFLICTO_R']."</center></td>";
  $return .="<td style='background-color: #FBEEE6;'><center>". $tl['DISCAPACIDAD_R']."</center></td>";
  $return .="<td style='background-color: #FBEEE6;'><center>". $tl['NINGUNO_R']."</center></td>";
  $return .="<td style='background-color: #FBEEE6;'><center>". $tl['PRIVADOS_R']."</center></td>";
  $return .="<td style='background-color: #FBEEE6;'><center>". $tl['RAIZALES_R']."</center></td>";
  $return .="<td style='background-color: #FBEEE6;'><center>". $tl['CAMPESINA_R']."</center></td>";
  $return .="</tr>";
}
$return .="</tbody>";
$return .="</table>";

echo $return;
