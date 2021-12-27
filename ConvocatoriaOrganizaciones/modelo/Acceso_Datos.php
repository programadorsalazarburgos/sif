<?php
/**
* Clase que realiza las operaciones de acceso a la base de datos.
* Área de Sistemas
* @author: Juan Modesto
* @version: 1.0.1
*/

header ('Content-type: text/html; charset=utf-8');
include_once('Conexion.php');

Class Convocatoria{
  /**
  * Retorna un vector con la informacion del USUARIO logueado
  * @return vector con la informacion del usuario
  */
  public static function obtenerBanderas($id_usuario)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'SELECT * FROM tb_propuesta_usuarios WHERE PK_Id_Usuario = "'.$id_usuario.'";');
 
    // Crear el array de elementos para la capa de la vista
    $info = array();
    while ($fila = mysqli_fetch_array($resultado))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    mysqli_close(ConexionDatos::conexion());
 
    return $info;
  }
  
  public static function actualizarPassword($id_usuario,$password)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la SENTENCIA SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'UPDATE tb_propuesta_usuarios SET VC_Password="'.md5($password).'", IN_Bandera_Pass=1 WHERE PK_Id_Usuario = "'.$id_usuario.'";');
    mysqli_close(ConexionDatos::conexion());
  }

  /**
  * Retorna un vector con la informacion del las propuestas de la convocatoria
  * @return vector con la informacion propuestas de la convocatoria
  */
  public static function obtenerConvocatoria($convocatoria)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'SELECT * FROM tb_propuesta_usuarios WHERE VC_Convocatoria = "'.$convocatoria.'" AND IN_Bandera_Habilitantes=1 AND IN_Bandera_Propuesta=1;');
 
    // Crear el array de elementos para la capa de la vista
    $info = array();
    while ($fila = mysqli_fetch_array($resultado))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    mysqli_close(ConexionDatos::conexion());
 
    return $info;
  }
}
?>