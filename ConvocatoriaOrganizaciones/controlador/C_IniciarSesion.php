<?php
 header ('Content-type: text/html; charset=utf-8');
include_once('../modelo/Conexion.php');//Se incluye la Libreria de Acceso a la Base de Datos.
// server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 25200);//SIETE HORAS DE SESSION

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(25200);

session_start(); // ready to go!
/*session is started if you don't write this line can't use $_Session  global variable*/

$_SESSION["id_usuario"]="";
$id_usuario = "NULL";
$usuario=$_POST["usuario"];
$password=$_POST["password"];

$resultado = mysqli_query(ConexionDatos::conexion(),"SELECT * FROM tb_propuesta_usuarios WHERE VC_Nombre_Usuario ='".$usuario."' AND VC_Password = '".md5($password)."' AND IN_Estado=1;"); 
mysqli_close(ConexionDatos::conexion());

while ($row = $resultado->fetch_assoc()) {
        $id_usuario = $row['PK_Id_Usuario'];
        $_SESSION["id_usuario"]=$id_usuario;
        $_SESSION["nombre_usuario"]= $row['VC_Nombre_Usuario'];
        $_SESSION["nit"]= $row['VC_NIT'];
        $_SESSION["bandera_password"]= $row['IN_Bandera_Pass'];
        $_SESSION["bandera_habilitantes"]= $row['IN_Bandera_Habilitantes'];
        $_SESSION["bandera_password"]= $row['IN_Bandera_Propuesta'];
        $_SESSION["tipo"]= $row['IN_Tipo'];
}

echo $id_usuario;
?>