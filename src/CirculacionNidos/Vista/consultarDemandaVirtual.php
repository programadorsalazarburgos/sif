<?php
$return = "";
foreach ($this->getVariables()['oferta'] as $o){

	if($o["FORMULARIO"] == "Arn" || $o["FORMULARIO"] == "Aulas hospitalarias"){
		$data_horario = "No aplica";
		$data_fecha = (is_null($o['FECHA_FORMULARIO_SIN_HORARIO']) || $o['FECHA_FORMULARIO_SIN_HORARIO'] == '') ? 'Sin asignar': $o['FECHA_FORMULARIO_SIN_HORARIO'];
	}else{
		$data_horario = $o['INICIO']." a ".$o['FIN'];
		$data_fecha = $o['FECHA_FORMULARIO_CON_HORARIO'];
	}

	if(is_null($o["DIRECCION"]) || $o["DIRECCION"] == "") {
		$o["DIRECCION"] = "Sin información";
	}

	$return .="<tr>";
	$return .="<td>".$data_fecha."</td>";
	$return .="<td>".$data_horario."</td>";
	$return .="<td>".$o['ATENCION']."</td>";
	$return .="<td>".$o['DIRIGIDA']."</td>";
	$return .="<td>".$o['CUIDADOR']."</td>";	  
	$return .="<td>".$o['NOMBRES']."</td>";
	$return .="<td>".$o['POBLACIONAL']."</td>";	  
	$return .="<td>".$o['COMENTARIOS']."</td>";
	$return .="<td>".$o['TELEFONO']."</td>";
	$return .="<td>".$o['NOMBREARTISTA']."</td>";
	$clase = is_null($o['ARTISTA']) ? 'btn-success' : 'btn-warning';
	$artista = is_null($o['ARTISTA']) ? 'Asignar Artista' : 'Cambiar Artista';

	$return .="<td><a href='#' class='asignarArtista btn btn-block ".$clase."' data-id-registro='".$o['IDREGISTRO']."' data-formulario='".$o['FORMULARIO']."' data-atencion='".$o['ATENCION']."' data-fecha='".$data_fecha."' data-horario='".$data_horario."' data-artista='".$o['ARTISTA']."' data-idlocalidad='".$o['IDLOCALIDAD']."' data-localidad='".$o['LOCALIDAD']."' data-idupz='".$o['IDUPZ']."' data-barrio='".$o['BARRIO']."' data-direccion='".$o['DIRECCION']."' data-toggle='modal' data-target='#miModalAsignarArtista'>".$artista."</a></td>"; 

	$return .="</tr>";
} 
echo $return;