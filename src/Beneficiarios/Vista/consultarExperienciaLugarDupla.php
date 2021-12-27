    <?php
   $return = "";
  foreach ($this->getVariables()['lugares'] as $o)
	{
    	$return .="<tr>";
    	$return .="	<td>". $o['LUGAR']."</td>";
      $return .="	<td><center>". $o['CANTIDAD']."</center></td>";

      if ($o['SOPORTE'] == NULL) {
        $return .="<td><center>
        <input class='TX_Listado_Asistencia' name='TX_Listado_Asistencia' type='file' runat='server' accept='.pdf'>
        <button type='button' class='btn btn-primary imagen subir-imagen' data-idlugar='".$o['IDLUGAR']."' data-dupla='".$o["IDDUPLA"]."'><i class='fas fa-save'></i>
        </button></center></td>";
      }else{
        $return .="<td><center>		
        <a href='".$o['SOPORTE']."' target='_blank'>
          <button type='button' class='btn btn-success imagen'>
            <i class='fas fa-download'></i>
          </button>
        </a>
          <button type='button' class='btn btn-danger borrar' data-id-soporte='".$o['IDSOPORTE']."' data-soporte='".$o["SOPORTE"]."'>
            <i class='fas fa-trash-alt'></i>
          </button>
        </center></td>";
      } 
      $return .="</tr>";

}
    echo $return;
?>
