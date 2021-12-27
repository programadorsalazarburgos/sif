<?php
include_once('../../Modelo/Pedagogico/Acceso_Datos.php');
if (isset($_POST['opcion'])){
	switch ($_POST['opcion']) {
		case 'guardarCaracterizacion':	
		guardarCaracterizacion();
		break;
		case 'getCaracterizacion':
		echo getCaracterizacion();
		break;
		default:
		echo "Opcion no existente.";
		break;
	}
}
/***************************************************************************
Metodo encargado de consultar la ultima caracterizacion de un grupo
***************************************************************************/
function getCaracterizacion()
{
	$codigoGrupo = $_POST['codigoGrupo'];
	$lineaAtencion = $_POST['lineaAtencion'];
	$caracterizaciones = getCaracterizacionData($codigoGrupo,$lineaAtencion);
	if (sizeof($caracterizaciones) > 0)
		$caracterizacion = $caracterizaciones[sizeof($caracterizaciones)-1];
	else
		$caracterizacion = null;
	return json_encode($caracterizacion);
}
/***************************************************************************
Metodo encargado de realizar el almacenamiento de la caracterizacion realizada
***************************************************************************/
function guardarCaracterizacion()
{
	$Id_Artista_Formador = $_POST['id_artista_formador'];
	$Id_Grupo = $_POST['id_grupo'];
	$Linea_Atencion = $_POST['linea_atencion'];
	$Ciclo =$_POST['ciclos'];
	$Descripcion_Grupo   =$_POST['TXTA_DESCRIPCION_GRUPO'];
	$Slider_Convivencia  =$_POST['SLIDER_CONVIVENCIA'];
	$Descripcion_Convivencia      =$_POST['TXTA_CONVIVENCIA'];
	$Intereses_Array    =$_POST['intereses'];
	$Otros_Intereses    =$_POST['TX_OTROS_INTERESES'];
	$Descripcion_Intereses  =$_POST['TXTA_INTERESES'];
	if($Otros_Intereses!=""){
		$Intereses_Array = $Intereses_Array.$Otros_Intereses;
	}
	$Slider_Actitudinales = $_POST['SLIDER_ACTITUDINALES'];
	$Descripcion_Actitudinales =$_POST['TXTA_ACTITUDINALES'];
	$Slider_Cognitivos   =$_POST['SLIDER_COGNITIVOS'];
	$Descripcion_Cognitivos = $_POST['TXTA_COGNITIVOS'];
	$Slider_Procedimentales   =$_POST['SLIDER_PROCEDIMENTALES'];
	$Descripcion_Procedimentales =$_POST['TXTA_PROCEDIMENTALES'];
	$Necesidades    =$_POST['necesidades'];
	$Etnias       =$_POST['etnias'];
	$Descripcion_Particularidades    =$_POST['TXTA_PARTICULARIDADES'];
	$Espacio       =$_POST['TXTA_ESPACIO'];
	$Observaciones     =$_POST['TXTA_OBSERVACIONES'];
	guardarCaracterizacionData($Id_Grupo,$Linea_Atencion,$Ciclo,$Descripcion_Grupo,$Slider_Convivencia,$Descripcion_Convivencia,$Intereses_Array,$Descripcion_Intereses,$Slider_Actitudinales,$Descripcion_Actitudinales,$Slider_Cognitivos,$Descripcion_Cognitivos,$Slider_Procedimentales,$Descripcion_Procedimentales,$Necesidades, $Etnias, $Descripcion_Particularidades, $Espacio, $Observaciones, $Id_Artista_Formador);
}
?>