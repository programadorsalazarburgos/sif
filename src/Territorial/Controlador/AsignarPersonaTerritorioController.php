<?php
namespace Territorial\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Territorial\Controlador\TerritorialFactory;

class AsignarPersonaTerritorioController extends TerritorialFactory
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

    public function getUsuariosNidos(){
      $NidosPersonaTerritorioDAO = $this->contenedor['NidosPersonaTerritorioDAO'];
      $usuariosNidos = $NidosPersonaTerritorioDAO->consultarUsuariosNidos();
      $vista= $this->contenedor['vista'];
      $vista->setVariables(array('usuarios'=>$usuariosNidos));
      $vista->renderHtml();
    }

		public function getInformacionUsusario($idUsuario){
			$NidosPersonaTerritorioDAO = $this->contenedor['NidosPersonaTerritorioDAO'];
			$informacionUsuario = $NidosPersonaTerritorioDAO->consultarInformacionUsuario($idUsuario);
			echo json_encode($informacionUsuario);
		}

		public function getTerritorioUsuario($idUsuario){
			$NidosPersonaTerritorioDAO = $this->contenedor['NidosPersonaTerritorioDAO'];
			$territorioUsuario = $NidosPersonaTerritorioDAO->consultarTerritorioUsuario($idUsuario);
			echo json_encode($territorioUsuario);
		}
		public function getOptionsTerritorios(){
			$NidosPersonaTerritorioDAO = $this->contenedor['NidosPersonaTerritorioDAO'];
			$territorios = $NidosPersonaTerritorioDAO->consultarTerritorios();
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('Territorio'=>$territorios));
			$vista->renderHtml();
		}
		public function asignarTerritorio($datos){
			$TbNidosPersonaTerritorio = $this->contenedor['TbNidosPersonaTerritorio'];
			$NidosPersonaTerritorioDAO = $this->contenedor['NidosPersonaTerritorioDAO'];
			$TbNidosPersonaTerritorio->setFkIdPersona($datos['fk_id_persona']);
			$TbNidosPersonaTerritorio->setFkIdTerritorio($datos['fk_id_territorio']);

			echo $NidosPersonaTerritorioDAO->crearObjeto($TbNidosPersonaTerritorio);
		}
		public function actualizarTerritorio($datos){
		$TbNidosPersonaTerritorio = $this->contenedor['TbNidosPersonaTerritorio'];
		$NidosPersonaTerritorioDAO = $this->contenedor['NidosPersonaTerritorioDAO'];

		$TbNidosPersonaTerritorio->setIdPersonTerrito($datos['pk_id_person_territo']);
		$TbNidosPersonaTerritorio->setFkIdPersona($datos['fk_id_persona']);
		$TbNidosPersonaTerritorio->setFkIdTerritorio($datos['fk_id_territorio']);

		echo $NidosPersonaTerritorioDAO->modificarObjeto($TbNidosPersonaTerritorio);
		}

		public function getUsuariosTerritorio($idsTerritorio){
			$NidosPersonaTerritorioDAO = $this->contenedor['NidosPersonaTerritorioDAO'];
			$usuariosTerritorio = $NidosPersonaTerritorioDAO->consultarUsuariosTerritorio($idsTerritorio);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('usuarios'=>$usuariosTerritorio));
			$vista->renderHtml();
		}
}

$objControlador = new AsignarPersonaTerritorioController();
unset($objControlador);
