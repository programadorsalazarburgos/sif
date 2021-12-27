<?php
function conectar_bd(){
	try{
	   	global $conexio;
	    $elServer ="186.30.115.113";
	    $elUsr = "sif_dev";
	    $elPw  = "7412589630";
		$laBd = "db_sif_dev";
		$elPuerto = 8083;
	    try {
	    	$conexio = mysqli_connect($elServer, $elUsr , $elPw, $laBd, $elPuerto) or die (mysqli_error());
	    	mysqli_set_charset($conexio,"utf8");
	    } catch (Exception $e) {
	    }
	    mysqli_select_db($conexio,$laBd) or die (mysqli_error());

	}catch (Exception $e){

	}
}
?>
