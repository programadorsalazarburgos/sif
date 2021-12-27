<?php 
$return = "";
foreach ($this->getVariables()['consolidado'] as $o)
	{
    	$return .="<tr style='font-size: 10px;'>";
      $return .="	<td class='text-center' style='background-color: #F5B7B1;'><strong>". $o['Vc_Descripcion']." ". $o['Vc_Abreviatura']."</strong></td>";
    	$return .="	<td class='text-center'>". $o['VC_Nombre_Upz']."</td>";
    	$return .="	<td class='text-center'>". $o['VC_Barrio']."</td>";
      $return .="	<td class='text-center'>". $o['VC_Nombre_Lugar']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['COBERTURA']."</td>";
      $return .="	<td class='text-center'><strong>". $o['VC_Nombre_Grupo']."<strong></td>";
      $return .=" <td class='text-center' style='font-size: 16px;'>". $o['CUIDADORES']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['EXPERIENCIA']."</td>";


      $return .="	<td class='text-center' style='background-color: #E5E7E9; font-size: 16px;'><strong>". $o['TOTAL_DE_0_3_ANIOS_N']."</strong></td>";
      $return .="	<td class='text-center' style='background-color: #E5E7E9; font-size: 16px;'><strong>". $o['TOTAL_DE_4_6_ANIOS_N']."</strong></td>";
      $return .="	<td class='text-center' style='font-size: 16px;'><strong>". $o['GESTANTES_N']."</strong></td>";

      $return .="	<td class='text-center' style='background-color: #3A84B5; font-size: 16px;'><a href='#' class='consultar_beneficiarios btn btn-primary btn-block' data-id_beneficiairos='".$o['TOTAL_N_IDENTIFICACION'] ."' data-toggle='modal' data-target='#miModalBeneficiariosNuevos'>". $o['TOTAL_N']."</a></td>";

      $return .="	<td class='text-center' style='background-color: #E5E7E9; font-size: 16px;'><strong>". $o['TOTAL_DE_0_3_ANIOS_R']."</strong></td>";
      $return .="	<td class='text-center' style='background-color: #E5E7E9; font-size: 16px;'><strong>". $o['TOTAL_DE_4_6_ANIOS_R']."</strong></td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['NINOS_DE_0_A_3_R']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['NINAS_DE_0_A_3_R']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['NINOS_DE_4_A_6_R']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['NINAS_DE_4_A_6_R']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['GESTANTES_R']."</td>";

      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['AFRODESCENDIENTE_R']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['INDIGENA_R']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['RAIZALES_R']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['ROM_R']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['CAMPESINA_R']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['DISCAPACIDAD_R']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['CONFLICTO_R']."</td>";
      $return .="	<td class='text-center' style='font-size: 16px;'>". $o['PRIVADOS_R']."</td>";
      $return .="	<td class='text-center' style='background-color: #F1980C; font-size: 16px;'><strong>". $o['TOTAL_R']."</strong></td>";
      $return .="</tr>";
  }
    echo $return;
?>
