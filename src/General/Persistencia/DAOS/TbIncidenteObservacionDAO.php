<?php
namespace General\Persistencia\DAOS; 


class TbIncidenteObservacionDAO extends GestionDAO {
    
    private $db;
    
    function __construct()
    {        
        $this->db=$this->obtenerBD();
    }
    
    public function crearObjeto($objeto) {
        //echo print_r($objeto,true);
            
        $inserta=$this->db->insert("tb_incidente_observacion", [
        "incidente_codigo" => $objeto->getIncidenteCodigo(),
        "servicio_codigo" => $objeto->getServicioCodigo(),
        "sla_codigo" => $objeto->getSlaCodigo(),
        "observaciones"=>$objeto->getObservaciones(),
        "tipo_observacion"=>$objeto->getTipoObservacion(),
        "fK_id_persona"=>$objeto->getFkIdPersona(),
        "fecha"=>$objeto->getFecha()
        ]); 
        //echo print_r($this->db->error(),true); 
        return $inserta; 
    }

    public function modificarObjeto($objeto) {

            return;
    }

    public function eliminarObjeto($objeto) {

            return;
    }

    public function consultarObjeto($where) {            

        $sql="SELECT IO.fecha,
                     CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Apellido,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'nombre',
                     IO.observaciones,
                     IO.tipo_observacion
              FROM tb_incidente_observacion AS IO   
              JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=IO.fk_id_persona
              WHERE ".$where." ORDER BY IO.fecha";

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);            
    }

}

