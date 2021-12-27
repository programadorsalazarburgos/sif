<?php

$return = "";
foreach ($this->getVariables()['colegio'] as $c) {
	$return .= "<option class='option' value='".$c['PK_Id_Colegio']."'>".$c['VC_Nom_Colegio']."</option>";
}
echo $return;