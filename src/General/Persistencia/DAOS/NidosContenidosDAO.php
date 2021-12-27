<?php 

namespace General\Persistencia\DAOS;

class NidosContenidosDAO extends GestionDAO {

  private $db;

  function __construct() {
    $this->db=$this->obtenerBD();
    $this->dbPDO=$this->obtenerPDOBD();
  }

  public function crearObjeto($objeto) { return; }

  public function modificarObjeto($objeto) { return; }

  public function eliminarObjeto($objeto) { return; }

  public function consultarObjeto($objeto) { return; }

  public function guardarBeneficiariosSinInfo($objeto){

    $sql = "INSERT INTO tb_nidos_sin_informacion_contenidos (IN_Total_Beneficiarios, IN_Total_Ninos, IN_Total_Ninas, IN_Total_Ninos_0_3, IN_Total_Ninos_3_6, IN_Total_Ninas_0_3, IN_Total_Ninas_3_6, IN_Mujeres_Gestantes, IN_Afrodescendiente, IN_Campesina, IN_Discapacidad, IN_Conflicto, IN_Indigena, IN_Privados, IN_Victimas, IN_Raizal, IN_Rom, Fk_Id_Lugar_Atencion, Fk_Id_Grupo, VC_Contenido, DT_Fecha_Entrega, VC_Documento_Soporte, Fk_Id_Usuario_Registro, DT_Fecha_Registro) VALUES (:total, :ninos, :ninas, :ninos_cero_tres, :ninos_tres_seis, :ninas_cero_tres, :ninas_tres_seis, :mujeres, :afro, :rural, :discapacidad, :conflicto, :indigena, :libertad, :violencia, :raizal, :rom, :lugar_atencion, :grupo, :contenido, :fecha_entrega, :ruta_archivo, :id_usuario, :fecha_registro)";

    @$sentencia=$this->dbPDO->prepare($sql);

    @$sentencia->bindParam(':total', $objeto->getInTotalBeneficiarios());
    @$sentencia->bindParam(':ninos', $objeto->getInTotalNinos());
    @$sentencia->bindParam(':ninas', $objeto->getInTotalNinas());
    @$sentencia->bindParam(':ninos_cero_tres', $objeto->getInTotalNinos03());
    @$sentencia->bindParam(':ninos_tres_seis', $objeto->getInTotalNinos36());
    @$sentencia->bindParam(':ninas_cero_tres', $objeto->getInTotalNinas03());
    @$sentencia->bindParam(':ninas_tres_seis', $objeto->getInTotalNinas36());
    @$sentencia->bindParam(':mujeres', $objeto->getInMujeresGestantes());
    @$sentencia->bindParam(':afro', $objeto->getInAfrodescendiente());
    @$sentencia->bindParam(':rural', $objeto->getInCampesina());
    @$sentencia->bindParam(':discapacidad', $objeto->getInDiscapacidad());
    @$sentencia->bindParam(':conflicto', $objeto->getInConflicto());
    @$sentencia->bindParam(':indigena', $objeto->getInIndigena());
    @$sentencia->bindParam(':libertad', $objeto->getInPrivados());
    @$sentencia->bindParam(':violencia', $objeto->getInVictimas());
    @$sentencia->bindParam(':raizal', $objeto->getInRaizal());
    @$sentencia->bindParam(':rom', $objeto->getInRom());
    @$sentencia->bindParam(':lugar_atencion', $objeto->getFkIdLugarAtencion());
    @$sentencia->bindParam(':grupo', $objeto->getFkIdGrupo());
    @$sentencia->bindParam(':contenido', $objeto->getVcContenido());
    @$sentencia->bindParam(':fecha_entrega', $objeto->getDtFechaEntrega());
    @$sentencia->bindParam(':ruta_archivo', $objeto->getVcDocumentoSoporte());
    @$sentencia->bindParam(':id_usuario', $objeto->getFkIdUsuarioRegistro());
    @$sentencia->bindParam(':fecha_registro', $objeto->getDtFechaRegistro());

    $sentencia->execute();

    return $sentencia->rowCount();
  }

