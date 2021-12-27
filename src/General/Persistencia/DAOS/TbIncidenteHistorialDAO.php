<?php
namespace General\Persistencia\DAOS; 


class TbIncidenteHistorialDAO extends GestionDAO {
    
    private $db;
    private $dbPDO;
    
    function __construct()
    {        
        $this->db=$this->obtenerBD();
        $this->dbPDO=$this->obtenerPDOBD();
    }
    
    public function crearObjeto($objeto) {
            
        //echo '<pre>'.print_r($objeto,true).'</pre>';
        $inserta=0;
        try {  
            $this->dbPDO->beginTransaction();
            $sql="INSERT INTO tb_incidente_historial 
                (fecha,incidente_codigo,servicio_codigo,sla_codigo,fk_id_usuario,estado_anterior,estado_nuevo)
                VALUES(:fecha,:incidente_codigo,:servicio_codigo,:sla_codigo,:fk_id_usuario,:estado_anterior,:estado_nuevo )";    
            $sentencia=$this->dbPDO->prepare($sql);    
            @$sentencia->bindParam(':fecha',$objeto->getFecha()['valor']);
            @$sentencia->bindParam(':incidente_codigo',$objeto->getIncidenteCodigo()['valor']);
            @$sentencia->bindParam(':servicio_codigo', $objeto->getServicioCodigo()['valor']);
            @$sentencia->bindParam(':sla_codigo',$objeto->getSlaCodigo()['valor']);
            @$sentencia->bindParam(':fk_id_usuario',$objeto->getFkIdUsuario()['valor']);   
            @$sentencia->bindParam(':estado_anterior',$objeto->getEstadoAnterior()['valor']);   
            @$sentencia->bindParam(':estado_nuevo',$objeto->getEstadoNuevo()['valor']);   
            $sentencia->execute();    
            $sentencia->rowCount(); 
            $this->dbPDO->commit(); 
                        
        }catch(PDOExecption $e) { 
            $inserta=-1;
            echo  "Error!: " . $e->getMessage() . "</br>";
          $this->dbPDO->rollback();
        }    
        return $inserta;       
    }

    public function modificarObjeto($objeto) {

            return;
    }

    public function eliminarObjeto($objeto) {

            return;
    }

    public function consultarObjeto($localidad) {            
        return; 
    }

}

