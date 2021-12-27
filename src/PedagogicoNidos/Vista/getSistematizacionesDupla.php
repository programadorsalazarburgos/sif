<?php
$return = "";
$idRol = $this->getVariables()['rolId'];
foreach ($this->getVariables()['sistematizaciones'] as $s){
  if($s['EstadoPlaneacion'] == "Sin terminar"){
    if($idRol == 16){
      $return .="<tr>";
      $return .="<td>".$s['Experiencia']."</td>";
      $return .="<td>".$s['Mes']."</td>";
      $return .="<td><button type='button' class='btn btn-block btn-info' data-id-sistematizacion='".$s['IdSistematizacion']."' data-estado='editar' data-parte='planeacion'>Editar planeación</button></td>";
      $return .="<td><button type='button' class='btn btn-block btn-default' data-id-sistematizacion='".$s['IdSistematizacion']."' disabled>No disponible</button></td>";
      $return .="<td><button type='button' class='btn btn-block btn-default' data-id-sistematizacion='".$s['IdSistematizacion']."' disabled>No disponible</button></td>";
      $return .="</tr>";
    }
  }else{
    $return .="<tr>";
    $return .="<td>".$s['Experiencia'];
    if($s['TotalArtistas'] == 2){
      $return .="<div id='div-artistas-oculto'><div class='img-artista' id='img-artista-1' style='margin-left: -1000px; position: absolute;'></div>".
      "<div class='img-artista' id='img-artista-2' style='margin-left: -1000px; position: absolute;'></div></div>";
    }

    if($s['TotalArtistas'] == 3){
      $return .= "<div id='div-artistas-oculto'><div class='img-artista' id='img-artista-1' style='width: 150px; height: 150px; margin-left: -1000px; position: absolute;'></div>".
      "<div class='img-artista' id='img-artista-2' style='width: 150px; height: 150px; margin-left: -1000px; position: absolute;'></div>".
      "<div class='img-artista' id='img-artista-3' style='width: 150px; height: 150px; margin-left: -1000px; position: absolute;'></div></div>";
    }

    if($s['TotalArtistas'] == 4){
      $return .= "<div id='div-artistas-oculto'><div class='img-artista' id='img-artista-1' style='width: 110px; height: 110px; margin-left: -1000px; position: absolute;'></div>".
      "<div class='img-artista' id='img-artista-2' style='width: 110px; height: 110px; margin-left: -1000px; position: absolute;'></div>".
      "<div class='img-artista' id='img-artista-3' style='width: 110px; height: 110px; margin-left: -1000px; position: absolute;'></div>".
      "<div class='img-artista' id='img-artista-4' style='width: 110px; height: 110px; margin-left: -1000px; position: absolute;'></div></div>";
    }

    $return .= "</td>";
    $return .="<td>".$s['Mes']."</td>";
    if($s['EstadoPlaneacion'] == "Revisión pendiente"){
      if($idRol == 16){
        $return .="<td><button type='button' class='btn btn-block btn-warning' disabled>En revisión</button></td>";
      }else{
        $return .="<td><button type='button' class='btn btn-block btn-info' data-id-sistematizacion='".$s['IdSistematizacion']."' data-estado='revisar' data-parte='planeacion'>Revisar planeación</button></td>";
      }
    }
    if($s['EstadoPlaneacion'] == "Revisado con observaciones"){
      if($idRol == 16){
        $return .="<td><button type='button' class='btn btn-block btn-danger' data-id-sistematizacion='".$s['IdSistematizacion']."' data-estado='correccion' data-parte='planeacion'>Corregir planeación</button></td>";
      }else{
        $return .="<td><button type='button' class='btn btn-block btn-warning' disabled>En corrección</button></td>";
      }
    }
    if($s['EstadoPlaneacion'] == "Corregido"){
      if($idRol == 16){
        $return .="<td><button type='button' class='btn btn-block btn-warning' disabled>En revisión</button></td>";
      }else{
        $return .="<td><button type='button' class='btn btn-block btn-info' data-id-sistematizacion='".$s['IdSistematizacion']."' data-estado='revisar' data-parte='planeacion'>Revisar correcciones planeación</button></td>";
      }
    }
    if($s['EstadoPlaneacion'] == "Aprobado"){
      if($idRol == 16){
        $return .="<td><button type='button' class='btn btn-block btn-success aprobado' disabled>Planeación aprobada</button></td>";
      }else{
        $return .="<td><button type='button' class='btn btn-block btn-success aprobado' data-id-sistematizacion='".$s['IdSistematizacion']."' data-parte='planeacion'>Descargar planeación</button></td>";
      }
    }
    if($s['EstadoPlaneacion'] != "Aprobado"){
      $return .="<td><button type='button' class='btn btn-block btn-default' data-id-sistematizacion='".$s['IdSistematizacion']."' disabled>No disponible</button></td>";
      $return .="<td><button type='button' class='btn btn-block btn-default' data-id-sistematizacion='".$s['IdSistematizacion']."' disabled>No disponible</button></td>";
    }else{
      if($s['EstadoSistematizacion'] == "Sin terminar"){
        if($idRol == 16){
          $return .="<td><button type='button' class='btn btn-block btn-info' data-id-sistematizacion='".$s['IdSistematizacion']."' data-estado='editar' data-parte='sistematizacion'>Editar sistematización</button></td>";
        }else{
          $return .="<td><button type='button' class='btn btn-block btn-danger' data-id-sistematizacion='".$s['IdSistematizacion']."' disabled>Sin diligenciar</button></td>";
        }
      }
      if($s['EstadoSistematizacion'] == "Revisión pendiente"){
        if($idRol == 16){
          $return .="<td><button type='button' class='btn btn-block btn-warning' disabled>En revisión</button></td>";
        }else{
          $return .="<td><button type='button' class='btn btn-block btn-info' data-id-sistematizacion='".$s['IdSistematizacion']."' data-estado='revisar' data-parte='sistematizacion'>Revisar sistematización</button></td>";
        }
      }
      if($s['EstadoSistematizacion'] == "Revisado con observaciones"){
        if($idRol == 16){
          $return .="<td><button type='button' class='btn btn-block btn-danger' data-id-sistematizacion='".$s['IdSistematizacion']."' data-estado='correccion' data-parte='sistematizacion'>Corregir sistematización</button></td>";
        }else{
          $return .="<td><button type='button' class='btn btn-block btn-warning' disabled>En corrección</button></td>";
        }
      }
      if($s['EstadoSistematizacion'] == "Corregido"){
        if($idRol == 16){
          $return .="<td><button type='button' class='btn btn-block btn-warning' disabled>En revisión</button></td>";
        }else{
          $return .="<td><button type='button' class='btn btn-block btn-info' data-id-sistematizacion='".$s['IdSistematizacion']."' data-estado='revisar' data-parte='sistematizacion'>Revisar correcciones sistematización</button></td>";
        }
      }
      if($s['EstadoSistematizacion'] == "Aprobado"){
        $return .="<td><button type='button' class='btn btn-block btn-success aprobado' data-id-sistematizacion='".$s['IdSistematizacion']."' data-parte='sistematizacion'>Descargar sistematización</button></td>";
        $return .="<td><button type='button' class='btn btn-block btn-success images' data-id-sistematizacion='".$s['IdSistematizacion']."'>Ver</button></td>";
      }else{
        $return .="<td><button type='button' class='btn btn-block btn-default' disabled data-id-sistematizacion='".$s['IdSistematizacion']."'>No disponible</button></td>";
      }
    }
    $return .="</tr>";
  }
}
echo $return;