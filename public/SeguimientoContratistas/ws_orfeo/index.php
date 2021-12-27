<?php

// URL:
// http://190.26.196.146/orfeopf/serviciosWeb/provee/serverGd.php?wsdl
// app:
// APPSIF
// token:
// fb431aae604805920a321415c496276f330f748ec6c13518fbf8e1b400b61966

// $auten=array('token'=>'9fb0c93fb806e377951a9f3bFcG2e','app'=>'NOMBRE_APP');//echo $auten['token'];
$auten=array('token'=>'fb431aae604805920a321415c496276f330f748ec6c13518fbf8e1b400b61966','app'=>'APPSIF');
$correo="soporteorfeo@entidad.gov.co";
$filename = 'documentoradicadoprueba_sif.pdf';
$strFile = file_get_contents($filename);
$file = base64_encode($strFile);
$descripcion = "archivo prueba";
$asunto = 'Prueba radicado desde SIF '.date('H_i_s');
$dependencia = '112';
$radiDepeActu='130';
$radi_usua_actu='1';
$destinatario = array('0','12751099','0','MIGUEL ANDRES','SALAS','CASTRO','0','Calle 8 # 15-45','sif@idartes.gov.co','0','1','170','11','170-11-1');
$datos = array('autent'=>$auten,'file'=>$file,'fileName'=>$filename, 'destinatario'=>$destinatario,
	'asu'=>$asunto,'med'=>'1','ane'=>'','coddepe'=>$dependencia,'tpRadicado'=>'2',
	'cuentai'=>'','radi_usua_actu'=>$radi_usua_actu,'tip_rem'=>'1',
	'tdoc'=>'1','tip_doc'=>'1','carp_codi'=>'0','carp_per'=>'0');
$radicado = llamarWS('radicarDocumento', $datos);
/*if (strpos($radicado['valor'], "Error!!!!!") == 0)
{
	$filename = 'documentoanexoprueba.docx';
	$strFile = file_get_contents($filename);$file = base64_encode($strFile);
	$descripcion = "archivo anexo de prueba";
	$datos = array('autent'=>$auten,'file'=>$file, 'fileName'=>$filename, 'descripcion'=>$descripcion,
		'radicado'=>$radicado['valor'], 'correo'=>$correo);
	$rta = llamarWS('crearAnexo', $datos);
}*/
var_dump($radicado);
// var_dump($rta);
function llamarWS($metodo, $datos)
{
	require_once('nusoap/nusoap.php');
	// $wsdl="http://192.160.1.3/orfeows/url/suministrada/enzip/datos.php?wsdl";
	$wsdl="http://190.26.196.146/orfeopf/serviciosWeb/provee/serverGd.php?wsdl";
	$client = new nusoap_client($wsdl, 'wsdl');
	$rta = $client->call($metodo, $datos);
	if ($client->fault) {
		echo '<b>Error: ';
		print_r($rta);
		echo '</b>';
	} else {
		$error = $client->getError();
		if ($error) {
			echo '<b style="color: red">Error: ' . $error . '</b>';
		} else {
			return $rta;
		}
	}
}