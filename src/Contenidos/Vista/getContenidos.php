<?php
$return = "";
foreach ($this->getVariables()['contenidos'] as $c){
	$return .= "<optgroup label=".$c["nombre_categoria"].">";
	$return .= $c["options"];
	$return .= "</optgroup>";
}

echo $return;