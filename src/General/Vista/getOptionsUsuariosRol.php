<?php
//$return = "<optgroup label='".$this->getVariables()['label']."'>";
$return="";
foreach ($this->getVariables()['usuario'] as $u) {
	$return .= "<option value='".$u['PK_Id_Persona']."'>".$u['VC_Primer_Nombre'].' '.$u['VC_Segundo_Nombre'].' '.$u['VC_Primer_Apellido'].' '.$u['VC_Segundo_Apellido']."</option>";
}
//$return .= "</optgroup>";
echo $return;