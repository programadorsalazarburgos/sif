<?php

namespace ConsultasReportes\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\ConsultasReportesDAO;
use General\Persistencia\DAOS\GrupoDAO;
use General\Persistencia\DAOS\TbOrganizaciones2017DAO;
use General\Persistencia\DAOS\TbPersona2017DAO;
use General\Persistencia\DAOS\BeneficiarioDAO;
use General\Persistencia\Entidades\TbOrganizaciones2017;
use General\Persistencia\Entidades\TbPersona2017;
use General\Persistencia\Entidades\TbCentroMonitoreo;
use General\Vista\Vista;



class ConsultasReportesController extends ControladorBase
{
	/**
	 * @var Container
	 *
	 */
	// private /*static*/ $contenedor;

	function __construct()
	{

		parent::__construct();

 		//ConsultasReportesController::contenedor=$this::getContenedor();
		$this->contenedor=$this->getContenedor();
		$this->contenedor['ConsultasReportesDAO'] = function ($c) {
			return new ConsultasReportesDAO();
		};

		$this->contenedor['GrupoDAO'] = function ($c) {
			return new GrupoDAO();
		};

		$this->contenedor['organizacion'] = function ($c) {
			return new TbOrganizaciones2017();
		};

		$this->contenedor['TbOrganizaciones2017DAO'] = function ($c) {
			return new TbOrganizaciones2017DAO();
		};


		$this->contenedor['personaDAO'] = function ($c) {
			return new TbPersona2017DAO();
		};

		$this->contenedor['BeneficiarioDAO'] = function ($c) {
			return new BeneficiarioDAO();
		};

		$this->contenedor['persona'] = function ($c) {
			return new TbPersona2017();
		};			

		$this->contenedor['TbCentroMonitoreo'] = function ($c) {
			return new TbCentroMonitoreo();
		};	
		/**
		  * Usado para Pruebas Render HTML en PHP vs JS
		  */

		$variables=array();
		$this->contenedor['vista'] = function ($c) use ($variables) {
			return new Vista($variables);
		};		

		//parent::__construct(); 

		if(isset($_POST['p1'])) $this->p1=$_POST['p1']; else $this->p1=null;
		if(isset($_POST['p2'])) $this->p2=$_POST['p2']; else $this->p2=null;
		if(isset($_POST['p3'])) $this->p3=$_POST['p3']; else $this->p3=null;
		if(isset($_POST['p4'])) $this->p4=$_POST['p4']; else $this->p4=null;
		if(isset($_POST['p5'])) $this->p5=$_POST['p5']; else $this->p5=null;
		if(isset($_FILES) && sizeof($_FILES)>0) {
			if($this->p1===null) {
				$this->p1=$_POST;
				unset($this->p1["funcion"]);		
			}	
			$this->p2=$_FILES; 
		} 

		$this->{$_POST["funcion"]}($this->p1,$this->p2,$this->p3,$this->p4,$this->p5);

	}


	/**
	  * @ejecutador Consultar_asistencias_Grupos.php
	  * 
	  */  
	public function getAsistenciasMesAE($lista_clan,$anio)
	{		
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos= $consultasReportesDAO->getAsistenciasMesAE($lista_clan,$anio);
		//echo '<pre>'.print_r($grupos,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();
	}

	public function getAsistenciasMesEC($lista_clan,$anio)
	{
		//echo '<pre>**'.$lista_clan.'</pre>';
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos= $consultasReportesDAO->getAsistenciasMesEC($lista_clan,$anio);
		//echo '<pre>'.print_r($grupos,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();
	}

	public function getAsistenciasMesLC($lista_clan,$anio){
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos= $consultasReportesDAO->getAsistenciasMesLC($lista_clan,$anio);  
		//echo '<pre>'.print_r($grupos,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml(); 
	}


	public function getHorasArtistaMes($organizacion,$anio)
	{
		//echo '<pre>'.print_r($organizacion,true).'</pre>'; 

		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$horas= $consultasReportesDAO->getHorasArtistaMes($organizacion,$anio);
		//echo '<pre>'.print_r($horas,true).'</pre>'; 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('horas'=>$horas));
		$vista->renderHtml(); 
	}


