<?php

$datos = $this->getVariables()['datos'];
if (sizeof($datos)==0)
	die("No se encontraron resultados en la búsqueda.");

$return = "";
foreach ($this->getVariables()['datos'] as $row) {
	$return .= "<tr>
	<td style='text-align:center'>".$row['PLACA']."</td>
	<td style='text-align:center'>".$row['DESCRIPCION']."</td>
	<td style='text-align:center'>".$row['CANTIDAD']."</td>
	<td style='text-align:center'>".$row['ARGUMENTO']."</td>
	<td style='text-align:center'>".$row['ORIGEN']."</td>
	<td style='text-align:center'>".$row['DESTINO']."</td>
	<td style='text-align:center'>".$row['TIPO']."</td>
	<td style='text-align:center'>".$row['SOLICITUD']."</td>
	<td style='text-align:center'>".$row['ESTADO']."</td>
	<td style='text-align:center'>".$row['TRASLADO SIF']."</td>
	<td style='text-align:center'>".$row['TRASLADO FÍSICO']."</td></tr>";
}

echo $return;