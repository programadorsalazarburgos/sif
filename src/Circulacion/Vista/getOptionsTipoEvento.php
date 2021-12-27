<?php
$return = "";
$id_rol = $this->getVariables()['id_rol'];
$evento = $this->getVariables()['tipo_evento'];
if($id_rol == 13){ // Si es equipo circulación
	$return .= "<optgroup label='Evento Distrital'>";
}else{
	$return .= "<optgroup label='Evento Local'>";
}
$selected = "selected='selected'";
foreach ($evento as $e) {
	if($id_rol == 13){		
		if($e['FK_Value'] == 16 || $e['FK_Value'] == 17 || $e['FK_Value'] == 18){
			$return .= "<option value='".$e['FK_Value']."' ".$selected.">".$e['VC_Descripcion']."</option>";
		}
	}else{
		if($e['FK_Value'] == 14 || $e['FK_Value'] == 15 || $e['FK_Value'] == 19){
			$return .= "<option value='".$e['FK_Value']."' ".$selected.">".$e['VC_Descripcion']."</option>";
		}
	}
	//$selected = "";
}
$return .= "</optgroup>";
echo $return;