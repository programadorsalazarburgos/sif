<?php

namespace General\Persistencia\DAOS; 


class ColegioDAO extends GestionDAO {

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

    public function consultarColegiosDeCrea($id_crea){
        $sentencia=$this->db->prepare("SELECT C.PK_Id_Colegio,C.VC_Nom_Colegio FROM tb_clan_colegio CC LEFT JOIN tb_colegios C ON CC.FK_Id_Colegio = C.PK_Id_Colegio WHERE CC.FK_Id_Clan = :id_crea");    
        $sentencia->bindParam(':id_crea',$id_crea);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);        
    }

    public function consultarIDColegioPorCodigoDANE($codigo_dane){
        $sentencia=$this->db->prepare("SELECT C.PK_Id_Colegio FROM tb_colegios C WHERE C.VC_DANE_12=:codigo_dane; ");    
        $sentencia->bindParam(':codigo_dane',$codigo_dane);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function asociarColegioCrea($id_crea, $id_colegio, $id_usuario){
        $set_id_usuario = $this->db->prepare("SET @user_id = :id_usuario;");
        $set_id_usuario->bindParam(':id_usuario',$id_usuario);
        $set_id_usuario->execute();
        $sentencia=$this->db->prepare("INSERT INTO tb_clan_colegio (FK_Id_Colegio, FK_Id_Clan) VALUES (:id_colegio,:id_crea); ");    
        $sentencia->bindParam(':id_crea',$id_crea);
        $sentencia->bindParam(':id_colegio',$id_colegio);
        $sentencia->execute();
        return $sentencia->rowCount();
    }
        public function eliminarColegioCrea($id_crea, $id_colegio, $id_usuario){
        $set_id_usuario = $this->db->prepare("SET @user_id = :id_usuario;");
        $set_id_usuario->bindParam(':id_usuario',$id_usuario);
        $set_id_usuario->execute();
        $sentencia=$this->db->prepare("DELETE FROM tb_clan_colegio WHERE FK_Id_Colegio=:id_colegio AND FK_Id_Clan=:id_crea;");    
        $sentencia->bindParam(':id_crea',$id_crea);
        $sentencia->bindParam(':id_colegio',$id_colegio);
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function consultarColegiosPorGrupo($id_grupo){
        $sentencia=$this->db->prepare("SELECT C.PK_Id_Colegio,C.VC_Nom_Colegio,C.VC_DANE_12 FROM tb_colegios C JOIN tb_terr_grupo_arte_escuela AE ON C.PK_Id_Colegio = AE.FK_colegio WHERE AE.PK_Grupo = :id_grupo");    
        $sentencia->bindParam(':id_grupo',$id_grupo);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);        
    }
}