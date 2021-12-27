<?php
	$return = "";
	foreach ($this->getVariables()['jornada'] as $p)
	{
    	$return .="	<option value='". $p['VC_Descripcion']."'>".$p['VC_Descripcion']."</option>";
    }
    echo $return;
?>