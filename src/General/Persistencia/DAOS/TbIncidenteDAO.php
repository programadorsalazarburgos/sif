<?php

namespace General\Persistencia\DAOS; 


class TbIncidenteDAO extends GestionDAO {
    
    private $db;
    private $dbPDO; 
    function __construct()
    {        
        $this->db=$this->obtenerBD();
        $this->dbPDO=$this->obtenerPDOBD();
    }
    
    public function crearObjeto($objeto) {

        try { 
            $this->dbPDO->beginTransaction();
            $sql="INSERT INTO tb_incidente 
                (servicio_codigo,sla_codigo,fk_id_usuario,
                fk_tipo_soporte,titulo,descripcion_sintomas,
                fk_actividad_apertura,estado,metodo_notificacion,
                FECHA_CREACION,fk_observadores)
                VALUES(:servicio_codigo,:sla_codigo,:fk_id_usuario,
                       :fk_tipo_soporte,:titulo,:descripcion_sintomas,
                       :fk_actividad_apertura,:estado,:metodo_notificacion,
                       :FECHA_CREACION,:fk_observadores )";
            $estado="abierto";
            $metodo_notificacion="SIF";
            $sentencia=$this->dbPDO->prepare($sql);    
            @$sentencia->bindParam(':servicio_codigo',$objeto->getServicioCodigo()['valor']);
            @$sentencia->bindParam(':sla_codigo',$objeto->getSlaCodigo()['valor']);
            @$sentencia->bindParam(':fk_id_usuario',$objeto->getFkIdUsuario()['valor']);
            @$sentencia->bindParam(':fk_tipo_soporte',$objeto->getFkTipoSoporte()['valor']);
            @$sentencia->bindParam(':titulo',$objeto->getTitulo()['valor']);
            @$sentencia->bindParam(':descripcion_sintomas',$objeto->getDescripcionSintomas()['valor']);
            @$sentencia->bindParam(':fk_actividad_apertura',$objeto->getFkActividadApertura()['valor']);
            @$sentencia->bindParam(':estado',$estado);
            @$sentencia->bindParam(':metodo_notificacion',$metodo_notificacion);
            @$sentencia->bindParam(':FECHA_CREACION',$objeto->getFechaCreacion()['valor']);
            @$sentencia->bindParam(':fk_observadores',$objeto->getFKObservadores()['valor']);    
            $sentencia->execute();    
            $codigo = $this->dbPDO->lastInsertId();        
            $this->dbPDO->commit();
            return $codigo;   
                        
        }catch(PDOExecption $e) { 
          $this->dbPDO->rollback();
          return "Error!: " . $e->getMessage() . "</br>";
        }            
    }

    public function modificarObjeto($update) {
        $sql="UPDATE tb_incidente AS I 
                SET ".$update;            
        $sentencia=$this->dbPDO->prepare($sql);   
        $sentencia->execute();  
        return  $sentencia->rowCount(); 

        //return $this->db->query($sql)->rowCount();  
    }

    public function eliminarObjeto($objeto) {

            return;
    }

    public function consultarObjeto($localidad) {            
        return;  
    }

