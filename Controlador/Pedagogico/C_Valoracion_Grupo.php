<?php
header ('Content-type: text/html; charset=utf-8');

include_once('../../Modelo/Pedagogico/Acceso_Datos.php');
if (isset($_POST['opcion'])){
	switch ($_POST['opcion']) {
		case 'get_grupos_arte_escuela':
		echo getOptionsGruposArteEscuelaUsuario($_POST['id_usuario']);
		break;
		case 'get_grupos_emprende_clan':
		echo getOptionsGruposEmprendeClanUsuario($_POST['id_usuario']);
		break;
		case 'getFormador':
		echo getFormador($_POST['idUsuario']);
		break;
		case 'getCInformacionGrupo':
		echo getCInformacionGrupo($_POST['idGrupo'],$_POST['tipoGrupo']);
		break;
		case 'getEntidad':
		echo getEntidad($_POST['idGrupo'],$_POST['linea']);
		break;
		case 'guardarDatos':
		echo guardarDatos();
		break;
		case 'getEstudiantesGrupo':
		echo getEstudiantesGrupo($_POST['codigoGrupo'],$_POST['lineaAtencion'],$_POST['fecha']);
		break;
		case 'subirArchivosValoracion':
		echo subirArchivosValoracion();
		break;
		case 'guardarObservacion':
		echo guardarObservacion();
		break;
		case 'getValoracion':
		echo getValoracion();
		break;
		case 'getValoracionFromId':
		echo getValoracionFromId();
		break;
		default:
		echo "Opcion no existente.";
		break;
	}
}

/***************************************************************************
/* getOptionsGruposArteEscuelaUsuario() muestra en formato <option></option> los grupos de arte en la escuela activos, que tiene asignado un artista formador
***************************************************************************/
function getOptionsGruposArteEscuelaUsuario($id_usuario){
	$return = "<optgroup label='Arte En La Escuela'>";
	$grupo = getGruposActivosArteEscuelaByUsuario($id_usuario); 
	foreach ($grupo as $g){
		$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='arte_escuela'>AE-".$g['PK_Grupo']."</option>";
	}
	$return .= "</optgroup>";
	return $return;
}

/***************************************************************************
/* getOptionsGruposEmprendeClanUsuario() muestra en formato <option></option> los grupos de emprende clan activos, que tiene asignado un artista formador
***************************************************************************/
function getOptionsGruposEmprendeClanUsuario($id_usuario){
	$return = "<optgroup label='Emprende Clan'>";
	$grupo = getGruposActivosEmprendeClanByUsuario($id_usuario); 
	foreach ($grupo as $g){
		$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='emprende_clan'>EC-".$g['PK_Grupo']."</option>";
	}
	$return .= "</optgroup>";
	return $return;
}


/***************************************************************************
Retorna los datos del formador pertenecientes a la tabla tb_persona_2017 de acueal id
@Return $return
@Param  $idFormador : id del formador que se desea consultar
***************************************************************************/
function getFormador($idFormador){
	$formador = getDatosArtistaFormador($idFormador);
	return json_encode($formador);
}
/***************************************************************************
Retorna los datos del grupo deacuerdo al id
@Return $return
@Param  $grupoId : id del grupo a consultar
***************************************************************************/
function getCInformacionGrupo($grupoId,$tipo_grupo){
	$grupo = getInformacionGrupo($grupoId,$tipo_grupo);
	return json_encode($grupo);
}
/***************************************************************************$
Alamacena todos los datos enviados por post a la Base de datos (Valoracion)
@Return $return
***************************************************************************/
function guardarDatos(){
	$periodo = $_POST['SL_PERIODO'];
	$ciclo = $_POST['ciclos'];
	$artistaFormadorId = $_POST['artistaFormadorId'];
	$codigoGrupo = $_POST['codigoGrupo'];
	$tipo_grupo = $_POST['tipo_grupo'];//FK_Linea_Atencion
	$gestoCognitivo = $_POST['gestoCognitivo'];
	$idValoracion = guardarValoracion($periodo,$ciclo,$artistaFormadorId,$codigoGrupo,$tipo_grupo,$gestoCognitivo);
	foreach ($_POST as $key => $value) {
		$idEstudiante = null;
		if (strpos($key,'SL_Rating_Cog_') !== false) {
			$rta = explode('SL_Rating_Cog_', $key);
			$idEstudiante = $rta[1];
			$cognitivo = $_POST['SL_Rating_Cog_'.$idEstudiante];
			$actitudinal = $_POST['SL_Rating_Act_'.$idEstudiante];
			$convivencial = $_POST['SL_Rating_Con_'.$idEstudiante];
			$observacion = $_POST['IN_Observacion_'.$idEstudiante];
			$asistencia = $_POST['IN_Asistencia_'.$idEstudiante];
			guardarEstudianteValoracion($idEstudiante,$cognitivo,$actitudinal,$convivencial,$observacion,$idValoracion,$asistencia);
		}
	};
	return $idValoracion;
}
/***************************************************************************
Retorna los datos de organizacion y area artistica del grupo deacuerdo al id
@Return $grupo
***************************************************************************/
function getEntidad($grupoId,$linea){

	$grupo = "";
	if ($linea == 1) {
		$grupo = getOrganizacionYAreaArtisticaGrupoArteEscuela($grupoId);
	}
	if ($linea == 2) {
		$grupo = getOrganizacionYAreaArtisticaGrupoEmprendeClan($grupoId);
	}
	return json_encode($grupo);
}

