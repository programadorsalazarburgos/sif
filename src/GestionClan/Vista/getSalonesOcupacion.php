<?php
$return = "";
foreach ($this->getVariables()['salones'] as $s){
	$return .= "<tr>";
	$return .= "<td>".$s['VC_Nombre']."</td>";
	$return .= "<td>".$s['IN_Nivel']."</td>";
	$return .= "<td>".$s['VC_Capacidad']."</td>";
	$return .= "<td>Cifra Porcentaje</td>";
	$return .= "</tr>";
}
echo $return;