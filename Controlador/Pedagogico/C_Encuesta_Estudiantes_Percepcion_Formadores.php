<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/Pedagogico/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'get_areas_artisticas':
				echo getSelectAreasArtisticas();
				break;
			case 'get_artistas_formadores':
				echo getSelectArtistaFormador();
				break;
			case 'guardar_encuesta':
				echo saveEncuesta($_POST['TB_nombre_estudiante'],$_POST['SL_area_artistica'],$_POST['SL_artista_formador'],$_POST['slider_1'],$_POST['slider_2'],$_POST['slider_3'],$_POST['slider_4'],$_POST['slider_5'],$_POST['slider_6'],$_POST['slider_7'],$_POST['TB_observaciones']);
				break;
			default:
				echo "opcion no valida: (".$_POST['opcion'].")";
				break;
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
	/* getSelectArtistaFormador() retorna en formato <option></option> los artistas formadores.
	***************************************************************************/
	function getSelectArtistaFormador(){
		$artista_formador = getArtistasFormadores();
		foreach ($artista_formador as $a) {
			echo "<option value='".$a['PK_Id_Persona']."'>".$a['VC_Identificacion']." - ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido']." ".$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']."</option>";
		}
	}

	/***************************************************************************
	/* saveEncuesta() guarda los resultados de la encuesta en la base de datos
	***************************************************************************/
	function saveEncuesta($nombre_estudiante,$id_area_artistica,$id_formador,$r1,$r2,$r3,$r4,$r5,$r6,$r7,$observaciones){
		return insertEncuesta($nombre_estudiante,$id_area_artistica,$id_formador,$r1,$r2,$r3,$r4,$r5,$r6,$r7,$observaciones);
	}
?>