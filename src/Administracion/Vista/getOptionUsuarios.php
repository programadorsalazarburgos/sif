<?php

$return = "";
foreach ($this->getVariables()['usuario'] as $e) {
	$return .= "<option value='".$e['PK_Id_Persona']."'>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']." ".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']." - ".$e['VC_Identificacion']."</option>";
}
echo $return;
