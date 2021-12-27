<?php // You need to add server side validation and better error handling here
header ('Content-type: text/html; charset=utf-8');
include_once('modelo/Conexion.php');
session_start();
$id_usuario = $_POST["id_usuario"];
$nombre_usuario = $_POST["nombre_usuario"];
function quitar_tildes($cadena) {
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array("a","e","i","o","u","A","E","I","O","U","n","N","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		$texto = str_replace($no_permitidas, $permitidas ,$cadena);
		return $texto;
}

$data = array();
$fecha=date("Y-m-d-H:i:s");

if(isset($_FILES))
{	
	$nombre_carpeta = "archivospropuesta/".$nombre_usuario."-2016-12"; 
	//$nombre_carpeta = "archivospropuesta/"; 

	if(!is_dir($nombre_carpeta)){
		$mask=umask(0);
		@mkdir($nombre_carpeta, 0777);
		umask($mask);
	}else{ 
		echo "Ya existe ese directorio\n";
		mysqli_query(ConexionDatos::conexion(),'DELETE FROM TB_PROPUESTA_Proyecto_Archivos WHERE FK_Id_Usuario = "'.$id_usuario.'" AND VC_Fuente="PROPUESTA";');
		mysqli_close(ConexionDatos::conexion());
		foreach(glob($nombre_carpeta."/*") as $archivos_carpeta)
    	{
	        echo $archivos_carpeta;
        	if (is_file($archivos_carpeta))
        	{
	           unlink($archivos_carpeta);	           
        	}
    	} 
	}

	$error = false;
	$files = array();
	$uploaddir = './'.$nombre_carpeta.'/';

	foreach($_FILES as $file)
	{
		$path_info = pathinfo($file['name']);
		//$Id_Usuario = $id_usuario;
		$Tipo_Archivo = $path_info['extension'];
		$Nombre_Archivo = basename($file['name']);
		$Nombre_Archivo = quitar_tildes($Nombre_Archivo);
		$Ubicacion_Archivo =$nombre_carpeta."/".$Nombre_Archivo;

		if(move_uploaded_file($file['tmp_name'], $uploaddir.$Nombre_Archivo))
		{
			$files[] = $Ubicacion_Archivo;
			mysqli_query(ConexionDatos::conexion(),"INSERT INTO TB_PROPUESTA_Proyecto_Archivos (FK_Id_Usuario, VC_Nombre_Archivo, VC_Ubicacion, VC_Tipo, VC_Fuente) VALUES ('$id_usuario','$Nombre_Archivo','$Ubicacion_Archivo','$Tipo_Archivo', 'PROPUESTA')");
			mysqli_close(ConexionDatos::conexion());
		}
		else
		{
		    $error = true;
		}
	}
	$data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
	mysqli_query(ConexionDatos::conexion(),'UPDATE TB_PROPUESTA_Usuarios SET IN_Bandera_Propuesta=1 WHERE PK_Id_Usuario = "'.$id_usuario.'";');
	mysqli_close(ConexionDatos::conexion());
}
else
{
	$data = array('success' => 'Form was submitted', 'formData' => $_POST);
}
echo json_encode($data);
?>