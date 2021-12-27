<?php

namespace General\Persistencia\DAOS;
class OrganizacionesProyeccionGastoDAO extends GestionDAO {

  private $dbPDO;

  function __construct()
  {
    $this->dbPDO=$this->obtenerPDOBD();
  }
  public function crearObjeto($objeto){
    return null;
  }

  public function modificarObjeto($objeto){
    return null;
  }

  public function eliminarObjeto($objeto){
    return null;
  }

  public function consultarObjeto($objeto){
    return null; 
  }


  public function getLastApprovedProyeccionPk($organizacion){
    $sql=" SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(tpg.TX_Periodo, ',', -1), ',', -1) as LAST_TX_PERIODO,
    tpg.*
    FROM tb_organizaciones_proyeccion_gasto tpg 
    WHERE tpg.IN_Aprobacion = 1 AND tpg.FK_Organizacion_Id = :id_usuario AND tpg.FK_Id_Seguimiento_Propuesta = :FK_Id_Seguimiento_Propuesta
    AND tpg.DT_Fecha_Registro IN (SELECT MAX(tpg.DT_Fecha_Registro) FROM  tb_organizaciones_proyeccion_gasto tpg 
    WHERE tpg.IN_Aprobacion = 1 AND tpg.FK_Organizacion_Id = :id_usuario AND tpg.FK_Id_Seguimiento_Propuesta = :FK_Id_Seguimiento_Propuesta);";
    $sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':id_usuario',$organizacion->getFkOrganizacionId());
    @$sentencia->bindParam(':FK_Id_Seguimiento_Propuesta',$organizacion->setFkIdSeguimientoPropuesta());
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

}
