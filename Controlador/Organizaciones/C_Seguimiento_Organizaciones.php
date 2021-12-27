<?php  
include_once('../../Modelo/Organizaciones/Acceso_Datos.php'); 
if (isset($_POST['opcion'])){ 
  switch ($_POST['opcion']) { 
    case 'guardarSeguimiento':   
    guardarSeguimiento(); 
    break;
    case 'guardarSeguimientoV2':   
    guardarSeguimientoV2(); 
    break;
    case 'guardarSeguimientoV3':   
    guardarSeguimientoV3(); 
    break;
    case 'getEncabezadoSeguimiento': 
    echo getEncabezadoSeguimiento(); 
    break; 
    case 'getOrganizacionesAnio': 
    echo getOrganizacionesAnio(); 
    break; 
    case 'getSeguimientosOrganizacion': 
    echo getSeguimientosOrganizacion(); 
    break;
    case 'getSeguimientosOrganizacionAnioConvenio': 
    echo getSeguimientosOrganizacionAnioConvenio(); 
    break;
    case 'guardarRevisionSeguimiento': 
    echo guardarRevisionSeguimiento(); 
    break;
    case 'getSeguimientoPeriodo': 
    echo getSeguimientoPeriodo(); 
    break;
    case 'getPeriodosSeguimientosOrganizacion':
    echo getPeriodosSeguimientosOrganizacion();
    break;
    case 'getEncabezadoConsolidadoSeguimientos':
    echo getEncabezadoConsolidadoSeguimientos();
    break;
    case 'getConveniosOrganizacion':
    echo getConveniosOrganizacion();
    break;
    default: 
    echo "Opcion no existente."; 
    break;
  } 
} 
/*************************************************************************** 
Metodo encargado de consultar el encabezado de seguimiento de una organizacion 
***************************************************************************/ 
function getEncabezadoSeguimiento() 
{ 
  $id_organizacion = $_POST['id_organizacion'];
  $id_periodo = $_POST['id_periodo'];
  $datos = getSeguimientoEncabezado($id_organizacion, $id_periodo); 
  if (sizeof($datos) > 0) 
    $datos = $datos[sizeof($datos)-1]; 
  else 
    $datos = null; 
  return json_encode($datos); 
}

/*************************************************************************** 
Metodo encargado de consultar toda la informacion del seguimiento un periodo.
***************************************************************************/ 
function getSeguimientoPeriodo() 
{ 
  $id_periodo = $_POST['id_periodo']; 
  $datos = getSeguimientoDelPeriodo($id_periodo); 
  if (sizeof($datos) > 0) 
    $datos = $datos[sizeof($datos)-1]; 
  else
    $datos = null;
  return json_encode($datos); 
}

/*************************************************************************** 
Metodo encargado de consultar toda la informacion de los seguimientos APROBADOS de una organización.
***************************************************************************/ 
function getPeriodosSeguimientosOrganizacion() 
{
  $id_organizacion = $_POST['id_organizacion'];
  $year = $_POST['year'];
  $datos = getPeriodosSeguimientosDeOrganizacion($id_organizacion,$year); 
  
  return json_encode($datos); 
}

/*************************************************************************** 
Metodo encargado de realizar el almacenamiento del seguimiento realizado de la VERSION 1 del formato.
***************************************************************************/ 
function guardarSeguimiento() 
{ 
  //DATOS SEGUIMIENTO ORGANIZACION 
  $id_seguimiento_propuesta = $_POST['bandera_existencia']; 
  date_default_timezone_set('America/Bogota'); 
  $Id_Usuario = $_POST['id_usuario']; 
  $NIT = $_POST['TX_NIT']; 
  $Convenio = $_POST['TX_Numero_Convenio']; 
  $Fecha_Inicio =$_POST['TX_Fecha_Inicio']; 
  $Fecha_Fin   =$_POST['TX_Fecha_Fin']; 
  $Areas      =$_POST['areas']; 
  $Objetivo_General    =trim($_POST['TXTA_OBJETIVO_GRAL']); 
  $Objetivos_Especificos    =trim($_POST['json_objetivos_especificos']); 
  $Actividades  =trim($_POST['json_actividades']); 
  $Metas = trim($_POST['json_metas']); 
  $Indicadores =trim($_POST['json_indicadores']);
  $Propuestas  =trim($_POST['propuestas']); 

  //DATOS SEGUIMIENTO PERIODO 
  $Periodo   =$_POST['TX_Periodo']; 
  $Grupos      =$_POST['TX_Numero_Grupos']; 
  $Porcentaje    =trim($_POST['json_porcentajes']); 
  $Cumplimiento    =trim($_POST['json_cumplimiento']); 
  $Hallazgos = trim($_POST['hallazgos']); 
  $Transformaciones =trim($_POST['transformaciones']); 
  $Fecha_Registro = date("Y-m-d H:i:s"); 
  $Version      =$_POST['version']; 

  if($id_seguimiento_propuesta == 0) 
  {
    $id_seguimiento_propuesta = guardarSeguimientoOrganizacion($Id_Usuario,$NIT,$Convenio,$Fecha_Inicio,$Fecha_Fin,$Areas,$Objetivo_General,$Objetivos_Especificos,$Actividades,$Metas,$Indicadores,$Propuestas,$Fecha_Registro);
  }
  guardarSeguimientoPeriodo($Id_Usuario,$Periodo,$Grupos,$Porcentaje,$Cumplimiento,$Hallazgos,$Transformaciones,$Fecha_Registro,$Version,$id_seguimiento_propuesta);

  return true; 
} 

