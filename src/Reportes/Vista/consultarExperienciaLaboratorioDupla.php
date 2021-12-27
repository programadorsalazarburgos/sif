    <?php
   $return = "";
  foreach ($this->getVariables()['lugares'] as $o)
	{
    	$return .="<tr >";
    	$return .="	<td>". $o['LUGAR']."</td>";
      $return .="	<td><center><b>". $o['CANTIDAD']."</b></center></td>";
      if ($o['SOPORTE'] == NULL) {
        $return .="<td><center>
		<button type='button' class='btn btn-primary imagen subir-imagen' >No hay listado</button></center></td>";
      }else{
        $return .="<td><center>		
        <a href='".$o['SOPORTE']."' target='_blank'>
        <button type='button' class='btn btn-success imagen' 
        data-id-beneficiario=".$o['SOPORTE'].">
          Descargar listado
        </button>
        </a></center></td>";
      } 
      $return .="</tr>";
}
    echo $return;
?>
