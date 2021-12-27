<?php

namespace General\Persistencia\DAOS;


class ZonaDAO extends GestionDAO {

    private $db;
    function __construct()
    {
        $this->db=$this->obtenerPDOBD();
    }

    public function crearObjeto($objeto) {return;}
    public function modificarObjeto($objeto) {return;}
    public function eliminarObjeto($objeto) {return;}
    
    public function consultarObjeto($objeto){
        $sentencia = $this->db->prepare("SELECT * FROM tb_zonas;");
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function crearNuevaZona($datos){
        $json_artistas_por_area = array();
        foreach ($datos as $key => $value) {
            if(strpos($key, 'IN_artistas_area') !== false){
                array_push($json_artistas_por_area,array(substr($key,-1,1),$value));
            }
        }
        if(count($datos['SL_localidades_zona']) > 1){
            $id_localidades=implode(',',$datos['SL_localidades_zona']);
        }else{
            $id_localidades=$datos['SL_localidades_zona'];
        }
        if(count($datos['SL_creas_zona']) > 1){
            $id_creas=implode(',',$datos['SL_creas_zona']);
        }
        else{
            $id_creas=$datos['SL_creas_zona'];
        }
        $json_artistas_por_area = json_encode($json_artistas_por_area);
    	$sentencia = $this->db->prepare("INSERT INTO tb_zonas (VC_Nombre_Zona,FK_persona_responsable,VC_Localidades,VC_Creas,FK_estadistica_anio) VALUES (:VC_Nombre_Zona, :FK_persona_responsable, :VC_Localidades, :VC_Creas,:FK_estadistica_anio)");
    	@$sentencia->bindParam(':VC_Nombre_Zona',$datos['TX_nombre_zona']);
    	@$sentencia->bindParam(':FK_persona_responsable',$datos['SL_responsable_zona']);
    	@$sentencia->bindParam(':VC_Localidades',$id_localidades);
        @$sentencia->bindParam(':VC_Creas',$id_creas);
        $FK_estadistica_anio='2020';
        @$sentencia->bindParam(':FK_estadistica_anio',$FK_estadistica_anio);
    	try {
            $this->db->beginTransaction();
            // $set_id_usuario->execute();
            $sentencia->execute();
            $id_zona= $this->db->lastInsertId();
            /*for ($i=1; $i <=8; $i++) { 
                $sentencia_artista_avatar = $this->db->prepare("INSERT INTO tb_cobertura_artista_formador_avatar (id,id_zona,id_area_artistica,nombre) VALUES (:id,:id_zona,:id_area_artistica,:nombre);");
                for($j=1; $j<=$datos["IN_artistas_area_".$i];$j++){
                    $id_artista_avatar = $i.$id_zona;
                    if($j<10){
                        $id_artista_avatar.="000";
                    }else if($j>=10 && $j<100){
                        $id_artista_avatar.="00";
                    }
                    $id_artista_avatar.=$j;
                    $nombre_artista_avatar = "AF-".$datos['TX_nombre_zona']."-".$id_artista_avatar;

                    @$sentencia_artista_avatar->bindParam(':id', $id_artista_avatar);
                    @$sentencia_artista_avatar->bindParam(':id_zona', $id_zona);
                    @$sentencia_artista_avatar->bindParam(':id_area_artistica', $i);
                    @$sentencia_artista_avatar->bindParam(':nombre', $nombre_artista_avatar);
                    $sentencia_artista_avatar->execute();
                }
            }*/
    		$this->db->commit();
    		return $id_zona;
    	}catch(PDOExecption $e) {
    		$this->db->rollback();
    		return "Error!: " . $e->getMessage() . "</br>";
    	}
    }

    public function modificarZona($datos,$id_zona_modificar){
        $json_artistas_por_area = array();
        foreach ($datos as $key => $value) {
            if(strpos($key, 'IN_artistas_area_modificar') !== false){
                array_push($json_artistas_por_area,array(substr($key,-1,1),$value));
            }
        }
        $json_artistas_por_area = json_encode($json_artistas_por_area);
        $id_localidades=0;
        $id_creas=0;
        if(count($datos['SL_localidades_zona_modificar']) > 1){
            $id_localidades=implode(',',$datos['SL_localidades_zona_modificar']);
        }else{
            $id_localidades=$datos['SL_localidades_zona_modificar'];
        }

        if(count($datos['SL_creas_zona_modificar']) > 1){
            $id_creas=implode(',',$datos['SL_creas_zona_modificar']);
        }
        else{
            $id_creas=$datos['SL_creas_zona_modificar'];
        }
        $sentencia = $this->db->prepare("UPDATE tb_zonas SET
         VC_Nombre_Zona=:VC_Nombre_Zona,
         FK_persona_responsable=:FK_persona_responsable,
         VC_Localidades=:VC_Localidades,
         VC_Creas=:VC_Creas,
         DT_fecha_creacion_edicion=NOW() 
         WHERE Pk_Id_Zona=:Pk_Id_Zona;");
        @$sentencia->bindParam(':VC_Nombre_Zona',$datos['TX_nombre_zona_modificar']);
        @$sentencia->bindParam(':FK_persona_responsable',$datos['SL_responsable_zona_modificar']);
        @$sentencia->bindParam(':VC_Localidades',$id_localidades);
        @$sentencia->bindParam(':VC_Creas',$id_creas);
        // @$sentencia->bindParam(':VC_Artistas_Area',$json_artistas_por_area);
        @$sentencia->bindParam(':Pk_Id_Zona',$id_zona_modificar);

        try {
            $this->db->beginTransaction();
// $set_id_usuario->execute();
            $sentencia->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function consultarZonasFormador($datos){
        $sentencia = $this->db->prepare("SELECT JSON_zona FROM tb_formador_zona WHERE FK_Id_Persona=:FK_Id_Persona;");
        @$sentencia->bindParam(':FK_Id_Persona',$datos['id_artista_formador']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function GuardarNuevasZonasFormador($datos){
        $json_zonas = json_encode($datos['zonas']);
        $sentencia = $this->db->prepare("INSERT INTO tb_formador_zona(FK_Id_Persona,JSON_zona) VALUES (:FK_Id_Persona,:JSON_zona);");
        @$sentencia->bindParam(':FK_Id_Persona',$datos['id_artista_formador']);
        @$sentencia->bindParam(':JSON_zona',$json_zonas);
        try {
            $this->db->beginTransaction();
            $sentencia->execute();
            $id_zona= $this->db->lastInsertId();
            $this->db->commit();
            return $id_zona;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function ActualizarZonasFormador($datos){
        $json_zonas = json_encode($datos['zonas']);
        $sentencia = $this->db->prepare("UPDATE tb_formador_zona SET JSON_zona=:JSON_zona WHERE FK_Id_Persona=:FK_Id_Persona;");
        @$sentencia->bindParam(':JSON_zona',$json_zonas);
        @$sentencia->bindParam(':FK_Id_Persona',$datos['id_artista_formador']);
        try {
            $this->db->beginTransaction();
            // $set_id_usuario->execute();
            $sentencia->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function ConsultarArtistasAreaPorZona($id_zona){
        $sentencia = $this->db->prepare("SELECT VC_Artistas_Area FROM tb_zonas WHERE PK_Id_Zona=:PK_Id_Zona;");
        @$sentencia->bindParam(':PK_Id_Zona',$id_zona);
        try {
            $this->db->beginTransaction();
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function consultarDisponibilidadArtistas($datos){
        var_dump($datos);
    }
}