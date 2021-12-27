<?php 
namespace General\Persistencia\DAOS;

class NidosDuplasDAO extends GestionDAO {

    private $db;
    private $dbPDO;

    function __construct()
  	{
  		$this->db=$this->obtenerBD();
  		$this->dbPDO=$this->obtenerPDOBD();
  	}

    public function crearObjeto($objeto) {

        $sql="INSERT INTO tb_nidos_dupla (Fk_Id_Tipo_Dupla,VC_Codigo_Dupla,Fk_Id_Territorio,Fk_Id_Gestor,IN_Estado,DT_Fecha_Creacion)
            VALUES (:TipoDupla, :CodigoDupla, :Territorio, :Gestor, :estado, :fecha_creacion)";
        @$sentencia=$this->dbPDO->prepare($sql);

        @$sentencia->bindParam(':TipoDupla',$objeto->getTipoDupla());
        @$sentencia->bindParam(':CodigoDupla',$objeto->getCodigoDupla());
        @$sentencia->bindParam(':Territorio',$objeto->getFkIdTerritorio());
        @$sentencia->bindParam(':Gestor',$objeto->getFkIdGestor());
        @$sentencia->bindParam(':estado',$objeto->getInEstado());
        @$sentencia->bindParam(':fecha_creacion',$objeto->getDtFechaCreacion());

        try {
            $this->dbPDO->beginTransaction();
            $sentencia->execute();
            $id_insertado = $this->dbPDO->lastInsertId();
            $Estado = '1';
            $Fecha_Creacion = date("Y-m-d H:i:s");
            $sql1="INSERT INTO tb_nidos_dupla_artista (Fk_Id_Dupla,Fk_Id_Persona,IN_Estado,DT_Fecha_Ingreso) VALUES (:FK_Dupla, :FK_artista, :In_Estado, :DT_FechaCreacion)";
            @$sentencia_artista=$this->dbPDO->prepare($sql1);
            $sentencia_artista->bindParam(':FK_artista', $id_artista);
            $sentencia_artista->bindParam(':FK_Dupla', $id_evento);
            $sentencia_artista->bindParam(':In_Estado', $Estado);
            $sentencia_artista->bindParam(':DT_FechaCreacion', $Fecha_Creacion );
            foreach ($objeto->getArtistasDupla() as $artistaDupla) {
                $id_artista=$artistaDupla;
                $id_evento=$id_insertado;
                $sentencia_artista->execute();
            }
            $this->dbPDO->commit();
            return $id_insertado;
        }
        catch(PDOExecption $e) {
            $this->dbPDO->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function modificarObjetoDupla($objeto) {

        $sql="UPDATE tb_nidos_dupla SET Fk_Id_Tipo_Dupla = :TipoDupla, VC_Codigo_Dupla = :CodigoDupla WHERE Pk_Id_Dupla = :idGrupo";

        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':idGrupo',$objeto->getPkIdDupla());
        @$sentencia->bindParam(':TipoDupla',$objeto->getTipoDupla());
        @$sentencia->bindParam(':CodigoDupla',$objeto->getCodigoDupla());
        try {
            $this->dbPDO->beginTransaction();
            $sentencia->execute();
            $id_insertado = $objeto->getPkIdDupla();
            $Estado = '1';
            $Fecha_Creacion = date("Y-m-d H:i:s");

            $sql1="INSERT INTO tb_nidos_dupla_artista (Fk_Id_Dupla,Fk_Id_Persona,IN_Estado,DT_Fecha_Ingreso) VALUES (:FK_Dupla, :FK_artista, :In_Estado, :DT_FechaCreacion)";

            @$sentencia_artista=$this->dbPDO->prepare($sql1);
            $sentencia_artista->bindParam(':FK_artista', $id_artista);
            $sentencia_artista->bindParam(':FK_Dupla', $id_evento);
            $sentencia_artista->bindParam(':In_Estado', $Estado);
            $sentencia_artista->bindParam(':DT_FechaCreacion', $Fecha_Creacion );

            foreach ($objeto->getArtistasDupla() as $artistaDupla) {
                $id_artista=$artistaDupla;
                $id_evento=$id_insertado;
                $sentencia_artista->execute();
            }
            $this->dbPDO->commit();
            return $id_insertado;
        }
        catch(PDOExecption $e) {
            $this->dbPDO->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
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

    public function consultarTipoDupla() {
            $sql="SELECT * FROM tb_nidos_tipo_dupla where Pk_Id_Tipo_dupla > 1";
            $sentencia=$this->dbPDO->prepare($sql);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTerritorio($id_usuario) {
        $sql="SELECT DISTINCT(TE.Pk_Id_Territorio), TE.Vc_Nom_Territorio
            FROM tb_nidos_persona_territorio AS PT
            JOIN tb_nidos_terri_locali AS TL ON PT.Fk_Id_Territorio = TL.Fk_Id_Territorio
            JOIN tb_nidos_territorios AS TE ON TL.Fk_Id_Territorio = TE.Pk_Id_Territorio
            WHERE PT.IN_Estado = 1 AND PT.Fk_Id_Persona = :usuario";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':usuario',$id_usuario);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarArtistas($id_dupla) {
      if($id_dupla == 0){
        $sql=" SELECT P.PK_Id_Persona, P.VC_Primer_Nombre, P.VC_Segundo_Nombre, P.VC_Primer_Apellido, P.VC_Segundo_Apellido 
               FROM tb_persona_2017 AS P 
               JOIN tb_acceso_usuario_2017 AS AC ON P.PK_Id_Persona = AC.FK_Id_Persona
               WHERE P.FK_Tipo_Persona = '16' AND AC.IN_Estado =  '1'";
      }
      else{
        $sql="SELECT
        DISTINCT P.PK_Id_Persona,
        P.VC_Primer_Nombre,
        P.VC_Segundo_Nombre,
        P.VC_Primer_Apellido,
        P.VC_Segundo_Apellido
        FROM tb_persona_2017 AS P
        JOIN tb_acceso_usuario_2017 AS AC ON P.PK_Id_Persona = AC.FK_Id_Persona
        WHERE P.PK_Id_Persona NOT IN (SELECT NDA.Fk_Id_Persona FROM tb_nidos_dupla_artista AS NDA WHERE NDA.Fk_Id_Dupla=:idDupla) AND P.FK_Tipo_Persona = '16' 
        AND AC.IN_Estado =  '1'";
      }
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':idDupla',$id_dupla);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarGestores() {
            $sql="SELECT P.PK_Id_Persona, P.VC_Primer_Nombre, P.VC_Segundo_Nombre, P.VC_Primer_Apellido, P.VC_Segundo_Apellido FROM tb_persona_2017 P where P.FK_Tipo_Persona = '22'";
            $sentencia=$this->dbPDO->prepare($sql);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarDuplasGuardadas($id_usuario) {
            $sql="SELECT TD.Vc_Descripcion,
				          ND.VC_Codigo_Dupla,
                  (SELECT GROUP_CONCAT(CONCAT(' ',PER.VC_Primer_Nombre,' ',PER.VC_Segundo_Nombre,' ',PER.VC_Primer_Apellido,' ',PER.VC_Segundo_Apellido,' ') )
					        FROM tb_nidos_dupla_artista DA, tb_persona_2017 PER
					        WHERE DA.Fk_Id_Dupla = ND.Pk_Id_Dupla AND DA.Fk_Id_Persona = PER.PK_Id_Persona AND DA.IN_Estado = 1)  AS 'ARTISTAS',
					        (CASE ND.IN_Estado WHEN '1' THEN 'ACTIVO' WHEN '2' THEN 'INACTIVO' END ) AS ESTADO
                  FROM tb_nidos_dupla  AS ND
                  JOIN tb_nidos_tipo_dupla AS TD ON ND.Fk_Id_Tipo_Dupla = TD.Pk_Id_Tipo_dupla
                  WHERE ND.IN_Estado = 1 AND ND.Fk_Id_Gestor = :usuario ORDER BY VC_Codigo_Dupla ";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':usuario',$id_usuario);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function TotalDuplasTerritorio($id_usuario) {
           $sql="SELECT COUNT(*) FROM tb_nidos_dupla WHERE IN_Estado = 1 AND Fk_Id_Gestor = :usuario";
           @$sentencia=$this->dbPDO->prepare($sql);
           @$sentencia->bindParam(':usuario',$id_usuario);
           $sentencia->execute();
           return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function ConsultarDuplasM($id_usuario) {
           $sql="SELECT Pk_Id_Dupla, VC_Codigo_Dupla FROM tb_nidos_dupla WHERE IN_Estado = 1 AND Fk_Id_Gestor = :usuario";
           @$sentencia=$this->dbPDO->prepare($sql);
           @$sentencia->bindParam(':usuario',$id_usuario);
           $sentencia->execute();
           return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function consultarDuplaModificar($id_dupla){
       $sql="SELECT * FROM tb_nidos_dupla WHERE IN_Estado = 1 AND Pk_Id_Dupla = :dupla";
       @$sentencia=$this->dbPDO->prepare($sql);
       @$sentencia->bindParam(':dupla',$id_dupla);
       $sentencia->execute();
       return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function contarGruposTerritorio($id_territorio){
         $sql="SELECT COUNT(Pk_Id_Grupo) AS total_grupos from tb_nidos_grupos G left join tb_nidos_dupla D ON G.Fk_Id_Dupla = D.Pk_Id_Dupla where G.IN_Estado = '1' AND D.Fk_Id_Territorio = :id_territorio";
         $sentencia=$this->dbPDO->prepare($sql);
         @$sentencia->bindParam(':id_territorio',$id_territorio);
         $sentencia->execute();
         return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }

    public function ConsultarArtistasDupla($id_dupla){
             $sql="SELECT  Pk_Id_Dupla_Artista AS IDARTISTA,
                           VC_Identificacion AS IDENTIFICACION,
		                       concat(VC_Primer_Nombre,' ',VC_Segundo_Nombre,' ',VC_Primer_Apellido,' ',VC_Segundo_Apellido) AS ARTISTA,
		                       IN_Estado AS ESTADO,
                           DT_Fecha_Ingreso AS INGRESO,
                           DT_Fecha_Retiro AS RETIRO
                           FROM tb_nidos_dupla_artista DA, tb_persona_2017 P WHERE P.PK_Id_Persona = DA.Fk_Id_Persona  AND DA.Fk_Id_Dupla = :id_dupla;";
             $sentencia=$this->dbPDO->prepare($sql);
             @$sentencia->bindParam(':id_dupla',$id_dupla);
             $sentencia->execute();
             return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
     }

     public function InactivarArtistaObjeto($objeto) {
         $sql="UPDATE tb_nidos_dupla_artista SET IN_Estado = :estado, DT_Fecha_Retiro = :fechaInactivar  WHERE Pk_Id_Dupla_Artista = :idArtista";
             @$sentencia=$this->dbPDO->prepare($sql);
             @$sentencia->bindParam(':idArtista',$objeto->getPkIdDupla());
             @$sentencia->bindParam(':estado',$objeto->getInEstado());
             @$sentencia->bindParam(':fechaInactivar',$objeto->getDtFechaCreacion());
             $sentencia->execute();
             return $sentencia->rowCount();
      }

      public function ActivarArtistaObjeto($objeto) {
          $sql="UPDATE tb_nidos_dupla_artista SET IN_Estado = :estado, DT_Fecha_Ingreso = :fechaActivar  WHERE Pk_Id_Dupla_Artista = :idArtista";
             @$sentencia=$this->dbPDO->prepare($sql);
             @$sentencia->bindParam(':idArtista',$objeto->getPkIdDupla());
             @$sentencia->bindParam(':estado',$objeto->getInEstado());
             @$sentencia->bindParam(':fechaActivar',$objeto->getDtFechaCreacion());
              $sentencia->execute();
               return $sentencia->rowCount();
      }


      public function consultaTodaslasDuplas(){
        $sql="SELECT Pk_Id_Dupla, VC_Codigo_Dupla FROM tb_nidos_dupla";
        $sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }

      public function consultaDuplasTerritorio($parametro){
        $sql="SELECT Pk_Id_Dupla, VC_Codigo_Dupla FROM tb_nidos_dupla WHERE IN_Estado = 1 AND Fk_Id_Gestor = :id_territorio";
        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_territorio',$parametro);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }

      public function consultaGruposDupla($id_dupla){
        $sql="SELECT G.Pk_Id_Grupo, E.Vc_Estrategia, LU.VC_Nombre_Lugar, G.VC_Nombre_Grupo
        FROM tb_nidos_grupos G
        JOIN tb_nidos_lugar_atencion AS LU ON G.Fk_Id_Lugar_Atencion = LU.Pk_Id_lugar_atencion
        JOIN tb_nidos_estrategia AS E ON G.Fk_Id_Estrategia_Atencion = E.Pk_Id_Estrategia
        WHERE Fk_Id_Dupla = :id_dupla AND G.IN_Estado = '1' order by VC_Nombre_Lugar, VC_Nombre_Grupo";
        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_dupla',$id_dupla);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }


      public function modificarGruposDupla($objeto) {
      $sql="UPDATE tb_nidos_grupos SET Fk_Id_Dupla = :dupla WHERE Pk_Id_Grupo = :grupo";
        $sentencia=$this->dbPDO->prepare($sql);
        $this->dbPDO->beginTransaction();
        @$sentencia->bindParam(':dupla',$objeto->getFkIdDupla());
        @$sentencia->bindParam(':grupo', $id_grupo);

         foreach ($objeto->getIdGrupo() as $grupo) {
          $id_grupo=$grupo;
          $sentencia->execute();
       }
       $this->dbPDO->commit();
       return true;

      }

      public function consultaNombreGestor($id_usuario){
        $sql="SELECT CONCAT(VC_Primer_Nombre,' ',VC_Segundo_Nombre,' ',VC_Primer_Apellido,' ',VC_Segundo_Apellido) AS 'GESTOR' FROM tb_persona_2017 WHERE PK_Id_Persona = :Usuario";
        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':Usuario',$id_usuario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }


}
