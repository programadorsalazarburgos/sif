<?php 

namespace General\Persistencia\DAOS;
class NidosAsistenciaDAO extends GestionDAO {

  private $db;

  function __construct()
  {
    $this->db=$this->obtenerBD();
    $this->dbPDO=$this->obtenerPDOBD();
  }

  public function crearExperiencia($objeto, $objeto2) {
    $sql="INSERT INTO tb_nidos_experiencia(Fk_Id_Lugar_Atencion,Fk_Id_Dupla,Fk_Id_Grupo,VC_Nombre_Experiencia,DT_Fecha_Encuentro,HR_Hora_Inicio,HR_Hora_Finalizacion,IN_Cuidadores, DT_Fecha_Registro,IN_Id_Persona, IN_Tipo_Suplencia, IN_Modalidad) VALUES (:lugar, :dupla, :grupo, :experiencia, :fecha, :horainicio, :horafin, :cuidadores, :fecharegistro, :idusuario, :tiposuplencia, :modalidad)";
    @$sentencia=$this->dbPDO->prepare($sql);

    @$sentencia->bindParam(':lugar',$objeto->getFkIdLugarAtencion());
    @$sentencia->bindParam(':dupla',$objeto->getFkIdDupla());
    @$sentencia->bindParam(':grupo',$objeto->getFkIdGrupo());
    @$sentencia->bindParam(':experiencia',$objeto->getVcNombreExperiencia());
    @$sentencia->bindParam(':fecha',$objeto->getDtFechaEncuentro());
    @$sentencia->bindParam(':horainicio',$objeto->getHrHoraInicio());
    @$sentencia->bindParam(':horafin',$objeto->getHrHoraFinalizacion());
    @$sentencia->bindParam(':cuidadores',$objeto->getInCuidadores());
    @$sentencia->bindParam(':modalidad',$objeto->getInModalidad());
    @$sentencia->bindParam(':fecharegistro',$objeto->getDtFechaRegistro());
    @$sentencia->bindParam(':idusuario',$objeto->getInIdPersona());
    @$sentencia->bindParam(':tiposuplencia',$objeto->getIntTipoSuplencia());

    try {
      $this->dbPDO->beginTransaction();
      $sentencia->execute();
      $id_insertado = $this->dbPDO->lastInsertId();
      $sql1="INSERT INTO tb_nidos_asistencia (Fk_Id_Experiencia,Fk_Id_Beneficiario,Vc_Asistencia) VALUES(:Id_Experiencia, :Beneficiario, :In_Asistencia)";

      @$sentencia_artista=$this->dbPDO->prepare($sql1);
      $sentencia_artista->bindParam(':Id_Experiencia', $id_experiencia);
      $sentencia_artista->bindParam(':Beneficiario', $id_beneficiario);
      $sentencia_artista->bindParam(':In_Asistencia', $asistencia);
      foreach ($objeto->getBeneficiarioArray() as $beneficiario) {
        $id_experiencia=$id_insertado;
        $id_beneficiario=$beneficiario[0];
        $asistencia=$beneficiario[1];
        $sentencia_artista->execute();
      }

      $sql2="INSERT INTO tb_nidos_experiencia_artista (Fk_Id_Experiencia, Fk_Id_Artista) VALUES(:Id_Experiencia, :Fk_Id_Artista)";
      @$suplencia=$this->dbPDO->prepare($sql2);
      $suplencia->bindParam(':Id_Experiencia', $id_experiencia);
      $suplencia->bindParam(':Fk_Id_Artista', $id_artista);
            //@$suplencia->bindParam(':tipo_suplencia', $objeto2->getFkIdTipoSuplencia());
      foreach ($objeto2->getFkIdArtistas() as $artista) {
        $id_experiencia=$id_insertado;
        $id_artista=$artista;
        $suplencia->execute();
      }

      $this->dbPDO->commit();
      return true;
    }
    catch(PDOExecption $e) {
      $this->dbPDO->rollback();
      return "Error!: " . $e->getMessage() . "</br>";
    }
  }

  public function crearObjeto($objeto) {
    return;
  }

  public function modificarObjeto($objeto) {
    return;
  }

  public function eliminarObjeto($objeto) {

    $sql="UPDATE tb_nidos_lugar_atencion SET IN_Estado = :estado WHERE Pk_Id_lugar_atencion = :idLugar";
    return;
  }


  public function consultarObjeto($objeto) {
    return;
  }

