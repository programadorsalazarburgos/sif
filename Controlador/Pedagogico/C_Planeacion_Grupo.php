<?php
header ('Content-type: text/html; charset=utf-8');

include_once('../../Modelo/Pedagogico/Acceso_Datos.php');
if (isset($_POST['opcion'])){
	switch ($_POST['opcion']) {
		case 'getFormador':
		echo getFormador($_POST['idUsuario']);
		break;
		case 'getCInformacionGrupo':
		echo getCInformacionGrupo($_POST['idGrupo'],$_POST['tipoGrupo']);
		break;
		case 'getEntidad':
		echo getEntidad($_POST['idGrupo'],$_POST['linea']);
		break;
		case 'getRecursos':
		echo getRecursos();
		break;
		case 'guardarDatos':
		echo guardarDatos();
		break;
		case 'guardarObservacionPlaneacion':
		echo guardarObservacionPlaneacion();
		break;
		case 'getPlaneacion':
		echo getPlaneacion();
		break;
		default:
		echo "Opcion no existente.";
		break;
	}
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
/***************************************************************************
Retorna la lista de recursos 
***************************************************************************/
function getRecursos(){
	$recursos = getRecursosActuales();
	return json_encode($recursos);
}
/***************************************************************************$
Alamacena todos los datos enviados por post a la Base de datos (Planeacion)
@Return $return
***************************************************************************/
function guardarDatos(){
	$ciclo = $_POST['ciclos'];
	$objetivo = $_POST['TXT_Objetivo_Formacion'];
	$pregunta = $_POST['TXT_Pregunta'];
	$descripcion = $_POST['TXT_Descripcion_proyecto'];
	$circulacion = $_POST['TXT_Circulacion'];
	$metodologia = $_POST['metodologias'];
	$articulacion = $_POST['TXT_Articulacion'];
	$ciclotext = $_POST['TXT_Ciclo'];
	$temas = $_POST['TXT_Temas'];
	$resultados = $_POST['TXT_Resultados'];
	$recursos = $_POST['recursosSelec'].$_POST['TX_Otros_Recursos'];
	$referentes = $_POST['referentes'];
	$acciones = array ("semana_1"=>$_POST['TXT_semana_1'],"semana_2"=>$_POST['TXT_semana_2'],"semana_3"=>$_POST['TXT_semana_3'],"semana_4"=>$_POST['TXT_semana_4'],"semana_5"=>$_POST['TXT_semana_5'],"semana_6"=>$_POST['TXT_semana_6'],"semana_7"=>$_POST['TXT_semana_7'],"semana_8"=>$_POST['TXT_semana_8'],"semana_9"=>$_POST['TXT_semana_9'],"semana_10"=>$_POST['TXT_semana_10'],"semana_11"=>$_POST['TXT_semana_11'],"semana_12"=>$_POST['TXT_semana_12'],"semana_13"=>$_POST['TXT_semana_13'],"semana_14"=>$_POST['TXT_semana_14'],"semana_15"=>$_POST['TXT_semana_15'],"semana_16"=>$_POST['TXT_semana_16'],"semana_17"=>$_POST['TXT_semana_17'],"semana_18"=>$_POST['TXT_semana_18'],"semana_19"=>$_POST['TXT_semana_19'],"semana_20"=>$_POST['TXT_semana_20'],"semana_21"=>$_POST['TXT_semana_21'],"semana_22"=>$_POST['TXT_semana_22'],"semana_23"=>$_POST['TXT_semana_23'],"semana_24"=>$_POST['TXT_semana_24'],"semana_25"=>$_POST['TXT_semana_25'],"semana_26"=>$_POST['TXT_semana_26'],"semana_27"=>$_POST['TXT_semana_27'],"semana_28"=>$_POST['TXT_semana_28'],"semana_29"=>$_POST['TXT_semana_29'],"semana_30"=>$_POST['TXT_semana_30'],"semana_31"=>$_POST['TXT_semana_31'],"semana_32"=>$_POST['TXT_semana_32'],"semana_33"=>$_POST['TXT_semana_33'],"semana_34"=>$_POST['TXT_semana_34'],"semana_35"=>$_POST['TXT_semana_35'],"semana_36"=>$_POST['TXT_semana_36'],"semana_37"=>$_POST['TXT_semana_37'],"semana_38"=>$_POST['TXT_semana_38'],"semana_39"=>$_POST['TXT_semana_39'],"semana_40"=>$_POST['TXT_semana_40'],"semana_41"=>$_POST['TXT_semana_41'],"semana_42"=>$_POST['TXT_semana_42'],"semana_43"=>$_POST['TXT_semana_43'],"semana_44"=>$_POST['TXT_semana_44']);
	$accionesJson = json_encode($acciones);
	$usuarioRegistro = $_POST['artistaFormadorId'];
	$grupo = $_POST['codigoGrupo'];
	$linea = $_POST['tipo_grupo'];
	date_default_timezone_set('America/Bogota');
	$fecha=date("Y-m-d H:i:s");
	guardarPlaneacion($grupo,$linea,$ciclo,$objetivo,$pregunta,$descripcion,$metodologia,$temas,$recursos,$referentes,$accionesJson,$usuarioRegistro,$fecha,$circulacion,$resultados,$articulacion,$ciclotext);

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
	if ($linea == 3) {
		$grupo = getOrganizacionYAreaArtisticaGrupoLaboratorioCrea($grupoId);
	}
	return json_encode($grupo);
}
/***************************************************************************
actualiza la observacion sobre una planeación
@Return boolean update
***************************************************************************/
function guardarObservacionPlaneacion(){

	$estado = "";
	if (isset($_POST['IN_Estado_pl_ae'])) {
		if ($_POST['IN_Estado_pl_ae'] == "on")
			$estado = '1';
		else
			$estado = '0';
	}
	
	if (isset($_POST['IN_Estado_pl_ec'])) {
		if ($_POST['IN_Estado_pl_ec'] == "on")
			$estado = '1';
		else
			$estado = '0';
	}
	
	if (isset($_POST['IN_Estado_pl_lc'])) {
		if ($_POST['IN_Estado_pl_lc'] == "on")
			$estado = '1';
		else
			$estado = '0';
	}
	$idUsuario = $_POST['idUsuario'];
	$idPlaneacion = "";
	if(isset($_POST['SL_Planeacion_Grupo_Arte_Escuela']))
		$idPlaneacion = $_POST['SL_Planeacion_Grupo_Arte_Escuela'];	
	if(isset($_POST['SL_Planeacion_Grupo_Emprende_Clan']))
		$idPlaneacion = $_POST['SL_Planeacion_Grupo_Emprende_Clan'];	
	if(isset($_POST['SL_Planeacion_Grupo_Laboratorio_Clan']))
		$idPlaneacion = $_POST['SL_Planeacion_Grupo_Laboratorio_Clan'];	

	$observacion = "";
	if(isset($_POST['TXT_Observacion_ae']))
		$observacion = $_POST['TXT_Observacion_ae'];	
	if(isset($_POST['TXT_Observacion_ec']))
		$observacion = $_POST['TXT_Observacion_ec'];	
	if(isset($_POST['TXT_Observacion_lc']))
		$observacion = $_POST['TXT_Observacion_lc'];	
	if($idPlaneacion != "")
		$rta = updateObservacion($idPlaneacion,$observacion,$estado,$idUsuario);
	else 
		$rta = "false";
	return json_encode($rta);
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
/* getPlaneacion de acuerdo al codigo del grupo y la linea de atencion, trae los datos de la ultima planeacion que se realizó
***************************************************************************/
function getPlaneacion()
{
	$planeaciones = consultarPlaneaciones($_POST['codigoGrupo'],$_POST['lineaAtencion']);
	if (sizeof($planeaciones) > 0)
		$planeacion = $planeaciones[sizeof($planeaciones)-1];
	else
		$planeacion = null;
	return json_encode($planeacion);
}

?>