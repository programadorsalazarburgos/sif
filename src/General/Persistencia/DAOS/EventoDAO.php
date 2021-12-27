<?php

namespace General\Persistencia\DAOS;


class EventoDao extends GestionDAO {

    private $db;
    function __construct()
    {
        $this->db=$this->obtenerPDOBD();
    }

    public function crearObjeto($objeto) {
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$objeto->getFkOrganizador().";");
    	$sentencia = $this->db->prepare("INSERT INTO tb_circ_evento (FK_Tipo_Evento,DT_Fecha_Inicio,DT_Fecha_Fin,VC_Nombre,FK_Organizador,VC_Lugar,VC_Objetivo,DT_Fecha_Creacion,VC_Observaciones,VC_quien_invita,IN_publico_asistente)  VALUES (:FK_Tipo_Evento, :DT_Fecha_Inicio, :DT_Fecha_Fin, :VC_Nombre, :FK_Organizador, :VC_Lugar, :VC_Objetivo, :DT_Fecha_Creacion, :VC_Observaciones, :VC_quien_invita, :IN_publico_asistente)");
        @$sentencia->bindParam(':FK_Tipo_Evento',$objeto->getFkTipoEvento());
        @$sentencia->bindParam(':DT_Fecha_Inicio',$objeto->getDtFechaInicio());
        @$sentencia->bindParam(':DT_Fecha_Fin',$objeto->getDtFechaFin());
        @$sentencia->bindParam(':VC_Nombre',$objeto->getVcNombre());
        @$sentencia->bindParam(':FK_Organizador',$objeto->getFkOrganizador());
        @$sentencia->bindParam(':VC_Lugar',$objeto->getVcLugar());
        @$sentencia->bindParam(':VC_Objetivo',$objeto->getVcObjetivo());
        @$sentencia->bindParam(':DT_Fecha_Creacion',$objeto->getDtFechaCreacion());
        @$sentencia->bindParam(':VC_Observaciones',$objeto->getVcObservaciones());
        @$sentencia->bindParam(':VC_quien_invita',$objeto->getVcQuienInvita());
        @$sentencia->bindParam(':IN_publico_asistente',$objeto->getInPublicoAsistente());
    	try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $id_insertado = $this->db->lastInsertId();

            $sentencia_area_artistica = $this->db->prepare("INSERT INTO tb_circ_evento_area_artistica VALUES (:FK_Area_Artistica, :FK_Evento)");
            $sentencia_area_artistica->bindParam(':FK_Area_Artistica', $id_area_artistica);
            $sentencia_area_artistica->bindParam(':FK_Evento', $id_evento);
            foreach ($objeto->getArrayAreaArtistica() as $area) {
                $id_area_artistica=$area[0];
                $id_evento=$id_insertado;
                $sentencia_area_artistica->execute();
            }

            $sentencia_artista_formador = $this->db->prepare("INSERT INTO tb_circ_evento_artista_formador VALUES (:FK_artista_formador, :FK_Evento)");
            $sentencia_artista_formador->bindParam(':FK_artista_formador', $id_artista_formador);
            $sentencia_artista_formador->bindParam(':FK_Evento', $id_evento);
            foreach ($objeto->getArrayArtistaFormador() as $artista) {
                $id_artista_formador=$artista;
                $id_evento=$id_insertado;
                $sentencia_artista_formador->execute();
            }

            $sentencia_clan = $this->db->prepare("INSERT INTO tb_circ_evento_clan VALUES (:FK_clan, :FK_Evento)");
            $sentencia_clan->bindParam(':FK_clan', $id_clan);
            $sentencia_clan->bindParam(':FK_Evento', $id_evento);
            foreach ($objeto->getArrayClan() as $c) {
                $id_clan=$c;
                $id_evento=$id_insertado;
                $sentencia_clan->execute();
            }

