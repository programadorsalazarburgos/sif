<?php

$return = "";
foreach ($this->getVariables()['grupos'] as $g) {
	$return .= 
"<tr>
	<td>".$g['Grupo']."</td>
	<td>".$g['Clan']."</td>
	<td>".$g['Area']."</td>
	<td>".$g['lugar_atencion']."</td>
	<td>".$g['tipo_poblacion']."</td>
	<td>".$g['Organizacion']."</td>
	<td>".$g['AF']."</td>
	<td>".$g['Fecha Creación']."</td>							
	<td>".$g['Estado']."</td>					
	<td>".$g['Fecha Cierre']."</td>							
	<td>".$g['N° Estudiantes']."</td>
	<td>".$g['Enero']."</td>
	<td>".$g['Febrero']."</td>
	<td>".$g['Marzo']."</td>
	<td>".$g['Abril']."</td>
	<td>".$g['Mayo']."</td>
	<td>".$g['Junio']."</td>
	<td>".$g['Julio']."</td>
	<td>".$g['Agosto']."</td>
	<td>".$g['Septiembre']."</td>
	<td>".$g['Octubre']."</td>
	<td>".$g['Noviembre']."</td>
	<td>".$g['Diciembre']."</td>																	
</tr>
"; 
}
echo $return;

