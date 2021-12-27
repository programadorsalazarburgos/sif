<?php
include_once('../../Modelo/Organizaciones/Acceso_Datos.php');
if (isset($_POST['opcion'])){
	switch ($_POST['opcion']) {
		case 'guardarInformeGestion':
		echo guardarInformeGestion();
		break;
		case 'getInfoContractual':
		echo getInfoContractual();
		break;
		case 'getOrganizacionesAnio':
		echo getOrganizacionesAnio();
		break;
		case 'getFormatosAdministrativosOrganizacion':
		echo getFormatosAdministrativosOrganizacion();
		break;
		case 'guardarRevisionFA':
		echo guardarRevisionFA();
		break;
		case 'getInformeGestion':
		echo getInformeGestion();
		break;
		case 'getPeriodosSeguimientosOrganizacion':
		echo getPeriodosSeguimientosOrganizacion();
		break;
		case 'guardarInformeProyeccion':
		echo guardarInformeProyeccion();
		break;
		case 'getOrganizacionData':
		echo getOrganizacionData();
		break;
		case 'getInformeProyeccion':
		echo getInformeProyeccion();
		break;
		case 'getInfoExtra':
		echo getInfoExtra();
		break;
		case 'actualizarEstadoFAS':
		echo actualizarEstadoFAS();
		break;
		case 'actualizarEstadoArchivo':
		echo actualizarEstadoArchivo();
		break;
		case 'consultarSeguimientoPropuesta':
		echo consultarSeguimientoPropuesta();
		break;
		default:
		echo "Opcion no existente.";
		break;
	}
}
/***************************************************************************
Metodo encargado de consultar el encabezado del informe de gestión de una organizacion
***************************************************************************/
function getInfoContractual()
{
	$id_organizacion = $_POST['id_organizacion'];
	$id_informe_gestion = $_POST['id_informe_gestion'];
	$datos = getInformacionContractual($id_organizacion, $id_informe_gestion);
	if (sizeof($datos) > 0)
		$datos = $datos[sizeof($datos)-1];
	else
		$datos = null;
	return json_encode($datos);
}

/***************************************************************************
Metodo encargado de consultar toda la informacion del seguimiento un periodo.
***************************************************************************/
function getInformeGestion()
{
	$id_informe_gestion = $_POST['id_informe_gestion'];
	$datos = getInformeDeGestion($id_informe_gestion);
	if (sizeof($datos) > 0)
		$datos = $datos[sizeof($datos)-1];
	else
		$datos = null;
	return json_encode($datos);
}

/***************************************************************************
Metodo encargado de consultar toda la informacion de los seguimientos APROBADOS de una organización.
***************************************************************************/
function getPeriodosSeguimientosOrganizacion()
{
	$id_organizacion = $_POST['id_organizacion'];
	$year = $_POST['year'];
	$datos = getPeriodosSeguimientosDeOrganizacion($id_organizacion,$year);

	return json_encode($datos);
}

/***************************************************************************
Metodo encargado de consultar toda la informacion de un seguimiento a la propuesta específico de una organización.
***************************************************************************/
function getSeguimientoPeriodo()
{
	$id_periodo = $_POST['id_periodo'];
	$datos = getSeguimientoDePeriodo($id_periodo);

	return json_encode($datos);
}

