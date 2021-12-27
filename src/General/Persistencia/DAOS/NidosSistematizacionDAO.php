<?php
namespace General\Persistencia\DAOS;
class NidosSistematizacionDAO extends GestionDAO {
  private $db;
  function __construct(){
    $this->db=$this->obtenerBD();
    $this->dbPDO=$this->obtenerPDOBD();
  }

  public function crearObjeto($objeto){
  }

  public function guardarSistematizacion($objeto, $objeto2){

    $sql="INSERT INTO tb_nidos_sistematizacion (Fk_Id_Dupla, VC_Nombre_Experiencia, IN_Periodo, TX_Tema, TX_Materias, TX_Intencion_Artistica, TX_Referentes, TX_Aplicabilidad_Referentes, TX_Ambientacion, TX_Dispositivos, TX_Momentos, DT_Fecha_Envio_Planeacion, Fk_Id_Artista_Envio_Planeacion, In_Aprobacion_Planeacion) VALUES (:id_dupla, :nombre_experiencia, :mes_experiencia, :tema, :materias, :intencion, :referentes, :aplicabilidad, :ambientacion, :dispositivos, :momentos, :fecha_envio, :id_artista, :estado)";

    @$sentencia=$this->dbPDO->prepare($sql);

    @$sentencia->bindparam('id_dupla', $objeto->getFkIdDupla());
    @$sentencia->bindparam('nombre_experiencia', $objeto->getVcNombreExperiencia());
    @$sentencia->bindparam('mes_experiencia', $objeto->getInPeriodo());
    @$sentencia->bindparam('tema', $objeto->getTxTema());
    @$sentencia->bindparam('materias', $objeto->getTxMaterias());
    @$sentencia->bindparam('intencion', $objeto->getTxIntencionArtistica());
    @$sentencia->bindparam('referentes', $objeto->getTxReferentes());
    @$sentencia->bindparam('aplicabilidad', $objeto->getTxAplicabilidadReferentes());
    @$sentencia->bindparam('ambientacion', $objeto->getTxAmbientacion());
    @$sentencia->bindparam('dispositivos', $objeto->getTxDispositivos());
    @$sentencia->bindparam('momentos', $objeto->getTxMomentos());
    @$sentencia->bindparam('fecha_envio', $objeto->getDtFechaEnvioPlaneacion());
    @$sentencia->bindparam('id_artista', $objeto->getFkIdArtistaEnvioPlaneacion());
    @$sentencia->bindparam('estado', $objeto->getInAprobacionPlaneacion());

    try{
      $this->dbPDO->beginTransaction();
      $sentencia->execute();
      $id_insertado = $this->dbPDO->lastInsertId();

      $sql2="INSERT INTO tb_nidos_sistematizacion_artista (Fk_Id_Sistematizacion, Fk_Id_Artista) VALUES (:id_sistematizacion, :fk_id_artista)";
      @$sentencia2=$this->dbPDO->prepare($sql2);
      @$sentencia2->bindparam(':id_sistematizacion', $id_sistematizacion);
      @$sentencia2->bindparam('fk_id_artista', $id_artista);

      foreach ($objeto2->getFkIdArtistas() as $artista) {
        $id_sistematizacion = $id_insertado;  
        $id_artista = $artista;
        $sentencia2->execute();
      }
      $this->dbPDO->commit();
      return true;
    }catch(PDOExecption $e) {
      $this->dbPDO->rollback();
      return "Error!: " . $e->getMessage() . "</br>";
    }
  }

  public function modificarObjeto($objeto){

  }

