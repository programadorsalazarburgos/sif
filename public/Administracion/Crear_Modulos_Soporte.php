<?php

include_once('../../Modelo/Administracion/Acceso_Datos.php');

session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else {
	$Id_Persona= $_SESSION["session_username"];
}

$modulos = getModulosUsuario($Id_Persona);

foreach($modulos as $modulo)
{
	$actividades[$modulo['VC_Nom_Modulo']]=getActividadesUsuarioModulo($Id_Persona,$modulo['PK_Id_Modulo']);
	
}
echo $Id_Persona."<br><pre>".print_r($actividades,TRUE)."</pre>";