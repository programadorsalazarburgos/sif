<?php
$return = "";
foreach ($this->getVariables()['clanes'] as $c) {
	$return .= "<option value='".$c['PK_Id_Clan']."'>".$c['VC_Nom_Clan']."</option>";
}
echo $return;