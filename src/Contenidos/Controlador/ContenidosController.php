<?php
namespace Contenidos\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Contenidos\Controlador\ContenidosFactory;

class ContenidosController extends ContenidosFactory
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

	public function guardarBeneficiariosSinInfo($datos_string, $archivo){
		$datos = json_decode($datos_string,true);

		$TbNidosSinInformacionContenidos = $this->contenedor['TbNidosSinInformacionContenidos'];
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];

		$TbNidosSinInformacionContenidos->setInTotalBeneficiarios($datos["tx-total"]);
		$TbNidosSinInformacionContenidos->setInTotalNinos($datos["tx-ninos"]);
		$TbNidosSinInformacionContenidos->setInTotalNinas($datos["tx-ninas"]);
		$TbNidosSinInformacionContenidos->setInTotalNinos03($datos["tx-ninos-cero-tres"]);
		$TbNidosSinInformacionContenidos->setInTotalNinos36($datos["tx-ninos-tres-seis"]);
		$TbNidosSinInformacionContenidos->setInTotalNinas03($datos["tx-ninas-cero-tres"]);
		$TbNidosSinInformacionContenidos->setInTotalNinas36($datos["tx-ninas-tres-seis"]);
		$TbNidosSinInformacionContenidos->setInMujeresGestantes($datos["tx-mujeres"]);
		$TbNidosSinInformacionContenidos->setInAfrodescendiente($datos["tx-afro"]);
		$TbNidosSinInformacionContenidos->setInCampesina($datos["tx-rural"]);
		$TbNidosSinInformacionContenidos->setInDiscapacidad($datos["tx-discapacidad"]);
		$TbNidosSinInformacionContenidos->setInConflicto($datos["tx-conflicto"]);
		$TbNidosSinInformacionContenidos->setInIndigena($datos["tx-indigena"]);
		$TbNidosSinInformacionContenidos->setInPrivados($datos["tx-libertad"]);
		$TbNidosSinInformacionContenidos->setInVictimas($datos["tx-violencia"]);
		$TbNidosSinInformacionContenidos->setInRaizal($datos["tx-raizal"]);
		$TbNidosSinInformacionContenidos->setInRom($datos["tx-rom"]);
		$TbNidosSinInformacionContenidos->setFkIdLugarAtencion($datos["sl-lugar"]);
		$TbNidosSinInformacionContenidos->setFkIdGrupo($datos["sl-grupo"]);
		$TbNidosSinInformacionContenidos->setVcContenido($datos["sl-contenido"]);
		$TbNidosSinInformacionContenidos->setDtFechaEntrega($datos["tx-fecha"]);
		$TbNidosSinInformacionContenidos->setFkIdUsuarioRegistro($datos["id-usuario"]);
		$TbNidosSinInformacionContenidos->setDtFechaRegistro(date("Y-m-d H:i:s"));

		$rta = $this->subirArchivos($archivo);

		$TbNidosSinInformacionContenidos->setVcDocumentoSoporte($rta);

		echo $NidosContenidosDAO->guardarBeneficiariosSinInfo($TbNidosSinInformacionContenidos);
	}

	public function getBeneficiariosSinInfo($mes){
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];
		$info = $NidosContenidosDAO->getBeneficiariosSinInfo($mes);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('info'=>$info));
		$vista->renderHtml();
	}

	public function getCategoriaContenido($tipo_consulta){
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];
		$categoria_contenido = $NidosContenidosDAO->getCategoriaContenido();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('categoria_contenido'=>$categoria_contenido, 'tipo_consulta'=>$tipo_consulta));
		$vista->renderHtml();
	}

	public function getContenidosCategoria($id_categoria){
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];
		$contenidos = $NidosContenidosDAO->getContenidosCategoria($id_categoria);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('contenidos'=>$contenidos));
		$vista->renderHtml();
	}

	public function guardarNuevaCategoriaContenido($nombre_nueva_categoria, $estado){

		$TbNidosCategoriaContenido = $this->contenedor['TbNidosCategoriaContenido'];
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];

		$TbNidosCategoriaContenido->setVcNombreCategoriaContenido($nombre_nueva_categoria);
		$TbNidosCategoriaContenido->setInEstado($estado);

		echo $NidosContenidosDAO->guardarNuevaCategoriaContenido($TbNidosCategoriaContenido);
	}

	public function guardarNuevContenido($datos){

		$TbNidosContenido = $this->contenedor['TbNidosContenido'];
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];

		$TbNidosContenido->setVcNombreContenido($datos["nombre_nuevo_contenido"]);
		$TbNidosContenido->setFkIdCategoriaContenido($datos["id_categoria_contenido"]);

		echo $NidosContenidosDAO->guardarNuevContenido($TbNidosContenido);
	}

	public function modificarCategoriaContenido($datos){

		$TbNidosCategoriaContenido = $this->contenedor['TbNidosCategoriaContenido'];
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];

		$TbNidosCategoriaContenido->setPkIdCategoriaContenido($datos["id_categoria_contenido"]);
		$TbNidosCategoriaContenido->setVcNombreCategoriaContenido($datos["nombre_categoria_contenido"]);
		$TbNidosCategoriaContenido->setInEstado($datos["estado_categoria"]);

		echo $NidosContenidosDAO->modificarCategoriaContenido($TbNidosCategoriaContenido);
	}

	public function modificarContenido($datos){

		$TbNidosContenido = $this->contenedor['TbNidosContenido'];
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];

		$TbNidosContenido->setPkIdContenido($datos["id_contenido"]);
		$TbNidosContenido->setVcNombreContenido($datos["nombre_contenido"]);
		$TbNidosContenido->setInEstado($datos["estado_contenido"]);

		echo $NidosContenidosDAO->modificarContenido($TbNidosContenido);
	}

	public function getOptionsCategorias(){
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];
		$categorias = $NidosContenidosDAO->getOptionsCategorias();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('categorias'=>$categorias));
		$vista->renderHtml();
	}

	public function getContenidos(){
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];
		$contenidos = $NidosContenidosDAO->getContenidos();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('contenidos'=>$contenidos));
		$vista->renderHtml();
	}

	public function getDatosLugar($id_lugar){
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];
		$info_lugar = $NidosContenidosDAO->getDatosLugar($id_lugar);
		echo json_encode($info_lugar[0]);
	}

	public function getGrupos($id_lugar){
		$NidosContenidosDAO = $this->contenedor['NidosContenidosDAO'];
		$grupos = $NidosContenidosDAO->getGrupos($id_lugar);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();
	}
	
	protected function subirArchivos($archivo){
		$backtrace = debug_backtrace()[1];
		$rutaBase = substr($backtrace['file'],0, strpos($backtrace['file'],'src'));  
		$carpeta = $rutaBase.'uploadedFiles/Contenidos/Soportes/';
		$ubicacion = '../../../uploadedFiles/Contenidos/Soportes/';
		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return 4;
		} 
		$rta = "";
		foreach ($archivo as $a) {
			$ruta = $carpeta.$this->clean($a["name"]);
			//$ruta = $carpeta."uso_imagen_".$id_beneficiario.".pdf";
			if (move_uploaded_file($a['tmp_name'] , $ruta)){
				$rta .= $ubicacion.$this->clean($a['name']);
				//$rta .= $ubicacion."uso_imagen_".$id_beneficiario.".pdf";
			}
			else{
				$rta = "4";
			}
		}
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
$objControlador = new ContenidosController();
unset($objControlador);
