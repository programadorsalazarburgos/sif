<?php
	$return = "";
	$programa = explode(" ", $this->getVariables()['programa'])[1];
	$return .="<optgroup label=".$programa.">";
	foreach ($this->getVariables()['perfiles'] as $p)
	{
    	$return .="	<option value='". $p['FK_Value']."'>".$p['VC_Descripcion']."</option>";
    }
    $return .="</optgroup>";
    echo $return;
?>