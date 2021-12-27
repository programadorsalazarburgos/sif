<?php
$return = "";
foreach ($this->getVariables()['modalidad'] as $m) {
	$return .= "<option value='".$m['PK_Id_Modalidad']."'>".$m['VC_Nom_Modalidad']."</option>";
}
echo $return;