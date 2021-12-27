<?php 
$return = "";
foreach ($this->getVariables()['grupos'] as $d)
{
if($d['IN_Estado'] == 1){
	  $return .="<tr style='background-color:  #ABEBC6;'>";
	  $return .="<td><center>". $d['Vc_Estrategia']."</center></td>";
	  $return .="<td><center>". $d['VC_Nombre_Lugar']."</center></td>";
	  $return .="<td><center>". $d['VC_Nombre_Grupo']."</center></td>";
	  $return .="<td><center>". $d['TipoGrupo']."</center></td>";
	  $return .="<td><center>". $d['NIVEL']."</center></td>";
	  $return .="<td><center>". $d['INSCRITOS']."</center></td>";	  
	  $return .="<td><center> <a href='#' class='inactivar-grupo btn btn-danger' data-id-grupo='".$d['Pk_Id_Grupo']."' data-nombre-grupo='".$d['VC_Nombre_Grupo']."' data-toggle='modal' data-target='#modalInactivacion'><span class='fa fa-thumbs-down'></span></a><a href='#' class='editar-grupo btn btn-warning' data-id-grupo='".$d['Pk_Id_Grupo']."' data-nombre-grupo='".$d['VC_Nombre_Grupo']."' data-idestrategia='".$d['IDESTRATEGIA']."' data-idlugar='".$d['IDLUGAR']."' data-idtipogrupo='".$d['IDTIPOGRUPO']."' data-idnivel='".$d['IDNIVEL']."' data-idlaboratorio='".$d['IDLUGARLABORATORIO']."' data-responsable='".$d['VC_Profesional_Responsable']."' data-toggle='modal' data-target='#modal-modificar-grupo'><span class='fa fa-edit'></span></a></center></td>";
	  	 
	  $return .="</tr>";
  }else {
	  $return .="<tr style='background-color:  #F2D7D5;'>";
	  $return .="<td><center>". $d['Vc_Estrategia']."</center></td>";
	  $return .="<td><center>". $d['VC_Nombre_Lugar']."</center></td>";
	  $return .="<td><center>". $d['VC_Nombre_Grupo']."</center></td>";
	  $return .="<td><center>". $d['TipoGrupo']."</center></td>";
	  $return .="<td><center>". $d['NIVEL']."</center></td>";	  
	  $return .="<td><center>". $d['INSCRITOS']."</center></td>";
	  $return .="<td><center> <a href='#' class='activar-grupo btn btn-success' data-id-grupo='".$d['Pk_Id_Grupo']."' data-nombre-grupo='".$d['VC_Nombre_Grupo']."' data-toggle='modal' data-target='#modalActivacion'><span class='fa fa-thumbs-up'></span></a></center></td>";
	  $return .="</tr>";
  }
}
echo $return;
?>
