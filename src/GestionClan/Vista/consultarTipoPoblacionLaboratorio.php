<?php
$return = "";
foreach ($this->getVariables()['tipo_poblacion'] as $t) {
	$return .= "<option value='".$t['PK_Id_Tabla']."'>".$t['VC_Nombre']."</option>";
}
echo $return;