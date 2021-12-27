<?php 
namespace Beneficiarios\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Beneficiarios\Controlador\BeneficiariosFactory;

class AdministrarGruposController extends BeneficiariosFactory
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

 	public function crearNuevoGrupo($datos){
 		$TbNidosGrupos = $this->contenedor['TbNidosGrupos'];
 		$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
		$TbNidosGrupos->setFkEstrategiaAtencion($datos['fk_id_estrategia_atencion']);
 		$TbNidosGrupos->setFkLugarAtencion($datos['fk_id_lugar_atencion']);
		$TbNidosGrupos->setVcNombreGrupo($datos['vc_nombre_grupo']);
 		$TbNidosGrupos->setFkIdDupla($datos['fk_id_dupla']);
		$TbNidosGrupos->setFkIdNivelEscolaridad($datos['fk_nivel_escolaridad']);
		$TbNidosGrupos->setVcProfesional($datos['vc_profesional']);
    	$TbNidosGrupos->setInEstado(1);
		$TbNidosGrupos->setDtFechaCreacion(date("Y-m-d+H:i:s"));
		$TbNidosGrupos->setFkIdTipoGrupo($datos['tipo_grupo']);
		$datos['lugar_grupo'] = $datos['lugar_grupo'] == '' ? 0 : $datos['lugar_grupo'];
		$TbNidosGrupos->setFkIdLugarGrupoLaboratorio($datos['lugar_grupo']);
		$TbNidosGrupos->setFkIdUsuarioCreacion($datos['fk_id_usuario_creacion']);
   		echo $NidosGruposDAO->crearObjeto($TbNidosGrupos);
 	}

	public function modificarGrupo($datos){
		$TbNidosGrupos = $this->contenedor['TbNidosGrupos'];
		$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
		$TbNidosGrupos->setIdGrupo($datos['pk_id_grupo']);
		$TbNidosGrupos->setFkEstrategiaAtencion($datos['fk_id_estrategia_atencion']);
		$TbNidosGrupos->setFkLugarAtencion($datos['fk_id_lugar_atencion']);
		$TbNidosGrupos->setVcNombreGrupo($datos['vc_nombre_grupo']);
		$TbNidosGrupos->setFkIdTipoGrupo($datos['tipo_grupo']);
		$TbNidosGrupos->setFkIdNivelEscolaridad($datos['fk_nivel_escolaridad']);
		$TbNidosGrupos->setVcProfesional($datos['vc_profesional']);
		$datos['lugar_grupo'] = $datos['lugar_grupo'] == '' ? 0 : $datos['lugar_grupo'];
		$TbNidosGrupos->setFkIdLugarGrupoLaboratorio($datos['lugar_grupo']);	
		echo $NidosGruposDAO->modificarObjeto($TbNidosGrupos);
	}

		public function getOptionsEstrategias(){
			$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
			$estrategias_guardados = $NidosGruposDAO->consultarEstrategiasGuardadas();
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('estrategias'=>$estrategias_guardados));
			$vista->renderHtml();
		}

		public function getOptionsLugares($id_usuario){
			$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
			$lugares_usuario = $NidosGruposDAO->consultarLugaresUsuario($id_usuario);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('lugares'=>$lugares_usuario));
			$vista->renderHtml();
		}

		public function getIdCodigoDupla($id_usuario){
			$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
			$IdDupla = $NidosGruposDAO->consultarIdCodigoDupla($id_usuario);
			echo json_encode($IdDupla);
		}

		public function consultarGrupos($id_usuario){
			$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
			$grupos = $NidosGruposDAO->consultarGruposGuardados($id_usuario);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('grupos'=>$grupos));
			$vista->renderHtml();
		}

		public function getDupla($id_dupla){
			$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
			$Dupla = $NidosGruposDAO->consultarDupla($id_dupla);
			echo json_encode($Dupla);
		}

		public function consultarDatosCompletosGrupo($id_grupo){
			$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
	 	 	$TbNidosGrupos = $this->contenedor['TbNidosGrupos'];
	 	 	$TbNidosGrupos->setIdGrupo($id_grupo);
	 	 	$datosGrupo = $NidosGruposDAO->consultarGrupoModificar($TbNidosGrupos->getIdGrupo());
	 		echo json_encode($datosGrupo[0]);
		}

		public function inactivarGrupo($id_grupo){
			$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
			$IdGrupo = $NidosGruposDAO->inactivarGrupo($id_grupo);
			echo json_encode($IdGrupo);
		}

		public function activarGrupo($id_grupo){
			$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
			$IdGrupo = $NidosGruposDAO->activarGrupo($id_grupo);
			echo json_encode($IdGrupo);
		}

		public function getNombreTerritorio($id_usuario){
			$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
			$territorio = $NidosGruposDAO->consultarTerritorio($id_usuario);
			echo json_encode($territorio);
		}

		public function getOptionsLugaryGrupoArtista($id_usuario){
			$NidosAsistenciaDAO = $this->contenedor['NidosAsistenciaDAO'];
			$LugaryGrupo = $NidosAsistenciaDAO->consultarLugaryGrupoArtista($id_usuario);
			$vista = $this->contenedor['vista'];
			$vista->setVariables(array('LugaryGrupo'=>$LugaryGrupo));
			$vista->renderHtml();
		}

		public function ConsultarTotalesGruposDupla($id_usuario){
			$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
			$nombre_terri = $NidosGruposDAO->ConsultarTotalesGruposDupla($id_usuario);
			echo json_encode($nombre_terri[0]);
		}

		public function consolidadoAtencionesDupla($id_usuario){
			$NidosGruposDAO = $this->contenedor['NidosGruposDAO'];
			$grupos = $NidosGruposDAO->consolidadoAtencionesDupla($id_usuario);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('grupos'=>$grupos));
			$vista->renderHtml();
		}

		

		
}

$objControlador = new AdministrarGruposController();
unset($objControlador);
