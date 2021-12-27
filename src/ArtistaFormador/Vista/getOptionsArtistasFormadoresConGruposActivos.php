<?php
$return = "";
foreach ($this->getVariables()['artista_formador'] as $a) {
	$return .= "<option value='".$a['PK_Id_Persona']."'>".$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']." ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido']."</option>";
}
echo $return;