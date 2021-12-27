<?php

namespace General\Persistencia\DAOS;


class PsicosocialDAO extends GestionDAO {

	private $dbPDO;

	function __construct()
	{
		$this->dbPDO=$this->obtenerPDOBD();
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

	public function consultarObjeto($texto) {
		return;
	}

	public function saveReporteCaso($objeto){
		$sentencia = $this->dbPDO->prepare('INSERT INTO tb_psico_reporte_casos (FK_Beneficiario,FK_Crea, TX_Linea_Atencion, FK_Grupo, TX_Datos, TX_Origen_Reporte, TX_Descripcion_Hechos, DT_Fecha_Registro, FK_Usuario_Registro, IN_Finalizado) VALUES ( :FK_Beneficiario,:FK_Crea , :TX_Linea_Atencion, :FK_Grupo, :TX_Datos, :TX_Origen_Reporte, :TX_Descripcion_Hechos, :DT_Fecha_Registro, :FK_Usuario_Registro, :IN_Finalizado );');
		@$sentencia->bindParam(':FK_Beneficiario',$objeto->getFkBeneficiario());
		@$sentencia->bindParam(':FK_Crea',$objeto->getFkCrea());
		@$sentencia->bindParam(':TX_Linea_Atencion',$objeto->getTxLineaAtencion());
		@$sentencia->bindParam(':FK_Grupo',$objeto->getFkGrupo());
		@$sentencia->bindParam(':TX_Datos',$objeto->getTxDatos());
		@$sentencia->bindParam(':TX_Origen_Reporte',$objeto->getTxOrigenReporte());
		@$sentencia->bindParam(':TX_Descripcion_Hechos',$objeto->getTxDescripcionHechos());
		@$sentencia->bindParam(':DT_Fecha_Registro',$objeto->getDtFechaRegistro());
		@$sentencia->bindParam(':FK_Usuario_Registro',$objeto->getFkUsuarioRegistro());
		@$sentencia->bindParam(':IN_Finalizado',$objeto->getInFinalizado());
		$sentencia->execute();
		$filasAfectadas = $sentencia->rowCount();
		return $filasAfectadas;
	}

	public function consultarCasosReportados($year){
		$sentencia = $this->dbPDO->prepare("SELECT
			R.PK_Tabla AS 'ID',
			C.VC_Nom_Clan AS 'CREA',
			CASE
			WHEN R.FK_Beneficiario = 0 THEN 'OTRO' 
			WHEN R.FK_Beneficiario != 0 THEN UPPER(CONCAT(E.VC_Primer_Nombre,' ',E.VC_Segundo_Nombre,' ',E.VC_Primer_Apellido,' ',E.VC_Segundo_Apellido))
			END AS 'BENEFICIARIO',
			UPPER(REPLACE(R.TX_Linea_Atencion, '_', ' ')) AS 'LINEA',
			CASE
			WHEN R.TX_Linea_Atencion = 'arte_escuela' THEN CONCAT('AE-',R.FK_Grupo)
			WHEN R.TX_Linea_Atencion = 'emprende_crea' THEN CONCAT('EC-',R.FK_Grupo) 
			WHEN R.TX_Linea_Atencion = 'laboratorio_crea' THEN CONCAT('LC-',R.FK_Grupo) 
			END AS 'GRUPO',
			R.TX_Origen_Reporte AS 'ORIGEN',
			UPPER(CONCAT(U.VC_Primer_Nombre,' ',U.VC_Segundo_Nombre,' ',U.VC_Primer_Apellido,' ',U.VC_Segundo_Apellido)) AS 'USUARIO',
			R.DT_Fecha_Registro AS 'FECHA_REGISTRO'
			FROM tb_psico_reporte_casos R
			LEFT JOIN tb_estudiante E ON E.id=R.FK_Beneficiario
			JOIN tb_clan C ON R.FK_Crea=C.PK_Id_Clan
			JOIN tb_persona_2017 U ON R.FK_Usuario_Registro = U.PK_Id_Persona
			WHERE YEAR(R.DT_Fecha_Registro) = :year");
		@$sentencia->bindParam(':year',$year);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
}