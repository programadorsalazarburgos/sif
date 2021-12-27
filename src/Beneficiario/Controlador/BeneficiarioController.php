<?php

namespace Beneficiario\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use Beneficiario\Controlador\BeneficiarioFactory;

class BeneficiarioController extends BeneficiarioFactory
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
		@session_start();
	}

	public function consultarTablaEstudiante($datosEstudiante){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
 		$tbEstudiante=$this->contenedor['TbEstudiante'];
 		$tbEstudiante->setVariables($datosEstudiante);
		$estudiante = $BeneficiarioDAO->consultarEstudianteEnTbEstudiante($tbEstudiante);
		$vista = $this->contenedor['vista'];
		$vista->setNamespace('GestionClan');
		$vista->setPlantilla('tableEstudiantesBase');
		$vista->setVariables(array('estudiante'=>$estudiante,'tipo_mostrar'=>'consultar_para_editar'));
		$vista->renderHtml();
	}

	public function consultarEstudianteDetalleAnio($id_estudiante,$anio){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$detalle_anio = $BeneficiarioDAO->consultarEstudianteDetalleAnio($id_estudiante,$anio);
		if(empty($detalle_anio)){
			echo "0";
		}else{
			echo json_encode($detalle_anio);
		}
	}

	public function actualizarRegistroDetalleAnio($datos){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$TbEstudianteDetalleAnio = $this->contenedor['TbEstudianteDetalleAnio'];
		$TbEstudianteDetalleAnio->setFkLocalidad(isset($datos['SL_localidad'])? $datos['SL_localidad']:NULL);
		$TbEstudianteDetalleAnio->setFkEps(isset($datos['SL_eps'])? $datos['SL_eps']:NULL);
		$TbEstudianteDetalleAnio->setFkGrupoPoblacional(isset($datos['SL_grupo_poblacional'])? $datos['SL_grupo_poblacional']:NULL);
		$TbEstudianteDetalleAnio->setFkClan(isset($datos['SL_crea'])? $datos['SL_crea']:NULL);
		$TbEstudianteDetalleAnio->setFkColegio(isset($datos['SL_colegio'])? $datos['SL_colegio']:NULL);
		$TbEstudianteDetalleAnio->setFkJornada(isset($datos['SL_jornada'])? $datos['SL_jornada']:NULL);
		$TbEstudianteDetalleAnio->setFkGrado(isset($datos['SL_grado'])? $datos['SL_grado']:NULL);
		$TbEstudianteDetalleAnio->setFKTipoDiscapacidad(isset($datos['SL_tipo_discapacidad'])? $datos['SL_tipo_discapacidad']:NULL);
		$TbEstudianteDetalleAnio->setFkTipoPoblacionVictima(isset($datos['SL_tipo_poblacion_victima'])? $datos['SL_tipo_poblacion_victima']:NULL);
		$TbEstudianteDetalleAnio->setIdentificacionAcudiente(isset($datos['TX_identificacion_acudiente'])? $datos['TX_identificacion_acudiente']:NULL);
		$TbEstudianteDetalleAnio->setNombreAcudiente(isset($datos['TX_nombre_acudiente'])? $datos['TX_nombre_acudiente']:NULL);
		$TbEstudianteDetalleAnio->setTelefonoAcudiente(isset($datos['TX_telefono_acudiente'])? $datos['TX_telefono_acudiente']:NULL);
		$TbEstudianteDetalleAnio->setTXBarrio(isset($datos['TX_barrio'])? $datos['TX_barrio']:NULL);
		$TbEstudianteDetalleAnio->setInEstrato(isset($datos['SL_estrato'])? $datos['SL_estrato']:NULL);
		$TbEstudianteDetalleAnio->setTxTipoAfiliacion(isset($datos['TX_tipo_afiliacion'])? $datos['TX_tipo_afiliacion']:NULL);
		$TbEstudianteDetalleAnio->setFkEtnia(isset($datos['SL_etnia'])? $datos['SL_etnia']:NULL);
		$TbEstudianteDetalleAnio->setTxEnfermedades(isset($datos['TX_enfermedades'])? $datos['TX_enfermedades']:NULL);
		$TbEstudianteDetalleAnio->setTxObservaciones(isset($datos['TX_observaciones'])? $datos['TX_observaciones']:NULL);
		$TbEstudianteDetalleAnio->setFkEstudiante(isset($datos['id_estudiante'])? $datos['id_estudiante']:NULL);
		$TbEstudianteDetalleAnio->setFkUsuarioCreacion($_SESSION["session_username"]);
		$TbEstudianteDetalleAnio->setAnio(date('Y'));
		$estudiante = $BeneficiarioDAO->modificarDetalleAnio($TbEstudianteDetalleAnio);
		echo $estudiante;
	}

	public function crearRegistroDetalleAnio($datos){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$TbEstudianteDetalleAnio = $this->contenedor['TbEstudianteDetalleAnio'];
		$TbEstudianteDetalleAnio->setFkLocalidad(isset($datos['SL_localidad'])? $datos['SL_localidad']:NULL);
		$TbEstudianteDetalleAnio->setFkEps(isset($datos['SL_eps'])? $datos['SL_eps']:NULL);
		$TbEstudianteDetalleAnio->setFkGrupoPoblacional(isset($datos['SL_grupo_poblacional'])? $datos['SL_grupo_poblacional']:NULL);
		$TbEstudianteDetalleAnio->setFkClan(isset($datos['SL_crea'])? $datos['SL_crea']:NULL);
		$TbEstudianteDetalleAnio->setFkColegio(isset($datos['SL_colegio'])? $datos['SL_colegio']:NULL);
		$TbEstudianteDetalleAnio->setFkJornada(isset($datos['SL_jornada'])? $datos['SL_jornada']:NULL);
		$TbEstudianteDetalleAnio->setFkGrado(isset($datos['SL_grado'])? $datos['SL_grado']:NULL);
		$TbEstudianteDetalleAnio->setFKTipoDiscapacidad(isset($datos['SL_tipo_discapacidad'])? $datos['SL_tipo_discapacidad']:NULL);
		$TbEstudianteDetalleAnio->setFkTipoPoblacionVictima(isset($datos['SL_tipo_poblacion_victima'])? $datos['SL_tipo_poblacion_victima']:NULL);
		$TbEstudianteDetalleAnio->setIdentificacionAcudiente(isset($datos['TX_identificacion_acudiente'])? $datos['TX_identificacion_acudiente']:NULL);
		$TbEstudianteDetalleAnio->setNombreAcudiente(isset($datos['TX_nombre_acudiente'])? $datos['TX_nombre_acudiente']:NULL);
		$TbEstudianteDetalleAnio->setTelefonoAcudiente(isset($datos['TX_telefono_acudiente'])? $datos['TX_telefono_acudiente']:NULL);
		$TbEstudianteDetalleAnio->setTXBarrio(isset($datos['TX_barrio'])? $datos['TX_barrio']:NULL);
		$TbEstudianteDetalleAnio->setInEstrato(isset($datos['SL_estrato'])? $datos['SL_estrato']:NULL);
		$TbEstudianteDetalleAnio->setTxTipoAfiliacion(isset($datos['TX_tipo_afiliacion'])? $datos['TX_tipo_afiliacion']:NULL);
		$TbEstudianteDetalleAnio->setFkEtnia(isset($datos['SL_etnia'])? $datos['SL_etnia']:NULL);
		$TbEstudianteDetalleAnio->setTxEnfermedades(isset($datos['TX_enfermedades'])? $datos['TX_enfermedades']:NULL);
		$TbEstudianteDetalleAnio->setTxObservaciones(isset($datos['TX_observaciones'])? $datos['TX_observaciones']:NULL);
		$TbEstudianteDetalleAnio->setFkEstudiante(isset($datos['id_estudiante'])? $datos['id_estudiante']:NULL);
		$TbEstudianteDetalleAnio->setAnio(date('Y'));
		$TbEstudianteDetalleAnio->setFkUsuarioCreacion($_SESSION["session_username"]);
		$resultado = $BeneficiarioDAO->crearRegistroDetalleAnio($TbEstudianteDetalleAnio);
		echo $resultado;
	}

	public function consultarAnioDetalleEstudiante($id_estudiante){
		$return = "";
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$anio_detalle_anio = $BeneficiarioDAO->consultarAnioDetalleEstudiante($id_estudiante);
		foreach ($anio_detalle_anio as $d) {
			$return .= "<option value='".$d['anio']."'>".$d['anio']."</option>";
		}
		echo $return;
	}

	public function consultarAnioEstudianteArchivo($id_estudiante){
		$return = "";
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$anio_archivo = $BeneficiarioDAO->consultarAnioEstudianteArchivo($id_estudiante);
		foreach ($anio_archivo as $d) {
			$return .= "<option value='".$d['anio']."'>".$d['anio']."</option>";
		}
		echo $return;
	}

	public function consultarEstudianteArchivo($id_estudiante,$anio){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$archivo_anio = $BeneficiarioDAO->consultarEstudianteArchivo($id_estudiante,$anio);
		if(empty($archivo_anio)){
			echo "0";
		}else{
			echo json_encode($archivo_anio);
		}
	}

	public function consultarDatosBasicosEstudiante($id_estudiante){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$datos_estudiante = $BeneficiarioDAO->consultarDatosBasicosEstudiante($id_estudiante);
		if(empty($datos_estudiante)){
			echo "0";
		}else{
			echo json_encode($datos_estudiante);
		}
	}

	public function consultarGruposBeneficiarioAnio($datos){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$datos_grupo = $BeneficiarioDAO->consultarGruposBeneficiarioAnio($datos);
		echo json_encode($datos_grupo);
	}

	public function obtenerFormulario($datos){
		$vista = $this->contenedor['vista'];
		$vista->setPlantilla('Formulario'.$datos['tipo_formulario']);
		$vista->renderHtml();
	}

	public function registrarBeneficiario($datos_beneficiario_json,$documentos_beneficiario){
		$datos_beneficiario = json_decode($datos_beneficiario_json,true);
		$fecha_hora_actual = date('Y-m-d H:i:s');
 		$anio_actual = date('Y');
 		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
 		$TbEstudiante = $this->contenedor['TbEstudiante'];
 		$TbEstudiante->setInIdentificacion($datos_beneficiario['numero_documento']);
 		$TbEstudiante->setChTipoIdentificacion($datos_beneficiario['id_tipo_identificacion']);
 		$TbEstudiante->setVcPrimerNombre(trim($datos_beneficiario['primer_nombre']));
 		$TbEstudiante->setVcSegundoNombre(trim($datos_beneficiario['segundo_nombre']));
 		$TbEstudiante->setVcPrimerApellido(trim($datos_beneficiario['primer_apellido']));
 		$TbEstudiante->setVcSegundoApellido(trim($datos_beneficiario['segundo_apellido']));
 		$TbEstudiante->setDdFNacimiento($datos_beneficiario['fecha_nacimiento']);
 		$TbEstudiante->setChGenero($datos_beneficiario['id_sexo']);
 		$TbEstudiante->setVcDireccion($datos_beneficiario['direccion']);
 		$TbEstudiante->setVcCorreo($datos_beneficiario['correo_electronico']);
 		$TbEstudiante->setVcTelefono($datos_beneficiario['telefono_fijo']);
 		$TbEstudiante->setVcCelular($datos_beneficiario['telefono_celular']);
 		$TbEstudiante->setDaFechaRegistro($fecha_hora_actual);
 		$TbEstudiante->setIdUsuarioRegistro($datos_beneficiario['id_usuario']);
 		$TbEstudiante->setVcTipoEstudiante($datos_beneficiario['fuente']);
 		$TbEstudiante->setNacionalidad($datos_beneficiario['nacionalidad']);
 		$TbEstudiante->setFkRh($datos_beneficiario['id_grupo_sanguineo']);
		$TbEstudiante->setInAceptaUsoImagen($datos_beneficiario['acepta_uso_imagen']);
		$TbEstudiante->setInAceptaUsoObras($datos_beneficiario['acepta_uso_obras']);
		$TbEstudiante->setInAceptaUsoDatos($datos_beneficiario['acepta_uso_datos']);

 		$TbEstudianteDetalleAnio = $this->contenedor['TbEstudianteDetalleAnio'];
 		$TbEstudianteDetalleAnio->setAnio($anio_actual);
 		$TbEstudianteDetalleAnio->setFkClan($datos_beneficiario['id_crea']);
 		$TbEstudianteDetalleAnio->setFkColegio($datos_beneficiario['id_colegio']);
 		$TbEstudianteDetalleAnio->setFkJornada($datos_beneficiario['id_jornada']);
		$TbEstudianteDetalleAnio->setFkGrado($datos_beneficiario['id_grado']);
 		$TbEstudianteDetalleAnio->setNombreAcudiente($datos_beneficiario['nombre_acudiente']);
 		$TbEstudianteDetalleAnio->setIdentificacionAcudiente($datos_beneficiario['documento_acudiente']);
 		$TbEstudianteDetalleAnio->setTelefonoAcudiente($datos_beneficiario['telefono_acudiente']);
 		$TbEstudianteDetalleAnio->setFkGrupoPoblacional($datos_beneficiario['id_grupo_poblacional']);
 		$TbEstudianteDetalleAnio->setFkEps($datos_beneficiario['id_eps']);
 		$TbEstudianteDetalleAnio->setTxTipoAfiliacion($datos_beneficiario['id_tipo_afiliacion']);
 		$TbEstudianteDetalleAnio->setTxEnfermedades($datos_beneficiario['enfermedades']);
 		$TbEstudianteDetalleAnio->setFkLocalidad($datos_beneficiario['id_localidad']);
 		$TbEstudianteDetalleAnio->setTxBarrio($datos_beneficiario['barrio']);
 		$TbEstudianteDetalleAnio->setFkTipoPoblacionVictima($datos_beneficiario['id_tipo_poblacion_victima']);
 		$TbEstudianteDetalleAnio->setFkTipoDiscapacidad($datos_beneficiario['id_tipo_discapacidad']);
 		$TbEstudianteDetalleAnio->setFkEtnia($datos_beneficiario['id_etnia']);
 		$TbEstudianteDetalleAnio->setFkUsuarioCreacion($datos_beneficiario['id_usuario']);
 		$TbEstudianteDetalleAnio->setInEstrato($datos_beneficiario['estrato']);
 		$TbEstudianteDetalleAnio->setPuntajeSisben($datos_beneficiario['puntaje_sisben']);
 		$TbEstudianteDetalleAnio->setTxObservaciones($datos_beneficiario['observaciones']);

 		$TbEstudianteDetalleAnio->setFkAreaArtisticaInteres($datos_beneficiario['id_area_artistica_interes']);
 		$TbEstudianteDetalleAnio->setInExperiencia($datos_beneficiario['experiencia']);
 		$TbEstudianteDetalleAnio->setInExperienciaEmpirica($datos_beneficiario['experiencia_empirica']);
 		$TbEstudianteDetalleAnio->setInExperienciaAcademica($datos_beneficiario['experiencia_academia']);
 		$TbEstudianteDetalleAnio->setInExperienciaAnios($datos_beneficiario['experiencia_anios']);

		$datos_encapsulados = array('TbEstudiante' => $TbEstudiante,'TbEstudianteDetalleAnio' =>$TbEstudianteDetalleAnio);
 		$id_beneficiario = $BeneficiarioDAO->crearObjeto($datos_encapsulados);
 		if($datos_beneficiario['numero_documento'] == ''){
 			$documento_beneficiario_creado = 'SIFPROV'.$id_beneficiario;
 		}else{
 			$documento_beneficiario_creado = $datos_beneficiario['numero_documento'];
 		}
 		$archivos = $this->subirArchivos($documento_beneficiario_creado,$documentos_beneficiario,$datos_beneficiario['id_usuario']);
 		echo $id_beneficiario;
	}

	public function consultarEstudiantePorDocumento($numero_documento){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$id_beneficiario = $BeneficiarioDAO->consultarIDEstudiantePorDocumento($numero_documento);
		if(empty($id_beneficiario)){
			echo "0";
		}else{
			echo "1";
		}
	}

	public function consultarIDEstudiantePorDocumento($numero_documento){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$id_beneficiario = $BeneficiarioDAO->consultarIDEstudiantePorDocumento($numero_documento);
		if(empty($id_beneficiario)){
			echo 0;
		}else{
			echo $id_beneficiario[0]["id"];
		}
	}

	public function validarExistenciaDocumentosAnio($id_beneficiario){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$fecha_hora_actual = date('Y-m-d H:i:s');
		$anio_actual = date('Y');
		$documento_beneficiario = $BeneficiarioDAO->consultarDatosBasicosEstudiante($id_beneficiario)[0]['IN_Identificacion'];
		$tiene_documentos_este_anio = $BeneficiarioDAO->consultarEstudianteArchivo($documento_beneficiario,$anio_actual);
		if(empty($tiene_documentos_este_anio)){
			echo 0;
		}else{
			echo 1;
		}
	}

	public function subirArchivosBeneficiarioAnioActual($datos_beneficiario,$archivos){
		$datos_beneficiario = json_decode($datos_beneficiario,true);
		$archivos = $this->subirArchivos($datos_beneficiario['id_beneficiario'],$archivos,$datos_beneficiario['id_usuario']);
		echo 1;
	}

	public function actualizarFechaNacimiento($datos){
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		echo $BeneficiarioDAO->actualizarFechaNacimiento($datos);
	}

	private function subirArchivos($id_beneficiario,$archivos,$id_usuario)
	{
		$BeneficiarioDAO = $this->contenedor['BeneficiarioDAO'];
		$fecha_hora_actual = date('Y-m-d H:i:s');
		$anio_actual = date('Y');
		$backtrace = debug_backtrace()[1];
		$rutaBase =   substr($backtrace['file'],0, strpos($backtrace['file'],'src'));  
		$carpeta = $rutaBase.'uploadedFiles/documentosEstudiantes/'.$anio_actual.'/'.$id_beneficiario.'/';
		$ubicacion = "../../uploadedFiles/documentosEstudiantes/".$anio_actual.'/'.$id_beneficiario.'/';
		$url_archivo = "documentosEstudiantes/".$anio_actual.'/'.$id_beneficiario.'/';
		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return 4;
		} 
		else{
			$rta = "";
			if(!empty($archivos)){
				foreach ($archivos as $clave => $archivo) {
					$ext = pathinfo($archivo["name"], PATHINFO_EXTENSION);
					$archivo['name'] = "";
					switch ($clave) {
						case 0:
							$archivo['name'] = "documento_identificacion.".$ext;
							$BeneficiarioDAO->eliminarArchivoPorNombreBeneficiario('documento_identificacion',$id_beneficiario);
							break;
						case 1:
							$archivo['name'] = "recibo_publico.".$ext;
							$BeneficiarioDAO->eliminarArchivoPorNombreBeneficiario('recibo_publico',$id_beneficiario);
							break;
						case 2:
							$archivo['name'] = "eps.".$ext;
							$BeneficiarioDAO->eliminarArchivoPorNombreBeneficiario('eps',$id_beneficiario);
							break;
						case 3:
							$archivo['name'] = "permiso_uso_imagen.".$ext;
							$BeneficiarioDAO->eliminarArchivoPorNombreBeneficiario('permiso_uso_imagen',$id_beneficiario);
							break;						
						default:
							break;
					}
					$ruta = $carpeta.$this->clean($archivo['name']);
					if ($rta != "4"){					
						if (move_uploaded_file($archivo['tmp_name'] , $ruta)){
							$url_completa = $url_archivo.$archivo['name'];
							$rta .= $ubicacion.$this->clean($archivo['name'])."///";
							$datos_table_db = array(
								'FK_Id_Estudiante' => $id_beneficiario,
								'VC_Nombre_Archivo' => $archivo['name'],
								'VC_Url' => $url_completa,
								'DA_Fecha_Subida' => $fecha_hora_actual,
								'FK_Usuario_Creacion' => $id_usuario,
								'Anio' => $anio_actual
							);
							$BeneficiarioDAO->agregarArchivoBeneficiario($datos_table_db);
						}
						else
							$rta = "4";
					}

				}
			}
			$rta = rtrim($rta,"///");
			return $rta;            
		} 
	}
	/**
	 * Limpia de tildes y caracteres extraños un string
	 * @param  string $string		  string que se quiere limpiar
	 * @return string         string limpio
	 */
	private function clean($string) {
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

$objControlador = new BeneficiarioController();
unset($objControlador);
