<?php  
namespace CirculacionNidos\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use CirculacionNidos\Controlador\CirculacionFactory;

class AtencionesVirtualesController extends CirculacionFactory
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
		$TbNidosAtencionesVirtuales = $this->contenedor['TbNidosHorariosAtencion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		$TbNidosAtencionesVirtuales->setInIdFormulario($datos['formulario']);
		$TbNidosAtencionesVirtuales->setInIdTipoAtencion($datos['tipo_atencion']);
		$TbNidosAtencionesVirtuales->setDtFechaAtencion($datos['fecha_oferta']);
		$TbNidosAtencionesVirtuales->setVcDia($datos['dia']);
		$TbNidosAtencionesVirtuales->setVcHoraInicio($datos['horario']);
		$TbNidosAtencionesVirtuales->setVcHoraFin($datos['horario_fin']);
		$TbNidosAtencionesVirtuales->setInCupos($datos['cupos']);
		$TbNidosAtencionesVirtuales->setInCuposDisponibles($datos['cupos_disponibles']);		
		$TbNidosAtencionesVirtuales->setFkIdUsuarioRegistro($datos['id_usuario']);
		$TbNidosAtencionesVirtuales->setDtFechaRegistro(date("Y-m-d H:i:s"));
		echo $NidosCirculacionDAO->crearOfertaAtencionesVirtuales($TbNidosAtencionesVirtuales);
	}

	public function getOptionsMes(){
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Poblacional'=>$vista));
		$vista->renderHtml("Reportes");
	}

	public function consultarOfertaVirtual($idmes,$formulario){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$oferta = $NidosCirculacionDAO->consultarOfertaVirtual($idmes,$formulario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('oferta'=>$oferta));
		$vista->renderHtml();
	}

	public function consultarDemandaVirtual($dia,$formulario){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$oferta = $NidosCirculacionDAO->consultarDemandaAtenciones($dia,$formulario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('oferta'=>$oferta));
		$vista->renderHtml();
	}

	public function EditarFranjaHoraria($datos){
		$TbNidosAtencionesVirtuales = $this->contenedor['TbNidosHorariosAtencion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		$TbNidosAtencionesVirtuales->setPkIdHorario($datos['tx_id_franja']);
		$TbNidosAtencionesVirtuales->setInIdFormulario($datos['sl_formulario']);
		$TbNidosAtencionesVirtuales->setInIdTipoAtencion($datos['sl_atencion']);
		$TbNidosAtencionesVirtuales->setDtFechaAtencion($datos['tx_fecha']);
		$TbNidosAtencionesVirtuales->setVcHoraInicio($datos['tx_horainicio']);
		$TbNidosAtencionesVirtuales->setVcHoraFin($datos['tx_horafin']);		
		$TbNidosAtencionesVirtuales->setInCupos($datos['tx_cupostotal']);
		$TbNidosAtencionesVirtuales->setInCuposDisponibles($datos['tx_disponibles']);		
		$TbNidosAtencionesVirtuales->setFkIdUsuarioRegistro($datos['id_usuario']);
		$TbNidosAtencionesVirtuales->setDtFechaRegistro(date("Y-m-d H:i:s"));
		echo $NidosCirculacionDAO->editarFranjaHoraria($TbNidosAtencionesVirtuales);
	}

	public function getOptionsArtistas(){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$Artista = $NidosCirculacionDAO->consultarArtistasComunitarios();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('artista'=>$Artista));
		$vista->renderHtml();
	}

	public function validarFechaAsignacion($id_atencion_virtual){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$fecha_atencion = $NidosCirculacionDAO->validarFechaAsignacion($id_atencion_virtual);
		echo json_encode($fecha_atencion[0]);
	}

	public function AsignarArtista($datos){

		$TbNidosLlamadasAsignacion = $this->contenedor['TbNidosLlamadasAsignacion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		
		$TbNidosLlamadasAsignacion->setFkAtencionVirtual($datos["tx_id_franja"]);
		$TbNidosLlamadasAsignacion->setFechaLlamada($datos["fecha_llamada"]);
		$TbNidosLlamadasAsignacion->setQuienLlama($datos["sl_artista"]);
		$TbNidosLlamadasAsignacion->setFechaAsignacion(date('Y-m-d H:i:s'));
		$TbNidosLlamadasAsignacion->setQuienAsigno($datos["quien_asigno"]);

		echo $NidosCirculacionDAO->AsignarArtista($TbNidosLlamadasAsignacion, $datos["formulario"], $datos["sl_upz"]);
	}

	public function consultarAtencionesAsignadas($mes,$usuario){
		$NidosCirculacionDAO = $this->contenedor['NidosAtencionesVirtualesDAO'];
		$oferta = $NidosCirculacionDAO->consultarAtencionesAsignadas($mes,$usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('oferta'=>$oferta));
		$vista->renderHtml();
	}

	public function RegistroLlamadasArtistas($datos){
		$TbNidosLlamadas = $this->contenedor['TbNidosLlamadas'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		
		$TbNidosLlamadas->setFkAtencionVirtual($datos['tx_id_franja']);
		$TbNidosLlamadas->setFkLlamadaAsignacion($datos['id_asignacion']);
		$TbNidosLlamadas->setFechaLlamada($datos['fecha_llamada']);
		$TbNidosLlamadas->setQuienLlamo($datos['quien_llamo']);
		$TbNidosLlamadas->setDuracionLlamada($datos['tx_duracion']);
		$TbNidosLlamadas->setMaterialNarrado($datos['tx_material']);
		$TbNidosLlamadas->setParecioLectura($datos['tx_lectura']);
		$TbNidosLlamadas->setReaccion($datos['tx_reacciono']);
		$TbNidosLlamadas->setObservaciones($datos['tx_observaciones']);


		echo $NidosCirculacionDAO->RegistroLlamadasArtistas($TbNidosLlamadas, $datos["sl_llamada"], $datos["numero_documento_beneficiario"], $datos["formulario"]);
	}

	public function consultarTotalAtencionesMes($mes){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$oferta = $NidosCirculacionDAO->consultarTotalAtencionesMes($mes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('oferta'=>$oferta));
		$vista->renderHtml();
	}

	public function getUpzLocalidad($Localidad){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$Upz = $NidosCirculacionDAO->consultarUpzLocalidad($Localidad);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('upz'=>$Upz));
		$vista->renderHtml();
	}

	public function getTotalAtenciones($mes,$usuario){
		$NidosCirculacionDAO = $this->contenedor['NidosAtencionesVirtualesDAO'];
		$TotalAtenciones = $NidosCirculacionDAO->consultarTotalesAsignadas($mes,$usuario);
		echo json_encode($TotalAtenciones[0]);
	}

	public function guardarSolicitud($datos){
		$TbNidosAtencionesVirtuales = $this->contenedor['TbNidosAtencionesVirtuales'];
		$NidosAtencionesVirtualesDAO = $this->contenedor['NidosAtencionesVirtualesDAO'];

		$TbNidosAtencionesVirtuales->setVcPrimerNombreCuidador($datos['TX_Nombre_Cuidador']);
		$TbNidosAtencionesVirtuales->setVcCorreo($datos['TX_Correo_Cuidador']);
		$TbNidosAtencionesVirtuales->setInTipoDocCuidador($datos['SL_Tipo_Doc_Cuidador']);
		$TbNidosAtencionesVirtuales->setInIdentificacionCuidador($datos['TX_Identificacion_Cuidador']);
		$TbNidosAtencionesVirtuales->setInLocalidad($datos['SL_Localidad_Cuidador']);
		$TbNidosAtencionesVirtuales->setVcOtroLugar($datos['TX_Otro']);
		$TbNidosAtencionesVirtuales->setVcBarrio($datos['TX_Barrio_Cuidador']);
		$TbNidosAtencionesVirtuales->setVcDireccion($datos['TX_Direccion_Cuidador']);
		$TbNidosAtencionesVirtuales->setInEstrato($datos['SL_Estrato_Cuidador']);
		$TbNidosAtencionesVirtuales->setVcEdadCuidador($datos['TX_Edad_Cuidador']);
		$TbNidosAtencionesVirtuales->setInDirigidaAtencion($datos['SL_Dirigida']);
		$TbNidosAtencionesVirtuales->setInParentesco($datos['SL_Parentesco']);
		$TbNidosAtencionesVirtuales->setInPotestad($datos['SL_Potestad']);
		$TbNidosAtencionesVirtuales->setVcIdentificacion($datos['TX_Identificacion_Beneficiario']);
		$TbNidosAtencionesVirtuales->setFkTipoIdentificacion($datos['SL_Tipo_Doc_Beneficiario']);
		$TbNidosAtencionesVirtuales->setVCPrimerNombreBeneficiario($datos['TX_Nombres_Beneficiario']);
		$TbNidosAtencionesVirtuales->setVCPrimerApellidobeneficiario($datos['TX_Apellidos_Beneficiario']);
		$TbNidosAtencionesVirtuales->setDdFNacimiento($datos['TX_Fec_Nac_Beneneficiario']);
		$TbNidosAtencionesVirtuales->setVcGrupoPoblacional($datos['SL_Enf_Beneficiario']);
		$TbNidosAtencionesVirtuales->setVcEdadBeneficiario($datos['SL_Edad_Beneficiario']);
		$TbNidosAtencionesVirtuales->setVcInstitucion($datos['TX_Institucion']);
		$TbNidosAtencionesVirtuales->setVcEntidad($datos['SL_Entidad']);
		$TbNidosAtencionesVirtuales->setVcTelefono($datos['TX_Celular']);
		$TbNidosAtencionesVirtuales->setInTipoAtencion($datos['SL_Tipo_Atencion']);
		$TbNidosAtencionesVirtuales->setInHorarioLlamada($datos['SL_Horario_Atencion']);
		$TbNidosAtencionesVirtuales->setVcComentarios($datos['TX_Comentario']);
		$TbNidosAtencionesVirtuales->setVcAutorizacion($datos['RB_Autorizacion']);
		$TbNidosAtencionesVirtuales->setDdFechaSolicitud(date('Y-m-d H:i:s'));
		$TbNidosAtencionesVirtuales->setInFormulario($datos['TX_Formulario']);

		echo $NidosAtencionesVirtualesDAO->guardarSolicitud($TbNidosAtencionesVirtuales);
	}

	public function consultarAtencionPrevia($id_beneficiario){
		$NidosAtencionesVirtualesDAO = $this->contenedor['NidosAtencionesVirtualesDAO'];
		$infoAtencion = $NidosAtencionesVirtualesDAO->consultarAtencionPrevia($id_beneficiario);
		echo json_encode($infoAtencion);
	}

	public function getInfoFormulario($id_formulario){
		$NidosAtencionesVirtualesDAO = $this->contenedor['NidosAtencionesVirtualesDAO'];
		$info_formulario = $NidosAtencionesVirtualesDAO->getInfoFormulario($id_formulario);
		echo json_encode($info_formulario[0]);
	}

	public function getTiposAtencionDisponible($id_formulario){
		$NidosAtencionesVirtualesDAO = $this->contenedor['NidosAtencionesVirtualesDAO'];
		$atenciones = $NidosAtencionesVirtualesDAO->getTiposAtencionDisponible($id_formulario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('atenciones'=>$atenciones));
		$vista->renderHtml();
	}

	public function getHorarios($tipo_formulario, $tipo_atencion){
		$NidosAtencionesVirtualesDAO = $this->contenedor['NidosAtencionesVirtualesDAO'];
		$horarios = $NidosAtencionesVirtualesDAO->getHorarios($tipo_formulario, $tipo_atencion);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('horarios'=>$horarios));
		$vista->renderHtml();
	}

	public function guardarConfiguracionFormulario($datos){
		$TbNidosFormulariosAtencionesVirtuales = $this->contenedor['TbNidosFormulariosAtencionesVirtuales'];
		$NidosAtencionesVirtualesDAO = $this->contenedor['NidosAtencionesVirtualesDAO'];

		$TbNidosFormulariosAtencionesVirtuales->setPkIdFormulario($datos["id-formulario"]);
		$TbNidosFormulariosAtencionesVirtuales->setInEstado($datos["cb-estado-formulario"]);
		$TbNidosFormulariosAtencionesVirtuales->setVcContenidoCerrado($datos["tx-contenido"]);
		$TbNidosFormulariosAtencionesVirtuales->setDtFechaModificacion(date("Y-m-d H:i:s"));

		echo $NidosAtencionesVirtualesDAO->guardarConfiguracionFormulario($TbNidosFormulariosAtencionesVirtuales);
	}

	public function EditarInformacionLlamada($datos){

		$TbNidosAtencionesVirtuales = $this->contenedor['TbNidosAtencionesVirtuales'];
		$NidosAtencionesVirtualesDAO = $this->contenedor['NidosAtencionesVirtualesDAO'];

		$TbNidosAtencionesVirtuales->setPkIdRegistro($datos["tx-id-llamada"]);
		$TbNidosAtencionesVirtuales->setInTipoDocCuidador($datos["sl-tipo-doc-cuidador-editar"]);
		$TbNidosAtencionesVirtuales->setInIdentificacionCuidador($datos["tx-documento-cuidador-editar"]);
		$TbNidosAtencionesVirtuales->setVcNombreCuidador($datos["tx-nombre-cuidador-editar"]);
		$TbNidosAtencionesVirtuales->setVcCorreo($datos["tx-correo-cuidador-editar"]);
		$TbNidosAtencionesVirtuales->setInLocalidad($datos["sl-localidad-cuidador-editar"]);
		$TbNidosAtencionesVirtuales->setVcBarrio($datos["tx-barrio-cuidador-editar"]);
		$TbNidosAtencionesVirtuales->setVcDireccion($datos["tx-direccion-cuidador-editar"]);
		$TbNidosAtencionesVirtuales->setInEstrato($datos["sl-estrato-cuidador-editar"]);
		$TbNidosAtencionesVirtuales->setVcEdadCuidador($datos["tx-edad-cuidador-editar"]);
		$TbNidosAtencionesVirtuales->setInParentesco($datos["tx-parentesco-editar"]);
		$TbNidosAtencionesVirtuales->setVcNombres($datos["tx-nombres-beneficiario-editar"]);
		$TbNidosAtencionesVirtuales->setVcApellidos($datos["tx-apellidos-beneficiario-editar"]);
		$TbNidosAtencionesVirtuales->setVcGrupoPoblacional($datos["sl-enfoque-beneficiario-editar"]);
		$TbNidosAtencionesVirtuales->setDdFNacimiento($datos["tx-fecha-nacimiento-beneficiario-editar"]);
		$TbNidosAtencionesVirtuales->setFkTipoIdentificacion($datos["sl-tipo-doc-beneficiario-editar"]);
		$TbNidosAtencionesVirtuales->setVcIdentificacion($datos["tx-numero-doc-beneficiario-editar"]);
		$TbNidosAtencionesVirtuales->setVcEdadBeneficiario($datos["sl-edad-beneficiario-editar"]);
		
		echo $NidosAtencionesVirtualesDAO->EditarInformacionLlamada($TbNidosAtencionesVirtuales);
	}

	public function getBeneficiariosArticulacionArn($id_persona){
		$NidosAtencionesVirtualesDAO = $this->contenedor['NidosAtencionesVirtualesDAO'];
		$info = $NidosAtencionesVirtualesDAO->getBeneficiariosArticulacionArn($id_persona);
		echo json_encode($info);
	}
}
$objControlador = new AtencionesVirtualesController();
unset($objControlador); 
