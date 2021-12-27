<?php
namespace General\Persistencia\DAOS;

class ReporteDAO extends GestionDAO {

  private $db;
  function __construct()
  {
    $this->db=$this->obtenerPDOBD();
  }

  public function crearObjeto($objeto) {return;}
  public function modificarObjeto($objeto) {return;}
  public function eliminarObjeto($objeto) {return;}
  public function consultarObjeto($objeto){return;}

  public function consultarCodigoVerificacion($objeto){
    $sql="SELECT html FROM tb_admin_pdf_codigo_verificacion WHERE id = :id;";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id',$objeto->getId());
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function guardarHTMLInDB($objeto){
    $sql="INSERT INTO tb_admin_pdf_codigo_verificacion (html) VALUES (:html)";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':html',$objeto->getHtml());
    $sentencia->execute();
    $id_insertado = $this->db->lastInsertId();
  }

  public function consultarInformacionEncabezadoReporteArtista($id){
    $sql = "SELECT CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre, ' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) as nombre_artista ,P.VC_Identificacion,P.VC_Correo from tb_persona_2017 P WHERE P.PK_Id_Persona=:id";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':id',$id);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function saveReporteMensual($datos){
    $sql="INSERT INTO tb_terr_informe_mensual_grupo (FK_persona_reporte, FK_grupo, linea_atencion, VC_fecha_reporte, TX_json, DT_fecha_creacion, SM_estado, TX_observaciones_json, FK_persona_aprueba, DT_fecha_aprobacion) VALUES(:id_usuario, :id_grupo, :tipo_grupo, :mes_reporte, :json, CURRENT_TIMESTAMP, 0, '', :id_coordinador_crea, NULL)";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_usuario',$datos['datos_basicos']['id_usuario']);
    @$sentencia->bindParam(':id_grupo',$datos['datos_basicos']['id_grupo']);
    @$sentencia->bindParam(':tipo_grupo',$datos['datos_basicos']['tipo_grupo']);
    @$sentencia->bindParam(':mes_reporte',$datos['datos_basicos']['mes_reporte']);
    @$sentencia->bindParam(':json',json_encode($datos));
    @$sentencia->bindParam(':id_coordinador_crea',$datos['datos_basicos']['id_coordinador_crea']);
    $sentencia->execute(); 
    $filasAfectadas = $sentencia->rowCount();
    return $filasAfectadas;
  }

