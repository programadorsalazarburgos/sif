<?php
 header ('Content-type: text/html; charset=utf-8');
include_once('../modelo/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.

/**
*El Id_Usuario enviado por post mediante ajax con la clave "id_usuario"
*/
 $Id_Usuario=$_POST["id_usuario"];
 /**
*La nueva contraseña enviada por post mediante ajax con la clave "password"
*/
 $password=$_POST["password"];

 $resultado = Convocatoria::actualizarPassword($Id_Usuario, $password);

 return $resultado;
?>