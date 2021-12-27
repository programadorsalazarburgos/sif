<?php

namespace General\Controlador;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../../Vendor/autoload.php";
use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\OptionsDAO;
use General\Persistencia\DAOS\GrupoDAO;
use General\Persistencia\DAOS\TbOrganizaciones2017DAO;
use General\Persistencia\Entidades\TbOrganizaciones2017;
use General\Persistencia\DAOS\TbPersona2017DAO;
use General\Persistencia\Entidades\TbPersona2017;
use General\Persistencia\DAOS\InfraestructuraDAO;
use General\Persistencia\DAOS\ZonaDAO;
use General\Vista\Vista;



class OptionsController extends ControladorBase
{
	/**
	 * @var Container
	 *
	 */
	//// private /*static*/ $contenedor;

	function __construct()
	{

		parent::__construct();



		/**
		  * Usado para Pruebas Render HTML en PHP vs JS
		  */
		$this->contenedor=$this->getContenedor();

		$this->contenedor['OptionsDAO'] = function ($c) {
			return new OptionsDAO();
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

		$this->contenedor['GrupoDAO'] = function ($c) {
			return new GrupoDAO();
		};

		$this->contenedor['persona'] = function ($c) {
			return new TbPersona2017();
		};

		$this->contenedor['InfraestructuraDAO'] = function ($c) {
			return new InfraestructuraDAO();
		};

		$this->contenedor['ZonaDAO'] = function ($c) {
			return new ZonaDAO();
		};

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

	public function getOptionsOrganizaciones()
	{
		$organizacion = $this->contenedor['TbOrganizaciones2017DAO'];
		$vista= $this->contenedor['vista'];
		$vista->setPlantilla('getOptionsOrganizacionesRol');
		$organizaciones = $organizacion->consultarObjeto("");
		$vista->setVariables(array('organizaciones'=>$organizaciones));
		$vista->renderHtml();
		echo json_encode($organizaciones);
	}

	public function getBase64Url($url)
	{
		echo 'data:image/png;base64,'.base64_encode(file_get_contents($url));
	}

	public function getOptionsClanes($estado)
	{
		$consultasReportesDAO = $this->contenedor['OptionsDAO'];
		$clanes = $consultasReportesDAO->getClanes($estado);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('clanes'=>$clanes));
		$vista->renderHtml();
	}

	public function getOptionsOrganizacionesRol($id_usuario)
	{
		$persona=$this->contenedor['persona'];
		$persona->setPkIdPersona($id_usuario);
		$personaDAO=$this->contenedor['personaDAO'];
		$datosPersona=$personaDAO->consultarObjeto($persona);
		//Busca en Tabla Organización los tipos de usuario Coordinador Organizacion
		$organizacionDAO=$this->contenedor['TbOrganizaciones2017DAO'];
		if($datosPersona[0]['TipoPersona']==11) // || $datosPersona[0]['TipoPersona']==12)
		$organizaciones=$organizacionDAO->getOrganizaciones($id_usuario);
		else
			$organizaciones=$organizacionDAO->getOrganizaciones();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('organizaciones'=>$organizaciones));
		$vista->renderHtml();
	}

