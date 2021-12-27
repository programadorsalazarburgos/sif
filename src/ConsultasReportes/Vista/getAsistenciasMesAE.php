<?php

$return = "";

$encabezado=$this->getVariables()['grupos'][0];
 $return .= "<table class='table table-hover' id='table_asistencia_grupo_ae' style='width: 100%'> 
<thead>
";
$estilos = array();
foreach ($encabezado as $clave=>$valor) { 
	$class="";
	if(strstr($clave, 'Porcentaje'))
		$class="class='bg-success'";
	else if(strstr($clave, 'N° Atendidos'))
		$class="class='bg-info'";
	else if(strstr($clave, 'Total Reportados'))
		$class="class='bg-warning'";
  $estilos[]=$class;
  $return .= "<th ".$class.">"; 
  $return .= $clave;    
  $return .= "</th>
  "; 
}   
$return .= "
</thead>
<tbody>
"; 

foreach ($this->getVariables()['grupos'] as $clave=>$fila) {
	$return .= "<tr>
	";	 
	$i=0;
	foreach ($fila as $clave => $valor) {

		$return .= "<td ".$estilos[$i].">".$valor."</td>
		"; 
		$i++;    
	}
	$return .= "</tr>
	";
}
echo $return."
</tbody>
</table>"; 