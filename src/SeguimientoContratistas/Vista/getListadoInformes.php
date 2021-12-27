<?php
$return = "";
$userId = $this->getVariables()['userId'];
$historico = $this->getVariables()['historico'];
$tipo = $this->getVariables()['tipo'];
$rol = $this->getVariables()['rol'];
$cedula = $this->getVariables()['cedula'];
foreach ($this->getVariables()['arrayInformes'] as $informe)
{
	if($historico == 'true')
	{	
		if ($userId == $informe['FK_Persona'])	
			$return .= drawData($informe,$userId,$tipo,$rol,$cedula);
		elseif ($informe['SM_Finalizado'] == "1" || $informe['SM_Finalizado_Detallado'] == 1)
			$return .= drawData($informe,$userId,$tipo,$rol,$cedula);
	}
	elseif($informe["ultimo"] == "1"){
		if ($userId == $informe['FK_Persona'])	
			$return .= drawData($informe,$userId,$tipo,$rol,$cedula);
		elseif ($informe['SM_Finalizado'] == "1" || $informe['SM_Finalizado_Detallado'] == 1)
			$return .= drawData($informe,$userId,$tipo,$rol,$cedula);
	}
	elseif($informe["ultimo_revision"] == "1" && ($tipo == '3' || $tipo == '2')){
		if ($informe['SM_Finalizado'] == "1" || $informe['SM_Finalizado_Detallado'] == 1)
			$return .= drawData($informe,$userId,$tipo,$rol,$cedula);
	}
}
function drawData($informe,$userId,$tipo,$rol,$cedula)
{
	$estadoInforme = array();
	$estadoInforme = $informe['SM_Estado'] != null ? explode(",",$informe['SM_Estado']) : $estadoInforme;	
	$botonRadicado = '';
	$esInformeFinalizado = esInformeFinalizado($informe,$estadoInforme);
	$transaccion = obtenerIdTransaccion($informe,$userId);

	$noEstaFirmadoEnOrfeo = strpos($informe['validado'],"Documento sin Firmar") !== false;
	$numeroAprobaciones =  count(obtenerArrayAprobacionesFirmas($informe)); #mas la firma de contratista
	$numeroFirmas = count(explode(',',$informe['firmas']));		
	if($noEstaFirmadoEnOrfeo && $esInformeFinalizado){
		if(($numeroAprobaciones+1) ==$numeroFirmas){
			$botonRadicado.= "<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' class='firmar_radicado btn btn-info data-placement='top' data-toggle='tooltip' title='Firmar Documento en Orfeo'><i class='fas fa-file-signature'></i></button>";
		}
		$ultimaFirma = esUltimaFirma($informe);
		$botonRadicado.= "<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' data-cedula='".$cedula."' data-transaccion='".$transaccion."' data-radicado='1' data-ultima_firma='".$ultimaFirma['esUltimaFirma']."' class='resolicitar_codigo btn btn-danger data-placement='top' data-toggle='tooltip' title='Volver a solicitar codigo para firmar, ".$ultimaFirma['mensaje']." '><i class='fas fa-signature'></i></button>";
		
	}
	$botonRadicado .= "<span class='label label-danger' data-toggle='tooltip' title='".$informe['validado']."'>".$informe['validado']."</span>";

	$botonAnulado = '';
	$tipoLabel = 'success';
	$textoRadicado = $informe['asunto'].", ".$informe['validado']." - ".$informe['fecha_radicado'].". Anulado: ".$informe['anulacion'];
	if(strpos($informe['anulacion'],'ANULADO') !== false){
		$botonAnulado.= "<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' class='reiniciar_aprobaciones btn btn-danger data-placement='top' data-toggle='tooltip' title='Reiniciar el proceso de aprobaciones'><i class='fas fa-undo'></i></button>";
		$tipoLabel = 'danger';
	}
	$return = "";
	$return .="<tr>";
	$return .="<td>".$informe['PK_Id_Tabla']."</td>";
	$return .="<td>".$informe['VC_Identificacion']."</td>";
	$return .="<td>".$informe['nombre_contratista']."</td>";
	$return .="<td>".$informe['VC_Numero_Contrato']."</td>";
	$return .="<td>".$informe['VC_Periodo_Inicio']." - ".$informe['VC_Periodo_Fin']."</td>";
	$return .="<td>".$informe['DA_Subida']."</td>";
	$return .="<td>".
				"<span class='label label-".$tipoLabel."' data-toggle='tooltip' title='".$textoRadicado."'>".$informe['VC_orfeo_radicado']."</span>".
				"<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' class='ver_historial btn btn-success' data-placement='top' data-toggle='tooltip' title='ver Historial de aprobaciones'><i class='fab fa-stack-overflow'></i></button>".
				$botonRadicado.
				$botonAnulado
			 ."</td>";	
	/*$return .="<td>".$informe['DA_Subida']."</td>";*/
	$estado = "";
	if ((in_array("1", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor'] == null ) && (in_array("2", $estadoInforme) || $informe['FK_Aprobacion_Administrativo'] == null) && (in_array("7", $estadoInforme) || $informe['FK_Persona_Supervisor'] == null) && (in_array("9", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == null ))
		$claseBotonDescargar = $informe["ultimodescarga"] == 1? "success":"old";
	else
		$claseBotonDescargar = "success";

	//Etiquetas del estado del informe.
	$estado .= in_array("1", $estadoInforme) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Aprobado por el apoyo a la supervisión'>Vo.Bo Apoyo Supervisión</span>" : (in_array("4", $estadoInforme) ? "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el apoyo a la supervisión'>No.Ap Apoyo Supervisión</span>": ($informe['FK_Persona_Apoyo_Supervisor'] != null ? "<span class='label label-white' data-toggle='tooltip' title='Sin revisar por el apoyo a la supervisión'>Apoyo Supervisión</span>": ""));
	$estado .= in_array("9", $estadoInforme) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Aprobado por el apoyo a la supervisión Dos'>Vo.Bo Apoyo Supervisión Dos</span>" : (in_array("0", $estadoInforme) ? "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el Supervisor Dos'>No.Ap Apoyo Supervisión Dos</span>" : ($informe['FK_Persona_Apoyo_Supervisor_Dos'] != null ? "<span class='label label-white' data-toggle='tooltip' title='Sin revisar por el apoyo a la supervisión'>Apoyo Supervisión Dos</span>" : ""));	
	$estado .= in_array("2", $estadoInforme) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Aprobado por el apoyo financiero'>Vo.Bo Apoyo Financiero</span>" : (in_array("5", $estadoInforme) ? "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el apoyo Financiero'>No.Ap Apoyo Financiero</span>" : ($informe['FK_Aprobacion_Administrativo'] != null ? "<span class='label label-white' data-toggle='tooltip' title='Sin revisar por el apoyo financiero'>Apoyo Financiero</span>":""));
	$estado .= in_array("7", $estadoInforme) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Aprobado por el Supervisor'>Vo.Bo Supervisor</span>" : (in_array("8", $estadoInforme) ? "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el Supervisor'>No.Ap Supervisor</span>" : ($informe['FK_Persona_Supervisor'] != null ? "<span class='label label-white' data-toggle='tooltip' title='Sin revisar por el Supervisor'>Supervisor</span>" : ""));
	
	/*$estado .= $informe['IN_estado_supervisor'] == 1 ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Aprobado Supervisor'>Aprobado Supervisor</span>" :"<span class='label label-white' data-toggle='tooltip' title='Requiere revisión'>Sin revisar supervisor</span>";*/
	$estado .= $informe['SM_Finalizado'] == 1 ? ((in_array("1", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor'] == null ) && (in_array("2", $estadoInforme) || $informe['FK_Aprobacion_Administrativo'] == null) && (in_array("7", $estadoInforme) || $informe['FK_Persona_Supervisor'] == null) && (in_array("9", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == null) && (in_array("1", $estadoInforme) || in_array("2", $estadoInforme) || in_array("7", $estadoInforme) || in_array("9", $estadoInforme)) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Disponible para descarga'>Aprobado</span>":"<span class='label label-warning' data-toggle='tooltip' title='Requiere revisiones'>Enviado</span>"):"<span class='label label-white' data-toggle='tooltip' title='Formato sin finalizar'>Sin Enviar</span>";

	$planillas_extras = "";
	if ($informe["TX_Planillas_Extras"] != "" && $informe["TX_Planillas_Extras"] != 'undefined' && $informe["TX_Planillas_Extras"] != null){
		$anexos_informe_pago = explode('///', $informe['TX_Planillas_Extras']);
		foreach ($anexos_informe_pago as $key => $value) {
			$contador = $key>0?($key+1):'';
			$planillas_extras .= ' <a href="'.$value.'" title="Descargar archivo anexo"  class="btn btn-warning download" data-placement="left" data-toggle="tooltip" download><span class="fa fa-download"></span> Anexo '.$contador.'</a>';	
		}
	}

	#Valida si es la ultima aprobacion
	$cantidadFirmas = 0;
	$cantidadFirmas += $informe['FK_Persona_Apoyo_Supervisor'] != null ? 1 : 0;
	$cantidadFirmas += $informe['FK_Aprobacion_Administrativo'] != null ? 1 : 0;
	$cantidadFirmas += $informe['FK_Persona_Supervisor'] != null ? 1 : 0;
	$cantidadFirmas += $informe['FK_Persona_Apoyo_Supervisor_Dos'] != null ? 1 : 0;

	$numeroAprobados = count($estadoInforme);
	$aprobadoFinal   =  (($numeroAprobados+1)==$cantidadFirmas) ? 1 : 0;


	if ($tipo == '3' && ($rol == '18' || $rol == '31' || $rol == '32')){
		$botonesRechazar = '';
		if (in_array("1", $estadoInforme))
			$botonesRechazar .= "<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='apoyo-supervisor'  class='rechazar_informe form-control btn btn-danger' data-placement='top' data-toggle='tooltip' title='Rechazar'>R. Apoyo Supervisión</a>";
		if (in_array("9", $estadoInforme))
			$botonesRechazar .= "<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='apoyo-supervisor-dos'  class='rechazar_informe form-control btn btn-danger' data-placement='top' data-toggle='tooltip' title='Rechazar'>R. Apoyo Supervisión Dos</a>";		
		if (in_array("2", $estadoInforme))
			$botonesRechazar .= "<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='apoyo-financiero'  class='rechazar_informe form-control btn btn-danger' data-placement='top' data-toggle='tooltip' title='Rechazar'>R. Apoyo Financiero</a>";
		if (in_array("7", $estadoInforme))
			$botonesRechazar .= "<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='supervisor'  class='rechazar_informe form-control btn btn-danger' data-placement='top' data-toggle='tooltip' title='Rechazar'>R. Supervisor</a>";

		/*if ($informe['SM_Finalizado'] == 1)
			$botonesRechazar .= "<br><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='finalizado'  class='rechazar_informe form-control btn btn-danger' data-placement='top' data-toggle='tooltip' title='Rechazar'>Quitar Finalizado</a>";*/
		if ((in_array("1", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor'] == null ) && (in_array("2", $estadoInforme) || $informe['FK_Aprobacion_Administrativo'] == null) && (in_array("7", $estadoInforme) || $informe['FK_Persona_Supervisor'] == null) && (in_array("9", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == null) && (in_array("1", $estadoInforme) || in_array("2", $estadoInforme) || in_array("7", $estadoInforme) || in_array("9", $estadoInforme))){
			$botonesRechazar .="<br><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='descargar_informe form-control btn btn-".$claseBotonDescargar."' data-placement='top' data-toggle='tooltip' title='Descargar'>Descargar</a>";
		}
		$return .="<td>".$botonesRechazar."&nbsp&nbsp".$estado."</td>";
	}
	else if ((in_array("1", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor'] == null ) && (in_array("2", $estadoInforme) || $informe['FK_Aprobacion_Administrativo'] == null) && (in_array("7", $estadoInforme) || $informe['FK_Persona_Supervisor'] == null) && (in_array("9", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == null) && (in_array("1", $estadoInforme) || in_array("2", $estadoInforme) || in_array("7", $estadoInforme) || in_array("9", $estadoInforme)) && $userId == $informe['FK_Persona']){
		$return .= "<td>";
		#$return .="<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='descargar_informe form-control btn btn-".$claseBotonDescargar."' data-placement='top' data-toggle='tooltip' title='Descargar'>Descargar PDF</a>&nbsp<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='descargar_certificado form-control btn btn-".$claseBotonDescargar."' data-placement='top' data-toggle='tooltip' title='Certificado de Cumplimiento'>Certificado Cumplimiento</a>&nbsp";
		$return .="<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='descargar_certificado form-control btn btn-".$claseBotonDescargar."' data-placement='top' data-toggle='tooltip' title='Certificado de Cumplimiento'>Certificado Cumplimiento</a>&nbsp";
		if ($informe["ultimo"] == "1" && $informe["IN_Certificado_Final"] == "1") {
			$return .="<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe' class='descargar_certificado_final form-control btn btn-".$claseBotonDescargar."' data-placement='top' data-toggle='tooltip' title='Descargar Certificado Final'>Certificado Final</a>&nbsp";
		}

		// if($informe['VC_orfeo_radicado'] != ""){
		// 	$return.= "<a href='#' class='btn btn-info radicar_orfeo' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' title='Radicar en orfeo'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>";
		// }else{
		// 	$return.= "<a href='#' class='btn btn-info consultar_radicado_orfeo' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-codigo_verificacion='".$informe['VC_orfeo_radicado']."' data-codigo_verificacion='".$informe['VC_orfeo_codigo_radicado']."' title='Consultar radicado en orfeo'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>";
		// }
		// $return.= "<a href='#' class='btn btn-info radicar_orfeo' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' title='Radicar en orfeo'><span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a>";
		$return .= $planillas_extras."&nbsp&nbsp".$estado."</td>";
	}
	else{
		if ($userId == $informe['FK_Persona']){
			if ($informe['SM_Finalizado'] == 1)
				$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='visualizar_informe form-control btn btn-primary' data-placement='top' data-toggle='tooltip' title='Visualizar'>Ver</a>&nbsp&nbsp".$estado."</td>";
			else
				$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='editar_informe form-control btn btn-warning' data-placement='top' data-toggle='tooltip' title='Editar'><i class='fa fa-edit'></i></a>&nbsp&nbsp".$estado."</td>";
		}
		else{
			if ($informe['SM_Finalizado'] == 1){
				if ($userId == $informe['FK_Persona_Apoyo_Supervisor'] && !in_array("1", $estadoInforme)){
					$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='revisar_informe form-control btn btn-warning' data-placement='top' data-toggle='tooltip' title='Revisar'>Revisar</a>&nbsp&nbsp".$estado."</td>";
				}
				else{
					if ($userId == $informe['FK_Aprobacion_Administrativo'] && !in_array("2", $estadoInforme)){
						$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='revisar_informe form-control btn btn-warning' data-placement='top' data-toggle='tooltip' title='Revisar'>Revisar</a>&nbsp&nbsp".$estado."</td>";
					}
					else{
						/*if ($userId == $informe['FK_Aprobacion'] && !in_array("3", $estadoInforme)){
							$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='revisar_informe form-control btn btn-warning' data-placement='top' data-toggle='tooltip' title='Revisar'>Revisar</a>&nbsp&nbsp".$estado."</td>";
						}
						else*/
							//Si es el supervisor mostrar boton revisar.
						if ($userId == $informe['FK_Persona_Supervisor']){
							$return .= "<td>";
							if(!in_array("7", $estadoInforme)){
								$return .="<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='revisar_informe form-control btn btn-warning' data-placement='top' data-toggle='tooltip' title='Revisar'>Revisar</a>&nbsp&nbsp";
							}
							else{
								$return .= "<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='visualizar_informe form-control btn btn-primary' data-placement='top' data-toggle='tooltip' title='Visualizar'>Ver</a>";
							}
							if($informe["ultimo"] == "1" && $informe["IN_Certificado_Final"] == NULL && in_array("7", $estadoInforme) && (in_array("1", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor'] == null ) && (in_array("2", $estadoInforme) || $informe['FK_Aprobacion_Administrativo'] == null) && (in_array("7", $estadoInforme) || $informe['FK_Persona_Supervisor'] == null) && (in_array("9", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == null) && (in_array("1", $estadoInforme) || in_array("2", $estadoInforme) || in_array("7", $estadoInforme) || in_array("9", $estadoInforme))){
								$return .="<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe' data-persona_id='".$informe['FK_Persona']."' class='habilitar_certificado_final form-control btn btn-warning' data-placement='top' data-toggle='tooltip' title='Habilitar certificado final'>Habilitar Certificado Final</a>&nbsp&nbsp";
							}
							else{
								if($informe["ultimo"] == "1" && $informe["IN_Certificado_Final"] == 1 && (in_array("1", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor'] == null ) && (in_array("2", $estadoInforme) || $informe['FK_Aprobacion_Administrativo'] == null) && (in_array("7", $estadoInforme) || $informe['FK_Persona_Supervisor'] == null) && (in_array("9", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == null) && (in_array("1", $estadoInforme) || in_array("2", $estadoInforme) || in_array("7", $estadoInforme) || in_array("9", $estadoInforme))){
									$return .="<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe' class='descargar_certificado_final form-control btn btn-".$claseBotonDescargar."' data-placement='top' data-toggle='tooltip' title='Descargar Certificado Final'>Certificado Final</a>&nbsp&nbsp";
								}
							}
							$return .= $estado."</td>";
						}
						else{
							if ($userId == $informe['FK_Persona_Apoyo_Supervisor_Dos'] && !in_array("9", $estadoInforme)){
								$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='revisar_informe form-control btn btn-warning' data-placement='top' data-toggle='tooltip' title='Revisar'>Revisar</a>&nbsp&nbsp".$estado."</td>";
							}
							else{					
								$return .= "<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='visualizar_informe form-control btn btn-primary' data-placement='top' data-toggle='tooltip' title='Visualizar'>Ver</a>&nbsp&nbsp".$estado."</td>";
							}
					  	}	
					}
				}
			}
			else
				$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='form-control btn btn-danger disabled'>Sin Finalizar</a>&nbsp&nbsp".$estado."</td>";
		}
	}
	if ($informe['SM_Estado_Detallado'] == "0") $estado = "<span class='label label-danger'>No Aprobado</span>";

	$estadoInformeDetallado = array();
	$estadoInformeDetallado = $informe['SM_Estado_Detallado'] != null ? explode(",",$informe['SM_Estado_Detallado']) : $estadoInformeDetallado;
	$estado = "";
	$estado .= in_array("1", $estadoInformeDetallado) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Aprobado por el apoyo a la supervisión'>Vo.Bo Apoyo Supervisión</span>" : (in_array("4", $estadoInformeDetallado) ? "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el apoyo a la supervisión'>No.Ap Apoyo Supervisión</span>": "<span class='label label-white' data-toggle='tooltip' title='Sin revisar por el apoyo a la supervisión'>Apoyo Supervisión</span>");
	
	if ($informe['FK_Aprobacion'] > 0) {
		$estado .= in_array("2", $estadoInformeDetallado) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Aprobado por el Apoyo del Apoyo Supervisión'>Vo.Bo Apoyo - Apoyo Supervisión</span>" : (in_array("5", $estadoInformeDetallado) ? "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el Apoyo del Apoyo Supervisión'>No.Ap Apoyo del Apoyo Supervisión</span>" : "<span class='label label-white' data-toggle='tooltip' title='Sin revisar por el Apoyo del Apoyo Supervisión'>Apoyo - Apoyo Supervisión</span>");
	}
	
	$anexo = "";
	if ($informe["VC_Url_Anexo"] != "" && $informe["VC_Url_Anexo"] != 'undefined' && $informe["VC_Url_Anexo"] != null){
		$anexo = '<a href="'.$informe["VC_Url_Anexo"].'"  target="_blank" title="Descargar archivo anexo"  class="btn btn-warning download" data-placement="left" data-toggle="tooltip"><span>Descargar Anexo</span></a>';
	}

	if ($tipo == '3' && $rol == '18'){
		$botonesRechazar = '';
		if (in_array("1", $estadoInformeDetallado))
			$botonesRechazar .= "<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='apoyo-supervisor'  class='rechazar_informe_detallado form-control btn btn-danger' data-placement='top' data-toggle='tooltip' title='Rechazar'>R. apoyo supervisión</a>";
		if ($informe['FK_Aprobacion'] > 0 && in_array("2", $estadoInformeDetallado))
			$botonesRechazar .= "<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='apoyo-apoyo'  class='rechazar_informe_detallado form-control btn btn-danger' data-placement='top' data-toggle='tooltip' title='Rechazar'>R. apoyo-apoyo financiero</a>";
		if ($informe['SM_Finalizado_Detallado'] == 1)
			$botonesRechazar .= "<br><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='finalizado'  class='rechazar_informe_detallado form-control btn btn-danger' data-placement='top' data-toggle='tooltip' title='Rechazar'>Quitar Finalizado</a>";
		/*if (in_array("1", $estadoInformeDetallado) && in_array("2", $estadoInformeDetallado)) || ($informe['FK_Aprobacion'] == null || $informe['FK_Aprobacion'] == 0) && in_array("1", $estadoInformeDetallado)) ) {
			$botonesRechazar .="<br><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='descargar_informe_detallado form-control btn btn-".$claseBotonDescargar."' data-placement='top' data-toggle='tooltip' title='Descargar'>Descargar</a><br>".$anexo;
		}*/
		$return .="<td>".$botonesRechazar."&nbsp&nbsp".$estado."</td>";
	}
	else if ($informe['FK_Aprobacion'] > 0 && in_array("1", $estadoInformeDetallado) && in_array("2", $estadoInformeDetallado)){
		$estado .= $informe['SM_Finalizado_Detallado'] == 1 ? (in_array("2", $estadoInformeDetallado) && in_array("1", $estadoInformeDetallado) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Disponible para descarga'>Aprobado</span>" :"<span class='label label-warning' data-toggle='tooltip' title='Requiere revisiones'>Enviado</span>") :"<span class='label label-white' data-toggle='tooltip' title='Formato sin finalizar '>Sin Enviar</span>";
		$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='descargar_informe_detallado form-control btn btn-".$claseBotonDescargar."' data-placement='top' data-toggle='tooltip' title='Descargar'>Descargar</a>&nbsp&nbsp".$estado."&nbsp".$anexo."</td>";
	}
	else{
		/*
		if (($informe['FK_Aprobacion'] == null || $informe['FK_Aprobacion'] == 0) && in_array("1", $estadoInformeDetallado)) {
			$estado .= $informe['SM_Finalizado_Detallado'] == 1 ? (in_array("1", $estadoInformeDetallado) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Disponible para descarga'>Aprobado</span>" :"<span class='label label-warning' data-toggle='tooltip' title='Requiere revisiones'>Enviado</span>") :"<span class='label label-white' data-toggle='tooltip' title='Formato sin finalizar '>Sin Enviar</span>";
			$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='descargar_informe_detallado form-control btn btn-".$claseBotonDescargar."' data-placement='top' data-toggle='tooltip' title='Descargar'>Descargar</a>&nbsp&nbsp".$estado."&nbsp".$anexo."</td>";
		}
		else{
				//var_dump($informe['FK_Persona_Apoyo_Supervisor']);
			$estado .= $informe['SM_Finalizado_Detallado'] == 1 ? "<span class='label label-warning' data-toggle='tooltip' title='Requiere revisiones'>Enviado</span>" :"<span class='label label-white' data-toggle='tooltip' title='Formato sin finalizar '>Sin Enviar</span>";
			if ($userId == $informe['FK_Persona']){				
				if ($informe['FK_Informe_Detallado'] != 1)
					$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='editar_informe_detallado form-control btn btn-default' data-placement='top' data-toggle='tooltip'>Diligenciar</a>&nbsp".$anexo."</td>";
				else{
					if ($informe['SM_Finalizado_Detallado'] == 1)
						$return .="<td>$estado".$anexo."</td>";
					else
						$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='editar_informe_detallado form-control btn btn-warning' data-placement='top' data-toggle='tooltip' title='Editar'><i class='fa fa-edit'></i></a>&nbsp&nbsp".$estado."&nbsp".$anexo."</td>";
				}
			}
			else{
				if ($informe['SM_Finalizado_Detallado'] == 1){
					if ($userId == $informe['FK_Persona_Apoyo_Supervisor'] && !in_array("1", $estadoInformeDetallado)){
						$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='revisar_informe_detallado form-control btn btn-warning' data-placement='top' data-toggle='tooltip' title='Revisar'>Revisar</a>&nbsp&nbsp".$estado."&nbsp".$anexo."</td>";
					}
					else{
						
						if ($userId == $informe['FK_Aprobacion'] && !in_array("2", $estadoInformeDetallado)){
							$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='revisar_informe_detallado form-control btn btn-warning' data-placement='top' data-toggle='tooltip' title='Revisar'>Revisar</a>&nbsp&nbsp".$estado."&nbsp".$anexo."</td>";
						}
						else
							$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='visualizar_informe_detallado form-control btn btn-primary' data-placement='top' data-toggle='tooltip' title='Visualizar'>Ver</a>".$estado."&nbsp".$anexo."</td>";
					}

				}
				else
					$return .="<td><a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='form-control btn btn-danger disabled'>Sin Finalizar</a>&nbsp&nbsp</td>";
			}
		}
		*/
	}
	$return .="</tr>";

	return $return;
}

echo $return;