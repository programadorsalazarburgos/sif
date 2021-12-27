<?php
$return = "";
foreach ($this->getVariables()['Etnia'] as $g){
	$return .= "<option value='". $g['FK_Value']."'>".$g['VC_Descripcion']."</option>";
}
echo $return;
