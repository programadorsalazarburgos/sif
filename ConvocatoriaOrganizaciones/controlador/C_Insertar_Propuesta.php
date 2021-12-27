<?php
 header ('Content-type: text/html; charset=utf-8');
include_once('../modelo/Conexion.php');//Se incluye la Libreria de Acceso a la Base de Datos.

//DATOS PARA TABLA tb_propuesta_organizacion_precontractual
session_start();
/*session is started if you don't write this line can't use $_Session  global variable*/
$nombre_entidad=utf8_decode($_POST["nombre_entidad"]);
$_SESSION["nombre_entidad"]=$nombre_entidad;
$id_usuario = $_POST["id_usuario"];
//ELIMINAR LAS PROPUESTAS QUE EXISTAN ANTERIORMENTE
mysqli_query(ConexionDatos::conexion(),'DELETE FROM tb_propuesta_organizacion_precontractual WHERE FK_Id_Usuario = "'.$id_usuario.'";');
mysqli_close(ConexionDatos::conexion());

mysqli_query(ConexionDatos::conexion(),'DELETE FROM tb_propuesta_historial_organizacion WHERE FK_Id_Usuario = "'.$id_usuario.'";');
mysqli_close(ConexionDatos::conexion());

mysqli_query(ConexionDatos::conexion(),'DELETE FROM tb_propuesta_proyecto WHERE FK_Id_Usuario = "'.$id_usuario.'";');
mysqli_close(ConexionDatos::conexion());

mysqli_query(ConexionDatos::conexion(),'DELETE FROM tb_propuesta_proyecto_metas WHERE FK_Id_Usuario = "'.$id_usuario.'";');
mysqli_close(ConexionDatos::conexion());

mysqli_query(ConexionDatos::conexion(),'DELETE FROM tb_propuesta_proyecto_indicadores WHERE FK_Id_Usuario = "'.$id_usuario.'";');
mysqli_close(ConexionDatos::conexion());

mysqli_query(ConexionDatos::conexion(),'DELETE FROM tb_propuesta_proyecto_equipo WHERE FK_Id_Usuario = "'.$id_usuario.'";');
mysqli_close(ConexionDatos::conexion());

mysqli_query(ConexionDatos::conexion(),'DELETE FROM tb_propuesta_proyecto_obj_especificos WHERE FK_Id_Usuario = "'.$id_usuario.'";');
mysqli_close(ConexionDatos::conexion());

$nit=utf8_decode($_POST["nit"]);
$direccion_entidad=utf8_decode($_POST["direccion_entidad"]);
$localidad_entidad=utf8_decode($_POST["SL_LOCALIDAD_ENTIDAD"]);
$objeto_social=utf8_decode($_POST["objeto_social"]);
$telefono_entidad=utf8_decode($_POST["telefono_entidad"]);
$correo_entidad=utf8_decode($_POST["correo_entidad"]);
$estrato_sede=utf8_decode($_POST["SL_ESTRATO_SEDE"]);
$nombre_representante=utf8_decode($_POST["nombre_representante"]);
$identificacion_representante=utf8_decode($_POST["identificacion_representante"]);
$direccion_representante=utf8_decode($_POST["direccion_representante"]);
$telefono_representante=utf8_decode($_POST["telefono_representante"]);
$correo_representante=utf8_decode($_POST["correo_representante"]);

mysqli_query(ConexionDatos::conexion(),"INSERT INTO tb_propuesta_organizacion_precontractual (FK_Id_Usuario, VC_Nombre_Entidad, VC_Nit, VC_Direccion, IN_Id_Localidad, VC_Objeto_Social, VC_Telefono, VC_Correo, IN_Estrato_Sede, VC_Representante_Legal, VC_Cedula_RL, VC_Direccion_RL, VC_Telefono_RL, VC_Correo_RL) VALUES ('".$id_usuario."','".$nombre_entidad."','".$nit."','".$direccion_entidad."','".$localidad_entidad."','".$objeto_social."','".$telefono_entidad."','".$correo_entidad."','".$estrato_sede."','".$nombre_representante."','".$identificacion_representante."','".$direccion_representante."','".$telefono_representante."','".$correo_representante."')"); 
mysqli_close(ConexionDatos::conexion());

/*$resultado = mysqli_query(ConexionDatos::conexion(),"SELECT MAX(PK_Id_Organizacion) AS 'Id_Organizacion' FROM tb_propuesta_organizacion_precontractual;"); 
mysqli_close(ConexionDatos::conexion());

while ($row = $resultado->fetch_assoc()) {
        $id_organizacion_precontractual = $row['Id_Organizacion'];
}*/

