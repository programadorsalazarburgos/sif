<?php

namespace General\Persistencia\DAOS;
use General\Persistencia\Entidades\TbTerrGrupoSesionClase;

class SesionClaseDAO extends GestionDAO {

    private $db;
    private $estudiante_array;

    function __construct()
    {
        $this->db=$this->obtenerPDOBD();
    }


    public function eliminarObjeto($objeto) {
        $this->eliminarEstudiantesSesionClase($objeto);
        $this->eliminarSesionClase($objeto);
    }

    public function consultarObjeto($objeto) {
        consultarEstudiantesAsistenciaSesionClase();
        consultarObservacionSessionClase();
    }

    public function crearObjeto($objeto) {}

    public function crearRegistroSesionClase($objeto,$id_usuario_web) {
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$id_usuario_web.";");
        $array_campos =
        array("arte_escuela"=>"IN_lugar_atencion,FK_colegio,VC_Nom_colegio,hora_inicio,hora_fin",
          "emprende_clan"=>"FK_modalidad, IN_Tipo_Ubicacion",
          "laboratorio_clan"=>"FK_lugar_atencion,tipo_poblacion,FK_Institucion,FK_Aliado,IN_Tipo_Ubicacion,TX_Sitio");
        $array_valores=
        array("arte_escuela"=>" :IN_lugar_atencion, :FK_colegio, :VC_Nom_colegio, :hora_inicio, :hora_fin",
          "emprende_clan"=>" :FK_modalidad, :IN_Tipo_Ubicacion",
          "laboratorio_clan"=>" :FK_lugar_atencion, :tipo_poblacion, :FK_Institucion, :FK_Aliado, :IN_Tipo_Ubicacion, :TX_Sitio");
        $sentencia = $this->db->prepare("INSERT INTO tb_terr_grupo_".$objeto->getTipoGrupo()."_sesion_clase (FK_grupo,DA_fecha_clase,DT_fecha_creacion_registro,IN_horas_clase,FK_usuario,FK_organizacion,TX_observaciones,suplencia,FK_Clan,VC_Nom_Clan,FK_area_artistica,tipo_grupo, FK_salon, IN_Modalidad_Atencion, IN_Tipo_Atencion, IN_Material,".$array_campos[$objeto->getTipoGrupo()].")  VALUES (:FK_grupo, :DA_fecha_clase, :DT_fecha_creacion_registro, :IN_horas_clase, :FK_usuario, :FK_organizacion, :TX_observaciones, :suplencia, :FK_Clan, :VC_Nom_Clan, :FK_area_artistica,:tipo_grupo, :FK_salon, :IN_Modalidad_Atencion, :IN_Tipo_Atencion, :IN_Material,".$array_valores[$objeto->getTipoGrupo()].")");
        @$sentencia->bindParam(':FK_grupo',$objeto->getFkGrupo());
        @$sentencia->bindParam(':DA_fecha_clase',$objeto->getDaFechaClase());
        @$sentencia->bindParam(':DT_fecha_creacion_registro',$objeto->getDtFechaCreacionRegistro());
        @$sentencia->bindParam(':IN_horas_clase',$objeto->getInHorasClase());
        @$sentencia->bindParam(':FK_salon',$objeto->getFkSalon());
        @$sentencia->bindParam(':FK_usuario',$objeto->getFkUsuario());
        @$sentencia->bindParam(':FK_organizacion',$objeto->getFkOrganizacion());
        @$sentencia->bindParam(':TX_observaciones',$objeto->getTxObservaciones());
        @$sentencia->bindParam(':suplencia',$objeto->getSuplencia());
        @$sentencia->bindParam(':FK_Clan',$objeto->getFkClan());
        @$sentencia->bindParam(':VC_Nom_Clan',$objeto->getVcNomClan());
        @$sentencia->bindParam(':FK_area_artistica',$objeto->getFkAreaArtistica());
        @$sentencia->bindParam(':tipo_grupo',$objeto->getTipoGrupoAtencion());
        @$sentencia->bindParam(':IN_Modalidad_Atencion',$objeto->getInModalidadAtencion());
        @$sentencia->bindParam(':IN_Tipo_Atencion',$objeto->getInTipoAtencion());
        @$sentencia->bindParam(':IN_Material',$objeto->getInMaterial());
        switch ($objeto->getTipoGrupo()) {
            case 'arte_escuela':
            @$sentencia->bindParam(':FK_colegio',$objeto->getFkColegio());
            @$sentencia->bindParam(':VC_Nom_colegio',$objeto->getVcNomColegio());
            @$sentencia->bindParam(':IN_lugar_atencion',$objeto->getInLugarAtencion());
            @$sentencia->bindParam(':hora_inicio',$objeto->getHoraInicio());
            @$sentencia->bindParam(':hora_fin',$objeto->getHoraFin());
            break;
            case 'emprende_clan':
            @$sentencia->bindParam(':FK_modalidad',$objeto->getFkModalidad());
            @$sentencia->bindParam(':IN_Tipo_Ubicacion',$objeto->getInTipoUbicacion());
            break;
            case 'laboratorio_clan':
            @$sentencia->bindParam(':FK_lugar_atencion',$objeto->getFkLugarAtencion());
            @$sentencia->bindParam(':tipo_poblacion',$objeto->getTipoPoblacion());
            @$sentencia->bindParam(':FK_Institucion',$objeto->getFkInstitucion());
            @$sentencia->bindParam(':FK_Aliado',$objeto->getFkAliado());
            @$sentencia->bindParam(':IN_Tipo_Ubicacion',$objeto->getInTipoUbicacion());
            @$sentencia->bindParam(':TX_Sitio',$objeto->getTxSitio());
            break;
            default:
            break;
        }
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $id_insertado = $this->db->lastInsertId();
            $sentenciaAsistencia = $this->db->prepare("INSERT INTO tb_terr_grupo_".$objeto->getTipoGrupo()."_sesion_clase_asistencia VALUES (:FK_sesion_clase, :FK_estudiante, :IN_estado_asistencia, :IN_Modalidad_Atencion, :IN_Tipo_Atencion)");
            $sentenciaAsistencia->bindParam(':FK_sesion_clase', $sesion);
            
