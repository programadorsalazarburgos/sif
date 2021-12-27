<?php

namespace SeguimientoContratistas\Persistencia\DAOS; 
use General\Persistencia\DAOS\GestionDAO;
use SeguimientoContratistas\Modelo\Firma\TipoDocumento;
use SeguimientoContratistas\Modelo\Firma\RadicadoResponse;

class TbInformePagoPersonaDAO extends GestionDAO {

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
    public function saveInformePago($objeto) {
            $sentencia = $this->dbPDO->prepare('INSERT INTO db_informe_pago.tb_informe_pago_persona (FK_Persona,VC_Fecha_Informe, VC_Periodo_Inicio, VC_Periodo_Fin, VC_Numero_Contrato, VC_Tipo_Identificacion, VC_Identificacion, VC_Ciiu, VC_Nombres_Apellidos_Cedente, VC_Tipo_Identificacion_Cedente, VC_Identificacion_Cendete, VC_Banco, VC_Tipo_Cuenta, VC_Numero_Cuenta, VC_Objeto, VC_Fecha_Inicio, VC_Plazo_Inicial, VC_Prorrogas, VC_Fecha_Plazo_Fin, VC_Fecha_Fin, VC_Numero_Pagos, VC_Pago_Numero, VC_Pago_De_Total, TX_Rp_Json, VC_Valor_Inicial, VC_Valor_Adicion_1, VC_Valor_Adicion_2, VC_Valor_Adicion_3, VC_Valor_Total_Contrato, VC_Valor_Pago_Efectuar, VC_Valor_Letras, VC_Giros_Efectuados, VC_Saldo_Pediente, VC_Valor_Liberar, VC_Numero_Obligaciones, TX_Obligaciones_Json, VC_Textarea_Producto, VC_Textarea_Mecanismo_Verificacion, TX_Declaracion_Json, VC_Disminucion_Retencion, VC_Tomados_Retencion, VC_Mes_Planilla, VC_Numero_Planilla,TX_Planillas_Extras, DA_Subida,SM_Finalizado,VC_Suspension, FK_Basico) VALUES ( :FK_Persona,:VC_Fecha_Informe , :VC_Periodo_Inicio, :VC_Periodo_Fin, :VC_Numero_Contrato, :VC_Tipo_Identificacion, :VC_Identificacion, :VC_Ciiu, :VC_Nombres_Apellidos_Cedente, :VC_Tipo_Identificacion_Cedente, :VC_Identificacion_Cendete, :VC_Banco, :VC_Tipo_Cuenta, :VC_Numero_Cuenta, :VC_Objeto, :VC_Fecha_Inicio, :VC_Plazo_Inicial, :VC_Prorrogas, :VC_Fecha_Plazo_Fin, :VC_Fecha_Fin, :VC_Numero_Pagos, :VC_Pago_Numero, :VC_Pago_De_Total, :TX_Rp_Json, :VC_Valor_Inicial, :VC_Valor_Adicion_1, :VC_Valor_Adicion_2, :VC_Valor_Adicion_3, :VC_Valor_Total_Contrato, :VC_Valor_Pago_Efectuar, :VC_Valor_Letras, :VC_Giros_Efectuados, :VC_Saldo_Pediente, :VC_Valor_Liberar, :VC_Numero_Obligaciones, :TX_Obligaciones_Json, :VC_Textarea_Producto, :VC_Textarea_Mecanismo_Verificacion, :TX_Declaracion_Json, :VC_Disminucion_Retencion, :VC_Tomados_Retencion, :VC_Mes_Planilla, :VC_Numero_Planilla,:TX_Planillas_Extras,now(),:SM_Finalizado,:VC_Suspension, :FK_Basico);');

        $this->bindParams($sentencia,$objeto);
        @$sentencia->bindParam(':TX_Planillas_Extras',$objeto->getTxPlanillasExtras());
        $sentencia->execute();
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
        /*try{
            $this->dbPDO->beginTransaction();
            $sentencia->execute();
            $id_insertado = $this->dbPDO->lastInsertId();
            
            $sql2=("UPDATE db_informe_pago.tb_informe_pago_anexos_orfeo SET
                        FK_Informe_pago_persona = :FK_Informe_pago_persona
                    WHERE
                        FK_Informe_pago_basico = :FK_Informe_pago_basico
            ");
            @$sentencia2=$this->dbPDO->prepare($sql2);
            @$sentencia2->bindparam(':FK_Informe_pago_persona', $id_insertado);
            @$sentencia2->bindparam(':FK_Informe_pago_basico', $objeto->getFkBasico());
            

              $sentencia2->execute();
            
            $this->dbPDO->commit();
            $filasAfectadas = $sentencia->rowCount();
            return $filasAfectadas;   
            //return true;
          }catch(PDOExecption $e) {
            $this->dbPDO->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
          }*/
    }
    public function saveInformePagoLog($informeId) {
        $sql = 'INSERT INTO db_informe_pago.tb_informe_pago_persona_log (FK_Id_Informe,FK_Persona,VC_Fecha_Informe,VC_Periodo_Inicio,VC_Periodo_Fin,VC_Numero_Contrato,VC_Tipo_Identificacion,VC_Identificacion,VC_Ciiu,VC_Nombres_Apellidos_Cedente,VC_Tipo_Identificacion_Cedente,VC_Identificacion_Cendete,VC_Banco,VC_Tipo_Cuenta,VC_Numero_Cuenta,VC_Objeto,VC_Fecha_Inicio,VC_Plazo_Inicial,VC_Prorrogas,VC_Fecha_Plazo_Fin,VC_Fecha_Fin,VC_Numero_Pagos,VC_Pago_Numero,VC_Pago_De_Total,TX_Rp_Json,VC_Valor_Inicial,VC_Valor_Adicion_1,VC_Valor_Adicion_2,VC_Valor_Adicion_3,VC_Valor_Total_Contrato,VC_Valor_Pago_Efectuar,VC_Valor_Letras,VC_Giros_Efectuados,VC_Saldo_Pediente,VC_Valor_Liberar,VC_Numero_Obligaciones,TX_Obligaciones_Json,VC_Textarea_Producto,VC_Textarea_Mecanismo_Verificacion,TX_Declaracion_Json,VC_Disminucion_Retencion,VC_Tomados_Retencion,VC_Mes_Planilla,VC_Numero_Planilla,FK_Persona_Supervisor,FK_Persona_Apoyo_Supervisor,DA_Subida,SM_Finalizado,SM_Estado,VC_Observacion,DA_Revision,FK_Persona_Reviso,DA_Aprobo,FK_Persona_Aprobo,TX_Planillas_Extras, FK_Basico) SELECT PK_Id_Tabla,FK_Persona,VC_Fecha_Informe,VC_Periodo_Inicio,VC_Periodo_Fin,VC_Numero_Contrato,VC_Tipo_Identificacion,VC_Identificacion,VC_Ciiu,VC_Nombres_Apellidos_Cedente,VC_Tipo_Identificacion_Cedente,VC_Identificacion_Cendete,VC_Banco,VC_Tipo_Cuenta,VC_Numero_Cuenta,VC_Objeto,VC_Fecha_Inicio,VC_Plazo_Inicial,VC_Prorrogas,VC_Fecha_Plazo_Fin,VC_Fecha_Fin,VC_Numero_Pagos,VC_Pago_Numero,VC_Pago_De_Total,TX_Rp_Json,VC_Valor_Inicial,VC_Valor_Adicion_1,VC_Valor_Adicion_2,VC_Valor_Adicion_3,VC_Valor_Total_Contrato,VC_Valor_Pago_Efectuar,VC_Valor_Letras,VC_Giros_Efectuados,VC_Saldo_Pediente,VC_Valor_Liberar,VC_Numero_Obligaciones,TX_Obligaciones_Json,VC_Textarea_Producto,VC_Textarea_Mecanismo_Verificacion,TX_Declaracion_Json,VC_Disminucion_Retencion,VC_Tomados_Retencion,VC_Mes_Planilla,VC_Numero_Planilla,FK_Persona_Supervisor,FK_Persona_Apoyo_Supervisor,DA_Subida,SM_Finalizado,SM_Estado,VC_Observacion,DA_Revision,FK_Persona_Reviso,DA_Aprobo,FK_Persona_Aprobo,TX_Planillas_Extras, FK_Basico FROM db_informe_pago.tb_informe_pago_persona WHERE PK_Id_Tabla = ';

        if ($informeId == null )
            $sql = $sql.' LAST_INSERT_ID() '.';';
        else
            $sql = $sql.':FK_Id_Informe'.';';
        $sentencia = $this->dbPDO->prepare($sql);
        if ($informeId != null )
            @$sentencia->bindParam(':FK_Id_Informe',$informeId);
        
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }

