<?php 
$baseurl = $_SERVER['DOCUMENT_ROOT'].'/sif/uploadedFiles/Territorial/Experiencia/';  
$return = "";
foreach ($this->getVariables()['Datos'] as $d){

 if($d['APROBADO'] == 0){
	$return .="<tr>";	
	$return .="<td>".$d["ID"]."</td>";
	$return .="<td>".$d["LUGAR"]."</td>";
	$return .="<td>".$d["GRUPO"]." / ".$d["GRADO"]."</td>";
	$return .="<td>".$d["MODALIDAD"]."</td>";
	$return .="<td>".$d["EXPERIENCIAS"]."</td>";
	$return .="<td>".$d["FECHA"]."</td>";
	$return .="<td>".$d["CUIDADORES"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_0_3_NINOS_R"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_0_3_NINAS_R"]."</td>";
	$return .="<td style='background-color: #7FB3D5; text-align: center;'><font size=4>".$d["TOTAL_0_3_R"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_4_5_NINOS_R"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_4_5_NINAS_R"]."</td>";
	$return .="<td style='background-color: #7FB3D5; text-align: center;'><font size=4>".$d["TOTAL_4_5_R"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_6_NINOS_R"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_6_NINAS_R"]."</td>";
	$return .="<td style='background-color: #7FB3D5; text-align: center;'><font size=4>".$d["TOTAL_6_R"]."</td>";	
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["GESTANTES_R"]."</td>";
	$return .="<td style='background-color: #5499C7; text-align: center;'><font size=4>".$d["TOTAL_R"]."</td>";
	$return .="<td style='background-color: #45B39D; text-align: center;'><button type='button' class='btn btn-primary enfoque' data-id-experiencia='".$d['ID']."'>".$d["ENFOQUE_R"]."</button></td>";
	

	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_0_3_NINOS_N"]."</td>";
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_0_3_NINAS_N"]."</td>";
	$return .="<td style='background-color: #D98880; text-align: center;'><font size=4>".$d["TOTAL_0_3_N"]."</td>";
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_4_5_NINOS_N"]."</td>";	
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_4_5_NINAS_N"]."</td>";
	$return .="<td style='background-color: #D98880; text-align: center;'><font size=4>".$d["TOTAL_4_5_N"]."</td>";
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_6_NINOS_N"]."</td>";	
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_6_NINAS_N"]."</td>";
	$return .="<td style='background-color: #D98880; text-align: center;'><font size=4>".$d["TOTAL_6_N"]."</td>";
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["GESTANTES_N"]."</td>";
	$return .="<td style='background-color: #EC7063; text-align: center;'><font size=4>".$d["TOTAL_N"]."</td>";
	$return .="<td style='background-color: #F75848; text-align: center;'><font size=4>".$d["ENFOQUE_N"]."</td>";
	$return .="<td style='background-color: #5D6D7E'><center>
	<a href='#' class='editarEvento btn btn-warning EliminarExperiencia'  data-id-experiencia='".$d["ID"]."' data-fecha='".$d["FECHA"]."' data-grupo='".$d["GRUPO"]."' data-nombre='".$d["EXPERIENCIAS"]."'>
	<i class='fas fa-trash-alt'></i>
	</button></center></td>";
	$return .="</tr>";

  }else {
	$return .="<tr>";	
	$return .="<td style='background-color: #82E0AA;'>".$d["ID"]."</td>";
	$return .="<td style='background-color: #82E0AA;'>".$d["LUGAR"]."</td>";
	$return .="<td style='background-color: #82E0AA;'>".$d["GRUPO"]." / ".$d["GRADO"]."</td>";
	$return .="<td style='background-color: #82E0AA;'>".$d["MODALIDAD"]."</td>";
	$return .="<td style='background-color: #82E0AA;'>".$d["EXPERIENCIAS"]."</td>";
	$return .="<td style='background-color: #82E0AA;'>".$d["FECHA"]."</td>";
	$return .="<td style='background-color: #82E0AA;'>".$d["CUIDADORES"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_0_3_NINOS_R"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_0_3_NINAS_R"]."</td>";
	$return .="<td style='background-color: #7FB3D5; text-align: center;'><font size=4>".$d["TOTAL_0_3_R"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_4_5_NINOS_R"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_4_5_NINAS_R"]."</td>";
	$return .="<td style='background-color: #7FB3D5; text-align: center;'><font size=4>".$d["TOTAL_4_5_R"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_6_NINOS_R"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["_6_NINAS_R"]."</td>";
	$return .="<td style='background-color: #7FB3D5; text-align: center;'><font size=4>".$d["TOTAL_6_R"]."</td>";	
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["GESTANTES_R"]."</td>";
	$return .="<td style='background-color: #5499C7; text-align: center;'><font size=4>".$d["TOTAL_R"]."</td>";
	$return .="<td style='background-color: #45B39D; text-align: center;'><button type='button' class='btn btn-primary enfoque' data-id-experiencia='".$d['ID']."'>".$d["ENFOQUE_R"]."</button></td>";

	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_0_3_NINOS_N"]."</td>";
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_0_3_NINAS_N"]."</td>";
	$return .="<td style='background-color: #D98880; text-align: center;'><font size=4>".$d["TOTAL_0_3_N"]."</td>";
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_4_5_NINOS_N"]."</td>";	
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_4_5_NINAS_N"]."</td>";
	$return .="<td style='background-color: #D98880; text-align: center;'><font size=4>".$d["TOTAL_4_5_N"]."</td>";
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_6_NINOS_N"]."</td>";	
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["_6_NINAS_N"]."</td>";
	$return .="<td style='background-color: #D98880; text-align: center;'><font size=4>".$d["TOTAL_6_N"]."</td>";
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["GESTANTES_N"]."</td>";
	$return .="<td style='background-color: #EC7063; text-align: center;'><font size=4>".$d["TOTAL_N"]."</td>";
	$return .="<td style='background-color: #F75848; text-align: center;'><font size=4>".$d["ENFOQUE_N"]."</td>";
	$return .="<td style='background-color: #82E0AA'><center>		
	<a href='".$d['SOPORTE']."' target='_blank'>
		<button type='button' class='btn btn-success imagen'>Descargar</button>
	</a></center></td>";

	$return .="</tr>";
} 
}
echo $return;
?>