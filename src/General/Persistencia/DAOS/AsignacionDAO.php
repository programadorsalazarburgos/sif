<?php

namespace General\Persistencia\DAOS; 


class AsignacionDAO extends GestionDAO {
    
    private $db;
    function __construct()
    {        
        $this->db=$this->obtenerPDOBD();
    }
    
    public function crearObjeto($objeto) {return;}
    public function modificarObjeto($objeto) {return;}
    public function eliminarObjeto($objeto) {return;}
    public function consultarObjeto($objeto){return;}

    public function consultarArtistasFormadoresDeZona($id_zona){
    	$sql="SELECT P.PK_Id_Persona,P.VC_Identificacion,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre
			FROM tb_formador_zona FZ
			JOIN tb_persona_2017 P ON FZ.FK_Id_Persona = P.PK_Id_Persona
			WHERE FZ.FK_Id_Zona = :FK_Id_Zona;";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':FK_Id_Zona',$id_zona);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarZonas(){
        $sql="SELECT * FROM tb_zonas;";
        @$sentencia=$this->db->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionArtistaPorOrganizacion($id_organizacion){
        $sql="SELECT P.PK_Id_Persona,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre
            FROM tb_persona_2017 P
            LEFT JOIN tb_acceso_usuario_2017 AU ON P.PK_Id_Persona = AU.FK_Id_Persona
            LEFT JOIN tb_formador_organizacion_2017 O ON P.PK_Id_Persona = O.FK_Id_Persona
            WHERE O.FK_Id_Organizacion = :FK_Id_Organizacion AND AU.IN_Estado = 1 
            AND (P.FK_Tipo_Persona = 1 OR P.FK_Tipo_Persona = 2)
            UNION
            SELECT PE.PK_Id_Persona,PE.VC_Primer_Apellido,PE.VC_Segundo_Apellido,PE.VC_Primer_Nombre,PE.VC_Segundo_Nombre
                FROM tb_persona_2017 PE
            LEFT JOIN tb_acceso_usuario_2017 AU2 ON PE.PK_Id_Persona = AU2.FK_Id_Persona
            LEFT JOIN tb_af_organizacion_area_artistica OA ON PE.PK_Id_Persona = OA.FK_Id_Persona
            WHERE OA.FK_Organizacion = :FK_Id_Organizacion  AND AU2.IN_Estado = 1 
            AND (PE.FK_Tipo_Persona = 1 OR PE.FK_Tipo_Persona = 2)";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':FK_Id_Organizacion',$id_organizacion);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTipoArtistaFormador($datos){
        $sql="SELECT PD.VC_Descripcion FROM tb_af_organizacion_area_artistica AOA LEFT JOIN tb_parametro_detalle PD ON AOA.FK_Tipo_Artista = PD.FK_Value AND FK_Id_Parametro = 32 WHERE AOA.FK_Id_Persona=:FK_Id_Persona AND AOA.FK_Organizacion=:FK_Id_Organizacion AND AOA.IN_estado = 1;";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':FK_Id_Persona',$datos['id_artista_formador']);
        @$sentencia->bindParam(':FK_Id_Organizacion',$datos['id_organizacion']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarZonificacionArtista($datos){
        $sql="SELECT * FROM tb_formador_zona WHERE FK_Id_Persona=:id_artista_formador;";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_artista_formador',$datos['id_artista_formador']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }
}