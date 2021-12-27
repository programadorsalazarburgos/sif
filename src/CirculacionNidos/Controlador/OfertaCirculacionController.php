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


	public function getOptionsMes(){
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Poblacional'=>$vista));
		$vista->renderHtml("Reportes");
	}

	public function consultarTipoEvento(){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$TipoEvento = $NidosCirculacionDAO->consultarTipoEvento();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('TipoEvento'=>$TipoEvento));
		$vista->renderHtml();
	}

	public function crearOfertaDiaria($datos){
		$TbNidosEventoCirculacion = $this->contenedor['TbNidosEventoCirculacion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		$TbNidosEventoCirculacion->setInDia($datos['dia_oferta']);
		$TbNidosEventoCirculacion->setDtFechaEvento($datos['fecha_oferta']);
		$TbNidosEventoCirculacion->setVcFranjaAtencion($datos['franja_oferta']);
		$TbNidosEventoCirculacion->setInEstadoEvento(1);
		$TbNidosEventoCirculacion->setInAprobacion(0);
		echo $NidosCirculacionDAO->crearObjetoEvento($TbNidosEventoCirculacion);
	}

	public function consultarOfertaCreada($idmes){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$oferta = $NidosCirculacionDAO->consultarOfertaMensual($idmes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('oferta'=>$oferta));
		$vista->renderHtml();
	}

	public function getOptionsEquipos(){ 
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$equipos = $NidosCirculacionDAO->consultarEquiposCirculacion();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('equipos'=>$equipos));
		$vista->renderHtml();
	}

	public function AprobarEventoCirculacion($datos){
		$TbNidosEventoCirculacion = $this->contenedor['TbNidosEventoCirculacion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		$TbNidosEventoCirculacion->setPkIdEvento($datos['tx_id_evento']);
		$TbNidosEventoCirculacion->setInSolicitudInformacion($datos['sl_solicitud']);                     
		$TbNidosEventoCirculacion->setInTipoPoblacion($datos['sl_poblacion']);                     
		$TbNidosEventoCirculacion->setFkIdTipoAtencion($datos['sl_atencion']);                      
		$TbNidosEventoCirculacion->setFkIdLineaAtencion($datos['sl_linea']);                              
		$TbNidosEventoCirculacion->setVcPropuestaAtencion($datos['tx_propuesta']);                      
		$TbNidosEventoCirculacion->setVcTransporte($datos['tx_transporte']);                      
		$TbNidosEventoCirculacion->setVcContactoTransporte($datos['tx_contac_trans']);                          
		$TbNidosEventoCirculacion->setVcHoraLlegadaTransporte($datos['tx_hora_llegada']);                        
		$TbNidosEventoCirculacion->setVcParticularidadesTerreno($datos['tx_terreno']);                      
		$TbNidosEventoCirculacion->setInCantidadEquipos($datos['tx_equipo']);
		$TbNidosEventoCirculacion->setInFichaTecnica($datos['tx_fichatecnica']);        
		$TbNidosEventoCirculacion->setVcAcompanamientoCirculacion($datos['tx_acompana']);                          
		$TbNidosEventoCirculacion->setVcHoraLlegadaArtistas($datos['tx_llegada']);                             
		$TbNidosEventoCirculacion->setVcHoraMontajeNido($datos['tx_montaje_nido']);               
		$TbNidosEventoCirculacion->setVcHoraInicioAtencion($datos['tx_inicio_aten']);                           
		$TbNidosEventoCirculacion->setVcHoraFinalizacion($datos['tx_fin_aten']);
		$TbNidosEventoCirculacion->setFkIdLugarAtencion($datos['tx_lugar']);
		$TbNidosEventoCirculacion->setVcUbicacion($datos['tx_ubicacion']);
		$TbNidosEventoCirculacion->setVcIndicacionesLlegada($datos['tx_indicaciones']);
		$TbNidosEventoCirculacion->setVcHoraMontaje($datos['tx_hora_montaje']);
		$TbNidosEventoCirculacion->setVcHoraDesmontaje($datos['tx_hora_desmontaje']);
		$TbNidosEventoCirculacion->setInEstadoEvento($datos['tx_estado_modificar']);                           
		echo $NidosCirculacionDAO->AprobarEventoCirculacion($TbNidosEventoCirculacion);
	}

	public function EditarEventoCirculacion($datos){

		$TbNidosEventoCirculacion = $this->contenedor['TbNidosEventoCirculacion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		$TbNidosEventoCirculacion->setPkIdEvento($datos['tx_id_evento']);
		$TbNidosEventoCirculacion->setInDia($datos['tx_dia']);
		$TbNidosEventoCirculacion->setDtFechaEvento($datos['tx_fecha']);
		$TbNidosEventoCirculacion->setVcFranjaAtencion($datos['tx_franja']);

		$TbNidosEventoCirculacion->setVcNombreEvento($datos['tx_nombreevento']);

		if($datos['tx_localidad'] == "")
			$datos['tx_localidad'] = 0;		
		$TbNidosEventoCirculacion->setFkIdLocalidad($datos['tx_localidad']);

		$TbNidosEventoCirculacion->setFkIdLugarAtencion($datos['tx_lugar_atencion']);
		$TbNidosEventoCirculacion->setVcEntidadDirigida($datos['tx_entidad']);
		$TbNidosEventoCirculacion->setFkIdLineaAtencion($datos['tx_linea_atencion']);
		$TbNidosEventoCirculacion->setVcTipoAtencion($datos['tx_tipo_atencion']);
		$TbNidosEventoCirculacion->setInTipoPoblacion($datos['tx_modalidad']);
		$TbNidosEventoCirculacion->setInGestorAsiste($datos['tx_gestor']);
		$TbNidosEventoCirculacion->setVcContactoLugar($datos['tx_contactoL']);
		$TbNidosEventoCirculacion->setFkIdTipoAtencion($datos['sl_atencion']);
		$TbNidosEventoCirculacion->setVcOtroTipoAtencion($datos['tx_otro_lugar']);

		$TbNidosEventoCirculacion->setVcPropuestaAtencion($datos['tx_propuesta']);
		$TbNidosEventoCirculacion->setvcArtistasLocales($datos['tx_artistas']);
		$TbNidosEventoCirculacion->setVcTransporte($datos['tx_transporte']);
		$TbNidosEventoCirculacion->setVcContactoTransporte($datos['tx_contac_trans']);	
		$TbNidosEventoCirculacion->setVcHoraLlegadaTransporte($datos['tx_hora_llegada']);
		$TbNidosEventoCirculacion->setVcParticularidadesTerreno($datos['tx_terreno']);
		$TbNidosEventoCirculacion->setVcUbicacion($datos['tx_ubicacion']);
		$TbNidosEventoCirculacion->setVcIndicacionesLlegada($datos['tx_indicaciones']);

		$TbNidosEventoCirculacion->setInCantidadEquipos($datos['tx_equipo_asignado']);
		
		if($datos['tx_visitatecnica'] == "")
			$datos['tx_visitatecnica'] = 0;	
		$TbNidosEventoCirculacion->setInFichaTecnica($datos['tx_visitatecnica']);

		$TbNidosEventoCirculacion->setVcAcompanamientoCirculacion($datos['tx_acompana']);
		$TbNidosEventoCirculacion->setVcHoraLlegadaArtistas($datos['tx_llegada']);
		$TbNidosEventoCirculacion->setVcHoraMontaje($datos['tx_hora_montaje']);
		$TbNidosEventoCirculacion->setVcHoraMontajeNido($datos['tx_montaje_nido']);
		$TbNidosEventoCirculacion->setVcHoraInicioAtencion($datos['tx_inicio_aten']);
		$TbNidosEventoCirculacion->setVcHoraFinalizacion($datos['tx_fin_aten']);
		$TbNidosEventoCirculacion->setVcHoraDesmontaje($datos['tx_hora_desmontaje']);
		$TbNidosEventoCirculacion->setInNumNinos($datos['tx_ninos']);
		$TbNidosEventoCirculacion->setInNumAdultos($datos['tx_adultos']);

		echo $NidosCirculacionDAO->EditarEventoCirculacion($TbNidosEventoCirculacion);
	}


	public function CancelarEventoCirculacion($datos){
		$TbNidosEventoCirculacion = $this->contenedor['TbNidosEventoCirculacion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		$TbNidosEventoCirculacion->setPkIdEvento($datos['tx_id_evento']);
		$TbNidosEventoCirculacion->setInEstadoEvento($datos['tx_estado_modificar']); 		                 
		echo $NidosCirculacionDAO->CancelarEventoCirculacion($TbNidosEventoCirculacion);
	}
	
	public function consultarDatosEventoReporte($idEvento){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$ResulEvento = $NidosCirculacionDAO->consultarInformacionEventoAprobado($idEvento);
		echo json_encode($ResulEvento);
	}

	public function consultarEquiposReporte($idEvento){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$ResulEvento = $NidosCirculacionDAO->consultarEquiposAprobado($idEvento);
		echo json_encode($ResulEvento);
	}

	public function getReporteMetaCirculacion($id_mes, $id_usuario){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$Datos = $NidosCirculacionDAO->getReporteMetaCirculacion($id_mes, $id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}
}
$objControlador = new OfertaCirculacionController();
unset($objControlador);
