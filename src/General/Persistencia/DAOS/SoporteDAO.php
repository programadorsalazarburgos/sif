<?php

namespace General\Persistencia\DAOS; 


class SoporteDAO extends GestionDAO {
    
    private $db;
    
    function __construct()
    {        
        $this->db=$this->obtenerBD();
    }
    
    public function crearObjeto($objeto) {

            return;
    }

    public function modificarObjeto($objeto) {

            return;
    }

    public function eliminarObjeto($objeto) {

            return;
    }

    public function consultarObjeto($localidad) {            
        /*$sql="SELECT * FROM tb_colegios AS C WHERE C.FK_Id_Localidad=?";
        $statement=$this->db->prepare($sql);    
        $statement->execute(array($localidad));
        $r=$statement->fetchAll(\PDO::FETCH_ASSOC);  
        return $r;*/
    }

    public function getSoportesASolucionar()
    {
        /*$sql="SELECT * FROM tb_soporte_2017 AS S WHERE S.estado<>1";
        $statement=$this->db->query($sql);              
        return $statement->fetchAll(\PDO::FETCH_ASSOC);*/

        $soporte = $this->db->select("tb_soporte_2017",[
            "[>]tb_soporte_2017_tipo_soporte"=>["FK_tipo_soporte"=>"PK_tipo_soporte"],
            "[>]tb_persona_2017"=>["FK_persona"=>"PK_Id_Persona"]
        ],[
            "tb_soporte_2017_tipo_soporte.VC_descripcion",
            "tb_soporte_2017.TX_solicitud",
            "tb_soporte_2017.DT_fecha_creacion",
            "tb_soporte_2017.FK_persona",
            "tb_persona_2017.VC_Primer_Apellido",
            "tb_persona_2017.VC_Segundo_Apellido",
            "tb_persona_2017.VC_Primer_Nombre",
            "tb_persona_2017.VC_Segundo_Nombre"
        ],
        ["estado"=>0]);
        return $soporte;        
    }

}

