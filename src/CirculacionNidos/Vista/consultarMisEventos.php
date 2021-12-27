<?php  
$return = "";
foreach ($this->getVariables()['oferta'] as $o){
	switch($o['ESTADO']){
		case 2:
		$color = "#FFF2CC";
		$boton = "<a href='#' class='confirmar_reserva btn btn-block btn-success' data-id-evento='".$o['ID_EVENTO']."' data-evento='".$o['EVENTO']."' data-dia='".$o['DIA']."' data-fecha='".$o['FECHA']."' data-franja='".$o['FRANJA']."' data-localidad='".$o['LOCALIDAD']."' data-solicita='".$o['SOLICITA']."' data-id_atencion='".$o['ID_ATENCION']."' data-entidad='".$o['ENTIDAD']."' data-toggle='modal' data-target='#miModalConfirmar'>CONFIRMAR</a>";
		break;
		case 3:
		$color = "#FFD966";
		$boton = "<button class='reserva btn btn-block btn-warning' disabled>Preconfirmado</button>";
		break;
		case 4:
		$color = "#A8D08D";
		$boton = "<button type='button' class='Consultar-Reporte btn btn-block btn-success' data-id-evento='".$o['ID_EVENTO']."'>Aprobado</button>";
		break;
		case 5:
		$color = "#FF6161";
		$boton = "<button class='btn btn-block btn-danger' disabled>Cancelado</button>";
		break;
	}
	$return .="<tr>";
	$return .="<td style='background-color:".$color."';>".$o['DIA']."</td>";
	$return .="<td style='background-color:".$color."';>".$o['FECHA']."</td>";
	$return .="<td style='background-color:".$color."';>".$o['FRANJA']."</td>";
	$return .="<td style='background-color:".$color."';>".$o['EVENTO']."</td>";
	$return .="<td style='background-color:".$color."';>".$o['LOCALIDAD']."</td>";
	$return .="<td style='background-color:".$color."';>".$o['SOLICITA']."</td>";
	$return .="<td style='background-color:".$color."';>".$o['ENTIDAD']."</td>";
	$return .="<td style='background-color:".$color."';>".$o['T_ATENCION']."</td>";
	$return .="<td style='background-color:".$color."';>".$boton."</td>";
	$return .="</tr>";
}
echo $return;