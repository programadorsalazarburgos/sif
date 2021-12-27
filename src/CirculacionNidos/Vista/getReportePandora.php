<?php
$return = "";
foreach ($this->getVariables()['info'] as $i){
	$return.="<tr>";
	
	$return .= "<td>".$i["EVENTO"]."</td>";
	$return .= "<td>".$i["DESCRIPCIÓN"]."</td>";
	$return .= "<td>".$i["MODALIDAD"]."</td>";
	$return .= "<td>".$i["DIMENSION"]."</td>";
	$return .= "<td>".$i["TIPOLOGIA"]."</td>";
	$return .= "<td>".$i["EXPERIENCIAS"]."</td>";
	$return .= "<td>".$i["FECHA"]."</td>";
	$return .= "<td>".$i["ENFOQUE_POBLACIONAL"]."</td>";
	$return .= "<td>".$i["LUGAR"]."</td>";
	$return .= "<td>".$i["ESPACIO_PUBLICO"]."</td>";
	$return .= "<td>".$i["CAPACIDAD"]."</td>";
	$return .= "<td>".$i["LOCALIDAD"]."</td>";
	$return .= "<td>".$i["UPZ"]."</td>";
	$return .= "<td>".$i["BARRIO"]."</td>";
	$return .= "<td>".$i["IMPACTO_TERRITORIAL"]."</td>";
	$return .= "<td>".$i["ORIGEN"]."</td>";
	$return .= "<td>".$i["MODALIDAD_EQUIPAMIENTO"]."</td>";
	$return .= "<td>".$i["EVENTO_GRATUITO_PAGO"]."</td>";
	$return .= "<td>".$i["ARTISTAS_REMUNERADOS"]."</td>";
	$return .= "<td>".$i["TOTAL_ARTISTAS"]."</td>";
	$return .= "<td>".$i["INSCRITOS"]."</td>";
	$return .= "<td>".$i["TOTAL_NINAS"]."</td>";
	$return .= "<td>".$i["TOTAL_NINOS"]."</td>";
	$return .= "<td>".$i["OTRO"]."</td>";
	$return .= "<td>".$i["TOTAL_BENEFICIARIOS"]."</td>";
	$return .= "<td>".$i["PRIMERA"]."</td>";
	$return .= "<td>".$i["INFANCIA"]."</td>";
	$return .= "<td>".$i["ADOLESCENCIA"]."</td>";
	$return .= "<td>".$i["JUVENTUD"]."</td>";
	$return .= "<td>".$i["ADULTOS"]."</td>";
	$return .= "<td>".$i["MAYORES"]."</td>";
	$return .= "<td>".$i["CAMPESINA_N"]."</td>";
	$return .= "<td>".$i["GESTANTES_N"]."</td>";
	$return .= "<td>".$i["PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_N"]."</td>";
	$return .= "<td>".$i["PERSONAS_HABITANTES_CALLE_N"]."</td>";
	$return .= "<td>".$i["DISCAPACIDAD_N"]."</td>";
	$return .= "<td>".$i["POBLACION_CARCELARIA_N"]."</td>";
	$return .= "<td>".$i["PROFESIONALES"]."</td>";
	$return .= "<td>".$i["LGBTIQ_N"]."</td>";
	$return .= "<td>".$i["POBLACION_VICTIMA_CONFLICTO_N"]."</td>";
	$return .= "<td>".$i["MIGRANTES_N"]."</td>";
	$return .= "<td>".$i["VICTIMAS_TRATA"]."</td>";
	$return .= "<td>".$i["EMERGENCIA_SOCIAL_N"]."</td>";
	$return .= "<td>".$i["DETERIORO_URBANO_N"]."</td>";
	$return .= "<td>".$i["VULNERABILIDAD"]."</td>";
	$return .= "<td>".$i["DESPLAZAMIENTO_N"]."</td>";
	$return .= "<td>".$i["CONSUMIDORAS"]."</td>";
	$return .= "<td>".$i["ROM_N"]."</td>";
	$return .= "<td>".$i["PRO_ROM"]."</td>";
	$return .= "<td>".$i["INDIGENA_N"]."</td>";
	$return .= "<td>".$i["COMUNIDADES_NEGRAS_N"]."</td>";
	$return .= "<td>".$i["AFRODESCENDIENTE_N"]."</td>";
	$return .= "<td>".$i["PALENQUERA_N"]."</td>";
	$return .= "<td>".$i["RAIZALES_N"]."</td>";
	$return .= "<td>".$i["OBSERVACION"]."</td>";

	$return.="</tr>";
}

echo $return;