	public function getOptionsArtistasFormadores($conGrupos = false)
	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$artistas = $optionsDAO->getArtistasFormadores($conGrupos);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('artistas'=>$artistas));
		$vista->renderHtml();
	}

	public function getOptionsArtistasFormadoresNidos(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$artistas = $optionsDAO->getOptionsArtistasFormadoresNidos();
		$vista= $this->contenedor['vista'];
		$vista->setPlantilla('getOptionsArtistasFormadores');
		$vista->setVariables(array('artistas'=>$artistas));
		$vista->renderHtml();
	}

	public function getOptionsArtistasFormadoresDeAreaArtistica($area_artistica)
	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$artistas = $optionsDAO->getOptionsArtistasFormadoresDeAreaArtistica($area_artistica);
		$vista= $this->contenedor['vista'];
		$vista->setPlantilla('getOptionsArtistasFormadores');
		$vista->setVariables(array('artistas'=>$artistas));
		$vista->renderHtml();
	}

	public function getOptionsAreasArtisticas()
	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$area_artistica = $optionsDAO->getAreasArtisticas();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$area_artistica));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionsAreasArtisticasPorColegio($listaColegios)
	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$area_artistica = $optionsDAO->getOptionsAreasArtisticasPorColegio($listaColegios);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$area_artistica));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionsColegios()
	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$colegio = $optionsDAO->getColegios();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('colegio'=>$colegio));
		$vista->renderHtml();
	}

	public function getOptionsColegiosAtendidos()
	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$colegio = $optionsDAO->getColegiosAtendidos();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('colegio'=>$colegio));
		$vista->renderHtml();
	}

	public function getOptionsEventosActivos($id_usuario)
	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$evento = $optionsDAO->getEventosActivos($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('evento'=>$evento));
		$vista->renderHtml();
	}

	public function getOptionsNovedades()
	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$novedades = $optionsDAO->getParametroDetalle(25); //25 id tb_parametro de TIPO NOVEDAD ASISTENCIA FORMADOR
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$novedades));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionsTiposDeIdentificacion(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$tiposDeIdentificacion = $optionsDAO->getTiposDeIdentificacion();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$tiposDeIdentificacion));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionsGenero(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$generos = $optionsDAO->getOptionsGenero();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$generos));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionsPerfiles($parametro){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$perfiles = $optionsDAO->getPerfiles($parametro);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('perfiles'=>$perfiles, 'programa'=>$parametro));
		$vista->renderHtml();
	}

	public function getParametroDetalle($parametro){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		echo json_encode($optionsDAO->getParametroDetalle($parametro));
	}
	
	public function getParametroDetalleByOrder($parametro, $ordernar_por, $orden){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		echo json_encode($optionsDAO->getParametroDetalleByOrder($parametro, $ordernar_por, $orden));
	}

	public function getParametroDetalleActivoInactivo($parametro){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		echo json_encode($optionsDAO->getParametroDetalleActivoInactivo($parametro));
	}

	public function getParametroDetalleProyectoEstado($id_parametro, $id_proyecto, $estado){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$resultado = $optionsDAO->getParametroDetalleProyectoEstado($id_parametro, $id_proyecto, $estado);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$resultado));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getPermisosRol($parametro){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		echo json_encode($optionsDAO->getPermisosRol($parametro));
	}

	public function getOptionsLineasAtencion(){
		$linea_atencion = array(array('FK_Value'=>'arte_escuela','VC_Descripcion'=>'ARTE EN LA ESCUELA'),
			array('FK_Value'=>'emprende_clan','VC_Descripcion'=> 'IMPULSO COLECTIVO'),
			array('FK_Value'=>'laboratorio_clan','VC_Descripcion'=>'CONVERGE')
		);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$linea_atencion));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionsLocalidadesGestor($id_usuario)
	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$localidades = $optionsDAO->getLocalidades($id_usuario);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('localidades'=>$localidades));
		$vista->renderHtml();
	}

	public function getOptionsUpz($parametro)	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$Upz = $optionsDAO->getUpzLocalidad($parametro);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('Upz'=>$Upz));
		$vista->renderHtml();
	}

	public function getOptionsLugarNidos($parametro)	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$LugarNidos = $optionsDAO->getLugarNidosUpz($parametro);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('LugarNidos'=>$LugarNidos));
		$vista->renderHtml();
	}

	public function getOptionsTipoLugar(){
		$OptionsDAO = $this->contenedor['OptionsDAO'];
		$tipoLugares= $OptionsDAO->consultarLugarAtencion();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('tipoLugares'=>$tipoLugares));
		$vista->renderHtml();
	}

	public function getOptionsAnio()	{
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$anios = $optionsDAO->getOptionsAnio();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$anios));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionsMes(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$meses = $optionsDAO->getOptionsMes();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$meses));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionGruposDeUnCrea($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$linea_atencion = array('arte_escuela','emprende_clan','laboratorio_clan');
		for ($i=0; $i < sizeof($linea_atencion); $i++) {
			$grupo = $GrupoDAO->consultarGruposClanPorEstado($datos['id_crea'],$linea_atencion[$i],1);
			$vista = $this->contenedor['vista'];
			$vista->setVariables(array('grupo'=>$grupo,'tipo_grupo'=>$linea_atencion[$i]));
			$vista->renderHtml();
		}
	}

	public function getOptionsGPoblacional(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$gpoblacional = $optionsDAO->getOptionsGPoblacional();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$gpoblacional));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionsEPS(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$eps = $optionsDAO->getOptionsEPS();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$eps));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionsGSanguineo(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$gsanguineo = $optionsDAO->getOptionsGSanguineo();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$gsanguineo));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionsColegiosCrea($datos,$muestraDane){
		//print_r($datos);
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$colegios = $optionsDAO->getOptionsColegiosCrea($datos['id_crea']);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('colegios'=>$colegios,'muestraDane'=>$muestraDane));
		$vista->renderHtml();
	}

	public function getOptionsJornada(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$jornada = $optionsDAO->getOptionsJornada();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$jornada));
		$vista->setPlantilla('getOptionsParametroDetalleDescripcion');
		$vista->renderHtml();
	}
	//Consulta el listado de Grados que existian en tb_grado.
	public function getOptionsGrados(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$grado = $optionsDAO->getOptionsGrado();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$grado));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}
	public function getOptionsLocalidad(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$localidad = $optionsDAO->getOptionsLocalidad();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$localidad));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getOptionsLugarInventario()
	{
		$consultasReportesDAO = $this->contenedor['OptionsDAO'];
		$lugares_inventario = $consultasReportesDAO->getOptionsLugarInventario();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$lugares_inventario));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}
	public function getPersonas()
	{
		$personaDAO = $this->contenedor['personaDAO'];
		$personas = $personaDAO->getPersonas();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('personas'=>$personas));
		$vista->renderHtml();
	}
	public function getOptionsParametroDetalle($id_parametro){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$parametro_detalle = $optionsDAO->getParametroDetalle($id_parametro);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$parametro_detalle));
		$vista->renderHtml();
	}

	public function getOptionsEtnia(){
		$consultasReportesDAO = $this->contenedor['OptionsDAO'];
		$etnia = $consultasReportesDAO->getEtnias();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('etnia'=>$etnia));
		$vista->renderHtml();
	}

	//Consulta el listado de Actividades activas que existian en tb_menu_actividad.
	public function getOptionsActividades(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$actividades = $optionsDAO->getOptionsActividades();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('actividades'=>$actividades));
		$vista->renderHtml();
	}

	public function getFechaYHoraServidor(){
		date_default_timezone_set('America/Bogota');
		echo  date('Y-m-d H:i:s');
	}

	public function consultarDatosBasicosUsuario($id_usuario){
		$consultasReportesDAO = $this->contenedor['OptionsDAO'];
		$dato_usuario = $consultasReportesDAO->consultarDatosBasicosUsuario($id_usuario);
		echo json_encode($dato_usuario);
	}

	public function getOptionsGruposDeUnColegio($datos) {
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$grupos=$optionsDAO->getOptionsGruposDeUnColegio($datos);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos,'linea'=>$datos['linea']));
		$vista->renderHtml();

	}
	public function getUsuariosActivos() {
		$personaDAO = $this->contenedor['personaDAO'];
		$personas=$personaDAO->getUsuariosActivos();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$personas));
		$vista->setPlantilla("getOptionsPersonas");
		$vista->renderHtml();
	}

	public function getOptionsUsuariosRol($id_rol,$todos,$label){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$usuario=$optionsDAO->getOptionsUsuariosRol($id_rol,$todos);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('usuario'=>$usuario,'label'=>$label));
		$vista->renderHtml();
	}

	public function getParametros(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$parametros=$optionsDAO->getParametros();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('parametros'=>$parametros));
		$vista->renderHtml();
	}

	public function getTiposIndicadores($id_seccion){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$tiposIndicadores=$optionsDAO->getTiposIndicadores($id_seccion);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$tiposIndicadores));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getAllTiposIndicadores(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$tiposIndicadores=$optionsDAO->getAllTiposIndicadores();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$tiposIndicadores));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getTipoDeGraficas(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$datos=$optionsDAO->getTipoDeGraficas();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$datos));
		$vista->setPlantilla('getOptionsParametroDetalleDescripcion');
		$vista->renderHtml();
	}

	public function getTipoDeFiltrosGraficos(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$datos=$optionsDAO->getTipoDeFiltrosGraficos();
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$datos));
		$vista->setPlantilla('getOptionsParametroDetalleDescripcion');
		$vista->renderHtml();
	}

	public function getOptionsGruposLineaArea($datos){
		$GrupoDAO = $this->contenedor['GrupoDAO'];
		$grupos = $GrupoDAO->consultarGruposPorLineaPorArea($datos['anio'], $datos['linea'], $datos['area']);
		$vista = $this->contenedor['vista'];
		$vista->setVariables(array('grupos'=>$grupos));
		$vista->renderHtml();
	}

	public function getOptionsFormatosPedagogicos(){
		$formatos_pegagogicos = array(array('FK_Value'=>'CARACTERIZACION','VC_Descripcion'=>'CARACTERIZACIÓN'),array('FK_Value'=>'PLANEACION','VC_Descripcion'=>'PLANEACIÓN'));
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('datos'=>$formatos_pegagogicos));
		$vista->setPlantilla('getOptionsParametroDetalle');
		$vista->renderHtml();
	}

	public function getEspaciosCrea($id_crea){
		$InfraestructuraDAO = $this->contenedor['InfraestructuraDAO'];
		echo json_encode($InfraestructuraDAO->getEspaciosCrea($id_crea));
	}

	public function getListadoTodosBeneficiariosGrupo($id_grupo,$tipo_grupo){
    	$grupo = $this->contenedor['GrupoDAO'];
 		$beneficiarios = $grupo->getListadoTodosBeneficiariosGrupo($id_grupo,$tipo_grupo);
 		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('beneficiarios'=>$beneficiarios));
		$vista->setPlantilla("getOptionsBeneficiariosGrupo");
		$vista->renderHtml();
	}
	
	public function consultarGruposActivosActualmente(){
		$tipo_grupo = array('arte_escuela' => 'AE', 'emprende_clan' => 'EC', 'laboratorio_clan' => 'LC');
		$grupo = $this->contenedor['GrupoDAO'];
		foreach ($tipo_grupo as $key => $value) {
			$id_grupo = $grupo->consultarIDGruposActivos($key);
			// var_dump($id_grupo);
			for ($j=0; $j < sizeof($id_grupo); $j++) { 
				echo "<option value='".$id_grupo[$j]['PK_Grupo']."' data-tipo_grupo='".$key."'>".$tipo_grupo[$key]."-".$id_grupo[$j]['PK_Grupo']."</option>";
			}
		}
	}

	public function getListadoCargos(){
		$personaDAO = $this->contenedor['personaDAO'];
		$cargos = $personaDAO->consultarListadoCargos();
		echo json_encode($cargos);
	}

	public function consultarZonas(){
		$mostrar = "";
		$ZonaDAO = $this->contenedor['ZonaDAO'];
		$zona = $ZonaDAO->consultarObjeto(null);
		foreach ($zona as $z) {
			$mostrar.="<option value='".$z['PK_Id_Zona']."' data-id_responsable='".$z['FK_persona_responsable']."' data-localidades='".$z['VC_Localidades']."' data-creas='".$z['VC_Creas']."' data-nombre_zona='".$z['VC_Nombre_Zona']."' data-artistas_por_area='".$z['VC_Artistas_Area']."'>".$z['VC_Nombre_Zona']."</option>";
		}
		echo $mostrar;
	}

	public function getAniosEstadisticas(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$datos=$optionsDAO->getAniosEstadisticas();
		echo json_encode($datos);
	}

	public function getProyectos(){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$datos=$optionsDAO->getProyectos();
		echo json_encode($datos);
	}

	public function getOptionsBarriosLocalidad($id_localidad){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$datos=$optionsDAO->getOptionsBarriosLocalidad($id_localidad);
		echo json_encode($datos);
	}

	public function getOptionsColegiosCreaNew($datos,$anio){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$colegios = $optionsDAO->getOptionsColegiosCreaNew($datos['id_crea'], $anio);
		$vista= $this->contenedor['vista'];
		$vista->setVariables(array('colegios'=>$colegios));
		$vista->renderHtml();
	}

	public function getOptionsColegiosConvenio($convenio, $year){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$colegios = $optionsDAO->getOptionsColegiosConvenio($convenio, $year);
		echo json_encode($colegios);
	}

	public function getOptionsConveniosByLineaAtencionYear($linea_atencion, $year){
		$optionsDAO = $this->contenedor['OptionsDAO'];
		$colegios = $optionsDAO->getOptionsConveniosByLineaAtencionYear($linea_atencion, $year);
		echo json_encode($colegios);
	}

}

$objControlador = new OptionsController();

if(isset($_POST['funcion']) && $_POST['funcion']==='addAdjuntosSoporte')
{
	//echo '<pre>'.print_r($GLOBALS,true).'</pre>';

}
unset($objControlador);