/***************************************************************************
Metodo encargado de realizar el almacenamiento del Informe de Gestión realizado
***************************************************************************/
function guardarInformeGestion()
{
  //DATOS INFORMACION CONTRACTUAL
	$id_info_contractual = $_POST['bandera_existencia_info_contractual'];
	$bandera_ultimo_informe = $_POST['bandera_ultimo_informe'];
	date_default_timezone_set('America/Bogota');
	$Id_Usuario = $_POST['id_usuario'];
	$Nombre_Proyecto = $_POST['TXTA_NOMBRE_PROYECTO'];
	$Representante_Legal = $_POST['TX_Nombre_Representante'];
	$Objeto_Contrato =$_POST['TXTA_OBJETO_CONTRATO'];
	$Obligaciones =$_POST['json_Obligaciones_Especificas'];
	$Datos_Cifras = "";
	$Fecha_Registro = date("Y-m-d H:i:s");

  //DATOS INFORME DE GESTION
	$Numero_Informe = $_POST['Numero_Informe'];
	$Periodo   =$_POST['mes'];
	$Anio   =$_POST['SL_Anio_Informe'];
	$Correo      =$_POST['TX_Correo'];
	$DetalleActividades    =$_POST['json_detalle'];

	$ActividadesRealizadas = "";
	$PoblacionBeneficiada = "";
	$ArtistasBeneficiados = "";
	$Difusion = "";

	$id_seguimiento_propuesta = $_POST['bandera_existencia_seguimiento_propuesta'];

	if (isset($_POST['TXTA_Actividades_Realizadas']) && isset($_POST['TXTA_Poblacion_Beneficiada']) && isset($_POST['TX_Artistas_Beneficiados']) && isset($_POST['TX_Difusion']) && isset($_POST['json_cifras_recursos'])){
		$ActividadesRealizadas    = $_POST['TXTA_Actividades_Realizadas'];
		$PoblacionBeneficiada =$_POST['TXTA_Poblacion_Beneficiada'];
		$ArtistasBeneficiados =$_POST['TX_Artistas_Beneficiados'];
		$Difusion =$_POST['TX_Difusion'];
		$Datos_Cifras = $_POST['json_cifras_recursos'];
	}

	if($id_info_contractual == 0)
	{
		$id_info_contractual = guardarInfoContractual($Id_Usuario,$Nombre_Proyecto,$Representante_Legal,$Objeto_Contrato,$Obligaciones,$Datos_Cifras,$ActividadesRealizadas,$PoblacionBeneficiada,$ArtistasBeneficiados,$Difusion,$Fecha_Registro,$id_seguimiento_propuesta);
	}
	else{
		if ($bandera_ultimo_informe == 1) {
			actualizarInfoContractual($Id_Usuario,$Datos_Cifras,$ActividadesRealizadas,$PoblacionBeneficiada,$ArtistasBeneficiados,$Difusion,$id_info_contractual);
		}
	}
	guardarInformeDeGestion($Id_Usuario,$Numero_Informe,$Periodo,$Anio,$Correo,$DetalleActividades,$Fecha_Registro,$id_info_contractual);

	return true;
}

/***************************************************************************
Metodo encargado de consultar el listado de  organizaciones del año especificado.
***************************************************************************/
function getOrganizacionesAnio(){
	$year = $_POST['year'];
	$datos = getOrganizacionesYear($year);
	return json_encode($datos);
}

/***************************************************************************
Metodo encargado de consultar el listado de seguimientos que ha realizado un Coordinador de Organizacion
***************************************************************************/
function getFormatosAdministrativosOrganizacion(){
	$organizacion = $_POST['organizacion'];
	$year = $_POST['year'];
	$datos = getFormatosAdministrativosDeOrganizacion($organizacion, $year);
	return json_encode($datos);
}

/***************************************************************************
Funcion encargada de guardar una revisión de un seguimiento específico (La observación y el estado de aprobación)
***************************************************************************/
function guardarRevisionFA(){
	date_default_timezone_set('America/Bogota');
	$id_persona = $_POST['id_persona'];
	$id_tabla = $_POST['id_tabla'];
	$observacion = $_POST['observacion'];
	$Fecha_Registro = date("Y-m-d H:i:s");
	if($_POST['aprobacion'] == "true"){
		$aprobacion = 1;
	}
	else{
		$aprobacion = 0;
	}
	if ($_POST['tipo_informe'] == 'INFORME DE GESTIÓN') {
		$datos = saveRevisionFA($id_persona, $id_tabla, $observacion, $aprobacion, $Fecha_Registro);
	}
	if ($_POST['tipo_informe'] == 'PROYECCIÓN Y SEGUIMIENTO DEL GASTO') {
		$datos = saveRevisionFAProyeccion($id_persona, $id_tabla, $observacion, $aprobacion, $Fecha_Registro);
	}
	return json_encode($datos);
}


