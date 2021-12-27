<?php
	$return = "";
	$mes = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
	foreach ($this->getVariables()['meses'] as $m)
	{
    	$return .="	<option value='". $m['mes']."'>".$mes[$m['mes']-1]."</option>";
    }   
    echo $return;
?>