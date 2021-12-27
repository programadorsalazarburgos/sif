<?php 
require_once "recaptchalib.php";
session_start();
if(isset($_SESSION["clicks"]))
  unset($_SESSION["clicks"]); 
session_destroy();
session_start();
session_regenerate_id(); 

include_once('../../Modelo/Administracion/Acceso_Datos.php');

$Id_Persona = "NULL";
$bandera = "NULL";
$username=$_POST['username'];
//$password = sha1(md5($_POST['password']));
$password = $_POST['password'];
 // tu clave secreta

$secret = " 6LcU2jAUAAAAACXzVS19M99StYhgbuaL7zCnxjBD";
 // respuesta vacía
$response = null;
 // comprueba la clave secreta
$reCaptcha = new ReCaptcha($secret);
 // si se detecta la respuesta como enviada
// if ($_POST["g-recaptcha-response"]) {
//   $response = $reCaptcha->verifyResponse(
//     $_SERVER["REMOTE_ADDR"],
//     $_POST["g-recaptcha-response"]
//     );
// }
$response = true;
// $response->success = true;

// if ($response != null && $response->success){
if ($response != null && $response){
  $persona = getIdPersonaByLogin($username,$password)[0];    
  if($persona!=null){
    $Id_Persona = $persona['FK_Id_Persona'];
    
     $_SESSION['session_username']=$Id_Persona;
     $_SESSION['session_usertype']=$persona['FK_Tipo_Persona'];     
     $idLogLogin=saveLogInicioSesion($Id_Persona,$_SERVER['HTTP_USER_AGENT'],obtenerIP(),returnMacAddress());
     $_SESSION['session_logLogin']=$idLogLogin;
     $bandera = true;
 }
 else{
  $bandera = false;
 }
}

function obtenerIP() {

    //si utilizamos un CDN, por ejemplo Cloudflare, genera un header con la IP real del cliente que se conecta
  if( isset($_SERVER['HTTP_CF_CONNECTING_IP']) )
    return $_SERVER['HTTP_CF_CONNECTING_IP'];

    //dependiendo de la configuración de proxys o apache o nginx tenemos varias variables de servidor que PHP recibe. Al final del artículo hay una lista de posibles variables

  if( isset($_SERVER['HTTP_CLIENT_IP']) ) 
    return $_SERVER['HTTP_CLIENT_IP'];

  if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )
    return $_SERVER['HTTP_X_FORWARDED_FOR'];

  if( isset($_SERVER['<variable seteada por server>']) )
    return $_SERVER['<variable seteada por server>'];

    //ultimo recurso, lo que envía el navegador 
  if( isset($_SERVER['REMOTE_ADDR']) ) 
    return $_SERVER['REMOTE_ADDR']; 

    //no hay nada definido
  return null; 
}

function returnMacAddress() {
  return false;
}

echo json_encode($bandera);
?>
