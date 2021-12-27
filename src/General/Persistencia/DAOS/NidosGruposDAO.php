<?php  
namespace General\Persistencia\DAOS;

class NidosGruposDAO extends GestionDAO {

    private $db;

    function __construct(){
  		$this->db=$this->obtenerBD();
  		$this->dbPDO=$this->obtenerPDOBD();
  	}

    public function crearObjeto($objeto) {
        $sql="INSERT INTO tb_nidos_grupos (FK_Id_Estrategia_Atencion,Fk_Id_Lugar_Atencion,VC_Nombre_Grupo,FK_Id_Dupla,Fk_Id_Nivel_Escolaridad,VC_Profesional_Responsable,IN_Estado,Dt_Fecha_Creacion,Fk_Id_Usuario_Creacion,Fk_Id_Tipo_Grupo,Fk_Id_Lugar_Grupo_Laboratorio)
            VALUES (:estatencion, :lugatencion, :nomgrupo, :dupla, :nivelescolaridad, :profesional, :estado, :fechacreacion, :usuariocreacion, :tipogrupo, :lugargrupo)";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':estatencion',$objeto->getFkEstrategiaAtencion());
        @$sentencia->bindParam(':lugatencion',$objeto->getFkLugarAtencion());
        @$sentencia->bindParam(':nomgrupo',$objeto->getVcNombreGrupo());
        @$sentencia->bindParam(':dupla',$objeto->getFkIdDupla());
        @$sentencia->bindParam(':nivelescolaridad',$objeto->getFkIdNivelEscolaridad());
        @$sentencia->bindParam(':profesional',$objeto->getVcProfesional());
        @$sentencia->bindParam(':estado',$objeto->getInEstado());
        @$sentencia->bindParam(':fechacreacion',$objeto->getDtFechaCreacion());
        @$sentencia->bindParam(':tipogrupo',$objeto->getFkIdTipoGrupo());
        @$sentencia->bindParam(':usuariocreacion',$objeto->getFkIdUsuarioCreacion());
        @$sentencia->bindParam(':lugargrupo',$objeto->getFkIdLugarGrupoLaboratorio());
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function modificarObjeto($objeto) {
      $sql="UPDATE tb_nidos_grupos SET FK_Id_Estrategia_Atencion=:estatencion, Fk_Id_Lugar_Atencion=:lugatencion, VC_Nombre_Grupo=:nomgrupo, VC_Profesional_Responsable=:profesional,
      Fk_Id_Tipo_Grupo=:tipogrupo, Fk_Id_Nivel_Escolaridad=:nivelescolaridad, Fk_Id_Lugar_Grupo_Laboratorio=:lugargrupo WHERE Pk_Id_Grupo=:id";
      @$sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':id',$objeto->getIdGrupo());
      @$sentencia->bindParam(':estatencion',$objeto->getFkEstrategiaAtencion());
      @$sentencia->bindParam(':lugatencion',$objeto->getFkLugarAtencion());
      @$sentencia->bindParam(':nomgrupo',$objeto->getVcNombreGrupo());
      @$sentencia->bindParam(':tipogrupo',$objeto->getFkIdTipoGrupo());
      @$sentencia->bindParam(':nivelescolaridad',$objeto->getFkIdNivelEscolaridad());
      @$sentencia->bindParam(':profesional',$objeto->getVcProfesional());
      @$sentencia->bindParam(':lugargrupo',$objeto->getFkIdLugarGrupoLaboratorio());
      $sentencia->execute();
      return$sentencia->rowCount();
    }

    public function eliminarObjeto($objeto) {
            return;
    }

    public function consultarObjeto($objeto) {
          return;
    }

