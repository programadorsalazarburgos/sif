<?php
session_start();
header ('Content-type: text/html; charset=utf-8');
include_once('../../../Modelo/Infraestructura/Acceso_Datos.php');
if (isset($_POST['opcion'])){
	switch ($_POST['opcion']) {
		case 'guardar_observacion':
		echo guardarObservacion($_POST["id"],$_POST["observacion"],$_POST["estado"],$_POST["usuario_registro"]);
		break;
		case 'eliminar_observacion':
		echo eliminarObservacion($_POST["id"],$_POST["usuario"], $_POST["fecha_observacion"]);
		break;
		case 'historial_observaciones':
		echo consultarHistorialObservaciones($_POST["id_inventario"]);
		break;
		case 'historial_traslados':
		echo consultarHistorialTraslados($_POST["id_inventario"]);
		break;
		case 'listar_descripciones':
		echo listarDescripciones();
		break;
		case 'listar_donantes':
		echo listarDonantes();
		break;
		case 'listar_elementos':
		echo listarElementos();
		break;
		case 'listar_estado_bien':
		echo listarEstadosBien();
		break;
		case 'listar_tipo_bien':
		echo listarTiposBien();
		break;
		case 'consultar_crea_usuario':
		echo consultarCreaUsuario($_POST["usuario"]);
		break;
		case 'eliminar_traslado':
		echo eliminarTraslado($_POST["id"],$_POST["usuario"]);
		break;
		case 'efectuar_Traslado':
		echo efectuarTraslado($_POST['tipo_traslado'], $_POST['id_traslado'], $_POST['estado'], $_POST['id_inventario'], $_POST['id_destino'], $_POST['cantidad'], $_POST['observacion'], $_POST['restantes'], $_POST['usuario'], $_POST['accion']);
		break;
		case 'consultarCoincidenciasTraslado':
		echo consultarCoincidenciasTraslado($_POST['id_inventario'], $_POST['id_destino']);
		break;
		case 'actualizar_info_complementaria_traslado':
		echo actualizarInfoComplementariaTraslado($_POST['id_traslado'], $_POST['numero_traslado'], $_POST['fecha_traslado'], $_POST['consecutivo_salida'], $_POST['usuario']);
		break;
		default:
		echo "opcion no valida en asignar estudiantes a grupo: (".$_POST['opcion'].")";
		break;
	}
}

	/*****************************************************
	Metodo para dar de baja el bien especificado.
	*****************************************************/
	function darDeBaja($id_inventario,$id_usuario){
		$resultado = Inventario::darBaja($id_inventario,$id_usuario);
		return $resultado;
	}
	/*****************************************************
	Metodo para guardar una nueva observacion al bien especificado.
	*****************************************************/
	function guardarObservacion($id_inventario, $observacion, $estado, $id_usuario){
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-d H:i:s");
		$resultado = Inventario::guardarObservacion($fecha, $id_inventario, $id_usuario, $observacion, $estado);
		return $resultado;
	}
	/*****************************************************
	Metodo para eliminar una observacion especifica de un bien.
	*****************************************************/
	function eliminarObservacion($id_observacion, $id_usuario, $fecha_observacion){
		$resultado = Inventario::deleteObservacion($id_observacion,$id_usuario, $fecha_observacion);
		return $resultado;
	}
	/*****************************************************
	Metodo para consultar el historial de observaciones de un bien especifico.
	*****************************************************/
	function consultarHistorialObservaciones($id){
		$respuesta = Inventario::consultarObservaciones($id);

		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}
	/*****************************************************
	Metodo para consultar el historial de traslados de un bien especifico.
	*****************************************************/
	function consultarHistorialTraslados($id){
		$respuesta = Inventario::consultarTraslados($id);

		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}
	/*****************************************************
	Metodo consultar las distintas descripciones de bienes que se han registrado a la fecha, esto para el complemento de autocompletado de JQueryUI.
	*****************************************************/
	function listarDescripciones(){
		$respuesta = Inventario::listarDescripciones();
		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}
	/*****************************************************
	Metodo que consulta los distintos donantes que se han registrado para el Autocomplete de JQueryUI.
	*****************************************************/
	function listarDonantes(){
		$respuesta = Inventario::listarDonantes();

		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}
	/*****************************************************
	Metodo que consulta la clasificacion de Elementos.
	*****************************************************/
	function listarElementos(){
		$respuesta = Inventario::listarElementos();

		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}

	/*****************************************************
	Metodo que consulta los distintos Estados para un Bien.
	*****************************************************/
	function listarEstadosBien(){
		$respuesta = Inventario::listarEstadosBien();

		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}

	/*****************************************************
	Metodo que consulta los distintos Tipos de Bien.
	*****************************************************/
	function listarTiposBien(){
		$respuesta = Inventario::listarTipoBien();

		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}

	/*****************************************************
	Metodo que consulta el CREA al que pertenece el usuario que desea accdeder a Consulta Inventario.
	*****************************************************/
	function consultarCreaUsuario($id_usuario){
		$respuesta = Inventario::consultarCreaUsuario($id_usuario);
		echo $respuesta;
	}

	/*****************************************************
	Metodo para eliminar un traslado especifico de un bien.
	*****************************************************/
	function eliminarTraslado($id_traslado, $id_usuario){
		$resultado = Inventario::deleteTraslado($id_traslado,$id_usuario);
		return $resultado;
	}

	function consultarCoincidenciasTraslado($id_inventario, $id_destino){
		$coincidencias = Inventario::consultarCoincidenciasParaTraslado($id_inventario,$id_destino);
		echo count($coincidencias);
	}

	/*****************************************************
	Metodo para actualizar el estado de un traslado especifico de un bien.
	*****************************************************/
	function efectuarTraslado($tipo_traslado, $id_traslado, $estado, $id_inventario, $id_destino, $cantidad, $observacion, $restantes, $id_usuario,
		$accion){
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-d H:i:s");
		
		if($estado == 1 && ($tipo_traslado == "Definitivo" OR $tipo_traslado == "Baja")){
			if($tipo_traslado=="Definitivo"){
				$bandera_baja = "NO";
			}
			if($tipo_traslado=="Baja"){
				$bandera_baja = "SI";
			}
			if($accion == "fusiona_elementos"){
				$resultado = Inventario::fusionarElementosPorTraslado($id_inventario, $id_destino, $cantidad, $restantes, $id_usuario, $id_traslado, $estado, $observacion, $fecha, $bandera_baja);
			}
			if($accion == "crea_nuevo_elemento"){
				$resultado = Inventario::crearElementoIdenticoEnInventario($id_inventario, $id_destino, $cantidad, $id_usuario, $id_traslado, $estado, $observacion, $fecha, $bandera_baja);
			}
			if($accion == "actualiza_crea" && $cantidad==$restantes){
				$resultado = Inventario::actualizarCreaPorTraslado($id_inventario, $id_destino, $id_usuario, $id_traslado, $estado, $observacion, $fecha, $bandera_baja);
			}
		}
		else{
			$resultado = Inventario::actualizarObservacionEstadoTraslado($id_traslado, $estado, $observacion, $id_usuario, $fecha);
		}
		echo $resultado;
	}
	/*****************************************************
	Metodo para actualizar la información complementaria (Numero, Fecha, Consecutivo Salida) de un traslado especifico de un bien.
	*****************************************************/
	function actualizarInfoComplementariaTraslado($id_traslado, $numero_traslado, $fecha_traslado, $consecutivo_salida, $usuario){
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-d H:i:s");
		$resultado = Inventario::actualizarInfoComplementariaTraslado($id_traslado, $numero_traslado, $fecha_traslado, $consecutivo_salida, $usuario, $fecha);
		return $resultado;
	}
	?>