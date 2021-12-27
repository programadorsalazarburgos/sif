<?php
namespace Territorial\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use Territorial\Controlador\TerritorialFactory;

class AdministrarLugaresController extends TerritorialFactory
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

 	public function crearNuevoLugar($datos){
 		$TbNidosLugarAtencion = $this->contenedor['TbNidosLugarAtencion'];
 		$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
		$TbNidosLugarAtencion->setFkLocalidad($datos['fk_localidad']);
 		$TbNidosLugarAtencion->setFkUpz($datos['fk_upz']);
 		$TbNidosLugarAtencion->setVcBarrio($datos['vc_barrio']);
		$TbNidosLugarAtencion->setFkIdEntidad($datos['vc_Entidad']);
		$TbNidosLugarAtencion->setVcTipoLugar($datos['vc_tipo_lugar']);
 		$TbNidosLugarAtencion->setVcNombreLugar($datos['vc_nombre_lugar']);
 		$TbNidosLugarAtencion->setVcDireccion($datos['vc_direccion']);
 		$TbNidosLugarAtencion->setVcTelefono($datos['vc_telefono']);
 		$TbNidosLugarAtencion->setVcCoordinador($datos['vc_coordinador']);
      $TbNidosLugarAtencion->setVcEmail($datos['vc_email']);
      $TbNidosLugarAtencion->setVcCelular($datos['vc_celular']);
      $TbNidosLugarAtencion->setVcEstado(1);
		$TbNidosLugarAtencion->setUsuarioCrea($datos['id_usuario']);
		$TbNidosLugarAtencion->setDtFechaCreacion(date("Y-m-d H:i:s"));
    echo $NidosLugaresDAO->crearObjeto($TbNidosLugarAtencion);
 	}

	public function modificarLugar($datos){
		$TbNidosLugarAtencion = $this->contenedor['TbNidosLugarAtencion'];
		$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
		$TbNidosLugarAtencion->setPkJardin($datos['fk_id_lugar']);
		$TbNidosLugarAtencion->setFkLocalidad($datos['sl_localidad_modificar']);
 		$TbNidosLugarAtencion->setFkUpz($datos['sl_upz_modificar']);
		$TbNidosLugarAtencion->setVcBarrio($datos['tx_barrio_modificar']);
		$TbNidosLugarAtencion->setFkIdEntidad($datos['sl_entidad_modificar']);
		$TbNidosLugarAtencion->setVcTipoLugar($datos['sl_tipo_modificar']);
		$TbNidosLugarAtencion->setVcNombreLugar($datos['tx_nombre_modificar']);
		$TbNidosLugarAtencion->setVcDireccion($datos['tx_direccion_modificar']);
		$TbNidosLugarAtencion->setVcTelefono($datos['tx_telefono_modificar']);
		$TbNidosLugarAtencion->setVcCoordinador($datos['tx_coordinador_modificar']);
		$TbNidosLugarAtencion->setVcEmail($datos['tx_email_modificar']);
		$TbNidosLugarAtencion->setVcCelular($datos['tx_celularrespon_modificar']);
		$TbNidosLugarAtencion->setVcEstado($datos['tx_estado_modificar']);
		echo $NidosLugaresDAO->modificarObjetoLugar($TbNidosLugarAtencion);
	}

	public function EliminarLugar($datos){
		$TbNidosLugarAtencion = $this->contenedor['TbNidosLugarAtencion'];
		$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
		$TbNidosLugarAtencion->setPkJardin($datos['fk_lugar_eliminar']);
		$TbNidosLugarAtencion->setVcEstado(0);
		echo $NidosLugaresDAO->eliminarObjeto($TbNidosLugarAtencion);
	}

	public function getOptionsUpz(){
			$optionsDAO = $this->contenedor['OptionsDAO'];
			$Upz = $optionsDAO->getUpzLocalidad();
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('Upz'=>$Upz));
			$vista->renderHtml();
	}

	public function getOptionsTipoLugar(){
			$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
			$tipoLugares= $NidosLugaresDAO->consultarLugarAtencion();
  		   $vista= $this->contenedor['vista'];
			$vista->setVariables(array('tipoLugares'=>$tipoLugares));
			$vista->renderHtml();
	}

	public function getOptionsEntidades(){
			$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
			$Entidades= $NidosLugaresDAO->consultarEntidades();
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('Entidades'=>$Entidades));
			$vista->renderHtml();
	}

	public function getLugaresNidos($id_territorio){
			$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
			$lugares_guardados = $NidosLugaresDAO->consultarLugaresGuardados($id_territorio);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('lugares'=>$lugares_guardados));
			$vista->renderHtml();
	}

	public function getLugaresTerritorio($id_territorio){
			$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
			$total_lugares = $NidosLugaresDAO->TotalLugaresTerritorio($id_territorio);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('total'=>$total_lugares));
			$vista->renderHtml();
	}

	public function getConsultarLugarM($id_territorio){
			$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
			$Consulta_lugaresM = $NidosLugaresDAO->ConsultarLugaresM($id_territorio);
			$vista= $this->contenedor['vista'];
			$vista->setVariables(array('ConsultaLugarM'=>$Consulta_lugaresM));
			$vista->renderHtml();
	}

	public function getNombreTerritorio($id_usuario){
			$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
			$nombre_terri = $NidosLugaresDAO->ConsultarNomTerritorio($id_usuario);
			echo json_encode($nombre_terri[0]);
	}

	public function consultarDatosCompletosLugar($datos){
   		$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
	 		$TbNidosLugarAtencion = $this->contenedor['TbNidosLugarAtencion'];
	 		$TbNidosLugarAtencion->setPkJardin($datos['id_lugar']);
	 		$datos_lugar = $NidosLugaresDAO->consultarLugarModificar($TbNidosLugarAtencion->getPkJardin());
			echo json_encode($datos_lugar[0]);
	}