  public function consultarLugaresUsuario($id_usuario){
    $sql="SELECT
    LA.Pk_Id_lugar_atencion,
    LA.VC_Nombre_Lugar
    FROM tb_nidos_lugar_atencion AS LA
    JOIN tb_nidos_terri_locali AS L ON L.Fk_Id_Localidad=LA.Fk_Id_Localidad
    JOIN tb_nidos_persona_territorio AS PT ON PT.Fk_Id_Territorio=L.Fk_Id_Territorio
    WHERE PT.Fk_Id_Persona=:id_usuario";
    $sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':id_usuario',$id_usuario);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function obtenerGruposGuardados($id_usuario, $id_lugar){
    $sql="SELECT
    G.Pk_Id_Grupo,
    G.VC_Nombre_Grupo
    FROM tb_nidos_grupos AS G
    JOIN tb_nidos_estrategia AS E ON E.Pk_Id_Estrategia=G.FK_Id_Estrategia_Atencion
    JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=G.Fk_Id_Lugar_Atencion
    JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=G.Fk_Id_Dupla
    WHERE DA.Fk_Id_Persona=:id_usuario AND Fk_Id_Lugar_Atencion=:id_lugar AND G.IN_Estado = '1' ORDER BY G.VC_Nombre_Grupo";
    $sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':id_usuario',$id_usuario);
    @$sentencia->bindParam(':id_lugar',$id_lugar);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }


  public function consultarEncabezado($idGrupo){
    $sql="SELECT
    LO.VC_Nom_Localidad,
    UP.VC_Nombre_Upz,
    LA.VC_Barrio, LA.VC_Direccion,
    TL.Vc_Descripcion,
    ND.Pk_Id_Grupo,
    ND.VC_Nombre_Grupo,
    ND.VC_Profesional_Responsable,
    DU.Pk_Id_Dupla,
    DU.VC_Codigo_Dupla,
    ES.Vc_Estrategia,
    LA.Pk_Id_Lugar_atencion,
    LA.VC_Nombre_Lugar,
    CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'GESTOR',
    (SELECT GROUP_CONCAT(PER.PK_Id_Persona)
    FROM tb_nidos_dupla_artista DA, tb_persona_2017 PER
    WHERE DA.Fk_Id_Dupla = DU.Pk_Id_Dupla AND DA.Fk_Id_Persona = PER.PK_Id_Persona AND DA.IN_Estado='1')  AS 'IdsArtistas',
    (SELECT GROUP_CONCAT(CONCAT(PER.VC_Primer_Nombre,' ',PER.VC_Primer_Apellido) SEPARATOR ' Y ' )
    FROM tb_nidos_dupla_artista DA, tb_persona_2017 PER
    WHERE DA.Fk_Id_Dupla = DU.Pk_Id_Dupla AND DA.Fk_Id_Persona = PER.PK_Id_Persona AND IN_Estado = '1')  AS 'ARTISTAS',
    (SELECT GROUP_CONCAT(CONCAT(PER.VC_Primer_Nombre,' ',PER.VC_Segundo_Nombre,' ',PER.VC_Primer_Apellido,' ',PER.VC_Segundo_Apellido) SEPARATOR ' Y ' )
    FROM tb_persona_2017 AS PER JOIN tb_nidos_persona_territorio AS PT ON PER.PK_Id_Persona = PT.Fk_Id_Persona
    where PER.FK_Tipo_Persona = 22 AND PT.Fk_Id_Territorio = DU.Fk_Id_Territorio  ) AS 'EAAT',
    PDT.VC_Descripcion AS 'TIPO_GRUPO',
    PDN.VC_Descripcion AS 'GRADO'
    FROM tb_nidos_grupos AS ND
    JOIN tb_nidos_lugar_atencion AS LA ON ND.FK_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
    JOIN tb_nidos_estrategia AS ES ON  ND.FK_Id_Estrategia_Atencion = ES.Pk_Id_Estrategia
    JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
    JOIN tb_upz AS UP ON LA.FK_Id_Upz = UP.Pk_Id_Upz
    JOIN tb_nidos_tipo_lugar AS TL ON LA.VC_Tipo_Lugar = TL.PK_Id_Lugar
    JOIN tb_nidos_dupla  AS DU ON ND.Fk_Id_Dupla = DU.Pk_Id_Dupla
    JOIN tb_persona_2017 AS P ON DU.Fk_Id_Gestor = P.PK_Id_Persona    
    LEFT JOIN tb_parametro_detalle AS PDT ON ND.Fk_Id_Tipo_Grupo = PDT.FK_Value AND PDT.FK_Id_Parametro = 45
    LEFT JOIN tb_parametro_detalle AS PDN ON ND.Fk_Id_Nivel_Escolaridad = PDN.FK_Value AND PDN.FK_Id_Parametro = 58
    WHERE Pk_Id_Grupo = :IdGrupo";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':IdGrupo',$idGrupo);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }


  public function consultarBeneficiario($Usuario){
    $sql="SELECT
    FK_Tipo_Identificacion,
    VC_Primer_Nombre,
    VC_Segundo_Nombre,
    VC_Primer_Apellido,
    VC_Segundo_Apellido,
    DD_F_Nacimiento,
    FK_Id_Genero,
    IN_Grupo_Poblacional,
    IN_Identificacion_Poblacional
    FROM tb_nidos_beneficiarios WHERE VC_Identificacion = :Identificacion";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':Identificacion',$Usuario);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarBeneficiarioGrupo($idGrupo){
    $sql="SELECT
    B.Pk_Id_Beneficiario AS 'IDBENEFICIARIO',
    B.VC_Identificacion AS 'IDENTIFICACION',
    CONCAT(B.VC_Primer_Apellido,' ',B.VC_Segundo_Apellido,' ',B.VC_Primer_Nombre,' ',B.VC_Segundo_Nombre) AS 'BENEFICIARIO',
    PG.VC_Descripcion AS GENERO,
    B.DD_F_Nacimiento AS 'Fecha de nacimiento',
    (SELECT EX.DT_Fecha_Encuentro
    FROM tb_nidos_asistencia AS NA 
    JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
    WHERE NA.Fk_Id_Beneficiario = B.Pk_Id_Beneficiario AND YEAR(EX.DT_Fecha_Encuentro) = 2021
	 ORDER BY EX.DT_Fecha_Encuentro ASC LIMIT 1) AS 'PRIMERA',
    PE.VC_Descripcion AS 'Enfoque',
    B.VC_Uso_Imagen AS 'Imagen'
    FROM tb_nidos_beneficiario_grupo BG
    JOIN tb_nidos_beneficiarios AS B ON BG.Fk_Id_Beneficiario = B.Pk_Id_Beneficiario
    JOIN tb_parametro_detalle AS PG ON B.FK_Id_Genero = PG.FK_Value AND PG.FK_Id_Parametro = 17
    JOIN tb_parametro_detalle AS PE ON B.IN_Grupo_Poblacional = PE.FK_Value AND PE.FK_Id_Parametro = 14 AND PE.IN_Estado_Nidos=1
    WHERE BG.IN_Estado='1' AND BG.Fk_Id_Grupo = :IdGrupo";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':IdGrupo',$idGrupo);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getExperienciaGrupo($parametro)
  {
   $sql="SELECT Pk_Id_Experiencia, VC_Nombre_Experiencia, DT_Fecha_Encuentro FROM .tb_nidos_experiencia where Fk_ID_grupo = :parametro";
   @$sentencia=$this->dbPDO->prepare($sql);
   @$sentencia->bindParam(':parametro',$parametro);
   $sentencia->execute();
   return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }

 public function consultarArtistas($id_dupla, $tipo_persona){
  if($tipo_persona == 20){
   $sql="SELECT
   P.PK_Id_Persona,
   P.VC_Primer_Nombre,
   P.VC_Segundo_Nombre,
   P.VC_Primer_Apellido,
   P.VC_Segundo_Apellido
   FROM tb_persona_2017 P
   WHERE P.FK_Tipo_Persona IN ('16','22')";
 }else{
   $sql="SELECT
   P.PK_Id_Persona,
   P.VC_Primer_Nombre,
   P.VC_Segundo_Nombre,
   P.VC_Primer_Apellido,
   P.VC_Segundo_Apellido
   FROM tb_persona_2017 P
   WHERE P.PK_Id_Persona NOT IN (SELECT NDA.Fk_Id_Persona FROM tb_nidos_dupla_artista AS NDA WHERE NDA.Fk_Id_Dupla=:id_dupla AND NDA.IN_Estado='1') AND P.FK_Tipo_Persona IN ('16','22')";
 }
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':id_dupla',$id_dupla);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultarArtistaRemover($id_usuario){
 $sql="SELECT
 DA.Fk_Id_Persona,
 CONCAT(P.VC_Primer_Nombre,' ',P.VC_Primer_Apellido) AS 'Artista'
 FROM tb_nidos_dupla_artista AS DA
 JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=DA.Fk_Id_Persona
 WHERE DA.Fk_Id_Dupla=(SELECT DA.Fk_Id_Dupla
 FROM tb_nidos_dupla_artista AS DA
 WHERE DA.Fk_Id_Persona=:id_usuario AND DA.IN_Estado='1') AND DA.IN_Estado='1' AND DA.Fk_Id_Persona<>:id_usuario";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':id_usuario',$id_usuario);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}
   //++++++++++++++ CONSULTAS PESTAÑA DE CONSULTAR EXPERIENCIAS GUARDADAS

public function consultarLugaryGrupoArtista($id_usuario){
 $sql="SELECT
 G.Pk_Id_Grupo,
 LA.VC_Nombre_Lugar,
 G.VC_Nombre_Grupo,
 LA.Fk_Id_Entidad
 FROM tb_nidos_grupos AS G
 JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion = G.Fk_Id_Lugar_Atencion
 JOIN tb_nidos_dupla_artista DA ON G.Fk_Id_Dupla=DA.Fk_Id_Dupla
 WHERE DA.Fk_Id_Persona =:id_usuario AND G.IN_Estado='1' AND DA.IN_Estado = '1'";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':id_usuario',$id_usuario);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

}

public function ConsultaAsistenciaExperienciaEncabezado($idExperiencia){
 $sql="SELECT
 EX.Pk_Id_Experiencia AS 'ID',
 EX.VC_Nombre_Experiencia  AS 'EXPERIENCIA',
 EX.DT_Fecha_Encuentro AS 'FECHA',
 EX.IN_Cuidadores AS 'CUIDADORES',
 CONCAT('DE ',EX.HR_Hora_Inicio,' A ',EX.HR_Hora_Finalizacion) AS 'HORA',
 LO.VC_Nom_Localidad AS 'LOCALIDAD',
 UP.VC_Nombre_Upz AS 'UPZ',
 LA.VC_Barrio AS 'BARRIO',
 LA.VC_Nombre_Lugar AS 'LUGAR',
 TL.Vc_Descripcion AS 'TIPO_LUGAR',
 DU.VC_Codigo_Dupla AS 'CODIGO_DUPLA',
 CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'GESTOR',
 ES.Vc_Estrategia AS 'ESTRATEGIA',
 G.VC_Nombre_Grupo AS 'GRUPO',
 G.VC_Profesional_Responsable AS 'RESPONSABLE',
 (SELECT GROUP_CONCAT(CONCAT(' ',PER.VC_Primer_Nombre,' ',PER.VC_Primer_Apellido,' ') )
 FROM tb_nidos_experiencia_artista DA, tb_persona_2017 PER
 WHERE DA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia AND DA.Fk_Id_Artista = PER.PK_Id_Persona)  AS 'ARTISTAS',
 (SELECT GROUP_CONCAT(CONCAT(PER.VC_Primer_Nombre,' ',PER.VC_Segundo_Nombre,' ',PER.VC_Primer_Apellido,' ',PER.VC_Segundo_Apellido) SEPARATOR ' Y ' )
 FROM tb_persona_2017 AS PER JOIN tb_nidos_persona_territorio AS PT ON PER.PK_Id_Persona = PT.Fk_Id_Persona
 where PER.FK_Tipo_Persona = 22 AND PT.Fk_Id_Territorio = DU.Fk_Id_Territorio  ) AS 'EAAT'
 FROM tb_nidos_experiencia EX
 JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
 JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
 JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
 JOIN tb_nidos_tipo_lugar AS TL ON LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
 JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
 JOIN tb_persona_2017 AS P ON DU.Fk_Id_Gestor = P.PK_Id_Persona
 JOIN tb_nidos_grupos AS G ON EX.Fk_Id_Grupo = G.Pk_Id_Grupo
 JOIN tb_nidos_estrategia AS ES ON G.Fk_Id_Estrategia_Atencion = ES.Pk_Id_Estrategia
 WHERE EX.Pk_Id_Experiencia = :idExperiencia";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':idExperiencia',$idExperiencia);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function ConsultaAsistenciaBeneficiariosExperiencia($idExperiencia){
 $sql="SELECT
 B.Pk_Id_Beneficiario,
 B.VC_Identificacion AS 'IDENTIFICACION',
 CONCAT(B.VC_Primer_Apellido,' ',B.VC_Segundo_Apellido,' ',B.VC_Primer_Nombre,' ',B.VC_Segundo_Nombre) AS 'BENEFICIARIO',
 B.DD_F_Nacimiento AS 'FECHANACIMIENTO',
 PG.VC_Descripcion AS 'GENERO',
 PE.VC_Descripcion AS 'ENFOQUE',
 EX.DT_Fecha_Encuentro AS 'FECHAENCUENTRO',
 (CASE WHEN NA.Vc_Asistencia = '0' THEN 'No Asistió' WHEN NA.Vc_Asistencia = '1' THEN 'Asistió' END) AS 'ASISTENCIA'
 FROM tb_nidos_asistencia AS NA
 JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
 JOIN tb_nidos_beneficiarios  AS B ON NA.Fk_Id_Beneficiario = B.Pk_Id_Beneficiario
 JOIN tb_parametro_detalle AS PT ON B.Fk_Tipo_Identificacion = PT.FK_Value AND PT.FK_Id_Parametro = 5
 JOIN tb_parametro_detalle AS PG ON B.FK_Id_Genero = PG.FK_Value AND PG.FK_Id_Parametro = 17
 JOIN tb_parametro_detalle AS PE ON B.IN_Grupo_Poblacional = PE.FK_Value AND PE.FK_Id_Parametro = 14
 WHERE Fk_Id_Experiencia = :idExperiencia";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':idExperiencia',$idExperiencia);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function ConsultaTipoPersona($id_usuario){
 $sql="SELECT
 FK_Tipo_Persona
 FROM tb_persona_2017
 WHERE PK_Id_Persona = :id_usuario";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':id_usuario',$id_usuario);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function ConsultarAtencionesGrupo($id_grupo, $tipo_persona){
 $am = date('Y-m');
 $ant = date("Y-m", strtotime("-1 months"));
 $a_date = date("Y-m-d");
 $ultimo= date("t", strtotime($a_date));
 $p=$am."-01";
 $u=$am."-".$ultimo;
 $dia_actual = date('d');
 /*if($tipo_persona != 16 && $dia_actual <= 15){
   $p=$ant."-01";
 }*/
 $sql="SELECT
 Pk_Id_Experiencia,
 VC_Nombre_Experiencia,
 DT_Fecha_Encuentro,
 HR_Hora_Inicio,
 HR_Hora_Finalizacion
 FROM tb_nidos_experiencia WHERE Fk_Id_Grupo = :id_grupo AND IN_Aprobacion = 0 /* AND DT_Fecha_Encuentro BETWEEN :primer AND :ultimo */ ORDER BY DT_Fecha_Encuentro ASC";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':id_grupo',$id_grupo);
 //@$sentencia->bindParam(':primer',$p);
 //@$sentencia->bindParam(':ultimo',$u);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function ConsultarGruposDupla($id_dupla){
 $sql="SELECT
 G.Pk_Id_Grupo,
 L.VC_Nombre_Lugar,
 G.VC_Nombre_Grupo
 FROM tb_nidos_grupos AS G
 JOIN tb_nidos_lugar_atencion AS L ON G.Fk_Id_Lugar_Atencion = L.Pk_Id_lugar_atencion
 WHERE G.IN_Estado = '1' and G.Fk_Id_Dupla = :id_dupla";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':id_dupla',$id_dupla);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultarExperienciaEncabezado($experiencia){
 $sql="SELECT
 EX.Pk_Id_Experiencia AS IdExperiencia,
 EX.Fk_Id_Dupla AS 'IdDupla',
 (SELECT GROUP_CONCAT(CONCAT(PER.VC_Primer_Nombre,' ',PER.VC_Primer_Apellido) SEPARATOR ' Y ')
 FROM tb_nidos_experiencia_artista EA, tb_persona_2017 PER
 WHERE EA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia AND EA.Fk_Id_Artista = PER.PK_Id_Persona)  AS 'NomArtExp',
 (SELECT GROUP_CONCAT(CONCAT(PER.PK_Id_Persona))
 FROM tb_nidos_experiencia_artista EA, tb_persona_2017 PER
 WHERE EA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia AND EA.Fk_Id_Artista = PER.PK_Id_Persona)  AS 'IdsArtistasExp',
 (SELECT GROUP_CONCAT(CONCAT(DA.Fk_Id_Persona))
 FROM tb_nidos_dupla_artista AS DA
 WHERE DA.Fk_Id_Dupla = EX.Fk_Id_Dupla AND DA.IN_Estado='1')  AS 'IdsArtistasOri',
 (SELECT GROUP_CONCAT(CONCAT(PER.VC_Primer_Nombre,' ',PER.VC_Primer_Apellido) SEPARATOR ' Y ')
 FROM tb_nidos_dupla_artista AS DA, tb_persona_2017 PER
 WHERE DA.Fk_Id_Dupla = EX.Fk_Id_Dupla AND DA.IN_Estado='1' AND DA.Fk_Id_Persona = PER.PK_Id_Persona)  AS 'NomArtOri',
 EX.IN_Tipo_Suplencia AS TipoSuplencia,
 EX.DT_Fecha_Encuentro AS 'Fecha',
 DU.VC_Codigo_Dupla AS 'Dupla',
 TL.Vc_Descripcion AS 'Tipo_Grupo',
 ES.Vc_Estrategia AS 'Estrategia',
 EX.HR_Hora_Inicio AS 'HoraInicio',
 EX.HR_Hora_Finalizacion AS 'HoraFin',
 EX.VC_Nombre_Experiencia AS 'Experiencia',
 CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'GESTOR',
 (SELECT GROUP_CONCAT(CONCAT(PER.VC_Primer_Nombre,' ',PER.VC_Segundo_Nombre,' ',PER.VC_Primer_Apellido,' ',PER.VC_Segundo_Apellido) SEPARATOR ' Y ' )
 FROM tb_persona_2017 AS PER JOIN tb_nidos_persona_territorio AS PT ON PER.PK_Id_Persona = PT.Fk_Id_Persona
 where PER.FK_Tipo_Persona = 22 AND PT.Fk_Id_Territorio = DU.Fk_Id_Territorio  ) AS 'EAAT',
 ND.VC_Profesional_Responsable AS 'Responsable',
 EX.Fk_Id_Grupo AS 'IdGrupo',
 ND.VC_Nombre_Grupo AS 'Grupo',
 LO.VC_Nom_Localidad AS 'Localidad',
 UP.VC_Nombre_Upz AS 'Upz',
 LA.VC_Barrio AS 'Barrio',
 LA.VC_Nombre_Lugar AS 'Lugar',
 EX.IN_Cuidadores AS 'Cuidadores',
 (SELECT COUNT(NA.Fk_Id_Beneficiario)
FROM tb_nidos_asistencia AS NA
WHERE NA.Vc_Asistencia = 1 AND NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia) AS 'BENEFICIARIOS',
 PDT.VC_Descripcion AS 'TIPO_GRUPO',
 PDN.VC_Descripcion AS 'GRADO',
 EX.IN_Modalidad AS 'modalidad'
 FROM tb_nidos_experiencia AS EX
 JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
 JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
 JOIN tb_upz AS UP ON LA.FK_Id_Upz = UP.Pk_Id_Upz
 JOIN tb_nidos_tipo_lugar AS TL ON LA.VC_Tipo_Lugar = TL.PK_Id_Lugar
 JOIN tb_nidos_grupos AS ND ON EX.Fk_Id_Grupo = ND.Pk_Id_Grupo
 JOIN tb_nidos_estrategia AS ES ON  ND.FK_Id_Estrategia_Atencion = ES.Pk_Id_Estrategia
 JOIN tb_nidos_dupla  AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
 JOIN tb_persona_2017 AS P ON DU.Fk_Id_Gestor = P.PK_Id_Persona
 LEFT JOIN tb_parametro_detalle AS PDT ON ND.Fk_Id_Tipo_Grupo = PDT.FK_Value AND PDT.FK_Id_Parametro = 45
 LEFT JOIN tb_parametro_detalle AS PDN ON ND.Fk_Id_Nivel_Escolaridad = PDN.FK_Value AND PDN.FK_Id_Parametro = 58
 WHERE EX.Pk_Id_Experiencia = :experiencia";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':experiencia',$experiencia);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultarBeneficiariosModificarExperiencia($id_atencion){
 $sql="SELECT
 IDEXPERIENCIA,
 IDBENEFICIARIO,
 IDENTIFICACION,
 BENEFICIARIO,
 FECHAATENCION,
 FECHANACIMIENTO,
 GENERO,
 ENFOQUE,
 BENEFICI,
 IDASISTENCIA,
 ASISTENCIA
 FROM
 (SELECT EX.Pk_Id_Experiencia AS 'IDEXPERIENCIA',
 B.Pk_Id_Beneficiario AS 'IDBENEFICIARIO',
 B.VC_Identificacion AS 'IDENTIFICACION',
 CONCAT(B.VC_Primer_Apellido,' ',B.VC_Segundo_Apellido,' ',B.VC_Primer_Nombre,' ',B.VC_Segundo_Nombre) AS 'BENEFICIARIO',
 EX.DT_Fecha_Encuentro AS 'FECHAATENCION',
 B.DD_F_Nacimiento AS 'FECHANACIMIENTO',
 PG.VC_Descripcion AS 'GENERO',
 PE.VC_Descripcion AS 'ENFOQUE'
 FROM tb_nidos_experiencia AS EX
 JOIN tb_nidos_beneficiario_grupo AS BG ON EX.Fk_Id_Grupo = BG.Fk_Id_Grupo
 JOIN tb_nidos_beneficiarios  AS B ON BG.Fk_Id_Beneficiario = B.Pk_Id_Beneficiario
 JOIN tb_parametro_detalle AS PG ON B.FK_Id_Genero = PG.FK_Value AND PG.FK_Id_Parametro = 17
 JOIN tb_parametro_detalle AS PE ON B.IN_Grupo_Poblacional = PE.FK_Value AND PE.FK_Id_Parametro = 14
 WHERE Pk_Id_Experiencia = :id_atencion AND BG.IN_Estado = 1) AS PRIMERA LEFT JOIN
 (SELECT
 Fk_Id_Beneficiario AS 'BENEFICI',
 Pk_Id_Asistencia AS 'IDASISTENCIA',
 Vc_Asistencia AS 'ASISTENCIA'
 FROM tb_nidos_asistencia
 WHERE fk_Id_Experiencia = :id_atencion) AS SEGUNDA ON PRIMERA.IDBENEFICIARIO = SEGUNDA.BENEFICI";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':id_atencion',$id_atencion);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function crearObjetoAsistenciaBeneficiario($objeto) {
 $sql="INSERT INTO tb_nidos_asistencia (Fk_Id_Experiencia, Fk_Id_Beneficiario, Vc_Asistencia) VALUES (:idexperiencia, :beneficiario, :asistencia)";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':idexperiencia',$objeto->getFkIdExperiencia());
 @$sentencia->bindParam(':beneficiario',$objeto->getFkIdBeneficiario());
 @$sentencia->bindParam(':asistencia',$objeto->getVcAsistencia());
 $sentencia->execute();
 return $sentencia->rowCount();
}

public function modificarObjetoAsistencia($objeto) {
 $sql="UPDATE tb_nidos_asistencia SET Vc_Asistencia = :asistencia WHERE  Pk_Id_Asistencia  = :idasistencia";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':idasistencia',$objeto->getPkIdAsistencia());
 @$sentencia->bindParam(':asistencia',$objeto->getVcAsistencia());
 $sentencia->execute();
 return $sentencia->rowCount();
}

public function eliminarArtistasExperiencia($id_experiencia){
  $sql="DELETE FROM tb_nidos_experiencia_artista WHERE Fk_Id_Experiencia=:id_experiencia";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_experiencia',$id_experiencia);
  $sentencia->execute();
  return $sentencia->rowCount();
}

public function crearArtistasExperiencia($objeto){
  $sql="INSERT INTO tb_nidos_experiencia_artista (Fk_Id_Experiencia, Fk_Id_Artista) VALUES(:Id_Experiencia, :Fk_Id_Artista)";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':Id_Experiencia',$objeto->getFkIdExperiencia());
  @$sentencia->bindParam(':Fk_Id_Artista', $id_artista);
  foreach ($objeto->getFkIdArtistas() as $artista) {
    $id_artista=$artista;
    $sentencia->execute();
  }
}
public function modificarInfoBasicaExperiencia($objeto){
  $sql="UPDATE tb_nidos_experiencia SET DT_Fecha_Encuentro=:fecha_encuentro, VC_Nombre_Experiencia=:nombre_experiencia, HR_Hora_Inicio=:hora_inicio, HR_Hora_Finalizacion=:hora_fin, IN_Cuidadores=:cuidadores, IN_Tipo_Suplencia=:tipo_suplencia, IN_Modalidad=:modalidad WHERE Pk_Id_Experiencia=:id_experiencia";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_experiencia',$objeto->getPkIdExperiencia());
  @$sentencia->bindParam(':fecha_encuentro',$objeto->getDtFechaEncuentro());  
  @$sentencia->bindParam(':hora_inicio',$objeto->getVcNombreExperiencia());
  @$sentencia->bindParam(':hora_fin',$objeto->getHrHoraInicio());
  @$sentencia->bindParam(':nombre_experiencia',$objeto->getHrHoraFinalizacion());
  @$sentencia->bindParam(':modalidad',$objeto->getInModalidad());  
  @$sentencia->bindParam(':cuidadores',$objeto->getInCuidadores());
  @$sentencia->bindParam(':tipo_suplencia',$objeto->getIntTipoSuplencia());
  $sentencia->execute();
  return $sentencia->rowCount();
}

