<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/Administracion/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'get_datos_usuario':
				echo getDatosUsuarioById($_POST['id_usuario']);
				break;
			case 'get_tipo_soporte':
				echo getOptionsTipoSoporte();
				break;
			case 'add_solicitud_soporte':
				echo addSolicitudSoporte($_POST['id_usuario'],$_POST['id_tipo_soporte'],$_POST['solicitud']);
				break;
			case 'get_historico_solicitudes':
				echo getHistoricoSolicitudes($_POST['id_usuario']);
				break;
			default:
				echo "opcion no valida en solicitudSoporte: (".$_POST['opcion'].")";
				break;
		}
	}

	/***************************************************************************
	/* getDatosUsuario() carga los datos de: Identificación, NombreCompleto y correo del usuario.
	***************************************************************************/
	function getDatosUsuarioById($id_usuario){
		$dato = array(
			'VC_Identificacion' => '12345',
			'VC_Primer_Nombre' => 'Pepito',
			'VC_Segundo_Nombre' => 'Andres',
			'VC_Primer_Apellido' => 'Perez',
			'VC_Segundo_Apellido' => 'Fin',
			'VC_Correo' => 'asd@asd.com'.$id_usuario
		);
		$dato = getDatosPerfil($id_usuario)[0];
		$d = array(
			'identificacion' => $dato['VC_Identificacion'],
			'nombre' => $dato['VC_Primer_Nombre'].' '.$dato['VC_Segundo_Nombre'].' '.$dato['VC_Primer_Apellido'].' '.$dato['VC_Segundo_Apellido'],
			'correo' => $dato['VC_Correo']
		);
		return json_encode($d);
	}

	/***************************************************************************
	/* getOptionsTipoSoporte() retorna los option de los tipo soporte que existen.
	***************************************************************************/
	function getOptionsTipoSoporte(){
		$return = "";
		$tipo_soporte = getTipoSoporte();
		foreach ($tipo_soporte as $ts){
			$return .= "<option value='".$ts['PK_tipo_soporte']."'>".$ts['VC_descripcion']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* addSolicitudSoporte() agrega una nueva solicitud de soporte
	***************************************************************************/
	function addSolicitudSoporte($id_usuario,$id_tipo_soporte,$solicitud){
		return saveNewSoporte($id_usuario,$id_tipo_soporte,$solicitud);
	}

	/***************************************************************************
	/* getHistoricoSolicitudes() busca el historico de todas las solicitudes que ha realizado el usuario.
	***************************************************************************/
	function getHistoricoSolicitudes($id_usuario){
		$return = "";
		$soporte = getHistoricoSoportesByPersona($id_usuario);
		foreach ($soporte as $s){
			$return .= "<tr>";
			$return .= "<td>".$s['DT_fecha_creacion']."</td>";
			$return .= "<td>".$s['VC_descripcion']."</td>";
			$return .= "<td>".$s['TX_solicitud']."</td>";
			if($s['estado'] == 0){
				$return .= "<td><a href='#' class='btn btn-danger'><span class='glyphicon glyphicon-time' aria-hidden='true'></span>  En espera</a></td>";
			}else if($s['estado'] == 1){
				$return .= "<td><a href='#' class='btn btn-success'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span>  Solucionado</a></td>";
			}
			$return .= "<td>".$s['TX_solucion']."</td>";
			$return .= "<td>".$s['DT_fecha_solucion']."</td>";
			$return .= "</tr>";
		}
		return $return;
	}
?>