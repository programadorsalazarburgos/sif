<?php

$return = "";
foreach ($this->getVariables()['planeacion'] as $p) {
	$return .= 
	"<tr>
	<td>".$p['IdSICREA']."</td>
	<td>".$p['Identificación']."</td>
	<td>".$p['NombreBeneficiario']."</td>
	<td>".$p['Grupo']."</td>
	<td>".$p['TipoGrupo']."</td>
	<td>".$p['Formador']."</td>
	<td>".$p['CREA']."</td>
	<td>".$p['Organización']."</td>
	<td>".$p['AreaArtística']."</td>
	<td>".$p['LocalidadCREA']."</td>
	<td>".$p['LocalidadColegio']."</td>
	<td>".$p['Colegio']."</td>
	<td>".$p['LugardeAtención']."</td>
	<td>".$p['Asistencias']."</td>
	<td>".$p['Edad']."</td>
	<td>".$p['Grado']."</td>
	<td>".$p['PoblacionVictimaConflicto']."</td>
	<td>".$p['TipoDiscapacidad']."</td>
	<td>".$p['Etnia']."</td>
	<td>".$p['Estrato']."</td>
	<td>".$p['TipoRegistro']."</td>
	<td>".$p['FechaRegistro']."</td>
	<td>".$p['SIMAT']."</td>
	</tr>
	"; 
}
echo $return;