	public function getHistorialGruposOrganizacion($datos){
		$organizacion = $this->contenedor['TbOrganizaciones2017DAO'];
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('organizacion'=>$organizacion->consultarHistorialGruposAsignados($datos)));
		$vista->renderHtml();
	}

	public function getHistorialArtistasGruposOrganizacion($datos){
		$organizacion = $this->contenedor['TbOrganizaciones2017DAO'];
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('organizacion'=>$organizacion->consultarHistorialArtistasGruposAsignados($datos)));
		$vista->renderHtml();
 		//echo $organizacion->consultarHistorialArtistasGruposAsignados($datos);
	}

	/**
	  * @ejecutador Consultar_Novedades_Grupos.php
	  * 
	  */  
	public function getNovedadesAFAE($lista_clan,$anio,$mes)
	{
		
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos= $consultasReportesDAO->getNovedadesAFAE($lista_clan,$anio,$mes);
		//echo '<pre>'.print_r($grupos,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();		
	} 

	/**
	  * @ejecutador Consultar_Novedades_Grupos.php
	  * 
	  */  
	public function getNovedadesAFEC($lista_clan,$anio,$mes)
	{
		
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos= $consultasReportesDAO->getNovedadesAFEC($lista_clan,$anio,$mes);
		//echo '<pre>'.print_r($grupos,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();		
	} 

	/**
	  * @ejecutador Consultar_Novedades_Grupos.php
	  * 
	  */  
	public function getNovedadesAFLC($lista_clan,$anio,$mes)
	{
		
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos= $consultasReportesDAO->getNovedadesAFLC($lista_clan,$anio,$mes);
		//echo '<pre>'.print_r($grupos,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();		
	} 	

	/**
	  * @ejecutador Consultar_Grupos.js
	  * 
	  */  
	public function getGruposArteEscuelaByCrea($creas,$anios)
	{ 
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos=$consultasReportesDAO->getGruposArteEscuelaByCrea($creas,$anios); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();		
	}

	/**
	  * @ejecutador Consultar_Estudiantes_general.js
	  * 
	  */  
	public function getEstudiantesArteEscuelaByCrea($creas,$anios)
	{ 
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos=$consultasReportesDAO->getEstudiantesArteEscuelaByCrea($creas,$anios); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$grupos,'idTabla'=>"table_grupos_arte_escuela"));
		$vista->setPlantilla('pintarDatatableGeneral');
		$vista->renderHtml();	
	}

	public function getEstudiantesGruposEmprendeByCrea($creas,$anios)
	{ 
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos=$consultasReportesDAO->getEstudiantesGruposEmprendeByCrea($creas,$anios); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$grupos,'idTabla'=>"table_grupos_emprende_clan"));
		$vista->setPlantilla('pintarDatatableGeneral');
		$vista->renderHtml();	
	}	


	public function getEstudiantesGruposLaboratorioByCrea($creas,$anios)
	{ 
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos=$consultasReportesDAO->getEstudiantesGruposLaboratorioByCrea($creas,$anios); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$grupos,'idTabla'=>"table_grupos_laboratorio_clan"));
		$vista->setPlantilla('pintarDatatableGeneral');
		$vista->renderHtml();	
	}

	/**
	  * @ejecutador Consultar_Grupos.js
	  * 
	  */  
	public function getGruposEmprendeCreaByCrea($creas,$anos)
	{
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos=$consultasReportesDAO->getGruposEmprendeCreaByCrea($creas,$anos); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos)); 
		$vista->renderHtml();		
	}	

	
	/**
	  * @ejecutador Consultar_Grupos.js
	  * 
	  */  
	public function getGruposLaboratorioCreaByCrea($creas,$anos)
	{
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos=$consultasReportesDAO->getGruposLaboratorioCreaByCrea($creas,$anos); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();		
	}	

	public function getTotalGruposClan($creas,$anos)
	{
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$grupos=$consultasReportesDAO->getTotalGruposClan($creas,$anos); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();		
	}

	public function getMesSesionesClaseColegio($id_colegio,$anio,$id_clan)
	{
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$meses=$consultasReportesDAO->getMesSesionesClaseColegio($id_colegio,$anio,$id_clan); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('meses'=>$meses));
		$vista->renderHtml();	 		
	} 
	public function getConsultaColegioMes($id_colegio,$mesd,$mesh,$anio,$crea) 
	{
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$meses=$consultasReportesDAO->getConsultaColegioMes($id_colegio,$mesd,$mesh,$anio,$crea); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$meses));
		$vista->renderHtml();			
	}

	public function getAtendidosMesColegio($id_colegio,$mesd,$mesh,$anio,$crea){
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$atenciones=$consultasReportesDAO->getAtendidosMesColegio($id_colegio,$mesd,$mesh,$anio,$crea); 
		echo json_encode($atenciones);
	} 

	public function getConsultaAsistenciaECMes($id_clan,$mesd,$mesh,$anio) 
	{
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$meses=$consultasReportesDAO->getConsultaAsistenciaECMes($id_clan,$mesd,$mesh,$anio); 
		//echo '<pre>'.print_r($meses,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$meses));
		$vista->setPlantilla('consultaArea'); 
		$vista->renderHtml();			
	}

	public function getConsultaAsistenciaLCMes($id_clan,$mesd,$mesh,$anio) 
	{
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$meses=$consultasReportesDAO->getConsultaAsistenciaLCMes($id_clan,$mesd,$mesh,$anio); 
		//echo '<pre>'.print_r($meses,true).'</pre>';
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$meses));
		$vista->setPlantilla('consultaArea'); 
		$vista->renderHtml();			
	}	

	public function getAtendidosMesECYLC($id_colegio,$mesd,$mesh,$anio,$tipo_grupo){

		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$atenciones=$consultasReportesDAO->getAtendidosMesECYLC($id_colegio,$mesd,$mesh,$anio,$tipo_grupo); 
		echo json_encode($atenciones);
	}  

	public function getPlaneacionArteEnLaEscuela($anio, $inicio, $fin, $asistencias, $usuario){
		try {
			//Cargar plantilla del formato.
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template_ae.xls');
			//Carga información del encabezado.
			date_default_timezone_set('America/Bogota');

			$fecha = date('Y-m-d H-i-s');
			$meses = array('ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
			$mes_inicial = explode("-",$inicio)[0];
			$dia_inicial = explode("-",$inicio)[1];
			$mes_final = explode("-",$fin)[0];
			$dia_final = explode("-",$fin)[1];
			$worksheet = $spreadsheet->getSheet(0);
			$worksheet->getCell('A1')->setValue("PLANEACIÓN ".$anio." ".$meses[$mes_inicial-1]." ".$dia_inicial." - ".$meses[$mes_final-1]." ".$dia_final." IDARTES");

			$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
			$planeacion=$consultasReportesDAO->getPlaneacionArteEnLaEscuelaIdartes($anio, $inicio, $fin, $asistencias);
			$fila = 3;
			foreach ($planeacion as $p) {
				$worksheet->getCell('A'.$fila)->setValue($p['Id_SIF']);
				$worksheet->getCell('B'.$fila)->setValue($p['Tipo_Identificacion']);
				$worksheet->getCell('C'.$fila)->setValue($p['Identificación']);
				$worksheet->getCell('D'.$fila)->setValue($p['Nombre_Beneficiario']);
				$worksheet->getCell('E'.$fila)->setValue($p['Genero']);
				$worksheet->getCell('F'.$fila)->setValue($p['Grupo']);
				$worksheet->getCell('G'.$fila)->setValue($p['Tipo_Grupo']);
				$worksheet->getCell('H'.$fila)->setValue($p['Formador']);
				$worksheet->getCell('I'.$fila)->setValue($p['CREA']);
				$worksheet->getCell('J'.$fila)->setValue($p['Organización']);
				$worksheet->getCell('K'.$fila)->setValue($p['Area_Artística']);
				$worksheet->getCell('L'.$fila)->setValue($p['Localidad_CREA']);
				$worksheet->getCell('M'.$fila)->setValue($p['Localidad_Colegio']);
				$worksheet->getCell('N'.$fila)->setValue($p['Colegio']);
				$worksheet->getCell('O'.$fila)->setValue($p['DANE12']);
				$worksheet->getCell('P'.$fila)->setValue($p['Lugar_Atención']);
				$worksheet->getCell('Q'.$fila)->setValue($p['Asistencias']);
				$worksheet->getCell('R'.$fila)->setValue($p['Edad']);
				$worksheet->getCell('S'.$fila)->setValue($p['Grado']);
				$worksheet->getCell('T'.$fila)->setValue($p['Poblacion_Victima_Conflicto']);
				$worksheet->getCell('U'.$fila)->setValue($p['Tipo_Discapacidad']);
				$worksheet->getCell('V'.$fila)->setValue($p['Etnia']);
				$worksheet->getCell('W'.$fila)->setValue($p['Estrato']);
				$worksheet->getCell('X'.$fila)->setValue($p['Fecha_Registro']);
				$worksheet->getCell('Y'.$fila)->setValue($p['SIMAT']);
				$worksheet->getCell('Z'.$fila)->setValue($p['Asistencias_Colegio']);
				$worksheet->getCell('AA'.$fila)->setValue($p['Asistencias_CREA']);
				$worksheet->getCell('AB'.$fila)->setValue($p['Asistencias_Remoto']);
				$worksheet->getCell('AC'.$fila)->setValue($p['Asistencias_Modalidad_Presencial']);
				$worksheet->getCell('AD'.$fila)->setValue($p['Asistencias_Modalidad_No_Presencial']);
				$worksheet->getCell('AE'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Presencial']);
				$worksheet->getCell('AF'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Sincronica']);
				$worksheet->getCell('AG'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Asincronica']);
				$worksheet->getCell('AH'.$fila)->setValue($p['FECHA_INICIO']);
				$fila++;
			}

			$worksheet = $spreadsheet->getSheet(1);
			$worksheet->getCell('A1')->setValue("PLANEACIÓN ".$anio." ".$meses[$mes_inicial-1]." ".$dia_inicial." - ".$meses[$mes_final-1]." ".$dia_final." SED");

			$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
			$planeacion=$consultasReportesDAO->getPlaneacionArteEnLaEscuelaSED($anio, $inicio, $fin, $asistencias);
			$fila = 3;
			foreach ($planeacion as $p) {
				$worksheet->getCell('A'.$fila)->setValue($p['Id_SIF']);
				$worksheet->getCell('B'.$fila)->setValue($p['Tipo_Identificacion']);
				$worksheet->getCell('C'.$fila)->setValue($p['Identificación']);
				$worksheet->getCell('D'.$fila)->setValue($p['Nombre_Beneficiario']);
				$worksheet->getCell('E'.$fila)->setValue($p['Genero']);
				$worksheet->getCell('F'.$fila)->setValue($p['Grupo']);
				$worksheet->getCell('G'.$fila)->setValue($p['Tipo_Grupo']);
				$worksheet->getCell('H'.$fila)->setValue($p['Formador']);
				$worksheet->getCell('I'.$fila)->setValue($p['CREA']);
				$worksheet->getCell('J'.$fila)->setValue($p['Organización']);
				$worksheet->getCell('K'.$fila)->setValue($p['Area_Artística']);
				$worksheet->getCell('L'.$fila)->setValue($p['Localidad_CREA']);
				$worksheet->getCell('M'.$fila)->setValue($p['Localidad_Colegio']);
				$worksheet->getCell('N'.$fila)->setValue($p['Colegio']);
				$worksheet->getCell('O'.$fila)->setValue($p['DANE12']);
				$worksheet->getCell('P'.$fila)->setValue($p['Lugar_Atención']);
				$worksheet->getCell('Q'.$fila)->setValue($p['Asistencias']);
				$worksheet->getCell('R'.$fila)->setValue($p['Edad']);
				$worksheet->getCell('S'.$fila)->setValue($p['Grado']);
				$worksheet->getCell('T'.$fila)->setValue($p['Poblacion_Victima_Conflicto']);
				$worksheet->getCell('U'.$fila)->setValue($p['Tipo_Discapacidad']);
				$worksheet->getCell('V'.$fila)->setValue($p['Etnia']);
				$worksheet->getCell('W'.$fila)->setValue($p['Estrato']);
				$worksheet->getCell('X'.$fila)->setValue($p['Fecha_Registro']);
				$worksheet->getCell('Y'.$fila)->setValue($p['SIMAT']);
				$worksheet->getCell('Z'.$fila)->setValue($p['Asistencias_Colegio']);
				$worksheet->getCell('AA'.$fila)->setValue($p['Asistencias_CREA']);
				$worksheet->getCell('AB'.$fila)->setValue($p['Asistencias_Remoto']);
				$worksheet->getCell('AC'.$fila)->setValue($p['Asistencias_Modalidad_Presencial']);
				$worksheet->getCell('AD'.$fila)->setValue($p['Asistencias_Modalidad_No_Presencial']);
				$worksheet->getCell('AE'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Presencial']);
				$worksheet->getCell('AF'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Sincronica']);
				$worksheet->getCell('AG'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Asincronica']);
				$worksheet->getCell('AH'.$fila)->setValue($p['FECHA_INICIO']);
				$fila++;
			}

			// $worksheet = $spreadsheet->getSheet(2);
			// $sesiones_crea=$consultasReportesDAO->getSesionesCreaAE($anio, $inicio, $fin);
			// $fila = 2;
			// foreach ($sesiones_crea as $s) {
			// 	$worksheet->getCell('A'.$fila)->setValue($s['CREA']);
			// 	$worksheet->getCell('B'.$fila)->setValue($s['SESIONES']);
			// 	$fila++;
			// }

			$worksheet = $spreadsheet->getSheet(2);
			$sesiones_crea=$consultasReportesDAO->getSesionesColegioAE($anio, $inicio, $fin);
			$fila = 2;
			foreach ($sesiones_crea as $s) {
				$worksheet->getCell('A'.$fila)->setValue($s['COLEGIO']);
				$worksheet->getCell('B'.$fila)->setValue($s['SESIONES']);
				$fila++;
			}

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
			$nombre_archivo = 'AE '.$anio.'-'.$mes_inicial.'-'.$dia_inicial.' al '.$anio.'-'.$mes_final.'-'.$dia_final.' de '.$fecha.'.xls';
			$url= "uploadedFiles/ConsultasReportes/ReportesPlaneacion/".$anio."/".$nombre_archivo;
			$writer->save('../../../'.$url);
			$resultado=$consultasReportesDAO->saveHistoricoPlaneacion($nombre_archivo, $url, $fecha, $usuario);
			$retorno = $nombre_archivo;
		} catch (Exception $e) {
			$retorno = false;
		}
		echo $retorno;
	}

	public function getPlaneacionEmprendeCrea($anio, $inicio, $fin, $asistencias, $usuario){
		try {
			//Cargar plantilla del formato.
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template_ic.xls');
			//Carga información del encabezado.
			date_default_timezone_set('America/Bogota');
			$fecha = date('Y-m-d H-i-s');
			$meses = array('ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
			$mes_inicial = explode("-",$inicio)[0];
			$dia_inicial = explode("-",$inicio)[1];
			$mes_final = explode("-",$fin)[0];
			$dia_final = explode("-",$fin)[1];
			$worksheet = $spreadsheet->getSheet(0);
			$worksheet->getCell('A1')->setValue("PLANEACIÓN ".$anio." ".$meses[$mes_inicial-1]." ".$dia_inicial." - ".$meses[$mes_final-1]." ".$dia_final." IDARTES");

			$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
			$planeacion=$consultasReportesDAO->getPlaneacionEmprendeCrea($anio, $inicio, $fin, $asistencias);
			$fila = 3;
			foreach ($planeacion as $p) {
				$worksheet->getCell('A'.$fila)->setValue($p['Id_SIF']);
				$worksheet->getCell('B'.$fila)->setValue($p['Tipo_Identificacion']);
				$worksheet->getCell('C'.$fila)->setValue($p['Identificación']);
				$worksheet->getCell('D'.$fila)->setValue($p['Nombre_Beneficiario']);
				$worksheet->getCell('E'.$fila)->setValue($p['Genero']);
				$worksheet->getCell('F'.$fila)->setValue($p['Grupo']);
				$worksheet->getCell('G'.$fila)->setValue($p['Tipo_Grupo']);
				$worksheet->getCell('H'.$fila)->setValue($p['Formador']);
				$worksheet->getCell('I'.$fila)->setValue($p['Organización']);
				$worksheet->getCell('J'.$fila)->setValue($p['CREA']);
				$worksheet->getCell('K'.$fila)->setValue($p['Area_Artística']);
				$worksheet->getCell('L'.$fila)->setValue($p['Localidad_CREA']);
				$worksheet->getCell('M'.$fila)->setValue($p['Asistencias']);
				$worksheet->getCell('N'.$fila)->setValue($p['Edad']);
				$worksheet->getCell('O'.$fila)->setValue($p['Grupo_Poblacional']);
				$worksheet->getCell('P'.$fila)->setValue($p['Estrato']);
				$worksheet->getCell('Q'.$fila)->setValue($p['Asistencias_CREA']);
				$worksheet->getCell('R'.$fila)->setValue($p['Asistencias_Espacio_Alterno']);
				$worksheet->getCell('S'.$fila)->setValue($p['Asistencias_Remoto']);
				$worksheet->getCell('T'.$fila)->setValue($p['Asistencias_Modalidad_Presencial']);
				$worksheet->getCell('U'.$fila)->setValue($p['Asistencias_Modalidad_No_Presencial']);
				$worksheet->getCell('V'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Presencial']);
				$worksheet->getCell('W'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Sincronica']);
				$worksheet->getCell('X'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Asincronica']);
				$worksheet->getCell('Y'.$fila)->setValue($p['FECHA_INICIO']);
				$fila++;
			}

			$worksheet = $spreadsheet->getSheet(1);
			$sesiones_crea=$consultasReportesDAO->getSesionesCreaEC($anio, $inicio, $fin, $asistencias);
			$fila = 2;
			foreach ($sesiones_crea as $s) {
				$worksheet->getCell('A'.$fila)->setValue($s['CREA']);
				$worksheet->getCell('B'.$fila)->setValue($s['SESIONES']);
				$fila++;
			}

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
			$nombre_archivo = 'IC '.$anio.'-'.$mes_inicial.'-'.$dia_inicial.' al '.$anio.'-'.$mes_final.'-'.$dia_final.' de '.$fecha.'.xls';
			$url= "uploadedFiles/ConsultasReportes/ReportesPlaneacion/".$anio."/".$nombre_archivo;
			$writer->save('../../../'.$url);
			$resultado=$consultasReportesDAO->saveHistoricoPlaneacion($nombre_archivo, $url, $fecha, $usuario);
			$retorno = $nombre_archivo;
		} catch (Exception $e) {
			$retorno = false;
		}
		echo $retorno;
	}

	public function getPlaneacionLaboratorioCrea($anio, $inicio, $fin, $asistencias, $usuario){
		try {
			//Cargar plantilla del formato.
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template_cv.xls');
			//Carga información del encabezado.
			date_default_timezone_set('America/Bogota');
			$fecha = date('Y-m-d H-i-s');
			$meses = array('ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
			$mes_inicial = explode("-",$inicio)[0];
			$dia_inicial = explode("-",$inicio)[1];
			$mes_final = explode("-",$fin)[0];
			$dia_final = explode("-",$fin)[1];
			$worksheet = $spreadsheet->getSheet(0);
			$worksheet->getCell('A1')->setValue("PLANEACIÓN ".$anio." ".$meses[$mes_inicial-1]." ".$dia_inicial." - ".$meses[$mes_final-1]." ".$dia_final." IDARTES");

			$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
			$planeacion=$consultasReportesDAO->getPlaneacionLaboratorioCrea($anio, $inicio, $fin, $asistencias);
			$fila = 3;
			foreach ($planeacion as $p) {
				$worksheet->getCell('A'.$fila)->setValue($p['Id_SIF']);
				$worksheet->getCell('B'.$fila)->setValue($p['Tipo_Identificacion']);
				$worksheet->getCell('C'.$fila)->setValue($p['IDENTIFICACIÓN']);
				$worksheet->getCell('D'.$fila)->setValue($p['NOMBRE_BENEFICIARIO']);
				$worksheet->getCell('E'.$fila)->setValue($p['GENERO']);
				$worksheet->getCell('F'.$fila)->setValue($p['GRUPO']);
				$worksheet->getCell('G'.$fila)->setValue($p['AREA_ARTÍSTICA']);
				$worksheet->getCell('H'.$fila)->setValue($p['TIPO_DE_GRUPO']);
				$worksheet->getCell('I'.$fila)->setValue($p['CATEGORIA_POBLACIÓN']);
				$worksheet->getCell('J'.$fila)->setValue($p['SUBCATEGORIA_POBLACIÓN']);
				$worksheet->getCell('K'.$fila)->setValue($p['INSTITUCIÓN']);
				$worksheet->getCell('L'.$fila)->setValue($p['ALIADO']);
				$worksheet->getCell('M'.$fila)->setValue($p['TIPO_DE_UBICACIÓN']);
				$worksheet->getCell('N'.$fila)->setValue($p['LUGAR_DE_ATENCIÓN']);
				$worksheet->getCell('O'.$fila)->setValue($p['LOCALIDAD_LUGAR_ATENCIÓN']);
				$worksheet->getCell('P'.$fila)->setValue($p['CREA']);
				$worksheet->getCell('Q'.$fila)->setValue($p['LOCALIDAD_CREA']);
				$worksheet->getCell('R'.$fila)->setValue($p['FORMADOR']);
				$worksheet->getCell('S'.$fila)->setValue($p['ORGANIZACIÓN']);
				$worksheet->getCell('T'.$fila)->setValue($p['LUGAR_DE_ATENCIÓN_Desactualizado']);
				$worksheet->getCell('U'.$fila)->setValue($p['ASISTENCIAS']);
				$worksheet->getCell('V'.$fila)->setValue($p['EDAD']);
				$worksheet->getCell('W'.$fila)->setValue($p['GRUPO_POBLACIONAL_Beneficiario']);
				$worksheet->getCell('X'.$fila)->setValue($p['FECHA_DE_CREACIÓN_BENEFICIARIO']);
				$worksheet->getCell('Y'.$fila)->setValue($p['SIMAT']);
				$worksheet->getCell('Z'.$fila)->setValue($p['Asistencias_CREA']);
				$worksheet->getCell('AA'.$fila)->setValue($p['Asistencias_Aliado']);
				$worksheet->getCell('AB'.$fila)->setValue($p['Asistencias_Espacio_Alterno']);
				$worksheet->getCell('AC'.$fila)->setValue($p['Asistencias_Remoto']);
				$worksheet->getCell('AD'.$fila)->setValue($p['Asistencias_Modalidad_Presencial']);
				$worksheet->getCell('AE'.$fila)->setValue($p['Asistencias_Modalidad_No_Presencial']);
				$worksheet->getCell('AF'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Presencial']);
				$worksheet->getCell('AG'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Sincronica']);
				$worksheet->getCell('AH'.$fila)->setValue($p['Asistencias_Tipo_Atencion_Asincronica']);
				$worksheet->getCell('AI'.$fila)->setValue($p['FECHA_INICIO']);
				$fila++;
			}

			$worksheet = $spreadsheet->getSheet(1);
			$sesiones_crea=$consultasReportesDAO->getSesionesLC($anio, $inicio, $fin, $asistencias);
			$fila = 2;
			foreach ($sesiones_crea as $s) {
				$worksheet->getCell('A'.$fila)->setValue($s['CREA']);
				$worksheet->getCell('B'.$fila)->setValue($s['INSTITUCIÓN']);
				$worksheet->getCell('C'.$fila)->setValue($s['ALIADO']);
				$worksheet->getCell('D'.$fila)->setValue($s['Lugar_Atención']);
				$worksheet->getCell('E'.$fila)->setValue($s['SESIONES']);
				$fila++;
			}

			$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
			$nombre_archivo = 'CV '.$anio.'-'.$mes_inicial.'-'.$dia_inicial.' al '.$anio.'-'.$mes_final.'-'.$dia_final.' de '.$fecha.'.xls';
			$url= "uploadedFiles/ConsultasReportes/ReportesPlaneacion/".$anio."/".$nombre_archivo;
			$writer->save('../../../'.$url);
			$resultado=$consultasReportesDAO->saveHistoricoPlaneacion($nombre_archivo, $url, $fecha, $usuario);
			$retorno = $nombre_archivo;
		} catch (Exception $e) {
			$retorno = false;
		}
		echo $retorno;
	}

	public function consultarDatosEstudiantesGrupo($datos){
		
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$id_grupo = "";
		for ($i=0; $i < sizeof($datos['id_grupo']) ; $i++) { 
			$id_grupo .= $datos['id_grupo'][$i].",";
		}
		$id_grupo = substr($id_grupo, 0, -1);
		$id_area = "";
		for ($i=0; $i < sizeof($datos['id_area']) ; $i++) { 
			$id_area .= $datos['id_area'][$i].",";
		}
		$id_area = substr($id_area, 0, -1);
		$linea_atencion = array('arte_escuela','emprende_clan','laboratorio_clan');
		for ($i=0; $i < sizeof($linea_atencion); $i++) {
			// $grupo = $GrupoDAO->consultarGruposClanPorEstado($id_crea,$linea_atencion[$i],1);
			$tipo_grupo = $linea_atencion[$i];
			$estudiante = $BeneficiarioDAO->consultarDatosEstudiantesGrupo($id_grupo,$tipo_grupo,$id_area);
			$vista = $this->contenedor['vista'];
			$vista->setNamespace('GestionClan');
			$vista->setPlantilla('tableEstudiantesBase');
			$vista->setVariables(array('estudiante'=>$estudiante,'tipo_grupo'=>$tipo_grupo,'tipo_mostrar'=>'datos_estudiante'));
			$vista->renderHtml();
		}		
	}


	public function consultarTotalMesPorArea($datos)
	{
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$areas=$consultasReportesDAO->consultarTotalMesPorArea($datos); 
		$vista = $this->contenedor['vista'];  
		$vista->setVariables(array('areas'=>$areas));
		$vista->setPlantilla('consultarTotalMesPorArea'); 
		$vista->renderHtml(); 		
	}	

	public function consultarAsistenciasMesPorArea($datos) 
	{
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$meses=$consultasReportesDAO->consultarAsistenciasMesPorArea($datos); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$meses));
		$vista->setPlantilla('consultaArea');
		$vista->renderHtml();
	}

	public function consultarHorarioArtistaFormador($id_artista_formador){
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$linea_atencion = ["arte_escuela","emprende_clan","laboratorio_clan"];
		$horario = array();
		for ($i=0; $i < sizeof($linea_atencion); $i++) { 
			$horario_linea_temp = $consultasReportesDAO->consultarHorarioArtistaFormador($id_artista_formador,$linea_atencion[$i]);
			for ($j=0; $j < sizeof($horario_linea_temp); $j++) {
				$horario_linea_temp[$j]['linea_atencion'] = $linea_atencion[$i];
				$horario_linea_temp[$j]['tipo_grupo'] = $linea_atencion[$i];
				$horario_linea_temp[$j]['id_grupo'] = $horario_linea_temp[$j]['FK_grupo'];
				$horario_linea_temp[$j]['colegio'] = $GrupoDAO->consultarColegioGrupo($horario_linea_temp[$j]);
				$horario_linea_temp[$j]['total_estudiantes'] = $GrupoDAO->contarEstudiantesActivosGrupo($horario_linea_temp[$j]['FK_grupo'],$linea_atencion[$i])[0]['total'];
				$horario_linea_temp[$j]['total_acumulado'] = $GrupoDAO->consultarCantidadAcumuladoAtentidosGrupo($horario_linea_temp[$j]['FK_grupo'],$linea_atencion[$i])[0]['total_acumulado'];
				$horario_linea_temp[$j]['listado_activos'] = $GrupoDAO->consultarEstudiantesPorEstadoGrupo($horario_linea_temp[$j]['FK_grupo'],$linea_atencion[$i],1);
				$horario_linea_temp[$j]['listado_acumulado'] = $GrupoDAO->getListadoAcumuladoAtendidosGrupo($horario_linea_temp[$j]['FK_grupo'],$linea_atencion[$i],1);
				//$total_mensual = $GrupoDAO->consultarAtentidosMensualmenteGrupo($horario_linea_temp[$j]['FK_grupo'],$linea_atencion[$i])[0]['mensual'];
				array_push($horario,$horario_linea_temp[$j]);
			}
		}
		if(count($horario)>0){
			foreach ($horario as $key => $row) {
				$aux[$key] = $row['TI_hora_inicio_clase'];
			}
			array_multisort($aux, SORT_DESC, $horario);
		}
		echo json_encode($horario);
	}

	public function consultarHorarioCreaAreaEstado($id_crea, $area_artistica, $estado){
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$linea_atencion = ["arte_escuela","emprende_clan","laboratorio_clan"];
		$horario = array();
		for ($i=0; $i < sizeof($linea_atencion); $i++) { 
			$horario_linea_temp = $consultasReportesDAO->consultarHorarioCreaAreaEstado($id_crea, $area_artistica, $estado, $linea_atencion[$i]);
			for ($j=0; $j < sizeof($horario_linea_temp); $j++) {
				$horario_linea_temp[$j]['linea_atencion'] = $linea_atencion[$i];
				$horario_linea_temp[$j]['tipo_grupo'] = $linea_atencion[$i];
				$horario_linea_temp[$j]['id_grupo'] = $horario_linea_temp[$j]['FK_grupo'];
				$horario_linea_temp[$j]['colegio'] = $GrupoDAO->consultarColegioGrupo($horario_linea_temp[$j]);
				$horario_linea_temp[$j]['total_estudiantes'] = $GrupoDAO->contarEstudiantesActivosGrupo($horario_linea_temp[$j]['FK_grupo'],$linea_atencion[$i])[0]['total'];
				$horario_linea_temp[$j]['total_acumulado'] = $GrupoDAO->consultarCantidadAcumuladoAtentidosGrupo($horario_linea_temp[$j]['FK_grupo'],$linea_atencion[$i])[0]['total_acumulado'];
				$horario_linea_temp[$j]['listado_activos'] = $GrupoDAO->consultarEstudiantesPorEstadoGrupo($horario_linea_temp[$j]['FK_grupo'],$linea_atencion[$i],1);
				$horario_linea_temp[$j]['listado_acumulado'] = $GrupoDAO->getListadoAcumuladoAtendidosGrupo($horario_linea_temp[$j]['FK_grupo'],$linea_atencion[$i],1);
				//$total_mensual = $GrupoDAO->consultarAtentidosMensualmenteGrupo($horario_linea_temp[$j]['FK_grupo'],$linea_atencion[$i])[0]['mensual'];
				array_push($horario,$horario_linea_temp[$j]);
			}
		}
		if(count($horario)>0){
			foreach ($horario as $key => $row) {
				$aux[$key] = $row['TI_hora_inicio_clase'];
			}
			array_multisort($aux, SORT_DESC, $horario);
		}
		echo json_encode($horario);
	}

	public function getHistoricoPlaneacion(){
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$historico_planeacion=$consultasReportesDAO->getHistoricoPlaneacion(); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('historico_planeacion'=>$historico_planeacion));
		$vista->renderHtml();
	}

	public function eliminarReportePlaneacion($id_registro, $url, $usuario){
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$resultado=$consultasReportesDAO->eliminarReportePlaneacion($id_registro,$usuario);
		if($resultado == 1){
			$url = "../../../".$url;
			unlink($url);
		}
		echo $resultado;
	}

	public function getAsignaciones($tipo_grupo,$anio,$mesd,$mesh){
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$asignaciones=$consultasReportesDAO->getAsignaciones($tipo_grupo,$anio,$mesd,$mesh);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$asignaciones,'idTabla'=>"table_asignaciones"));
		$vista->setPlantilla('pintarDatatableGeneral');
		$vista->renderHtml();		 
	}

	public function getGestionUsuarios($anio,$mesd,$mesh){
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$asignaciones=$consultasReportesDAO->getGestionUsuarios($anio,$mesd,$mesh);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$asignaciones,'idTabla'=>"table_asignaciones"));
		$vista->setPlantilla('pintarDatatableGeneral');
		$vista->renderHtml();		
	}

	public function getConsultaCentroMonitoreo($datos){
		$tbCentroMonitoreo=$this->contenedor['TbCentroMonitoreo'];
		$tbCentroMonitoreo->setVariables($datos);
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		return $consultasReportesDAO->getConsultaCentroMonitoreo($tbCentroMonitoreo);	
	}
	public function getPanelCentroMonitoreo($datos){
		$tbCentroMonitoreo=$this->contenedor['TbCentroMonitoreo'];
		$tbCentroMonitoreo->setVariables($datos);
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$indicadores = $consultasReportesDAO->getPanelCentroMonitoreo($tbCentroMonitoreo);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('indicadores'=>$indicadores));
		$vista->renderHtml();		
	}		
	public function executeSql($datos){
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$sql=$this->getConsultaCentroMonitoreo($datos);
		echo json_encode($consultasReportesDAO->executeSql($sql, $datos['valores_filtros']));
		// echo json_encode($sql);
	}
	public function getTiposIndicadoresCentroMonitoreo($datos){
		$tbCentroMonitoreo=$this->contenedor['TbCentroMonitoreo'];
		$tbCentroMonitoreo->setVariables($datos);
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$indicadores = $consultasReportesDAO->getPanelCentroMonitoreo($tbCentroMonitoreo);

		//echo "<pre>".print_r($indicadores,true)."</pre>"; 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$indicadores,'idTabla'=>"table_tipos_indicadores"));
		//$vista->setPlantilla('pintarDatatableGeneral');
		$vista->renderHtml();		
	}	

	public function saveTipoIndicador($datos){ 
		$tbCentroMonitoreo=$this->contenedor['TbCentroMonitoreo'];
		$tbCentroMonitoreo->setVariables($datos);		
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO']; 
		echo $consultasReportesDAO->saveTipoIndicador($tbCentroMonitoreo);		
	}
	public function updateTipoIndicador($datos){		
		$tbCentroMonitoreo=$this->contenedor['TbCentroMonitoreo'];
		$tbCentroMonitoreo->setVariables($datos);			
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		echo $consultasReportesDAO->updateTipoIndicador($tbCentroMonitoreo);		
	}

	/* Consulta asistencias diarias de los grupos del Convenio de Seguridad 2019 (Laboratorio CREA) por MES.*/
	public function getAsistenciasMesConvenio_0810_2019($mes, $anio)
	{		
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$meses=$consultasReportesDAO->getAsistenciasMesConvenioSeguridad_0810_2019($mes,$anio); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$meses));
		$vista->renderHtml();
	}
	
	/* Consulta la cantidad de beneficiarios atendidos por cada uno de los aliados del Convenio de Seguridad 0810-2019 (Laboratorio CREA) en el rango de tiempo especificado.*/
	public function getBeneficariosAliadosConvenio_0810_2019($mes_desde, $mes_hasta)
	{		
		$consultasReportesDAO = $this->contenedor['ConsultasReportesDAO'];
		$resultado=$consultasReportesDAO->getBeneficariosAliadosConvenio_0810_2019($mes_desde,$mes_hasta); 
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$resultado));
		$vista->renderHtml();
	}

	public function getAtencionMensualGrupo($id_grupo, $linea_atencion){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$result = $GrupoDAO->getAtencionMensualGrupo($id_grupo, $linea_atencion);
		echo json_encode($result);
	}

	public function getColegioGrupo($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$result = $GrupoDAO->consultarColegioGrupo($datos);
		echo json_encode($result);
	}
}

$objControlador = new ConsultasReportesController(); 
//Llamar metodo de clase Forma 1

if(isset($_POST['funcion']) && $_POST['funcion']==='addAdjuntosSoporte')
{
	//echo '<pre>'.print_r($GLOBALS,true).'</pre>';
	
}
unset($objControlador);
