<?php
header ('Content-type: text/html; charset=utf-8');
include_once('../../Modelo/Organizaciones/Acceso_Datos.php');
if (isset($_POST['opcion'])){
	switch ($_POST['opcion']) {
		case 'subirArchivos':
		echo subirArchivos();
		break; 
		case 'subirArchivosSeguimiento':
		echo subirArchivosSeguimiento();
		break; 
		case 'getOrganizacionesAnio': 
		echo getOrganizacionesAnio(); 
		break; 
		case 'getArchivosOrganizacion': 
		echo getArchivosOrganizacion(); 
		break;
		case 'guardarRevisionArchivo': 
		echo guardarRevisionArchivo(); 
		break;
		case 'getAnexosArchivo': 
		echo getAnexosArchivo(); 
		break;
		case 'getFormatosOrganizacionMes':
		echo getFormatosOrganizacionMes();
		break;
		case 'actualizarEstadoArchivo':
		echo actualizarEstadoArchivo();
		break;
		case 'getRubrosProyecto':
		echo getRubrosProyecto();
		break;
		default:
		echo "Opcion no existente.";
		break;
	}
}

/***************************************************************************

***************************************************************************/
function subirArchivos(){
	krsort($_FILES);
	$idUsuario = $_POST['idUsuario'];
	$meses = $_POST['meses'];
	$anio = $_POST['anio'];
	date_default_timezone_set('America/Bogota');
	$fecha=date("Y-m-d-H:i:s");
	$idOrganizacion = getOrganizacion($idUsuario);
	$idSeguimientoPropuesta = $_POST['idPropuesta'];
	// $idSeguimientoPropuesta = consultarExisteSeguimientoPropuesta($idUsuario);
	// $idSeguimientoPropuesta = $idSeguimientoPropuesta[0]['PK_Id_Tabla'];
	$nombre_carpeta = "../../uploadedFiles/documentosOrganizaciones/".$anio."/".$idOrganizacion;
	$existentes = array();
	if(!is_dir($nombre_carpeta)){
		$mask=umask(0);
		@mkdir($nombre_carpeta, 0777);
		umask($mask);
	}else{ 
		foreach( glob($nombre_carpeta."/*") as $archivos_carpeta)
		{
			$namePath = pathinfo($archivos_carpeta);
			array_push($existentes,quitarTildes($namePath['filename']));
		}
	}
	// print_r($_FILES);
	foreach($_FILES as $key => $file)
	{
		$namePath = pathinfo($file['name']);
		$archivo =quitarTildes($namePath['filename']);
		$extension = $namePath['extension'];
		$name = ifInArray($existentes,$archivo,0,$archivo);
		$_FILES[$key]['name'] = $name.'.'.$extension;
	}
	$uploaded = true;
	$files = array();
	$uploaddir =$nombre_carpeta.'/';
	$i=0;
	$idSaved1 = 0;
	$idSaved3 = 0;
	$idSaved4 = 0;
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
			if ($key == 'div_anexos_archivo_seg') {
				$idSaved1 = saveOrganizacionArchivo($idOrganizacion,$Nombre_Archivo,$uploaddir.$Nombre_Archivo,$meses,$anio,"SEGUIMIENTO ORGANIZACIONES",$idUsuario,$fecha,$idSeguimientoPropuesta);
			}

			if ($key == 'archivo_1') {
				$idSaved1 = saveOrganizacionArchivo($idOrganizacion,$Nombre_Archivo,$uploaddir.$Nombre_Archivo,$meses,$anio,"INFORME FINANCIERO",$idUsuario,$fecha,$idSeguimientoPropuesta);
			}
			else
			{
				if ($key == 'archivo_2') {
					$idSaved2 = saveOrganizacionArchivo($idOrganizacion,$Nombre_Archivo,$uploaddir.$Nombre_Archivo,$meses,$anio,"PROYECCION DEL GASTO",$idUsuario,$fecha,$idSeguimientoPropuesta);
				}
				else
				{
					if ($key == 'archivo_3') {
						$idSaved3 = saveOrganizacionArchivo($idOrganizacion,$Nombre_Archivo,$uploaddir.$Nombre_Archivo,$meses,$anio,"REPORTE DE RECURSOS",$idUsuario,$fecha,$idSeguimientoPropuesta);
					}
					else
					{
						if ($key == 'archivo_4') {
							$idSaved4 = saveOrganizacionArchivo($idOrganizacion,$Nombre_Archivo,$uploaddir.$Nombre_Archivo,$meses,$anio,"INFORME DE GESTION",$idUsuario,$fecha,$idSeguimientoPropuesta);
						}
						else{
							$newKey = substr($key, 0, -2);
							if ( $newKey == 'anexos_archivo_1'){
								if ($idSaved1 == 0) {
									$idSaved1 = getIdArchivoOrganizacion($meses,$idOrganizacion,'INFORME FINANCIERO');
								}
								echo $idSaved1;
								if ($idSaved1 != 0) {
									saveOrganizacionArchivoAnexo($Nombre_Archivo,$uploaddir.$Nombre_Archivo,$idUsuario,$fecha,$idSaved1);
								}
								else
									$uploaded = false;
							}
							if ( $newKey == 'anexos_archivo_3'){
								if ($idSaved3 == 0) {
									$idSaved3 = getIdArchivoOrganizacion($meses,$idOrganizacion,'REPORTE DE RECURSOS');
								}
								if ($idSaved3 != 0) {
									saveOrganizacionArchivoAnexo($Nombre_Archivo,$uploaddir.$Nombre_Archivo,$idUsuario,$fecha,$idSaved3);
								}
								else
									$uploaded = false;
							}
							if ( $newKey == 'anexos_archivo_4'){
								if ($idSaved4 == 0) {
									$idSaved4 = getIdArchivoOrganizacion($meses,$idOrganizacion,'INFORME DE GESTION');
								}
								if ($idSaved4 != 0) {
									saveOrganizacionArchivoAnexo($Nombre_Archivo,$uploaddir.$Nombre_Archivo,$idUsuario,$fecha,$idSaved4);
								}
								else
									$uploaded = false;

							}
							
						}
					}
				}
			}
		}
		else
		{
			$uploaded = false;
		}
	}

	return $uploaded;
}
/***************************************************************************

***************************************************************************/
function subirArchivosSeguimiento(){
	krsort($_FILES);
	$idUsuario = $_POST['idUsuario'];
	$meses = $_POST['meses'];
	$anio = $_POST['anio'];
	date_default_timezone_set('America/Bogota');
	$fecha=date("Y-m-d-H:i:s");
	$idOrganizacion = getOrganizacion($idUsuario);
	$idSeguimientoPropuesta = $_POST['idPropuesta'];
	// $idSeguimientoPropuesta = consultarExisteSeguimientoPropuesta($idUsuario);
	// $idSeguimientoPropuesta = $idSeguimientoPropuesta[0]['PK_Id_Tabla'];
	$nombre_carpeta = "../../uploadedFiles/documentosOrganizaciones/".$anio."/circulacion/".$idOrganizacion;
	$existentes = array();
	if(!is_dir($nombre_carpeta)){
		$mask=umask(0);
		@mkdir($nombre_carpeta, 0775);
		umask($mask);
	}else{
		foreach( glob($nombre_carpeta."/*") as $archivos_carpeta)
		{
			$namePath = pathinfo($archivos_carpeta);
			array_push($existentes,quitarTildes($namePath['filename']));
		}
	}
	// print_r($_FILES);
	foreach($_FILES as $key => $file)
	{
		$namePath = pathinfo($file['name']);
		$archivo =quitarTildes($namePath['filename']);
		$extension = $namePath['extension'];
		$name = ifInArray($existentes,$archivo,0,$archivo);
		$_FILES[$key]['name'] = $name.'.'.$extension;
	}
	$uploaded = true;
	$files = array();
	$uploaddir =$nombre_carpeta.'/';
	$i=0;
	$idSaved1 = 0;
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
			if ($key == 'archivo_seg') {
				$idSaved1 = saveOrganizacionArchivo($idOrganizacion,$Nombre_Archivo,$uploaddir.$Nombre_Archivo,$meses,$anio,"SEGUIMIENTO ORGANIZACIONES",$idUsuario,$fecha,$idSeguimientoPropuesta);
			}
			$newKey = substr($key, 0, -2);
			if ( $newKey == 'anexos_archivo_seg'){
				if ($idSaved1 == 0) {
					$idSaved1 = getIdArchivoOrganizacion($meses,$idOrganizacion,'SEGUIMIENTO ORGANIZACIONES');
				}
				if ($idSaved1 != 0) {
					saveOrganizacionArchivoAnexo($Nombre_Archivo,$uploaddir.$Nombre_Archivo,$idUsuario,$fecha,$idSaved1);
				}
				else
					$uploaded = false;
			}
		}
		else
		{
			$uploaded = false;
		}
	}

	return $uploaded;
}

