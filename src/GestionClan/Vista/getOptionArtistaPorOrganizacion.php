<?php
$return = "<option value='0'></option>";
foreach ($this->getVariables()['artista_formador'] as $a) {
	$return .= "<option value='".$a['PK_Id_Persona']."'>".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido']." ".$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']."</option>";
}
echo $return;