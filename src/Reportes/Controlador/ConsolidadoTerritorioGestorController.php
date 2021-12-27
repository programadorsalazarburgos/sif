<?php
namespace Reportes\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Reportes\Controlador\ReportesFactory;

class ConsolidadoTerritorioGestorController extends ReportesFactory
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

	 public function ConsultarDuplasTerritorio($id_usuario)
   {
     $NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
     $Consulta_Duplas = $NidosConsultaGeneralDAO->consultarDuplasTerritorios($id_usuario);
     $vista= $this->contenedor['vista'];
     $vista->setVariables(array('ConsultaDuplas'=>$Consulta_Duplas));
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

/* -------   INFORMACIÓN DEL TERRITORIO GESTOR   */

	public function consultarDatosTerritorioGestor($id_dupla){
    $NidosConsultaGeneralDAO = $this->contenedor['NidosConsultaGeneralDAO'];
  	 $grupo1 = $NidosConsultaGeneralDAO->contarGruposDupla($id_dupla['id_dupla'])[0]['total_grupos1'];
  	 $experiencia = $NidosConsultaGeneralDAO->contarExperienciasDupla($id_dupla['id_dupla'])[0]['total_experiencia'];
  	 $beneficiario = $NidosConsultaGeneralDAO->contarBeneficiariosDupla($id_dupla['id_dupla'])[0]['total_beneficiarios'];
     $artistas = $NidosConsultaGeneralDAO->consultarArtistasDuplas($id_dupla['id_dupla'])[0]['ARTISTAS'];
     $tablainfo = $NidosConsultaGeneralDAO->contultaTablaGruposDupla($id_dupla['id_dupla']);

     $vista = $this->contenedor['vista'];
  	 $vista->setVariables(array('id_dupla'=>$id_dupla['id_dupla'],'total_grupos1'=>$grupo1,'total_experiencia'=>$experiencia,'total_beneficiarios'=>$beneficiario,'ARTISTAS'=>$artistas,'tablainfo'=>$tablainfo));
  	 $vista->renderHtml();
	}

}

$objControlador = new ConsolidadoTerritorioGestorController();
unset($objControlador);
