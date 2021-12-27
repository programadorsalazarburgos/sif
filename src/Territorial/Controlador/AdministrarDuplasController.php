<?php
namespace Territorial\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Territorial\Controlador\TerritorialFactory;

class AdministrarDuplasController extends TerritorialFactory
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


 	public function crearNuevaDupla($datos){
 		$TbNidosDupla = $this->contenedor['TbNidosDupla'];
 		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$TbNidosDupla->setTipoDupla($datos['tipo_dupla']);
		$TbNidosDupla->setCodigoDupla($datos['codigo_dupla']);
 		$TbNidosDupla->setFkIdTerritorio($datos['fk_id_territorio']);
		$TbNidosDupla->setArtistasDupla($datos['Artistas']);
 		$TbNidosDupla->setFkIdGestor($datos['fk_id_gestor']);
		$TbNidosDupla->setInEstado(1);
		$TbNidosDupla->setDtFechaCreacion(date("Y-m-d H:i:s"));
    echo $NidosDuplasDAO->crearObjeto($TbNidosDupla);
 	}

	public function modificarDupla($datos){
		$TbNidosDupla = $this->contenedor['TbNidosDupla'];
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$TbNidosDupla->setPkIdDupla($datos['fk_id_dupla_Modificar']);
		$TbNidosDupla->setTipoDupla($datos['tipo_dupla_Modificar']);
		$TbNidosDupla->setCodigoDupla($datos['codigo_dupla_Modificar']);
		$TbNidosDupla->setArtistasDupla($datos['Artistas_Modificar']);
		echo $NidosDuplasDAO->modificarObjetoDupla($TbNidosDupla);
	}

	public function getOptionsDuplas(){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$tipoDuplas= $NidosDuplasDAO->consultarTipoDupla();
  	$vista= $this->contenedor['vista'];
		$vista->setVariables(array('tipoDuplas'=>$tipoDuplas));
		$vista->renderHtml();
	}

	public function getOptionsTerritorios($id_usuario){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$Territorio = $NidosDuplasDAO->consultarTerritorio($id_usuario);
		echo json_encode($Territorio[0]);
	}

	public function getOptionsArtistas($id_dupla){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$Artistas= $NidosDuplasDAO->consultarArtistas($id_dupla);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Artistas'=>$Artistas));
		$vista->renderHtml("Beneficiarios");
	}

	public function getOptionsGestores(){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$Gestor= $NidosDuplasDAO->consultarGestores();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Gestor'=>$Gestor));
		$vista->renderHtml();
	}

	public function getDuplasCreadas($id_usuario){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$duplas_guardados = $NidosDuplasDAO->consultarDuplasGuardadas($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('duplas'=>$duplas_guardados));
		$vista->renderHtml();
	}

	public function getDuplasTerritorio($id_usuario){
		$NidosLugaresDAO = $this->contenedor['NidosDuplasDAO'];
		$total_lugares = $NidosLugaresDAO->TotalDuplasTerritorio($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('total'=>$total_lugares));
		$vista->renderHtml();
	}

	public function getConsultarDuplaM($id_usuario){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$Consulta_duplasM = $NidosDuplasDAO->ConsultarDuplasM($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('ConsultaDuplaM'=>$Consulta_duplasM));
		$vista->renderHtml();
	}

	public function consultarDatosCompletosDupla($datos){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$TbNidosDupla = $this->contenedor['TbNidosDupla'];
		$TbNidosDupla->setPkIdDupla($datos['id_dupla']);
		$datos_dupla = $NidosDuplasDAO->consultarDuplaModificar($TbNidosDupla->getPkIdDupla());
		echo json_encode($datos_dupla[0]);
	}

	public function consultarDatosArtistasDupla($id_dupla){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$TbNidosDupla = $this->contenedor['TbNidosDupla'];
		$TbNidosDupla->setPkIdDupla($id_dupla['id_dupla']);
		$datos_artista = $NidosDuplasDAO->ConsultarArtistasDupla($TbNidosDupla->getPkIdDupla());
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos_artista'=>$datos_artista));
		$vista->renderHtml();
	}

	public function InactivarArtista($datos){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$TbNidosDupla = $this->contenedor['TbNidosDupla'];
		$TbNidosDupla->setPkIdDupla($datos['Id_Artista_Inactivar']);
		$TbNidosDupla->setInEstado(2);
		$TbNidosDupla->setDtFechaCreacion(date("Y-m-d H:i:s"));
		echo $NidosDuplasDAO->InactivarArtistaObjeto($TbNidosDupla);
	}

	public function ActivarArtista($datos){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$TbNidosDupla = $this->contenedor['TbNidosDupla'];
		$TbNidosDupla->setPkIdDupla($datos['Id_Artista_Activar']);
		$TbNidosDupla->setInEstado(1);
		$TbNidosDupla->setDtFechaCreacion(date("Y-m-d H:i:s"));
		echo $NidosDuplasDAO->ActivarArtistaObjeto($TbNidosDupla);
	}

 	public function getNombreGestor($id_usuario){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$NombreGestor = $NidosDuplasDAO->consultaNombreGestor($id_usuario);
		echo json_encode($NombreGestor[0]);
 	}

}

$objControlador = new AdministrarDuplasController();
unset($objControlador);
