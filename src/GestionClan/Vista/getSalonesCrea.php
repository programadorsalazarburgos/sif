<?php
$return = "";
foreach ($this->getVariables()['salones'] as $t) {
	$return .= "<option value='".$t['PK_Id_Salon']."'>".$t['VC_Nombre']."</option>";
}
echo $return;