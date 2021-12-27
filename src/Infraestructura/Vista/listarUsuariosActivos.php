<?php
$return = "";
foreach ($this->getVariables()['usuarios_activos'] as $usuario_activo){
	$return .= "<option value='".$usuario_activo['Id_Persona']."'>".$usuario_activo['Nombre'].' - '.$usuario_activo['Identificacion']."</option>";
}
echo $return;