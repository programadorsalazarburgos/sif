<?php
	$return = "";
	foreach ($this->getVariables()['datos'] as $d)
	{
    	$return .="	<option value='". $d['FK_Value']."'>".$d['VC_Descripcion']."</option>";
    }
    echo $return;
?>