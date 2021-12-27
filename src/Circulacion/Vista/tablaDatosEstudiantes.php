<?php
$tabla = "<br>
	<table class='table table-striped table-bordered table-hover'>
		<thead><tr>
			<td><center><strong>Identificación</strong></center></td>
			<td><center><strong>Nombre</strong></center></td>
			<td><center><strong>Asignar</strong></center></td>
		</tr><thead>";
foreach ($this->getVariables()['estudiante'] as $e) {
	$tabla .= "<tr>";
	$tabla .= "<td>".$e['IN_Identificacion']."</td>";
	$tabla .= "<td>".$e['VC_Nombre']."</td>";
	$tabla .= "<td><a class='cargarDatosEstudiante' data-id_evento ='".$this->getVariables()['id_evento']."' data-id_estudiante='".$e['id']."' data-nombre_estudiante='".$e['VC_Nombre']."' href='#'>Cargar Datos</a></td>";
	$tabla .= "</tr>";
}
echo $tabla;