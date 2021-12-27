<?php

namespace General\Persistencia\DAOS;


class NidosPersonaTerritorioDAO extends GestionDAO {

    private $db;

    function __construct()
  	{
  		$this->db=$this->obtenerBD();
  		$this->dbPDO=$this->obtenerPDOBD();
  	}

    public function crearObjeto($objeto) {

        $sql="INSERT INTO tb_nidos_persona_territorio (Fk_Id_Persona,Fk_Id_Territorio)  VALUES (:fkpersona, :fkterritorio)";
        @$sentencia=$this->dbPDO->prepare($sql);

        @$sentencia->bindParam(':fkpersona',$objeto->getFkIdPersona());
        @$sentencia->bindParam(':fkterritorio',$objeto->getFkIdTerritorio());

        $sentencia->execute();

        return $sentencia->rowCount();
        return;
    }


    public function modificarObjeto($objeto) {
      $sql="UPDATE tb_nidos_persona_territorio SET
      Fk_Id_Persona=:fkpersona,
      Fk_Id_Territorio=:fkterritorio
      WHERE Pk_Id_Person_Territo=:idterritorio";
      @$sentencia=$this->dbPDO->prepare($sql);

      @$sentencia->bindParam(':idterritorio',$objeto->getIdPersonTerrito());
      @$sentencia->bindParam(':fkpersona',$objeto->getFkIdPersona());
      @$sentencia->bindParam(':fkterritorio',$objeto->getFkIdTerritorio());

      $sentencia->execute();
      return $sentencia->rowCount();
    }

    public function eliminarObjeto($objeto) {

            return;
    }


    public function consultarObjeto($objeto) {

          return;

    }

    public function consultarUsuariosNidos() {
      $sql="SELECT
      PK_Id_Persona,
      CONCAT(VC_Primer_Nombre,' ',VC_Segundo_Nombre,' ',VC_Primer_Apellido,' ',VC_Segundo_Apellido) AS 'Nombre'
      FROM tb_persona_2017
      WHERE FK_Tipo_Persona='16' OR FK_Tipo_Persona='20' OR FK_Tipo_Persona='22'";
      @$sentencia=$this->dbPDO->prepare($sql);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarInformacionUsuario($idUsuario){
      $sql="SELECT
      PK_Id_Persona,
      VC_Identificacion,
      CONCAT(VC_Primer_Nombre,' ',VC_Segundo_Nombre,' ',VC_Primer_Apellido,' ',VC_Segundo_Apellido) AS 'Nombre'
      FROM tb_persona_2017
      WHERE PK_Id_Persona=:idUsuario";
      @$sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':idUsuario',$idUsuario);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTerritorioUsuario($idUsuario){
      $sql="SELECT
      PT.Pk_Id_Person_Territo,
      T.Vc_Nom_Territorio
      FROM tb_nidos_persona_territorio AS PT
      JOIN tb_nidos_territorios AS T ON T.Pk_Id_Territorio=PT.Fk_Id_Territorio
      WHERE PT.Fk_Id_Persona=:idUsuario";
      @$sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':idUsuario',$idUsuario);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTerritorios(){
      $sql="SELECT
      *
      FROM tb_nidos_territorios
      ORDER BY Vc_Nom_Territorio ASC";
      @$sentencia=$this->dbPDO->prepare($sql);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarUsuariosTerritorio($idsTerritorio){
      $sql="SELECT
	    T.Vc_Nom_Territorio,
      P.VC_Identificacion,
      CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'Nombre',
      TP.VC_Nom_Tipo
      FROM tb_nidos_persona_territorio AS PT
      JOIN tb_nidos_territorios AS T ON T.Pk_Id_Territorio=PT.Fk_Id_Territorio
      JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=PT.Fk_Id_Persona
      JOIN tb_tipo_persona AS TP ON TP.PK_Id_Tipo_Persona=P.FK_Tipo_Persona
      WHERE  FIND_IN_SET(PT.Fk_Id_Territorio, :idsTerritorio)";
      @$sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':idsTerritorio',$idsTerritorio);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

}
