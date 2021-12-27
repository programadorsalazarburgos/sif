<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/Pedagogico/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'get_artistas_formadores':
				echo getSelectArtistaFormador();
				break;
			case 'get_areas_artisticas':
				echo getSelectAreasArtisticas();
				break;
			case 'get_organizaciones':
				echo getSelectOrganizaciones();
				break;
			case 'registrar_evaluacion_artista_formador':
				$id_evaluacion = registrarEvaluacionArtistaFormador($_POST['id_usuario'],$_POST['SL_artista_formador'],$_POST['SL_area_artistica'],$_POST['slider_artista_formador_1'],$_POST['justificacion_1'],$_POST['slider_artista_formador_2'],$_POST['justificacion_2'],$_POST['slider_artista_formador_3'],$_POST['justificacion_3'],$_POST['slider_artista_formador_4'],$_POST['justificacion_4'],$_POST['slider_artista_formador_5'],$_POST['justificacion_5']);
				echo $id_evaluacion;
				break;
			case 'registrar_evaluacion_organizacion':
				$id_evaluacion = registrarEvaluacionOrganizacion($_POST['id_usuario'],$_POST['SL_organizacion_ev'],$_POST['slider_organizacion_1'],$_POST['justificacion_org_1'],$_POST['slider_organizacion_2'],$_POST['justificacion_org_2'],$_POST['slider_organizacion_3'],$_POST['justificacion_org_3'],$_POST['slider_organizacion_4'],$_POST['justificacion_org_4'],$_POST['slider_organizacion_5'],$_POST['justificacion_org_5'],$_POST['slider_organizacion_6'],$_POST['justificacion_org_6'],$_POST['slider_organizacion_7'],$_POST['justificacion_org_7']);
				echo $id_evaluacion;
				break;
			default:
				echo "opcion no valida: (".$_POST['opcion'].")";
				break;
		}
	}

	/***************************************************************************
	/* getSelectArtistaFormador() retorna en formato <option></option> los artistas formadores.
	***************************************************************************/
	function getSelectArtistaFormador(){
		$artista_formador = getArtistasFormadores();
		foreach ($artista_formador as $a) {
			echo "<option value='".$a['PK_Id_Persona']."'>".$a['VC_Identificacion']." - ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido']." ".$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']."</option>";
		}
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
	/* getSelectOrganizaciones() retorna en formato <option></option> las organizaciones.
	***************************************************************************/
	function getSelectOrganizaciones(){
		$organizacion = getOrganizaciones();
		$return = "";
		foreach ($organizacion as $a) {
			$return .= "<option value='".$a['PK_Id_Organizacion']."'>".$a['VC_Nom_Organizacion']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* registrarEvaluacionArtistaFormador() guarda una encuesta en la base de datos
	***************************************************************************/
	function registrarEvaluacionArtistaFormador($id_usuario,$id_artista_formador,$id_area_artistica,$p1,$j1,$p2,$j2,$p3,$j3,$p4,$j4,$p5,$j5){
		return insertEvaluacionArtistaFormador($id_usuario,$id_artista_formador,$id_area_artistica,$p1,$j1,$p2,$j2,$p3,$j3,$p4,$j4,$p5,$j5);
	}

	/***************************************************************************
	/* registrarEvaluacionArtistaFormador() guarda una encuesta en la base de datos
	***************************************************************************/
	function registrarEvaluacionOrganizacion($id_usuario,$id_organizacion,$p1,$j1,$p2,$j2,$p3,$j3,$p4,$j4,$p5,$j5,$p6,$j6,$p7,$j7){
		return insertEvaluacionOrganizacion($id_usuario,$id_organizacion,$p1,$j1,$p2,$j2,$p3,$j3,$p4,$j4,$p5,$j5,$p6,$j6,$p7,$j7);
	}

	/***************************************************************************
	/* concatMultipleSelect() retorna las opciones de un select que han sido seleccionadas separadas por el concatenador '-'.
	***************************************************************************/
	function concatMultipleSelect($selector){
		$return = "";
		foreach ($selector as $c){
			$return .= $c."-";
		}
		$return = substr($return,0,-1);
		return $return;
	}