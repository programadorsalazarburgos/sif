<?php
$return = "";
foreach ($this->getVariables()['lugar_atencion'] as $l) {
	$return .= "<option value='".$l['PK_lugar_atencion']."'>".$l['VC_Nombre_Lugar']."</option>";
}
echo $return;