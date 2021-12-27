    <?php 
   $return = "";
    foreach ($this->getVariables()['lugaresP'] as $l)
	{
    	$return .="<tr>";
    	$return .="	<td><center>". $l['Localidad']."</center></td>";
    	$return .="	<td><center>". $l['Upz']."</center></td>";
    	$return .="	<td><center>". $l['Barrio']."</center></td>";
      $return .="	<td><center>". $l['Lugar']."</center></td>";
      $return .="	<td><center> <a href='#' class='solucionar_soporte btn btn-danger' data-id_lugar='".$l['IdLugar'] ."' data-nombre_lugar='".$l['Lugar']."'  data-toggle='modal' data-target='#miModal'>Inactivar</a></center></td>";
      $return .="</tr>";
    }
    echo $return;
?>
