<?php
$return = "";
$actividad = $this->getVariables()['actividad'];
foreach ($this->getVariables()['inventario'] as $inv){
	$return .= "<tr>";
	$return .= "<td>".$inv['PK_Id_Inventario']."</td>";
	$return .= "<td>".$inv['FK_Id_Clan']."</td>";
	$return .= "<td>".$inv['lugar_inventario']."</td>";
	$return .= "<td>".$inv['IN_Cantidad']."</td>";
	$return .= "<td>".$inv['tipo_bien']."</td>";
	$return .= "<td>".$inv['VC_Placa']."</td>";
	$return .= "<td>".$inv['elemento']."</td>";
	$return .= "<td>".$inv['VC_Descripcion']."</td>";
	$return .= "<td>".$inv['estado']."</td>";
	$return .= "<td>".$inv['FL_Valor_Unitario_Inicial']."</td>";
	$return .= "<td>".$inv['FL_Valor_Total']."</td>";
	$return .= "<td>".$inv['VC_Donante']."</td>";
	if($inv['IN_Estado_Baja']==1){
		$option_estado = "<a href='#' title='Dar de baja' id='btn-dar-baja' class='btn btn-default btn-sm opciones dar-baja' style='background-color: rgba(185, 9, 2, 1); color: white' data-toggle='tooltip' btn-circle'><span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span></a>";
	}
	else{
		$option_estado = "<a href='#' title='Quitar Baja' id='btn-quitar-baja' class='btn btn-warning btn-sm opciones quitar-baja' style=color: white' data-toggle='tooltip' btn-circle'><span class='glyphicon glyphicon-triangle-top' aria-hidden='true'></span></a>";
	}
	if($actividad == 'consultarInventario'){
		$return .= "<td>"."<a href='#' title='Modificar' id='btn-editar' class='btn btn-default btn-sm opciones editar' style='background-color: rgba(0, 34, 109, 1); color: white' data-toggle='tooltip' ><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>".$option_estado."<a href='#' title='Traslados' id='btn-traslado' class='btn btn-warning btn-sm opciones traslado' style='background-color: rgba(45, 47, 47, 1); color: white' data-toggle='tooltip' ><span class='fa fa-truck' aria-hidden='true'></span></a>"."<a href='#' title='Observaciones' id='btn-observaciones' class='btn btn-default btn-sm opciones observaciones' style='background-color: #006100; color: white' data-toggle='tooltip' btn-circle'><span class='glyphicon glyphicon-tags' aria-hidden='true'></span></a>"."<a href='#' title='Registro Fotográfico' id='btn-registro-fotografico' class='btn btn-default btn-sm opciones registro-fotografico' style='background-color: #017975; color: white' data-toggle='tooltip' btn-circle'><span class='fa fa-camera' aria-hidden='true'></span></a>"."<div style='margin-top: 8px; margin-left: 50px;' class='material-switch pull-left' data-toggle='tooltip' title='Finalizado / Sin Finalizar' data-placement='bottom'></div>"."</td>";
	}
	if($actividad == 'traslados'){
		$return .= "<td class='opciones' id='btn-seleccionar'>"."<input data-toggle='toggle' data-onstyle='success' class='seleccionar' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_inventario='".$inv['PK_Id_Inventario']."'>";
	}
	$return .= "<td>".$inv['VC_Observacion']." - ".$inv['Observador']."</td>";
	$return .= "<td>".$inv['Creador']."</td>";
	$return .= "<td>".$inv['VC_Numero_Traslado']."</td>";
	$return .= "<td>".$inv['FK_Proyecto']."</td>";
	$return .= "<td>".$inv['tiene_registro_fotografico']."</td>";
	$return .= "<td>".$inv['Responsable']."</td>";
	$return .= "</tr>";
}
echo $return;