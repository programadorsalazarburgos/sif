<?php 
namespace PedagogicoNidos\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use PedagogicoNidos\Controlador\PedagogicoFactory;

class ReporteFAPController extends PedagogicoFactory
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
 	}

	public function getConsolidadoFAP($MesC){
		$NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
		$ConsolidadoFAP= $NidosPedagogicoDAO->consultarConsolidadoReporteFAP($MesC);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('ConsolidadoFAP'=>$ConsolidadoFAP));
		$vista->renderHtml();
	}

	public function getTerritorios(){
		$NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
		$Territorios= $NidosPedagogicoDAO->consultarTerritoriosNidos();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Territorios'=>$Territorios));
		$vista->renderHtml();
	}

	public function getLocalidades(){
		$NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
		$Localidades= $NidosPedagogicoDAO->consultarLocalidadesNidos();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Localidades'=>$Localidades));
		$vista->renderHtml();
	}

	public function getDetalladoFAPLocalidad($MesD, $Localidad){
		$NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
		$FAPLocalidad= $NidosPedagogicoDAO->consultarReporteFAPLocalidad($MesD, $Localidad);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('FAPLocalidad'=>$FAPLocalidad));
		$vista->renderHtml();
	}

	public function getDetalladoFAP($MesD, $Territorio){
		$NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
		$DetalladoFAP= $NidosPedagogicoDAO->consultarDetalladoReporteFAP($MesD, $Territorio);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('DetalladoFAP'=>$DetalladoFAP));
		$vista->renderHtml();
	}

	public function consultarEncabezadoFortalecimiento($idFortalecimiento){
			$NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
			$ResulFortalecimiento = $NidosPedagogicoDAO->reporteFortalecimientoEncabezado($idFortalecimiento);
			echo json_encode($ResulFortalecimiento);
	}

	public function consultarArtistasFortalecimiento($idFortalecimiento){
			$NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
			$ResulFortalecimiento = $NidosPedagogicoDAO->reporteAsistenciaFortalecimientoArtista($idFortalecimiento);
			echo json_encode($ResulFortalecimiento);
	}


}
