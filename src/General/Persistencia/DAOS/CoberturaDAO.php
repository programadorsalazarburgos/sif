<?php

namespace General\Persistencia\DAOS; 
use General\Persistencia\Entidades\TbCobertura;

class CoberturaDAO extends GestionDAO {

    private $db;
    
    function __construct()
    {        
        $this->db=$this->obtenerPDOBD();
    }
    
    public function crearObjeto($objeto) {
        $TbCobertura = $objeto;
        // var_dump($TbCobertura);
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$TbCobertura->getFkUsuarioCreacionEdicion().";");
        $sentencia_tb_cobertura = $this->db->prepare("INSERT INTO tb_cobertura (anio,IN_linea_atencion,FK_zona,id_colegio,id_clan,id_convenio,json_area_artistica,FK_usuario_creacion_edicion,estado) VALUES (:anio,:linea_atencion,:id_zona,:id_colegio,:id_clan,:id_convenio,:json_area_artistica,:FK_usuario_creacion_edicion,:estado);");
        $anio=$TbCobertura->getAnio();
        $linea_atencion=$TbCobertura->getLineaAtencion();
        $id_zona=$TbCobertura->getIdZona();
        $id_colegio=$TbCobertura->getIdColegio();
        $id_clan=$TbCobertura->getIdClan();
        $id_convenio=$TbCobertura->getIdConvenio();
        $json_area_artistica=$TbCobertura->getJsonAreaArtistica();
        $id_usiario=$TbCobertura->getFkUsuarioCreacionEdicion();
        $estado=$TbCobertura->getEstado();
        $sentencia_tb_cobertura->bindParam(':anio',$anio);
        $sentencia_tb_cobertura->bindParam(':linea_atencion',$linea_atencion);
        $sentencia_tb_cobertura->bindParam(':id_colegio',$id_colegio);
        $sentencia_tb_cobertura->bindParam(':id_zona',$id_zona);
        $sentencia_tb_cobertura->bindParam(':id_clan',$id_clan);
        $sentencia_tb_cobertura->bindParam(':id_convenio',$id_convenio);
        $sentencia_tb_cobertura->bindParam(':json_area_artistica',$json_area_artistica);
        $sentencia_tb_cobertura->bindParam(':FK_usuario_creacion_edicion',$id_usiario);
        $sentencia_tb_cobertura->bindParam(':estado',$estado);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia_tb_cobertura->execute();
            $id_cobertura= $this->db->lastInsertId();
            $this->db->commit();
            echo $id_cobertura;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
        return;
    }

    public function modificarObjeto($objeto) {
        $TbCobertura = $objeto;
        // var_dump($TbCobertura);
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$TbCobertura->getFkUsuarioCreacionEdicion().";");
        $sentencia_tb_cobertura = $this->db->prepare("REPLACE INTO tb_cobertura (id,anio,IN_linea_atencion,FK_zona,id_colegio,id_clan,id_convenio,json_area_artistica,FK_usuario_creacion_edicion,estado) VALUES (:id,:anio,:linea_atencion,:id_zona,:id_colegio,:id_clan,:id_convenio,:json_area_artistica,:FK_usuario_creacion_edicion,:estado);");
        $id=$TbCobertura->getId();
        $anio=$TbCobertura->getAnio();
        $linea_atencion=$TbCobertura->getLineaAtencion();
        $id_zona=$TbCobertura->getIdZona();
        $id_colegio=$TbCobertura->getIdColegio();
        $id_clan=$TbCobertura->getIdClan();
        $id_convenio=$TbCobertura->getIdConvenio();
        $json_area_artistica=$TbCobertura->getJsonAreaArtistica();
        $id_usiario=$TbCobertura->getFkUsuarioCreacionEdicion();
        $estado=$TbCobertura->getEstado();
        $sentencia_tb_cobertura->bindParam(':id',$id);
        $sentencia_tb_cobertura->bindParam(':anio',$anio);
        $sentencia_tb_cobertura->bindParam(':linea_atencion',$linea_atencion);
        $sentencia_tb_cobertura->bindParam(':id_colegio',$id_colegio);
        $sentencia_tb_cobertura->bindParam(':id_zona',$id_zona);
        $sentencia_tb_cobertura->bindParam(':id_clan',$id_clan);
        $sentencia_tb_cobertura->bindParam(':id_convenio',$id_convenio);
        $sentencia_tb_cobertura->bindParam(':json_area_artistica',$json_area_artistica);
        $sentencia_tb_cobertura->bindParam(':FK_usuario_creacion_edicion',$id_usiario);
        $sentencia_tb_cobertura->bindParam(':estado',$estado);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia_tb_cobertura->execute();
            //$id_cobertura= $this->db->lastInsertId();
            $this->db->commit();
            echo $id;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
        return;
    }

    public function eliminarObjeto($data) {
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$data['id_usuario'].";");
        $sql="DELETE FROM tb_cobertura WHERE id = :id";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id', $data['id']);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            //$id_cobertura= $this->db->lastInsertId();
            $this->db->commit();
            echo $data['id'];
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
        return;
    }

    public function consultarObjeto($localidad){

        return;
    }

    public function consultarIdAnioEstadistica(){
        $sql="SELECT PK_Anio as id_anio FROM tb_estadistica_anio;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarJSONFormadoresAnioEstadistica($id_anio){
        $sql="SELECT TX_Formadores_Area as json_formadores FROM tb_estadistica_anio WHERE PK_Anio=:id_anio;";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_anio', $id_anio);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarAreasArtisticas(){
        $sql="SELECT * FROM tb_areas_artisticas;";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarZonasIdAnioEstadistica($id_anio,$estado){
        $sql="SELECT * FROM tb_zonas WHERE estado=:estado;";
        $sentencia=$this->db->prepare($sql);
        // @$sentencia->bindParam(':id_anio', $id_anio);
        @$sentencia->bindParam(':estado', $estado);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getJsonColegioAnioEstadistica($id_anio){
        $sql="SELECT TX_Grupos_Area FROM tb_estadistica_anio WHERE PK_Anio=:id_anio";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_anio', $id_anio);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function setJsonBolsaArtistasGruposEstadisticaAnio($json,$id_persona,$id_anio){
        $sql="UPDATE tb_estadistica_anio SET JSON_bolsa_artistas_grupos=:JSON_bolsa_artistas_grupos,FK_usuario_creacion_edicion=:FK_usuario_creacion_edicion,updated_at=now() WHERE PK_Anio=:id_anio";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':JSON_bolsa_artistas_grupos', $json);
        @$sentencia->bindParam(':FK_usuario_creacion_edicion', $id_persona);
        @$sentencia->bindParam(':id_anio', $id_anio);
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function consultarJsonMatrizAsignacion($id_anio){
        $sql="SELECT JSON_bolsa_artistas_grupos FROM tb_estadistica_anio WHERE PK_Anio=:id_anio";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_anio', $id_anio);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarCoberturasActivasbyid($id){
        $sql="SELECT PD.FK_Value FROM tb_parametro_detalle PD JOIN tb_parametro P ON P.PK_Id_Parametro=PD.FK_Id_Parametro WHERE P.VC_Nombre='ÁREAS ARTÍSTICAS' AND PD.IN_Estado=1";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        $areas = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        
        $sql="SELECT PD.FK_Value FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=56 AND PD.IN_Estado = 1 ORDER BY FK_Value ASC";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        $lugares = $sentencia->fetchAll(\PDO::FETCH_ASSOC);

        $sql="SELECT *, L.VC_Descripcion AS Linea, CON.VC_Descripcion AS Convenio,";
        foreach ((array)$areas as $area) {
            $area = implode($area);

            $sql .= "(";
            foreach ((array) $lugares as $lugar) {
                $lugar = implode($lugar);
                //$sql .= "JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(COB.json_area_artistica, '$.".$area."'), '$.grupos_lugar_atencion_".$lugar."')) AS '".$area."_".$lugar."',";
                $sql .= "COALESCE(JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(COB.json_area_artistica, '$.".$area."'), '$.grupos_lugar_atencion_".$lugar."')),0) + ";
            }
            $sql .= "0) AS GRUPOS_".$area.", JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(COB.json_area_artistica, '$.".$area."'), '$.beneficiarios_proyectados')) AS '".$area."_BENEFICIARIOS',";
            $sql .= "JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(COB.json_area_artistica, '$.".$area."'), '$.observaciones')) AS '".$area."_OBSERVACIONES',";
        }
        $sql .= "1 FROM tb_cobertura COB
                JOIN tb_colegios COL ON COB.id_colegio = COL.PK_Id_Colegio
                LEFT JOIN tb_clan C ON COB.id_clan=C.PK_Id_Clan                
                JOIN tb_parametro_detalle L ON L.FK_Id_Parametro=60 AND L.FK_Value=COB.IN_linea_atencion
                JOIN tb_parametro_detalle CON ON CON.FK_Id_Parametro=68 AND CON.FK_Value=COB.id_convenio
                JOIN tb_zonas Z ON COB.FK_zona=Z.PK_Id_Zona
                WHERE COB.id = :id";
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id', $id);
        //var_dump($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarCoberturasActivas($datos){
        $sql="SELECT *,
            Z.VC_Nombre_Zona AS ZONA,
            COB.DT_fecha_creacion_edicion AS FECHA,
            L.VC_Descripcion AS LINEA_ATENCION, 
            CON.VC_Descripcion AS CONVENIO,";
        $areas = $datos['SL_area_artistica_consulta'];
        $lugares = [1,2,3,4];
        foreach ((array)$areas as $area) {
            /*foreach ((array) $lugares as $lugar) {
                $sql .= "JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(COB.json_area_artistica, '$.".$area."'), '$.grupos_lugar_atencion_".$lugar."')) AS '".$area."_".$lugar."',";
            }*/
            $sql .= "(";
            foreach ((array) $lugares as $lugar) {
                $sql .= "COALESCE(JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(COB.json_area_artistica, '$.".$area."'), '$.grupos_lugar_atencion_".$lugar."')),0) + ";
            }
            $sql .= "0) AS GRUPOS_".$area.", JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(COB.json_area_artistica, '$.".$area."'), '$.beneficiarios_proyectados')) AS '".$area."_BENEFICIARIOS',";
            $sql .= "JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(COB.json_area_artistica, '$.".$area."'), '$.observaciones')) AS '".$area."_OBSERVACIONES',";
        }
        $sql .= "1 FROM tb_cobertura COB
            JOIN tb_colegios COL ON COB.id_colegio = COL.PK_Id_Colegio
            LEFT JOIN tb_clan C ON COB.id_clan=C.PK_Id_Clan
            JOIN tb_persona_2017 P ON COB.FK_usuario_creacion_edicion = P.PK_Id_Persona
            JOIN tb_parametro_detalle L ON L.FK_Id_Parametro=60 AND L.FK_Value=COB.IN_linea_atencion
            JOIN tb_parametro_detalle CON ON CON.FK_Id_Parametro=68 AND CON.FK_Value=COB.id_convenio
            JOIN tb_zonas Z ON COB.FK_zona=Z.PK_Id_Zona
            WHERE COB.estado=1 AND COB.anio=:anio AND COB.IN_linea_atencion=:linea_atencion AND COB.FK_zona=:id_zona";
        //var_dump($sql);
        $sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':anio', $datos['SL_anio_consulta']);
        @$sentencia->bindParam(':linea_atencion', $datos['SL_linea_atencion_consulta']);
        @$sentencia->bindParam(':id_zona', $datos['SL_zona_consulta']);
        //var_dump($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTotalGruposActivosConArtistaArea($id_crea,$id_area_artistica,$linea_atencion,$id_convenio){
        if($id_convenio==0){
            $sql="SELECT COUNT(PK_Grupo) AS COUNT FROM tb_terr_grupo_".$linea_atencion." WHERE estado=1 AND FK_artista_formador IS NOT NULL AND FK_clan IN($id_crea) AND FK_area_artistica=:id_area_artistica AND (IN_convenio IS NULL OR IN_convenio = :id_convenio)";
        }
        else{
            $sql="SELECT 
            (SELECT COUNT(PK_Grupo) FROM tb_terr_grupo_arte_escuela WHERE estado=1 AND FK_artista_formador IS NOT NULL AND FK_clan IN($id_crea) AND FK_area_artistica=:id_area_artistica AND IN_convenio = :id_convenio) +
            (SELECT COUNT(PK_Grupo) FROM tb_terr_grupo_emprende_clan WHERE estado=1 AND FK_artista_formador IS NOT NULL AND FK_clan IN($id_crea) AND FK_area_artistica=:id_area_artistica AND IN_convenio = :id_convenio) +
            (SELECT COUNT(PK_Grupo) FROM tb_terr_grupo_laboratorio_clan WHERE estado=1 AND FK_artista_formador IS NOT NULL AND FK_clan IN($id_crea) AND FK_area_artistica=:id_area_artistica AND IN_convenio = :id_convenio) AS COUNT";
        }
        $sentencia=$this->db->prepare($sql);
        // @$sentencia->bindParam(':id_crea', $id_crea);
        @$sentencia->bindParam(':id_convenio', $id_convenio);
        @$sentencia->bindParam(':id_area_artistica', $id_area_artistica);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0]['COUNT'];
    }

    public function consultarTotalArtistasAsignadosAreaZona($id_crea,$id_area_artistica){
        $sql="SELECT COUNT(A.AF) AS COUNT FROM
        (SELECT DISTINCT AE.FK_artista_formador AS AF
        FROM tb_terr_grupo_arte_escuela AE
        WHERE AE.estado=1 AND AE.FK_clan IN($id_crea) AND AE.FK_area_artistica=:id_area_artistica AND AE.FK_artista_formador IS NOT NULL
        UNION 
        SELECT DISTINCT IC.FK_artista_formador AF
        FROM tb_terr_grupo_emprende_clan IC
        WHERE IC.estado=1 AND IC.FK_clan IN($id_crea) AND IC.FK_area_artistica=:id_area_artistica AND IC.FK_artista_formador IS NOT NULL
        UNION
        SELECT DISTINCT CV.FK_artista_formador AF
        FROM tb_terr_grupo_emprende_clan CV
        WHERE CV.estado=1 AND CV.FK_clan IN($id_crea) AND CV.FK_area_artistica=:id_area_artistica AND CV.FK_artista_formador IS NOT NULL) A";
        $sentencia=$this->db->prepare($sql);
        // @$sentencia->bindParam(':id_crea', $id_crea);
        @$sentencia->bindParam(':id_area_artistica', $id_area_artistica);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0]['COUNT'];
    }

    public function consultarGruposCoberturaZonaArea($id_zona, $id_area_artistica, $id_linea_atencion){
        
        $sql="SELECT PD.FK_Value FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=56 AND PD.IN_Estado = 1 ORDER BY FK_Value ASC";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        $lugares = $sentencia->fetchAll(\PDO::FETCH_ASSOC);

        $year = date('Y');
        $sql="SELECT SUM(";

        foreach ((array)$lugares as $lugar) {
            $lugar = implode($lugar);
            $sql.="COALESCE(JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(COB.json_area_artistica, '$.$id_area_artistica'), '$.grupos_lugar_atencion_".$lugar."')),0)+";
        }
        
        $sql.="0) AS COUNT
                    FROM tb_cobertura COB
                    JOIN tb_colegios COL ON COB.id_colegio = COL.PK_Id_Colegio
                    LEFT JOIN tb_clan C ON COB.id_clan=C.PK_Id_Clan
                    WHERE estado=1 AND FK_zona=:id_zona AND anio=$year AND ";
        if($id_linea_atencion<4){            
            $sql.="IN_linea_atencion=:id_linea_atencion AND id_convenio = 0";
        }
        if($id_linea_atencion==4){
            $sql.="id_convenio = 1";
        }
        if($id_linea_atencion==5){
            $sql.="id_convenio = 2";
        }
        $sentencia=$this->db->prepare($sql);

        //@$sentencia->bindParam(':id_area_artistica_a', $id_area_artistica);
        //@$sentencia->bindParam(':id_area_artistica_b', $id_area_artistica);
        @$sentencia->bindParam(':id_zona', $id_zona);
        if($id_linea_atencion<4)
            @$sentencia->bindParam(':id_linea_atencion', $id_linea_atencion);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0]['COUNT'];
    }
}