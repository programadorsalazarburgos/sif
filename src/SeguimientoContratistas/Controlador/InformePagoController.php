<?php
namespace SeguimientoContratistas\Controlador;
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
/*error_reporting(E_ALL);*/
ini_set("display_errors", 1);
require_once "../Vendor/autoload.php";
use SeguimientoContratistas\Modelo\Firma\InformePago;
use SeguimientoContratistas\Modelo\Firma\RadicadoDocumentoResponse;
use SeguimientoContratistas\Controlador\SeguimientoContratistasFactory;
use General\Persistencia\Entidades\TbPersona2017;
use General\Persistencia\DAOS\TbPersona2017DAO;
//include '../Vendor/econea/nusoap/src/nusoap.php';
//use nusoap_client;


class InformePagoController extends SeguimientoContratistasFactory
{
	/**
	 * @var Container
	 *
	 */
	//private /*static*/ $contenedor;
	private $userId;
	private $rolId;
	private $firmaService;

	function __construct()
	{

		parent::__construct();
		session_start();
		$this->userId = $_SESSION["session_username"];
		$this->rolId = $_SESSION['session_usertype'];
		$this->initializeFactory();
		$this->firmaService = $this->contenedor["firmaService"];
		$this->contenedor['personaDAO'] = function ($c) {
			return new TbPersona2017DAO();
		};
	}
	public function getSession()
	{
		$datosUsuario["userId"] = $this->userId;
		$datosUsuario["rolId"] = $this->rolId;
		echo json_encode($datosUsuario);
	}
	public function updateInformePago($informe,$archivos,$informeId,$revision,$id_contrato)
	{
		$informe = json_decode($informe,true);
		$informe["userId"] = isset($informe["userId"]) ? $informe["userId"] : $this->userId;
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		
		if ($tbInformePagoPersonaDAO->validarPeriodo($informe["userId"] ? $informe["userId"] : $this->userId,$informe["input-periodo-fin"],$informeId)[0]["cantidad"] == 0)
			$this->generalSaveInformePago($informe,$informeId,$revision,$archivos,$informe["userId"] ? $informe["userId"] : $this->userId, $id_contrato);
		else
			/*$this->generalSaveInformePago($informe,$informeId,$revision,$archivos,$informe["userId"] ? $informe["userId"] : $this->userId);*/
			echo "5";
	}
	public function saveInformePago($informe,$archivos,$revision,$id_contrato)
	{
		$informe = json_decode($informe,true);
		$informe["userId"] = isset($informe["userId"]) ? $informe["userId"] : $this->userId;
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		if ($tbInformePagoPersonaDAO->validarPeriodo($informe["userId"] ? $informe["userId"] : $this->userId,$informe["input-periodo-fin"])[0]["cantidad"] == 0)
			$this->generalSaveInformePago($informe,null,$revision,$archivos,$informe["userId"] ? $informe["userId"] : $this->userId, $id_contrato);
		else
			/*$this->generalSaveInformePago($informe,null,$revision,$archivos,$informe["userId"] ? $informe["userId"] : $this->userId);*/
			echo "5";
	}

