<?php 
namespace General\Persistencia\DAOS;
class NidosLugaresDAO extends GestionDAO {

    private $db;
    function __construct()
  	{
  		$this->db=$this->obtenerBD();
  		$this->dbPDO=$this->obtenerPDOBD();
  	}

    public function crearObjeto($objeto) {
        $sql="INSERT INTO tb_nidos_lugar_atencion (Fk_Id_Localidad,Fk_Id_Upz,VC_Barrio,fk_Id_Entidad,VC_Tipo_Lugar,VC_Nombre_Lugar,VC_Direccion,VC_Telefono,VC_Coordinador,VC_Email,VC_Celular,IN_Estado,Fk_Id_Usuario_Crea,DT_Fecha_Creacion)
            VALUES (:localidad, :upz, :barrio, :Entidad, :tipolugar, :nomlugar, :direccion, :telefono,  :coordinador, :email, :celular, :estado, :usuario, :fecha_creacion)";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':localidad',$objeto->getFkLocalidad());
        @$sentencia->bindParam(':upz',$objeto->getFkUpz());
        @$sentencia->bindParam(':barrio',$objeto->getVcBarrio());
        @$sentencia->bindParam(':Entidad',$objeto->getFkIdEntidad());
        @$sentencia->bindParam(':tipolugar',$objeto->getVcTipoLugar());
        @$sentencia->bindParam(':nomlugar',$objeto->getVcNombreLugar());
        @$sentencia->bindParam(':direccion',$objeto->getVcDireccion());
        @$sentencia->bindParam(':telefono',$objeto->getVcTelefono());
        @$sentencia->bindParam(':coordinador',$objeto->getVcCoordinador());
        @$sentencia->bindParam(':email',$objeto->getVcEmail());
        @$sentencia->bindParam(':celular',$objeto->getVcCelular());
        @$sentencia->bindParam(':estado',$objeto->getVcEstado());
        @$sentencia->bindParam(':usuario',$objeto->getUsuarioCrea());
        @$sentencia->bindParam(':fecha_creacion',$objeto->getDtFechaCreacion());
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function modificarObjetoLugar($objeto) {
        $sql="UPDATE tb_nidos_lugar_atencion SET  Fk_Id_Localidad = :localidad,  Fk_Id_Upz = :upz, VC_Barrio = :barrio, fk_Id_Entidad = :Entidad, VC_Tipo_Lugar = :tipolugar, VC_Nombre_Lugar = :nomlugar, VC_Direccion = :direccion,
        VC_Telefono = :telefono, VC_Coordinador = :coordinador, VC_Email = :email, VC_Celular = :celular, IN_Estado = :estado WHERE Pk_Id_lugar_atencion = :idLugar";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':idLugar',$objeto->getPkJardin());
        @$sentencia->bindParam(':localidad',$objeto->getFkLocalidad());
        @$sentencia->bindParam(':upz',$objeto->getFkUpz());
        @$sentencia->bindParam(':barrio',$objeto->getVcBarrio());
        @$sentencia->bindParam(':Entidad',$objeto->getFkIdEntidad());
        @$sentencia->bindParam(':tipolugar',$objeto->getVcTipoLugar());
        @$sentencia->bindParam(':nomlugar',$objeto->getVcNombreLugar());
        @$sentencia->bindParam(':direccion',$objeto->getVcDireccion());
        @$sentencia->bindParam(':telefono',$objeto->getVcTelefono());
        @$sentencia->bindParam(':coordinador',$objeto->getVcCoordinador());
        @$sentencia->bindParam(':email',$objeto->getVcEmail());
        @$sentencia->bindParam(':celular',$objeto->getVcCelular());
        @$sentencia->bindParam(':estado',$objeto->getVcEstado());
        $sentencia->execute();

        return $sentencia->rowCount();
    }

    public function modificarObjeto($objeto) {
            return;
    }

    public function eliminarObjeto($objeto) {
       $sql="UPDATE tb_nidos_lugar_atencion SET IN_Estado = :estado WHERE Pk_Id_lugar_atencion = :idLugar";
       @$sentencia=$this->dbPDO->prepare($sql);
       @$sentencia->bindParam(':idLugar',$objeto->getPkJardin());
       @$sentencia->bindParam(':estado',$objeto->getVcEstado());
       $sentencia->execute();
      return $sentencia->rowCount();
    }

    public function consultarObjeto($objeto) {
          return;
    }

    public function consultarLugarAtencion() {
      $sql="SELECT * FROM tb_nidos_tipo_lugar";
      $sentencia=$this->dbPDO->prepare($sql);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarEntidades() {
      $sql="SELECT * FROM tb_nidos_entidades";
      $sentencia=$this->dbPDO->prepare($sql);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarLugaresGuardados($id_territorio) {
            $sql="SELECT
                 LA.Pk_Id_lugar_atencion,
                 LA.Fk_Id_Localidad,
                 L.VC_Nom_Localidad,
                 LA.Fk_Id_Upz,
                 U.VC_Nombre_Upz,
                 LA.VC_Barrio,
                 LA.Fk_Id_Entidad,
                 E.Vc_Nom_Entidad,
                 LA.VC_Tipo_Lugar,
                 TL.Vc_Descripcion,
                 LA.VC_Nombre_Lugar,
                 LA.VC_Direccion,
                 LA.VC_Telefono,
                 LA.VC_Coordinador,
                 LA.VC_Email,
                 LA.VC_Celular,
                 LA.IN_Estado
                 FROM tb_nidos_lugar_atencion  AS LA
                 JOIN tb_localidades AS L ON LA.Fk_Id_Localidad = L.Pk_Id_Localidad
                 LEFT JOIN tb_upz AS U ON LA.Fk_Id_Upz = U.Pk_Id_Upz
                 LEFT JOIN tb_nidos_tipo_lugar AS TL ON LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
                 LEFT JOIN tb_nidos_entidades AS E ON  LA.Fk_Id_Entidad = E.Pk_Id_Entidad
                 LEFT JOIN tb_nidos_terri_locali AS TE ON LA.Fk_Id_Localidad = TE.Fk_Id_Localidad
                 WHERE  TE.Fk_Id_Territorio = :territorio";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':territorio',$id_territorio);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

          public function TotalLugaresTerritorio($id_territorio) {
                 $sql="  SELECT COUNT(*)
                         FROM tb_nidos_lugar_atencion AS LA
                         LEFT JOIN tb_nidos_terri_locali AS TE ON LA.Fk_Id_Localidad = TE.Fk_Id_Localidad
                         WHERE IN_Estado = '1' AND TE.Fk_Id_Territorio = :territorio";
                 @$sentencia=$this->dbPDO->prepare($sql);
                 @$sentencia->bindParam(':territorio',$id_territorio);
                 $sentencia->execute();
                 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
         }

      public function ConsultarLugaresM($id_territorio) {
           $sql="SELECT Pk_Id_lugar_atencion, VC_Nombre_Lugar
                 FROM tb_nidos_lugar_atencion AS LA
                 JOIN tb_nidos_terri_locali AS TE ON LA.Fk_Id_Localidad = TE.Fk_Id_Localidad
                 WHERE LA.IN_Estado = '1' AND TE.Fk_Id_Territorio = :territorio";
           @$sentencia=$this->dbPDO->prepare($sql);
           @$sentencia->bindParam(':territorio',$id_territorio);
           $sentencia->execute();
           return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }

public function ConsultarNomTerritorio($id_usuario) {
       $sql="SELECT NT.Pk_Id_Territorio, NT.Vc_Nom_Territorio
             FROM tb_nidos_persona_territorio PT, tb_nidos_territorios NT
             WHERE NT.Pk_Id_Territorio = PT.Fk_Id_Territorio AND PT.IN_Estado = 1 AND  PT.Fk_Id_Persona = :usuario";
       @$sentencia=$this->dbPDO->prepare($sql);
       @$sentencia->bindParam(':usuario',$id_usuario);
       $sentencia->execute();
       return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultarLugarModificar($id_lugar){
    $sql="SELECT * FROM tb_nidos_lugar_atencion WHERE Pk_Id_lugar_atencion = :lugar";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':lugar',$id_lugar);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

//****************** CONSULTAS ACTIVIDAD LUGARES PEDAGOGICOS  ******//////////
    public function crearObjetoPedagogico($objeto) {
        $sql="INSERT INTO tb_nidos_lugar_pedagogico (Fk_Id_Localidad,Fk_Id_Upz,VC_Barrio,VC_Nombre_Lugar,IN_Estado,Fk_Id_Usuario_Crea,DT_Fecha_Creacion)
            VALUES (:localidad, :upz, :barrio, :nomlugar, :estado, :usuario, :fecha_creacion)";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':localidad',$objeto->getFkLocalidad());
            @$sentencia->bindParam(':upz',$objeto->getFkUpz());
            @$sentencia->bindParam(':barrio',$objeto->getVcBarrio());
            @$sentencia->bindParam(':nomlugar',$objeto->getVcNombreLugar());
            @$sentencia->bindParam(':estado',$objeto->getVcEstado());
            @$sentencia->bindParam(':usuario',$objeto->getUsuarioCrea());
            @$sentencia->bindParam(':fecha_creacion',$objeto->getDtFechaCreacion());
            $sentencia->execute();
            return $sentencia->rowCount();
    }

    public function consultarLugaresPedagogicos($id_usuario) {
            $sql="SELECT LP.Pk_Id_lugar_pedagogico AS 'IdLugar', L.VC_Nom_Localidad AS 'Localidad', U.VC_Nombre_Upz  AS 'Upz', LP.VC_Barrio AS 'Barrio', LP.VC_Nombre_Lugar AS 'Lugar'
            FROM tb_nidos_lugar_pedagogico AS LP
            JOIN tb_localidades AS L ON LP.Fk_Id_Localidad = L.Pk_Id_Localidad
            JOIN tb_upz AS U ON LP.Fk_Id_Upz = U.Pk_Id_Upz
            WHERE LP.IN_Estado = 1 AND Fk_Id_Usuario_Crea = :usuario";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':usuario',$id_usuario);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function TotalLugaresPedagogico() {
            $sql="SELECT COUNT(*) FROM tb_nidos_lugar_pedagogico WHERE IN_Estado = '1'";
            @$sentencia=$this->dbPDO->prepare($sql);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function ConsultarLugaresPedagogicoM() {
            $sql="SELECT Pk_Id_lugar_pedagogico, VC_Nombre_Lugar FROM tb_nidos_lugar_pedagogico WHERE IN_Estado = '1'";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':usuario',$id_usuario);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarLugarPedagogicoModificar($id_lugar){
            $sql="SELECT * FROM tb_nidos_lugar_pedagogico WHERE Pk_Id_lugar_pedagogico = :lugar";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':lugar',$id_lugar);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function modificarObjetoLugarPedagogico($objeto) {
            $sql="UPDATE tb_nidos_lugar_pedagogico SET Fk_Id_Localidad = :localidad, Fk_Id_Upz = :upz, VC_Barrio = :barrio,  VC_Nombre_Lugar = :nomlugar WHERE Pk_Id_lugar_pedagogico = :idLugar";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':idLugar',$objeto->getPkJardin());
            @$sentencia->bindParam(':localidad',$objeto->getFkLocalidad());
            @$sentencia->bindParam(':upz',$objeto->getFkUpz());
            @$sentencia->bindParam(':barrio',$objeto->getVcBarrio());
            @$sentencia->bindParam(':nomlugar',$objeto->getVcNombreLugar());
            $sentencia->execute();
            return $sentencia->rowCount();
        }
}