$fecha_radicacion=utf8_decode($_POST["fecha"]);
$nombre_proyecto=utf8_decode($_POST["nombre_proyecto"]);
$tipo_proyecto=utf8_decode($_POST["tipo_proyecto"]);
$nombre_director=utf8_decode($_POST["nombre_director"]);
$cedula_director=utf8_decode($_POST["identificacion_director"]);
$direccion_director=utf8_decode($_POST["direccion_director"]);
$telefono_director=utf8_decode($_POST["telefono_director"]);
$correo_director=utf8_decode($_POST["correo_director"]);
$dimension=utf8_decode("formación");
$antecedentes=utf8_decode($_POST["textarea_antecedentes_entidad"]);
$objetivo_general=utf8_decode($_POST["textarea_objetivo_general"]);
$descripcion_problema=utf8_decode($_POST["textarea_problema"]);
$descripcion_proyecto=utf8_decode($_POST["textarea_descripcion_proyecto"]);
$beneficiarios_proyecto=$_POST["beneficiarios_proyecto"];
$cantidad_beneficiados=$_POST["cantidad_beneficiados"];

mysqli_query(ConexionDatos::conexion(),"INSERT INTO tb_propuesta_proyecto (FK_Id_Usuario, DA_Fecha_Radicacion, VC_Nombre_Proyecto, VC_Tipo_Proyecto, VC_Nombre_Director, VC_Cedula_Director, VC_Direccion_Director, VC_Telefono_Director, VC_Correo_Director, VC_Dimension, VC_Antecedentes, VC_Objetivo_General, VC_Descripcion_Problema, VC_Descripcion_Proyecto, FL_Cantidad_Beneficiados, VC_Beneficiarios) VALUES ('".$id_usuario."','".$fecha_radicacion."','".addslashes($nombre_proyecto)."','".$tipo_proyecto."','".$nombre_director."','".$cedula_director."','".$direccion_director."','".$telefono_director."','".$correo_director."','".$dimension."','".addslashes($antecedentes)."','".addslashes($objetivo_general)."','".addslashes($descripcion_problema)."','".addslashes($descripcion_proyecto)."','".$cantidad_beneficiados."','".$beneficiarios_proyecto."')");
mysqli_close(ConexionDatos::conexion());

/*$resultado = mysqli_query(ConexionDatos::conexion(),"SELECT MAX(PK_Id_Proyecto) AS 'Id_Proyecto' FROM TB_PROPUESTA_Proyecto;"); 
mysqli_close(ConexionDatos::conexion());
while ($row = $resultado->fetch_assoc()){
        $id_proyecto = $row['Id_Proyecto'];
}
$_SESSION["id_proyecto"]=$id_proyecto;*/

$contador_historial = utf8_decode($_POST["contador_historial"]);

for($i=1;$i<$contador_historial;$i++){
	$nombre_input_entidad="entidad_".$i;
	$nombre_input_proyecto="proyecto_".$i;
	$nombre_input_antecedente_inicio="antecedente_inicio_".$i;
	$nombre_input_antecedente_fin="antecedente_fin_".$i;
	$nombre_input_actividad="actividad_".$i;
	$nombre_input_beneficiarios="beneficiarios_".$i;
	$nombre_input_sumatoria="sumatoria_".$i;
	$entidad = utf8_decode($_POST[$nombre_input_entidad]);
	$proyecto = utf8_decode($_POST[$nombre_input_proyecto]);
	$antecedente_inicio = utf8_decode($_POST[$nombre_input_antecedente_inicio]);
	$antecedente_fin = utf8_decode($_POST[$nombre_input_antecedente_fin]);
	$actividad = utf8_decode($_POST[$nombre_input_actividad]);
	$beneficiarios = utf8_decode($_POST[$nombre_input_beneficiarios]);
	$sumatoria = utf8_decode($_POST[$nombre_input_sumatoria]);

	if($beneficiarios == ""){
		$beneficiarios = "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
		$sumatoria = "0";
	}
	
	mysqli_query(ConexionDatos::conexion(),"INSERT INTO tb_propuesta_historial_organizacion (FK_Id_Usuario, VC_Entidad, VC_Nombre_Proyecto, VC_Inicio, VC_Fin, VC_Actividad_Desarrollada, VC_Poblacion_Beneficiada, FL_Cantidad_Beneficiados) VALUES ('".$id_usuario."','".addslashes($entidad)."','".addslashes($proyecto)."','".$antecedente_inicio."','".$antecedente_fin."','".addslashes($actividad)."','".$beneficiarios."','".$sumatoria."')");
	mysqli_close(ConexionDatos::conexion());
}

