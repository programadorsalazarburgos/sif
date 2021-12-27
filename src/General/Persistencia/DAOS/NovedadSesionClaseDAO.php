<?php

namespace General\Persistencia\DAOS; 


class NovedadSesionClaseDAO extends GestionDAO {
    
    private $db;
    
    function __construct()
    {        
        $this->db=$this->obtenerBD();
        $this->dbPDO=$this->obtenerPDOBD();
    }
    
    public function crearObjeto($objeto) {
        $set_id_usuario = $this->dbPDO->prepare("SET @user_id = ".$objeto->getFkUsuarioRegistro().";");
        $sentencia = $this->dbPDO->prepare("INSERT INTO tb_terr_grupo_".$objeto->getTipoGrupo()."_sesion_clase_novedad (FK_grupo,DA_fecha_sesion_clase,IN_novedad,IN_asistencia,TX_observacion,FK_artista_formador,FK_usuario_registro,DT_fecha_registro) VALUES (:FK_grupo,:DA_fecha_sesion_clase,:IN_novedad,:IN_asistencia,:TX_observacion,:FK_artista_formador,:FK_usuario_registro,NOW())");
        @$sentencia->bindParam(':FK_grupo',$objeto->getFkGrupo());
        @$sentencia->bindParam(':DA_fecha_sesion_clase',$objeto->getDaFechaSesionClase());
        @$sentencia->bindParam(':IN_novedad',$objeto->getInNovedad());
        @$sentencia->bindParam(':IN_asistencia',$objeto->getInAsistencia());
        @$sentencia->bindParam(':TX_observacion',$objeto->getTxObservacion());
        @$sentencia->bindParam(':FK_artista_formador',$objeto->getFkArtistaFormador());
        @$sentencia->bindParam(':FK_usuario_registro',$objeto->getFkUsuarioRegistro());
        try {
            $this->dbPDO->beginTransaction();
            $set_id_usuario->execute();
            $id_insertado = $sentencia->execute();
            $id_insertado = $this->dbPDO->lastInsertId();
            $this->dbPDO->commit();
            return $id_insertado;
        }catch(PDOExecption $e) {
            $this->dbPDO->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
        return;
    }

    public function modificarObjeto($update) {

    }

    public function modificarObjetoLineaAtencion($update,$tipo_grupo) {
        $sql="UPDATE tb_terr_grupo_".$tipo_grupo."_sesion_clase_novedad AS N 
                SET ".$update;
         return $this->db->query($sql)->rowCount();  
    }

    public function eliminarObjeto($objeto) {

            return;
    }

    public function eliminarNovedad($id_novedad,$linea_atencion){
        return $this->db->delete("tb_terr_grupo_".$linea_atencion."_sesion_clase_novedad",["id"=>$id_novedad]);
    }

    public function consultarObjeto($objeto){
        $sql="SELECT N.DA_fecha_sesion_clase,N.IN_asistencia,D.VC_Descripcion,N.TX_observacion FROM tb_terr_grupo_".$objeto['tipo_grupo']."_sesion_clase_novedad N LEFT JOIN tb_terr_detalle_referencia D ON N.IN_novedad = D.PK_Id_Detalle WHERE N.FK_artista_formador=".$objeto['id_usuario']." AND N.FK_grupo=".$objeto['id_grupo']." AND N.DA_fecha_sesion_clase LIKE '".$objeto['mes_anio']."%' AND D.FK_Id_Referencia = 1;";
        $statement=$this->dbPDO->prepare($sql);    
        $statement->execute(); 
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarNovedadGrupoDia($datos){
        $sql="SELECT N.id FROM tb_terr_grupo_".$datos['tipo_grupo']."_sesion_clase_novedad N WHERE N.FK_grupo = :FK_grupo AND N.DA_fecha_sesion_clase = :DA_fecha_sesion_clase AND IN_novedad=:IN_novedad;";
        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':DA_fecha_sesion_clase',$datos['fecha_sesion_clase']);
        @$sentencia->bindParam(':FK_grupo',$datos['id_grupo']);
        @$sentencia->bindParam(':IN_novedad',$datos['id_novedad']);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function cargarHistorialNovedadesGrupo($datos){
        $sql="SELECT N.*,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,D.VC_Descripcion FROM tb_terr_grupo_".$datos['tipo_grupo']."_sesion_clase_novedad N LEFT JOIN tb_persona_2017 P ON N.FK_artista_formador = P.PK_Id_Persona LEFT JOIN tb_terr_detalle_referencia D ON N.IN_novedad = D.PK_Id_Detalle WHERE N.FK_grupo = :FK_grupo;";
        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':FK_grupo',$datos['id_grupo']);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarDiasMesCanceladosCoordinadorGrupo($datos){
        $sql="SELECT DA_fecha_sesion_clase AS dia
        FROM tb_terr_grupo_".$datos['tipo_grupo']."_sesion_clase_novedad
        WHERE FK_grupo = :id_grupo AND IN_novedad = 1 AND FK_artista_formador = :id_artista_formador AND YEAR(DA_fecha_sesion_clase) = YEAR(:fecha_sesion_clase_1) AND MONTH(DA_fecha_sesion_clase) = MONTH(:fecha_sesion_clase_2)";
        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_grupo',$datos['id_grupo']);
        @$sentencia->bindParam(':id_artista_formador',$datos['id_artista_formador']);
        @$sentencia->bindParam(':fecha_sesion_clase_1',$datos['fecha_mes']);
        @$sentencia->bindParam(':fecha_sesion_clase_2',$datos['fecha_mes']);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarDiasFestivosMes($datos){
        $sql="SELECT DIA_NO_HABIL AS dia FROM tb_servicio_calendario WHERE YEAR(DIA_NO_HABIL) = YEAR(:dia_mes_1) AND MONTH(DIA_NO_HABIL) = MONTH(:dia_mes_2)";
        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':dia_mes_1',$datos['fecha_mes']);
        @$sentencia->bindParam(':dia_mes_2',$datos['fecha_mes']);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function actualizarNovedad($datos){
        $sql = "UPDATE tb_terr_grupo_".$datos['tipo_grupo']."_sesion_clase_novedad SET DA_fecha_sesion_clase=:DA_fecha_sesion_clase, IN_novedad=:IN_novedad, IN_asistencia=:IN_asistencia, TX_observacion=:TX_observacion WHERE id=:id_novedad;";
        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':DA_fecha_sesion_clase',$datos['fecha_novedad']);
        @$sentencia->bindParam(':IN_novedad',$datos['id_tipo_novedad']);
        @$sentencia->bindParam(':IN_asistencia',$datos['asistencia']);
        @$sentencia->bindParam(':TX_observacion',$datos['observacion']);
        @$sentencia->bindParam(':id_novedad',$datos['id_novedad']);
        $sentencia->execute(); 
        return $sentencia->rowCount();        
    }
}