<?php
namespace Territorial\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Territorial\Controlador\TerritorialFactory;


class CambiarDuplaGruposController extends TerritorialFactory
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

	 	public function getOptionsDuplasTerritorios($parametro){
			$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
			$Duplas = $NidosDuplasDAO->consultaDuplasTerritorio($parametro);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('Duplas'=>$Duplas));
			$vista->renderHtml();
		}

		public function getGruposDuplaCambiar($id_dupla){
			$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
			$Grupos = $NidosDuplasDAO->consultaGruposDupla($id_dupla);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('Grupos'=>$Grupos));
			$vista->renderHtml();
		}


		public function cambiarGruposDupla($datos){
    	$TbNidosGrupos = $this->contenedor['TbNidosGrupos'];
			$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];

			$TbNidosGrupos->setFkIdDupla($datos['Dupla_Nueva']);
			$TbNidosGrupos->setIdGrupo(json_decode($datos["CH_grupos_cambiar"]));

			echo $NidosDuplasDAO->modificarGruposDupla($TbNidosGrupos);
		}

}

$objControlador = new CambiarDuplaGruposController();
unset($objControlador);
