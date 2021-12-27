<?php
$return = "";
$datos = $this->getVariables()['info_data'];
if (sizeof($datos) > 0) {

  $encabezado=array();
  foreach ($datos[0] as $clave => $valor)
  $encabezado[]=$clave;

  $return .= "<table class='table table-hover' id='tabla_info_detallada_territorios' style='width: 100%'>
  <thead>";
  foreach ($encabezado as $texto) {
    $return .= "<th>";
    $return .= $texto;
    $return .= "</th>";
  }
  $return .= "</thead><tbody>";
  foreach($datos as $d){
    $return .= "<tr>";
    foreach ($d as $key => $value)
    $return .="<td>".$value."</td>";
    $return .= "</tr>";
  }
  echo $return."</tbody></table>";
}
else {
  echo "No hay registros disponibles";
}
