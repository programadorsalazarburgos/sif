<?php 
namespace CirculacionNidos\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use CirculacionNidos\Controlador\CirculacionFactory;

class RegistroBeneficiariosController extends CirculacionFactory
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

	public function consultarEventosEquipo($id_mes, $id_usuario, $tipo_persona){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$EventosEquipo = $NidosCirculacionDAO->consultarEventosEquipo($id_mes, $id_usuario, $tipo_persona);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('EventosEquipo'=>$EventosEquipo));
		$vista->renderHtml();
	}

	public function getLugarAtencionEvento($id_evento){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$instituciones = $NidosCirculacionDAO->getLugarAtencionEvento($id_evento);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('instituciones'=>$instituciones));
		$vista->renderHtml();
	}

	public function consultarInformacionEvento($idEvento){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$ResulEvento = $NidosCirculacionDAO->consultarInformacionEvento($idEvento);
		echo json_encode($ResulEvento[0]);
	}

	public function guardarAsistentesEvento($datos){
		$TbNidosAsistentesEvento = $this->contenedor['TbNidosAsistentesEvento'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		$TbNidosAsistentesEvento->setFkIdEvento($datos['id_evento']);
		$TbNidosAsistentesEvento->setFkIdLugarAtencion($datos['id_lugar_atencion']);
		$TbNidosAsistentesEvento->setVcNinos03($datos['ninos_0_3']);
		$TbNidosAsistentesEvento->setVcNinos46($datos['ninos_4_6']);
		$TbNidosAsistentesEvento->setVcNinos610($datos['ninos_6_10']);
		$TbNidosAsistentesEvento->setVcNinas03($datos['ninas_0_3']);
		$TbNidosAsistentesEvento->setVcNinas46($datos['ninas_4_6']);
		$TbNidosAsistentesEvento->setVcNinas610($datos['ninas_6_10']);
		$TbNidosAsistentesEvento->setVcMadres($datos['madres']);
		$TbNidosAsistentesEvento->setTxObservacion($datos['observacion']);
		$TbNidosAsistentesEvento->setDtFechaRegistro(date("Y-m-d H:i:s"));
		$TbNidosAsistentesEvento->setFkIdArtistaRegistro($datos['id_persona']);

		echo $NidosCirculacionDAO->guardarAsistentesEvento($TbNidosAsistentesEvento);
	}

	public function guardarBeneficiariosEvento($json_datos){
		$TbNidosBeneficiarios = $this->contenedor['TbNidosBeneficiarios'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		
		foreach ($json_datos as $dato => $value) {
			$TbNidosBeneficiarios->setVcIdentificacion($value[0]['numdoc']);
			$TbNidosBeneficiarios->setFkTipoIdentificacion($value[0]['tipdoc']);
			$TbNidosBeneficiarios->setVcPrimerNombre($value[0]['prinom']);
			$TbNidosBeneficiarios->setVcSegundoNombre($value[0]['segnom']);
			$TbNidosBeneficiarios->setVcPrimerApellido($value[0]['priape']);
			$TbNidosBeneficiarios->setVcSegundoApellido($value[0]['segape']);
			$TbNidosBeneficiarios->setDdFNacimiento(date("Y-m-d", strtotime(str_replace('/', '-', $value[0]['fecha']))));
			$TbNidosBeneficiarios->setFkIdGenero($value[0]['gene']);
			$TbNidosBeneficiarios->setInGrupoPoblacional($value[0]['enfo']);
			$TbNidosBeneficiarios->setInIdentificacionPoblacional($value[0]['estra']);
			$TbNidosBeneficiarios->setFkIdUsuarioRegistra($value[0]['id_usuario']);
			$TbNidosBeneficiarios->setDtFechaRegistro(date("Y-m-d H:i:s"));
			
			echo $NidosCirculacionDAO->guardarBeneficiariosEvento($TbNidosBeneficiarios);
		}
	}

	public function guardarAsistenciaEvento($json_datos){
		$TbNidosAsistencia = $this->contenedor['TbNidosAsistencia'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		foreach ($json_datos as $dato => $value) {
			$TbNidosAsistencia->setFkIdEvento($value[0]["id_evento"]);
			$TbNidosAsistencia->setFkIdBeneficiario($value[0]["numdoc"]);
			$TbNidosAsistencia->setVcNivel($value[0]["nivel"]);
			$TbNidosAsistencia->setFkIdLugarAtencionEvento($value[0]["id_lugar_atencion"]);

			echo $NidosCirculacionDAO->guardarAsistenciaEvento($TbNidosAsistencia);
		}
	}

	public function getReporteEvento($id_mes, $id_usuario){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$Datos = $NidosCirculacionDAO->getReporteEvento($id_mes, $id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos, 'id_usuario'=> $id_usuario));
		$vista->renderHtml();
	}

	public function getProgramacionAsignada($idmes,$usuario){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$programacion = $NidosCirculacionDAO->getProgramacionAsignada($idmes,$usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('programacion'=>$programacion));
		$vista->renderHtml();
	}

	public function RegistroInformacionEvento($datos_string, $archivo){
		$datos = json_decode($datos_string, true);
		
		$TbNidosEventoCirculacion = $this->contenedor['TbNidosEventoCirculacion'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		$TbNidosEventoCirculacion->setPkIdEvento($datos['id_evento']);
		$TbNidosEventoCirculacion->setInNumaAtistas($datos['num_artistas']);
		$TbNidosEventoCirculacion->setInNumGrupos($datos['num_grupos']);
		$TbNidosEventoCirculacion->setInEspacioPublico($datos['espacio_publico']);
		$TbNidosEventoCirculacion->setInExperiencias($datos['experiencias']);
		$TbNidosEventoCirculacion->setInCuidadores($datos['cuidadores']);

		$informacionEvento = $NidosCirculacionDAO->ConsultarInformacionEvento($datos["id_evento"]);

		if($archivo != null){
			if($informacionEvento[0]["LISTADO_ASISTENCIA"] != ""){
				$archivo_antiguo = $informacionEvento[0]["LISTADO_ASISTENCIA"];
				unlink($archivo_antiguo);
			}
			$rta = $this->subirArchivos($datos['id_evento'], $archivo);
			$TbNidosEventoCirculacion->setVcListadoAsistencia($rta);
		}else{
			$TbNidosEventoCirculacion->setVcListadoAsistencia($informacionEvento[0]["LISTADO_ASISTENCIA"]);
		}
		echo $NidosCirculacionDAO->RegistroInformacionEvento($TbNidosEventoCirculacion);
	}

	public function getBeneficiariosEvento($datos){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$datos = $NidosCirculacionDAO->getBeneficiariosEvento($datos["id_evento"], $datos["id_lugar_atencion"]);
		echo json_encode($datos[0]);
	}

	public function getAsistentesEvento($datos){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$datos = $NidosCirculacionDAO->getAsistentesEvento($datos["id_evento"], $datos["id_lugar_atencion"]);
		echo json_encode($datos[0]);
	}

	public function actualizarAsistentesEvento($datos){
		$TbNidosAsistentesEvento = $this->contenedor['TbNidosAsistentesEvento'];
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];

		$TbNidosAsistentesEvento->setFkIdEvento($datos['id_evento']);
		$TbNidosAsistentesEvento->setFkIdLugarAtencion($datos['id_lugar_atencion']);
		$TbNidosAsistentesEvento->setVcNinos03($datos['ninos_0_3']);
		$TbNidosAsistentesEvento->setVcNinos46($datos['ninos_4_6']);
		$TbNidosAsistentesEvento->setVcNinos610($datos['ninos_6_10']);
		$TbNidosAsistentesEvento->setVcNinas03($datos['ninas_0_3']);
		$TbNidosAsistentesEvento->setVcNinas46($datos['ninas_4_6']);
		$TbNidosAsistentesEvento->setVcNinas610($datos['ninas_6_10']);
		$TbNidosAsistentesEvento->setVcMadres($datos['madres']);
		$TbNidosAsistentesEvento->setTxObservacion($datos['observacion']);
		$TbNidosAsistentesEvento->setDtFechaRegistro(date("Y-m-d H:i:s"));
		$TbNidosAsistentesEvento->setFkIdArtistaRegistro($datos['id_persona']);

		echo $NidosCirculacionDAO->actualizarAsistentesEvento($TbNidosAsistentesEvento);
	}

	public function getReporteBeneficiariosEvento($id_evento, $id_mes){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$beneficiarios = $NidosCirculacionDAO->getReporteBeneficiariosEvento($id_evento, $id_mes);
		$vista=$this->contenedor['vista'];
		$vista->setVariables(array('beneficiarios'=>$beneficiarios));
		$vista->renderHtml();
	}

	public function getReportePandora($id_mes){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$info = $NidosCirculacionDAO->getReportePandora($id_mes);
		$vista=$this->contenedor['vista'];
		$vista->setVariables(array('info'=>$info));
		$vista->renderHtml();
	}

	public function aprobarEvento($id_evento, $estado){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$aprobacion = $NidosCirculacionDAO->aprobarEvento($id_evento, $estado);
		echo $aprobacion;
	}

	public function getReportePdf($id_dupla, $id_mes){
		$NidosCirculacionDAO = $this->contenedor['NidosCirculacionDAO'];
		$datos = $NidosCirculacionDAO->getReportePdf($id_dupla, $id_mes);
		echo json_encode($datos[0]);
	}

	protected function subirArchivos($id_evento, $archivo){
		$current_date_time = date("_d_m_Y_H_i_s");
		$backtrace = debug_backtrace()[1];
		$rutaBase = substr($backtrace['file'],0, strpos($backtrace['file'],'src'));  
		$carpeta = $rutaBase.'uploadedFiles/Nidos/Circulacion/2021/Eventos/'.$id_evento.'/';
		$ubicacion = '../../../uploadedFiles/Nidos/Circulacion/2021/Eventos/'.$id_evento.'/';

		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return 4;
		} 
		else{
			$rta = "";
			foreach ($archivo as $a) {
				$ruta = $carpeta.$this->clean(substr($a["name"], 0, -4).$current_date_time.'.pdf');
				$estado = move_uploaded_file($a['tmp_name'] , $ruta);
				if ($estado){
					$rta = $ubicacion.$this->clean(substr($a["name"], 0, -4).$current_date_time.'.pdf');
				}
				else{
					$rta = "4";
				}
			}	
		}
		//return json_encode($rta);
		return $rta;
	}
	/**
	 * Limpia de tildes y caracteres extraños un string
	 * @param  string $string		  string que se quiere limpiar
	 * @return string         string limpio
	 */
	protected function clean($string) {
		$utf8 = array(
			'/[áàâãªä]/u'   =>   'a',
			'/[ÁÀÂÃÄ]/u'    =>   'A',
			'/[ÍÌÎÏ]/u'     =>   'I',
			'/[íìîï]/u'     =>   'i',
			'/[éèêë]/u'     =>   'e',
			'/[ÉÈÊË]/u'     =>   'E',
			'/[óòôõºö]/u'   =>   'o',
			'/[ÓÒÔÕÖ]/u'    =>   'O',
			'/[úùûü]/u'     =>   'u',
			'/[ÚÙÛÜ]/u'     =>   'U',
			'/ç/'           =>   'c',
			'/Ç/'           =>   'C',
			'/ñ/'           =>   'n',
			'/Ñ/'           =>   'N',
			'/–/'           =>   '-',
			'/[#$!!#]/u'    =>   '',
			'/[’‘‹›‚]/u'    =>   ' ',
			'/[“”«»„]/u'    =>   ' ',
			'/ /'           =>   ' ',
		);
		return str_replace("?", "",utf8_decode(preg_replace(array_keys($utf8), array_values($utf8), $string)));      
	}
}
$objControlador = new RegistroBeneficiariosController();
unset($objControlador);

