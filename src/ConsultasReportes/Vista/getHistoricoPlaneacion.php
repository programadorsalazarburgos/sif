<?php
$return = "";
foreach ($this->getVariables()['historico_planeacion'] as $p){
	$nombre = $p['VC_Nombre'];
	$año = substr($nombre, 3, 4);
	$meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
	$mes_inicial = substr($nombre, 8, 2);
	$mes_inicial = $meses[((int)$mes_inicial)-1];
	$periodo = $mes_inicial;
	$vector_nombre = explode(" al ", $nombre);
	
	if(sizeof($vector_nombre) > 1 && substr_count($nombre, "-") == 5){
		$mes_final = substr($vector_nombre[1], 0, 2);
		$mes_final = $meses[((int)$mes_final)-1];
		$periodo = $mes_inicial.'-'.$mes_final;
	}
	else{
		if(sizeof($vector_nombre) > 1){
			$mes_inicial = substr($vector_nombre[0],2);
			$vector_fecha_final = explode(" de ", $vector_nombre[1]);
			$mes_final = $vector_fecha_final[0];
			//$mes_final = $meses[((int)$mes_final)-1];
			$periodo = $mes_inicial.' A '.$mes_final;
		}
	}

	$linea_de_atencion = substr($nombre, 0, 2);
	if($linea_de_atencion == 'AE') {$linea_de_atencion='ARTE EN LA ESCUELA';}
	if($linea_de_atencion == 'EC') {$linea_de_atencion='EMPRENDE CREA';}
	if($linea_de_atencion == 'LC') {$linea_de_atencion='LABORATORIO CREA';}
	if($linea_de_atencion == 'IC') {$linea_de_atencion='IMPULSO COLECTIVO';}
	if($linea_de_atencion == 'CV') {$linea_de_atencion='CONVERGE';}
	// $fecha_generacion = substr($nombre, 13, 19);
	$fecha_generacion = $p['DA_Subida'];
	$return .= "<tr>";
	$return .= "<td>".$año."</td>";
	$return .= "<td>".$periodo."</td>";
	$return .= "<td>".$linea_de_atencion."</td>";
	$return .= "<td>".$fecha_generacion."</td>";
	$return .= "<td>"."<a href='../../".$p['VC_Url']."' title='Descargar' id='btn-descargar' class='btn btn-primary btn-sm opciones descargar' style='color: white' data-toggle='tooltip'><span class='fa fa-download' aria-hidden='true'></span></a> <a title='Eliminar' id='btn-eliminar' class='btn btn-danger btn-sm opciones eliminar' style='color: white' data-toggle='tooltip' data-id_registro=".$p['PK_Id_Tabla']." data-url='".$p['VC_Url']."' data-mes=".$periodo." data-anio=".$año." data-linea_atencion='".$linea_de_atencion."'><span class='fa fa-close' aria-hidden='true'></span></a>"."</td>";
	$return .= "</tr>";
}
echo $return;