<?php
$return = "";
foreach ($this->getVariables()['TDocumento'] as $t){
	$return .= "<option value='". $t['FK_Value']."'>".$t['VC_Descripcion']."</option>";
}
echo $return;