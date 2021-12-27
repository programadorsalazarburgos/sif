<?php
require_once('../../../Modelo/Infraestructura/Acceso_Datos.php');
if (isset($_POST['function'])){
	switch ($_POST['function']) {
		case 'getInfoGeneral':
		echo getInfoGeneral($_POST['id_crea']);
		break;
		case 'getInfoAsistentes':
		echo getInfoAsistentes($_POST['id_crea']);
		break;
		case 'getInfoAuxiliaresOperativos':
		echo getInfoAuxiliaresOperativos($_POST['id_crea']);
		break;
		case 'getInfoComplementaria':
		echo getInfoComplementaria($_POST['id_crea']);
		break;
		case 'subirArchivosCrea':
		echo subirArchivosCrea($_POST['id_crea'],$_POST['tipo_archivo'],$_POST['usuario']);
		break;
		case 'getCarouselFotograficoCrea':
		echo getCarouselFotograficoCrea($_POST['id_crea'],$_POST['tipo_archivo']);
		break;
		case 'getArchivosCrea':
		echo getArchivosCrea($_POST['id_crea'],$_POST['tipo_archivo']);
		break;
		case 'deleteArchivoCrea':
		echo deleteArchivoCrea($_POST['id_crea'],$_POST['id_archivo'],$_POST['nombre_archivo'],$_POST['tipo_archivo'],$_POST['usuario']);
		break;
		case 'getCoordinadoresCrea':
		echo getCoordinadoresCrea();
		break;
		case 'getLocalidades':
		echo getLocalidades();
		break;
		case 'getZonas':
		echo getZonas();
		break;
		case 'updateFichaCreaInfoGeneral':
		echo updateFichaCreaInfoGeneral($_POST['id_crea'],$_POST['usuario'],$_POST['SL_ADMINISTRADOR'],$_POST['TX_TELEFONO'],$_POST['TX_DIRECCION'],$_POST['SL_LOCALIDAD'],$_POST['SL_ZONA'],$_POST['TX_CORREO_ADMINISTRADOR'],$_POST['TX_FECHA_APERTURA']);
		break;
		case 'updateFichaCreaAsistentesAdministrativos':
		echo updateFichaCreaAsistentesAdministrativos($_POST['id_crea'],$_POST['usuario'],$_POST['fk_asistentes_administrativos']);
		break;
		case 'updateFichaCreaEmergencias':
		echo updateFichaCreaEmergencias($_POST['id_crea'],$_POST['usuario'],$_POST['TX_CUADRANTE'],$_POST['TX_BOMBEROS']);
		break;
		case 'updateFichaCreaAuxiliaresOperativos':
		echo updateFichaCreaAuxiliaresOperativos($_POST['id_crea'],$_POST['usuario'],$_POST['fk_auxiliares_operativos']);
		break;
		case 'getAsistentesAdministrativos':
		echo getAsistentesAdministrativos();
		break;
		case 'getAuxiliaresOperativos':
		echo getAuxiliaresOperativos();
		break;
		default:
		echo "opcion no valida en C_Ficha_Crea: (".$_POST['function'].")";
		break;
	}
}

	/***************************************************************************
	/* getInfoGeneral() retorna un registro con la informacion general del CREA.
	***************************************************************************/
	function getInfoGeneral($id_crea){
		$ficha = fichaCrea::getInfoGeneralCrea($id_crea);
		$return = "";
		foreach ($ficha as $f){
			//Informacion General
			$return .= "<form id='fm-info-general' name='fm-info-general'>";
			$return .= "<input id='TX_FK_Coordinador_Crea' name='TX_FK_Coordinador_Crea' value='".$f['FK_Persona_Administrador']."' hidden>";
			$return .= "<input id='TX_FK_Localidad' name='TX_FK_Localidad' value='".$f['FK_Id_Localidad']."' hidden>";
			$return .= "<input id='TX_FK_Zona' name='TX_FK_Zona' value='".$f['PK_Id_Zona']."' hidden>";
			$return .= " <div class='col-sm-12 col-md-12 col-lg-12 div-content'>";
			$return .= "<div class='col-sm-6 col-md-6 col-lg-6'>";
			$return .= "Responsable: <label><span id='span-tx-administrador'><input id='TX_ADMINISTRADOR' name='TX_ADMINISTRADOR' type='text' class='form-control input-edit info-general' value='".$f['Coordinador']."' title='".$f['Coordinador']."' readonly></span><span id='span-sl-administrador' hidden><select id='SL_ADMINISTRADOR' name='SL_ADMINISTRADOR' class='form-control'></select></span></label>";
			$return .= "</div>";
			$return .= "<div class='col-sm-6 col-md-6 col-lg-6'>";
			$return .= "Teléfono: <label><input id='TX_TELEFONO' name='TX_TELEFONO' type='text' class='form-control input-edit info-general' value='".$f['VC_Telefono_Clan']."' title='".$f['VC_Telefono_Clan']."' readonly>";
			$return .= "</div>";
			$return .= "</div>";

			$return .= " <div class='col-sm-12 col-md-12 col-lg-12 div-content'>";
			$return .= "<div class='col-sm-6 col-md-6 col-lg-6'>";
			$return .= "Direccion: <label><input id='TX_DIRECCION' name='TX_DIRECCION' type='text' class='form-control input-edit info-general' value='".$f['VC_Direccion_Clan']."' title='".$f['VC_Direccion_Clan']."' readonly></label>";
			$return .= "</div>";
			$return .= "<div class='col-sm-6 col-md-6 col-lg-6'>";
			$return .= "Correo: <label><input id='TX_CORREO_ADMINISTRADOR' name='TX_CORREO_ADMINISTRADOR' type='text' class='form-control input-edit info-general' value='".$f['VC_Correo']."' title='".$f['VC_Correo']."' readonly></label>";
			$return .= "</div>";
			$return .= "</div>";

			$return .= " <div class='col-sm-12 col-md-12 col-lg-12 div-content'>";
			$return .= "<div class='col-sm-6 col-md-6 col-lg-6'>";
			$return .= "Zona: <label><span id='span-tx-zona'><input id='TX_ZONA' name='TX_ZONA' type='text' class='form-control input-edit info-general' value='".$f['VC_Nombre_Zona']."' title='".$f['VC_Nombre_Zona']."' readonly></span><span id='span-sl-zonas' hidden><select id='SL_ZONA' name='SL_ZONA' class='form-control'></select></span></label>";
			$return .= "</div>";
			$return .= "<div class='col-sm-6 col-md-6 col-lg-6'>";
			$return .= "Localidad: <label><span id='span-tx-localidad'><input id='TX_LOCALIDAD' name='TX_LOCALIDAD' type='text' class='form-control input-edit info-general' value='".$f['VC_Nom_Localidad']."' title='".$f['VC_Nom_Localidad']."' readonly></span><span id='span-sl-localidades' hidden><select id='SL_LOCALIDAD' name='SL_LOCALIDAD' class='form-control'></select></span></label>";
			$return .= "</div>";
			$return .= "</div>";
			
			$return .= " <div class='col-sm-12 col-md-12 col-lg-12 div-content'>";
			$return .= "<div class='col-sm-6 col-md-6 col-lg-6'>";
			$return .= "Fecha Apertura: <label><input id='TX_FECHA_APERTURA' name='TX_FECHA_APERTURA' type='text' class='form-control input-edit info-general' value='".$f['DT_Fecha_Apertura']."' title='".$f['DT_Fecha_Apertura']."' readonly></label>";
			$return .= "</div>";
			$return .= "</div>";
			$return .= "</form>";
		}
		return $return;
	}

	/***************************************************************************
	/* getInfoAsistentes() retorna los asistentes administrativos de un determinado CREA.
	***************************************************************************/
	function getInfoAsistentes($id_crea){
		$asistentes = fichaCrea::getInfoAsistentesCrea($id_crea);
		$return = "";
		$fk_asistentes_administrativos = "";
		$contador = 0;
		$return .= "<div class='col-sm-12 col-md-12 col-lg-12 div-sl-administrativos div-content' hidden>";
		$return .= "<select id='SL_ASISTENTES_ADMINISTRATIVOS' name='SL_ASISTENTES_ADMINISTRATIVOS' class='form-control selectpicker' data-live-search='true' multiple='multiple'></select>";
		$return .= "</div>";
		foreach ($asistentes as $a){
			$contador++;
			//Informacion Asistentes
			$fk_asistentes_administrativos .= $a['PK_Id_Persona'].',';
			$return .= " <div class='col-sm-12 col-md-12 col-lg-12 div-content div-asistentes-administrativos'>";
			
			$return .= "<div class='col-sm-4 col-md-4 col-lg-4'>";
			$return .= "<input id='TX_NOMBRE_ASISTENTE_ADMINISTRATIVO_".$contador."' name='TX_NOMBRE_ASISTENTE_ADMINISTRATIVO_".$contador."' type='text' class='form-control input-edit asistentes-administrativos' value='".$a['nombre_asistente']."' title='".$a['nombre_asistente']."' readonly></label>";
			$return .= "</div>";
			$return .= "<div class='col-sm-4 col-md-4 col-lg-4'>";
			$return .= "<input id='TX_EMAIL_ASISTENTE_".$contador."' name='TX_EMAIL_ASISTENTE_".$contador."' type='text' class='form-control input-edit asistentes-administrativos' value='".$a['email_asistente']."' title='".$a['email_asistente']."' readonly></label>";
			$return .= "</div>";
			$return .= "<div class='col-sm-4 col-md-4 col-lg-4'>";
			$return .= "Celular: <label><input id='TX_CELULAR_ASISTENTE_ADMINISTRATIVO_".$contador."' name='TX_CELULAR_ASISTENTE_ADMINISTRATIVO_".$contador."' type='text' class='form-control input-edit asistentes-administrativos' value='".$a['celular']."' title='".$a['celular']."' readonly></label>";
			$return .= "</div>";
			$return .= "</div>";
		}
		$return .= "<input id='TX_FK_Asistentes_Administrativos' name='TX_FK_Asistentes_Administrativos' value='".$fk_asistentes_administrativos."' hidden>";
		return $return;
	}

	/***************************************************************************
	/* getInfoAuxiliaresOperativos() retorna los Auxiliares operativos de un determinado CREA.
	***************************************************************************/
	function getInfoAuxiliaresOperativos($id_crea){
		$auxiliares = fichaCrea::getInfoAuxiliaresOperativosCrea($id_crea);
		$return = "";
		$fk_auxiliares_operativos = "";
		$contador = 0;
		$return .= "<div class='col-sm-12 col-md-12 col-lg-12 div-sl-auxiliares div-content' hidden>";
		$return .= "<select id='SL_AUXILIARES_OPERATIVOS' name='SL_AUXILIARES_OPERATIVOS' class='form-control selectpicker' data-live-search='true' multiple='multiple'></select>";
		$return .= "</div>";
		foreach ($auxiliares as $a){
			$contador++;
			//Informacion auxiliares
			$fk_auxiliares_operativos .= $a['PK_Id_Persona'].',';
			$return .= " <div class='col-sm-12 col-md-12 col-lg-12 div-content div-auxiliares-operativos'>";
			
			$return .= "<div class='col-sm-4 col-md-4 col-lg-4'>";
			$return .= "<input id='TX_NOMBRE_AUXILIAR_OPERATIVO_".$contador."' name='TX_NOMBRE_AUXILIAR_OPERATIVO_".$contador."' type='text' class='form-control input-edit auxiliares-operativos' value='".$a['nombre_auxiliar']."' title='".$a['nombre_auxiliar']."' readonly></label>";
			$return .= "</div>";
			$return .= "<div class='col-sm-4 col-md-4 col-lg-4'>";
			$return .= "<input id='TX_EMAIL_AUXILIAR_".$contador."' name='TX_EMAIL_AUXILIAR_".$contador."' type='text' class='form-control input-edit auxiliares-operativos' value='".$a['email_auxiliar']."' title='".$a['email_auxiliar']."' readonly></label>";
			$return .= "</div>";
			$return .= "<div class='col-sm-4 col-md-4 col-lg-4'>";
			$return .= "Celular: <label><input id='TX_CELULAR_AUXILIAR_OPERATIVO_".$contador."' name='TX_CELULAR_AUXILIAR_OPERATIVO_".$contador."' type='text' class='form-control input-edit auxiliares-operativos' value='".$a['celular']."' title='".$a['celular']."' readonly></label>";
			$return .= "</div>";
			$return .= "</div>";
		}
		$return .= "<input id='TX_FK_Auxiliares_Operativos' name='TX_FK_Auxiliares_Operativos' value='".$fk_auxiliares_operativos."' hidden>";
		return $return;
	}

	/***************************************************************************
	/* getInfoComplementaria() retorna la información de Emergencias, Asistentes Operativos, Documentación y GeoReferenciación del Crea indicado.
	***************************************************************************/
	function getInfoComplementaria($id_crea){
		$ficha = fichaCrea::getInfoGeneralCrea($id_crea);
		$contador = 0;
		$return = "";
		foreach ($ficha as $f){
			//Informacion General
			$return .= "<form id='fm-emergencias' name='fm-emergencias'>";
			$return .= "<div class='col-md-12 header'><h4><i class='fa fa-medkit'></i> EMERGENCIAS <span id='botones-emergencias' hidden><a class='fas fa-save a-save' data-seccion='emergencias'></a></span><span class='span-edit'><a class='fas fa-pencil-alt a-edit' data-seccion='emergencias'></a></span></h4></div>";
			$return .= " <div class='col-sm-12 col-md-12 col-lg-12 div-content'>";
			$return .= "<div class='col-sm-6 col-md-6 col-lg-6'>";
			$return .= "Cuadrante: <label><input id='TX_CUADRANTE' name='TX_CUADRANTE' type='text' class='form-control input-edit emergencias' value='".$f['VC_Cuadrante']."' readonly></label>";
			$return .= "</div>";
			$return .= "<div class='col-sm-6 col-md-6 col-lg-6'>";
			$return .= "Bomberos: <label><input id='TX_BOMBEROS' name='TX_BOMBEROS' type='text' class='form-control input-edit emergencias' value='".$f['VC_Bomberos']."' readonly></label>";
			$return .= "</div>";
			$return .= "</div>";
			$return .= "</form>";
			$return .= "</div>";
			
			$return .= "<div class='col-md-6 header-middle'><h4><i class='fa fa-folder-open'></i> DOCUMENTACIÓN</h4></div>";
			$return .= "<div class='col-md-6 header-middle'><h4><i class='fa fa-map-marker'></i> GEOREFERENCIACIÓN</h4></div>";
			$return .= "<div class='col-md-4 col-md-offset-1 div-content' style='padding:20px'>";
			$return .= "<div class='input-group'><input type='button' id='BT_REGISTRO_FOTOGRAFICO' name='BT_REGISTRO_FOTOGRAFICO' class='btn btn-default form-control' value='REGISTRO FOTOGRÁFICO'><span class='input-group-btn'><button id='BT_EDITAR_FOTOGRAFIAS' class='btn btn-secondary' type='button'><i class='fa fa-camera'></i></button></span></div>";
			$return .= "<button id='BT_PLANOS_ARQUITECTONICOS' class='btn btn-default form-control'><i class='fas fa-map'></i> PLANOS ARQUITECTÓNICOS</button>";
			$return .= "<button id='BT_ARRENDAMIENTOS' class='btn btn-default form-control'><i class='fas fa-file-alt'></i> ARRENDAMIENTOS</button>";
			$return .= "<button id='BT_TERRITORIAL' class='btn btn-default form-control'><i class='fa fa-map-signs'></i> TERRITORIAL</button>";
			$return .= "<button id='BT_ESPACIOS' class='btn btn-default form-control'><i class='fa fa-users'></i> ESPACIOS</button>";
			$return .= "</div>";
			$return .= "<div class='col-sm-6 col-md-6 col-lg-6 col-md-offset-1 div-content'>";
			$return .= "<div class='maps'>";
			$return .= "<iframe id='mapa' src=".$f['VC_Google_Maps']." width='100%' height='450' frameborder='0' style='border:0' allowfullscreen></iframe>";
			$return .= "</div>";
			$return .= "</div>";
		}
		return $return;
	}

	/***************************************************************************
	/* subirArchivosCrea() realiza la subida de archivos de cada CREA con su respectivo TIPO.
	***************************************************************************/
	function subirArchivosCrea($id_crea,$tipo_archivo,$usuario){
		function quitarTildes($cadena) {
			$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹","?");
			$permitidas= array("a","e","i","o","u","A","E","I","O","U","n","N","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","");
			$texto = str_replace($no_permitidas, $permitidas ,$cadena);
			$texto = str_replace($no_permitidas, $permitidas ,utf8_decode($texto));
			return $texto;
		}

		$data = array();
		date_default_timezone_set('America/Bogota');
		$fecha=date("Y-m-d-H:i:s");

		if(isset($_FILES))
		{
			$nombre_carpeta = "../../../uploadedFiles/Infraestructura/FichaCrea/".$id_crea."/".$tipo_archivo;

			if(!is_dir($nombre_carpeta)){
				$mask=umask(0);
				@mkdir($nombre_carpeta, 0777);
				umask($mask);
			}else{ 
				echo "Ya existe ese directorio\n";
			}

			$error = false;
			$files = array();
			$uploaddir = './'.$nombre_carpeta.'/';
			$i=0;
			foreach($_FILES as $file)
			{	
				$i++;
				$path_info = pathinfo($file['name']);
				$Nombre_Archivo = basename($file['name']);
				$Nombre_Archivo = quitarTildes($Nombre_Archivo);
				$Ubicacion_Archivo ="uploadedFiles/Infraestructura/FichaCrea/".$id_crea."/".$tipo_archivo."/".$Nombre_Archivo;
				if(move_uploaded_file($file['tmp_name'], $uploaddir.$Nombre_Archivo))
				{
					$files[] = $Ubicacion_Archivo;
					fichaCrea::saveNuevoArchivoCrea($id_crea, $tipo_archivo, $Nombre_Archivo, $Ubicacion_Archivo, $fecha, $usuario);
				}
				else
				{
					$error = true;
				}
			}
			$data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
		}
		else
		{
			$data = array('success' => 'Form was submitted', 'formData' => $_POST);
		}
		echo json_encode($data);
	}

	/***************************************************************************
	/* getCarouselFotograficoCrea() construye el carousel de fotografias del Crea.
	***************************************************************************/
	function getCarouselFotograficoCrea($id_crea,$tipo_archivo){
		$ficha = fichaCrea::getArchivosCrea($id_crea,$tipo_archivo);
		$return = "";
		$contador = 0;
		$return .= "<div class='col-sm-12 col-md-12 col-lg-12'>";
		$return .= "<div id='myCarousel' class='carousel slide' data-ride='carousel'>";
		$return .= "<ol class='carousel-indicators'>";
		foreach ($ficha as $f){
			//Indicators		
			$return .= "<li data-target='#myCarousel' data-slide-to='".$contador."'></li>";
			$contador++;
		}
		$return .= "</ol>";

		$ficha = fichaCrea::getArchivosCrea($id_crea,$tipo_archivo); 
		$contador = 0;        
		$return .= "<div class='carousel-inner'>";
		foreach ($ficha as $f){
			//Indicators
			$direccion_imagen = "../../uploadedFiles/Infraestructura/FichaCrea/".$f['FK_Id_Crea']."/".$tipo_archivo."/".$f['VC_Nombre'];	
			if ($contador == 0) {
				$return .= "<div class='item active'>";
			}else{
				$return .= "<div class='item'>";
			}			
			$return .= "<img src='".$direccion_imagen."'>";
			$return .= "</div>";
			$contador++;
		}
		$return .= "</div>";
		$return .= "<a class='left carousel-control' href='#myCarousel' data-slide='prev'>";
		$return .= "<span class='glyphicon glyphicon-chevron-left'></span>";
		$return .= "<span class='sr-only'>Previous</span>";
		$return .= "</a>";
		$return .= "<a class='right carousel-control' href='#myCarousel' data-slide='next'>";
		$return .= "<span class='glyphicon glyphicon-chevron-right'></span>";
		$return .= "<span class='sr-only'>Next</span>";		
		$return .= "</a>";
		$return .= "</div>";

		$return .= "<div class='clearfix'>";
		$return .= "<div id='thumbcarousel' class='carousel slide' data-interval='false'>";
		$return .= "<div class='carousel-inner'>";

		$ficha = fichaCrea::getArchivosCrea($id_crea,$tipo_archivo); 
		$contador = 0;        
		$return .= "<div class='carousel-inner'>";
		foreach ($ficha as $f){
			//Indicators
			$direccion_imagen = "../../uploadedFiles/Infraestructura/FichaCrea/".$f['FK_Id_Crea']."/".$tipo_archivo."/".$f['VC_Nombre'];
			if ($contador == 0) {
				$return .= "<div class='item active'>";
			}else{
				if($contador == 5 || $contador == 10 || $contador == 15 || $contador == 20 || $contador == 25){
					$return .= "</div>";
					$return .= "<div class='item'>";
				}
			}		
			$return .= "<div data-target='#myCarousel' data-slide-to='".$contador."' class='thumb'><img src='".$direccion_imagen."'></div>";
			$contador++;
		}
		$return .= "</div>";//<!-- /item -->
		$return .= "</div>";//<!-- /carousel-inner -->
		$return .= "<a class='left carousel-control' href='#thumbcarousel' role='button' data-slide='prev'><span class='glyphicon glyphicon-chevron-left'></span></a>";
		$return .= "<a class='right carousel-control' href='#thumbcarousel' role='button' data-slide='next'>
		<span class='glyphicon glyphicon-chevron-right'></span></a>";
		$return .= "</div>"; //<!-- /thumbcarousel -->
		$return .= "</div>";//<!-- /clearfix -->
		$return .= "</div>";//<!-- /col-md-12 -->
		
		return $return;
	}

	/***************************************************************************
	/* getArchivosCrea() construye la tabla de archivos del Crea.
	***************************************************************************/
	function getArchivosCrea($id_crea,$tipo_archivo){
		$archivos = fichaCrea::getArchivosCrea($id_crea,$tipo_archivo);
		$return = "";
		foreach ($archivos as $r){
			$return .= "<tr>";
			$return .= "<td>".$r['VC_Nombre']."</td>";
			$return .= "<td>
			<a class='btn btn-primary ver-archivo' title='Ver' data-id-archivo='".$r['PK_Id_Tabla']."' href='../../".$r['VC_Url']."' target='_blank'><i class='fa fa-external-link'></i></a>
			<a class='btn btn-success descargar-archivo' title='Descargar' data-id-archivo='".$r['PK_Id_Tabla']."' download='".$r['VC_Nombre']."' href='../../".$r['VC_Url']."'><i class='fa fa-cloud-download'></i></a>
			<span class='span-eliminar-archivo'><a class='btn btn-danger eliminar-archivo' title='Eliminar' data-id-archivo='".$r['PK_Id_Tabla']."' data-nombre-archivo='".$r['VC_Nombre']."' data-tipo-archivo='".$tipo_archivo."'><i class='fa fa-close'></i></a></span>
			</td>";
			$return .= "</tr>";
		}
		return $return;
	}
	/***************************************************************************
	/* deleteArchivoCrea() elimina el archivo indicado del Crea.
	***************************************************************************/
	function deleteArchivoCrea($id_crea,$id_archivo,$nombre_archivo,$tipo_archivo,$usuario){

		fichaCrea::deleteArchivoCrea($id_crea,$id_archivo,$nombre_archivo,$tipo_archivo,$usuario);

	}
	/***************************************************************************
	/* updateFichaCreaInfoGeneral() actualiza la informacion de la seccion INFORMACION GENERAL de la Ficha CREA.
	***************************************************************************/
	function updateFichaCreaInfoGeneral($id_crea,$usuario,$administrador,$telefono,$direccion,$localidad,$zona,$correo_administrador,$fecha_apertura){
		fichaCrea::updateFichaCreaInfoGeneral($id_crea,$usuario,$administrador,$telefono,$direccion,$localidad,$zona,$correo_administrador,$fecha_apertura);
	}
	/***************************************************************************
	/* updateFichaCreaAsistentesAdministrativos() actualiza la informacion de la seccion ASISTENTES ADMINISTRATIVOS de la Ficha CREA.
	***************************************************************************/
	function updateFichaCreaAsistentesAdministrativos($id_crea,$usuario,$asistentes_administrativos){
		fichaCrea::updateFichaCreaAsistentesAdministrativos($id_crea,$usuario,$asistentes_administrativos);
	}
	/***************************************************************************
	/* updateFichaCreaEmergencias() actualiza la informacion de la seccion EMERGENCIAS de la Ficha CREA.
	***************************************************************************/
	function updateFichaCreaEmergencias($id_crea,$usuario,$cuadrante,$bomberos){
		fichaCrea::updateFichaCreaEmergencias($id_crea,$usuario,$cuadrante,$bomberos);
	}
	/***************************************************************************
	/* updateFichaCreaAuxiliaresOperativos() actualiza la informacion de la seccion AUXILIARES OPERATIVOS de la Ficha CREA.
	***************************************************************************/
	function updateFichaCreaAuxiliaresOperativos($id_crea,$usuario,$auxiliares_operativos){
		fichaCrea::updateFichaCreaAuxiliaresOperativos($id_crea,$usuario,$auxiliares_operativos);
	}
	/***************************************************************************
	/* getCoordinadoresCrea() consulta el listado de usuarios que tienen rol Coordinador Crea.
	***************************************************************************/
	function getCoordinadoresCrea(){
		$coordinadores = fichaCrea::getCoordinadoresCrea();
		$return = "";
		foreach ($coordinadores as $c){
			$return .= "<option value=".$c['PK_Id_Persona'].">".$c['Coordinador']."</option>";
		}
		return $return;
	}
	/***************************************************************************
	/* getLocalidades() consulta el listado de localidades que tiene la tabla tb_localidades.
	***************************************************************************/
	function getLocalidades(){
		$localidades = fichaCrea::getLocalidades();
		$return = "";
		foreach ($localidades as $l){
			$return .= "<option value=".$l['PK_Id_Localidad'].">".$l['VC_Nom_Localidad']."</option>";
		}
		return $return;
	}
	/***************************************************************************
	/* getZonas() consulta el listado de zonas que tiene la tabla tb_zonas.
	***************************************************************************/
	function getZonas(){
		$zonas = fichaCrea::getZonas();
		$return = "";
		foreach ($zonas as $l){
			$return .= "<option value=".$l['PK_Id_Zona'].">".$l['VC_Nombre_Zona']."</option>";
		}
		return $return;
	}
	/***************************************************************************
	/* getAsistentesAdministrativos() consulta el listado de usuarios que tienen rol de Asistentes Administrativos.
	***************************************************************************/
	function getAsistentesAdministrativos(){
		$asistentes_administrativos = fichaCrea::getAsistentesAdministrativos();
		$return = "";
		foreach ($asistentes_administrativos as $a){
			$return .= "<option value=".$a['PK_Id_Persona'].">".$a['Asistente']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getAuxiliaresOperativos() consulta el listado de usuarios que tienen rol de Auxiliares Operativos.
	***************************************************************************/
	function getAuxiliaresOperativos(){
		$auxiliares_operativos = fichaCrea::getAuxiliaresOperativos();
		$return = "";
		foreach ($auxiliares_operativos as $a){
			$return .= "<option value=".$a['PK_Id_Persona'].">".$a['Auxiliar']."</option>";
		}
		return $return;
	}

	?>