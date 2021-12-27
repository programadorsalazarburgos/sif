<?php
namespace General\Persistencia\DAOS; 


class TbFormadorOrganizacion2017DAO extends GestionDAO {
    
    private $db;
    
    function __construct()
    {                
        $this->db=$this->obtenerPDOBD();
    }
    
    public function crearObjeto($objeto) {
            
        $sql="INSERT INTO tb_formador_organizacion_2017 (FK_Id_Persona,FK_Id_Organizacion,DT_fecha_asignacion)
            VALUES (:artista,:organizacion,:fecha)";
        @$sentencia=$this->db->prepare($sql);  
        @$sentencia->bindParam(':artista',$objeto->getFkIdPersona());
        @$sentencia->bindParam(':organizacion',$objeto->getFkIdOrganizacion());
        @$sentencia->bindParam(':fecha',$objeto->getDtFechaAsignacion());
        $sentencia->execute(); 
        return $sentencia->rowCount();  
    }

    public function modificarObjeto($objeto) {

            return;
    }

    public function eliminarObjeto($objeto) {

            return;
    }

    public function consultarObjeto($localidad) {            
        return; 
    }



}

