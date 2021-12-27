<?php
$return = "";
foreach ($this->getVariables()['nombre'] as $c) {
	$return .= $c['Vc_Nom_Territorio'];
}
echo $return;