	public function generalSaveInformePago($informe,$informeId,$revision,$archivos,$userId, $id_contrato)
	{
		$revision = $revision == "true" ? 1 : 0;
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$tbInformePagoPersona = $this->contenedor["informePagoPersona"];

		$tx_rp_json["VC_Rp_Contenido_A"] = $informe["input-rp-contenido-a"];
		$tx_rp_json["VC_Tipo_Codigo_A"] = $informe["select-codigo-a"];
		$tx_rp_json["VC_Tipo_Convenio_A"] = $informe["select-convenio-a"];
		$tx_rp_json["VC_Rp_Valor_A"] = $informe["input-rp-valor-a"];
		$tx_rp_json["VC_Rp_Contenido_B"] = $informe["input-rp-contenido-b"];
		$tx_rp_json["VC_Tipo_Codigo_B"] = $informe["select-codigo-b"];
		$tx_rp_json["VC_Tipo_Convenio_B"] = $informe["select-convenio-b"];
		$tx_rp_json["VC_Rp_Valor_B"] = $informe["input-rp-valor-b"];
		$tx_rp_json["VC_Rp_Contenido_C"] = $informe["input-rp-contenido-c"];
		$tx_rp_json["VC_Tipo_Codigo_C"] = $informe["select-codigo-c"];
		$tx_rp_json["VC_Tipo_Convenio_C"] = $informe["select-convenio-c"];
		$tx_rp_json["VC_Rp_Valor_C"] = $informe["input-rp-valor-c"];
		$tx_rp_json["VC_Rp_Contenido_D"] = $informe["input-rp-contenido-d"];
		$tx_rp_json["VC_Tipo_Codigo_D"] = $informe["select-codigo-d"];
		$tx_rp_json["VC_Tipo_Convenio_D"] = $informe["select-convenio-d"];
		$tx_rp_json["VC_Rp_Valor_D"] = $informe["input-rp-valor-d"];
		$tbInformePagoPersona->setTxRpJson($tx_rp_json);

		$tx_declaracion_json["VC_Declaracion_1_Si"] = $informe["input-declaracion-1-si"];
		$tx_declaracion_json["VC_Declaracion_1_No"] = $informe["input-declaracion-1-no"];
		$tx_declaracion_json["VC_Declaracion_1_Observacion"] = $informe["input-declaracion-1-observacion"];
		$tx_declaracion_json["VC_Declaracion_2_Si"] = $informe["input-declaracion-2-si"];
		$tx_declaracion_json["VC_Declaracion_2_No"] = $informe["input-declaracion-2-no"];
		$tx_declaracion_json["VC_Declaracion_2_Observacion"] = $informe["input-declaracion-2-observacion"];
		$tx_declaracion_json["VC_Declaracion_3_Si"] = $informe["input-declaracion-3-si"];
		$tx_declaracion_json["VC_Declaracion_3_No"] = $informe["input-declaracion-3-no"];
		$tx_declaracion_json["VC_Declaracion_3_Observacion"] = $informe["input-declaracion-3-observacion"];
		$tx_declaracion_json["VC_Declaracion_4_Si"] = $informe["input-declaracion-4-si"];
		$tx_declaracion_json["VC_Declaracion_4_No"] = $informe["input-declaracion-4-no"];
		$tx_declaracion_json["VC_Declaracion_4_Observacion"] = $informe["input-declaracion-4-observacion"];
		$tx_declaracion_json["VC_Declaracion_5_Si"] = $informe["input-declaracion-5-si"];
		$tx_declaracion_json["VC_Declaracion_5_No"] = $informe["input-declaracion-5-no"];
		$tx_declaracion_json["VC_Declaracion_5_Observacion"] = $informe["input-declaracion-5-observacion"];
		$tx_declaracion_json["VC_Declaracion_6_Si"] = $informe["input-declaracion-6-si"];
		$tx_declaracion_json["VC_Declaracion_6_No"] = $informe["input-declaracion-6-no"];
		$tx_declaracion_json["VC_Declaracion_6_Observacion"] = $informe["input-declaracion-6-observacion"];
		$tx_declaracion_json["VC_Declaracion_7_Si"] = $informe["input-declaracion-7-si"];
		$tx_declaracion_json["VC_Declaracion_7_No"] = $informe["input-declaracion-7-no"];
		$tx_declaracion_json["VC_Declaracion_7_Observacion"] = $informe["input-declaracion-7-observacion"];
		$tx_declaracion_json["VC_Declaracion_8_Si"] = $informe["input-declaracion-8-si"];
		$tx_declaracion_json["VC_Declaracion_8_No"] = $informe["input-declaracion-8-no"];
		$tx_declaracion_json["VC_Declaracion_8_Observacion"] = $informe["input-declaracion-8-observacion"];
		$tx_declaracion_json["VC_Declaracion_9_Si"] = $informe["input-declaracion-9-si"];
		$tx_declaracion_json["VC_Declaracion_9_No"] = $informe["input-declaracion-9-no"];
		$tx_declaracion_json["VC_Declaracion_9_Observacion"] = $informe["input-declaracion-9-observacion"];
		$tx_declaracion_json["VC_Declaracion_10_Si"] = $informe["input-declaracion-10-si"];
		$tx_declaracion_json["VC_Declaracion_10_No"] = $informe["input-declaracion-10-no"];
		$tx_declaracion_json["VC_Declaracion_10_Observacion"] = $informe["input-declaracion-10-observacion"];
		$tx_declaracion_json["VC_Declaracion_11_Si"] = $informe["input-declaracion-11-si"];
		$tx_declaracion_json["VC_Declaracion_11_No"] = $informe["input-declaracion-11-no"];
		$tx_declaracion_json["VC_Declaracion_11_Observacion"] = $informe["input-declaracion-11-observacion"];
		$tx_declaracion_json["VC_Declaracion_12_Si"] = $informe["input-declaracion-12-si"];
		$tx_declaracion_json["VC_Declaracion_12_No"] = $informe["input-declaracion-12-no"];
		$tx_declaracion_json["VC_Declaracion_12_Observacion"] = $informe["input-declaracion-12-observacion"];
		$tx_declaracion_json["VC_Declaracion_13_Si"] = $informe["input-declaracion-13-si"];
		$tx_declaracion_json["VC_Declaracion_13_No"] = $informe["input-declaracion-13-no"];
		$tx_declaracion_json["VC_Declaracion_13_Observacion"] = $informe["input-declaracion-13-observacion"];
		$tx_declaracion_json["VC_Declaracion_14_Si"] = $informe["input-declaracion-14-si"];
		$tx_declaracion_json["VC_Declaracion_14_No"] = $informe["input-declaracion-14-no"];
		$tx_declaracion_json["VC_Declaracion_14_Observacion"] = $informe["input-declaracion-14-observacion"];
		$tbInformePagoPersona->setTxDeclaracionJson($tx_declaracion_json);

		$tx_suspension["VC_Fecha_Inicio"] = $informe["input-suspension-inicio"];
		$tx_suspension["VC_Fecha_Fin"] = $informe["input-suspension-fin"];
		$tbInformePagoPersona->setTxSuspension($tx_suspension);

		$tbInformePagoPersona->setFkPersona($userId);
		$tbInformePagoPersona->setVcFechaInforme(isset($informe["input-fecha-informe"])? $informe["input-fecha-informe"]:null);
		$tbInformePagoPersona->setVcPeriodoInicio($informe["input-periodo-inicio"]);
		$tbInformePagoPersona->setVcPeriodoFin($informe["input-periodo-fin"]);
		$tbInformePagoPersona->setVcNumeroContrato($informe["input-numero-contrato"]);
		$tbInformePagoPersona->setVcTipoIdentificacion($informe["select-identificacion"]);
		$tbInformePagoPersona->setVcIdentificacion($informe["input-identificacion"]);
		$tbInformePagoPersona->setVcCiiu($informe["input-ciiu"]);
		$tbInformePagoPersona->setVcNombresApellidosCedente($informe["input-nombres-apellidos-cedente"]);
		$tbInformePagoPersona->setVcTipoIdentificacionCedente($informe["select-identificacion-cedente"]);
		$tbInformePagoPersona->setVcIdentificacionCendete($informe["input-identificacion-cendete"]);
		$tbInformePagoPersona->setVcBanco(isset($informe["select-banco"])? $informe["select-banco"]:null);
		$tbInformePagoPersona->setVcTipoCuenta($informe["input-tipo-cuenta"]);
		$tbInformePagoPersona->setVcNumeroCuenta($informe["input-numero-cuenta"]);
		$tbInformePagoPersona->setVcObjeto($informe["input-objeto"]);
		$tbInformePagoPersona->setVcFechaInicio($informe["input-fecha-inicio"]);
		$tbInformePagoPersona->setVcPlazoInicial($informe["input-plazo-inicial"]);
		$tbInformePagoPersona->setVcProrrogas($informe["input-prorrogas"]);
		$tbInformePagoPersona->setVcFechaPlazoFin($informe["input-fecha-plazo-fin"]);
		$tbInformePagoPersona->setVcFechaFin($informe["input-fecha-fin"]);
		$tbInformePagoPersona->setVcNumeroPagos($informe["input-numero-pagos"]);
		$tbInformePagoPersona->setVcPagoNumero($informe["input-pago-numero"]);
		$tbInformePagoPersona->setVcPagoDeTotal($informe["input-pago-de-total"]);
		$tbInformePagoPersona->setVcValorInicial($informe["input-valor-inicial"]);
		$tbInformePagoPersona->setVcValorAdicion1($informe["input-valor-adicion-1"]);
		$tbInformePagoPersona->setVcValorAdicion2($informe["input-valor-adicion-2"]);
		$tbInformePagoPersona->setVcValorAdicion3($informe["input-valor-adicion-3"]);
		$tbInformePagoPersona->setVcValorTotalContrato($informe["input-valor-total-contrato"]);
		$tbInformePagoPersona->setVcValorPagoEfectuar($informe["input-valor-pago-efectuar"]);
		$tbInformePagoPersona->setVcValorLetras($informe["input-valor-letras"]);
		$tbInformePagoPersona->setVcGirosEfectuados($informe["input-giros-efectuados"]);
		$tbInformePagoPersona->setVcSaldoPediente($informe["input-saldo-pediente"]);
		$tbInformePagoPersona->setVcValorLiberar($informe["input-valor-liberar"]);
		$tbInformePagoPersona->setVcNumeroObligaciones($informe["input-numero-obligaciones"]);
		$tbInformePagoPersona->setVcTextareaProducto($informe["textarea-producto"]);
		$tbInformePagoPersona->setSmfinalizado($revision);
		$tbInformePagoPersona->setVcTextareaMecanismoVerificacion($informe["textarea-mecanismo-verificacion"]);
		$disminucion = "";
		if ($informe["input-disminucion-retencion-si"] == "X") $disminucion = 1;
		if ($informe["input-disminucion-retencion-no"] == "X") $disminucion = 0;
		$tbInformePagoPersona->setVcDisminucionRetencion($disminucion);
		$retencion = "";
		if ($informe["input-tomados-retencion-si"] == "X") $retencion = 1;
		if ($informe["input-tomados-retencion-no"] == "X") $retencion = 0;
		$tbInformePagoPersona->setVcTomadosRetencion($retencion);
		$tbInformePagoPersona->setVcMesPlanilla($informe["input-mes-planilla"]);
		$tbInformePagoPersona->setVcNumeroPlanilla($informe["input-numero-planilla"]);
		$obligaciones = [];
		$obligacionesBasico = [];
		foreach ($informe as $key => $value) {
			if (strpos($key, 'oblicacion') !== false || strpos($key, 'descripcion') !== false) {
				$obligaciones[$key]=$value;
				if (strpos($key, 'oblicacion') !== false)
					$obligacionesBasico[$key]=$value;
			}
		}
		$state = 0;
		$tbInformePagoPersona->setTxObligacionesJson($obligaciones);
		$tbInformePagoPersona->setFkBasico($id_contrato);
		$inicio = $informe["input-periodo-inicio"];
		$fin = $informe["input-periodo-fin"];
		$periodo = $inicio.' al '.$fin;
		$periodo = str_replace('/', '-', $periodo);
		$urlPlanilla = "";
		if ($archivos != null)
			$urlPlanilla = $this->subirArchivos($userId,$archivos,'Anexos-Planillas', $periodo, 1, 'tbInformePagoPersonaDAO');
		if ($urlPlanilla == 3 || $urlPlanilla == 4){
			$state = $urlPlanilla;
			$urlPlanilla = "";
		}

		$tbInformePagoPersona->setTxPlanillasExtras($urlPlanilla);
		if ($state == 0) {
			if ($informeId == null){
				$state = $tbInformePagoPersonaDAO->saveInformePago($tbInformePagoPersona);
			}
			else
				$state = $tbInformePagoPersonaDAO->updateInformePago($tbInformePagoPersona,$informeId);
		}

		$tbInformePagoPersonaDAO->saveInformePagoLog($informeId);
		$tbiformePagoPersonaBasico = $this->contenedor["informePagoPersonaBasico"];
		$tbiformePagoPersonaBasico->setFkPersona($userId);
		$tbiformePagoPersonaBasico->setFkPersonaActualizo($userId);
		$tbiformePagoPersonaBasico->setVcNumeroContrato($tbInformePagoPersona->getVcNumeroContrato());
		$tbiformePagoPersonaBasico->setVcTipoIdentificacion($tbInformePagoPersona->getVcTipoIdentificacion());
		$tbiformePagoPersonaBasico->setVcIdentificacion($tbInformePagoPersona->getVcIdentificacion());
		$tbiformePagoPersonaBasico->setVcCiiu($tbInformePagoPersona->getVcCiiu());
		$tbiformePagoPersonaBasico->setVcNombresApellidosCedente($tbInformePagoPersona->getVcNombresApellidosCedente());
		$tbiformePagoPersonaBasico->setVcTipoIdentificacionCedente($tbInformePagoPersona->getVcTipoIdentificacionCedente());
		$tbiformePagoPersonaBasico->setVcIdentificacionCendete($tbInformePagoPersona->getVcIdentificacionCendete());
		$tbiformePagoPersonaBasico->setVcBanco($tbInformePagoPersona->getVcBanco());
		$tbiformePagoPersonaBasico->setVcTipoCuenta($tbInformePagoPersona->getVcTipoCuenta());
		$tbiformePagoPersonaBasico->setVcNumeroCuenta($tbInformePagoPersona->getVcNumeroCuenta());
		$tbiformePagoPersonaBasico->setVcObjeto($tbInformePagoPersona->getVcObjeto());
		$tbiformePagoPersonaBasico->setVcFechaInicio($tbInformePagoPersona->getVcFechaInicio());
		$tbiformePagoPersonaBasico->setVcPlazoInicial($tbInformePagoPersona->getVcPlazoInicial());
		$tbiformePagoPersonaBasico->setVcProrrogas($tbInformePagoPersona->getVcProrrogas());
		$tbiformePagoPersonaBasico->setVcFechaPlazoFin($tbInformePagoPersona->getVcFechaPlazoFin());
		$tbiformePagoPersonaBasico->setVcFechaFin($tbInformePagoPersona->getVcFechaFin());
		$tbiformePagoPersonaBasico->setVcNumeroPagos($tbInformePagoPersona->getVcNumeroPagos());
		$tbiformePagoPersonaBasico->setVcPagoNumero($tbInformePagoPersona->getVcPagoNumero());
		$tbiformePagoPersonaBasico->setVcPagoDeTotal($tbInformePagoPersona->getVcPagoDeTotal());
		$tbiformePagoPersonaBasico->setVcValorInicial($tbInformePagoPersona->getVcValorInicial());
		$tbiformePagoPersonaBasico->setVcValorAdicion1($tbInformePagoPersona->getVcValorAdicion1());
		$tbiformePagoPersonaBasico->setVcValorAdicion2($tbInformePagoPersona->getVcValorAdicion2());
		$tbiformePagoPersonaBasico->setVcValorAdicion3($tbInformePagoPersona->getVcValorAdicion3());
		$tbiformePagoPersonaBasico->setVcValorTotalContrato($tbInformePagoPersona->getVcValorTotalContrato());
		$tbiformePagoPersonaBasico->setVcValorPagoEfectuar($tbInformePagoPersona->getVcValorPagoEfectuar());
		$tbiformePagoPersonaBasico->setVcGirosEfectuados($tbInformePagoPersona->getVcGirosEfectuados());
		$tbiformePagoPersonaBasico->setVcSaldoPediente($tbInformePagoPersona->getVcSaldoPediente());
		$tbiformePagoPersonaBasico->setVcValorLiberar($tbInformePagoPersona->getVcValorLiberar());
		$tbiformePagoPersonaBasico->setTxObligacionesJson($obligacionesBasico);
		$tbiformePagoPersonaBasico->setVcNumeroObligaciones($tbInformePagoPersona->getVcNumeroObligaciones());
		$tbiformePagoPersonaBasico->setVcTextareaProducto($tbInformePagoPersona->getVcTextareaProducto());
		$tbiformePagoPersonaBasico->setVcDisminucionRetencion($tbInformePagoPersona->getVcDisminucionRetencion());
		$tbiformePagoPersonaBasico->setVcTomadosRetencion($tbInformePagoPersona->getVcTomadosRetencion());
		$tbiformePagoPersonaBasico->setTxRpJson(json_decode($tbInformePagoPersona->getTxRpJson()));
		$tbiformePagoPersonaBasico->setTxDeclaracionJson(json_decode($tbInformePagoPersona->getTxDeclaracionJson()));
		$tbInformePagoPersonaBasicoDAO = $this->contenedor["tbInformePagoPersonaBasicoDAO"];
		$filasAfectadas = $tbInformePagoPersonaBasicoDAO->updateInformePagoBasico($tbiformePagoPersonaBasico);
		$tbInformePagoPersonaBasicoDAO->saveInformePagoBasicoAdminLog($id_contrato);
		echo $state;
	}
	public function updateInformePagoBasicoAdmin($informe,$basicoId, $fk_persona)
	{
		$tbInformePagoPersonaBasicoDAO = $this->contenedor["tbInformePagoPersonaBasicoDAO"];
		$informe["userId"] = isset($informe["userId"]) ? $informe["userId"] : $this->userId;
		$informe["select-supervisor"] = !empty($informe["select-supervisor"]) ? $informe["select-supervisor"] : null;
		$informe["select-apoyo"] = !empty($informe["select-apoyo"]) ? $informe["select-apoyo"] : null;
		$informe["select-apoyo-dos"] = !empty($informe["select-apoyo-dos"]) ? $informe["select-apoyo-dos"] : null;
		$informe["select-apoyo-financiero"] = !empty($informe["select-apoyo-financiero"]) ? $informe["select-apoyo-financiero"] : null;
		$informe["select-apoyo-auxiliar"] = !empty($informe["select-apoyo-auxiliar"]) ? $informe["select-apoyo-auxiliar"] : null;
		$tx_rp_json["VC_Rp_Contenido_A"] = $informe["input-rp-contenido-a"];
		$tx_rp_json["VC_Tipo_Codigo_A"] = $informe["select-codigo-a"];
		$tx_rp_json["VC_Tipo_Convenio_A"] = $informe["select-convenio-a"];
		$tx_rp_json["VC_Rp_Valor_A"] = $informe["input-rp-valor-a"];
		$tx_rp_json["VC_Rp_Contenido_B"] = $informe["input-rp-contenido-b"];
		$tx_rp_json["VC_Tipo_Codigo_B"] = $informe["select-codigo-b"];
		$tx_rp_json["VC_Tipo_Convenio_B"] = $informe["select-convenio-b"];
		$tx_rp_json["VC_Rp_Valor_B"] = $informe["input-rp-valor-b"];
		$tx_rp_json["VC_Rp_Contenido_C"] = $informe["input-rp-contenido-c"];
		$tx_rp_json["VC_Tipo_Codigo_C"] = $informe["select-codigo-c"];
		$tx_rp_json["VC_Tipo_Convenio_C"] = $informe["select-convenio-c"];
		$tx_rp_json["VC_Rp_Valor_C"] = $informe["input-rp-valor-c"];
		$tx_rp_json["VC_Rp_Contenido_D"] = $informe["input-rp-contenido-d"];
		$tx_rp_json["VC_Tipo_Codigo_D"] = $informe["select-codigo-d"];
		$tx_rp_json["VC_Tipo_Convenio_D"] = $informe["select-convenio-d"];
		$tx_rp_json["VC_Rp_Valor_D"] = $informe["input-rp-valor-d"];

		$tx_declaracion_json["VC_Declaracion_1_Si"] = $informe["input-declaracion-1-si"];
		$tx_declaracion_json["VC_Declaracion_1_No"] = $informe["input-declaracion-1-no"];
		$tx_declaracion_json["VC_Declaracion_1_Observacion"] = $informe["input-declaracion-1-observacion"];
		$tx_declaracion_json["VC_Declaracion_2_Si"] = $informe["input-declaracion-2-si"];
		$tx_declaracion_json["VC_Declaracion_2_No"] = $informe["input-declaracion-2-no"];
		$tx_declaracion_json["VC_Declaracion_2_Observacion"] = $informe["input-declaracion-2-observacion"];
		$tx_declaracion_json["VC_Declaracion_3_Si"] = $informe["input-declaracion-3-si"];
		$tx_declaracion_json["VC_Declaracion_3_No"] = $informe["input-declaracion-3-no"];
		$tx_declaracion_json["VC_Declaracion_3_Observacion"] = $informe["input-declaracion-3-observacion"];
		$tx_declaracion_json["VC_Declaracion_4_Si"] = $informe["input-declaracion-4-si"];
		$tx_declaracion_json["VC_Declaracion_4_No"] = $informe["input-declaracion-4-no"];
		$tx_declaracion_json["VC_Declaracion_4_Observacion"] = $informe["input-declaracion-4-observacion"];
		$tx_declaracion_json["VC_Declaracion_5_Si"] = $informe["input-declaracion-5-si"];
		$tx_declaracion_json["VC_Declaracion_5_No"] = $informe["input-declaracion-5-no"];
		$tx_declaracion_json["VC_Declaracion_5_Observacion"] = $informe["input-declaracion-5-observacion"];
		$tx_declaracion_json["VC_Declaracion_6_Si"] = $informe["input-declaracion-6-si"];
		$tx_declaracion_json["VC_Declaracion_6_No"] = $informe["input-declaracion-6-no"];
		$tx_declaracion_json["VC_Declaracion_6_Observacion"] = $informe["input-declaracion-6-observacion"];
		$tx_declaracion_json["VC_Declaracion_7_Si"] = $informe["input-declaracion-7-si"];
		$tx_declaracion_json["VC_Declaracion_7_No"] = $informe["input-declaracion-7-no"];
		$tx_declaracion_json["VC_Declaracion_7_Observacion"] = $informe["input-declaracion-7-observacion"];
		$tx_declaracion_json["VC_Declaracion_8_Si"] = $informe["input-declaracion-8-si"];
		$tx_declaracion_json["VC_Declaracion_8_No"] = $informe["input-declaracion-8-no"];
		$tx_declaracion_json["VC_Declaracion_8_Observacion"] = $informe["input-declaracion-8-observacion"];
		$tx_declaracion_json["VC_Declaracion_9_Si"] = $informe["input-declaracion-9-si"];
		$tx_declaracion_json["VC_Declaracion_9_No"] = $informe["input-declaracion-9-no"];
		$tx_declaracion_json["VC_Declaracion_9_Observacion"] = $informe["input-declaracion-9-observacion"];
		$tx_declaracion_json["VC_Declaracion_10_Si"] = $informe["input-declaracion-10-si"];
		$tx_declaracion_json["VC_Declaracion_10_No"] = $informe["input-declaracion-10-no"];
		$tx_declaracion_json["VC_Declaracion_10_Observacion"] = $informe["input-declaracion-10-observacion"];
		$tx_declaracion_json["VC_Declaracion_11_Si"] = $informe["input-declaracion-11-si"];
		$tx_declaracion_json["VC_Declaracion_11_No"] = $informe["input-declaracion-11-no"];
		$tx_declaracion_json["VC_Declaracion_11_Observacion"] = $informe["input-declaracion-11-observacion"];
		$tx_declaracion_json["VC_Declaracion_12_Si"] = $informe["input-declaracion-12-si"];
		$tx_declaracion_json["VC_Declaracion_12_No"] = $informe["input-declaracion-12-no"];
		$tx_declaracion_json["VC_Declaracion_12_Observacion"] = $informe["input-declaracion-12-observacion"];
		$tx_declaracion_json["VC_Declaracion_13_Si"] = $informe["input-declaracion-13-si"];
		$tx_declaracion_json["VC_Declaracion_13_No"] = $informe["input-declaracion-13-no"];
		$tx_declaracion_json["VC_Declaracion_13_Observacion"] = $informe["input-declaracion-13-observacion"];
		$tx_declaracion_json["VC_Declaracion_14_Si"] = $informe["input-declaracion-14-si"];
		$tx_declaracion_json["VC_Declaracion_14_No"] = $informe["input-declaracion-14-no"];
		$tx_declaracion_json["VC_Declaracion_14_Observacion"] = $informe["input-declaracion-14-observacion"];

		$tx_suspension["VC_Fecha_Inicio"] = $informe["input-suspension-inicio"];
		$tx_suspension["VC_Fecha_Fin"] = $informe["input-suspension-fin"];

		$disminucion = "";
		if ($informe["input-disminucion-retencion-si"] == "X") $disminucion = 1;
		if ($informe["input-disminucion-retencion-no"] == "X") $disminucion = 0;
		$retencion = "";
		if ($informe["input-tomados-retencion-si"] == "X") $retencion = 1;
		if ($informe["input-tomados-retencion-no"] == "X") $retencion = 0;

		$tbiformePagoPersonaBasico = $this->contenedor["informePagoPersonaBasico"];
		$tbiformePagoPersonaBasico->setPkIdTabla($basicoId);
		$tbiformePagoPersonaBasico->setFkPersonaActualizo($informe["userId"]);
		//$tbiformePagoPersonaBasico->setVcNumeroContrato($informe["input-numero-contrato"]);
		$tbiformePagoPersonaBasico->setVcTipoIdentificacion($informe["select-identificacion"]);
		$tbiformePagoPersonaBasico->setVcIdentificacion($informe["input-identificacion"]);
		$tbiformePagoPersonaBasico->setVcCiiu($informe["input-ciiu"]);
		//$tbiformePagoPersonaBasico->setVcNombresApellidosCedente($informe["input-nombres-apellidos-cedente"]);
		//$tbiformePagoPersonaBasico->setVcTipoIdentificacionCedente($informe["select-identificacion-cedente"]);
		//$tbiformePagoPersonaBasico->setVcIdentificacionCendete($informe["input-identificacion-cendete"]);
		$tbiformePagoPersonaBasico->setVcObjeto($informe["input-objeto"]);
		$tbiformePagoPersonaBasico->setVcFechaInicio($informe["input-fecha-inicio"]);
		$tbiformePagoPersonaBasico->setVcPlazoInicial($informe["input-plazo-inicial"]);
		$tbiformePagoPersonaBasico->setVcProrrogas($informe["input-prorrogas"]);
		$tbiformePagoPersonaBasico->setVcFechaPlazoFin($informe["input-fecha-plazo-fin"]);
		$tbiformePagoPersonaBasico->setVcFechaFin($informe["input-fecha-fin"]);
		$tbiformePagoPersonaBasico->setVcNumeroPagos($informe["input-numero-pagos"]);
		$tbiformePagoPersonaBasico->setVcPagoDeTotal($informe["input-pago-de-total"]);
		$tbiformePagoPersonaBasico->setVcValorInicial($informe["input-valor-inicial"]);
		$tbiformePagoPersonaBasico->setVcValorAdicion1($informe["input-valor-adicion-1"]);
		$tbiformePagoPersonaBasico->setVcValorAdicion2($informe["input-valor-adicion-2"]);
		$tbiformePagoPersonaBasico->setVcValorAdicion3($informe["input-valor-adicion-3"]);
		$tbiformePagoPersonaBasico->setVcValorTotalContrato($informe["input-valor-total-contrato"]);
		$tbiformePagoPersonaBasico->setVcValorPagoEfectuar($informe["input-valor-pago-efectuar"]);
		$tbiformePagoPersonaBasico->setVcGirosEfectuados($informe["input-giros-efectuados"]);
		$tbiformePagoPersonaBasico->setVcSaldoPediente($informe["input-saldo-pediente"]);
		$tbiformePagoPersonaBasico->setVcValorLiberar($informe["input-valor-liberar"]);
		$tbiformePagoPersonaBasico->setFkPersonaSupervisor($informe["select-supervisor"]);
		$tbiformePagoPersonaBasico->setFkPersonaApoyoSupervisor($informe["select-apoyo"]);
		$tbiformePagoPersonaBasico->setFkPersonaApoyoSupervisordos($informe["select-apoyo-dos"]);
		$tbiformePagoPersonaBasico->setFkAprobacionAdministrativo($informe["select-apoyo-financiero"]);
		$tbiformePagoPersonaBasico->setFkAprobacion($informe["select-apoyo-auxiliar"]);
		$tbiformePagoPersonaBasico->setVcDisminucionRetencion($disminucion);
		$tbiformePagoPersonaBasico->setVcTomadosRetencion($retencion);
		$tbiformePagoPersonaBasico->setTxRpJson($tx_rp_json);
		$tbiformePagoPersonaBasico->setTxDeclaracionJson($tx_declaracion_json);
		
		$filasAfectadas = $tbInformePagoPersonaBasicoDAO->updateInformePagoBasicoAdmin($tbiformePagoPersonaBasico);
		$tbInformePagoPersonaBasicoDAO->saveInformePagoBasicoAdminLog($basicoId);
	
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$idUltimoInforme = $tbInformePagoPersonaDAO->getIdUltimoInformeContrato($fk_persona);

		$tbiformePagoPersona = $this->contenedor["informePagoPersona"];
		$tbiformePagoPersona->setPkIdTabla($idUltimoInforme[0]['PK_Id_Tabla']);
		//$tbiformePagoPersona->setVcNumeroContrato($informe["input-numero-contrato"]);
		$tbiformePagoPersona->setVcTipoIdentificacion($informe["select-identificacion"]);
		$tbiformePagoPersona->setVcIdentificacion($informe["input-identificacion"]);
		$tbiformePagoPersona->setVcCiiu($informe["input-ciiu"]);
		//$tbiformePagoPersona->setVcNombresApellidosCedente($informe["input-nombres-apellidos-cedente"]);
		//$tbiformePagoPersona->setVcTipoIdentificacionCedente($informe["select-identificacion-cedente"]);
		//$tbiformePagoPersona->setVcIdentificacionCendete($informe["input-identificacion-cendete"]);
		$tbiformePagoPersona->setVcObjeto($informe["input-objeto"]);
		$tbiformePagoPersona->setVcFechaInicio($informe["input-fecha-inicio"]);
		$tbiformePagoPersona->setVcFechaFin($informe["input-fecha-fin"]);
		$tbiformePagoPersona->setVcPlazoInicial($informe["input-plazo-inicial"]);
		$tbiformePagoPersona->setVcProrrogas($informe["input-prorrogas"]);
		$tbiformePagoPersona->setVcFechaPlazoFin($informe["input-fecha-plazo-fin"]);
		$tbiformePagoPersona->setVcNumeroPagos($informe["input-numero-pagos"]);
		$tbiformePagoPersona->setVcPagoDeTotal($informe["input-pago-de-total"]);
		$tbiformePagoPersona->setTxRpJson($tx_rp_json);
		$tbiformePagoPersona->setVcValorInicial($informe["input-valor-inicial"]);
		$tbiformePagoPersona->setVcValorAdicion1($informe["input-valor-adicion-1"]);
		$tbiformePagoPersona->setVcValorAdicion2($informe["input-valor-adicion-2"]);
		$tbiformePagoPersona->setVcValorAdicion3($informe["input-valor-adicion-3"]);
		$tbiformePagoPersona->setVcValorTotalContrato($informe["input-valor-total-contrato"]);
		$tbiformePagoPersona->setVcValorPagoEfectuar($informe["input-valor-pago-efectuar"]);
		$tbiformePagoPersona->setVcValorLetras($informe["input-valor-letras"]);
		$tbiformePagoPersona->setVcGirosEfectuados($informe["input-giros-efectuados"]);
		$tbiformePagoPersona->setVcSaldoPediente($informe["input-saldo-pediente"]);
		$tbiformePagoPersona->setVcValorLiberar($informe["input-valor-liberar"]);
		$tbiformePagoPersona->setTxDeclaracionJson($tx_declaracion_json);
		$tbiformePagoPersona->setVcDisminucionRetencion($disminucion);
		$tbiformePagoPersona->setVcTomadosRetencion($retencion);

		if($idUltimoInforme[0]['PK_Id_Tabla'] > 0){
			$filasAfectadas = $tbInformePagoPersonaDAO->updateInformePagoAdmin($tbiformePagoPersona);
		}
		echo $filasAfectadas;
	}
	public function getInformePago($informeId)
	{

		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$informePago = $tbInformePagoPersonaDAO->getInformePago($informeId)[0];
		$formInformePago = $this->convertionFormName($informePago);
		$formInformePago["anexosOrfeo"] = $informePago['anexosOrfeo'];
		$tbPersona2017 = $this->contenedor['tbPersona2017'];
		$tbPersona2017->setPkIdPersona($informePago['FK_Persona']);
		$tbPersonaDAO = $this->contenedor['tbPersonaDAO'];
		$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
		$formInformePago["FK_Basico"] = $informePago["FK_Basico"];
		$formInformePago["usuarios_observaciones_json"] = $informePago["usuarios_observaciones_json"];
		$formInformePago["input-nombres-apellidos"] = $datosPersona["nombre"];
		$formInformePago["input-pago-numero"] = intval($formInformePago["input-pago-numero"]);
		$formInformePago['span-nombre-contratista-juramento'] = $datosPersona["nombre"];
		$formInformePago['span-nombre-contratista'] = $datosPersona["nombre"];
		$formInformePago['span-cargo-contratista'] = "Contratista";
		$formInformePago['span-firma-contratista'] = $datosPersona["TX_Firma_Escaneada"] != null ? $datosPersona["TX_Firma_Escaneada"] : '';
		$sin_firma = '';
		if ($informePago['FK_Persona_Apoyo_Supervisor']) {
			$tbPersona2017->setPkIdPersona($informePago['FK_Persona_Apoyo_Supervisor']);
			$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
			$formInformePago['span-nombre-apoyo'] =  $datosPersona["nombre"];
			$formInformePago['span-firma-apoyo'] =  $datosPersona["TX_Firma_Escaneada"] != null ? $datosPersona["TX_Firma_Escaneada"]:'';
			$formInformePago['span-cargo-apoyo'] = $datosPersona["VC_Cargo"];

			if ($informePago['VC_Numero_Contrato'] == '0000-2020') {
				$formInformePago['span-etiqueta-apoyo'] = 'Revisó Supervisor o Interventor';
			} else {
				$formInformePago['span-etiqueta-apoyo'] = 'Revisó Apoyo a la Supervisión';
			}
		}
		else
		{
			$formInformePago['span-nombre-apoyo'] =  '';
			$formInformePago['span-firma-apoyo'] =  '';
			$formInformePago['span-cargo-apoyo'] = '';
			$formInformePago['span-etiqueta-apoyo'] = '';
		}
		
		if ($informePago['FK_Persona_Apoyo_Supervisor_Dos']) {
			$tbPersona2017->setPkIdPersona($informePago['FK_Persona_Apoyo_Supervisor_Dos']);
			$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
			$formInformePago['span-nombre-apoyo_dos'] =  $datosPersona["nombre"];
			$formInformePago['span-firma-apoyo_dos'] =  $datosPersona["TX_Firma_Escaneada"] != null ? $datosPersona["TX_Firma_Escaneada"]:'';
			$formInformePago['span-cargo-apoyo_dos'] = $datosPersona["VC_Cargo"];
		}
		elseif ($informePago['IN_Firma_Administrativo'] == 1 && $informePago['FK_Aprobacion_Administrativo'] != NULL) {
			$tbPersona2017->setPkIdPersona($informePago['FK_Aprobacion_Administrativo']);
			$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
			$formInformePago['span-nombre-apoyo_dos'] =  $datosPersona["nombre"];
			$formInformePago['span-firma-apoyo_dos'] =  $datosPersona["TX_Firma_Escaneada"] != null ? $datosPersona["TX_Firma_Escaneada"]:'';
			$formInformePago['span-cargo-apoyo_dos'] = $datosPersona["VC_Cargo"];
		}
		else
		{
			$formInformePago['span-nombre-apoyo_dos'] =  '';
			$formInformePago['span-firma-apoyo_dos'] =  '';
			$formInformePago['span-cargo-apoyo_dos'] = '';
		}		

		$tbPersona2017->setPkIdPersona($informePago['FK_Persona_Supervisor']);
		$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
		$formInformePago['span-nombre-supervisor'] = strtoupper($datosPersona["nombre"]);
		$formInformePago['FK_Persona'] = $informePago['FK_Persona'];
		$formInformePago['FK_Persona_Supervisor'] = $informePago['FK_Persona_Supervisor'];
		$formInformePago['FK_Persona_Apoyo_Supervisor'] = $informePago['FK_Persona_Apoyo_Supervisor'];
		$formInformePago['FK_Persona_Apoyo_Supervisor_Dos'] = $informePago['FK_Persona_Apoyo_Supervisor_Dos'];
		$formInformePago['FK_Aprobacion'] = $informePago['FK_Aprobacion'];
		$formInformePago['FK_Aprobacion_Administrativo'] = $informePago['FK_Aprobacion_Administrativo'];

		$formInformePago["destinatario-documento"] = $datosPersona["identificacion"];
		$formInformePago["destinatario-nombre"] = $datosPersona["VC_Primer_Nombre"]." ".$datosPersona["VC_Segundo_Nombre"];
		$formInformePago["destinatario-prim_apel"] = $datosPersona["VC_Primer_Apellido"];
		$formInformePago["destinatario-seg_apel"] = $datosPersona["VC_Segundo_Apellido"];
		$formInformePago["destinatario-telefono"] = ($datosPersona["VC_Telefono"]==""?"0":$datosPersona["VC_Telefono"]);
		$formInformePago["destinatario-direccion"] = "Cra. 8 #15-46";// $datosPersona["VC_Direccion"];
		$formInformePago["destinatario-mail"] = $datosPersona["correo"];

		if ($datosPersona["FK_Id_Genero"] == "1") {
			$formInformePago['span-rol-supervisor'] = "Supervisor";
		}
		else
		{	
			if ($datosPersona["FK_Id_Genero"] == "2") {	
				$formInformePago['span-rol-supervisor'] = "Supervisora";
			}
			else{
				$formInformePago['span-rol-supervisor'] = "Supervisor(a)";
			}
		}
		$formInformePago['span-cargo-supervisor'] = $datosPersona["VC_Cargo"];
		$formInformePago['span-firma-supervisor'] = $datosPersona["TX_Firma_Escaneada"] != null ? $datosPersona["TX_Firma_Escaneada"]:'';
		$suspension = json_decode($informePago["VC_Suspension"],true);
		$formInformePago['input-suspension-inicio'] = $suspension["VC_Fecha_Inicio"];
		$formInformePago['input-suspension-fin'] = $suspension["VC_Fecha_Fin"];


		if($formInformePago["observaciones-generales"] != '') {
			$ObservacionesGenerales = json_decode($formInformePago["observaciones-generales"], true);
			foreach($ObservacionesGenerales['observacion'] as $indice => $observacion) {
				$tbPersona2017->setPkIdPersona($observacion['usuario']);
				$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
				$ObservacionesGenerales['observacion'][$indice]['nombre_usuario'] = strtoupper($datosPersona["nombre"]);
			}
			$formInformePago["observaciones-generales"] = json_encode($ObservacionesGenerales);
		}
		echo json_encode($formInformePago);
	}

