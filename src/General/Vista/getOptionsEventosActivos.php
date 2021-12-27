<?php

$return = "";
foreach ($this->getVariables()['evento'] as $e) {
	$return .= "<option value='".$e['PK_Id_Evento']."' data-tipo_evento='".$e['FK_Tipo_Evento']."'>".strtoupper($e['VC_Nombre'])."</option>";
}
echo $return;