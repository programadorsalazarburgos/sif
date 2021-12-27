<?php
$return = "";
$dato = $this->getVariables();
$detalle = $dato['detalle'][0];
$return .= "<h4><ins>Responsable del Evento: ".$detalle['organizador']."</ins></h4>";
$return .= "<h3>Datos Basicos</h3>";
$return .= "<table class='table table-bordered'>";
$return .= "<tr>";
$return .= "<th>Nombre</th>";
$return .= "<th>Fecha de Inicio</th>";
$return .= "<th>Fecha de Fin</th>";
$return .= "<th>Objetivo</th>";
$return .= "<th>Observaciones</th>";
$return .= "<th>Publico Esperado</th>";
$return .= "<th>Estado</th>";
$return .= "</tr>";
$return .= "<tr>";
$return .= "<td>".$detalle['VC_Nombre']."</td>";
$return .= "<td>".$detalle['DT_Fecha_Inicio']."</td>";
$return .= "<td>".$detalle['DT_Fecha_Fin']."</td>";
$return .= "<td>".$detalle['VC_Objetivo']."</td>";
$return .= "<td>".$detalle['VC_Observaciones']."</td>";
$return .= "<td>".$detalle['IN_publico_asistente']."</td>";
if ($detalle['estado_evento']) 
{
	$return .= '<td class="alert alert-warning">Activo</td>';
}
else
{
	$return .= '<td class="alert alert-danger">Finalizado</td>';
}
$return .= "</tr>";
$return .= "</table>";

$multiple = $dato['datos_multiples'];
$return .= "<h3>Datos multiples</h3>";
$return .= "<table class='table table-bordered'>";
$return .= "<tr>";
$return .= "<th>Crea(s)</th>";
$return .= "<th>Area(s) Artistica(s)</th>";
$return .= "<th>Artista(s) Formador(es)</th>";
$return .= "</tr>";
$return .= "<tr>";
$return .= "<td>";
foreach ($multiple['crea'] as $c) {
	$return .= $c['VC_Nom_Clan']."<br />";
}
$return .= "</td><td>";
foreach ($multiple['area_artistica'] as $a) {
	$return .= $a['VC_Nom_Area']."<br />";
}
$return .= "</td><td>";
foreach ($multiple['artista_formador'] as $a) {
	$return .= $a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido']." ".$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']."<br />";
}
$return .= "</td></tr>";
$return .= "</table>";

$recurso = $dato['recursos_insumos'][0];
$return .= "<h3>Recursos e insumos</h3>";
$return .= "<table class='table table-bordered'>";
$return .= "<tr>";
$return .= "<th>Transporte</th>";
$return .= "<th>Tecnica Producción</th>";
$return .= "<th>Vestuario</th>";
$return .= "<th>Escenografia</th>";
$return .= "<th>Maquillaje</th>";
$return .= "<th>Alimentación</th>";
$return .= "<th>Comunicaciones</th>";
$return .= "</tr>";
$return .= "<tr>";
$return .= "<td>".$recurso['VC_transporte']."</td>";
$return .= "<td>".$recurso['VC_tecnica_produccion']."</td>";
$return .= "<td>".$recurso['VC_vestuario']."</td>";
$return .= "<td>".$recurso['VC_escenografia']."</td>";
$return .= "<td>".$recurso['VC_maquillaje']."</td>";
$return .= "<td>".$recurso['VC_alimentacion']."</td>";
$return .= "<td>".$recurso['VC_comunicaciones']."</td>";
$return .= "</tr>";
$return .= "</table>";

echo $return;