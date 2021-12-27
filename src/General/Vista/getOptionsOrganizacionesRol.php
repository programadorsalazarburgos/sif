<?php
	$return = "";
	foreach ($this->getVariables()['organizaciones'] as $o)
	{
    	$return .="	<option value='". $o['PK_Id_Organizacion']."'>".$o['VC_Nom_Organizacion']."</option>";
    }
    echo $return;
?>