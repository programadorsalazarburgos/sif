<?php 
$baseurl = $_SERVER['DOCUMENT_ROOT'].'/sif/uploadedFiles/Territorial/Experiencia/';
$return = "";
foreach ($this->getVariables()['Datos'] as $d){
	$ninos03real = $d["NINAS03REAL"] + $d["NINOS03REAL"];
	$ninos45real = $d["NINOS46REAL"] + $d["NINAS46REAL"];
	$ninos6real  = $d["NINOS6REAL"] + $d["NINAS6REAL"];
	$ninos03nuevos = $d["NINOS03NUEVOS"] + $d["NINAS03NUEVOS"];
	$ninos45nuevos = $d["NINOS46NUEVOS"] + $d["NINAS46NUEVOS"];
	$ninos6nuevos  = $d["NINOS6NUEVOS"] + $d["NINAS6NUEVOS"];
	$return .="<tr>";	
	$return .="<td>".$d["IDEXPERIENCIA"]."</td>";
	$return .="<td>".$d["LUGAR"]."</td>";
	$return .="<td>".$d["DUPLA"]."</td>";
	$return .="<td>".$d["GRUPO"]."</td>";
	$return .="<td>".$d["EXPERIENCIA"]."</td>";
	$return .="<td>".$d["FECHA"]."</td>";
	$return .="<td>".$d["CUIDADORES"]."</td>";
	$return .="<td style='background-color: #52BE80; text-align: center;'><font size=4>".$d["BENEFICIARIOS"]."</font></td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["NINOS03REAL"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["NINAS03REAL"]."</td>";
	$return .="<td style='background-color: #7FB3D5; text-align: center;'><font size=4>".$ninos03real."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["NINOS46REAL"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["NINAS46REAL"]."</td>";
	$return .="<td style='background-color: #7FB3D5; text-align: center;'><font size=4>".$ninos45real."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["NINOS6REAL"]."</td>";
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["NINAS6REAL"]."</td>";
	$return .="<td style='background-color: #7FB3D5; text-align: center;'><font size=4>".$ninos6real."</td>";	
	
	$return .="<td style='background-color: #D4E6F1; text-align: center;'><font size=4>".$d["GESTANTESREAL"]."</td>";
	$return .="<td style='background-color: #5499C7; text-align: center;'><font size=4>".$d["TOTALBENEFICIARIOSREAL"]."</td>";

	$return .="<td style='background-color: #AED6F1; text-align: center;'><font size=4>".$d["AFROREAL"]."</td>";
	$return .="<td style='background-color: #AED6F1; text-align: center;'><font size=4>".$d["CAMPESINOSREAL"]."</td>";
	$return .="<td style='background-color: #AED6F1; text-align: center;'><font size=4>".$d["DISCAPACIDADREAL"]."</td>";
	$return .="<td style='background-color: #AED6F1; text-align: center;'><font size=4>".$d["CONFLICTOREAL"]."</td>";
	$return .="<td style='background-color: #AED6F1; text-align: center;'><font size=4>".$d["INDIGENAREAL"]."</td>";
	$return .="<td style='background-color: #AED6F1; text-align: center;'><font size=4>".$d["PRIVADOSREAL"]."</td>";
	$return .="<td style='background-color: #AED6F1; text-align: center;'><font size=4>".$d["VICTIMASREAL"]."</td>";
	$return .="<td style='background-color: #AED6F1; text-align: center;'><font size=4>".$d["RAIZALREAL"]."</td>";
	$return .="<td style='background-color: #AED6F1; text-align: center;'><font size=4>".$d["ROMREAL"]."</td>";
	
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["NINOS03NUEVOS"]."</td>";
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["NINAS03NUEVOS"]."</td>";
	$return .="<td style='background-color: #D98880; text-align: center;'><font size=4>".$ninos03nuevos."</td>";

	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["NINOS46NUEVOS"]."</td>";	
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["NINAS46NUEVOS"]."</td>";
	$return .="<td style='background-color: #D98880; text-align: center;'><font size=4>".$ninos45nuevos."</td>";

	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["NINOS6NUEVOS"]."</td>";	
	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["NINAS6NUEVOS"]."</td>";
	$return .="<td style='background-color: #D98880; text-align: center;'><font size=4>".$ninos6nuevos."</td>";

	$return .="<td style='background-color: #E6B0AA; text-align: center;'><font size=4>".$d["GESTANTESNUEVOS"]."</td>";
	$return .="<td style='background-color: #EC7063; text-align: center;'><font size=4>".$d["TOTALBENEFICIARIOSNUEVOS"]."</td>";

	$return .="<td style='background-color: #F5B7B1; text-align: center;'><font size=4>".$d["AFRONUEVOS"]."</td>";
	$return .="<td style='background-color: #F5B7B1; text-align: center;'><font size=4>".$d["CAMPESINOSNUEVOS"]."</td>";
	$return .="<td style='background-color: #F5B7B1; text-align: center;'><font size=4>".$d["DISCAPACIDADNUEVOS"]."</td>";
	$return .="<td style='background-color: #F5B7B1; text-align: center;'><font size=4>".$d["CONFLICTONUEVOS"]."</td>";
	$return .="<td style='background-color: #F5B7B1; text-align: center;'><font size=4>".$d["INDIGENANUEVOS"]."</td>";
	$return .="<td style='background-color: #F5B7B1; text-align: center;'><font size=4>".$d["PRIVADOSNUEVOS"]."</td>";
	$return .="<td style='background-color: #F5B7B1; text-align: center;'><font size=4>".$d["VICTIMASNUEVOS"]."</td>";
	$return .="<td style='background-color: #F5B7B1; text-align: center;'><font size=4>".$d["RAIZALNUEVOS"]."</td>";
	$return .="<td style='background-color: #F5B7B1; text-align: center;'><font size=4>".$d["ROMNUEVOS"]."</td>";
	if ($d['soporte'] == NULL) {
		$return .="<td style='background-color: #E59866'><center>
		<input class='TX_Listado_Asistencia' name='TX_Listado_Asistencia' type='file' runat='server' accept='.pdf'>
		<button type='button' class='btn btn-primary imagen subir-imagen' data-id-experiencia='".$d['IDEXPERIENCIA']."'  data-dupla='".$d["IDDUPLA"]."' data-grupo='".$d["IDGRUPO"]."' data-fecha='".$d["FECHA"]."'><i class='fas fa-save'></i>
		</button></center></td>";
	}else{
		$return .="<td style='background-color: #E59866'><center>		
		<a href='".$d['soporte']."' target='_blank'>
			<button type='button' class='btn btn-success imagen' data-id-beneficiario=".$d['soporte'].">
				<i class='fas fa-download'></i>
			</button>
		</a>
			<button type='button' class='btn btn-danger borrar' data-id-experiencia='".$d["IDEXPERIENCIA"]."' data-dupla='".$d["IDDUPLA"]."' data-grupo='".$d["IDGRUPO"]."'  data-soporte='".$d["soporte"]."' data-fecha='".$d["FECHA"]."'>
				<i class='fas fa-trash-alt'></i>
			</button>
		</center></td>";
	}
	$return .="<td style='background-color: #5D6D7E'><center>
	<a href='#' class='editarEvento btn btn-warning' data-id-experiencia='".$d["IDEXPERIENCIA"]."'     data-ninos03real='".$d["NINOS03REAL"]."' data-ninos46real='".$d["NINOS46REAL"]."' data-totalninosreal='".$d["TOTALNINOSREAL"]."' data-ninas03real='".$d["NINAS03REAL"]."' data-ninas46real='".$d["NINAS46REAL"]."' data-totalninasreal='".$d["TOTALNINASREAL"]."' data-gestantesreal='".$d["GESTANTESREAL"]."' data-totalreal='".$d["TOTALBENEFICIARIOSREAL"]."' data-afroreal='".$d["AFROREAL"]."' data-campesinoreal='".$d["CAMPESINOSREAL"]."' data-discapacidadreal='".$d["DISCAPACIDADREAL"]."' data-conflictoreal='".$d["CONFLICTOREAL"]."' data-indigenareal='".$d["INDIGENAREAL"]."' data-privadosreal='".$d["PRIVADOSREAL"]."' data-victimasreal='".$d["VICTIMASREAL"]."' data-raizalreal='".$d["RAIZALREAL"]."' data-romreal='".$d["ROMREAL"]."'
	data-ninos03nuevos='".$d["NINOS03NUEVOS"]."' data-ninos46nuevos='".$d["NINOS46NUEVOS"]."' data-totalninosnuevos='".$d["TOTALNINOSNUEVOS"]."' data-ninas03nuevos='".$d["NINAS03NUEVOS"]."' data-ninas46nuevos='".$d["NINAS46NUEVOS"]."' data-totalninasnuevos='".$d["TOTALNINASNUEVOS"]."' data-gestantesnuevos='".$d["GESTANTESNUEVOS"]."' data-totalnuevos='".$d["TOTALBENEFICIARIOSNUEVOS"]."' data-afronuevos='".$d["AFRONUEVOS"]."' data-campesinonuevos='".$d["CAMPESINOSNUEVOS"]."' data-discapacidadnuevos='".$d["DISCAPACIDADNUEVOS"]."' data-conflictonuevos='".$d["CONFLICTONUEVOS"]."' data-indigenasnuevos='".$d["INDIGENANUEVOS"]."'	data-privadosnuevos='".$d["PRIVADOSNUEVOS"]."' data-victimasnuevos='".$d["VICTIMASNUEVOS"]."' data-raizalnuevos='".$d["RAIZALNUEVOS"]."' data-romnuevos='".$d["ROMNUEVOS"]."' data-toggle='modal' data-target='#miModalEditarEvento' ><i class='fas fa-pencil-alt'></i></a>
	<button type='button' class='btn btn-danger eliminarexperiencia' data-id-registro='".$d["IDREGISTRO"]."' data-experiencia='".$d["EXPERIENCIA"]."' data-grupo='".$d["GRUPO"]."' data-fecha='".$d["FECHA"]."'>
		<i class='fas fa-trash-alt'></i>
	</button></center></td>";
	$return .="</tr>";
}
echo $return;




?>