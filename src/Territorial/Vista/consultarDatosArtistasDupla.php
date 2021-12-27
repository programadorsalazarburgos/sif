<?php
   $return = "";
   $return .="<tr>";
   $return .="<td><font size='4'><strong><center> IDENTIFICACIÓN </centrer></strong></font></td>";
   $return .="<td><font size='4'><strong><center> ARTISTAS DE LA DUPLA </centrer></strong></font></td>";
   $return .="<td><font size='4'><strong><center> FECHA INGRESO </centrer></strong></font></td>";
   $return .="<td><font size='4'><strong><center> FECHA RETIRO </centrer></strong></font></td>";
   $return .="<td><font size='4'><strong><center> ESTADO </centrer></strong></font></td>";
   $return .="</tr>";
 foreach ($this->getVariables()['datos_artista'] as $o){
   $return .="<tr>";
   $return .="<td><center>". $o['IDENTIFICACION']."</center></td>";
   $return .="<td><center>". $o['ARTISTA']."</center></td>";
   $return .="<td><center>". $o['INGRESO']."</center></td>";
   $return .="<td><center>". $o['RETIRO']."</center></td>";
 if  ($o['ESTADO'] == '1')   {
   $return .="<td><center><a href='#' class='Inactivar_Artista btn btn-danger btn-block' data-id_artista='".$o['IDARTISTA'] ."' data-nombre='".$o['ARTISTA']."' data-toggle='modal' data-target='#miModalInactivar'>Inactivar</a></center></td>";
} else {
   $return .="<td><center><a href='#' class='Activar_Artista btn btn-success btn-block' data-id_artista='".$o['IDARTISTA'] ."' data-nombre='".$o['ARTISTA']."'   data-toggle='modal' data-target='#miModalActivar'>Activar</a></center></td>";
}
  $return .="</tr>";
}
  echo $return;
?>
