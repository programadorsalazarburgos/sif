<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/Administracion/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'get_solicitudes_pendientes':
				echo getSolicitudesPendientes();
				break;
			case 'guardar_solucion_soporte':
				echo guardarSolucionSoporte($_POST['id_persona'],$_POST['fecha_creacion'],$_POST['solucion']);
				break;
			default:
				echo "opcion no valida en solicitudSoporte: (".$_POST['opcion'].")";
				break;
		}
	}

	/***************************************************************************
	/* getSolicitudesPendientes() consulta las solicitudes pendientes por solucionar
	***************************************************************************/
	function getSolicitudesPendientes(){
		$return = "";
		$soporte = getSoportesSinSolucinar();
		foreach ($soporte as $s) {
			$return .= "<tr>";
			$return .= "<td>".$s['DT_fecha_creacion']."</td>";
			$return .= "<td>".$s['VC_descripcion']."</td>";
			$return .= "<td>".$s['TX_solicitud']."</td>";
			$return .= "<td>".$s['VC_Primer_Apellido']." ".$s['VC_Segundo_Apellido']." ".$s['VC_Primer_Nombre']." ".$s['VC_Segundo_Nombre']."</td>";
			$return .= "<td><a href='#' class='solucionar_soporte btn btn-info' data-id_persona='".$s['FK_persona']."' data-fecha_creacion='".$s['DT_fecha_creacion']."' data-texto_solicitud='".$s['TX_solicitud']."' data-toggle='modal' data-target='#modal_solucion_soporte'>Solucionar Soporte</a></td>";
			$return .= "</tr>";
		}
		return $return;
	}

	/***************************************************************************
	/* guardarSolucionSoporte() actualiza la solución de un soporte.
	***************************************************************************/
	function guardarSolucionSoporte($id_persona,$fecha_creacion,$solucion){
		return saveSolucionSoporte($id_persona,$fecha_creacion,$solucion);
	}
?>