    public function consultarHistoricoIncidente($where)
    {
 
        $sql="SELECT 
                I.codigo,
                TS.VC_descripcion,
                I.titulo,            
                I.descripcion_sintomas,
                I.prioridad,
                I.fecha_Creacion,
                I.descripcion_solucion,
                I.fecha_cierre,
                I.estado,
                I.FK_Actividad_Apertura,
                I.FK_Actividad_Cierre,
                I.urgencia,
                I.impacto,
                I.prioridad,
                F.vc_primer_nombre AS 'primer_nombre_funcionario',
                F.vc_segundo_nombre AS 'segundo_nombre_funcionario',
                F.vc_primer_apellido AS 'primer_apellido_funcionario',
                F.vc_segundo_apellido AS 'segundo_apellido_funcionario',
                U.vc_primer_nombre AS 'primer_nombre_usuario',
                U.vc_segundo_nombre AS 'segundo_nombre_usuario',
                U.vc_primer_apellido AS 'primer_apellido_usuario',
                U.vc_segundo_apellido AS 'segundo_apellido_usuario',
                AA.VC_Nom_Actividad AS 'actividad_apertura',
                AC.VC_Nom_Actividad AS 'actividad_cierre',
                I.FK_Id_Usuario,
                (SELECT GROUP_CONCAT(CONCAT(OB.VC_Primer_Nombre,' ',OB.VC_Segundo_Nombre,' ',OB.VC_Primer_Apellido,' ',OB.VC_Segundo_Apellido))  FROM tb_persona_2017 as OB where FIND_IN_SET(OB.PK_Id_Persona,I.FK_observadores)) AS observadores,
                (SELECT GROUP_CONCAT(OB.PK_Id_Persona)  FROM tb_persona_2017 as OB where FIND_IN_SET(OB.PK_Id_Persona,I.FK_observadores)) AS observadores_id
                FROM tb_incidente AS I 
                JOIN tb_soporte_2017_tipo_soporte AS TS ON I.FK_tipo_soporte = TS.PK_tipo_soporte
                LEFT JOIN tb_persona_2017 AS F ON I.FK_Id_Usuario_Funcionario=F.PK_Id_Persona
                LEFT JOIN  tb_persona_2017 AS U ON I.FK_Id_Usuario = U.PK_Id_Persona
                LEFT JOIN tb_menu_actividad AS AA ON I.FK_Actividad_Apertura=AA.PK_Id_Actividad
                LEFT JOIN tb_menu_actividad AS AC ON I.FK_Actividad_Cierre=AC.PK_Id_Actividad
                 WHERE ".$where;  
        $sentencia=$this->dbPDO->prepare($sql);   
        $sentencia->execute();   
        return  $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        //return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function consultaMiHistoricoIncidente($objeto)
    {

        $sql="SELECT 
                I.codigo,
                TS.VC_descripcion,
                I.titulo,            
                I.descripcion_sintomas,
                I.prioridad,
                I.fecha_Creacion,
                I.descripcion_solucion,
                I.fecha_cierre,
                I.estado,
                I.FK_Actividad_Apertura,
                I.FK_Actividad_Cierre,
                I.urgencia,
                I.impacto,
                I.prioridad,
                F.PK_Id_Persona as atendido_por,
                F.vc_primer_nombre AS 'primer_nombre_funcionario',
                F.vc_segundo_nombre AS 'segundo_nombre_funcionario',
                F.vc_primer_apellido AS 'primer_apellido_funcionario',
                F.vc_segundo_apellido AS 'segundo_apellido_funcionario',
                U.vc_primer_nombre AS 'primer_nombre_usuario',
                U.vc_segundo_nombre AS 'segundo_nombre_usuario',
                U.vc_primer_apellido AS 'primer_apellido_usuario',
                U.vc_segundo_apellido AS 'segundo_apellido_usuario',
                AA.VC_Nom_Actividad AS 'actividad_apertura',
                AC.VC_Nom_Actividad AS 'actividad_cierre',
                I.FK_Id_Usuario,
                CONCAT(U.VC_Primer_Nombre,' ',U.VC_Segundo_Nombre,' ',U.VC_Primer_Apellido,' ',U.VC_Segundo_Apellido) as usuario,
                (SELECT GROUP_CONCAT(CONCAT(OB.VC_Primer_Nombre,' ',OB.VC_Segundo_Nombre,' ',OB.VC_Primer_Apellido,' ',OB.VC_Segundo_Apellido))  FROM tb_persona_2017 as OB where FIND_IN_SET(OB.PK_Id_Persona,I.FK_observadores)) AS observadores,
                (SELECT GROUP_CONCAT(OB.PK_Id_Persona)  FROM tb_persona_2017 as OB where FIND_IN_SET(OB.PK_Id_Persona,I.FK_observadores)) AS observadores_id                
                FROM tb_incidente AS I 
                JOIN tb_soporte_2017_tipo_soporte AS TS ON I.FK_tipo_soporte = TS.PK_tipo_soporte
                LEFT JOIN tb_persona_2017 AS F ON I.FK_Id_Usuario_Funcionario=F.PK_Id_Persona
                LEFT JOIN  tb_persona_2017 AS U ON I.FK_Id_Usuario = U.PK_Id_Persona
                LEFT JOIN tb_menu_actividad AS AA ON I.FK_Actividad_Apertura=AA.PK_Id_Actividad
                LEFT JOIN tb_menu_actividad AS AC ON I.FK_Actividad_Cierre=AC.PK_Id_Actividad
                WHERE I.SLA_CODIGO=:sla_codigo AND (I.FK_Id_Usuario=:fk_id_usuario OR FIND_IN_SET(:fk_id_usuario,I.FK_observadores) > 0)";            
   
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':sla_codigo',$objeto->getSlaCodigo());      
        @$sentencia->bindParam(':fk_id_usuario',$objeto->getFkIdUsuario());       
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

    }    

}


?>
