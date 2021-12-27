<?php
$return = "";
foreach ($this->getVariables()['localidades'] as $c) {
  $return .= "<option value='".$c['Pk_Id_Localidad']."'>".$c['Pk_Id_Localidad'].'. '.$c['VC_Nom_Localidad']."</option>";
}
echo $return;
