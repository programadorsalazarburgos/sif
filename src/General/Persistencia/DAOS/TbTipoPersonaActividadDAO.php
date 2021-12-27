<?php
namespace General\Persistencia\DAOS; 


class TbTipoPersonaActividadDAO extends GestionDAO {
    
    private $dbPDO;
    
    function __construct()
    {        
        $this->dbPDO=$this->obtenerPDOBD();
    }

    public function crearObjeto($objeto) {
        //Nothing to do.
    }

    public function modificarObjeto($update) {
        //Nothing to do.
    }

    public function eliminarObjeto($objeto) {
        //Nothing to do.
    }

    public function consultarObjeto($localidad) {            
        //Nothing to do.
    }
    
     public function saveActividadTipoUsuario($actividadId,$tipoUsuarioId)
    {
        $sql="INSERT INTO tb_tipo_persona_actividad VALUES (:p1, :p2);";
        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindValue(':p1',$actividadId);
        @$sentencia->bindValue(':p2',$tipoUsuarioId);
        return $sentencia->execute();
    }

    
     public function deleteActividadTipoUsuario($actividadId,$tipoUsuarioId)
    {
        $sql="DELETE FROM tb_tipo_persona_actividad WHERE FK_Actividad = :p1 AND FK_Tipo_Persona =:p2;";
        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindValue(':p1',$actividadId);
        @$sentencia->bindValue(':p2',$tipoUsuarioId);
        return $sentencia->execute();
    }

}

