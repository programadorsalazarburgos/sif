<?php
namespace PedagogicoNidos\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../Vendor/autoload.php";
use PedagogicoNidos\Controlador\PedagogicoFactory;

class SistematizacionController extends PedagogicoFactory
{
	/**
	 * @var Container
	 *
	 */
	// private /*static*/ $contenedor;
	private $userId;
	private $rolId;

	function __construct()
	{
		parent::__construct();
		session_start();
		$this->userId = $_SESSION["session_username"];
		$this->rolId = $_SESSION['session_usertype'];
		$this->initializeFactory();
	}

	public function getDuplas($id_usuario){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$duplas = $NidosSistematizacionDAO->getDuplas($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('duplas'=>$duplas));
		$vista->renderHtml();
	}

	public function getArtistasDupla($id_usuario){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$infoArtistas = $NidosSistematizacionDAO->getArtistasDupla($id_usuario);
		echo json_encode($infoArtistas);
	}

	public function getArtistasPDF($id_sistematizacion){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$infoArtistas = $NidosSistematizacionDAO->getArtistasPDF($id_sistematizacion);
		echo json_encode($infoArtistas);
	}

	public function getSistematizacionExistente($mes, $id_dupla){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$validacion = $NidosSistematizacionDAO->getSistematizacionExistente($id_dupla, $mes);
		echo json_encode($validacion[0]);
	}

	public function getSistematizacionMesAnterior($id_dupla){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$datos_sistematizacion_mes_anterior = $NidosSistematizacionDAO->getSistematizacionMesAnterior($id_dupla);
		echo json_encode($datos_sistematizacion_mes_anterior[0]);
	}

	public function getInfoPlaneacion($id_sistematizacion){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$info_sistematizacion = $NidosSistematizacionDAO->getInfoPlaneacion($id_sistematizacion);
		echo json_encode($info_sistematizacion[0]);
	}

	public function getObservaciones($id_sistematizacion){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$observaciones = $NidosSistematizacionDAO->getObservaciones($id_sistematizacion);
		echo json_encode($observaciones[0]);
	}

	
	public function guardarSistematizacion($datos_string){
		$datos = json_decode($datos_string,true);

		$TbNidosSistematizacion = $this->contenedor['TbNidosSistematizacion'];
		$TbNidosSistematizacionArtista = $this->contenedor['TbNidosSistematizacionArtista'];
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];

		$TbNidosSistematizacion->setFkIdDupla($datos['id_dupla']);
		$TbNidosSistematizacion->setVcNombreExperiencia($datos['nombre_experiencia']);
		$TbNidosSistematizacion->setInPeriodo($datos['mes_experiencia']);
		$TbNidosSistematizacion->setTxTema($datos['tema']);
		$TbNidosSistematizacion->setTxMaterias($datos['materias']);
		$TbNidosSistematizacion->setTxIntencionArtistica($datos['intencion']);
		$TbNidosSistematizacion->setTxReferentes(json_encode($datos['referentes'])) ;
		$TbNidosSistematizacion->setTxAplicabilidadReferentes(json_encode($datos['aplicabilidad_referentes'])) ;
		$TbNidosSistematizacion->setTxAmbientacion($datos['ambientacion']);
		$TbNidosSistematizacion->setTxDispositivos($datos['dispositivos']);
		$TbNidosSistematizacion->setTxMomentos($datos['momentos']);
		$TbNidosSistematizacion->setInAprobacionPlaneacion($datos['estado']);
		if($datos['estado'] == 1){
			$TbNidosSistematizacion->setDtFechaEnvioPlaneacion(date("Y-m-d H:i:s"));
			$TbNidosSistematizacion->setFkIdArtistaEnvioPlaneacion($datos["id_artista"]);
		}
		$TbNidosSistematizacionArtista->setFkIdArtistas($datos["json_artistas"]);

