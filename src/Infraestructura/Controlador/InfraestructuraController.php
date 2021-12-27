<?php

namespace Infraestructura\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
/*require_once "../Vendor/autoload.php";*/
use Infraestructura\Controlador\InfraestructuraFactory;

class InfraestructuraController extends InfraestructuraFactory
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

	public function crearExcelConsultaInventario($lugar_inventario, $id_lugar_inventario){
		try {
			//Cargar plantilla del formato.
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template.xls');
			//Carga información del encabezado.
			date_default_timezone_set('America/Bogota');
			$fecha = date('Y');

			$worksheet = $spreadsheet->getActiveSheet();
			$worksheet->getCell('G9')->setValue($lugar_inventario);
			$worksheet->getCell('G11')->setValue($fecha);

			$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
			$informacionLugarInventario = $InfraestructuraDAO->getInfoLugarInventario($lugar_inventario);
			foreach ($informacionLugarInventario as $info) {
				$worksheet->getCell('C10')->setValue($info['Coordinador']);
				$worksheet->getCell('G10')->setValue('Contratista - Responsable CREA');				
				$worksheet->getCell('C11')->setValue($info['VC_Direccion_Clan']);
				$worksheet->getCell('C12')->setValue($info['VC_Telefono_Clan']);
			}

			$inventario = $InfraestructuraDAO->consultarInventarioExcel($id_lugar_inventario);
			// var_dump($inventario);
			$registros = count($inventario);
			$spreadsheet->getActiveSheet()->insertNewRowBefore(15, $registros);
			$fila=15;
			foreach ($inventario as $inv) {
				$spreadsheet->getActiveSheet()->mergeCells('E'.$fila.':G'.$fila);
				$worksheet->getCell('A'.$fila)->setValue($inv['IN_Cantidad']);
				$worksheet->getCell('B'.$fila)->setValue($inv['VC_Placa']);
				$worksheet->getCell('C'.$fila)->setValue($inv['elemento']);
				$worksheet->getCell('D'.$fila)->setValue($inv['VC_Descripcion']);
				$worksheet->getCell('E'.$fila)->setValue($inv['FL_Valor_Unitario_Inicial']);
				$worksheet->getCell('H'.$fila)->setValue('');
				$worksheet->getCell('I'.$fila)->setValue($inv['FL_Valor_Total']);
				$worksheet->getCell('J'.$fila)->setValue($inv['estado']);
				$worksheet->getCell('K'.$fila)->setValue($inv['VC_Observacion']);
				$fila++;
			}	
			$worksheet->getCell('I'.$fila)->setValue($inv['Valor_Inventario']);
			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
			$fecha = date("Y-m-d H-i-s");
			$nombre_fichero = 'InventarioCrea'.$fecha.'.xls'; 
			$writer->save($nombre_fichero);
			$retorno = $nombre_fichero;
		} catch (Exception $e) {
			$retorno = false;
		}
		echo $retorno;
	}
	public function crearSolicitudDeTraslado($datos){
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-d H:i:s");
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$traslado_object = $this->contenedor['traslado'];
		$traslado_object->setFkIdInventario($datos["id"]);
		$traslado_object->setVcTipoTraslado($datos["tipo"]);
		$traslado_object->setDaFechaSolicitud($fecha);
		$traslado_object->setFkPersonaSolicita($datos["usuario"]);
		$traslado_object->setFkOrigen($datos["origen"]);
		$traslado_object->setFkDestino($datos["destino"]);
		$traslado_object->setInCantidad($datos["cantidad"]);
		$traslado_object->setTxArgumento($datos["argumento"]);
		$resultado = $InfraestructuraDAO->guardarSolicitudTraslado($traslado_object);
		echo $resultado;
	}

	public function registrarInventario($datos,$archivos, $cantidad_archivos_elemento)
	{
		$datos = json_decode($datos, true);
		$cantidad_archivos_elemento = json_decode($cantidad_archivos_elemento, true);
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$inventario_object = $this->contenedor['inventario'];
		$id_usuario_registro = $datos["usuario_registro"];
		date_default_timezone_set('America/Bogota');
		$fecha=date("Y-m-d H:i:s");
		$registrados=0;
		$valor_inicial = str_replace("$", "",str_replace(",", ".", str_replace(".", "",$datos["TXT_VALOR_INICIAL"])));
		if ($datos['SL_TIPO_BIEN']==1 || $datos['SL_TIPO_BIEN']==3) {
			$inventario_object->setInCantidad(1);
			$valor_total = $valor_inicial;
			for ($i=1; $i <= intval($datos['TXT_CANTIDAD']); $i++) {
				$archivos_elemento = [];
				if (isset($cantidad_archivos_elemento[$i])) {
					for ($n=1; $n <= intval($cantidad_archivos_elemento[$i]); $n++) {
						$archivos_elemento[$n-1] = $archivos["archivo_".$i."_".$n];
					}
				}
				$inventario_object->setFkIdClan($datos['SL_LUGAR']);
				$inventario_object->setFkIdTipoBien($datos['SL_TIPO_BIEN']);
				$inventario_object->setVcPlaca($datos['TXT_PLACA_'.$i]);
				$inventario_object->setFkIdElemento($datos['SL_ELEMENTO']);
				$inventario_object->setVcDescripcion($datos['TXT_DESCRIPCION']);
				$inventario_object->setFkIdEstado($datos['SL_ESTADO_BIEN']);
				$inventario_object->setVcNumeroTraslado($datos['TXT_NUMERO_TRASLADO']);
				$inventario_object->setFlValorUnitarioInicial($valor_inicial);
				$inventario_object->setVcDonante($datos['TXT_DONANTE']);
				$inventario_object->setFlValorTotal($valor_total);
				$inventario_object->setDaFechaRegistro($fecha);
				$inventario_object->setFkUsuario($id_usuario_registro);
				$inventario_object->setFkProyecto($datos['SL_PROYECTO']);
				$id_insertado = $InfraestructuraDAO->registrarInventario($inventario_object);
				if($id_insertado[0]["id_insertado"] > 1){
					$urlArchivos=null;
					if (count($archivos_elemento)>0){
						$urlArchivos = $this->subirArchivos($id_insertado[0]["id_insertado"],$archivos_elemento,'Inventarios', 1);
					}
					$InfraestructuraDAO->registrarRegistroFotografico($id_insertado[0]["id_insertado"],$urlArchivos,$id_usuario_registro);
					$registrados++;
				}
			}
			if ($registrados == $datos['TXT_CANTIDAD']) {
				echo 1;
			}
		}
		else{
			$archivos_elemento = [];
			if (isset($cantidad_archivos_elemento[1])) {
				for ($n=1; $n <= intval($cantidad_archivos_elemento[1]); $n++) {
					$archivos_elemento[$n-1] = $archivos["archivo_1_".$n];
				}
			}
			$inventario_object->setInCantidad($datos['TXT_CANTIDAD']);
			$valor_total = $valor_inicial*($datos['TXT_CANTIDAD']);
			$inventario_object->setFkIdClan($datos['SL_LUGAR']);
			$inventario_object->setFkIdTipoBien($datos['SL_TIPO_BIEN']);
			$inventario_object->setVcPlaca($datos['TXT_PLACA_1']);
			$inventario_object->setFkIdElemento($datos['SL_ELEMENTO']);
			$inventario_object->setVcDescripcion($datos['TXT_DESCRIPCION']);
			$inventario_object->setFkIdEstado($datos['SL_ESTADO_BIEN']);
			$inventario_object->setVcNumeroTraslado($datos['TXT_NUMERO_TRASLADO']);
			$inventario_object->setFlValorUnitarioInicial($valor_inicial);
			$inventario_object->setVcDonante($datos['TXT_DONANTE']);
			$inventario_object->setFlValorTotal($valor_total);
			$inventario_object->setDaFechaRegistro($fecha);
			$inventario_object->setFkUsuario($id_usuario_registro);
			$inventario_object->setFkProyecto($datos['SL_PROYECTO']);
			$id_insertado = $InfraestructuraDAO->registrarInventario($inventario_object);
			if($id_insertado[0]["id_insertado"] > 1){
				$urlArchivos=null;
				if (count($archivos_elemento)>0){
					$urlArchivos = $this->subirArchivos($id_insertado[0]["id_insertado"],$archivos_elemento,'Inventarios', 1);
				}
				$InfraestructuraDAO->registrarRegistroFotografico($id_insertado[0]["id_insertado"],$urlArchivos,$id_usuario_registro);
				$registrados++;
			}
			if ($registrados == 1) {
				echo 1;
			}
		}
	}

	public function actualizarInventario($datos){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$inventario_object = $this->contenedor['inventario'];
		$valor_inicial = str_replace("$", "",str_replace(",", ".", str_replace(".", "",$datos["MODAL_TXT_VALOR_INICIAL"])));
		$valor_total = $valor_inicial*($datos['MODAL_TXT_CANTIDAD']);
		
		$inventario_object->setPkIdInventario($datos["id"]);
		$inventario_object->setFkIdClan($datos['MODAL_SL_LUGAR']);
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
		$result = $InfraestructuraDAO->actualizarInventario($inventario_object);
		echo $result;
	}

	public function consultarInventario($datos, $actividad)
	{
		$inventario_object = $this->contenedor['inventario'];
		$inventario_object->setVariables($datos);
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$inventario=$InfraestructuraDAO->consultarInventario($inventario_object);
		//echo '<pre>'.print_r($adjuntos,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('inventario'=>$inventario, 'actividad'=>$actividad));
		$vista->renderHtml();
	}

	public function darBaja($id_inventario, $usuario){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado = $InfraestructuraDAO->darDeBajaEnInventario($id_inventario, $usuario);
		echo $resultado;
	}

	/*****************************************************
	Metodo para guardar una nueva observacion al bien especificado.
	*****************************************************/
	public function guardarObservacion($datos){
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-d H:i:s");
		$resultado = $InfraestructuraDAO->guardarObservacion($datos['fecha'], $datos['id_inventario'], $datos['id_usuario'], $datos['observacion'], $datos['estado']);
		echo $resultado;
	}

	public function listarUsuariosActivos()
	{
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$usuarios_activos=$InfraestructuraDAO->listarUsuariosActivos();
		//echo '<pre>'.print_r($adjuntos,true).'</pre>';
		$vector = array();
		foreach ($usuarios_activos as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}

	public function asignarInventarioContratista($datos){
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-d H:i:s");
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado=$InfraestructuraDAO->asignarInventarioContratista($datos['id_contratista'], $datos['id_inventario'], $datos['fecha_recibe'], $fecha, $datos['usuario']);
		echo $resultado;
	}

	public function consultarHistorialAsignacionesBien($datos)
	{
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$asignaciones=$InfraestructuraDAO->consultarHistorialAsignacionesBien($datos['id_inventario']);
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
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado = $InfraestructuraDAO->eliminarAsignacionInventario($datos['id_asignacion'], $datos['usuario']);
		echo $resultado;
	}
	
	/*****************************************************
	Guardar un nuevo espacio de un CREA.
	*****************************************************/
	public function guardarEspacioCREA($datos){
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-d H:i:s");
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado=$InfraestructuraDAO->guardarEspacioCREA($datos['id_crea'], $datos['nombre_espacio'], $datos['nivel'], $fecha, $datos['usuario']);
		echo $resultado;
	}

	/*****************************************************
	Consultar los salones/espacios de un CREA
	*****************************************************/
	public function getEspaciosCrea($datos)
	{
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$espacios=$InfraestructuraDAO->getEspaciosCrea($datos['id_crea']);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('espacios'=>$espacios));
		$vista->renderHtml();
	}

	/*****************************************************
	Eliminar un espacio de un centro CREA.
	*****************************************************/
	public function eliminarEspacioCREA($datos){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado = $InfraestructuraDAO->eliminarEspacioCREA($datos['id_espacio'], $datos['usuario']);
		echo $resultado;
	}

	public function getCantidadRegistroInventarioMes($datos){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado=$InfraestructuraDAO->getCantidadRegistroInventarioMes($datos["anio"],$datos["mes"]);
		echo json_encode($resultado);
	}

	public function getListadoInventarioRegistradoUsuario($datos){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado=$InfraestructuraDAO->getListadoInventarioRegistradoUsuario($datos["anio"],$datos["mes"], $datos["id_persona"]);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$resultado));
		$vista->renderHtml();
	}

	public function getCantidadTrasladosInventarioMes($datos){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado=$InfraestructuraDAO->getCantidadTrasladosInventarioMes($datos["anio"],$datos["mes"]);
		echo json_encode($resultado);
	}

	public function getListadoTrasladoInventarioUsuario($datos){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado=$InfraestructuraDAO->getListadoTrasladoInventarioUsuario($datos["anio"],$datos["mes"], $datos["id_persona"]);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$resultado));
		$vista->renderHtml();
	}
	
	public function getCantidadObservacionesInventarioMes($datos){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado=$InfraestructuraDAO->getCantidadObservacionesInventarioMes($datos["anio"],$datos["mes"]);
		echo json_encode($resultado);
	}

	public function getListadoObservacionesInventarioUsuario($datos){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado=$InfraestructuraDAO->getListadoObservacionesInventarioUsuario($datos["anio"],$datos["mes"], $datos["id_persona"]);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$resultado));
		$vista->renderHtml();
	}

	public function validarPlaca($datos){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		
		$id = $datos['id'];
		if ($id == "") {
			$id = 0;
		}
		$placas_encontradas = [];
		$placas = $datos['placa'];
		$cantidad_placas = count($placas);
		for ($i=0; $i < $cantidad_placas; $i++) { 
			if ($placas[$i] != "S/P") {
				$resultado=$InfraestructuraDAO->validarPlaca($placas[$i],$id);
				if ($resultado > 0) {
					$placas_encontradas[$i] = $placas[$i];
				}	
			}
		}
		echo json_encode($placas_encontradas);
	}

	public function updateRegistroFotografico($id_inventario, $archivos, $id_usuario){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$urlArchivos = $this->subirArchivos($id_inventario,$archivos,'Inventarios', 1);
		$result = $InfraestructuraDAO->actualizarRegistroFotografico($id_inventario,$urlArchivos,$id_usuario);
		echo $result;
	}

	public function getRegistroFotografico($id_inventario){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		$resultado = $InfraestructuraDAO->getRegistroFotografico($id_inventario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$resultado[0]['VC_Url']));
		$vista->renderHtml();
	}
}

$objControlador = new InfraestructuraController(); 
//Llamar metodo de clase Forma 1

if(isset($_POST['funcion']) && $_POST['funcion']==='addAdjuntosSoporte')
{
	//echo '<pre>'.print_r($GLOBALS,true).'</pre>';
	
}
unset($objControlador);
