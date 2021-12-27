<?php

$return = "";
$datos = $this->getVariables()['datos'];

$encabezado = explode(',',$datos[0]['clases']); 
 
  $return .= "<table class='table table-hover' id='table_asistencia' style='width: 100%'> 
<thead> 
  <th>documento</th> 
  <th>nombre estudiante</th> 
  <th>organizacion</th> 
  <th>nombre artista</th> 
  <th>area</th> 
  <th>crea</th>                     
  <th>Grupo</th>
  <th>Tipo Grupo</th>
  <th>Archivos</th>";
foreach ($encabezado as $dia) { 
  $return .= "<th>"; 
  $return .= $dia;    
  $return .= "</th>"; 
}   
$return .= "<th>Total Asistencias</th>"; 
$return .= "<th>Total Ausencias</th>"; 
$return .= "<th>Promedio</th>";  
$return .= "</thead><tbody>"; 
foreach ($this->getVariables()['datos'] as $g) {
	$return .= "
<tr>
	<td>".$g['documento']."</td>
	<td>".$g['nombre_estudiante']."</td>
	<td>".$g['organizacion']."</td>
	<td>".$g['nombre_artista']."</td>
	<td>".$g['area']."</td>
	<td>".$g['crea']."</td>										
  <td>".$g['grupo']."</td>
  <td>".$g['tipo_grupo']."</td>
  <td>".$g['archivos']."</td>"; 
  $dias=explode(',',$g['asistencias']); 
  $noDias=explode(',',$g['noasistencias']); 
  foreach ($encabezado as $dia) { 
    $return .= "<td>"; 
    if(in_array($dia, $dias)) 
      $return .="SI"; 
    else if(in_array($dia, $noDias))  
      $return .="NO"; 
    else $return .="";  
    $return .= "</td>"; 
  }
  $totalprogramado=sizeof($dias)+sizeof($noDias);
  $promedio=round((sizeof($dias)/$totalprogramado)*100,2);
  $return .= "<td>".sizeof($dias)."</td>"; 
  $return .= "<td>".sizeof($noDias)."</td>"; 
  $return .= "<td>".$promedio."</td>";                       
$return .= "</tr>"; 
} 
echo $return."</tbody></table>";