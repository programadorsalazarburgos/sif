<?php

namespace General\Persistencia\DAOS; 


class TbOrganizaciones2017DAO extends GestionDAO {
    
    private $db;
    private $dbPDO;
    
    function __construct()
    {        
        $this->db=$this->obtenerBD();
        $this->dbPDO=$this->obtenerPDOBD();

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

    public function consultarObjeto($objeto) {            
        return $this->db->select("tb_organizaciones_2017",["PK_Id_Organizacion","VC_Nom_Organizacion"]);
    }

    public function consultarHistorialGruposAsignados($objeto){
        $id_clan = $objeto['id_clan'];
        $id_clan_string = "";
        foreach ($id_clan as $id) {
            $id_clan_string .= $id.",";
        }
        $id_clan_string =  substr($id_clan_string, 0, -1);

        return $this->db->query("SELECT O.DT_fecha_asignacion_grupo,
                CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS quien_asigno,
                O.FK_grupo,C.VC_Nom_Clan
            FROM tb_terr_grupo_arte_escuela_organizacion O
                LEFT JOIN tb_terr_grupo_arte_escuela G ON O.FK_grupo = G.PK_Grupo
                LEFT JOIN tb_persona_2017 P ON O.FK_usuario_asigno = P.PK_Id_Persona
                LEFT JOIN tb_clan C ON G.FK_clan = C.PK_Id_Clan
            WHERE O.FK_organizacion = ".$objeto['id_organizacion']." 
                AND C.PK_Id_Clan IN (".$id_clan_string.")")->fetchAll(); 
    }

    public function consultarHistorialArtistasGruposAsignados($objeto){
        $id_clan = $objeto['id_clan'];
        $id_clan_string = "";
        foreach ($id_clan as $id) {
            $id_clan_string .= $id.",";
        }
        $id_clan_string =  substr($id_clan_string, 0, -1);

        return $this->db->query("SELECT AF.FK_grupo,AF.DT_fecha_asignacion_grupo,CL.VC_Nom_Clan,COL.VC_Nom_Colegio,
               G.estado,G.DT_fecha_cierre,CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS artista_formador,
               CONCAT(P2.VC_Primer_Nombre,' ',P2.VC_Segundo_Nombre,' ',P2.VC_Primer_Apellido,' ',P2.VC_Segundo_Apellido) AS quien_asigno
            FROM tb_terr_grupo_arte_escuela_artista_formador AF
               LEFT JOIN tb_persona_2017 P ON AF.FK_artista_formador = P.PK_Id_Persona
               LEFT JOIN tb_terr_grupo_arte_escuela G ON AF.FK_grupo = G.PK_Grupo
               LEFT JOIN tb_organizaciones_2017 O ON G.FK_organizacion = O.Pk_Id_Organizacion
               LEFT JOIN tb_clan CL ON G.FK_clan = CL.PK_Id_Clan
               LEFT JOIN tb_colegios COL ON G.FK_colegio = COL.PK_Id_Colegio
               LEFT JOIN tb_persona_2017 P2 ON AF.FK_usuario_asigno = P2.PK_Id_Persona
            WHERE ".(($objeto['id_organizacion'] == 2)?" ":"O.FK_Coordinador = P2.PK_Id_Persona AND")." O.PK_Id_Organizacion= ".$objeto['id_organizacion']." 
                AND CL.PK_Id_Clan IN (".$id_clan_string.")")->fetchAll(); 
    }

    public function getOrganizaciones($id_usuario = NULL)    
    {
        
        if($id_usuario!=NULL)
            return $this->db->select("tb_organizaciones_2017",["PK_Id_Organizacion","VC_Nom_Organizacion"],
                                    ["fk_coordinador"=>$id_usuario]);            
        else
            return $this->db->select("tb_organizaciones_2017",["PK_Id_Organizacion","VC_Nom_Organizacion"]);
    }

    public function getAdministradorOrganizacion($id_organizacion){
        $sentencia = $this->dbPDO->prepare("SELECT VC_Nom_Organizacion,FK_Coordinador FROM tb_organizaciones_2017 WHERE PK_Id_Organizacion=:Pk_Id_Organizacion");
        try{
        $this->dbPDO->beginTransaction();

        $sentencia->bindParam(':Pk_Id_Organizacion',$id_organizacion);
        $sentencia->execute();

        $this->dbPDO->commit();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }catch(PDOExecption $e){
        $this->dbPDO->rollback();
        return "Error!: " . $e->getMessage() . "</br>";
      }
    }
}