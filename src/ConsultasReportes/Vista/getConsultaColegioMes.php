<?php

$return = "";
$datos = $this->getVariables()['datos'];
if (sizeof($datos)==0)
  die("No se encontraron coincidencias en la busqueda");
$encabezado = explode(',',$datos[0]['clases']); 
 
  $return .= "<table class='table table-hover' id='table_asistencia' style='width: 100%'> 
<thead> 
  <th>documento</th> 
  <th>nombre_estudiante</th> 
  <th>grado</th> 
  <th>organizacion</th> 
  <th>nombre_artista</th> 
  <th>area</th> 
  <th>crea</th>                     
  <th>lugar_atencion</th> 
  <th>Colegio</th>
  <th>Grupo</th>";
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
	<td>".$g['grado']."</td>
	<td>".$g['organizacion']."</td>
	<td>".$g['nombre_artista']."</td>
	<td>".$g['area']."</td>
	<td>".$g['crea']."</td>										
    <td>".$g['lugar_atencion']."</td>
    <td>".$g['colegio']."</td> 
    <td>".$g['grupo']."</td>"; 
  //$dias = ($g['asistencias'] == null) ? array() : explode(',',$g['asistencias']);   
  //$noDias = ($g['asistencias'] == null) ? array() : explode(',',$g['noasistencias']);   
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

  if(is_null($g['asistencias']))
    $tDias=0;
  else
    $tDias=sizeof($dias);
  if(is_null($g['noasistencias']))
    $tNoDias=0;  
  else
    $tNoDias=sizeof($noDias);

  $totalprogramado=$tDias+$tNoDias;
  $promedio=round(($tDias/$totalprogramado)*100,2);
  $return .= "<td>".$tDias."</td>"; 
  $return .= "<td>".$tNoDias."</td>"; 
  $return .= "<td>".$promedio."</td>";                
$return .= "</tr>"; 
} 
echo $return."</tbody></table>";