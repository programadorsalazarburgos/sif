<?php 
namespace Reportes\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Reportes\Controlador\ReportesFactory;

class ConsultaGeneralController extends ReportesFactory
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

  public function getConsultarTerritorios()
  {
    $NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
    $Consulta_Territorios = $NidosConsultaGeneralDAO->consultarTerritorios();
    $vista= $this->contenedor['vista'];
    $vista->setVariables(array('ConsultaTerritorios'=>$Consulta_Territorios));
    $vista->renderHtml();
  }

	public function consultarDatosCompletosTerritorio($id_territorio){
 	 $NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
 	 $dupla = $NidosConsultaGeneralDAO->contarDuplasTerritorio($id_territorio['id_territorio'])[0]['total_duplas'];
 	 $grupo = $NidosConsultaGeneralDAO->contarGruposTerritorio($id_territorio['id_territorio'])[0]['total_grupos'];
 	 $lugar = $NidosConsultaGeneralDAO->contarLugaresAtencionTerritorio($id_territorio['id_territorio'])[0]['total_lugares'];
   $beneficiario = $NidosConsultaGeneralDAO->contarBeneficiariosTerritorio($id_territorio['id_territorio'])[0]['total_beneficiarios'];
 	 $vista = $this->contenedor['vista'];
 	 $vista->setVariables(array('total_duplas'=>$dupla,'total_grupos'=>$grupo,'total_lugares'=>$lugar,'total_beneficiarios'=>$beneficiario));
 	 $vista->renderHtml();
  }
  public function consultarDatosDetalladosTerritorio($id_territorio, $tipo_consulta){
    $NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
    $vista = $this->contenedor['vista'];
    switch ($tipo_consulta) {
    case 0:
        $lugares = $NidosConsultaGeneralDAO->infoLugaresTerritorio($id_territorio);
        $vista->setVariables(array('info_data'=>$lugares));
        break;
    case 1:
        $duplas = $NidosConsultaGeneralDAO->infoDuplasTerritorio($id_territorio);
        $vista->setVariables(array('info_data'=>$duplas));
        break;
    case 2:
        $grupos = $NidosConsultaGeneralDAO->infoGruposTerritorio($id_territorio);
        $vista->setVariables(array('info_data'=>$grupos));
        break;
    case 3:
        $beneficiarios = $NidosConsultaGeneralDAO->infoBeneficiariosTerritorio($id_territorio);
        $vista->setVariables(array('info_data'=>$beneficiarios));
        break;
    }
  	$vista->renderHtml();
  }

  public function getReportePandoraTerritorial($id_mes){
		$NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
		$Datos = $NidosConsultaGeneralDAO->getReportePandoraTerritorial($id_mes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}
}

$objControlador = new ConsultaGeneralController();
unset($objControlador);
