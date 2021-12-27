<?php
$return = "";
foreach ($this->getVariables()['casos'] as $caso){
	$return .= "<tr>";
	$return .= "<td>".$caso['ID']."</td>";
	$return .= "<td>".$caso['CREA']."</td>";
	$return .= "<td>".$caso['BENEFICIARIO']."</td>";
	$return .= "<td>".$caso['LINEA']."</td>";
	$return .= "<td>".$caso['GRUPO']."</td>";
	$return .= "<td>".$caso['ORIGEN']."</td>";
	$return .= "<td>".$caso['USUARIO']."</td>";
	$return .= "<td>".$caso['FECHA_REGISTRO']."</td>";
	$return .= "<td><button class='BT_EDITAR' class='btn btn-success' title='Ver'><i class='fa fa-external-link-alt'></i></button></td>";
	$return .= "</tr>";
}
echo $return;