$contador_objetivos_espec = utf8_decode($_POST["contador_objetivos"]);

for($i=1;$i<$contador_objetivos_espec;$i++){
	$nombre_input_objetivo_espec="objetivo_".$i;
	$nombre_input_acividades_obj_espec="actividad_obj_".$i;
	$objetivo = utf8_decode($_POST[$nombre_input_objetivo_espec]);
	$actividades = utf8_decode($_POST[$nombre_input_acividades_obj_espec]);

	mysqli_query(ConexionDatos::conexion(),"INSERT INTO tb_propuesta_proyecto_obj_especificos (FK_Id_Usuario, VC_Objetivo_Especifico, VC_Actividades) VALUES ('".$id_usuario."','".addslashes($objetivo)."','".addslashes($actividades)."')");
	mysqli_close(ConexionDatos::conexion());
}

$contador_metas = utf8_decode($_POST["contador_metas"]);

for($i=1;$i<$contador_metas;$i++){
	$nombre_input_proceso="proceso_".$i;
	$nombre_input_magnitud="magnitud_".$i;
	$nombre_input_unidad="unidad_".$i;
	$nombre_input_descripcion="descripcion_".$i;
	$nombre_input_periodo="periodo_".$i;
	
	$proceso = utf8_decode($_POST[$nombre_input_proceso]);
	$magnitud = utf8_decode($_POST[$nombre_input_magnitud]);
	$unidad = utf8_decode($_POST[$nombre_input_unidad]);
	$descripcion = utf8_decode($_POST[$nombre_input_descripcion]);
	$periodo = utf8_decode($_POST[$nombre_input_periodo]);
	
	mysqli_query(ConexionDatos::conexion(),"INSERT INTO tb_propuesta_proyecto_metas (FK_Id_Usuario, VC_Proceso, VC_Magnitud, VC_Unidad_Medida, VC_Descripcion, VC_Periodo) VALUES ('".$id_usuario."','".addslashes($proceso)."','".$magnitud."','".addslashes($unidad)."','".addslashes($descripcion)."','".$periodo."')");
	mysqli_close(ConexionDatos::conexion());
}

$contador_indicadores = utf8_decode($_POST["contador_indicadores"]);

for($i=1;$i<$contador_indicadores;$i++){
	$nombre_input_indicador="nombreindicador_".$i;
	$nombre_input_formula="formula_".$i;
	$nombre_input_estado_inicial="estadoinicial_".$i;
	$nombre_input_valor_esperado="valoresperado_".$i;
	$nombre_input_periodo_indicador="periodoindicador_".$i;
	
	$indicador = utf8_decode($_POST[$nombre_input_indicador]);
	$formula = utf8_decode($_POST[$nombre_input_formula]);
	$estado_inicial = utf8_decode($_POST[$nombre_input_estado_inicial]);
	$valor_esperado = utf8_decode($_POST[$nombre_input_valor_esperado]);
	$periodo_indicador = utf8_decode($_POST[$nombre_input_periodo_indicador]);
	
	mysqli_query(ConexionDatos::conexion(),"INSERT INTO tb_propuesta_proyecto_indicadores (FK_Id_Usuario, VC_Nombre_Indicador, VC_Formula, VC_Estado_Inicial, VC_Valor_Esperado, VC_Periodo) VALUES ('".$id_usuario."','".addslashes($indicador)."','".addslashes($formula)."','".$estado_inicial."','".$valor_esperado."','".$periodo_indicador."')");
	mysqli_close(ConexionDatos::conexion());
}

$contador_equipo = utf8_decode($_POST["contador_equipo"]);

for($i=1;$i<$contador_equipo;$i++){
	$nombre_input_persona="nombrepersona_".$i;
	$nombre_input_perfil="perfilpersona_".$i;
	$nombre_input_rolpersona="rolpersona_".$i;
	$nombre_input_actividadespersona="actividadespersona_".$i;
	
	$persona = utf8_decode($_POST[$nombre_input_persona]);
	$perfil = utf8_decode($_POST[$nombre_input_perfil]);
	$rol = utf8_decode($_POST[$nombre_input_rolpersona]);
	$actividadespersona = utf8_decode($_POST[$nombre_input_actividadespersona]);
	
	mysqli_query(ConexionDatos::conexion(),"INSERT INTO tb_propuesta_proyecto_equipo (FK_Id_Usuario, VC_Nombre_Persona, VC_Perfil, VC_Rol, VC_Actividades) VALUES ('".$id_usuario."','".$persona."','".addslashes($perfil)."','".$rol."','".addslashes($actividadespersona)."')");
	mysqli_close(ConexionDatos::conexion());
}

return $resultado;
?>