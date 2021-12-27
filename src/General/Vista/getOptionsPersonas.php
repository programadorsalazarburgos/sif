<?php
	$return = "";
	foreach ($this->getVariables()['datos'] as $d)
	{
    	$return .="	<option value='". $d['PK_Id_Persona']."' data-cargo='".$d['VC_Cargo']."' >".$d['Nombre']."</option>";
    }
    echo $return;
?>