<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/Administracion/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'get_options_usuarios':
				echo getOptionsUsuarios();
				break;
			case 'get_log_login_usuario':
				echo getTableLoginUsuario($_POST['id_usuario'],$_POST['mes_anio']);
				break;
			case 'get_options_clan':
				echo getOptionsClan();
				break;
			case 'get_options_grupo':
				echo getOptionsGrupoArteEscuela($_POST['id_clan']);
				echo getOptionsGrupoEmprendeClan($_POST['id_clan']);
				break;
			case 'get_log_grupo':
				echo getTableLogGrupo($_POST['mes_anio'],$_POST['id_clan'],$_POST['id_grupo'],$_POST['tipo_grupo']);
				break;
			default:
				echo "opcion no valida en revisar auditoria: (".$_POST['opcion'].")";
				break;
		}
	}

	/***************************************************************************
	/* getDatosUsuario() carga los datos de: Identificación, NombreCompleto y correo del usuario.
	***************************************************************************/
	function getOptionsUsuarios(){
		$option = "";
		$usuario = getAllUsuarios();
		foreach ($usuario as $u) {
			$option .= "<option value='".$u['PK_Id_Persona']."'>".$u['VC_Primer_Nombre']." ".$u['VC_Segundo_Nombre']." ".$u['VC_Primer_Apellido']." ".$u['VC_Segundo_Apellido']."</option>";
		}
		return $option;
	}

	/***************************************************************************
	/* getTableLoginUsuario() consulta la tabla de auditoria de logins de inicio de sesión de un usuario especifico en el SICLAN
	***************************************************************************/
	function getTableLoginUsuario($id_usuario,$mes_anio){
		$return = "";
		$log = getLoginsUsuario($id_usuario,$mes_anio);
		foreach ($log as $l) {
			$return .= "<tr>";
			$return .= "<td>".$l['DT_fecha_ingreso']."</td>";
			$return .= "<td>".$l['TX_dispositivo']."</td>";
			$return .= "<td>".$l['TX_IP']."</td>";
			$return .= "</tr>";
		}
		return $return;
	}

	/***************************************************************************
	/* getOptionsClan() consulta en formato option para un select los datos de los clan que existen en el sistema.
	***************************************************************************/
	function getOptionsClan(){
		$return = "";
		$clan = getClanes();
		foreach ($clan as $c) {
			$return .= "<option value='".$c['PK_Id_Clan']."'>".$c['VC_Nom_Clan']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getOptionsGrupoArteEscuela() retorna en formato option los grupos de arte en la escuela que pertenecen a un clan especifico
	***************************************************************************/
	function getOptionsGrupoArteEscuela($id_clan){
		$return = "<optgroup label='Arte en la escuela'>";
		$grupo = getGruposByClanArteEscuela($id_clan);
		foreach ($grupo as $g) {
			$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='arte_escuela'>AE-".$g['PK_Grupo']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getOptionsGrupoEmprendeClan() retorna en formato option los grupos de emprende clan que pertenecen a un clan especifico
	***************************************************************************/
	function getOptionsGrupoEmprendeClan($id_clan){
		$return = "<optgroup label='Emprende Clan'>";
		$grupo = getGruposByClanEmprendeClan($id_clan);
		foreach ($grupo as $g) {
			$return .= "<option value='".$g['PK_Grupo']."' data-tipo_grupo='emprende_clan'>EC-".$g['PK_Grupo']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getTableLogGrupo() retorna las filas y columnas para la tabla que muestra los log de acciones realizadas en las tablas relacionadas a los grupos.
	***************************************************************************/
	function getTableLogGrupo($mes_anio,$id_clan,$id_grupo,$tipo_grupo){
		$return = "";
		$log_grupo = getLogGrupo($id_grupo,$mes_anio,$tipo_grupo);
		foreach ($log_grupo as $l) {
			$antes = json_decode($l['antes'],true);
			$mostrar_antes = "";
			if(json_last_error() != 0){
				$mostrar_antes = $l['antes'];
			}else{
				if (!empty($antes)){
					foreach ($antes as $key => $value) {
						$mostrar_antes .= "<b>".$key."</b>"." => ".$value."<br>";
					}
				}
			}
			$ahora = json_decode($l['ahora'],true);
			$mostrar_ahora = "";
			if (json_last_error() != 0){
				$mostrar_ahora = $l['ahora'];
			}else{
				if(!empty($ahora)){
					foreach ($ahora as $key => $value) {
						$mostrar_ahora .= "<b>".$key."</b>"." => ".$value."<br>";
					}
				}
			}

			$return .= "<tr>";
				$return .= "<td>".$l['tabla']."</td>";
				$return .= "<td class='bg-info'>".$mostrar_antes."</td>";
				$return .= "<td class='bg-success'>".$mostrar_ahora."</td>";
				$return .= "<td>".$l['fecha']."</td>";
			$return .= "</tr>";
		}
		return $return;
	}