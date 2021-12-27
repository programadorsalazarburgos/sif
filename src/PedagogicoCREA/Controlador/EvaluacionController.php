<?php
namespace PedagogicoCREA\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use PedagogicoCREA\Controlador\PedagogicoCREAFactory;

class EvaluacionController extends PedagogicoCREAFactory
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

 	public function getOptionsArtistasFormadoresEvaluadosPorEstudiante($datos){
 		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
 		$artista = $PedagogicoDAO->consultarArtistasFormadoresEvaluadosPorEstudiante($datos['anio']);
 		foreach ($artista as $a) {
 			echo "<option value='".$a['FK_artista_formador']."'>".$a['VC_Primer_Nombre'].' '.$a['VC_Segundo_Nombre'].' '.$a['VC_Primer_Apellido'].' '.$a['VC_Segundo_Apellido']."</option>";
 		}
 	}

 	public function getOptionsArtistasFormadoresEvaluadosPorFuncionario($datos){
 		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
 		$artista = $PedagogicoDAO->consultarArtistasFormadoresEvaluadosPorFuncionario($datos['anio']);
 		foreach ($artista as $a) {
 			echo "<option value='".$a['FK_artista_formador_evaluado']."'>".$a['VC_Primer_Nombre'].' '.$a['VC_Segundo_Nombre'].' '.$a['VC_Primer_Apellido'].' '.$a['VC_Segundo_Apellido']."</option>";
 		}
 	}

 	public function consultarResultadoEvaluacionEstudiantesArtistaFormador($datos){
 		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
 		if(isset($datos['id_artista_formador'])){
 			$resultado_evaluacion = $PedagogicoDAO->consutarResultadoEvaluacionEstudiante($datos['id_artista_formador'],$datos['anio']);
 		}else{
 			$resultado_evaluacion = $PedagogicoDAO->consultarResultadoEvaluacionEstudianteTodosLosArtistas($datos['anio']);
 		}
 		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('resultado_evaluacion'=>$resultado_evaluacion));
		$vista->renderHtml();
 	}

 	public function consultarResultadoEvaluacionFuncionarioArtistaFormador($datos){
 		$PedagogicoDAO = $this->contenedor['PedagogicoDAO'];
 		if(isset($datos['id_artista_formador'])){
 			$resultado_evaluacion = $PedagogicoDAO->consutarResultadoEvaluacionFuncionario($datos['id_artista_formador'],$datos['anio']);
 		}else{
 			$resultado_evaluacion = $PedagogicoDAO->consultarResultadoEvaluacionFuncionarioTodosLosArtistas($datos['anio']);
 		}
 		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('resultado_evaluacion'=>$resultado_evaluacion));
		$vista->renderHtml();
 	}
}

$objControlador = new EvaluacionController();
unset($objControlador);
