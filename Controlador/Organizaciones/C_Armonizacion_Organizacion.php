<?php
header ('Content-type: text/html; charset=utf-8');
include_once('../../Modelo/Organizaciones/Acceso_Datos.php');
if (isset($_POST['opcion'])){
	switch ($_POST['opcion']) {
		case 'subirArchivo':
		echo subirArchivo();
		break;
		case 'guardarDatos':
		echo guardarDatos();
		break;
		case 'getOrganizacionesAnio': 
		echo getOrganizacionesAnio(); 
		break; 
		case 'getArmonizacionesOrganizacion': 
		echo getArmonizacionesOrganizacion(); 
		break;
		case 'getArchivosArmonizacionesOrganizacion': 
		echo getArchivosArmonizacionesOrganizacion(); 
		break;
		case 'getArmonizacion': 
		echo getArmonizacion(); 
		break;
		case 'guardarRevisionArmonizacion': 
		echo guardarRevisionArmonizacion(); 
		break;
		default:
		echo "Opcion no existente.";
		break;
	}
}
/***************************************************************************
Funcion Utilizada para guardar los datos del formulario
***************************************************************************/

function guardarDatos(){
	$idUsuario = $_POST['idUsuario'];
	$idOrganizacion = getOrganizacion($idUsuario);
	$idSeguimientoPropuesta = consultarExisteSeguimientoPropuesta($idUsuario);
	$idSeguimientoPropuesta = $idSeguimientoPropuesta[0]['PK_Id_Tabla'];
	date_default_timezone_set('America/Bogota');
	$fecha=date("Y-m-d-H:i:s");
	return guardarDatosFormulario($idOrganizacion,$_POST['TX_pregunta_1'],$_POST['TX_pregunta_2'],$_POST['TX_pregunta_3'],
		$_POST['TX_pregunta_4'],$_POST['TX_pregunta_5'],$_POST['TX_pregunta_6'],$idUsuario,$fecha,$idSeguimientoPropuesta);  
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
Metodo encargado de retornar la una armonizcacion de acuerod al id de la misma. 
***************************************************************************/ 
function getArmonizacion(){ 
	$idArmonizacion = $_POST['idArmonizacion']; 
	$datos = getArmonizacionDatos($idArmonizacion); 
	return json_encode($datos); 
}

/*************************************************************************** 
Metodo encargado de consultar el listado de armonizaciones que ha realizado un Coordinador de Organizacion
***************************************************************************/ 
function getArmonizacionesOrganizacion(){ 
	$organizacion = $_POST['organizacion']; 
	if (isset($_POST['tipo']) && $_POST['tipo'] == 11 ){
		$organizacion = getOrganizacion($organizacion);
	}
	$year = $_POST['year'];
	$datos = getArmonizacionesdeOrganizacion($organizacion, $year); 
	return json_encode($datos);
}

/*************************************************************************** 
Metodo encargado de consultar el listado de armonizaciones enviadas como archivo que ha realizado un Coordinador de Organizacion
***************************************************************************/ 
function getArchivosArmonizacionesOrganizacion(){ 
	$organizacion = $_POST['organizacion']; 
	if (isset($_POST['tipo']) && $_POST['tipo'] == 11 ){
		$organizacion = getOrganizacion($organizacion);
	}
	$year = $_POST['year'];
	$datos = getArchivosArmonizacionesdeOrganizacion($organizacion, $year); 
	return json_encode($datos);
}

/*************************************************************************** 
Metodo encargado de guardar la observacion que se le hace a alguna armonizacion.
***************************************************************************/
function guardarRevisionArmonizacion(){
	date_default_timezone_set('America/Bogota'); 
	$id_persona = $_POST['id_persona'];
	$id_armonizacion = $_POST['id_armonizacion']; 
	$observacion = $_POST['observacion'];
	$Fecha_Registro = date("Y-m-d H:i:s");
	if($_POST['aprobacion'] == "true"){
		$aprobacion = 1;
	}
	else{
		$aprobacion = 0;	
	}

	$datos = saveRevisionArmonizacion($id_persona, $id_armonizacion, $observacion, $aprobacion, $Fecha_Registro);
	return json_encode($datos);
}

/***************************************************************************
Funcion Utilizada para quitar tildes a un texto 
***************************************************************************/
function quitarTildes($cadena) {
	$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹","?");
	$permitidas= array("a","e","i","o","u","A","E","I","O","U","n","N","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","");
	$texto = str_replace($no_permitidas, $permitidas ,$cadena);
	$texto = str_replace($no_permitidas, $permitidas ,utf8_decode($texto));
	return $texto;
}

/***************************************************************************
Funcion para subir el Balance Final del convenio.
***************************************************************************/
function subirArchivo(){
	krsort($_FILES);
	$idUsuario = $_POST['idUsuario'];
	date_default_timezone_set('America/Bogota');
	$fecha=date("Y-m-d-H:i:s");
	$meses = $_POST['meses'];
	$anio = $_POST['anio'];
	$idOrganizacion = getOrganizacion($idUsuario);
	$idSeguimientoPropuesta = $_POST['idPropuesta'];
	// $idSeguimientoPropuesta = consultarExisteSeguimientoPropuesta($idUsuario);
	// $idSeguimientoPropuesta = $idSeguimientoPropuesta[0]['PK_Id_Tabla'];
	$nombre_carpeta = "../../uploadedFiles/documentosOrganizaciones/".$anio."/pedagogico/".$idOrganizacion;
	if(!is_dir($nombre_carpeta)){
		$mask=umask(0);
		@mkdir($nombre_carpeta, 0775);
		umask($mask);
	}
	foreach($_FILES as $key => $file)
	{
		$namePath = pathinfo($file['name']);
		$name =quitarTildes($namePath['filename']);
		$extension = $namePath['extension'];
		$_FILES[$key]['name'] = $name.'.'.$extension;
	}
	$uploaded = true;
	$files = array();
	$uploaddir =$nombre_carpeta.'/';
	$i=0;
	if (sizeof($_FILES) == 0) {
		$uploaded = false;
	}
	foreach($_FILES as $key => $file)
	{	
		$i++;
		$path_info = pathinfo($file['name']);
		$Nombre_Archivo = basename($file['name']);
		$Nombre_Archivo = quitarTildes($Nombre_Archivo);
		$Ubicacion_Archivo =$nombre_carpeta."/".$Nombre_Archivo;
		if(move_uploaded_file($file['tmp_name'], $uploaddir.$Nombre_Archivo))
		{
			$files[] = $Ubicacion_Archivo;
			saveOrganizacionArchivo($idOrganizacion,$Nombre_Archivo,$uploaddir.$Nombre_Archivo,$meses,$anio,"ARMONIZACION",$idUsuario,$fecha,$idSeguimientoPropuesta);
		}
		else
		{
			$uploaded = false;
		}
	}

	return $uploaded;
}

?>