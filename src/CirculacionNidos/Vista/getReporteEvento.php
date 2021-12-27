<?php
$return = "";
foreach ($this->getVariables()['Datos'] as $d){
	$return.="<tr>";

	$return.="<td>".$d["DT_Fecha_Evento"]."</td>";
	$return.="<td>".$d["VC_Nombre_Evento"]."</td>";
	$return.="<td>".$d["VC_Nombre_Lugar"]."</td>";
	if($this->getVariables()['id_usuario'] == ""){
		$return.="<td>".$d["EQUIPOSASIGNADOS"]."</td>";
	}
	$return.="<td>".$d["Vc_Descripcion"]."</td>";
	$return.="<td>".$d["VC_Nom_Localidad"]."</td>";
	$return.="<td>".$d["UPZ"]."</td>";
	$return.="<td>".$d["VC_Barrio"]."</td>";
	$return.="<td>".$d["MODALIDADATENCION"]."</td>";
	$return.="<td>".$d["IN_Num_Artistas"]."</td>";
	$return.="<td>".$d["IN_Num_Grupos"]."</td>";
	$return.="<td>".$d["IN_Experiencias"]."</td>";
	$return.="<td>".$d["IN_Cuidadores"]."</td>";

	$return.="<td>".$d["NINOS_DE_0_3_ANIOS_N"]."</td>";
	$return.="<td>".$d["NINAS_DE_0_3_ANIOS_N"]."</td>";
	$return.="<td>".$d["TOTAL_DE_0_3_ANIOS_N"]."</td>";
	$return.="<td>".$d["NINOS_DE_4_6_ANIOS_N"]."</td>";
	$return.="<td>".$d["NINAS_DE_4_6_ANIOS_N"]."</td>";
	$return.="<td>".$d["TOTAL_DE_4_6_ANIOS_N"]."</td>";
	$return.="<td>".$d["NINOS_FUERA_RANGO_N"]."</td>";
	$return.="<td>".$d["NINAS_FUERA_RANGO_N"]."</td>";
	$return.="<td>".$d["TOTAL_NINOS_FUERA_RANGO_N"]."</td>";
	$return.="<td>".$d["GESTANTES_N"]."</td>";
	$return.="<td>".$d["TOTAL_N"]."</td>";

	$return.="<td>".$d["CAMPESINA_N"]."</td>";
	$return.="<td>".$d["INDIGENA_N"]."</td>";
	$return.="<td>".$d["AFRODESCENDIENTE_N"]."</td>";
	$return.="<td>".$d["ROM_N"]."</td>";
	$return.="<td>".$d["RAIZALES_N"]."</td>";
	$return.="<td>".$d["PALENQUERA_N"]."</td>";
	$return.="<td>".$d["COMUNIDADES_NEGRAS_N"]."</td>";
	$return.="<td>".$d["POBLACION_CARCELARIA_N"]."</td>";
	$return.="<td>".$d["DISCAPACIDAD_N"]."</td>";
	$return.="<td>".$d["PERSONAS_HABITANTES_CALLE_N"]."</td>";
	$return.="<td>".$d["PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_N"]."</td>";
	$return.="<td>".$d["POBLACION_VICTIMA_CONFLICTO_N"]."</td>";
	$return.="<td>".$d["DESPLAZAMIENTO_N"]."</td>";
	$return.="<td>".$d["MIGRANTES_N"]."</td>";
	$return.="<td>".$d["DETERIORO_URBANO_N"]."</td>";
	$return.="<td>".$d["EMERGENCIA_SOCIAL_N"]."</td>";
	$return.="<td>".$d["LGBTIQ_N"]."</td>";
	$return.="<td>".$d["TOTAL_EN_N"]."</td>";

	$return.="<td>".$d["NINOS_DE_0_3_ANIOS_S"]."</td>";
	$return.="<td>".$d["NINAS_DE_0_3_ANIOS_S"]."</td>";
	$return.="<td>".$d["TOTAL_DE_0_3_ANIOS_S"]."</td>";
	$return.="<td>".$d["NINOS_DE_4_6_ANIOS_S"]."</td>";
	$return.="<td>".$d["NINAS_DE_4_6_ANIOS_S"]."</td>";
	$return.="<td>".$d["TOTAL_DE_4_6_ANIOS_S"]."</td>";
	$return.="<td>".$d["NINOS_DE_6_10_ANIOS_S"]."</td>";
	$return.="<td>".$d["NINAS_DE_6_10_ANIOS_S"]."</td>";
	$return.="<td>".$d["TOTAL_NINOS_DE_6_10_ANIOS_S"]."</td>";
	$return.="<td>".$d["GESTANTES_S"]."</td>";
	$return.="<td>".$d["TOTAL_S"]."</td>";

	$return.="<td>".$d["NINOS_DE_0_3_ANIOS_R"]."</td>";
	$return.="<td>".$d["NINAS_DE_0_3_ANIOS_R"]."</td>";
	$return.="<td>".$d["TOTAL_DE_0_3_ANIOS_R"]."</td>";
	$return.="<td>".$d["NINOS_DE_4_6_ANIOS_R"]."</td>";
	$return.="<td>".$d["NINAS_DE_4_6_ANIOS_R"]."</td>";
	$return.="<td>".$d["TOTAL_DE_4_6_ANIOS_R"]."</td>";
	$return.="<td>".$d["NINOS_FUERA_RANGO_R"]."</td>";
	$return.="<td>".$d["NINAS_FUERA_RANGO_R"]."</td>";
	$return.="<td>".$d["TOTAL_NINOS_FUERA_RANGO_R"]."</td>";
	$return.="<td>".$d["GESTANTES_R"]."</td>";
	$return.="<td>".$d["TOTAL_R"]."</td>";

	$return.="<td>".$d["CAMPESINA_R"]."</td>";
	$return.="<td>".$d["INDIGENA_R"]."</td>";
	$return.="<td>".$d["AFRODESCENDIENTE_R"]."</td>";
	$return.="<td>".$d["ROM_R"]."</td>";
	$return.="<td>".$d["RAIZALES_R"]."</td>";
	$return.="<td>".$d["PALENQUERA_R"]."</td>";
	$return.="<td>".$d["COMUNIDADES_NEGRAS_R"]."</td>";
	$return.="<td>".$d["POBLACION_CARCELARIA_R"]."</td>";
	$return.="<td>".$d["DISCAPACIDAD_R"]."</td>";
	$return.="<td>".$d["PERSONAS_HABITANTES_CALLE_R"]."</td>";
	$return.="<td>".$d["PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_R"]."</td>";
	$return.="<td>".$d["POBLACION_VICTIMA_CONFLICTO_R"]."</td>";
	$return.="<td>".$d["DESPLAZAMIENTO_R"]."</td>";
	$return.="<td>".$d["MIGRANTES_R"]."</td>";
	$return.="<td>".$d["DETERIORO_URBANO_R"]."</td>";
	$return.="<td>".$d["EMERGENCIA_SOCIAL_R"]."</td>";
	$return.="<td>".$d["LGBTIQ_R"]."</td>";
	$return.="<td>".$d["TOTAL_EN_R"]."</td>";
	$return.="<td>".$d["OBSERVACION_S"]."</td>";
	$return.= $d["LISTADO_ASISTENCIA"] == "" ? "<td><button class='btn btn-block btn-default' disabled>Ver</button></td>" : "<td><a href='".$d["LISTADO_ASISTENCIA"]."' class='btn btn-block btn-info' target='_blank'>Ver</a></td>";

	if($this->getVariables()['id_usuario'] == ""){
		$return .= $d["IN_Aprobacion"] == 0 ? "<td><button type='button' class='btn btn-block btn-success aprobar' data-estado='1' data-texto='aprobar' data-id-evento='".$d["Pk_Id_Evento"]."'>Aprobar</button></td>" : "<td><button type='button' class='btn btn-block btn-danger aprobar' data-estado='0' data-texto='desaprobar' data-id-evento='".$d["Pk_Id_Evento"]."'>Desaprobar</button></td>";
	}else{
		$return .= $d["IN_Aprobacion"] == 0 ? "<td><span class='label label-danger'>No aprobado</span>" : "<td><span class='label label-success'>Aprobado</span></td>";
	}
	
	$return.="</tr>";
}

echo $return;