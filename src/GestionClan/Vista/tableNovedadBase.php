<?php
$return = "";
$dato = $this->getVariables();
switch ($dato['tipo_mostrar']) {
	case 'novedades_reporte':
		$return="<table class='table' id='table_novedad'>
							<thead>
								<tr>
									<th>Fecha Sesión</th>
									<th>Asistencia</th>
									<th>Novedad</th>
									<th>Observación</th>
								</tr>
							</thead>
							<tbody>";
		foreach ($dato['novedad'] as $n) {
			$return .= "<tr>";
			$return .= "<td>".$n['DA_fecha_sesion_clase']."</td>";
			$return .= "<td>".$n['IN_asistencia']."</td>";
			$return .= "<td>".$n['VC_Descripcion']."</td>";
			$return .= "<td>".$n['TX_observacion']."</td>";
			$return .= "</tr>";
		}
		$return .="</tbody>
						</table>";		
		break;
	case 'historial_novedades_grupo':
		foreach ($dato['novedad'] as $n) {
			$return .= "<tr>";
			$return .= "<td>".$n['DA_fecha_sesion_clase']."</td>";
			$return .= "<td>".$n['VC_Primer_Apellido']." ".$n['VC_Segundo_Apellido']." ".$n['VC_Primer_Nombre']." ".$n['VC_Segundo_Nombre']."</td>";
			if($n['IN_asistencia'])
				$return .= "<td>SÍ<span class='glyphicon glyphicon-ok' aria-hidden='true'></span></td>";
			else
				$return .= "<td>NO<span class='glyphicon glyphicon-remove' aria-hidden='true'></span></td>";
			$return .= "<td>".$n['VC_Descripcion']."</td>";
			$return .= "<td>".$n['TX_observacion']."</td>";
			$return .= "<td>".$n['DT_fecha_registro']."</td>";
			$return .= "<td align='center'><button data-toggle='modal' data-target='#modal_editar_novedad' data-id_novedad='".$n['id']."' data-tipo_grupo='".$dato['tipo_grupo']."' data-in_asistencia='".$n['IN_asistencia']."' data-in_novedad='".$n['IN_novedad']."' data-observacion='".$n['TX_observacion']."' type='button' class='opciones_historial_novedad btn btn-primary' aria-label='Left Align'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span></button></td>";
			$return .= "</tr>";
		}
	break;
	default:
		$return .= "<b>Opcion no valida en tableNovedadBase</b>";
	break;
}
echo $return;