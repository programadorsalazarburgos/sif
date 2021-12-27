<?php
$return = "";
foreach ($this->getVariables()['beneficiarios'] as $b){
	$fecha_evento = DateTime::createFromFormat("Y-m-d", $b['fecha_evento']);
	$fecha_nacimiento = DateTime::createFromFormat("Y-m-d", $b['fecha_nacimiento_calculo']);
	$edad = $fecha_evento->diff($fecha_nacimiento);

	$return .="<tr>";
	$return .= "<td>".$b['atendido']."</td>";
	$return .="<td>";
	if($edad->y == 1){
		$return .=$edad->y. " año ";
	}
	if($edad->y > 1){
		$return .=$edad->y. " años ";
	}
	if($edad->m == 1){
		$return .= $edad->m." mes ";
	}
	if($edad->m > 1){
		$return .= $edad->m." meses ";
	}
	if($edad->d == 1){
		$return .= $edad->d." día";
	}
	if($edad->d > 1){
		$return .= $edad->d." días";
	}
	$return .="</td>";

	if($edad->y >= 0 && $edad->y < 4){
		if($b['genero'] == "MASCULINO"){
			$return .= "<td>Niño de 1 mes a 3 años</td>";
		}else{
			$return .= "<td>Niña de 1 mes a 3 años</td>";
		}
	}
	if($edad->y >= 4 && $edad->y < 6){
		if($b['genero'] == "MASCULINO"){
			$return .= "<td>Niño de 4 años a 5 años</td>";
		}else{
			$return .= "<td>Niña de 4 años a 5 años</td>";
		}
	}
	if($edad->y >= 6 && $edad->y < 12){
		if($b['genero'] == "MASCULINO"){
			$return .= "<td>Niño fuera del rango de edad</td>";
		}else{
			$return .= "<td>Niña fuera del rango de edad</td>";
		}
	}
	if($edad->y >= 12){
		if($b['genero'] == "MASCULINO"){
			$return .= "<td>Niño fuera del rango de edad</td>";
		}else{
			$return .= "<td>Madre gestante</td>";
		}
	}

	$return .= "<td>".$b['fecha_nacimiento']."</td>";
	$return .= "<td>".$b['genero']."</td>";
	$return .= "<td>".$b['enfoque']."</td>";
	$return .= "<td>".$b['identificacion']."</td>";
	$return .= "<td>".$b['primer_nombre']."</td>";
	$return .= "<td>".$b['segundo_nombre']."</td>";
	$return .= "<td>".$b['primer_apellido']."</td>";
	$return .= "<td>".$b['segundo_apellido']."</td>";
	$return .= "<td>".$b['tipo_identificacion']."</td>";
	$return .= "<td>".$b['nivel']."</td>";
	$return .= "<td>".$b['estrato']."</td>";
	$return .= "<td>".$b['lugar_atencion']."</td>";
	$return .="</tr>";
}
echo $return;