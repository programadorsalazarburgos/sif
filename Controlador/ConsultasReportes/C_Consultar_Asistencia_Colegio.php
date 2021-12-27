<?php
	header ('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);	
	include_once('../../Modelo/ConsultasReportes/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'get_options_colegios':
				echo getOptionsColegios();
				break;
			case 'get_mes_sesion_clase_colegio':
				echo getOptionsMesSesionesClaseColegio($_POST['id_colegio']);
				break;
			case 'get_encabezados_sesiones_asistencia_clase_colegio_mes':
				echo getEncabezadoSesionesClaseColegioMes($_POST['id_colegio'],$_POST['mes_anio'],$_POST['mes_anioh']);
				break;
			case 'get_asistencia_clase_colegio_mes':
				echo getDatosSesionesClaseColegioMes($_POST['id_colegio'],$_POST['mes_anio'],$_POST['mes_anioh']);
				break;
			case 'get_options_clan_colegio':
				echo getOptionsClanes($_POST['id_colegio']);
				break;
			case 'get_atendidos_colegio_mes':
				echo getAtendidosColegioMes($_POST['id_colegio'],$_POST['mes_anio'],$_POST['mes_anioh']);
				break;
			default:
				echo "opcion no valida en consultar asistencia colegio: (".$_POST['opcion'].")";
				break;
		}
	}

	/***************************************************************************
	/* getOptionsColegios() retorna una un listado de options con los colegios.
	***************************************************************************/
	function getOptionsColegios(){
		$return = "";
		$colegio = getColegios();
		foreach ($colegio as $c) {
			$return .= "<option value='".$c['PK_Id_Colegio']."'>".$c['VC_Nom_Colegio']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getOptionsMesSesionesClaseColegio() retorna una un listado de los meses que han registrado clase estudiantes que se encuentran registrados hacia alguno de los colegios.
	***************************************************************************/
	function getOptionsMesSesionesClaseColegio($id_colegio){
		$return = "";
		$mes = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
		$mes_anio = getMesSesionesClaseColegio($id_colegio);
		foreach ($mes_anio as $m) {
			$return .= "<option value='".$m['anio']."-".(($m['mes']<10)?'0':'').$m['mes']."'>".$mes[$m['mes'] - 1]." de ".$m['anio']."</option>";
		}
		return $return;
	}

	function getEncabezadoSesionesClaseColegioMes($id_colegio, $mes_anio, $mes_anioh){
		$return = "<tr>";
		$return .= "<th></th>";
		$return .= "<th>Identificación</th>";
		$return .= "<th>Nombre del estudiante</th>";
		$return .= "<th>Grado</th>";
		$return .= "<th>Organización</th>";
		$return .= "<th>Artista Formador</th>";
		$return .= "<th>Area Artistica</th>";
		$return .= "<th>CREA</th>";
		$return .= "<th>Lugar Atención</th>";
		$return .= "<th>Grupo</th>";
		$dia_clase = getFechaSesionesClaseGruposDeColegio($id_colegio,$mes_anio, $mes_anioh);
		foreach ($dia_clase as $d) {
			$return .= "<th>".$d['DIA']."</th>";
		}
		$return .= "</tr>";
		return $return;
	}

	function getDatosSesionesClaseColegioMes($id_colegio, $mes_anio, $mes_anioh){
		$return = "";
		//echo "<script>console.log('inicio: "+date("Y-m-d H:i:s")+"');</script>";
		$estudiante = getEstudiantesSesionesClaseGruposDeColegio($id_colegio,$mes_anio, $mes_anioh);
		//echo "<script>console.log('Luego de getEstudiantesSesionesClaseGruposDeColegio: "+date("Y-m-d H:i:s")+" - "+sizeof($estudiante)+"');</script>";
		//echo 'estudiante: <pre>'.print_r($estudiante,true).'</pre>'; 
		$dia_clase = getFechaSesionesClaseGruposDeColegio($id_colegio,$mes_anio, $mes_anioh);
		//echo "<script>console.log('Luego de getFechaSesionesClaseGruposDeColegio: "+date("Y-m-d H:i:s")+" - "+sizeof($dia_clase)+"');</script>"; 
		$explode = explode("-",$mes_anio);
		foreach ($estudiante as $e) {
			switch ($e['IN_lugar_atencion']) {
				case '1':
					$lugar_atencion = "Solo Colegio";
					break;
				case '2':
					$lugar_atencion = "Solo Crea";
					break;
				case '3':
					$lugar_atencion = "Colegio y Crea";
					break;
				default:
					$lugar_atencion = "No definido";
					break;
			}
			$return .= "<tr>";
			$return .= "<td></td>";
			$return .= "<td>".$e['IN_Identificacion']."</td>";
			$return .= "<td>".$e['nombre_estudiante']."</td>";
			$return .= "<td>".$e['VC_Descripcion_Grado']."</td>";
			$return .= "<td>".$e['VC_Nom_Organizacion']."</td>";
			$return .= "<td>".$e['nombre_artista']."</td>";
			$return .= "<td>".$e['VC_Nom_Area']."</td>";
			$return .= "<td>".$e['VC_Nom_Clan']."</td>";
			$return .= "<td>".$lugar_atencion."</td>";
			$return .= "<td>AE-".$e['FK_grupo']."</td>";
			foreach ($dia_clase as $d) { 
				$return .= "<td>".getEstadoAsistenciaEstudianteSesionClase($e['id'],$explode[0]."-".$d["DIA"])."</td>"; 
				//echo "<script>console.log('Luego de getEstadoAsistenciaEstudianteSesionClase: "+date("Y-m-d H:i:s")+"');</script>";
			}
			$return .= "</tr>";
		}
		return $return;
	}

	function getEstadoAsistenciaEstudianteSesionClase($id_estudiante,$fecha_clase){
		error_reporting(0);
		$estado_asistencia = consultarEstadoAsistenciaSesionClase($id_estudiante,$fecha_clase)[0]["IN_estado_asistencia"];
		if($estado_asistencia != ""){
			if($estado_asistencia == 1){
				$return = '<span title="SÍ Asistió" class="glyphicon glyphicon-ok" aria-hidden="true">SÍ</span>';
			}else if($estado_asistencia == 0){
				$return = '<span title="NO Asistió" class="glyphicon glyphicon-remove" aria-hidden="true">NO</span>';
			}
		}else{
			//$return = '<span title="No Registra" class="glyphicon glyphicon-exclamation-sign" aria-hidden="true">N/R</span>';
		}
		return $return;
	}

	function getOptionsClanes($id_colegio){
		$mostrar = "";
		$clan = getClanesColegiosSesionClase($id_colegio);
		foreach ($clan as $c) {
			$mostrar .= "<option value='".$c['PK_Id_Clan']."'>".$c['VC_Nom_Clan']."</option>";
		}
		return $mostrar;
	}

	function getAtendidosColegioMes($id_colegio, $mes_anio,$mes_anioh){
		$return = "";		
		$contador = 0;
		$atendidos_mes = getAtendidosMesColegio($id_colegio,$mes_anio,$mes_anioh); 
		if($mes_anio!=$mes_anioh) {
			$atendidos="Cantidad Niños ATENDIDOS en el periodo ".$mes_anio." / ".$mes_anioh." : ";
			$inscritos="<br>Cantidad Niños INSCRITOS en el periodo ".$mes_anio." / ".$mes_anioh." : ";
		}
		else {
			$atendidos="Cantidad Niños ATENDIDOS en el Mes ".$mes_anio." : ";
			$inscritos="<br>Cantidad Niños INSCRITOS en el Mes ".$mes_anio." : ";
		}
		foreach ($atendidos_mes as $a){
			$contador++;
			if($contador == 1){
				$return .= $atendidos.$a['datos'];		
			}
			if($contador == 2){
				$return .= $inscritos.$a['datos']; 		
			}
			
		}
		return $return;
	} 
?>