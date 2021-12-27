<?php
namespace Reportes\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Reportes\Controlador\ReportesFactory;

class ReporteBeneficiarioArtistaController extends ReportesFactory
{
	/**
	 * @var Container
	 *
	 */
	// private /*static*/ $contenedor;

	function __construct()
	{
		parent::__construct();
		$this->initializeFactory();
		$this->prepareParameters($_POST,$_FILES);
 	}

	public function getOptionsLugares($id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$lugares_usuario = $NidosAsistenciaDAO->consultarLugaresUsuario($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('lugares'=>$lugares_usuario));
		$vista->renderHtml("Beneficiarios");
	}

	public function getOptionsLugaryGrupoArtista($id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$LugaryGrupo = $NidosAsistenciaDAO->consultarLugaryGrupoArtista($id_usuario);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('LugaryGrupo'=>$LugaryGrupo));
		$vista->renderHtml("Beneficiarios");
	}

	public function getAsistenciaBeneficiario($idgrupo){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Asistencia = $NidosReporteAsistenciaDAO->consultarAsistencia_Experiencia($idgrupo);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Asistencia'=>$Asistencia));
		$vista->renderHtml();
	}

	public function consultarEncabezadoExperiencia($Experiencia){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$ResulExperiencia = $NidosReporteAsistenciaDAO->reporteAsistenciaExperienciaEncabezado($Experiencia);
		echo json_encode($ResulExperiencia);
	}

	public function consultarBeneficiariosExperiencia($Experiencia){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$ResulExperiencia = $NidosReporteAsistenciaDAO->reporteAsistenciaExperienciaBeneficiarios($Experiencia);
		echo json_encode($ResulExperiencia);
	}

	public function consultarTotalesExperiencia($Experiencia){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$ResulExperiencia = $NidosReporteAsistenciaDAO->reporteAsistenciaExperienciaTotales($Experiencia);
		echo json_encode($ResulExperiencia);
	}

	public function getOptionsMes()
	{
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Poblacional'=>$vista));
		$vista->renderHtml();
	}

	public function consultarIdDuplaArtista($idUsuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$ResulIdDupla = $NidosReporteAsistenciaDAO->obtenerIdDuplaArtista($idUsuario);
		echo json_encode($ResulIdDupla);
	}

	public function EncabezadoConsolidadoDupla ($IdDupla){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$IdDupla = $NidosReporteAsistenciaDAO->EncabezadoConsolidadoMensualDupla($IdDupla);
		echo json_encode($IdDupla[0]);
	}

	public function getConsolidadoMensualDupla($mes, $IdDupla){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Consolidado = $NidosReporteAsistenciaDAO->ConsolidadoMensualDupla($mes, $IdDupla);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Consolidado'=>$Consolidado));
		$vista->renderHtml();
	}

	public function TotalesConsolidadoDupla ($mes, $IdDupla){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Totales= $NidosReporteAsistenciaDAO->TotalesConsolidadoMensualDupla($mes, $IdDupla);
		echo json_encode($Totales[0]);
	}

/* Consultas PDF reporte mensual  */

public function consultarEncabezadoReporteMensual($IdDupla){
	$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
	$ResulInfoDupla = $NidosReporteAsistenciaDAO->EncabezadoConsolidadoMensualDupla($IdDupla);
	echo json_encode($ResulInfoDupla);
}

public function consultarInfoGruposMes($mes, $IdDupla){
	$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
	$ResulGruposMes = $NidosReporteAsistenciaDAO->ConsolidadoMensualDupla($mes, $IdDupla);
	echo json_encode($ResulGruposMes);
}

public function consultarTotalesGruposPdf($mes, $IdDupla){
	$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
	$ResulTotalesPdf = $NidosReporteAsistenciaDAO->TotalesConsolidadoMensualDupla($mes, $IdDupla);
	echo json_encode($ResulTotalesPdf);
}


}

$objControlador = new ReporteBeneficiarioArtistaController();
unset($objControlador);
