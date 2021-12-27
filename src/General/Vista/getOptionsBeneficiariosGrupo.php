<?php
	$return = "";
	foreach ($this->getVariables()['beneficiarios'] as $b)
	{
    	$return .="	<option value='". $b['id']."'>".$b['Nombre']."</option>";
    }
    $return .="	<option value='0'>OTRO</option>";
    echo $return;
?>