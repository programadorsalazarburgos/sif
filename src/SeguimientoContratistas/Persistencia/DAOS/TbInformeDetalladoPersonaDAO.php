<?php

namespace SeguimientoContratistas\Persistencia\DAOS; 
use General\Persistencia\DAOS\GestionDAO;

class tbInformeDetalladoPersonaDAO extends GestionDAO {

    private $db;
    private $dbPDO;
    
    function __construct()
    {        
        $this->db=$this->obtenerBD();
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

    public function consultarObjeto($objeto) {            
    	//Nothing to do.
    }
    public function getInformeDetallado($informeId) {            
        $sentencia = $this->dbPDO->prepare("SELECT tidp.FK_Id_Informe_Pago,tidp.FK_Persona,tidp.IN_Tipo_Territorial,tidp.VC_Periodo_Inicio,tidp.VC_Periodo_Fin,tidp.VC_Numero_Contrato,tidp.VC_Numero_Obligaciones,tidp.TX_Obligaciones_Json,tidp.VC_Url_Anexo,tidp.DA_Subida,tidp.SM_Finalizado,tidp.SM_Estado,tidp.VC_Observacion,tidp.DA_Revision,tidp.FK_Persona_Reviso,tidp.DA_Aprobo,tidp.FK_Persona_Aprobo,tippb.FK_Persona_Supervisor,tippb.FK_Persona_Apoyo_Supervisor,tippb.FK_Aprobacion,tippb.FK_Aprobacion_Administrativo FROM db_informe_pago.tb_informe_detallado_persona tidp JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tidp.FK_Persona WHERE tippb.SM_Activo = 1 AND FK_Id_Informe_Pago = :FK_Id_Informe_Pago");

        @$sentencia->bindParam(':FK_Id_Informe_Pago',$informeId);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function saveInformeDetallado($objeto) {            
        $sentencia = $this->dbPDO->prepare("INSERT INTO db_informe_pago.tb_informe_detallado_persona (FK_Id_Informe_Pago,FK_Persona,IN_Tipo_Territorial,VC_Periodo_Inicio,VC_Periodo_Fin,VC_Numero_Contrato,VC_Numero_Obligaciones,TX_Obligaciones_Json,VC_Url_Anexo,DA_Subida,SM_Finalizado) VALUES(:FK_Id_Informe_Pago,:FK_Persona,:IN_Tipo_Territorial,:VC_Periodo_Inicio,:VC_Periodo_Fin,:VC_Numero_Contrato,:VC_Numero_Obligaciones,:TX_Obligaciones_Json,:VC_Url_Anexo,now(),:SM_Finalizado) ON DUPLICATE KEY UPDATE FK_Id_Informe_Pago = VALUES(FK_Id_Informe_Pago),FK_Persona = VALUES(FK_Persona),IN_Tipo_Territorial = VALUES(IN_Tipo_Territorial),VC_Periodo_Inicio = VALUES(VC_Periodo_Inicio),VC_Periodo_Fin = VALUES(VC_Periodo_Fin),VC_Numero_Contrato = VALUES(VC_Numero_Contrato),VC_Numero_Obligaciones = VALUES(VC_Numero_Obligaciones),TX_Obligaciones_Json = VALUES(TX_Obligaciones_Json),VC_Url_Anexo = VALUES(VC_Url_Anexo),DA_Subida = VALUES(DA_Subida),SM_Finalizado = VALUES(SM_Finalizado),SM_Estado = VALUES(SM_Estado),DA_Revision = VALUES(DA_Revision),FK_Persona_Reviso = VALUES(FK_Persona_Reviso),DA_Aprobo = VALUES(DA_Aprobo),FK_Persona_Aprobo = VALUES(FK_Persona_Aprobo);");

        @$sentencia->bindParam(':FK_Id_Informe_Pago',$objeto->getFkIdInformePago());
        @$sentencia->bindParam(':FK_Persona',$objeto->getFkPersona());
        @$sentencia->bindParam(':IN_Tipo_Territorial',$objeto->getInTipoTerritorial());
        @$sentencia->bindParam(':VC_Periodo_Inicio',$objeto->getVcPeriodoInicio());
        @$sentencia->bindParam(':VC_Periodo_Fin',$objeto->getVcPeriodoFin());
        @$sentencia->bindParam(':VC_Numero_Contrato',$objeto->getVcNumeroContrato());
        @$sentencia->bindParam(':VC_Numero_Obligaciones',$objeto->getVcNumeroObligaciones());
        @$sentencia->bindParam(':TX_Obligaciones_Json',$objeto->getTxObligacionesJson());
        @$sentencia->bindParam(':VC_Url_Anexo',$objeto->getVcUrlAnexo());
        @$sentencia->bindParam(':SM_Finalizado',$objeto->getSmFinalizado());
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }
    public function saveInformeDetalladoLog($objeto) {            
        $sentencia = $this->dbPDO->prepare("INSERT INTO db_informe_pago.tb_informe_detallado_persona_log (FK_Id_Informe_Pago,FK_Persona,IN_Tipo_Territorial,VC_Periodo_Inicio,VC_Periodo_Fin,VC_Numero_Contrato,VC_Numero_Obligaciones,TX_Obligaciones_Json,VC_Url_Anexo,DA_Subida,SM_Finalizado,SM_Estado,VC_Observacion,DA_Revision,FK_Persona_Reviso,DA_Aprobo,FK_Persona_Aprobo) SELECT FK_Id_Informe_Pago,FK_Persona,IN_Tipo_Territorial,VC_Periodo_Inicio,VC_Periodo_Fin,VC_Numero_Contrato,VC_Numero_Obligaciones,TX_Obligaciones_Json,VC_Url_Anexo,DA_Subida,SM_Finalizado,SM_Estado,VC_Observacion,DA_Revision,FK_Persona_Reviso,DA_Aprobo,FK_Persona_Aprobo FROM db_informe_pago.tb_informe_detallado_persona WHERE FK_Id_Informe_Pago = :FK_Id_Informe_Pago;");

        @$sentencia->bindParam(':FK_Id_Informe_Pago',$objeto->getFkIdInformePago());
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }
    public function saveObservacion($observacion,$informeId,$aprobado,$userId,$finalizado) {
        if ($aprobado == 0){
            $extraData = ", FK_Persona_Aprobo = :FK_Persona, DA_Aprobo = now() ";
        }
        else{
            $extraData = ", FK_Persona_Reviso = :FK_Persona, DA_Revision = now() ";
        }

        $sentencia = $this->dbPDO->prepare('UPDATE db_informe_pago.tb_informe_detallado_persona SET VC_Observacion = :VC_Observacion, SM_Finalizado = :SM_Finalizado, SM_Estado = :SM_Estado '.$extraData.' WHERE FK_Id_Informe_Pago = :FK_Id_Informe_Pago');

        @$sentencia->bindParam(':VC_Observacion',$observacion);
        @$sentencia->bindParam(':FK_Id_Informe_Pago',$informeId);
        @$sentencia->bindParam(':SM_Finalizado',$finalizado);
        @$sentencia->bindParam(':SM_Estado',$aprobado);
        @$sentencia->bindParam(':FK_Persona',$userId);
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }

    public function saveEstadoInformeDetallado($informeId,$aprobado,$userId) {
        if ($aprobado == 0)
            $extraData = "SM_Finalizado = :SM_Finalizado";
        else
            $extraData = "SM_Estado = :SM_Estado";

        $sentencia = $this->dbPDO->prepare('UPDATE db_informe_pago.tb_informe_detallado_persona SET 
            '.$extraData.',
            FK_Persona_Aprobo = :FK_Persona, DA_Aprobo = now()
            WHERE FK_Id_Informe_Pago = :FK_Id_Informe_Pago');
        @$sentencia->bindParam(':FK_Id_Informe_Pago',$informeId);
        if ($aprobado == 0)
            @$sentencia->bindParam(':SM_Finalizado',$aprobado);
        else
            @$sentencia->bindParam(':SM_Estado',$aprobado);
        @$sentencia->bindParam(':FK_Persona',$userId);
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }
    public function limpiarAnexosFormatos($fkpersona) {            
        $sentencia = $this->dbPDO->prepare("UPDATE db_informe_pago.tb_informe_detallado_persona SET VC_Url_Anexo = '' WHERE FK_Persona = :FK_Persona;");
        $sentencia->bindParam(':FK_Persona',$fkpersona);
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }

    public function getUltimoContratoActivo($userId)
    {
        $sentencia = $this->dbPDO->prepare("SELECT VC_Nombres_Apellidos_Cedente, PK_Id_Tabla, VC_Numero_Contrato, FK_Persona_Supervisor, VC_Pago_Numero, VC_Numero_Pagos FROM db_informe_pago.tb_informe_pago_persona_basico WHERE FK_Persona = :userId AND SM_Activo=1 ORDER BY PK_Id_Tabla DESC LIMIT 1;");
        @$sentencia->bindParam(':userId',$userId);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUltimoInforme($userId)
    {
        $sentencia = $this->dbPDO->prepare("SELECT PK_Id_Tabla, VC_Numero_Contrato, FK_Persona_Supervisor FROM db_informe_pago.tb_informe_pago_persona WHERE FK_Persona = :userId ORDER BY PK_Id_Tabla DESC LIMIT 1;");
        @$sentencia->bindParam(':userId',$userId);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }
}