    public function updateInformePago($objeto,$informeId) {
        $extra = "";
        if ($objeto->getTxPlanillasExtras() != "")
            $extra = "TX_Planillas_Extras = :TX_Planillas_Extras,";
        $sentencia = $this->dbPDO->prepare("UPDATE db_informe_pago.tb_informe_pago_persona SET 
            FK_Persona = :FK_Persona,
            VC_Fecha_Informe = :VC_Fecha_Informe,
            VC_Periodo_Inicio = :VC_Periodo_Inicio,
            VC_Periodo_Fin = :VC_Periodo_Fin,
            VC_Numero_Contrato = :VC_Numero_Contrato,
            VC_Tipo_Identificacion = :VC_Tipo_Identificacion,
            VC_Identificacion = :VC_Identificacion,
            VC_Ciiu = :VC_Ciiu,
            VC_Nombres_Apellidos_Cedente = :VC_Nombres_Apellidos_Cedente,
            VC_Tipo_Identificacion_Cedente = :VC_Tipo_Identificacion_Cedente,
            VC_Identificacion_Cendete = :VC_Identificacion_Cendete,
            VC_Banco = :VC_Banco,
            VC_Tipo_Cuenta = :VC_Tipo_Cuenta,
            VC_Numero_Cuenta = :VC_Numero_Cuenta,
            VC_Objeto = :VC_Objeto,
            VC_Fecha_Inicio = :VC_Fecha_Inicio,
            VC_Plazo_Inicial = :VC_Plazo_Inicial,
            VC_Prorrogas = :VC_Prorrogas,
            VC_Fecha_Plazo_Fin = :VC_Fecha_Plazo_Fin,
            VC_Fecha_Fin = :VC_Fecha_Fin,
            VC_Numero_Pagos = :VC_Numero_Pagos,
            VC_Pago_Numero = :VC_Pago_Numero,
            VC_Pago_De_Total = :VC_Pago_De_Total,
            TX_Rp_Json = :TX_Rp_Json,
            VC_Valor_Inicial = :VC_Valor_Inicial,
            VC_Valor_Adicion_1 = :VC_Valor_Adicion_1,
            VC_Valor_Adicion_2 = :VC_Valor_Adicion_2,
            VC_Valor_Adicion_3 = :VC_Valor_Adicion_3,
            VC_Valor_Total_Contrato = :VC_Valor_Total_Contrato,
            VC_Valor_Pago_Efectuar = :VC_Valor_Pago_Efectuar,
            VC_Valor_Letras = :VC_Valor_Letras,
            VC_Giros_Efectuados = :VC_Giros_Efectuados,
            VC_Saldo_Pediente = :VC_Saldo_Pediente,
            VC_Valor_Liberar = :VC_Valor_Liberar,
            VC_Numero_Obligaciones = :VC_Numero_Obligaciones,
            TX_Obligaciones_Json = :TX_Obligaciones_Json,
            VC_Textarea_Producto = :VC_Textarea_Producto,
            VC_Textarea_Mecanismo_Verificacion = :VC_Textarea_Mecanismo_Verificacion,
            TX_Declaracion_Json = :TX_Declaracion_Json,
            VC_Disminucion_Retencion = :VC_Disminucion_Retencion,
            VC_Tomados_Retencion = :VC_Tomados_Retencion,
            VC_Mes_Planilla = :VC_Mes_Planilla,
            SM_Estado = REPLACE(REPLACE(REPLACE(REPLACE(SM_Estado, '4', ''), '5', ''), '8', ''), '0', ''),
            VC_Numero_Planilla = :VC_Numero_Planilla,
            ".$extra."
            DA_Subida = now(),
            SM_Finalizado = :SM_Finalizado,
            VC_Suspension = :VC_Suspension,
            FK_Basico = :FK_Basico
            WHERE
            PK_Id_Tabla = :PK_Id_Tabla;");

        $this->bindParams($sentencia,$objeto);
        @$sentencia->bindParam(':PK_Id_Tabla',$informeId);
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }

    public function updateInformePagoAdmin($objeto) {
        $extra = "";
        $sentencia = $this->dbPDO->prepare("UPDATE db_informe_pago.tb_informe_pago_persona SET 
            VC_Tipo_Identificacion = :VC_Tipo_Identificacion,
            VC_Identificacion = :VC_Identificacion,
            VC_Ciiu = :VC_Ciiu,
            VC_Objeto = :VC_Objeto,
            VC_Fecha_Inicio = :VC_Fecha_Inicio,
            VC_Fecha_Fin = :VC_Fecha_Fin,
            VC_Plazo_Inicial = :VC_Plazo_Inicial,
            VC_Prorrogas = :VC_Prorrogas,
            VC_Fecha_Plazo_Fin = :VC_Fecha_Plazo_Fin,
            VC_Numero_Pagos = :VC_Numero_Pagos,
            VC_Pago_De_Total = :VC_Pago_De_Total,
            TX_Rp_Json = :TX_Rp_Json,
            VC_Valor_Inicial = :VC_Valor_Inicial,
            VC_Valor_Adicion_1 = :VC_Valor_Adicion_1,
            VC_Valor_Adicion_2 = :VC_Valor_Adicion_2,
            VC_Valor_Adicion_3 = :VC_Valor_Adicion_3,
            VC_Valor_Total_Contrato = :VC_Valor_Total_Contrato,
            VC_Valor_Pago_Efectuar = :VC_Valor_Pago_Efectuar,
            VC_Valor_Letras = :VC_Valor_Letras,
            VC_Giros_Efectuados = :VC_Giros_Efectuados,
            VC_Saldo_Pediente = :VC_Saldo_Pediente,
            VC_Valor_Liberar = :VC_Valor_Liberar,
            TX_Declaracion_Json = :TX_Declaracion_Json,
            VC_Disminucion_Retencion = :VC_Disminucion_Retencion,
            VC_Tomados_Retencion = :VC_Tomados_Retencion,
            DA_Subida = now()
            WHERE
            PK_Id_Tabla = :PK_Id_Tabla;");

        @$sentencia->bindParam(':VC_Tipo_Identificacion',$objeto->getVcTipoIdentificacion());
        @$sentencia->bindParam(':VC_Identificacion',$objeto->getVcIdentificacion());
        @$sentencia->bindParam(':VC_Ciiu',$objeto->getVcCiiu());
        //@$sentencia->bindParam(':VC_Nombres_Apellidos_Cedente',$objeto->getVcNombresApellidosCedente());
        //@$sentencia->bindParam(':VC_Tipo_Identificacion_Cedente',$objeto->getVcTipoIdentificacionCedente());
        //@$sentencia->bindParam(':VC_Identificacion_Cendete',$objeto->getVcIdentificacionCendete());
        @$sentencia->bindParam(':VC_Objeto',$objeto->getVcObjeto());
        @$sentencia->bindParam(':VC_Fecha_Inicio',$objeto->getVcFechaInicio());
        @$sentencia->bindParam(':VC_Fecha_Fin',$objeto->getVcFechaFin());
        @$sentencia->bindParam(':VC_Plazo_Inicial',$objeto->getVcPlazoInicial());
        @$sentencia->bindParam(':VC_Prorrogas',$objeto->getVcProrrogas());
        @$sentencia->bindParam(':VC_Fecha_Plazo_Fin',$objeto->getVcFechaPlazoFin());
        @$sentencia->bindParam(':VC_Numero_Pagos',$objeto->getVcNumeroPagos());
        @$sentencia->bindParam(':VC_Pago_De_Total',$objeto->getVcPagoDeTotal());
        @$sentencia->bindParam(':TX_Rp_Json',$objeto->getTxRpJson());
        @$sentencia->bindParam(':VC_Valor_Inicial',$objeto->getVcValorInicial());
        @$sentencia->bindParam(':VC_Valor_Adicion_1',$objeto->getVcValorAdicion1());
        @$sentencia->bindParam(':VC_Valor_Adicion_2',$objeto->getVcValorAdicion2());
        @$sentencia->bindParam(':VC_Valor_Adicion_3',$objeto->getVcValorAdicion3());
        @$sentencia->bindParam(':VC_Valor_Total_Contrato',$objeto->getVcValorTotalContrato());
        @$sentencia->bindParam(':VC_Valor_Pago_Efectuar',$objeto->getVcValorPagoEfectuar());
        @$sentencia->bindParam(':VC_Giros_Efectuados',$objeto->getVcGirosEfectuados());
        @$sentencia->bindParam(':VC_Valor_Letras',$objeto->getVcValorLetras());
        @$sentencia->bindParam(':VC_Saldo_Pediente',$objeto->getVcSaldoPediente());
        @$sentencia->bindParam(':VC_Valor_Liberar',$objeto->getVcValorLiberar());
        @$sentencia->bindParam(':TX_Declaracion_Json',$objeto->getTxDeclaracionJson());
        @$sentencia->bindParam(':VC_Disminucion_Retencion',$objeto->getVcDisminucionRetencion());
        @$sentencia->bindParam(':VC_Tomados_Retencion',$objeto->getVcTomadosRetencion());
        @$sentencia->bindParam(':PK_Id_Tabla',$objeto->getPkIdTabla());
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }

    public function bindParams(&$sentencia,$objeto)
    {
        @$sentencia->bindParam(':FK_Persona',$objeto->getFkPersona());
        @$sentencia->bindParam(':VC_Fecha_Informe',$objeto->getVcFechaInforme());
        @$sentencia->bindParam(':VC_Periodo_Inicio',$objeto->getVcPeriodoInicio());
        @$sentencia->bindParam(':VC_Periodo_Fin',$objeto->getVcPeriodoFin());
        @$sentencia->bindParam(':VC_Numero_Contrato',$objeto->getVcNumeroContrato());
        @$sentencia->bindParam(':VC_Tipo_Identificacion',$objeto->getVcTipoIdentificacion());
        @$sentencia->bindParam(':VC_Identificacion',$objeto->getVcIdentificacion());
        @$sentencia->bindParam(':VC_Ciiu',$objeto->getVcCiiu());
        @$sentencia->bindParam(':VC_Nombres_Apellidos_Cedente',$objeto->getVcNombresApellidosCedente());
        @$sentencia->bindParam(':VC_Tipo_Identificacion_Cedente',$objeto->getVcTipoIdentificacionCedente());
        @$sentencia->bindParam(':VC_Identificacion_Cendete',$objeto->getVcIdentificacionCendete());
        @$sentencia->bindParam(':VC_Banco',$objeto->getVcBanco());
        @$sentencia->bindParam(':VC_Tipo_Cuenta',$objeto->getVcTipoCuenta());
        @$sentencia->bindParam(':VC_Numero_Cuenta',$objeto->getVcNumeroCuenta());
        @$sentencia->bindParam(':VC_Objeto',$objeto->getVcObjeto());
        @$sentencia->bindParam(':VC_Fecha_Inicio',$objeto->getVcFechaInicio());
        @$sentencia->bindParam(':VC_Plazo_Inicial',$objeto->getVcPlazoInicial());
        @$sentencia->bindParam(':VC_Prorrogas',$objeto->getVcProrrogas());
        @$sentencia->bindParam(':VC_Fecha_Plazo_Fin',$objeto->getVcFechaPlazoFin());
        @$sentencia->bindParam(':VC_Fecha_Fin',$objeto->getVcFechaFin());
        @$sentencia->bindParam(':VC_Numero_Pagos',$objeto->getVcNumeroPagos());
        @$sentencia->bindParam(':VC_Pago_Numero',$objeto->getVcPagoNumero());
        @$sentencia->bindParam(':VC_Pago_De_Total',$objeto->getVcPagoDeTotal());
        @$sentencia->bindParam(':TX_Rp_Json',$objeto->getTxRpJson());
        @$sentencia->bindParam(':VC_Valor_Inicial',$objeto->getVcValorInicial());
        @$sentencia->bindParam(':VC_Valor_Adicion_1',$objeto->getVcValorAdicion1());
        @$sentencia->bindParam(':VC_Valor_Adicion_2',$objeto->getVcValorAdicion2());
        @$sentencia->bindParam(':VC_Valor_Adicion_3',$objeto->getVcValorAdicion3());
        @$sentencia->bindParam(':VC_Valor_Total_Contrato',$objeto->getVcValorTotalContrato());
        @$sentencia->bindParam(':VC_Valor_Pago_Efectuar',$objeto->getVcValorPagoEfectuar());
        @$sentencia->bindParam(':VC_Valor_Letras',$objeto->getVcValorLetras());
        @$sentencia->bindParam(':VC_Giros_Efectuados',$objeto->getVcGirosEfectuados());
        @$sentencia->bindParam(':VC_Saldo_Pediente',$objeto->getVcSaldoPediente());
        @$sentencia->bindParam(':VC_Valor_Liberar',$objeto->getVcValorLiberar());
        @$sentencia->bindParam(':SM_Finalizado',$objeto->getSmfinalizado());
        @$sentencia->bindParam(':VC_Numero_Obligaciones',$objeto->getVcNumeroObligaciones());
        @$sentencia->bindParam(':TX_Obligaciones_Json',$objeto->getTxObligacionesJson());
        @$sentencia->bindParam(':VC_Textarea_Producto',$objeto->getVcTextareaProducto());
        @$sentencia->bindParam(':VC_Textarea_Mecanismo_Verificacion',$objeto->getVcTextareaMecanismoVerificacion());
        @$sentencia->bindParam(':TX_Declaracion_Json',$objeto->getTxDeclaracionJson());
        @$sentencia->bindParam(':VC_Disminucion_Retencion',$objeto->getVcDisminucionRetencion());
        @$sentencia->bindParam(':VC_Tomados_Retencion',$objeto->getVcTomadosRetencion());
        @$sentencia->bindParam(':VC_Mes_Planilla',$objeto->getVcMesPlanilla());
        @$sentencia->bindParam(':VC_Numero_Planilla',$objeto->getVcNumeroPlanilla());
        @$sentencia->bindParam(':VC_Suspension',$objeto->getTxSuspension());
        @$sentencia->bindParam(':FK_Basico',$objeto->getFkBasico());
        if ($objeto->getTxPlanillasExtras() != "")
            @$sentencia->bindParam(':TX_Planillas_Extras',$objeto->getTxPlanillasExtras());
    }
    public function saveObservacion($observacion,$informeId,$aprobado,$userId,$finalizado) {
        if ($aprobado == 0)
            $extraData = ", FK_Persona_Reviso = :FK_Persona, DA_Revision = now() ";
        else
            $extraData = ", FK_Persona_Aprobo = :FK_Persona, DA_Aprobo = now() ";

        $sentencia = $this->dbPDO->prepare('UPDATE db_informe_pago.tb_informe_pago_persona SET VC_Observacion = :VC_Observacion, SM_Finalizado = :SM_Finalizado, SM_Estado = :SM_Estado '.$extraData.' WHERE PK_Id_Tabla = :PK_Id_Tabla');
        @$sentencia->bindParam(':VC_Observacion',$observacion);
        @$sentencia->bindParam(':PK_Id_Tabla',$informeId);
        @$sentencia->bindParam(':SM_Finalizado',$finalizado);
        @$sentencia->bindParam(':SM_Estado',$aprobado);
        @$sentencia->bindParam(':FK_Persona',$userId);
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        $this->saveInformePagoLog($informeId);
        return $filasAfectadas;
    }
    public function saveObservacionGeneral($obsGeneral, $informeId) {
        
        $sentencia = $this->dbPDO->prepare('UPDATE db_informe_pago.tb_informe_pago_persona SET VC_Observacion_general = :VC_Observacion_general WHERE PK_Id_Tabla = :PK_Id_Tabla');
        @$sentencia->bindParam(':VC_Observacion_general',$obsGeneral);
        @$sentencia->bindParam(':PK_Id_Tabla',$informeId);
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        $this->saveInformePagoLog($informeId);
        return $filasAfectadas;
    }
    
    public function saveEstadoInformePago($informeId,$aprobado,$userId) {
        if ($aprobado != "-1")
            $extraData = ", SM_Estado = :SM_Estado";
        $rechazado = 0;
        $sentencia = $this->dbPDO->prepare('UPDATE db_informe_pago.tb_informe_pago_persona SET SM_Finalizado = :SM_Finalizado, FK_Persona_Aprobo = :FK_Persona, DA_Aprobo = now() '.$extraData.' WHERE PK_Id_Tabla = :PK_Id_Tabla');
        @$sentencia->bindParam(':PK_Id_Tabla',$informeId);
        
        if ($aprobado != "-1")
            @$sentencia->bindParam(':SM_Estado',$aprobado);

        @$sentencia->bindParam(':FK_Persona',$userId);
        @$sentencia->bindParam(':SM_Finalizado',$rechazado);
        $sentencia->execute();
        $filasAfectadas = $sentencia->rowCount();
        $this->saveInformePagoLog($informeId);
        return $filasAfectadas;
    }
    public function updateRevisionSupervisor($informeId,$estado) {
        $sentencia = $this->dbPDO->prepare('UPDATE db_informe_pago.tb_informe_pago_persona SET 
            IN_estado_supervisor = :estado, DT_estado_supervisor = now()
            WHERE PK_Id_Tabla = :PK_Id_Tabla');
        @$sentencia->bindParam(':estado',$estado);
        @$sentencia->bindParam(':PK_Id_Tabla',$informeId);
        $sentencia->execute();
        $filasAfectadas = $sentencia->rowCount();
        $this->saveInformePagoLog($informeId);
        return $filasAfectadas;
    }
    public function getInformePago($informeId) {            
       // var_dump($objeto);
      /*  $sentencia = $this->dbPDO->prepare("SELECT tipp.PK_Id_Tabla, tipp.FK_Persona, tipp.VC_Fecha_Informe, tipp.VC_Periodo_Inicio, tipp.VC_Periodo_Fin, tipp.VC_Numero_Contrato, tipp.VC_Tipo_Identificacion, tipp.VC_Identificacion, tipp.VC_Ciiu, tipp.VC_Nombres_Apellidos_Cedente, tipp.VC_Tipo_Identificacion_Cedente, tipp.VC_Identificacion_Cendete, tipp.VC_Banco, tipp.VC_Tipo_Cuenta, tipp.VC_Numero_Cuenta, tipp.VC_Objeto, tipp.VC_Fecha_Inicio, tipp.VC_Plazo_Inicial, tipp.VC_Prorrogas, tipp.VC_Fecha_Plazo_Fin, tipp.VC_Fecha_Fin, tipp.VC_Numero_Pagos, tipp.VC_Pago_Numero, tipp.VC_Pago_De_Total, tipp.TX_Rp_Json, tipp.VC_Valor_Inicial, tipp.VC_Valor_Adicion_1, tipp.VC_Valor_Adicion_2, tipp.VC_Valor_Adicion_3, tipp.VC_Valor_Total_Contrato, tipp.VC_Valor_Pago_Efectuar, tipp.VC_Valor_Letras, tipp.VC_Giros_Efectuados, tipp.VC_Saldo_Pediente, tipp.VC_Valor_Liberar, tipp.VC_Numero_Obligaciones, tipp.TX_Obligaciones_Json, tipp.VC_Textarea_Producto, tipp.VC_Textarea_Mecanismo_Verificacion, tipp.TX_Declaracion_Json, tipp.VC_Disminucion_Retencion, tipp.VC_Tomados_Retencion, tipp.VC_Mes_Planilla, tipp.VC_Numero_Planilla, tipp.TX_Planillas_Extras, tippb.FK_Persona_Supervisor, tippb.FK_Persona_Apoyo_Supervisor,tippb.FK_Aprobacion,tippb.FK_Aprobacion_Administrativo, tipp.DA_Subida, tipp.SM_Estado, tipp.VC_Observacion, tipp.DA_Revision, tipp.FK_Persona_Reviso, tipp.DA_Aprobo, tipp.FK_Persona_Aprobo,CONCAT(tp2.VC_Primer_Nombre,' ',tp2.VC_Segundo_Nombre,' ',tp2.VC_Primer_Apellido,' ',tp2.VC_Segundo_Apellido) AS 'nombre_contratista',tipp.SM_Finalizado,'' as usuarios_observaciones_json FROM db_informe_pago.tb_informe_pago_persona tipp JOIN  db_sif_dev.tb_persona_2017 tp2 ON tp2.PK_Id_Persona = tipp.FK_Persona JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tippb.SM_Activo = 1 WHERE tipp.PK_Id_Tabla = :PK_Id_Tabla ");*/
      //$sentencia = $this->dbPDO->prepare("SELECT tipp.VC_Observacion_general, tipp.PK_Id_Tabla, tipp.FK_Persona, tipp.VC_Fecha_Informe, tipp.VC_Periodo_Inicio, tipp.VC_Periodo_Fin, tipp.VC_Numero_Contrato, tipp.VC_Tipo_Identificacion, tipp.VC_Identificacion, tipp.VC_Ciiu, tipp.VC_Nombres_Apellidos_Cedente, tipp.VC_Tipo_Identificacion_Cedente, tipp.VC_Identificacion_Cendete, tipp.VC_Banco, tipp.VC_Tipo_Cuenta, tipp.VC_Numero_Cuenta, tipp.VC_Objeto, tipp.VC_Fecha_Inicio, tipp.VC_Plazo_Inicial, tipp.VC_Prorrogas, tipp.VC_Fecha_Plazo_Fin, tipp.VC_Fecha_Fin, tipp.VC_Numero_Pagos, tipp.VC_Pago_Numero, tipp.VC_Pago_De_Total, tipp.TX_Rp_Json, tipp.VC_Valor_Inicial, tipp.VC_Valor_Adicion_1, tipp.VC_Valor_Adicion_2, tipp.VC_Valor_Adicion_3, tipp.VC_Valor_Total_Contrato, tipp.VC_Valor_Pago_Efectuar, tipp.VC_Valor_Letras, tipp.VC_Giros_Efectuados, tipp.VC_Saldo_Pediente, tipp.VC_Valor_Liberar, tipp.VC_Numero_Obligaciones, tipp.TX_Obligaciones_Json, tipp.VC_Textarea_Producto, tipp.VC_Textarea_Mecanismo_Verificacion, tipp.TX_Declaracion_Json, tipp.VC_Disminucion_Retencion, tipp.VC_Tomados_Retencion, tipp.VC_Mes_Planilla, tipp.VC_Numero_Planilla, tipp.TX_Planillas_Extras, tippb.FK_Persona_Supervisor, tippb.FK_Persona_Apoyo_Supervisor, tippb.FK_Persona_Apoyo_Supervisor_Dos, tippb.FK_Aprobacion,tippb.FK_Aprobacion_Administrativo, tipp.DA_Subida, tipp.SM_Estado, tipp.VC_Observacion, tipp.DA_Revision, tipp.FK_Persona_Reviso, tipp.DA_Aprobo, tipp.VC_Suspension, tipp.FK_Persona_Aprobo,CONCAT(tp2.VC_Primer_Nombre,' ',tp2.VC_Segundo_Nombre,' ',tp2.VC_Primer_Apellido,' ',tp2.VC_Segundo_Apellido) AS 'nombre_contratista',tipp.SM_Finalizado,tipp.FK_Basico, tippb.IN_Firma_Administrativo, (select CONCAT('[',GROUP_CONCAT(JSON_OBJECT('PK_Id_Persona',tp2.PK_Id_Persona,'nombre',CONCAT(tp2.VC_Primer_Nombre,' ',tp2.VC_Primer_Apellido) )),']') from db_sif_dev.tb_persona_2017 tp2 WHERE FIND_IN_SET( tp2.PK_Id_Persona, (SELECT replace(replace(replace(replace(JSON_EXTRACT(tpp.VC_Observacion, '$.*[*].usuario'),'\"',''),'[',''),']',''),' ','') AS usuarios FROM db_informe_pago.tb_informe_pago_persona tpp where tpp.PK_Id_Tabla = tipp.PK_Id_Tabla)) > 0) as usuarios_observaciones_json FROM db_informe_pago.tb_informe_pago_persona tipp JOIN  db_sif_dev.tb_persona_2017 tp2 ON tp2.PK_Id_Persona = tipp.FK_Persona JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tippb.SM_Activo = 1 WHERE tipp.PK_Id_Tabla = :PK_Id_Tabla ");
        $sentencia = $this->dbPDO->prepare("SELECT tipp.VC_orfeo_radicado, tipp.VC_orfeo_codigo_verificacion, tipp.VC_orfeo_radicado_anexo, tippb.VC_Expediente,tipp.VC_Observacion_general, tipp.PK_Id_Tabla, tipp.FK_Persona, tipp.VC_Fecha_Informe, tipp.VC_Periodo_Inicio, tipp.VC_Periodo_Fin, tipp.VC_Numero_Contrato, tipp.VC_Tipo_Identificacion, tipp.VC_Identificacion, tipp.VC_Ciiu, tipp.VC_Nombres_Apellidos_Cedente, tipp.VC_Tipo_Identificacion_Cedente, tipp.VC_Identificacion_Cendete, tipp.VC_Banco, tipp.VC_Tipo_Cuenta, tipp.VC_Numero_Cuenta, tipp.VC_Objeto, tipp.VC_Fecha_Inicio, tipp.VC_Plazo_Inicial, tipp.VC_Prorrogas, tipp.VC_Fecha_Plazo_Fin, tipp.VC_Fecha_Fin, tipp.VC_Numero_Pagos, tipp.VC_Pago_Numero, tipp.VC_Pago_De_Total, tipp.TX_Rp_Json, tipp.VC_Valor_Inicial, tipp.VC_Valor_Adicion_1, tipp.VC_Valor_Adicion_2, tipp.VC_Valor_Adicion_3, tipp.VC_Valor_Total_Contrato, tipp.VC_Valor_Pago_Efectuar, tipp.VC_Valor_Letras, tipp.VC_Giros_Efectuados, tipp.VC_Saldo_Pediente, tipp.VC_Valor_Liberar, tipp.VC_Numero_Obligaciones, tipp.TX_Obligaciones_Json, tipp.VC_Textarea_Producto, tipp.VC_Textarea_Mecanismo_Verificacion, tipp.TX_Declaracion_Json, tipp.VC_Disminucion_Retencion, tipp.VC_Tomados_Retencion, tipp.VC_Mes_Planilla, tipp.VC_Numero_Planilla, tipp.TX_Planillas_Extras, tippb.FK_Persona_Supervisor, tippb.FK_Persona_Apoyo_Supervisor, tippb.FK_Persona_Apoyo_Supervisor_Dos, tippb.FK_Aprobacion, tippb.FK_Aprobacion_Administrativo, tipp.DA_Subida, tipp.SM_Estado, tipp.VC_Observacion, tipp.DA_Revision, tipp.FK_Persona_Reviso, tipp.DA_Aprobo, tipp.VC_Suspension, tipp.FK_Persona_Aprobo, CONCAT( tp2.VC_Primer_Nombre, ' ', tp2.VC_Segundo_Nombre, ' ', tp2.VC_Primer_Apellido, ' ', tp2.VC_Segundo_Apellido ) AS 'nombre_contratista', tipp.SM_Finalizado, tipp.FK_Basico, tippb.IN_Firma_Administrativo, GROUP_CONCAT( tipo_anexo.VC_Descripcion,':',tipao.TX_Anexo ) AS anexosOrfeo, (SELECT CONCAT( '[', GROUP_CONCAT( JSON_OBJECT( 'PK_Id_Persona', tp2.PK_Id_Persona, 'nombre', CONCAT( tp2.VC_Primer_Nombre, ' ', tp2.VC_Primer_Apellido ) )), ']' ) FROM db_sif_dev.tb_persona_2017 tp2 WHERE FIND_IN_SET(tp2.PK_Id_Persona,(SELECT REPLACE( REPLACE ( REPLACE ( REPLACE ( JSON_EXTRACT( tpp.VC_Observacion, '$.*[*].usuario' ), '\"', '' ), '[', '' ), ']', '' ), ' ', '' ) AS usuarios FROM db_informe_pago.tb_informe_pago_persona tpp WHERE tpp.PK_Id_Tabla = tipp.PK_Id_Tabla)) > 0) AS usuarios_observaciones_json 
                                            FROM db_informe_pago.tb_informe_pago_persona tipp JOIN db_sif_dev.tb_persona_2017 tp2 ON tp2.PK_Id_Persona = tipp.FK_Persona JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tippb.SM_Activo = 1 LEFT JOIN db_informe_pago.tb_informe_pago_anexos_orfeo tipao ON tipao.FK_Informe_pago_persona = tipp.PK_Id_Tabla AND tipao.TX_Anexo <> '' LEFT JOIN db_sif_dev.tb_parametro_detalle tipo_anexo ON tipo_anexo.FK_Value = tipao.FK_Parametro_Detalle AND tipo_anexo.FK_Id_Parametro = 65 WHERE tipp.PK_Id_Tabla = :PK_Id_Tabla");

      @$sentencia->bindParam(':PK_Id_Tabla',$informeId);
      $sentencia->execute();

      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }
  public function validarPeriodo($idPersona,$fechaFin,$informeId = null) {            

    $extra = "";
    if ($informeId != null)
        $extra = "AND PK_Id_Tabla != :PK_Id_Tabla;";
    $sentencia = $this->dbPDO->prepare('SELECT COUNT(t.PK_Id_Tabla) AS "cantidad" FROM db_informe_pago.tb_informe_pago_persona  t WHERE t.FK_Persona = :FK_Persona 
        AND DATE_FORMAT(STR_TO_DATE(t.VC_Periodo_Fin, "%d/%m/%Y"),"%Y-%m-%d") = DATE_FORMAT(STR_TO_DATE(:Fecha_Fin, "%d/%m/%Y"),"%Y-%m-%d")'.$extra);

    @$sentencia->bindParam(':FK_Persona',$idPersona);
    @$sentencia->bindParam(':Fecha_Fin',$fechaFin);
    if ($informeId != null)
        @$sentencia->bindParam(':PK_Id_Tabla',$informeId);

    $sentencia->execute();
    //print_r($sentencia->fetchAll(\PDO::FETCH_ASSOC));
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function validarExistenciaContrato($codigo_contrato) {            
    $sentencia = $this->dbPDO->prepare('SELECT COUNT(t.PK_Id_Tabla) AS "cantidad" FROM db_informe_pago.tb_informe_pago_persona_basico t WHERE REPLACE(t.VC_Numero_Contrato," ", "") = :codigo_contrato');

    @$sentencia->bindParam(':codigo_contrato',$codigo_contrato);
    $sentencia->execute(); 
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getListadoInformes($filtro, $origen)
{
    ini_set('memory_limit', '2G'); 
    $sql = "SELECT 
   
    tipp.I_radicado_orfeo, tipp.DT_firma_orfeo, tipp.PK_Id_Tabla, tipp.FK_Persona, tipp.VC_Periodo_Inicio, tipp.VC_Periodo_Fin, tipp.VC_Numero_Contrato, tipp.VC_Tipo_Identificacion, tipp.VC_Identificacion, tipp.VC_Ciiu, tipp.VC_Nombres_Apellidos_Cedente, tipp.VC_Tipo_Identificacion_Cedente, tipp.VC_Identificacion_Cendete, tipp.VC_Banco, tipp.VC_Tipo_Cuenta, tipp.VC_Numero_Cuenta, tipp.VC_Objeto, tipp.VC_Fecha_Inicio, tipp.VC_Plazo_Inicial, tipp.VC_Prorrogas, tipp.VC_Fecha_Plazo_Fin, tipp.VC_Fecha_Fin, tipp.VC_Numero_Pagos, tipp.VC_Pago_Numero, tipp.VC_Pago_De_Total, tipp.TX_Rp_Json, tipp.VC_Valor_Inicial, tipp.VC_Valor_Adicion_1, tipp.VC_Valor_Adicion_2, tipp.VC_Valor_Adicion_3, tipp.VC_Valor_Total_Contrato, tipp.VC_Valor_Pago_Efectuar, tipp.VC_Valor_Letras, tipp.VC_Giros_Efectuados, tipp.VC_Saldo_Pediente, tipp.VC_Valor_Liberar, tipp.VC_Numero_Obligaciones, tipp.TX_Obligaciones_Json, tipp.VC_Textarea_Producto, tipp.VC_Textarea_Mecanismo_Verificacion, tipp.TX_Declaracion_Json, tipp.VC_Disminucion_Retencion, tipp.VC_Tomados_Retencion, tipp.VC_Mes_Planilla, tipp.VC_Numero_Planilla, tipp.TX_Planillas_Extras, tippb.FK_Persona_Supervisor, tippb.FK_Persona_Apoyo_Supervisor, tippb.FK_Persona_Apoyo_Supervisor_Dos,tippb.FK_Aprobacion,tippb.FK_Aprobacion_Administrativo, tipp.DA_Subida, tipp.SM_Estado, tipp.VC_Observacion, tipp.DA_Revision, tipp.FK_Persona_Reviso,tipp.VC_orfeo_codigo_verificacion,tipp.VC_orfeo_radicado , tipp.DA_Aprobo, tipp.FK_Persona_Aprobo,CONCAT(tp2.VC_Primer_Nombre,' ',tp2.VC_Segundo_Nombre,' ',tp2.VC_Primer_Apellido,' ',tp2.VC_Segundo_Apellido) AS 'nombre_contratista',tipp.SM_Finalizado, COUNT(tidp.FK_Id_Informe_Pago) AS FK_Informe_Detallado,tidp.VC_Url_Anexo,tidp.SM_Estado as SM_Estado_Detallado,tidp.SM_Finalizado as SM_Finalizado_Detallado, CASE WHEN dt.DA_Subida IS NULL THEN 0 ELSE 1 END AS 'ultimodescarga' , CASE WHEN dt2.DA_Subida IS NULL THEN 0 ELSE 1 END AS 'ultimo', CASE WHEN dt3.DA_Subida IS NULL THEN 0 ELSE 1 END AS 'ultimo_revision', tippb.IN_Certificado_Final FROM db_informe_pago.tb_informe_pago_persona tipp JOIN  db_sif_dev.tb_persona_2017 tp2 ON tp2.PK_Id_Persona = tipp.FK_Persona JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tipp.FK_Basico = tippb.PK_Id_Tabla
    LEFT JOIN (select tp.FK_Persona,max(tp.DA_Subida) AS DA_Subida from db_informe_pago.tb_informe_pago_persona tp WHERE tp.SM_Finalizado=1 group by tp.FK_Persona) dt ON dt.FK_Persona = tipp.FK_Persona AND tipp.DA_Subida = dt.DA_Subida AND ((tippb.FK_Persona_Apoyo_Supervisor IS NOT NULL AND tipp.SM_Estado LIKE '%1%') OR tippb.FK_Persona_Apoyo_Supervisor IS NULL) AND ((tippb.FK_Persona_Apoyo_Supervisor_Dos IS NOT NULL AND tipp.SM_Estado LIKE '%9%') OR tippb.FK_Persona_Apoyo_Supervisor_Dos IS NULL) AND ((tippb.FK_Aprobacion_Administrativo IS NOT NULL AND tipp.SM_Estado LIKE '%2%') OR tippb.FK_Aprobacion_Administrativo IS NULL) AND ((tippb.FK_Persona_Supervisor IS NOT NULL AND tipp.SM_Estado LIKE '%7%') OR tippb.FK_Persona_Supervisor IS NULL)
    LEFT JOIN (select tp2.FK_Persona,max(tp2.DA_Subida) AS DA_Subida from db_informe_pago.tb_informe_pago_persona tp2 group by tp2.FK_Persona) dt2 ON dt2.FK_Persona = tipp.FK_Persona AND tipp.DA_Subida = dt2.DA_Subida 
    LEFT JOIN (select tp2.FK_Persona,max(tp2.DA_Subida) AS DA_Subida from db_informe_pago.tb_informe_pago_persona tp2 WHERE tp2.SM_Finalizado = 1 group by tp2.FK_Persona) dt3 ON dt3.FK_Persona = tipp.FK_Persona AND tipp.DA_Subida = dt3.DA_Subida 

    LEFT JOIN db_informe_pago.tb_informe_detallado_persona tidp ON  tidp.FK_Id_Informe_Pago = tipp.PK_Id_Tabla";
    //$array_estado = explode(',', tipp.SM_Estado);
    $filtroSql = "";
    $filtroUsuario = "";
    $filtroEstado = " AND (";
    $filtroEstadoDoc = " AND (";
    if (array_key_exists('estadoLista', $filtro)) {
        if (array_key_exists('estadoListaDoc', $filtro))
            $filtroEstado = " AND ((";
            if (in_array(1, $filtro["estadoLista"],false)){//Ver
                if($origen != null){
                    $filtroEstado .= "
                        (tipp.SM_Finalizado = 1 AND
                        (
                            (tippb.FK_Persona_Apoyo_Supervisor IS NOT NULL AND tipp.SM_Estado NOT LIKE '%1%')
                            OR
                            (tippb.FK_Aprobacion_Administrativo IS NOT NULL AND tipp.SM_Estado NOT LIKE '%2%')
                            OR
                            (tippb.FK_Persona_Supervisor IS NOT NULL AND tipp.SM_Estado NOT LIKE '%7%')
                            OR
                            (tippb.FK_Persona_Apoyo_Supervisor_Dos IS NOT NULL AND tipp.SM_Estado NOT LIKE '%9%')
                            OR
                            tipp.SM_Estado IS NULL
                        )
                        ) OR";
                }
                else{
                    $filtroEstado .= "
                        (tipp.SM_Finalizado = 1 AND
                        (
                            (tippb.FK_Persona_Apoyo_Supervisor IS NOT NULL AND tipp.SM_Estado NOT LIKE '%1%')
                            OR
                            (tippb.FK_Aprobacion_Administrativo IS NOT NULL AND tipp.SM_Estado NOT LIKE '%2%')
                            OR
                            (tippb.FK_Persona_Supervisor IS NOT NULL AND tipp.SM_Estado NOT LIKE '%7%')
                            OR
                            (tippb.FK_Persona_Apoyo_Supervisor_Dos IS NOT NULL AND tipp.SM_Estado NOT LIKE '%9%')
                            OR
                            tipp.SM_Estado IS NULL
                        )
                        AND 
                        (
                            (tippb.FK_Persona_Apoyo_Supervisor = :userId AND tipp.SM_Estado LIKE '%1%')
                            OR
                            (tippb.FK_Aprobacion_Administrativo = :userId AND tipp.SM_Estado LIKE '%2%')
                            OR
                            (tippb.FK_Persona_Supervisor = :userId AND tipp.SM_Estado LIKE '%7%')
                            OR
                            (tippb.FK_Persona_Apoyo_Supervisor_Dos = :userId AND tipp.SM_Estado LIKE '%9%')
                            OR
                            (tippb.FK_Aprobacion = :userId)
                            OR
                            (tipp.FK_Persona = :userId)
                        )
                        ) OR";
                }
            }
            if (in_array(2, $filtro["estadoLista"],false)){//Editar
                $filtroEstado .= " (tipp.SM_Finalizado = 0) OR";
            }
            if (in_array(3, $filtro["estadoLista"],false)){//Descargar
            $filtroEstado .= " 
                    (tipp.SM_Finalizado = 1 AND
                        (
                            ((tippb.FK_Persona_Apoyo_Supervisor IS NOT NULL AND tipp.SM_Estado LIKE '%1%') OR tippb.FK_Persona_Apoyo_Supervisor IS NULL)
                            AND
                            ((tippb.FK_Aprobacion_Administrativo IS NOT NULL AND tipp.SM_Estado LIKE '%2%') OR tippb.FK_Aprobacion_Administrativo IS NULL)
                            AND
                            ((tippb.FK_Persona_Supervisor IS NOT NULL AND tipp.SM_Estado LIKE '%7%') OR tippb.FK_Persona_Supervisor IS NULL)
                            AND
                            ((tippb.FK_Persona_Apoyo_Supervisor_Dos IS NOT NULL AND tipp.SM_Estado LIKE '%9%') OR tippb.FK_Persona_Apoyo_Supervisor_Dos IS NULL)
                        )
                    ) OR";
            }
            if (in_array(4, $filtro["estadoLista"],false)){//Revisar
                if($origen != null){
                    $filtroEstado .= " 
                    (tipp.SM_Finalizado = 1 AND
                        (
                            (tippb.FK_Persona_Apoyo_Supervisor IS NOT NULL AND tipp.SM_Estado NOT LIKE '%1%')
                            OR
                            (tippb.FK_Aprobacion_Administrativo IS NOT NULL AND tipp.SM_Estado NOT LIKE '%2%')
                            OR
                            (tippb.FK_Persona_Supervisor IS NOT NULL AND tipp.SM_Estado NOT LIKE '%7%')
                            OR
                            (tippb.FK_Persona_Apoyo_Supervisor_Dos IS NOT NULL AND tipp.SM_Estado NOT LIKE '%9%')
                            OR
                            tipp.SM_Estado IS NULL
                        )
                    ) OR";
                }
                else{
                    $filtroEstado .= " 
                    (tipp.SM_Finalizado = 1 AND
                        (
                            (tippb.FK_Persona_Apoyo_Supervisor IS NOT NULL AND tipp.SM_Estado NOT LIKE '%1%')
                            OR
                            (tippb.FK_Aprobacion_Administrativo IS NOT NULL AND tipp.SM_Estado NOT LIKE '%2%')
                            OR
                            (tippb.FK_Persona_Supervisor IS NOT NULL AND tipp.SM_Estado NOT LIKE '%7%')
                            OR
                            (tippb.FK_Persona_Apoyo_Supervisor_Dos IS NOT NULL AND tipp.SM_Estado NOT LIKE '%9%')
                            OR
                            tipp.SM_Estado IS NULL
                        )
                        AND 
                        (
                            (tippb.FK_Persona_Apoyo_Supervisor = :userId AND tipp.SM_Estado NOT LIKE '%1%')
                            OR
                            (tippb.FK_Aprobacion_Administrativo = :userId AND tipp.SM_Estado NOT LIKE '%2%')
                            OR
                            (tippb.FK_Persona_Supervisor = :userId AND tipp.SM_Estado NOT LIKE '%7%')
                            OR
                            (tippb.FK_Persona_Apoyo_Supervisor_Dos = :userId AND tipp.SM_Estado NOT LIKE '%9%')
                            OR
                            (tippb.FK_Aprobacion = :userId)
                            OR
                            (tipp.FK_Persona = :userId)
                            OR
                            (tipp.SM_Estado IS NULL)
                        )
                    ) OR";
                }
            }                
            $filtroEstado = substr($filtroEstado, 0,-2);
            $filtroEstado .= ')';
            $filtroEstadoDoc = " AND (";
            /*print_r($filtroEstado);*/
        }
        else
            $filtroEstado = "";
        
        if (array_key_exists('estadoListaDoc', $filtro)) {
            if (in_array(1, $filtro["estadoListaDoc"],false))//Digilenciar
            $filtroEstadoDoc .= " tidp.FK_Id_Informe_Pago IS NULL OR";
            if (in_array(2, $filtro["estadoListaDoc"],false))//Editar
            $filtroEstadoDoc .= " (tidp.SM_Finalizado = 0) OR";
            if (in_array(3, $filtro["estadoListaDoc"],false))//Descargar
            $filtroEstadoDoc .= " (tidp.SM_Finalizado = 1 AND tidp.SM_Estado = '1') OR";
            if (in_array(4, $filtro["estadoListaDoc"],false))//Revisar
            $filtroEstadoDoc .= " (tidp.SM_Finalizado = 1 AND (tidp.SM_Estado != '1' OR tidp.SM_Estado IS NULL)) OR";
            $filtroEstadoDoc = substr($filtroEstadoDoc, 0,-2);
            $filtroEstadoDoc .= ')';
            if (array_key_exists('estadoLista', $filtro))
                $filtroEstadoDoc .= ')';
        }
        else
            $filtroEstadoDoc = "";

        
        if (array_key_exists('tipo', $filtro)) {
            if ($filtro["tipo"] == 1)
                $filtroUsuario .= " tipp.FK_Persona = :userId OR";
            if ($filtro["tipo"] == 2)
                $filtroUsuario .= " tippb.FK_Persona_Apoyo_Supervisor = :userId OR tippb.FK_Persona_Apoyo_Supervisor_Dos = :userId OR tippb.FK_Aprobacion = :userId OR tippb.FK_Persona_Supervisor = :userId OR tippb.FK_Aprobacion_Administrativo = :userId OR";
            $filtroUsuario = substr($filtroUsuario, 0,-2);
        }
        else
            $filtroUsuario = "tipp.FK_Persona = :userId OR tippb.FK_Persona_Apoyo_Supervisor = :userId OR tippb.FK_Persona_Apoyo_Supervisor_Dos = :userId OR tippb.FK_Aprobacion = :userId OR tippb.FK_Persona_Supervisor = :userId OR tippb.FK_Aprobacion_Administrativo = :userId";

        foreach ($filtro as $key => $value) {
            if ($value != "" && $value != null && $key != 'historico') {
                if (!(strpos($filtroSql, 'WHERE') !== false)) {
                    $filtroSql = $filtroSql." WHERE (";
                }
                if ($key == "userId")
                    $filtroSql = $filtroSql.$filtroUsuario;
                if ($key == "fechaFin")
                    $filtroSql = $filtroSql." STR_TO_DATE(tipp.VC_Periodo_Fin,'%d/%m/%Y') = date(:fechaFin) ";
                if ($key == "nIdentificacion")
                    $filtroSql = $filtroSql." tipp.VC_Identificacion = :nIdentificacion ";
                if ($key == "estado")
                    $filtroSql = $filtroSql." tipp.SM_Estado = :estado ";
                if ($key != "tipo" && $key != "estadoLista" && $key != "estadoListaDoc")
                    $filtroSql = $filtroSql."AND";
            }
        }
        // echo substr($filtroSql, 0,-4);
        if ($filtroSql === ' WHERE (AND') {
            $filtroSql = substr($filtroSql, 0,-4)."".substr($filtroEstado, 4).$filtroEstadoDoc." GROUP BY tipp.PK_Id_Tabla;";
        }
        else
            $filtroSql = substr($filtroSql, 0,-3).")".$filtroEstado.$filtroEstadoDoc." GROUP BY tipp.PK_Id_Tabla;";

        #var_dump($sql.$filtroSql);
        #die();
        $sentencia = $this->dbPDO->prepare($sql.$filtroSql);
        

        if( array_key_exists('userId', $filtro) && $filtro["userId"] != "" && $filtro["userId"] != null )
            @$sentencia->bindParam(':userId',$filtro["userId"]);
        if($filtro["fechaFin"] != "" && $filtro["fechaFin"] != null )
            @$sentencia->bindParam(':fechaFin',$filtro["fechaFin"]);
        if($filtro["nIdentificacion"] != "" && $filtro["nIdentificacion"] != null )
            @$sentencia->bindParam(':nIdentificacion',$filtro["nIdentificacion"]);
        if($filtro["estado"] != "" && $filtro["estado"] != null )
            @$sentencia->bindParam(':estado',$filtro["estado"]);
        /*print_r($sentencia);*/
        $sentencia->execute();

        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getListadoInformesMejorado($filtros)
    {
        #echo '<pre>'.print_r($filtros).'</pre>';
        #die();
        #3 ES POR REVISAR, 2 HISTORICO
        $whereNot = ($filtros["estado"] == 3 ) ? "NOT" : "";
        $whereNotNull = ($filtros["estado"] == 3 ) ? "" : "NOT";
        # 1 INFORMES PROPIOS, 2 SUPERVISOR O APOYO
        $finalizadoUsuario = "";
        if($filtros['tipo'] == 1){
            $whereRol = "tippb.FK_Persona = :userId";
        }else if($filtros['tipo'] == 2){
            $finalizadoUsuario = "tipp.SM_Finalizado=1 AND";
            $whereRol = "
            (
                (tippb.FK_Persona_Apoyo_Supervisor = :userId AND (tipp.SM_Estado ".$whereNot." LIKE '%1%' OR tipp.SM_Estado IS ".$whereNotNull." NULL)) OR  
                (tippb.FK_Persona_Apoyo_Supervisor_Dos = :userId AND (tipp.SM_Estado ".$whereNot." LIKE '%9%' OR tipp.SM_Estado IS ".$whereNotNull." NULL)) OR 
                (tippb.FK_Aprobacion_Administrativo = :userId AND (tipp.SM_Estado ".$whereNot." LIKE '%2%' OR tipp.SM_Estado IS ".$whereNotNull." NULL)) OR 
                (tippb.FK_Persona_Supervisor = :userId AND (tipp.SM_Estado ".$whereNot." LIKE '%7%' OR tipp.SM_Estado IS ".$whereNotNull." NULL)) OR
                (tippb.FK_Aprobacion = :userId AND (tipp.SM_Estado ".$whereNot." LIKE '%3%' OR tipp.SM_Estado IS ".$whereNotNull." NULL))                
            )              
            ";          
        }
        $sql = "

            SELECT

            tf.firmas, 
            tf.firmantes,
            tipp.PK_Id_Tabla,
            tp2.VC_identificacion,
            CONCAT(tp2.VC_Primer_Nombre,' ',tp2.VC_Segundo_Nombre,' ',tp2.VC_Primer_Apellido,' ',tp2.VC_Segundo_Apellido) AS 'nombre_contratista',
            tipp.VC_Numero_Contrato,
            tipp.VC_Periodo_Inicio,
            tipp.VC_Periodo_Fin,
            tipp.DA_Subida,
            tipp.VC_orfeo_radicado,
            tipp.VC_orfeo_codigo_verificacion,
            tipp.VC_orfeo_radicado_anexo,
            tipp.SM_Finalizado,
            tipp.SM_Estado,
            tipp.FK_Persona,            
            tippb.FK_Persona_Supervisor,
            tippb.FK_Aprobacion_Administrativo,
            tippb.FK_Persona_Apoyo_Supervisor_Dos,
            tippb.FK_Aprobacion_Administrativo,
            tippb.FK_Persona_Apoyo_Supervisor,
            tippb.FK_Aprobacion,
            tipp.VC_Numero_Pagos,
            tipp.VC_Pago_Numero,
            tipp.VC_Pago_De_Total,
            tippb.IN_Firma_Administrativo,
            tippb.IN_Certificado_Final
            FROM db_informe_pago.tb_informe_pago_persona AS tipp 
            JOIN db_sif_dev.tb_persona_2017 tp2 ON tp2.PK_Id_Persona = tipp.FK_Persona 
            JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tipp.FK_Basico = tippb.PK_Id_Tabla 
            LEFT JOIN (
                    SELECT ff.FK_Informe_pago_persona, group_concat(ff.DT_Date) AS firmas, group_concat(ff.FK_Persona) AS firmantes
                    FROM db_informe_pago.tb_informe_pago_firmas AS ff 
                    WHERE ff.PK_Id_Tabla IN ( 
                        SELECT MAX(f.PK_Id_Tabla) 
                        FROM db_informe_pago.tb_informe_pago_firmas AS f 
                        JOIN db_informe_pago.tb_informe_pago_persona AS tp ON tp.PK_Id_Tabla = f.FK_Informe_pago_persona
                        WHERE f.I_Aprobado = 1 AND f.VC_Token IS NOT NULL 
                        AND tp.DA_Subida BETWEEN :fecha_inicio AND :fecha_fin
                        GROUP BY  f.FK_Informe_pago_persona ,  f.FK_Persona 
                    ) GROUP BY ff.FK_Informe_pago_persona 
            ) AS tf ON tf.FK_Informe_pago_persona = tipp.PK_Id_Tabla
            
            WHERE 
            ".$finalizadoUsuario." tipp.DA_Subida BETWEEN :fecha_inicio AND :fecha_fin
            AND ".
            $whereRol;

        #echo $sql;
        #die();
        $sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':userId',$filtros["userId"]);
        @$sentencia->bindParam(':fecha_inicio',$filtros["fecha_inicio"]);
        @$sentencia->bindParam(':fecha_fin',$filtros["fecha_fin"]);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }


    #Se busca por ID
    public function getInformePagoFirmas($informeId)
    {
        $sql = "

            SELECT

            tf.firmas, 
            tf.firmantes,
            tipp.PK_Id_Tabla,
            tp2.VC_identificacion,
            CONCAT(tp2.VC_Primer_Nombre,' ',tp2.VC_Segundo_Nombre,' ',tp2.VC_Primer_Apellido,' ',tp2.VC_Segundo_Apellido) AS 'nombre_contratista',
            tipp.VC_Numero_Contrato,
            tipp.VC_Periodo_Inicio,
            tipp.VC_Periodo_Fin,
            tipp.DA_Subida,
            tipp.VC_orfeo_radicado,
            tipp.VC_orfeo_codigo_verificacion,
            tipp.VC_orfeo_radicado_anexo,
            tipp.SM_Finalizado,
            tipp.SM_Estado,
            tipp.FK_Persona,
            tippb.FK_Persona_Supervisor,
            tippb.FK_Aprobacion_Administrativo,
            tippb.FK_Persona_Apoyo_Supervisor_Dos,
            tippb.FK_Aprobacion_Administrativo,
            tippb.FK_Persona_Apoyo_Supervisor,
            tippb.FK_Aprobacion,
            tipp.VC_Numero_Pagos,
            tipp.VC_Pago_Numero,
            tipp.VC_Pago_De_Total,
            tippb.IN_Firma_Administrativo,
            tippb.IN_Certificado_Final            
            FROM db_informe_pago.tb_informe_pago_persona AS tipp 
            JOIN db_sif_dev.tb_persona_2017 tp2 ON tp2.PK_Id_Persona = tipp.FK_Persona 
            JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tipp.FK_Basico = tippb.PK_Id_Tabla 
            LEFT JOIN (
                    SELECT ff.FK_Informe_pago_persona, group_concat(ff.DT_Date) AS firmas, group_concat(ff.FK_Persona) AS firmantes
                    FROM db_informe_pago.tb_informe_pago_firmas AS ff 
                    WHERE ff.PK_Id_Tabla IN ( 
                        SELECT MAX(f.PK_Id_Tabla) 
                        FROM db_informe_pago.tb_informe_pago_firmas AS f 
                        JOIN db_informe_pago.tb_informe_pago_persona AS tp ON tp.PK_Id_Tabla = f.FK_Informe_pago_persona
                        WHERE f.I_Aprobado = 1 AND f.VC_Token IS NOT NULL 
                        AND tp.PK_Id_Tabla = :PK_Id_Tabla
                        GROUP BY  f.FK_Informe_pago_persona ,  f.FK_Persona 
                    ) GROUP BY ff.FK_Informe_pago_persona 
            ) AS tf ON tf.FK_Informe_pago_persona = tipp.PK_Id_Tabla
            
            WHERE tipp.PK_Id_Tabla = :PK_Id_Tabla";

        #echo $sql;
        #die();
        $sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':PK_Id_Tabla',$informeId);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }   
    
    
    public function validarCantidadFirmasAprobadas($informeId){
        $sql = '
            SELECT
            f.PK_Id_Tabla,
            u.PK_Id_Persona,
            u.VC_Primer_Nombre,
            u.VC_Primer_Apellido,
            f.VC_Token,
            f.DT_Date,
            f.FK_usuario_orfeo
            FROM db_informe_pago.tb_informe_pago_firmas AS f
            JOIN  db_sif_dev.tb_persona_2017 u ON u.PK_Id_Persona = f.FK_Persona
            WHERE  f.PK_Id_Tabla IN (
                SELECT
                MAX(f.PK_Id_Tabla)
                FROM db_informe_pago.tb_informe_pago_firmas AS f
                JOIN  db_sif_dev.tb_persona_2017 u ON u.PK_Id_Persona = f.FK_Persona
                WHERE  f.FK_Informe_pago_persona =  :PK_Id_Tabla AND f.I_Aprobado = 1 AND f.VC_Token IS NOT NULL 
                GROUP BY f.FK_Persona
            )        
        ';
        $sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':PK_Id_Tabla',$informeId);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);        
    }


    public function verFirmantes($informeId){
        $sql = '
        SELECT 
        * 
        FROM
        (
            SELECT 
            tipp.PK_Id_Tabla AS id_informe,
            CONCAT(c.VC_Primer_Nombre," ",COALESCE(c.VC_Segundo_Nombre,"")," ",c.VC_Primer_Apellido," ",COALESCE(c.VC_Segundo_Apellido,"")) AS persona,
            "Contratista" AS rol,
            tf.VC_Token AS token,
            tf.DT_Date AS fecha
            FROM db_informe_pago.tb_informe_pago_persona AS tipp
            JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tipp.FK_Basico = tippb.PK_Id_Tabla 
            JOIN db_sif_dev.tb_persona_2017 c ON c.PK_Id_Persona = tipp.FK_Persona 
            LEFT JOIN db_sif_dev.tb_persona_2017 s ON s.PK_Id_Persona = tippb.FK_Persona_Supervisor
            LEFT JOIN (
             SELECT ff.FK_Informe_pago_persona, ff.FK_Persona, ff.VC_Token, ff.DT_Date
             FROM db_informe_pago.tb_informe_pago_firmas AS ff 
             WHERE ff.PK_Id_Tabla IN ( 
                 SELECT MAX(f.PK_Id_Tabla) 
                 FROM db_informe_pago.tb_informe_pago_firmas AS f 
                 JOIN db_informe_pago.tb_informe_pago_persona AS tp ON tp.PK_Id_Tabla = f.FK_Informe_pago_persona
                 WHERE f.I_Aprobado = 1 AND f.VC_Token IS NOT NULL 
                 AND tp.PK_Id_Tabla = :idInforme
                 GROUP BY  f.FK_Informe_pago_persona ,  f.FK_Persona 
             ) 
           ) AS tf ON tf.FK_Informe_pago_persona = tipp.PK_Id_Tabla AND tf.FK_Persona = tipp.FK_Persona
            WHERE tipp.PK_Id_Tabla = :idInforme
            
            UNION 
            SELECT 
            tipp.PK_Id_Tabla AS id_informe,
            CONCAT(c.VC_Primer_Nombre," ",COALESCE(c.VC_Segundo_Nombre,"")," ",c.VC_Primer_Apellido," ",COALESCE(c.VC_Segundo_Apellido,"")) AS persona,
            "Supervisor" AS rol,
            tf.VC_Token AS token,
            tf.DT_Date AS fecha
            FROM db_informe_pago.tb_informe_pago_persona AS tipp
            JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tipp.FK_Basico = tippb.PK_Id_Tabla 
            LEFT JOIN db_sif_dev.tb_persona_2017 c ON c.PK_Id_Persona = tippb.FK_Persona_Supervisor
            LEFT JOIN (
             SELECT ff.FK_Informe_pago_persona, ff.FK_Persona, ff.VC_Token, ff.DT_Date
             FROM db_informe_pago.tb_informe_pago_firmas AS ff 
             WHERE ff.PK_Id_Tabla IN ( 
                 SELECT MAX(f.PK_Id_Tabla) 
                 FROM db_informe_pago.tb_informe_pago_firmas AS f 
                 JOIN db_informe_pago.tb_informe_pago_persona AS tp ON tp.PK_Id_Tabla = f.FK_Informe_pago_persona
                 WHERE f.I_Aprobado = 1 AND f.VC_Token IS NOT NULL 
                 AND tp.PK_Id_Tabla = :idInforme
                 GROUP BY  f.FK_Informe_pago_persona ,  f.FK_Persona 
             ) 
           ) AS tf ON tf.FK_Informe_pago_persona = tipp.PK_Id_Tabla AND tf.FK_Persona = tippb.FK_Persona_Supervisor
            WHERE tipp.PK_Id_Tabla = :idInforme 
            
            UNION 
            SELECT 
            tipp.PK_Id_Tabla AS id_informe,
            CONCAT(c.VC_Primer_Nombre," ",COALESCE(c.VC_Segundo_Nombre,"")," ",c.VC_Primer_Apellido," ",COALESCE(c.VC_Segundo_Apellido,"")) AS persona,
            "Apoyo Supervision" AS rol,
            tf.VC_Token AS token,
            tf.DT_Date AS fecha
            FROM db_informe_pago.tb_informe_pago_persona AS tipp
            JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tipp.FK_Basico = tippb.PK_Id_Tabla 
            LEFT JOIN db_sif_dev.tb_persona_2017 c ON c.PK_Id_Persona = tippb.FK_Persona_Apoyo_Supervisor
            LEFT JOIN (
             SELECT ff.FK_Informe_pago_persona, ff.FK_Persona, ff.VC_Token, ff.DT_Date
             FROM db_informe_pago.tb_informe_pago_firmas AS ff 
             WHERE ff.PK_Id_Tabla IN ( 
                 SELECT MAX(f.PK_Id_Tabla) 
                 FROM db_informe_pago.tb_informe_pago_firmas AS f 
                 JOIN db_informe_pago.tb_informe_pago_persona AS tp ON tp.PK_Id_Tabla = f.FK_Informe_pago_persona
                 WHERE f.I_Aprobado = 1 AND f.VC_Token IS NOT NULL 
                 AND tp.PK_Id_Tabla = :idInforme
                 GROUP BY  f.FK_Informe_pago_persona ,  f.FK_Persona 
             ) 
           ) AS tf ON tf.FK_Informe_pago_persona = tipp.PK_Id_Tabla AND tf.FK_Persona = tippb.FK_Persona_Apoyo_Supervisor		
            WHERE tipp.PK_Id_Tabla = :idInforme 
            
            UNION 
            SELECT 
            tipp.PK_Id_Tabla AS id_informe,
            CONCAT(c.VC_Primer_Nombre," ",COALESCE(c.VC_Segundo_Nombre,"")," ",c.VC_Primer_Apellido," ",COALESCE(c.VC_Segundo_Apellido,"")) AS persona,
            "Apoyo Supervision 2" AS rol,
            tf.VC_Token AS token,
            tf.DT_Date AS fecha
            FROM db_informe_pago.tb_informe_pago_persona AS tipp
            JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tipp.FK_Basico = tippb.PK_Id_Tabla 
            left JOIN db_sif_dev.tb_persona_2017 c ON c.PK_Id_Persona = tippb.FK_Persona_Apoyo_Supervisor_Dos
            LEFT JOIN db_informe_pago.tb_informe_pago_firmas AS f ON tipp.PK_Id_Tabla = f.FK_Informe_pago_persona
            LEFT JOIN (
             SELECT ff.FK_Informe_pago_persona, ff.FK_Persona, ff.VC_Token, ff.DT_Date
             FROM db_informe_pago.tb_informe_pago_firmas AS ff 
             WHERE ff.PK_Id_Tabla IN ( 
                 SELECT MAX(f.PK_Id_Tabla) 
                 FROM db_informe_pago.tb_informe_pago_firmas AS f 
                 JOIN db_informe_pago.tb_informe_pago_persona AS tp ON tp.PK_Id_Tabla = f.FK_Informe_pago_persona
                 WHERE f.I_Aprobado = 1 AND f.VC_Token IS NOT NULL 
                 AND tp.PK_Id_Tabla = :idInforme
                 GROUP BY  f.FK_Informe_pago_persona ,  f.FK_Persona 
             ) 
           ) AS tf ON tf.FK_Informe_pago_persona = tipp.PK_Id_Tabla AND tf.FK_Persona = tippb.FK_Persona_Apoyo_Supervisor_Dos	
            WHERE tipp.PK_Id_Tabla = :idInforme 
            
            UNION 
            SELECT 
            tipp.PK_Id_Tabla AS id_informe,
            CONCAT(c.VC_Primer_Nombre," ",COALESCE(c.VC_Segundo_Nombre,"")," ",c.VC_Primer_Apellido," ",COALESCE(c.VC_Segundo_Apellido,"")) AS persona,
            "Apoyo Administrativo" AS rol,
            tf.VC_Token AS token,
            tf.DT_Date AS fecha
            FROM db_informe_pago.tb_informe_pago_persona AS tipp
            JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tipp.FK_Basico = tippb.PK_Id_Tabla 
            left JOIN db_sif_dev.tb_persona_2017 c ON c.PK_Id_Persona = tippb.FK_Aprobacion_Administrativo
            LEFT JOIN (
             SELECT ff.FK_Informe_pago_persona, ff.FK_Persona, ff.VC_Token, ff.DT_Date
             FROM db_informe_pago.tb_informe_pago_firmas AS ff 
             WHERE ff.PK_Id_Tabla IN ( 
                 SELECT MAX(f.PK_Id_Tabla) 
                 FROM db_informe_pago.tb_informe_pago_firmas AS f 
                 JOIN db_informe_pago.tb_informe_pago_persona AS tp ON tp.PK_Id_Tabla = f.FK_Informe_pago_persona
                 WHERE f.I_Aprobado = 1 AND f.VC_Token IS NOT NULL 
                 AND tp.PK_Id_Tabla = :idInforme
                 GROUP BY  f.FK_Informe_pago_persona ,  f.FK_Persona 
             ) 
           ) AS tf ON tf.FK_Informe_pago_persona = tipp.PK_Id_Tabla AND tf.FK_Persona =  tippb.FK_Aprobacion_Administrativo	
            WHERE tippb.IN_Firma_Administrativo = 1 AND
            tipp.PK_Id_Tabla = :idInforme 
        
        ) AS T ORDER BY T.fecha      
        ';
        $sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':idInforme',$informeId);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);        
    }    


 
    public function limpiarPlanillasFormatos($fkpersona) {            
        $sentencia = $this->dbPDO->prepare("UPDATE db_informe_pago.tb_informe_pago_persona SET TX_Planillas_Extras = '' WHERE FK_Persona = :FK_Persona;");
        $sentencia->bindParam(':FK_Persona',$fkpersona);
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }

    public function getIdUltimoInformeContrato($fk_persona){
        $sentencia = $this->dbPDO->prepare("SELECT tipp.PK_Id_Tabla
                FROM db_informe_pago.tb_informe_pago_persona tipp
                JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona=tipp.FK_Persona AND tippb.SM_Activo=1
                WHERE tipp.FK_Persona=:FK_Persona
                AND
                (
                    (tippb.FK_Persona_Supervisor IS NOT NULL && tipp.SM_Estado NOT LIKE '%7%')
                    OR
                    (tippb.FK_Persona_Apoyo_Supervisor IS NOT NULL && tipp.SM_Estado NOT LIKE '%1%')
                    OR
                    (tippb.FK_Persona_Apoyo_Supervisor_Dos IS NOT NULL && tipp.SM_Estado NOT LIKE '%9%')
                    OR
                    (tippb.FK_Aprobacion_Administrativo IS NOT NULL && tipp.SM_Estado NOT LIKE '%2%')
                    OR

                    tipp.SM_Estado IS NULL
                )
                ORDER BY PK_Id_Tabla DESC LIMIT 1;");
        @$sentencia->bindParam(':FK_Persona',$fk_persona);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarMesesInformes(){
        $sentencia = $this->dbPDO->prepare("SELECT DISTINCT SUBSTRING(VC_Fecha_Informe,7,4) AS anio, SUBSTRING(VC_Fecha_Informe,4,2) AS mes
        FROM db_informe_pago.tb_informe_pago_persona
        WHERE SUBSTRING(VC_Fecha_Informe,7,4) >= 2019
        ORDER BY anio DESC, mes DESC;");
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function setRadicadoOrfeo($radicado_orfeo,$codigo_verificacion,$informeId){
        $sentencia = $this->dbPDO->prepare('UPDATE db_informe_pago.tb_informe_pago_persona SET 
            VC_orfeo_radicado = :radicado_orfeo, VC_orfeo_codigo_verificacion = :codigo_veriicacion 
            WHERE PK_Id_Tabla = :PK_Id_Tabla');
        @$sentencia->bindParam(':radicado_orfeo',$radicado_orfeo);
        @$sentencia->bindParam(':codigo_veriicacion',$codigo_verificacion);
        @$sentencia->bindParam(':PK_Id_Tabla',$informeId);
        $sentencia->execute();
        $filasAfectadas = $sentencia->rowCount();
        $this->saveInformePagoLog($informeId);
        return $filasAfectadas;
    }

    public function agregarAnexoRadicadoOrfeo($numero_anexo,$numero_radicado){

    }

    public function getTrazabilidadInforme($contrato, $mes){
        $sql = "SELECT PPL.PK_Id_Tabla, PPL.FK_Id_Informe, PPL.FK_Persona, PPL.VC_Identificacion  AS 'IDENTIFICACION', 
        CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido) AS 'CONTRATISTA',
        PPL.VC_Numero_Contrato AS 'CONTRATO',
        PPL.VC_Fecha_Informe AS 'MES_INFORME',
        CONCAT(PPL.VC_Periodo_Inicio,' Hasta ',PPL.VC_Periodo_Fin) AS 'PERIODO',
         PPL.SM_Finalizado,
         (CASE WHEN PPL.SM_Finalizado = '0' THEN 'EDICIÓN' WHEN PPL.SM_Finalizado = '1' THEN 'ENVIADO' END) AS 'ENVIADO', 
         PPL.SM_Estado,
        (SELECT GROUP_CONCAT(PD.VC_Descripcion SEPARATOR ', ')
          FROM db_sif_dev.tb_parametro_detalle AS PD
          WHERE FIND_IN_SET(PD.FK_Value, PPL.SM_Estado) AND PD.FK_Id_Parametro = 59) AS 'APROBACIONES',
         PPL.DA_Aprobo AS 'FECHA'
        FROM db_informe_pago.tb_informe_pago_persona_log AS PPL 
        JOIN db_sif_dev.tb_persona_2017 AS PE ON PPL.FK_Persona = PE.PK_Id_Persona
        WHERE PPL.VC_Numero_Contrato = '$contrato' AND PPL.VC_Fecha_Informe LIKE '%$mes%'";  
        @$sentencia=$this->dbPDO->prepare($sql);  
        @$sentencia->bindParam(':contrato', $contrato);
        @$sentencia->bindParam(':mes', $mes);
        @$sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      
      }

      public function deleteObservacionGeneral($posicion, $contrato){
        $sentencia = $this->dbPDO->prepare("SELECT tipp.VC_Observacion_general, tipp.PK_Id_Tabla, tipp.FK_Persona, tipp.VC_Fecha_Informe, tipp.VC_Periodo_Inicio, tipp.VC_Periodo_Fin, tipp.VC_Numero_Contrato, tipp.VC_Tipo_Identificacion, tipp.VC_Identificacion, tipp.VC_Ciiu, tipp.VC_Nombres_Apellidos_Cedente, tipp.VC_Tipo_Identificacion_Cedente, tipp.VC_Identificacion_Cendete, tipp.VC_Banco, tipp.VC_Tipo_Cuenta, tipp.VC_Numero_Cuenta, tipp.VC_Objeto, tipp.VC_Fecha_Inicio, tipp.VC_Plazo_Inicial, tipp.VC_Prorrogas, tipp.VC_Fecha_Plazo_Fin, tipp.VC_Fecha_Fin, tipp.VC_Numero_Pagos, tipp.VC_Pago_Numero, tipp.VC_Pago_De_Total, tipp.TX_Rp_Json, tipp.VC_Valor_Inicial, tipp.VC_Valor_Adicion_1, tipp.VC_Valor_Adicion_2, tipp.VC_Valor_Adicion_3, tipp.VC_Valor_Total_Contrato, tipp.VC_Valor_Pago_Efectuar, tipp.VC_Valor_Letras, tipp.VC_Giros_Efectuados, tipp.VC_Saldo_Pediente, tipp.VC_Valor_Liberar, tipp.VC_Numero_Obligaciones, tipp.TX_Obligaciones_Json, tipp.VC_Textarea_Producto, tipp.VC_Textarea_Mecanismo_Verificacion, tipp.TX_Declaracion_Json, tipp.VC_Disminucion_Retencion, tipp.VC_Tomados_Retencion, tipp.VC_Mes_Planilla, tipp.VC_Numero_Planilla, tipp.TX_Planillas_Extras, tippb.FK_Persona_Supervisor, tippb.FK_Persona_Apoyo_Supervisor, tippb.FK_Persona_Apoyo_Supervisor_Dos, tippb.FK_Aprobacion,tippb.FK_Aprobacion_Administrativo, tipp.DA_Subida, tipp.SM_Estado, tipp.VC_Observacion, tipp.DA_Revision, tipp.FK_Persona_Reviso, tipp.DA_Aprobo, tipp.VC_Suspension, tipp.FK_Persona_Aprobo,CONCAT(tp2.VC_Primer_Nombre,' ',tp2.VC_Segundo_Nombre,' ',tp2.VC_Primer_Apellido,' ',tp2.VC_Segundo_Apellido) AS 'nombre_contratista',tipp.SM_Finalizado,tipp.FK_Basico, tippb.IN_Firma_Administrativo, (select CONCAT('[',GROUP_CONCAT(JSON_OBJECT('PK_Id_Persona',tp2.PK_Id_Persona,'nombre',CONCAT(tp2.VC_Primer_Nombre,' ',tp2.VC_Primer_Apellido) )),']') from db_sif_dev.tb_persona_2017 tp2 WHERE FIND_IN_SET( tp2.PK_Id_Persona, (SELECT replace(replace(replace(replace(JSON_EXTRACT(tpp.VC_Observacion, '$.*[*].usuario'),'\"',''),'[',''),']',''),' ','') AS usuarios FROM db_informe_pago.tb_informe_pago_persona tpp where tpp.PK_Id_Tabla = tipp.PK_Id_Tabla)) > 0) as usuarios_observaciones_json FROM db_informe_pago.tb_informe_pago_persona tipp JOIN  db_sif_dev.tb_persona_2017 tp2 ON tp2.PK_Id_Persona = tipp.FK_Persona JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tippb.SM_Activo = 1 WHERE tipp.PK_Id_Tabla = :PK_Id_Tabla ");
        @$sentencia->bindParam(':PK_Id_Tabla',$contrato);
        @$sentencia->execute();
        
        var_dump($sentencia->fetchAll(\PDO::FETCH_ASSOC));
      }

    public function saveAnexosOrfeo($objeto){

        $sentencia = $this->dbPDO->prepare('INSERT INTO db_informe_pago.tb_informe_pago_anexos_orfeo (FK_Persona, FK_Informe_pago_persona, FK_Parametro_Detalle, TX_Anexo, DT_Date, FK_Informe_pago_basico) VALUES ( :FK_Persona, :FK_Informe_pago_persona, :FK_Parametro_Detalle, :TX_Anexo, :DT_Date, :FK_Informe_pago_basico);');
        
        @$sentencia->bindParam(':FK_Persona',$objeto->getFkPersona());
        @$sentencia->bindParam(':FK_Informe_pago_persona',$objeto->getFkInformePagoPersona());
        @$sentencia->bindParam(':FK_Parametro_Detalle',$objeto->getFkParametroD());
        @$sentencia->bindParam(':TX_Anexo',$objeto->getTxAnexo());
        @$sentencia->bindParam(':DT_Date',$objeto->getDtDate());
        @$sentencia->bindParam(':FK_Informe_pago_basico',$objeto->getFkInformePagoBasico());
        
        @$sentencia->execute();
        //$id_insertado = $this->dbPDO->lastInsertId();
        $filasAfectadas = $sentencia->rowCount();
        echo($filasAfectadas);
        return $filasAfectadas;   
    }

    public function deleteAnexoOrfeo($idAnexo){
        try {

            $query = "SELECT *  FROM db_informe_pago.tb_informe_pago_anexos_orfeo WHERE PK_Id_Tabla = :PK_Id_Tabla";  
            @$sentenciaQuery=$this->dbPDO->prepare($query);  
            @$sentenciaQuery->bindParam(':PK_Id_Tabla', $idAnexo);
            @$sentenciaQuery->execute();
            $anexo  = $sentenciaQuery->fetchAll(\PDO::FETCH_ASSOC)[0];
            $this->dbPDO->beginTransaction();
            $sql = "DELETE FROM db_informe_pago.tb_informe_pago_anexos_orfeo WHERE PK_Id_Tabla = :PK_Id_Tabla";
            $sentencia=$this->dbPDO->prepare($sql); 
            $sentencia->bindParam(':PK_Id_Tabla', $idAnexo);
            $sentencia->execute();
            $this->dbPDO->commit();
            $elimino = $sentencia->rowCount();
            if($elimino && isset($anexo['TX_Anexo'])){
                unlink($anexo['TX_Anexo']);
            }
            return  $elimino;
            
        }catch(PDOExecption $e) {
            $this->dbPDO->rollback();
            return 0;
        }		
	}

    public function getAnexosOrfeo($idInforme){

        $sql="SELECT * FROM db_informe_pago.tb_informe_pago_anexos_orfeo WHERE FK_Informe_pago_persona = :FK_Informe_pago_persona";

        $sentencia=$this->dbPDO->prepare($sql); 
        $sentencia->bindParam(':FK_Informe_pago_persona', $idInforme);

        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   
    }

    public function getAnexoOrfeo($id_parametro, $id_informe){

        $sql="SELECT * FROM db_informe_pago.tb_informe_pago_anexos_orfeo WHERE FK_Informe_pago_persona = :FK_Informe_pago_persona AND FK_Parametro_Detalle = :FK_Parametro_Detalle";

        $sentencia=$this->dbPDO->prepare($sql); 
        $sentencia->bindParam(':FK_Informe_pago_persona', $id_informe);
        $sentencia->bindParam(':FK_Parametro_Detalle', $id_parametro);

        $sentencia->execute();
    
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   
    }

    public function updateAnexosOrfeo($objeto){

        $sentencia = $this->dbPDO->prepare('UPDATE db_informe_pago.tb_informe_pago_anexos_orfeo SET TX_Anexo = :TX_Anexo, DT_Date = :DT_Date  WHERE FK_Informe_pago_persona = :FK_Informe_pago_persona AND FK_Parametro_Detalle = :FK_Parametro_Detalle');
        
        @$sentencia->bindParam(':FK_Informe_pago_persona',$objeto->getFkInformePagoPersona());
        @$sentencia->bindParam(':FK_Parametro_Detalle',$objeto->getFkParametroD());
        @$sentencia->bindParam(':TX_Anexo',$objeto->getTxAnexo());
        @$sentencia->bindParam(':DT_Date',$objeto->getDtDate());
        
        @$sentencia->execute();
        
        $filasAfectadas = $sentencia->rowCount();
        echo($filasAfectadas);
        return $filasAfectadas;

    }
    
    public function saveFirma($objeto){
       
        $sql = "INSERT INTO db_informe_pago.tb_informe_pago_firmas 
            (FK_usuario_orfeo, FK_Persona, VC_Token, FK_Informe_pago_persona, DT_Date, I_Aprobado, VC_Observacion, VC_Transaccion, VC_sistema_operativo, VC_navegador, VC_navegador_version, VC_direccion_ip) 
            VALUES (:FK_usuario_orfeo, :FK_Persona, :VC_Token, :FK_Informe_pago_persona, now(), :I_Aprobado, :VC_Observacion, :VC_Transaccion, :VC_sistema_operativo, :VC_navegador, :VC_navegador_version, :VC_direccion_ip);
        ";
        $sentencia = $this->dbPDO->prepare($sql);

        
        @$sentencia->bindParam(':FK_usuario_orfeo',$objeto->getFkUsuarioOrfeo());
        @$sentencia->bindParam(':FK_Persona',$objeto->getFkPersona());
        @$sentencia->bindParam(':VC_Token',$objeto->getVcToken());
        @$sentencia->bindParam(':FK_Informe_pago_persona',$objeto->getFkInformePagoPersona());
        @$sentencia->bindParam(':I_Aprobado',$objeto->getIAprobado());
        @$sentencia->bindParam(':VC_Observacion',$objeto->getVcObservacion());
        @$sentencia->bindParam(':VC_Transaccion',$objeto->getVcTransaccion());
        @$sentencia->bindParam(':VC_sistema_operativo',$objeto->getVcSistemaOperativo());
        @$sentencia->bindParam(':VC_navegador',$objeto->getVcNavegador());
        @$sentencia->bindParam(':VC_navegador_version',$objeto->getVcNavegadorVersion());
        @$sentencia->bindParam(':VC_direccion_ip',$objeto->getVcDireccionIp());
        @$sentencia->execute();
        
        $filasAfectadas = $sentencia->rowCount();
        #echo($filasAfectadas);
        return $filasAfectadas;   

    }

    public function updateRadicadoInformePago(RadicadoResponse $radicado) {
        $sentencia = $this->dbPDO->prepare("UPDATE db_informe_pago.tb_informe_pago_persona SET 
            VC_orfeo_radicado = :VC_orfeo_radicado,
            VC_orfeo_codigo_verificacion = :VC_orfeo_codigo_verificacion,
            DT_orfeo_fecha = :DT_orfeo_fecha
            WHERE
            PK_Id_Tabla = :PK_Id_Tabla;");

        @$sentencia->bindParam(':VC_orfeo_radicado',$radicado->getNumeroRadicado());
        @$sentencia->bindParam(':VC_orfeo_codigo_verificacion',$radicado->getCodigoVerificacion());
        @$sentencia->bindParam(':DT_orfeo_fecha',$radicado->getFechaRadicado());
        @$sentencia->bindParam(':PK_Id_Tabla',$radicado->getInformePago()->getId());
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }  
    
    public function updateIdAnexoInformePago(RadicadoResponse $radicado) {
        $sentencia = $this->dbPDO->prepare("UPDATE db_informe_pago.tb_informe_pago_persona SET 
            VC_orfeo_radicado_anexo = :VC_orfeo_radicado_anexo
            WHERE
            PK_Id_Tabla = :PK_Id_Tabla;");

        $anexoInformePago = null;
        foreach($radicado->getDocumentos() as $documento)
        {
            if($documento->getEsPrincipal())
            {
                $anexoInformePago = $documento->getAnexoId();
            }
        }

        @$sentencia->bindParam(':VC_orfeo_radicado_anexo',$anexoInformePago);
        @$sentencia->bindParam(':PK_Id_Tabla',$radicado->getInformePago()->getId());
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }   
    
    
    public function getTiposAnexos(){

        $sql="SELECT * FROM db_informe_pago.tb_parametro_anexo WHERE I_estado = 1 ORDER BY I_orden";

        $sentencia=$this->dbPDO->prepare($sql); 

        $sentencia->execute();
    
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   
    } 
    
    public function getTiposAnexosObligatoriosNumeroPago($numeroPago){

        if($numeroPago == 'I'){
            $where = "VC_codigo_interno = 'O' OR  VC_codigo_interno ='I'";
        }else if($numeroPago == 'O'){
            $where = "VC_codigo_interno = 'O'";
        }
        else if($numeroPago == 'N'){
            $where = "VC_codigo_interno = 'N'";
        }else if($numeroPago == 'F'){
            $where = "VC_codigo_interno = 'O' OR  VC_codigo_interno ='F'";
        }
        #var_dump($numeroPago);
        $sql="SELECT * FROM db_informe_pago.tb_parametro_anexo WHERE I_estado = 1 AND ".$where." ORDER BY I_orden";
        #echo $sql;
        $sentencia=$this->dbPDO->prepare($sql); 
        $sentencia->execute();
    
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);   
    }
    
    public function getTiposAnexosOpcionales(){

        $sql="SELECT * FROM db_informe_pago.tb_parametro_anexo WHERE I_estado = 1
                AND VC_codigo_interno = 'N' ORDER BY I_orden";

        $sentencia=$this->dbPDO->prepare($sql); 
        $sentencia->execute();
    
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   
    }   
    
    public function getTiposAnexosObjeto() 
    {
        $tipoDocumentos = $this->getTiposAnexos();
        $tiposDocumentosArray = [];
        foreach($tipoDocumentos as $tipoDocumento){
            $tiposDocumentosArray[$tipoDocumento['I_orden']] = new TipoDocumento(
                $tipoDocumento['PK_Id_Tabla'],
                $tipoDocumento['VC_nombre'],
                $tipoDocumento['I_orden'],
                $tipoDocumento['VC_extensiones'],
                $tipoDocumento['VC_codigo_interno']
            );
        }
        return $tiposDocumentosArray;
    }
  
    
    public function getObservacionGeneral($idInforme){
       
      $sentencia = $this->dbPDO->prepare("SELECT tipp.VC_Observacion_general, tipp.PK_Id_Tabla, tipp.FK_Persona, tipp.VC_Fecha_Informe, tipp.VC_Periodo_Inicio, tipp.VC_Periodo_Fin, tipp.VC_Numero_Contrato, tipp.VC_Tipo_Identificacion, tipp.VC_Identificacion, tipp.VC_Ciiu, tipp.VC_Nombres_Apellidos_Cedente, tipp.VC_Tipo_Identificacion_Cedente, tipp.VC_Identificacion_Cendete, tipp.VC_Banco, tipp.VC_Tipo_Cuenta, tipp.VC_Numero_Cuenta, tipp.VC_Objeto, tipp.VC_Fecha_Inicio, tipp.VC_Plazo_Inicial, tipp.VC_Prorrogas, tipp.VC_Fecha_Plazo_Fin, tipp.VC_Fecha_Fin, tipp.VC_Numero_Pagos, tipp.VC_Pago_Numero, tipp.VC_Pago_De_Total, tipp.TX_Rp_Json, tipp.VC_Valor_Inicial, tipp.VC_Valor_Adicion_1, tipp.VC_Valor_Adicion_2, tipp.VC_Valor_Adicion_3, tipp.VC_Valor_Total_Contrato, tipp.VC_Valor_Pago_Efectuar, tipp.VC_Valor_Letras, tipp.VC_Giros_Efectuados, tipp.VC_Saldo_Pediente, tipp.VC_Valor_Liberar, tipp.VC_Numero_Obligaciones, tipp.TX_Obligaciones_Json, tipp.VC_Textarea_Producto, tipp.VC_Textarea_Mecanismo_Verificacion, tipp.TX_Declaracion_Json, tipp.VC_Disminucion_Retencion, tipp.VC_Tomados_Retencion, tipp.VC_Mes_Planilla, tipp.VC_Numero_Planilla, tipp.TX_Planillas_Extras, tippb.FK_Persona_Supervisor, tippb.FK_Persona_Apoyo_Supervisor, tippb.FK_Persona_Apoyo_Supervisor_Dos, tippb.FK_Aprobacion,tippb.FK_Aprobacion_Administrativo, tipp.DA_Subida, tipp.SM_Estado, tipp.VC_Observacion, tipp.DA_Revision, tipp.FK_Persona_Reviso, tipp.DA_Aprobo, tipp.VC_Suspension, tipp.FK_Persona_Aprobo,CONCAT(tp2.VC_Primer_Nombre,' ',tp2.VC_Segundo_Nombre,' ',tp2.VC_Primer_Apellido,' ',tp2.VC_Segundo_Apellido) AS 'nombre_contratista',tipp.SM_Finalizado,tipp.FK_Basico, tippb.IN_Firma_Administrativo, (select CONCAT('[',GROUP_CONCAT(JSON_OBJECT('PK_Id_Persona',tp2.PK_Id_Persona,'nombre',CONCAT(tp2.VC_Primer_Nombre,' ',tp2.VC_Primer_Apellido) )),']') from db_sif_dev.tb_persona_2017 tp2 WHERE FIND_IN_SET( tp2.PK_Id_Persona, (SELECT replace(replace(replace(replace(JSON_EXTRACT(tpp.VC_Observacion, '$.*[*].usuario'),'\"',''),'[',''),']',''),' ','') AS usuarios FROM db_informe_pago.tb_informe_pago_persona tpp where tpp.PK_Id_Tabla = tipp.PK_Id_Tabla)) > 0) as usuarios_observaciones_json FROM db_informe_pago.tb_informe_pago_persona tipp JOIN  db_sif_dev.tb_persona_2017 tp2 ON tp2.PK_Id_Persona = tipp.FK_Persona JOIN db_informe_pago.tb_informe_pago_persona_basico tippb ON tippb.FK_Persona = tipp.FK_Persona AND tippb.SM_Activo = 1 WHERE tipp.PK_Id_Tabla = :PK_Id_Tabla ");
        @$sentencia->bindParam(':PK_Id_Tabla',$idInforme);
        @$sentencia->execute();
        
        var_dump($sentencia->fetchAll(\PDO::FETCH_ASSOC));

    }

    public function getAnexosInformePago($informePago)
    {
        $sql = "SELECT 
        a.PK_Id_Tabla,
        a.Tx_Anexo,
        a.FK_Parametro_Detalle,
        pa.VC_nombre,
        pa.I_orden
        FROM db_informe_pago.tb_informe_pago_anexos_orfeo AS a
        JOIN db_informe_pago.tb_parametro_anexo AS pa ON pa.PK_Id_Tabla = a.FK_Parametro_Detalle
        WHERE FK_Informe_pago_persona = :FK_Informe_pago_persona ORDER BY pa.I_orden";  
        $sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':FK_Informe_pago_persona',$informePago);
        $sentencia->execute();
    
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);             
    }

    public function getFirmasInformePago($informePago)
    {
    
        $sql = "SELECT
        u.VC_Identificacion,
        f.VC_Token,
        f.VC_sistema_operativo,
        f.VC_navegador,
        f.VC_navegador_version,
        f.VC_direccion_ip,
        f.FK_usuario_orfeo
        FROM db_informe_pago.tb_informe_pago_firmas AS f
        JOIN  db_sif_dev.tb_persona_2017 u ON u.PK_Id_Persona = f.FK_Persona
        WHERE  f.PK_Id_Tabla IN (
            SELECT
            MAX(f.PK_Id_Tabla)
            FROM db_informe_pago.tb_informe_pago_firmas AS f
            JOIN  db_sif_dev.tb_persona_2017 u ON u.PK_Id_Persona = f.FK_Persona
            WHERE  f.FK_Informe_pago_persona =  :FK_Informe_pago_persona AND f.I_Aprobado = 1 AND f.VC_Token IS NOT NULL 
            GROUP BY f.FK_Persona
        )";


        $sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':FK_Informe_pago_persona',$informePago);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                
    } 
    
    public function getHistoricoAprobacionesInformePago($informePago)
    {
        
        $sql = "SELECT
        u.VC_Identificacion,
        u.VC_Primer_Nombre,
        u.VC_Primer_Apellido,
        f.VC_Transaccion,
        f.VC_Observacion,
        f.DT_Date,
        f.I_Aprobado
        FROM db_informe_pago.tb_informe_pago_firmas AS f
        JOIN  db_sif_dev.tb_persona_2017 u ON u.PK_Id_Persona = f.FK_Persona
        WHERE  f.FK_Informe_pago_persona = :FK_Informe_pago_persona";


        $sentencia=$this->dbPDO->prepare($sql); 
        @$sentencia->bindParam(':FK_Informe_pago_persona',$informePago);
        $sentencia->execute();
        return  $sentencia->fetchAll(\PDO::FETCH_ASSOC);           
    }  

	public function getUltimoInformePagoPersonaPorBasico($idBasico) {
		$sql="SELECT i.PK_Id_Tabla, i.FK_Persona, i.VC_Numero_Pagos, i.VC_Pago_Numero, i.VC_Pago_De_Total, 
        b.VC_Numero_Pagos as VC_Numero_Pagos_Basico, b.VC_Pago_Numero as VC_Pago_Numero_Basico, b.VC_Pago_De_Total as  VC_Pago_De_Total_Basico
        FROM db_informe_pago.tb_informe_pago_persona_basico AS b
        LEFT JOIN  db_informe_pago.tb_informe_pago_persona AS i ON i.VC_Numero_Contrato = b.VC_Numero_Contrato
        WHERE  b.PK_Id_Tabla = :PK_Id_Tabla AND b.SM_Activo = 1 
        ORDER BY  i.PK_Id_Tabla DESC LIMIT 1 ";
		@$sentencia=$this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':PK_Id_Tabla',$idBasico);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0];
	}
    
    public function updateIRadicadoInforme($firma,$informeId) {
        $sentencia = $this->dbPDO->prepare("UPDATE db_informe_pago.tb_informe_pago_persona SET 
            I_radicado_orfeo = :I_radicado_orfeo,
            DT_firma_orfeo   = now()
            WHERE
            PK_Id_Tabla = :PK_Id_Tabla;");
            
        @$sentencia->bindParam(':I_radicado_orfeo',$firma);
        @$sentencia->bindParam(':PK_Id_Tabla',$informeId);
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
    }
    
	public function reiniciarAprobaciones($informeId)
	{
        $sentencia = $this->dbPDO->prepare("UPDATE db_informe_pago.tb_informe_pago_persona SET 
            SM_Finalizado = 0,
            SM_Estado = '',
            VC_orfeo_radicado = '',
            VC_orfeo_codigo_verificacion = '',
            VC_Observacion_general = NULL,
            VC_orfeo_radicado_anexo = NULL,
            DT_orfeo_fecha = NULL,
            I_radicado_orfeo = NULL,
            DT_firma_orfeo   = NULL
            WHERE
            PK_Id_Tabla = :PK_Id_Tabla;");

        @$sentencia->bindParam(':PK_Id_Tabla',$informeId);
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
	}

	public function eliminarFirmas($informeId)
	{
        $sentencia = $this->dbPDO->prepare("DELETE FROM db_informe_pago.tb_informe_pago_firmas
            WHERE FK_Informe_pago_persona = :FK_Informe_pago_persona;");

        @$sentencia->bindParam(':FK_Informe_pago_persona',$informeId);
        $sentencia->execute(); 
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
	}    

}