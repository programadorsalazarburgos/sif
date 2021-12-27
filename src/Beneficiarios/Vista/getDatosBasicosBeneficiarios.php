<?php 
$baseurl = $_SERVER['DOCUMENT_ROOT'].'/sif/uploadedFiles/Nidos/Uso_de_imagen/2020/';
$return = "";
foreach ($this->getVariables()['datos_beneficiarios'] as $db)
{
	$return .="<tr>";
	$return .="<td><center>". $db['VC_Identificacion']."</center></td>";
	$return .="<td><center>". $db['Nombre']."</center></td>";
	$return .="<td><center><button type='button' class='btn btn-primary modificar' data-id-beneficiario=".$db['VC_Identificacion'].">Modificar información</button></center></td>";
	$return .="<td><center><button type='button' class='btn btn-warning historico' data-id-beneficiario=".$db['Pk_Id_Beneficiario'].">Histórico de grupos</button></center></td>";
	if (is_readable($baseurl.$db['VC_Identificacion'])) {
		$return .="<td><center>
		<div class='col-lg-offset-4 col-lg-1'>
		<a href='".$db['VC_Uso_Imagen']."' target='_blank'>
			<button type='button' class='btn btn-success imagen' data-id-beneficiario=".$db['VC_Identificacion'].">
				<i class='fas fa-download'></i>
			</button>
		</a>
		</div>
		<div class='col-lg-offset-1 col-lg-1'>
			<button type='button' class='btn btn-danger borrar' data-id-beneficiario=".$db['VC_Identificacion'].">
				<i class='fas fa-trash-alt'></i>
			</button>
		</div></center></td>";
	}else{
		$return .="<td><center>
		<input class='TX_Uso_Imagen' name='TX_Uso_Imagen' type='file' runat='server' accept='.pdf'>
		<button type='button' class='btn btn-primary imagen subir-imagen' data-id-beneficiario=".$db['VC_Identificacion']."><i class='fas fa-save'></i></button></center></td>";
	}
	$return .="</tr>";
}
echo $return;
