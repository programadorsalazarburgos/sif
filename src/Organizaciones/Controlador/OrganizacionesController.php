<?php
namespace Organizaciones\Controlador;
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once "../Vendor/autoload.php";
use Organizaciones\Controlador\OrganizacionesFactory;


class OrganizacionesController extends OrganizacionesFactory
{
	/**
	 * @var Container
	 *
	 */
	//private /*static*/ $contenedor;
	private $userId;
	private $rolId;

	function __construct()
	{

		parent::__construct();
		/*session_start();*/
		/*$this->userId = $_SESSION["session_username"];
		$this->rolId = $_SESSION['session_usertype'];*/
		$this->initializeFactory();
	}
	public function getLastApprovedProyeccionPk($datos)
	{
		$OrganizacionesProyeccionGastoDAO = $this->contenedor['OrganizacionesProyeccionGastoDAO'];
		$TbOrganizacionesProyeccionGasto = $this->contenedor['TbOrganizacionesProyeccionGasto'];
		$TbOrganizacionesProyeccionGasto->setFkOrganizacionId($datos["idOrganizacion"]); 
		$TbOrganizacionesProyeccionGasto->setFkIdSeguimientoPropuesta($datos["idSeguimientoPropuesta"]); 
		$lastApprovedProyeccionPk = $OrganizacionesProyeccionGastoDAO->getLastApprovedProyeccionPk($TbOrganizacionesProyeccionGasto);
		echo json_encode($lastApprovedProyeccionPk);
	}
}