    public function consultarEstrategiasGuardadas() {
      $sql="SELECT * FROM tb_nidos_estrategia";
      $sentencia=$this->dbPDO->prepare($sql);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarLugaresUsuario($id_usuario){
      $sql="SELECT LA.Pk_Id_lugar_atencion,  LO.VC_Nom_Localidad, LA.VC_Nombre_Lugar
      FROM tb_nidos_lugar_atencion AS LA
      JOIN tb_nidos_terri_locali AS L ON L.Fk_Id_Localidad=LA.Fk_Id_Localidad
      JOIN tb_nidos_persona_territorio AS PT ON PT.Fk_Id_Territorio=L.Fk_Id_Territorio
      JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
      WHERE LA.IN_Estado = 1 AND PT.Fk_Id_Persona =:id_usuario";
      $sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':id_usuario',$id_usuario);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarIdCodigoDupla($id_usuario){
      $sql="SELECT DA.Fk_Id_Dupla, D.VC_Codigo_Dupla
      FROM tb_nidos_dupla_artista AS DA
      JOIN tb_nidos_dupla AS D ON D.Pk_Id_Dupla=DA.Fk_Id_Dupla
      WHERE D.IN_Estado = 1 AND Fk_Id_Persona=:id_usuario";
      $sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':id_usuario',$id_usuario);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarGruposGuardados($id_usuario){
      $sql="SELECT G.Pk_Id_Grupo, 
      G.FK_Id_Estrategia_Atencion AS 'IDESTRATEGIA',
      E.Vc_Estrategia, 
      G.Fk_Id_Lugar_Atencion AS 'IDLUGAR', 
      LA.VC_Nombre_Lugar, 
      G.VC_Nombre_Grupo, 
      G.VC_Profesional_Responsable,
      G.Fk_Id_Tipo_Grupo AS 'IDTIPOGRUPO',
     (SELECT PD.VC_Descripcion FROM tb_parametro_detalle AS PD WHERE G.Fk_Id_Tipo_Grupo = PD.FK_Value AND FK_Id_Parametro = 45) AS 'TipoGrupo',
       G.IN_Estado,
       (SELECT GROUP_CONCAT(CONCAT(' ',PD.Fk_Value,' ') SEPARATOR ','  )
       FROM tb_parametro_detalle PD
       WHERE Fk_Id_Parametro = 58 AND FIND_IN_SET(PD.Fk_Value, G.Fk_Id_Nivel_Escolaridad) > 0)  AS 'IDNIVEL', 
       (SELECT GROUP_CONCAT(CONCAT(' ',PD.VC_Descripcion,' ') SEPARATOR ','  )
       FROM tb_parametro_detalle PD
       WHERE Fk_Id_Parametro = 58 AND FIND_IN_SET(PD.Fk_Value, G.Fk_Id_Nivel_Escolaridad) > 0)  AS 'NIVEL',      
       G.Fk_Id_Lugar_Grupo_Laboratorio AS 'IDLUGARLABORATORIO',
		(SELECT COUNT(DISTINCT(BE.Fk_Id_Beneficiario))
		FROM tb_nidos_beneficiario_grupo AS BE
		WHERE BE.Fk_Id_Grupo = G.Pk_Id_Grupo AND BE.IN_Estado = 1)  AS 'INSCRITOS'  
       FROM tb_nidos_grupos AS G
       JOIN tb_nidos_estrategia AS E ON E.Pk_Id_Estrategia=G.FK_Id_Estrategia_Atencion
       JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=G.Fk_Id_Lugar_Atencion
       JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=G.Fk_Id_Dupla
       LEFT JOIN tb_nidos_entidades AS EN ON G.Fk_Id_Entidad_Grupo = EN.Pk_Id_Entidad
       WHERE DA.Fk_Id_Persona = :id_usuario AND DA.IN_Estado = '1' AND G.DT_Fecha_Creacion > '2021-01-01 00:00:00'";
      $sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':id_usuario',$id_usuario);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarDupla($id_dupla){
      $sql="SELECT CONCAT(P.VC_Primer_Nombre, ' ' ,P.VC_Primer_Apellido) AS 'Nombre'
      FROM tb_nidos_dupla_artista AS DA
      JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=DA.Fk_Id_Persona
      WHERE DA.Fk_Id_Dupla=:id_dupla AND DA.IN_Estado = 1 ORDER BY 'Nombre' ASC";
      $sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':id_dupla',$id_dupla);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function obtenerGruposGuardados($id_usuario, $id_lugar){
      $sql="SELECT G.Pk_Id_Grupo, G.VC_Nombre_Grupo
      FROM tb_nidos_grupos AS G
      JOIN tb_nidos_estrategia AS E ON E.Pk_Id_Estrategia=G.FK_Id_Estrategia_Atencion
      JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=G.Fk_Id_Lugar_Atencion
      JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=G.Fk_Id_Dupla
      WHERE DA.Fk_Id_Persona=:id_usuario  AND G.IN_Estado='1' AND Fk_Id_Lugar_Atencion=:id_lugar";
      $sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':id_usuario',$id_usuario);
      @$sentencia->bindParam(':id_lugar',$id_lugar);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarGrupoModificar($id_grupo){
      $sql="SELECT * FROM tb_nidos_grupos WHERE Pk_Id_Grupo = :id_grupo";
      @$sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':id_grupo',$id_grupo);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function inactivarGrupo($id_grupo){
      $sql="UPDATE tb_nidos_grupos SET IN_Estado = '0' WHERE Pk_Id_Grupo=:id_grupo";
      @$sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':id_grupo',$id_grupo);
      $sentencia->execute();
      return$sentencia->rowCount();
    }

