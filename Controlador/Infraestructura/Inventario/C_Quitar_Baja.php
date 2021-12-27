<?php
 header ('Content-type: text/html; charset=utf-8');
include_once('../../../Modelo/Infraestructura/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.
/**
* El id del inventario al que se agregara el elemento enviado por post mediante ajax con la clave "id"
*/
 $id_inventario=$_POST["id"];
 $id_usuario=$_POST["usuario_registro"];
 $resultado = Inventario::quitarBaja($id_inventario,$id_usuario);

 return $resultado;
?>