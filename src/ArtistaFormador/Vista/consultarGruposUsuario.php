<?php
$return = "<optgroup label='".$this->getVariables()['tipo_grupo_texto']."'>";
foreach ($this->getVariables()['grupo'] as $g) {
	$return .= "<option data-tipo_grupo='".$this->getVariables()['tipo_grupo']."' data-crea='".$g['FK_clan']."' data-id_organizacion='".$g['FK_organizacion']."' data-tipo_ubicacion='".$g['tipo_ubicacion']."' value='".$g['PK_Grupo']."'>".$this->getVariables()['tipo_grupo_acronimo']."-".$g['PK_Grupo']."</grupo>";
}
$return .= "</optgroup>";
echo $return;