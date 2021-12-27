<?php           
$return = "";
foreach ($this->getVariables()['oferta'] as $o){

	$color;

	if($o['ESTADO'] == 0){
		$color = "";
	}
	if($o['ESTADO'] == 1){
		$color = "style='background-color: #82FA58'";
	}
	if($o['ESTADO'] == 2){
		$color = "style='background-color: #FA5858'";
	}

	$return .="<tr>";
	$return .="<td ".$color.">". $o['IDREGISTRO']."</td>";
	$return .="<td ".$color.">". $o['FECHA']."</td>";
	$return .="<td ".$color.">". $o['HORARIO']."</td>";
	$return .="<td ".$color.">". $o['ATENCION']."</td>";
	$return .="<td ".$color.">". $o['DIRIGIDA']."</td>";
	$return .="<td ".$color.">". $o['LOCALIDAD']."</td>";
	$return .="<td ".$color.">". $o['UPZ']."</td>";
	$return .="<td ".$color.">". $o['BARRIO']."</td>";
	$return .="<td ".$color.">". $o['DIRECCION']."</td>";
	$return .="<td ".$color.">". $o['ESTRATO']."</td>";
	$return .="<td ".$color.">". $o['CUIDADOR']."</td>";
	$return .="<td ".$color.">". $o['IDENCUIDADOR']."</td>";
	$return .="<td ".$color.">". $o['CORREO']."</td>";
	$return .="<td ".$color.">". $o['EDADCUIDADOR']."</td>";
	$return .="<td ".$color.">". $o['PARENTESCO']."</td>";
	$return .="<td ".$color.">". $o['POTESTAD']."</td>";
	$return .="<td ".$color.">". $o['IDENTIFICACION']."</td>";
	$return .="<td ".$color.">". $o['NOMBRE']." ". $o['APELLIDOS']."</td>";	  
	$return .="<td ".$color.">". $o['FECHANACIMIENTO']."</td>";
	if($o["POTESTAD"] == "SI"){
		$fecha_llamada = DateTime::createFromFormat("Y-m-d", $o['FECHACALCULO']);
		$fecha_nacimiento = DateTime::createFromFormat("Y-m-d", $o['FECHANACIMIENTO']);
		$edad = $fecha_llamada->diff($fecha_nacimiento);

		$return .="<td ".$color. ">";
		if($edad->y < 1){
			$return .="menos de un año";
		}
		if($edad->y == 1){
			$return .=$edad->y. " año";
		}
		if($edad->y > 1){
			$return .=$edad->y. " años";
		}
		$return .="</td>";
	}else{
		$return .="<td ".$color. ">";
		if($o["EDADBENEFICIARIO"] == 1){
			$return .=$o["EDADBENEFICIARIO"]." año";
		}else{
			$return .=$o["EDADBENEFICIARIO"]." años";
		}
		$return .="</td>";
	}
	$return .="<td ".$color.">". $o['ENFOQUE']."</td>";	  
	$return .="<td ".$color.">". $o['INSTITUCION']."</td>";
	$return .="<td ".$color.">". $o['ENTIDAD']."</td>";
	$return .="<td ".$color.">". $o['TELEFONO']."</td>";
	$return .="<td ".$color.">". $o['COMENTARIOS']."</td>";
	$return .="<td ".$color.">". $o['AUTORIZACION']."</td>";
	$return .="<td ".$color.">". $o['FORMULARIO']."</td>";
	$return .="<td ".$color.">". $o['NOMBREARTISTA']."</td>";
	$return .="<td ".$color.">". $o['DURACION']."</td>";
	$return .="<td ".$color.">". $o['MATERIAL']."</td>";
	$return .="<td ".$color.">". $o['PARECIO']."</td>";
	$return .="<td ".$color.">". $o['REACCIONO']."</td>";
	$return .="<td ".$color.">". $o['OBSERVACIONES']."</td>";
	$return .="</tr>";

}
echo $return;