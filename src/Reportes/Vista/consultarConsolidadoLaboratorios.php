<?php
$return = "";

$return .="<table id='table_consolidado_laboratorios' class='table table-hover table-striped' width='50%' border='1'>";
$return .="<thead>";
$return .="<tr>";
$return .="<th style='background-color: #F9EBEA;'><center>Tipo Lugar</center></th>";
$return .="<th style='background-color: #F9EBEA;'><center>Localidad</center></th>";
$return .="<th style='background-color: #F9EBEA;'><center>Lugar</center></th>";
$return .="<th style='background-color: #F9EBEA;'><center>Upz</center></th>";
$return .="<th style='background-color: #F9EBEA;'><center>Barrio</center></th>";
$return .="<th style='background-color: #F9EBEA;'><center># Encuentros</center></th>";


$return .="<th style='background-color: #ABB2B9;'><center>Gestantes</center></th>";
$return .="<th style='background-color: #ABB2B9;'><center>Total 1 mes a 3 años</center></th>";
$return .="<th style='background-color: #ABB2B9;'><center>Total 4 a 6 años</center></th>";
$return .="<th style='background-color: #EBDEF0;'><center>Niños 1 mes - 3 años</center></th>";
$return .="<th style='background-color: #EBDEF0;'><center>Niñas 1 mes - 3 años</center></th>";
$return .="<th style='background-color: #EBDEF0;'><center>Niños 4 - 6</center></th>";
$return .="<th style='background-color: #EBDEF0;'><center>Niñas 4 - 6</center></th>";



$return .="<th style='background-color: #EAECEE;'><center>Afro descendientes</center></th>";
$return .="<th style='background-color: #EAECEE;'><center>Indígenas</center></th>";
$return .="<th style='background-color: #EAECEE;'><center>Raizales</center></th>";
$return .="<th style='background-color: #EAECEE;'><center>ROM</center></th>";
$return .="<th style='background-color: #EAECEE;'><center>Comunidad Campesina</center></th>";
$return .="<th style='background-color: #EAECEE;'><center>Discapacidad</center></th>";
$return .="<th style='background-color: #EAECEE;'><center>Víctimas del Conflicto</center></th>";
$return .="<th style='background-color: #EAECEE;'><center>Privados de la Libertad</center></th>";
$return .="<th style='background-color: #EAECEE;'><center>Ninguno</center></th>";
$return .="<th style='background-color: #58D68D;'><center>TOTAL ATENCIÓN</center></th>";



$return .="</tr>";
$return .="</thead>";

$return .="<tbody>";
foreach ($this->getVariables()['laboratoriosIntervenciones'] as $li)

{
  $return .="<tr>";
  $return .="<td style='background-color: #F9EBEA;'><center>". $li['TIPO']."</center></td>";
  $return .="<td style='background-color: #F9EBEA;'><center>". $li['Localidad']."</center></td>";
  $return .="<td style='background-color: #F9EBEA;'><center>". $li['Lugar']."</center></td>";
  $return .="<td style='background-color: #F9EBEA;'><center>". $li['UPZ']."</center></td>";
  $return .="<td style='background-color: #F9EBEA;'><center>". $li['Barrio']."</center></td>";
  $return .="<td style='background-color: #FDEDEC;'><center>". $li['EXPERIENCIA']."</center></td>";

  $return .="<td style='background-color: #ABB2B9;'><center>". $li['GESTANTES_R']."</center></td>";
  $return .="<td style='background-color: #ABB2B9;'><center>". $li['TOTAL_DE_0_3_ANIOS_R']."</center></td>";
  $return .="<td style='background-color: #ABB2B9;'><center>". $li['TOTAL_DE_4_6_ANIOS_R']."</center></td>";
  $return .="<td style='background-color: #EBDEF0;'><center>". $li['NINOS_DE_0_A_3_R']."</center></td>";
  $return .="<td style='background-color: #EBDEF0;'><center>". $li['NINAS_DE_0_A_3_R']."</center></td>";
  $return .="<td style='background-color: #EBDEF0;'><center>". $li['NINOS_DE_4_A_6_R']."</center></td>";
  $return .="<td style='background-color: #EBDEF0;'><center>". $li['NINAS_DE_4_A_6_R']."</center></td>";

  $return .="<td style='background-color: #EAECEE;'><center>". $li['AFRODESCENDIENTE_R']."</center></td>";
  $return .="<td style='background-color: #EAECEE;'><center>". $li['INDIGENA_R']."</center></td>";
  $return .="<td style='background-color: #EAECEE;'><center>". $li['RAIZALES_R']."</center></td>";
  $return .="<td style='background-color: #EAECEE;'><center>". $li['ROM_R']."</center></td>";
  $return .="<td style='background-color: #EAECEE;'><center>". $li['CAMPESINA_R']."</center></td>";
  $return .="<td style='background-color: #EAECEE;'><center>". $li['DISCAPACIDAD_R']."</center></td>";
  $return .="<td style='background-color: #EAECEE;'><center>". $li['CONFLICTO_R']."</center></td>";
  $return .="<td style='background-color: #EAECEE;'><center>". $li['PRIVADOS_R']."</center></td>";
  $return .="<td style='background-color: #EAECEE;'><center>". $li['NINGUNO_R']."</center></td>";
  $return .="<td style='background-color: #58D68D;'><center>". $li['TOTAL_R']."</center></td>";
  $return .="</tr>";
}
$return .="</tbody>";
$return .="</table>";

echo $return;
