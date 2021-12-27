<?php
namespace General\Persistencia\DAOS; 


class TbNotificacionDAO extends GestionDAO {
    
    private $db;
    private $dbPDO;
    
    function __construct()
    {        
        //$this->db=$this->obtenerBD();
        $this->dbPDO=$this->obtenerPDOBD();
    }
    
    public function crearObjeto($objetos) {
            

    }

    public function modificarObjeto($objeto) {

            return;
    }

    public function eliminarObjeto($objeto) {

            return;
    }

    public function consultarObjeto($objeto) {

            return;
    }

    public function ejecutarProcedimiento($objeto=null) {            
        //$sql="CALL sp_notificacion_c(CURRENT_DATE-1);";
        $sql="CALL sp_notificacion(CURRENT_DATE);"; 
        @$sentencia=$this->dbPDO->prepare($sql); 
        $sentencia->execute();  
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);            
    }

    public function getAllNotificationsData($idUsuario){
        $sql="SELECT * FROM tb_notificacion_persona AS NP
              JOIN tb_notificacion P ON P.PK_Notificacion_Id=NP.FK_Notificacion
              WHERE NP.FK_Persona=:idUsuario ORDER BY P.DT_Fecha DESC LIMIT 1500"; 

        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':idUsuario',$idUsuario);
        $sentencia->execute();  
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);          
    }  

    public function getNotificacionesData($idUsuario){

        $sql="SELECT * FROM tb_notificacion_persona AS NP
              JOIN tb_notificacion P ON P.PK_Notificacion_Id=NP.FK_Notificacion
              WHERE NP.FK_Persona=:idUsuario AND NP.IN_Visto=0 ORDER BY P.DT_Fecha ASC"; 

        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':idUsuario',$idUsuario);
        $sentencia->execute();  
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);          
    }    

    public function setNotificationUserView($idUsuario,$notificationId){
        $sql="UPDATE tb_notificacion_persona 
              SET IN_Visto=1, DT_Fecha_Visto=:fechaVisto
              WHERE FK_persona=:idUsuario AND FK_Notificacion=:notificationId";

        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':fechaVisto',date('Y-m-d H:i:s'));
        @$sentencia->bindParam(':idUsuario',$idUsuario);
        @$sentencia->bindParam(':notificationId',$notificationId);
        $sentencia->execute();  
        return $sentencia->rowCount();  
    }  
    public function setNotificacionesLeidas($idUsuario){
        $sql="UPDATE tb_notificacion_persona 
              SET IN_Visto=1, DT_Fecha_Visto=:fechaVisto
              WHERE FK_persona=:idUsuario AND IN_Visto=0";
        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':fechaVisto',date('Y-m-d H:i:s'));
        @$sentencia->bindParam(':idUsuario',$idUsuario);
        $sentencia->execute();  
        return $sentencia->rowCount();  
    }  

    public function saveNotificationUserData($objeto,$userId){ 
        date_default_timezone_set('America/Bogota');
        $notificationId=0;
        $sql="INSERT INTO tb_notificacion
              (FK_Tipo_Alcance,FK_Tipo_Notificacion,VC_Contenido,VC_Url,DT_Fecha,VC_Icon)
              VALUES (2,3,:contenido,:url,:fecha,:icon);";
        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':contenido',$objeto->getVcContenido()); 
        @$sentencia->bindParam(':url',$objeto->getVcUrl());
        @$sentencia->bindParam(':fecha',date('Y-m-d H:i:s'));
        @$sentencia->bindParam(':icon',$objeto->getVcIcon()); 
        try {
            $this->dbPDO->beginTransaction();
            $sentencia->execute();
            $notificationId= $this->dbPDO->lastInsertId(); 
            $sqlNP="INSERT INTO tb_notificacion_persona
              (FK_Notificacion,FK_Persona,IN_Visto)
              VALUES (:notificationId,:userId,0);";
            @$sentenciaNP=$this->dbPDO->prepare($sqlNP); 
            @$sentenciaNP->bindParam(':notificationId',$notificationId);
            @$sentenciaNP->bindParam(':userId',$userId);  
            $sentenciaNP->execute();
            $this->dbPDO->commit();
        }catch(PDOExecption $e) {
            $this->dbPDO->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }            

        return $notificationId;
    }         

    public function saveNotificationRoleData($objeto,$roleId){
        date_default_timezone_set('America/Bogota');
        $notificationId=0;
        $sql="INSERT INTO tb_notificacion
              (FK_Tipo_Alcance,FK_Tipo_Notificacion,VC_Contenido,VC_Url,DT_Fecha,VC_Icon)
              VALUES (2,3,:contenido,:url,:fecha,:icon);";
        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':contenido',$objeto->getVcContenido()); 
        @$sentencia->bindParam(':url',$objeto->getVcUrl());
        @$sentencia->bindParam(':fecha',date('Y-m-d H:i:s'));
        @$sentencia->bindParam(':icon',$objeto->getVcIcon()); 
        try { 
            $this->dbPDO->beginTransaction();
            $sentencia->execute();
            $notificationId= $this->dbPDO->lastInsertId();             
            $sqlNP="INSERT INTO tb_notificacion_persona
              (FK_Notificacion,FK_Persona,IN_Visto)
              VALUES (:notificationId,:userId,0);";
            @$sentenciaNP=$this->dbPDO->prepare($sqlNP); 
            @$sentenciaNP->bindParam(':notificationId',$notificationId);
            @$sentenciaNP->bindParam(':userId',$userId);
            $sqlPersona="SELECT PK_Id_Persona FROM tb_persona_2017 WHERE FIND_IN_SET(FK_Tipo_Persona,:roleId);";
            @$sentenciaPersona=$this->dbPDO->prepare($sqlPersona); 
            @$sentenciaPersona->bindParam(':roleId',$roleId);   
            $sentenciaPersona->execute();
            $personas=$sentenciaPersona->fetchAll(\PDO::FETCH_ASSOC);  
            foreach ($personas as $persona){
                $userId=$persona['PK_Id_Persona'];
                $sentenciaNP->execute();                
            }
            $this->dbPDO->commit(); 
        }catch(PDOExecption $e) {
            $this->dbPDO->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }            

        return $notificationId;
    }

    public function getNotificacionAnexo($idNotificacion){
        $sql="SELECT DT_Fecha,TX_Datos_Extra FROM tb_notificacion 
            WHERE PK_Notificacion_Id=:idNotificacion;"; 
        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':idNotificacion',$idNotificacion);
        $sentencia->execute();  
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);  

    }    

    public function getGruposArteEscuela($gruposText){
        $sql="SELECT G.PK_Grupo, C.VC_Nom_Clan, AA.VC_Nom_Area,
              O.VC_Nom_Organizacion,G.FK_artista_formador,G.TX_observaciones,
              P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.VC_Primer_Apellido,
              P.VC_Segundo_Apellido  FROM tb_terr_grupo_arte_escuela G
              JOIN tb_areas_artisticas AS AA ON G.FK_area_artistica=AA.PK_Area_Artistica
              JOIN tb_clan AS C ON G.FK_clan=C.PK_Id_Clan
              JOIN tb_persona_2017 AS P ON G.FK_artista_formador=P.PK_Id_Persona
              JOIN tb_organizaciones_2017 AS O ON G.FK_organizacion=O.PK_Id_Organizacion
              WHERE FIND_IN_SET(G.PK_Grupo,:grupos);";
        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':grupos',$gruposText);
        $sentencia->execute();  
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);           
    }    

    public function getGruposEmprendeClan($gruposText){
        $sql="SELECT G.PK_Grupo, C.VC_Nom_Clan, AA.VC_Nom_Area,
              O.VC_Nom_Organizacion,G.FK_artista_formador,G.TX_observaciones,
              P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.VC_Primer_Apellido,
              P.VC_Segundo_Apellido  FROM tb_terr_grupo_emprende_clan G
              JOIN tb_areas_artisticas AS AA ON G.FK_area_artistica=AA.PK_Area_Artistica
              JOIN tb_clan AS C ON G.FK_clan=C.PK_Id_Clan
              JOIN tb_persona_2017 AS P ON G.FK_artista_formador=P.PK_Id_Persona
              JOIN tb_organizaciones_2017 AS O ON G.FK_organizacion=O.PK_Id_Organizacion
              WHERE FIND_IN_SET(G.PK_Grupo,:grupos);";
        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':grupos',$gruposText);
        $sentencia->execute();  
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);         
    } 

    public function consultarHorarioGrupoArteEscuela($id_grupo){
        $sql="SELECT * FROM tb_terr_grupo_arte_escuela_horario_clase 
              WHERE FK_grupo=:id_grupo;"; 
        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':id_grupo',$id_grupo);
        $sentencia->execute();  
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);  
    }   

    public function consultarHorarioGrupoEmprendeClan($id_grupo){
        $sql="SELECT * FROM tb_terr_grupo_emprende_clan_horario_clase 
              WHERE FK_grupo=:id_grupo;"; 
        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':id_grupo',$id_grupo);
        $sentencia->execute();  
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);  
    }       
}

