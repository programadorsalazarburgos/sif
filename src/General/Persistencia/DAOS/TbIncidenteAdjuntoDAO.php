<?php
namespace General\Persistencia\DAOS; 


class TbIncidenteAdjuntoDAO extends GestionDAO {
    
    private $db;
    private $dbPDO;
    
    function __construct()
    {        
        $this->db=$this->obtenerBD();
        $this->dbPDO=$this->obtenerPDOBD();
    }
    
    public function crearObjeto($objetos) {
            
            $guardados = array();
            foreach ($objetos as $objeto) {
                $inserta=0;
                try { 
                    $this->dbPDO->beginTransaction();
                    $sql="INSERT INTO tb_incidente_adjunto 
                        (incidente_codigo,servicio_codigo,sla_codigo,ruta)
                        VALUES(:incidente_codigo,:servicio_codigo,:sla_codigo,:ruta )";    
                    $sentencia=$this->dbPDO->prepare($sql);    
                    @$sentencia->bindParam(':incidente_codigo',$objeto['incidente_codigo']);
                    @$sentencia->bindParam(':servicio_codigo',$objeto['servicio_codigo']);
                    @$sentencia->bindParam(':sla_codigo',$objeto['sla_codigo']);
                    @$sentencia->bindParam(':ruta',$objeto['ruta']);   
                    $sentencia->execute();    
                    $inserta = $this->dbPDO->lastInsertId();        
                    $this->dbPDO->commit(); 
                                
                }catch(PDOExecption $e) { 
                  $this->dbPDO->rollback();
                }   

                $guardados[]=$inserta; 
            }
            return $guardados;
    }

    public function modificarObjeto($objeto) {

            return;
    }

    public function eliminarObjeto($objeto) {

            return;
    }

    public function consultarObjeto($objeto) {            
        $sql="SELECT IA.`RUTA` FROM tb_incidente_adjunto AS IA 
              WHERE IA.`INCIDENTE_CODIGO`= :incidente_codigo AND IA.`SERVICIO_CODIGO`= :servicio_codigo AND IA.`SLA_CODIGO`= :sla_codigo";
        @$sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':incidente_codigo',$objeto->getIncidenteCodigo());
        @$sentencia->bindParam(':servicio_codigo',$objeto->getServicioCodigo());
        @$sentencia->bindParam(':sla_codigo',$objeto->getSlaCodigo());
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);            
    }

}

