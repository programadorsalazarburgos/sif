<?php
  $dato = $this->getVariables();

  $return = "<font size='4'><center><strong>Artistas de la Dupla:" . $dato['ARTISTAS']."</strong></center></font>";
  $return .= "<br>";
  $return .= "<div class='row'>";
  $return .= "<br>";
  $return .= "<div class='total_lugares col-xs-8 col-xs-offset-2 col-md-2 col-md-offset-1 alert alert-info' role='alert'>";
  $return .= "<center><strong>Total Grupos 1</strong><br>" . $dato['total_grupos1']."</center>";
  $return .= "</div>";
  $return .= "<div class='total_duplas col-xs-8 col-xs-offset-2 col-md-2 col-md-offset-2 alert alert-success' role='alert'>";
  $return .= "<center><strong>Total atenciones 2</strong><br>" . $dato['total_experiencia']."</center>";
  $return .= "</div>";
  $return .= "<div class='total_grupos col-xs-8 col-xs-offset-2 col-md-2 col-md-offset-2 alert alert-danger' role='alert'>";
  $return .= "<center><strong>Total Beneficiarios 3</strong><br>" . $dato['total_beneficiarios']."</center>";
  $return .= "</div>";
  $return .= "</div>";

  $return .="<table id='table_grupos_dupla_".$dato['id_dupla']."' class='table table-hover table-striped' width='100%' border='1'>";
  $return .="<thead>";
  $return .="<tr>";
  $return .="<th><center>Entidad</center></th>";
  $return .="<th><center>Tipo Grupo</center></th>";
  $return .="<th><center>Lugar de atención</center></th>";
  $return .="<th><center>Nombre Grupo</center></th>";
  $return .="<th><center># Atenciones</center></th>";
  $return .="<th><center># Beneficiarios</center></th>";
  $return .="<th><center># Asistencias</center></th>";
  $return .="</tr>";
  $return .="</thead>";

  $return .="<tbody>";
 foreach ($dato['tablainfo'] as $gd)
  {
    $return .="<tr>";
    $return .="<td><center>". $gd['Vc_Nom_Entidad']."</center></td>";
    $return .="<td><center>". $gd['Vc_Descripcion']."</center></td>";
    $return .="<td><center>". $gd['VC_Nombre_Lugar']."</center></td>";
    $return .="<td><center>". $gd['VC_Nombre_Grupo']."</center></td>";
    $return .="<td><center>". $gd['EXPERIENCIA']."</center></td>";
    $return .="<td><center>". $gd['BENEFICIARIOS']."</center></td>";
    $return .="<td><center>". $gd['ASISTENCIA']."</center></td>";
    $return .="</tr>";
  }
$return .="</tbody>";
$return .="</table>";

echo $return;
