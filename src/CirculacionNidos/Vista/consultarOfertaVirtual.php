<?php         
$return = "";
foreach ($this->getVariables()['oferta'] as $o){
	  $return .="<tr>";
	  $return .="<td><center>". $o['FORMULARIO']."</center></td>";	  	  
	  $return .="<td><center>". $o['ATENCION']."</center></td>";
	  $return .="<td><center>". $o['FECHA']."</center></td>";
	  $return .="<td><center>". $o['DIA']."</center></td>";
	  $return .="<td><center>". $o['HORAINICIO']." a ". $o['HORAFIN']."</center></td>";
	  $return .="<td><center>". $o['CUPOS']."</center></td>";
 	  $return .="<td><center>". $o['DISPONIBLES']."</center></td>";
	  $return .="<td><center><a href='#' class='editarFranja btn btn-warning' data-id-frnaja='".$o['ID']."' data-formulario='".$o['IDFORMULARIO']."' data-atencion='".$o['IDATENCION']."' data-fecha='".$o['FECHA']."' data-hora='".$o['HORAINICIO']."' data-cupos='".$o['CUPOS']."' data-disponible='".$o['DISPONIBLES']."' data-toggle='modal' data-target='#miModalEditarFranja'> <i class='fas fa-edit'></i></a></center></td>"; 
 	  $return .="</tr>";  
} 
echo $return;
?>
