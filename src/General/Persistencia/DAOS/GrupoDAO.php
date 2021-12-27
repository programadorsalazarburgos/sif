<?php

namespace General\Persistencia\DAOS;


class GrupoDao extends GestionDAO {

  private $db;

  function __construct()
  {
    $this->db=$this->obtenerPDOBD();
  }

  public function crearObjeto($objeto) {
    $set_id_usuario = $this->db->prepare("SET @user_id = ".$objeto->getFkCreador().";");
    $pk_grupo = $this->consultarUltimoIdGrupo($objeto->getTipoGrupo())[0]['max'];
    $pk_grupo++;
    $array_campos =
    array("arte_escuela"=>"FK_colegio, VC_grados",
      "emprende_clan"=>"FK_modalidad, abierto_publico, IN_cupos",
      "laboratorio_clan"=>"FK_Institucion, FK_Aliado, tipo_poblacion, IN_espacio_alterno");
    $array_valores=
    array("arte_escuela"=>":FK_colegio, :VC_grados",
      "emprende_clan"=>":FK_modalidad, :abierto_publico, :IN_cupos",
      "laboratorio_clan"=>":FK_Institucion, :FK_Aliado, :tipo_poblacion, :IN_espacio_alterno");

    $sentencia = $this->db->prepare("INSERT INTO tb_terr_grupo_".$objeto->getTipoGrupo()." (
      PK_Grupo,
      FK_clan,
      FK_area_artistica,
      IN_lugar_atencion,
      IN_modalidad_atencion,
      IN_tipo_atencion,
      IN_convenio,
      DT_fecha_creacion,
      FK_creador,
      FK_organizacion,
      estado,
      TX_observaciones,
      tipo_grupo,
      ".$array_campos[$objeto->getTipoGrupo()].") VALUES (
      :PK_Grupo,
      :FK_clan,
      :FK_area_artistica,
      :IN_lugar_atencion,
      :IN_modalidad_atencion,
      :IN_tipo_atencion,
      :IN_convenio,
      :DT_fecha_creacion,
      :FK_creador,
      :FK_organizacion,
      :estado,
      :TX_observaciones,
      :tipo_grupo,
      ".$array_valores[$objeto->getTipoGrupo()].")");

    @$sentencia->bindParam(':PK_Grupo',$pk_grupo);
    @$sentencia->bindParam(':FK_clan',$objeto->getFkClan());
    @$sentencia->bindParam(':FK_area_artistica',$objeto->getFkAreaArtistica());
    @$sentencia->bindParam(':IN_lugar_atencion',$objeto->getInLugarAtencion());
    @$sentencia->bindParam(':IN_modalidad_atencion',$objeto->getInModalidadAtencion());
    @$sentencia->bindParam(':IN_tipo_atencion',$objeto->getInTipoAtencion());
    @$sentencia->bindParam(':IN_convenio',$objeto->getInConvenio());
    @$sentencia->bindParam(':DT_fecha_creacion',date('Y-m-d H:i:s'));
    @$sentencia->bindParam(':FK_creador',$objeto->getFkCreador());
    @$sentencia->bindParam(':FK_organizacion',$objeto->getFkOrganizacion());
    @$sentencia->bindParam(':estado',$objeto->getEstado());
    @$sentencia->bindParam(':TX_observaciones',$objeto->getTxObservaciones());
    @$sentencia->bindParam(':tipo_grupo',$objeto->getTipoGrupoAtencion());

    switch ($objeto->getTipoGrupo()) {
      case 'arte_escuela':
      @$sentencia->bindParam(':FK_colegio',$objeto->getFkColegio());
      @$sentencia->bindParam(':VC_grados',$objeto->getVcGrados());
      break;
      case 'emprende_clan':
      @$sentencia->bindParam(':FK_modalidad',$objeto->getFkModalidad());
      @$sentencia->bindParam(':abierto_publico',$objeto->getGrupoAbiertoPublico());
      @$sentencia->bindParam(':IN_cupos',$objeto->getInCupos());
      break;
      case 'laboratorio_clan':
      @$sentencia->bindParam(':FK_Institucion',$objeto->getFkInstitucionLaboratorio());
      @$sentencia->bindParam(':FK_Aliado',$objeto->getFkAliadoLaboratorio());
      @$sentencia->bindParam(':tipo_poblacion',$objeto->getTipoPoblacion());
      @$sentencia->bindParam(':IN_espacio_alterno',$objeto->getInEspacioAlterno());
      break;
      default:
      break;
    }
    try {
      $this->db->beginTransaction();
      $set_id_usuario->execute();
      $sentencia->execute();
      $sentenciaHorario = $this->db->prepare("INSERT INTO tb_terr_grupo_".$objeto->getTipoGrupo()."_horario_clase (FK_grupo,IN_dia,TI_hora_inicio_clase,TI_hora_fin_clase) VALUES (:FK_grupo, :IN_dia, :TI_hora_inicio_clase, :TI_hora_fin_clase)");
      @$sentenciaHorario->bindParam(':FK_grupo', $id_grupo);
      @$sentenciaHorario->bindParam(':IN_dia', $dia_clase);
      @$sentenciaHorario->bindParam(':TI_hora_inicio_clase', $hora_inicio_clase);
      @$sentenciaHorario->bindParam(':TI_hora_fin_clase', $hora_fin_clase);

      foreach ($objeto->getHorarioArray() as $horario) {
        $id_grupo = $pk_grupo;
        $dia_clase = intval($horario['dia']);
        $hora_inicio_clase = $horario['hora_inicio'];
        $hora_fin_clase = $horario['hora_fin'];
        $set_id_usuario->execute();
        $sentenciaHorario->execute();
      }
      $this->db->commit();
      return $pk_grupo;
    }catch(PDOExecption $e) {
      $this->db->rollback();
      return "Error!: " . $e->getMessage() . "</br>";
    }
  }

