<?php

$datos = $this->getVariables()['datos'];
if (sizeof($datos)==0)
	die("No se encontraron resultados en la búsqueda.");

$return = "<table class='table table-hover' id='table_aliados_beneficiarios' style='width: 100%'> 
<thead> 
<th style='text-align:center'>ALIADO</th> 
<th style='text-align:center'>BENEFICIARIOS</th> 
<th style='text-align:center'>SESIONES</th>
</thead><tbody>";
foreach ($this->getVariables()['datos'] as $row) {
	$return .= "
	<tr>
	<td style='text-align:center'>".$row['ALIADO']."</td>
	<td data-id-aliado='".$row['ID_ALIADO']."' class='beneficiario-button' style='text-align:center'><a class='btn btn-success'>".$row['BENEFICIARIOS']."</a></td>
	<td style='text-align:center'>".$row['SESIONES']."</td>";
}
echo $return."</tbody></table>";