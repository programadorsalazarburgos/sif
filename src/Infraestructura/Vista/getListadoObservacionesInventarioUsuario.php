<?php

$datos = $this->getVariables()['datos'];
if (sizeof($datos)==0)
	die("No se encontraron resultados en la búsqueda.");

$return = "";
foreach ($this->getVariables()['datos'] as $row) {
	$return .= "<tr>
	<td style='text-align:center'>".$row['CREA']."</td>
	<td style='text-align:center'>".$row['PLACA']."</td>
	<td style='text-align:center'>".$row['ELEMENTO']."</td>
	<td style='text-align:center'>".$row['DESCRIPCION']."</td>
	<td style='text-align:center'>".$row['OBSERVACION']."</td>
	<td style='text-align:center'>".$row['FECHA']."</td>
	<td style='text-align:center'>".$row['ESTADO']."</td></tr>";
}

echo $return;