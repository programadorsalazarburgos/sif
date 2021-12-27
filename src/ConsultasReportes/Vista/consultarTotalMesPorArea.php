<?php

$return = "";
$datos = $this->getVariables()['areas'];

if (sizeof($datos)==0)
  die("No se encontraron coincidencias en la busqueda");


$titulos =array();
foreach ($datos[0] as $key => $value) {
    $titulos[$key]=$key;
}
 
  $return .= "<table class='table table-hover' id='table_total_area' style='width: 100%'>  
<thead>";
  foreach ($titulos as $titulo) {
    $return .= "<th>".ucwords(str_replace('_',' ',str_replace('-',' ',$titulo)))."</th>"; 
  }
$return .= "</thead><tbody>"; 
$total=0;
foreach ($datos as $g) {
  $return .= "
  <tr>";
  $total+=$g['total'];
  foreach ($titulos as $titulo) {
    $return .= "<td>".$g[$titulo]."</td>";      
  } 
  $return .= "</tr>";
}           

$return .= "
  <tr>"; 
foreach ($titulos as $titulo) {
  if($titulo=='colegio')
    $return .= "<td><strong>Total:</strong></td>";     
  else if($titulo=='total')
    $return .= "<td><strong>".$total."</strong></td>"; 
  else 
    $return .= "<td></td>"; 
}  
$return .= "
</tr>";    
echo $return."
</tbody>
</table>";