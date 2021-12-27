<?php
$dato = $this->getVariables();
$acronimo_linea_atencion = array('arte_escuela' => 'AE','emprende_clan' => 'IC', 'laboratorio_clan' => 'CV');
$dias_semana = [''.'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
$return = "";
foreach ($dato['grupo'] as $d) {
	switch ($dato['tipo_mostrar']) {
		case 'cerrar_grupo':
			$return .= "<tr>";
			$return .= "<td>".$acronimo_linea_atencion[$dato['tipo_grupo']]."-".$d['PK_Grupo']."</td>";
			$return .= "<td>".$d['VC_Nom_Area']."</td>";
			$return .= "<td>".$d['VC_Primer_Apellido']." ".$d['VC_Segundo_Apellido']." ".$d['VC_Primer_Nombre']." ".$d['VC_Segundo_Nombre']."</td>";
			switch ($dato['tipo_grupo']) {
				case 'arte_escuela':
					$return .= "<td>".$d['VC_Nom_colegio']."</td>";
					break;
				case 'emprende_clan':
					$return .= "<td>".$d['VC_Nom_Modalidad']."</td>";
					break;
				case 'laboratorio_clan':
					//$return .= "<td>".$d['']."</td>";
					break;
				default:

					break;
			}
			$return .= '<td><a title="Cerrar grupo" href="#" data-toggle="modal" data-target="#modal_cerrar_grupo" type="button" class="btn btn-danger cerrar_grupo" data-id_grupo="'.$d['PK_Grupo'].'" data-tipo_grupo="'.$dato['tipo_grupo'].'" data-acronimo_linea_atencion="'.$acronimo_linea_atencion[$dato['tipo_grupo']].'" aria-label="Cerrar">
				<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cerrar
				</a></td>';
			$return .= "</tr>";
			break;
		case 'asignar_estudiante':
			$return .= "<tr>";
			$return .= "<td>".$acronimo_linea_atencion[$dato['tipo_grupo']]."-".$d['PK_Grupo']."</td>";
			$return .= "<td>".$d['VC_Nom_Area']."</td>";
			$return .= "<td>".$d['VC_Nom_Organizacion']."</td>";
			$return .= "<td>".$d['VC_Primer_Apellido']." ".$d['VC_Segundo_Apellido']." ".$d['VC_Primer_Nombre']." ".$d['VC_Segundo_Nombre']."</td>";
			switch ($dato['tipo_grupo']) {
				case 'arte_escuela':
					$return .= "<td>".$d['VC_Nom_colegio']."</td>";
					break;
				case 'emprende_clan':
					$return .= "<td>".$d['VC_Nom_Modalidad']."</td>";
					$return .= "<td>".$d['tipo_grupo']."</td>";
					break;
				case 'laboratorio_clan':
					$return .= "<td>".$d['VC_Nombre_Lugar']."</td>";
					$return .= "<td>".$d['tipo_poblacion']."</td>";
					break;
				default:

					break;
			}
			$return .= "<td>".$dato['total_estudiantes'][$d['PK_Grupo']]."</td>";
			$return .= "<td class='text-center'></div>";
				$return .= "<div class'btn-group' role='group' aria-label='Agregar Estudiante'><a href='#' data-toggle='modal' data-target='#modal_agregar_estudiante_grupo' class='add_estudiantes btn btn-success' data-tipo_grupo='".$dato['tipo_grupo']."' data-acronimo_linea_atencion=".$acronimo_linea_atencion[$dato['tipo_grupo']]." data-tipo_grupo_atencion='".$d['tipo_grupo']."' data-id_grupo='".$d["PK_Grupo"]."' title='Agregar Estudiantes'><i class='fas fa-user-plus'></i></a>";
			if($d['tipo_grupo'] == "Ensamble - Mixto" || $d['tipo_grupo'] == "CREA EN CASA"){
				$return .= "<a href='#' data-toggle='modal' data-target='#modal_agregar_estudiante_ensamble' class='add_estudiante_ensamble btn btn-warning' data-id_grupo='".$d['PK_Grupo']."' title='Agregar Estudiante Desde Grupo'><i class='fas fa-users'></i></a>";
			}
			$return .= "<a href='#' data-toggle='modal' data-target='#modal_remover_estudiante_grupo' class='remover_estudiantes btn btn-danger' title='Remover Estudiantes' data-tipo_grupo='".$dato['tipo_grupo']."' data-acronimo_linea_atencion=".$acronimo_linea_atencion[$dato['tipo_grupo']]." data-id_grupo='".$d["PK_Grupo"]."'><i class='fas fa-user-minus'></i></a>";
			$return .= "</div></td>";
			$return .= "</tr>";
			break;
		case 'asignar_organizacion':
			$return .= "<tr>";
			$return .= "<td>".$acronimo_linea_atencion[$dato['tipo_grupo']]."-".$d['PK_Grupo']."</td>";
			$return .= "<td>".$d['VC_Nom_Clan']."</td>";
			$return .= "<td>".$d['horario']; 
			/*foreach ($dato['horario_grupo'][$d['PK_Grupo']] as $h) {
				$return .= $dias_semana[$h['IN_dia']].' de '.$h['TI_hora_inicio_clase'].' a '.$h['TI_hora_fin_clase'].'<br>';
			}*/ 
			$return .= "</td>";
			$return .= "<td>".$d['VC_Nom_Area']."</td>";
			$return .= "<td>".$d['VC_Nom_Organizacion']."</td>";
			$return .= "<td>".$d['VC_Primer_Apellido']." ".$d['VC_Segundo_Apellido']." ".$d['VC_Primer_Nombre']." ".$d['VC_Segundo_Nombre']."</td>";
			switch ($dato['tipo_grupo']) {
				case 'arte_escuela':
					$return .= "<td>".$d['VC_Nom_colegio']."</td>";
					break;
				case 'emprende_clan':
					$return .= "<td>".$d['VC_Nom_Modalidad']."</td>";
					break;
				case 'laboratorio_clan':
					$return .= "<td>".$d['VC_Nombre_Lugar']."</td>";
					$return .= "<td>".$d['tipo_poblacion']."</td>";
					break;
				default:

					break;
			}
			if($d['VC_Nom_Organizacion'] == ""){
				$return .= "<td><a class='btn btn-success asignar_organizacion_grupo' data-toggle='modal' data-target='#modal_buscar_organizacion' data-id_grupo='".$d['PK_Grupo']."' data-tipo_grupo='".$dato['tipo_grupo']."' data-acronimo_linea_atencion='".$acronimo_linea_atencion[$dato['tipo_grupo']]."'>Asignar Organización</a></td>";
			}else{
				$return .= "<td><a class='btn btn-warning asignar_organizacion_grupo' data-toggle='modal' data-target='#modal_buscar_organizacion' data-id_grupo='".$d['PK_Grupo']."' data-tipo_grupo='".$dato['tipo_grupo']."' data-acronimo_linea_atencion='".$acronimo_linea_atencion[$dato['tipo_grupo']]."'>Cambiar Organización</a></td>";
			}
			break;
		case 'transicion':
			$horario = json_decode($d['horario_json']);
			$return .= "<tr>";
			$return .= "<td>".$d['id']."</td>";
			$return .= "<td>".$d['artista_crea']."</td>";
			$return .= "<td>".$d['artista_nidos']."</td>";
			$return .= "<td>".$d['TX_lugar_atencion']."</td>";
			$return .= "<td>";
			foreach ($horario as $h) {
				$return .= $dias_semana[intval($h->dia) - 1]." ".$h->hora_inicio." a ".$h->hora_fin."<br>";
				// $return .= json_encode($h);
			}
			$return .= "</td>";
			$return .= "<td align='center'>".$dato['total_estudiantes'][$d['id']]."</td>";
			$return .= "<td><a class='btn btn-success asignar_beneficiario_grupo' data-id_grupo='".$d['id']."' role='group' aria-label='Agregar Beneficiario' data-toggle='modal' data-target='#modal_agregar_estudiante_grupo'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span></a></td>";
			$return .= "</tr>";
			break;
		default:
			$return = "no valido:".$dato['tipo_mostrar'];
			break;
	}
}
echo $return;