/**************** FUNCIONES ACTIVIDAD DE LUGARES PEDAGOGICOS *******///////////////
	public function crearNuevoLugarPedagogico($datos){
			$TbNidosLugarAtencion = $this->contenedor['TbNidosLugarAtencion'];
			$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
			$TbNidosLugarAtencion->setFkLocalidad($datos['fk_localidad']);
			$TbNidosLugarAtencion->setFkUpz($datos['fk_upz']);
			$TbNidosLugarAtencion->setVcBarrio($datos['vc_barrio']);
			$TbNidosLugarAtencion->setVcNombreLugar($datos['vc_nombre_lugar']);
			$TbNidosLugarAtencion->setVcEstado(1);
			$TbNidosLugarAtencion->setUsuarioCrea($datos['id_usuario']);
			$TbNidosLugarAtencion->setDtFechaCreacion(date("Y-m-d H:i:s"));
			echo $NidosLugaresDAO->crearObjetoPedagogico($TbNidosLugarAtencion);
	}

	public function getLugaresPedagogicos($id_usuario){
		$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
		$lugares_pedagogico = $NidosLugaresDAO->consultarLugaresPedagogicos($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('lugaresP'=>$lugares_pedagogico));
		$vista->renderHtml();
	}

	public function getTotalLugaresPedagogico(){
		$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
		$total_lugares = $NidosLugaresDAO->TotalLugaresPedagogico();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('total'=>$total_lugares));
		$vista->renderHtml();
	}

	public function getConsultarLugarPedagogicosM()	{
		$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
		$Consulta_lugaresM = $NidosLugaresDAO->ConsultarLugaresPedagogicoM();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('ConsultaLugarM'=>$Consulta_lugaresM));
		$vista->renderHtml();
	}

	public function consultarDatosPedagogicoLugar($datos){
	   $NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
		$TbNidosLugarAtencion = $this->contenedor['TbNidosLugarAtencion'];
		$TbNidosLugarAtencion->setPkJardin($datos['id_lugar']);
		$datos_lugar = $NidosLugaresDAO->consultarLugarPedagogicoModificar($TbNidosLugarAtencion->getPkJardin());
		echo json_encode($datos_lugar[0]);
	}

	public function modificarLugarPedagogico($datos){
		$TbNidosLugarAtencion = $this->contenedor['TbNidosLugarAtencion'];
		$NidosLugaresDAO = $this->contenedor['NidosLugaresDAO'];
		$TbNidosLugarAtencion->setPkJardin($datos['fk_id_lugar']);
		$TbNidosLugarAtencion->setFkLocalidad($datos['sl_localidad_modificar']);
	 	$TbNidosLugarAtencion->setFkUpz($datos['sl_upz_modificar']);
		$TbNidosLugarAtencion->setVcBarrio($datos['tx_barrio_modificar']);
		$TbNidosLugarAtencion->setVcNombreLugar($datos['tx_nombre_modificar']);
		echo $NidosLugaresDAO->modificarObjetoLugarPedagogico($TbNidosLugarAtencion);
	}
}
$objControlador = new AdministrarLugaresController();
unset($objControlador);
