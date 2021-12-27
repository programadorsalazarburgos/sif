<?php 

namespace General\Persistencia\DAOS;
class NidosBeneficiariosDAO extends GestionDAO {

  private $db;

  function __construct()
  {
    $this->db=$this->obtenerBD();
    $this->dbPDO=$this->obtenerPDOBD();
  }

  public function crearBeneficiario($objeto) {

    $sql="INSERT INTO tb_nidos_beneficiarios (VC_Identificacion,FK_Tipo_Identificacion,VC_Primer_Nombre,VC_Segundo_Nombre,VC_Primer_Apellido,VC_Segundo_Apellido,DD_F_Nacimiento,FK_Id_Genero,IN_Grupo_Poblacional,IN_Estrato,VC_Uso_Imagen,Fk_Id_Usuario_Registra,DT_Fecha_Registro, VC_Observacion)
    VALUES (:identificacion, :tidentifi, :pnombre, :snombre, :papellido, :sapellido, :fnacimiento, :genero, :etnia, :estrato, :usoimagen, :idusuario, :fechacreacion, :observacion)";
    @$sentencia=$this->dbPDO->prepare($sql);

    @$sentencia->bindParam(':identificacion',$objeto->getVcIdentificacion());
    @$sentencia->bindParam(':tidentifi',$objeto->getFkTipoIdentificacion());
    @$sentencia->bindParam(':pnombre',$objeto->getVcPrimerNombre());
    @$sentencia->bindParam(':snombre',$objeto->getVcSegundoNombre());
    @$sentencia->bindParam(':papellido',$objeto->getVcPrimerApellido());
    @$sentencia->bindParam(':sapellido',$objeto->getVcSegundoApellido());
    @$sentencia->bindParam(':fnacimiento',$objeto->getDdFNacimiento());
    @$sentencia->bindParam(':genero',$objeto->getFkIdGenero());
    @$sentencia->bindParam(':etnia',$objeto->getInGrupoPoblacional());
    @$sentencia->bindParam(':estrato',$objeto->getInIdentificacionPoblacional());
    @$sentencia->bindParam(':usoimagen',$objeto->getVcUsoImagen());
    @$sentencia->bindParam(':idusuario',$objeto->getFkIdUsuarioRegistra());
    @$sentencia->bindParam(':fechacreacion',$objeto->getDtFechaRegistro());
    @$sentencia->bindParam(':observacion',$objeto->getVcObservacion());

    $sentencia->execute();

    return $sentencia->rowCount();
  }