            $sentencia_recursos = $this->db->prepare("INSERT INTO tb_circ_evento_recursos_insumos(FK_Evento,VC_transporte,VC_tecnica_produccion,VC_vestuario,VC_escenografia,VC_maquillaje,VC_alimentacion,VC_comunicaciones) VALUES (:FK_Evento, :VC_transporte, :VC_tecnica_produccion, :VC_vestuario, :VC_escenografia, :VC_maquillaje, :VC_alimentacion, :VC_comunicaciones)");
            $sentencia_recursos->bindParam('FK_Evento',$id_insertado);
            @$sentencia_recursos->bindParam('VC_transporte',$objeto->getVCTransporte());
            @$sentencia_recursos->bindParam('VC_tecnica_produccion',$objeto->getVcTecnicaProduccion());
            @$sentencia_recursos->bindParam('VC_vestuario',$objeto->getVcVestuario());
            @$sentencia_recursos->bindParam('VC_escenografia',$objeto->getVcEscenografia());
            @$sentencia_recursos->bindParam('VC_maquillaje',$objeto->getVcMaquillaje());
            @$sentencia_recursos->bindParam('VC_alimentacion',$objeto->getVcAlimentacion());
            @$sentencia_recursos->bindParam('VC_comunicaciones',$objeto->getVcComunicaciones());
            $sentencia_recursos->execute();