	public function getInformePagoBasico($userId)
	{
		$tbInformePagoPersonaBasicoDAO = $this->contenedor["tbInformePagoPersonaBasicoDAO"];
		$informePagoBasico = $tbInformePagoPersonaBasicoDAO->getInformePagoBasicoPersona($userId);
		$formInformePagoBasico = $this->convertionFormName($informePagoBasico);
		$tbPersona2017 = $this->contenedor['tbPersona2017'];
		$tbPersona2017->setPkIdPersona($userId);
		$tbPersonaDAO = $this->contenedor['tbPersonaDAO'];
		$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
		$formInformePagoBasico["input-nombres-apellidos"] = $datosPersona["nombre"];
		$formInformePagoBasico["input-pago-numero"] = intval($formInformePagoBasico["input-pago-numero"]);
		$formInformePagoBasico['span-nombre-contratista-juramento'] = $datosPersona["nombre"];
		$formInformePagoBasico['span-nombre-contratista'] = $datosPersona["nombre"];
		$formInformePagoBasico['span-cargo-contratista'] = "Contratista";
		if ($informePagoBasico['FK_Persona_Apoyo_Supervisor']) {
			$tbPersona2017->setPkIdPersona($informePagoBasico['FK_Persona_Apoyo_Supervisor']);
			$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
			$formInformePagoBasico['span-nombre-apoyo'] =  $datosPersona["nombre"];
			$formInformePagoBasico['span-cargo-apoyo'] = $datosPersona["VC_Cargo"];
			$formInformePagoBasico['span-aprobado-apoyo'] = 'APROBADO POR: ';
			$formInformePagoBasico['span-reviso-apoyo'] = 'Revisó Apoyo a la Supervisión';					
		}
		else
		{
			$formInformePagoBasico['span-nombre-apoyo'] =  '';
			$formInformePagoBasico['span-cargo-apoyo'] = '';
			$formInformePagoBasico['span-aprobado-apoyo'] = '';
			$formInformePagoBasico['span-reviso-apoyo'] = '';
		}

		if ($informePagoBasico['FK_Persona_Apoyo_Supervisor_Dos']) {
			$tbPersona2017->setPkIdPersona($informePagoBasico['FK_Persona_Apoyo_Supervisor_Dos']);
			$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
			$formInformePagoBasico['span-nombre-apoyo_dos'] =  $datosPersona["nombre"];
			$formInformePagoBasico['span-cargo-apoyo_dos'] = $datosPersona["VC_Cargo"];
			$formInformePagoBasico['span-aprobado-apoyo_dos'] = 'APROBADO POR: ';
			$formInformePagoBasico['span-reviso-apoyo_dos'] = 'Revisó Apoyo a la Supervisión';					
		}
		else
		{
			$formInformePagoBasico['span-nombre-apoyo_dos'] =  '';
			$formInformePagoBasico['span-cargo-apoyo_dos'] = '';
			$formInformePagoBasico['span-aprobado-apoyo_dos'] = '';
			$formInformePagoBasico['span-reviso-apoyo_dos'] = '';
		}

		if ($informePagoBasico['FK_Persona_Supervisor']) {
			$tbPersona2017->setPkIdPersona($informePagoBasico['FK_Persona_Supervisor']);
			$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
			$formInformePagoBasico['span-nombre-supervisor'] = strtoupper($datosPersona["nombre"]);
			if ($datosPersona["FK_Id_Genero"] == "1") {
				$formInformePagoBasico['span-rol-supervisor'] = "Supervisor";
			}
			else
			{	
				if ($datosPersona["FK_Id_Genero"] == "2") {	
					$formInformePagoBasico['span-rol-supervisor'] = "Supervisora";
				}
				else{
					$formInformePagoBasico['span-rol-supervisor'] = "Supervisor(a)";
				}
			}
			$formInformePagoBasico['span-cargo-supervisor'] = $datosPersona["VC_Cargo"];
		}
		else{
			$formInformePagoBasico['span-nombre-supervisor'] = '';
			$formInformePagoBasico['span-rol-supervisor'] = '';
			$formInformePagoBasico['span-cargo-supervisor'] = '';
		}
		echo json_encode($formInformePagoBasico);
	}
	public function getInformePagoBasicoPk($idInforme)
	{
		$tbInformePagoPersonaBasicoDAO = $this->contenedor["tbInformePagoPersonaBasicoDAO"];
		$informePagoBasico = $tbInformePagoPersonaBasicoDAO->getInformePagoBasicoPk($idInforme);
		$formInformePagoBasico = $this->convertionFormName($informePagoBasico);
		$tbPersona2017 = $this->contenedor['tbPersona2017'];
		$tbPersona2017->setPkIdPersona($informePagoBasico["FK_Persona"]);
		$tbPersonaDAO = $this->contenedor['tbPersonaDAO'];
		$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
		$formInformePagoBasico["input-nombres-apellidos"] = $datosPersona["nombre"];
		$formInformePagoBasico["input-pago-numero"] = intval($formInformePagoBasico["input-pago-numero"]);
		$formInformePagoBasico['span-nombre-contratista-juramento'] = $datosPersona["nombre"];
		$formInformePagoBasico['span-nombre-contratista'] = $datosPersona["nombre"];
		$formInformePagoBasico['span-cargo-contratista'] = "Contratista";
		
		if (isset($informePagoBasico['FK_Persona_Apoyo_Supervisor'])){
			$tbPersona2017->setPkIdPersona($informePagoBasico['FK_Persona_Apoyo_Supervisor']);
			$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];	
		}
		$formInformePagoBasico['span-nombre-apoyo'] =  isset($informePagoBasico['FK_Persona_Apoyo_Supervisor']) ? $datosPersona["nombre"] : '';
		$formInformePagoBasico['span-cargo-apoyo'] = isset($informePagoBasico['FK_Persona_Apoyo_Supervisor']) ? $datosPersona["VC_Cargo"] : '';

