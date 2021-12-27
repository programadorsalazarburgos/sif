<?php
$return = "";
if($this->getVariables()['Consulta'] == '1'){
  foreach ($this->getVariables()['Beneficiarios'] as $o)
  {
    $return .="<tr>";
    $return .="<td><center>". $o['VC_Identificacion']."</center></td>";
    $return .="<td><center>". $o['Beneficiario']."</center></td>";
    $return .="<td><center>". $o['DD_F_Nacimiento']."</center></td>";
    $return .="<td><center>". $o['GENERO']."</center></td>";
    $return .="<td><center>". $o['ETNIA']."</center></td>";
    $return .="<td><center>". $o['IN_Estrato']."</center></td>";
    if  ($o['IN_Estado'] == '1')   {
      // <input class='registrar_asistencia' data-toggle='toggle' data-onstyle='success' name='CH_asistencia_beneficiario' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' data-id_beneficiario='".$b['IDBENEFICIARIO']."' data-id_experiencia='".$b['IDEXPERIENCIA']."'>
      $return .="<center><td><input class='Activar_beneficiario' data-toggle='toggle' data-width='100%' data-onstyle='success' data-offstyle='danger' data-on='Activar' data-off='Inactivar' type='checkbox' data-beneficiario='".$o['Beneficiario'] ."' data-grupo='".$o['VC_Nombre_Grupo']."' data-idbeneficiario='".$o['Pk_Id_Benefi_Grupo']."'></td></center>";
      // $return .="<td><a href='#' class='Inactivar_beneficiario btn btn-danger btn-block' data-beneficiario='".$o['Beneficiario'] ."' data-grupo='".$o['VC_Nombre_Grupo']."' data-idbeneficiario='".$o['Pk_Id_Benefi_Grupo']."' data-toggle='modal' data-target='#miModalInactivar'>INACTIVAR</a></td>";
    } else {
      $return .="<center><td><input class='Inactivar_beneficiario' data-toggle='toggle' data-width='100%' checked data-onstyle='success' data-offstyle='danger' data-on='Activar' data-off='Inactivar' type='checkbox' data-beneficiario='".$o['Beneficiario'] ."' data-grupo='".$o['VC_Nombre_Grupo']."' data-idbeneficiario='".$o['Pk_Id_Benefi_Grupo']."'></td></center>";
      // $return .="<td><a href='#' class='aActivar_beneficiario btn btn-success btn-block' data-beneficiario='".$o['Beneficiario'] ."' data-grupo='".$o['VC_Nombre_Grupo']."'  data-idbeneficiario='".$o['Pk_Id_Benefi_Grupo']."'   data-toggle='modal' data-target='#miModalActivar'>ACTIVAR</a></td>";
    }
    $return .="</tr>";
  }
}else{
  foreach ($this->getVariables()['Beneficiarios'] as $o)
  {
    $return .="<tr>";
    $return .="<td><center>". $o['VC_Identificacion']. "</center></td>";
    $return .="<td><center>". $o['Beneficiario']. "</center></td>";
    $return .="<td><center>";
    $return .= $o['IN_Estado']=='1'?"Activo":"Inactivo";
    $return .= "</center></td>";
    $return .="</tr>";
  }
}
echo $return;