/***************************************************************************
guarda la informacion del informe de proyeccion del gasto
***************************************************************************/
function guardarInformeProyeccion(){
	$desembolsosFinal = array();
	$arrayInicialyAdiciones = array();
	$arrayAuxiliar = array();
	$arrayAportesAsociado = array();
	$arrayAportesAsociado = array();
	$arrayGrupos = array();
	$arrayIdartes = array();
	$arrayCaja = array();
	$arrayEgresos = array();
	$arrayAsociadoTotal = array();
	$numeroMes = 0;
	$numeroItem = 0;
	$finished = 0;
	$total = false;
	$proyecto = $_POST['proyecto'];
	$periodoProyeccion = $_POST['periodo'];
	$rubrosProyeccion = $_POST['rubros'];
	$anio = $_POST['SL_Anio_Proyeccion'];
	$id_seguimiento_propuesta = $_POST['id_seguimiento_propuesta'];
	$ejecucion_anterior = 0; //deformatMoney($_POST['input-ejecucion-anterior']);
	// unset($_POST['SL_Periodo_Proyeccion']);
	// unset($_POST['SL_Anio_Proyeccion']);

	foreach ($_POST as $key => $value) {

		if(strpos($key,'TX_AD') !== false){
			$finished = 0;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
			if (strpos($key,'TX_ADT') !== false) $total = true;
			else $total = false;
		}
		else{
			if ($finished == 0 ) {
				$finished = 0.5;
				$numeroItem = 0;
			}
		}

		if ($numeroMes == 4 && $finished == 0) {
			$numeroMes = 0;
			$numeroItem++;
			$arrayInicialyAdiciones[0][$numeroItem] = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}
		////////// Inicial y Adiciones /////////////
		// if(strpos($key,'TX_AD') !== false){
		// 	$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
		// 	$numeroMes++;
		// 	$finished = 0;
		// }
		// else{
		// 	if ($finished == 0) {
		// 		$finished = 0.5;
		// 		$numeroItem = 0;
		// 	}
		// }
		// if ($numeroMes == 4 && $finished == 0) {
		// 	$numeroMes = 0;
		// 	$arrayInicialyAdiciones[$numeroItem] = $arrayAuxiliar;
		// 	$arrayAuxiliar = array();
		// }

		////////// Desembolsos /////////////
		if(strpos($key,'TX_TD') !== false){
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
			$finished = 0.5;
		}
		else{
			if ($finished == 0.5) {
				$finished = 1;
				$numeroItem = 0;
			}
		}
		if ($numeroMes == 14 && $finished == 0.5) {
			$numeroMes = 0;
			$numeroItem++;
			$desembolsosFinal[$numeroItem] = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}

		////////// GRUPOS /////////////////////
		if(strpos($key,'TX_Grupos') !== false){
			$finished = 1;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
		}
		else{
			if ($finished == 1 ) {
				$finished = 2;
			}
		}
		if ($numeroMes == 12  && $finished == 1) {
			$numeroMes = 0;
			$arrayGrupos = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}

		////////// APORTES IDARTES /////////////////////

		if(strpos($key,'TX_T1') !== false || strpos($key,'SL_T1') !== false){
			$finished = 2;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
			if (strpos($key,'TX_T1T') !== false) $total = true;
			else $total = false;
		}
		else{
			if ($finished == 2 ) {
				$finished = 3;
				$numeroItem = 0;
			}
		}

		if (($numeroMes == 25 || ($total && $numeroMes == 19))  && $finished == 2) {
			$numeroMes = 0;
			$numeroItem++;
			$arrayAportes[1][$numeroItem] = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}

		if(strpos($key,'TX_T2') !== false || strpos($key,'SL_T2') !== false){
			$finished = 3;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
			if (strpos($key,'TX_T2T') !== false) $total = true;
			else $total = false;
		}
		else{
			if ($finished == 3 ) {
				$finished = 4;
				$numeroItem = 0;
			}
		}
		if (($numeroMes == 25 || ($total && $numeroMes == 19))  && $finished == 3) {
			$numeroMes = 0;
			$numeroItem++;
			$arrayAportes[2][$numeroItem] = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}

		if(strpos($key,'TX_T3') !== false || strpos($key,'SL_T3') !== false){
			$finished = 4;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
			if (strpos($key,'TX_T3T') !== false) $total = true;
			else $total = false;
		}
		else{
			if ($finished == 4 ) {
				$finished = 5;
				$numeroItem = 0;
			}
		}
		if (($numeroMes == 25 || ($total && $numeroMes == 19))  && $finished == 4) {
			$numeroMes = 0;
			$numeroItem++;
			$arrayAportes[3][$numeroItem] = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}

		if(strpos($key,'TX_T4') !== false || strpos($key,'SL_T4') !== false){
			$finished = 5;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
			if (strpos($key,'TX_T4T') !== false) $total = true;
			else $total = false;
		}
		else{
			if ($finished == 5 ) {
				$finished = 6;
				$numeroItem = 0;
			}
		}
		if (($numeroMes == 25 || ($total && $numeroMes == 19))  && $finished == 5) {
			$numeroMes = 0;
			$numeroItem++;
			$arrayAportes[4][$numeroItem] = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}

		if(strpos($key,'TX_T5') !== false || strpos($key,'SL_T5') !== false){
			$finished = 6;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
			if (strpos($key,'TX_T5T') !== false) $total = true;
			else $total = false;
		}
		else{
			if ($finished == 6 ) {
				$finished = 7;
				$numeroItem = 0;
			}
		}
		if (($numeroMes == 25 || ($total && $numeroMes == 19))  && $finished == 6) {
			$numeroMes = 0;
			$numeroItem++;
			$arrayAportes[5][$numeroItem] = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}

		if(strpos($key,'TX_T6') !== false || strpos($key,'SL_T6') !== false){
			$finished = 7;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
			if (strpos($key,'TX_T6T') !== false) $total = true;
			else $total = false;
		}
		else{
			if ($finished == 7) {
				$finished = 8;
				$numeroItem = 0;
			}
		}
		if (($numeroMes == 25 || ($total && $numeroMes == 19))  && $finished == 7) {
			$numeroMes = 0;
			$numeroItem++;
			$arrayAportes[6][$numeroItem] = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}

		 ///////////// TOTALES ////////////////
		if(strpos($key,'TX_TIT') !== false){
			$finished = 8;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
		}
		else{
			if ($finished == 8) {
				$finished = 9;
			}
		}
		if ($numeroMes == 19 && $finished == 8) {
			$numeroMes = 0;
			$arrayIdartes = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}

		if(strpos($key,'TX_TCT') !== false){
			$finished = 9;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
		}
		else{
			if ($finished == 9) {
				$finished = 10;
			}
		}
		if ($numeroMes == 14 && $finished == 9) {
			$numeroMes = 0;
			$arrayCaja = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}


		if(strpos($key,'TX_TET') !== false){
			$finished = 10;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
		}
		else{
			if ($finished == 10) {
				$finished = 11;
			}
		}
		if ($numeroMes == 13 && $finished == 10) {
			$numeroMes = 0;
			$arrayEgresos = $arrayAuxiliar;
			$arrayAuxiliar = array();
		}

		///////////// APORTES ASOCIADO ////////////////////
		///////////////// APORTES ASOCIADO //////////////////////////

		if(strpos($key,'TX_TA') !== false){
			$finished = 11;
			$arrayAuxiliar[$key] = stripos($value, '$') !== FALSE ? deformatMoney($value): $value ;
			$numeroMes++;
			if (strpos($key,'TX_TAT') !== false) $total = true;
			else $total = false;
		}
		else{
			if ($finished == 11) {
				$finished = 12;
				$numeroItem = 0;
			}
		}
		if (($numeroMes == 25 || ($total && $numeroMes == 19))  && $finished == 11) {
			$numeroItem++;
			$arrayAportesAsociado[1][$numeroItem] = $arrayAuxiliar;
			if ($numeroMes == 19) {
				$arrayAsociadoTotal = $arrayAuxiliar;
			}
			$numeroMes = 0;
			$arrayAuxiliar = array();
		}
	}
	date_default_timezone_set('America/Bogota');
	$fechaRegistro = date("Y-m-d H:i:s");

	$formatoId = guardarSeguimientoGasto($_POST['organizacionId'],$fechaRegistro,json_encode($arrayIdartes),json_encode($arrayAsociadoTotal),json_encode($arrayCaja),json_encode($arrayEgresos),json_encode($arrayGrupos),$_POST['idUsuario'],$proyecto,$periodoProyeccion,$rubrosProyeccion,$anio,$id_seguimiento_propuesta);
	foreach ($arrayInicialyAdiciones as $key => $value) {
		foreach ($value as $k => $v) {
			guardarAportes($formatoId,$key,$k,1,json_encode($v));//tabla,item,tipo 1 idartes- 2 asociado,txdatos
		}
	}
	foreach ($desembolsosFinal as $key => $value) {
		guardarDesembolso($formatoId,$key,json_encode($value),$ejecucion_anterior);
	}
	foreach ($arrayAportes as $key => $value) {
		foreach ($value as $k => $v) {
			guardarAportes($formatoId,$key,$k,1,json_encode($v));//tabla,item,tipo 1 idartes- 2 asociado,txdatos
		}
	}
	foreach ($arrayAportesAsociado as $key => $value) {
		foreach ($value as $k => $v) {
			guardarAportes($formatoId,$key,$k,2,json_encode($v));//tabla,item,tipo 1 idartes- 2 asociado,txdatos
		}
	}

	// print_r($desembolsosFinal);
	// // echo json_encode($desembolsosFinal);
	/*echo "arrayAportes:\n";
	print_r($arrayAportes);
	echo "arrayGrupos:\n";
	print_r($arrayGrupos);
	echo "arrayIdartes:\n";
	print_r($arrayIdartes);
	echo "arrayCaja:\n";
	print_r($arrayCaja);
	echo "arrayEgresos:\n";
	print_r($arrayEgresos);
	echo "arrayAportesAsociado:\n";
	print_r($arrayAportesAsociado);
	echo "arrayAsociadoTotal:\n";
	print_r($arrayAsociadoTotal);*/
	return true;
}

