<?php
namespace General\Persistencia\DAOS;
//use Global\Persistencia\Medoo\Medoo; //apuntando por el Autolader generado por mi :)
//use Medoo\Medoo; // apuntando a Medoo instalado por composer
//use Medoo\Medoo;

abstract class GestionDAO {

    // Forzar la extensión de clase para definir este método
    abstract protected function crearObjeto($objeto);

    abstract protected function modificarObjeto($objeto);

    abstract protected function eliminarObjeto($objeto);

    abstract protected function consultarObjeto($objeto);

    // Método común
    public static function obtenerPDOBD() {
        try
        {
          $db=new \PDO('mysql:dbname=db_sif_dev;host=186.30.115.113;charset=utf8;port=8083', 'sif_dev', '7412589630');
          $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
          return $db;
        }
        catch(PDOException $e)
        {
            echo "Error de conexion a la base de datos. ";  
            die(); 
        }
    }

    // Método común
    public static function obtenerBD() {
    // Establecer parametros de conexión a la base de datos
        try {

                return  new \Medoo([
                    'database_type' => 'mysql',
                    'database_name' => 'db_sif_dev',
                    'server' => '186.30.115.113',
                    'username' => 'sif_dev',
                    'password' => '7412589630',
                    'port' => '8083',
                    'charset' => 'utf8'

                ]);

            }
            catch (Exception $e) {
                //var_dump($e);   
                header('HTTP/1.1 500 Internal Server Booboo');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
            }
        }
    }
