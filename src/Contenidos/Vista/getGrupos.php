<?php
$return = "";
foreach ($this->getVariables()['grupos'] as $g){
	$return .= "<option value='".$g['Pk_Id_Grupo']."'>".$g['VC_Nombre_Grupo']."</option>";
}
echo $return;