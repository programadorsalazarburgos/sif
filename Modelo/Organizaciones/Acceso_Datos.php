<?php
//header ('Content-type: text/html; charset=utf-8');
  // Incluir libreria de acceso a base de datos
require_once('../../Modelo/medoo/medoo.php');
require_once('../../Modelo/medoo/parametros_conexion.php');

  /***************************************************************************
  /*guardarSeguimientoOrganizacion() almacena la información del seguimiento realizado.
  ***************************************************************************/
  function guardarSeguimientoOrganizacion($Id_Usuario,$NIT,$Convenio,$Fecha_Inicio,$Fecha_Fin,$Areas,$Objetivo_General,$Objetivos_Especificos,$Actividades,$Metas,$Indicadores,$Propuestas,$Fecha_Registro){
    global $db_siclan;
    $row_id = $db_siclan->insert("tb_organizacion_seguimiento_propuesta",[
      'FK_Id_Organizacion'=>$Id_Usuario,
      'VC_Nit'=>$NIT,
      'VC_Convenio'=>$Convenio,
      'DA_Inicio'=>$Fecha_Inicio,
      'DA_Fin'=>$Fecha_Fin,
      'VC_Areas'=>$Areas,
      'TX_Objetivo_General'=>$Objetivo_General,
      'TX_Objetivos_Especificos'=>$Objetivos_Especificos,
      'TX_Actividades'=>$Actividades,
      'TX_Metas'=>$Metas,
      'TX_Indicadores'=>$Indicadores,
      'TX_Propuesta'=>$Propuestas,
      'DA_Registro'=>$Fecha_Registro
    ]);
    return $row_id;
  }

  /***************************************************************************
  /*guardarSeguimientoOrganizacion() almacena la información del seguimiento V1 realizado.
  ***************************************************************************/
  function guardarSeguimientoPeriodo($Id_Usuario,$Periodo,$Grupos,$Porcentaje,$Cumplimiento,$Hallazgos,$Transformaciones,$Fecha_Registro,$version,$id_seguimiento_propuesta){
    global $db_siclan;
    $db_siclan->insert("tb_organizacion_seguimiento_propuesta_periodo",[
      'FK_Id_Organizacion'=>$Id_Usuario,
      'VC_Periodo'=>$Periodo,
      'IN_Grupos'=>$Grupos,
      'TX_Porcentaje'=>$Porcentaje,
      'TX_Cumplimiento'=>$Cumplimiento,
      'TX_Hallazgos'=>$Hallazgos,
      'TX_Transformaciones'=>$Transformaciones,
      'DA_Registro'=>$Fecha_Registro,
      'IN_Version'=>$version,
      'FK_Id_Seguimiento_Propuesta'=>$id_seguimiento_propuesta
    ]);
  }

  /***************************************************************************
  /*guardarSeguimientoOrganizacionV2() almacena la información del seguimiento V2 realizado.
  ***************************************************************************/
  function guardarSeguimientoOrganizacionV2($Id_Usuario,$NIT,$Convenio,$Fecha_Inicio,$Fecha_Fin,$Areas,$Objetivo_General,$Objetivos_Especificos,$Actividades,$Propuestas,$Fecha_Registro){
    global $db_siclan;
    $row_id = $db_siclan->insert("tb_organizacion_seguimiento_propuesta",[
      'FK_Id_Organizacion'=>$Id_Usuario,
      'VC_Nit'=>$NIT,
      'VC_Convenio'=>$Convenio,
      'DA_Inicio'=>$Fecha_Inicio,
      'DA_Fin'=>$Fecha_Fin,
      'VC_Areas'=>$Areas,
      'TX_Objetivo_General'=>$Objetivo_General,
      'TX_Objetivos_Especificos'=>$Objetivos_Especificos,
      'TX_Actividades'=>$Actividades,
      'TX_Propuesta'=>$Propuestas,
      'DA_Registro'=>$Fecha_Registro
    ]);
    return $row_id;
  }

  /***************************************************************************
  /*guardarSeguimientoOrganizacionV3() almacena la información del seguimiento V3 realizado.
  ***************************************************************************/
  function guardarSeguimientoOrganizacionV3($Id_Usuario,$NIT,$Convenio,$Fecha_Inicio,$Fecha_Fin,$Areas,$Objetivo_General,$Objetivos_Especificos,$Actividades,$Indicadores,$Propuestas,$Fecha_Registro){
    global $db_siclan;
    $row_id = $db_siclan->insert("tb_organizacion_seguimiento_propuesta",[
      'FK_Id_Organizacion'=>$Id_Usuario,
      'VC_Nit'=>$NIT,
      'VC_Convenio'=>$Convenio,
      'DA_Inicio'=>$Fecha_Inicio,
      'DA_Fin'=>$Fecha_Fin,
      'VC_Areas'=>$Areas,
      'TX_Objetivo_General'=>$Objetivo_General,
      'TX_Objetivos_Especificos'=>$Objetivos_Especificos,
      'TX_Actividades'=>$Actividades,
      'TX_Indicadores'=>$Indicadores,
      'TX_Propuesta'=>$Propuestas,
      'DA_Registro'=>$Fecha_Registro
    ]);
    return $row_id;
  }

  /***************************************************************************
  /*actualizarSeguimientoOrganizacionV2() actualiza la información de esta tabla ante la contigencia que se manejo en convenios 2018.
  ***************************************************************************/
  function actualizarSeguimientoOrganizacionV2($Areas,$Objetivo_General,$Objetivos_Especificos,$Actividades,$Propuestas,$id_seguimiento_propuesta){
    global $db_siclan;
    $db_siclan->update("tb_organizacion_seguimiento_propuesta",[
      'VC_Areas'=>$Areas,
      'TX_Objetivo_General'=>$Objetivo_General,
      'TX_Objetivos_Especificos'=>$Objetivos_Especificos,
      'TX_Actividades'=>$Actividades,
      'TX_Propuesta'=>$Propuestas
    ],
    ["PK_Id_Tabla"=>$id_seguimiento_propuesta]);
  }

  /***************************************************************************
  /*actualizarIndicadoresSeguimientoOrganizacionV3() actualiza la información de INDICADORES como contingencia del cambio del formato en 2019.
  ***************************************************************************/
  function actualizarIndicadoresSeguimientoOrganizacionV3($Indicadores,$id_seguimiento_propuesta){
    global $db_siclan;
    $db_siclan->update("tb_organizacion_seguimiento_propuesta",[
      'TX_Indicadores'=>$Indicadores
    ],
    ["PK_Id_Tabla"=>$id_seguimiento_propuesta]);
  }

  /***************************************************************************
  /*guardarSeguimientoPeriodoV2() almacena la información del seguimiento del periodo V2 realizado.
  ***************************************************************************/
  function guardarSeguimientoPeriodoV2($Id_Usuario,$Periodo,$Grupos,$avances_formacion,$aportes_articulacion,$Fecha_Registro,$version,$id_seguimiento_propuesta){
    global $db_siclan;
    $db_siclan->insert("tb_organizacion_seguimiento_propuesta_periodo",[
      'FK_Id_Organizacion'=>$Id_Usuario,
      'VC_Periodo'=>$Periodo,
      'IN_Grupos'=>$Grupos,
      'TX_Avances_Formacion'=>$avances_formacion,
      'TX_Aportes_Articulacion'=>$aportes_articulacion,
      'DA_Registro'=>$Fecha_Registro,
      'IN_Version'=>$version,
      'FK_Id_Seguimiento_Propuesta'=>$id_seguimiento_propuesta
    ]);
  }

    /***************************************************************************
  /*guardarSeguimientoPeriodoV3() almacena la información del seguimiento del periodo V3 realizado.
  ***************************************************************************/
  function guardarSeguimientoPeriodoV3($Id_Usuario,$Periodo,$Grupos,$Cumplimiento,$avances_formacion,$aportes_articulacion,$Fecha_Registro,$version,$id_seguimiento_propuesta){
    global $db_siclan;
    $db_siclan->insert("tb_organizacion_seguimiento_propuesta_periodo",[
      'FK_Id_Organizacion'=>$Id_Usuario,
      'VC_Periodo'=>$Periodo,
      'IN_Grupos'=>$Grupos,
      'TX_Cumplimiento'=>$Cumplimiento,
      'TX_Avances_Formacion'=>$avances_formacion,
      'TX_Aportes_Articulacion'=>$aportes_articulacion,
      'DA_Registro'=>$Fecha_Registro,
      'IN_Version'=>$version,
      'FK_Id_Seguimiento_Propuesta'=>$id_seguimiento_propuesta
    ]);
  }

  /***************************************************************************
  /* getSeguimientoEncabezado($id_organizacion,$id_seguimiento_periodo) consulta los datos del encabezado de seguimiento de una organizacion que corresponde al periodo que se desea ver.
  ***************************************************************************/

  function getSeguimientoEncabezado($id_organizacion, $id_seguimiento_periodo){
    global $db_siclan;
    if($id_seguimiento_periodo != ''){
     $encabezado = $db_siclan->select("tb_organizacion_seguimiento_propuesta",[
      "[>]tb_organizacion_seguimiento_propuesta_periodo" => ["PK_Id_Tabla" => "FK_Id_Seguimiento_Propuesta"],
      "[>]tb_organizaciones_2017" => ["tb_organizacion_seguimiento_propuesta_periodo.FK_Id_Organizacion" => "FK_Coordinador"]
    ],
    [
      "tb_organizacion_seguimiento_propuesta.PK_Id_Tabla",
      "tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion",
      "tb_organizacion_seguimiento_propuesta.VC_Nit",
      "tb_organizacion_seguimiento_propuesta.VC_Convenio",
      "tb_organizacion_seguimiento_propuesta.DA_Inicio",
      "tb_organizacion_seguimiento_propuesta.DA_Fin",
      "tb_organizacion_seguimiento_propuesta.VC_Areas",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivo_General",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivos_Especificos",
      "tb_organizacion_seguimiento_propuesta.TX_Actividades",
      "tb_organizacion_seguimiento_propuesta.TX_Metas",
      "tb_organizacion_seguimiento_propuesta.TX_Indicadores",
      "tb_organizacion_seguimiento_propuesta.TX_Propuesta",
      "tb_organizacion_seguimiento_propuesta.DA_Registro",
      // "tb_organizacion_seguimiento_propuesta_periodo.PK_Id_Tabla",
      "tb_organizacion_seguimiento_propuesta_periodo.FK_Id_Organizacion",
      "tb_organizacion_seguimiento_propuesta_periodo.VC_Periodo",
      "tb_organizacion_seguimiento_propuesta_periodo.IN_Grupos",
      "tb_organizacion_seguimiento_propuesta_periodo.TX_Porcentaje",
      "tb_organizacion_seguimiento_propuesta_periodo.TX_Cumplimiento",
      "tb_organizacion_seguimiento_propuesta_periodo.TX_Hallazgos",
      "tb_organizacion_seguimiento_propuesta_periodo.TX_Transformaciones",
      "tb_organizacion_seguimiento_propuesta_periodo.TX_Observaciones",
      "tb_organizacion_seguimiento_propuesta_periodo.IN_Aprobacion",
      "tb_organizacion_seguimiento_propuesta_periodo.FK_Persona_Revisa",
      "tb_organizacion_seguimiento_propuesta_periodo.DA_Cambio",
      "tb_organizacion_seguimiento_propuesta_periodo.DA_Registro",
      "tb_organizacion_seguimiento_propuesta_periodo.FK_Id_Seguimiento_Propuesta",
      "tb_organizaciones_2017.VC_Nom_Organizacion"
    ],
    ["AND"=>["tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion"=>$id_organizacion, "tb_organizacion_seguimiento_propuesta_periodo.PK_Id_Tabla"=>$id_seguimiento_periodo]]);
   }
   else{
     $encabezado = $db_siclan->select("tb_organizacion_seguimiento_propuesta",[
      "[>]tb_organizaciones_2017" => ["FK_Id_Organizacion" => "FK_Coordinador"]
    ],
    [
      "tb_organizacion_seguimiento_propuesta.PK_Id_Tabla",
      "tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion",
      "tb_organizacion_seguimiento_propuesta.VC_Nit",
      "tb_organizacion_seguimiento_propuesta.VC_Convenio",
      "tb_organizacion_seguimiento_propuesta.DA_Inicio",
      "tb_organizacion_seguimiento_propuesta.DA_Fin",
      "tb_organizacion_seguimiento_propuesta.VC_Areas",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivo_General",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivos_Especificos",
      "tb_organizacion_seguimiento_propuesta.TX_Actividades",
      "tb_organizacion_seguimiento_propuesta.TX_Metas",
      "tb_organizacion_seguimiento_propuesta.TX_Indicadores",
      "tb_organizacion_seguimiento_propuesta.TX_Propuesta",
      "tb_organizacion_seguimiento_propuesta.DA_Registro",
      "tb_organizaciones_2017.VC_Nom_Organizacion"
    ],
    ["AND"=>["FK_Id_Organizacion"=>$id_organizacion, "tb_organizacion_seguimiento_propuesta.IN_Estado"=>1]]); 
   }
   return $encabezado;
 }

  /***************************************************************************
  /* getInformacionContractual($id_organizacion,$id_informe_gestion) consulta la informacion contractual de una organizacion para cargar el encabezado del Informe de Gestión (Si viene un id_informe_gestion se consulta la info_contractual que le corresponde, sino entonces consulta la info contractual que este activa para la organización (IN_Estado = 1)).
  ***************************************************************************/

  function getInformacionContractual($id_organizacion, $id_informe_gestion){
    global $db_siclan;
    if($id_informe_gestion != ''){
     $info_contractual = $db_siclan->select("tb_organizacion_informe_gestion",[
      "[>]tb_organizacion_info_contractual" => ["FK_Id_Info_Contractual" => "PK_Id_Tabla"],
      "[>]tb_organizaciones_2017" => ["tb_organizacion_informe_gestion.FK_Id_Organizacion" => "FK_Coordinador"],
      "[>]tb_organizacion_seguimiento_propuesta" => ["tb_organizacion_info_contractual.FK_Id_Seguimiento_Propuesta" => "PK_Id_Tabla"]
    ],
    [
      "tb_organizacion_informe_gestion.PK_Id_Tabla (id_informe_gestion)",
      "tb_organizacion_informe_gestion.FK_Id_Organizacion (fk_id_organizacion_informe_gestion)",
      "tb_organizacion_informe_gestion.VC_Informe",
      "tb_organizacion_informe_gestion.VC_Periodo",
      "tb_organizacion_informe_gestion.IN_Anio",
      "tb_organizacion_informe_gestion.VC_Correo",
      "tb_organizacion_informe_gestion.TX_Detalle_Actividades",
      "tb_organizacion_informe_gestion.DA_Registro (fecha_registro_informe_gestion)",
      "tb_organizacion_informe_gestion.TX_Observaciones",
      "tb_organizacion_informe_gestion.IN_Aprobacion",
      "tb_organizacion_informe_gestion.FK_Persona_Revisa",
      "tb_organizacion_informe_gestion.DA_Cambio",
      "tb_organizacion_informe_gestion.IN_Estado_Final",
      "tb_organizacion_informe_gestion.FK_Id_Info_Contractual",
      "tb_organizacion_info_contractual.PK_Id_Tabla (id_info_contractual)",
      "tb_organizacion_info_contractual.FK_Id_Organizacion (fk_id_organizacion_info_contractual)",
      "tb_organizacion_info_contractual.TX_Nombre_Proyecto",
      "tb_organizacion_info_contractual.VC_Representante_Legal",
      "tb_organizacion_info_contractual.TX_Objeto_Contrato",
      "tb_organizacion_info_contractual.TX_Obligaciones_Idartes",
      "tb_organizacion_info_contractual.TX_Cifras_Recursos",
      "tb_organizacion_info_contractual.TX_Actividades_Realizadas",
      "tb_organizacion_info_contractual.TX_Poblacion_Beneficiada",
      "tb_organizacion_info_contractual.IN_Artistas_Beneficiados",
      "tb_organizacion_info_contractual.TX_Difusion",
      "tb_organizacion_info_contractual.DA_Registro (fecha_registro_info_contractual)",
      "tb_organizacion_info_contractual.FK_Id_Seguimiento_Propuesta",
      "tb_organizaciones_2017.PK_Id_Organizacion",
      "tb_organizaciones_2017.VC_Nom_Organizacion",
      "tb_organizaciones_2017.FK_Id_Localidad",
      "tb_organizaciones_2017.VC_Telefono",
      "tb_organizaciones_2017.VC_Direccion_Organiz",
      "tb_organizaciones_2017.VC_Responsable_Organi",
      "tb_organizaciones_2017.VC_Estado_Organizacion",
      "tb_organizaciones_2017.Anio",
      "tb_organizaciones_2017.FK_Coordinador",
      "tb_organizacion_seguimiento_propuesta.PK_Id_Tabla (id_seguimiento_propuesta)",
      "tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion (fk_id_organizacion_seguimiento_propuesta)",
      "tb_organizacion_seguimiento_propuesta.VC_Nit",
      "tb_organizacion_seguimiento_propuesta.VC_Convenio",
      "tb_organizacion_seguimiento_propuesta.DA_Inicio",
      "tb_organizacion_seguimiento_propuesta.DA_Fin",
      "tb_organizacion_seguimiento_propuesta.VC_Areas",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivo_General",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivos_Especificos",
      "tb_organizacion_seguimiento_propuesta.TX_Actividades",
      "tb_organizacion_seguimiento_propuesta.TX_Metas",
      "tb_organizacion_seguimiento_propuesta.TX_Indicadores",
      "tb_organizacion_seguimiento_propuesta.TX_Propuesta",
      "tb_organizacion_seguimiento_propuesta.DA_Registro (fecha_registro_seguimiento_propuesta)",
      "tb_organizacion_seguimiento_propuesta.IN_Estado"],
      ["AND"=>["tb_organizacion_informe_gestion.PK_Id_Tabla"=>$id_informe_gestion]]);
   }
   else{
     $info_contractual = $db_siclan->select("tb_organizacion_seguimiento_propuesta",[ 
      "[>]tb_organizaciones_2017" => ["FK_Id_Organizacion" => "FK_Coordinador"], 
      "[>]tb_organizacion_info_contractual" => ["PK_Id_Tabla" => "FK_Id_Seguimiento_Propuesta"], 
    ], 
    [
      "tb_organizacion_info_contractual.PK_Id_Tabla (id_info_contractual)", 
      "tb_organizacion_info_contractual.FK_Id_Organizacion (fk_id_organizacion_info_contractual)", 
      "tb_organizacion_info_contractual.TX_Nombre_Proyecto", 
      "tb_organizacion_info_contractual.VC_Representante_Legal", 
      "tb_organizacion_info_contractual.TX_Objeto_Contrato", 
      "tb_organizacion_info_contractual.TX_Obligaciones_Idartes", 
      "tb_organizacion_info_contractual.TX_Cifras_Recursos", 
      "tb_organizacion_info_contractual.TX_Actividades_Realizadas", 
      "tb_organizacion_info_contractual.TX_Poblacion_Beneficiada", 
      "tb_organizacion_info_contractual.IN_Artistas_Beneficiados", 
      "tb_organizacion_info_contractual.TX_Difusion", 
      "tb_organizacion_info_contractual.DA_Registro (fecha_registro_info_contractual)", 
      "tb_organizacion_info_contractual.FK_Id_Seguimiento_Propuesta", 
      "tb_organizaciones_2017.PK_Id_Organizacion", 
      "tb_organizaciones_2017.VC_Nom_Organizacion", 
      "tb_organizaciones_2017.FK_Id_Localidad", 
      "tb_organizaciones_2017.VC_Telefono", 
      "tb_organizaciones_2017.VC_Direccion_Organiz", 
      "tb_organizaciones_2017.VC_Responsable_Organi", 
      "tb_organizaciones_2017.VC_Estado_Organizacion", 
      "tb_organizaciones_2017.Anio", 
      "tb_organizaciones_2017.FK_Coordinador", 
      "tb_organizacion_seguimiento_propuesta.PK_Id_Tabla (id_seguimiento_propuesta)", 
      "tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion (fk_id_organizacion_seguimiento_propuesta)", 
      "tb_organizacion_seguimiento_propuesta.VC_Nit", 
      "tb_organizacion_seguimiento_propuesta.VC_Convenio", 
      "tb_organizacion_seguimiento_propuesta.DA_Inicio", 
      "tb_organizacion_seguimiento_propuesta.DA_Fin", 
      "tb_organizacion_seguimiento_propuesta.VC_Areas", 
      "tb_organizacion_seguimiento_propuesta.TX_Objetivo_General", 
      "tb_organizacion_seguimiento_propuesta.TX_Objetivos_Especificos", 
      "tb_organizacion_seguimiento_propuesta.TX_Actividades", 
      "tb_organizacion_seguimiento_propuesta.TX_Metas", 
      "tb_organizacion_seguimiento_propuesta.TX_Indicadores", 
      "tb_organizacion_seguimiento_propuesta.TX_Propuesta", 
      "tb_organizacion_seguimiento_propuesta.DA_Registro (fecha_registro_seguimiento_propuesta)", 
      "tb_organizacion_seguimiento_propuesta.IN_Estado"], 
      ["AND"=>["tb_organizacion_info_contractual.FK_Id_Organizacion"=>$id_organizacion, "tb_organizacion_seguimiento_propuesta.IN_Estado"=>1]]); 
   }
   return $info_contractual;
 }

  /***************************************************************************
  /* getSeguimientoPeriodo consulta los datos del seguimiento realizado en determinado periodo.
  ***************************************************************************/
  function getSeguimientoDelPeriodo($id_periodo){
    global $db_siclan;
    $seguimiento = $db_siclan->select("tb_organizacion_seguimiento_propuesta_periodo","*",["PK_Id_Tabla"=>$id_periodo]);
    return $seguimiento;
  }

    /***************************************************************************
  /* getInformeDeGestion consulta los datos del informe de gestion indicado.
  ***************************************************************************/
  function getInformeDeGestion($id_informe_gestion){
    global $db_siclan;
    $informe_gestion = $db_siclan->select("tb_organizacion_informe_gestion","*",["PK_Id_Tabla"=>$id_informe_gestion]);
    return $informe_gestion;
  }

  /***************************************************************************
  /* getPeriodosSeguimientosDeOrganizacion consulta los datos de los seguimientos APROBADOS de una organizacion.
  ***************************************************************************/
  function getPeriodosSeguimientosDeOrganizacion($id_organizacion, $year){
    global $db_siclan;
    // $seguimiento = $db_siclan->query("SELECT * FROM tb_organizacion_seguimiento_propuesta_periodo WHERE FK_Id_Organizacion='".$id_organizacion."' AND YEAR(DA_Registro)='".$year."' AND IN_Aprobacion=1")->fetchAll();
    $seguimiento = $db_siclan->query("SELECT * FROM tb_organizacion_seguimiento_propuesta_periodo SPP JOIN tb_organizacion_seguimiento_propuesta SP ON SPP.FK_Id_Seguimiento_Propuesta=SP.PK_Id_Tabla WHERE SPP.FK_Id_Organizacion='".$id_organizacion."' AND SPP.IN_Aprobacion=1 AND SP.DA_Inicio LIKE '%".$year."%'")->fetchAll();
    return $seguimiento;
  }

  /***************************************************************************
  /* getSeguimientoDePeriodo consulta los datos de un seguimiento a la propuesta específico de una organizacion.
  ***************************************************************************/
  function getSeguimientoDePeriodo($id_periodo){
    global $db_siclan;
    $seguimiento = $db_siclan->query("SELECT * FROM tb_organizacion_seguimiento_propuesta_periodo WHERE PK_Id_Tabla='".$id_periodo)->fetchAll();
    return $seguimiento;
  }

  /***************************************************************************
  /* getOrganizacionesYear consulta el listado de Organizaciones del año especificado.
  ***************************************************************************/
  function getOrganizacionesYear($year){
    global $db_siclan;
    $organizaciones = $db_siclan->select("tb_organizaciones_2017","*",["AND"=>["Anio[~]"=>$year, "PK_Id_Organizacion[>]"=>2]]);
    return $organizaciones;
  }


  /***************************************************************************
  /* getSeguimientosdeOrganizacion consulta el listado de Seguimientos de un convenio, que ha realizado una Organización
  ***************************************************************************/
  function getSeguimientosdeOrganizacion($organizacion, $id_convenio){
    global $db_siclan;
    $organizaciones = $db_siclan->select("tb_organizacion_seguimiento_propuesta_periodo",
      [
        "[>]tb_persona_2017" => ["FK_Id_Organizacion" => "PK_Id_Persona"],
        "[>]tb_organizacion_seguimiento_propuesta" => ["FK_Id_Seguimiento_Propuesta" => "PK_Id_Tabla"]
      ],
      [
        "tb_organizacion_seguimiento_propuesta_periodo.FK_Id_Organizacion",
        "tb_organizacion_seguimiento_propuesta_periodo.PK_Id_Tabla",
        "tb_organizacion_seguimiento_propuesta_periodo.VC_Periodo",
        "tb_organizacion_seguimiento_propuesta_periodo.TX_Observaciones",
        "tb_organizacion_seguimiento_propuesta_periodo.IN_Aprobacion",
        "tb_organizacion_seguimiento_propuesta_periodo.DA_Registro",
        "tb_organizacion_seguimiento_propuesta_periodo.IN_Version",
        "tb_persona_2017.VC_Primer_Nombre",
        "tb_persona_2017.VC_Segundo_Nombre",
        "tb_persona_2017.VC_Primer_Apellido",
        "tb_persona_2017.VC_Segundo_Apellido"
      ],["AND"=>["tb_organizacion_seguimiento_propuesta_periodo.FK_Id_Organizacion"=>$organizacion, "FK_Id_Seguimiento_Propuesta"=>$id_convenio]]);
    return $organizaciones;
  }

   /***************************************************************************
  /* getSeguimientosOrganizacionPorAnioConvenio consulta el listado de Seguimientos de un convenio según el año, que ha realizado una Organización
  ***************************************************************************/
  function getSeguimientosOrganizacionPorAnioConvenio($organizacion, $year){
    global $db_siclan;
    $organizaciones = $db_siclan->select("tb_organizacion_seguimiento_propuesta_periodo",
      [
        "[>]tb_persona_2017" => ["FK_Id_Organizacion" => "PK_Id_Persona"],
        "[>]tb_organizacion_seguimiento_propuesta" => ["FK_Id_Seguimiento_Propuesta" => "PK_Id_Tabla"]
      ],
      [
        "tb_organizacion_seguimiento_propuesta_periodo.FK_Id_Organizacion",
        "tb_organizacion_seguimiento_propuesta_periodo.PK_Id_Tabla",
        "tb_organizacion_seguimiento_propuesta_periodo.VC_Periodo",
        "tb_organizacion_seguimiento_propuesta_periodo.TX_Observaciones",
        "tb_organizacion_seguimiento_propuesta_periodo.IN_Aprobacion",
        "tb_organizacion_seguimiento_propuesta_periodo.DA_Registro",
        "tb_organizacion_seguimiento_propuesta_periodo.IN_Version",
        "tb_persona_2017.VC_Primer_Nombre",
        "tb_persona_2017.VC_Segundo_Nombre",
        "tb_persona_2017.VC_Primer_Apellido",
        "tb_persona_2017.VC_Segundo_Apellido"
      ],["AND"=>["tb_organizacion_seguimiento_propuesta_periodo.FK_Id_Organizacion"=>$organizacion, "DA_Inicio[~]"=>$year]]);
    return $organizaciones;
  }

  /***************************************************************************
  /* getFormatosAdministrativosDeOrganizacion consulta el listado de Informes de Gestión y Proyecciones del Gasto que ha realizado una Organización.
  ***************************************************************************/
  function getFormatosAdministrativosDeOrganizacion($organizacion, $year){
    global $db_siclan;
    $FAS = $db_siclan->query("(SELECT 
      toig.PK_Id_Tabla,
      toig.VC_Periodo,
      toig.IN_Anio,
      toig.DA_Registro,
      toig.IN_Aprobacion,
      toig.TX_Observaciones,
      'INFORME DE GESTIÓN' AS tipo_informe, 
      IN_Estado_Final 
      FROM tb_organizacion_informe_gestion toig
      JOIN tb_organizacion_info_contractual toic ON toig.FK_Id_Info_Contractual=toic.PK_Id_Tabla
      JOIN tb_organizacion_seguimiento_propuesta sp ON toic.FK_Id_Seguimiento_Propuesta=sp.PK_Id_Tabla
      WHERE toig.FK_Id_Organizacion=".$organizacion." AND sp.DA_Inicio LIKE '%".$year."%')
      UNION
      (SELECT 
      topg.PK_Seguimiento_Gasto_Id,
      topg.TX_Periodo,
      topg.IN_Anio,
      topg.DT_Fecha_Registro,
      topg.IN_Aprobacion,
      topg.TX_Observaciones,
      'PROYECCIÓN Y SEGUIMIENTO DEL GASTO' AS tipo_informe,
      IN_Estado_Final
      FROM tb_organizaciones_proyeccion_gasto topg
      JOIN tb_organizaciones_2017 to2 ON to2.PK_Id_Organizacion =  topg.FK_Organizacion_Id
      JOIN tb_organizacion_seguimiento_propuesta sp ON topg.FK_Id_Seguimiento_Propuesta=sp.PK_Id_Tabla
      WHERE to2.FK_Coordinador = ".$organizacion." AND sp.DA_Inicio LIKE '%".$year."%')
      ")->fetchAll();
    return $FAS;
  }

  /***************************************************************************
  /*saveRevisionSeguimiento() almacena la información de la revisión del seguimiento específicado.
  ***************************************************************************/
  function saveRevisionSeguimiento($id_persona, $id_periodo, $observacion, $aprobacion, $fecha){
    global $db_siclan;
    $db_siclan->update("tb_organizacion_seguimiento_propuesta_periodo",
      [
        'TX_Observaciones'=>$observacion,
        'IN_Aprobacion'=>$aprobacion,
        'FK_Persona_Revisa'=>$id_persona,
        'DA_Cambio'=>$fecha
      ],
      [
        'PK_Id_Tabla'=>$id_periodo
      ]);
  }

  /***************************************************************************
  /*saveRevisionFA() almacena la información de la revisión del formato administrativo específicado.
  ***************************************************************************/
  function saveRevisionFA($id_persona, $id_tabla, $observacion, $aprobacion, $fecha){
    global $db_siclan;
    $db_siclan->update("tb_organizacion_informe_gestion",
      [
        'TX_Observaciones'=>$observacion,
        'IN_Aprobacion'=>$aprobacion,
        'FK_Persona_Revisa'=>$id_persona,
        'DA_Cambio'=>$fecha
      ],
      [
        'PK_Id_Tabla'=>$id_tabla
      ]);
  }
  /***************************************************************************
  /*saveRevisionFAProyeccion() almacena la información de la revisión del formato administrativo específicado.
  ***************************************************************************/
  function saveRevisionFAProyeccion($id_persona, $id_tabla, $observacion, $aprobacion, $fecha){
    global $db_siclan;
    $db_siclan->update("tb_organizaciones_proyeccion_gasto",
      [
        'TX_Observaciones'=>$observacion,
        'IN_Aprobacion'=>$aprobacion,
        'FK_Persona_Revisa'=>$id_persona,
        'DA_Cambio'=>$fecha
      ],
      [
        'PK_Seguimiento_Gasto_Id'=>$id_tabla
      ]);
    return $rta;
  }

  /***************************************************************************
  /*getOrganizacion() retorna el id de la organizacion a la que pertenece un usuario
  ***************************************************************************/
  function getOrganizacion($idUsuario){
    global $db_siclan;
    $id_organizacion = $db_siclan->select("tb_organizaciones_2017","*",["FK_Coordinador"=>$idUsuario]);
    return $id_organizacion[0]['PK_Id_Organizacion'];
  }
  /***************************************************************************
  /*getOrganizacionAllData() retorna el id de la organizacion a la que pertenece un usuario
  ***************************************************************************/
  function getOrganizacionAllData($idUsuario){
  	global $db_siclan;
    $id_organizacion = $db_siclan->select("tb_organizaciones_2017",[
      "[>]tb_organizacion_seguimiento_propuesta" => ["FK_Coordinador" => "FK_Id_Organizacion"]
    ],
    [
      "tb_organizacion_seguimiento_propuesta.PK_Id_Tabla",
      "tb_organizaciones_2017.PK_Id_Organizacion",
      "tb_organizaciones_2017.PK_Id_Organizacion",
      "tb_organizaciones_2017.VC_Nom_Organizacion",
      "tb_organizaciones_2017.FK_Id_Localidad",
      "tb_organizaciones_2017.VC_Telefono",
      "tb_organizaciones_2017.VC_Direccion_Organiz",
      "tb_organizaciones_2017.VC_Responsable_Organi",
      "tb_organizaciones_2017.VC_Estado_Organizacion",
      "tb_organizaciones_2017.Anio",
      "tb_organizaciones_2017.FK_Coordinador"
    ],
    ["AND"=>["FK_Coordinador"=>$idUsuario,'IN_Estado'=> 1]]);
    return $id_organizacion[0];
  }

  /***************************************************************************
  /*saveOrganizacionArchivo() almacena la información del seguimiento realizado.
  ***************************************************************************/
  function saveOrganizacionArchivo($idOrganizacion,$nombreArchivo,$url,$meses,$anio,$tipo,$idUsuario,$fecha,$id_seguimiento_propuesta){
    global $db_siclan;
    $db_siclan->insert("tb_organizacion_archivo",[
      'FK_Id_Organizacion'=> $idOrganizacion ,
      'VC_Nombre_Archivo'=> $nombreArchivo,
      'VC_URL'=> $url,
      'VC_Mes'=> $meses,
      'IN_Anio'=> $anio,
      'VC_Tipo'=> $tipo,
      'FK_Id_Usuario'=> $idUsuario,
      'DA_Subida' => $fecha,
      'FK_Id_Seguimiento_Propuesta' => $id_seguimiento_propuesta
    ]);
    $archivo = $db_siclan->select("tb_organizacion_archivo","*",["AND"=>["FK_Id_Organizacion"=>$idOrganizacion,'VC_Nombre_Archivo'=> $nombreArchivo,'DA_Subida' => $fecha]]);
    // echo ($archivo[0]['PK_Id_Tabla']);
    return $archivo[0]['PK_Id_Tabla'];
  }
  /***************************************************************************
  /*saveOrganizacionArchivoAnexo() almacena la información del seguimiento realizado.
  ***************************************************************************/
  function saveOrganizacionArchivoAnexo($nombreArchivo,$url,$idUsuario,$fecha,$idArchivo){
    global $db_siclan;
    $db_siclan->insert("tb_organizacion_archivo_anexo",[
      'VC_Nombre_Archivo'=> $nombreArchivo,
      'VC_URL'=> $url,
      'FK_Id_Usuario'=> $idUsuario,
      'FK_Id_Archivo' => $idArchivo,
      'DA_Subida' => $fecha
    ]);
  }

  /***************************************************************************
  /* getArchivosdeOrganizacion consulta el listado de Archivos que ha subido una Organización segun el año del convenio seleccionado.
  ***************************************************************************/
  function getArchivosdeOrganizacion($organizacion, $year){
    global $db_siclan;
    $archivos = $db_siclan->select("tb_organizacion_archivo",[
      "[>]tb_organizacion_seguimiento_propuesta" => ["FK_Id_Seguimiento_Propuesta" => "PK_Id_Tabla"]
    ],
    [
      "tb_organizacion_archivo.PK_Id_Tabla", 
      "tb_organizacion_archivo.FK_Id_Organizacion",
      "tb_organizacion_archivo.VC_Nombre_Archivo",
      "tb_organizacion_archivo.VC_URL",
      "tb_organizacion_archivo.VC_Mes",
      "tb_organizacion_archivo.IN_Anio",
      "tb_organizacion_archivo.VC_Tipo",
      "tb_organizacion_archivo.TX_Observacion",
      "tb_organizacion_archivo.IN_Aprobacion",
      "tb_organizacion_archivo.DA_Cambio",
      "tb_organizacion_archivo.FK_Persona_Revisa",
      "tb_organizacion_archivo.FK_Id_Usuario",
      "tb_organizacion_archivo.DA_Subida",
      "tb_organizacion_archivo.IN_Estado_Final",
      "tb_organizacion_archivo.FK_Id_Seguimiento_Propuesta",
      "tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion",
      "tb_organizacion_seguimiento_propuesta.VC_Nit",
      "tb_organizacion_seguimiento_propuesta.VC_Convenio",
      "tb_organizacion_seguimiento_propuesta.DA_Inicio",
      "tb_organizacion_seguimiento_propuesta.DA_Fin",
      "tb_organizacion_seguimiento_propuesta.VC_Areas",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivo_General",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivos_Especificos",
      "tb_organizacion_seguimiento_propuesta.TX_Actividades",
      "tb_organizacion_seguimiento_propuesta.TX_Metas",
      "tb_organizacion_seguimiento_propuesta.TX_Indicadores",
      "tb_organizacion_seguimiento_propuesta.TX_Propuesta",
      "tb_organizacion_seguimiento_propuesta.DA_Registro",
      "tb_organizacion_seguimiento_propuesta.IN_Estado"
    ]
    ,["AND"=>["tb_organizacion_archivo.FK_Id_Organizacion"=>$organizacion, "tb_organizacion_seguimiento_propuesta.DA_Inicio[~]" => $year]]);
    return $archivos;
  }

  /***************************************************************************
  /* getArmonizacionDatos consulta los datos del seguimiento realizado en determinado periodo.
  ***************************************************************************/
  function getArmonizacionDatos($idArmonizacion){
    global $db_siclan;
    $armonziacion = $db_siclan->select("tb_organizacion_armonizacion","*",["PK_Id_Tabla"=>$idArmonizacion]);
    return $armonziacion;
  }

  /***************************************************************************
  /* getArmonizacionesdeOrganizacion consulta el listado de Armonizaciones que ha subido una Organización
  ***************************************************************************/
  function getArmonizacionesdeOrganizacion($organizacion, $year){
    global $db_siclan;
    $armonizaciones = $db_siclan->select("tb_organizacion_armonizacion",[
      "[>]tb_organizacion_seguimiento_propuesta" => ["FK_Id_Seguimiento_Propuesta" => "PK_Id_Tabla"]
    ],
    [
      "tb_organizacion_armonizacion.PK_Id_Tabla",
      "tb_organizacion_armonizacion.FK_Id_Organizacion",
      "tb_organizacion_armonizacion.TX_R1",
      "tb_organizacion_armonizacion.TX_R2",
      "tb_organizacion_armonizacion.TX_R3",
      "tb_organizacion_armonizacion.TX_R4",
      "tb_organizacion_armonizacion.TX_R5",
      "tb_organizacion_armonizacion.TX_R6",
      "tb_organizacion_armonizacion.TX_Observacion",
      "tb_organizacion_armonizacion.IN_Aprobacion",
      "tb_organizacion_armonizacion.DA_Cambio",
      "tb_organizacion_armonizacion.FK_Persona_Revisa",
      "tb_organizacion_armonizacion.FK_Id_Usuario",
      "tb_organizacion_armonizacion.DA_Registro",
      "tb_organizacion_armonizacion.FK_Id_Seguimiento_Propuesta",
      "tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion",
      "tb_organizacion_seguimiento_propuesta.VC_Nit",
      "tb_organizacion_seguimiento_propuesta.VC_Convenio",
      "tb_organizacion_seguimiento_propuesta.DA_Inicio",
      "tb_organizacion_seguimiento_propuesta.DA_Fin",
      "tb_organizacion_seguimiento_propuesta.VC_Areas",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivo_General",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivos_Especificos",
      "tb_organizacion_seguimiento_propuesta.TX_Actividades",
      "tb_organizacion_seguimiento_propuesta.TX_Metas",
      "tb_organizacion_seguimiento_propuesta.TX_Indicadores",
      "tb_organizacion_seguimiento_propuesta.TX_Propuesta",
      "tb_organizacion_seguimiento_propuesta.DA_Registro",
      "tb_organizacion_seguimiento_propuesta.IN_Estado"
    ],
    ["AND"=>["tb_organizacion_armonizacion.FK_Id_Organizacion"=>$organizacion, "tb_organizacion_seguimiento_propuesta.DA_Inicio[~]" => $year]]);
    return $armonizaciones;
  }

  /***************************************************************************
  /* getArchivosArmonizacionesdeOrganizacion consulta el listado de Armonizaciones enviadas como Archivo de una Organización de determinado CONVENIO.
  ***************************************************************************/
  function getArchivosArmonizacionesdeOrganizacion($organizacion,$year){
    global $db_siclan;
    $armonizaciones = $db_siclan->select("tb_organizacion_archivo",[
      "[>]tb_organizacion_seguimiento_propuesta" => ["FK_Id_Seguimiento_Propuesta" => "PK_Id_Tabla"]
    ],
    [
      "tb_organizacion_archivo.PK_Id_Tabla", 
      "tb_organizacion_archivo.FK_Id_Organizacion",
      "tb_organizacion_archivo.VC_Nombre_Archivo",
      "tb_organizacion_archivo.VC_URL",
      "tb_organizacion_archivo.VC_Mes",
      "tb_organizacion_archivo.IN_Anio",
      "tb_organizacion_archivo.VC_Tipo",
      "tb_organizacion_archivo.TX_Observacion",
      "tb_organizacion_archivo.IN_Aprobacion",
      "tb_organizacion_archivo.DA_Cambio",
      "tb_organizacion_archivo.FK_Persona_Revisa",
      "tb_organizacion_archivo.FK_Id_Usuario",
      "tb_organizacion_archivo.DA_Subida",
      "tb_organizacion_archivo.IN_Estado_Final",
      "tb_organizacion_archivo.FK_Id_Seguimiento_Propuesta",
      "tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion",
      "tb_organizacion_seguimiento_propuesta.VC_Nit",
      "tb_organizacion_seguimiento_propuesta.VC_Convenio",
      "tb_organizacion_seguimiento_propuesta.DA_Inicio",
      "tb_organizacion_seguimiento_propuesta.DA_Fin",
      "tb_organizacion_seguimiento_propuesta.VC_Areas",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivo_General",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivos_Especificos",
      "tb_organizacion_seguimiento_propuesta.TX_Actividades",
      "tb_organizacion_seguimiento_propuesta.TX_Metas",
      "tb_organizacion_seguimiento_propuesta.TX_Indicadores",
      "tb_organizacion_seguimiento_propuesta.TX_Propuesta",
      "tb_organizacion_seguimiento_propuesta.DA_Registro",
      "tb_organizacion_seguimiento_propuesta.IN_Estado"
    ],["AND"=>["tb_organizacion_archivo.FK_Id_Organizacion"=>$organizacion, "tb_organizacion_seguimiento_propuesta.DA_Inicio[~]" => $year]]);
    return $armonizaciones;
  }

  /***************************************************************************
  /* getIdArchivoOrganizacion retorna el id de un archivo de acuerdo a la organizacion y el tipo de archivo
  ***************************************************************************/
  function getIdArchivoOrganizacion($meses,$idOrganizacion,$tipo){
    global $db_siclan;
    $idArchivo = $db_siclan->max("tb_organizacion_archivo","PK_Id_Tabla",["AND"=>["FK_Id_Organizacion"=>$idOrganizacion,"VC_Tipo"=>$tipo,"VC_Mes"=>$meses]]);
    return $idArchivo;
  }

  /***************************************************************************
  /*saveRevisionArchivo() almacena la información de la revisión del archivo específicado.
  ***************************************************************************/
  function saveRevisionArchivo($id_persona, $id_archivo, $observacion, $aprobacion, $fecha){
    global $db_siclan;
    $db_siclan->update("tb_organizacion_archivo",
      [
        'TX_Observacion'=>$observacion,
        'IN_Aprobacion'=>$aprobacion,
        'FK_Persona_Revisa'=>$id_persona,
        'DA_Cambio'=>$fecha
      ],
      [
        'PK_Id_Tabla'=>$id_archivo
      ]);
  }

  /***************************************************************************
  /*guardarDatosFormulario() almacena la información de la revisión del archivo específicado.
  ***************************************************************************/
  function guardarDatosFormulario($idOrganizacion,$r_1,$r_2,$r_3,$r_4,$r_5,$r_6,$idUsuario,$fecha,$id_seguimiento_propuesta){
    global $db_siclan;
    return $db_siclan->insert("tb_organizacion_armonizacion",
      [
        'FK_Id_Organizacion' => $idOrganizacion,
        'TX_R1' =>$r_1,
        'TX_R2' =>$r_2,
        'TX_R3' =>$r_3,
        'TX_R4' =>$r_4,
        'TX_R5' =>$r_5,
        'TX_R6' =>$r_6,
        'FK_Id_Usuario' =>$idUsuario,
        'DA_Registro' =>$fecha,
        'FK_Id_Seguimiento_Propuesta' =>$id_seguimiento_propuesta
      ]);
  }

  /***************************************************************************
  /* getAnexosdeArchivo consulta el listado de Archivos que ha subido una Organización
  ***************************************************************************/
  function getAnexosdeArchivo($id_archivo){
    global $db_siclan;
    $anexos = $db_siclan->select("tb_organizacion_archivo_anexo","*",["FK_Id_Archivo"=>$id_archivo]);
    return $anexos;
  }

  /***************************************************************************
  /*saveRevisionArmonizacion() almacena la información de la revisión de la armonziación específicada.
  ***************************************************************************/
  function saveRevisionArmonizacion($id_persona, $id_armonizacion, $observacion, $aprobacion, $fecha){
    global $db_siclan;
    $db_siclan->update("tb_organizacion_armonizacion",
      [
        'TX_Observacion'=>$observacion,
        'IN_Aprobacion'=>$aprobacion,
        'FK_Persona_Revisa'=>$id_persona,
        'DA_Cambio'=>$fecha
      ],
      [
        'PK_Id_Tabla'=>$id_armonizacion
      ]);
  }

  /***************************************************************************
  /*getArchivosSubidosOrganizacion() consulta el listado de archivos subidos y formatos administrativos diligenciados en linea.
  ***************************************************************************/
  function getArchivosSubidosOrganizacion($organizacion, $year, $mes){
    global $db_siclan;
    $archivos_y_formatos = $db_siclan->query("(SELECT
      P.VC_Primer_Nombre,
      P.VC_Segundo_Nombre,
      P.VC_Primer_Apellido,
      P.VC_Segundo_Apellido,
      OA.FK_Id_Organizacion,
      OA.VC_Nombre_Archivo,
      OA.VC_URL,
      OA.VC_Mes,
      OA.VC_Tipo,
      OA.TX_Observacion,
      OA.IN_Aprobacion,
      OA.DA_Subida AS 'fecha_subida'
      FROM tb_organizacion_archivo OA
      JOIN tb_persona_2017 P ON OA.FK_Persona_Revisa = P.PK_Id_Persona
      WHERE OA.FK_Id_Organizacion = '".$organizacion."' AND OA.VC_Mes = UPPER('".$mes."') AND  OA.IN_Anio = '".$year."' AND (OA.IN_Aprobacion = 1 OR OA.TX_Observacion != '')
      AND OA.`VC_Tipo` IN ('INFORME FINANCIERO','REPORTE DE RECURSOS', 'INFORME DE GESTION', 'PROYECCIÓN DEL GASTO')
      ORDER BY OA.DA_Subida DESC)
      UNION ALL
      (SELECT
      PIG.VC_Primer_Nombre,
      PIG.VC_Segundo_Nombre,
      PIG.VC_Primer_Apellido,
      PIG.VC_Segundo_Apellido,
      ORG.PK_Id_Organizacion,
      'FORMATO INFORME DE GESTIÓN',
      'SIN URL',
      UPPER('".$mes."'),
      'EN LÍNEA',
      IG.`TX_Observaciones`,
      IG.`IN_Aprobacion`,
      IG.DA_Registro AS 'fecha_subida'
      FROM `tb_organizacion_informe_gestion` IG
      JOIN `tb_persona_2017` PIG ON IG.`FK_Persona_Revisa` = PIG.PK_Id_Persona
      JOIN `tb_organizaciones_2017` ORG ON IG.FK_Id_Organizacion = ORG.FK_Coordinador
      WHERE ORG.PK_Id_Organizacion='".$organizacion."' AND (IG.`IN_Aprobacion`=1 OR IG.`TX_Observaciones` != '') AND IG.VC_Periodo LIKE UPPER('%".$mes."%') AND IG.IN_Anio= '".$year."')
      UNION ALL
      (SELECT
      PPG.VC_Primer_Nombre,
      PPG.VC_Segundo_Nombre,
      PPG.VC_Primer_Apellido,
      PPG.VC_Segundo_Apellido,
      PG.FK_Organizacion_Id,
      'FORMATO PROYECCIÓN DEL GASTO',
      'SIN URL',
      UPPER('".$mes."'),
      'EN LÍNEA',
      PG.`TX_Observaciones`,
      PG.`IN_Aprobacion`,
      PG.DT_Fecha_Registro AS 'fecha_subida'
      FROM `tb_organizaciones_proyeccion_gasto` PG
      JOIN `tb_persona_2017` PPG ON PG.`FK_Persona_Revisa` = PPG.PK_Id_Persona
      WHERE PG.FK_Organizacion_Id='".$organizacion."' AND (PG.`IN_Aprobacion`=1 OR PG.`TX_Observaciones` != '') AND PG.TX_Periodo LIKE UPPER('%".$mes."%') AND PG.IN_Anio= '".$year."') ORDER BY fecha_subida DESC;")->fetchAll();
    return $archivos_y_formatos;
  }

  /***************************************************************************
  /*guardarInfoContractual() almacena la información del encabezado de los Informes de Gestión (Información relacionada al contrato de la organización).
  ***************************************************************************/
  function guardarInfoContractual($Id_Usuario,$Nombre_Proyecto,$Representante_Legal,$Objeto_Contrato,$Obligaciones,$CifrasRecursos,$ActividadesRealizadas,$PoblacionBeneficiada,$ArtistasBeneficiados,$Difusion,$Fecha_Registro,$id_seguimiento_propuesta){
    global $db_siclan;
    $id_info_contractual = $db_siclan->insert("tb_organizacion_info_contractual",[
      'FK_Id_Organizacion'=>$Id_Usuario,
      'TX_Nombre_Proyecto'=>$Nombre_Proyecto,
      'VC_Representante_Legal'=>$Representante_Legal,
      'TX_Objeto_Contrato'=>$Objeto_Contrato,
      'TX_Obligaciones_Idartes'=>$Obligaciones,
      'TX_Cifras_Recursos'=>$CifrasRecursos,
      'TX_Actividades_Realizadas'=>$ActividadesRealizadas,
      'TX_Poblacion_Beneficiada'=>$PoblacionBeneficiada,
      'IN_Artistas_Beneficiados'=>$ArtistasBeneficiados,
      'TX_Difusion'=>$Difusion,
      'DA_Registro'=>$Fecha_Registro,
      'FK_Id_Seguimiento_Propuesta'=>$id_seguimiento_propuesta
    ]);
    return $id_info_contractual;
  }

  /***************************************************************************
  /*actualizarInfoContractual() actualiza la información de esta tabla para el ultimo informe.
  ***************************************************************************/
  function actualizarInfoContractual($Id_Usuario,$CifrasRecursos,$ActividadesRealizadas,$PoblacionBeneficiada,$ArtistasBeneficiados,$Difusion,$id_info_contractual){
    global $db_siclan;
    $db_siclan->update("tb_organizacion_info_contractual",[
      'TX_Cifras_Recursos'=>$CifrasRecursos,
      'TX_Actividades_Realizadas'=>$ActividadesRealizadas,
      'TX_Poblacion_Beneficiada'=>$PoblacionBeneficiada,
      'IN_Artistas_Beneficiados'=>$ArtistasBeneficiados,
      'TX_Difusion'=>$Difusion
    ],
    ["AND"=>["FK_Id_Organizacion"=>$Id_Usuario, "PK_Id_Tabla"=>$id_info_contractual]]);
  }

  /***************************************************************************
  /*guardarInformeDeGestion() almacena la información del seguimiento realizado.
  ***************************************************************************/
  function guardarInformeDeGestion($Id_Usuario,$Numero_Informe,$Periodo,$Anio,$Correo,$DetalleActividades,$Fecha_Registro,$bandera_existencia){
    global $db_siclan;
    $db_siclan->insert("tb_organizacion_informe_gestion",[
      'FK_Id_Organizacion'=>$Id_Usuario,
      'VC_Informe'=>$Numero_Informe,
      'VC_Periodo'=>$Periodo,
      'IN_Anio'=>$Anio,
      'VC_Correo'=>$Correo,
      'TX_Detalle_Actividades'=>$DetalleActividades,
      'DA_Registro'=>$Fecha_Registro,
      'FK_Id_Info_Contractual'=>$bandera_existencia
    ]);
  }


  /***************************************************************************
  /*guardarSeguimientoGasto() almacena la información principal del seguimiento al gasto.
  ***************************************************************************/
  function guardarSeguimientoGasto($organizacionId,$fechaRegistro,$arrayIdartes,$arrayAsociadoTotal,$arrayCaja,$arrayEgresos,$arrayGrupos,$idUsuario,$proyecto,$periodoProyeccion,$rubrosProyeccion,$anio,$id_seguimiento_propuesta){
    global $db_siclan;
    $seguimientoId = $db_siclan->insert("tb_organizaciones_proyeccion_gasto",[
      'FK_Organizacion_Id' => $organizacionId,
      'TX_Periodo' => $periodoProyeccion,
      'IN_Anio' => $anio,
      'TX_Total_Idartes' => $arrayIdartes,
      'TX_Total_Asociado' => $arrayAsociadoTotal,
      'TX_Caja' => $arrayCaja,
      'TX_Egresos' => $arrayEgresos,
      'TX_Grupos' => $arrayGrupos,
      'VC_Rubros' => $rubrosProyeccion,
      'FK_Persona_Registro' => $idUsuario,
      'DT_Fecha_Registro' => $fechaRegistro,
      'FK_Id_Seguimiento_Propuesta' => $id_seguimiento_propuesta,
      'FK_Proyecto' => $proyecto
    ]);
    return $seguimientoId;
  }

  /***************************************************************************
  /*guardarDesembolso() almacena la información del un desembolso delacionado a un formato de seguimineto al gasto.
  ***************************************************************************/
  function guardarDesembolso($formatoId,$n_item,$tx_datos,$ejecucion_anterior){
    global $db_siclan;
    $db_siclan->insert("tb_organizaciones_proyeccion_desembolso",[
      'FK_Seguimiento_Gasto_Id' => $formatoId,
      'IN_Numero_Desembolso' => $n_item,
      'TX_Datos' => $tx_datos,
      'TX_ejecucion_anterior' => $ejecucion_anterior
    ]);
  }

  /***************************************************************************
  /*guardarAportes() almacena los aportes realizados por un formato de seguimineto al gasto
  ***************************************************************************/
  function guardarAportes($formatoId,$tabla,$item,$tipo,$tx_datos){
    global $db_siclan;
    $db_siclan->insert("tb_organizaciones_proyeccion_aportes",[
      'FK_Seguimiento_Gasto_Id' => $formatoId,
      'IN_Tabla' => $tabla,
      'IN_Item' => $item,
      'TX_Datos' => $tx_datos,
      'IN_Tipo' => $tipo
    ]);
  }
   /***************************************************************************
  /*getInformeDeProyeccion() carga.
  ***************************************************************************/
  function getInformeDeProyeccion($idInforme){
    global $db_siclan;
    return $db_siclan->query("SELECT
      tb_organizaciones_proyeccion_gasto.PK_Seguimiento_Gasto_Id,
      tb_organizaciones_proyeccion_gasto.FK_Organizacion_Id,
      tb_organizaciones_proyeccion_gasto.TX_Periodo,
      tb_organizaciones_proyeccion_gasto.IN_Anio,
      tb_organizaciones_proyeccion_gasto.TX_Total_Idartes,
      tb_organizaciones_proyeccion_gasto.TX_Total_Asociado,
      tb_organizaciones_proyeccion_gasto.TX_Caja,
      tb_organizaciones_proyeccion_gasto.TX_Egresos,
      tb_organizaciones_proyeccion_gasto.TX_Grupos,
      tb_organizaciones_proyeccion_gasto.VC_Rubros,
      tb_organizaciones_proyeccion_gasto.FK_Persona_Registro,
      tb_organizaciones_proyeccion_gasto.DT_Fecha_Registro,
      tb_organizaciones_proyeccion_gasto.TX_Observaciones,
      tb_organizaciones_proyeccion_gasto.IN_Aprobacion,
      tb_organizaciones_proyeccion_gasto.FK_Persona_Revisa,
      tb_organizaciones_proyeccion_gasto.DA_Cambio,
      tb_organizaciones_proyeccion_gasto.FK_Proyecto,
      tb_organizacion_seguimiento_propuesta.VC_Convenio,
      tb_organizaciones_2017.VC_Nom_Organizacion,
      tb_organizacion_seguimiento_propuesta.PK_Id_Tabla AS 'id_seguimiento_propuesta'
      FROM tb_organizaciones_proyeccion_gasto
      LEFT JOIN tb_organizaciones_2017 ON tb_organizaciones_proyeccion_gasto.FK_Organizacion_Id = tb_organizaciones_2017.PK_Id_Organizacion
      LEFT JOIN tb_organizacion_seguimiento_propuesta ON tb_organizacion_seguimiento_propuesta.PK_Id_Tabla = tb_organizaciones_proyeccion_gasto.FK_Id_Seguimiento_Propuesta
      WHERE tb_organizaciones_proyeccion_gasto.PK_Seguimiento_Gasto_Id =".$idInforme)->fetchAll();
  }

 /***************************************************************************
  /*getDesembolsosProyeccion() almacena la información de la revisión de la armonziación específicada.
  ***************************************************************************/
  function getDesembolsosProyeccion($idInforme){
    global $db_siclan;
    return $db_siclan->select("tb_organizaciones_proyeccion_desembolso","*",["FK_Seguimiento_Gasto_Id"=>$idInforme]);
  }

 /***************************************************************************
  /*getAportesProyeccion() almacena la información de la revisión de la armonziación específicada.
  ***************************************************************************/
  function getAportesProyeccion($idInforme){
    global $db_siclan;
    return $db_siclan->select("tb_organizaciones_proyeccion_aportes","*",["FK_Seguimiento_Gasto_Id"=>$idInforme]);
  }

/***************************************************************************
  /*getInformacionOrganizacion() consulta alguna informacion extra que se necesita para mostrar en el PDF del Informe de Gestión.
  ***************************************************************************/
  function getInformacionOrganizacion($id_organizacion){
    global $db_siclan;
    return $db_siclan->select("tb_organizacion_seguimiento_propuesta",[
      "[>]tb_organizaciones_2017" => ["FK_Id_Organizacion" => "FK_Coordinador"]
    ],
    [
      "tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion",
      "tb_organizacion_seguimiento_propuesta.VC_Nit",
      "tb_organizacion_seguimiento_propuesta.VC_Convenio",
      "tb_organizacion_seguimiento_propuesta.DA_Inicio",
      "tb_organizacion_seguimiento_propuesta.DA_Fin",
      "tb_organizacion_seguimiento_propuesta.VC_Areas",
      "tb_organizaciones_2017.VC_Nom_Organizacion"
    ],
    ["FK_Id_Organizacion"=>$id_organizacion]);
  }

  /***************************************************************************
  /*actualizarEstadoDeFAS() actualiza el estado de un Formato Administrativo (FA)
  ***************************************************************************/
  function actualizarEstadoDeFAS($tipo_formato,$id_formato, $estado, $usuario){
    global $db_siclan;
    $db_siclan->query("SET @user_id = ".$usuario.";");
    if($tipo_formato=='INFORME DE GESTIÓN'){
      $db_siclan->update("tb_organizacion_informe_gestion",
        [
          'IN_Estado_Final'=>$estado
        ],
        [
          'PK_Id_Tabla'=>$id_formato
        ]);
    }
    if($tipo_formato=='PROYECCIÓN Y SEGUIMIENTO DEL GASTO'){
      $db_siclan->update("tb_organizaciones_proyeccion_gasto",
        [
          'IN_Estado_Final'=>$estado
        ],
        [
          'PK_Seguimiento_Gasto_Id'=>$id_formato
        ]);
    }
  }

  /***************************************************************************
  /*actualizarEstadoArchivo() actualiza el estado de un archivo Administrativo.
  ***************************************************************************/
  function actualizarEstadoDeArchivo($id_archivo, $estado, $usuario){
    global $db_siclan;
    $db_siclan->query("SET @user_id = ".$usuario.";");
    $db_siclan->update("tb_organizacion_archivo",
      [
        'IN_Estado_Final'=>$estado
      ],
      [
        'PK_Id_Tabla'=>$id_archivo
      ]);
  }

  /***************************************************************************
  /* consultarExisteSeguimientoPropuesta consulta los datos del seguimiento a la propuesta activo de una organización.
  ***************************************************************************/
  function consultarExisteSeguimientoPropuesta($id_organizacion){
    global $db_siclan;
    $seguimiento = $db_siclan->select("tb_organizacion_seguimiento_propuesta",
      "*",
      ["AND"=>["tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion"=>$id_organizacion, "tb_organizacion_seguimiento_propuesta.IN_Estado"=>1]]);
    return $seguimiento;
  }

  /***************************************************************************
  /* getEncabezadoConsolidadoDeSeguimientos($id_organizacion,$anio) consulta los datos del encabezado de seguimiento de una organizacion según el AÑO DEL CONVENIO.
  ***************************************************************************/

  function getEncabezadoConsolidadoDeSeguimientos($id_organizacion, $anio){
    global $db_siclan;
    $encabezado = $db_siclan->select("tb_organizacion_seguimiento_propuesta",[
      "[>]tb_organizaciones_2017" => ["FK_Id_Organizacion" => "FK_Coordinador"]
    ],
    [
      "tb_organizacion_seguimiento_propuesta.PK_Id_Tabla",
      "tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion",
      "tb_organizacion_seguimiento_propuesta.VC_Nit",
      "tb_organizacion_seguimiento_propuesta.VC_Convenio",
      "tb_organizacion_seguimiento_propuesta.DA_Inicio",
      "tb_organizacion_seguimiento_propuesta.DA_Fin",
      "tb_organizacion_seguimiento_propuesta.VC_Areas",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivo_General",
      "tb_organizacion_seguimiento_propuesta.TX_Objetivos_Especificos",
      "tb_organizacion_seguimiento_propuesta.TX_Actividades",
      "tb_organizacion_seguimiento_propuesta.TX_Metas",
      "tb_organizacion_seguimiento_propuesta.TX_Indicadores",
      "tb_organizacion_seguimiento_propuesta.TX_Propuesta",
      "tb_organizacion_seguimiento_propuesta.DA_Registro",
      "tb_organizaciones_2017.VC_Nom_Organizacion"
    ],
    ["AND"=>["FK_Id_Organizacion"=>$id_organizacion, "tb_organizacion_seguimiento_propuesta.DA_Inicio[~]"=>$anio]]);
    return $encabezado;
  }

  /***************************************************************************
  /* getConveniosDeOrganizacion consulta los convenios que ha tenido una organizacion.
  ***************************************************************************/
  function getConveniosDeOrganizacion($id_organizacion){
    global $db_siclan;
    $convenios_organizacion = $db_siclan->select("tb_organizacion_seguimiento_propuesta",
      "*",
      ["tb_organizacion_seguimiento_propuesta.FK_Id_Organizacion"=>$id_organizacion]);
    return $convenios_organizacion;
  }
  ?>
