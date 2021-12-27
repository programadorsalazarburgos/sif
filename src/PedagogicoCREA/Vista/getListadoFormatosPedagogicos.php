<?php
$return = "";
foreach ($this->getVariables()['formatos_pedagogicos'] as $a) {
	if ($a['LINEA'] == 'arte_escuela') {
		$linea_atencion = 'ARTE EN LA ESCUELA';
		$acronimo = 'AE-';
	}
	else{
		if ($a['LINEA'] == 'emprende_clan') {
			$linea_atencion = 'EMPRENDE CREA';
			$acronimo = 'EC-';
		}
		else{
			$linea_atencion = 'LABORATORIO CREA';	
			$acronimo = 'LC-';
		}
	}
	$boton = $a['ESTADO'] == 1 ? "<a class='btn btn-success descargar' data-formato='".$a['FORMATO']."' data-id-tabla='".$a['PK']."' data-id-grupo='".$a['GRUPO']."' data-linea-atencion='".$a['LINEA']."' data-id-formador='".$a['ID_FORMADOR']."'>Descargar</a>" : ($a['FINALIZADO'] == 0 ? "<a class='btn btn-warning editar' data-id-tabla='".$a['PK']."' data-id-grupo='".$a['GRUPO']."' data-linea-atencion='".$a['LINEA']."'><span class='fas fa-edit'></span></a>" : "<a class='btn btn-warning ver' data-id-tabla='".$a['PK']."' data-id-grupo='".$a['GRUPO']."' data-id-formador='".$a['ID_FORMADOR']."' data-formato='".$a['FORMATO']."' data-linea-atencion='".$a['LINEA']."'>Revisar</a>");
	$estado = $a['ESTADO'] == 1 ? "<span class='label label-success' data-toggle='tooltip' title='Aprobado por el asesor pedagógico.'>Aprobado</span>" : ($a['ESTADO'] == '' ? "<span class='label label-white' data-toggle='tooltip' title='Sin revisar.' style='color:black'>Sin revisar</span>" : "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el asesor pedagógico.'>No Aprobado</span>");
	$finalizado = $a['FINALIZADO'] == 1 ? "<span class='label label-success' data-toggle='tooltip' title='Enviado.'>Enviado</span>" : "<span class='label label-danger' data-toggle='tooltip' title='Sin finalizar.'>Sin finalizar</span>";
	$return .= "<tr>";
	$return .= "<td>".$a['PK']."</td>";
	$return .= "<td>".$acronimo.$a['GRUPO']."</td>";
	$return .= "<td>".$a['AREA_ARTISTICA']."</td>";
	$return .= "<td>".$a['FORMADOR']."</td>";
	$return .= "<td>".$a['TIPO']."</td>";
	$return .= "<td>".$a['FECHA']."</td>";
	$return .= "<td>".$boton.$estado.$finalizado."</td>";
	$return .= "</tr>";
}
echo $return;