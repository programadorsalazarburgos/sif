<?php
$return = "";

foreach ($this->getVariables()["oferta"] as $o){

	$color;

	//$estado = ($o["FORMULARIO"] == "Arn" || $o["FORMULARIO"] == "Aulas hospitalarias") ? $o["ESTADO_LLAMADA_SIN_HORARIO"] : $o["ESTADO_LLAMADA_CON_HORARIO"];

	if($o["ESTADO_LLAMADA"] == 0){
		$color = "";
	}
	if($o["ESTADO_LLAMADA"] == 1){
		$color = "style='background-color: #E2EFD9'";
	}
	if($o["ESTADO_LLAMADA"] == 2){
		$color = "style='background-color: #F2DEDE'";
	}

	$horario = ($o["FORMULARIO"] == "Arn" || $o["FORMULARIO"] == "Aulas hospitalarias") ? 'No aplica' : $o["INICIO_LLAMADA"]." a ". $o["FIN_LLAMADA"];

	$fecha_llamada = ($o["FORMULARIO"] == "Arn" || $o["FORMULARIO"] == "Aulas hospitalarias") ? $o["FECHA_LLAMADA_MOSTRAR_SIN_HORARIO"] : $o["FECHA_LLAMADA_MOSTRAR_CON_HORARIO"];

	$return .="<tr>";
	$return .="<td ".$color. ">" .$fecha_llamada. "</td>";
	$return .="<td ".$color. ">". $horario."</td>";
	$return .="<td ".$color. ">". $o['ATENCION']."</td>";
	$return .="<td ".$color. ">". $o['DIRIGIDA']."</td>";
	$return .="<td ".$color. ">". $o['NOMBRE_CUIDADOR']."</td>";	  
	$return .="<td ".$color. ">". $o['NOMBRE_BENEFICIARIO']."</td>";
	if($o["DIRIGIDA"] == "MUJER GESTANTE"){
		$return .="<td ".$color. ">N/A</td>";
	}else{
		if(!is_null($o['FECHA_NACIMIENTO_BENEFICIARIO']) && $o['FECHA_NACIMIENTO_BENEFICIARIO'] != ""){
			$fecha_llamada = DateTime::createFromFormat("Y-m-d", $o['FECHA_CALCULO']);
			$fecha_nacimiento = DateTime::createFromFormat("Y-m-d", $o['FECHA_NACIMIENTO_BENEFICIARIO']);
			$edad = $fecha_llamada->diff($fecha_nacimiento);

			$return .="<td ".$color. ">";
			if($edad->y < 1){
				$return .="menos de un año";
			}
			if($edad->y == 1){
				$return .=$edad->y. " año";
			}
			if($edad->y > 1){
				$return .=$edad->y. " años";
			}
			$return .="</td>";
		}else{
			$return .="<td ".$color. ">";
			if($o["EDAD_BENEFICIARIO"] == 1){
				$return .=$o["EDAD_BENEFICIARIO"]." año";
			}else{
				$return .=$o["EDAD_BENEFICIARIO"]." años";
			}
			$return .="</td>";
		}
	}
	$return .="<td ".$color. ">". $o['ENFOQUE_BENEFICIARIO']."</td>";	  
	$return .="<td ".$color. ">". $o['COMENTARIOS']."</td>";
	$return .="<td ".$color. ">". $o['AUTORIZACION']."</td>";
	$return .="<td ".$color. ">". $o['TELEFONO_LLAMADA']."</td>";
	$return .="<td ".$color. ">". $o['CONDICION_SALUD']."</td>";
	$return .="<td ".$color. ">". $o['DIFICULTAD_MOVILIDAD']."</td>";
	$return .="<td ".$color. ">". $o['FORMULARIO']."</td>";

	if($o["ESTADO_LLAMADA"] == 0){
		$return .="<td ".$color. "><a href='#' class='registrollamada btn btn-block btn-success' data-id-registro='".$o['ID_REGISTRO']."' data-id-asignacion='".$o['ID_ASIGNACION']."' data-formulario='".$o["FORMULARIO"]."' data-fecha-llamada-sin-horario='".$o["FECHA_LLAMADA_SIN_HORARIO"]."' data-numero-documento-beneficiario='".$o["NUMERO_DOC_BENEFICIARIO"]."' data-nombre-beneficiario='".$o['NOMBRE_BENEFICIARIO']."' data-nombre-cuidador='".$o["NOMBRE_CUIDADOR"]."' data-dirigida='".$o['DIRIGIDA']."' data-toggle='modal' data-target='#miModalRegistroLlamada'>Registrar</a></td>";
		// $return .="<td ".$color. "><a href='#' class='editarllamada btn btn-block btn-warning' data-toggle='modal' data-id-registro='".$o['ID_REGISTRO']."' data-tipo-doc-cuidador='".$o['TIPO_DOC_CUIDADOR']."' data-documento-cuidador='".$o['DOCUMENTO_CUIDADOR']."' data-nombre-cuidador='".$o['NOMBRE_CUIDADOR']."' data-correo-cuidador='".$o['CORREO_CUIDADOR']."' data-localidad-cuidador='".$o['LOCALIDAD_CUIDADOR']."' data-barrio-cuidador='".$o['BARRIO_CUIDADOR']."' data-direccion-cuidador='".$o['DIRECCION_CUIDADOR']."' data-estrato-cuidador='".$o['ESTRATO_CUIDADOR']."' data-edad-cuidador='".$o['EDAD_CUIDADOR']."' data-dirigida='".$o['DIRIGIDA']."' data-id-parentesco='".$o['ID_PARENTESCO']."' data-potestad='".$o['POTESTAD']."' data-tipo-doc-beneficiario='".$o['TIPO_DOC_BENEFICIARIO']."' data-numero-doc-beneficiario='".$o['NUMERO_DOC_BENEFICIARIO']."' data-numero-documento-beneficiario='".$o["NUMERO_DOC_BENEFICIARIO"]."' data-nombre-beneficiario='".$o['NOMBRE_BENEFICIARIO']."' data-enfoque-beneficiario='".$o['ENFOQUE_BENEFICIARIO']."' data-fecha-nacimiento-beneficiario='".$o['FECHA_NACIMIENTO_BENEFICIARIO']."' data-edad-beneficiario='".$o['EDAD_BENEFICIARIO']."' data-fecha-llamada='".$o['FECHA_LLAMADA']."' data-inIcio-llamada='".$o['INICIO_LLAMADA']."' data-fin-llamada='".$o['FIN_LLAMADA']."' data-telefono-llamada='".$o['TELEFONO_LLAMADA']."' data-target='#miModalEditarLlamada'><i class='fas fa-edit'></i></a></td>";
	}
	else{
		$return .="<td ".$color. "><button type='button' class='ver-llamada btn btn-block btn-success' data-estado='".$o["ESTADO_LLAMADA"]."' data-numero-documento-beneficiario='".$o["NUMERO_DOC_BENEFICIARIO"]."' data-nombre-beneficiario='".$o["NOMBRE_BENEFICIARIO"]."' data-duracion='".$o["DURACION"]."' data-material='".$o["MATERIAL"]."' data-parecio='".$o["PARECIO"]."' data-reaccion='".$o["REACCION"]."' data-observaciones='".$o["OBSERVACIONES"]."' data-target='miModalConsultarLlamada' data-toggle='modal'>Ver</button></td>";
	// 	$return .="<td ".$color. "><button type='button' class='btn btn-block btn-warning' disabled><i class='fas fa-edit'></i></button></td>";
	}

	$return .="</tr>"; 
}
echo $return;