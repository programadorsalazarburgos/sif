<?php
$i=1;
$return = "";
foreach ($this->getVariables()['Grupos'] as $o)
{
    	$return .="<tr>";
      $return .="<td><center>". $o['Pk_Id_Grupo']."</center></td>";
      $return .="<td><center>". $o['Vc_Estrategia']."</center></td>";
      $return .="<td><center>". $o['VC_Nombre_Lugar']."</center></td>";
      $return .="<td><center>". $o['VC_Nombre_Grupo']."</center></td>";
      $return .="<td><center><input data-width='70%' id='checkbox_".$i."' data-toggle='toggle' data-onstyle='success' name='CH_grupos_dupla' data-offstyle='danger' data-on='CAMBIAR DUPLA' data-off='NO CAMBIAR' type='checkbox' data-idgrupo='".$o['Pk_Id_Grupo'] ."' data-lugar='".$o['VC_Nombre_Lugar']."' data-nomgrupo='".$o['VC_Nombre_Grupo']."' class='cambiar_grupo' data-target='#miModalCambiarGrupo'></center></td>";
      $return .="</tr>";
      $i++;
    }
    echo $return;
?>
