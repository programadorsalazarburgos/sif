<?php
$return = "";
$userId = $this->getVariables()['usuarioId'];

foreach ($this->getVariables()['planeaciones'] as $a) {
	if ($a['FK_Id_Linea_atencion'] == 'arte_escuela') {
		$linea_atencion = 'ARTE EN LA ESCUELA';
		$acronimo = 'AE-';
	}
	else{
		if ($a['FK_Id_Linea_atencion'] == 'emprende_clan') {
			$linea_atencion = 'EMPRENDE CREA';
			$acronimo = 'EC-';
		}
		else{
			$linea_atencion = 'LABORATORIO CREA';	
			$acronimo = 'LC-';
		}
	}
	if($userId == $a['FK_Id_Usuario_Registro']){
		$boton = $a['IN_Estado'] == 1 ? "<a class='btn btn-success descargar' data-id-planeacion='".$a['PK_Id']."' data-id-grupo='".$a['FK_grupo']."' data-linea-atencion='".$a['FK_Id_Linea_atencion']."'>Descargar</a>" : ($a['IN_Finalizado'] == 0 ? "<a class='btn btn-warning editar' data-id-planeacion='".$a['PK_Id']."' data-id-grupo='".$a['FK_grupo']."' data-linea-atencion='".$a['FK_Id_Linea_atencion']."'><span class='fas fa-edit'></span></a>" : "<a class='btn btn-primary ver' data-id-planeacion='".$a['PK_Id']."' data-id-grupo='".$a['FK_grupo']."' data-linea-atencion='".$a['FK_Id_Linea_atencion']."'>Ver</a>");
		$estado = $a['IN_Estado'] == 1 ? "<span class='label label-success' data-toggle='tooltip' title='Aprobado por el asesor pedagógico.'>Aprobado</span>" : ($a['IN_Estado'] == '' ? "<span class='label label-white' data-toggle='tooltip' title='Sin revisar.' style='color:black'>Sin revisar</span>" : "<span class='label label-danger' data-toggle='tooltip' title='NO Aprobado por el asesor pedagógico.'>No Aprobado</span>");
		$finalizado = $a['IN_Finalizado'] == 1 ? "<span class='label label-success' data-toggle='tooltip' title='Enviado.'>Enviado</span>" : "<span class='label label-danger' data-toggle='tooltip' title='Sin finalizar.'>Sin finalizar</span>";
		$return .= "<tr>";
		$return .= "<td>".$a['PK_Id']."</td>";
		$return .= "<td>".$acronimo.$a['FK_grupo']."</td>";
		$return .= "<td>".$linea_atencion."</td>";
		$return .= "<td>".$a['DA_Fecha_Registro']."</td>";
		$return .= "<td>".$boton.$estado.$finalizado."</td>";
		$return .= "</tr>";
	}
	else{
		if($a['IN_Finalizado'] == 1){
			$boton = "<a class='btn btn-warning revisar' data-id-planeacion='".$a['PK_Id']."' data-id-grupo='".$a['FK_grupo']."' data-linea-atencion='".$a['FK_Id_Linea_atencion']."'>Revisar</a>";
			$return .= "<tr>";
			$return .= "<td>".$a['PK_Id']."</td>";
			$return .= "<td>".$acronimo.$a['FK_grupo']."</td>";
			$return .= "<td>".$linea_atencion."</td>";
			$return .= "<td>".$a['DA_Fecha_Registro']."</td>";
			$return .= "<td>".$boton."</td>";
			$return .= "</tr>";
		}
	}
}
echo $return;