  public function getBeneficiariosSinInfo($mes){
    $sql = "SELECT
    GROUP_CONCAT(co.VC_Nombre_Contenido ORDER BY co.VC_Nombre_Contenido DESC SEPARATOR ', ') AS 'VC_Contenido',
    DATE_FORMAT(c.DT_Fecha_Entrega, '%d/%m/%Y') AS 'DT_Fecha_Entrega',
    l.VC_Nom_Localidad,
    CONCAT(u.IN_Codigo_Upz, '. ', u.VC_Nombre_Upz) as 'VC_Nombre_Upz',
    la.VC_Nombre_Lugar,
    e.Vc_Abreviatura,
    la.VC_Barrio,
    g.VC_Nombre_Grupo,
    c.IN_Total_Beneficiarios,
    c.IN_Total_Ninos,
    c.IN_Total_Ninas,
    c.IN_Total_Ninos_0_3,
    c.IN_Total_Ninos_3_6,
    c.IN_Total_Ninas_0_3,
    c.IN_Total_Ninas_3_6,
    c.IN_Mujeres_Gestantes,
    c.IN_Afrodescendiente,
    c.IN_Campesina,
    c.IN_Discapacidad,
    c.IN_Conflicto,
    c.IN_Indigena,
    c.IN_Privados,
    c.IN_Victimas,
    c.IN_Raizal,
    c.IN_Rom,
    c.VC_Documento_Soporte
    FROM tb_nidos_sin_informacion_contenidos c
    JOIN tb_nidos_lugar_atencion la ON la.Pk_Id_lugar_atencion=c.Fk_Id_Lugar_Atencion
    JOIN tb_nidos_grupos g ON g.Pk_Id_Grupo=c.Fk_Id_Grupo  
    JOIN tb_localidades l ON l.Pk_Id_Localidad=la.Fk_Id_Localidad
    JOIN tb_upz u ON u.Pk_Id_Upz=la.Fk_Id_Upz
    JOIN tb_nidos_entidades e ON e.Pk_Id_Entidad=la.Fk_Id_Entidad
    JOIN tb_nidos_contenido co ON FIND_IN_SET(co.PK_Id_Contenido, c.VC_Contenido)
    WHERE MONTH(DT_Fecha_Entrega)=:mes
    GROUP BY c.Pk_Id_Registro_Contenido";

    $sentencia=$this->dbPDO->prepare($sql);

    @$sentencia->bindParam(':mes',$mes);
    $sentencia->execute();

    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getCategoriaContenido(){
    $sql = "SELECT * FROM tb_nidos_categoria_contenido ORDER BY UPPER(VC_Nombre_Categoria_Contenido) ASC";

    $sentencia=$this->dbPDO->prepare($sql);
    $sentencia->execute();

    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getContenidosCategoria($id_categoria){
    $sql = "SELECT * FROM tb_nidos_contenido WHERE FK_Id_Categoria_Contenido=:id_categoria ORDER BY UPPER(VC_Nombre_Contenido) ASC";

    $sentencia=$this->dbPDO->prepare($sql);

    @$sentencia->bindParam(':id_categoria',$id_categoria);
    $sentencia->execute();

    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function guardarNuevaCategoriaContenido($objeto){
   $sql = "INSERT INTO tb_nidos_categoria_contenido (VC_Nombre_Categoria_Contenido, IN_Estado) VALUES (:nombre_nueva_categoria_contenido, :estado)";

   @$sentencia=$this->dbPDO->prepare($sql);

   @$sentencia->bindParam(':nombre_nueva_categoria_contenido', $objeto->getVcNombreCategoriaContenido());
   @$sentencia->bindParam(':estado', $objeto->getInEstado());

   $sentencia->execute();

   return $sentencia->rowCount();
 }

 public function guardarNuevContenido($objeto){
   $sql = "INSERT INTO tb_nidos_contenido (VC_Nombre_Contenido, FK_Id_Categoria_Contenido, IN_estado) VALUES (:nombre_nuevo_contenido, :id_categoria_contenido, 1)";

   @$sentencia=$this->dbPDO->prepare($sql);

   @$sentencia->bindParam(':nombre_nuevo_contenido', $objeto->getVcNombreContenido());
   @$sentencia->bindParam(':id_categoria_contenido', $objeto->getFkIdCategoriaContenido());

   $sentencia->execute();

   return $sentencia->rowCount();
 }

 public function modificarCategoriaContenido($objeto){
   $sql = "UPDATE tb_nidos_categoria_contenido SET VC_Nombre_Categoria_Contenido=:nombre_categoria_contenido, IN_Estado=:estado_categoria WHERE PK_Id_Categoria_Contenido=:id_categoria_contenido";

   @$sentencia=$this->dbPDO->prepare($sql);

   @$sentencia->bindParam(':id_categoria_contenido', $objeto->getPkIdCategoriaContenido());
   @$sentencia->bindParam(':nombre_categoria_contenido', $objeto->getVcNombreCategoriaContenido());
   @$sentencia->bindParam(':estado_categoria', $objeto->getInEstado());

   $sentencia->execute();

   return $sentencia->rowCount();
 } 

 public function modificarContenido($objeto){
   $sql = "UPDATE tb_nidos_contenido SET VC_Nombre_Contenido=:nombre_contenido, IN_Estado=:estado_contenido WHERE PK_Id_Contenido=:id_contenido";

   @$sentencia=$this->dbPDO->prepare($sql);

   @$sentencia->bindParam(':id_contenido', $objeto->getPkIdContenido());
   @$sentencia->bindParam(':nombre_contenido', $objeto->getVcNombreContenido());
   @$sentencia->bindParam(':estado_contenido', $objeto->getInEstado());

   $sentencia->execute();

   return $sentencia->rowCount();
 }

 public function getContenidos(){
  $sql = "SELECT
  cc.VC_Nombre_Categoria_Contenido AS 'nombre_categoria',
  GROUP_CONCAT(CONCAT('<option value=\"',c.PK_Id_Contenido,'\">',c.VC_Nombre_Contenido,'</option>') SEPARATOR '') AS 'options'
  FROM tb_nidos_contenido c
  JOIN tb_nidos_categoria_contenido cc ON cc.PK_Id_Categoria_Contenido=c.FK_Id_Categoria_Contenido
  WHERE c.IN_Estado=1 AND cc.IN_Estado=1
  GROUP BY c.FK_Id_Categoria_Contenido
  ORDER BY UPPER(c.VC_Nombre_Contenido) ASC";

  $sentencia=$this->dbPDO->prepare($sql);

  $sentencia->execute();

  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getDatosLugar($id_lugar){
 $sql = "SELECT
 l.VC_Nom_Localidad as 'localidad',
 CONCAT(u.IN_Codigo_Upz, '. ', u.VC_Nombre_Upz) as 'upz',
 e.Vc_Nom_Entidad as 'entidad',
 la.VC_Barrio as 'barrios'
 FROM tb_nidos_lugar_atencion la
 JOIN tb_nidos_entidades e ON e.Pk_Id_Entidad=la.Fk_Id_Entidad
 JOIN tb_localidades l ON l.Pk_Id_Localidad=la.Fk_Id_Localidad
 JOIN tb_upz u ON u.Pk_Id_Upz=la.Fk_Id_Upz
 WHERE la.Pk_Id_lugar_atencion=:id_lugar";

 $sentencia=$this->dbPDO->prepare($sql);

 @$sentencia->bindParam(':id_lugar',$id_lugar);
 $sentencia->execute();

 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

}

public function getGrupos($id_lugar){
 $sql = "SELECT
 g.Pk_Id_Grupo,
 g.VC_Nombre_Grupo
 FROM tb_nidos_grupos g
 WHERE g.Fk_Id_Lugar_Atencion=:id_lugar AND g.IN_Estado=1";

 $sentencia=$this->dbPDO->prepare($sql);

 @$sentencia->bindParam(':id_lugar',$id_lugar);
 $sentencia->execute();

 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

}


}
