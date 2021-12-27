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

	public function ConsolidadoTotalLaboratoriosMes($mes, $tipo){
			$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
			if ($tipo == 1) {
			 	$TotalLaboratorios = $NidosConsultaGeneralDAO->ConsolidadoLaboratoriosAtencionRealMes($mes);				
			}else{
				$TotalLaboratorios = $NidosConsultaGeneralDAO->ConsolidadoLaboratoriosEIntervencionesMes($mes);
			}
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('TotalLaboratorios'=>$TotalLaboratorios));
			$vista->renderHtml();
	}

		public function ConsolidadoGruposComunidadMes($mes, $tipo){
			$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
			if ($tipo == 1) {			
				$TotalLaboratorios = $NidosConsultaGeneralDAO->ConsolidadoGruposComunidadAtencionRealMes($mes);				
			}else{
				$TotalLaboratorios = $NidosConsultaGeneralDAO->ConsolidadoGruposComunidadNuevosMes($mes);
			}
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('TotalLaboratorios'=>$TotalLaboratorios));
			$vista->renderHtml();
	}


}

$objControlador = new EncuentrosGrupalestotalController();
unset($objControlador);
