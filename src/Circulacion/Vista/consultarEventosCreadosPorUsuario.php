<?php
$return = "";
foreach ($this->getVariables()['evento'] as $e) {
	$return .= "<option value='".$e['PK_Id_Evento']."'>".$e['VC_Nombre']."</option>";
}
echo $return;