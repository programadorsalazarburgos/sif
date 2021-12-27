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
        $elServer ="186.30.115.113";
        $elUsr = "sif_dev";
        $elPw  = "7412589630";
        $laBd = "db_sif_dev";
        $elPuerto = 8083;
        $conexion;
        try {
            $conexion = mysqli_connect($elServer, $elUsr , $elPw, $laBd, $elPuerto) or die (mysqli_error());
            mysqli_set_charset($conexion,"utf8");
        } catch (Exception $e) {
        }
        mysqli_select_db($conexion,$laBd) or die (mysqli_error());

        /**
        * Retorna la conexión
        * @return conexión establecida
        */
        return $conexion;
    }//fin metodo con
}//fin clase conexion
?>
