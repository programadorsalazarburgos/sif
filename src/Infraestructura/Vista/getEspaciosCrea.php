<?php
$return = "";
foreach ($this->getVariables()['espacios'] as $esp){
	$return .= "<tr>";
	$return .= "<td>".$esp['PK_Id_Salon']."</td>";
	$return .= "<td>".$esp['FK_Id_Crea']."</td>";
	$return .= "<td>".$esp['VC_Nombre']."</td>";
	$return .= "<td>".$esp['IN_Nivel']."</td>";
	$return .= "<td>".$esp['VC_Descripcion']."</td>";
	$return .= "<td>".$esp['VC_Areas_Artisticas']."</td>";
	$return .= "<td>".$esp['VC_Capacidad']."</td>";
	if ($esp['IN_Estado']==0) {
		$return .= "<td>INACTIVO</td>";
	}else{
		$return .= "<td>ACTIVO</td>";
	}
	// $return .= "<td>"."<a href='#' title='Áreas Artísticas' id='btn-areas-artisticas' class='btn btn-primary btn-sm span-areas-artisticas'; color: white' data-toggle='tooltip' ><span class='' aria-hidden='true'>AA</span></a><a href='#' title='Eliminar' id='btn-eliminar-espacio' class='btn btn-danger btn-sm a-eliminar-espacio'; color: white' data-toggle='tooltip' data-id-espacio='".$esp['PK_Id_Salon']."' data-nombre-espacio='".$esp['VC_Nombre']."'><span class='fas fa-times' aria-hidden='true'></span></a></td>";
	$return .= "<td>"."<a href='#' title='Eliminar' id='btn-eliminar-espacio' class='btn btn-danger btn-sm a-eliminar-espacio'; color: white' data-toggle='tooltip' data-id-espacio='".$esp['PK_Id_Salon']."' data-nombre-espacio='".$esp['VC_Nombre']."'><span class='fas fa-times' aria-hidden='true'></span></a></td>";
	$return .= "</tr>";
}
echo $return;