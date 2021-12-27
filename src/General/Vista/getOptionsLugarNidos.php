<?php
$return = "";
foreach ($this->getVariables()['LugarNidos'] as $c) {
	$return .= "<option value='".$c['Pk_Id_lugar_atencion']."'>".$c['VC_Nombre_Lugar']."</option>";
}
echo $return;
