<?php
$return = "";

$encabezado = "<thead><tr style='background-color: #EAECEE; font-weight: bold;' class='text-center'><td>No. DUPLA</td><td>Lugar Atención</td><td>Grupo</td><td>Experiencia</td><td>Identificación</td><td>Nombre Beneficiario</td></tr></thead><tbody>";


$return .='<table id="table_beneficiarios_atendidos" class="table table-striped table-bordered table-hover" width="100%">';
$return .= $encabezado;


foreach ($this->getVariables()['Beneficiarios'] as $li)

{
  $return .="<tr>";
  $return .="<td style='background-color: #F9EBEA;'><center>". $li['DUPLA']."</center></td>";
  $return .="<td style='background-color: #F9EBEA;'><center>". $li['LUGAR']."</center></td>";
  $return .="<td style='background-color: #F9EBEA;'><center>". $li['GRUPO']."</center></td>";
  $return .="<td style='background-color: #F9EBEA;'><center>". $li['EXPERIENCIA']."</center></td>";
  $return .="<td style='background-color: #F9EBEA;'><center>". $li['IDENTIFICACION']."</center></td>";
  $return .="<td style='background-color: #FDEDEC;'><center>". $li['BENEFICIARIO']."</center></td>";

  $return .="</tr>";
}
$return .="</tbody>";
$return .="</table>";

echo $return;
