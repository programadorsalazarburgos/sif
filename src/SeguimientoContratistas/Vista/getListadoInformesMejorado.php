<?php
$return = "";
$userId = $this->getVariables()['userId'];
$rol = $this->getVariables()['rol'];
$cedula = $this->getVariables()['cedula'];
#var_dump($userId);
#die();

foreach ($this->getVariables()['arrayInformes'] as $informe)
{
	$estadoInforme = array();
	$estadoInforme = $informe['SM_Estado'] != null ? explode(",",$informe['SM_Estado']) : $estadoInforme;	
	$botonRadicado = '';
	
	/*$esInformeFinalizado = esInformeFinalizado($informe,$estadoInforme);
	$transaccion = obtenerIdTransaccion($informe,$userId);

	
	$noEstaFirmadoEnOrfeo = strpos($informe['validado'],"Documento sin Firmar") !== false;
	$numeroAprobaciones =  count(obtenerArrayAprobacionesFirmas($informe)); #mas la firma de contratista
		
	if($noEstaFirmadoEnOrfeo && $esInformeFinalizado){
		if(($numeroAprobaciones+1) ==$numeroFirmas){
			$botonRadicado.= "<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' class='firmar_radicado btn btn-info btn_8 data-placement='top' data-toggle='tooltip' title='Firmar Documento en Orfeo'><i class='fas fa-file-signature'></i></button>";
		}
		$ultimaFirma = esUltimaFirma($informe);
		$botonRadicado.= "<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' data-cedula='".$cedula."' data-transaccion='".$transaccion."' data-radicado='1' data-ultima_firma='".$ultimaFirma['esUltimaFirma']."' class='resolicitar_codigo btn btn-danger data-placement='top' data-toggle='tooltip' title='Volver a solicitar codigo para firmar, ".$ultimaFirma['mensaje']." '><i class='fas fa-signature'></i></button>";
		
	}
	$botonRadicado .= "<span class='label label-danger' data-toggle='tooltip' title='".$informe['validado']."'>".$informe['validado']."</span>";
	
	$botonAnulado = '';
	$tipoLabel = 'success';
	$textoRadicado = $informe['asunto'].", ".$informe['validado']." - ".$informe['fecha_radicado'].". Anulado: ".$informe['anulacion'];
	if(strpos($informe['anulacion'],'ANULADO') !== false){
		$botonAnulado.= "<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' class='reiniciar_aprobaciones btn btn-danger btn_8 data-placement='top' data-toggle='tooltip' title='Reiniciar el proceso de aprobaciones'><i class='fas fa-undo'></i></button>";
		$tipoLabel = 'danger';
	}
	*/
	#Valida si es la ultima aprobacion
	$cantidadFirmas = 1;
	$cantidadFirmas += $informe['FK_Persona_Apoyo_Supervisor'] != null ? 1 : 0;
	$cantidadFirmas += $informe['FK_Aprobacion_Administrativo'] != null && $informe['IN_Firma_Administrativo'] == 1  ? 1 : 0;
	$cantidadFirmas += $informe['FK_Persona_Supervisor'] != null ? 1 : 0;
	$cantidadFirmas += $informe['FK_Persona_Apoyo_Supervisor_Dos'] != null ? 1 : 0;

	$numeroFirmas = count(explode(',',$informe['firmas']));	
	$aprobadoFinal   =  (($numeroFirmas+1)==$cantidadFirmas) ? 1 : 0;

	#Ids de firmantes
	$firmantesInforme = [];
	$firmantesInforme[] = $informe['FK_Persona'];
	if($informe['FK_Persona_Apoyo_Supervisor'] != null){
		$firmantesInforme[] = $informe['FK_Persona_Apoyo_Supervisor'];
	}
	if($informe['FK_Aprobacion_Administrativo'] != null && $informe['IN_Firma_Administrativo'] == 1){
		$firmantesInforme[] = $informe['FK_Aprobacion_Administrativo'];
	}
	if($informe['FK_Persona_Supervisor'] != null){
		$firmantesInforme[] = $informe['FK_Persona_Supervisor'];
	}
	if($informe['FK_Persona_Apoyo_Supervisor_Dos'] != null){

		$firmantesInforme[] = $informe['FK_Persona_Apoyo_Supervisor_Dos'];	
	}
	
	$firmantes = explode(',',$informe['firmantes']);
	#$numeroFirmantes = $firmantes[0] == null ? 0 : count($firmantes);	

	$numeroFirmantes = 0;
	foreach($firmantesInforme as $aprobador){
		foreach($firmantes as $firmante){
			if($firmante == $aprobador){
				$numeroFirmantes++;	
			}
		}
	}



	$firmasFaltantes = $cantidadFirmas - $numeroFirmantes;
	$botonOrfeo = "";
	$tieneRadicadoOrfeo = strlen($informe['VC_orfeo_radicado'])>0;
	if($tieneRadicadoOrfeo){
		
		$botonOrfeo = "
					<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."'  data-radicado='".$informe['VC_orfeo_radicado']."'  data-radicado_verificacion='".$informe['VC_orfeo_codigo_verificacion']."'
						class='ver_datos_orfeo btn btn-info data-placement='top' data-toggle='tooltip' title='Ver datos de Orfeo'>
						<i class='fas fa-file-alt'></i>
					</button>";
	}

	$estado = "";
	if ((in_array("1", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor'] == null ) && 
		(in_array("2", $estadoInforme) || $informe['FK_Aprobacion_Administrativo'] == null) && 
		(in_array("7", $estadoInforme) || $informe['FK_Persona_Supervisor'] == null) && 
		(in_array("9", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == null ))
		$claseBotonDescargar = $informe["ultimodescarga"] == 1? "success":"old";
	else
		$claseBotonDescargar = "success";

	//Etiquetas del estado del informe.
	$estado .= in_array("1", $estadoInforme) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Aprobado por el apoyo a la supervisión'>Vo.Bo Apoyo Supervisión</span>" : (in_array("4", $estadoInforme) ? "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el apoyo a la supervisión'>No.Ap Apoyo Supervisión</span>": ($informe['FK_Persona_Apoyo_Supervisor'] != null ? "<span class='label label-white' data-toggle='tooltip' title='Sin revisar por el apoyo a la supervisión'>Apoyo Supervisión</span>": ""));
	$estado .= in_array("9", $estadoInforme) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Aprobado por el apoyo a la supervisión Dos'>Vo.Bo Apoyo Supervisión Dos</span>" : (in_array("0", $estadoInforme) ? "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el Supervisor Dos'>No.Ap Apoyo Supervisión Dos</span>" : ($informe['FK_Persona_Apoyo_Supervisor_Dos'] != null ? "<span class='label label-white' data-toggle='tooltip' title='Sin revisar por el apoyo a la supervisión'>Apoyo Supervisión Dos</span>" : ""));	
	$estado .= in_array("2", $estadoInforme) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Aprobado por el apoyo financiero'>Vo.Bo Apoyo Financiero</span>" : (in_array("5", $estadoInforme) ? "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el apoyo Financiero'>No.Ap Apoyo Financiero</span>" : ($informe['FK_Aprobacion_Administrativo'] != null ? "<span class='label label-white' data-toggle='tooltip' title='Sin revisar por el apoyo financiero'>Apoyo Financiero</span>":""));
	$estado .= in_array("7", $estadoInforme) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Aprobado por el Supervisor'>Vo.Bo Supervisor</span>" : (in_array("8", $estadoInforme) ? "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el Supervisor'>No.Ap Supervisor</span>" : ($informe['FK_Persona_Supervisor'] != null ? "<span class='label label-white' data-toggle='tooltip' title='Sin revisar por el Supervisor'>Supervisor</span>" : ""));	
	$estado .= $informe['SM_Finalizado'] == 1 ? ((in_array("1", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor'] == null ) && (in_array("2", $estadoInforme) || $informe['FK_Aprobacion_Administrativo'] == null) && (in_array("7", $estadoInforme) || $informe['FK_Persona_Supervisor'] == null) && (in_array("9", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == null) && (in_array("1", $estadoInforme) || in_array("2", $estadoInforme) || in_array("7", $estadoInforme) || in_array("9", $estadoInforme)) ? "<span class='label label-".$claseBotonDescargar."' data-toggle='tooltip' title='Disponible para descarga'>Aprobado</span>":"<span class='label label-warning' data-toggle='tooltip' title='Requiere revisiones'>Enviado</span>"):"<span class='label label-white' data-toggle='tooltip' title='Formato sin finalizar'>Sin Enviar</span>";
	 

	$informe["ultimo"] = $informe["VC_Pago_Numero"] >= $informe["VC_Pago_De_Total"] ? 1 : 0;

	$return .="<tr>";
	$return .="<td>".$informe['PK_Id_Tabla']."</td>";
	$return .="<td>".$informe['VC_identificacion']."</td>";
	$return .="<td>".$informe['nombre_contratista']."</td>";
	$return .="<td>".$informe['VC_Numero_Contrato']."</td>";
	$return .="<td>".$informe['VC_Periodo_Inicio']." - ".$informe['VC_Periodo_Fin']."</td>";
	$return .="<td>".$informe['DA_Subida'];
	
	$return .="</td>";
	$return .="<td>
				<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' class='ver_historial btn btn-success' data-placement='top' data-toggle='tooltip' title='ver Historial de aprobaciones'>
					<i class='fab fa-stack-overflow'></i>
				</button>".
				$botonOrfeo.
				"<span class='label label-default' data-toggle='tooltip' title='Radicado de ORFEO'>".$informe['VC_orfeo_radicado']."</span>"			
			 ."</td>";
	$botonFirmar = "";
	if($informe['SM_Finalizado'] ==1){
		$transaccion = obtenerIdTransaccion($informe,$userId);
		$botonFirmar = "
			<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' data-cedula='".$cedula."' data-transaccion='".$transaccion."' 
				data-radicado='1' class='resolicitar_codigo btn btn-danger btn_8' data-placement='top' 
				data-toggle='tooltip' title='Volver a solicitar codigo para firmar'>
				Firmar <i class='fas fa-signature'></i>
			</button>	
		";
	}

	$return .="
			<td>
				<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' data-firmantes_informe='".$firmantesInforme."'
					data-firmaron='".$informe['firmantes']."'
					class='ver_firmantes btn btn-primary btn_8' data-placement='top' data-toggle='tooltip' title='ver Firmantes'>
					Firmas Faltantes <span class='badge'>".$firmasFaltantes."</span>
				</button>
				".$botonFirmar."			 	
		  	</td>";

	if ((in_array("1", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor'] == null ) && 
		(in_array("2", $estadoInforme) || $informe['FK_Aprobacion_Administrativo'] == null) && 
		(in_array("7", $estadoInforme) || $informe['FK_Persona_Supervisor'] == null) && 
		(in_array("9", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == null) && 
		(in_array("1", $estadoInforme) || in_array("2", $estadoInforme) || in_array("7", $estadoInforme) || in_array("9", $estadoInforme)) && $userId == $informe['FK_Persona'])
	{
		$return .= "<td>";
		#if ($userId == $informe['FK_Persona_Apoyo_Supervisor'] && !in_array("1", $estadoInforme) && !$tieneRadicadoOrfeo		
		#$return .="<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='descargar_informe form-control btn btn-".$claseBotonDescargar."' data-placement='top' data-toggle='tooltip' title='Descargar'>Descargar PDF</a>&nbsp<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe'  class='descargar_certificado form-control btn btn-".$claseBotonDescargar."' data-placement='top' data-toggle='tooltip' title='Certificado de Cumplimiento'>Certificado Cumplimiento</a>&nbsp";
		/*
		$contenidoBoton = [
			'aprobadoFinal'=>$aprobadoFinal,
			'idInforme'=>$informe['PK_Id_Tabla'],
			'class'=> 'descargar_informe',
			'classBoton'=>'btn-success btn_8',
			'title'=>'Descargar Informe',
			'classIcon'=>'',
			'texto'=>'Descargar PDF',
			'estado'=>'',
			'firma'=>0, 
		];
		$return .= botonAccionesPrincipales($contenidoBoton);			
		
		$contenidoBoton = [
			'aprobadoFinal'=>$aprobadoFinal,
			'idInforme'=>$informe['PK_Id_Tabla'],
			'class'=> 'descargar_certificado',
			'classBoton'=>'btn_8 btn-'.$claseBotonDescargar,
			'title'=>'Descargar Certificado de Cumplimiento',
			'classIcon'=>'',
			'texto'=>'Certificado de Cumplimiento',
			'estado'=>'',
			'firma'=>0,
		];
		$return .= botonAccionesPrincipales($contenidoBoton);
		*/		
		
		if ($informe["ultimo"] == "1" && $informe["IN_Certificado_Final"] == "1") {
			$contenidoBoton = [
				'aprobadoFinal'=>$aprobadoFinal,
				'idInforme'=>$informe['PK_Id_Tabla'],
				'class'=> 'descargar_certificado_final',
				'classBoton'=>'btn_8 btn-'.$claseBotonDescargar,
				'title'=>'Descargar Certificado Final',
				'classIcon'=>'',
				'texto'=>'Certificado Final',
				'estado'=>'',
				'firma'=>0,
			];
			$return .= botonAccionesPrincipales($contenidoBoton);	
		}
		$return .= $estado."</td>";
	}else{

		if ($userId == $informe['FK_Persona']){

			$contenidoBoton = [
				'aprobadoFinal'=>$aprobadoFinal,
				'idInforme'=>$informe['PK_Id_Tabla'],
				'class'=> ($informe['SM_Finalizado'] == 1) ? 'visualizar_informe' : 'editar_informe',
				'classBoton'=>($informe['SM_Finalizado'] == 1) ? 'btn_8 btn-primary': 'btn_8 btn-warning',
				'title'=>($informe['SM_Finalizado'] == 1) ? 'Visualizar': 'Editar',
				'classIcon'=>($informe['SM_Finalizado'] == 1) ? 'fa fa-eye': 'fa fa-edit',
				'texto'=>'',
				'estado'=>$estado,
				'firma'=>1,
			];
			$return .= "<td>".botonAccionesPrincipales($contenidoBoton)."</td>";				
		}
		else{
			if ($informe['SM_Finalizado'] == 1){
				if ($userId == $informe['FK_Persona_Apoyo_Supervisor'] && !in_array("1", $estadoInforme) && !$tieneRadicadoOrfeo){
					$contenidoBoton = [
						'aprobadoFinal'=>$aprobadoFinal,
						'idInforme'=>$informe['PK_Id_Tabla'],
						'class'=> 'revisar_informe',
						'classBoton'=>'btn_8 btn-warning',
						'title'=>'Revisar',
						'classIcon'=>'',
						'texto'=>'Revisar',
						'estado'=>$estado,
						'firma'=>1,
					];
					$return .= "<td>".botonAccionesPrincipales($contenidoBoton)."</td>";	

				}
				else{
					if ($userId == $informe['FK_Aprobacion_Administrativo'] && !in_array("2", $estadoInforme) && !$tieneRadicadoOrfeo){
						$firma = $informe['IN_Firma_Administrativo'] == "1" ? 1 : 0;
						$contenidoBoton = [
							'aprobadoFinal'=>$aprobadoFinal,
							'idInforme'=>$informe['PK_Id_Tabla'],
							'class'=> 'revisar_informe',
							'classBoton'=>'btn_8 btn-warning',
							'title'=>'Revisar',
							'classIcon'=>'',
							'texto'=>'Revisar',
							'estado'=>$estado,
							'firma'=>$firma,
						];
						$return .= "<td>".botonAccionesPrincipales($contenidoBoton)."</td>";	
					}
					else{					
						if ($userId == $informe['FK_Persona_Supervisor']){
							$return .= "<td>";
							if(!in_array("7", $estadoInforme) && !$tieneRadicadoOrfeo){
								$contenidoBoton = [
									'aprobadoFinal'=>$aprobadoFinal,
									'idInforme'=>$informe['PK_Id_Tabla'],
									'class'=> 'revisar_informe',
									'classBoton'=>'btn_8 btn-warning',
									'title'=>'Revisar',
									'classIcon'=>'',
									'texto'=>'Revisar',
									'estado'=>$estado,
									'firma'=>1,
								];
								$return .= botonAccionesPrincipales($contenidoBoton);	
							}
							else{
								$contenidoBoton = [
									'aprobadoFinal'=>$aprobadoFinal,
									'idInforme'=>$informe['PK_Id_Tabla'],
									'class'=> 'visualizar_informe',
									'classBoton'=>'btn_8 btn-primary',
									'title'=>'Visualizar',
									'classIcon'=>'fa fa-eye',
									'texto'=>'Ver',
									'estado'=>'',
									'firma'=>1,
								];								
								$return .= botonAccionesPrincipales($contenidoBoton);	
							}
							if($informe["ultimo"] == "1" && $informe["IN_Certificado_Final"] == NULL && in_array("7", $estadoInforme) && 
								(in_array("1", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor'] == null ) && 
								(in_array("2", $estadoInforme) || $informe['FK_Aprobacion_Administrativo'] == null) && 
								(in_array("7", $estadoInforme) || $informe['FK_Persona_Supervisor'] == null) && 
								(in_array("9", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == null) && 
								(in_array("1", $estadoInforme) || in_array("2", $estadoInforme) || in_array("7", $estadoInforme) || in_array("9", $estadoInforme))){
								$return .="
								<a href='#' data-aprobadoFinal='".$aprobadoFinal."' data-informe_id='".$informe['PK_Id_Tabla']."' data-tipo='informe' 
									data-persona_id='".$informe['FK_Persona']."' 
									class='habilitar_certificado_final form-control btn btn-warning btn_8' data-placement='top' data-toggle='tooltip' title='Habilitar certificado final'>
									Habilitar Certificado Final
								</a>&nbsp&nbsp";
							}
							else{
								if($informe["ultimo"] == "1" && $informe["IN_Certificado_Final"] == 1 && 
								(in_array("1", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor'] == null ) && 
								(in_array("2", $estadoInforme) || $informe['FK_Aprobacion_Administrativo'] == null) && 
								(in_array("7", $estadoInforme) || $informe['FK_Persona_Supervisor'] == null) && 
								(in_array("9", $estadoInforme) || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == null) && 
								(in_array("1", $estadoInforme) || in_array("2", $estadoInforme) || in_array("7", $estadoInforme) || in_array("9", $estadoInforme))){

									$contenidoBoton = [
										'aprobadoFinal'=>$aprobadoFinal,
										'idInforme'=>$informe['PK_Id_Tabla'],
										'class'=> 'descargar_certificado_final',
										'classBoton'=>'btn_8 btn-'.$claseBotonDescargar,
										'title'=>'Descargar Certificado Final',
										'classIcon'=>'',
										'texto'=>'Certificado Final',
										'estado'=>'',
										'firma'=>0,
									];								
									$return .= botonAccionesPrincipales($contenidoBoton);	
								}
							}
							$return .= "</td>";
						}
						else{
							if ($userId == $informe['FK_Persona_Apoyo_Supervisor_Dos'] && !in_array("9", $estadoInforme) && !$tieneRadicadoOrfeo){
								$contenidoBoton = [
									'aprobadoFinal'=>$aprobadoFinal,
									'idInforme'=>$informe['PK_Id_Tabla'],
									'class'=> 'revisar_informe',
									'classBoton'=>'btn_8 btn-warning',
									'title'=>'Revisar',
									'classIcon'=>'',
									'texto'=>'Revisar',
									'estado'=>$estado,
									'firma'=>1,
								];								
								$return .= "<td>".botonAccionesPrincipales($contenidoBoton)."</td>";	
							}
							else if ($userId == $informe['FK_Aprobacion'] && !in_array("3", $estadoInforme) && !$tieneRadicadoOrfeo){
								$contenidoBoton = [
									'aprobadoFinal'=>$aprobadoFinal,
									'idInforme'=>$informe['PK_Id_Tabla'],
									'class'=> 'revisar_informe',
									'classBoton'=>'btn_8 btn-warning',
									'title'=>'Revisar',
									'classIcon'=>'',
									'texto'=>'Revisar',
									'estado'=>$estado,
									'firma'=>0,
								];
								$return .= "<td>".botonAccionesPrincipales($contenidoBoton)."</td>";								
							}	
							else{	
								$contenidoBoton = [
									'aprobadoFinal'=>$aprobadoFinal,
									'idInforme'=>$informe['PK_Id_Tabla'],
									'class'=> 'visualizar_informe',
									'classBoton'=>'btn_8 btn-primary',
									'title'=>'Visualizar',
									'classIcon'=>'',
									'texto'=>'Visualizar',
									'estado'=>$estado,
									'firma'=>0,
								];								
								$return .= "<td>".botonAccionesPrincipales($contenidoBoton)."</td>";												
							}
					  	}	
					}
				}
			}
			else{
				$contenidoBoton = [
					'aprobadoFinal'=>$aprobadoFinal,
					'idInforme'=>$informe['PK_Id_Tabla'],
					'class'=> 'disabled',
					'classBoton'=>'btn_8 btn-danger',
					'title'=>'Sin Finalizar',
					'classIcon'=>'',
					'texto'=>'Sin Finalizar',
					'estado'=>$estado,
					'firma'=>0,
				];								
				$return .= "<td>".botonAccionesPrincipales($contenidoBoton)."</td>";					
			}
		}
	}

	$return .="</tr>";
}			 
	 

function esInformeFinalizado($informe,$estadoInforme){
	$aprobaciones =  obtenerArrayAprobaciones($informe); 

	$numeroAprobaciones = 0;
	foreach($aprobaciones as $aprobacion){
		foreach($estadoInforme as $estado){
			if($aprobacion == $estado){
				$numeroAprobaciones++;
			}
		}
	}
	

	return $numeroAprobaciones == count($aprobaciones);
}

function obtenerArrayAprobaciones($informe){
	$aprobaciones = [];
	if($informe['FK_Persona_Apoyo_Supervisor'] != null){
		$aprobaciones[] = 1;
	}
	if($informe['FK_Persona_Apoyo_Supervisor_Dos'] != null){
		$aprobaciones[] = 9;
	}
	if($informe['FK_Aprobacion_Administrativo'] != null){
		$aprobaciones[] = 2;
	}
	if($informe['FK_Persona_Supervisor'] != null){
		$aprobaciones[] = 7;
	}	
	return $aprobaciones;
}

#El apoyo no debe administrativo no debe firmar
function obtenerArrayAprobacionesFirmas($informe){
	$aprobaciones = [];
	if($informe['FK_Persona_Apoyo_Supervisor'] != null){
		$aprobaciones[] = 1;
	}
	if($informe['FK_Persona_Apoyo_Supervisor_Dos'] != null){
		$aprobaciones[] = 9;
	}
	if($informe['FK_Aprobacion_Administrativo'] != null){
		#$aprobaciones[] = 2;
	}
	if($informe['FK_Persona_Supervisor'] != null){
		$aprobaciones[] = 7;
	}	
	return $aprobaciones;
}

function obtenerIdTransaccion($informe,$userId){
	$transaccion = 0;
	if($informe['FK_Persona_Apoyo_Supervisor'] == $userId || $informe['FK_Persona_Apoyo_Supervisor_Dos'] == $userId || $informe['FK_Aprobacion_Administrativo'] == $userId  ){
		$transaccion = 1;
	}else if($informe['FK_Persona_Supervisor'] == $userId){
		$transaccion = 4;
	}else{ //contratista
		$transaccion = 10;
	}
	return $transaccion;
}

function esUltimaFirma($informe){
	$aprobaciones = 1; #El 1 es la firma del contratista
	if($informe['FK_Persona_Apoyo_Supervisor'] != null){
		$aprobaciones++;
	}
	if($informe['FK_Persona_Apoyo_Supervisor_Dos'] != null){
		$aprobaciones++;
	}
	if($informe['FK_Aprobacion_Administrativo'] != null){
		//$aprobaciones++;
	}
	if($informe['FK_Persona_Supervisor'] != null){
		$aprobaciones++;
	}

	$ultimasFirmas = explode(',',$informe['firmas']);
	$fechaDespuesRadicado = 0;
	$fechaRadicadoTime = new \DateTime($informe['DT_firma_orfeo']);
	foreach($ultimasFirmas as $fechaFirma){
		$fechaTime = new \DateTime($fechaFirma);
		if($fechaTime  > $fechaRadicadoTime ){
			$fechaDespuesRadicado++;
		}
	}
	$esUltimaFirma = $aprobaciones == $fechaDespuesRadicado+1;
	$restaFirmas =  $aprobaciones - $fechaDespuesRadicado;
	return ['esUltimaFirma'=>intval($esUltimaFirma),'mensaje'=>'faltan ('.$restaFirmas.') firmas posteriores a '.$informe['DT_firma_orfeo']];
}

function botonAccionesPrincipales($c){
	//var_dump($c['estado']);
	//die();
	$icon = $c['classIcon'] != '' ? "<i class='".$c['classIcon']."'></i>" : "";
	return "
		<a href='#' data-aprobadoFinal='".$c['aprobadoFinal']."' data-informe_id='".$c['idInforme']."'  data-firma='".$c['firma']."' data-tipo='informe'  
			class='".$c['class']." form-control btn ".$c['classBoton']."' data-placement='top' data-toggle='tooltip' title='".$c['title']."'>
			".$icon.$c['texto'].
		"</a>&nbsp&nbsp".$c['estado'];	
}

echo $return;