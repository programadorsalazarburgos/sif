<?php
	session_start();
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/Territorial/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'registrar_asistencia':
				$_SESSION["id_asistencia"] = registrarAsistencia($_POST['SL_Clan'],$_POST['SL_Area_Artistica'],$_SESSION['session_username'],$_POST['fecha_taller'],$_POST['SL_Lugar_Atencion'],$_POST['numero_personas'],$_POST['observaciones']);
				echo $_SESSION["id_asistencia"];
				break;
			case 'get_clanes':
				echo getSelectClan();
				break;
			case 'get_areas_artisticas':
				echo getSelectAreasArtisticas();
				break;
			case 'get_lugares_atencion':
				echo getSelectLugaresAtencion();
				break;
			case 'guardar_asistencia':
				echo guardarAsistenciaPersona($_POST['id_registro_asistencia'],$_POST['tiene_documento'],$_POST['documento_persona'],$_POST['nombre_persona']);
				break;
			case 'get_historial_artista_formador':
				echo getHistorialArtistaFormador($_POST['id_artista_formador']);
				break;
			case 'validar_taller_existente':
				echo validarTallerExistente($_POST['id_clan'],$_POST['id_area_artistica'],$_POST['id_artista_formador'],$_POST['fecha_taller'],$_POST['id_lugar_atencion']);
				break;
			case 'editar_archivo_soporte':
				$_SESSION["id_asistencia"] = $_POST['id_taller_editado'];
				echo "edicion_ok_taller_".$_SESSION["id_asistencia"];
				break;
			default:
				echo "opcion no valida: (".$_POST['opcion'].")";
				break;
		}
	}
	if(isset($_FILES) && !empty($_FILES)){
		$nombre_carpeta = "SoporteAsistenciaLaboratorioCLAN2017/".$_SESSION["session_username"];
		if(!is_dir($nombre_carpeta)){
			$mask=umask(0);
			@mkdir($nombre_carpeta, 0777);
			umask($mask);
		}else{ 
			echo "Ya existe ese directorio\n";
		}
		$files = array();
		$uploaddir = './'.$nombre_carpeta.'/';
		foreach($_FILES as $file){
			$nombre_archivo = $_SESSION["id_asistencia"].".".explode("/",$file['type'])[1];
			if(move_uploaded_file($file['tmp_name'], $uploaddir.$nombre_archivo)){
				echo "subio_ok";
				echo setExtencionArchivoSoporte($_SESSION["id_asistencia"],explode("/",$file['type'])[1]);
			}else{
				echo "no_subio";
			}
		}
	}

	/***************************************************************************
	/* registrarAsistencia() inserta un registro con los datos de una clase registrada por un artista formador.
	***************************************************************************/
	function registrarAsistencia($id_clan,$id_area_artistica,$id_artista_formador,$fecha_taller,$id_lugar_atencion,$numero_personas,$observaciones){
		return addRegistroAsistencia($id_clan,$id_area_artistica,$id_artista_formador,$fecha_taller,$id_lugar_atencion,$numero_personas,$observaciones);
	}

	/***************************************************************************
	/* getSelectClan() retorna en formato <option></option> los clanes registrados en el sistema.
	***************************************************************************/
	function getSelectClan(){
		$clan = getClanes();
		$return = "";
		foreach ($clan as $c) {
			$return .= "<option value='".$c['PK_Id_Clan']."'>".$c['VC_Nom_Clan']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getSelectAreasArtisticas() retorna en formato <option></option> las areas artisticas.
	***************************************************************************/
	function getSelectAreasArtisticas(){
		$area_artistica = getAreasArtisticas();
		$return = "";
		foreach ($area_artistica as $a) {
			$return .= "<option value='".$a['PK_Area_Artistica']."'>".$a['VC_Nom_Area']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getSelectLugaresAtencion() retorna en formato <option></option> los lugares de atención registrados en el sistema para el programa laboratorio clan.
	***************************************************************************/
	function getSelectLugaresAtencion(){
		$lugar_atencion = getLugaresAtencion();
		$return = "";
		foreach ($lugar_atencion as $l) {
			$return .= "<option value='".$l['PK_lugar_atencion']."'>".$l['VC_Nombre_Lugar']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* guardarAsistencia() almacena la información detallada (documento y nombre) de una persona que asiste a una clase de laboratorio clan.
	***************************************************************************/
	function guardarAsistenciaPersona($id_registro_asistencia,$tiene_documento,$documento_persona,$nombre_persona){
		if(!$tiene_documento){
			$documento_persona = "PV_IDARTES_".(getUltimoDocumentoAsignado() + 1);
		}
		return guardarAsistenciaLaboratorioClan($id_registro_asistencia,$tiene_documento,$documento_persona,$nombre_persona);
	}

	/***************************************************************************
	/* getUltimoDocumentoAsignado() retorna el ultimo número de documento asignado automaticamente para las personas que no reportan documento.
	***************************************************************************/
	function getUltimoDocumentoAsignado(){
		$ultimo_documento_asignado = getUltimoDocumentoAsignadoLaboratorioClan();
		$ultimo_documento_asignado = $ultimo_documento_asignado[0]['VC_Documento'];
		$numero = "";
		for( $i = 0; $i < strlen($ultimo_documento_asignado); $i++ ){
			if( is_numeric($ultimo_documento_asignado[$i])){
				$numero .= $ultimo_documento_asignado[$i];
			}
    	} 
		return $numero;
	}

	/***************************************************************************
	/* getHistorialArtistaFormador() consulta el historico de las clases dadas por un artista formador del programa laboratorio clan.
	***************************************************************************/
	function getHistorialArtistaFormador($id_artista_formador){
		$historico = getHistoricoArtistaFormador($id_artista_formador);
		$mostrar = "";
		foreach ($historico as $h) {
			$mostrar .= "<tr>";
			$mostrar .= "<td>".$h['VC_codigo_taller']."</td>";
			$mostrar .= "<td>".$h['VC_Nom_Clan']."</td>";
			$mostrar .= "<td>".$h['VC_Nom_Area']."</td>";
			$mostrar .= "<td>".$h['DA_fecha_taller']."</td>";
			$mostrar .= "<td>".$h['VC_Nombre_Lugar']."</td>";
			$mostrar .= "<td>".$h['IN_numero_personas']."</td>";
			$mostrar .= "<td>".$h['VC_observaciones']."</td>";
			$mostrar .= "<td><a href='../../Controlador/Territorial/SoporteAsistenciaLaboratorioCLAN/".$_SESSION['session_username']."/".$h['PK_Asistencia'].".".$h['VC_extencion_archivo_soporte']."' target='_blank'><span class='glyphicon glyphicon-picture' aria-hidden='true'> ver</span></a></td>";
			$mostrar .= "<td><a href='#' class='edtiar_taller' data-id_taller='".$h['PK_Asistencia']."' data-toggle='modal' data-target='#modal-editar_taller'>Editar</a></td>";
			$mostrar .= "</tr>";
		}
		return $mostrar;
	}

	/***************************************************************************
	/* setExtencionArchivoSoporte() guarda en la base de datos la extención del archivo soporte que se adjunto para la asistencia.
	***************************************************************************/
	function setExtencionArchivoSoporte($id_registro_asistencia,$extencion_archivo){
		return updateExtencionArchivoSoporte($id_registro_asistencia,$extencion_archivo);
	}

	/***************************************************************************
	/* validarTallerExistente() verifica si ya existe algun registro de asistencia en ese día, para ese clan, esa area artistica, ese lugar de atención, esa fecha y registrado por ese artista formador.
	***************************************************************************/
	function validarTallerExistente($id_clan,$id_area_artistica,$id_artista_formador,$fecha_taller,$id_lugar_atencion){
		$return = "";
		$taller =  consultarTaller($id_clan,$id_area_artistica,$id_artista_formador,$fecha_taller,$id_lugar_atencion);
		foreach ($taller as $t) {
			$return .= "Taller: ".$t['VC_codigo_taller']." con total personas: ".$t["IN_numero_personas"]." y observaciones: ".$t["VC_observaciones"]."\n";
		}
		return $return;
	}
?>