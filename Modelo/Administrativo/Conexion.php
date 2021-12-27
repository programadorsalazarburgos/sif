<?php
/**
* Clase que establece la conexión a la base de Datos.
* Área de Sistemas
* @author: Juan Modesto
* @version: 1.0.1
*/

Class ConexionDatos{
    //$connection[]=array();
  public static function conexion()
  {
        /**
        * El nombre del servidor
        */
        $conection['server']="186.30.115.113";

        /**
        * El nombre del usuario
        */
        $conection['user']="sif_dev";

        /**
        * La contraseña de acceso a la base de datos
        */
        $conection['pass']="7412589630";

        /**
        * El nombre de la base de datos
        */
        $conection['base']="db_sif_dev";

        /**
        * El puerto
        */
        $conection['port']=8083;

    /**
    * Variable que almacena el resultado de la conexión
    */
    $conexion= mysqli_connect($conection['server'],$conection['user'],$conection['pass'], $conection['base'], $conection['port']);

    if(!$conexion)
    {
            die("Error en la conexion : ".$conexion->connect_errno.“-“.$conexion->connect_error);
    }

    //@mysqli_query("SET NAMES 'utf8'");

    /**
    * Retorna la conexión
    * @return conexión establecida
    */
    return $conexion;
  }//fin metodo con
}//fin clase conexion
?>
