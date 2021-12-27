<?php
$return = "";

$duplaActual = "";
$aux3 = [0,0,0];
$total = [0,0,0];

$encabezado = "<thead><tr style='background-color: #EAECEE; font-weight: bold;' class='text-center'><td>Localidad</td><td>A. Espacios no convencionales</td><td>A. Espacios adecuados</td><td>Total</td></tr></thead><tbody>";
$final_tabla="</tr></tbody></table></div></div>";

$return .='<div class="panel panel-primary">';
$return .='<div class="panel-heading"><center><h4>Meta 1: Encuentros Artísticos</h4></center></div>';
$return .='<div class="panel-body">';
$return .='<table id="table_Metas_Primera_Infancia" class="table table-striped table-bordered table-hover" width="100%">';
$return .= $encabezado;


foreach ($this->getVariables()['MetaEncuentros'] as $m){

  $cambiodupla =  $m['LOCALIDAD'];

                $aux3[0] += $m['NOCONVENIONALES'];
                $aux3[1] += $m['ADECUADOS'];
                $aux3[2] += $m['TOTAL'];

  $duplaActual = $m['LOCALIDAD'];

    if($m['LOCALIDAD'] == $cambiodupla){



  $return .="<tr>";
  $return .="	<td style='background-color: #E5E8E8'><center>". $m['LOCALIDAD']."</center></td>";
  $return .="	<td style='background-color: #7FB3D5'><center>". $m['NOCONVENIONALES']."</center></td>";
  $return .="	<td style='background-color: #85C1E9'><center>". $m['ADECUADOS']."</center></td>";
  $return .="	<td style='background-color: #2E86C1'><center><strong><font color='white' size='3'>". $m['TOTAL']."</font></strong></center></td>";
  $return .="</tr>";
}
}
if (sizeof($this->getVariables()['MetaEncuentros']) != 0){

$return .="<tr style='background-color: #2471A3; color: white;' class='text-center'>";
$return .="<td>TOTALES</td>";

for($i=0; $i<= 2; $i++){
  $return .=" <td>". $aux3[$i]."</td>";
  $total[$i] = ($total[$i] + $aux3[$i]);
   }
}
$return .= $final_tabla;

echo $return;

?>
