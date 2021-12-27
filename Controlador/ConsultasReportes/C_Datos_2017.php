<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/ConsultasReportes/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'getMatriculados':
				echo getMatriculados();
				break;
			case 'getAtendidos':
				echo getAtendidos();
				break;
			case 'getEstadisticaGenero':
				echo getEstadisticasGenero();
				break;
			case 'getCantidadGruposActivos':
				echo getCantidadGruposActivos();
				break;
			case 'getCantidadGruposInactivos':
				echo getCantidadGruposInactivos();
				break;
		}
	}

	/**
	* almacena la cantidad de matriculados que tiene SICLAN.
	*/
	function getMatriculados(){
		$respuesta = getCantidadMatriculados('2017');

		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}
	/**
	* almacena la informacion de las atenciones de los clanes almacenados en la Base de Datos.
	*/
	function getAtendidos(){
		$respuesta = getCantidadAtendidos();

		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}

	/**
	* almacena la informacion de las atenciones de los clanes almacenados en la Base de Datos.
	*/
	function getEstadisticasGenero(){
		$respuesta = getEstadisticaGenero('2017');

		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}

	/**
	* almacena la cantidad de grupos activos que tiene SICLAN para el 2017.
	*/
	function getCantidadGruposActivos(){
		$respuesta = getNumeroGruposActivos('2017');

		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}

	/**
	* almacena la cantidad de grupos activos que tiene SICLAN para el 2017.
	*/
	function getCantidadGruposInactivos(){
		$respuesta = getNumeroGruposInactivos('2017');

		$vector = array();
		foreach ($respuesta as $array) {
			$vector[]= $array;
		}
		echo json_encode($vector);
	}
?>