  public function modificarObjeto($objeto) {
    $array_update_linea_atencion =
    array("arte_escuela"=>"VC_grados=:VC_grados,",
      "emprende_clan"=>"FK_modalidad=:FK_modalidad, tipo_grupo=:tipo_grupo, abierto_publico=:abierto_publico, IN_cupos=:IN_cupos,",
      "laboratorio_clan"=>"tipo_grupo=:tipo_grupo, FK_Institucion=:FK_Institucion, FK_Aliado=:FK_Aliado, tipo_poblacion=:tipo_poblacion, IN_espacio_alterno=:IN_espacio_alterno,");

    $set_id_usuario = $this->db->prepare("SET @user_id = ".$objeto->getFkCreador().";");

    $sql="UPDATE tb_terr_grupo_".$objeto->getTipoGrupo()." SET IN_lugar_atencion=:IN_lugar_atencion, IN_modalidad_atencion=:IN_modalidad_atencion, IN_tipo_atencion=:IN_tipo_atencion, IN_convenio=:IN_convenio, FK_area_artistica=:FK_area_artistica, ".$array_update_linea_atencion[$objeto->getTipoGrupo()]."TX_observaciones=:TX_observaciones WHERE PK_Grupo=:PK_Grupo";

    $sentencia = $this->db->prepare($sql);

    @$sentencia->bindParam(':IN_lugar_atencion',$objeto->getInLugarAtencion());
    @$sentencia->bindParam(':PK_Grupo',$objeto->getPkGrupo());
    @$sentencia->bindParam(':IN_modalidad_atencion',$objeto->getInModalidadAtencion());
    @$sentencia->bindParam(':IN_tipo_atencion',$objeto->getInTipoAtencion());
    @$sentencia->bindParam(':IN_convenio',$objeto->getInConvenio());
    @$sentencia->bindParam(':FK_area_artistica',$objeto->getFkAreaArtistica());
    @$sentencia->bindParam(':TX_observaciones',$objeto->getTxObservaciones());

    $sentenciaDelete = $this->db->prepare("DELETE FROM tb_terr_grupo_".$objeto->getTipoGrupo()."_horario_clase WHERE FK_Grupo=".$objeto->getPkGrupo());
    try {
      $this->db->beginTransaction();
      $set_id_usuario->execute();
      switch ($objeto->getTipoGrupo()) {
        case 'arte_escuela':
        @$sentencia->bindParam(':VC_grados',$objeto->getVcGrados());
        break;
        case 'emprende_clan':
        @$sentencia->bindParam(':FK_modalidad',$objeto->getFkModalidad());
        @$sentencia->bindParam(':tipo_grupo',$objeto->getTipoGrupoAtencion());
        @$sentencia->bindParam(':abierto_publico',$objeto->getGrupoAbiertoPublico());
        @$sentencia->bindParam(':IN_cupos',$objeto->getInCupos());
        break;
        case 'laboratorio_clan':
        @$sentencia->bindParam(':tipo_grupo',$objeto->getTipoGrupoAtencion());                  
        @$sentencia->bindParam(':FK_Institucion',$objeto->getFkInstitucionLaboratorio());
        @$sentencia->bindParam(':FK_Aliado',$objeto->getFkAliadoLaboratorio());
        @$sentencia->bindParam(':tipo_poblacion',$objeto->getTipoPoblacion());
        @$sentencia->bindParam(':IN_espacio_alterno',$objeto->getInEspacioAlterno());
        break;
        default:
        break;
      }   

      $sentencia->execute();
      $sentenciaDelete->execute();

      $sentenciaHorario = $this->db->prepare("INSERT INTO tb_terr_grupo_".$objeto->getTipoGrupo()."_horario_clase (FK_grupo,IN_dia,TI_hora_inicio_clase,TI_hora_fin_clase) VALUES (:FK_grupo, :IN_dia, :TI_hora_inicio_clase, :TI_hora_fin_clase)");
      @$sentenciaHorario->bindParam(':FK_grupo', $id_grupo);
      @$sentenciaHorario->bindParam(':IN_dia', $dia_clase);
      @$sentenciaHorario->bindParam(':TI_hora_inicio_clase', $hora_inicio_clase);
      @$sentenciaHorario->bindParam(':TI_hora_fin_clase', $hora_fin_clase);

      foreach ($objeto->getHorarioArray() as $horario) {
        $id_grupo = $objeto->getPkGrupo();
        $dia_clase = intval($horario['dia']);
        $hora_inicio_clase = $horario['hora_inicio'];
        $hora_fin_clase = $horario['hora_fin'];
        $set_id_usuario->execute();
        $sentenciaHorario->execute();
      }
      
      $this->db->commit();
      return "1";
    }catch(PDOExecption $e) {
      $this->db->rollback();
      return "Error!: " . $e->getMessage() . "</br>";
    }
  }

  public function eliminarObjeto($objeto) {
    $sql="";
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function cerrarGrupo($objeto){
    $set_id_usuario = $this->db->prepare("SET @user_id = '".$objeto->getFkQuienCerro()."';");
    $sentencia = $this->db->prepare("UPDATE tb_terr_grupo_".$objeto->getTipoGrupo()." SET estado=:estado,DT_fecha_cierre=:DT_fecha_cierre,TX_observaciones=:TX_observaciones,FK_quien_cerro=:FK_quien_cerro WHERE PK_Grupo=:PK_Grupo");
    @$sentencia->bindParam(':estado',$objeto->getEstado());
    @$sentencia->bindParam(':DT_fecha_cierre',date('Y-m-d H:i:s'));
    @$sentencia->bindParam(':TX_observaciones',$objeto->getTxObservaciones());
    @$sentencia->bindParam(':FK_quien_cerro',$objeto->getFkQuienCerro());
    @$sentencia->bindParam(':PK_Grupo',$objeto->getPkGrupo());
    try {
      $this->db->beginTransaction();
      $set_id_usuario->execute();
      $sentenciaEstudiante = $this->db->prepare("UPDATE tb_terr_grupo_".$objeto->getTipoGrupo()."_estudiante SET DT_fecha_retiro=:DT_fecha_retiro,FK_usuario_retiro=:FK_usuario_retiro,estado=:estado,TX_observaciones=:TX_observaciones WHERE FK_grupo=:FK_Grupo AND estado=1;");
      $sentencia->execute();
      @$sentenciaEstudiante->bindParam(':DT_fecha_retiro', date('Y-m-d H:i:s'));
      @$sentenciaEstudiante->bindParam(':FK_usuario_retiro', $objeto->getFkQuienCerro());
      @$sentenciaEstudiante->bindParam(':estado',$objeto->getEstado());
      @$sentenciaEstudiante->bindParam(':TX_observaciones', $objeto->getTxObservaciones());
      @$sentenciaEstudiante->bindParam(':FK_Grupo', $objeto->getPkGrupo());
      $sentenciaEstudiante->execute();

      $this->db->commit();
      return "1";
    }catch(PDOExecption $e) {
      $this->db->rollback();
      return "Error!: " . $e->getMessage() . "</br>";
    }
  }


  public function fusionarGrupos($objeto_1,$objeto_2){
    $estudiante = array();
    foreach ($objeto_1->getEstudianteArray() as $e) {
      array_push($estudiante, $e['id']);
    }
    foreach ($objeto_2->getEstudianteArray() as $e) {
      array_push($estudiante, $e['id']);
    }
    $objeto_1->setEstado(1);
    $id_nuevo_grupo = $this->crearObjeto($objeto_1);
    $objeto_1->setFkQuienCerro($objeto_1->getFkCreador());
    $objeto_1->setEstado(0);
    $objeto_2->setFkQuienCerro($objeto_1->getFkCreador());
    $objeto_2->setEstado(0);

    $this->cerrarGrupo($objeto_1);
    $this->cerrarGrupo($objeto_2);
    for ($i=0; $i < sizeof($estudiante); $i++) {
      $this->agregarEstudianteGrupo($id_nuevo_grupo,$estudiante[$i],date('Y-m-d H:i:s'),$objeto_1->getFkCreador(),"Fusión de Grupos (".$objeto_1->getTipoGrupo()."): ".$objeto_1->getPkGrupo()." y ".$objeto_2->getPkGrupo(),$objeto_1->getTipoGrupo());
    }
    return $id_nuevo_grupo;
  }

  public function consultarObjeto($objeto) {
    $select="";
    $join="";
    if($objeto->getTipoGrupo()=='laboratorio_clan'){
      $select=" , TP.FK_Id_Categoria ";
      $join=" JOIN tb_terr_grupo_laboratorio_crea_tipo_poblacion AS TP ON TP.PK_Id_Tabla=G.tipo_poblacion";
    }
    $sql="SELECT G.* ".$select." FROM tb_terr_grupo_".$objeto->getTipoGrupo()." AS G ".$join." WHERE G.PK_Grupo=".$objeto->getPkGrupo().";";
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0];
  }

