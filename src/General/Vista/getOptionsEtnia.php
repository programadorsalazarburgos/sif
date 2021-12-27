<?php

$return = "";
foreach ($this->getVariables()['etnia'] as $e) {
	$return .= "<option value='".$e['PK_Id_Etnia']."'>".strtoupper($e['VC_Nombre'])."</option>";
}
echo $return;