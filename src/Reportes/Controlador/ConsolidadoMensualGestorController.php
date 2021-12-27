<?php  
namespace Reportes\Controlador;
error_reporting(E_ALL); 
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Reportes\Controlador\ReportesFactory;

class ConsolidadoMensualGestorController extends ReportesFactory
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

	public function getConsultarDuplaM($id_usuario){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$Consulta_duplasM = $NidosDuplasDAO->ConsultarDuplasM($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('ConsultaDuplaM'=>$Consulta_duplasM));
		$vista->renderHtml("Territorial");
	}

	public function getOptionsMes()
	{
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Poblacional'=>$vista));
		$vista->renderHtml();
	}

	public function getOptionsTipoGrupo()
	{
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('TGrupo'=>$vista));
		$vista->renderHtml();
	}

	public function getConsolidadoMensualGestor($id_dupla, $mes){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$consolidado = $NidosReporteAsistenciaDAO->ConsultaConsolidadoGestor($id_dupla, $mes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('consolidado'=>$consolidado));
		$vista->renderHtml();
	}

 	public function AprobarExperiencia($datos){
 		$TbNidosExperiencia = $this->contenedor['TbNidosExperiencia'];
 		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$TbNidosExperiencia->setPkIdExperiencia($datos['Id_Experiencia']);
		$TbNidosExperiencia->setInAprobacion(1);
		$TbNidosExperiencia->setFechaAprobacion(date("Y-m-d H:i:s"));
    echo $NidosReporteAsistenciaDAO->aprobarExperienciaDAO($TbNidosExperiencia);
 	}
	/* Consultas PDF reporte mensual  */
	public function consultarEncabezadoReporteMensual($IdDupla){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$ResulInfoDupla = $NidosReporteAsistenciaDAO->EncabezadoConsolidadoMensualDupla($IdDupla);
		echo json_encode($ResulInfoDupla);
	}
	/* Consultas PDF reporte mensual Cuerpo  */
	public function consultarTotalAtencionesMensualPdf($IdDupla, $mes, $mes_anterior){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$ResulInfoDupla = $NidosReporteAsistenciaDAO->ConsolidadoMensualDuplaPdf($IdDupla, $mes, $mes_anterior);
		echo json_encode($ResulInfoDupla);
	}
	/* Consultas PDF reporte mensual Cuerpo  */
	public function consultarTotalAtencionesMensualCifrasPdf($IdDupla, $mes, $mes_anterior){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$ResulInfoDupla = $NidosReporteAsistenciaDAO->ConsolidadoMensualDuplaCifrasPdf($IdDupla, $mes, $mes_anterior);
		echo json_encode($ResulInfoDupla);
	}
	/* Consultas PDF reporte mensual Cuerpo  */
	public function consultarTotalesMensualPdf($IdDupla, $mes){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$ResulInfoDupla = $NidosReporteAsistenciaDAO->TotalesMensualDuplaPdf($IdDupla, $mes);
		echo json_encode($ResulInfoDupla);
	}

	public function consultarBeneficiariosNuevos($beneficiarios){			
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Beneficiarios = $NidosReporteAsistenciaDAO->consultarBeneficiariosNuevosGrupo($beneficiarios);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Beneficiarios'=>$Beneficiarios));
		$vista->renderHtml();
	}

	public function consultarTotalExperienciasMes($id_mes, $id_usuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$IdExperiencia = $NidosReporteAsistenciaDAO->consultarTotalExperienciasMes($id_mes, $id_usuario);
		echo json_encode($IdExperiencia[0]);
	}
	
	public function getExperienciasDupla($id_mes, $id_usuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Datos = $NidosReporteAsistenciaDAO->getExperienciasDupla($id_mes, $id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}

	/********  CONSULTAS CONSOLIDADO TERRITORIO  *************/
	
	public function ConsultarTotalesTerritorio($id_usuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$nombre_terri = $NidosReporteAsistenciaDAO->ConsultarTotalesTerritorio($id_usuario);
		echo json_encode($nombre_terri[0]);
	}

	public function ConsultarTotalesMensualesTerritorio($id_usuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Datos = $NidosReporteAsistenciaDAO->ConsultarTotalesMensualesTerritorio($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}

	public function ConsultarTotalesMensualesEntidades($id_usuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Datos = $NidosReporteAsistenciaDAO->ConsultarTotalesMensualesEntidades($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}	

	public function ConsultarTotalesDuplaTerritorio($id_usuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Datos = $NidosReporteAsistenciaDAO->ConsultarTotalesDuplaTerritorio($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}

	public function ConsultarTotalesLugarTerritorio($id_usuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Datos = $NidosReporteAsistenciaDAO->ConsultarTotalesLugarTerritorio($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}

	public function ConsultarPandoraTerritorio($id_usuario,$mes_consulta,$mes_anterior){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Datos = $NidosReporteAsistenciaDAO->ConsultarPandoraTerritorio($id_usuario,$mes_consulta,$mes_anterior);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}

	public function getBeneficiariosEnfoque($idExpeEnfoque){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Datos = $NidosReporteAsistenciaDAO->getBeneficiariosEnfoque($idExpeEnfoque);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}

	public function ConsultarTotalesEntidadTerritorio($id_usuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$nombre_terri = $NidosReporteAsistenciaDAO->ConsultarTotalesEntidadTerritorio($id_usuario);
		echo json_encode($nombre_terri[0]);
	}

	public function ConsultarListadoBeneficiariosTerritorio($id_usuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$Datos = $NidosReporteAsistenciaDAO->ConsultarListadoBeneficiariosTerritorio($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}

	public function consultarExperienciaLugarDupla($id_mes, $id_usuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$lugares_guardados = $NidosReporteAsistenciaDAO->consultarExperienciaLugarDupla($id_mes, $id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('lugares'=>$lugares_guardados));
		$vista->renderHtml();
	}

	public function consultarExperienciaLaboratorioDupla($id_mes, $id_usuario){
		$NidosReporteAsistenciaDAO = $this->contenedor['NidosReporteAsistenciaDAO'];
		$lugares_guardados = $NidosReporteAsistenciaDAO->consultarExperienciaLaboratorioDupla($id_mes, $id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('lugares'=>$lugares_guardados));
		$vista->renderHtml();
	}
 
}

$objControlador = new ConsolidadoMensualGestorController();
unset($objControlador);
