<?php
	$return = "";
	$return .= "<option value='0' data-subtext='Emprende CREA/Laboratorio CREA'>No Aplica</option>";
	$muestraDane=$this->getVariables()['muestraDane']; 
	foreach ($this->getVariables()['colegios'] as $g)
	{
	    if($muestraDane) 
	      $value=trim($g['VC_DANE_12']);    
	    else 
	      $value=$g['FK_Id_Colegio'];     
	      $return .="  <option value='".$value."'>".$g['VC_Nom_Colegio']."</option>"; 
    }
    echo $return; 
?>