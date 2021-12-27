<?php

namespace General\Persistencia\DAOS;


class OcupacionCreaDAO extends GestionDAO {

  private $db;

  function __construct()
  {
    $this->db=$this->obtenerPDOBD();
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

  public function consultarObjeto($objeto){

    return;
  }

  public function crearRegistroOcupacionCREA($datos){
    //$set_id_usuario = $this->db->prepare("SET @user_id = '".$datos['id_usuario']."';");
    $sql = "INSERT INTO tb_terr_ocupacion_crea
    (TX_nombre_actividad,FK_crea,TX_descripcion,TX_responsable,IN_asistentes,FK_Salones,DT_fecha_hora_inicio,DT_fecha_hora_fin,DT_fecha_registro) VALUES
    (:nombre_actividad,:id_crea,:descripcion_actividad,:responsable_actividad,:numero_asistentes,:salones,:fecha_hora_inicio,:fecha_hora_fin,:fecha);";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':nombre_actividad',$datos['nombre_actividad']);
    @$sentencia->bindParam(':id_crea',$datos['id_crea']);
    @$sentencia->bindParam(':descripcion_actividad',$datos['descripcion_actividad']);
    @$sentencia->bindParam(':responsable_actividad',$datos['responsable_actividad']);
    @$sentencia->bindParam(':numero_asistentes',$datos['numero_asistentes']);
    @$sentencia->bindParam(':salones',$datos['salones']);
    @$sentencia->bindParam(':fecha_hora_inicio',$datos['fecha_hora_inicio']);
    @$sentencia->bindParam(':fecha_hora_fin',$datos['fecha_hora_fin']);
    @$sentencia->bindParam(':fecha',date("Y-m-d H:i:s"));
    try {
      $this->db->beginTransaction();
      //$set_id_usuario->execute();
      $sentencia->execute();
      $this->db->commit();
      return 1;
    }catch(PDOExecption $e) {
      $this->db->rollback();
      return "Error!: " . $e->getMessage() . "</br>";
    }
  }

  public function modificarRegistroOcupacionCREA($datos){
    //$set_id_usuario = $this->db->prepare("SET @user_id = '".$datos['id_usuario']."';");
    $sql = "UPDATE tb_terr_ocupacion_crea SET TX_nombre_actividad=:nombre_actividad,
    TX_descripcion=:descripcion_actividad,TX_responsable=:responsable_actividad,
    IN_asistentes=:numero_asistentes,FK_Salones=:salones,DT_fecha_hora_inicio=:fecha_hora_inicio,DT_fecha_hora_fin=:fecha_hora_fin
    WHERE id = :id_registro_ocupacion";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':nombre_actividad',$datos['nombre_actividad']);
    @$sentencia->bindParam(':id_registro_ocupacion',$datos['id_registro_ocupacion']);
    @$sentencia->bindParam(':descripcion_actividad',$datos['descripcion_actividad']);
    @$sentencia->bindParam(':responsable_actividad',$datos['responsable_actividad']);
    @$sentencia->bindParam(':numero_asistentes',$datos['numero_asistentes']);
    @$sentencia->bindParam(':salones',$datos['salones']);
    @$sentencia->bindParam(':fecha_hora_inicio',$datos['fecha_hora_inicio']);
    @$sentencia->bindParam(':fecha_hora_fin',$datos['fecha_hora_fin']);
    try {
      $this->db->beginTransaction();
      //$set_id_usuario->execute();
      $sentencia->execute();
      $this->db->commit();
      return 1;
    }catch(PDOExecption $e) {
      $this->db->rollback();
      return "Error!: " . $e->getMessage() . "</br>";
    }
  }

  public function consultarRegistrosOcupacionCREA($id_crea){
    $sentencia=$this->db->prepare("SELECT * FROM tb_terr_ocupacion_crea WHERE FK_crea = :id_crea");
    @$sentencia->bindParam(':id_crea',$id_crea);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getSalonesCrea($id_crea){
    $sentencia=$this->db->prepare("SELECT * FROM tb_salones WHERE FK_Id_Crea = :id_crea AND IN_Estado=1");
    @$sentencia->bindParam(':id_crea',$id_crea);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getSalonesOcupacion($id_ocupacion){
    $sentencia=$this->db->prepare("SELECT * FROM tb_salones WHERE PK_Id_Salon IN ($id_ocupacion)");
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getOcupacionesMesCrea($id_crea, $anio, $mes){
    $sentencia=$this->db->prepare("SELECT * FROM tb_terr_ocupacion_crea WHERE FK_crea = :id_crea AND YEAR(DT_fecha_hora_inicio)=:anio AND MONTH(DT_fecha_hora_inicio)=:mes");
    @$sentencia->bindParam(':id_crea',$id_crea);
    @$sentencia->bindParam(':anio',$anio);
    @$sentencia->bindParam(':mes',$mes);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }
}
