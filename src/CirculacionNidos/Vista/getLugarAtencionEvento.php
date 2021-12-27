<?php
$return = "";
$ids = explode(",", $this->getVariables()['instituciones'][0]["id_lugar"]);
$nombres = explode(",", $this->getVariables()['instituciones'][0]["nombre_lugar"]);

for ($i=0; $i < count($ids); $i++) { 
	if($ids[$i] != ""){
		$return .= "<option value='".$ids[$i]."''>".$nombres[$i]."</option>";
	}
}

echo $return;