/*************************************************************************** 
Metodo encargado de realizar el almacenamiento del seguimiento realizado de la VERSION 2 del formato.
***************************************************************************/ 
function guardarSeguimientoV2() 
{ 
  //DATOS SEGUIMIENTO ORGANIZACION 
  $id_seguimiento_propuesta = $_POST['bandera_existencia']; 
  $bandera_actualizar = $_POST['bandera_actualizar']; 
  date_default_timezone_set('America/Bogota'); 
  $Id_Usuario = $_POST['id_usuario']; 
  $NIT = $_POST['TX_NIT_V2']; 
  $Convenio = $_POST['TX_Numero_Convenio_V2']; 
  $Fecha_Inicio =$_POST['TX_Fecha_Inicio_V2']; 
  $Fecha_Fin   =$_POST['TX_Fecha_Fin_V2'];
  $Areas      =$_POST['areas'];
  $Objetivo_General    =trim($_POST['TXTA_OBJETIVO_GRAL_V2']); 
  $Objetivos_Especificos    =trim($_POST['json_objetivos_especificos']); 
  $Actividades  =trim($_POST['json_actividades']); 
  $Propuestas  =trim($_POST['propuestas']); 

  //DATOS SEGUIMIENTO PERIODO V2
  $Periodo   =$_POST['TX_Periodo_V2']; 
  $Grupos      =$_POST['TX_Numero_Grupos_V2']; 
  $avances_formacion = trim($_POST['avances_formacion']); 
  $aportes_articulacion =trim($_POST['aportes_articulacion']); 
  $Fecha_Registro = date("Y-m-d H:i:s"); 
  $Version = $_POST['version']; 

  if($id_seguimiento_propuesta == 0) 
  {
    $id_seguimiento_propuesta = guardarSeguimientoOrganizacionV2($Id_Usuario,$NIT,$Convenio,$Fecha_Inicio,$Fecha_Fin,$Areas,$Objetivo_General,$Objetivos_Especificos,$Actividades,$Propuestas,$Fecha_Registro);
  }
  else{
    if($bandera_actualizar == 1) {
      actualizarSeguimientoOrganizacionV2($Areas,$Objetivo_General,$Objetivos_Especificos,$Actividades,$Propuestas,$id_seguimiento_propuesta);
    }
  }
  guardarSeguimientoPeriodoV2($Id_Usuario,$Periodo,$Grupos,$avances_formacion,$aportes_articulacion,$Fecha_Registro,$Version,$id_seguimiento_propuesta);

  return true; 
}

