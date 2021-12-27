<?php

$return = "";
foreach ($this->getVariables()['artistas'] as $c) {
	$return .= "<option value='".$c['PK_Id_Persona']."'>".$c['NOMBRE']."</option>";
}
echo $return; 