<?php         
$return = "";
foreach ($this->getVariables()['programacion'] as $o)
{
	  $return .="<tr>";
	  $return .="<td style='background-color: #D6DBDF'><strong>". $o['ID']."</strong></td>";
	  $return .="<td style='background-color: #D6DBDF'><strong>". $o['DIA']."</strong></td>";
	  $return .="<td style='background-color: #D6DBDF'><strong>". $o['FECHA']."</strong></td>";
	  $return .="<td style='background-color: #D6DBDF'><strong>". $o['FRANJA']."</strong></td>";
	  $return .="<td>". $o['EVENTO']."</td>";

	  $return .="<td>". $o['LOCALIDAD']."</td>";	  
	  
	  $return .="<td>". $o['ENTIDAD']."</td>";
	  $return .="<td>". $o['SOLICITA']."</td>";
	  $return .="<td>". $o['EQUIPOSASIG']."</td>";
	  $return .="<td>". $o['MODALIDAD']."</td>";
	  $return .="<td>". $o['LUGAR']."</td>";
	  $return .="<td>". $o['UPZ']."</td>";
	  $return .="<td>". $o['BARRIO']."</td>";
	  $return .="<td>". $o['DIRECCION']."</td>";

      $return .="<td>". $o['CONTACTO_LUGAR']."</td>";
      $return .="<td>". $o['PROPUESTA']."</td>";
      $return .="<td>". $o['ACOMPANAMIENTO']."</td>";

      
      $return .="<td>". $o['LLEGADA_ARTISTAS']."</td>";
      $return .="<td>". $o['MONTAJE']."</td>";
   	  $return .="<td>". $o['MONTAJE_NIDO']."</td>";
      $return .="<td>". $o['INICIO_ATENCION']."</td>";
      $return .="<td>". $o['FINALIZACION']."</td>";  
      $return .="<td>". $o['DESMONTAJE']."</td>";
      
	  $return .="<td>". $o['UBICACION']."</td>";
	  $return .="<td>". $o['INDICACIONES']."</td>";
      $return .="<td>". $o['PARTICULARIDADES']."</td>";
	  $return .="</tr>";
} 
echo $return;
?>