		if (isset($informePagoBasico['FK_Persona_Apoyo_Supervisor_Dos'])){
			$tbPersona2017->setPkIdPersona($informePagoBasico['FK_Persona_Apoyo_Supervisor_Dos']);
			$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];	
		}
		$formInformePagoBasico['span-nombre-apoyo-dos'] =  isset($informePagoBasico['FK_Persona_Apoyo_Supervisor_Dos']) ? $datosPersona["nombre"] : '';
		$formInformePagoBasico['span-cargo-apoyo-dos'] = isset($informePagoBasico['FK_Persona_Apoyo_Supervisor_Dos']) ? $datosPersona["VC_Cargo"] : '';

		if (isset($informePagoBasico['FK_Persona_Supervisor'])){
			$tbPersona2017->setPkIdPersona($informePagoBasico['FK_Persona_Supervisor']);
			$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];	
		}
		$formInformePagoBasico['span-nombre-supervisor'] = isset($informePagoBasico['FK_Persona_Supervisor']) ? strtoupper($datosPersona["nombre"]) : '';

		if (isset($informePagoBasico['FK_Persona_Supervisor'])) {
			if ($datosPersona["FK_Id_Genero"] == "1") {
				$formInformePagoBasico['span-rol-supervisor'] = "Supervisor";
			}
			else
			{	
				if ($datosPersona["FK_Id_Genero"] == "2") {	
					$formInformePagoBasico['span-rol-supervisor'] = "Supervisora";
				}
				else{
					$formInformePagoBasico['span-rol-supervisor'] = "Supervisor(a)";
				}
			}
		}
		else{
			$formInformePagoBasico['span-rol-supervisor'] = "";
		}
		$formInformePagoBasico['span-cargo-supervisor'] = isset($informePagoBasico['FK_Persona_Supervisor']) ? $datosPersona["VC_Cargo"] : '';
		$formInformePagoBasico['select-supervisor'] = isset($informePagoBasico['FK_Persona_Supervisor']) ? $informePagoBasico["FK_Persona_Supervisor"] : null;
		$formInformePagoBasico['select-apoyo'] = isset($informePagoBasico['FK_Persona_Apoyo_Supervisor']) ? $informePagoBasico["FK_Persona_Apoyo_Supervisor"] : null;
		$formInformePagoBasico['select-apoyo-dos'] = isset($informePagoBasico['FK_Persona_Apoyo_Supervisor_Dos']) ? $informePagoBasico["FK_Persona_Apoyo_Supervisor_Dos"] : null;
		$formInformePagoBasico['select-apoyo-financiero'] = isset($informePagoBasico['FK_Aprobacion_Administrativo']) ? $informePagoBasico["FK_Aprobacion_Administrativo"] : null;
		$formInformePagoBasico['select-apoyo-auxiliar'] = isset($informePagoBasico['FK_Aprobacion']) ? $informePagoBasico["FK_Aprobacion"] : null;
		echo json_encode($formInformePagoBasico);
	}

	public function convertionFormName($informePago)
	{
			
		$form["input-numero-contrato"] = $informePago["VC_Numero_Contrato"];
		$form["select-identificacion"] = $informePago["VC_Tipo_Identificacion"];
		$form["input-identificacion"] = $informePago["VC_Identificacion"];
		$form["input-ciiu"] = $informePago["VC_Ciiu"];
		$form["input-nombres-apellidos-cedente"] = $informePago["VC_Nombres_Apellidos_Cedente"];
		$form["select-tipo-identificacion-cedente"] = $informePago["VC_Tipo_Identificacion_Cedente"];
		$form["input-identificacion-cendete"] = $informePago["VC_Identificacion_Cendete"];
		$form["input-identificacion-cedente"] = $informePago["VC_Identificacion_Cendete"];
		$form["select-banco"] = $informePago["VC_Banco"];
		$form["input-tipo-cuenta"] = $informePago["VC_Tipo_Cuenta"];
		$form["input-numero-cuenta"] = $informePago["VC_Numero_Cuenta"];
		$form["input-objeto"] = $informePago["VC_Objeto"];
		$form["input-fecha-inicio"] = $informePago["VC_Fecha_Inicio"];
		$form["input-plazo-inicial"] = $informePago["VC_Plazo_Inicial"];
		$form["input-prorrogas"] = $informePago["VC_Prorrogas"];
		$form["input-fecha-plazo-fin"] = $informePago["VC_Fecha_Plazo_Fin"];
		$form["input-fecha-fin"] = $informePago["VC_Fecha_Fin"];
		$form["input-numero-pagos"] = $informePago["VC_Numero_Pagos"];
		$form["input-pago-numero"] = $informePago["VC_Pago_Numero"];
		$form["input-numero-pagos"] = $informePago["VC_Pago_De_Total"];
		$form["input-pago-de-total"] = $informePago["VC_Pago_De_Total"];
		$form["input-valor-inicial"] = $informePago["VC_Valor_Inicial"];
		$form["input-valor-adicion-1"] = $informePago["VC_Valor_Adicion_1"];
		$form["input-valor-adicion-2"] = $informePago["VC_Valor_Adicion_2"];
		$form["input-valor-adicion-3"] = $informePago["VC_Valor_Adicion_3"];
		$form["input-valor-total-contrato"] = $informePago["VC_Valor_Total_Contrato"];
		$form["input-valor-pago-efectuar"] = $informePago["VC_Valor_Pago_Efectuar"];
		$form["input-finalizado"] = isset($informePago["SM_Finalizado"]) ? $informePago["SM_Finalizado"] : 0;
		$form["input-estado"] = isset($informePago["SM_Estado"]) ? $informePago["SM_Estado"] : "";
		
		$form["input-giros-efectuados"] = $informePago["VC_Giros_Efectuados"];
		$form["input-saldo-pediente"] = $informePago["VC_Saldo_Pediente"];
		$form["input-valor-liberar"] = $informePago["VC_Valor_Liberar"];
		$form["input-numero-obligaciones"] = $informePago["VC_Numero_Obligaciones"];
		$form["input-disminucion-retencion-no"] = $informePago["VC_Disminucion_Retencion"] == '0' ? "X":"";
		$form["input-disminucion-retencion-si"] = $informePago["VC_Disminucion_Retencion"] == '1' ? "X":"";
		$form["input-tomados-retencion-no"] = $informePago["VC_Tomados_Retencion"] == '0' ? "X":"";
		$form["input-tomados-retencion-si"] = $informePago["VC_Tomados_Retencion"] == '1' ? "X":"";

		if ($informePago["TX_Obligaciones_Json"] != "" && $informePago["TX_Obligaciones_Json"] != null) {
			$tx_obligaciones_json = json_decode($informePago["TX_Obligaciones_Json"]);
			foreach ($tx_obligaciones_json as $key => $value) {
				if (strpos($key, 'oblicacion') !== false || strpos($key, 'descripcion') !== false) {
					$form[$key]=$value;
				}
			}
		}

		$tx_rp_json = json_decode($informePago["TX_Rp_Json"]);
		$form["input-rp-contenido-a"] = $tx_rp_json->VC_Rp_Contenido_A;
		$form["select-codigo-a"] = $tx_rp_json->VC_Tipo_Codigo_A;
		$form["select-convenio-a"] = $tx_rp_json->VC_Tipo_Convenio_A;
		$form["input-rp-valor-a"] = $tx_rp_json->VC_Rp_Valor_A;
		$form["input-rp-contenido-b"] = $tx_rp_json->VC_Rp_Contenido_B;
		$form["select-codigo-b"] = $tx_rp_json->VC_Tipo_Codigo_B;
		$form["select-convenio-b"] = $tx_rp_json->VC_Tipo_Convenio_B;
		$form["input-rp-valor-b"] = $tx_rp_json->VC_Rp_Valor_B;
		$form["input-rp-contenido-c"] = $tx_rp_json->VC_Rp_Contenido_C;
		$form["select-codigo-c"] = $tx_rp_json->VC_Tipo_Codigo_C;
		$form["select-convenio-c"] = $tx_rp_json->VC_Tipo_Convenio_C;
		$form["input-rp-valor-c"] = $tx_rp_json->VC_Rp_Valor_C;
		$form["input-rp-contenido-d"] = $tx_rp_json->VC_Rp_Contenido_D;
		$form["select-codigo-d"] = $tx_rp_json->VC_Tipo_Codigo_D;
		$form["select-convenio-d"] = $tx_rp_json->VC_Tipo_Convenio_D;
		$form["input-rp-valor-d"] = $tx_rp_json->VC_Rp_Valor_D;

		if ($informePago["TX_Declaracion_Json"] != "" && $informePago["TX_Declaracion_Json"] != null) {
			$tx_declaracion_json = json_decode($informePago["TX_Declaracion_Json"]);
			$form["input-declaracion-1-si"] = $tx_declaracion_json->VC_Declaracion_1_Si;
			$form["input-declaracion-1-no"] = $tx_declaracion_json->VC_Declaracion_1_No;
			$form["input-declaracion-1-observacion"] = $tx_declaracion_json->VC_Declaracion_1_Observacion;
			$form["input-declaracion-2-si"] = $tx_declaracion_json->VC_Declaracion_2_Si;
			$form["input-declaracion-2-no"] = $tx_declaracion_json->VC_Declaracion_2_No;
			$form["input-declaracion-2-observacion"] = $tx_declaracion_json->VC_Declaracion_2_Observacion;
			$form["input-declaracion-3-si"] = $tx_declaracion_json->VC_Declaracion_3_Si;
			$form["input-declaracion-3-no"] = $tx_declaracion_json->VC_Declaracion_3_No;
			$form["input-declaracion-3-observacion"] = $tx_declaracion_json->VC_Declaracion_3_Observacion;
			$form["input-declaracion-4-si"] = $tx_declaracion_json->VC_Declaracion_4_Si;
			$form["input-declaracion-4-no"] = $tx_declaracion_json->VC_Declaracion_4_No;
			$form["input-declaracion-4-observacion"] = $tx_declaracion_json->VC_Declaracion_4_Observacion;
			$form["input-declaracion-5-si"] = $tx_declaracion_json->VC_Declaracion_5_Si;
			$form["input-declaracion-5-no"] = $tx_declaracion_json->VC_Declaracion_5_No;
			$form["input-declaracion-5-observacion"] = $tx_declaracion_json->VC_Declaracion_5_Observacion;
			$form["input-declaracion-6-si"] = $tx_declaracion_json->VC_Declaracion_6_Si;
			$form["input-declaracion-6-no"] = $tx_declaracion_json->VC_Declaracion_6_No;
			$form["input-declaracion-6-observacion"] = $tx_declaracion_json->VC_Declaracion_6_Observacion;
			$form["input-declaracion-7-si"] = $tx_declaracion_json->VC_Declaracion_7_Si;
			$form["input-declaracion-7-no"] = $tx_declaracion_json->VC_Declaracion_7_No;
			$form["input-declaracion-7-observacion"] = $tx_declaracion_json->VC_Declaracion_7_Observacion;
			$form["input-declaracion-8-si"] = isset($tx_declaracion_json->VC_Declaracion_8_Si) ? $tx_declaracion_json->VC_Declaracion_8_Si : "";
			$form["input-declaracion-8-no"] = isset($tx_declaracion_json->VC_Declaracion_8_No) ? $tx_declaracion_json->VC_Declaracion_8_No : "";
			$form["input-declaracion-8-observacion"] = isset($tx_declaracion_json->VC_Declaracion_8_Observacion) ? $tx_declaracion_json->VC_Declaracion_8_Observacion : "";
			$form["input-declaracion-9-si"] = isset($tx_declaracion_json->VC_Declaracion_9_Si) ? $tx_declaracion_json->VC_Declaracion_9_Si : "";
			$form["input-declaracion-9-no"] = isset($tx_declaracion_json->VC_Declaracion_9_No) ? $tx_declaracion_json->VC_Declaracion_9_No : "";
			$form["input-declaracion-9-observacion"] = isset($tx_declaracion_json->VC_Declaracion_9_Observacion) ? $tx_declaracion_json->VC_Declaracion_9_Observacion : "";
			$form["input-declaracion-10-si"] = isset($tx_declaracion_json->VC_Declaracion_10_Si) ? $tx_declaracion_json->VC_Declaracion_10_Si : "";
			$form["input-declaracion-10-no"] = isset($tx_declaracion_json->VC_Declaracion_10_No) ? $tx_declaracion_json->VC_Declaracion_10_No : "";
			$form["input-declaracion-10-observacion"] = isset($tx_declaracion_json->VC_Declaracion_10_Observacion) ? $tx_declaracion_json->VC_Declaracion_10_Observacion : "";
			$form["input-declaracion-11-si"] = isset($tx_declaracion_json->VC_Declaracion_11_Si) ? $tx_declaracion_json->VC_Declaracion_11_Si : "";
			$form["input-declaracion-11-no"] = isset($tx_declaracion_json->VC_Declaracion_11_No) ? $tx_declaracion_json->VC_Declaracion_11_No : "";
			$form["input-declaracion-11-observacion"] = isset($tx_declaracion_json->VC_Declaracion_11_Observacion) ? $tx_declaracion_json->VC_Declaracion_11_Observacion : "";
			$form["input-declaracion-12-si"] = isset($tx_declaracion_json->VC_Declaracion_12_Si) ? $tx_declaracion_json->VC_Declaracion_12_Si : "";
			$form["input-declaracion-12-no"] = isset($tx_declaracion_json->VC_Declaracion_12_No) ? $tx_declaracion_json->VC_Declaracion_12_No : "";
			$form["input-declaracion-12-observacion"] = isset($tx_declaracion_json->VC_Declaracion_12_Observacion) ? $tx_declaracion_json->VC_Declaracion_12_Observacion : "";
			$form["input-declaracion-13-si"] = isset($tx_declaracion_json->VC_Declaracion_13_Si) ? $tx_declaracion_json->VC_Declaracion_13_Si : "";
			$form["input-declaracion-13-no"] = isset($tx_declaracion_json->VC_Declaracion_13_No) ? $tx_declaracion_json->VC_Declaracion_13_No : "";
			$form["input-declaracion-13-observacion"] = isset($tx_declaracion_json->VC_Declaracion_13_Observacion) ? $tx_declaracion_json->VC_Declaracion_13_Observacion : "";
			$form["input-declaracion-14-si"] = isset($tx_declaracion_json->VC_Declaracion_14_Si) ? $tx_declaracion_json->VC_Declaracion_14_Si : "";
			$form["input-declaracion-14-no"] = isset($tx_declaracion_json->VC_Declaracion_14_No) ? $tx_declaracion_json->VC_Declaracion_14_No : "";
			$form["input-declaracion-14-observacion"] = isset($tx_declaracion_json->VC_Declaracion_14_Observacion) ? $tx_declaracion_json->VC_Declaracion_14_Observacion : "";
		}
		$form['span-rol-apoyo'] = "Apoyo a la Supervisión";

		if(isset($informePago["VC_Periodo_Inicio"])) $form["input-periodo-inicio"] = $informePago["VC_Periodo_Inicio"]; else $form["input-periodo-inicio"] = "";
		if(isset($informePago["VC_Periodo_Fin"])) $form["input-periodo-fin"] = $informePago["VC_Periodo_Fin"]; else $form["input-periodo-fin"] = "";
		if(isset($informePago["VC_Mes_Planilla"])) $form["input-mes-planilla"] = $informePago["VC_Mes_Planilla"]; else $form["input-mes-planilla"] = "";
		if(isset($informePago["VC_Observacion"])) $form["observacion"] = $informePago["VC_Observacion"]; else $form["observacion"] = "";
		if(isset($informePago["VC_Valor_Letras"])) $form["input-valor-letras"] = $informePago["VC_Valor_Letras"]; else $form["input-valor-letras"] = "";
		if(isset($informePago["VC_Numero_Planilla"])) $form["input-numero-planilla"] = $informePago["VC_Numero_Planilla"]; else $form["input-numero-planilla"] = "";
		if(isset($informePago["VC_Textarea_Producto"])) $form["textarea-producto"] = $informePago["VC_Textarea_Producto"]; else $form["textarea-producto"] = "";
		if(isset($informePago["TX_Planillas_Extras"])) $form["anexos-planillas"] = $informePago["TX_Planillas_Extras"]; else $form["anexos-planillas"] = "";
		if(isset($informePago["VC_Textarea_Mecanismo_Verificacion"])) $form["textarea-mecanismo-verificacion"] = $informePago["VC_Textarea_Mecanismo_Verificacion"]; else $form["textarea-mecanismo-verificacion"] = "";
		if(isset($informePago["VC_Fecha_Informe"])) $form["fecha-informe"] = $informePago["VC_Fecha_Informe"]; else $form["fecha-informe"] = "";
		if(isset($informePago["VC_Fecha_Informe"])) $form["input-fecha-informe"] = $informePago["VC_Fecha_Informe"]; else $form["fecha-informe"] = "";

		$form["observaciones-generales"] = $informePago["VC_Observacion_general"];

		return $form;
	}
	public function getListadoInformes($filtro, $origen = null)
	{
		$personaDAO = $this->contenedor['personaDAO'];
		$usuarioActual = $personaDAO->consultarCedulaUsuarioById($this->userId)[0];
		$filtro["userId"] = isset($filtro["userId"]) ? $filtro["userId"] : $this->userId;
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		if ($filtro["fechaFin"] != "")
			$filtro["fechaFin"] = explode("/", $filtro["fechaFin"])[2]."/".explode("/", $filtro["fechaFin"])[1]."/".explode("/", $filtro["fechaFin"])[0];
		$informes = $tbInformePagoPersonaDAO->getListadoInformes($filtro, $origen);

		$informesWS = [];
		#echo count($informes);
		#die();
		foreach($informes as $informe){
			if(strlen($informe['VC_orfeo_radicado'])>0){
				$infoRadicado = $this->firmaService->consultarRadicado($informe['VC_orfeo_radicado'],$informe['VC_orfeo_codigo_verificacion']);
				$informe['numero_radicado'] = $infoRadicado->numero_radicado;
				$informe['fecha_radicado'] = $infoRadicado->fecha_radicado;
				$informe['asunto'] = $infoRadicado->asunto;
				$informe['validado'] = $infoRadicado->validado;
				$informe['anulacion'] = $infoRadicado->anulacion;
			}else{
				$informe['numero_radicado'] = '';
				$informe['fecha_radicado'] = '';
				$informe['asunto'] = '';
				$informe['validado'] = '';
				$informe['anulacion'] = '';
			}
			$informesWS[] = $informe;
		}

		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('arrayInformes'=>$informesWS,'userId'=>$filtro["userId"],'historico'=>$filtro["historico"],'tipo'=>$filtro["tipo"][0],'rol'=>$this->rolId,'cedula'=>$usuarioActual['VC_Identificacion']));
		$vista->renderHtml();
	}

	public function getListadoInformesMejorado($filtros)
	{
		$personaDAO = $this->contenedor['personaDAO'];
		$usuarioActual = $personaDAO->consultarCedulaUsuarioById($this->userId)[0];		
		$filtros["userId"] = isset($filtros["userId"]) ? $filtros["userId"] : $this->userId;
		$fechaInicio = explode("/", $filtros["fecha_inicio"]);
		$fechaFin = explode("/", $filtros["fecha_fin"]);
		$filtros["fecha_inicio"] = $fechaInicio[2]."-".$fechaInicio[1]."-".$fechaInicio[0]." 00:00:00";
		$filtros["fecha_fin"] =  $fechaFin[2]."-".$fechaFin[1]."-".$fechaFin[0]." 23:59:59";
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$informes = $tbInformePagoPersonaDAO->getListadoInformesMejorado($filtros);
		$datosVista = array('arrayInformes'=>$informes,'userId'=>$this->userId,'rol'=>$this->rolId,'cedula'=>$usuarioActual['VC_Identificacion']);
		#var_dump($datosVista);
		#die();
		$vista= $this->contenedor['vista'];
		$vista->setVariables($datosVista);
		$vista->renderHtml();
	}
	
	public function verDatosOrfeo($informeId,$radicado,$codigoVerificacion){
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];		
		$infoRadicado = $this->firmaService->consultarRadicado($radicado,$codigoVerificacion);
		$informePago = $tbInformePagoPersonaDAO->getInformePagoFirmas($informeId)[0];
		$personaDAO = $this->contenedor['personaDAO'];
		$usuarioActual = $personaDAO->consultarCedulaUsuarioById($this->userId)[0];

		$html = "";		
		$vista= $this->contenedor['vista'];
		$vista->setVariables(['infoRadicado'=>$infoRadicado,'cedula'=>$usuarioActual['VC_Identificacion'],'informe'=>$informePago,'userId'=>$this->userId]);
		$html=$vista->returnHtml();	
		echo json_encode(['html'=>$html]);			
	}

	public function verFirmantes($informeId){
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];		
		$firmas = $tbInformePagoPersonaDAO->verFirmantes($informeId);
		$html = "";		
		$vista= $this->contenedor['vista'];
		$vista->setVariables(['firmas'=>$firmas]);
		$html=$vista->returnHtml();	
		echo json_encode(['html'=>$html]);			
	}	

	

	public function getListadoInformesBasicos($filtro)
	{
		
		$tbInformePagoPersonaBasicoDAO = $this->contenedor["tbInformePagoPersonaBasicoDAO"];
		$informes = $tbInformePagoPersonaBasicoDAO->getListadoInformesBasicos($filtro);
		$vista = $this->contenedor['vista'];

		$vista->setVariables(array('arrayInformes'=>$informes));
		$vista->renderHtml();
	}

	public function saveObservacion($datos,$informeId,$aprobado,$userId,$generales)
	{
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$aprobado = $aprobado == "true" ? 1 : 0;
		$aprobadoEstado = "";
		$result = 0;

		$tbInformePagoPersonaBasicoDAO = $this->contenedor["tbInformePagoPersonaBasicoDAO"];
		$informePago = $tbInformePagoPersonaDAO->getInformePago($informeId)[0];
		$personaInformeId = $informePago["FK_Persona"];
		$tempAprobadoEstado = $informePago['SM_Estado'] != null ? explode(",",$informePago['SM_Estado']) : array();
		$tempAprobadoEstado = array_filter($tempAprobadoEstado);
		$informePagoBasico = $tbInformePagoPersonaBasicoDAO->getInformePagoBasicoPersona($personaInformeId);
		if ($aprobado == 1){
			if ($informePagoBasico['FK_Persona_Apoyo_Supervisor'] == $userId && !in_array("1", $tempAprobadoEstado)){
				$result = 1;
				if (in_array("4", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["4"]);
				}
				array_push($tempAprobadoEstado,"1");
			}
			if ($informePagoBasico['FK_Aprobacion_Administrativo'] == $userId && !in_array("2", $tempAprobadoEstado)){
				$result = 2;
				if (in_array("5", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["5"]);
				}
				array_push($tempAprobadoEstado,"2");
			}
			/*if ($informePagoBasico['FK_Aprobacion'] == $userId && !in_array("3", $tempAprobadoEstado)){
				$result = 3;
				if (in_array("6", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["6"]);
				}
				array_push($tempAprobadoEstado,"3");
			}	*/
			if ($informePagoBasico['FK_Persona_Supervisor'] == $userId && !in_array("7", $tempAprobadoEstado)){
				$result = 4;
				if (in_array("8", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["8"]);
				}
				array_push($tempAprobadoEstado,"7");
			}
			if ($informePagoBasico['FK_Persona_Apoyo_Supervisor_Dos'] == $userId && !in_array("9", $tempAprobadoEstado)){
				$result = 5;
				if (in_array("0", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["0"]);
				}
				array_push($tempAprobadoEstado,"9");
			}			
			$finalizado = 1;
		}
		else{
			if ($informePagoBasico['FK_Persona_Apoyo_Supervisor'] == $userId && !in_array("4", $tempAprobadoEstado)){
				$result = 1;				
				if (in_array("1", $tempAprobadoEstado) || in_array("7", $tempAprobadoEstado) || in_array("9", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["1","7","9"]);
				}
				array_push($tempAprobadoEstado,"4");

				/*if (in_array("7", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["7"]);
					array_push($tempAprobadoEstado,"8");
				}*/
			}
			if ($informePagoBasico['FK_Aprobacion_Administrativo'] == $userId && !in_array("5", $tempAprobadoEstado)){
					$correccion_obligaciones = 0;
					if(!is_array($datos)){
						foreach ($datos as $key => $value) {
							if(strpos($key, 'input-descripcion') !== false){
								$correccion_obligaciones += 1;
							}
						}
					}
					if($correccion_obligaciones > 0) {
						$result = 2;
						if (in_array("2", $tempAprobadoEstado) || in_array("1", $tempAprobadoEstado) || in_array("7", $tempAprobadoEstado) || in_array("9", $tempAprobadoEstado)) {
							$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["1","2","7","9"]);
						}
						array_push($tempAprobadoEstado,"5");
					}
					else{
						$result = 2;
						if (in_array("2", $tempAprobadoEstado)) {
							$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["2"]);
						}
						array_push($tempAprobadoEstado,"5");
					}
			}
			/*if ($informePagoBasico['FK_Aprobacion'] == $this->userId && !in_array("6", $tempAprobadoEstado)){
				$result = 3;
				if (in_array("3", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["3"]);
				}
				array_push($tempAprobadoEstado,"6");
			}*/
			if ($informePagoBasico['FK_Persona_Supervisor'] == $this->userId && !in_array("8", $tempAprobadoEstado)){
				$result = 4;
				if (in_array("7", $tempAprobadoEstado) || in_array("1", $tempAprobadoEstado) || in_array("9", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["7","1","9"]);
				}
				array_push($tempAprobadoEstado,"8");

				/*if (in_array("1", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["1"]);
					array_push($tempAprobadoEstado,"4");
				}*/
			}
			if ($informePagoBasico['FK_Persona_Apoyo_Supervisor_Dos'] == $this->userId && !in_array("0", $tempAprobadoEstado)){
				$result = 5;
				if (in_array("7", $tempAprobadoEstado) || in_array("1", $tempAprobadoEstado) || in_array("9", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["7","1","9"]);
				}
				array_push($tempAprobadoEstado,"0");

				/*if (in_array("1", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["1"]);
					array_push($tempAprobadoEstado,"4");
				}*/
			}			
			$finalizado = 0;
		}
		$aprobadoEstado  = implode(",", $tempAprobadoEstado);

		$tbInformePagoPersonaDAO->saveObservacion(json_encode($datos),$informeId,$aprobadoEstado,$userId,$finalizado);
		
		if($generales != '') {
			$diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$hoy = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y'). " " .date("H:i:s");
			$arrInforme = json_decode($informePago['VC_Observacion_general'], true);
			$arrInforme['observacion'][] = array('usuario' => $this->userId, 'contenido' => strtoupper($generales), 'fecha' => $hoy);
			#Esto tambien debe ir a la tabla tb_informe_pago_firmas tanto cuando aprueba como cuando no
			$tbInformePagoPersonaDAO->saveObservacionGeneral(json_encode($arrInforme), $informeId);
		}

		echo json_encode($result);
		

		
	}

	public function saveEstadoInformePago($informeId,$estado,$userId)
	{
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$aprobadoEstado = "";
		$result = 0;
		$informePago = $tbInformePagoPersonaDAO->getInformePago($informeId)[0];
		$personaInformeId = $informePago["FK_Persona"];
		$tempAprobadoEstado = $informePago['SM_Estado'] != null ? explode(",",$informePago['SM_Estado']) : array();
		$tempAprobadoEstado = array_filter($tempAprobadoEstado);
		if ($estado != "-1"){
			$result = 1;
			if ($estado == "1") {
				$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["1","7","9"]);
				array_push($tempAprobadoEstado,"4");
			}
			if ($estado == "2") {
				$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["2"]);
				array_push($tempAprobadoEstado,"5");
			}
			if ($estado == "7") {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["1","7","9"]);
					array_push($tempAprobadoEstado,"8");
			}
			if ($estado == "9") {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["1","7","9"]);
					array_push($tempAprobadoEstado,"0");
			}

			/*if (in_array(($estado - 3), $tempAprobadoEstado) && ($estado == 4 || $estado == 5)){
				$tempAprobadoEstado = array_diff($tempAprobadoEstado, [($estado - 3)]);
			}
			else{
				if (in_array(7, $tempAprobadoEstado) && $estado == 8){
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, [7]);
				}
			}

			array_push($tempAprobadoEstado,$estado);*/
		}
		$aprobadoEstado  = $estado != "-1" ? implode(",", $tempAprobadoEstado) : $estado;
		$filasAfectadas = $tbInformePagoPersonaDAO->saveEstadoInformePago($informeId,$aprobadoEstado,$userId);
		echo json_encode($filasAfectadas);
	}
	public function saveEstadoInformeDetallado($informeId,$estado,$userId)
	{
		$estado = intval($estado);
		$aprobadoEstado = "";
		$tbInformeDetalladoPersonaDAO = $this->contenedor["tbInformeDetalladoPersonaDAO"];
		$informePagoDetallado = $tbInformeDetalladoPersonaDAO->getInformeDetallado($informeId)[0];
		$tempAprobadoEstado = $informePagoDetallado['SM_Estado'] != null ? explode(",",$informePagoDetallado['SM_Estado']) : array();
		$tempAprobadoEstado = array_filter($tempAprobadoEstado);
		if (!in_array($estado, $tempAprobadoEstado) && $estado != 0){
			$result = 1;
			if (in_array(($estado - 3), $tempAprobadoEstado))
				$tempAprobadoEstado = array_diff($tempAprobadoEstado, [($estado - 3)]);
			array_push($tempAprobadoEstado,$estado);
		}
		$aprobadoEstado  = $estado != 0 ? implode(",", $tempAprobadoEstado) : $estado;

		$filasAfectadas = $tbInformeDetalladoPersonaDAO->saveEstadoInformeDetallado($informeId,$aprobadoEstado,$userId);
		$tbInformeDetalladoPersona = $this->contenedor["tbInformeDetalladoPersona"];
		$tbInformeDetalladoPersona->setFkIdInformePago($informeId);
		$tbInformeDetalladoPersonaDAO->saveInformeDetalladoLog($tbInformeDetalladoPersona);
		if ($filasAfectadas == 1)
			echo json_encode(1);
		else
			echo json_encode($filasAfectadas);
	}
	public function saveObservacionInformeDetallado($datos,$informeId,$aprobado,$userId)
	{
		$tbInformeDetalladoPersonaDAO = $this->contenedor["tbInformeDetalladoPersonaDAO"];
		$aprobado = $aprobado == "true" ? 1 : 0;
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$informePago = $tbInformePagoPersonaDAO->getInformePago($informeId)[0];
		$personaInformeId = $informePago["FK_Persona"];
		$informePagoDetallado = $tbInformeDetalladoPersonaDAO->getInformeDetallado($informeId)[0];
		$tempAprobadoEstado = $informePagoDetallado['SM_Estado'] != null ? explode(",",$informePagoDetallado['SM_Estado']) : array();
		$tempAprobadoEstado = array_filter($tempAprobadoEstado);
		if ($aprobado == 1) {

			if (($informePagoDetallado['FK_Persona_Apoyo_Supervisor'] == $userId || $informePagoDetallado['FK_Persona_Supervisor'] == $userId) && !in_array("1", $tempAprobadoEstado)){
				$result = 1;
				if (in_array("4", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["4"]);
				}
				array_push($tempAprobadoEstado,"1");
			}
			if ($informePagoDetallado['FK_Aprobacion'] == $userId && !in_array("2", $tempAprobadoEstado)){
				$result = 2;
				if (in_array("5", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["5"]);
				}
				array_push($tempAprobadoEstado,"2");
			}
			$finalizado = 1;
		}
		else
		{
			if (($informePagoDetallado['FK_Persona_Apoyo_Supervisor'] == $userId || $informePagoDetallado['FK_Persona_Supervisor'] == $userId) && !in_array("4", $tempAprobadoEstado)){
				$result = 1;				
				if (in_array("1", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["1"]);
				}
				array_push($tempAprobadoEstado,"4");
			}
			if ($informePagoDetallado['FK_Aprobacion'] == $userId && !in_array("5", $tempAprobadoEstado)){
				$result = 2;
				if (in_array("2", $tempAprobadoEstado)) {
					$tempAprobadoEstado = array_diff($tempAprobadoEstado, ["2"]);
				}
				array_push($tempAprobadoEstado,"5");
			}
			$finalizado = 0;
		}
		$aprobadoEstado  = implode(",", $tempAprobadoEstado);
		$filasAfectadas = $tbInformeDetalladoPersonaDAO->saveObservacion(json_encode($datos),$informeId,$aprobadoEstado,$userId,$finalizado);
		$tbInformeDetalladoPersona = $this->contenedor["tbInformeDetalladoPersona"];
		$tbInformeDetalladoPersona->setFkIdInformePago($informeId);
		$tbInformeDetalladoPersonaDAO->saveInformeDetalladoLog($tbInformeDetalladoPersona);
		if ($filasAfectadas == 1)
			echo json_encode(1);
		else
			echo json_encode($filasAfectadas);
	}
	/**
	 * Guarda el informe de pago Detallado, bien sea nuevo o edicion de uno anterior
	 * @param  Array $formularioJson Todos los campos del formulario asi como adicionales como el id del  informe de pago
	 * @param  Array $archivos       Archivo Anexo del informe de pago, no es requiered (posiblemente funciona para mas de 1 archivo pero inicialmente es solo para uno)
	 * @return Integer               Retorna el estado de la peticion, Exito u Error, 1 para Todo correcto, 2 para error de insert, 3 para error al subir arhivo en caso de que se adjunte,
	 *                               4 tamaño maximo excedido
	 */
	public function saveInformePagoDetallado($formularioJson,$archivos,$fileSelectedInforme)
	{
		$state = 0;
		$datos = json_decode($formularioJson,true);
		$datos["userId"] = isset($datos["userId"]) ? $datos["userId"] : $this->userId;
		$revision = $datos["revision"] == "true" ? 1 : 0;
		$territorial = $datos["territorial"] == "true" ? 1 : 0;
		$datos["codigo-territorial"] = 0;
		if ($territorial)
			$datos["codigo-territorial"] = $datos["tipo-territorial"];
		$tbInformeDetalladoPersonaDAO = $this->contenedor['tbInformeDetalladoPersonaDAO'];
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$tbInformeDetalladoPersona = $this->contenedor["tbInformeDetalladoPersona"];
		$informePago = $tbInformePagoPersonaDAO->getInformePago($datos["FK_Informe_Selected"])[0];
		$datos["FK_Persona"] = $informePago["FK_Persona"];
		$urlAnexo = "";
		if ($archivos != null)
			$urlAnexo = $this->subirArchivos($datos['FK_Persona'],$archivos,'Anexos',1,'tbInformeDetalladoPersonaDAO','limpiarAnexosFormatos');
		else
			$urlAnexo = $fileSelectedInforme;

		$tbInformeDetalladoPersona->setFkIdInformePago($datos["FK_Informe_Selected"]);
		$tbInformeDetalladoPersona->setFkPersona($datos["userId"]);
		$tbInformeDetalladoPersona->setVcPeriodoInicio($informePago["VC_Periodo_Inicio"]);
		$tbInformeDetalladoPersona->setVcPeriodoFin($informePago["VC_Periodo_Fin"]);
		$tbInformeDetalladoPersona->setVcNumeroContrato($informePago["VC_Numero_Contrato"]);
		$tbInformeDetalladoPersona->setVcNumeroObligaciones($informePago["VC_Numero_Obligaciones"]);
		$tbInformeDetalladoPersona->setInTipoTerritorial($datos["codigo-territorial"]);
		if ($urlAnexo == 3 || $urlAnexo == 4){
			$state = $urlAnexo;
			$urlAnexo = "";
		}
		$tbInformeDetalladoPersona->setVcUrlAnexo($urlAnexo);		
		$obligacionesDescrip = [];
		foreach ($datos as $key => $value) {
			if (strpos($key, 'descripcion') !== false) {
				$obligacionesDescrip[$key]=$value;
			}
		}
		$tbInformeDetalladoPersona->setTxObligacionesJson($obligacionesDescrip);
		$tbInformeDetalladoPersona->setSmFinalizado($revision);
		if (json_encode($tbInformeDetalladoPersonaDAO->saveInformeDetallado($tbInformeDetalladoPersona)) != 0 && $state == 0) {
			$tbInformeDetalladoPersonaDAO->saveInformeDetalladoLog($tbInformeDetalladoPersona);
			$state = 1;
		}
		echo json_encode($state);
	}

	public function getInformeDetallado($informeId)
	{
		$tbInformeDetalladoPersonaDAO = $this->contenedor['tbInformeDetalladoPersonaDAO'];
		$tbInformeDetalladoPersona = $this->contenedor["tbInformeDetalladoPersona"];
		$formInformeDetallado = [];	
		$informeDetallado = $tbInformeDetalladoPersonaDAO->getInformeDetallado($informeId);
		if (sizeof($informeDetallado) > 0) {
			$informeDetallado = $informeDetallado[0];
			$formInformeDetallado["input-url-anexo"] = $informeDetallado["VC_Url_Anexo"];	
			$formInformeDetallado["observacion"] = $informeDetallado["VC_Observacion"];	
			$formInformeDetallado["tipo-territorial"] = $informeDetallado["IN_Tipo_Territorial"];	
			$formInformeDetallado["input-finalizado-detallado"] = $informeDetallado["SM_Finalizado"];	
			if ($informeDetallado["TX_Obligaciones_Json"] != "" && $informeDetallado["TX_Obligaciones_Json"] != null) {
				$tx_obligaciones_json = json_decode($informeDetallado["TX_Obligaciones_Json"]);
				foreach ($tx_obligaciones_json as $key => $value) {
					$formInformeDetallado[$key]=$value;
				}
			}	
			$tbPersona2017 = $this->contenedor['tbPersona2017'];
			$tbPersonaDAO = $this->contenedor['tbPersonaDAO'];
			
			$tbPersona2017->setPkIdPersona($informeDetallado['FK_Persona']);
			$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
			$formInformeDetallado['span-nombre-contratista'] = $datosPersona["nombre"];
			$formInformeDetallado['span-cargo-contratista'] = "Contratista";

			if ($informeDetallado['FK_Persona_Apoyo_Supervisor']) {
				$tbPersona2017->setPkIdPersona($informeDetallado['FK_Persona_Apoyo_Supervisor']);
				$datosPersona = $tbPersonaDAO->consultarObjeto($tbPersona2017)[0];
				$formInformeDetallado['span-nombre-apoyo'] =  $datosPersona["nombre"];
				$formInformeDetallado['span-cargo-apoyo'] = $datosPersona["VC_Cargo"];
			}
			else
			{
				$formInformeDetallado['span-nombre-apoyo'] =  '';
				$formInformeDetallado['span-cargo-apoyo'] = '';
			}
		}
		echo json_encode($formInformeDetallado);
	}

	public function getUltimoContratoActivo($userId)
	{
		$tbInformeDetalladoPersonaDAO = $this->contenedor['tbInformeDetalladoPersonaDAO'];
		$resultado = $tbInformeDetalladoPersonaDAO->getUltimoContratoActivo($userId);
		if(empty($resultado))
			echo json_encode(null);
		else
			echo json_encode($resultado);
	}

	public function updateRevisionSupervisor($informeId,$estado)
	{
		$estado = intval($estado);
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];		
		$filasAfectadas = $tbInformePagoPersonaDAO->updateRevisionSupervisor($informeId,$estado);
		echo json_encode($filasAfectadas);
	}

	public function inactivarInformePagoBasico($id_informe, $id_usuario){
		$tbInformePagoPersonaBasicoDAO = $this->contenedor["tbInformePagoPersonaBasicoDAO"];
		$result = $tbInformePagoPersonaBasicoDAO->inactivarInformePagoBasico($id_informe,$id_usuario);
		echo $result;
	}

	public function saveInformePagoBasicoAdmin($informe, $usuario){
		
		$tbInformePagoPersonaBasicoDAO = $this->contenedor["tbInformePagoPersonaBasicoDAO"];
		$informe["select-supervisor"] = !empty($informe["select-supervisor"]) ? $informe["select-supervisor"] : null;
		$informe["select-apoyo"] = !empty($informe["select-apoyo"]) ? $informe["select-apoyo"] : null;
		$informe["select-apoyo-dos"] = !empty($informe["select-apoyo-dos"]) ? $informe["select-apoyo-dos"] : null;
		$informe["select-apoyo-financiero"] = !empty($informe["select-apoyo-financiero"]) ? $informe["select-apoyo-financiero"] : null;

		$tbiformePagoPersonaBasico = $this->contenedor["informePagoPersonaBasico"];

		
		$tbiformePagoPersonaBasico->setFkPersona($informe["select-contratista"]);
		$tbiformePagoPersonaBasico->setVcNumeroContrato($informe["input-numero-contrato"]);
		$tbiformePagoPersonaBasico->setVcTipoIdentificacion($informe["select-identificacion"]);
		$tbiformePagoPersonaBasico->setVcIdentificacion($informe["input-identificacion"]);
		$tbiformePagoPersonaBasico->setVcCiiu($informe["input-ciiu"]);
		$tbiformePagoPersonaBasico->setVcObjeto($informe["input-objeto"]);
		$tbiformePagoPersonaBasico->setVcFechaInicio($informe["input-fecha-inicio"]);
		$tbiformePagoPersonaBasico->setVcFechaFin($informe["input-fecha-fin"]);
		$tbiformePagoPersonaBasico->setVcNumeroPagos(0);
		$tbiformePagoPersonaBasico->setVcPagoNumero(0);
		$tbiformePagoPersonaBasico->setVcPagoDeTotal(0);
		$tx_rp_json["VC_Rp_Contenido_A"] = $informe["input-rp-contenido-a"];
		$tx_rp_json["VC_Tipo_Codigo_A"] = $informe["select-codigo-a"];
		$tx_rp_json["VC_Tipo_Convenio_A"] = $informe["select-convenio-a"];
		$tx_rp_json["VC_Rp_Valor_A"] = $informe["input-rp-valor-a"];
		$tx_rp_json["VC_Rp_Contenido_B"] = $informe["input-rp-contenido-b"];
		$tx_rp_json["VC_Tipo_Codigo_B"] = $informe["select-codigo-b"];
		$tx_rp_json["VC_Tipo_Convenio_B"] = $informe["select-convenio-b"];
		$tx_rp_json["VC_Rp_Valor_B"] = $informe["input-rp-valor-b"];
		$tx_rp_json["VC_Rp_Contenido_C"] = $informe["input-rp-contenido-c"];
		$tx_rp_json["VC_Tipo_Codigo_C"] = $informe["select-codigo-c"];
		$tx_rp_json["VC_Tipo_Convenio_C"] = $informe["select-convenio-c"];
		$tx_rp_json["VC_Rp_Valor_C"] = $informe["input-rp-valor-c"];
		$tx_rp_json["VC_Rp_Contenido_D"] = $informe["input-rp-contenido-d"];
		$tx_rp_json["VC_Tipo_Codigo_D"] = $informe["select-codigo-d"];
		$tx_rp_json["VC_Tipo_Convenio_D"] = $informe["select-convenio-d"];
		$tx_rp_json["VC_Rp_Valor_D"] = $informe["input-rp-valor-d"];
		$tbiformePagoPersonaBasico->setTxRpJson($tx_rp_json);
		$tbiformePagoPersonaBasico->setVcValorInicial($informe["input-valor-inicial"]);
		$tbiformePagoPersonaBasico->setVcValorAdicion1($informe["input-valor-adicion-1"]);
		$tbiformePagoPersonaBasico->setVcValorAdicion2($informe["input-valor-adicion-2"]);
		$tbiformePagoPersonaBasico->setVcValorAdicion3($informe["input-valor-adicion-3"]);
		$tbiformePagoPersonaBasico->setVcValorTotalContrato($informe["input-valor-total-contrato"]);
		$tbiformePagoPersonaBasico->setVcValorPagoEfectuar($informe["input-valor-pago-efectuar"]);
		$tbiformePagoPersonaBasico->setVcGirosEfectuados($informe["input-giros-efectuados"]);
		$tbiformePagoPersonaBasico->setVcSaldoPediente($informe["input-saldo-pediente"]);
		$tbiformePagoPersonaBasico->setVcValorLiberar($informe["input-valor-liberar"]);
		$tbiformePagoPersonaBasico->setFkPersonaSupervisor($informe["select-supervisor"]);
		$tbiformePagoPersonaBasico->setFkPersonaApoyoSupervisor($informe["select-apoyo"]);
		$tbiformePagoPersonaBasico->setFkPersonaApoyoSupervisordos($informe["select-apoyo-dos"]);
		$tbiformePagoPersonaBasico->setFkAprobacionAdministrativo($informe["select-apoyo-financiero"]);
		$tbiformePagoPersonaBasico->setFkPersonaActualizo($usuario);
		
		$result = $tbInformePagoPersonaBasicoDAO->saveInformePagoBasicoAdmin($tbiformePagoPersonaBasico);
		$result = $tbInformePagoPersonaBasicoDAO->saveInformePagoBasicoAdminLog(null);
		echo $result;
	}

	public function validarPeriodo($userId,$fechaFin){
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		if ($tbInformePagoPersonaDAO->validarPeriodo($userId,$fechaFin)[0]["cantidad"] == 0)
			echo "0";
		else
			echo "5";
	}
	public function validarExistenciaContrato($codigo_contrato){
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		if ($tbInformePagoPersonaDAO->validarExistenciaContrato($codigo_contrato)[0]["cantidad"] == 0)
			echo "0";
		else
			echo "1";
	}

	public function consultarMesesInformes(){
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$meses = $tbInformePagoPersonaDAO->consultarMesesInformes();
		foreach ($meses as $k => $v) {
			echo "<option value='".$v['mes']."/".$v['anio']."'>".$v['mes']."/".$v['anio']."</option>";
		}
	}

	public function habilitarCertificadoFinalContrato($personaInformeId,$usuario){
		$tbInformePagoPersonaBasicoDAO = $this->contenedor["tbInformePagoPersonaBasicoDAO"];
		$tbiformePagoPersonaBasico = $this->contenedor["informePagoPersonaBasico"];

		$tbiformePagoPersonaBasico->setFkPersona($personaInformeId);
		$tbiformePagoPersonaBasico->setInCertificadoFinal(1);
		$tbiformePagoPersonaBasico->setFkPersonaActualizo($usuario);
		
		$result = $tbInformePagoPersonaBasicoDAO->habilitarCertificadoFinalContrato($tbiformePagoPersonaBasico);
		echo $result;
	}

	public function consultarRadicadoOrfeo($datos){
		// var_dump($datos);
		$auten=array('token'=>'fb431aae604805920a321415c496276f330f748ec6c13518fbf8e1b400b61966','app'=>'APPSIF');
		$datos_ws = array('autent'=>$auten,'radicado'=>$datos['radicado'], 'codVerificacion'=>$datos['codigo_verificacion']);
		$rta = $this->llamarWS('descargarDocumento', $datos_ws);
		// var_dump($rta);
		echo $rta['path'];
	}

	public function getTrazabilidadInforme($contrato, $mes){
		$tbInformePagoPersonaDAO = $this->contenedor['tbInformePagoPersonaDAO'];
		$Datos = $tbInformePagoPersonaDAO->getTrazabilidadInforme($contrato, $mes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}

	public function deleteObservacionGen($posicion, $contrato){
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$informePago = $tbInformePagoPersonaDAO->getInformePago($contrato)[0];
		$observacionesGrales = json_decode($informePago['VC_Observacion_general'], true);
		unset($observacionesGrales['observacion'][$posicion]);
		$tbInformePagoPersonaDAO->saveObservacionGeneral(json_encode($observacionesGrales), $contrato);
	}

	public function cargarSelectOrfeo()
	{
		$ParametroDAO = $this->contenedor['ParametroDAO'];
        $nombres_archivos_orfeo = $ParametroDAO->getParametroDetalle(65);
		echo json_encode($nombres_archivos_orfeo);
	}

	public function uploadedDocument($id_informe, $formData, $id_persona, $id_parametro, $id_contrato)
	{

		$hoy = date('Y-m-d H:i:s');
	
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$tbInformePagoAnexosOrfeo = $this->contenedor['TbInformePagoAnexosOrfeo'];
		
		$tbInformePagoAnexosOrfeo->setFkPersona($id_persona);
		$tbInformePagoAnexosOrfeo->setFkInformePagoPersona($id_informe);
		$tbInformePagoAnexosOrfeo->setFkParametroD($id_parametro);
		$informePago = $tbInformePagoPersonaDAO->getInformePago($id_informe)[0];
		$anio = explode('-',$informePago['VC_Numero_Contrato'])[1];
		$numeroPago = $informePago['VC_Pago_Numero'];
		$urlAnexoOrfeo = $this->subirAnexos($id_persona,$formData,'Anexos',$anio,$numeroPago,0);
		$tbInformePagoAnexosOrfeo->setTxAnexo($urlAnexoOrfeo);
		$tbInformePagoAnexosOrfeo->setDtDate($hoy);
		$tbInformePagoAnexosOrfeo->setFkInformePagoBasico($id_contrato);

		$result = $tbInformePagoPersonaDAO->getAnexoOrfeo($id_parametro, $id_informe);
		print_r(count($result));
		if (count($result) == 0) {
			$tbInformePagoPersonaDAO->saveAnexosOrfeo($tbInformePagoAnexosOrfeo);
		}else{
			$tbInformePagoPersonaDAO->updateAnexosOrfeo($tbInformePagoAnexosOrfeo);
		}

	}

	public function deleteAnexoOrfeo($idAnexo)
	{
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		echo json_encode($tbInformePagoPersonaDAO->deleteAnexoOrfeo($idAnexo));
		
	}

	public function getUltimoInforme($userId)
	{
		$tbInformeDetalladoPersonaDAO = $this->contenedor['tbInformeDetalladoPersonaDAO'];
		$resultado = $tbInformeDetalladoPersonaDAO->getUltimoInforme($userId);
		if(empty($resultado))
			echo json_encode(null);
		else
			echo json_encode($resultado);
	}

	public function getParametrosAnexosOrfeo($numeroPago){
		
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$nombres_archivos_orfeo = $tbInformePagoPersonaDAO->getTiposAnexosObligatoriosNumeroPago($numeroPago);
		echo json_encode($nombres_archivos_orfeo);

		/*
		$ParametroDAO = $this->contenedor['ParametroDAO'];

        $nombres_archivos_orfeo = $ParametroDAO->getParametroDetalleFlag(65, $first, $last);
		echo json_encode($nombres_archivos_orfeo);
		*/
	}

	public function obtenerUsuarioResponse($iCedula)
    {
        $usuarioResponse =$this->firmaService->obtenerUsuarioResponse(trim($iCedula));
        return response()->json($usuarioResponse->toArray());  
    }

    public function solicitarCodigoSeguridad($iCedula)
    {
		//echo "<pre>".print_r($iCedula, true)."</pre>";
        $usuarioResponse =$this->firmaService->obtenerUsuarioResponse(trim($iCedula));
		if($usuarioResponse == false){
			echo $usuarioResponse;
		}else{

			echo json_encode($this->firmaService->solicitarCodigoSeguridad($usuarioResponse));  
		}
    }

	public function saveFirma($idPersona, $idInforme, $token, $aprobado, $observacion)
	{
	 
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$tbInformePagoFirma = $this->contenedor['TbInformePagoFirmas'];

		$personaDAO = $this->contenedor['personaDAO'];
		$usuarioActual = $personaDAO->consultarInformacionUsuarioById($this->userId)[0];		
		$usuarioResponse =$this->firmaService->obtenerUsuarioResponse(trim($usuarioActual['VC_Identificacion']));

		$informe = $tbInformePagoPersonaDAO->getInformePagoFirmas($idInforme)[0];

		$transaccion = "APROBADO"; 
		if($aprobado['aprobacion'] == 1){
			if($informe['FK_Persona'] == $idPersona){
				$transaccion = "PROYECTADO";
			}
			else if($informe['FK_Persona_Supervisor'] != null && $informe['FK_Persona_Supervisor']  == $idPersona){
				$transaccion = "APROBADO";
			}
			else{
				$transaccion = "REVISADO";
			}
		}else{
			$transaccion = "DEVUELTO";
		}

		$tbInformePagoFirma->setFkUsuarioOrfeo($usuarioResponse->getIdResponse());
		$tbInformePagoFirma->setFkPersona($idPersona);
		$tbInformePagoFirma->setFkInformePagoPersona($idInforme);
		$tbInformePagoFirma->setVcToken($token);
		$tbInformePagoFirma->setIAprobado($aprobado['aprobacion']);
		$tbInformePagoFirma->setVcObservacion($observacion);
		$tbInformePagoFirma->setVctransaccion($transaccion);
		$tbInformePagoFirma->setVcSistemaOperativo($aprobado['sistemaOperativo']);
		$tbInformePagoFirma->setVcNavegador($aprobado['navegador']);
		$tbInformePagoFirma->setVcNavegadorVersion($aprobado['navegadorVersion']);
		$tbInformePagoFirma->setVcDireccionIp($this->obtenerIP());
		
		echo $tbInformePagoPersonaDAO->saveFirma($tbInformePagoFirma);

	}

    public function radicarInformePago($informeId)
	{ 
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$informePago = $tbInformePagoPersonaDAO->getInformePago($informeId)[0];	
		$historicoInformePago = $tbInformePagoPersonaDAO->getHistoricoAprobacionesInformePago($informeId);
		#Contratista
		$usuarioRadicador =$this->firmaService->obtenerUsuarioResponse(trim($informePago["VC_Identificacion"]));	
		$informePagoResponse = new InformePago($informePago["PK_Id_Tabla"],$informePago["VC_Numero_Contrato"],$usuarioRadicador,$informePago['VC_Pago_Numero'],$informePago['VC_Pago_De_Total']);
		#Jose Alexander Bulla
        $usuarioActual =$this->firmaService->obtenerUsuarioResponse("80115231");
        return $this->firmaService->radicarInformePago($informePagoResponse, $usuarioActual, $historicoInformePago);   


    } 
	
	public function radicarInformePagoArchivos($archivos,$informeId)
	{
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$informePago = $tbInformePagoPersonaDAO->getInformePago($informeId)[0];
		$anio = explode('-',$informePago['VC_Numero_Contrato'])[1];
		$numeroPago = $informePago['VC_Pago_Numero'];
		#Consultar si existe el Expediente para el contrato
		if(strlen($informePago['VC_Expediente'])== 0)
		{
			$expediente = $this->firmaService->consultarExpediente(trim($informePago['VC_Identificacion']),$anio);
		}
		#echo '<pre>'.print_r($expediente,true).'</pre>';
		#die(); 
		#Solo Radica cuando todos hayan aprobado 
		$archivosSubidos = $this->subirArchivosBase64($informePago['FK_Persona'],$archivos,'Anexos',$anio,$numeroPago,0);
		if(is_array($archivosSubidos)){
			$radicado = $this->radicarInformePago($informeId,$userId);		
			#guardar datos de radicado en SIF 
			$tbInformePagoPersonaDAO->updateRadicadoInformePago($radicado);
			#Subir Documento Principal a Orfeo y Certificados de cumplimiento
			$tiposDocumentos = $tbInformePagoPersonaDAO->getTiposAnexosObjeto();
			#echo '<pre>'.print_r($tiposDocumentos[3]->getOrden(),true).'</pre>';
			#die(); 
			$anexosRadicado = [];
			$anexosRadicado[1] = new RadicadoDocumentoResponse($archivosSubidos['informePago'],'Documento Principal del Informe de Pago',3,true,$tiposDocumentos[1]);
			$anexosRadicado[10] = new RadicadoDocumentoResponse($archivosSubidos['certificadoMensual'],'Certificado de cumplimiento mensual Informe de Pago',2,false,$tiposDocumentos[10]);
			#Busqueda de otros anexos, llegan ordenados
			$otrosAnexos = $tbInformePagoPersonaDAO->getAnexosInformePago($informeId);
			foreach($otrosAnexos as $anexo){				
				$anexosRadicado[$anexo['FK_Parametro_Detalle']] = new RadicadoDocumentoResponse($anexo['Tx_Anexo'],$anexo['VC_nombre'],10,false,$tiposDocumentos[$anexo['FK_Parametro_Detalle']]);
			}   
			#echo '<pre>'.print_r($anexosRadicado,true).'</pre>';
			#die();
			ksort($anexosRadicado); 
			$radicado->setDocumentos($anexosRadicado);
			$radicado = $this->firmaService->asociarDocumentoPrincipal($radicado);
			#guardar AnexoId Archivo Principal  
			$actualiza = $tbInformePagoPersonaDAO->updateIdAnexoInformePago($radicado);			
			#Subir Anexos a Orfeo
			$cantidadAnexosSubidos = $this->firmaService->asociarAnexosRadicado($radicado);

			#Asociar Expediente
			if($expediente != false)
			{
				$radicado->getInformePago()->setExpediente($expediente);
				$incluyeExpediente = $this->firmaService->incluirExpediente($radicado);			
			}else{
				$incluyeExpediente = false;
			}
			
			#Respuesta
			$type = 'success';
			$numeroExpediente = $incluyeExpediente != false ? 'con Expediente: '.$expediente : 'Sin Expediente';
			$docPrincipal = $actualiza > 0 ? ", con documento Principal" : ", sin documento Principal";
			$mensaje = "Se ha radicado el informe pago con #: "
						.$radicado->getNumeroRadicado().", ".$numeroExpediente." ".$docPrincipal." y (".$cantidadAnexosSubidos.") anexos cargados";
			echo json_encode([
				'type'=>$type,
				'title'=>"Radicado Correctamente",
				'message'=>$mensaje,
			]);
		}else{
			echo json_encode([
				'type'=>'error',
				'title'=>"error",
				'message'=>"No se pudo radicar el informe en ORFEO, Contacte al administrador.",
			]);
		}
	}

	public function subirArchivosBase64($id_usuario,$archivos,$folder,$anio,$numeroPago,$cleanForlder = 0)
	{
		$backtrace = debug_backtrace()[1];
		if ($namespace == null)
			$namespace = substr($backtrace['class'],0, strpos($backtrace['class'],'\\'));
		$rutaBase =   substr($backtrace['file'],0, strpos($backtrace['file'],'src'));
		$folder_create = $id_usuario.'/'.$anio.'/'.$numeroPago.'/';
		$carpeta = $rutaBase.'uploadedFiles/'.$namespace.'/'.$folder.'/'.$folder_create;
		$ubicacion = "../../uploadedFiles/".$namespace.'/'.$folder.'/'.$folder_create;
		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return false;
		} 
		else{
			$rutaArchivos = [];
			if ($cleanForlder == 1 && sizeof($archivos) > 0){
				$this->cleanFolder($carpeta);
			}
			foreach ($archivos as $nombre=>$base64) {
				$decodedData = base64_decode($base64);
				$rutaCompleta = $carpeta.$nombre.'.pdf';
				$fp = fopen($rutaCompleta, 'wb');
				fwrite($fp, $decodedData);
				if(fclose($fp))
				{
					$rutaArchivos[$nombre] = $rutaCompleta;
				}			
			}
			return count($rutaArchivos)> 0 ? $rutaArchivos : false ;            
		}		
	}

	protected function subirAnexos($id_usuario, $archivos, $folder, $anio,$numeroPago, $cleanForlder = 0)
	{
		$backtrace = debug_backtrace()[1];
		if ($namespace == null)
			$namespace = substr($backtrace['class'],0, strpos($backtrace['class'],'\\'));
		$rutaBase =   substr($backtrace['file'],0, strpos($backtrace['file'],'src'));
		$folder_create = $id_usuario.'/'.$anio.'/'.$numeroPago.'/';
		$carpeta = $rutaBase.'uploadedFiles/'.$namespace.'/'.$folder.'/'.$folder_create;
		$ubicacion = "../../uploadedFiles/".$namespace.'/'.$folder.'/'.$folder_create;
		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return 4;
		} 
		else{
			$rta = "";
			if ($cleanForlder == 1 && sizeof($archivos) > 0){
				$this->cleanFolder($carpeta);
			}
			foreach ($archivos as $archivo) {
				
				$ruta = $carpeta.$this->clean($archivo['name']);
				if ($rta != "4"){					
					if (move_uploaded_file($archivo['tmp_name'] , $ruta)){
						$rta .= $carpeta.$this->clean($archivo['name'])."///";	
					}
					else
						$rta = "4";
				}
			}
			$rta = rtrim($rta,"///");
			return $rta;            
		} 
	}
		

	public function firmaElectronicaDocumento($informeId)
	{
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$informePago = $tbInformePagoPersonaDAO->getInformePago($informeId)[0];
		$arreglofirmas=$tbInformePagoPersonaDAO->getFirmasInformePago($informeId);
		$retornoFirma = $this->firmaService->firmaElectronicaInforme($arreglofirmas,$informePago);	
		$infoRadicado = $this->firmaService->consultarRadicado($informePago['VC_orfeo_radicado'],$informePago['VC_orfeo_codigo_verificacion']);
		#var_dump($infoRadicado);
		#die();
		$firmo = 0;
		if($infoRadicado->validado == 'Documento Firmado electrónicamente' ||
		   strpos($infoRadicado->validado,'VALIDADO') !==  FALSE){
			$firmo = 1;
		}
		$tbInformePagoPersonaDAO->updateIRadicadoInforme($firmo,$informeId);	
		echo json_encode($infoRadicado); 
	}

	
	public function getNumDocument($userId)
	{ 
		$persona = $this->contenedor['personaDAO'];
		$informacion_usuario = $persona->consultarInformacionUsuarioById($userId);
		echo json_encode($informacion_usuario);
    } 

	public function getInformePagoAnexos($informeId,$visualizacion,$cesion = '')
	{
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$otrosAnexos = [];
		if($visualizacion == 'C'){
			#Tiene que buscar por el Padre
			$informePago = $tbInformePagoPersonaDAO->getUltimoInformePagoPersonaPorBasico($informeId);
			$pagoActual = strlen($informePago["VC_Pago_Numero"]) > 0 ? $informePago["VC_Pago_Numero"] : $informePago["VC_Pago_Numero_Basico"];
			$totalPagos = strlen($informePago["VC_Numero_Pagos"]) > 0 ? $informePago["VC_Numero_Pagos"] : $informePago["VC_Numero_Pagos_Basico"];
			$numeroPago = $this->obtenerNumeroPagoAnexos($pagoActual+1,$totalPagos);
			if($cesion == 'CESION'){
				$numeroPago = $this->obtenerNumeroPagoAnexos(1,$totalPagos);
			}else{
				$numeroPago = $this->obtenerNumeroPagoAnexos($pagoActual+1,$totalPagos);
			}
			
		}else{
			$otrosAnexos = $tbInformePagoPersonaDAO->getAnexosInformePago($informeId);
			$informePago = $tbInformePagoPersonaDAO->getInformePago($informeId)[0];
			$numeroPago = $this->obtenerNumeroPagoAnexos($informePago["VC_Pago_Numero"],$informePago["VC_Numero_Pagos"]);
		}	
		$nombres_archivos_orfeo = $tbInformePagoPersonaDAO->getTiposAnexosObligatoriosNumeroPago($numeroPago);
		#echo json_encode($nombres_archivos_orfeo);
		#die();
		$html = "";
		$vista= $this->contenedor['vista'];
		$vista->setVariables(['anexos'=>$otrosAnexos,'options'=>$nombres_archivos_orfeo,'visualizacion'=>$visualizacion]);
		$html=$vista->returnHtml();		

		echo json_encode(['html'=>$html]);			
	}

	function obtenerNumeroPagoAnexos($VC_Pago_Numero,$VC_Numero_Pagos){
		$pagoActual = intval($VC_Pago_Numero);
		$totalPagos = intval($VC_Numero_Pagos);
		if($pagoActual == 1){
			$numeroPago = 'I';
		}else if($pagoActual == $totalPagos){
			$numeroPago = 'F';
		}else{
			$numeroPago = 'O';
		}	
		return $numeroPago;
	}
	
	function getHistorial($idInforme){

		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$historicoInformePago = $tbInformePagoPersonaDAO->getHistoricoAprobacionesInformePago($idInforme);
		
		echo json_encode($historicoInformePago);
	}

	public function obtenerIP() {  

		//si utilizamos un CDN, por ejemplo Cloudflare, genera un header con la IP real del cliente que se conecta  
		  if( isset($_SERVER['HTTP_CF_CONNECTING_IP']) )  
			  return $_SERVER['HTTP_CF_CONNECTING_IP'];  
  
		//dependiendo de la configuración de proxys o apache o nginx tenemos varias variables de servidor que PHP recibe. Al final del artículo hay una lista de posibles variables  
  
		  if( isset($_SERVER['HTTP_CLIENT_IP']) )   
			  return $_SERVER['HTTP_CLIENT_IP'];  
  
		  if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )  
			  return $_SERVER['HTTP_X_FORWARDED_FOR'];  
  
		  if( isset($_SERVER['<variable seteada por server>']) )  
			  return $_SERVER['<variable seteada por server>'];  
  
		//ultimo recurso, lo que envía el navegador   
		  if( isset($_SERVER['REMOTE_ADDR']) )   
			  return $_SERVER['REMOTE_ADDR'];   
  
		//no hay nada definido  
		  return '';   
	} 
	
	public function reiniciarAprobaciones($informeId)
	{
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$actualiza = $tbInformePagoPersonaDAO->reiniciarAprobaciones($informeId);
		$actualiza +=$tbInformePagoPersonaDAO->eliminarFirmas($informeId);
		if($actualiza>1){
			$mensaje = [
				'title'=>'Bien hecho!',
				'message'=>'Se ha reiniciado el estado de las aprobaciones del informe de pago',
				'type'=>'success',
			];
		}else{
			$mensaje = [
				'title'=>'Algo salio!',
				'message'=>'No se pudo reiniciar el estado de las aprobaciones para el informe de pago',
				'type'=>'error',
			];			
		}
		echo json_encode($mensaje);
		
	}

	public function validarCantidadFirmasAprobadas($informeId)
	{
		$tbInformePagoPersonaDAO = $this->contenedor["tbInformePagoPersonaDAO"];
		$firmas = $tbInformePagoPersonaDAO->validarCantidadFirmasAprobadas($informeId);	
		#numero de aprobados		
		$informe = $tbInformePagoPersonaDAO->getInformePagoFirmas($informeId)[0];
		$aprobadores = [];

		$aprobadores[] = $informe['FK_Persona'];
		if($informe['FK_Persona_Apoyo_Supervisor'] != null){
			$aprobadores[] = $informe['FK_Persona_Apoyo_Supervisor'];
		}
		if( $informe['FK_Aprobacion_Administrativo'] != null && $informe['IN_Firma_Administrativo'] == 1){
			$aprobadores[] = $informe['FK_Aprobacion_Administrativo'];
		}
		if( $informe['FK_Persona_Supervisor'] != null ){
			$aprobadores[] = $informe['FK_Persona_Supervisor'];
		}			
		if( $informe['FK_Persona_Apoyo_Supervisor_Dos'] != null ){
			$aprobadores[] = $informe['FK_Persona_Apoyo_Supervisor_Dos'];
		}

		#$numeroFirmas = count($firmas);	
		$numeroFirmas = 0;
		foreach($aprobadores as $aprobador){
			foreach($firmas as $firma){
				if($firma['PK_Id_Persona'] == $aprobador){
					$numeroFirmas++;	
				}
			}
		}

		$cantidadFirmas = 1;
		$cantidadFirmas += $informe['FK_Persona_Apoyo_Supervisor'] != null ? 1 : 0;
		$cantidadFirmas += $informe['FK_Aprobacion_Administrativo'] != null && $informe['IN_Firma_Administrativo'] == 1  ? 1 : 0;
		$cantidadFirmas += $informe['FK_Persona_Supervisor'] != null ? 1 : 0;
		$cantidadFirmas += $informe['FK_Persona_Apoyo_Supervisor_Dos'] != null ? 1 : 0;
		
		#numero de firmas
	
		
		$aprobadoFinal   =  ($numeroFirmas==$cantidadFirmas) ? 1 : 0;	
		$faltantes = $cantidadFirmas - $numeroFirmas;
		/*
		var_dump($numeroFirmas);
		var_dump($cantidadFirmas);
		var_dump($faltantes);
		var_dump($aprobadoFinal);
		#die();
		*/
		if($aprobadoFinal == 1){
			$mensaje = [
				'ultimaFirma'=>true,
				'title'=>'Bien hecho',
				'message'=>'Es la ultima firma del informe de pago',
				'type'=>'success',
			];	
		}else{
			
			$mensaje = [
				'ultimaFirma'=>false,
				'title'=>'Bien hecho!',
				'message'=>'Faltan '.$faltantes.' Firma(s) para el informe de pago',
				'type'=>'success',
			];	
		}
		echo json_encode($mensaje);
	}

	public function validarCodigoSeguridad($codigoSeguridad)
	{
		$personaDAO = $this->contenedor['personaDAO'];
		$usuarioActual = $personaDAO->consultarCedulaUsuarioById($this->userId)[0];			
		$usuarioResponse =$this->firmaService->obtenerUsuarioResponse(trim($usuarioActual['VC_Identificacion']));
		$respuestaValidacionCodigo = $this->firmaService->validarCodigoSeguridad($usuarioResponse,$codigoSeguridad);
		echo json_encode($respuestaValidacionCodigo);	
	}
	
}
