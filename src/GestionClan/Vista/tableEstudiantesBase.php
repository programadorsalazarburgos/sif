<?php
$return = "";
$dato = $this->getVariables();
$tipo_grupo_acronimo = array('arte_escuela' => 'AE','emprende_clan'=>'EC','laboratorio_clan'=>'LC');
foreach ($dato['estudiante'] as $e) {
	switch ($dato['tipo_mostrar']) {
		case 'consulta_estudiante_tb_estudiante':
			$id_grupo = $dato['id_grupo'];
			$estudiante_grupo = $dato['estudiante_grupo'];
			$return .= "<tr>";
			$return .= "<td>".$e['IN_Identificacion_Estudiante']."</td>";
			$return .= "<td>".$e['NOMBRE']."</td>";
			$return .= "<td>".$e['VC_Descripcion_Grado']."</td>";
			$return .= "<td>".$e['VC_Nom_Colegio']."</td>";
			$return .= "<td>";
			if($estudiante_grupo[$e['id']] && $dato['tipo_grupo_atencion'] != "Emprende - Vacacional"){
				$return .= "<a class='eventoClic btn btn-info'>En grupo ".$estudiante_grupo[$e['id']]."</a>";
			}else{
				$return .= "<a class='cargar_datos_estudiante eventoClic btn btn-success' data-id_grupo ='".$id_grupo."' data-id_estudiante='".$e['id']."' data-identificacion_beneficiario='".$e['IN_Identificacion_Estudiante']."' data-nombre_estudiante='".$e['NOMBRE']."' data-tipo_origen='historico_crea' href='#'>Cargar Datos<sup><b>Historico CREA</b></sup></a>";
			}
			$return .= "</td>";
			$return .= "</tr>";
			break;
		case 'ensamble':
			$return .= "<tr>";
			$return .= "<td>".$e['IN_Identificacion']."</td>";
			$return .= "<td>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']."</td>";
			$return .= "<td>".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']."</td>";
			$return .= '<td><a title="Asignar a grupo ensamble" href="#" type="button" class="eventoClic btn btn-info asignar_estudiante_grupo_ensamble" data-id_estudiante="'.$e['id'].'" aria-label="Asignar">
				<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
				</a></td>';
			$return .= "</tr>";
			break;
		case 'remover':
			$return .= "<tr>";
			$return .= "<td>".$e['IN_Identificacion']."</td>";
			$return .= "<td>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']." ".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']."</td>";
			$return .= "<td>".$e['DT_fecha_ingreso']."</td>";
			// $return .= '<td><a title="Remover estudiante del grupo" href="#" type="button" class="eventoClic btn btn-danger remover_estudiante_grupo" data-id_grupo="'.$dato['id_grupo'].'" data-id_estudiante="'.$e['id'].'" data-nombre_estudiante="'.$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']." ".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre'].'" aria-label="Remover">
			// 	<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
			// 	</a></td>';
			$return .= '<td><input data-toggle="toggle" data-onstyle="danger" name= "CH_remover_estudiante[]" data-offstyle="success" data-on="SI" data-off="NO" type="checkbox" data-id_grupo="'.$dato['id_grupo'].'" data-id_estudiante='.$e['id'].' class="remover_estudiante_grupo_masivo"></td>';
			$return .= "</tr>";
			break;
		case 'asignar_evento':
			$return .= "<tr>";
			$return .= "<td>".$e['IN_Identificacion']."</td>";
			$return .= "<td>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']." ".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']."</td>";
			if(!isset($dato['estudiante_en_evento'][$e['id']])){
				$return .= '<td><a title="Asignar al evento" href="#" type="button" class="eventoClic btn btn-success asignar_estudiante_evento_desde_grupo" data-id_estudiante="'.$e['id'].'" data-id_evento="'.$dato['id_evento'].'" aria-label="Asignar">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				</a></td>';
			}else{
				$return .= '<td><a title="Ya está en este evento" href="#" type="button" class="eventoClic btn btn-warning" data-id_estudiante="'.$e['id'].'" aria-label="Ya está en este evento">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				</a></td>';
			}
			$return .= "</tr>";
			break;
		case 'datos_estudiante':
			$return .= "<tr>";
			$return .= "<td>".$e['tipo_identificacion_descripcion']."</td>";
			$return .= "<td>".$e['IN_Identificacion']."</td>";
			$return .= "<td>".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']."</td>";
			$return .= "<td>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']."</td>";
			$return .= "<td>".$e['DD_F_Nacimiento']."</td>";

			$tiempo = strtotime($e['DD_F_Nacimiento']); 
		    $ahora = time(); 
		    $edad = ($ahora-$tiempo)/(60*60*24*365.25); 
		    $edad = floor($edad); 


			$return .= "<td>".$edad."</td>";
			$return .= "<td>".($e['CH_Genero'] == "F" ? "Femenino" : "Masculino")."</td>";
			$return .= "<td>".$e['VC_Correo']."</td>";
			$return .= "<td>".$e['VC_Direccion']."</td>";
			$return .= "<td>".$e['VC_Telefono']."</td>";
			$return .= "<td>".$e['VC_Celular']."</td>";
			$return .= "<td>".$e['VC_Nom_Clan']."</td>";
			if (isset($e['VC_Nom_Colegio'])){
				$return .= "<td>".$e['VC_Nom_Colegio']."</td>";
			}
			else{				
				$return .= "<td></td>";
			}

			$return .= "<td>".$e['grado_descripcion']."</td>";
			$return .= "<td>".$e['jornada_descripcion']."</td>";
			$return .= "<td>".$e['NOMBRE_ACUDIENTE']."</td>";
			$return .= "<td>".$e['IDENTIFICACION_ACUDIENTE']."</td>";
			$return .= "<td>".$e['TELEFONO_ACUDIENTE']."</td>";
			$return .= "<td>".$e['grupo_poblacional_descripcion']."</td>";
			$return .= "<td>".$e['eps_descripcion']."</td>";
			$return .= "<td>".$e['TX_Tipo_Afiliacion']."</td>";
			$return .= "<td>".($e['FK_RH'] == "0" ? "" : $e['FK_RH'] == "0")."</td>";
			$return .= "<td>".$e['TX_Enfermedades']."</td>";
			$return .= "<td>".$e['localidad_descripcion']."</td>";
			$return .= "<td>".$e['TX_Barrio']."</td>";
			$return .= "<td>".$e['poblacion_victima_descripcion']."</td>";
			$return .= "<td>".$e['tipo_discapacidad_descripcion']."</td>";
			$return .= "<td>".$e['etnia_descripcion']."</td>";
			$return .= "<td>".$e['IN_estrato']."</td>";
			$return .= "<td>".$tipo_grupo_acronimo[$dato['tipo_grupo']]."-".$e['FK_Grupo']."</td>";
			$return .= "<td>".$e['VC_Nom_Area']."</td>";
			$return .= "<td>".$e['fecha_ingreso']."</td>";
			$return .= "<td>"."<center><button class='btn btn-warning'>".($e['estado'] ? "Activo" : "Inactivo")."</button></center></td>";
			$return .= "</tr>";
			break;
		case 'consultar_para_editar':
			$return .= "<tr>";
			$return .= "<td>".$e['IN_Identificacion_Estudiante']."</td>";
			$return .= "<td>".$e['NOMBRE']."</td>";
			$return .= "<td>".$e['VC_Nom_Colegio']."</td>";
			$return .= "<td>".$e['VC_Descripcion_Grado']."</td>";
			$return .= "<td><a class='eventoClic btn btn-info cargar_datos_estudiante' data-id_estudiante='".$e['id']."' data-tipo_estudiante='".$e['VC_Tipo_Estudiante']."'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span> Seleccionar Beneficiario</a></td>";
			$return .= "</tr>";
			break;
		case 'consultar_para_auditoria':
			$return .= "<tr>";
			$return .= "<td>".$e['IN_Identificacion_Estudiante']."</td>";
			$return .= "<td>".$e['NOMBRE']."</td>";
			$return .= "<td>".$e['VC_Nom_Colegio']."</td>";
			$return .= "<td>".$e['VC_Descripcion_Grado']."</td>";
			$return .= "<td><a class='eventoClic cargar_datos_estudiante_auditoria' data-id_estudiante='".$e['id']."'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>";
			$return .= "</tr>";
			break;
		case 'administrado_por_usuario_a_grupo':
			$return .= "<tr>";
			$return .= "<td>".$e['IN_Identificacion']."</td>";
			$return .= "<td>".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']."</td>";
			$return .= "<td>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']."</td>";
			$return .= "<td>".(($dato['tipo_accion'] == 'asignacion') ? $e['DT_fecha_ingreso'] : $e['DT_fecha_retiro'])."</td>";
			$return .= "<td>".$e['FK_grupo']."</td>";
			$return .= "<td>".$e['tipo_grupo']."</td>";
			$return .= "<td>".$e['TX_observaciones']."</td>";
			$return .= "<td>"."<center><button class='btn btn-warning'>".($e['estado'] ? "Activo" : "Inactivo")."</button></center></td>";
			$return .= "</tr>";
			break;
		case 'administrado_por_usuario_creacion':
			$return .= "<tr>";
			$return .= "<td>".$e['IN_Identificacion']."</td>";
			$return .= "<td>".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']."</td>";
			$return .= "<td>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']."</td>";
			$return .= "<td>".$e['DA_Fecha_Registro']."</td>";
			$return .= "<td>".$e['VC_Direccion']."</td>";
			$return .= "<td>".$e['VC_Telefono']."</td>";
			$return .= "</tr>";
			break;
		case 'consulta_beneficiario_tb_nidos':
			$id_grupo = $dato['id_grupo'];
			$nombre_beneficiario_nidos = $e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']." ".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido'];
			//$estudiante_grupo = $dato['estudiante_grupo'];
			$return .= "<tr>";
			$return .= "<td>".$e['VC_Identificacion']."</td>";
			$return .= "<td>".$nombre_beneficiario_nidos."</td>";
			$return .= "<td></td>";
			$return .= "<td></td>";
			$return .= "<td>";
			// if($estudiante_grupo[$e['id']] && $dato['tipo_grupo_atencion'] != "Emprende - Vacacional"){
			// 	$return .= "<a class='eventoClic btn btn-warning' href='#'>En grupo ".$estudiante_grupo[$e['id']]."</a>";
			// }else{
				$return .= "<a class='cargar_datos_estudiante eventoClic btn btn-success' data-id_grupo ='".$id_grupo."' data-id_estudiante='".$e['VC_Identificacion']."' data-identificacion_beneficiario='".$e['VC_Identificacion']."'  data-nombre_estudiante='".$nombre_beneficiario_nidos."' data-tipo_origen='historico_nidos' data-tipo_documento='".$e['FK_Tipo_Identificacion']."' data-primer_nombre='".$e['VC_Primer_Nombre']."' data-segundo_nombre='".$e['VC_Segundo_Nombre']."' data-primer_apellido='".$e['VC_Primer_Apellido']."' data-segundo_apellido='".$e['VC_Segundo_Apellido']."' data-fecha_nacimiento='".$e['DD_F_Nacimiento']."' data-genero='".$e['FK_Id_Genero']."' data-id_grupo_poblacional = '".$e['IN_Grupo_Poblacional']."' data-estrato='".$e['IN_Estrato']."' href='#'>Cargar Datos<sup><b>Historico NIDOS</b></sup></a>";
			//}
			$return .= "</td>";
			$return .= "</tr>";
			break;
		default:
			$return = "no valido: ".$dato['tipo_mostrar'];
			break;
	}
}
echo $return;