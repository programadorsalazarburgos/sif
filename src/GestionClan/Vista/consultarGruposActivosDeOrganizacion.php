<?php
$dia_semana = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
$id_organizacion = $this->getVariables()['id_organizacion'];
$tipo_grupo = $this->getVariables()['tipo_grupo'];
$horario = $this->getVariables()['horario'];
$clan_zona_array = $this->getVariables()['clan_zona_array'];
$return = "";
$dato_especifico_linea_atencion = "";
$acronimo_linea_atencion = "";
foreach ($this->getVariables()['grupo'] as $g) {
	switch ($tipo_grupo) {
		case 'arte_escuela':
			$acronimo_linea_atencion = "AE";
			$dato_especifico_linea_atencion = "<td>".$g['Vc_Nom_Colegio']."</td>";
			break;
		case 'emprende_clan':
			$acronimo_linea_atencion = "EC";
			$dato_especifico_linea_atencion = "<td>".$g['VC_Nom_Modalidad']."</td>";
			break;
		case 'laboratorio_clan':
			$acronimo_linea_atencion = "LC";
			$dato_especifico_linea_atencion = "<td>".$g['VC_Nombre_Lugar']."</td>";
			$dato_especifico_linea_atencion .= "<td>".$g['tipo_poblacion']."</td>";
			break;
		default:
			$dato_especifico_linea_atencion = "";
			break;
	}
	$return .= "<tr>";
	$tipo_grupo_text = "";
	switch($g["estado"]){
		case '1':
			$tipo_grupo_text="<span class='label label-success'>Activo</span>";
		break;
		case '2':
			$tipo_grupo_text="<span class='label label-warning'>Pregrupo</span>";
		break;
		case '0':
			$tipo_grupo_text="<span class='label label-danger'>Inactivo</span>";
		break;
		default:
		$tipo_grupo_text="<span class='label label-info'>nn</span>";
			break;
	}
	$return .= "<td>".$acronimo_linea_atencion."-".$g['PK_Grupo']."<br>".$tipo_grupo_text."</td>";
	$return .= "<td>".$clan_zona_array[$g['FK_clan']]."</td>";
	$return .= "<td>".$g['VC_Nom_Clan']."</td>";
	$return .= "<td>".$g['VC_Nom_Area']."</td>";
	$return .= $dato_especifico_linea_atencion;
	$return .= "<td>".$g['VC_Primer_Apellido']." ".$g['VC_Segundo_Apellido']." ".$g['VC_Primer_Nombre']." ".$g['VC_Segundo_Nombre']."</td>";
	$return .= "<td>".$g['DT_fecha_creacion']."</td>";
	$return .= "<td>";
	foreach ($horario[$g['PK_Grupo']] as $h) {
		$return .= $dia_semana[$h['IN_dia'] - 1]." de ".$h['TI_hora_inicio_clase']." a ".$h['TI_hora_fin_clase']."<br>";
	}
	$return .= "</td>";
	$return .= "<td>".$g['TX_observaciones']."</td>";
	if(empty($g['FK_artista_formador'])){
		$return .= "<td><a href='#' data-toggle='modal' data-target='#modal_buscar_artista_formador' class='asignar_artista_formador_grupo_".$tipo_grupo." btn btn-success' data-id_organizacion='".$id_organizacion."' data-id_grupo='".$g['PK_Grupo']."'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span>Asignar Artista Formador</a></td>";
	}else{
		$return .= "<td><a href='#' data-toggle='modal' data-target='#modal_buscar_artista_formador' class='asignar_artista_formador_grupo_".$tipo_grupo." btn btn-warning' data-id_organizacion='".$id_organizacion."' data-id_grupo='".$g['PK_Grupo']."'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>Cambiar Artista Formador</a>";
		$return.="<a class='btn btn-danger quitar_artista' data-id_grupo='".$g['PK_Grupo']."' data-tipo_grupo='".$tipo_grupo."' href='#' title='Quitar Artista'><span class='glyphicon glyphicon-minus' aria-hidden='true'></span>Quitar Artista</a></td>";
	}
	$return .= "</tr>";
}
echo $return;