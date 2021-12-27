<?php

$return = "";
$datos = $this->getVariables()['datos'];
if (sizeof($datos)==0)
	die("No se encontraron coincidencias en la busqueda");
$fechas = explode(',',$datos[0]['FECHAS']); 

$return .= "<table class='table table-hover' id='table_asistencia' style='width: 100%'> 
<thead> 
<th>GRUPO</th> 
<th style='min-width: 40vh'>CENTRO</th> 
<th>TALLER</th>
<th style='min-width: 20vh'>FORMADOR</th>
<th>HORARIO</th>";
foreach ($fechas as $dia) { 
	$return .= "<th>"; 
	$return .= setDias($dayofweek = date('w', strtotime($dia)).'- ').date("d", strtotime($dia));
	$return .= "</th>"; 
}
// $return .= "<th>Total Asistencias</th>"; 
// $return .= "<th>Total Ausencias</th>"; 
// $return .= "<th>Promedio</th>";  
$return .= "</thead><tbody>"; 
foreach ($this->getVariables()['datos'] as $g) {
	$return .= "
	<tr>
	<td>LC-".$g['GRUPO']."</td>
	<td>".$g['CENTRO']."</td>
	<td>".$g['TALLER']."</td>
	<td>".$g['FORMADOR']."</td>
	<td>".setDias($g['HORARIO'])."</td>"; 
	$clases=explode(',',$g['CLASES']);
	$asistentes=explode(',',$g['ASISTENTES']); 
	// $noDias=explode(',',$g['noasistencias']);   
	foreach ($fechas as $dia) { 
		if (date('w', strtotime($dia)) == 0) {
			$estilo = "background-color:#b7b5b5;border-style:hidden"; 
		}
		else{
			$estilo = "background-color:#b1b1b152;padding:1.1%;border-color:#737373;border-style:solid;"; 
		}
		$return .= "<td style=".$estilo.">"; 
		if(false !== $key = array_search($dia, $clases))
			$return .="<b>".$asistentes[$key]."</b>";
		// else if(in_array($dia, $noDias))  
			// $return .="NO"; 
		else $return .=""; 
		$return .= "</td>";
	}

	if(is_null($g['CLASES']))
		$tDias=0;
	else
		$tDias=sizeof($clases);

	// $totalSesiones=$tDias;
	// $promedio=$tDias/$totalSesiones)*100,2);
	// $return .= "<td>".$tDias."</td>round(("; 
	// $return .= "<td>".$tNoDias."</td>"; 
	// $return .= "<td>".$promedio."</td>";                
	// $return .= "</tr>"; 
} 
echo $return."</tbody></table>";

function setDias($horario){
	$horario = str_replace("1-", "Lunes", $horario);
	$horario = str_replace("2-", "Martes", $horario);
	$horario = str_replace("3-", "Miércoles", $horario);
	$horario = str_replace("4-", "Jueves", $horario);
	$horario = str_replace("5-", "Viernes", $horario);
	$horario = str_replace("6-", "Sábado", $horario);
	$horario = str_replace("0-", "Domingo", $horario);
	return $horario;
}