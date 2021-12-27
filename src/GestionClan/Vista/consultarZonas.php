<?php
$return = "";
foreach ($this->getVariables()['zona'] as $z) {
	$return .= "<option value='".$z['PK_Id_Zona']."'>".$z['VC_Nombre_Zona']."(".$z['VC_Localidades'].")</option>";
}
echo $return;