function ifInArray($array,$searched,$count,$name)
{
	if (in_array($name,$array)) {	
		$count++;
		$name = $searched.$count;
		return ifInArray($array,$searched,$count,$name);
	}
	else{
		return $name;
	}
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
function getArchivosOrganizacion(){ 
	$organizacion = $_POST['organizacion']; 
	if (isset($_POST['tipo']) && $_POST['tipo'] == 11 ){
		$organizacion = getOrganizacion($organizacion);
	}
	$year = $_POST['year']; 
	$datos = getArchivosdeOrganizacion($organizacion, $year); 
	return json_encode($datos);
}

/*************************************************************************** 
Funcion encargada de guardar una revisión de un seguimiento específico (La observación y el estado de aprobación)
***************************************************************************/ 
function guardarRevisionArchivo(){
	date_default_timezone_set('America/Bogota'); 
	$id_persona = $_POST['id_persona'];
	$id_archivo = $_POST['id_archivo']; 
	$observacion = str_replace("'", "", $_POST['observacion']); 
	$Fecha_Registro = date("Y-m-d H:i:s");
	if($_POST['aprobacion'] == "true"){
		$aprobacion = 1;  
	}
	else{
		$aprobacion = 0;	
	}

	$datos = saveRevisionArchivo($id_persona, $id_archivo, $observacion, $aprobacion, $Fecha_Registro);
	return json_encode($datos);
}

/*************************************************************************** 
Metodo encargado de consultar el listado de archivos anexos a un archivo subido por la Organizacion.
***************************************************************************/ 
function getAnexosArchivo(){ 
	$id_archivo = $_POST['id_archivo'];
	$datos = getAnexosdeArchivo($id_archivo); 
	return json_encode($datos);
}


/*************************************************************************** 
Metodo encargado de consultar el listado de formatos administrativos subidos por una organizacion en determinado MES.
***************************************************************************/ 
function getFormatosOrganizacionMes(){ 
	$id_organizacion = $_POST['id_organizacion'];
	$year = $_POST['year'];
	$mes = $_POST['mes'];
	$datos = getArchivosSubidosOrganizacion($id_organizacion,$year,$mes); 
	return json_encode($datos);
}

/*************************************************************************** 
Metodo encargado de consultar el listado de rubros de la proyección del gasto correspondientes al proyecto especificado.
***************************************************************************/ 
function getRubrosProyecto(){ 
	$id_proyecto = $_POST['id_proyecto'];
	$datos = getListadoRubrosProyecto($id_proyecto); 
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
Metodo encargado de actualizar el Estado de un Archivo Específico. (Parcial/Final)
***************************************************************************/ 
function actualizarEstadoArchivo() 
{
  $id_archivo = $_POST['id_archivo']; //Aquí se envía el Id del formato administrativo.
  $estado = $_POST['estado']; //Aquí se envía el estado del Formato (0-Parcial, 1-Final)
  $usuario = $_POST['usuario']; //Aquí se envía el estado del Formato (0-Parcial, 1-Final)
  actualizarEstadoDeArchivo($id_archivo,$estado, $usuario);
}