            $this->db->commit();
            return $id_insertado;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function consultarObjeto($objeto) {
        $sql = "SELECT * FROM tb_circ_evento";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarEventoMesAnio($datos){
        //echo addslashes($datos['id_crea']);
        $sql = "SELECT DISTINCT E.PK_Id_Evento,E.DT_Fecha_Inicio,E.VC_Nombre 
        FROM tb_circ_evento E LEFT JOIN tb_circ_evento_clan C ON C.FK_Evento = E.PK_Id_Evento LEFT JOIN tb_circ_evento_area_artistica A ON A.FK_Evento = E.PK_Id_Evento
        WHERE YEAR(E.DT_Fecha_Inicio) = :anio AND MONTH(E.DT_Fecha_Inicio) = :mes AND FIND_IN_SET(C.FK_Clan, :id_crea) > 0 AND FIND_IN_SET(A.FK_Area_Artistica, :id_area_artistica) > 0";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        @$sentencia->bindParam(':id_crea',addslashes($datos['id_crea']));
        @$sentencia->bindParam(':id_area_artistica',addslashes($datos['id_area_artistica']));
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarEventosPorCrea($id_crea){
        $sql = "SELECT DISTINCT tb_circ_evento.* FROM tb_circ_evento LEFT JOIN tb_circ_evento_clan ON PK_Id_Evento = FK_Evento WHERE FK_Clan IN($id_crea);";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarObjetoPorId($id_evento) {
        $sentencia=$this->db->prepare("SELECT E.* , CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS organizador
            FROM tb_circ_evento E LEFT JOIN tb_persona_2017 P ON E.FK_Organizador = P.PK_Id_Persona
            WHERE E.PK_Id_Evento = :PK_Id_Evento");
        @$sentencia->bindParam(':PK_Id_Evento',$id_evento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarRecursosInsumosEventoPorId($id_evento){
        $sentencia=$this->db->prepare("SELECT * FROM tb_circ_evento_recursos_insumos WHERE FK_Evento = :FK_Evento");
        @$sentencia->bindParam(':FK_Evento',$id_evento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarCreasEvento($id_evento){
        $sentencia=$this->db->prepare("SELECT C.PK_Id_Clan,C.VC_Nom_Clan
            FROM tb_circ_evento_clan EC
            LEFT JOIN tb_clan C ON EC.FK_Clan = C.PK_Id_Clan
            WHERE EC.FK_Evento = :FK_Evento");
        @$sentencia->bindParam(':FK_Evento',$id_evento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarAreasArtisticasEvento($id_evento){
        $sentencia=$this->db->prepare("SELECT AA.PK_Area_Artistica,AA.VC_Nom_Area
            FROM tb_circ_evento_area_artistica EA
            LEFT JOIN tb_areas_artisticas AA ON EA.FK_Area_Artistica = AA.PK_Area_Artistica
            WHERE EA.FK_Evento = :FK_Evento");
        @$sentencia->bindParam(':FK_Evento',$id_evento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarArtistasFormadoresEvento($id_evento){
        $sentencia=$this->db->prepare("SELECT EA.FK_Artista_Formador,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.VC_Identificacion
            FROM tb_circ_evento_artista_formador EA
            LEFT JOIN tb_persona_2017 P ON EA.FK_Artista_Formador = P.Pk_Id_Persona 
            WHERE EA.FK_Evento = :FK_Evento");
        @$sentencia->bindParam(':FK_Evento',$id_evento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarEventosCreadosPorUsuario($id_usuario){
        $sql = "SELECT * FROM tb_circ_evento WHERE FK_Organizador = :id_usuario";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_usuario',$id_usuario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarEventosActivosCreadosPorUsuario($id_usuario){
        $sql = "SELECT * FROM tb_circ_evento WHERE FK_Organizador = :id_usuario AND estado_evento = 1;";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_usuario',$id_usuario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTiposEvento(){
        $sql = "SELECT * FROM tb_parametro_detalle WHERE FK_Id_Parametro = 47 AND IN_Estado = 1;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarFechaInicioYFechaFinEvento($id_evento){
        $sql = "SELECT DT_Fecha_Inicio,DT_Fecha_Fin FROM tb_circ_evento WHERE PK_Id_Evento = $id_evento;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarEstudiantesGrupoActivosEnEvento($tipo_grupo,$id_evento,$id_grupo){
        $sql = "SELECT E.id,E.VC_Primer_Apellido,E.VC_Segundo_Apellido,E.VC_Primer_Nombre,E.VC_Segundo_Nombre,E.IN_Identificacion
            FROM tb_terr_grupo_".$tipo_grupo."_estudiante GE
            JOIN tb_estudiante E ON GE.FK_estudiante = E.id
            JOIN tb_circ_evento_estudiante EE ON E.id = EE.FK_Estudiante
            WHERE GE.FK_grupo = ".$id_grupo." AND GE.estado = 1 AND EE.TI_permiso_padres = 1 AND EE.FK_Evento = ".$id_evento.";";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function modificarObjeto($objeto) {return;}
    public function eliminarObjeto($objeto) {return;}


    public function modificarEventoDatosBasicos($objeto){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$objeto->getFkOrganizador().";");
        $sentencia = $this->db->prepare("UPDATE tb_circ_evento SET VC_Nombre=:VC_Nombre, DT_Fecha_Inicio=:DT_Fecha_Inicio, DT_Fecha_Fin=:DT_Fecha_Fin, VC_Lugar=:VC_Lugar, VC_Objetivo=:VC_Objetivo, IN_publico_asistente=:IN_publico_asistente, FK_Tipo_Evento=:FK_Tipo_Evento WHERE PK_Id_Evento=:PK_Id_Evento");
        @$sentencia->bindParam(':VC_Nombre',$objeto->getVcNombre());
        @$sentencia->bindParam(':DT_Fecha_Inicio',$objeto->getDtFechaInicio());
        @$sentencia->bindParam(':DT_Fecha_Fin',$objeto->getDtFechaFin());
        @$sentencia->bindParam(':VC_Lugar',$objeto->getVcLugar());
        @$sentencia->bindParam(':VC_Objetivo',$objeto->getVcObjetivo());
        @$sentencia->bindParam(':IN_publico_asistente',$objeto->getInPublicoAsistente());
        @$sentencia->bindParam(':FK_Tipo_Evento',$objeto->getFkTipoEvento());
        @$sentencia->bindParam(':PK_Id_Evento',$objeto->getPkIdEvento());
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();

            $sentencia_delete_crea = $this->db->prepare("DELETE FROM tb_circ_evento_clan WHERE FK_Evento = :FK_Evento;");
            @$sentencia_delete_crea->bindParam(':FK_Evento',$objeto->getPkIdEvento());
            $sentencia_delete_crea->execute();

            $sentencia_crea = $this->db->prepare("INSERT INTO tb_circ_evento_clan VALUES (:FK_clan, :FK_Evento)");
            $sentencia_crea->bindParam(':FK_clan', $id_clan);
            $sentencia_crea->bindParam(':FK_Evento', $id_evento);
            foreach ($objeto->getArrayClan() as $c) {
                $id_clan=$c;
                $id_evento=$objeto->getPkIdEvento();
                $sentencia_crea->execute();
            }

            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function modificarEventoDatosMultiples($objeto){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$objeto->getFkOrganizador().";");
        try {
          $this->db->beginTransaction();
          $set_id_usuario->execute();

          $sentencia_delete_crea = $this->db->prepare("DELETE FROM tb_circ_evento_clan WHERE FK_Evento = :FK_Evento;");
          @$sentencia_delete_crea->bindParam(':FK_Evento',$objeto->getPkIdEvento());
          $sentencia_delete_crea->execute();

          $sentencia_crea = $this->db->prepare("INSERT INTO tb_circ_evento_clan VALUES (:FK_crea, :FK_Evento)");
          $sentencia_crea->bindParam(':FK_crea', $id_crea);
          $sentencia_crea->bindParam(':FK_Evento', $id_evento);
          foreach ($objeto->getArrayClan() as $crea) {
              $id_crea=$crea;
              $id_evento=$objeto->getPkIdEvento();
              $sentencia_crea->execute();
          }

          $sentencia_delete_area_artistica = $this->db->prepare("DELETE FROM tb_circ_evento_area_artistica WHERE FK_Evento = :FK_Evento;");
          @$sentencia_delete_area_artistica->bindParam(':FK_Evento',$objeto->getPkIdEvento());
          $sentencia_delete_area_artistica->execute();

          $sentencia_area_artistica = $this->db->prepare("INSERT INTO tb_circ_evento_area_artistica VALUES (:FK_Area_Artistica, :FK_Evento)");
          $sentencia_area_artistica->bindParam(':FK_Area_Artistica', $id_area_artistica);
          $sentencia_area_artistica->bindParam(':FK_Evento', $id_evento);
          foreach ($objeto->getArrayAreaArtistica() as $area) {
              $id_area_artistica=$area;
              $id_evento=$objeto->getPkIdEvento();
              $sentencia_area_artistica->execute();
          }

          $sentencia_delete_artista_formador = $this->db->prepare("DELETE FROM tb_circ_evento_artista_formador WHERE FK_Evento = :FK_Evento;");
          @$sentencia_delete_artista_formador->bindParam(':FK_Evento',$objeto->getPkIdEvento());
          $sentencia_delete_artista_formador->execute();

          $sentencia_artista_formador = $this->db->prepare("INSERT INTO tb_circ_evento_artista_formador VALUES (:FK_artista_formador, :FK_Evento)");
          $sentencia_artista_formador->bindParam(':FK_artista_formador', $id_artista_formador);
          $sentencia_artista_formador->bindParam(':FK_Evento', $id_evento);
          foreach ($objeto->getArrayArtistaFormador() as $artista) {
              $id_artista_formador=$artista;
              $id_evento=$objeto->getPkIdEvento();
              $sentencia_artista_formador->execute();
          }
          $this->db->commit();
          return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function modificarEventoRecursosInsumos($objeto){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$objeto->getFkOrganizador().";");
        $sentencia = $this->db->prepare("UPDATE tb_circ_evento_recursos_insumos SET VC_transporte=:VC_transporte, VC_tecnica_produccion=:VC_tecnica_produccion, VC_vestuario=:VC_vestuario, VC_escenografia=:VC_escenografia, VC_maquillaje=:VC_maquillaje, VC_alimentacion=:VC_alimentacion, VC_comunicaciones=:VC_comunicaciones WHERE FK_Evento=:FK_Evento");
        @$sentencia->bindParam(':VC_transporte',$objeto->getVCTransporte());
        @$sentencia->bindParam(':VC_tecnica_produccion',$objeto->getVcTecnicaProduccion());
        @$sentencia->bindParam(':VC_vestuario',$objeto->getVcVestuario());
        @$sentencia->bindParam(':VC_escenografia',$objeto->getVcEscenografia());
        @$sentencia->bindParam(':VC_maquillaje',$objeto->getVcMaquillaje());
        @$sentencia->bindParam(':VC_alimentacion',$objeto->getVcAlimentacion());
        @$sentencia->bindParam(':VC_comunicaciones',$objeto->getVcComunicaciones());
        @$sentencia->bindParam(':FK_Evento',$objeto->getPkIdEvento());
        $sentencia_quien_invita = $this->db->prepare("UPDATE tb_circ_evento SET VC_quien_invita=:VC_quien_invita WHERE PK_Id_Evento=:PK_Id_Evento");
        @$sentencia_quien_invita->bindParam(':VC_quien_invita',$objeto->getVcQuienInvita());
        @$sentencia_quien_invita->bindParam(':PK_Id_Evento',$objeto->getPkIdEvento());
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $sentencia_quien_invita->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function consultarEstudiantesEvento($id_evento){
        $sentencia=$this->db->prepare("SELECT P.id, P.IN_Identificacion,CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS VC_Nombre,
                A.VC_Nom_Area,C.VC_Nom_Clan,COL.VC_Nom_Colegio,G.VC_Descripcion_Grado,O.VC_Nom_Organizacion,
                EV.FK_Estudiante,EV.FK_Evento,EV.TI_Permiso_Padres,EV.TI_Asistencia_Dia1,EV.TI_Asistencia_Dia2,EV.FK_Area_Artistica,EV.FK_clan,EV.FK_Colegio,EV.FK_Grado,EV.FK_Organizacion 
            FROM tb_circ_evento_estudiante EV
                LEFT JOIN tb_estudiante P ON EV.FK_Estudiante = P.id
                LEFT JOIN tb_areas_artisticas A ON EV.FK_Area_Artistica = A.PK_Area_Artistica
                LEFT JOIN tb_clan C ON EV.FK_Clan = C.PK_Id_Clan
                LEFT JOIN tb_colegios COL ON EV.FK_Colegio = COL.PK_Id_Colegio
                LEFT JOIN tb_grado G ON EV.FK_Grado = G.PK_Id_Grado
                LEFT JOIN tb_organizaciones_2017 O ON EV.FK_Organizacion = O.PK_Id_Organizacion
            WHERE EV.FK_Evento = :FK_Evento");
        $sentencia->bindParam(':FK_Evento',$id_evento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarIDYEstadoEstudiantesSesionClaseEvento($id_sesion_clase_evento){
        $sentencia=$this->db->prepare("SELECT FK_estudiante,IN_estado_asistencia FROM tb_circ_evento_sesion_clase_asistencia WHERE FK_sesion_clase=:FK_sesion_clase");
        $sentencia->bindParam(':FK_sesion_clase',$id_sesion_clase_evento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function agregarEstudianteEventoDistrital($datos){
        $estado_asistencia_default = 0;
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
        $sentencia = $this->db->prepare("INSERT INTO tb_circ_evento_estudiante(FK_Estudiante,FK_Evento,FK_Usuario,TI_Asistencia_Dia1,TI_Asistencia_Dia2) VALUES(:FK_Estudiante,:FK_Evento,:FK_Usuario,:TI_Asistencia_Dia1,:TI_Asistencia_Dia2);");
        $sentencia->bindParam(':FK_Estudiante',$datos['id_estudiante']);
        $sentencia->bindParam(':FK_Evento',$datos['id_evento']);
        $sentencia->bindParam(':FK_Usuario',$datos['id_usuario']);
        $sentencia->bindParam(':TI_Asistencia_Dia1',$estado_asistencia_default);
        $sentencia->bindParam(':TI_Asistencia_Dia2',$estado_asistencia_default);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function actualizarPermisoPadres($datos){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
        $sentencia = $this->db->prepare("UPDATE tb_circ_evento_estudiante
                SET TI_Permiso_Padres = :TI_Permiso_Padres
            WHERE FK_Estudiante = :FK_Estudiante AND FK_Evento = :FK_Evento;");
        $sentencia->bindParam(':FK_Estudiante',$datos['id_estudiante']);
        $sentencia->bindParam(':FK_Evento',$datos['id_evento']);
        $sentencia->bindParam(':TI_Permiso_Padres',$datos['permiso']);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function validarFechaSesionClaseEvento($id_evento,$id_grupo,$fecha,$tipo_grupo){
        $sql="SELECT FK_grupo FROM tb_circ_evento_sesion_clase WHERE FK_Evento=".$id_evento." AND FK_grupo=".$id_grupo." AND tipo_grupo='".$tipo_grupo."' AND DA_fecha_sesion_clase='".$fecha."';";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }


//// este metodo vuela con el nuevo registro de asistencias.
    public function actualizarEstadoAsistenciaEstudianteEvento($datos){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
        $sentencia = $this->db->prepare("UPDATE tb_circ_evento_estudiante
                SET TI_Asistencia_Dia1 = :TI_Asistencia_Dia1
            WHERE FK_Estudiante = :FK_Estudiante AND FK_Evento = :FK_Evento;");
        $sentencia->bindParam(':FK_Estudiante',$datos['id_estudiante']);
        $sentencia->bindParam(':FK_Evento',$datos['id_evento']);
        $sentencia->bindParam(':TI_Asistencia_Dia1',$datos['estado']);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function consultarFechaSesionClaseEventoMesUsuario($datos){
        $sql="SELECT * FROM tb_circ_evento_sesion_clase WHERE FK_Evento=:id_evento AND FK_Usuario=:id_usuario;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->bindParam(':id_evento',$datos['id_evento']);
        $sentencia->bindParam(':id_usuario',$datos['id_artista_formador']);
        try {
            $this->db->beginTransaction();
            $sentencia->execute();
            $this->db->commit();
            return $sentencia->fetchAll();
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function eliminarAsistenciaSesionEvento($id_sesion_clase_evento,$id_usuario_web){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$id_usuario_web.";");
        try {
          $this->db->beginTransaction();
          $set_id_usuario->execute();

          $sentencia_delete_sesion = $this->db->prepare("DELETE FROM tb_circ_evento_sesion_clase WHERE PK_sesion_clase = :id_sesion_clase_evento;");
          @$sentencia_delete_sesion->bindParam(':id_sesion_clase_evento',$id_sesion_clase_evento);
          $sentencia_delete_sesion->execute();
          $this->db->commit();
          return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function modificarAsistenciaSesionEvento($datos){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
        $sentencia = $this->db->prepare("UPDATE tb_circ_evento_sesion_clase SET IN_horas_clase=:IN_horas_clase, TX_observaciones=:TX_observaciones WHERE PK_sesion_clase=:PK_sesion_clase");
        @$sentencia->bindParam(':IN_horas_clase',$datos['horas_participacion']);
        @$sentencia->bindParam(':TX_observaciones',$datos['tx_observaciones']);
        @$sentencia->bindParam(':PK_sesion_clase',$datos['id_sesion_evento']);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();

            $sentencia_delete_asistencia = $this->db->prepare("DELETE FROM tb_circ_evento_sesion_clase_asistencia WHERE FK_sesion_clase = :FK_sesion_clase;");
            @$sentencia_delete_asistencia->bindParam(':FK_sesion_clase',$datos['id_sesion_evento']);
            $sentencia_delete_asistencia->execute();

            $sentencia_insert_asistencia = $this->db->prepare("INSERT INTO tb_circ_evento_sesion_clase_asistencia VALUES (:FK_sesion_clase, :FK_estudiante, :IN_estado_asistencia)");
            $sentencia_insert_asistencia->bindParam(':FK_sesion_clase', $id_sesion_evento);
            $sentencia_insert_asistencia->bindParam(':FK_estudiante', $id_estudiante);
            $sentencia_insert_asistencia->bindParam(':IN_estado_asistencia', $estado_asistencia);

            foreach ($datos['id_estudiante'] as $e) {
                $id_sesion_evento=$datos['id_sesion_evento'];
                $id_estudiante = $e;
                $estado_asistencia = 1;
                $sentencia_insert_asistencia->execute();
            }

            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function consultarEventosDistritalesActivos(){
        $sql="SELECT PK_Id_Evento,VC_Nombre FROM tb_circ_evento WHERE FK_Tipo_Evento IN (16,17,18) AND estado_evento = 1;";
        $sentencia=$this->db->prepare($sql);
        try {
            $this->db->beginTransaction();
            $sentencia->execute();
            $this->db->commit();
            return $sentencia->fetchAll();
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function consultarGradosTablaAntigua(){
        $sql="SELECT * FROM tb_parametro_detalle WHERE FK_Id_Parametro = 18;";
        $sentencia=$this->db->prepare($sql);
        try {
            $this->db->beginTransaction();
            $sentencia->execute();
            $this->db->commit();
            return $sentencia->fetchAll();
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function modificarEstudianteEventoDistrital($datos){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
        $sentencia = $this->db->prepare("UPDATE tb_circ_evento_estudiante SET FK_Area_Artistica=:id_area_artistica, FK_Clan=:id_crea, FK_Colegio=:id_colegio, FK_Grado=:id_grado, FK_Organizacion=:id_organizacion WHERE FK_Evento=:id_evento AND FK_Estudiante=:id_estudiante");
        @$sentencia->bindParam(':id_area_artistica',$datos['id_area_artistica']);
        @$sentencia->bindParam(':id_crea',$datos['id_crea']);
        @$sentencia->bindParam(':id_colegio',$datos['id_colegio']);
        @$sentencia->bindParam(':id_grado',$datos['id_grado']);
        @$sentencia->bindParam(':id_organizacion',$datos['id_organizacion']);
        @$sentencia->bindParam(':id_evento',$datos['id_evento']);
        @$sentencia->bindParam(':id_estudiante',$datos['id_estudiante']);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function removerBeneficiarioEventoDistrital($datos){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();

            $sentencia_delete_estudiante_evento = $this->db->prepare("DELETE FROM tb_circ_evento_estudiante WHERE FK_Evento = :id_evento AND FK_Estudiante = :id_estudiante;");
            @$sentencia_delete_estudiante_evento->bindParam(':id_evento',$datos['id_evento']);
            @$sentencia_delete_estudiante_evento->bindParam(':id_estudiante',$datos['id_beneficiario']);
            $sentencia_delete_estudiante_evento->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function FinalizarEvento($datos){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();

            $sentencia = $this->db->prepare("UPDATE tb_circ_evento SET IN_asistencia_nna=:asistentes_nna, IN_asistencia_padres=:asistentes_padres,IN_asistencia_publico=:asistentes_publico, estado_evento=:estado_evento WHERE PK_Id_Evento=:id_evento");
            @$sentencia->bindParam(':asistentes_nna',$datos['asistentes_nna']);
            @$sentencia->bindParam(':asistentes_padres',$datos['asistentes_padres']);
            @$sentencia->bindParam(':asistentes_publico',$datos['asistentes_publico']);
            @$sentencia->bindParam(':estado_evento',$datos['estado']);
            @$sentencia->bindParam(':id_evento',$datos['id_evento']);
            $sentencia->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function consultarsEventosActivosMiCrea($id_usuario){
        $sql="SELECT E.PK_Id_Evento,E.VC_Nombre
                FROM tb_circ_evento E
                    LEFT JOIN tb_circ_evento_clan EC ON E.PK_Id_Evento = EC.FK_Evento
                    LEFT JOIN tb_clan C ON EC.FK_Clan = C.PK_Id_Clan
                WHERE E.estado_evento = 1 AND FK_Persona_Administrador = :id_usuario;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->bindParam(':id_usuario',$id_usuario);
        try {
            $this->db->beginTransaction();
            $sentencia->execute();
            $this->db->commit();
            return $sentencia->fetchAll();
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function consultarArtistasFormadoresNoAsociadosAEvento($datos){
        $sql="SELECT P.PK_Id_Persona,VC_Identificacion,CONCAT(VC_Primer_Nombre,' ',VC_Segundo_Nombre,' ',VC_Primer_Apellido,' ',VC_Segundo_Apellido) AS Nombre
            FROM tb_persona_2017 P 
                LEFT JOIN tb_acceso_usuario_2017 AU ON P.PK_Id_Persona = AU.FK_Id_Persona
            WHERE AU.IN_Estado = 1 AND P.FK_Tipo_Persona = 1 
                AND P.PK_Id_Persona NOT IN(SELECT FK_artista_formador FROM tb_circ_evento_artista_formador WHERE FK_evento = :id_evento)
                AND (P.VC_Identificacion LIKE '%".$datos['texto']."%' OR CONCAT(VC_Primer_Nombre,' ',VC_Segundo_Nombre,' ',VC_Primer_Apellido,' ',VC_Segundo_Apellido) LIKE '%".$datos['texto']."%');";
        $sentencia=$this->db->prepare($sql);
        $sentencia->bindParam(':id_evento',$datos['id_evento']);
        try {
            $this->db->beginTransaction();
            $sentencia->execute();
            $this->db->commit();
            return $sentencia->fetchAll();
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function AsignarArtistaEvento($datos){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
        $sql="INSERT INTO tb_circ_evento_artista_formador(FK_Evento,FK_Artista_Formador) VALUES(:id_evento,:id_artista_formador);";
        $sentencia=$this->db->prepare($sql);
        $sentencia->bindParam(':id_evento',$datos['id_evento']);
        $sentencia->bindParam(':id_artista_formador',$datos['id_artista_formador']);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function consultarReporteAforos($tipo_evento){
        $where_tipo_evento = "";
        if($tipo_evento == 'distrital'){
            $where_tipo_evento = "AND FK_Tipo_Evento IN (16,17,18)";
        }else{
            $where_tipo_evento = "AND FK_Tipo_Evento IN (14,15)";
        }
        $sql = "SELECT estado_evento,DT_Fecha_Inicio,DT_Fecha_Fin,VC_Nombre,VC_Lugar,IN_publico_asistente,IN_asistencia_nna,IN_asistencia_padres,IN_asistencia_publico 
                FROM tb_circ_evento 
                WHERE YEAR(DT_Fecha_Inicio) = 2019 ".$where_tipo_evento;
        $sentencia=$this->db->prepare($sql);
        try {
            $this->db->beginTransaction();
            $sentencia->execute();
            $this->db->commit();
            return $sentencia->fetchAll();
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }
}