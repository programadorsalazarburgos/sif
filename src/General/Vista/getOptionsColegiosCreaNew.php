<?php
	$return = "";
	$return .= "<option value='0' data-subtext='Emprende CREA/Laboratorio CREA'>No Aplica</option>";
	//$muestraDane=$this->getVariables()['muestraDane']; 
	foreach ($this->getVariables()['colegios'] as $g)
	{ 
	      $value=$g['id_Colegio'];     
	      $return .="  <option value='".$value."'>".$g['nombre_Colegio']."</option>"; 
    }
    echo $return; 
?>