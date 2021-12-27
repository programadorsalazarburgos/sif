<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/ConsultasReportes/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'get_clan':
				echo getOptionsClan();
				break;
			case 'get_all_grupos_clan':
				echo getGruposArteEscuelaClan($_POST['id_clan']);
				echo getGruposEmprendeClanClan($_POST['id_clan']);
				break;
			case 'get_meses_novedades_grupo':
				echo getOptionsNovdadesGrupoMes($_POST['id_grupo'],$_POST['tipo_grupo']);
				break;
			case 'get_table_novedades_grupo':
				echo getRowsTableNovedades($_POST['id_grupo'],$_POST['tipo_grupo'],$_POST['mes_anio']);
				break;
			default:
				echo "opcion no valida en consultar asistencia formador: (".$_POST['opcion'].")";
				break;
		}
	}

	/***************************************************************************
	/* getOptionsClan() retorna en formato optionlos clan que existen en el sistema de información
	***************************************************************************/
	function getOptionsClan(){
		$return = "";
		foreach (getClanes() as $c) {
			$return .= "<option value='".$c['PK_Id_Clan']."'>".$c['VC_Nom_Clan']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getGruposArteEscuelaClan() retorna en formato option los grupos activos de un clan especifico de la linea arte en la escuela
	***************************************************************************/
	function getGruposArteEscuelaClan($id_clan){
		$return = "<optgroup label='Arte En La Escuela'>";
		foreach (getGruposActivosArteEnLaEscuelaPorClan($id_clan) as $g) {
			$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='arte_escuela'>AE-".$g['PK_Grupo']."</option>";
		}
		$return .= "<optgroup>";
		return $return;
	}

	/***************************************************************************
	/* getGruposEmprendeClanClan() retorna en formato option los grupos activos de un clan especifico de la linea emprende clan
	***************************************************************************/
	function getGruposEmprendeClanClan($id_clan){
		$return = "<optgroup label='Emprende Clan'>";
		foreach (getGruposActivosEmprendeClanPorClan($id_clan) as $g) {
			$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='emprende_clan'>EC-".$g['PK_Grupo']."</option>";
		}
		$return .= "</optgroup>";
		return $return;
	}

	function getOptionsNovdadesGrupoMes($id_grupo,$tipo_grupo){
		$return = "";
		if ($tipo_grupo == 'arte_escuela') {
			foreach (getMesNovdadesGrupoArteEscuela($id_grupo) as $m) {
				$return .= "<option value='".$m['ANIO']."-".(($m['MES'] < 10)? '0' : '').$m['MES']."'>".$m['ANIO']."-".(($m['MES'] < 10)? '0' : '').$m['MES']."</option>";
			}
		}else if($tipo_grupo == 'emprende_clan'){
			foreach (getMesNovdadesGrupoEmprendeClan($id_grupo) as $m) {
				$return .= "<option value='".$m['ANIO']."-".(($m['MES'] < 10)? '0' : '').$m['MES']."'>".$m['ANIO']."-".(($m['MES'] < 10)? '0' : '').$m['MES']."</option>";
			}
		}
		return $return;
	}

	function getRowsTableNovedades($id_grupo,$tipo_grupo,$mes_anio){
		$return = "";
		if ($tipo_grupo == 'arte_escuela') {
			foreach (getNovdadesGrupoArteEscuela($id_grupo,$mes_anio) as $n) {
				$return .= "<tr>";
				$return .= "<td>".$n['DA_fecha_sesion_clase']."</td>";
				$return .= "<td>".$n['ARTISTA']."</td>";
				switch ($n['IN_asistencia']) {
					case '0':
						$return .= "<td><span class='glyphicon glyphicon-remove'></span>NO</td>";
						break;
					case '1':
						$return .= "<td><span class='glyphicon glyphicon-ok'></span>SÍ</td>";
						break;	
					default:
						$return .= "<td><span class='glyphicon glyphicon-trash'></span>??</td>";
						break;
				}
				switch ($n['IN_novedad']) {
					case '0':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Ninguna</td>";
						break;
					case '1':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Clase Cancelada</td>";
						break;
					case '2':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Retraso o llegada tarde</td>";
						break;
					case '3':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Remplazo o suplencia</td>";
						break;
					case '4':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Incapacidad medica</td>";
						break;
					case '5':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Calamidad</td>";
						break;
					case '6':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Taller no finalizado</td>";
						break;
					case '7':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Salida artistica</td>";
						break;
					default:
						$return .= "<td><span class='glyphicon glyphicon-trash'></span>??</td>";
						break;
				}
				$return .= "<td>".$n['TX_observacion']."</td>";
				$return .= "<td>".$n['DT_fecha_registro']."</td>";
				$return .= "<td>".$n['USUARIO_REGISTRO']."</td>";
				$return .= "</tr>";
			}
		}else if($tipo_grupo == 'emprende_clan'){
			foreach (getNovdadesGrupoEmprendeClan($id_grupo,$mes_anio) as $m) {
				$return .= "<tr>";
				$return .= "<td>".$n['DA_fecha_sesion_clase']."</td>";
				$return .= "<td>".$n['ARTISTA']."</td>";
				switch ($n['IN_asistencia']) {
					case '0':
						$return .= "<td><span class='glyphicon glyphicon-remove'></span>NO</td>";
						break;
					case '1':
						$return .= "<td><span class='glyphicon glyphicon-ok'></span>SÍ</td>";
						break;	
					default:
						$return .= "<td><span class='glyphicon glyphicon-trash'></span>??</td>";
						break;
				}
				switch ($n['IN_novedad']) {
					case '0':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Ninguna</td>";
						break;
					case '1':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Clase Cancelada</td>";
						break;
					case '2':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Retraso o llegada tarde</td>";
						break;
					case '3':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Remplazo o suplencia</td>";
						break;
					case '4':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Incapacidad medica</td>";
						break;
					case '5':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Calamidad</td>";
						break;
					case '6':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Taller no finalizado</td>";
						break;
					case '7':
						$return .= "<td><span class='glyphicon glyphicon-screenshot'></span>Salida artistica</td>";
						break;
					default:
						$return .= "<td><span class='glyphicon glyphicon-trash'></span>??</td>";
						break;
				}
				$return .= "<td>".$n['TX_observacion']."</td>";
				$return .= "<td>".$n['DT_fecha_registro']."</td>";
				$return .= "<td>".$n['USUARIO_REGISTRO']."</td>";
				$return .= "</tr>";
			}
		}
		return $return;
	}
?>