public function validarExperienciaDuplicada($id_grupo, $fecha){
  $sql ="SELECT * FROM tb_nidos_experiencia WHERE Fk_Id_Grupo=:id_grupo AND DT_Fecha_Encuentro=:fecha";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_grupo', $id_grupo);
  @$sentencia->bindParam(':fecha', $fecha);
  $sentencia->execute();
  return $sentencia->rowCount();
}

public function getExperienciasEliminar($id_grupo){
  $sql="SELECT
  E.Pk_Id_Experiencia AS 'id_experiencia',
  E.VC_Nombre_Experiencia AS 'Experiencia',
  DATE_FORMAT (E.DT_Fecha_Encuentro, ' %d-%m-%Y') AS 'Fecha',
  CONCAT(E.HR_Hora_Inicio, ' - ', E.HR_Hora_Finalizacion) AS 'Horario',
  CONCAT(CAST(COUNT(A.Vc_Asistencia) AS char(500)), ' de ' ,(SELECT COUNT(Fk_Id_Beneficiario) FROM tb_nidos_asistencia WHERE Fk_Id_Experiencia=E.Pk_Id_Experiencia)) AS 'Asistentes'
  FROM tb_nidos_experiencia AS E
  JOIN tb_nidos_asistencia AS A ON A.Fk_Id_Experiencia=E.Pk_Id_Experiencia
  WHERE E.Fk_Id_Grupo=:id_grupo 
  AND A.Vc_Asistencia='1' AND E.IN_Aprobacion='0'
  AND (
  (now() < DATE_FORMAT (now(), ' %Y-%m-10') AND E.DT_Fecha_Encuentro >= DATE_FORMAT (DATE_SUB(NOW(),INTERVAL 1 MONTH), ' %Y-%m-01')) OR
  (now() > DATE_FORMAT (now(), ' %Y-%m-10') AND E.DT_Fecha_Encuentro >= DATE_FORMAT (now(), ' %Y-%m-01'))
  )
  GROUP BY E.Pk_Id_Experiencia";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_grupo', $id_grupo);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function eliminarExperiencia($id_experiencia){
  $sql1="DELETE
  FROM tb_nidos_asistencia
  WHERE Fk_Id_Experiencia=:id_experiencia;
  DELETE
  FROM tb_nidos_experiencia_artista
  WHERE Fk_Id_Experiencia=:id_experiencia;
  DELETE
  FROM tb_nidos_experiencia
  WHERE Pk_Id_Experiencia=:id_experiencia";
  @$sentencia=$this->dbPDO->prepare($sql1);
  @$sentencia->bindParam(':id_experiencia', $id_experiencia);
  $sentencia->execute();
  return $sentencia->rowCount();
}

