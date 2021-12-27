<?php
$return = "";
foreach ($this->getVariables()['Upz'] as $c) {
	$return .= "<option value='".$c['Pk_Id_Upz']."'>".$c['Pk_Id_Upz'].'. '.$c['VC_Nombre_Upz']."</option>";
}
echo $return;
