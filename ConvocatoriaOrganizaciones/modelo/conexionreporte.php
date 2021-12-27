<?php
function conectar_bd(){
	try{
	   	global $conexio;
	    $elServer ="172.16.83.34";
	    $elUsr = "siclango_dev";
	    $elPw  = "1qaz2wsx3edc";
	    $laBd = "sifidartesgov_db";
	    try {
	    	$conexio = mysqli_connect($elServer, $elUsr , $elPw) or die (mysqli_error());
	    } catch (Exception $e) {
	    }
	    mysqli_select_db($conexio,$laBd) or die (mysqli_error());

	}catch (Exception $e){

	}
}
?>