/***************************************************************************
/* getEstudiantesGrupo() retorna los estudiantes y su asistencia deacuerdo al grupo, la linea de atencion y el mes
***************************************************************************/
function getEstudiantesGrupo($codigoGrupo,$lineaAtencion,$fecha){
	$grupo = consultarEstudiantesGrupo($codigoGrupo,$lineaAtencion,$fecha);
	return json_encode($grupo);
}

/***************************************************************************
/* subirArchivosValoracion() Se encarga de subir archivos a una valoracion previamente creada
***************************************************************************/
function subirArchivosValoracion(){
	$idValoracion = $_POST['idValoracion'];
	krsort($_FILES);
	date_default_timezone_set('America/Bogota');
	$fecha=date("Y-m-d-H:i:s");
	$nombre_carpeta = "../../public/Pedagogico/Archivos";
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
	print_r($_FILES);
	foreach($_FILES as $key => $file)
	{
		$namePath = pathinfo($file['name']);
		$archivo =quitarTildes($namePath['filename']);
		$extension = $namePath['extension'];
		$name = ifInArray($existentes,$archivo,0,$archivo);
		$_FILES[$key]['name'] = $name.'.'.$extension;
	}
	$uploaded = true;
	$uploaddir =$nombre_carpeta.'/';
	foreach($_FILES as $key => $file)
	{	
		$path_info = pathinfo($file['name']);
		$Nombre_Archivo = basename($file['name']);
		$Nombre_Archivo = quitarTildes($Nombre_Archivo);
		$Ubicacion_Archivo =$nombre_carpeta."/".$Nombre_Archivo;
		if(move_uploaded_file($file['tmp_name'], $uploaddir.$Nombre_Archivo))
		{
			guardarValoracionAnexo($idValoracion,$Nombre_Archivo,str_replace('../../public/Pedagogico/', '',$uploaddir).$Nombre_Archivo,$fecha);
		}
		else
		{
			$uploaded = false;
		}
	}

	return $uploaded;
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
actualiza la observacion sobre una valoracion
@Return boolean update
***************************************************************************/
function guardarObservacion(){
	$estado = "";
	if (isset($_POST['IN_Estado_val_ae'])) {
		if ($_POST['IN_Estado_val_ae'] == "on") {
			$estado = '1';
		}
		else
		{
			$estado = '0';
		}
	}
	else{
		if (isset($_POST['IN_Estado_val_ec'])) {
			if ($_POST['IN_Estado_val_ec'] == "on") {
				$estado = '1';
			}
			else
			{
				$estado = '0';
			}
		}
		else
		{
			$estado = '0';
		}
	}
	$idUsuario = $_POST['idUsuario'];
	$idValoracion = (isset($_POST['SL_Valoracion_Grupo_Arte_Escuela'])? $_POST['SL_Valoracion_Grupo_Arte_Escuela'] : $_POST['SL_Valoracion_Grupo_Emprende_Clan']);
	$observacion = (isset($_POST['TXT_Observacion_Valoracion_ae'])? $_POST['TXT_Observacion_Valoracion_ae'] : $_POST['TXT_Observacion_Valoracion_ec']);
	$rta = updateObservacionValoracion($idValoracion,$observacion,$estado,$idUsuario);
	return json_encode($rta);
}
/***************************************************************************
retorna todos los datos de una valoracion
@Return boolean update
***************************************************************************/
function getValoracion(){
	$valoraciones = consultarValoraciones($_POST['codigoGrupo'],$_POST['lineaAtencion']);
	if (sizeof($valoraciones) > 0)
		$valoracion = $valoraciones[sizeof($valoraciones)-1];
	else
		$valoracion = null;
	return json_encode($valoracion);
}
/***************************************************************************
retorna todos los datos de una valoracion especifica
@Return boolean update
***************************************************************************/
function getValoracionFromId(){
	$valoracion = getValoracionFromIdData($_POST['valoracionId']);
	return json_encode($valoracion);
}

?>