<?php

$return = "";
foreach ($this->getVariables()['grupos'] as $g) {
	$return .= "
<tr>
	<td>".$g['Grupo']."</td>
	<td>".$g['Crea']."</td>
	<td>".$g['AF']."</td>
	<td>".$g['Novedad']."</td>									
	<td>".$g['Fecha_Sesion']."</td>
	<td>".$g['Asistencia']."</td>
	<td>".$g['Observacion']."</td>
	<td>".$g['Area']."</td>
	<td>".$g['Tipo_Grupo']."</td>
	<td>".$g['Modalidad']."</td>
	<td>".$g['Organizacion']."</td>								
	<td>".$g['Fecha_Creacion_Grupo']."</td>									
	<td>".$g['Estado']."</td>							
	<td>".$g['Fecha_Cierre']."</td>								
</tr>
";
}
echo $return;