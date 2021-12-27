<?php
namespace Reportes\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Reportes\Controlador\ReportesFactory;

class ConsultaEncuentrosGrupalesController extends ReportesFactory
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
	public function ConsultarDuplasTerritoriales($id_usuario){
		$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
		$Consulta_Duplas = $NidosConsultaGeneralDAO->consultarDuplasTerritoriales($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('ConsultaDuplas'=>$Consulta_Duplas));
		$vista->renderHtml();
	}

	public function getNombreTerritorio($id_usuario){
			$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
			$nombre_terri = $NidosConsultaGeneralDAO->ConsultarNomTerritorio($id_usuario);
			echo json_encode($nombre_terri[0]);
	}

	public function consultarInfoDuplaEncuentros($id_dupla, $mes){
     $NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
		 $grupo1 = $NidosConsultaGeneralDAO->contarGruposAtendidosMes($id_dupla['id_dupla'], $mes)[0]['GRUPOS'];
  	 $experiencia = $NidosConsultaGeneralDAO->contarAtencionesMes($id_dupla['id_dupla'], $mes)[0]['ATENCIONES'];
  	 $beneficiario = $NidosConsultaGeneralDAO->contarBeneficiariosMes($id_dupla['id_dupla'], $mes)[0]['BENEFICIARIOS'];
		 $artistas = $NidosConsultaGeneralDAO->consultarArtistasDuplas($id_dupla['id_dupla'])[0]['ARTISTAS'];
     $tablainfo = $NidosConsultaGeneralDAO->contultaTablaGruposLinea($id_dupla['id_dupla'], $mes);
		 $tablainfolugares = $NidosConsultaGeneralDAO->InfoAtencionesXlugarDupla($id_dupla['id_dupla'], $mes);
     $vista = $this->contenedor['vista'];
  	 $vista->setVariables(array('id_dupla'=>$id_dupla['id_dupla'],'GRUPOS'=>$grupo1,'ATENCIONES'=>$experiencia,'BENEFICIARIOS'=>$beneficiario,'ARTISTAS'=>$artistas,'tablainfo'=>$tablainfo,'tablainfolugares'=>$tablainfolugares));
  	 $vista->renderHtml();
	}

	public function consultarConsolidadoFamiliar($id_usuario, $mes){
		$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
		$entornoFamiliar = $NidosConsultaGeneralDAO->ConsolidadoEntornoFamiliarTerritorio($id_usuario, $mes);
		$entornoInstitucional = $NidosConsultaGeneralDAO->ConsolidadoEntornoInstitucionalTerritorio($id_usuario, $mes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('entornoFamiliar'=>$entornoFamiliar,'entornoInstitucional'=>$entornoInstitucional ));
		$vista->renderHtml();
	}


	public function consultarConsolidadoLaboratorios($id_usuario, $mes)	{
		$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
		$laboratoriosIntervenciones = $NidosConsultaGeneralDAO->ConsolidadoLaboratoriosEIntervencionesTerritorio($id_usuario, $mes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('laboratoriosIntervenciones'=>$laboratoriosIntervenciones));
		$vista->renderHtml();
	}
			public function ConsolidadoGestorTerritorioUPZMes($mes, $id_territorio){
				$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
				$TotalEncuentrosUpz = $NidosConsultaGeneralDAO->ConsolidadoGestorTerritorioUPZDao($mes, $id_territorio);
				$vista= $this->contenedor['vista'];
				$vista->setVariables(array('TotalEncuentrosUpz'=>$TotalEncuentrosUpz));
				$vista->renderHtml();
			}

			public function ConsolidadoGestorTerritorioLaboratoriosMes($mes, $id_territorio){
				$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
				$TotalLaboratorios = $NidosConsultaGeneralDAO->ConsolidadoGestorTerritorioLaboratoriosDao($mes, $id_territorio);
				$vista= $this->contenedor['vista'];
				$vista->setVariables(array('TotalLaboratorios'=>$TotalLaboratorios));
				$vista->renderHtml();
			}

			public function ConsolidadoAtencionRealTerritorioMes($mes, $id_territorio){
				$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
				$TotalLaboratorios = $NidosConsultaGeneralDAO->ConsolidadoGestorAtencionRealDao($mes, $id_territorio);
				$vista= $this->contenedor['vista'];
				$vista->setVariables(array('TotalLaboratorios'=>$TotalLaboratorios));
				$vista->renderHtml();
			}

			public function ConsolidadoBeneficiariosAtendidosMes($mes, $id_territorio){
				$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
				$Beneficiarios = $NidosConsultaGeneralDAO->ConsolidadoBeneficiariosAtendidosMesDao($mes, $id_territorio);
				$vista= $this->contenedor['vista'];
				$vista->setVariables(array('Beneficiarios'=>$Beneficiarios));
				$vista->renderHtml();
			}
}

$objControlador = new ConsultaEncuentrosGrupalesController();
unset($objControlador);
