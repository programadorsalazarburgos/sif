<?php          
namespace CirculacionNidos\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use CirculacionNidos\Controlador\CirculacionFactory;

class OfertaCirculacionController extends CirculacionFactory
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

	public function crearOfertaDiaria($datos){
		$TbNidosEventoCirculacion = $this->contenedor['TbNidosEventoCirculacion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$TbNidosEventoCirculacion->setInDia($datos['dia_oferta']);
		$TbNidosEventoCirculacion->setDtFechaEvento($datos['fecha_oferta']);
		$TbNidosEventoCirculacion->setVcFranjaAtencion($datos['franja_oferta']);
		$TbNidosEventoCirculacion->setInEstadoEvento(1);
		echo $NidosCirculacionDAO->crearObjetoEvento($TbNidosEventoCirculacion);
	}

	public function getOfertaMensual($idmes, $idusuario){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$oferta = $NidosCirculacionDAO->consultarOfertaMensualGestor($idmes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('oferta'=>$oferta,'userId'=>$idusuario));
		$vista->renderHtml();
	}

	public function consultarTipoEvento(){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$TipoEvento = $NidosCirculacionDAO->consultarTipoEvento();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('TipoEvento'=>$TipoEvento));
		$vista->renderHtml();
	}


	public function getOptionsMes(){
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Poblacional'=>$vista));
		$vista->renderHtml("Reportes");
	}

	public function getOptionsEquiposDisponibles($disponible){
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('disponible'=>$disponible));
		$vista->renderHtml();
	}

	public function reservaEventoGestor($datos){
		$TbNidosEventoCirculacion = $this->contenedor['TbNidosEventoCirculacion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$TbNidosEventoCirculacion->setPkIdEvento($datos['tx_id_evento']);
		$TbNidosEventoCirculacion->setVcNombreEvento($datos['tx_evento_nombre']);
		$TbNidosEventoCirculacion->setFkIdLocalidad($datos['sl_localidad']);
		$TbNidosEventoCirculacion->setFkIdUsuarioSolicita($datos['tx_solicita']);
		$TbNidosEventoCirculacion->setVcEntidadDirigida($datos['tx_entidad']);
		$TbNidosEventoCirculacion->setVcTipoAtencion($datos['sl_tipo_atencion']);
		$TbNidosEventoCirculacion->setFkIdTipoAtencion($datos['sl_atencion']);
		$TbNidosEventoCirculacion->setVcOtroTipoAtencion($datos['tx_otro_lugar']);
		$TbNidosEventoCirculacion->setInSolicitudEquipos($datos['sl_cantidad_equipos']);
		$TbNidosEventoCirculacion->setInEstadoEvento($datos['tx_estado']);
		$TbNidosEventoCirculacion->setInCantidadEquipos($datos['Equipos_Soli']);
		$TbNidosEventoCirculacion->setInNumNinos($datos['tx_ninos']);
		$TbNidosEventoCirculacion->setInNumAdultos($datos['tx_adultos']);
		
		echo $NidosCirculacionDAO->modificarReservaGestor($TbNidosEventoCirculacion);
	}

	public function ConfirmarEventoGestor($datos){
		$TbNidosEventoCirculacion = $this->contenedor['TbNidosEventoCirculacion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		$TbNidosEventoCirculacion->setPkIdEvento($datos['tx_id_evento']);
		$TbNidosEventoCirculacion->setVcNombreEvento($datos['tx_nombre']);
		$TbNidosEventoCirculacion->setFkIdTipoAtencion($datos['sl_atencion']);
		$TbNidosEventoCirculacion->setVcOtroTipoAtencion($datos['tx_otro_lugar']);
		$TbNidosEventoCirculacion->setVcTipoAtencion($datos['sl_tipo_atencion']);
		$TbNidosEventoCirculacion->setVcEntidadDirigida($datos['tx_entidad']);
		$TbNidosEventoCirculacion->setVcContactoLugar($datos['tx_contacto']);
		$TbNidosEventoCirculacion->setInSolicitudInformacion($datos['sl_solicitud']);
		$TbNidosEventoCirculacion->setInTipoPoblacion($datos['sl_poblacion']);
		$TbNidosEventoCirculacion->setInGestorAsiste($datos['sl_gestor']);
		$TbNidosEventoCirculacion->setFkIdLineaAtencion($datos['sl_linea']);
		$TbNidosEventoCirculacion->setVcPropuestaAtencion($datos['tx_propuesta']);
		$TbNidosEventoCirculacion->setvcArtistasLocales($datos['tx_artistas']);
		$TbNidosEventoCirculacion->setVcTransporte($datos['tx_transporte']);  
		$TbNidosEventoCirculacion->setVcContactoTransporte($datos['tx_contacto_trans']);
		$TbNidosEventoCirculacion->setVcHoraLlegadaTransporte($datos['tx_hora_llegada']);
		$TbNidosEventoCirculacion->setVcParticularidadesTerreno($datos['tx_terreno']); 
		$TbNidosEventoCirculacion->setFkIdLugarAtencion($datos['tx_lugar']);
		$TbNidosEventoCirculacion->setVcUbicacion($datos['tx_ubicacion']);
		$TbNidosEventoCirculacion->setVcIndicacionesLlegada($datos['tx_indicaciones']);

		$TbNidosEventoCirculacion->setInNumNinos($datos['tx_ninos_conf']);
		$TbNidosEventoCirculacion->setInNumAdultos($datos['tx_adultos_conf']);

		$TbNidosEventoCirculacion->setInEstadoEvento($datos['tx_estado_modificar']);
		echo $NidosCirculacionDAO->confirmarEventoGestor($TbNidosEventoCirculacion);
	}

	public function consultarMisEventos($idmes, $idusuario){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$oferta = $NidosCirculacionDAO->consultarMisEventoslGestor($idmes, $idusuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('oferta'=>$oferta));
		$vista->renderHtml();
	}

	public function consultarDatosEventoReporte($idEvento){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$ResulEvento = $NidosCirculacionDAO->consultarInformacionEventoAprobado($idEvento);
		echo json_encode($ResulEvento);
	}

	public function getOptionsLAtencion($idLugarEvento){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$lugares = $NidosCirculacionDAO->consultarlugaresAencionDAO($idLugarEvento);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('lugares'=>$lugares));
		$vista->renderHtml();
	}

	public function consultarDatosLugar($idlugarA){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$ResulEvento = $NidosCirculacionDAO->consultarInformacionlugarerDAO($idlugarA);
		echo json_encode($ResulEvento[0]);
	}

	public function crearNuevoLugar($datos){
		$TbNidosLugarAtencion = $this->contenedor['TbNidosLugarAtencion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		$TbNidosLugarAtencion->setPkJardin($datos['pk_id_lugar']);
		$TbNidosLugarAtencion->setFkLocalidad($datos['fk_localidad']);
		$TbNidosLugarAtencion->setFkUpz($datos['fk_upz']);
		$TbNidosLugarAtencion->setVcBarrio($datos['vc_barrio']);
		$TbNidosLugarAtencion->setFkIdEntidad($datos['vc_Entidad']);
		$TbNidosLugarAtencion->setVcTipoLugar($datos['vc_tipo_lugar']);
		$TbNidosLugarAtencion->setVcNombreLugar($datos['vc_nombre_lugar']);
		$TbNidosLugarAtencion->setVcDireccion($datos['vc_direccion']);
		$TbNidosLugarAtencion->setVcEstado(1);

		if($datos["pk_id_lugar"] == ''){
			$TbNidosLugarAtencion->setUsuarioCrea($datos['id_usuario']);
			$TbNidosLugarAtencion->setDtFechaCreacion(date("Y-m-d H:i:s"));
			echo $NidosCirculacionDAO->crearObjetoLugar($TbNidosLugarAtencion);	
		}else{
			echo $NidosCirculacionDAO->modificarObjetoLugar($TbNidosLugarAtencion);		
		}
	}
}
$objControlador = new OfertaCirculacionController();
unset($objControlador);