/*************************************************************************** 
Metodo encargado de realizar el almacenamiento del seguimiento realizado de la VERSION 3 del formato.
***************************************************************************/ 
function guardarSeguimientoV3() 
{ 
  $id_seguimiento_propuesta = $_POST['bandera_existencia']; 
  $bandera_existencia_indicadores = $_POST['bandera_existencia_indicadores']; 
  date_default_timezone_set('America/Bogota'); 
  $Id_Usuario = $_POST['id_usuario']; 
  $NIT = $_POST['TX_NIT_V3']; 
  $Convenio = $_POST['TX_Numero_Convenio_V3']; 
  $Fecha_Inicio = $_POST['TX_Fecha_Inicio_V3']; 
  $Fecha_Fin = $_POST['TX_Fecha_Fin_V3'];
  $Areas = $_POST['areas'];
  $Objetivo_General = trim($_POST['TXTA_OBJETIVO_GRAL_V3']); 
  $Objetivos_Especificos = trim($_POST['json_objetivos_especificos']); 
  $Actividades = trim($_POST['json_actividades']); 
  $Indicadores = trim($_POST['json_indicadores']);
  $Propuestas = trim($_POST['propuestas']); 

  //DATOS SEGUIMIENTO PERIODO V3
  $Periodo = $_POST['TX_Periodo_V3']; 
  $Grupos = $_POST['TX_Numero_Grupos_V3'];
  $Cumplimiento    =trim($_POST['json_cumplimiento']); 
  $avances_formacion = trim($_POST['avances_formacion']); 
  $aportes_articulacion = trim($_POST['aportes_articulacion']); 
  $Fecha_Registro = date("Y-m-d H:i:s"); 
  $Version = $_POST['version']; 

  if($id_seguimiento_propuesta == 0) 
  {
    $id_seguimiento_propuesta = guardarSeguimientoOrganizacionV3($Id_Usuario,$NIT,$Convenio,$Fecha_Inicio,$Fecha_Fin,$Areas,$Objetivo_General,$Objetivos_Especificos,$Actividades, $Indicadores,$Propuestas,$Fecha_Registro);
  }
  else{
    if($bandera_existencia_indicadores == 0) {
      actualizarIndicadoresSeguimientoOrganizacionV3($Indicadores,$id_seguimiento_propuesta);
    }
  }
  guardarSeguimientoPeriodoV3($Id_Usuario,$Periodo,$Grupos,$Cumplimiento,$avances_formacion,$aportes_articulacion,$Fecha_Registro,$Version,$id_seguimiento_propuesta);

  return true; 
} 

/*************************************************************************** 
Metodo encargado de consultar el listado de  organizaciones del año especificado. 
***************************************************************************/ 
function getOrganizacionesAnio(){ 
  $year = $_POST['year']; 
  $datos = getOrganizacionesYear($year); 
  return json_encode($datos); 
} 

/*************************************************************************** 
Metodo encargado de consultar el listado de seguimientos que ha realizado un Coordinador de Organizacion 
***************************************************************************/ 
function getSeguimientosOrganizacion(){ 
  $organizacion = $_POST['organizacion']; 
  $id_convenio = $_POST['id_convenio']; 
  $datos = getSeguimientosdeOrganizacion($organizacion, $id_convenio); 
  return json_encode($datos); 
}

/*************************************************************************** 
Metodo encargado de consultar el listado de seguimientos que ha realizado un Coordinador de Organizacion 
***************************************************************************/ 
function getSeguimientosOrganizacionAnioConvenio(){ 
  $organizacion = $_POST['organizacion']; 
  $year = $_POST['year']; 
  $datos = getSeguimientosOrganizacionPorAnioConvenio($organizacion, $year); 
  return json_encode($datos); 
}

/*************************************************************************** 
Funcion encargada de guardar una revisión de un seguimiento específico (La observación y el estado de aprobación)
***************************************************************************/ 
function guardarRevisionSeguimiento(){
	date_default_timezone_set('America/Bogota'); 
	$id_persona = $_POST['id_persona'];
	$id_periodo = $_POST['id_periodo']; 
 $observacion = $_POST['observacion'];
 $Fecha_Registro = date("Y-m-d H:i:s");
 if($_POST['aprobacion'] == "true"){
  $aprobacion = 1;
}
else{
  $aprobacion = 0;	
}

$datos = saveRevisionSeguimiento($id_persona, $id_periodo, $observacion, $aprobacion, $Fecha_Registro);
return json_encode($datos); 
}

/*************************************************************************** 
Metodo encargado de consultar el encabezado de seguimiento de una organizacion según el año especificado.
***************************************************************************/ 
function getEncabezadoConsolidadoSeguimientos() 
{ 
  $id_organizacion = $_POST['id_organizacion'];
  $anio = $_POST['anio'];
  $datos = getEncabezadoConsolidadoDeSeguimientos($id_organizacion, $anio); 
  if (sizeof($datos) > 0) 
    $datos = $datos[sizeof($datos)-1]; 
  else 
    $datos = null; 
  return json_encode($datos); 
}


/*************************************************************************** 
Metodo encargado de consultar los convenios que ha tenido una organizacion a lo largo del tiempo.
***************************************************************************/ 
function getConveniosOrganizacion() 
{ 
  $id_organizacion = $_POST['id_organizacion'];
  $datos = getConveniosDeOrganizacion($id_organizacion);
  return json_encode($datos); 
}

?>