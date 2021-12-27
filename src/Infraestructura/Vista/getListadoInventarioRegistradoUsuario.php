<?php

$datos = $this->getVariables()['datos'];
if (sizeof($datos)==0)
	die("No se encontraron resultados en la búsqueda.");

$return = "";
foreach ($this->getVariables()['datos'] as $row) {
	$return .= "<tr>
	<td style='text-align:center'>".$row['LUGAR']."</td>
	<td style='text-align:center'>".$row['TIPOBIEN']."</td>
	<td style='text-align:center'>".$row['CANTIDAD']."</td>
	<td style='text-align:center'>".$row['PLACA']."</td>
	<td style='text-align:center'>".$row['ELEMENTO']."</td>
	<td style='text-align:center'>".$row['DESCRIPCION']."</td>
	<td style='text-align:center'>".$row['REGISTRO']."</td></tr>";
}

echo $return;