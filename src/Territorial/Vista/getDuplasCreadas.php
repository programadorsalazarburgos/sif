    <?php
   $return = "";
    foreach ($this->getVariables()['duplas'] as $o)
	{
    	$return .="<tr>";
      $return .="	<td>". $o['Vc_Descripcion']."</td>";
      $return .="	<td>". $o['VC_Codigo_Dupla']."</td>";
      $return .="	<td>". $o['ARTISTAS']."</td>";
      $return .="	<td>". $o['ESTADO']."</td>";
      $return .="</tr>";
    }
    echo $return;
?>
