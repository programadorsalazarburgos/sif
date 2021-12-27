<?php
$return = "";
$datos = $this->getVariables();
$acronimo_tipo_grupo = "NA";
switch ($datos['tipo_grupo']) {
	case 'arte_escuela':
		$acronimo_tipo_grupo = "AE";
		break;
	case 'emprende_clan':
		$acronimo_tipo_grupo = "IC";
		break;
	case 'laboratorio_clan':
		$acronimo_tipo_grupo = "CV";
		break;
	default:
		
		break;
}
foreach ($datos['grupo'] as $g) {
	$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='".$datos['tipo_grupo']."'>".$acronimo_tipo_grupo."-".$g['PK_Grupo']."</option>";
}
echo $return;