   <?php 
   $organizacion = $this->getVariables()['organizacion'];
   $return = "";
   foreach ($this->getVariables()['usuarios_organizacion'] as $usuario)
   {
    $return .= "<tr>";
    $return .= "<td class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>".$usuario['PK_Id_Persona']."</td>";
    $return .= "<td class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>".$usuario['VC_Identificacion']."</td>";
    $return .= "<td class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>".$usuario['Nombre']."</td>";
    $return .= "<td class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>".$usuario['VC_Usuario']."</td>";
    $return .= "<td class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>".$usuario['VC_Descripcion']."</td>";

    if($usuario["IN_Estado"]=="0") { 
        $return .="<td class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Deshabilitado</td>";
    } 

    if($usuario["IN_Estado"]=="1") { 
        $return .= "<td class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Activo</td>";
    } 

    if($usuario["IN_Estado"]=="0") { 
        $return .= "<td class='col-xs-3 col-sm-3 col-md-3 col-lg-3'>";
        $return .= "<a class='btn btn-success' title='Activar' id='activacion'><span class='fa fa-thumbs-up'></span></a>";
    } 

    if($usuario["IN_Estado"]=="1") { 
        $return .= "<td class='col-xs-3 col-sm-3 col-md-3 col-lg-3'>";
        $return .= "<a class='btn btn-danger' title='Desactivar' id='desactivacion'><span class='fa fa-thumbs-down'></span></a>";
    } 
    $return .= "<a class='btn btn-primary' title='Resetear Contraseña' id='restablecer'><span class='fa fa-key'></span></a>";
    $return .= "<a class='btn btn-warning' title='Perfil' id='perfil'><span class='fa fa-check-square'></span></a>";
    if($organizacion==2) {
        $return .= "<a class='btn btn-info' title='Zona' id='zona'><span class='fa fa-map-marker'></span></a>";
    }

    $return .= "<a class='btn btn-default ver_observaciones_usuario' title='Ver observaciones' data-id_usuario='".$usuario['PK_Id_Persona']."'><span class='fa fa-eye'></span></a>";
    $return .= "</td>";
    $return .= "</tr>";
}
echo $return;
?>