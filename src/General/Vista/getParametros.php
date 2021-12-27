<?php
$return = "";
foreach ($this->getVariables()['parametros'] as $u) {
	$return .= "<option value='".$u['PK_Id_Parametro']."'>".$u['VC_Nombre']."</option>";
}
echo $return;