  public function modificarBeneficiario($objeto) {

    $sql="UPDATE tb_nidos_beneficiarios SET FK_Tipo_Identificacion= :tidentifi, VC_Primer_Nombre= :pnombre, VC_Segundo_Nombre= :snombre, VC_Primer_Apellido= :papellido, VC_Segundo_Apellido= :sapellido, DD_F_Nacimiento= :fnacimiento, FK_Id_Genero= :genero, IN_Grupo_Poblacional= :etnia, IN_Estrato= :estrato, VC_Uso_Imagen= :usoimagen WHERE VC_Identificacion = :identificacion;";
        //$sql="UPDATE tb_nidos_beneficiarios SET FK_Tipo_Identificacion= :tidentifi, VC_Primer_Nombre= :pnombre, VC_Segundo_Nombre= :snombre, VC_Primer_Apellido= :papellido, VC_Segundo_Apellido= :sapellido, DD_F_Nacimiento= :fnacimiento, FK_Id_Genero= :genero, IN_Grupo_Poblacional= :etnia, IN_Estrato= :estrato, Fk_Id_Usuario_Registra= :idusuario, DT_Fecha_Registro= :fechacreacion WHERE VC_Identificacion = :identificacion;";
    @$sentencia=$this->dbPDO->prepare($sql);

    @$sentencia->bindParam(':identificacion',$objeto->getVcIdentificacion());
    @$sentencia->bindParam(':tidentifi',$objeto->getFkTipoIdentificacion());
    @$sentencia->bindParam(':pnombre',$objeto->getVcPrimerNombre());
    @$sentencia->bindParam(':snombre',$objeto->getVcSegundoNombre());
    @$sentencia->bindParam(':papellido',$objeto->getVcPrimerApellido());
    @$sentencia->bindParam(':sapellido',$objeto->getVcSegundoApellido());
    @$sentencia->bindParam(':fnacimiento',$objeto->getDdFNacimiento());
    @$sentencia->bindParam(':genero',$objeto->getFkIdGenero());
    @$sentencia->bindParam(':etnia',$objeto->getInGrupoPoblacional());
    @$sentencia->bindParam(':estrato',$objeto->getInIdentificacionPoblacional());
    @$sentencia->bindParam(':usoimagen',$objeto->getVcUsoImagen());
        //@$sentencia->bindParam(':fechacreacion',$objeto->getDtFechaRegistro());

    $sentencia->execute();

    return $sentencia->rowCount();
  }
  public function BeneficiarioGrupo($objeto) {

    $ninos = explode(";", $objeto->getFkIdBeneficiario());
    for ($i=0; $i < count($ninos)-1; $i++) {

      $sqlSelect="SELECT
        *
      FROM tb_nidos_beneficiario_grupo TBG
      JOIN tb_nidos_beneficiarios AS B ON B.Pk_Id_Beneficiario=TBG.Fk_Id_Beneficiario
      WHERE TBG.Fk_Id_Grupo = :id_grupo AND B.VC_Identificacion = :beneficiario";
      $sentenciaa=$this->dbPDO->prepare($sqlSelect);
      @$sentenciaa->bindParam(':id_grupo',$objeto->getFkIdGrupo());
      @$sentenciaa->bindParam(':beneficiario',$ninos[$i]);
      $sentenciaa->execute();
      $result = $sentenciaa->fetchAll(\PDO::FETCH_ASSOC);

      $sql = "INSERT INTO tb_nidos_beneficiario_grupo (Fk_Id_Grupo,Fk_Id_Beneficiario,Dt_Fecha_Ingreso,Fk_Usuario_Ingreso, IN_Estado) VALUES (:id_grupo, (SELECT Pk_Id_Beneficiario FROM tb_nidos_beneficiarios WHERE VC_Identificacion = :beneficiario), :fecha_ingreso, :usuario, :Estado)";
      @$sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':id_grupo',$objeto->getFkIdGrupo());
      @$sentencia->bindParam(':beneficiario',$ninos[$i]);
      @$sentencia->bindParam(':fecha_ingreso',$objeto->getDtFechaIngreso());
      @$sentencia->bindParam(':usuario',$objeto->getFkUsuarioIngreso());
      @$sentencia->bindParam(':Estado',$objeto->getInEstado());
      if (sizeof($result) == 0)
        $sentencia->execute();
    }
    return $sentencia->rowCount();


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
  WHERE DA.Fk_Id_Persona=:id_usuario AND G.IN_Estado = '1' AND Fk_Id_Lugar_Atencion=:id_lugar";
  $sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_usuario',$id_usuario);
  @$sentencia->bindParam(':id_lugar',$id_lugar);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function obtenerTipoDocuemnto(){
  $sql="SELECT FK_Value, VC_Descripcion FROM tb_parametro_detalle WHERE FK_Id_Parametro = 5 AND IN_Estado_Nidos = 1 ORDER BY VC_Descripcion";
  $sentencia=$this->dbPDO->prepare($sql);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function obtenerGenero(){
  $sql="SELECT FK_Value, VC_Descripcion FROM tb_parametro_detalle WHERE FK_Id_Parametro = '17' AND IN_Estado_Nidos='1'";
  $sentencia=$this->dbPDO->prepare($sql);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function obtenerEtnia(){
  $sql="SELECT FK_Value, VC_Descripcion FROM tb_parametro_detalle WHERE FK_Id_Parametro = 14 AND IN_Estado_Nidos = 1 ORDER BY VC_Descripcion";
  $sentencia=$this->dbPDO->prepare($sql);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultarEncabezado($idGrupo){
  $sql="SELECT ND.Pk_Id_Grupo, TL.Vc_Descripcion, ND.VC_Nombre_Grupo, ND.VC_Profesional_Responsable, DU.VC_Codigo_Dupla, ES.Vc_Estrategia,
  (SELECT GROUP_CONCAT(CONCAT(' ',PER.VC_Primer_Nombre,' ',PER.VC_Primer_Apellido,' ') )
  FROM tb_nidos_dupla_artista DA, tb_persona_2017 PER
  WHERE DA.Fk_Id_Dupla = DU.Pk_Id_Dupla AND DA.Fk_Id_Persona = PER.PK_Id_Persona)  AS 'ARTISTAS',
  LA.Pk_Id_lugar_atencion,
  LA.Fk_Id_Entidad
  FROM tb_nidos_grupos AS ND
  JOIN tb_nidos_lugar_atencion AS LA ON ND.FK_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
  JOIN tb_nidos_estrategia AS ES ON  ND.FK_Id_Estrategia_Atencion = ES.Pk_Id_Estrategia
  JOIN tb_nidos_tipo_lugar AS TL ON LA.VC_Tipo_Lugar = TL.PK_Id_Lugar
  JOIN tb_nidos_dupla  AS DU ON ND.Fk_Id_Dupla = DU.Pk_Id_Dupla
  WHERE Pk_Id_Grupo = :IdGrupo";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':IdGrupo',$idGrupo);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}


public function consultarBeneficiario($Usuario){
  $sql="SELECT Pk_Id_Beneficiario, FK_Tipo_Identificacion, VC_Primer_Nombre, VC_Segundo_Nombre, VC_Primer_Apellido, VC_Segundo_Apellido, DD_F_Nacimiento, FK_Id_Genero,
  IN_Grupo_Poblacional, IN_Estrato FROM tb_nidos_beneficiarios WHERE VC_Identificacion = :Identificacion";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':Identificacion',$Usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultarBeneficiarioGrupo($idGrupoC) {
  $sql="SELECT DISTINCT(NB.Pk_Id_Beneficiario),
  NB.VC_Identificacion,
  CONCAT(NB.VC_Primer_Apellido,' ',NB.VC_Segundo_Apellido,' ', NB.VC_Primer_Nombre,' ',NB.VC_Segundo_Nombre) AS 'Beneficiario',
  NB.DD_F_Nacimiento,
  PG.VC_Descripcion AS GENERO,
  PE.VC_Descripcion AS ETNIA,
  NB.IN_Estrato,
  BG.Pk_Id_Benefi_Grupo,
  BG.IN_Estado,
  GR.VC_Nombre_Grupo
  FROM tb_nidos_beneficiarios AS NB
  JOIN tb_nidos_beneficiario_grupo AS BG  ON NB.Pk_Id_Beneficiario = BG.Fk_Id_Beneficiario
  JOIN tb_nidos_grupos AS GR ON BG.Fk_Id_Grupo = GR.Pk_Id_Grupo
  JOIN tb_parametro_detalle AS PG ON NB.FK_Id_Genero = PG.FK_Value AND PG.FK_Id_Parametro = 17
  JOIN tb_parametro_detalle AS PE ON NB.IN_Grupo_Poblacional = PE.FK_Value AND PE.FK_Id_Parametro = 14
  WHERE BG.Fk_Id_Grupo = :grupoc";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':grupoc',$idGrupoC);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function InactivarBeneficiarioObjeto($objeto) {
  $sql="UPDATE tb_nidos_beneficiario_grupo SET Dt_Fecha_Retiro = :FechaRetiro, Fk_Usuario_Retiro = :UsuarioRetiro, IN_Estado = :Estado, VC_Observaciones = :Observaciones WHERE Pk_Id_Benefi_Grupo = :idBeneficiario";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':idBeneficiario',$objeto->getPkIdBenefiGrupo());
  @$sentencia->bindParam(':FechaRetiro',$objeto->getDtFechaRetiro());
  @$sentencia->bindParam(':UsuarioRetiro',$objeto->getFkUsuarioRetiro());
  @$sentencia->bindParam(':Estado',$objeto->getInEstado());
  @$sentencia->bindParam(':Observaciones',$objeto->getVcObservaciones());
  $sentencia->execute();
  return $sentencia->rowCount();
}

public function ActivarBeneficiarioObjeto($objeto) {
 $sql="UPDATE tb_nidos_beneficiario_grupo SET IN_Estado = :Estado WHERE Pk_Id_Benefi_Grupo = :idBeneficiario";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':idBeneficiario',$objeto->getPkIdBenefiGrupo());
 @$sentencia->bindParam(':Estado',$objeto->getInEstado());
 $sentencia->execute();
 return $sentencia->rowCount();
}

public function consultarDatosBasicosBeneficiarios($dato_beneficiario){
  $sql="SELECT
  Pk_Id_Beneficiario,
  VC_Identificacion,
  CONCAT(VC_Primer_Apellido, ' ' ,VC_Segundo_Apellido, ' ' ,VC_Primer_Nombre, ' ' , VC_Segundo_Nombre) AS 'Nombre',
  VC_Uso_Imagen
  FROM tb_nidos_beneficiarios WHERE VC_Identificacion LIKE :dato_beneficiario
  OR VC_Primer_Apellido LIKE :dato_beneficiario
  OR VC_Segundo_Apellido LIKE :dato_beneficiario
  OR VC_Primer_Nombre LIKE :dato_beneficiario
  OR VC_Segundo_Nombre LIKE :dato_beneficiario
  OR CONCAT(VC_Primer_Apellido, ' ' ,VC_Segundo_Apellido, ' ' ,VC_Primer_Nombre, ' ' , VC_Segundo_Nombre) LIKE :dato_beneficiario
  OR CONCAT(VC_Primer_Nombre, ' ' , VC_Segundo_Nombre, ' ' , VC_Primer_Apellido, ' ' ,VC_Segundo_Apellido) LIKE :dato_beneficiario
  OR CONCAT(VC_Primer_Apellido, ' ' ,VC_Primer_Nombre, ' ' ,VC_Segundo_Nombre, ' ' , VC_Segundo_Apellido) LIKE :dato_beneficiario
  OR CONCAT(VC_Segundo_Nombre, ' ' , VC_Segundo_Apellido, ' ' ,VC_Primer_Nombre, ' ' ,VC_Primer_Apellido) LIKE :dato_beneficiario
  OR CONCAT(VC_Segundo_Apellido, ' ' ,VC_Segundo_Nombre, ' ' ,VC_Primer_Nombre, ' ' ,VC_Primer_Apellido) LIKE :dato_beneficiario
  OR CONCAT(VC_Primer_Apellido, ' ' ,VC_Segundo_Nombre, ' ' ,VC_Segundo_Apellido, ' ' ,VC_Primer_Nombre) LIKE :dato_beneficiario
  OR CONCAT( VC_Primer_Nombre, ' ' ,VC_Segundo_Apellido, ' ' ,VC_Segundo_Nombre, ' ' ,VC_Primer_Apellido) LIKE :dato_beneficiario";
  @$sentencia=$this->dbPDO->prepare($sql);
  $datos_beneficiarios = '%'.$dato_beneficiario.'%';
  @$sentencia->bindParam(':dato_beneficiario',$datos_beneficiarios);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultarGruposBeneficiario($id_beneficiario){
  $sql= "SELECT
  NA.Fk_Id_Beneficiario AS 'BENEFICIARIO',
  PDL.VC_Descripcion AS 'LOCALIDAD',
  LU.VC_Nombre_Lugar AS 'LUGAR', 
  GR.VC_Nombre_Grupo AS 'GRUPO', 
  (CASE WHEN PDG.VC_Descripcion IS NULL THEN 'SIN INFORMACIÓN' WHEN PDG.VC_Descripcion IS NOT NULL THEN PDG.VC_Descripcion END) AS 'TIPO_GRUPO', 
  DU.VC_Codigo_Dupla AS 'DUPLA', 
  DATE_FORMAT(EX.DT_Fecha_Encuentro, '%d/%m/%Y') AS 'FECHA', 
  (CASE WHEN NA.Vc_Asistencia='1' THEN 'ASISTIÓ' WHEN NA.Vc_Asistencia='0' THEN 'NO ASISTIÓ' END) AS 'ASISTENCIA'  
  FROM tb_nidos_asistencia AS NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
  JOIN tb_nidos_lugar_atencion AS LU ON EX.Fk_Id_Lugar_Atencion = LU.Pk_Id_Lugar_Atencion
  JOIN tb_parametro_detalle AS PDL ON LU.Fk_Id_Localidad = PDL.FK_Value AND PDL.FK_Id_Parametro = '19'
  LEFT JOIN tb_parametro_detalle AS PDG ON GR.Fk_Id_Tipo_Grupo = PDG.FK_Value AND PDG.FK_Id_Parametro = '45'
  WHERE Fk_Id_Beneficiario = :id_beneficiario

  UNION

  SELECT
  NA.Fk_Id_Beneficiario AS 'BENEFICIARIO',
  (SELECT
  GROUP_CONCAT(l.VC_Nom_Localidad)
  FROM tb_nidos_lugar_atencion la
  JOIN tb_localidades l ON l.Pk_Id_Localidad=la.Fk_Id_Localidad  
  WHERE FIND_IN_SET(la.Pk_Id_lugar_atencion,  EC.VC_Lugar_Atencion)) AS 'LOCALIDAD',
  (SELECT
  GROUP_CONCAT(la.VC_Nombre_Lugar)
  FROM tb_nidos_lugar_atencion la  
  WHERE FIND_IN_SET(la.Pk_Id_lugar_atencion,  EC.VC_Lugar_Atencion)) AS 'LUGAR',
  EC.VC_Nombre_Evento AS 'GRUPO',
  'No aplica' AS 'TIPO_GRUPO',
  (SELECT GROUP_CONCAT(CONCAT(' ',DU.VC_Codigo_Dupla,' ') SEPARATOR 'Y'  )  
  FROM tb_nidos_dupla DU  
  WHERE FIND_IN_SET(DU.Pk_Id_Dupla, EC.IN_Cantidad_Equipos) > 0)  AS 'DUPLA',
  DATE_FORMAT(EC.DT_Fecha_Evento, '%d/%m/%Y') AS 'FECHA',
  'ASISTIÓ' AS 'ASISTENCIA'
  FROM tb_nidos_evento_circulacion EC
  LEFT JOIN tb_nidos_asistencia AS NA ON NA.Fk_Id_Evento=EC.Pk_Id_Evento
  WHERE Fk_Id_Beneficiario = :id_beneficiario";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_beneficiario',$id_beneficiario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function subirUsoImagen($objeto){
  $sql="UPDATE tb_nidos_beneficiarios SET VC_Uso_Imagen=:url WHERE VC_Identificacion=:id_beneficiario";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_beneficiario',$objeto->getVcIdentificacion());
  @$sentencia->bindParam(':url',$objeto->getVcUsoImagen());
  $sentencia->execute();
  return $sentencia->rowCount();
}

public function borrarArchivo($id_beneficiario){
  $sql="UPDATE tb_nidos_beneficiarios SET VC_Uso_Imagen=null WHERE VC_Identificacion=:id_beneficiario";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':id_beneficiario',$id_beneficiario);
  $sentencia->execute();
  return $sentencia->rowCount();
}

public function cargarUsoDatosManual($objeto) {

  $sql="UPDATE tb_nidos_beneficiarios SET VC_Uso_Imagen = :AutorizacionDatos WHERE VC_Identificacion = :identificacion;";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':identificacion',$objeto->getVcIdentificacion());
  @$sentencia->bindParam(':AutorizacionDatos',$objeto->getVcUsoImagen());
  $sentencia->execute();
  return $sentencia->rowCount();
}

public function getBeneficiariosDocumentoProvisional(){ 
  $sql="SELECT EX.Pk_Id_Beneficiario AS 'ID',
  EX.VC_Identificacion AS 'IDENTIFICACION',
  'DOCUMENTO PROVISIONAL' AS 'TIPO',
  CONCAT(EX.VC_Primer_Nombre,' ',EX.VC_Segundo_Nombre,' ',EX.VC_Primer_Apellido,' ',EX.VC_Segundo_Apellido) AS 'BENEFICIARIO',
  EX.DD_F_Nacimiento AS 'FECHANACIMIENTO',
  (CASE WHEN EX.FK_Id_Genero = '1' THEN 'MASCULINO' WHEN EX.FK_Id_Genero = '2' THEN 'FEMENINO' END) AS 'GENERO',
  PD.VC_Descripcion AS 'ENFOQUE'
  FROM tb_nidos_beneficiarios AS EX
  JOIN tb_parametro_detalle AS PD ON EX.IN_Grupo_Poblacional = PD.FK_Value AND PD.FK_Id_Parametro = 14
  WHERE EX.FK_Tipo_Identificacion = 8";
  @$sentencia=$this->dbPDO->prepare($sql);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

}
