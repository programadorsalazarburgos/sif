    <?php
   $return = "";
  foreach ($this->getVariables()['lugares'] as $o)
	{
  if($o['IN_Estado'] == 1){
    	$return .="<tr style='background-color:  #ABEBC6;'>";
    	$return .="	<td>". $o['VC_Nom_Localidad']."</td>";
    	$return .="	<td>". $o['VC_Nombre_Upz']."</td>";
    	$return .="	<td>". $o['VC_Barrio']."</td>";
      $return .="	<td>". $o['Vc_Nom_Entidad']."</td>";
      $return .="	<td>". $o['Vc_Descripcion']."</td>";
      $return .="	<td>". $o['VC_Nombre_Lugar']."</td>";
      $return .="	<td>". $o['VC_Direccion']."</td>";
      $return .="	<td>". $o['VC_Telefono']."</td>";
      $return .="	<td>". $o['VC_Coordinador']."</td>";
      $return .="	<td> <a href='#' class='solucionar_soporte btn btn-success btn-block' data-id_lugar='".$o['Pk_Id_lugar_atencion'] ."' data-nombre_lugar='".$o['VC_Nombre_Lugar']."'  data-toggle='modal' data-target='#miModal'>INACTIVAR</a></td>";
      $return .="</tr>";
    }else {
      $return .="<tr style='background-color:  #F2D7D5;'>";
    	$return .="	<td>". $o['VC_Nom_Localidad']."</td>";
    	$return .="	<td>". $o['VC_Nombre_Upz']."</td>";
    	$return .="	<td>". $o['VC_Barrio']."</td>";
      $return .="	<td>". $o['Vc_Nom_Entidad']."</td>";
      $return .="	<td>". $o['Vc_Descripcion']."</td>";
      $return .="	<td>". $o['VC_Nombre_Lugar']."</td>";
      $return .="	<td>". $o['VC_Direccion']."</td>";
      $return .="	<td>". $o['VC_Telefono']."</td>";
      $return .="	<td>". $o['VC_Coordinador']."</td>";
      $return .="	<td> <a href='#' class='modificar_lugar_div btn btn-danger btn-block' data-id_lugar='".$o['Pk_Id_lugar_atencion'] ."' data-nombre_lugar='".$o['VC_Nombre_Lugar']."' data-barrio='".$o['VC_Barrio']."' data-entidad='".$o['Vc_Nom_Entidad']."' data-tipo='".$o['Vc_Descripcion']."' data-direccion='".$o['VC_Direccion']."' data-telefono='".$o['VC_Telefono']."'
      data-coordinador='".$o['VC_Coordinador']."' data-email='".$o['VC_Email']."' data-celular='".$o['VC_Celular']."' data-id_entidad='".$o['Fk_Id_Entidad']."' data-id_tipolugar='".$o['VC_Tipo_Lugar']."' data-id_localidad='".$o['Fk_Id_Localidad']."' data-id_upz='".$o['Fk_Id_Upz']."' data-toggle='modal' data-target='#miModalActivacion'>ACTIVAR</a></td>";
      $return .="</tr>";
    }
}
    echo $return;
?>