  public function modificarSistematizacion($objeto, $parte_modificar){

    if($parte_modificar == "planeacion"){

     $sql="UPDATE tb_nidos_sistematizacion SET VC_Nombre_Experiencia=:nombre_experiencia, TX_Tema=:tema, TX_Materias=:materias, TX_Intencion_Artistica=:intencion, TX_Referentes=:referentes, TX_Aplicabilidad_Referentes=:aplicabilidad_referentes, TX_Ambientacion=:ambientacion, TX_Dispositivos=:dispositivos, TX_Momentos=:momentos, In_Aprobacion_Planeacion=:estado";

     if($objeto->getDtFechaEnvioPlaneacion() != null && $objeto->getFkIdArtistaEnvioPlaneacion() != null){
      $sql .= ", DT_Fecha_Envio_Planeacion=:fecha_envio, Fk_Id_Artista_Envio_Planeacion=:id_artista";
    }

    if($objeto->getDtFechaAprobacionPlaneacion() != null && $objeto->getFkIdEaatAprobo() != null){
      $sql .= ", FK_Id_Eaat_Aprobo=:id_eaat, DT_Fecha_Aprobacion_Planeacion=:fecha_aprobacion";
    }

    if($objeto->getTxObservaciones() != null){
      $sql .= ", TX_Observaciones=:observaciones";
    }


    $sql .= " WHERE PK_Id_Sistematizacion=:id_sistematizacion";

    @$sentencia=$this->dbPDO->prepare($sql);

    @$sentencia->bindparam('id_sistematizacion', $objeto->getPkIdSistematizacion());
    @$sentencia->bindparam('nombre_experiencia', $objeto->getVcNombreExperiencia());
    @$sentencia->bindparam('tema', $objeto->getTxTema());
    @$sentencia->bindparam('materias', $objeto->getTxMaterias());
    @$sentencia->bindparam('intencion', $objeto->getTxIntencionArtistica());
    @$sentencia->bindparam('referentes', $objeto->getTxReferentes());
    @$sentencia->bindparam('aplicabilidad_referentes', $objeto->getTxAplicabilidadReferentes());
    @$sentencia->bindparam('ambientacion', $objeto->getTxAmbientacion());
    @$sentencia->bindparam('dispositivos', $objeto->getTxDispositivos());
    @$sentencia->bindparam('momentos', $objeto->getTxMomentos());
    @$sentencia->bindparam('estado', $objeto->getInAprobacionPlaneacion());

    if($objeto->getDtFechaEnvioPlaneacion() != null && $objeto->getFkIdArtistaEnvioPlaneacion() != null){
      @$sentencia->bindparam('fecha_envio', $objeto->getDtFechaEnvioPlaneacion());
      @$sentencia->bindparam('id_artista', $objeto->getFkIdArtistaEnvioPlaneacion());
    }

    if($objeto->getDtFechaAprobacionPlaneacion() != null && $objeto->getFkIdEaatAprobo() != null){
      @$sentencia->bindparam('fecha_aprobacion', $objeto->getDtFechaAprobacionPlaneacion());
      @$sentencia->bindparam('id_eaat', $objeto->getFkIdEaatAprobo());
    }

    if($objeto->getTxObservaciones() != null){
      @$sentencia->bindparam('observaciones', $objeto->getTxObservaciones());
    }

    $sentencia->execute();
    return $sentencia->rowCount();

  }

  if($parte_modificar == "sistematizacion"){
    $sql="UPDATE tb_nidos_sistematizacion SET TX_Ninos_Ins=:ninos_ins, TX_Agentes_Ins=:agentes_ins, TX_Ninos_Fam=:ninos_fam, TX_Agentes_Fam=:agentes_fam, TX_Familias_Fam=:familias_fam, TX_Mujeres_Fam=:mujeres_fam, TX_Ninos_Com=:ninos_com, TX_Familias_Com=:familias_com, TX_Aprendizajes_Creacion=:aprendizajes_creacion, TX_Aprendizajes_Personales=:aprendizajes_personales, TX_Otros_Aspectos=:otros_aspectos, TX_Banco_Imagenes=:banco_imagenes, IN_Aprobacion_Sistematizacion=:estado";

    if($objeto->getDtFechaEnvioSistematizacion() != null && $objeto->getFkIdArtistaEnvioSistematizacion() != null){
      $sql .= ", DT_Fecha_Envio_Sistematizacion=:fecha_envio, Fk_Id_Artista_Envio_Sistematizacion=:id_artista";
    }

    if($objeto->getTxObservaciones() != null){
      $sql .= ", TX_Observaciones=:observaciones";
    }

    if($objeto->getDtFechaAprobacionSistematizacion() != null){
      $sql .= ", DT_Fecha_Aprobacion_Sistematizacion=:fecha_aprobacion";
    }

    $sql .= " WHERE PK_Id_Sistematizacion=:id_sistematizacion";

    @$sentencia=$this->dbPDO->prepare($sql);

    @$sentencia->bindparam('id_sistematizacion', $objeto->getPkIdSistematizacion());
    @$sentencia->bindparam('ninos_ins', $objeto->getTxNinosIns());
    @$sentencia->bindparam('agentes_ins', $objeto->getTxAgentesIns());
    @$sentencia->bindparam('ninos_fam', $objeto->getTxNinosFam());
    @$sentencia->bindparam('agentes_fam', $objeto->getTxAgentesFam());
    @$sentencia->bindparam('familias_fam', $objeto->getTxFamiliasFam());
    @$sentencia->bindparam('mujeres_fam', $objeto->getTxMujeresFam());
    @$sentencia->bindparam('ninos_com', $objeto->getTxNinosCom());
    @$sentencia->bindparam('familias_com', $objeto->getTxFamiliasCom());
    @$sentencia->bindparam('aprendizajes_creacion', $objeto->getTxAprendizajesCreacion());
    @$sentencia->bindparam('aprendizajes_personales', $objeto->getTxAprendizajesPersonales());
    @$sentencia->bindparam('otros_aspectos', $objeto->getTxOtrosAspectos());
    @$sentencia->bindparam('banco_imagenes', $objeto->getTxBancoImagenes());
    @$sentencia->bindparam('estado', $objeto->getInAprobacionSistematizacion());

    if($objeto->getDtFechaEnvioSistematizacion() != null && $objeto->getFkIdArtistaEnvioSistematizacion() != null){
     @$sentencia->bindparam('fecha_envio', $objeto->getDtFechaEnvioSistematizacion());
     @$sentencia->bindparam('id_artista', $objeto->getFkIdArtistaEnvioSistematizacion());
   }

   if($objeto->getTxObservaciones() != null){
    @$sentencia->bindparam('observaciones', $objeto->getTxObservaciones());
  }

  if($objeto->getDtFechaAprobacionSistematizacion() != null){
    @$sentencia->bindparam('fecha_aprobacion', $objeto->getDtFechaAprobacionSistematizacion());
  }

  $sentencia->execute();
  return $sentencia->rowCount();

}

}

public function getSistematizacionMesAnterior($id_dupla){
  $sql = "SELECT
  PK_Id_Sistematizacion,
  Fk_Id_Dupla,
  VC_Nombre_Experiencia,
  TX_Tema,
  TX_Materias,
  TX_Intencion_Artistica,
  TX_Referentes,
  TX_Aplicabilidad_Referentes,
  TX_Ambientacion,
  TX_Dispositivos,
  TX_Momentos
  FROM tb_nidos_sistematizacion where Fk_Id_Dupla=:id_dupla ORDER BY PK_Id_Sistematizacion DESC LIMIT 1";

  $sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_dupla',$id_dupla);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getObservaciones($id_sistematizacion){
 $sql="SELECT
 IN_Aprobacion_Planeacion,
 IN_Aprobacion_Sistematizacion,
 TX_Observaciones
 FROM tb_nidos_sistematizacion
 WHERE PK_Id_Sistematizacion=:id_sistematizacion";
 @$sentencia=$this->dbPDO->prepare($sql);

 @$sentencia->bindParam(':id_sistematizacion', $id_sistematizacion);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function eliminarObjeto($objeto){
 return;
}

public function consultarObjeto($objeto){
 return;
}

public function getDuplas($id_usuario){
  $sql="SELECT
  ND.Pk_Id_Dupla AS 'Id',
  CONCAT(ND.VC_Codigo_Dupla, ' - ',GROUP_CONCAT(P.VC_Primer_Nombre,' ', P.VC_Primer_Apellido ORDER BY P.VC_Primer_Nombre ASC SEPARATOR ' Y ')) AS 'Dupla'
  FROM tb_nidos_dupla AS ND
  JOIN tb_nidos_persona_territorio AS PT ON PT.Fk_Id_Territorio=ND.Fk_Id_Territorio
  JOIN tb_nidos_dupla_artista DA ON DA.Fk_Id_Dupla=ND.Pk_Id_Dupla
  JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=DA.Fk_Id_Persona
  WHERE PT.Fk_Id_Persona=:id_usuario AND ND.IN_Estado='1' AND DA.IN_Estado='1'
  GROUP BY ND.Pk_Id_Dupla";
  $sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_usuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getSistematizacionExistente($id_dupla, $mes){
  $sql="SELECT
  COUNT(*) AS 'Res'
  FROM tb_nidos_sistematizacion
  WHERE Fk_Id_Dupla=:id_dupla AND IN_Periodo=:mes";
  $sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_dupla',$id_dupla);
  @$sentencia->bindParam(':mes',$mes);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getInfoPlaneacion($id_sistematizacion){
  $sql="SELECT
  PK_Id_Sistematizacion,
  VC_Nombre_Experiencia,
  TX_Tema,
  TX_Materias,
  CASE
  WHEN IN_Periodo=1 THEN 'Enero'
  WHEN IN_Periodo=2 THEN 'Febrero'
  WHEN IN_Periodo=3 THEN 'Marzo'
  WHEN IN_Periodo=4 THEN 'Abril'
  WHEN IN_Periodo=5 THEN 'Mayo'
  WHEN IN_Periodo=6 THEN 'Junio'
  WHEN IN_Periodo=7 THEN 'Julio'
  WHEN IN_Periodo=8 THEN 'Agosto'
  WHEN IN_Periodo=9 THEN 'Septiembre'
  WHEN IN_Periodo=10 THEN 'Octubre'
  WHEN IN_Periodo=11 THEN 'Noviembre'
  WHEN IN_Periodo=12 THEN 'Diciembre'
  END AS 'mes',
  TX_Intencion_Artistica,
  TX_Referentes,
  TX_Aplicabilidad_Referentes,
  TX_Ambientacion,
  TX_Dispositivos,
  TX_Momentos,
  TX_Ninos_Ins,
  TX_Agentes_Ins,
  TX_Ninos_Fam,
  TX_Agentes_Fam,
  TX_Familias_Fam,
  TX_Mujeres_Fam,
  TX_Ninos_Com,
  TX_Familias_Com,
  TX_Aprendizajes_Creacion,
  TX_Aprendizajes_Personales,
  TX_Otros_Aspectos,
  TX_Banco_Imagenes,
  Fk_Id_Artista_Envio_Planeacion
  FROM tb_nidos_sistematizacion
  WHERE PK_Id_Sistematizacion=:id_sistematizacion";
  $sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_sistematizacion',$id_sistematizacion);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getArtistasDupla($id_usuario){
  $sql="SELECT
  P.PK_Id_Persona AS 'Id',
  CONCAT(P.VC_Primer_Nombre, ' ',P.VC_Primer_Apellido) AS 'Nombre',
  P.TX_Foto_Perfil AS 'Foto',
  DA.Fk_Id_Dupla AS 'IdDupla',
  DU.VC_Codigo_Dupla AS 'NombreDupla',
  T.Vc_Nom_Territorio AS 'Territorio',
  PE.PK_Id_Persona AS 'EAAT',
  CONCAT(UPPER(LEFT(PE.VC_Primer_Nombre, 1)), LOWER(SUBSTRING(PE.VC_Primer_Nombre, 2)), ' ', UPPER(LEFT(PE.VC_Primer_Apellido, 1)), LOWER(SUBSTRING(PE.VC_Primer_Apellido, 2))) AS 'Nombre_EAAT',
  CONCAT(UPPER(LEFT(PG.VC_Primer_Nombre, 1)), LOWER(SUBSTRING(PG.VC_Primer_Nombre, 2)), ' ', UPPER(LEFT(PG.VC_Primer_Apellido, 1)), LOWER(SUBSTRING(PG.VC_Primer_Apellido, 2))) AS 'Nombre_Gestor',
  T.Pk_Id_Territorio
  FROM tb_nidos_dupla_artista AS DA
  JOIN tb_nidos_dupla AS DU ON DU.Pk_Id_Dupla=DA.Fk_Id_Dupla
  JOIN tb_nidos_territorios AS T ON T.Pk_Id_Territorio=DU.Fk_Id_Territorio
  JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=DA.Fk_Id_Persona AND P.FK_Tipo_Persona='16'
  JOIN tb_persona_2017 AS PE ON PE.PK_Id_Persona=DU.Fk_Id_Eaat AND PE.FK_Tipo_Persona='22'
  LEFT JOIN tb_persona_2017 AS PG ON PG.PK_Id_Persona=DU.Fk_Id_Gestor AND PG.FK_Tipo_Persona='20'
  WHERE DA.Fk_Id_Dupla=(SELECT Fk_Id_Dupla FROM tb_nidos_dupla_artista WHERE Fk_Id_Persona=:id_usuario AND IN_Estado='1') AND DA.IN_Estado='1'";
  $sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_usuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getArtistasPDF($id_sistematizacion){
  $sql = "SELECT
  SA.Fk_Id_Artista,
  CONCAT(P.VC_Primer_Nombre, ' ',P.VC_Primer_Apellido) AS 'Nombre',
  P.TX_Foto_Perfil AS 'Foto',
  DU.VC_Codigo_Dupla AS 'NombreDupla',
  T.Vc_Nom_Territorio AS 'Territorio',
  CONCAT(UPPER(LEFT(PE.VC_Primer_Nombre, 1)), LOWER(SUBSTRING(PE.VC_Primer_Nombre, 2)), ' ', UPPER(LEFT(PE.VC_Primer_Apellido, 1)), LOWER(SUBSTRING(PE.VC_Primer_Apellido, 2))) AS 'Nombre_EAAT',
  CONCAT(UPPER(LEFT(PG.VC_Primer_Nombre, 1)), LOWER(SUBSTRING(PG.VC_Primer_Nombre, 2)), ' ', UPPER(LEFT(PG.VC_Primer_Apellido, 1)), LOWER(SUBSTRING(PG.VC_Primer_Apellido, 2))) AS 'Nombre_Gestor'
  FROM tb_nidos_sistematizacion_artista AS SA
  JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=SA.Fk_Id_Artista
  JOIN tb_nidos_sistematizacion AS S ON S.PK_Id_Sistematizacion=SA.Fk_Id_Sistematizacion
  JOIN tb_nidos_dupla AS DU ON DU.Pk_Id_Dupla=S.Fk_Id_Dupla
  JOIN tb_nidos_territorios AS T ON T.Pk_Id_Territorio=DU.Fk_Id_Territorio
  JOIN tb_persona_2017 AS PE ON PE.PK_Id_Persona=DU.Fk_Id_Eaat AND PE.FK_Tipo_Persona='22'
  LEFT JOIN tb_persona_2017 AS PG ON PG.PK_Id_Persona=DU.Fk_Id_Gestor AND PG.FK_Tipo_Persona='20'
  WHERE SA.Fk_Id_Sistematizacion=:id_sistematizacion";
  $sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_sistematizacion',$id_sistematizacion);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getSistematizacionesDupla($id_dupla, $id_usuario, $rol){
  if($rol == 16){
    $sql="SELECT DISTINCT
    S.PK_Id_Sistematizacion AS 'IdSistematizacion',
    S.VC_Nombre_Experiencia AS 'Experiencia',
    PD.VC_Descripcion AS 'Mes',
    CASE
    WHEN S.IN_Aprobacion_Planeacion = 0 THEN 'Sin terminar'
    WHEN S.IN_Aprobacion_Planeacion = 1 THEN 'Revisión pendiente'
    WHEN S.IN_Aprobacion_Planeacion = 2 THEN 'Revisado con observaciones'
    WHEN S.IN_Aprobacion_Planeacion = 3 THEN 'Corregido'
    WHEN S.IN_Aprobacion_Planeacion = 4 THEN 'Aprobado'
    END AS 'EstadoPlaneacion',
    CASE
    WHEN S.IN_Aprobacion_Sistematizacion = 0 THEN 'Sin terminar'
    WHEN S.IN_Aprobacion_Sistematizacion = 1 THEN 'Revisión pendiente'
    WHEN S.IN_Aprobacion_Sistematizacion = 2 THEN 'Revisado con observaciones'
    WHEN S.IN_Aprobacion_Sistematizacion = 3 THEN 'Corregido'
    WHEN S.IN_Aprobacion_Sistematizacion = 4 THEN 'Aprobado'
    END AS 'EstadoSistematizacion',
    SUBQUERY.TotalArtistas
    FROM tb_nidos_sistematizacion_artista AS SA
    JOIN tb_nidos_sistematizacion AS S ON S.PK_Id_Sistematizacion=SA.Fk_Id_Sistematizacion
    JOIN tb_parametro_detalle AS PD ON PD.FK_Value=S.IN_Periodo AND PD.FK_Id_Parametro=8 AND PD.IN_Estado=1,
    ( SELECT
    COUNT(DISTINCT(Fk_Id_Persona)) AS 'TotalArtistas'
    FROM tb_nidos_dupla_artista
    WHERE IN_Estado='1' AND Fk_Id_Dupla=:id_dupla
    GROUP BY Fk_Id_Dupla ) AS SUBQUERY
    WHERE SA.Fk_Id_Artista=:id_usuario";
  }else{
    $sql="SELECT
    S.PK_Id_Sistematizacion AS 'IdSistematizacion',
    S.VC_Nombre_Experiencia AS 'Experiencia',
    PD.VC_Descripcion AS 'Mes',
    CASE
    WHEN S.IN_Aprobacion_Planeacion = 0 THEN 'Sin terminar'
    WHEN S.IN_Aprobacion_Planeacion = 1 THEN 'Revisión pendiente'
    WHEN S.IN_Aprobacion_Planeacion = 2 THEN 'Revisado con observaciones'
    WHEN S.IN_Aprobacion_Planeacion = 3 THEN 'Corregido'
    WHEN S.IN_Aprobacion_Planeacion = 4 THEN 'Aprobado'
    END AS 'EstadoPlaneacion',
    CASE
    WHEN S.IN_Aprobacion_Sistematizacion = 0 THEN 'Sin terminar'
    WHEN S.IN_Aprobacion_Sistematizacion = 1 THEN 'Revisión pendiente'
    WHEN S.IN_Aprobacion_Sistematizacion = 2 THEN 'Revisado con observaciones'
    WHEN S.IN_Aprobacion_Sistematizacion = 3 THEN 'Corregido'
    WHEN S.IN_Aprobacion_Sistematizacion = 4 THEN 'Aprobado'
    END AS 'EstadoSistematizacion',
    SUBQUERY.TotalArtistas
    FROM tb_nidos_sistematizacion AS S
    JOIN tb_parametro_detalle AS PD ON PD.FK_Value=S.IN_Periodo AND PD.FK_Id_Parametro=8 AND PD.IN_Estado=1,
    (
    SELECT
    COUNT(DISTINCT(Fk_Id_Persona)) AS 'TotalArtistas'
    FROM tb_nidos_dupla_artista
    WHERE IN_Estado='1' AND Fk_Id_Dupla=:id_dupla
    GROUP BY Fk_Id_Dupla
    ) AS SUBQUERY
    WHERE S.Fk_Id_Dupla=:id_dupla";
  }
  $sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_dupla',$id_dupla);
  @$sentencia->bindParam(':id_usuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getOptionsDuplas($ids_territorios){
  $sql = "SELECT 
  ND.Pk_Id_Dupla,
  ND.VC_Codigo_Dupla AS 'Dupla'
  -- CONCAT(ND.VC_Codigo_Dupla, ' - ',GROUP_CONCAT(P.VC_Primer_Nombre,' ', P.VC_Primer_Apellido SEPARATOR ' Y ')) AS 'Dupla'
  FROM tb_nidos_dupla AS ND 
  JOIN tb_nidos_dupla_artista DA ON DA.Fk_Id_Dupla=ND.Pk_Id_Dupla AND DA.IN_Estado='1'
  JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=DA.Fk_Id_Persona
  WHERE ND.IN_Estado='1'";

  if($ids_territorios != 0)
    $sql .= " AND FIND_IN_SET (ND.Fk_Id_Territorio, :ids_territorios)";

  $sql .=" GROUP BY ND.Pk_Id_Dupla";

  $sentencia=$this->dbPDO->prepare($sql);

  if($ids_territorios != 0)
    @$sentencia->bindParam(':ids_territorios',$ids_territorios);

  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getInformacionSistematizacion($ids_territorios, $ids_duplas, $ids_campos, $ids_meses){
  $sql="SELECT
  D.VC_Codigo_Dupla AS 'Dupla',
  CASE
  WHEN S.IN_Periodo=1 THEN 'Enero'
  WHEN S.IN_Periodo=2 THEN 'Febrero'
  WHEN S.IN_Periodo=3 THEN 'Marzo'
  WHEN S.IN_Periodo=4 THEN 'Abril'
  WHEN S.IN_Periodo=5 THEN 'Mayo'
  WHEN S.IN_Periodo=6 THEN 'Junio'
  WHEN S.IN_Periodo=7 THEN 'Julio'
  WHEN S.IN_Periodo=8 THEN 'Agosto'
  WHEN S.IN_Periodo=9 THEN 'Septiembre'
  WHEN S.IN_Periodo=10 THEN 'Octubre'
  WHEN S.IN_Periodo=11 THEN 'Noviembre'
  WHEN S.IN_Periodo=12 THEN 'Diciembre'
  END AS 'Mes',
  CONCAT(P.VC_Primer_Nombre,' ', P.VC_Primer_Apellido) AS 'EAAT',
  ".$ids_campos."
  FROM tb_nidos_sistematizacion AS S
  JOIN tb_nidos_dupla AS D on D.Pk_Id_Dupla=S.Fk_Id_Dupla AND D.IN_Estado='1'
  JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=S.FK_Id_Eaat_Aprobo";

  if($ids_duplas != "" || $ids_meses != "" || $ids_territorios != "")
    $sql .= " WHERE S.IN_Aprobacion_Sistematizacion='4' AND";

  if($ids_territorios != "")
    $sql .= " FIND_IN_SET(D.Fk_Id_Territorio, :ids_territorios) AND";

  if($ids_meses != "")
    $sql .= " FIND_IN_SET(S.IN_Periodo, :ids_meses) AND";

  if($ids_duplas != "")
    $sql .= " FIND_IN_SET(S.Fk_Id_Dupla, :ids_duplas) AND";

  if($ids_duplas != "" || $ids_meses != "" || $ids_territorios != "")
    $sql = substr($sql, 0,-3);

  $sentencia=$this->dbPDO->prepare($sql);
  
  if($ids_territorios != "")
    @$sentencia->bindParam(':ids_territorios',$ids_territorios);

  if($ids_meses != "")
    @$sentencia->bindParam(':ids_meses',$ids_meses);

  if($ids_duplas != "")
    @$sentencia->bindParam(':ids_duplas',$ids_duplas);

  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

}

public function getSistematizaciones($ids_territorios, $ids_duplas, $ids_meses){
  /*$subsql = "SELECT
  ND.Pk_Id_Dupla AS 'ID',
  CONCAT(ND.VC_Codigo_Dupla) AS 'Dupla',
  -- CONCAT(ND.VC_Codigo_Dupla, ' - ',GROUP_CONCAT(P.VC_Primer_Nombre,' ', P.VC_Primer_Apellido SEPARATOR ' Y ')) AS 'Dupla',
  CONCAT(PE.VC_Primer_Nombre,' ', PE.VC_Primer_Apellido) AS 'EAAT',
  COUNT(DISTINCT(DA.Fk_Id_Persona)) AS 'TotalArtistas'
  FROM tb_nidos_dupla AS ND 
  JOIN tb_nidos_dupla_artista DA ON DA.Fk_Id_Dupla=ND.Pk_Id_Dupla
  JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=DA.Fk_Id_Persona
  JOIN tb_persona_2017 AS PE ON PE.PK_Id_Persona=ND.FK_Id_Eaat
  WHERE ND.IN_Estado='1' AND DA.IN_Estado='1'";

  if($ids_territorios != "")
    $subsql .= " AND FIND_IN_SET(ND.Fk_Id_Territorio, :ids_territorios)";

  if($ids_duplas != "")
    $subsql .= " AND FIND_IN_SET(ND.Pk_Id_Dupla, :ids_duplas)";

  $subsql .= " GROUP BY ND.Pk_Id_Dupla";

  $sql="SELECT
  S.PK_Id_Sistematizacion,
  ARTISTAS.Dupla,
  CASE
  WHEN S.IN_Periodo=1 THEN 'Enero'
  WHEN S.IN_Periodo=2 THEN 'Febrero'
  WHEN S.IN_Periodo=3 THEN 'Marzo'
  WHEN S.IN_Periodo=4 THEN 'Abril'
  WHEN S.IN_Periodo=5 THEN 'Mayo'
  WHEN S.IN_Periodo=6 THEN 'Junio'
  WHEN S.IN_Periodo=7 THEN 'Julio'
  WHEN S.IN_Periodo=8 THEN 'Agosto'
  WHEN S.IN_Periodo=9 THEN 'Septiembre'
  WHEN S.IN_Periodo=10 THEN 'Octubre'
  WHEN S.IN_Periodo=11 THEN 'Noviembre'
  WHEN S.IN_Periodo=12 THEN 'Diciembre'
  END AS Mes,
  ARTISTAS.EAAT,
  S.IN_Aprobacion_Planeacion,
  S.IN_Aprobacion_Sistematizacion,
  ARTISTAS.TotalArtistas
  FROM tb_nidos_sistematizacion AS S,
  (".$subsql."
  ) AS ARTISTAS
  WHERE S.Fk_Id_Dupla=ARTISTAS.ID AND S.IN_Aprobacion_Planeacion='4'";


  if($ids_meses != "")
  $sql .= " AND FIND_IN_SET(S.IN_Periodo, :ids_meses)";*/

  ///////////////////////sql para obtener información desde tabla sistematización artista//////////////////////////////

  $sql = "SELECT
  S.PK_Id_Sistematizacion,
  CONCAT(ND.VC_Codigo_Dupla, ' - ',GROUP_CONCAT(P.VC_Primer_Nombre,' ', P.VC_Primer_Apellido  ORDER BY P.VC_Primer_Nombre SEPARATOR ' Y ')) AS 'Dupla',
  CASE
  WHEN S.IN_Periodo=1 THEN 'Enero'
  WHEN S.IN_Periodo=2 THEN 'Febrero'
  WHEN S.IN_Periodo=3 THEN 'Marzo'
  WHEN S.IN_Periodo=4 THEN 'Abril'
  WHEN S.IN_Periodo=5 THEN 'Mayo'
  WHEN S.IN_Periodo=6 THEN 'Junio'
  WHEN S.IN_Periodo=7 THEN 'Julio'
  WHEN S.IN_Periodo=8 THEN 'Agosto'
  WHEN S.IN_Periodo=9 THEN 'Septiembre'
  WHEN S.IN_Periodo=10 THEN 'Octubre'
  WHEN S.IN_Periodo=11 THEN 'Noviembre'
  WHEN S.IN_Periodo=12 THEN 'Diciembre'
  END AS Mes,
  CONCAT(PE.VC_Primer_Nombre,' ', PE.VC_Primer_Apellido) AS 'EAAT',
  S.IN_Aprobacion_Planeacion,
  S.IN_Aprobacion_Sistematizacion,
  COUNT(DISTINCT(SA.Fk_Id_Artista)) AS 'TotalArtistas'
  FROM tb_nidos_sistematizacion_artista AS SA
  JOIN tb_nidos_sistematizacion AS S ON S.PK_Id_Sistematizacion=SA.Fk_Id_Sistematizacion
  JOIN tb_nidos_dupla AS ND ON ND.Pk_Id_Dupla=S.Fk_Id_Dupla
  JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=SA.Fk_Id_Artista
  JOIN tb_persona_2017 AS PE ON PE.PK_Id_Persona=ND.FK_Id_Eaat
  WHERE ND.IN_Estado='1'";

  if($ids_meses != "")
    $sql .= " AND FIND_IN_SET(S.IN_Periodo, :ids_meses)";

  if($ids_territorios != "")
    $sql .= " AND FIND_IN_SET(ND.Fk_Id_Territorio, :ids_territorios)";

  if($ids_duplas != "")
    $sql .= " AND FIND_IN_SET(ND.Pk_Id_Dupla, :ids_duplas)";

  $sql .= " GROUP BY S.PK_Id_Sistematizacion";

  $sentencia=$this->dbPDO->prepare($sql);

  if($ids_territorios != "")
    @$sentencia->bindParam(':ids_territorios',$ids_territorios);

  if($ids_duplas != "")
    @$sentencia->bindParam(':ids_duplas',$ids_duplas);

  if($ids_meses != "")
    @$sentencia->bindParam(':ids_meses',$ids_meses);

  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

}

public function getBancoImagenes($id_sistematizacion){
  $sql="SELECT TX_Banco_Imagenes FROM tb_nidos_sistematizacion WHERE PK_Id_Sistematizacion=:id_sistematizacion";
  $sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_sistematizacion',$id_sistematizacion);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function updateImages($id_sistematizacion, $json_images){
  $sql="UPDATE tb_nidos_sistematizacion SET TX_Banco_Imagenes=:json_images WHERE PK_Id_Sistematizacion=:id_sistematizacion";
  $sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_sistematizacion',$id_sistematizacion);
  @$sentencia->bindParam(':json_images',$json_images);
  $sentencia->execute();
  return $sentencia->rowCount();
}

}
