<?php         
$return = "";
foreach ($this->getVariables()['oferta'] as $o){
	switch($o["ESTADO"]){
		case 1:
		$color = "";
		$boton = "<button class='reserva btn btn-block btn-success' disabled>Disponible</button>";
		break;
		case 2:
		$color = "#FFF2CC";
		$boton = "<button class='reserva btn btn-block btn-warning' disabled>Reservado</button>";
		break;
		case 3:
		$color = "#FFD966";
		$boton = "<a href='#' class='aprobar_evento btn btn-block btn-warning' data-id-evento='".$o['ID_EVENTO']."' data-evento='".$o['EVENTO']."' data-idlugarate='".$o['IDLUGARATENCION']."' data-localidad='".$o['LOCALIDAD']."' data-solicita='".$o['SOLICITA']."' data-entidad='".$o['ENTIDAD']."' data-contacto='".$o['CONTACTO']."' data-dia='".$o['DIA']."' data-fecha='".$o['FECHA_TABLA']."' data-franja='".$o['FRANJA']."' data-artistas='".$o['ARTISTAS_APOYO']."' data-gestor-asis='".$o['GESTOR']."' data-vc-tipo-atencion='".$o["VC_TIPO_ATENCION"]."' data-solicitud-info='".$o['SOLICITUD']."' data-modalidad='".$o['TIPO_POBLACION']."' data-linea='".$o['LINEA']."' data-tipo-atencion='".$o['TIPO_ATENCION']."' data-otro-tipo-lugar='".$o["VC_Otro_Tipo_Atencion"]."' data-propuesta='".$o['PROPUESTA']."' data-transporte='".$o['TRANSPORTE']."' data-ficha='".$o['IDFICHA']."' data-contac-trans='".$o['CONTAC_TRANS']."' data-llegada-trans='".$o['LLEGADA_TRANS']."' data-terreno='".$o['TERRENO']."' data-soliequipos='".$o['SOLIEQUIPOS']."' data-lugar='".$o['LUGAR']."'  data-equipo='".$o['EQUIPO']."' data-acirculacion='".$o['ACIRCULACION']."' data-llegadaartistas='".$o['LLEGADAARTISTAS']."' data-montajenido='".$o['MONTAJENIDO']."' data-inicioatencion='".$o['INICIOATENCION']."' data-finalizacion='".$o['FINALIZACION']."' data-montaje='".$o['MONTAJE']."' data-desmontaje='".$o['DESMONTAJE']."' data-emusical='".$o['EMUSICAL']."' data-ubicacion='".$o['UBICACION']."' data-llegada='".$o['LLEGADA']."' data-ninos='".$o['NINOS']."' data-adultos='".$o['ADULTOS']."' data-toggle='modal' data-target='#miModalAprobar'>Preconfirmado</a>";
		break;
		case 4:
		$color = "#A8D08D";
		$boton = "<a class='Consultar-Reporte btn btn-block btn-success' data-id-evento='".$o['ID_EVENTO']."'>Aprobado</a>";
		break;
		case 5:
		$color = "#FF6161";
		$boton = "";
		break;
	};

	$return .= "<tr>";
	$return .="<td style='background-color:".$color."';>". $o['DIA']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['FECHA_TABLA']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['FRANJA']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['EVENTO']."</td>";	  	  
	$return .="<td style='background-color:".$color."';>". $o['SOLICITA']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['ENTIDAD']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['VC_TIPO_ATENCION']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['MODALIDAD']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['SOLICITUDEQU']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['LOCALIDAD']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['UPZ']."</td>"; 
	$return .="<td style='background-color:".$color."';>". $o['NOMLUGAR']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['BARRIO']."</td>"; 
	$return .="<td style='background-color:".$color."';>". $o['DIRECCION']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['TIPOLUGAR']."</td>";  
	$return .="<td style='background-color:".$color."';>". $o['OTRO_TIPO_LUGAR']."</td>";  
	$return .="<td style='background-color:".$color."';>". $o['CONTACTO']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['UBICACION']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['LLEGADA']."</td>"; 
	$return .="<td style='background-color:".$color."';>". $o['GESTOR']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['PROPUESTA']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['ARTISTAS_APOYO']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['TRANSPORTE']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['CONTAC_TRANS']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['LLEGADA_TRANS']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['TERRENO']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['EQUIPOSASIG']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['FICHA']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['ACIRCULACION']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['LLEGADAARTISTAS']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['MONTAJE']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['MONTAJENIDO']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['INICIOATENCION']."</td>";
	$return .="<td style='background-color:".$color."';>". $o['FINALIZACION']."</td>";  
	$return .="<td style='background-color:".$color."';>". $o['DESMONTAJE']."</td>";
	$return .="<td style='background-color:".$color."';>".$boton."</td>";
	if($o["ESTADO"] != 5){
		$return .="<td style='background-color:".$color."';><a href='#' class='editarEvento btn btn-block btn-warning' data-id-evento='".$o['ID_EVENTO']."' data-dia='".$o['DIA']."' data-fecha='".$o['FECHA']."' data-franja='".$o['IDFRANJA']."' data-evento='".$o['EVENTO']."' data-localidad='".$o['IDLOCALIDAD']."' data-solicita='".$o['SOLICITA']."' data-entidad='".$o['ENTIDAD']."' data-idlugarate='".$o['IDLUGARATENCION']."' data-contacto='".$o['CONTACTO']."' data-ficha='".$o['IDFICHA']."' data-artistas='".$o['ARTISTAS_APOYO']."' data-idgestor='".$o['IDGESTOR']."' data-gestor-asis='".$o['GESTOR']."' data-solicitud-info='".$o['SOLICITUD']."' data-modalidadeditar='".$o['TIPO_POBLACION']."' data-vc-tipo-atencion='".$o["VC_TIPO_ATENCION"]."' data-otro-tipo-lugar='".$o["VC_Otro_Tipo_Atencion"]."' data-equipo='".$o['EQUIPO']."' data-linea='".$o['LINEA']."' data-tipo-atencion='".$o['TIPO_ATENCION']."' data-propuesta='".$o['PROPUESTA']."' data-transporte='".$o['TRANSPORTE']."' data-contac-trans='".$o['CONTAC_TRANS']."' data-llegada-trans='".$o['LLEGADA_TRANS']."' data-terreno='".$o['TERRENO']."' data-acirculacion='".$o['ACIRCULACION']."' data-llegadaartistas='".$o['LLEGADAARTISTAS']."' data-montajenido='".$o['MONTAJENIDO']."' data-inicioatencion='".$o['INICIOATENCION']."' data-finalizacion='".$o['FINALIZACION']."' data-montaje='".$o['MONTAJE']."' data-desmontaje='".$o['DESMONTAJE']."' data-emusical='".$o['EMUSICAL']."'  data-lugar='".$o['LUGAR']."' data-ubicacion='".$o['UBICACION']."' data-llegada='".$o['LLEGADA']."' data-ninos='".$o['NINOS']."' data-adultos='".$o['ADULTOS']."' data-toggle='modal' data-target='#miModalEditarEvento'><i class='fas fa-edit'></i></a>
		<a href='#' class='cancelar_evento btn btn-block btn-danger' data-id-evento='".$o['ID_EVENTO']."' data-evento='".$o['EVENTO']."' data-dia='".$o['DIA']."' data-fecha='".$o['FECHA_TABLA']."' data-toggle='modal' data-target='#miModalCancelar'><i class='fas fa-times-circle'></i></a>
		</td>"; 
	}else{
		$return .="<td style='background-color:".$color."';></td>";
	}
	$return .="</tr>";
} 
echo $return;