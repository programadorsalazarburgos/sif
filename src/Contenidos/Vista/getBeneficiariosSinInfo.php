<?php
$return = "";
$return .= "<table class='table table-striped table-bordered table-hover' id='tabla-beneficiarios-sin-informacion' class='display' style='width:100%'>";
$return .= "<thead>";
$return .= "<tr>";
$return .= "<th>Contenido</th>";
$return .= "<th>Fecha</th>";
$return .= "<th>Localidad</th>";
$return .= "<th>Upz</th>";
$return .= "<th>Lugar</th>";
$return .= "<th>Entidad</th>";
$return .= "<th>Barrio</th>";
$return .= "<th>Grupo</th>";
$return .= "<th>Total</th>";
$return .= "<th>Niños</th>";
$return .= "<th>Niñas</th>";
$return .= "<th>Niños 0 a 3</th>";
$return .= "<th>Niños 3 a 6</th>";
$return .= "<th>Niñas 0 a 3</th>";
$return .= "<th>Niñas 3 a 6</th>";
$return .= "<th data-toggle='popover' data-text='Mujer gestante'>MG</th>";
$return .= "<th data-toggle='popover' data-text='Afrodescendiente'>AF</th>";
$return .= "<th data-toggle='popover' data-text='Comunidad rural y campesina'>CR</th>";
$return .= "<th data-toggle='popover' data-text='Conflicto de discapacidad'>CD</th>";
$return .= "<th data-toggle='popover' data-text='Conflicto armado'>CA</th>";
$return .= "<th data-toggle='popover' data-text='Indígena'>IN</th>";
$return .= "<th data-toggle='popover' data-text='Menores privados de la libertad'>MP</th>";
$return .= "<th data-toggle='popover' data-text='Mujeres victimas de violencia'>MV</th>";
$return .= "<th data-toggle='popover' data-text='Raizal'>RZ</th>";
$return .= "<th data-toggle='popover' data-text='Rom o gitano'>RG</th>";
$return .= "<th>Soporte</th>";
$return .= "</tr>";
$return .= "</thead>";
$return .= "<tbody>";
foreach ($this->getVariables()['info'] as $i){
	$return .="<tr>";
	$return .= "<td>".$i['VC_Contenido']."</td>";
	$return .= "<td>".$i['DT_Fecha_Entrega']."</td>";
	$return .= "<td>".$i['VC_Nom_Localidad']."</td>";
	$return .= "<td>".$i['VC_Nombre_Upz']."</td>";
	$return .= "<td>".$i['VC_Nombre_Lugar']."</td>";
	$return .= "<td>".$i['Vc_Abreviatura']."</td>";
	$return .= "<td>".$i['VC_Barrio']."</td>";
	$return .= "<td>".$i['VC_Nombre_Grupo']."</td>";
	$return .= "<td>".$i['IN_Total_Beneficiarios']."</td>";
	$return .= "<td>".$i['IN_Total_Ninos']."</td>";
	$return .= "<td>".$i['IN_Total_Ninas']."</td>";
	$return .= "<td>".$i['IN_Total_Ninos_0_3']."</td>";
	$return .= "<td>".$i['IN_Total_Ninos_3_6']."</td>";
	$return .= "<td>".$i['IN_Total_Ninas_3_6']."</td>";
	$return .= "<td>".$i['IN_Total_Ninas_3_6']."</td>";
	$return .= "<td>".$i['IN_Mujeres_Gestantes']."</td>";
	$return .= "<td>".$i['IN_Afrodescendiente']."</td>";
	$return .= "<td>".$i['IN_Campesina']."</td>";
	$return .= "<td>".$i['IN_Discapacidad']."</td>";
	$return .= "<td>".$i['IN_Conflicto']."</td>";
	$return .= "<td>".$i['IN_Indigena']."</td>";
	$return .= "<td>".$i['IN_Privados']."</td>";
	$return .= "<td>".$i['IN_Victimas']."</td>";
	$return .= "<td>".$i['IN_Raizal']."</td>";
	$return .= "<td>".$i['IN_Rom']."</td>";
	$return .= "<td><center><a href='".$i['VC_Documento_Soporte']."' target='_blank'>
	<button type='button' class='btn btn-success'>
	<i class='fas fa-download'></i>
	</button>
	</a></center></td>";
	$return .="</tr>";
}
$return .= "</tbody></table>";

echo $return;
