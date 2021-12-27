<?

$infoRadicado = $this->getVariables()['infoRadicado'];
$cedula = $this->getVariables()['cedula'];
$informe = $this->getVariables()['informe'];
$userId = $this->getVariables()['userId'];
if($infoRadicado === false){
    $return = '
        <p>No se encontraron datos en ORFEO. '.$infoRadicado->message.'</p>
    ';
}else{

    $return = '
        <table class="table table-hover" cellspacing="0" width="100%"  >
        <thead>
            <tr>
                <th><strong>Item</strong></th>            
                <th><strong>Valor</strong></th>                    
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Radicado</td>            
                <td id="numero_radicado">'.$infoRadicado->numero_radicado.'</td>                    
            </tr>
            <tr>
                <td>Fecha Radicado</td>            
                <td id="fecha_radicado">'.$infoRadicado->fecha_radicado.'</td>                    
            </tr>	
            <tr>
                <td>Asunto</td>            
                <td id="asunto">'.$infoRadicado->asunto.'</td>                    
            </tr>	
            <tr>
                <td>Validado</td>            
                <td id="validado">'.$infoRadicado->validado.'</td>                    
            </tr>	
            <tr>
                <td>Anulacion</td>            
                <td id="anulacion">'.$infoRadicado->anulacion.'</td>                    
            </tr>																																																		
        </tbody>											
        </table>
    ';
	$botonRadicado = '';
	$estadoInforme = [];
	$estadoInforme = $informe['SM_Estado'] != null ? explode(",",$informe['SM_Estado']) : $estadoInforme;	

	$esInformeFinalizado = esInformeFinalizado($informe,$estadoInforme);

	$estaFirmadoEnOrfeo = false;
	if($infoRadicado->validado == 'Documento Firmado electrónicamente' ||
	   strpos($infoRadicado->validado,'VALIDADO') !==  FALSE){
		$estaFirmadoEnOrfeo = true;
	}	
	

	
	$botonAnulado = '';
	$tipoLabel = 'success';
	$textoRadicado = $infoRadicado->asunto.", ".$infoRadicado->validado." - ".$infoRadicado->fecha_radicado.". Anulado: ".$infoRadicado->anulacion;
	if(strpos($infoRadicado->anulacion,'ANULADO') !== false){
		$botonAnulado.= "
            <button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' class='reiniciar_aprobaciones btn btn-danger btn_8' data-placement='top' 
                    data-toggle='tooltip' title='Reiniciar el proceso de aprobaciones'>
                Reiniciar Aprobaciones &nbsp; <i class='fas fa-undo'></i>
            </button>";
		$tipoLabel = 'danger';
	}else if(!$estaFirmadoEnOrfeo && $esInformeFinalizado){
		$botonRadicado.= "
			<button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' class='firmar_radicado btn btn-info btn_8' data-placement='top' 
					data-toggle='tooltip' title='Firmar Documento en Orfeo'>
				Firmar en ORFEO &nbsp; <i class='fas fa-file-signature'></i>
			</button>";
		$botonRadicado.= "
            <button type='button' data-informe_id='".$informe['PK_Id_Tabla']."' data-cedula='".$cedula."' 
                    data-radicado='1' class='resolicitar_codigo btn btn-danger btn_8' data-placement='top' 
                    data-toggle='tooltip' title='Volver a solicitar codigo para firmar '>
                Solicitar Código &nbsp; <i class='fas fa-signature'></i>
            </button>";
		
	}   

    $return .= $botonRadicado.$botonAnulado;
}


function esInformeFinalizado($informe){


	#Valida si es la ultima aprobacion
	$cantidadFirmas = 1;
	$cantidadFirmas += $informe['FK_Persona_Apoyo_Supervisor'] != null ? 1 : 0;
	$cantidadFirmas += $informe['FK_Aprobacion_Administrativo'] != null && $informe['IN_Firma_Administrativo'] == 1  ? 1 : 0;
	$cantidadFirmas += $informe['FK_Persona_Supervisor'] != null ? 1 : 0;
	$cantidadFirmas += $informe['FK_Persona_Apoyo_Supervisor_Dos'] != null ? 1 : 0;

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

	return $cantidadFirmas == $numeroFirmantes;
}

$html = $return;
