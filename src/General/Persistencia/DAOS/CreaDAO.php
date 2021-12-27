<?php

namespace General\Persistencia\DAOS; 


class CreaDAO extends GestionDAO {
    
    private $db;
    
    function __construct()
    {        
        $this->db=$this->obtenerPDOBD();
    }
    
    public function crearObjeto($objeto) {

        return;
    }

    public function modificarObjeto($objeto) {

        return;
    }

    public function eliminarObjeto($objeto) {

        return;
    }

    public function consultarObjeto($localidad){
        
        return;
    }

    public function consultarDatosAdministradorCrea($id_crea){
        $sentencia=$this->db->prepare("SELECT FK_Persona_Administrador FROM tb_clan WHERE PK_Id_Clan = :id_crea");
        @$sentencia->bindParam(':id_crea',$id_crea);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarDatosGestor($id_crea){
        
        $sentencia=$this->db->prepare("SELECT FK_persona_responsable 
                                            FROM tb_zonas 
                                            WHERE (VC_Creas LIKE CONCAT(:id_crea, ',%')
                                                OR VC_Creas LIKE CONCAT('%,', :id_crea, ',%')
                                                OR VC_Creas LIKE CONCAT('%,', :id_crea))
                                    ");

        @$sentencia->bindParam(':id_crea',$id_crea);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarNombreCrea($id_crea){
        $sentencia=$this->db->prepare("SELECT VC_Nom_Clan FROM tb_clan WHERE PK_Id_Clan = :id_crea");
        @$sentencia->bindParam(':id_crea',$id_crea);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

}