  public function consultarGruposUsuario($id_usuario,$tipo_grupo){
  //Traer el campo de "Lugar Atencion/Tipo Ubicacion" del Grupo para saber si solicitar o no el salón en el registro asistencia.
    // $ubicacion = "";
    // switch ($tipo_grupo) {
    //   case 'arte_escuela':
    //   $ubicacion = ", IN_lugar_atencion AS tipo_ubicacion";
    //   break;
    //   case 'emprende_clan':
    //   $ubicacion = "";
    //   break;
    //   case 'laboratorio_clan':
    //   $ubicacion = ", IN_lugar_atencion AS tipo_ubicacion";
    //   break;
  //}
    $sql="SELECT PK_Grupo,FK_organizacion,FK_clan,IN_lugar_atencion AS tipo_ubicacion FROM tb_terr_grupo_".$tipo_grupo." WHERE estado = 1 AND FK_artista_formador=".$id_usuario;
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarGruposClanPorEstado($id_clan,$tipo_grupo,$estado){
    $sql="SELECT PK_Grupo FROM tb_terr_grupo_".$tipo_grupo." WHERE estado=".$estado." AND FK_clan=".$id_clan.";";
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarHorarioGrupo($id_grupo,$tipo_grupo){
    $sql="SELECT * FROM tb_terr_grupo_".$tipo_grupo."_horario_clase WHERE FK_grupo=".$id_grupo;
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarGruposActivosCrea($objeto){
    $dato_adicional = array(
      'arte_escuela' => ',COL.VC_Nom_colegio',
      'emprende_clan'=>',M.VC_Nom_Modalidad',
      'laboratorio_clan'=>',L.VC_Nombre_Lugar');
    $JOIN_adicional = array('arte_escuela' => ' LEFT JOIN tb_colegios COL ON COL.PK_Id_Colegio = G.FK_colegio ',
      'emprende_clan' => ' LEFT JOIN tb_modalidad M ON M.PK_Id_Modalidad = G.FK_modalidad ',
      'laboratorio_clan' => ' LEFT JOIN tb_terr_lugar_atencion_laboratorio_clan L ON G.FK_lugar_atencion = L.PK_lugar_atencion ');
    $sql="SELECT G.*,AA.VC_Nom_Area,O.VC_Nom_Organizacion,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre ".$dato_adicional[$objeto->getTipoGrupo()]." FROM tb_terr_grupo_".$objeto->getTipoGrupo()." G LEFT JOIN tb_areas_artisticas AA ON AA.PK_Area_Artistica = G.FK_area_artistica LEFT JOIN tb_organizaciones_2017 O ON G.FK_organizacion = O.PK_Id_Organizacion LEFT JOIN tb_persona_2017 P ON P.PK_Id_Persona = G.FK_artista_formador ".$JOIN_adicional[$objeto->getTipoGrupo()]." WHERE G.FK_clan=:getFkClan AND G.estado=1";
    $sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':getFkClan', $objeto->getFkClan());
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
  }

  public function consultarGruposInactivos($tipo_grupo){
    $sql="SELECT PK_Grupo FROM tb_terr_grupo_".$tipo_grupo." WHERE estado=0";
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarIDGruposActivos($tipo_grupo){
    $sql="SELECT PK_Grupo FROM tb_terr_grupo_".$tipo_grupo." WHERE estado=1";
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarGruposActivos($tipo_grupo){
    $dato_adicional = array(
      'arte_escuela' => ',COL.VC_Nom_colegio',
      'emprende_clan'=>',M.VC_Nom_Modalidad',
      'laboratorio_clan'=>',L.VC_Nombre_Lugar');
    $JOIN_adicional = array('arte_escuela' => ' LEFT JOIN tb_colegios COL ON COL.PK_Id_Colegio = G.FK_colegio ',
      'emprende_clan' => ' LEFT JOIN tb_modalidad M ON M.PK_Id_Modalidad = G.FK_modalidad ',
      'laboratorio_clan' => ' LEFT JOIN tb_terr_lugar_atencion_laboratorio_clan L ON G.FK_lugar_atencion = L.PK_lugar_atencion ');
    $sql="SELECT G.*,CL.VC_Nom_Clan,AA.VC_Nom_Area,O.VC_Nom_Organizacion,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre ".$dato_adicional[$tipo_grupo]."
    ,(
    SELECT
    GROUP_CONCAT( 
    CONCAT(
    (
    CASE 
    WHEN HC.IN_dia=1 THEN 'Lunes'
    WHEN HC.IN_dia=2 THEN 'Martes'
    WHEN HC.IN_dia=3 THEN 'Miercoles'
    WHEN HC.IN_dia=4 THEN 'Jueves'
    WHEN HC.IN_dia=5 THEN 'Viernes'
    WHEN HC.IN_dia=6 THEN 'Sabado'
    WHEN HC.IN_dia=7 THEN 'Domingo'
    END
    ),' (',HC.TI_hora_inicio_clase,' a ',HC.TI_hora_fin_clase,')')) 
    FROM tb_terr_grupo_".$tipo_grupo."_horario_clase AS HC 
    WHERE HC.FK_grupo=G.PK_Grupo
    ) AS 'horario'      
    FROM tb_terr_grupo_".$tipo_grupo." G LEFT JOIN tb_areas_artisticas AA ON AA.PK_Area_Artistica = G.FK_area_artistica LEFT JOIN tb_clan CL ON G.FK_clan = CL.PK_Id_Clan LEFT JOIN tb_organizaciones_2017 O ON G.FK_organizacion = O.PK_Id_Organizacion LEFT JOIN tb_persona_2017 P ON P.PK_Id_Persona = G.FK_artista_formador ".$JOIN_adicional[$tipo_grupo]." WHERE G.estado=1";
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarArtistasFormadoresDeGruposActivos($id_usuario_actual){
    $sql="SELECT DISTINCT(FK_artista_formador), P.VC_Identificacion,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.PK_Id_Persona
    FROM tb_terr_grupo_arte_escuela GAE
    JOIN tb_persona_2017 P ON GAE.FK_artista_formador = P.PK_Id_Persona
    WHERE estado = 1 AND FK_Artista_Formador != $id_usuario_actual
    UNION SELECT DISTINCT(FK_artista_formador), P.VC_Identificacion,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.PK_Id_Persona
    FROM tb_terr_grupo_emprende_clan GEC
    JOIN tb_persona_2017 P ON GEC.FK_artista_formador = P.PK_Id_Persona
    WHERE estado = 1 AND FK_Artista_Formador != $id_usuario_actual
    UNION SELECT DISTINCT(FK_artista_formador), P.VC_Identificacion,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.PK_Id_Persona
    FROM tb_terr_grupo_laboratorio_clan GLC
    JOIN tb_persona_2017 P ON GLC.FK_artista_formador = P.PK_Id_Persona
    WHERE estado = 1 AND FK_Artista_Formador != $id_usuario_actual";
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarIDCoorinadorActualClanGrupo($id_grupo,$tipo_grupo){
    $sql="SELECT FK_Persona_Administrador FROM tb_terr_grupo_".$tipo_grupo." G LEFT JOIN tb_clan C ON G.FK_clan = C.PK_Id_Clan WHERE G.PK_Grupo =".$id_grupo;
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarHorasDeClaseDia($id_grupo,$fecha_sesion,$tipo_grupo){
    $sql="SELECT TIME_TO_SEC(TIMEDIFF(H.TI_hora_fin_clase,H.TI_hora_inicio_clase))/3600 HORAS
    FROM tb_terr_grupo_".$tipo_grupo."_horario_clase H
    WHERE H.FK_grupo = ".$id_grupo."
    AND H.IN_dia = (SELECT (WEEKDAY('".$fecha_sesion."') + 1))";
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarTodosEstudiantesGrupo($id_grupo,$tipo_grupo){
    $sql="SELECT GE.DT_fecha_ingreso,E.id,E.IN_Identificacion,E.VC_Primer_Apellido,E.VC_Segundo_Apellido,E.VC_Primer_Nombre,E.VC_Segundo_Nombre
    FROM tb_terr_grupo_".$tipo_grupo."_estudiante GE
    INNER JOIN tb_estudiante E ON GE.FK_estudiante = E.id
    WHERE GE.FK_Grupo = ".$id_grupo;
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarEstudiantesPorEstadoGrupo($id_grupo,$tipo_grupo,$estado){
    $sql="SELECT GE.DT_fecha_ingreso,E.id,E.IN_Identificacion,E.VC_Primer_Apellido,E.VC_Segundo_Apellido,E.VC_Primer_Nombre,E.VC_Segundo_Nombre
    FROM tb_terr_grupo_".$tipo_grupo."_estudiante GE
    INNER JOIN tb_estudiante E ON GE.FK_estudiante = E.id
    WHERE GE.FK_Grupo = ".$id_grupo." AND GE.estado = ".$estado;
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarOrganizacionGrupo($id_grupo,$tipo_grupo){
    $sql = "SELECT G.FK_organizacion,O.VC_Nom_Organizacion AS 'nombre_organizacion' FROM tb_terr_grupo_".$tipo_grupo." G LEFT JOIN tb_organizaciones_2017 O ON G.FK_organizacion = O.PK_Id_Organizacion WHERE G.PK_Grupo=".$id_grupo;
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

            // public function agregarEstudianteGrupo($id_grupo,$id_estudiante,$fecha_hora,$id_usuario,$observaciones,$tipo_grupo, $bioseguridad = null){
  public function agregarEstudianteGrupo($id_grupo,$id_estudiante,$fecha_hora,$id_usuario,$observaciones,$tipo_grupo){
    $estado = 1;
    $set_id_usuario = $this->db->prepare("SET @user_id = '".$id_usuario."';");
              // $sentencia=$this->db->prepare("INSERT INTO tb_terr_grupo_".$tipo_grupo."_estudiante (FK_grupo,FK_estudiante,DT_fecha_ingreso,FK_usuario_ingreso,estado,TX_observaciones, JSON_bioseguridad) VALUES (:FK_grupo,:FK_estudiante,:DT_fecha_ingreso,:FK_usuario_ingreso,:estado,:TX_observaciones, :bioseguridad)");
    $sentencia=$this->db->prepare("INSERT INTO tb_terr_grupo_".$tipo_grupo."_estudiante (FK_grupo,FK_estudiante,DT_fecha_ingreso,FK_usuario_ingreso,estado,TX_observaciones) VALUES (:FK_grupo,:FK_estudiante,:DT_fecha_ingreso,:FK_usuario_ingreso,:estado,:TX_observaciones)");
    @$sentencia->bindParam(':FK_grupo',$id_grupo);
    @$sentencia->bindParam(':FK_estudiante',$id_estudiante);
    @$sentencia->bindParam(':DT_fecha_ingreso',$fecha_hora);
    @$sentencia->bindParam(':FK_usuario_ingreso',$id_usuario);
    @$sentencia->bindParam(':estado',$estado);
    @$sentencia->bindParam(':TX_observaciones',$observaciones);
              // @$sentencia->bindParam(':bioseguridad',$bioseguridad);
    try {
      $this->db->beginTransaction();
      $set_id_usuario->execute();
      $sentencia->execute();
      $this->db->commit();
      return 1;
    }catch(PDOExecption $e) {
      $this->db->rollback();
      return "Error!: " . $e->getMessage() . "</br>";
    }
  }

  public function consultarGruposActivosOrganizacion($id_organizacion,$tipo_grupo){
    $campos_linea_atencion = array(
      'arte_escuela' => 'COL.Vc_Nom_Colegio,IN_lugar_atencion,',
      'emprende_clan' => 'M.VC_Nom_Modalidad,',
      'laboratorio_clan' => 'G.tipo_poblacion,L.VC_Nombre_Lugar,'
    );
    $join_linea_atencion = array(
      'arte_escuela' => ' LEFT JOIN tb_colegios COL ON COL.PK_Id_Colegio = G.FK_colegio ',
      'emprende_clan' => ' LEFT JOIN tb_modalidad M ON M.PK_Id_Modalidad = G.FK_modalidad ',
      'laboratorio_clan' => ' LEFT JOIN tb_terr_lugar_atencion_laboratorio_clan L ON L.PK_lugar_atencion = G.FK_lugar_atencion'
    );
    $sql = "SELECT ".$campos_linea_atencion[$tipo_grupo]."G.PK_Grupo,G.FK_artista_formador,C.VC_Nom_Clan,AA.VC_Nom_Area,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,G.DT_fecha_creacion,G.TX_observaciones FROM tb_terr_grupo_".$tipo_grupo." G
    LEFT JOIN tb_clan C ON C.PK_Id_Clan = G.FK_clan
    LEFT JOIN tb_areas_artisticas AA ON AA.PK_Area_Artistica = G.FK_area_artistica
    LEFT JOIN tb_persona_2017 P ON G.FK_artista_formador = P.PK_Id_Persona
    ".$join_linea_atencion[$tipo_grupo]."
    WHERE FK_organizacion=".$id_organizacion." AND G.estado = 1;";
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarEstudianteYaExisteEnGrupo($datos,$tipo_grupo){
    $estado = 1;
    $sql = "SELECT estado FROM tb_terr_grupo_".$tipo_grupo."_estudiante WHERE FK_estudiante = ".$datos['id_estudiante']." AND FK_grupo = ".$datos['id_grupo'].";";
    $sentencia=$this->db->prepare($sql);
    $sentencia->execute();
    $estado = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    if(isset($estado[0]['estado'])){
      return true;
    }else{
      return false;
    }
  }

            // public function reactivarEstudianteGrupo($id_grupo,$id_estudiante,$fecha_hora,$id_usuario,$observaciones,$tipo_grupo, $bioseguridad){
  public function reactivarEstudianteGrupo($id_grupo,$id_estudiante,$fecha_hora,$id_usuario,$observaciones,$tipo_grupo){
              // $sentencia=$this->db->prepare("UPDATE tb_terr_grupo_".$tipo_grupo."_estudiante SET estado = 1, DT_fecha_ingreso = :fecha_hora, FK_usuario_ingreso = :id_usuario, TX_observaciones = :observaciones, JSON_bioseguridad = :bioseguridad WHERE FK_grupo = :id_grupo AND FK_estudiante = :id_estudiante");
    $sentencia=$this->db->prepare("UPDATE tb_terr_grupo_".$tipo_grupo."_estudiante SET estado = 1, DT_fecha_ingreso = :fecha_hora, FK_usuario_ingreso = :id_usuario, TX_observaciones = :observaciones WHERE FK_grupo = :id_grupo AND FK_estudiante = :id_estudiante");
    @$sentencia->bindParam(':fecha_hora',$fecha_hora);
    @$sentencia->bindParam(':id_usuario',$id_usuario);
    @$sentencia->bindParam(':observaciones',$observaciones);
              // @$sentencia->bindParam(':bioseguridad',$bioseguridad);
    @$sentencia->bindParam(':id_grupo',$id_grupo);
    @$sentencia->bindParam(':id_estudiante',$id_estudiante);
    $sentencia->execute();
    return 2;
  }

  public function consultarModalidad($id_area_artistica){
    $sentencia=$this->db->prepare("SELECT * FROM tb_modalidad WHERE FK_Area_Atencion = :id_area_artistica AND IN_Estado=1");
    @$sentencia->bindParam(':id_area_artistica',$id_area_artistica);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarLugaresAtencionLaboratorio(){
    $sentencia=$this->db->prepare("SELECT * FROM tb_terr_lugar_atencion_laboratorio_clan WHERE estado = 1;");
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function contarEstudiantesActivosGrupo($id_grupo,$tipo_grupo){
    $sentencia = $this->db->prepare("SELECT COUNT(FK_estudiante) AS total FROM tb_terr_grupo_".$tipo_grupo."_estudiante WHERE estado = 1 AND FK_Grupo = ".$id_grupo.";");
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  private function consultarUltimoIdGrupo($tipo_grupo){
    $sentencia=$this->db->prepare("SELECT max(PK_Grupo) AS max FROM tb_terr_grupo_".$tipo_grupo);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarOptionsPoblacionLaboratorio()
  {
    $sentencia=$this->db->prepare("select FK_Value as valor, VC_Descripcion as nombre FROM tb_parametro_detalle WHERE FK_Id_Parametro = 14 AND IN_Estado = 1");
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function removerEstudianteGrupo($datos){
    $set_id_usuario = $this->db->prepare("SET @user_id = '".$datos['id_usuario']."';");
    $sentenciaEstudiante = $this->db->prepare("UPDATE tb_terr_grupo_".$datos['tipo_grupo']."_estudiante SET DT_fecha_retiro=:DT_fecha_retiro,FK_usuario_retiro=:FK_usuario_retiro,estado=:estado,TX_observaciones=:TX_observaciones WHERE FK_grupo=:FK_Grupo AND FK_estudiante=:FK_estudiante");
    try {
      $fecha = date('Y-m-d H:i:s');
      $estado = 0;
      $this->db->beginTransaction();
      $set_id_usuario->execute();
      $sentenciaEstudiante->bindParam(':DT_fecha_retiro', $fecha);
      $sentenciaEstudiante->bindParam(':FK_usuario_retiro', $datos['id_usuario']);
      $sentenciaEstudiante->bindParam(':estado',$estado);
      $sentenciaEstudiante->bindParam(':TX_observaciones', $datos['justificacion']);
      $sentenciaEstudiante->bindParam(':FK_Grupo', $datos['id_grupo']);
      $sentenciaEstudiante->bindParam(':FK_estudiante', $datos['id_estudiante']);
      $sentenciaEstudiante->execute();

      $this->db->commit();
      return "1";
    }catch(PDOExecption $e) {
      $this->db->rollback();
      return "Error!: " . $e->getMessage() . "</br>";
    }
  }

  public function asignarOrganizacionGrupo($datos){
    $set_id_usuario = $this->db->prepare("SET @user_id = '".$datos['id_usuario']."';");
    $sentencia_insert = $this->db->prepare("INSERT INTO tb_terr_grupo_".$datos['tipo_grupo']."_organizacion (FK_grupo,FK_organizacion,FK_usuario_asigno,DT_fecha_asignacion_grupo) VALUES(:FK_grupo,:FK_organizacion,:FK_usuario_asigno,:DT_fecha_asignacion_grupo)");
    $sentencia_update = $this->db->prepare("UPDATE tb_terr_grupo_".$datos['tipo_grupo']." SET FK_organizacion=:FK_organizacion WHERE PK_Grupo=:PK_Grupo");
    try{
      $fecha = date('Y-m-d H:i:s');
      $this->db->beginTransaction();
      $set_id_usuario->execute();

      $sentencia_insert->bindParam(':FK_grupo',$datos['id_grupo']);
      $sentencia_insert->bindParam(':FK_organizacion',$datos['id_organizacion']);
      $sentencia_insert->bindParam(':FK_usuario_asigno',$datos['id_usuario']);
      $sentencia_insert->bindParam(':DT_fecha_asignacion_grupo',$fecha);
      $sentencia_insert->execute();

      $sentencia_update->bindParam(':FK_organizacion',$datos['id_organizacion']);
      $sentencia_update->bindParam(':PK_Grupo',$datos['id_grupo']);
      $sentencia_update->execute();

      $this->db->commit();
      return "1";
    }catch(PDOExecption $e) {
      $this->db->rollback();
      return "Error!: " . $e->getMessage() . "</br>";
    }
  }

  public function asignarArtistaFormadorAGrupo($datos){
    $sql_bitacora = "INSERT INTO tb_terr_grupo_".$datos['tipo_grupo']."_artista_formador (FK_grupo,FK_artista_formador,FK_usuario_asigno,DT_fecha_asignacion_grupo) VALUES(:FK_grupo,:FK_artista_formador,:FK_usuario_asigno,:DT_fecha_asignacion_grupo)";
    $sql_update = "UPDATE tb_terr_grupo_".$datos['tipo_grupo']." SET FK_artista_formador=:FK_artista_formador WHERE PK_Grupo=:FK_grupo;";
    $sql_update_tipo_grupo = "UPDATE tb_terr_grupo_".$datos['tipo_grupo']." SET tipo_grupo=:tipo_grupo WHERE PK_Grupo=:FK_grupo;";
    $sentencia = $this->db->prepare($sql_bitacora);
    $sentencia_update = $this->db->prepare($sql_update);
    $sentencia_update_tipo_grupo = $this->db->prepare($sql_update_tipo_grupo);
    try {
      $fecha_hora = date('Y-m-d H:i:s');
      $this->db->beginTransaction(); 
      $sentencia->bindParam(':FK_grupo', $datos['id_grupo']);
      $sentencia->bindParam(':FK_artista_formador', $datos['id_artista_formador']);
      $sentencia->bindParam(':FK_usuario_asigno', $datos['id_usuario']);
      $sentencia->bindParam(':DT_fecha_asignacion_grupo', $fecha_hora);
      $sentencia->execute();

      $sentencia_update->bindParam(':FK_artista_formador', $datos['id_artista_formador']);
      $sentencia_update->bindParam(':FK_grupo', $datos['id_grupo']);
      $sentencia_update->execute();

      if($datos['tipo_grupo'] == 'arte_escuela'){
        $sentencia_update_tipo_grupo->bindParam(':tipo_grupo', $datos['tipo_grupo_artista']);
        $sentencia_update_tipo_grupo->bindParam(':FK_grupo', $datos['id_grupo']);
        $sentencia_update_tipo_grupo->execute();
      }

      $this->db->commit();
      return 1;
    }catch(PDOExecption $e) { 
      $this->db->rollback(); 
      return "Error!: " . $e->getMessage() . "</br>"; 
    }
  }

  public function consultarTipoAtencionGrupo($id_grupo,$tipo_grupo){
    $sql="SELECT tipo_grupo FROM tb_terr_grupo_".$tipo_grupo." WHERE PK_Grupo=:id_grupo;";
    $sentencia=$this->db->prepare($sql);
    $sentencia->bindParam(':id_grupo', $id_grupo);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0];
  }

  public function consultarIDUltimaOrganizacionUsuario($id_usuario){
    $sql="SELECT FK_Organizacion FROM tb_af_organizacion_area_artistica WHERE FK_Id_Persona = :FK_Id_Persona AND IN_estado = 1 ORDER BY DT_Fecha_Asignacion DESC LIMIT 1;";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':FK_Id_Persona',$id_usuario);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarIDOrganizacionUsuario($id_usuario){
    $sql="SELECT FK_Organizacion,VC_Nom_Organizacion FROM tb_af_organizacion_area_artistica AOAA 
    LEFT JOIN tb_organizaciones_2017 O ON AOAA.FK_Organizacion = O.PK_Id_Organizacion 
    WHERE FK_Id_Persona = :FK_Id_Persona AND IN_estado = 1 ORDER BY DT_Fecha_Asignacion;";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':FK_Id_Persona',$id_usuario);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarAliadosLaboratorioCrea($id_institucion){
    $sql="SELECT * FROM tb_terr_grupo_laboratorio_crea_aliado WHERE FK_Institucion = :FK_Institucion AND IN_Estado = 1;";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':FK_Institucion',$id_institucion);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarTipoPoblacionLaboratorio($id_categoria_poblacion){
    $sql="SELECT * FROM tb_terr_grupo_laboratorio_crea_tipo_poblacion WHERE FK_Id_Categoria = :id_categoria_poblacion AND IN_estado = 1;";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_categoria_poblacion',$id_categoria_poblacion);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarGruposPorLineaPorArea($anio, $linea, $area_artistica){
    $sql="SELECT T.* FROM (
    SELECT 
    DISTINCT SC.FK_grupo,
    CONCAT('AE-',SC.FK_grupo) AS 'Nombre',
    1 AS 'linea'
    FROM tb_terr_grupo_arte_escuela_sesion_clase SC 
    JOIN tb_valoracion_grupo V ON V.FK_Grupo=SC.FK_grupo
    WHERE YEAR(SC.DA_fecha_clase)=:anio AND SC.FK_area_artistica=:area_artistica AND V.IN_Estado=1 AND V.FK_Linea_Atencion='arte_escuela'
    UNION
    SELECT 
    DISTINCT SC.FK_grupo,
    CONCAT('EC-',SC.FK_grupo),
    2 AS 'linea'
    FROM tb_terr_grupo_emprende_clan_sesion_clase SC 
    JOIN tb_valoracion_grupo V ON V.FK_Grupo=SC.FK_grupo
    WHERE YEAR(SC.DA_fecha_clase)=:anio AND SC.FK_area_artistica=:area_artistica AND V.IN_Estado=1 AND V.FK_Linea_Atencion='emprende_clan'
    UNION
    SELECT 
    DISTINCT SC.FK_grupo,
    CONCAT('LC-',SC.FK_grupo),
    3 AS 'linea'
    FROM tb_terr_grupo_laboratorio_clan_sesion_clase SC 
    JOIN tb_valoracion_grupo V ON V.FK_Grupo=SC.FK_grupo
    WHERE YEAR(SC.DA_fecha_clase)=:anio AND SC.FK_area_artistica=:area_artistica AND V.IN_Estado=1 AND V.FK_Linea_Atencion='laboratorio_clan'
    ) T 
    WHERE T.linea = :linea";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':anio',$anio);
    @$sentencia->bindParam(':linea',$linea);
    @$sentencia->bindParam(':area_artistica',$area_artistica);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarColegioGrupo($datos){
    if ($datos['tipo_grupo'] != 'arte_escuela') {
      return "No aplica (Línea de Atención)";
    }else{
      $sql="SELECT C.PK_Id_Colegio,C.VC_Nom_Colegio FROM tb_terr_grupo_arte_escuela G 
      LEFT JOIN tb_colegios C ON C.PK_Id_Colegio = G.FK_colegio 
      WHERE G.PK_Grupo = :id_grupo";
      @$sentencia=$this->db->prepare($sql);
      @$sentencia->bindParam(':id_grupo',$datos['id_grupo']);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0]['VC_Nom_Colegio'];
    }
  }

  public function consultarAreaArtisticaGrupo($datos){
    $sql="SELECT PK_Area_Artistica,AA.VC_Nom_Area FROM tb_terr_grupo_".$datos['tipo_grupo']." G 
    LEFT JOIN tb_areas_artisticas AA ON AA.Pk_Area_Artistica = G.FK_area_artistica 
    WHERE G.PK_Grupo = :id_grupo";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_grupo',$datos['id_grupo']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarConvenioGrupo($datos){
    $sql="SELECT CONVENIO.VC_Descripcion AS convenio FROM tb_terr_grupo_".$datos['tipo_grupo']." G 
    LEFT JOIN tb_parametro_detalle CONVENIO ON CONVENIO.FK_Value = G.IN_convenio AND CONVENIO.FK_Id_Parametro=68 
    WHERE G.PK_Grupo = :id_grupo";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_grupo',$datos['id_grupo']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarEngargadoCREAGrupo($datos){
    $sql="SELECT P.PK_Id_Persona,G.FK_clan, CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS nombre_coordinador, C.VC_Nom_Clan AS nombre_crea 
    FROM tb_terr_grupo_".$datos['tipo_grupo']." G
    LEFT JOIN tb_clan C ON C.PK_Id_Clan = G.FK_clan
    LEFT JOIN tb_persona_2017 P ON P.PK_Id_Persona = C.FK_Persona_Administrador
    WHERE G.PK_Grupo = :id_grupo";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_grupo',$datos['id_grupo']);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

          /***************************************************************************
          /* consultarPromedioAsistentesGrupo() obtiene el promedio de asistentes de un grupo.
          ***************************************************************************/
          public function consultarPromedioAsistentesGrupo($id_grupo, $tipo_grupo){
            if ($tipo_grupo == 'arte_escuela') {
              $sql="SELECT FORMAT(T.CANTIDAD_BENEFICIARIOS/T.CANTIDAD_SESIONES,2) AS PROMEDIO FROM (
              SELECT
              COUNT(SCA.FK_estudiante) AS 'CANTIDAD_BENEFICIARIOS',
              COUNT(DISTINCT SCA.FK_sesion_clase) AS 'CANTIDAD_SESIONES'
              FROM tb_terr_grupo_arte_escuela_sesion_clase S
              JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=S.PK_sesion_clase
              WHERE S.FK_grupo=:id_grupo AND SCA.IN_estado_asistencia=1) T";
            }
            if ($tipo_grupo == 'emprende_clan') {
              $sql="SELECT FORMAT(T.CANTIDAD_BENEFICIARIOS/T.CANTIDAD_SESIONES,2) AS PROMEDIO FROM (
              SELECT
              COUNT(SCA.FK_estudiante) AS 'CANTIDAD_BENEFICIARIOS',
              COUNT(DISTINCT SCA.FK_sesion_clase) AS 'CANTIDAD_SESIONES'
              FROM tb_terr_grupo_emprende_clan_sesion_clase S
              JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=S.PK_sesion_clase
              WHERE S.FK_grupo=:id_grupo AND SCA.IN_estado_asistencia=1) T";
            }
            if ($tipo_grupo == 'laboratorio_clan') {
              $sql="SELECT FORMAT(T.CANTIDAD_BENEFICIARIOS/T.CANTIDAD_SESIONES,2) AS PROMEDIO FROM (
              SELECT
              COUNT(SCA.FK_estudiante) AS 'CANTIDAD_BENEFICIARIOS',
              COUNT(DISTINCT SCA.FK_sesion_clase) AS 'CANTIDAD_SESIONES'
              FROM tb_terr_grupo_laboratorio_clan_sesion_clase S
              JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=S.PK_sesion_clase
              WHERE S.FK_grupo=:id_grupo AND SCA.IN_estado_asistencia=1) T";
            }
            @$sentencia=$this->db->prepare($sql);
            @$sentencia->bindParam(':id_grupo',$id_grupo);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
          }

          /***************************************************************************
          /* consultarFechaPrimerClaseGrupo() consulta la fecha de la primer clase del grupo de la línea indicada.
          ***************************************************************************/
          public function consultarFechaPrimerClaseGrupo($id_grupo, $tipo_grupo){
           $sql="SELECT MIN(SC.DA_fecha_clase) AS primer_clase FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase SC WHERE FK_grupo = :id_grupo;";
           @$sentencia=$this->db->prepare($sql);
           @$sentencia->bindParam(':id_grupo',$id_grupo);
           $sentencia->execute();
           return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
         }
         public function consultarFechaPrimerClaseGrupoFormador($id_grupo, $tipo_grupo, $id_formador){
           $sql="SELECT MIN(SC.DA_fecha_clase) AS primer_clase FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase SC WHERE FK_grupo = :id_grupo AND FK_usuario = :id_formador;";
           @$sentencia=$this->db->prepare($sql);
           @$sentencia->bindParam(':id_grupo',$id_grupo);
           @$sentencia->bindParam(':id_formador',$id_formador);
           $sentencia->execute();
           return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
         }

         public function crearGrupoTransicion($datos,$horario){
          try {
            $this->db->beginTransaction();
            $sql = "INSERT INTO tb_terr_grupo_transicion(FK_artista_crea,FK_artista_nidos,TX_lugar_atencion,horario_json,FK_creador,TX_observaciones,FK_crea) 
            VALUES(:FK_artista_crea,:FK_artista_nidos,:TX_lugar_atencion,:horario_json,:FK_creador,:TX_observaciones,:FK_crea);";
            @$sentencia=$this->db->prepare($sql);
            @$sentencia->bindParam(':FK_artista_crea',$datos['SL_artista_crea']);
            @$sentencia->bindParam(':FK_artista_nidos',$datos['SL_artista_nidos']);
            @$sentencia->bindParam(':TX_lugar_atencion',$datos['TX_lugar_atencion']);
            @$sentencia->bindParam(':horario_json',json_encode($horario));
            @$sentencia->bindParam(':FK_creador',$datos['id_usuario']);
            @$sentencia->bindParam(':TX_observaciones',$datos['TX_observaciones']);
            @$sentencia->bindParam(':FK_crea',$datos['SL_crea']);
            $sentencia->execute();
            $this->db->commit();
            return "1";
          }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
          }
        }

        public function consultarGruposTransicion(){
          $sql = "SELECT G.*,
          CONCAT(P1.VC_Primer_Nombre,' ',P1.VC_Segundo_Nombre,' ',P1.VC_Primer_Apellido,' ',P1.VC_Segundo_Apellido) AS artista_crea,
          CONCAT(P2.VC_Primer_Nombre,' ',P2.VC_Segundo_Nombre,' ',P2.VC_Primer_Apellido,' ',P2.VC_Segundo_Apellido) AS artista_nidos
          FROM tb_terr_grupo_transicion G
          LEFT JOIN tb_persona_2017 P1 ON G.FK_artista_crea = P1.PK_Id_Persona
          LEFT JOIN tb_persona_2017 P2 ON G.FK_artista_nidos = P2. PK_Id_Persona";
          @$sentencia=$this->db->prepare($sql);
          $sentencia->execute();
          return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function consultarMisGruposTransicion($id_usuario){
          $sql = "SELECT G.* FROM tb_terr_grupo_transicion G WHERE FK_artista_crea = $id_usuario OR FK_artista_nidos = $id_usuario;";
          @$sentencia=$this->db->prepare($sql);
          $sentencia->execute();
          return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function consultarBeneficiariosTransicionMenores($id_grupo){
          $sql = "SELECT E.*,TIMESTAMPDIFF(YEAR, DD_F_Nacimiento, CURDATE()) AS edad 
          FROM tb_estudiante E 
          RIGHT JOIN tb_terr_grupo_transicion_estudiante GE ON E.id = GE.FK_estudiante 
          WHERE TIMESTAMPDIFF(YEAR, DD_F_Nacimiento, CURDATE()) <= 5 AND FK_grupo=:id_grupo;";
          @$sentencia=$this->db->prepare($sql);
          @$sentencia->bindParam(':id_grupo',$id_grupo);
          $sentencia->execute();
          return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function consultarBeneficiariosTransicionMayores($id_grupo){
          $sql = "SELECT E.*,TIMESTAMPDIFF(YEAR, DD_F_Nacimiento, CURDATE()) AS edad 
          FROM tb_estudiante E 
          RIGHT JOIN tb_terr_grupo_transicion_estudiante GE ON E.id = GE.FK_estudiante 
          WHERE TIMESTAMPDIFF(YEAR, DD_F_Nacimiento, CURDATE()) > 5 AND FK_grupo=:id_grupo;";
          @$sentencia=$this->db->prepare($sql);
          @$sentencia->bindParam(':id_grupo',$id_grupo);
          $sentencia->execute();
          return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getListadoTodosBeneficiariosGrupo($id_grupo,$tipo_grupo){
          $sql="SELECT E.id,E.IN_Identificacion, CONCAT(E.VC_Primer_Nombre,' ',E.VC_Segundo_Nombre,' ',E.VC_Primer_Apellido,' ',E.VC_Segundo_Apellido) AS Nombre
          FROM tb_terr_grupo_".$tipo_grupo."_estudiante GE
          INNER JOIN tb_estudiante E ON GE.FK_estudiante = E.id
          WHERE GE.FK_Grupo = ".$id_grupo;
          $sentencia=$this->db->prepare($sql);
          $sentencia->execute();
          return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function consultarGruposFiltroSelect($datos){
          $tipo_grupo=$datos["tipo_grupo"];
          $campos_linea_atencion = array(
            'arte_escuela' => 'COL.Vc_Nom_Colegio,IN_lugar_atencion,',
            'emprende_clan' => 'M.VC_Nom_Modalidad,',
            'laboratorio_clan' => 'G.tipo_poblacion,L.VC_Nombre_Lugar,'
          );
          $join_linea_atencion = array(
            'arte_escuela' => ' LEFT JOIN tb_colegios COL ON COL.PK_Id_Colegio = G.FK_colegio ',
            'emprende_clan' => ' LEFT JOIN tb_modalidad M ON M.PK_Id_Modalidad = G.FK_modalidad ',
            'laboratorio_clan' => ' LEFT JOIN tb_terr_lugar_atencion_laboratorio_clan L ON L.PK_lugar_atencion = G.FK_lugar_atencion'
          );
          $sql = "SELECT ".$campos_linea_atencion[$tipo_grupo]."G.PK_Grupo,G.estado,G.FK_clan,G.FK_artista_formador,C.VC_Nom_Clan,AA.VC_Nom_Area,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,G.DT_fecha_creacion,G.TX_observaciones FROM tb_terr_grupo_".$tipo_grupo." G
          LEFT JOIN tb_clan C ON C.PK_Id_Clan = G.FK_clan
          LEFT JOIN tb_areas_artisticas AA ON AA.PK_Area_Artistica = G.FK_area_artistica
          LEFT JOIN tb_persona_2017 P ON G.FK_artista_formador = P.PK_Id_Persona
          ".$join_linea_atencion[$tipo_grupo]."
          WHERE FK_organizacion=".$datos["id_organizacion"]." 
          AND C.PK_Id_Clan IN(".implode(",",$datos["id_crea"]).") 
          AND AA.PK_Area_Artistica IN(".implode(",",$datos["id_area_artistica"]).") 
          AND G.estado IN (1,2);";
          $sentencia=$this->db->prepare($sql);
          $sentencia->execute();
          return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function consultarCantidadAcumuladoAtentidosGrupo($id_grupo, $linea_atencion){
          $sql = "SELECT COUNT(DISTINCT SCA.FK_estudiante) AS total_acumulado
          FROM tb_terr_grupo_".$linea_atencion."_sesion_clase SC
          JOIN tb_terr_grupo_".$linea_atencion."_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=SC.PK_sesion_clase
          WHERE SCA.IN_estado_asistencia=1 AND SC.FK_grupo=:id_grupo";
          @$sentencia=$this->db->prepare($sql);
          @$sentencia->bindParam(':id_grupo',$id_grupo);
          $sentencia->execute();
          return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getListadoAcumuladoAtendidosGrupo($id_grupo, $linea_atencion){
          $sql = "SELECT
          E.IN_Identificacion,
          E.VC_Primer_Nombre,
          E.VC_Segundo_Nombre,
          E.VC_Primer_Apellido,
          E.VC_Segundo_Apellido,
          MIN(SC.DA_fecha_clase) AS primer_asistencia,
          COUNT(DISTINCT SCA.FK_sesion_clase) AS asistencias
          FROM tb_terr_grupo_".$linea_atencion."_sesion_clase SC
          JOIN tb_terr_grupo_".$linea_atencion."_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=SC.PK_sesion_clase
          JOIN tb_estudiante E ON SCA.FK_estudiante=E.id
          WHERE SCA.IN_estado_asistencia=1 AND SC.FK_grupo=:id_grupo
          GROUP BY SCA.FK_estudiante";
          @$sentencia=$this->db->prepare($sql);
          @$sentencia->bindParam(':id_grupo',$id_grupo);
          $sentencia->execute();
          return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getAtencionMensualGrupo($id_grupo, $linea_atencion){
          $sql = "SELECT
          CASE
          WHEN MONTH(SC.DA_fecha_clase) = 1 THEN 'ENERO'
          WHEN MONTH(SC.DA_fecha_clase) = 2 THEN 'FEBRERO'
          WHEN MONTH(SC.DA_fecha_clase) = 3 THEN 'MARZO'
          WHEN MONTH(SC.DA_fecha_clase) = 4 THEN 'ABRIL'
          WHEN MONTH(SC.DA_fecha_clase) = 5 THEN 'MAYO'
          WHEN MONTH(SC.DA_fecha_clase) = 6 THEN 'JUNIO'
          WHEN MONTH(SC.DA_fecha_clase) = 7 THEN 'JULIO'
          WHEN MONTH(SC.DA_fecha_clase) = 8 THEN 'AGOSTO'
          WHEN MONTH(SC.DA_fecha_clase) = 9 THEN 'SEPTIEMBRE'
          WHEN MONTH(SC.DA_fecha_clase) = 10 THEN 'OCTUBRE'
          WHEN MONTH(SC.DA_fecha_clase) = 11 THEN 'NOVIEMBRE'
          WHEN MONTH(SC.DA_fecha_clase) = 12 THEN 'DICIEMBRE'
          END AS 'X',
          COUNT(DISTINCT SCA.FK_estudiante) AS 'Y',
          CONCAT('#',SUBSTRING((LPAD(HEX(ROUND(RAND() * 10000000)), 6, 0)),- 6)) AS 'color'
          FROM tb_terr_grupo_".$linea_atencion."_sesion_clase SC
          JOIN tb_terr_grupo_".$linea_atencion."_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=SC.PK_sesion_clase
          WHERE SC.FK_grupo=:id_grupo AND SCA.IN_estado_asistencia=1
          GROUP BY MONTH(SC.DA_fecha_clase) ORDER BY MONTH(SC.DA_fecha_clase) ASC;";
          @$sentencia=$this->db->prepare($sql);
          @$sentencia->bindParam(':id_grupo',$id_grupo);
          $sentencia->execute();
          return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function quitarArtistaFormadorGrupo($datos) {
          $sql = "UPDATE tb_terr_grupo_".$datos['tipo_grupo']." SET FK_artista_formador=NULL  WHERE PK_Grupo = ".$datos['id_grupo'].";";
          $sentencia=$this->db->prepare($sql);
          $sentencia->execute();
          return 1;
        }
      }