  public function consultarExistenciaReporteMes($datos){
    $sql="SELECT id,SM_estado FROM tb_terr_informe_mensual_grupo WHERE FK_persona_reporte=:id_usuario AND FK_grupo=:id_grupo AND linea_atencion=:tipo_grupo AND VC_fecha_reporte=:fecha_mes;";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
    @$sentencia->bindParam(':id_grupo',$datos['id_grupo']);
    @$sentencia->bindParam(':tipo_grupo',$datos['tipo_grupo']);
    @$sentencia->bindParam(':fecha_mes',$datos['fecha_mes']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarMisReportes($datos){
    $sql="SELECT id,FK_grupo,linea_atencion,VC_fecha_reporte,DT_fecha_creacion,DT_fecha_aprobacion,SM_estado,JSON_VALUE(TX_json,'$.datos_basicos.nombre_artista') AS nombre_artista,JSON_VALUE(TX_json,'$.datos_basicos.nombre_grupo') AS nombre_grupo,JSON_VALUE(TX_json,'$.datos_basicos.id_organizacion') AS id_organizacion FROM tb_terr_informe_mensual_grupo WHERE FK_persona_reporte=:id_usuario ORDER BY DT_fecha_creacion DESC";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarJSONReporte($id_reporte){
    $sql="SELECT IMG.TX_json,IMG.TX_observaciones_json,IMG.SM_estado, ED.TX_Firma_Escaneada FROM tb_terr_informe_mensual_grupo IMG LEFT JOIN tb_persona_extra_data ED ON IMG.FK_persona_reporte=ED.FK_Id_Persona WHERE id=:id_reporte";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_reporte',$id_reporte);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function actualizarJSON($id_informe,$json){
    $sql = "UPDATE tb_terr_informe_mensual_grupo SET TX_json=:TX_json WHERE id=:id_informe";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':TX_json',json_encode($json));
    @$sentencia->bindParam(':id_informe',$id_informe);
    $sentencia->execute();
    return $sentencia->rowCount();
  }

  public function consultarReportesPendientesRevision($datos){
    $sql="SELECT id,FK_grupo,linea_atencion,VC_fecha_reporte,DT_fecha_creacion,SM_estado,JSON_VALUE(TX_json,'$.datos_basicos.nombre_artista') AS nombre_artista,JSON_VALUE(TX_json,'$.datos_basicos.nombre_grupo') AS nombre_grupo,JSON_VALUE(TX_json,'$.datos_basicos.id_organizacion') AS id_organizacion FROM tb_terr_informe_mensual_grupo WHERE SM_estado=0 AND FK_persona_aprueba=:id_usuario ORDER BY DT_fecha_creacion DESC";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarReportesAsignadosParaRevisar($datos){
    $sql="SELECT id,FK_grupo,linea_atencion,VC_fecha_reporte,DT_fecha_creacion,DT_fecha_aprobacion,SM_estado,JSON_VALUE(TX_json,'$.datos_basicos.nombre_artista') AS nombre_artista,JSON_VALUE(TX_json,'$.datos_basicos.nombre_grupo') AS nombre_grupo,JSON_VALUE(TX_json,'$.datos_basicos.id_organizacion') AS id_organizacion FROM tb_terr_informe_mensual_grupo WHERE FK_persona_aprueba=:id_usuario AND VC_fecha_reporte=:anio_mes ORDER BY DT_fecha_creacion DESC";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
    @$sentencia->bindParam(':anio_mes',$datos['anio_mes']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function actualizarEstadoReporte($datos){
    switch ($datos["tipo_accion"]) {
      case 'rechazar':
        $nuevo_estado_informe = 2;
        $nueva_observacion = '{"observacion":"'.$datos["texto_rechazo"].'"}';
        break;
      case 'aprobar':
        $nuevo_estado_informe = 1;
        $nueva_observacion = '{"observacion":"aprobado"}';
        break;
      default:
        $nuevo_estado_informe = 5;
        break;
    }
    $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
    $sentencia = $this->db->prepare("UPDATE tb_terr_informe_mensual_grupo SET SM_estado=:estado_informe, TX_observaciones_json=:nueva_observacion, DT_fecha_aprobacion=NOW() WHERE id=:id_informe");
    @$sentencia->bindParam(':estado_informe',$nuevo_estado_informe);
    @$sentencia->bindParam(':nueva_observacion',$nueva_observacion);
    @$sentencia->bindParam(':id_informe',$datos['id_informe']);
    try {
        $this->db->beginTransaction();
        $set_id_usuario->execute();
        $sentencia->execute();
        $this->db->commit();
        return $sentencia->rowCount();
    }catch(PDOExecption $e) {
        $this->db->rollback();
        return "Error!: " . $e->getMessage() . "</br>";
    }
  }

  public function consultarJSONObservaciones($datos){
    $sql="SELECT JSON_VALUE(TX_observaciones_json,'$.observacion') AS observacion FROM tb_terr_informe_mensual_grupo WHERE id=:id_informe";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_informe',$datos['id_informe']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function updateJSONReporte($datos){
    $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
    $sentencia = $this->db->prepare("UPDATE tb_terr_informe_mensual_grupo SET SM_estado=0, TX_json=:nuevo_json, DT_fecha_creacion=NOW() WHERE id=:id_informe");
    @$sentencia->bindParam(':nuevo_json',json_encode($datos['datos_array_reporte_mensual']));
    @$sentencia->bindParam(':id_informe',$datos['id_informe']);
    try {
        $this->db->beginTransaction();
        $set_id_usuario->execute();
        $sentencia->execute();
        $this->db->commit();
        return $sentencia->rowCount();
    }catch(PDOExecption $e) {
        $this->db->rollback();
        return "Error!: " . $e->getMessage() . "</br>";
    }
  }

  public function consultarPeriodosReporteDigitalMensual(){
    $sql="SELECT DISTINCT VC_fecha_reporte FROM tb_terr_informe_mensual_grupo ORDER BY VC_fecha_reporte DESC";
    @$sentencia=$this->db->prepare($sql);
    // @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarTodosLosReportesAprobados($datos){
    $sql="SELECT id,FK_grupo,linea_atencion,VC_fecha_reporte,DT_fecha_creacion,SM_estado,JSON_VALUE(TX_json,'$.datos_basicos.nombre_artista') AS nombre_artista,JSON_VALUE(TX_json,'$.datos_basicos.nombre_grupo') AS nombre_grupo,JSON_VALUE(TX_json,'$.datos_basicos.id_organizacion') AS id_organizacion,DT_fecha_aprobacion FROM tb_terr_informe_mensual_grupo WHERE SM_estado=1 AND VC_fecha_reporte=:periodo ORDER BY DT_fecha_creacion DESC";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':periodo',$datos['periodo']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarUsuariosVerificanReporte($datos){
    $sql="SELECT DISTINCT P.PK_Id_Persona AS id_usuario, CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_apellido) AS nombre_usuario FROM tb_terr_informe_mensual_grupo I LEFT JOIN tb_persona_2017 P ON I.FK_persona_aprueba=P.PK_Id_Persona;";
    @$sentencia=$this->db->prepare($sql);
    // @$sentencia->bindParam(':periodo',$datos['periodo']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarReportesAprobadosArtistaFormador($datos){
    $sql="SELECT id,FK_grupo,linea_atencion,VC_fecha_reporte,DT_fecha_creacion,SM_estado,JSON_VALUE(TX_json,'$.datos_basicos.nombre_artista') AS nombre_artista,JSON_VALUE(TX_json,'$.datos_basicos.nombre_grupo') AS nombre_grupo,JSON_VALUE(TX_json,'$.datos_basicos.id_organizacion') AS id_organizacion, DT_fecha_aprobacion FROM tb_terr_informe_mensual_grupo WHERE SM_estado=1 AND FK_persona_reporte=:id_formador ORDER BY DT_fecha_creacion DESC";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_formador',$datos['id_formador']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarReportesAprobadosFiltros($year, $linea_atencion, $convenio, $colegio){
    $extra_where = "";
    if($linea_atencion == "arte_escuela") $extra_where = "AND G.FK_colegio = ".$colegio;
    $sql="select IMG.id,FK_grupo,
    IMG.linea_atencion,
    IMG.VC_fecha_reporte,
    IMG.DT_fecha_creacion,
    IMG.SM_estado,
    JSON_VALUE(TX_json,'$.datos_basicos.nombre_artista') AS nombre_artista,
    JSON_VALUE(TX_json,'$.datos_basicos.nombre_grupo') AS nombre_grupo,
    JSON_VALUE(TX_json,'$.datos_basicos.id_organizacion') AS id_organizacion,
    JSON_VALUE(TX_json,'$.datos_basicos.id_usuario') AS id_usuario,
    IMG.DT_fecha_aprobacion,
    G.FK_colegio
    FROM tb_terr_informe_mensual_grupo IMG
    JOIN tb_terr_grupo_arte_escuela G ON G.PK_Grupo=IMG.FK_grupo
    WHERE IMG.linea_atencion = 'arte_escuela' and IMG.FK_grupo = 4870";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':linea_atencion',$linea_atencion);
    @$sentencia->bindParam(':convenio',$convenio);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }
}
