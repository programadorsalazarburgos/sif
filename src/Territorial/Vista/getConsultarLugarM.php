<?php
$return = "";
foreach ($this->getVariables()['ConsultaLugarM'] as $ts){
	$return .= "<option value='". $ts['Pk_Id_lugar_atencion']."'>".$ts['VC_Nombre_Lugar']."</option>";
}
echo $return;
