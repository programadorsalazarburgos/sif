<?php


$tipoIndicadores= array();
$indicadores=array();

/*busqueda en array multidimensional*/
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
/*busqueda por valor['nombre'] en array multidimensional, retorna el key de la posición del arreglo o -1 si no lo encuentra*/
function array_search_r($needle, $haystack) {
    foreach($haystack as $key => $value) {
        if($value['nombre'] == $needle) return $key;
    }
    return -1;
}
/*crea arreglo de tipos de indicadores*/
foreach ($this->getVariables()['indicadores'] as $i) {
	if(!in_array_r($i['Nombre_Indicador'], $tipoIndicadores)){
		$tipoIndicadores[]['nombre']=$i['Nombre_Indicador'];		
	}
}
/*Llena el sub array de indicadores para cada tipo de indicador*/
foreach ($this->getVariables()['indicadores'] as $i) {
	$pos=array_search_r($i['Nombre_Indicador'], $tipoIndicadores);
	if($pos!=-1){
		$tipoIndicadores[$pos]['indicadores'][]=$i;
	} 
}

$return="";
foreach ($tipoIndicadores as $tipo) {
	$return .= "
	<div class='row' style='padding: 10px;'>
		<div class='col-xs-12 col-md-12 col-sm-12 text-center bg-default card-indicador' >
		<h5>".$tipo['nombre']."</h5>";
	$iconos="";
	foreach ($tipo['indicadores'] as $i) {
			$inactivo="";
			if($i['IN_estado']=="0"){
				$inactivo="indicador-inactivo";
			}
			$iconos .= "
			<div class='col-md-2 col-xs-6 col-sm-3 col-lg-1 descripcion-grafica'>
				<a href='#'>
					<img src=".$i['VC_icono']." class='miniatura ".$inactivo."' data-etiqueta='".$i['VC_titulo']."' data-numeral='".$i['VC_numeral']."' data-nombre-indicador='".$i['Nombre_Indicador']."' data-icono='".$i['VC_icono']."' data-tipo-grafica='".$i['VC_tipo_grafico']."' data-filtros='".$i['VC_filtros']."' data-descripcion='".$i['TX_descripcion']."' data-estado='".$i['IN_estado']."'>
				</a>
				<p class='etiqueta'>".$i['VC_titulo']."</p>
			</div>";			
		}
	$return.=	$iconos;
	$return .= "
		</div>
	</div>";
}
echo $return;
