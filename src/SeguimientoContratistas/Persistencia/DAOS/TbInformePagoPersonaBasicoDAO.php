<?php
namespace SeguimientoContratistas\Persistencia\DAOS;
use General\Persistencia\DAOS\GestionDAO;

class TbInformePagoPersonaBasicoDAO extends GestionDAO {

	private $db;
	private $dbPDO;

	function __construct() {
		$this->db    = $this->obtenerBD();
		$this->dbPDO = $this->obtenerPDOBD();
		//echo "<pre>".print_r($this->db,true)."</pre>";
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

	public function getInformePagoBasicoPersona($id_persona) {
		$sql="SELECT * FROM db_informe_pago.tb_informe_pago_persona_basico WHERE FK_persona = :FK_persona AND SM_Activo = 1 LIMIT 1;";
		@$sentencia=$this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':FK_persona',$id_persona);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0];
	}

	public function getInformePagoBasicoPk($informe_id) {
		//Informe Genérico para usar su estructura de datos.
		if($informe_id == 2534){
			$sql="SELECT * FROM db_informe_pago.tb_informe_pago_persona_basico WHERE PK_Id_Tabla = :PK_Id_Tabla LIMIT 1;";	
		}
		else{
			$sql="SELECT * FROM db_informe_pago.tb_informe_pago_persona_basico WHERE PK_Id_Tabla = :PK_Id_Tabla AND SM_Activo = 1 LIMIT 1;";
		}
		@$sentencia=$this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':PK_Id_Tabla',$informe_id);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0];
	}

	public function getInformePagoBasicoPkEstructura() {
		$sql="SELECT * FROM db_informe_pago.tb_informe_pago_persona_basico WHERE PK_Id_Tabla = 2574 LIMIT 1;";
		@$sentencia=$this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':PK_Id_Tabla',$informe_id);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0];
	}

	public function updateInformePagoBasico($objeto) {

		$sentencia = $this->dbPDO->prepare('UPDATE db_informe_pago.tb_informe_pago_persona_basico SET VC_Numero_Contrato = :VC_Numero_Contrato, VC_Tipo_Identificacion = :VC_Tipo_Identificacion, VC_Identificacion = :VC_Identificacion, VC_Ciiu = :VC_Ciiu, VC_Nombres_Apellidos_Cedente = :VC_Nombres_Apellidos_Cedente, VC_Tipo_Identificacion_Cedente = :VC_Tipo_Identificacion_Cedente, VC_Identificacion_Cendete = :VC_Identificacion_Cendete, VC_Banco = :VC_Banco, VC_Tipo_Cuenta = :VC_Tipo_Cuenta, VC_Numero_Cuenta = :VC_Numero_Cuenta, VC_Objeto = :VC_Objeto, VC_Fecha_Inicio = :VC_Fecha_Inicio, VC_Plazo_Inicial = :VC_Plazo_Inicial, VC_Prorrogas = :VC_Prorrogas, VC_Fecha_Plazo_Fin = :VC_Fecha_Plazo_Fin, VC_Fecha_Fin = :VC_Fecha_Fin, VC_Numero_Pagos = :VC_Numero_Pagos, VC_Pago_Numero = :VC_Pago_Numero, VC_Pago_De_Total = :VC_Pago_De_Total, VC_Pago_De_Total = :VC_Pago_De_Total, VC_Valor_Inicial = :VC_Valor_Inicial, VC_Valor_Adicion_1 = :VC_Valor_Adicion_1, VC_Valor_Adicion_2 = :VC_Valor_Adicion_2, VC_Valor_Adicion_3 = :VC_Valor_Adicion_3, VC_Valor_Total_Contrato = :VC_Valor_Total_Contrato, VC_Valor_Pago_Efectuar = :VC_Valor_Pago_Efectuar, VC_Giros_Efectuados = :VC_Giros_Efectuados, VC_Saldo_Pediente = :VC_Saldo_Pediente, VC_Valor_Liberar = :VC_Valor_Liberar,VC_Textarea_Producto = :VC_Textarea_Producto, VC_Numero_Obligaciones = :VC_Numero_Obligaciones, VC_Disminucion_Retencion = :VC_Disminucion_Retencion, VC_Tomados_Retencion = :VC_Tomados_Retencion, TX_Rp_Json = :TX_Rp_Json, TX_Declaracion_Json = :TX_Declaracion_Json, TX_Obligaciones_Json = :TX_Obligaciones_Json, FK_Persona_Actualizo = :FK_Persona_Actualizo, DA_Actualizo = now() WHERE FK_Persona = :FK_Persona AND SM_Activo = 1;');

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
		@$sentencia->bindParam(':VC_Pago_De_Total',$objeto->getVcPagoDeTotal());
		@$sentencia->bindParam(':VC_Valor_Inicial',$objeto->getVcValorInicial());
		@$sentencia->bindParam(':VC_Valor_Adicion_1',$objeto->getVcValorAdicion1());
		@$sentencia->bindParam(':VC_Valor_Adicion_2',$objeto->getVcValorAdicion2());
		@$sentencia->bindParam(':VC_Valor_Adicion_3',$objeto->getVcValorAdicion3());
		@$sentencia->bindParam(':VC_Valor_Total_Contrato',$objeto->getVcValorTotalContrato());
		@$sentencia->bindParam(':VC_Valor_Pago_Efectuar',$objeto->getVcValorPagoEfectuar());
		@$sentencia->bindParam(':VC_Giros_Efectuados',$objeto->getVcGirosEfectuados());
		@$sentencia->bindParam(':VC_Saldo_Pediente',$objeto->getVcSaldoPediente());
		@$sentencia->bindParam(':VC_Valor_Liberar',$objeto->getVcValorLiberar());
		@$sentencia->bindParam(':VC_Textarea_Producto',$objeto->getVcTextareaProducto());
		@$sentencia->bindParam(':VC_Numero_Obligaciones',$objeto->getVcNumeroObligaciones());
		@$sentencia->bindParam(':VC_Disminucion_Retencion',$objeto->getVcDisminucionRetencion());
		@$sentencia->bindParam(':VC_Tomados_Retencion',$objeto->getVcTomadosRetencion());
		@$sentencia->bindParam(':TX_Rp_Json',$objeto->getTxRpJson());
		@$sentencia->bindParam(':TX_Declaracion_Json',$objeto->getTxDeclaracionJson());
		@$sentencia->bindParam(':TX_Obligaciones_Json',$objeto->getTxObligacionesJson());
		@$sentencia->bindParam(':FK_Persona',$objeto->getFkPersona());
		@$sentencia->bindParam(':FK_Persona_Actualizo',$objeto->getFkPersonaActualizo());
		$sentencia->execute(); 
		$filasAfectadas = $sentencia->rowCount();
		return $filasAfectadas;
	}
	public function updateInformePagoBasicoAdmin($objeto) {

		$sentencia = $this->dbPDO->prepare('UPDATE db_informe_pago.tb_informe_pago_persona_basico SET VC_Tipo_Identificacion = :VC_Tipo_Identificacion, VC_Identificacion = :VC_Identificacion, VC_Ciiu = :VC_Ciiu, VC_Objeto = :VC_Objeto, VC_Fecha_Inicio = :VC_Fecha_Inicio, VC_Plazo_Inicial = :VC_Plazo_Inicial, VC_Prorrogas = :VC_Prorrogas, VC_Fecha_Plazo_Fin = :VC_Fecha_Plazo_Fin, VC_Fecha_Fin = :VC_Fecha_Fin, VC_Numero_Pagos = :VC_Numero_Pagos, VC_Pago_De_Total = :VC_Pago_De_Total, VC_Valor_Inicial = :VC_Valor_Inicial, VC_Valor_Adicion_1 = :VC_Valor_Adicion_1, VC_Valor_Adicion_2 = :VC_Valor_Adicion_2, VC_Valor_Adicion_3 = :VC_Valor_Adicion_3, VC_Valor_Total_Contrato = :VC_Valor_Total_Contrato, VC_Valor_Pago_Efectuar = :VC_Valor_Pago_Efectuar, VC_Giros_Efectuados = :VC_Giros_Efectuados, VC_Saldo_Pediente = :VC_Saldo_Pediente, VC_Valor_Liberar = :VC_Valor_Liberar, VC_Disminucion_Retencion = :VC_Disminucion_Retencion, VC_Tomados_Retencion = :VC_Tomados_Retencion, TX_Rp_Json = :TX_Rp_Json, TX_Declaracion_Json = :TX_Declaracion_Json, FK_Persona_Actualizo = :FK_Persona_Actualizo, FK_Persona_Supervisor = :FK_Persona_Supervisor, FK_Persona_Apoyo_Supervisor = :FK_Persona_Apoyo_Supervisor, FK_Persona_Apoyo_Supervisor_Dos = :FK_Persona_Apoyo_Supervisor_Dos, FK_Aprobacion_Administrativo = :FK_Aprobacion_Administrativo, FK_Aprobacion= :FK_Aprobacion, DA_Actualizo = now() WHERE PK_Id_Tabla = :PK_Id_Tabla AND SM_Activo = 1;');

		//@$sentencia->bindParam(':VC_Numero_Contrato',$objeto->getVcNumeroContrato());
		@$sentencia->bindParam(':VC_Tipo_Identificacion',$objeto->getVcTipoIdentificacion());
		@$sentencia->bindParam(':VC_Identificacion',$objeto->getVcIdentificacion());
		@$sentencia->bindParam(':VC_Ciiu',$objeto->getVcCiiu());
		//@$sentencia->bindParam(':VC_Nombres_Apellidos_Cedente',$objeto->getVcNombresApellidosCedente());
		//@$sentencia->bindParam(':VC_Tipo_Identificacion_Cedente',$objeto->getVcTipoIdentificacionCedente());
		//@$sentencia->bindParam(':VC_Identificacion_Cendete',$objeto->getVcIdentificacionCendete());
		@$sentencia->bindParam(':VC_Objeto',$objeto->getVcObjeto());
		@$sentencia->bindParam(':VC_Fecha_Inicio',$objeto->getVcFechaInicio());
		@$sentencia->bindParam(':VC_Plazo_Inicial',$objeto->getVcPlazoInicial());
		@$sentencia->bindParam(':VC_Prorrogas',$objeto->getVcProrrogas());
		@$sentencia->bindParam(':VC_Fecha_Plazo_Fin',$objeto->getVcFechaPlazoFin());
		@$sentencia->bindParam(':VC_Fecha_Fin',$objeto->getVcFechaFin());
		@$sentencia->bindParam(':VC_Numero_Pagos',$objeto->getVcNumeroPagos());
		@$sentencia->bindParam(':VC_Pago_De_Total',$objeto->getVcPagoDeTotal());
		@$sentencia->bindParam(':VC_Valor_Inicial',$objeto->getVcValorInicial());
		@$sentencia->bindParam(':VC_Valor_Adicion_1',$objeto->getVcValorAdicion1());
		@$sentencia->bindParam(':VC_Valor_Adicion_2',$objeto->getVcValorAdicion2());
		@$sentencia->bindParam(':VC_Valor_Adicion_3',$objeto->getVcValorAdicion3());
		@$sentencia->bindParam(':VC_Valor_Total_Contrato',$objeto->getVcValorTotalContrato());
		@$sentencia->bindParam(':VC_Valor_Pago_Efectuar',$objeto->getVcValorPagoEfectuar());
		@$sentencia->bindParam(':VC_Giros_Efectuados',$objeto->getVcGirosEfectuados());
		@$sentencia->bindParam(':VC_Saldo_Pediente',$objeto->getVcSaldoPediente());
		@$sentencia->bindParam(':VC_Valor_Liberar',$objeto->getVcValorLiberar());
		@$sentencia->bindParam(':VC_Disminucion_Retencion',$objeto->getVcDisminucionRetencion());
		@$sentencia->bindParam(':VC_Tomados_Retencion',$objeto->getVcTomadosRetencion());
		@$sentencia->bindParam(':FK_Persona_Supervisor',$objeto->getFkPersonaSupervisor());
		@$sentencia->bindParam(':FK_Persona_Apoyo_Supervisor',$objeto->getFkPersonaApoyoSupervisor());
		@$sentencia->bindParam(':FK_Persona_Apoyo_Supervisor_Dos',$objeto->getFkPersonaApoyoSupervisordos());
		@$sentencia->bindParam(':FK_Aprobacion_Administrativo',$objeto->getFkAprobacionAdministrativo());
		@$sentencia->bindParam(':FK_Aprobacion',$objeto->getFkAprobacion());
		@$sentencia->bindParam(':TX_Rp_Json',$objeto->getTxRpJson());
		@$sentencia->bindParam(':TX_Declaracion_Json',$objeto->getTxDeclaracionJson());
		@$sentencia->bindParam(':PK_Id_Tabla',$objeto->getPkIdTabla());
		@$sentencia->bindParam(':FK_Persona_Actualizo',$objeto->getFkPersonaActualizo());
		$sentencia->execute();
		$filasAfectadas = $sentencia->rowCount();
		return $filasAfectadas;
	}

	public function saveInformePagoBasicoAdmin($objeto) {

		$sentencia = $this->dbPDO->prepare('INSERT INTO db_informe_pago.tb_informe_pago_persona_basico (FK_Persona, VC_Numero_Contrato, VC_Tipo_Identificacion, VC_Identificacion, VC_Ciiu, VC_Objeto, VC_Fecha_Inicio, VC_Fecha_Fin, VC_Numero_Pagos, VC_Pago_Numero, VC_Pago_De_Total, TX_Rp_Json, VC_Valor_Inicial, VC_Valor_Adicion_1, VC_Valor_Adicion_2, VC_Valor_Adicion_3, VC_Valor_Total_Contrato, VC_Valor_Pago_Efectuar, VC_Giros_Efectuados, VC_Saldo_Pediente, VC_Valor_Liberar, FK_Persona_Supervisor, FK_Persona_Apoyo_Supervisor, FK_Persona_Apoyo_Supervisor_Dos, FK_Aprobacion_Administrativo, FK_Persona_Actualizo, DA_Actualizo, SM_Activo) VALUES (:FK_Persona, :VC_Numero_Contrato, :VC_Tipo_Identificacion, :VC_Identificacion, :VC_Ciiu, :VC_Objeto, :VC_Fecha_Inicio, :VC_Fecha_Fin, :VC_Numero_Pagos, :VC_Pago_Numero, :VC_Pago_De_Total, :TX_Rp_Json, :VC_Valor_Inicial, :VC_Valor_Adicion_1, :VC_Valor_Adicion_2, :VC_Valor_Adicion_3, :VC_Valor_Total_Contrato, :VC_Valor_Pago_Efectuar, :VC_Giros_Efectuados, :VC_Saldo_Pediente, :VC_Valor_Liberar, :FK_Persona_Supervisor, :FK_Persona_Apoyo_Supervisor, :FK_Persona_Apoyo_Supervisor_Dos, :FK_Aprobacion_Administrativo, :FK_Persona_Actualizo, NOW(), 1)');

		@$sentencia->bindParam(':FK_Persona',$objeto->getFkPersona());
		@$sentencia->bindParam(':VC_Numero_Contrato',$objeto->getVcNumeroContrato());
		@$sentencia->bindParam(':VC_Tipo_Identificacion',$objeto->getVcTipoIdentificacion());
		@$sentencia->bindParam(':VC_Identificacion',$objeto->getVcIdentificacion());
		@$sentencia->bindParam(':VC_Ciiu',$objeto->getVcCiiu());
		@$sentencia->bindParam(':VC_Objeto',$objeto->getVcObjeto());
		@$sentencia->bindParam(':VC_Fecha_Inicio',$objeto->getVcFechaInicio());
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
		@$sentencia->bindParam(':VC_Giros_Efectuados',$objeto->getVcGirosEfectuados());
		@$sentencia->bindParam(':VC_Saldo_Pediente',$objeto->getVcSaldoPediente());
		@$sentencia->bindParam(':VC_Valor_Liberar',$objeto->getVcValorLiberar());
		@$sentencia->bindParam(':FK_Persona_Supervisor',$objeto->getFkPersonaSupervisor());
		@$sentencia->bindParam(':FK_Persona_Apoyo_Supervisor',$objeto->getFkPersonaApoyoSupervisor());
		@$sentencia->bindParam(':FK_Persona_Apoyo_Supervisor_Dos',$objeto->getFkPersonaApoyoSupervisordos());
		@$sentencia->bindParam(':FK_Aprobacion_Administrativo',$objeto->getFkAprobacionAdministrativo());
		@$sentencia->bindParam(':FK_Persona_Actualizo',$objeto->getFkPersonaActualizo());
		$sentencia->execute();
		$filasAfectadas = $sentencia->rowCount();
		return $filasAfectadas;
	}

	public function saveInformePagoBasicoAdminLog($basicoId) {

		$sql = 'INSERT INTO db_informe_pago.tb_informe_pago_persona_basico_log (FK_Id_Basico, FK_Persona, VC_Numero_Contrato, VC_Tipo_Identificacion, VC_Identificacion, VC_Ciiu, VC_Nombres_Apellidos_Cedente, VC_Tipo_Identificacion_Cedente, VC_Identificacion_Cendete, VC_Banco, VC_Tipo_Cuenta, VC_Numero_Cuenta, VC_Objeto, VC_Fecha_Inicio, VC_Plazo_Inicial, VC_Prorrogas, VC_Fecha_Plazo_Fin, VC_Fecha_Fin, VC_Numero_Pagos, VC_Pago_Numero, VC_Pago_De_Total, TX_Rp_Json, VC_Valor_Inicial, VC_Valor_Adicion_1, VC_Valor_Adicion_2, VC_Valor_Adicion_3, VC_Valor_Total_Contrato, VC_Valor_Pago_Efectuar, VC_Giros_Efectuados, VC_Saldo_Pediente, VC_Valor_Liberar, VC_Numero_Obligaciones, TX_Obligaciones_Json, TX_Declaracion_Json, VC_Disminucion_Retencion, VC_Tomados_Retencion, VC_Textarea_Producto, FK_Rol, FK_Area, FK_Persona_Supervisor, FK_Persona_Apoyo_Supervisor, FK_Persona_Apoyo_Supervisor_Dos, FK_Aprobacion_Administrativo, FK_Aprobacion, FK_Persona_Actualizo, DA_Actualizo, SM_Activo, IN_Certificado_Final) SELECT PK_Id_Tabla, FK_Persona, VC_Numero_Contrato, VC_Tipo_Identificacion, VC_Identificacion, VC_Ciiu, VC_Nombres_Apellidos_Cedente, VC_Tipo_Identificacion_Cedente, VC_Identificacion_Cendete, VC_Banco, VC_Tipo_Cuenta, VC_Numero_Cuenta, VC_Objeto, VC_Fecha_Inicio, VC_Plazo_Inicial, VC_Prorrogas, VC_Fecha_Plazo_Fin, VC_Fecha_Fin, VC_Numero_Pagos, VC_Pago_Numero, VC_Pago_De_Total, TX_Rp_Json, VC_Valor_Inicial, VC_Valor_Adicion_1, VC_Valor_Adicion_2, VC_Valor_Adicion_3, VC_Valor_Total_Contrato, VC_Valor_Pago_Efectuar, VC_Giros_Efectuados, VC_Saldo_Pediente, VC_Valor_Liberar, VC_Numero_Obligaciones, TX_Obligaciones_Json, TX_Declaracion_Json, VC_Disminucion_Retencion, VC_Tomados_Retencion, VC_Textarea_Producto, FK_Rol, FK_Area, FK_Persona_Supervisor, FK_Persona_Apoyo_Supervisor, FK_Persona_Apoyo_Supervisor_Dos, FK_Aprobacion_Administrativo, FK_Aprobacion, FK_Persona_Actualizo, DA_Actualizo, SM_Activo, IN_Certificado_Final FROM db_informe_pago.tb_informe_pago_persona_basico WHERE PK_Id_Tabla = ';

		if ($basicoId == null )
            $sql = $sql.' LAST_INSERT_ID() '.';';
        else
            $sql = $sql.':FK_Id_Basico'.';';
        $sentencia = $this->dbPDO->prepare($sql);
        if ($basicoId != null )
            @$sentencia->bindParam(':FK_Id_Basico',$basicoId);
        
        $sentencia->execute();
        $filasAfectadas = $sentencia->rowCount();
        return $filasAfectadas;
	}

	public function getListadoInformesBasicos($filtro)
	{

		$sql = "SELECT  tippb.PK_Id_Tabla, tippb.VC_Identificacion,CONCAT(tp2.VC_Primer_Nombre,' ',tp2.VC_Segundo_Nombre,' ',tp2.VC_Primer_Apellido,' ',tp2.VC_Segundo_Apellido) AS 'nombre_contratista',tippb.VC_Numero_Contrato, tippb.FK_Persona FROM db_informe_pago.tb_informe_pago_persona_basico tippb JOIN db_sif_dev.tb_persona_2017 tp2 ON tp2.PK_Id_Persona = tippb.FK_Persona WHERE tippb.SM_Activo = 1";

		$filtroSql = "";
		foreach ($filtro as $key => $value) {
			if ($value != "" && $value != null) {
				if (!(strpos($filtroSql, 'WHERE') !== false)) {
					$filtroSql = $filtroSql." WHERE ";
				}                
				if ($key == "nIdentificacion")
					$filtroSql = $filtroSql." tippb.VC_Identificacion = :nIdentificacion ";

				$filtroSql = $filtroSql."AND";
			}
		}
		$filtroSql = substr($filtroSql, 0,-3).";";
		$sentencia = $this->dbPDO->prepare($sql.$filtroSql);
		if($filtro["nIdentificacion"] != "" && $filtro["nIdentificacion"] != null )
			@$sentencia->bindParam(':nIdentificacion',$filtro["nIdentificacion"]);
		$sentencia->execute(); 

		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

	}

	public function inactivarInformePagoBasico($informe_id, $id_usuario)
	{
		$sql = "UPDATE db_informe_pago.tb_informe_pago_persona_basico IPPB SET IPPB.SM_Activo=0, IPPB.FK_Persona_Actualizo=:id_usuario, DA_Actualizo=NOW() WHERE IPPB.PK_Id_Tabla=:informe_id;";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':informe_id',$informe_id);
		@$sentencia->bindParam(':id_usuario',$id_usuario);
		$sentencia->execute();
		return $sentencia->rowCount();
	}

	public function habilitarCertificadoFinalContrato($objeto){
		$sentencia = $this->dbPDO->prepare('UPDATE db_informe_pago.tb_informe_pago_persona_basico SET IN_Certificado_Final = :IN_Certificado_Final, FK_Persona_Actualizo = :FK_Persona_Actualizo, DA_Actualizo = now() WHERE FK_Persona = :FK_Persona AND SM_Activo = 1;');

		@$sentencia->bindParam(':IN_Certificado_Final',$objeto->getInCertificadoFinal());
		@$sentencia->bindParam(':FK_Persona_Actualizo',$objeto->getFkPersonaActualizo());
		@$sentencia->bindParam(':FK_Persona',$objeto->getFkPersona());
		
		$sentencia->execute();
		$filasAfectadas = $sentencia->rowCount();
		return $filasAfectadas;
	}

}
