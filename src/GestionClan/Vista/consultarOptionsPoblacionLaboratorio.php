<?php
	$return = "";
	foreach ($this->getVariables()['tipo_poblacion'] as $p)
	{
    	$return .="	<option value='". $p['valor']."'>".$p['nombre']."</option>";
    }
    echo $return; 
?>