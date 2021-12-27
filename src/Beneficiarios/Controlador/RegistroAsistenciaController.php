<?php 
namespace Beneficiarios\Controlador; 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Beneficiarios\Controlador\BeneficiariosFactory;
use General\Persistencia\Entidades\TbNidosExperiencia;

class RegistroAsistenciaController extends BeneficiariosFactory
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


	public function crearNuevaExperiencia($datos){
		$TbNidosExperiencia = $this->contenedor['TbNidosExperiencia'];
		$TbNidosExperienciaArtista = $this->contenedor['TbNidosExperienciaArtista'];
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];

		$TbNidosExperiencia->setFkIdLugarAtencion($datos['LugarAtencion']);
		$TbNidosExperiencia->setFkIdDupla($datos['Dupla']);
		$TbNidosExperiencia->setFkIdGrupo($datos['Grupo']);
		$TbNidosExperiencia->setVcNombreExperiencia($datos['Experiencia']);
		$TbNidosExperiencia->setDtFechaEncuentro($datos['FechaEncuentro']);
		$TbNidosExperiencia->setHrHoraInicio($datos['HoraInicio']);
		$TbNidosExperiencia->setHrHoraFinalizacion($datos['HoraFin']);
		$TbNidosExperiencia->setInCuidadores($datos['Cuidadores']);
		$TbNidosExperiencia->setDtFechaRegistro(date("Y-m-d H:i:s"));
		$TbNidosExperiencia->setInIdPersona($datos['id_usuario']);
		$TbNidosExperiencia->setIntTipoSuplencia($datos['tipo_suplencia']);
		$TbNidosExperiencia->setInModalidad($datos['Modalidad']);
		$TbNidosExperiencia->setBeneficiarioArray(json_decode($datos["CH_asistencia_beneficiario"]));

		$TbNidosExperienciaArtista->setFkIdArtistas(json_decode($datos["artistas_asistencia"]));

		echo $NidosAsistenciaDAO->crearExperiencia($TbNidosExperiencia, $TbNidosExperienciaArtista);
	}

	public function getOptionsLugares($id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$lugares_usuario = $NidosAsistenciaDAO->consultarLugaresUsuario($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('lugares'=>$lugares_usuario));
		$vista->renderHtml();
	}

	public function getInfoExperiencia($idGrupo){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$IdExperiencia = $NidosAsistenciaDAO->consultarEncabezado($idGrupo);
		echo json_encode($IdExperiencia[0]);
	}

	public function getBeneficiariosAsistencia($idgrupo){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$Beneficiarios = $NidosAsistenciaDAO->consultarBeneficiarioGrupo($idgrupo);
		echo json_encode($Beneficiarios);
	}

	public function getOptionsArtistas($id_dupla, $tipo_persona){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$Artistas = $NidosAsistenciaDAO->consultarArtistas($id_dupla,  $tipo_persona);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('Artistas'=>$Artistas));
		$vista->renderHtml();
	}
	public function artistaRemover($id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$artista = $NidosAsistenciaDAO->consultarArtistaRemover($id_usuario);
		echo json_encode($artista);

	}

	public function getOptionsLugaryGrupoArtista($id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$LugaryGrupo = $NidosAsistenciaDAO->consultarLugaryGrupoArtista($id_usuario);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('LugaryGrupo'=>$LugaryGrupo));
		$vista->renderHtml();
	}

	public function getOptionsExperienciaGrupo($parametro){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$experiencia = $NidosAsistenciaDAO->getExperienciaGrupo($parametro);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('experiencia'=>$experiencia));
		$vista->renderHtml();
	}

	public function getInfoEncabezadoExperiencia($idExperiencia){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$IdExperienciaG = $NidosAsistenciaDAO->ConsultaAsistenciaExperienciaEncabezado($idExperiencia);
		echo json_encode($IdExperienciaG[0]);
	}

	public function getConsultaAsistenciaBeneficiarios($idExperiencia){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$beneficiariosAsistencia = $NidosAsistenciaDAO->ConsultaAsistenciaBeneficiariosExperiencia($idExperiencia);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('beneficiariosAsistencia'=>$beneficiariosAsistencia));
		$vista->renderHtml();
	}

	public function getTipoPersona($id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$tipo_persona = $NidosAsistenciaDAO->ConsultaTipoPersona($id_usuario);
		echo json_encode($tipo_persona[0]);
	}

	public function getAtencionesGrupo($id_grupo, $tipo_persona){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$experiencias= $NidosAsistenciaDAO->ConsultarAtencionesGrupo($id_grupo, $tipo_persona);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('experiencias'=>$experiencias));
		$vista->renderHtml();
	}

	public function getConsultarDuplaM($id_usuario){
		$NidosDuplasDAO = $this->contenedor['NidosDuplasDAO'];
		$Consulta_duplasM = $NidosDuplasDAO->ConsultarDuplasM($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('ConsultaDuplaM'=>$Consulta_duplasM));
		$vista->renderHtml("Territorial");
	}

	public function getGruposDupla($id_dupla){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$grupos = $NidosAsistenciaDAO->ConsultarGruposDupla($id_dupla);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();
	}

	public function getInfoExperienciaEncabezado($experiencia){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$IdExperiencia = $NidosAsistenciaDAO->consultarExperienciaEncabezado($experiencia);
		echo json_encode($IdExperiencia[0]);
	}

	public function getBeneficiariosModificarExperiencia($id_atencion){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$Beneficiarios = $NidosAsistenciaDAO->consultarBeneficiariosModificarExperiencia($id_atencion);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Beneficiarios'=>$Beneficiarios));
		$vista->renderHtml();
	}

	public function getExperienciasEliminar($id_grupo){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$experiencias = $NidosAsistenciaDAO->getExperienciasEliminar($id_grupo);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('experiencias'=>$experiencias));
		$vista->renderHtml();
	}

	public function eliminarExperiencia($id_experiencia){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		echo $NidosAsistenciaDAO->eliminarExperiencia($id_experiencia);
	}

	public function modificarAsistencia($datos){
		$TbNidosExperiencia = $this->contenedor['TbNidosExperiencia'];
		$TbNidosAsistencia = $this->contenedor['TbNidosAsistencia'];
		$TbNidosExperienciaArtista = $this->contenedor['TbNidosExperienciaArtista'];
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];

		$TbNidosExperiencia->setPkIdExperiencia($datos["IdExperiencia"]);
		$TbNidosExperiencia->setDtFechaEncuentro($datos['FechaAtencion']);
		$TbNidosExperiencia->setVcNombreExperiencia($datos["HoraInicio"]);
		$TbNidosExperiencia->setHrHoraInicio($datos["HoraFin"]);
		$TbNidosExperiencia->setHrHoraFinalizacion($datos["Experiencia"]);
		$TbNidosExperiencia->setIntTipoSuplencia($datos["tipo_suplencia"]);
		$TbNidosExperiencia->setInModalidad($datos['Modalidad']);
		$TbNidosExperiencia->setInCuidadores($datos["cuidadores"]);
		$NidosAsistenciaDAO->modificarInfoBasicaExperiencia($TbNidosExperiencia);

	/*	$NidosAsistenciaDAO->eliminarArtistasExperiencia($datos["IdExperiencia"]);

		$TbNidosExperienciaArtista->setFkIdExperiencia($datos["IdExperiencia"]);
		$TbNidosExperienciaArtista->setFkIdArtistas($datos["artistas_asistencia"]);
		$NidosAsistenciaDAO->crearArtistasExperiencia($TbNidosExperienciaArtista); */

		$array_asistencia = $datos["array_asistencia"];
		foreach ($array_asistencia as $key => $asistencia) {
			if (isset($asistencia["id_beneficiario"])) {
				$TbNidosAsistencia->setFkIdExperiencia($datos['IdExperiencia']);
				$TbNidosAsistencia->setFkIdBeneficiario($asistencia['id_beneficiario']);
				$TbNidosAsistencia->setVcAsistencia($asistencia['estado']);
				$NidosAsistenciaDAO->crearObjetoAsistenciaBeneficiario($TbNidosAsistencia);
			}else if (isset($asistencia["id_asistencia"])) {
				$TbNidosAsistencia->setPkIdAsistencia($asistencia['id_asistencia']);
				$TbNidosAsistencia->setVcAsistencia($asistencia['estado']);
				$NidosAsistenciaDAO->modificarObjetoAsistencia($TbNidosAsistencia);
			}
		}
	}

	public function validarExperienciaDuplicada($id_grupo, $fecha){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		echo $NidosAsistenciaDAO->validarExperienciaDuplicada($id_grupo, $fecha);
	}

	public function ConsultaDuplaArtista($id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$tipo_persona = $NidosAsistenciaDAO->ConsultaDuplaArtista($id_usuario);
		echo json_encode($tipo_persona[0]);
	}

	public function ConsultaLugarGrupo($id_grupo){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$tipo_persona = $NidosAsistenciaDAO->ConsultaLugarGrupo($id_grupo);
		echo json_encode($tipo_persona[0]);
	}

	public function guardarBeneficiariosSinInfo($datos_string, $archivo){ 
		$datos = json_decode($datos_string,true);

		$TbNidosExperiencia = $this->contenedor['TbNidosExperiencia'];
		$TbNidosSinInformacionContenidos = $this->contenedor['TbNidosSinInformacionContenidos'];
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];

		$TbNidosExperiencia->setFkIdLugarAtencion($datos['LugarAtencion']);
		$TbNidosExperiencia->setFkIdDupla($datos['Dupla']);
		$TbNidosExperiencia->setFkIdGrupo($datos['Grupo']);
		$TbNidosExperiencia->setVcNombreExperiencia($datos['Experiencia']);
		$TbNidosExperiencia->setDtFechaEncuentro($datos['FechaEncuentro']);
		$TbNidosExperiencia->setHrHoraInicio($datos['HoraInicio']);
		$TbNidosExperiencia->setHrHoraFinalizacion($datos['HoraFin']);
		$TbNidosExperiencia->setInCuidadores($datos['Cuidadores']);
		$TbNidosExperiencia->setDtFechaRegistro(date("Y-m-d H:i:s"));
		$TbNidosExperiencia->setInIdPersona($datos['id_usuario']);
		$TbNidosExperiencia->setIntTipoSuplencia($datos['tipo_suplencia']);

		$TbNidosSinInformacionContenidos->setInTotalBeneficiarios($datos['total_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinos($datos['ninos_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinas($datos['ninas_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinos03($datos['ninos0a3_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinos36($datos['ninos4a6_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinos6($datos['ninos6_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinas03($datos['ninas0a3_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinas36($datos['ninas4a6_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinas6($datos['ninas6_atendidos']);
		$TbNidosSinInformacionContenidos->setInMujeresGestantes($datos['gestantes_atendidos']);
		$TbNidosSinInformacionContenidos->setInAfrodescendiente($datos['afro']);
		$TbNidosSinInformacionContenidos->setInCampesina($datos['rural']);
		$TbNidosSinInformacionContenidos->setInDiscapacidad($datos['discapacidad']);
		$TbNidosSinInformacionContenidos->setInConflicto($datos['conflicto']);
		$TbNidosSinInformacionContenidos->setInIndigena($datos['indigena']);
		$TbNidosSinInformacionContenidos->setInPrivados($datos['liberta']);
		$TbNidosSinInformacionContenidos->setInVictimas($datos['violencia']);
		$TbNidosSinInformacionContenidos->setInRaizal($datos['raizal']);
		$TbNidosSinInformacionContenidos->setInRom($datos['rom']);

		$TbNidosSinInformacionContenidos->setFkIdLugarAtencion($datos['LugarAtencion']);
		$TbNidosSinInformacionContenidos->setFkIdGrupo($datos['Grupo']);
		$TbNidosSinInformacionContenidos->setVcContenido('0');
		$TbNidosSinInformacionContenidos->setDtFechaEntrega($datos['FechaEncuentro']);
		$TbNidosSinInformacionContenidos->setFkIdUsuarioRegistro($datos['id_usuario']);
		$TbNidosSinInformacionContenidos->setDtFechaRegistro(date("Y-m-d H:i:s"));
		$TbNidosSinInformacionContenidos->setINComponente('1');

		$TbNidosSinInformacionContenidos->setINTotalBeneficiariosNuevos($datos['total_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinosNuevos($datos['ninos_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinasNuevos($datos['ninas_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinos03Nuevos($datos['ninos0a3_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinos36Nuevos($datos['ninos4a6_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinos6Nuevos($datos['ninos6_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinas03Nuevos($datos['ninas0a3_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinas36Nuevos($datos['ninas4a6_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinas6Nuevos($datos['ninas6_nuevos']);
		$TbNidosSinInformacionContenidos->setINMujeresGestantesNuevos($datos['gestantes_nuevos']);
		$TbNidosSinInformacionContenidos->setINAfrodescendienteNuevo($datos['afro_nuevos']);
		$TbNidosSinInformacionContenidos->setINCampesinaNuevo($datos['rural_nuevos']);
		$TbNidosSinInformacionContenidos->setINDiscapacidadNuevo($datos['discapacidad_nuevos']);
		$TbNidosSinInformacionContenidos->setINConflictoNuevo($datos['conflicto_nuevos']);
		$TbNidosSinInformacionContenidos->setINIndigenaNuevo($datos['indigena_nuevos']);
		$TbNidosSinInformacionContenidos->setINPrivadosNuevo($datos['liberta_nuevos']);
		$TbNidosSinInformacionContenidos->setINVictimasNuevo($datos['violencia_nuevos']);
		$TbNidosSinInformacionContenidos->setINRaizalNuevo($datos['raizal_nuevos']);
		$TbNidosSinInformacionContenidos->setINRomNuevo($datos['rom_nuevos']);

		$dupla = $datos['Dupla'];
		$grupo = $datos['Grupo'];
		$fecha = $datos['FechaEncuentro'];

		$rta = $this->subirArchivos($archivo,$dupla,$grupo,$fecha);
		$TbNidosSinInformacionContenidos->setVcDocumentoSoporte($rta);

		echo $NidosAsistenciaDAO->crearExperienciaBeneficiariosCifras($TbNidosExperiencia, $TbNidosSinInformacionContenidos);

		/*if($datos["id_experiencia"] == 1){ 
			echo $NidosAsistenciaDAO->crearExperienciaBeneficiariosCifras($TbNidosExperiencia, $TbNidosSinInformacionContenidos);
		}else{
			echo $NidosAsistenciaDAO->agregarBeneficiariosaExperiencia($TbNidosSinInformacionContenidos);
		} */
		
	}

	protected function subirArchivos($archivo,$dupla,$grupo,$fecha){
		$hora_actual = time();		
		$backtrace = debug_backtrace()[1];
		$rutaBase = substr($backtrace['file'],0, strpos($backtrace['file'],'src'));  
		$carpeta = $rutaBase.'uploadedFiles/Territorial/Experiencia/'.$dupla.'/'.$grupo.'/';
		$ubicacion = '../../../uploadedFiles/Territorial/Experiencia/'.$dupla.'/'.$grupo.'/';
		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return 4;
		} 
		$rta = "";
		foreach ($archivo as $a) {			
			$ruta = $carpeta."soporte_".$fecha."-".$hora_actual.".pdf";
			if (move_uploaded_file($a['tmp_name'] , $ruta)){								
				$rta .= $ubicacion."soporte_".$fecha."-".$hora_actual.".pdf";
			}else{
				$rta = "4";
			}
		}
		return $rta;
	}
	
	public function getExperienciasCifras($id_mes, $id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$Datos = $NidosAsistenciaDAO->getExperienciasCifras($id_mes, $id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}

	public function getConsultaAsistenciasDupla($id_mes, $id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$Datos = $NidosAsistenciaDAO->getConsultaAsistenciasDupla($id_mes, $id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Datos'=>$Datos));
		$vista->renderHtml();
	}

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

	public function borrarArchivo($experiencia,$soporte){
		$hora_actual = time();
		$backtrace = debug_backtrace()[1];
		$rutaBase =   substr($backtrace['file'],0, strpos($backtrace['file'],'src'));
		//$carpeta = $fecha;
		$archivo = $soporte;
		// ../../../uploadedFiles/Territorial/Experiencia/244/7387/soporte_2020-04-04.pdf
		unlink($archivo);
			$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
			echo $NidosAsistenciaDAO->borrarArchivo($experiencia);
	}

	protected function subirUsoImagen($datos_string, $archivo){
		$hora_actual = time();
		$datos = json_decode($datos_string,true);

		$backtrace = debug_backtrace()[1];
		$rutaBase = substr($backtrace['file'],0, strpos($backtrace['file'],'src'));  
		$carpeta = $rutaBase.'uploadedFiles/Territorial/Experiencia/'.$datos['id_dupla'].'/'.$datos['id_lugar'].'/'.$datos['id_mes'].'/';
		$ubicacion = '../../../uploadedFiles/Territorial/Experiencia/'.$datos['id_dupla'].'/'.$datos['id_lugar'].'/'.$datos['id_mes'].'/';
		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return 4;
		}else{
			$rta = "";
			foreach ($archivo as $a) {
				$ruta = $carpeta."soporte_lugar".$hora_actual.".pdf";
				if (move_uploaded_file($a['tmp_name'] , $ruta)){
					$rta .= $ubicacion."soporte_lugar".$hora_actual.".pdf";
					
					$TbNidosExperienciaSoporte = $this->contenedor['TbNidosExperienciaSoporte'];
					$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];

					$TbNidosExperienciaSoporte->setFkIdDupla($datos['id_dupla']);
					$TbNidosExperienciaSoporte->setFkIdLugarAtencion($datos['id_lugar']);					
					$TbNidosExperienciaSoporte->setInMes($datos['id_mes']);
					$TbNidosExperienciaSoporte->setVcDocumentoSoporte($rta);
					echo $NidosAsistenciaDAO->subirUsoImagen($TbNidosExperienciaSoporte);
				}
				else
					$rta = "4";
			}
			return $rta;
		}
	}

	public function eliminarExperienciaCifras($id_experiencia){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		echo $NidosAsistenciaDAO->eliminarExperienciaCifras($id_experiencia);
	}

	public function ActualizarCifrasBeneficiarios($datos_string){ 
		$datos = json_decode($datos_string,true);

		$TbNidosSinInformacionContenidos = $this->contenedor['TbNidosSinInformacionContenidos'];
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];

		$TbNidosSinInformacionContenidos->setInTotalBeneficiarios($datos['total_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinos($datos['ninos_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinas($datos['ninas_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinos03($datos['ninos0a3_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinos36($datos['ninos4a6_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinas03($datos['ninas0a3_atendidos']);
		$TbNidosSinInformacionContenidos->setInTotalNinas36($datos['ninas4a6_atendidos']);
		$TbNidosSinInformacionContenidos->setInMujeresGestantes($datos['gestantes_atendidos']);
		$TbNidosSinInformacionContenidos->setInAfrodescendiente($datos['afro']);
		$TbNidosSinInformacionContenidos->setInCampesina($datos['rural']);
		$TbNidosSinInformacionContenidos->setInDiscapacidad($datos['discapacidad']);
		$TbNidosSinInformacionContenidos->setInConflicto($datos['conflicto']);
		$TbNidosSinInformacionContenidos->setInIndigena($datos['indigena']);
		$TbNidosSinInformacionContenidos->setInPrivados($datos['liberta']);
		$TbNidosSinInformacionContenidos->setInVictimas($datos['violencia']);
		$TbNidosSinInformacionContenidos->setInRaizal($datos['raizal']);
		$TbNidosSinInformacionContenidos->setInRom($datos['rom']);

		$TbNidosSinInformacionContenidos->setDtFechaRegistro(date("Y-m-d H:i:s"));
		$TbNidosSinInformacionContenidos->setFkIdExperiencia($datos['id_experiencia']);

		$TbNidosSinInformacionContenidos->setINTotalBeneficiariosNuevos($datos['total_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinosNuevos($datos['ninos_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinasNuevos($datos['ninas_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinos03Nuevos($datos['ninos0a3_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinos36Nuevos($datos['ninos4a6_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinas03Nuevos($datos['ninas0a3_nuevos']);
		$TbNidosSinInformacionContenidos->setINTotalNinas36Nuevos($datos['ninas4a6_nuevos']);
		$TbNidosSinInformacionContenidos->setINMujeresGestantesNuevos($datos['gestantes_nuevos']);
		$TbNidosSinInformacionContenidos->setINAfrodescendienteNuevo($datos['afro_nuevos']);
		$TbNidosSinInformacionContenidos->setINCampesinaNuevo($datos['rural_nuevos']);
		$TbNidosSinInformacionContenidos->setINDiscapacidadNuevo($datos['discapacidad_nuevos']);
		$TbNidosSinInformacionContenidos->setINConflictoNuevo($datos['conflicto_nuevos']);
		$TbNidosSinInformacionContenidos->setINIndigenaNuevo($datos['indigena_nuevos']);
		$TbNidosSinInformacionContenidos->setINPrivadosNuevo($datos['liberta_nuevos']);
		$TbNidosSinInformacionContenidos->setINVictimasNuevo($datos['violencia_nuevos']);
		$TbNidosSinInformacionContenidos->setINRaizalNuevo($datos['raizal_nuevos']);
		$TbNidosSinInformacionContenidos->setINRomNuevo($datos['rom_nuevos']);
		echo $NidosAsistenciaDAO->ActualizarCifrasBeneficiarios($TbNidosSinInformacionContenidos);	
	}

	public function consultarTotalExperienciasMes($id_mes, $id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$IdExperiencia = $NidosAsistenciaDAO->consultarTotalExperienciasMes($id_mes, $id_usuario);
		echo json_encode($IdExperiencia[0]);
	}

	public function consultarExperienciaLugarDupla($id_mes, $id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$lugares_guardados = $NidosAsistenciaDAO->consultarExperienciaLugarDupla($id_mes, $id_usuario);
		$vista= $this->contenedor['vista']; 
		$vista->setVariables(array('lugares'=>$lugares_guardados));
		$vista->renderHtml();
}

public function consultarExperienciaLaboratorioDupla($id_mes, $id_usuario){
	$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
	$lugares_guardados = $NidosAsistenciaDAO->consultarExperienciaLaboratorioDupla($id_mes, $id_usuario);
	$vista= $this->contenedor['vista']; 
	$vista->setVariables(array('lugares'=>$lugares_guardados));
	$vista->renderHtml();
}

public function cargarUsoDatosManual($datos){
	$TbNidosBeneficiarios = $this->contenedor['TbNidosBeneficiarios'];
	$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
	$TbNidosBeneficiarios->setVcIdentificacion($datos['Identificacion']);
	$TbNidosBeneficiarios->setVcUsoImagen($datos['AutorizacionDatos']);	
	echo $NidosBeneficiariosDAO->cargarUsoDatosManual($TbNidosBeneficiarios);
}
	
}
 
$objControlador = new RegistroAsistenciaController();
unset($objControlador);