            $array_asistencia_estudiantes = $objeto->getEstudianteArray();
            $array_atencion_estudiantes = $objeto->getAtencionArray();
            $in_tipo_atencion = $objeto->getInTipoAtencion();
            for ($i=0; $i < count($array_asistencia_estudiantes); $i++) { 
                $sesion=$id_insertado;
                $id_estudiante=$array_asistencia_estudiantes[$i][0];
                $asistencia=($array_asistencia_estudiantes[$i][1]) ? 1 : 0;
                if($asistencia == 1){
                    $modalidad_atencion = ($array_atencion_estudiantes[$i][1]) ? 1 : 2;
                    if($in_tipo_atencion == 4) $tipo_atencion = ($array_atencion_estudiantes[$i][1]) ? 1 : 2;
                    if($in_tipo_atencion == 5) $tipo_atencion = ($array_atencion_estudiantes[$i][1]) ? 1 : 3;
                    if($in_tipo_atencion == 6) {
                        $modalidad_atencion = 2;
                        $tipo_atencion = ($array_atencion_estudiantes[$i][1]) ? 2 : 3;
                    }
                }
                else{
                    $modalidad_atencion = null;
                    $tipo_atencion = null;
                }
                
                //Si la modalidad es MIXTO toma los datos de cada beneficiario, si no, la toma de los SELECTS.
                if($objeto->getInModalidadAtencion()==3){
                    $sentenciaAsistencia->bindParam(':IN_Modalidad_Atencion', $modalidad_atencion);
                    $sentenciaAsistencia->bindParam(':IN_Tipo_Atencion', $tipo_atencion);
                }
                else{
                    if($asistencia==1){
                        $sentenciaAsistencia->bindParam(':IN_Modalidad_Atencion', $objeto->getInModalidadAtencion());
                        $sentenciaAsistencia->bindParam(':IN_Tipo_Atencion', $objeto->getInTipoAtencion());
                    }
                    else{
                        $sentenciaAsistencia->bindParam(':IN_Modalidad_Atencion', $modalidad_atencion);
                        $sentenciaAsistencia->bindParam(':IN_Tipo_Atencion', $tipo_atencion);
                    }
                }
                $sentenciaAsistencia->bindParam(':FK_estudiante', $id_estudiante);
                $sentenciaAsistencia->bindParam(':IN_estado_asistencia', $asistencia);
                $sentenciaAsistencia->execute();
            }
            // //var_dump($array_asistencia_estudiantes);
            // foreach ($objeto->getEstudianteArray() as $estudiante) {
            //     //var_dump($estudiante);
            //     // $sesion=$id_insertado;
            //     // $id_estudiante=$estudiante[0];
            //     // $asistencia=($estudiante[1]) ? 1 : 0;
            //     // $modalidad = 
            //     // $sentenciaAsistencia->bindParam(':IN_Modalidad_Atencion', $asistencia);
            //     // $sentenciaAsistencia->bindParam(':IN_Tipo_Atencion', $asistencia);
            //     // $sentenciaAsistencia->bindParam(':IN_estado_asistencia', $asistencia);
            //     // $sentenciaAsistencia->execute();
            // }
            $this->db->commit();
            return $id_insertado;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function guardarSesionClaseEvento($datos,$array_estudiante){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
        $sentencia = $this->db->prepare("INSERT INTO tb_circ_evento_sesion_clase (tipo_grupo,FK_evento,FK_grupo,DA_fecha_sesion_clase,DT_fecha_creacion_registro,IN_horas_clase,FK_usuario,TX_observaciones)  VALUES (:tipo_grupo, :FK_evento, :FK_grupo, :DA_fecha_sesion_clase, :DT_fecha_creacion_registro, :IN_horas_clase, :FK_usuario, :TX_observaciones)");
        @$sentencia->bindParam(':tipo_grupo',$datos['tipo_grupo']);
        @$sentencia->bindParam(':FK_evento',$datos['id_evento']);
        @$sentencia->bindParam(':FK_grupo',$datos['id_grupo']);
        @$sentencia->bindParam(':DA_fecha_sesion_clase',$datos['fecha_clase']);
        @$sentencia->bindParam(':DT_fecha_creacion_registro',date('Y-m-d H:i:s'));
        @$sentencia->bindParam(':IN_horas_clase',$datos['total_horas']);
        @$sentencia->bindParam(':FK_usuario',$datos['id_usuario']);
        @$sentencia->bindParam(':TX_observaciones',$datos['observaciones']);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $id_insertado = $this->db->lastInsertId();
            $sentenciaAsistencia = $this->db->prepare("INSERT INTO tb_circ_evento_sesion_clase_asistencia VALUES (:FK_sesion_clase, :FK_estudiante, :IN_estado_asistencia)");
            $sentenciaAsistencia->bindParam(':FK_sesion_clase', $sesion);
            $sentenciaAsistencia->bindParam(':FK_estudiante', $id_estudiante);
            $sentenciaAsistencia->bindParam(':IN_estado_asistencia', $asistencia);
            foreach ($array_estudiante as $estudiante) {
                $sesion=$id_insertado;
                $id_estudiante=$estudiante[0];
                $asistencia=$estudiante[1];
                $sentenciaAsistencia->execute();
            }
            $this->db->commit();
            return $id_insertado;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function modificarObjeto($objeto) {
        if($objeto->getTipoGrupo() == "arte_escuela") {
            $campo_lugar_atencion = ", IN_lugar_atencion =".$objeto->getInLugarAtencion();
            $campo_sitio = "";
        }
        if($objeto->getTipoGrupo() == "emprende_clan") {
            $campo_lugar_atencion = ", IN_Tipo_Ubicacion =".$objeto->getInTipoUbicacion();
            $campo_sitio = "";
        }
        if($objeto->getTipoGrupo() == "laboratorio_clan") {
            $campo_lugar_atencion = ", IN_Tipo_Ubicacion =".$objeto->getInTipoUbicacion();
            $campo_sitio = ", TX_Sitio ='".$objeto->getTxSitio()."'";
        }
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$objeto->getFkUsuario().";");
        
        $sentencia = $this->db->prepare("UPDATE tb_terr_grupo_".$objeto->getTipoGrupo()."_sesion_clase SET IN_Modalidad_Atencion=:IN_Modalidad_Atencion, IN_Tipo_Atencion=:IN_Tipo_Atencion, IN_Material='".$objeto->getInMaterial()."', TX_observaciones='".$objeto->getTxObservaciones()."', FK_salon='".$objeto->getFkSalon()."'".$campo_lugar_atencion.$campo_sitio." WHERE PK_sesion_clase=".$objeto->getPkSesionClase());
        $sentencia->bindParam(':IN_Modalidad_Atencion', $objeto->getInModalidadAtencion());
        $sentencia->bindParam(':IN_Tipo_Atencion', $objeto->getInTipoAtencion());
        $sentencia->execute();

        $sentenciaDelete = $this->db->prepare("DELETE FROM tb_terr_grupo_".$objeto->getTipoGrupo()."_sesion_clase_asistencia WHERE FK_sesion_clase=".$objeto->getPkSesionClase());
        $sentenciaDelete->execute();
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentenciaAsistencia = $this->db->prepare("INSERT INTO tb_terr_grupo_".$objeto->getTipoGrupo()."_sesion_clase_asistencia VALUES (:FK_sesion_clase, :FK_estudiante, :IN_estado_asistencia, :IN_Modalidad_Atencion, :IN_Tipo_Atencion)");
            @$sentenciaAsistencia->bindParam(':FK_sesion_clase', $objeto->getPkSesionClase());
            $array_asistencia_estudiantes = $objeto->getEstudianteArray();
            $array_atencion_estudiantes = $objeto->getAtencionArray();
            $in_tipo_atencion = $objeto->getInTipoAtencion();
            for ($i=0; $i < count($array_asistencia_estudiantes); $i++) { 
                $id_estudiante=$array_asistencia_estudiantes[$i][0];
                $asistencia=($array_asistencia_estudiantes[$i][1]) ? 1 : 0;
                if($asistencia == 1){
                    $modalidad_atencion = ($array_atencion_estudiantes[$i][1]) ? 1 : 2;
                    if($in_tipo_atencion == 4) $tipo_atencion = ($array_atencion_estudiantes[$i][1]) ? 1 : 2;
                    if($in_tipo_atencion == 5) $tipo_atencion = ($array_atencion_estudiantes[$i][1]) ? 1 : 3;
                    if($in_tipo_atencion == 6) {
                        $modalidad_atencion = 2;
                        $tipo_atencion = ($array_atencion_estudiantes[$i][1]) ? 2 : 3;
                    }
                }
                else{
                    $modalidad_atencion = null;
                    $tipo_atencion = null;
                } 
                //Si la modalidad es MIXTO toma los datos de cada beneficiario, si no, la toma de los SELECTS.
                if($objeto->getInModalidadAtencion()==3){
                    $sentenciaAsistencia->bindParam(':IN_Modalidad_Atencion', $modalidad_atencion);
                    $sentenciaAsistencia->bindParam(':IN_Tipo_Atencion', $tipo_atencion);
                }
                else{
                    if($asistencia==1){
                        $sentenciaAsistencia->bindParam(':IN_Modalidad_Atencion', $objeto->getInModalidadAtencion());
                        $sentenciaAsistencia->bindParam(':IN_Tipo_Atencion', $objeto->getInTipoAtencion());
                    }
                    else{
                        $sentenciaAsistencia->bindParam(':IN_Modalidad_Atencion', $modalidad_atencion);
                        $sentenciaAsistencia->bindParam(':IN_Tipo_Atencion', $tipo_atencion);
                    }
                }
                $sentenciaAsistencia->bindParam(':FK_estudiante', $id_estudiante);
                $sentenciaAsistencia->bindParam(':IN_estado_asistencia', $asistencia);
                
                $sentenciaAsistencia->execute();
            }
            $this->db->commit();
            return 1;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function validarFechaSesionClase($id_grupo,$fecha,$tipo_grupo){
        $sql="SELECT FK_grupo FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase WHERE FK_grupo=".$id_grupo." AND DA_fecha_clase='".$fecha."';";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarObservacionSesionClase($id_sesion_clase,$tipo_grupo){
        $sql="SELECT TX_observaciones FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase WHERE PK_sesion_clase=".$id_sesion_clase.";";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarGruposMisSesionesMes($id_usuario,$fecha_inicial,$tipo_grupo){
        $ubicacion = "";
        switch ($tipo_grupo) {
            case 'arte_escuela':
            $ubicacion = ", IN_lugar_atencion AS tipo_ubicacion";
            break;
            case 'emprende_clan':
            $ubicacion = "";
            break;
            case 'laboratorio_clan':
            $ubicacion = ", IN_Tipo_Ubicacion AS tipo_ubicacion";
            break;
        }
        $sql="SELECT FK_Grupo, FK_clan, suplencia".$ubicacion."
        FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase
        WHERE FK_usuario = $id_usuario
        AND Month(DA_fecha_clase) = Month('".$fecha_inicial."') 
        AND Year(DA_fecha_clase) = Year('".$fecha_inicial."') GROUP BY FK_Grupo;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarGruposMisSesionesEventoMes($id_usuario,$fecha_inicial,$tipo_grupo){
        $sql = "SELECT DISTINCT FK_grupo FROM tb_circ_evento_sesion_clase 
        WHERE FK_usuario = $id_usuario
        AND Month(DA_fecha_sesion_clase) = Month('".$fecha_inicial."') 
        AND Year(DA_fecha_sesion_clase) = Year('".$fecha_inicial."') AND tipo_grupo = '".$tipo_grupo."';";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarFechaSesionGrupoParaModificar($id_grupo,$id_usuario,$tipo_grupo,$fecha_inicial){
        switch ($tipo_grupo) {
            case 'arte_escuela':
            $lugar_atencion = ', IN_lugar_atencion AS tipo_ubicacion';
            break;
            case 'emprende_clan':
            $lugar_atencion = ', IN_Tipo_Ubicacion AS tipo_ubicacion';
            break;
            case 'laboratorio_clan':
            $lugar_atencion = ', IN_Tipo_Ubicacion AS tipo_ubicacion';
            break;
        };

        $sql="SELECT PK_sesion_clase,DA_fecha_clase,IN_Modalidad_Atencion, IN_Tipo_Atencion".$lugar_atencion.", FK_salon
        FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase
        WHERE FK_usuario = $id_usuario
        AND FK_grupo = $id_grupo
        AND DA_fecha_clase >= '".$fecha_inicial."';";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarEstudiantesAsistenciaSesionClase($id_sesion_clase,$tipo_grupo){
        $sql="SELECT A.IN_estado_asistencia,E.id,E.IN_Identificacion,E.VC_Primer_Apellido,E.VC_Segundo_Apellido,E.VC_Primer_Nombre,E.VC_Segundo_Nombre
        FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase_asistencia A
        LEFT JOIN tb_estudiante E ON E.id = A.FK_estudiante
        WHERE A.FK_sesion_clase = ".$id_sesion_clase;
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarEstudiantesActivosGrupoAsistenciaSesionClase($id_sesion_clase,$id_grupo,$tipo_grupo){
        $sql = "SELECT A.IN_Tipo_Atencion, A.IN_estado_asistencia, A.IN_Tipo_Atencion, GE.DT_fecha_ingreso,E.id,E.IN_Identificacion,E.VC_Primer_Apellido,E.VC_Segundo_Apellido,E.VC_Primer_Nombre,E.VC_Segundo_Nombre
        FROM tb_terr_grupo_".$tipo_grupo."_estudiante GE
        INNER JOIN tb_estudiante E ON GE.FK_estudiante = E.id
        LEFT JOIN tb_terr_grupo_".$tipo_grupo."_sesion_clase_asistencia A ON E.id = A.FK_estudiante AND A.FK_sesion_clase=".$id_sesion_clase."
        WHERE GE.FK_Grupo = ".$id_grupo." AND (GE.estado = 1 OR A.IN_estado_asistencia IS NOT NULL);";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarSesionesRegistradas($datos){
        $id_grupo = $datos['id_grupo'];
        $tipo_grupo = $datos['tipo_grupo'];
        $id_usuario = $datos['id_usuario'];
        $fecha_mes_anio = $datos['fecha_mes'].'-01';
        switch ($tipo_grupo){
            case 'arte_escuela':
                $join_lugar_atencion = "LEFT JOIN tb_parametro_detalle LUGAR_ATENCION ON LUGAR_ATENCION.FK_Value=SC.IN_lugar_atencion AND LUGAR_ATENCION.FK_Id_Parametro=56";
                break;
            case 'emprende_clan':
                $join_lugar_atencion = "LEFT JOIN tb_parametro_detalle LUGAR_ATENCION ON LUGAR_ATENCION.FK_Value=SC.IN_Tipo_Ubicacion AND LUGAR_ATENCION.FK_Id_Parametro=57";
                break;
            case 'laboratorio_clan':
                $join_lugar_atencion = "LEFT JOIN tb_parametro_detalle LUGAR_ATENCION ON LUGAR_ATENCION.FK_Value=SC.IN_Tipo_Ubicacion AND LUGAR_ATENCION.FK_Id_Parametro=39";
                break;
        }
        $sql = "SELECT SC.PK_sesion_clase,SC.FK_usuario,SC.DA_fecha_clase,SC.IN_horas_clase,SC.TX_observaciones,SC.suplencia,SC.VC_anexo, TIPO_ATENCION.VC_Descripcion AS tipo_atencion, LUGAR_ATENCION.VC_Descripcion AS lugar_atencion, MATERIAL.VC_Descripcion AS material FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase SC LEFT JOIN tb_parametro_detalle TIPO_ATENCION ON TIPO_ATENCION.FK_Value=SC.IN_Tipo_Atencion AND TIPO_ATENCION.FK_Id_Parametro=62 LEFT JOIN tb_parametro_detalle MATERIAL ON MATERIAL.FK_Value=SC.IN_Material AND MATERIAL.FK_Id_Parametro=63 ".$join_lugar_atencion." WHERE FK_grupo = $id_grupo AND FK_usuario = $id_usuario AND Month(DA_fecha_clase) = Month('".$fecha_mes_anio."') AND Year(DA_fecha_clase) = Year('".$fecha_mes_anio."') ORDER BY DA_fecha_clase ASC;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarSesionesRegistradasEnGrupo($datos){
        $id_grupo = $datos['id_grupo'];
        $tipo_grupo = $datos['tipo_grupo'];
        $fecha_mes_anio = $datos['fecha_mes'].'-01';
        switch ($tipo_grupo){
            case 'arte_escuela':
                $join_lugar_atencion = "LEFT JOIN tb_parametro_detalle LUGAR_ATENCION ON LUGAR_ATENCION.FK_Value=SC.IN_lugar_atencion AND LUGAR_ATENCION.FK_Id_Parametro=56";
                break;
            case 'emprende_clan':
                $join_lugar_atencion = "LEFT JOIN tb_parametro_detalle LUGAR_ATENCION ON LUGAR_ATENCION.FK_Value=SC.IN_Tipo_Ubicacion AND LUGAR_ATENCION.FK_Id_Parametro=57";
                break;
            case 'laboratorio_clan':
                $join_lugar_atencion = "LEFT JOIN tb_parametro_detalle LUGAR_ATENCION ON LUGAR_ATENCION.FK_Value=SC.IN_Tipo_Ubicacion AND LUGAR_ATENCION.FK_Id_Parametro=39";
                break;
        }
        $sql_previo = "SET lc_time_names = 'es_ES'";
        $sentencia=$this->db->prepare($sql_previo);
        $sentencia->execute();
        if($tipo_grupo == "arte_escuela" || $tipo_grupo == "emprende_clan"){
            $sql = "SELECT SC.PK_sesion_clase,DATE_FORMAT(SC.DA_fecha_clase,'%b %d') AS DA_fecha_clase,SC.IN_horas_clase,SC.FK_usuario,SC.TX_observaciones,SC.suplencia,SC.VC_anexo, SC.tipo_grupo AS tipo_sesion, TIPO_ATENCION.VC_Descripcion AS tipo_atencion, LUGAR_ATENCION.VC_Descripcion AS lugar_atencion, MATERIAL.VC_Descripcion AS material FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase SC LEFT JOIN tb_parametro_detalle TIPO_ATENCION ON TIPO_ATENCION.FK_Value=SC.IN_Tipo_Atencion AND TIPO_ATENCION.FK_Id_Parametro=62 LEFT JOIN tb_parametro_detalle MATERIAL ON MATERIAL.FK_Value=SC.IN_Material AND MATERIAL.FK_Id_Parametro=63 ".$join_lugar_atencion." WHERE FK_grupo = $id_grupo AND Month(DA_fecha_clase) = Month('".$fecha_mes_anio."') AND Year(DA_fecha_clase) = Year('".$fecha_mes_anio."') ORDER BY DA_fecha_clase ASC;";
        }
        else{
            $sql = "SELECT SC.PK_sesion_clase,DATE_FORMAT(SC.DA_fecha_clase,'%b %d') AS SC.DA_fecha_clase,SC.IN_horas_clase,SC.FK_usuario,SC.TX_observaciones,SC.suplencia,SC.VC_anexo, TG.VC_Descripcion AS tipo_sesion, TIPO_ATENCION.VC_Descripcion AS tipo_atencion, LUGAR_ATENCION.VC_Descripcion AS lugar_atencion, MATERIAL.VC_Descripcion AS material FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase SC LEFT JOIN tb_parametro_detalle TG ON TG.FK_Value=SC.tipo_grupo AND TG.FK_Value=38 LEFT JOIN tb_parametro_detalle TIPO_ATENCION ON TIPO_ATENCION.FK_Value=SC.IN_Tipo_Atencion AND TIPO_ATENCION.FK_Id_Parametro=62 LEFT JOIN tb_parametro_detalle MATERIAL ON MATERIAL.FK_Value=SC.IN_Material AND MATERIAL.FK_Id_Parametro=63 ".$join_lugar_atencion." WHERE FK_grupo = $id_grupo AND Month(DA_fecha_clase) = Month('".$fecha_mes_anio."') AND Year(DA_fecha_clase) = Year('".$fecha_mes_anio."') ORDER BY DA_fecha_clase ASC;";
        }
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarSesionesRegistradasEnGrupoUsuario($datos){
        $id_grupo = $datos['id_grupo'];
        $tipo_grupo = $datos['tipo_grupo'];
        $fecha_mes_anio = $datos['fecha_mes'].'-01';
        switch ($tipo_grupo){
            case 'arte_escuela':
                $join_lugar_atencion = "LEFT JOIN tb_parametro_detalle LUGAR_ATENCION ON LUGAR_ATENCION.FK_Value=SC.IN_lugar_atencion AND LUGAR_ATENCION.FK_Id_Parametro=56";
                break;
            case 'emprende_clan':
                $join_lugar_atencion = "LEFT JOIN tb_parametro_detalle LUGAR_ATENCION ON LUGAR_ATENCION.FK_Value=SC.IN_Tipo_Ubicacion AND LUGAR_ATENCION.FK_Id_Parametro=57";
                break;
            case 'laboratorio_clan':
                $join_lugar_atencion = "LEFT JOIN tb_parametro_detalle LUGAR_ATENCION ON LUGAR_ATENCION.FK_Value=SC.IN_Tipo_Ubicacion AND LUGAR_ATENCION.FK_Id_Parametro=39";
                break;
        }
        $id_usuario = $datos['id_usuario'];
        $sql_previo = "SET lc_time_names = 'es_ES'";
        $sentencia=$this->db->prepare($sql_previo);
        $sentencia->execute();
        $sql = "SELECT SC.PK_sesion_clase,DATE_FORMAT(SC.DA_fecha_clase,'%b %d') AS DA_fecha_clase,SC.IN_horas_clase,SC.FK_usuario,SC.TX_observaciones,SC.suplencia,SC.VC_anexo, TIPO_ATENCION.VC_Descripcion AS tipo_atencion, LUGAR_ATENCION.VC_Descripcion AS lugar_atencion, MATERIAL.VC_Descripcion AS material FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase SC LEFT JOIN tb_parametro_detalle TIPO_ATENCION ON TIPO_ATENCION.FK_Value=SC.IN_Tipo_Atencion AND TIPO_ATENCION.FK_Id_Parametro=62 LEFT JOIN tb_parametro_detalle MATERIAL ON MATERIAL.FK_Value=SC.IN_Material AND MATERIAL.FK_Id_Parametro=63 ".$join_lugar_atencion." WHERE FK_grupo = $id_grupo AND Month(DA_fecha_clase) = Month('".$fecha_mes_anio."') AND Year(DA_fecha_clase) = Year('".$fecha_mes_anio."') AND FK_usuario = ".$id_usuario." ORDER BY DA_fecha_clase ASC;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarDatosAdicionalesGrupo($id_grupo,$tipo_grupo){
        $dato_adicional = array(
            'arte_escuela' => 'FK_Clan,VC_Nom_Clan,FK_Colegio,VC_Nom_colegio,FK_area_artistica,IN_lugar_atencion,tipo_grupo',
            'emprende_clan'=>'FK_Clan,VC_Nom_Clan,FK_modalidad,FK_area_artistica,tipo_grupo',
            'laboratorio_clan'=>'FK_Clan,VC_Nom_Clan,tipo_poblacion,FK_area_artistica,FK_lugar_atencion,tipo_grupo,FK_Institucion,FK_Aliado,IN_Tipo_Ubicacion,TX_Sitio');
        $JOIN_adicional = array('arte_escuela' => ' join tb_colegios ON FK_Colegio = PK_Id_Colegio ',
            'emprende_clan' => "",
            'laboratorio_clan' => "");
        $sql = "SELECT ".$dato_adicional[$tipo_grupo]." FROM tb_terr_grupo_".$tipo_grupo." JOIN tb_clan ON FK_Clan = PK_Id_Clan ".$JOIN_adicional[$tipo_grupo]." WHERE PK_grupo=".$id_grupo;
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTotalEstudiantesSesionClase($id_sesion_clase,$tipo_grupo){
        $sql = "SELECT COUNT(FK_estudiante)
        FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase_asistencia SC
        WHERE SC.FK_sesion_clase = ".$id_sesion_clase.";";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll()[0][0];
    }

    public function consultarTotalEstudiantesAsistieronASesionClase($id_sesion_clase,$tipo_grupo){
        $sql = "SELECT COUNT(FK_estudiante)
        FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase_asistencia SC
        WHERE SC.FK_sesion_clase = ".$id_sesion_clase." AND IN_estado_asistencia = 1;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll()[0][0];
    }

    public function consultarDetalleAsistenciaSesionClase($id_sesion_clase,$tipo_grupo){
        $sql = "SELECT *
        FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase_asistencia SC
        WHERE SC.FK_sesion_clase = ".$id_sesion_clase.";";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarSesionesEventoRegistradas($datos){
        $fecha_sesion_evento = $datos['fecha_mes'].'-01';
        $sql = "SELECT PK_sesion_clase,DA_fecha_sesion_clase,IN_horas_clase,TX_observaciones
        FROM tb_circ_evento_sesion_clase SC 
        WHERE SC.FK_grupo = ".$datos['id_grupo']." AND tipo_grupo = '".$datos['tipo_grupo']."' AND FK_usuario = ".$datos['id_usuario']." AND YEAR(DA_fecha_sesion_clase) = YEAR('".$fecha_sesion_evento."') AND MONTH(DA_fecha_sesion_clase) = MONTH('".$fecha_sesion_evento."') ORDER BY DA_fecha_sesion_clase ASC;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTotalEstudiantesSesionEvento($id_sesion_clase){
        $sql = "SELECT COUNT(FK_estudiante)
        FROM tb_circ_evento_sesion_clase_asistencia SCA
        WHERE SCA.FK_sesion_clase = ".$id_sesion_clase.";";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll()[0][0];
    }

    public function consultarTotalEstudiantesAsistieronASesionEvento($id_sesion_clase){
        $sql = "SELECT COUNT(FK_estudiante)
        FROM tb_circ_evento_sesion_clase_asistencia SCA
        WHERE SCA.FK_sesion_clase = ".$id_sesion_clase." AND IN_estado_asistencia = 1;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll()[0][0];
    }

    public function consultarNovedadesReporteGrupo($datos){
        $id_grupo = $datos['id_grupo'];
        $tipo_grupo = $datos['tipo_grupo'];
        $id_usuario = $datos['id_usuario'];
        $fecha_mes_anio = $datos['fecha_mes'].'-01';
        $sql = "SELECT id,DA_fecha_sesion_clase,IN_asistencia,IN_novedad,TX_observacion,VC_Descripcion AS novedad_texto FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase_novedad LEFT JOIN tb_parametro_detalle ON IN_novedad = FK_Value AND FK_id_parametro = 25 WHERE FK_grupo = $id_grupo AND FK_artista_formador = $id_usuario AND Month(DA_fecha_sesion_clase) = Month('".$fecha_mes_anio."') AND Year(DA_fecha_sesion_clase) = Year('".$fecha_mes_anio."') ORDER BY DA_fecha_sesion_clase ASC;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarOrganizacionSesionClaseMesGrupo($datos){
        $fecha_mes_anio = $datos['fecha_mes'].'-01';
        $sql = "SELECT DISTINCT S.FK_organizacion,O.VC_Nom_Organizacion
        FROM tb_terr_grupo_".$datos['tipo_grupo']."_sesion_clase S
        LEFT JOIN tb_organizaciones_2017 O ON O.PK_Id_Organizacion = S.FK_organizacion
        WHERE S.FK_usuario = :id_usuario AND S.FK_grupo = :id_grupo 
        AND MONTH(S.DA_fecha_clase) = Month(:fecha_mes_1) AND Year(S.DA_fecha_clase) = Year(:fecha_mes_2);";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
        @$sentencia->bindParam(':id_grupo',$datos['id_grupo']);
        @$sentencia->bindParam(':fecha_mes_1',$fecha_mes_anio);
        @$sentencia->bindParam(':fecha_mes_2',$fecha_mes_anio);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function RegistrarAsistenciaGrupoTransicion($datos){
        $sql = "INSERT INTO tb_terr_grupo_transicion_sesion_clase (FK_grupo,DA_fecha_clase,IN_horas_clase,FK_usuario,TX_observaciones,FK_clan,VC_Nom_Clan,tipo_grupo) VALUES(:id_grupo,:fecha_sesion,:horas_clase,:id_usuario,:observacion,:id_crea,:nombre_crea,:tipo_grupo);";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_grupo',$datos['id_grupo']);
        @$sentencia->bindParam(':fecha_sesion',$datos['fecha_sesion']);
        @$sentencia->bindParam(':horas_clase',$datos['horas_clase']);
        @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
        @$sentencia->bindParam(':observacion',$datos['observacion']);
        @$sentencia->bindParam(':id_crea',$datos['id_crea']);
        @$sentencia->bindParam(':nombre_crea',$datos['nombre_crea']);
        @$sentencia->bindParam(':tipo_grupo',$datos['tipo_grupo']);
        // @$sentencia->bindParam(':',$datos['']);
         try {
            $this->db->beginTransaction();
            $sentencia->execute();
            $id_insertado = $this->db->lastInsertId();
            $sentenciaAsistencia = $this->db->prepare("INSERT INTO tb_terr_grupo_transicion_sesion_clase_asistencia VALUES (:FK_sesion_clase, :FK_estudiante, :IN_estado_asistencia, :IN_es_mayor)");
            $es_mayor = 0;
            foreach ($datos['menores'] as $estudiante) {
                $sesion=$id_insertado;
                $id_estudiante=$estudiante['id_beneficiario'];
                $asistencia=$estudiante['estado'];
                $sentenciaAsistencia->bindParam(':FK_sesion_clase', $sesion);
                $sentenciaAsistencia->bindParam(':FK_estudiante', $id_estudiante);
                $sentenciaAsistencia->bindParam(':IN_estado_asistencia', $asistencia);
                $sentenciaAsistencia->bindParam(':IN_es_mayor', $es_mayor);
                $sentenciaAsistencia->execute();
            }
            $es_mayor = 1;
            foreach ($datos['mayores'] as $estudiante) {
                $sesion=$id_insertado;
                $id_estudiante=$estudiante['id_beneficiario'];
                $asistencia=$estudiante['estado'];
                $sentenciaAsistencia->bindParam(':FK_sesion_clase', $sesion);
                $sentenciaAsistencia->bindParam(':FK_estudiante', $id_estudiante);
                $sentenciaAsistencia->bindParam(':IN_estado_asistencia', $asistencia);
                $sentenciaAsistencia->bindParam(':IN_es_mayor', $es_mayor);
                $sentenciaAsistencia->execute();
            }
            $this->db->commit();
            return $id_insertado;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
        $sentencia->execute();
    }

    public function actualizarEstadoAsistenciaBeneficiarioSesionClase($datos){
        $sentencia_delete = $this->db->prepare("DELETE FROM tb_terr_grupo_".$datos['tipo_grupo']."_sesion_clase_asistencia WHERE FK_sesion_clase=:FK_sesion_clase AND FK_estudiante=:FK_estudiante;");
        $sentencia_insert = $this->db->prepare("INSERT INTO tb_terr_grupo_".$datos['tipo_grupo']."_sesion_clase_asistencia(FK_sesion_clase,FK_estudiante,IN_estado_asistencia) VALUES(:FK_sesion_clase,:FK_estudiante,:IN_estado_asistencia)");
        try {
            $this->db->beginTransaction();
            $sentencia_delete->bindParam(':FK_sesion_clase', $datos['id_sesion_clase']);
            $sentencia_delete->bindParam(':FK_estudiante', $datos['id_beneficiario']);
            $sentencia_delete->execute();
            $sentencia_insert->bindParam(':FK_sesion_clase',$datos['id_sesion_clase']);
            $sentencia_insert->bindParam(':FK_estudiante',$datos['id_beneficiario']);
            $sentencia_insert->bindParam(':IN_estado_asistencia',$datos['estado_asistencia']);
            $sentencia_insert->execute();
            $this->db->commit();
            return 1;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function crearDiaSesionClase($datos,$dato_adicional){
        $array_campos =
        array("arte_escuela"=>"IN_lugar_atencion,FK_colegio,VC_Nom_colegio,hora_inicio,hora_fin",
          "emprende_clan"=>"FK_modalidad, IN_Tipo_Ubicacion",
          "laboratorio_clan"=>"FK_lugar_atencion,tipo_poblacion,FK_Institucion,FK_Aliado,IN_Tipo_Ubicacion,TX_Sitio");
        $array_valores=
        array("arte_escuela"=>" :IN_lugar_atencion, :FK_colegio, :VC_Nom_colegio, :hora_inicio, :hora_fin",
          "emprende_clan"=>" :FK_modalidad, :IN_Tipo_Ubicacion",
          "laboratorio_clan"=>" :FK_lugar_atencion, :tipo_poblacion, :FK_Institucion, :FK_Aliado, :IN_Tipo_Ubicacion, :TX_Sitio");
        $sentencia_insert = $this->db->prepare("INSERT INTO tb_terr_grupo_".$datos['tipo_grupo']."_sesion_clase(FK_grupo,DA_fecha_clase,DT_fecha_creacion_registro,IN_horas_clase,FK_usuario,FK_organizacion,suplencia,FK_Clan,VC_Nom_Clan,".$array_campos[$datos['tipo_grupo']].",FK_area_artistica,tipo_grupo,TX_observaciones,FK_salon) VALUES(:FK_grupo,:DA_fecha_clase,NOW(),:IN_horas_clase,:FK_usuario,:FK_organizacion,:suplencia,:FK_Clan,:VC_Nom_Clan,".$array_valores[$datos['tipo_grupo']].",:FK_area_artistica,:tipo_grupo,:TX_observaciones,:FK_salon);");
        try {
            $this->db->beginTransaction();
            $sentencia_insert->bindParam(':FK_grupo',$datos['id_grupo']);
            $sentencia_insert->bindParam(':DA_fecha_clase',$datos['fecha']);
            $sentencia_insert->bindParam(':FK_usuario',$datos['id_usuario']);
            $sentencia_insert->bindParam(':FK_organizacion',$datos['id_organizacion']);
            $sentencia_insert->bindParam(':IN_horas_clase',$dato_adicional['horas_sesion']);
            $sentencia_insert->bindParam(':suplencia',$dato_adicional['suplencia']);
            $sentencia_insert->bindParam(':FK_Clan',$dato_adicional['FK_Clan']);
            $sentencia_insert->bindParam(':VC_Nom_Clan',$dato_adicional['VC_Nom_Clan']);
            $sentencia_insert->bindParam(':FK_area_artistica',$dato_adicional['FK_area_artistica']);
            $sentencia_insert->bindParam(':tipo_grupo',$dato_adicional['tipo_grupo']);
            $sentencia_insert->bindParam(':TX_observaciones',$dato_adicional['observacion']);
            $sentencia_insert->bindParam(':FK_salon',$dato_adicional['id_salon']);
            switch ($datos['tipo_grupo']) {
                case 'arte_escuela':
                    $sentencia_insert->bindParam(':IN_lugar_atencion',$dato_adicional['id_lugar_atencion']);
                    $sentencia_insert->bindParam(':FK_colegio',$dato_adicional['FK_Colegio']);
                    $sentencia_insert->bindParam(':VC_Nom_colegio',$dato_adicional['VC_Nom_colegio']);
                    $sentencia_insert->bindParam(':hora_inicio',$dato_adicional['hora_inicio']);
                    $sentencia_insert->bindParam(':hora_fin',$dato_adicional['hora_fin']);
                    break;
                case 'emprende_clan':
                    $sentencia_insert->bindParam(':FK_modalidad',$dato_adicional['FK_modalidad']);
                    $sentencia_insert->bindParam(':IN_Tipo_Ubicacion',$dato_adicional['id_lugar_atencion']);
                    break;
                case 'laboratorio_clan':
                    $sentencia_insert->bindParam(':FK_lugar_atencion',$dato_adicional['id_lugar_atencion']);
                    $sentencia_insert->bindParam(':tipo_poblacion',$dato_adicional['tipo_pblacion']);
                    $sentencia_insert->bindParam(':FK_Institucion',$dato_adicional['FK_Institucion']);
                    $sentencia_insert->bindParam(':FK_Aliado',$dato_adicional['FK_Aliado']);
                    $sentencia_insert->bindParam(':IN_Tipo_Ubicacion',$dato_adicional['id_lugar_atencion']);
                    $sentencia_insert->bindParam(':TX_Sitio',$dato_adicional['TX_Sitio']);
                    break;
                default:
                    echo "tipo_grupo no valido";
                    break;
            }
            $sentencia_insert->execute();
            $id_insertado = $this->db->lastInsertId();
            $sentenciaAsistencia = $this->db->prepare("INSERT INTO tb_terr_grupo_".$datos['tipo_grupo']."_sesion_clase_asistencia VALUES (:FK_sesion_clase, :FK_estudiante, :IN_estado_asistencia)");
            $sentenciaAsistencia->bindParam(':FK_sesion_clase', $sesion);
            $sentenciaAsistencia->bindParam(':FK_estudiante', $id_estudiante);
            foreach ($this->consultarEstudiantesActivosGrupoAsistenciaSesionClase($id_insertado,$datos['id_grupo'],$datos['tipo_grupo']) as $estudiante) {
                // var_dump($estudiante);
                $sesion=$id_insertado;
                $id_estudiante=$estudiante['id'];
                $asistencia=0;
                $sentenciaAsistencia->bindParam(':IN_estado_asistencia', $asistencia);
                $sentenciaAsistencia->execute();
            }
            $this->db->commit();
            return $id_insertado;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
        var_dump($dato_adicional);
    }

    public function updateAnexo($datos){
        $sql="UPDATE tb_terr_grupo_".$datos['linea_atencion']."_sesion_clase SET VC_anexo=:VC_anexo WHERE PK_sesion_clase=:PK_sesion_clase;";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':VC_anexo', $datos['VC_anexo']);
        @$sentencia->bindParam(':PK_sesion_clase', $datos['PK_sesion_clase']);
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    /**
     * @return mixed
     */
    public function getEstudianteArray()
    {
        return $this->estudiante_array;
    }

    /**
     * @param mixed $estudiante_array
     *
     * @return self
     */
    public function setEstudianteArray($estudiante_array)
    {
        $this->estudiante_array = $estudiante_array;

        return $this;
    }

    private function eliminarEstudiantesSesionClase($objeto){
        $sql="DELETE FROM tb_terr_grupo_".$objeto->getTipoGrupo()."_sesion_clase_asistencia WHERE FK_sesion_clase=".$objeto->getPkSesionClase().";";
        $sentencia=$this->db->prepare($sql);
        return $sentencia->execute();
    }

    private function eliminarSesionClase($objeto){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$objeto->getFkUsuario().";");
        $set_id_usuario->execute();
        $sql="DELETE FROM tb_terr_grupo_".$objeto->getTipoGrupo()."_sesion_clase WHERE PK_sesion_clase=".$objeto->getPkSesionClase().";";
        $sentencia=$this->db->prepare($sql);
        return $sentencia->execute();
    }
}