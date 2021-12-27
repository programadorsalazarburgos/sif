<?php
$return = "";
foreach ($this->getVariables()['lugar_atencion'] as $l) {
	$return .= "<option value='".$l['id']."'>".$l['descripcion']."</option>";
}
echo $return;