    public function activarGrupo($id_grupo){
      $sql="UPDATE tb_nidos_grupos SET IN_Estado = '1' WHERE Pk_Id_Grupo=:id_grupo";
      @$sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':id_grupo',$id_grupo);
      $sentencia->execute();
      return$sentencia->rowCount();
    }
    public function consultarTerritorio($id_usuario) {
      $sql="SELECT
      NT.Vc_Nom_Territorio
      FROM tb_nidos_persona_territorio AS PT, tb_nidos_territorios AS NT
      WHERE PT.IN_Estado = 1 AND NT.Pk_Id_Territorio=Fk_Id_Territorio AND Fk_Id_Persona=:id_usuario";
      @$sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':id_usuario',$id_usuario);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function ConsultarTotalesGruposDupla($id_usuario) {
      $sql="SELECT  COUNT(G.Pk_Id_Grupo) AS 'TOTAL',
(SELECT COUNT(G.Pk_Id_Grupo)
FROM tb_nidos_grupos AS G     
JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=G.Fk_Id_Dupla
WHERE DA.Fk_Id_Persona = :usuario AND DA.IN_Estado = '1' AND G.IN_Estado = 1 AND G.FK_Id_Estrategia_Atencion = 1
AND G.DT_Fecha_Creacion > '2021-01-01 00:00:00' ) AS 'GRUPALES',
(SELECT COUNT(DISTINCT(BE.Fk_Id_Beneficiario))
FROM tb_nidos_beneficiario_grupo AS BE
JOIN tb_nidos_grupos AS G ON BE.Fk_Id_Grupo = G.Pk_Id_Grupo    
JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=G.Fk_Id_Dupla
WHERE DA.Fk_Id_Persona = :usuario AND DA.IN_Estado = '1' AND G.IN_Estado = 1 AND G.FK_Id_Estrategia_Atencion = 1
AND G.DT_Fecha_Creacion > '2021-01-01 00:00:00') AS 'BENEFICIARIOSGRUPALES',
(SELECT COUNT(G.Pk_Id_Grupo)
FROM tb_nidos_grupos AS G     
JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=G.Fk_Id_Dupla
WHERE DA.Fk_Id_Persona = :usuario AND DA.IN_Estado = '1' AND G.IN_Estado = 1 AND G.FK_Id_Estrategia_Atencion = 2
AND G.DT_Fecha_Creacion > '2021-01-01 00:00:00' ) AS 'LABORATORIOS',
(SELECT COUNT(DISTINCT(BE.Fk_Id_Beneficiario))
FROM tb_nidos_beneficiario_grupo AS BE
JOIN tb_nidos_grupos AS G ON BE.Fk_Id_Grupo = G.Pk_Id_Grupo    
JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=G.Fk_Id_Dupla
WHERE DA.Fk_Id_Persona = :usuario AND DA.IN_Estado = '1' AND G.IN_Estado = 1 AND G.FK_Id_Estrategia_Atencion = 2
AND G.DT_Fecha_Creacion > '2021-01-01 00:00:00') AS 'BENEFICIARIOSLABORATORIOS'
FROM tb_nidos_grupos AS G     
JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=G.Fk_Id_Dupla
WHERE DA.Fk_Id_Persona = :usuario AND DA.IN_Estado = '1' AND G.IN_Estado = 1 
AND G.DT_Fecha_Creacion > '2021-01-01 00:00:00'";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':usuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }



   public function consolidadoAtencionesDupla($id_usuario){
    $sql="SELECT DISTINCT(LA.Pk_Id_lugar_atencion) AS 'IDLUGAR', 
   LA.VC_Nombre_Lugar AS 'LUGAR',
   (SELECT COUNT(GR.Pk_Id_Grupo)
   FROM tb_nidos_grupos AS GR
   JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=GR.Fk_Id_Dupla
   WHERE DA.Fk_Id_Persona = :usuario AND DA.IN_Estado = '1' AND GR.DT_Fecha_Creacion > '2021-01-01 00:00:00'
   AND GR.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion) AS 'GRUPOS',
   (SELECT COUNT(EX.Pk_Id_Experiencia)
   FROM tb_nidos_grupos AS GR
   JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=GR.Fk_Id_Dupla
   JOIN tb_nidos_experiencia AS EX ON GR.Pk_Id_Grupo = EX.Fk_Id_Grupo
   WHERE DA.Fk_Id_Persona = :usuario AND DA.IN_Estado = '1' AND GR.DT_Fecha_Creacion > '2021-01-01 00:00:00'
   AND GR.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion) AS 'EXPERIENCAS',
   (SELECT COUNT(DISTINCT NA.Fk_Id_Beneficiario) 
   FROM tb_nidos_asistencia AS NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
   JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=GR.Fk_Id_Dupla
   WHERE DA.Fk_Id_Persona = :usuario AND DA.IN_Estado = '1' AND GR.DT_Fecha_Creacion > '2021-01-01 00:00:00'
   AND NA.Vc_Asistencia = 1 AND GR.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion) AS 'BENEFICIARIOS'
   FROM tb_nidos_grupos AS G     
   JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=G.Fk_Id_Dupla
   JOIN tb_nidos_lugar_atencion AS LA ON G.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
   WHERE DA.Fk_Id_Persona = :usuario AND DA.IN_Estado = '1' 
   AND G.DT_Fecha_Creacion > '2021-01-01 00:00:00'";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':usuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }


}
