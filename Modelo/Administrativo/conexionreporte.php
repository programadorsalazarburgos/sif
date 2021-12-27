<?php
function conectar_bd(){
   	global $conexio;
    $elServer ="186.30.115.113";
    $elUsr = "sif_dev";
    $elPw  = "7412589630";
    $laBd = "db_sif_dev";
    $elPuerto = 8083;
    $conexio = mysql_connect($elServer, $elUsr , $elPw, $laBd, $elPuerto) or die (mysql_error());
    mysql_select_db($laBd, $conexio) or die (mysql_error());
}
?>
