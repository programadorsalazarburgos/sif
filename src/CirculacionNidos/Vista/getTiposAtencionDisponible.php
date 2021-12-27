<?php
$return = "";
foreach ($this->getVariables()['atenciones'] as $a){
	$return .= $a['Id'] == 1 ? "<option value='". $a['Id']."'>Cuento y Poesía</option>" : "<option value='". $a['Id']."'>Canto</option>";
}
echo $return;