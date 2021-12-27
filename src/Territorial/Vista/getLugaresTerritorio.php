<?php
$return = "";
foreach ($this->getVariables()['total'] as $c) {
	$return .= $c['COUNT(*)'];
}
echo $return;
