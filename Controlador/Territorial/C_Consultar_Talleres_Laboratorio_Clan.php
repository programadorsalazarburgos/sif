<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/Territorial/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'get_artistas_formadores':
				echo getArtistasFormadores();
				break;
			case 'get_meses_clases':
				echo getMesesClases($_POST['id_artista_formador']);
				break;
			case 'get_historial_clases_mes':
				echo getHistorialMesArtistaFormador($_POST['anio_mes'],$_POST['id_artista_formador']);
				break;
			default:
				echo "opcion no valida: (".$_POST['opcion'].")";
				break;
		}
	}
	/***************************************************************************
	/* getArtistasFormadores() muestra en formato <option></option> los artistas formadores que han registrado asistencias.
	***************************************************************************/

	function getArtistasFormadores(){
		$return = "<option selected='selected'>Seleccione un artista formador</option>";
		$artista_formador = getArtistasFormadoresLaboratorioClan();
		foreach ($artista_formador as $a) {
			$return .= "<option value='".$a['FK_artista_formador']."'>".$a['VC_Identificacion']." - ".$a['VC_Primer_Apellido']." ".$a['VC_Segundo_Apellido']." ".$a['VC_Primer_Nombre']." ".$a['VC_Segundo_Nombre']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getMesesClases() muestra en formato <option></option> los meses en los cuales un artista formador ha registrado asistencias.
	***************************************************************************/
	function getMesesClases($id_artista_formador){
		$nombre_mes = ["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
		$anio_mes = getAnioMesSesionesClaseArtistaFormador($id_artista_formador);
		$return = "";
		foreach ($anio_mes as $a) {
			$return .= "<option value='".$a['anio']."-".(($a['mes'] < 10)? '0' : '').$a['mes']."'>".$nombre_mes[$a['mes']]." de ".$a['anio']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getHistorialMesArtistaFormador() consulta el historico de las clases dadas por un artista formador del programa laboratorio clan.
	***************************************************************************/
	function getHistorialMesArtistaFormador($anio_mes,$id_artista_formador){
		$historico = getClasesMesArtistaFormador($anio_mes,$id_artista_formador);
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
			$mostrar .= "<td><a href='../../Controlador/Territorial/SoporteAsistenciaLaboratorioCLAN/".$id_artista_formador."/".$h['PK_Asistencia'].".".$h['VC_extencion_archivo_soporte']."' target='_blank'><span class='glyphicon glyphicon-picture' aria-hidden='true'> ver</span></a></td>";
			$mostrar .= "</tr>";
		}
		return $mostrar;
	}
?>