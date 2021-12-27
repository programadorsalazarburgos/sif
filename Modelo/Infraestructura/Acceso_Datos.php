<?php
/**
* Clase que realiza las operaciones de acceso a la base de datos.
* Área de Sistemas
* @author: Juan Modesto
* @version: 1.0.1
*/

//header ('Content-type: text/html; charset=utf-8');
require_once('../../../Modelo/medoo/medoo.php');
require_once('../../../Modelo/medoo/parametros_conexion.php');
Class Inventario{
  /**
  * Retorna un vector con el listado de los tipos de documentos
  * @return vector con el tipo de documentos
  */
  public static function listarClanes($estado_clan)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    global $db_siclan;
    $lista_clanes = $db_siclan->select("tb_clan","*",["IN_Estado"=>$estado_clan]);
    return $lista_clanes;
  }

/**
  * Retorna un vector con el listado de los tipo bien existentes en la base de datos
  * @return vector con los tipo bien
  */
public static function listarTipoBien()
{
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
  global $db_siclan;
  $tipobien = $db_siclan->select("tb_parametro_detalle","*",["AND"=>["FK_Id_Parametro[=]"=>24,"IN_Estado[=]"=>1]]);
  return $tipobien;
}

/**
  * Retorna un vector con el listado de los elementos existentes en la base de datos
  * @return vector de elementos
  */
public static function listarElementos()
{
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
  global $db_siclan;
  $elementos = $db_siclan->select("tb_parametro_detalle","*",["AND"=>["FK_Id_Parametro[=]"=>22,"IN_Estado[=]"=>1]]);
  return $elementos;
}

/**
  * Retorna un vector con el listado de los distintos donantes existentes en la base de datos
  * @return vector de donantes
  */
