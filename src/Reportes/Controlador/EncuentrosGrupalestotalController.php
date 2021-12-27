<?php
namespace Reportes\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Reportes\Controlador\ReportesFactory;

class EncuentrosGrupalestotalController extends ReportesFactory
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

	public function getMesParametro(){
		$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
		$MesParametro = $NidosConsultaGeneralDAO->consultarMesParametro();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('MesParametro'=>$MesParametro));
		$vista->renderHtml();
	}

	public function getOptionsTerritorio(){
		$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
		$Territorio = $NidosConsultaGeneralDAO->consultarTerritorios();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Territorio'=>$Territorio));
		$vista->renderHtml();
	}

	public function ConsolidadoTotalEncuentrosgGrupalesL_A($mes){
		$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
		$entornoFamiliar = $NidosConsultaGeneralDAO->ConsolidadoEncuentrosGTotalFamiliar($mes);
		$entornoInstitucional = $NidosConsultaGeneralDAO->ConsolidadoEncuentrosGTotalInstitucional($mes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('entornoFamiliar'=>$entornoFamiliar,'entornoInstitucional'=>$entornoInstitucional ));
		$vista->renderHtml();
	}

	public function ConsolidadoTotalEncuentrosGrupalesUPZ($mes){
		$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
		$TotalEncuentrosUpz = $NidosConsultaGeneralDAO->ConsolidadoTotalEncuentrosGrupalesUPZDao($mes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('TotalEncuentrosUpz'=>$TotalEncuentrosUpz));
		$vista->renderHtml();
	}

	public function ConsultaAtencionesTerritorioCoordinador($Territorio, $mes){
		$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
		$entornoFamiliarCoordinador = $NidosConsultaGeneralDAO->EntornoFamiliarTerritorioRolCoordinadorT($Territorio, $mes);
		$entornoInstitucionalCoordinador = $NidosConsultaGeneralDAO->EntornoInstitucionalTerritorioRolCoordinadorT($Territorio, $mes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('entornoFamiliarCoordinador'=>$entornoFamiliarCoordinador, 'entornoInstitucionalCoordinador'=>$entornoInstitucionalCoordinador));
		$vista->renderHtml();
	}

		public function ConsolidadoTotalLaboratoriosMes($mes){
			$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
			$TotalLaboratorios = $NidosConsultaGeneralDAO->ConsolidadoLaboratoriosEIntervencionesMes($mes);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('TotalLaboratorios'=>$TotalLaboratorios));
			$vista->renderHtml();
		}

		public function MetasEncuentrosArtisticos($mes){
			$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
			$MetaEncuentros = $NidosConsultaGeneralDAO->Meta1EncuentrosGrupales($mes);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('MetaEncuentros'=>$MetaEncuentros));
			$vista->renderHtml();
		}
}

$objControlador = new EncuentrosGrupalestotalController();
unset($objControlador);
