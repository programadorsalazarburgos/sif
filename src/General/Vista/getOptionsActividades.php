<?php

$return = "";
foreach ($this->getVariables()['actividades'] as $c) {
	$return .= "<option value='".$c['VC_Page']."'>".$c['VC_Nom_Actividad']."</option>";
}
echo $return;