public static function listarDonantes()
{
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
  global $db_siclan;
  $donantes = $db_siclan->query("SELECT DISTINCT(VC_Donante) FROM tb_inf_inventario_clan WHERE VC_Donante!='';");
  return $donantes;
}

  /**
  * Retorna un vector con el listado de las subcategorias existentes en la base de datos parauna categoria especifica.
  * @return vector de subcategorias
  */
  public static function listarEstadosBien()
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    global $db_siclan;
    $estadosbien = $db_siclan->select("tb_parametro_detalle","*",["AND"=>["FK_Id_Parametro[=]"=>23,"IN_Estado[=]"=>1]]);
    return $estadosbien;
  }

  /**
  * Retorna un vector con el listado de las distintas descripciones existentes en la base de datos
  * @return vector de descripciones
  */
  public static function listarDescripciones()
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    global $db_siclan;
    $descripciones = $db_siclan->query("SELECT DISTINCT(VC_Descripcion) FROM tb_inf_inventario_clan WHERE VC_Descripcion!='' ORDER BY VC_Descripcion;");
    return $descripciones;
  }

  public static function validarPlaca($placa, $id)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    global $db_siclan;
    $existencia = $db_siclan->query("CALL sp_inf_existencia_placa('".$placa."','".$id."');")->fetchAll(\PDO::FETCH_ASSOC);
    return count($existencia);
  }

  public static function insertarInventario($id_clan,$cantidad, $tipo_bien, $placa, $elemento, $descripcion, $estado, $valor_inicial, $donante, $valor_total,$fecha_registro,$usuario)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    global $db_siclan;
    $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
    $set_id->execute([$usuario]);
    $result = $db_siclan->query("CALL sp_inf_insertar_inventario('".$id_clan."','".$cantidad."','".$tipo_bien."','".$placa."','".$elemento."','".$descripcion."','".$estado."','".$valor_inicial."','".$donante."','".$valor_total."','".$fecha_registro."','".$usuario."');");
    return $result;
  }

  public static function consultarInventario($placa, $id_clan, $id_elemento, $descripcion, $id_tipo_bien, $estado_baja)
  {
    global $db_siclan;
    $inventario = $db_siclan->query("CALL sp_inf_consultar_inventario('".$placa."','".$id_clan."','".$id_elemento."','".$descripcion."','".$id_tipo_bien."','".$estado_baja."');");
    return $inventario;
  }
  public static function actualizarInventario($id_inventario, $id_clan,$cantidad, $tipo_bien, $placa, $elemento, $descripcion, $estado, $valor_inicial, $donante, $valor_total,$usuario)
  {
    global $db_siclan;
    $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
    $set_id->execute([$usuario]);
    $db_siclan->query("CALL sp_inf_actualizar_inventario('".$id_inventario."','".$id_clan."','".$cantidad."','".$tipo_bien."','".$placa."','".$elemento."','".$descripcion."','".$estado."','".$valor_inicial."','".$donante."','".$valor_total."');");
  }
  public static function darBaja($id_inventario,$usuario)
  {
    global $db_siclan;
    $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
    $set_id->execute([$usuario]);
    $baja = $db_siclan->query("UPDATE tb_inf_inventario_clan SET IN_Estado_Baja=2 WHERE PK_Id_Inventario='".$id_inventario."';");
    return $baja;
  }
  public static function quitarBaja($id_inventario,$usuario)
  {
    global $db_siclan;
    $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
    $set_id->execute([$usuario]);
    $baja = $db_siclan->query("UPDATE tb_inf_inventario_clan SET IN_Estado_Baja=1 WHERE PK_Id_Inventario='".$id_inventario."';");
  }
  public static function consultarObservaciones($id)
  {
    global $db_siclan;
    $observaciones = $db_siclan->query("SELECT C.PK_Id_Control_Inventario,C.DA_Fecha,C.FK_Id_Inventario,C.VC_Observacion,PDES.VC_Descripcion AS Estado,CONCAT(VC_Primer_Nombre,'" .' '."',VC_Primer_Apellido) AS nombre FROM tb_inf_control_inventario C JOIN tb_persona_2017 P ON P.PK_Id_Persona=C.FK_Id_Persona JOIN tb_parametro_detalle PDES ON C.IN_Estado=PDES.FK_Value AND PDES.FK_Id_Parametro=23 WHERE FK_Id_Inventario='".$id."' ORDER BY DA_Fecha DESC");
    return $observaciones;
  }
  public static function consultarTraslados($id)
  {
    global $db_siclan;
    $traslados = $db_siclan->query("SELECT T.PK_Id_Traslado,T.DA_Fecha_Solicitud,T.FK_Id_Inventario, T.VC_Tipo_Traslado, T.IN_Cantidad AS Cantidad,T.TX_Argumento, T.FK_Origen, T.FK_Destino, T.IN_Estado, T.TX_Observacion, T.FK_Persona_Revisa, T.TX_Numero_Traslado, T.DA_Fecha_Traslado, T.TX_Consecutivo_Salida, PDO.VC_Descripcion AS Origen, PDD.VC_Descripcion AS Destino, CONCAT(P.VC_Primer_Nombre,'" .' '."',P.VC_Primer_Apellido) AS Solicitante, CASE WHEN T.IN_Estado IS NULL THEN 'Sin revisar' WHEN T.IN_Estado = 0 THEN 'Denegado' WHEN T.IN_Estado = 1 THEN 'Aprobado' END AS 'Estado', CONCAT(PU.VC_Primer_Nombre,'" .' '."',PU.VC_Primer_Apellido) AS Usuario_Revisa, T.DA_Fecha_Revision AS Fecha_Revision FROM tb_inf_traslado T JOIN tb_persona_2017 P ON P.PK_Id_Persona=T.FK_Persona_Solicita LEFT JOIN tb_persona_2017 PU ON PU.PK_Id_Persona=T.FK_Persona_Revisa JOIN tb_parametro_detalle PDO ON PDO.FK_Value=T.FK_Origen AND PDO.FK_Id_Parametro=27 JOIN tb_parametro_detalle PDD ON PDD.FK_Value=T.FK_Destino AND PDD.FK_Id_Parametro=27 WHERE FK_Id_Inventario='".$id."' OR FK_Id_Inventario_Destino='".$id."' ORDER BY T.DA_Fecha_Solicitud DESC;");
    return $traslados;
  }
  public static function guardarObservacion($fecha, $id_inventario, $usuario, $observacion, $estado)
  {
    global $db_siclan;
    $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
    $set_id->execute([$usuario]);
    $db_siclan->query("INSERT INTO tb_inf_control_inventario (DA_Fecha, FK_Id_Inventario, FK_Id_Persona, VC_Observacion, IN_Estado) VALUES ('".$fecha."', '".$id_inventario."', '".$usuario."', '".$observacion."', '".$estado."')");
    $db_siclan->query("UPDATE tb_inf_inventario_clan SET FK_Id_Estado = '".$estado."' WHERE PK_Id_Inventario='".$id_inventario."';");
  }
  public static function deleteObservacion($id_observacion,$usuario, $fecha_observacion)
  {
   global $db_siclan;
   date_default_timezone_set('America/Lima');
   $fecha_actual = date("Y-m-d H:i:s");
   $diferencia = $db_siclan->query("SELECT TIMESTAMPDIFF(SECOND, '".$fecha_observacion."', '".$fecha_actual."') AS DIFERENCIA;")->fetchAll(PDO::FETCH_ASSOC);
   if($diferencia[0]['DIFERENCIA'] > 86400){
    return 0;
  }
  else{
   $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
   $set_id->execute([$usuario]);
   $filas_afectadas = $db_siclan->delete("tb_inf_control_inventario",["PK_Id_Control_Inventario"=>$id_observacion]);
   return $filas_afectadas;
 }
}
public static function guardarSolicitudTraslado($id_inventario, $tipo_traslado, $fecha, $id_usuario, $origen, $destino, $cantidad, $argumento)
{
  global $db_siclan;
  $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
  $set_id->execute([$id_usuario]);
  $db_siclan->query("INSERT INTO tb_inf_traslado (FK_Id_Inventario, DA_Fecha_solicitud, FK_Persona_Solicita, FK_Origen, FK_Destino, IN_Cantidad, VC_Tipo_Traslado, TX_Argumento) VALUES ('".$id_inventario."', '".$fecha."', '".$id_usuario."', '".$origen."', '".$destino."', '".$cantidad."', '".$tipo_traslado."', '".$argumento."')");
}
public static function consultarCreaUsuario($id_usuario)
{
  global $db_siclan;
  $id_crea = 0;
  $resultado = $db_siclan->query("
    SELECT C.FK_Lugar_Inventario FROM tb_clan C 
    JOIN tb_parametro_detalle PD ON PD.FK_Value=C.FK_Lugar_Inventario AND PD.FK_Id_Parametro=27
    WHERE FIND_IN_SET('".$id_usuario."',C.FK_Auxiliares) OR FIND_IN_SET('".$id_usuario."',C.FK_Asistentes) OR FIND_IN_SET('".$id_usuario."',C.FK_Persona_Administrador);");
  foreach ($resultado as $res){
    $id_crea = $res['FK_Lugar_Inventario'];
  }
  return $id_crea;
}
public static function deleteTraslado($id_traslado,$usuario)
{
 global $db_siclan;
 $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
 $set_id->execute([$usuario]);
 $db_siclan->delete("tb_inf_traslado",["PK_Id_Traslado"=>$id_traslado]);
}
public static function actualizarObservacionEstadoTraslado($id_traslado, $estado, $observacion, $id_usuario, $fecha)
{
  global $db_siclan;
  try {
    $db_siclan->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_siclan->pdo->beginTransaction();
    $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
    $set_id->execute([$id_usuario]);
    $db_siclan->pdo->commit();
    $db_siclan->pdo->beginTransaction();
    $db_siclan->pdo->exec("UPDATE tb_inf_traslado SET IN_Estado='".$estado."', TX_Observacion='".$observacion."', FK_Persona_Revisa='".$id_usuario."', DA_Fecha_Revision='".$fecha."' WHERE PK_Id_Traslado='".$id_traslado."';");
    $db_siclan->pdo->commit();
    return 1;
  } catch (PDOExecption $e) {
    $db_siclan->pdo->rollBack();
    return 0;
  }
}
public static function actualizarCreaPorTraslado($id_inventario, $id_destino, $id_usuario, $id_traslado, $estado, $observacion, $fecha, $bandera_baja)
{
  global $db_siclan;
  try {
   $db_siclan->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $db_siclan->pdo->beginTransaction();
   $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
   $set_id->execute([$id_usuario]);
   $db_siclan->pdo->commit();
   $db_siclan->pdo->beginTransaction();
   $db_siclan->pdo->exec("UPDATE tb_inf_inventario_clan SET FK_Id_Clan='".$id_destino."' WHERE PK_Id_Inventario='".$id_inventario."';");
   $db_siclan->pdo->exec("UPDATE tb_inf_traslado SET FK_Id_Inventario_Destino='".$id_inventario."' ,IN_Estado='".$estado."', TX_Observacion='".$observacion."', FK_Persona_Revisa='".$id_usuario."', DA_Fecha_Revision='".$fecha."' WHERE PK_Id_Traslado='".$id_traslado."';");
   if($bandera_baja=="SI"){
     $db_siclan->pdo->exec("UPDATE tb_inf_inventario_clan SET IN_Estado_Baja=2 WHERE PK_Id_Inventario='".$id_inventario."';");
   }
   $db_siclan->pdo->commit();
   return 1;
 } catch (PDOExecption $e) {
   $db_siclan->pdo->rollBack();
   return 0;
 }
 return;
}
public static function consultarCoincidenciasParaTraslado($id_inventario,$id_destino){
  global $db_siclan;
  $coincidencias = $db_siclan->query("SELECT COINCIDENCIA.* FROM (SELECT INV.* FROM tb_inf_inventario_clan INV WHERE INV.PK_Id_Inventario='".$id_inventario."') ELEMENTO 
    JOIN tb_inf_inventario_clan COINCIDENCIA WHERE COINCIDENCIA.VC_Descripcion = ELEMENTO.VC_Descripcion AND COINCIDENCIA.FL_Valor_Unitario_Inicial = ELEMENTO.FL_Valor_Unitario_Inicial AND COINCIDENCIA.FK_Id_Elemento=1 AND COINCIDENCIA.IN_Estado_Baja=1 AND COINCIDENCIA.FK_Id_Clan='".$id_destino."';")->fetchAll(PDO::FETCH_ASSOC);
  return $coincidencias;
}
public static function crearElementoIdenticoEnInventario($id_inventario, $id_destino, $cantidad, $id_usuario, $id_traslado, $estado, $observacion, $fecha, $bandera_baja)
{
  global $db_siclan;
  try{
    $db_siclan->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_siclan->pdo->beginTransaction();
    $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
    $set_id->execute([$id_usuario]);
    $db_siclan->pdo->commit();
    $db_siclan->pdo->beginTransaction();
    $db_siclan->pdo->exec("INSERT INTO tb_inf_inventario_clan (FK_Id_Clan,IN_Cantidad,FK_Id_Tipo_Bien,VC_Placa,FK_Id_Elemento,VC_Descripcion,FK_Id_Estado,FL_Valor_Unitario_Inicial,VC_Donante,FL_Valor_Total,IN_Estado_Baja,DA_Fecha_Registro,FK_Usuario) SELECT '".$id_destino."', '".$cantidad."', IC.FK_Id_Tipo_Bien, IC.VC_Placa, IC.FK_Id_Elemento, IC.VC_Descripcion, IC.FK_Id_Estado, IC.FL_Valor_Unitario_Inicial, IC.VC_Donante, (IC.FL_Valor_Unitario_Inicial*'".$cantidad."'), IC.IN_Estado_Baja, '".$fecha."', '".$id_usuario."' FROM tb_inf_inventario_clan IC WHERE IC.PK_Id_Inventario='".$id_inventario."';");
    $id_insertado = $db_siclan->pdo->lastInsertId();
    $db_siclan->pdo->exec("UPDATE tb_inf_inventario_clan IC SET IC.FL_Valor_Total=(IC.FL_Valor_Unitario_Inicial*(IC.IN_Cantidad-'".$cantidad."')), IC.IN_Cantidad=(IC.IN_Cantidad-'".$cantidad."') WHERE IC.PK_Id_Inventario='".$id_inventario."';");
    if($bandera_baja=="SI"){
      $db_siclan->pdo->exec("UPDATE tb_inf_inventario_clan SET IN_Estado_Baja=2 WHERE PK_Id_Inventario='".$id_insertado."';");
    }
    $db_siclan->pdo->exec("UPDATE tb_inf_traslado SET FK_Id_Inventario_Destino='".$id_insertado."', IN_Estado='".$estado."', TX_Observacion='".$observacion."', FK_Persona_Revisa='".$id_usuario."', DA_Fecha_Revision='".$fecha."' WHERE PK_Id_Traslado='".$id_traslado."';");
    $db_siclan->pdo->commit();
    return 1;
  }
  catch(PDOExecption $e){
    $db_siclan->pdo->rollBack();
    return 0;
  }
  return;
}

public static function fusionarElementosPorTraslado($id_inventario, $id_destino, $cantidad, $restantes, $id_usuario, $id_traslado, $estado, $observacion, $fecha, $bandera_baja)
{
  global $db_siclan;
  $info_coincidencia = self::consultarCoincidenciasParaTraslado($id_inventario,$id_destino);
  $coincidencia_id = $info_coincidencia[0]['PK_Id_Inventario'];
  $coincidencia_cantidad = $info_coincidencia[0]['IN_Cantidad'];
  $coincidencia_valor_unitario = $info_coincidencia[0]['FL_Valor_Unitario_Inicial'];
  $coincidencia_valor_total = $info_coincidencia[0]['FL_Valor_Total'];
  
  $cantidad_fusion = $coincidencia_cantidad+$cantidad;
  $valor_total_fusion = $cantidad_fusion*$coincidencia_valor_unitario;
  try{
    $db_siclan->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_siclan->pdo->beginTransaction();
    $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
    $set_id->execute([$id_usuario]);
    $db_siclan->pdo->commit();
    $db_siclan->pdo->beginTransaction();
    $db_siclan->pdo->exec("UPDATE tb_inf_inventario_clan SET IN_Cantidad='".$cantidad_fusion."', FL_Valor_Total='".$valor_total_fusion."' WHERE PK_Id_Inventario='".$coincidencia_id."';");
    $db_siclan->pdo->exec("UPDATE tb_inf_inventario_clan SET IN_Cantidad=(IN_Cantidad-'".$cantidad."'), FL_Valor_Total=IN_Cantidad*FL_Valor_Unitario_Inicial WHERE PK_Id_Inventario='".$id_inventario."';");
    if($cantidad == $restantes){
      $db_siclan->pdo->exec("UPDATE tb_inf_inventario_clan SET IN_Estado_Baja=2 WHERE PK_Id_Inventario='".$id_inventario."';");
    }
    else{
      if($bandera_baja=="SI"){
        $db_siclan->pdo->exec("UPDATE tb_inf_inventario_clan SET IN_Estado_Baja=2 WHERE PK_Id_Inventario='".$coincidencia_id."';");
      }
    }
    $db_siclan->pdo->exec("UPDATE tb_inf_traslado SET FK_Id_Inventario_Destino='".$coincidencia_id."', IN_Estado='".$estado."', TX_Observacion='".$observacion."', FK_Persona_Revisa='".$id_usuario."', DA_Fecha_Revision='".$fecha."' WHERE PK_Id_Traslado='".$id_traslado."';");
    $db_siclan->pdo->commit();
    return 1;
  }
  catch(PDOExecption $e){
    $db_siclan->pdo->rollBack();
    return 0;
  }
  return;
}

public static function actualizarInfoComplementariaTraslado($id_traslado, $numero_traslado, $fecha_traslado, $consecutivo_salida, $usuario, $fecha)
{
  global $db_siclan;
  $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
  $set_id->execute([$usuario]);
  $result = $db_siclan->query("UPDATE tb_inf_traslado SET TX_Numero_Traslado='".$numero_traslado."', DA_Fecha_Traslado='".$fecha_traslado."', TX_Consecutivo_Salida='".$consecutivo_salida."' WHERE PK_Id_Traslado='".$id_traslado."';");
}
}

Class fichaCrea {
  public static function getInfoGeneralCrea($id_crea)
  {
    global $db_siclan;
    $info_crea = $db_siclan->query("SELECT C.*,L.*, P.VC_Correo, Z.*, CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido) AS 'Coordinador' FROM tb_clan C JOIN tb_localidades L ON C.FK_Id_Localidad = L.PK_Id_Localidad LEFT JOIN tb_zona_clan ZC ON ZC.FK_clan = C.PK_Id_Clan JOIN tb_zonas Z ON Z.PK_Id_Zona = ZC.FK_zona JOIN tb_persona_2017 P ON C.FK_Persona_Administrador=P.PK_Id_Persona WHERE C.PK_Id_Clan='".$id_crea."';")->fetchAll(PDO::FETCH_ASSOC);
    return $info_crea;
  }
  public static function getInfoAsistentesCrea($id_crea)
  {
    global $db_siclan;
    $info_crea = $db_siclan->query("SELECT P.PK_Id_Persona,CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS nombre_asistente,
      P.VC_Celular AS celular, P.VC_Correo AS 'email_asistente'
      FROM tb_persona_2017 AS P
      WHERE FIND_IN_SET(P.`PK_Id_Persona`, 
      (
      SELECT 
      C.`FK_Asistentes` AS 'Asistentes'
      FROM tb_clan C
      WHERE C.`PK_Id_Clan`='".$id_crea."'));")->fetchAll(PDO::FETCH_ASSOC);
    return $info_crea;
  }
  public static function getInfoAuxiliaresOperativosCrea($id_crea)
  {
    global $db_siclan;
    $info_crea = $db_siclan->query("SELECT P.PK_Id_Persona,CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS nombre_auxiliar,
      P.VC_Celular AS celular, P.VC_Correo AS 'email_auxiliar'
      FROM tb_persona_2017 AS P
      WHERE FIND_IN_SET(P.`PK_Id_Persona`, 
      (
      SELECT 
      C.`FK_Auxiliares` AS 'Auxiliares'
      FROM tb_clan C
      WHERE C.`PK_Id_Clan`='".$id_crea."'));")->fetchAll(PDO::FETCH_ASSOC);
    return $info_crea;
  }

  public static function getArchivosCrea($id_crea,$tipo_archivo)
  {
    global $db_siclan;
    $info_crea = $db_siclan->query("SELECT * FROM tb_crea_archivo C WHERE C.FK_Id_Crea='".$id_crea."' AND VC_Tipo='".$tipo_archivo."';")->fetchAll(PDO::FETCH_ASSOC);
    return $info_crea;
  }

  public static function saveNuevoArchivoCrea($id_crea, $tipo_archivo, $Nombre_Archivo, $Ubicacion_Archivo, $fecha, $usuario){
    global $db_siclan;
    $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
    $set_id->execute([$usuario]);
    $db_siclan->query("INSERT INTO tb_crea_archivo (FK_Id_Crea, VC_Tipo, VC_Nombre, VC_Url, DA_Subida, FK_Usuario) VALUES ('".$id_crea."', '".$tipo_archivo."', '".$Nombre_Archivo."', '".$Ubicacion_Archivo."', '".$fecha."', '".$usuario."')");
  }

  public static function deleteArchivoCrea($id_crea,$id_archivo,$nombre_archivo,$tipo_archivo,$usuario)
  {
    $Ubicacion_Archivo = "../../../uploadedFiles/Infraestructura/FichaCrea/".$id_crea."/".$tipo_archivo."/".$nombre_archivo;
    foreach(glob($Ubicacion_Archivo) as $archivo)
    {
      echo $archivo;
      if(is_file($Ubicacion_Archivo))
      {
       unlink($Ubicacion_Archivo);             
     }
   }
   global $db_siclan;
   $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
   $set_id->execute([$usuario]);
   $db_siclan->delete("tb_crea_archivo",["PK_Id_Tabla"=>$id_archivo]);
 }

 public static function getCoordinadoresCrea()
 {
  global $db_siclan;
  $coordinadores_crea = $db_siclan->query("SELECT P.PK_Id_Persona,CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido) AS 'Coordinador' FROM tb_persona_2017 P WHERE P.FK_Tipo_Persona=3 || P.FK_Tipo_Persona = 4 AND P.PK_Id_Persona !=134;")->fetchAll(PDO::FETCH_ASSOC);
  return $coordinadores_crea;
}

public static function getLocalidades()
{
  global $db_siclan;
  $localidades = $db_siclan->query("SELECT L.PK_Id_Localidad, L.VC_Nom_Localidad FROM tb_localidades L;")->fetchAll(PDO::FETCH_ASSOC);
  return $localidades;
}

public static function getZonas()
{
  global $db_siclan;
  $zonas = $db_siclan->query("SELECT Z.PK_Id_Zona, Z.VC_Nombre_Zona FROM tb_zonas Z;")->fetchAll(PDO::FETCH_ASSOC);
  return $zonas;
}

public static function updateFichaCreaInfoGeneral($id_crea,$usuario,$administrador,$telefono,$direccion,$localidad,$zona,$correo_administrador,$fecha_apertura)
{
  global $db_siclan;
  $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
  $set_id->execute([$usuario]);
  $db_siclan->query("UPDATE tb_clan SET FK_Persona_Administrador='".$administrador."',VC_Telefono_Clan='".$telefono."',VC_Direccion_Clan='".$direccion."', FK_Id_Localidad='".$localidad."', DT_Fecha_Apertura='".$fecha_apertura."' WHERE PK_Id_Clan='".$id_crea."';");
  $db_siclan->query("UPDATE tb_persona_2017 SET VC_Correo='".$correo_administrador."' WHERE PK_Id_Persona='".$administrador."';");
  $db_siclan->query("UPDATE tb_zona_clan SET FK_zona='".$zona."' WHERE FK_clan='".$id_crea."';");
}

public static function updateFichaCreaAsistentesAdministrativos($id_crea,$usuario,$asistentes_administrativos)
{
  global $db_siclan;
  $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
  $set_id->execute([$usuario]);
  $db_siclan->query("UPDATE tb_clan SET FK_Asistentes='".$asistentes_administrativos."' WHERE PK_Id_Clan='".$id_crea."';");
}

public static function updateFichaCreaEmergencias($id_crea,$usuario,$cuadrante,$bomberos)
{
  global $db_siclan;
  $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
  $set_id->execute([$usuario]);
  $db_siclan->query("UPDATE tb_clan SET VC_Cuadrante='".$cuadrante."', VC_Bomberos='".$bomberos."' WHERE PK_Id_Clan='".$id_crea."';");
}

public static function updateFichaCreaAuxiliaresOperativos($id_crea,$usuario,$auxiliares_operativos)
{
  global $db_siclan;
  $set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
  $set_id->execute([$usuario]);
  $db_siclan->query("UPDATE tb_clan SET FK_Auxiliares='".$auxiliares_operativos."' WHERE PK_Id_Clan='".$id_crea."';");
}

public static function getAsistentesAdministrativos()
{
  global $db_siclan;
  $coordinadores_crea = $db_siclan->query("SELECT P.PK_Id_Persona,CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido) AS 'Asistente' FROM tb_persona_2017 P WHERE P.FK_Tipo_Persona=8;")->fetchAll(PDO::FETCH_ASSOC);
  return $coordinadores_crea;
}

public static function getAuxiliaresOperativos()
{
  global $db_siclan;
  $coordinadores_crea = $db_siclan->query("SELECT P.PK_Id_Persona,CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido) AS 'Auxiliar' FROM tb_persona_2017 P WHERE P.FK_Tipo_Persona=21;")->fetchAll(PDO::FETCH_ASSOC);
  return $coordinadores_crea;
}
}

?>