public function ConsultaDuplaArtista($id_usuario){
  $sql="SELECT Fk_Id_Dupla AS 'IDDUPLA' 
  FROM tb_nidos_dupla_artista AS DA
  WHERE DA.Fk_Id_Persona = :id_usuario AND IN_Estado = 1 
  ORDER BY DA.Pk_Id_Dupla_Artista DESC LIMIT 1";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_usuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }

 public function ConsultaLugarGrupo($id_grupo){
  $sql="SELECT GR.Fk_Id_Lugar_Atencion AS 'IDLUGAR'
  FROM tb_nidos_grupos AS GR
  WHERE GR.Pk_Id_Grupo = :id_grupo";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_grupo',$id_grupo);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }

  public function crearExperienciaBeneficiariosCifras($objeto, $objeto2) {
    $sql="INSERT INTO tb_nidos_experiencia(Fk_Id_Lugar_Atencion,Fk_Id_Dupla,Fk_Id_Grupo,VC_Nombre_Experiencia,DT_Fecha_Encuentro,HR_Hora_Inicio,HR_Hora_Finalizacion,IN_Cuidadores, DT_Fecha_Registro,IN_Id_Persona, IN_Tipo_Suplencia) VALUES (:lugar, :dupla, :grupo, :experiencia, :fecha, :horainicio, :horafin, :cuidadores, :fecharegistro, :idusuario, :tiposuplencia)";
    @$sentencia=$this->dbPDO->prepare($sql);

    @$sentencia->bindParam(':lugar',$objeto->getFkIdLugarAtencion());
    @$sentencia->bindParam(':dupla',$objeto->getFkIdDupla());
    @$sentencia->bindParam(':grupo',$objeto->getFkIdGrupo());
    @$sentencia->bindParam(':experiencia',$objeto->getVcNombreExperiencia());
    @$sentencia->bindParam(':fecha',$objeto->getDtFechaEncuentro());
    @$sentencia->bindParam(':horainicio',$objeto->getHrHoraInicio());
    @$sentencia->bindParam(':horafin',$objeto->getHrHoraFinalizacion());
    @$sentencia->bindParam(':cuidadores',$objeto->getInCuidadores());
    @$sentencia->bindParam(':fecharegistro',$objeto->getDtFechaRegistro());
    @$sentencia->bindParam(':idusuario',$objeto->getInIdPersona());
    @$sentencia->bindParam(':tiposuplencia',$objeto->getIntTipoSuplencia());
    //$sentencia->execute();
    //return $sentencia->rowCount();
    
  try {
      $this->dbPDO->beginTransaction();
      $sentencia->execute();
      $id_insertado = $this->dbPDO->lastInsertId();
      $sql1="INSERT INTO tb_nidos_beneficiario_sin_informacion (IN_Total_Beneficiarios,	IN_Total_Ninos, IN_Total_Ninas, IN_Total_Ninos_0_3, IN_Total_Ninos_3_6, IN_Total_Ninos_6, IN_Total_Ninas_0_3, 
      IN_Total_Ninas_3_6, IN_Total_Ninas_6,	IN_Mujeres_Gestantes, IN_Afrodescendiente, IN_Campesina, IN_Discapacidad, IN_Conflicto, IN_Indigena, 
      IN_Privados, IN_Victimas, IN_Raizal, IN_Rom, Fk_Id_Lugar_Atencion, Fk_Id_Grupo, VC_Contenido, DT_Fecha_Entrega, VC_Documento_Soporte, Fk_Id_Usuario_Registro, DT_Fecha_Registro, Fk_Id_Experiencia, IN_Componente, 
      IN_Total_Beneficiarios_Nuevos, IN_Total_Ninos_Nuevos, IN_Total_Ninas_Nuevos, IN_Total_Ninos_0_3_Nuevos, 
      IN_Total_Ninos_3_6_Nuevos, IN_Total_Ninos_6_Nuevos, IN_Total_Ninas_0_3_Nuevos, IN_Total_Ninas_3_6_Nuevos, IN_Total_Ninas_6_Nuevos, IN_Mujeres_Gestantes_Nuevos, 
    IN_Afrodescendiente_Nuevo,	IN_Campesina_Nuevo, IN_Discapacidad_Nuevo, IN_Conflicto_Nuevo, 
      IN_Indigena_Nuevo, IN_Privados_Nuevo, IN_Victimas_Nuevo, IN_Raizal_Nuevo, IN_Rom_Nuevo) 
  VALUES(:total_atendidos, :ninos_atendidos, :ninas_atendidos, :ninos0a3_atendidos, :ninos4a6_atendidos, :ninos6_atendidos, :ninas0a3_atendidos,
      :ninas4a6_atendidos, :ninas6_atendidos, :gestantes_atendidos, :afro, :rural, :discapacidad, :conflicto, :indigena, :liberta, :violencia,
      :raizal, :rom, :lugar_atencion, :grupo, :contenido, :FechaEncuentro, :documento_soporte, :id_usuario, :fecha_registro, :id_experiencia, :componente, :total_nuevos, :ninos_nuevos, :ninas_nuevos,
      :ninos0a3_nuevos, :ninos4a6_nuevos, :ninos6_nuevos, :ninas0a3_nuevos, :ninas4a6_nuevos, :ninas6_nuevos, :gestantes_nuevos, :afro_nuevos, :rural_nuevos,
      :discapacidad_nuevos, :conflicto_nuevos, :indigena_nuevos, :liberta_nuevos, :violencia_nuevos, :raizal_nuevos, :rom_nuevos)";
      @$sentencia_cifras=$this->dbPDO->prepare($sql1);

     @$sentencia_cifras->bindParam(':total_atendidos',$objeto2->getInTotalBeneficiarios());
     @$sentencia_cifras->bindParam(':ninos_atendidos',$objeto2->getInTotalNinos());
     @$sentencia_cifras->bindParam(':ninas_atendidos',$objeto2->getInTotalNinas());
     @$sentencia_cifras->bindParam(':ninos0a3_atendidos',$objeto2->getInTotalNinos03());
     @$sentencia_cifras->bindParam(':ninos4a6_atendidos',$objeto2->getInTotalNinos36());
     @$sentencia_cifras->bindParam(':ninos6_atendidos',$objeto2->getInTotalNinos6());
     @$sentencia_cifras->bindParam(':ninas0a3_atendidos',$objeto2->getInTotalNinas03());
     @$sentencia_cifras->bindParam(':ninas4a6_atendidos',$objeto2->getInTotalNinas36());
     @$sentencia_cifras->bindParam(':ninas6_atendidos',$objeto2->getInTotalNinas6());
     @$sentencia_cifras->bindParam(':gestantes_atendidos',$objeto2->getInMujeresGestantes());
     @$sentencia_cifras->bindParam(':afro',$objeto2->getInAfrodescendiente());
     @$sentencia_cifras->bindParam(':rural',$objeto2->getInCampesina());
     @$sentencia_cifras->bindParam(':discapacidad',$objeto2->getInDiscapacidad());
     @$sentencia_cifras->bindParam(':conflicto',$objeto2->getInConflicto());
     @$sentencia_cifras->bindParam(':indigena',$objeto2->getInIndigena());
     @$sentencia_cifras->bindParam(':liberta',$objeto2->getInPrivados());
     @$sentencia_cifras->bindParam(':violencia',$objeto2->getInVictimas());
     @$sentencia_cifras->bindParam(':raizal',$objeto2->getInRaizal());
     @$sentencia_cifras->bindParam(':rom',$objeto2->getInRom());
     
     @$sentencia_cifras->bindParam(':lugar_atencion',$objeto2->getFkIdLugarAtencion());
     @$sentencia_cifras->bindParam(':grupo',$objeto2->getFkIdGrupo());
     @$sentencia_cifras->bindParam(':contenido',$objeto2->getVcContenido());
     @$sentencia_cifras->bindParam(':FechaEncuentro',$objeto2->getDtFechaEntrega());
     @$sentencia_cifras->bindParam(':documento_soporte',$objeto2->getVcDocumentoSoporte());   
     @$sentencia_cifras->bindParam(':id_usuario',$objeto2->getFkIdUsuarioRegistro());
     @$sentencia_cifras->bindParam(':fecha_registro',$objeto2->getDtFechaRegistro());     
     @$sentencia_cifras->bindParam(':id_experiencia', $id_insertado);
     @$sentencia_cifras->bindParam(':componente',$objeto2->getINComponente());
  
     @$sentencia_cifras->bindParam(':total_nuevos',$objeto2->getINTotalBeneficiariosNuevos());
     @$sentencia_cifras->bindParam(':ninos_nuevos',$objeto2->getINTotalNinosNuevos());
     @$sentencia_cifras->bindParam(':ninas_nuevos',$objeto2->getINTotalNinasNuevos());
     @$sentencia_cifras->bindParam(':ninos0a3_nuevos',$objeto2->getINTotalNinos03Nuevos());
     @$sentencia_cifras->bindParam(':ninos4a6_nuevos',$objeto2->getINTotalNinos36Nuevos());
     @$sentencia_cifras->bindParam(':ninos6_nuevos',$objeto2->getINTotalNinos6Nuevos());
     @$sentencia_cifras->bindParam(':ninas0a3_nuevos',$objeto2->getINTotalNinas03Nuevos());
     @$sentencia_cifras->bindParam(':ninas4a6_nuevos',$objeto2->getINTotalNinas36Nuevos());
     @$sentencia_cifras->bindParam(':ninas6_nuevos',$objeto2->getINTotalNinas6Nuevos());
     @$sentencia_cifras->bindParam(':gestantes_nuevos',$objeto2->getINMujeresGestantesNuevos());
     @$sentencia_cifras->bindParam(':afro_nuevos',$objeto2->getINAfrodescendienteNuevo());
     @$sentencia_cifras->bindParam(':rural_nuevos',$objeto2->getINCampesinaNuevo());
     @$sentencia_cifras->bindParam(':discapacidad_nuevos',$objeto2->getINDiscapacidadNuevo());
     @$sentencia_cifras->bindParam(':conflicto_nuevos',$objeto2->getINConflictoNuevo());
     @$sentencia_cifras->bindParam(':indigena_nuevos',$objeto2->getINIndigenaNuevo());
     @$sentencia_cifras->bindParam(':liberta_nuevos',$objeto2->getINPrivadosNuevo());
     @$sentencia_cifras->bindParam(':violencia_nuevos',$objeto2->getINVictimasNuevo());
     @$sentencia_cifras->bindParam(':raizal_nuevos',$objeto2->getINRaizalNuevo());
     @$sentencia_cifras->bindParam(':rom_nuevos',$objeto2->getINRomNuevo());
     $sentencia_cifras->execute();
      $this->dbPDO->commit();
      return true;
    } 

    catch(PDOExecption $e) {
      $this->dbPDO->rollback();
      return "Error!: " . $e->getMessage() . "</br>";
    } 
  }

  public function agregarBeneficiariosaExperiencia($objeto2) {
    $sql="INSERT INTO tb_nidos_beneficiario_sin_informacion (IN_Total_Beneficiarios,	IN_Total_Ninos, IN_Total_Ninas, IN_Total_Ninos_0_3, IN_Total_Ninos_3_6, IN_Total_Ninos_6, IN_Total_Ninas_0_3, 
    IN_Total_Ninas_3_6, IN_Total_Ninas_6,	IN_Mujeres_Gestantes, IN_Afrodescendiente, IN_Campesina, IN_Discapacidad, IN_Conflicto, IN_Indigena, 
    IN_Privados, IN_Victimas, IN_Raizal, IN_Rom, Fk_Id_Lugar_Atencion, Fk_Id_Grupo, VC_Contenido, DT_Fecha_Entrega, VC_Documento_Soporte, Fk_Id_Usuario_Registro, DT_Fecha_Registro, Fk_Id_Experiencia, IN_Componente, 
    IN_Total_Beneficiarios_Nuevos, IN_Total_Ninos_Nuevos, IN_Total_Ninas_Nuevos, IN_Total_Ninos_0_3_Nuevos, 
    IN_Total_Ninos_3_6_Nuevos, IN_Total_Ninos_6_Nuevos, IN_Total_Ninas_0_3_Nuevos, IN_Total_Ninas_3_6_Nuevos, IN_Total_Ninas_6_Nuevos, IN_Mujeres_Gestantes_Nuevos, 
  IN_Afrodescendiente_Nuevo,	IN_Campesina_Nuevo, IN_Discapacidad_Nuevo, IN_Conflicto_Nuevo, 
    IN_Indigena_Nuevo, IN_Privados_Nuevo, IN_Victimas_Nuevo, IN_Raizal_Nuevo, IN_Rom_Nuevo) 
VALUES(:total_atendidos, :ninos_atendidos, :ninas_atendidos, :ninos0a3_atendidos, :ninos4a6_atendidos, :ninos6_atendidos, :ninas0a3_atendidos,
    :ninas4a6_atendidos, :ninas6_atendidos, :gestantes_atendidos, :afro, :rural, :discapacidad, :conflicto, :indigena, :liberta, :violencia,
    :raizal, :rom, :lugar_atencion, :grupo, :contenido, :FechaEncuentro, :documento_soporte, :id_usuario, :fecha_registro, :id_experiencia, :componente, :total_nuevos, :ninos_nuevos, :ninas_nuevos,
    :ninos0a3_nuevos, :ninos4a6_nuevos, :ninos6_nuevos, :ninas0a3_nuevos, :ninas4a6_nuevos, :ninas6_nuevos, :gestantes_nuevos, :afro_nuevos, :rural_nuevos,
    :discapacidad_nuevos, :conflicto_nuevos, :indigena_nuevos, :liberta_nuevos, :violencia_nuevos, :raizal_nuevos, :rom_nuevos)";
    @$sentencia_cifras=$this->dbPDO->prepare($sql);

    @$sentencia_cifras->bindParam(':total_atendidos',$objeto2->getInTotalBeneficiarios());
    @$sentencia_cifras->bindParam(':ninos_atendidos',$objeto2->getInTotalNinos());
    @$sentencia_cifras->bindParam(':ninas_atendidos',$objeto2->getInTotalNinas());
    @$sentencia_cifras->bindParam(':ninos0a3_atendidos',$objeto2->getInTotalNinos03());
    @$sentencia_cifras->bindParam(':ninos4a6_atendidos',$objeto2->getInTotalNinos36());
    @$sentencia_cifras->bindParam(':ninos6_atendidos',$objeto2->getInTotalNinos6());
    @$sentencia_cifras->bindParam(':ninas0a3_atendidos',$objeto2->getInTotalNinas03());
    @$sentencia_cifras->bindParam(':ninas4a6_atendidos',$objeto2->getInTotalNinas36());
    @$sentencia_cifras->bindParam(':ninas6_atendidos',$objeto2->getInTotalNinas6());
    @$sentencia_cifras->bindParam(':gestantes_atendidos',$objeto2->getInMujeresGestantes());
    @$sentencia_cifras->bindParam(':afro',$objeto2->getInAfrodescendiente());
    @$sentencia_cifras->bindParam(':rural',$objeto2->getInCampesina());
    @$sentencia_cifras->bindParam(':discapacidad',$objeto2->getInDiscapacidad());
    @$sentencia_cifras->bindParam(':conflicto',$objeto2->getInConflicto());
    @$sentencia_cifras->bindParam(':indigena',$objeto2->getInIndigena());
    @$sentencia_cifras->bindParam(':liberta',$objeto2->getInPrivados());
    @$sentencia_cifras->bindParam(':violencia',$objeto2->getInVictimas());
    @$sentencia_cifras->bindParam(':raizal',$objeto2->getInRaizal());
    @$sentencia_cifras->bindParam(':rom',$objeto2->getInRom());  
    
    @$sentencia_cifras->bindParam(':lugar_atencion',$objeto2->getFkIdLugarAtencion());
    @$sentencia_cifras->bindParam(':grupo',$objeto2->getFkIdGrupo());
    @$sentencia_cifras->bindParam(':contenido',$objeto2->getVcContenido());
    @$sentencia_cifras->bindParam(':FechaEncuentro',$objeto2->getDtFechaEntrega());
    @$sentencia_cifras->bindParam(':documento_soporte',$objeto2->getVcDocumentoSoporte());    
    @$sentencia_cifras->bindParam(':id_usuario',$objeto2->getFkIdUsuarioRegistro());
    @$sentencia_cifras->bindParam(':fecha_registro',$objeto2->getDtFechaRegistro());
    @$sentencia_cifras->bindParam(':id_experiencia',$objeto2->getFkIdExperiencia());
    @$sentencia_cifras->bindParam(':componente',$objeto2->getINComponente());
 
    @$sentencia_cifras->bindParam(':total_nuevos',$objeto2->getINTotalBeneficiariosNuevos());
    @$sentencia_cifras->bindParam(':ninos_nuevos',$objeto2->getINTotalNinosNuevos());
    @$sentencia_cifras->bindParam(':ninas_nuevos',$objeto2->getINTotalNinasNuevos());
    @$sentencia_cifras->bindParam(':ninos0a3_nuevos',$objeto2->getINTotalNinos03Nuevos());
    @$sentencia_cifras->bindParam(':ninos4a6_nuevos',$objeto2->getINTotalNinos36Nuevos());
    @$sentencia_cifras->bindParam(':ninos6_nuevos',$objeto2->getINTotalNinos6Nuevos());
    @$sentencia_cifras->bindParam(':ninas0a3_nuevos',$objeto2->getINTotalNinas03Nuevos());
    @$sentencia_cifras->bindParam(':ninas4a6_nuevos',$objeto2->getINTotalNinas36Nuevos());
    @$sentencia_cifras->bindParam(':ninas6_nuevos',$objeto2->getINTotalNinas6Nuevos());
    @$sentencia_cifras->bindParam(':gestantes_nuevos',$objeto2->getINMujeresGestantesNuevos());
    @$sentencia_cifras->bindParam(':afro_nuevos',$objeto2->getINAfrodescendienteNuevo());
    @$sentencia_cifras->bindParam(':rural_nuevos',$objeto2->getINCampesinaNuevo());
    @$sentencia_cifras->bindParam(':discapacidad_nuevos',$objeto2->getINDiscapacidadNuevo());
    @$sentencia_cifras->bindParam(':conflicto_nuevos',$objeto2->getINConflictoNuevo());
    @$sentencia_cifras->bindParam(':indigena_nuevos',$objeto2->getINIndigenaNuevo());
    @$sentencia_cifras->bindParam(':liberta_nuevos',$objeto2->getINPrivadosNuevo());
    @$sentencia_cifras->bindParam(':violencia_nuevos',$objeto2->getINVictimasNuevo());
    @$sentencia_cifras->bindParam(':raizal_nuevos',$objeto2->getINRaizalNuevo());
    @$sentencia_cifras->bindParam(':rom_nuevos',$objeto2->getINRomNuevo());
    $sentencia_cifras->execute();
    return $sentencia_cifras->rowCount();

   }

  /* public function getExperienciasCifras($id_mes, $id_usuario){
    $sql = "SELECT EX.Pk_Id_Experiencia AS 'IDEXPERIENCIA',
    LA.VC_Nombre_Lugar AS 'LUGAR',
    EX.Fk_Id_Dupla AS 'IDDUPLA',
    DU.VC_Codigo_Dupla AS 'DUPLA',
    EX.Fk_Id_Grupo AS 'IDGRUPO',
    GR.VC_Nombre_Grupo AS 'GRUPO',
    EX.VC_Nombre_Experiencia AS 'EXPERIENCIA',
    EX.DT_Fecha_Encuentro AS 'FECHA',
    CONCAT(EX.HR_Hora_Inicio,' a ',EX.HR_Hora_Finalizacion) AS 'HORARIO',
    CONCAT(EX.HR_Hora_Inicio,' a ',EX.HR_Hora_Finalizacion) AS 'HORARIO',
    (SELECT COUNT(NA.Fk_Id_Beneficiario)
	  FROM tb_nidos_asistencia AS NA
	  WHERE NA.Vc_Asistencia = 1 AND NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia) AS 'BENEFICIARIOS',
    EX.IN_Cuidadores AS 'CUIDADORES',
    BI.Fk_Id_Experiencia AS 'FKEXPERIENCIA',
    BI.IN_Total_Ninos_0_3 AS 'NINOS03REAL',
    BI.IN_Total_Ninas_0_3 AS 'NINAS03REAL', 
    BI.IN_Total_Ninos_3_6 AS 'NINOS46REAL',
    BI.IN_Total_Ninas_3_6 AS 'NINAS46REAL',
    BI.IN_Total_Ninos_6 AS 'NINOS6REAL',
    BI.IN_Total_Ninas_6 AS 'NINAS6REAL',	 
	  BI.IN_Total_Ninos AS 'TOTALNINOSREAL',    
    BI.IN_Total_Ninas AS 'TOTALNINASREAL',
    BI.IN_Mujeres_Gestantes AS 'GESTANTESREAL',
    BI.IN_Total_Beneficiarios AS 'TOTALBENEFICIARIOSREAL',
    BI.IN_Afrodescendiente AS 'AFROREAL',
    BI.IN_Campesina AS 'CAMPESINOSREAL',
    BI.IN_Discapacidad AS 'DISCAPACIDADREAL',
    BI.IN_Conflicto AS 'CONFLICTOREAL',
    BI.IN_Indigena AS 'INDIGENAREAL',
    BI.IN_Privados AS 'PRIVADOSREAL',
    BI.IN_Victimas AS 'VICTIMASREAL',
    BI.IN_Raizal AS 'RAIZALREAL',
    BI.IN_Rom AS 'ROMREAL',
    BI.IN_Total_Ninos_0_3_Nuevos AS 'NINOS03NUEVOS',
    BI.IN_Total_Ninas_0_3_Nuevos AS 'NINAS03NUEVOS', 
	 BI.IN_Total_Ninos_3_6_Nuevos AS 'NINOS46NUEVOS',
    BI.IN_Total_Ninas_3_6_Nuevos AS 'NINAS46NUEVOS',
    BI.IN_Total_Ninos_6_Nuevos AS 'NINOS6NUEVOS',
    BI.IN_Total_Ninas_6_Nuevos AS 'NINAS6NUEVOS',
    BI.IN_Total_Ninos_Nuevos AS 'TOTALNINOSNUEVOS',   
    BI.IN_Total_Ninas_Nuevos AS 'TOTALNINASNUEVOS',
    BI.IN_Mujeres_Gestantes_Nuevos AS 'GESTANTESNUEVOS',
    BI.IN_Total_Beneficiarios_Nuevos AS 'TOTALBENEFICIARIOSNUEVOS',
    BI.IN_Afrodescendiente_Nuevo AS 'AFRONUEVOS',
    BI.IN_Campesina_Nuevo AS 'CAMPESINOSNUEVOS',
    BI.IN_Discapacidad_Nuevo AS 'DISCAPACIDADNUEVOS',
    BI.IN_Conflicto_Nuevo AS 'CONFLICTONUEVOS',
    BI.IN_Indigena_Nuevo AS 'INDIGENANUEVOS',
    BI.IN_Privados_Nuevo AS 'PRIVADOSNUEVOS',
    BI.IN_Victimas_Nuevo AS 'VICTIMASNUEVOS',
    BI.IN_Raizal_Nuevo AS 'RAIZALNUEVOS',
    BI.IN_Rom_Nuevo AS 'ROMNUEVOS',
    BI.VC_Documento_Soporte AS 'soporte',
    BI.Pk_Id_Registro AS 'IDREGISTRO'
    FROM tb_nidos_experiencia AS EX
    JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
    JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
    JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
    JOIN tb_nidos_beneficiario_sin_informacion AS BI ON EX.Pk_Id_Experiencia = BI.Fk_Id_Experiencia
    JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla = BI.Fk_Id_Usuario_Registro
    WHERE DA.Fk_Id_Persona = :id_usuario AND DA.IN_Estado = 1 AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31')
    ORDER BY LUGAR, GRUPO";  
    @$sentencia=$this->dbPDO->prepare($sql);  
    @$sentencia->bindParam(':id_usuario', $id_usuario);  
    @$sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);  
  } */

  public function getConsultaAsistenciasDupla($id_mes, $id_usuario){
    $sql = "SELECT ID, LUGAR, GRUPO, GRADO, MODALIDAD, EXPERIENCIAS, FECHA, CUIDADORES, IDEXPEREINCIA, SOPORTE, IDDUPLA, IDGRUPO, APROBADO,
    COALESCE(_0_3_NINOS_N,0) AS _0_3_NINOS_N,
    COALESCE(_0_3_NINAS_N,0) AS _0_3_NINAS_N,
    COALESCE(TOTAL_0_3_N,0) AS TOTAL_0_3_N,
    COALESCE(_4_5_NINOS_N,0) AS _4_5_NINOS_N,
    COALESCE(_4_5_NINAS_N,0) AS _4_5_NINAS_N,
    COALESCE(TOTAL_4_5_N,0) AS TOTAL_4_5_N,
    COALESCE(_6_NINOS_N,0) AS _6_NINOS_N,
    COALESCE(_6_NINAS_N,0) AS _6_NINAS_N,
    COALESCE(TOTAL_6_N,0) AS TOTAL_6_N,
    COALESCE(GESTANTES_N,0) AS GESTANTES_N,
    COALESCE(TOTAL_N,0) AS TOTAL_N,
    COALESCE(ENFOQUE_N,0) AS ENFOQUE_N,
    COALESCE(_0_3_NINOS_R,0) AS _0_3_NINOS_R,
    COALESCE(_0_3_NINAS_R,0) AS _0_3_NINAS_R,
    COALESCE(TOTAL_0_3_R,0) AS TOTAL_0_3_R,
    COALESCE(_4_5_NINOS_R,0) AS _4_5_NINOS_R,
    COALESCE(_4_5_NINAS_R,0) AS _4_5_NINAS_R,
    COALESCE(TOTAL_4_5_R,0) AS TOTAL_4_5_R,
    COALESCE(_6_NINOS_R,0) AS _6_NINOS_R,
    COALESCE(_6_NINAS_R,0) AS _6_NINAS_R,
    COALESCE(TOTAL_6_R,0) AS TOTAL_6_R,
    COALESCE(GESTANTES_R,0) AS GESTANTES_R,
    COALESCE(TOTAL_R,0) AS TOTAL_R,
    COALESCE(ENFOQUE_R,0) AS ENFOQUE_R
    FROM 
    (SELECT EX.Pk_Id_Experiencia AS 'ID',
    LA.VC_Nombre_Lugar AS 'LUGAR',
    EX.Fk_Id_Dupla AS 'IDDUPLA',
    EX.Fk_Id_Grupo AS 'IDGRUPO',
    GR.VC_Nombre_Grupo AS 'GRUPO',
    PD.VC_Descripcion AS 'GRADO',
    (CASE WHEN EX.IN_Modalidad = '1' THEN 'Presencial' WHEN EX.IN_Modalidad = '2' THEN 'Virtual' END) AS 'MODALIDAD',
    EX.VC_Nombre_Experiencia AS 'EXPERIENCIAS',
    EX.DT_Fecha_Encuentro AS 'FECHA',
    EX.IN_Cuidadores AS 'CUIDADORES',
    EX.VC_Documento_Soporte AS 'SOPORTE',
    EX.IN_Aprobacion AS 'APROBADO'
    FROM tb_nidos_experiencia AS EX
    JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
    JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
    JOIN tb_nidos_dupla_artista AS DA ON EX.Fk_Id_Dupla = DA.Fk_Id_Dupla
    LEFT JOIN tb_parametro_detalle AS PD ON GR.Fk_Id_Nivel_Escolaridad = PD.FK_Value AND PD.FK_Id_Parametro = 58
    WHERE  DA.Fk_Id_Persona = :id_usuario AND DA.IN_Estado = 1 AND EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31' ORDER BY ID ASC) AS PRIMERA LEFT JOIN
    (SELECT
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 1 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _0_3_NINOS_N,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 2 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _0_3_NINAS_N,
      COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_0_3_N,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 1 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _4_5_NINOS_N,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 2 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _4_5_NINAS_N,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_4_5_N,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 1 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _6_NINOS_N,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 2 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _6_NINAS_N,
      COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6  AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_6_N,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 10  AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS GESTANTES_N,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 60 AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_N,
     COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (1, 2, 3, 4, 5, 10, 12, 13, 14, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26) AND
     (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS ENFOQUE_N,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND DT.Fk_Id_Genero = 1 then 1 END) AS _0_3_NINOS_R,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND DT.Fk_Id_Genero = 2 then 1 END) AS _0_3_NINAS_R, 
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_0_3_R,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND DT.Fk_Id_Genero = 1 then 1 END) AS _4_5_NINOS_R,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND DT.Fk_Id_Genero = 2 then 1 END) AS _4_5_NINAS_R, 
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_4_5_R,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND DT.Fk_Id_Genero = 1 then 1 END) AS _6_NINOS_R,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND DT.Fk_Id_Genero = 2 then 1 END) AS _6_NINAS_R, 
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 then 1 END) AS TOTAL_6_R,
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 10 then 1 END) AS GESTANTES_R, 
     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 60 then 1 END) AS TOTAL_R,
     COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (1, 2, 3, 4, 5, 10, 12, 13, 14, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26) then 1 END) AS ENFOQUE_R,
     DT.Fk_Id_Experiencia AS IDEXPEREINCIA
     FROM (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,NA.Fk_Id_Experiencia, NA.Fk_Id_Beneficiario, BE.FK_Id_Genero
	  FROM tb_nidos_asistencia NA
     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
     JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
     where NA.Vc_Asistencia = '1'  AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31')) DT GROUP BY Fk_Id_Experiencia
     UNION
     SELECT 
     BI.IN_Total_Ninos_0_3_Nuevos AS _0_3_NINOS_N,
     BI.IN_Total_Ninas_0_3_Nuevos AS _0_3_NINAS_N,
     SUM(BI.IN_Total_Ninos_0_3_Nuevos  + BI.IN_Total_Ninas_0_3_Nuevos) AS TOTAL_0_3_N,
     BI.IN_Total_Ninos_3_6_Nuevos AS _4_5_NINOS_N,
     BI.IN_Total_Ninas_0_3_Nuevos AS _4_5_NINAS_N,
     SUM(BI.IN_Total_Ninos_3_6_Nuevos  + BI.IN_Total_Ninas_0_3_Nuevos) AS TOTAL_4_5_N,
     BI.IN_Total_Ninos_6_Nuevos AS _6_NINOS_N,
     BI.IN_Total_Ninas_6_Nuevos AS _6_NINAS_N,
     SUM(BI.IN_Total_Ninos_6_Nuevos  + BI.IN_Total_Ninas_6_Nuevos) AS TOTAL_6_N,
     BI.IN_Mujeres_Gestantes_Nuevos AS GESTANTES_N,
     SUM(BI.IN_Total_Ninos_Nuevos  + BI.IN_Total_Ninas_Nuevos) AS TOTAL_N,
     SUM(BI.IN_Afrodescendiente_Nuevo + BI.IN_Campesina_Nuevo + BI.IN_Discapacidad_Nuevo + BI.IN_Conflicto_Nuevo + BI.IN_Indigena_Nuevo + BI.IN_Privados_Nuevo + BI.IN_Victimas_Nuevo + BI.IN_Raizal_Nuevo + BI.IN_Rom_Nuevo) AS ENFOQUE_N,
     BI.IN_Total_Ninos_0_3 AS _0_3_NINOS_R,
     BI.IN_Total_Ninas_0_3 AS _0_3_NINAS_R,
     SUM(BI.IN_Total_Ninos_0_3 + BI.IN_Total_Ninas_0_3) AS TOTAL_0_3_R,
     BI.IN_Total_Ninos_3_6 AS _4_5_NINOS_R,
     BI.IN_Total_Ninas_3_6 AS _4_5_NINAS_R,
     SUM(BI.IN_Total_Ninos_3_6 + BI.IN_Total_Ninas_3_6) AS TOTAL_4_5_R,
     BI.IN_Total_Ninos_6 AS _6_NINOS_R,
     BI.IN_Total_Ninas_6 AS _6_NINAS_R,
     SUM(BI.IN_Total_Ninos_6 + BI.IN_Total_Ninas_6),
     BI.IN_Mujeres_Gestantes AS TOTAL_6_R,
     SUM(BI.IN_Total_Ninos + BI.IN_Total_Ninas) AS TOTAL_R,
     SUM(BI.IN_Afrodescendiente + BI.IN_Campesina + BI.IN_Discapacidad + BI.IN_Conflicto + BI.IN_Indigena + BI.IN_Privados + BI.IN_Victimas + BI.IN_Raizal + BI.IN_Rom) AS ENFOQUE_R,
     BI.Fk_Id_Experiencia AS IDEXPEREINCIA
     FROM tb_nidos_beneficiario_sin_informacion AS BI
     GROUP BY IDEXPEREINCIA) AS SEGUNDA
     ON PRIMERA.ID = SEGUNDA.IDEXPEREINCIA";  
    @$sentencia=$this->dbPDO->prepare($sql);  
    @$sentencia->bindParam(':id_usuario', $id_usuario);  
    @$sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }  

  public function borrarArchivo($experiencia){
    $sql="DELETE FROM tb_nidos_experiencia_soporte WHERE Pk_Id_Soporte = :id_experiencia";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':id_experiencia',$experiencia);
    $sentencia->execute();
    return $sentencia->rowCount();
  
  }

  public function subirUsoImagen($objeto){
    $sql="INSERT INTO tb_nidos_experiencia_soporte (Fk_Id_Dupla, Fk_Id_Lugar_Atencion, IN_Mes, VC_Documento_Soporte) VALUES (:id_dupla, :id_lugar, :id_mes, :url)";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':id_dupla',$objeto->getFkIdDupla());
    @$sentencia->bindParam(':id_lugar',$objeto->getFkIdLugarAtencion());
    @$sentencia->bindParam(':id_mes',$objeto->getInMes());
    @$sentencia->bindParam(':url',$objeto->getVcDocumentoSoporte());
    $sentencia->execute();
    return $sentencia->rowCount();
  }

  public function eliminarExperienciaCifras($id_experiencia){
    $sql1="DELETE 
    FROM tb_nidos_experiencia
    WHERE Pk_Id_Experiencia = :id_experiencia;";
    @$sentencia=$this->dbPDO->prepare($sql1);
    @$sentencia->bindParam(':id_experiencia', $id_experiencia);
    $sentencia->execute();
    return $sentencia->rowCount();
  }

  public function ActualizarCifrasBeneficiarios($objeto2) {
    $sql="UPDATE tb_nidos_beneficiario_sin_informacion SET IN_Total_Beneficiarios=:total_atendidos, IN_Total_Ninos=:ninos_atendidos, IN_Total_Ninas=:ninas_atendidos,
          IN_Total_Ninos_0_3=:ninos0a3_atendidos, IN_Total_Ninos_3_6=:ninos4a6_atendidos, IN_Total_Ninas_0_3=:ninas0a3_atendidos, IN_Total_Ninas_3_6=:ninas4a6_atendidos, IN_Mujeres_Gestantes=:gestantes_atendidos,
          IN_Afrodescendiente=:afro, IN_Campesina=:rural, IN_Discapacidad=:discapacidad, IN_Conflicto=:conflicto, IN_Indigena=:indigena, IN_Privados=:liberta, IN_Victimas=:violencia, IN_Raizal=:raizal, IN_Rom=:rom,
          DT_Fecha_Registro=:fecha_registro, IN_Total_Beneficiarios_Nuevos=:total_nuevos, IN_Total_Ninos_Nuevos=:ninos_nuevos, IN_Total_Ninas_Nuevos=:ninas_nuevos, IN_Total_Ninos_0_3_Nuevos=:ninos0a3_nuevos,
          IN_Total_Ninos_3_6_Nuevos=:ninos4a6_nuevos, IN_Total_Ninas_0_3_Nuevos=:ninas0a3_nuevos, IN_Total_Ninas_3_6_Nuevos=:ninas4a6_nuevos, IN_Mujeres_Gestantes_Nuevos=:gestantes_nuevos, IN_Afrodescendiente_Nuevo=:afro_nuevos, 
          IN_Campesina_Nuevo=:rural_nuevos, IN_Discapacidad_Nuevo=:discapacidad_nuevos, IN_Conflicto_Nuevo=:conflicto_nuevos, IN_Indigena_Nuevo=:indigena_nuevos, IN_Privados_Nuevo=:liberta_nuevos, IN_Victimas_Nuevo=:violencia_nuevos, IN_Raizal_Nuevo=:raizal_nuevos, IN_Rom_Nuevo=:rom_nuevos
        WHERE Fk_Id_Experiencia = :id_experiencia";
    @$sentencia_cifras=$this->dbPDO->prepare($sql);

    @$sentencia_cifras->bindParam(':total_atendidos',$objeto2->getInTotalBeneficiarios());
    @$sentencia_cifras->bindParam(':ninos_atendidos',$objeto2->getInTotalNinos());
    @$sentencia_cifras->bindParam(':ninas_atendidos',$objeto2->getInTotalNinas());
    @$sentencia_cifras->bindParam(':ninos0a3_atendidos',$objeto2->getInTotalNinos03());
    @$sentencia_cifras->bindParam(':ninos4a6_atendidos',$objeto2->getInTotalNinos36());
    @$sentencia_cifras->bindParam(':ninas0a3_atendidos',$objeto2->getInTotalNinas03());
    @$sentencia_cifras->bindParam(':ninas4a6_atendidos',$objeto2->getInTotalNinas36());
    @$sentencia_cifras->bindParam(':gestantes_atendidos',$objeto2->getInMujeresGestantes());
    @$sentencia_cifras->bindParam(':afro',$objeto2->getInAfrodescendiente());
    @$sentencia_cifras->bindParam(':rural',$objeto2->getInCampesina());
    @$sentencia_cifras->bindParam(':discapacidad',$objeto2->getInDiscapacidad());
    @$sentencia_cifras->bindParam(':conflicto',$objeto2->getInConflicto());
    @$sentencia_cifras->bindParam(':indigena',$objeto2->getInIndigena());
    @$sentencia_cifras->bindParam(':liberta',$objeto2->getInPrivados());
    @$sentencia_cifras->bindParam(':violencia',$objeto2->getInVictimas());
    @$sentencia_cifras->bindParam(':raizal',$objeto2->getInRaizal());
    @$sentencia_cifras->bindParam(':rom',$objeto2->getInRom());  

    @$sentencia_cifras->bindParam(':fecha_registro',$objeto2->getDtFechaRegistro());
    @$sentencia_cifras->bindParam(':id_experiencia',$objeto2->getFkIdExperiencia());
 
    @$sentencia_cifras->bindParam(':total_nuevos',$objeto2->getINTotalBeneficiariosNuevos());
    @$sentencia_cifras->bindParam(':ninos_nuevos',$objeto2->getINTotalNinosNuevos());
    @$sentencia_cifras->bindParam(':ninas_nuevos',$objeto2->getINTotalNinasNuevos());
    @$sentencia_cifras->bindParam(':ninos0a3_nuevos',$objeto2->getINTotalNinos03Nuevos());
    @$sentencia_cifras->bindParam(':ninos4a6_nuevos',$objeto2->getINTotalNinos36Nuevos());
    @$sentencia_cifras->bindParam(':ninas0a3_nuevos',$objeto2->getINTotalNinas03Nuevos());
    @$sentencia_cifras->bindParam(':ninas4a6_nuevos',$objeto2->getINTotalNinas36Nuevos());
    @$sentencia_cifras->bindParam(':gestantes_nuevos',$objeto2->getINMujeresGestantesNuevos());
    @$sentencia_cifras->bindParam(':afro_nuevos',$objeto2->getINAfrodescendienteNuevo());
    @$sentencia_cifras->bindParam(':rural_nuevos',$objeto2->getINCampesinaNuevo());
    @$sentencia_cifras->bindParam(':discapacidad_nuevos',$objeto2->getINDiscapacidadNuevo());
    @$sentencia_cifras->bindParam(':conflicto_nuevos',$objeto2->getINConflictoNuevo());
    @$sentencia_cifras->bindParam(':indigena_nuevos',$objeto2->getINIndigenaNuevo());
    @$sentencia_cifras->bindParam(':liberta_nuevos',$objeto2->getINPrivadosNuevo());
    @$sentencia_cifras->bindParam(':violencia_nuevos',$objeto2->getINVictimasNuevo());
    @$sentencia_cifras->bindParam(':raizal_nuevos',$objeto2->getINRaizalNuevo());
    @$sentencia_cifras->bindParam(':rom_nuevos',$objeto2->getINRomNuevo());
    $sentencia_cifras->execute();
    return $sentencia_cifras->rowCount();
   }

   public function consultarTotalExperienciasMes($id_mes, $id_usuario){
    $sql="SELECT COUNT(EX.Pk_Id_Experiencia) AS TOTAL 
    FROM tb_nidos_experiencia AS EX
    JOIN tb_nidos_dupla_artista AS DA ON EX.Fk_Id_Dupla = DA.Fk_Id_Dupla
    WHERE DA.Fk_Id_Persona = :IdUsuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31')";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':IdUsuario',$id_usuario);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarExperienciaLugarDupla($id_mes, $id_usuario){
    $sql="SELECT LA.Pk_Id_lugar_atencion AS 'IDLUGAR', LA.VC_Nombre_Lugar AS 'LUGAR', EX.Fk_Id_Dupla AS 'IDDUPLA',
    COUNT(EX.Pk_Id_Experiencia) AS 'CANTIDAD',
    (SELECT Pk_Id_Soporte
    FROM tb_nidos_experiencia_soporte AS  ES
    WHERE EX.Fk_Id_Lugar_Atencion = ES.Fk_Id_Lugar_Atencion
    AND EX.Fk_Id_Dupla = ES.Fk_Id_Dupla AND ES.IN_Mes = $id_mes ORDER BY Pk_Id_Soporte DESC LIMIT 1) AS 'IDSOPORTE',
    (SELECT VC_Documento_Soporte 
    FROM tb_nidos_experiencia_soporte AS  ES
    WHERE EX.Fk_Id_Lugar_Atencion = ES.Fk_Id_Lugar_Atencion
    AND EX.Fk_Id_Dupla = ES.Fk_Id_Dupla AND ES.IN_Mes = $id_mes ORDER BY Pk_Id_Soporte DESC LIMIT 1) AS 'SOPORTE'
    FROM tb_nidos_experiencia AS EX
    JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
    JOIN tb_nidos_dupla_artista AS DA ON EX.Fk_Id_Dupla = DA.Fk_Id_Dupla
    WHERE DA.Fk_Id_Persona = :IdUsuario 
    AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31') AND LA.Fk_Id_Entidad != 5
    GROUP BY EX.Fk_Id_Lugar_Atencion
    HAVING COUNT(EX.Pk_Id_Experiencia) ORDER BY LA.VC_Nombre_Lugar";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':IdUsuario',$id_usuario);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarExperienciaLaboratorioDupla($id_mes, $id_usuario){
    $sql="SELECT LA.Pk_Id_lugar_atencion AS 'IDLUGAR', LA.VC_Nombre_Lugar AS 'LUGAR', EX.Fk_Id_Dupla AS 'IDDUPLA',
    COUNT(EX.Pk_Id_Experiencia) AS 'CANTIDAD',
    (SELECT ES.Pk_Id_Soporte
    FROM tb_nidos_experiencia_soporte AS  ES
    JOIN tb_nidos_grupos AS GR ON ES.Fk_Id_Lugar_Atencion = GR.Fk_Id_Lugar_Grupo_Laboratorio
    WHERE GR.Fk_Id_Lugar_Grupo_Laboratorio = LA.Pk_Id_lugar_atencion
    AND EX.Fk_Id_Dupla = ES.Fk_Id_Dupla AND ES.IN_Mes = $id_mes ORDER BY ES.Pk_Id_Soporte DESC LIMIT 1) AS 'IDSOPORTE',    
    (SELECT VC_Documento_Soporte 
    FROM tb_nidos_experiencia_soporte AS  ES
    JOIN tb_nidos_grupos AS GR ON ES.Fk_Id_Lugar_Atencion = GR.Fk_Id_Lugar_Grupo_Laboratorio
    WHERE GR.Fk_Id_Lugar_Grupo_Laboratorio = LA.Pk_Id_lugar_atencion
    AND EX.Fk_Id_Dupla = ES.Fk_Id_Dupla AND ES.IN_Mes = $id_mes ORDER BY Pk_Id_Soporte DESC LIMIT 1) AS 'SOPORTE' 
   FROM tb_nidos_experiencia AS EX
   JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
   JOIN tb_nidos_lugar_atencion AS LA ON GR.Fk_Id_Lugar_Grupo_Laboratorio = LA.Pk_Id_lugar_atencion
   JOIN tb_nidos_dupla_artista AS DA ON EX.Fk_Id_Dupla = DA.Fk_Id_Dupla
   WHERE DA.Fk_Id_Persona = :IdUsuario 
   AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31') 
   GROUP BY GR.Fk_Id_Lugar_Grupo_Laboratorio
   HAVING COUNT(EX.Pk_Id_Experiencia) ORDER BY LA.VC_Nombre_Lugar";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':IdUsuario',$id_usuario);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }
  

}
