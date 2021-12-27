<?php

$return = "";
$linea="";
if($this->getVariables()['linea'] =='arte_escuela')
	$linea="AE-";
if($this->getVariables()['linea'] =='emprende_clan')
	$linea="IC-";
if($this->getVariables()['linea'] =='laboratorio_clan')
	$linea="CV-";
foreach ($this->getVariables()['grupos'] as $c) {

	$return .= "<option value='".$c['PK_grupo']."'>".$linea.$c['PK_grupo']."</option>";
}
echo $return; 