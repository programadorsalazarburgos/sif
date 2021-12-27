<?php
namespace Beneficiarios\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Beneficiarios\Controlador\BeneficiariosFactory;

class RegistroBeneficiariosController extends BeneficiariosFactory
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

	public function crearBeneficiarioNidos($datos){
		$TbNidosBeneficiarios = $this->contenedor['TbNidosBeneficiarios'];
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];

		$TbNidosBeneficiarios->setVcIdentificacion($datos['identificacion']);
		$TbNidosBeneficiarios->setFkTipoIdentificacion($datos['tipo_identifi']);
		$TbNidosBeneficiarios->setVcPrimerNombre($datos['p_nombre']);
		$TbNidosBeneficiarios->setVcSegundoNombre($datos['s_nombre']);
		$TbNidosBeneficiarios->setVcPrimerApellido($datos['p_apellido']);
		$TbNidosBeneficiarios->setVcSegundoApellido($datos['s_apellido']);
		$TbNidosBeneficiarios->setDdFNacimiento($datos['f_nacimiento']);
		$TbNidosBeneficiarios->setFkIdGenero($datos['genero']);
		$TbNidosBeneficiarios->setInGrupoPoblacional($datos['etnia']);
		
		if ($datos["uso_imagen"] == 3) {
		$TbNidosBeneficiarios->setVcUsoImagen("CARTA CONVENIO SED");

		} elseif  ($datos["uso_imagen"] == 1) {
		$TbNidosBeneficiarios->setVcUsoImagen("CARTA CONVENIO ICBF");		
	    }else{
		$TbNidosBeneficiarios->setVcUsoImagen(" ");
		}	
		
	
		$TbNidosBeneficiarios->setInIdentificacionPoblacional($datos['i_poblacional']);
		$TbNidosBeneficiarios->setVcObservacion($datos['observacion']);
		if($datos["existe"] == 1){
			echo $NidosBeneficiariosDAO->modificarBeneficiario($TbNidosBeneficiarios);
		}else{
			$TbNidosBeneficiarios->setFkIdUsuarioRegistra($datos['id_usuario']);
			$TbNidosBeneficiarios->setDtFechaRegistro(date("Y-m-d H:i:s"));
			echo $NidosBeneficiariosDAO->crearBeneficiario($TbNidosBeneficiarios);
		}
	}

	public function crearBeneficiarioGrupo($datos){
		$TbNidosBeneficiarioGrupo = $this->contenedor['TbNidosBeneficiarioGrupo'];
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];

		$TbNidosBeneficiarioGrupo->setFkIdGrupo($datos['id_grupo']);
		$TbNidosBeneficiarioGrupo->setFkIdBeneficiario($datos['beneficiarios_grupo']);
		$TbNidosBeneficiarioGrupo->setDtFechaIngreso(date("Y-m-d H:i:s"));
		$TbNidosBeneficiarioGrupo->setFkUsuarioIngreso($datos['id_usuario']);
		$TbNidosBeneficiarioGrupo->setInEstado(1);

		echo $NidosBeneficiariosDAO->BeneficiarioGrupo($TbNidosBeneficiarioGrupo);
	}

	public function getGrupos($id_usuario, $id_lugar){
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$grupos = $NidosBeneficiariosDAO->obtenerGruposGuardados($id_usuario, $id_lugar);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();
	}

	public function getOptionsLugares($id_usuario){
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$lugares_usuario = $NidosBeneficiariosDAO->consultarLugaresUsuario($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('lugares'=>$lugares_usuario));
		$vista->renderHtml();
	}

	public function getTipoDocumento()
	{
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$TDocumento = $NidosBeneficiariosDAO->obtenerTipoDocuemnto();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('TDocumento'=>$TDocumento));
		$vista->renderHtml();
	}

	public function getGenero()
	{
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$Genero = $NidosBeneficiariosDAO->obtenerGenero();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Genero'=>$Genero));
		$vista->renderHtml();
	}

	public function getEtnia()
	{
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$Etnia = $NidosBeneficiariosDAO->obtenerEtnia();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Etnia'=>$Etnia));
		$vista->renderHtml();
	}

	public function getNivel() {
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('nivel'=>$vista));
		$vista->renderHtml();
	}

	public function getTPoblacional()
	{
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Poblacional'=>$vista));
		$vista->renderHtml();
	}

	public function getInfoExperiencia($idGrupo)
	{
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$IdExperiencia = $NidosBeneficiariosDAO->consultarEncabezado($idGrupo);
		echo json_encode($IdExperiencia[0]);
	}

	public function getValidarBeneficiario($Usuario, $tc=0)
	{
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$Identificacion = $NidosBeneficiariosDAO->consultarBeneficiario($Usuario);
		if($tc==0)
			echo json_encode($Identificacion[0]);
		else
			echo json_encode($Identificacion);
	}

	public function getGruposBeneficiario($id_beneficiario){
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$Grupos = $NidosBeneficiariosDAO->consultarGruposBeneficiario($id_beneficiario);
		echo json_encode($Grupos);
	}

	public function getBeneficiariosXGrupo($idgrupo, $consulta){
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$Beneficiarios = $NidosBeneficiariosDAO->consultarBeneficiarioGrupo($idgrupo);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Beneficiarios'=>$Beneficiarios, 'Consulta'=> $consulta));
		$vista->renderHtml();
	}

	public function InactivarBeneficiario($datos){
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$TbNidosBeneficiarioGrupo = $this->contenedor['TbNidosBeneficiarioGrupo'];
		$TbNidosBeneficiarioGrupo->setPkIdBenefiGrupo($datos['Id_Beneficiario_Inactivar']);
		$TbNidosBeneficiarioGrupo->setDtFechaRetiro(date("Y-m-d H:i:s"));
		$TbNidosBeneficiarioGrupo->setFkUsuarioRetiro($datos['id_usuario']);
		$TbNidosBeneficiarioGrupo->setInEstado(2);
		$TbNidosBeneficiarioGrupo->setVcObservaciones($datos['Observacion']);
		echo $NidosBeneficiariosDAO->InactivarBeneficiarioObjeto($TbNidosBeneficiarioGrupo);
	}

	public function ActivarBeneficiario($datos){
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$TbNidosBeneficiarioGrupo = $this->contenedor['TbNidosBeneficiarioGrupo'];

		$TbNidosBeneficiarioGrupo->setPkIdBenefiGrupo($datos['Id_Beneficiario_Activar']);
		$TbNidosBeneficiarioGrupo->setInEstado(1);
		echo $NidosBeneficiariosDAO->ActivarBeneficiarioObjeto($TbNidosBeneficiarioGrupo);
	}

	public function getDatosBasicosBeneficiarios($dato_beneficiario){
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$datos_beneficiarios = $NidosBeneficiariosDAO->consultarDatosBasicosBeneficiarios($dato_beneficiario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos_beneficiarios'=>$datos_beneficiarios));
		$vista->renderHtml();
	}

	public function getDatosDetalladosBeneficiario($id_usuario){
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$datosBeneficiario = $NidosBeneficiariosDAO->consultarBeneficiario($id_usuario);
		echo json_encode($datosBeneficiario[0]);

	}

	public function getOptionsLugaryGrupoArtista($id_usuario){
		$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
		$LugaryGrupo = $NidosAsistenciaDAO->consultarLugaryGrupoArtista($id_usuario);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('LugaryGrupo'=>$LugaryGrupo));
		$vista->renderHtml();
	}

	public function borrarArchivo($id_beneficiario){
		$backtrace = debug_backtrace()[1];
		$rutaBase =   substr($backtrace['file'],0, strpos($backtrace['file'],'src'));
		$carpeta = $rutaBase.'uploadedFiles/Nidos/Uso_de_imagen/2020/'.$id_beneficiario;
		$archivo = $rutaBase.'uploadedFiles/Nidos/Uso_de_imagen/2020/'.$id_beneficiario.'/uso_imagen_'.$id_beneficiario.'.pdf';
		unlink($archivo);
		if(rmdir($carpeta)){
			$TbNidosBeneficiarios = $this->contenedor['TbNidosBeneficiarios'];
			$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
			echo $NidosBeneficiariosDAO->borrarArchivo($id_beneficiario);

		}

	}

	protected function subirUsoImagen($id_beneficiario,$archivo)
	{
		$backtrace = debug_backtrace()[1];
		$rutaBase =   substr($backtrace['file'],0, strpos($backtrace['file'],'src'));
		$carpeta = $rutaBase.'uploadedFiles/Nidos/Uso_de_imagen/2020/'.$id_beneficiario.'/';
		$ubicacion = '../../../uploadedFiles/Nidos/Uso_de_imagen/2020/'.$id_beneficiario.'/';
		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return 4;
		}
		else{
			$rta = "";
			foreach ($archivo as $a) {
				$ruta = $carpeta."uso_imagen_".$id_beneficiario.".pdf";
				//$ruta = $carpeta.$this->clean($a["name"]);
				if (move_uploaded_file($a['tmp_name'] , $ruta)){
					$rta .= $ubicacion."uso_imagen_".$id_beneficiario.".pdf";
					//$rta .= $ubicacion.$this->clean($a['name']);

					$TbNidosBeneficiarios = $this->contenedor['TbNidosBeneficiarios'];
					$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];

					$TbNidosBeneficiarios->setVcIdentificacion($id_beneficiario);
					$TbNidosBeneficiarios->setVcUsoImagen($rta);
					echo $NidosBeneficiariosDAO->subirUsoImagen($TbNidosBeneficiarios);
				}
				else
					$rta = "4";
			}
			return $rta;
		}
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

	public function getBeneficiariosDocumentoProvisional(){
		$NidosBeneficiariosDAO = $this->contenedor['NidosBeneficiariosDAO'];
		$beneficiariosAsistencia = $NidosBeneficiariosDAO->getBeneficiariosDocumentoProvisional();
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('beneficiariosAsistencia'=>$beneficiariosAsistencia));
		$vista->renderHtml();
	}
}

$objControlador = new RegistroBeneficiariosController();
unset($objControlador);