function deformatMoney($text) {
	return str_replace(".","",str_replace(" ","",str_replace(",","",str_replace("$", "", $text))));
}

/***************************************************************************
Metodo encargado de consultar la organizacion de un grupo especifico
***************************************************************************/
function getOrganizacionData(){
	$idUsuario = $_POST['idUsuario'];
	$datos = getOrganizacionAllData($idUsuario);
	return json_encode($datos);
}
/***************************************************************************
Metodo encargado de consultar toda la informacion del formato de proyeccion
***************************************************************************/
function getInformeProyeccion()
{
	$idInforme = $_POST['idInforme'];
	$informeProyeccion = getInformeDeProyeccion($idInforme);
	if (sizeof($informeProyeccion) > 0) {
		$informeProyeccion = $informeProyeccion[sizeof($informeProyeccion)-1];
		$desembolsos = getDesembolsosProyeccion($idInforme);
		$aportes = getAportesProyeccion($idInforme);
		$informeProyeccion['desembolsos'] = $desembolsos;
		$informeProyeccion['aportes'] = $aportes;
	}
	else
		$informeProyeccion = null;
	return json_encode($informeProyeccion);
}
/***************************************************************************
Metodo encargado de consultar toda la informacion de la organizacion en tb_organizacion_seguimiento_propuesta
***************************************************************************/
function getInfoExtra()
{
  $id_organizacion = $_POST['id_organizacion']; //Aquí se envía el Id del Usuario que tiene la Organizacion.
  $informacion_Organizacion = getInformacionOrganizacion($id_organizacion);
  if (sizeof($informacion_Organizacion) > 0)
  	$informacion_Organizacion = $informacion_Organizacion[sizeof($informacion_Organizacion)-1];
  else
  	$informacion_Organizacion = null;
  return json_encode($informacion_Organizacion);
}

/***************************************************************************
Metodo encargado de actualizar el Estado del Formato Administrativo (Parcial/Final)
***************************************************************************/
function actualizarEstadoFAS()
{
  $tipo_formato = $_POST['tipo_formato']; //Aquí se envía el nombre del Formato. (Informe de Gestión/Proyección del Gasto)
  $id_formato = $_POST['id_formato']; //Aquí se envía el Id del formato administrativo.
  $estado = $_POST['estado']; //Aquí se envía el estado del Formato (0-Parcial, 1-Final)
  $usuario = $_POST['usuario']; //Aquí se envía el estado del Formato (0-Parcial, 1-Final)
  actualizarEstadoDeFAS($tipo_formato,$id_formato,$estado,$usuario);
}

/***************************************************************************
Metodo encargado de consultar si existe un seguimiento a la propuesta creado y activo de la organización para poder realizar el informe de gestion desde ceros.
***************************************************************************/
function consultarSeguimientoPropuesta()
{
	$id_organizacion = $_POST['id_organizacion'];
	$datos = consultarExisteSeguimientoPropuesta($id_organizacion);
	if (sizeof($datos) > 0)
		$datos = $datos[sizeof($datos)-1];
	else
		$datos = null;
	return json_encode($datos);
}



?>