		echo $NidosSistematizacionDAO->guardarSistematizacion($TbNidosSistematizacion, $TbNidosSistematizacionArtista);
	}

	public function modificarSistematizacion($datos_string, $archivos, $parte_modificar, $observaciones=""){
		$datos = json_decode($datos_string,true);

		$TbNidosSistematizacion = $this->contenedor['TbNidosSistematizacion'];
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];

		$TbNidosSistematizacion->setPkIdSistematizacion($datos['id_sistematizacion']);

		if($observaciones != ""){
			if($datos['estado'] != 4){
				$TbNidosSistematizacion->setTxObservaciones($observaciones);
			}
		}

		if ($parte_modificar == "planeacion"){
			$TbNidosSistematizacion->setVcNombreExperiencia($datos['nombre_experiencia']);
			$TbNidosSistematizacion->setTxTema($datos['tema']);
			$TbNidosSistematizacion->setTxMaterias($datos['materias']);
			$TbNidosSistematizacion->setTxIntencionArtistica($datos['intencion']);
			$TbNidosSistematizacion->setTxReferentes(json_encode($datos['referentes'])) ;
			$TbNidosSistematizacion->setTxAplicabilidadReferentes(json_encode($datos['aplicabilidad_referentes'])) ;
			$TbNidosSistematizacion->setTxAmbientacion($datos['ambientacion']);
			$TbNidosSistematizacion->setTxDispositivos($datos['dispositivos']);
			$TbNidosSistematizacion->setTxMomentos($datos['momentos']);
			$TbNidosSistematizacion->setInAprobacionPlaneacion($datos['estado']);
			if($observaciones == ""){
				if($datos['estado'] == 1){
					$TbNidosSistematizacion->setFkIdArtistaEnvioPlaneacion($datos["id_artista"]);
					$TbNidosSistematizacion->setDtFechaEnvioPlaneacion(date("Y-m-d H:i:s"));
				}
			}
			if($datos['estado'] == 4){
				$TbNidosSistematizacion->setDtFechaAprobacionPlaneacion(date("Y-m-d H:i:s"));
				$TbNidosSistematizacion->setFkIdEaatAprobo($datos['id_eaat']);
			}
		}

		if ($parte_modificar == "sistematizacion"){
			$TbNidosSistematizacion->setTxNinosIns($datos['ninos_ins']);
			$TbNidosSistematizacion->setTxAgentesIns($datos['agentes_ins']);
			$TbNidosSistematizacion->setTxNinosFam($datos['ninos_fam']);
			$TbNidosSistematizacion->setTxAgentesFam($datos['agentes_fam']);
			$TbNidosSistematizacion->setTxFamiliasFam($datos['familias_fam']);
			$TbNidosSistematizacion->setTxMujeresFam($datos['mujeres_fam']);
			$TbNidosSistematizacion->setTxNinosCom($datos['ninos_com']);
			$TbNidosSistematizacion->setTxFamiliasCom($datos['familias_com']);
			$TbNidosSistematizacion->setTxAprendizajesCreacion($datos['aprendizajes_creacion']);
			$TbNidosSistematizacion->setTxAprendizajesPersonales($datos['aprendizajes_personales']);
			$TbNidosSistematizacion->setTxOtrosAspectos($datos['otros_aspectos']);
			$TbNidosSistematizacion->setInAprobacionSistematizacion($datos['estado']);
			if($observaciones == ""){
				if($datos['estado'] == 1){
					$TbNidosSistematizacion->setFkIdArtistaEnvioSistematizacion($datos["id_artista"]);
					$TbNidosSistematizacion->setDtFechaEnvioSistematizacion(date("Y-m-d H:i:s"));
				}
			}
			if($datos['estado'] == 4){
				$TbNidosSistematizacion->setDtFechaAprobacionSistematizacion(date("Y-m-d H:i:s"));
			}

			$array_images = $NidosSistematizacionDAO->getBancoImagenes($datos['id_sistematizacion']);
			if($archivos != null){
				$rta = $this->subirArchivos($datos['id_dupla'],$archivos,$datos['mes'], json_decode($array_images[0]["TX_Banco_Imagenes"]));
			}else{
				$rta = $array_images[0]["TX_Banco_Imagenes"];
			}

			$TbNidosSistematizacion->setTxBancoImagenes($rta);
		}
		echo $NidosSistematizacionDAO->modificarSistematizacion($TbNidosSistematizacion, $parte_modificar);
	}

	public function deleteImage(){
		foreach ($_POST as $key => $value) {
			try {
				if (isset($value["key"]) && $value["key"] == $_POST["key"]) {
					$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
					$info_images = $NidosSistematizacionDAO->getBancoImagenes($value["id_sis"]);

					$json_images = json_decode($info_images[0]["TX_Banco_Imagenes"], true);
					$backtrace = debug_backtrace()[1];
					$rutaBase = substr($backtrace['file'],0, strpos($backtrace['file'],'sif'));
					if (($key = array_search($value["filename"], $json_images)) !== false) {
						array_splice($json_images, $key,1);
						/* Para local
						if(unlink($rutaBase.substr($value["filename"],1))){	
							$update = $NidosSistematizacionDAO->updateImages($value["id_sis"], json_encode($json_images));
							echo json_encode($update);
						}*/
						if(unlink("../../".substr($value["filename"],1))){	
							$update = $NidosSistematizacionDAO->updateImages($value["id_sis"], json_encode($json_images));
							echo json_encode($update);
						}
					}
				}
			} catch (Exception $e) {

			}
		}
	}

	public function getCarouselImages($id_sistematizacion){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$array_images = $NidosSistematizacionDAO->getBancoImagenes($id_sistematizacion);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('array_images'=>json_decode($array_images[0]["TX_Banco_Imagenes"])));
		$vista->renderHtml();
	}

	public function getSistematizacionesDupla($id_dupla, $id_usuario){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$infoSistematizaciones = $NidosSistematizacionDAO->getSistematizacionesDupla($id_dupla, $id_usuario, $this->rolId);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('sistematizaciones'=>$infoSistematizaciones, 'rolId'=> $this->rolId));
		$vista->renderHtml();
	}

	public function getOptionsDuplas($ids_territorios){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$duplas = $NidosSistematizacionDAO->getOptionsDuplas($ids_territorios);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('duplas'=>$duplas));
		$vista->renderHtml();
	}

	public function getOptionsCampos(){
		$vista= $this->contenedor['vista'];
		$vista->renderHtml();
	}

	public function getInformacionSistematizacion($ids_territorios, $ids_duplas, $ids_campos, $ids_meses){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$info = $NidosSistematizacionDAO->getInformacionSistematizacion($ids_territorios, $ids_duplas, $ids_campos, $ids_meses);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('info'=>$info));
		$vista->renderHtml();
	}

	public function getSistematizaciones($ids_territorios, $ids_duplas, $ids_meses){
		$NidosSistematizacionDAO = $this->contenedor['NidosSistematizacionDAO'];
		$sistematizaciones = $NidosSistematizacionDAO->getSistematizaciones($ids_territorios, $ids_duplas, $ids_meses);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('sistematizaciones'=>$sistematizaciones));
		$vista->renderHtml();
	}

	/**
	 * Sube Archivos de acuerdo al Fk de la persona y una carpeta destino
	 * @param  Array $datos 		Todos los campos del formulario asi como adicionales como el id del  informe de pago, se utiliza unicamente FK_Persona dentro de esta funcion
	 * @param  Array $archivos      Archivo Anexo del informe de pago Detallado, no es requiered (posiblemente funciona para mas de 1 archivo pero inicialmente es solo para uno)
	 * @param  Array $folder        Nombre de la carpeta bajo el nombre del modulo donde se guardará el archivo
	 * @return Integer              Retorna el estado de la peticion, si todo esta correcto devuelve la url, 3 para error - sin archivos en la variable, 4 en el caso de que no pueda crear la carpeta 
	 *                              o no pueda mover el archivo, 4 tamaño maximo excedido
	*/
	protected function subirArchivos($id_dupla,$archivos,$mes, $array_images)
	{

		$backtrace = debug_backtrace()[1];
		$rutaBase = substr($backtrace['file'],0, strpos($backtrace['file'],'src'));  
		$carpeta = $rutaBase.'uploadedFiles/PedagogicoNidos/Sistematizacion/'.$id_dupla.'/'.$mes.'/';
		$ubicacion = '/sif/uploadedFiles/PedagogicoNidos/Sistematizacion/'.$id_dupla.'/'.$mes.'/';         
		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return 4;
		} 
		else{
			if($array_images == null){
				$rta = array();
			}else{
				$rta = $array_images;
			}
			foreach ($archivos as $archivo) {
				$ruta = $carpeta.$this->clean($archivo["name"]);
				$estado = move_uploaded_file($archivo['tmp_name'] , $ruta);
				if ($estado){
					array_push($rta, $ubicacion.$this->clean($archivo["name"]));
				}
				else{
					//$rta = "4";
				}
			}	
		}
		return json_encode($rta);
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
