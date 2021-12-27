<?php
	$return = "";
	foreach ($this->getVariables()['organizacion'] as $o)
	{
    	$return .= "<tr>";
    	$return .= "<td>AE-".$o['FK_grupo']."</td>";
    	$return .= "<td>".$o['VC_Nom_Clan']."</td>";
    	$return .= "<td>".$o['DT_fecha_asignacion_grupo']."</td>";
    	$return .= "<td>".$o['quien_asigno']."</td>";
    	$return .= "</tr>";
    }
    echo $return;
?>
