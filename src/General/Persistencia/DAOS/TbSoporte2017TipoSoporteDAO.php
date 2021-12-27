<?php

namespace General\Persistencia\DAOS; 


class TbSoporte2017TipoSoporteDAO extends GestionDAO {
    
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

    public function consultarObjeto($objeto = null) {            
        return $this->db->select("tb_soporte_2017_tipo_soporte","*");      
    }



}

