<?php
$return = "";
foreach ($this->getVariables()['aliado'] as $a) {
	$return .= "<option value='".$a['PK_Id_Aliado']."'>".$a['TX_Nombre_Aliado']."</option>";
}
echo $return;