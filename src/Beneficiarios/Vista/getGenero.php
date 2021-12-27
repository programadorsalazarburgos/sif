<?php
$return = "";
foreach ($this->getVariables()['Genero'] as $g){
	$return .= "<option value='". $g['FK_Value']."'>".$g['VC_Descripcion']."</option>";
}
echo $return;