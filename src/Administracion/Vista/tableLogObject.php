<?php
    $return="";
foreach ($this->getVariables()['objeto'] as $l) {
  $antes = json_decode($l['antes'],true);
  $mostrar_antes = "";
  if(json_last_error() != 0){
    $mostrar_antes = $l['antes'];
  }else{
    if (!empty($antes)){
      foreach ($antes as $key => $value) {
        $mostrar_antes .= "<b>".$key."</b>"." => ".$value."<br>";
      }
    }
  }
  $ahora = json_decode($l['ahora'],true);
  $mostrar_ahora = "";
  if (json_last_error() != 0){
    $mostrar_ahora = $l['ahora'];
  }else{
    if(!empty($ahora)){
      foreach ($ahora as $key => $value) {
        $mostrar_ahora .= "<b>".$key."</b>"." => ".$value."<br>";
      }
    }
  }
  $return .= "<tr>";
    $return .= "<td>".$l['tabla']."</td>";
    $return .= "<td class='bg-info'>".$mostrar_antes."</td>";
    $return .= "<td class='bg-success'>".$mostrar_ahora."</td>";
    $return .= "<td>".$l['fecha']."</td>";
    $return .= "<td>".$l['VC_Primer_Nombre']." ".$l['VC_Segundo_Nombre']." ".$l['VC_Primer_Apellido']." ".$l['VC_Segundo_Apellido']."</td>";
  $return .= "</tr>";
}
echo $return;
