<?php
	$return = "";
	foreach ($this->getVariables()['organizacion'] as $o)
	{
    	$return .= "<tr>";
    	$return .= "<td>AE-".$o['FK_grupo']."</td>";
    	$return .= "<td>".$o['VC_Nom_Clan']."</td>";
    	$return .= "<td>".$o['VC_Nom_Colegio']."</td>";
    	$return .= "<td>".$o['artista_formador']."</td>";
    	$return .= "<td>".$o['estado']."</td>";
    	$return .= "<td>".$o['DT_fecha_cierre']."</td>";
    	$return .= "<td>".$o['DT_fecha_asignacion_grupo']."</td>";
    	$return .= "<td>".$o['quien_asigno']."</td>";
    	$return .= "</tr>";
    }
    echo $return;
?>
