<?php

$return = "";
$datos = $this->getVariables()['datos'];

//echo "<pre>".print_r($datos,true)."</pre>"; 

$idTabla=$this->getVariables()['idTabla'];
if (sizeof($datos)==0)
  die("No se encontraron coincidencias en la busqueda");


$titulos =array();
foreach ($datos[0] as $key => $value) {
  $titulos[$key]=$key;
}

$return .= " 
<table class='table table-hover' id='".$idTabla."' style='width: 100%'> 
	<thead>
		<th>Numeral</th>
		<th>Titulo</th>
		<th>Editar</th>
	</thead>
	<tbody>"; 



foreach ($this->getVariables()['datos'] as $g) {
  $g['TX_sql']=str_replace("'", "\"", $g['TX_sql']);
	$return .= "
  		<tr>
  			<td>".$g['VC_numeral']."</td>
  			<td>".$g['VC_titulo']."</td>
  			<td><a class='btn btn-success BT_editar' data-indicador='".json_encode($g)."'>
  					<i class='fas fa-pen-square'></i>
  				</a>
  			</td> 
  		</tr>";  
  					


  					// data-PK_id_centro_monitoreo='".$g['PK_id_centro_monitoreo']."'
  					// data-VC_numeral='".$g['VC_numeral']."'
  					// data-VC_titulo='".$g['VC_titulo']."'
  					// data-TX_descripcion='".$g['TX_descripcion']."'
  					// data-IN_seccion='".$g['IN_seccion']."'
  					// data-FK_tipo_indicador='".$g['FK_tipo_indicador']."'


 
}
  
echo $return."
	</tbody>
</table>";