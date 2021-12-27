<?php

namespace Psicosocial\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use Psicosocial\Controlador\PsicosocialFactory;

class PsicosocialController extends PsicosocialFactory
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
	}

	public function saveReporteCaso($datos){
		$PsicosocialDAO = $this->contenedor['PsicosocialDAO'];
		$reporteCaso_object = $this->contenedor['reporteCaso'];
		$fecha=date("Y-m-d H:i:s");
		switch ($datos['TX_Linea_Atencion']) {
			case 'emprende_clan':
			$datos['TX_Linea_Atencion'] = 'emprende_crea';
			break;
			case 'laboratorio_clan':
			$datos['TX_Linea_Atencion'] = 'laboratorio_crea';
			break;
		}
		$reporteCaso_object->setFkBeneficiario($datos['FK_Beneficiario']);
		$reporteCaso_object->setFkCrea($datos['FK_Crea']);
		$reporteCaso_object->setTxLineaAtencion($datos['TX_Linea_Atencion']);
		$reporteCaso_object->setFkGrupo($datos['FK_Grupo']);
		$reporteCaso_object->setTxDatos($datos['TX_Datos']);
		$reporteCaso_object->setTxOrigenReporte($datos['TX_Origen_Reporte']);
		$reporteCaso_object->setTxDescripcionHechos($datos['TX_Descripcion_Hechos']);
		$reporteCaso_object->setDtFechaRegistro($fecha);
		$reporteCaso_object->setFkUsuarioRegistro($datos['FK_Usuario_Registro']);
		$reporteCaso_object->setInFinalizado($datos['IN_Finalizado']);
		$resultado = $PsicosocialDAO->saveReporteCaso($reporteCaso_object);
		echo $resultado;
	}

	public function consultarCasosReportados($datos, $actividad)
	{
		$PsicosocialDAO = $this->contenedor['PsicosocialDAO'];
		$casos=$PsicosocialDAO->consultarCasosReportados($datos['year']);
		//echo '<pre>'.print_r($adjuntos,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('casos'=>$casos));
		$vista->renderHtml();
	}

	public function actualizarInventario($datos){
		$PsicosocialDAO = $this->contenedor['PsicosocialDAO'];
		$inventario_object = $this->contenedor['inventario'];
		$valor_inicial = str_replace("$", "",str_replace(",", ".", str_replace(".", "",$datos["MODAL_TXT_VALOR_INICIAL"])));
		$valor_total = $valor_inicial*($datos['MODAL_TXT_CANTIDAD']);
		
		$inventario_object->setPkIdInventario($datos["id"]);
		$inventario_object->setFkIdClan($datos['MODAL_SL_CREA']);
		$inventario_object->setInCantidad($datos['MODAL_TXT_CANTIDAD']);
		$inventario_object->setFkIdTipoBien($datos['MODAL_SL_TIPO_BIEN']);
		$inventario_object->setVcPlaca($datos['MODAL_TXT_PLACA']);
		$inventario_object->setFkIdElemento($datos['MODAL_SL_ELEMENTO']);
		$inventario_object->setVcDescripcion($datos['MODAL_TXT_DESCRIPCION']);
		$inventario_object->setFkIdEstado($datos['MODAL_SL_ESTADO_BIEN']);
		$inventario_object->setVcNumeroTraslado($datos['MODAL_TXT_NUMERO_TRASLADO']);
		$inventario_object->setFlValorUnitarioInicial($valor_inicial);
		$inventario_object->setVcDonante($datos['MODAL_TXT_DONANTE']);
		$inventario_object->setFlValorTotal($valor_total);
		$inventario_object->setFkUsuario($datos["usuario_registro"]);
		$result = $PsicosocialDAO->actualizarInventario($inventario_object);
		echo $result;
	}

	public function darBaja($id_inventario, $usuario){
		$PsicosocialDAO = $this->contenedor['PsicosocialDAO'];
		$resultado = $PsicosocialDAO->darDeBajaEnInventario($id_inventario, $usuario);
		echo $resultado;
	}

	/*****************************************************
	Metodo para guardar una nueva observacion al bien especificado.
	*****************************************************/
	public function guardarObservacion($datos){
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-d H:i:s");
		$resultado = $PsicosocialDAO->guardarObservacion($datos['fecha'], $datos['id_inventario'], $datos['id_usuario'], $datos['observacion'], $datos['estado']);
		echo $resultado;
	}

	public function listarContratistasRol($rol)
	{
		$PsicosocialDAO = $this->contenedor['PsicosocialDAO'];
		$contratistas=$PsicosocialDAO->listarContratistasRol($rol);
		//echo '<pre>'.print_r($adjuntos,true).'</pre>';
		$vector = array();
		foreach ($contratistas as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}

	public function asignarInventarioContratista($datos){
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-d H:i:s");
		$PsicosocialDAO = $this->contenedor['PsicosocialDAO'];
		$resultado=$PsicosocialDAO->asignarInventarioContratista($datos['id_contratista'], $datos['id_inventario'], $datos['fecha_recibe'], $fecha, $datos['usuario']);
		echo $resultado;
	}

	public function consultarHistorialAsignacionesBien($datos)
	{
		$PsicosocialDAO = $this->contenedor['PsicosocialDAO'];
		$asignaciones=$PsicosocialDAO->consultarHistorialAsignacionesBien($datos['id_inventario']);
		//echo '<pre>'.print_r($adjuntos,true).'</pre>';
		$vector = array();
		foreach ($asignaciones as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}

	/*****************************************************
	Eliminar una asignación de inventario de un contratista.
	*****************************************************/
	public function eliminarAsignacionInventarioContratista($datos){
		$PsicosocialDAO = $this->contenedor['PsicosocialDAO'];
		$resultado = $PsicosocialDAO->eliminarAsignacionInventario($datos['id_asignacion'], $datos['usuario']);
		echo $resultado;
	}
	
	/*****************************************************
	Guardar un nuevo espacio de un CREA.
	*****************************************************/
	public function guardarEspacioCREA($datos){
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-d H:i:s");
		$PsicosocialDAO = $this->contenedor['PsicosocialDAO'];
		$resultado=$PsicosocialDAO->guardarEspacioCREA($datos['id_crea'], $datos['nombre_espacio'], $datos['nivel'], $fecha, $datos['usuario']);
		echo $resultado;
	}

	/*****************************************************
	Consultar los salones/espacios de un CREA
	*****************************************************/
	public function getEspaciosCrea($datos)
	{
		$PsicosocialDAO = $this->contenedor['PsicosocialDAO'];
		$espacios=$PsicosocialDAO->getEspaciosCrea($datos['id_crea']);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('espacios'=>$espacios));
		$vista->renderHtml();
	}

	/*****************************************************
	Eliminar un espacio de un centro CREA.
	*****************************************************/
	public function eliminarEspacioCREA($datos){
		$PsicosocialDAO = $this->contenedor['PsicosocialDAO'];
		$resultado = $PsicosocialDAO->eliminarEspacioCREA($datos['id_espacio'], $datos['usuario']);
		echo $resultado;
	}
}

$objControlador = new PsicosocialController(); 
//Llamar metodo de clase Forma 1

if(isset($_POST['funcion']) && $_POST['funcion']==='addAdjuntosSoporte')
{
	//echo '<pre>'.print_r($GLOBALS,true).'</pre>';
	
}
unset($objControlador);
