<?php

$return = "";
$datos = $this->getVariables()['datos'];

//echo "<pre>".print_r($datos,true)."</pre>"; 

$idTabla=$this->getVariables()['idTabla'];
if (sizeof($datos)==0)
  die("No se encontraron coincidencias en la busqueda");


$titulos =array();
foreach ($datos[0] as $key => $value) {
  $titulos[$key]=$key;
}

$return .= "<table class='table table-hover' id='".$idTabla."' style='width: 100%'> 
<thead>";
foreach ($titulos as $titulo) {
  $return .= "<th>".ucwords(str_replace('_',' ',str_replace('-',' ',$titulo)))."</th>"; 
} 
$return .= "</thead><tbody>"; 
foreach ($this->getVariables()['datos'] as $g) {
	$return .= "
  <tr>";

  foreach ($titulos as $titulo) {
    $return .= "<td>".$g[$titulo]."</td>";      
  } 
  $return .= "</tr>";   
}
  
echo $return."</tbody></table>";