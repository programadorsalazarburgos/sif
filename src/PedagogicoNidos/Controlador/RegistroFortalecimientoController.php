<?php  
namespace PedagogicoNidos\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use PedagogicoNidos\Controlador\PedagogicoFactory;

class RegistroFortalecimientoController extends PedagogicoFactory
{
	/**
	 * @var Container
	 *
	 */
	// private /*static*/ $contenedor;

		function __construct(){
			parent::__construct();
			$this->initializeFactory();
			
	 	}

		public function getNombreEaat($id_usuario){
			 $NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
			 $NombreEaat = $NidosPedagogicoDAO->getEaatTerritorio($id_usuario);
			 echo json_encode($NombreEaat[0]);
	   }

		public function getHoraEvento($id_evento){
			  $NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
			  $HoraEvento = $NidosPedagogicoDAO->ConsultarHoraEventos($id_evento);
			  echo json_encode($HoraEvento[0]);
		}

		public function getArtistasTerritorio($territorio){
			 $NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
			 $artistasTerritorio = $NidosPedagogicoDAO->getArtistasTerritorioDAO($territorio);
			 $vista = $this->contenedor['vista'];
			 $vista->setVariables(array('artistasTerritorio'=>$artistasTerritorio));
			 $vista->renderHtml();
		}

				public function getEquipoCentral($idTipoPersona){
			 $NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
			 $equipoCentral = $NidosPedagogicoDAO->getEquipoCentralDAO($idTipoPersona);
			 $vista = $this->contenedor['vista'];
			 $vista->setVariables(array('equipoCentral'=>$equipoCentral));
			 $vista->renderHtml();
		}


		public function getArtistasLaboratorio($territorio){
			 $NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
			 $artistasLaboratorio = $NidosPedagogicoDAO->getArtistasLaboratorioDAO($territorio);
			 $vista = $this->contenedor['vista'];
			 $vista->setVariables(array('artistasLaboratorio'=>$artistasLaboratorio));
			 $vista->renderHtml();
		}


		public function crearNuevoEvento($datos){
		 	 $TbNidosFortalecimiento = $this->contenedor['TbNidosFortalecimiento'];
		 	 $NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
		 	 $TbNidosFortalecimiento->setfkideaat($datos['eaat']);
		 	 $TbNidosFortalecimiento->setfkidterritorio($datos['localidad']);
		 	 $TbNidosFortalecimiento->setvclugar($datos['lugar']);
		 	 $TbNidosFortalecimiento->setvcnomevento($datos['evento']);
		 	 $TbNidosFortalecimiento->setDtFechaEvento($datos['fecha']);
		 	 $TbNidosFortalecimiento->setdtfecharegistro(date("Y-m-d H:i:s"));
		 	 echo $NidosPedagogicoDAO->crearObjetoEvento($TbNidosFortalecimiento);
		}

		public function crearNuevoFortalecimientoController($datos){
		 	$TbNidosFortalecimiento = $this->contenedor['TbNidosFortalecimiento'];
		 	$NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
			$TbNidosFortalecimiento->setvclugar($datos['Lugar']);
			$TbNidosFortalecimiento->setvcnomevento($datos['Nom_Evento']);
			$TbNidosFortalecimiento->setdtfecharegistro(date("Y-m-d H:i:s"));

			$TbNidosFortalecimiento->setEaatResponsable($datos['Id_Usuario']);
			$TbNidosFortalecimiento->setEaatTerritorio($datos['Territorio']);

  		$TbNidosFortalecimiento->setArtistaArray(json_decode($datos["CH_asistencia_artista"]));
		    echo $NidosPedagogicoDAO->crearObjeto($TbNidosFortalecimiento);
		}

		public function getFortalecimientosTerritorio($id_usuario, $Mes){
			$NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
			$Fortalecimiento = $NidosPedagogicoDAO->consultarFortalecimientosTerritorio($id_usuario, $Mes);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('Fortalecimiento'=>$Fortalecimiento));
			$vista->renderHtml();
		}

		public function getOptionsLugaresLocalidad($id_localidad){
			$NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
			$LPedagogico = $NidosPedagogicoDAO->ConsultarLugaresLocalidad($id_localidad);
			$vista = $this->contenedor['vista'];
			$vista->setVariables(array('LPedagogico'=>$LPedagogico));
			$vista->renderHtml();
		}

		public function getOptionsEventosLugar($id_lugar){
			$NidosPedagogicoDAO = $this->contenedor['NidosPedagogicoDAO'];
			$Eventos = $NidosPedagogicoDAO->ConsultarEventosLugar($id_lugar);
			$vista = $this->contenedor['vista'];
			$vista->setVariables(array('Eventos'=>$Eventos));
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


