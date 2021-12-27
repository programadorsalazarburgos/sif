<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:../index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Administración Grupos</title>
	<link href="../bower_components/fontawesome/web-fonts-with-css/css/fontawesome-all.css" rel="stylesheet">

	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<script type="text/javascript" src="Js/Administracion_Grupo.js?v=2021.08.09.0"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de grupos<small> CREA</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#panel_crear_grupo" role="tab">Crear Grupo</a></li>
					<li class="nav-item"><a id="nav_modificar_grupo" class="nav-link" data-toggle="tab" href="#modificar_grupo">Modificar Grupo</a></li>
					<li class="nav-item"><a id="nav_inactivar_cerrar_grupos" class="nav-link" data-toggle="tab" href="#panel_inactivar_cerrar_grupos">Cerrar o Inactivar Grupos</a></li>
					<li class="nav-item"><a id="nav_fusionar_grupos" class="nav-link" data-toggle="tab" href="#fusion_grupos" role="tab">Fusionar Grupos Existentes</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="panel_crear_grupo" role="tabpanel"><br>
						<form id="form_nuevo_grupo">
							
							<div class="form-row">
								<div class="form-group col-lg-6 col-lg-offset-3">
									<legend>Datos del grupo</legend>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-6 col-lg-offset-3">
									<label>Línea de atención</label>
									<select class="form-control selectpicker linea-atencion" title="Seleccione una opción"  id="SL_linea_atencion" name="SL_linea_atencion" required></select>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-6 col-lg-offset-3">
									<label>Lugar de atención</label>
									<select class="form-control selectpicker lugar-atencion" title="Seleccione una opción" id="SL_lugar_atencion" name="SL_lugar_atencion" required></select>
								</div>
							</div>
							<div class="converge" style="display: none">
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Espacio <small>(Solo aplica para espacio alterno)</small></label>
										<select class="form-control selectpicker" title="Seleccione una opción" id="SL_espacio_alterno_converge" name="SL_espacio_alterno_converge"></select>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-6 col-lg-offset-3">
									<label>Modalidad de atención</label>
									<select class="form-control selectpicker modalidad-atencion" title="Seleccione una opción" id="SL_modalidad_atencion" name="SL_modalidad_atencion" required></select>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-6 col-lg-offset-3">
									<label>Tipo de atención</label>
									<select class="form-control selectpicker" title="Seleccione una opción" id="SL_tipo_atencion" name="SL_tipo_atencion" required></select>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-6 col-lg-offset-3">
									<label>Crea</label>
									<select class="form-control selectpicker" title="Seleccione una opción" data-live-search="true" id="SL_clan" name="SL_clan" required></select>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-6 col-lg-offset-3">
									<label>Área artística</label>
									<select class="form-control selectpicker" title="Seleccione una opción" id="SL_area_artistica" name="SL_area_artistica" required></select>
								</div>
							</div>
							<div class="arte-escuela" id="div-creacion-grupo-arte-escuela" style="display: none">
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Colegio responsable</label>
										<select class="form-control selectpicker elemento-arte-escuela" title="Seleccione una opción" data-live-search="true" id="SL_colegio_responsable" name="SL_colegio_responsable"></select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Grado(s)</label>
										<select class="form-control selectpicker elemento-arte-escuela" title="Selección múltiple" multiple data-live-search="true" id="SL_grados" name="SL_grados">
											<option value="Primero">Primero</option>
											<option value="Segundo">Segundo</option>
											<option value="Tercero">Tercero</option>
											<option value="Cuarto">Cuarto</option>
											<option value="Quinto">Quinto</option>
											<option value="Sexto">Sexto</option>
											<option value="Septimo">Séptimo</option>
											<option value="Octavo">Octavo</option>
											<option value="Noveno">Noveno</option>
											<option value="Decimo">Decimo</option>
											<option value="Once">Once</option>
											<option value="Aceleración primeras letras">Aceleración primeras letras</option>
										</select>
									</div>
								</div>
							</div>
							<div class="impulso-colectivo" id="div-creacion-grupo-impulso-colectivo" style="display: none">
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Modalidad área artística</label>
										<select class="form-control selectpicker elemento-impulso-colectivo" title="Seleccione una opción" data-live-search="true" id="SL_modalidad_area_artistica" name="SL_modalidad_area_artistica"></select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-3 col-lg-offset-3">
										<label>¿Grupo con oferta disponible?</label>
										<select class="form-control selectpicker elemento-impulso-colectivo oferta-disponible" title="Seleccione una opción" id="SL_oferta_disponible" name="SL_oferta_disponible">
											<option value="1">Si, publicar esta oferta en la página web</option>
											<option value="0">No, este grupo no tiene preinscripción en la página web</option>
										</select>
									</div>
									<div class="form-group col-lg-3">
										<label>Cantidad de cupos</label>
										<input class="form-control" type="number" name="TX_cantidad_cupos" id="TX_cantidad_cupos" readonly>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Tipo grupo</label>
										<select class="form-control selectpicker elemento-impulso-colectivo" title="Seleccione una opción" data-live-search="true" id="SL_tipo_grupo_emprende_clan" name="SL_tipo_grupo_emprende_clan">
										</select>
									</div>
								</div>
							</div>
							<div class="converge" id="div-creacion-grupo-converge" style="display: none;"> 
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Tipo grupo</label>
										<select class="form-control selectpicker elemento-converge" title="Seleccione una opción" id="SL_tipo_grupo_laboratorio_crea" name="SL_tipo_grupo_laboratorio_crea"></select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Institución</label>
										<select class="form-control selectpicker elemento-converge" title="Seleccione una opción" data-live-search="true" id="SL_institucion_laboratorio_crea" name="SL_institucion_laboratorio_crea"></select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Aliado</label>
										<select class="form-control selectpicker elemento-converge" title="Seleccione una opción"  data-live-search="true" id="SL_aliado_laboratorio_crea" name="SL_aliado_laboratorio_crea"></select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Categoría población</label>
										<select class="form-control selectpicker elemento-converge" title="Seleccione una opción" data-live-search="true" id="SL_categoria_poblacion_laboratorio" name="SL_categoria_poblacion_laboratorio"></select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Subcategoría población</label>
										<select class="form-control selectpicker elemento-converge" title="Seleccione una opción" id="SL_subcategoria_poblacion_laboratorio" name="SL_subcategoria_poblacion_laboratorio"></select>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-6 col-lg-offset-3">
									<label>Convenio</label>
									<select class="form-control selectpicker" title="Seleccione una opción" id="SL_convenio" name="SL_convenio" required></select>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-6 col-lg-offset-3">
									<label>Observaciones</label>
									<textarea class="form-control" id="TX_observaciones" name="TX_observaciones" style="max-width: 100%; min-width: 100%; min-height: 100px;"></textarea>
								</div>
							</div>
							<div class="arte-escuela" id="div-horas-creacion-grupo-arte-escuela" style="display: none;">
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Número de horas por semana</label>
										<select class="form-control selectpicker elemento-arte-escuela horas" id="SL_numero_horas" name="SL_numero_horas" title="Seleccione una opción">
											<option value="2">Dos (02) Horas.</option>
											<option value="4">Cuatro (04) Horas.</option>
										</select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Número de sesiones por semana</label>
										<select class="form-control selectpicker elemento-arte-escuela" id="SL_numero_sesiones" name="SL_numero_sesiones" title="Seleccione una opción"></select>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-lg-offset-3">
								<div class="form-group">
									<div class="row">
										<div class="col-lg-12">
											<legend>Horario del grupo</legend>
										</div>
										<div class="alert alert-warning col-lg-12">
											<div class="text-center" role="alert">
												<span class="glyphicon glyphicon glyphicon-alert" aria-hidden="true"></span>
												A continuación podrá seleccionar los días en los cuales se daran clases para el grupo. <b id="b_mensaje_hora_inicio_hora_fin">Debe indicar unicamente la hora inicio.</b>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="bg-info col-lg-12 col-xs-12">
											<div class="col-xs-4 col-md-4">
												<div class="checkbox">
													<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='1' id="CH_dia_01" name="CH_dia_clase[]" value="01">Lunes</label>
													<select id="SL_hora_inicio_dia_01" name="SL_hora_inicio_dia_01" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
													<select id="SL_hora_fin_dia_01" name="SL_hora_fin_dia_01" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
												</div>
											</div>
											<div class="col-xs-4 col-md-4">
												<div class="checkbox">
													<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='2' id="CH_dia_02" name="CH_dia_clase[]" value="02">Martes</label>
													<select id="SL_hora_inicio_dia_02" name="SL_hora_inicio_dia_02" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
													<select id="SL_hora_fin_dia_02" name="SL_hora_fin_dia_02" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
												</div>
											</div>
											<div class="col-xs-4 col-md-4">
												<div class="checkbox">
													<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='3' id="CH_dia_03" name="CH_dia_clase[]" value="03">Miercoles</label>
													<select id="SL_hora_inicio_dia_03" name="SL_hora_inicio_dia_03" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
													<select id="SL_hora_fin_dia_03" name="SL_hora_fin_dia_03" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
												</div>
											</div>
											<div class="col-xs-4 col-md-4">
												<div class="checkbox">
													<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='4' id="CH_dia_04" name="CH_dia_clase[]" value="04">Jueves</label>
													<select id="SL_hora_inicio_dia_04" name="SL_hora_inicio_dia_04" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
													<select id="SL_hora_fin_dia_04" name="SL_hora_fin_dia_04" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
												</div>
											</div>
											<div class="col-xs-4 col-md-4">
												<div class="checkbox">
													<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='5' id="CH_dia_05" name="CH_dia_clase[]" value="05">Viernes</label>
													<select id="SL_hora_inicio_dia_05" name="SL_hora_inicio_dia_05" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
													<select id="SL_hora_fin_dia_05" name="SL_hora_fin_dia_05" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
												</div>
											</div>
											<div class="col-xs-4 col-md-4">
												<div class="checkbox">
													<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='6' id="CH_dia_06" name="CH_dia_clase[]" value="06">Sabado</label>
													<select id="SL_hora_inicio_dia_06" name="SL_hora_inicio_dia_06" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
													<select id="SL_hora_fin_dia_06" name="SL_hora_fin_dia_06" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-lg-4 col-lg-offset-4">
									<button class="btn btn-block btn-primary" id="BT_guardar_datos_grupo" type="submit">Guardar</button>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="modificar_grupo" role="tabpanel"><br>
						<div class="form-row">
							<div class="form-group col-lg-6 col-lg-offset-3">
								<label>Crea</label>
								<select class="form-control selectpicker" title="Seleccione una opción" id="SL_clan_modificar_grupo" data-live-search="true"></select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-lg-6 col-lg-offset-3">
								<label>Grupo</label>
								<select class="form-control selectpicker" title="Seleccione una opción" id="SL_grupo_modificar" data-live-search="true"></select>
							</div>
						</div>

						<div class="form-row" id="div_modificar_horario_clase" style="display: none;">
							<form id="form_modificar_grupo">
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<legend>Modificar datos del grupo</legend>
									</div>
								</div>
								<div class="form-row" style="display: none;">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Línea de atención</label>
										<select class="form-control selectpicker linea-atencion" title="Seleccione una opción"  id="SL_linea_atencion_modificar" name="SL_linea_atencion_modificar" required></select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Lugar de atención</label>
										<select class="form-control selectpicker lugar-atencion" title="Seleccione una opción" id="SL_lugar_atencion_modificar" name="SL_lugar_atencion_modificar" required></select>
									</div>
								</div>
								<div class="converge" style="display: none">
									<div class="form-row">
										<div class="form-group col-lg-6 col-lg-offset-3">
											<label>Espacio <small>(Solo aplica para espacio alterno)</small></label>
											<select class="form-control selectpicker" title="Seleccione una opción" id="SL_espacio_alterno_converge_modificar" name="SL_espacio_alterno_converge_modificar"></select>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Modalidad de atención</label>
										<select class="form-control selectpicker modalidad-atencion" title="Seleccione una opción" id="SL_modalidad_atencion_modificar" name="SL_modalidad_atencion_modificar" required></select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Tipo de atención</label>
										<select class="form-control selectpicker" title="Seleccione una opción" id="SL_tipo_atencion_modificar" name="SL_tipo_atencion_modificar" required></select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Área artística</label>
										<select class="form-control selectpicker" id="SL_area_artistica_modificar" name="SL_area_artistica_modificar" required></select>
									</div>
								</div>
								<div class="impulso-colectivo" id="div-modificacion-grupo-impulso-colectivo" style="display: none;">
									<div class="form-row">
										<div class="form-group col-lg-6 col-lg-offset-3">
											<label>Modalidad área artística</label>
											<select class="form-control selectpicker elemento-converge" data-live-search="true" id="SL_modalidad_area_artistica_modificar" name="SL_modalidad_area_artistica_modificar"></select>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-3 col-lg-offset-3">
											<label>¿Grupo con oferta disponible?</label>
											<select class="form-control selectpicker elemento-impulso-colectivo oferta-disponible" title="Seleccione una opción" id="SL_oferta_disponible_modificar" name="SL_oferta_disponible_modificar">
												<option value="1">Si, publicar esta oferta en la página web</option>
												<option value="0">No, este grupo no tiene preinscripción en la página web</option>
											</select>
										</div>
										<div class="form-group col-lg-3">
											<label>Cantidad de cupos</label>
											<input class="form-control" type="number" name="TX_cantidad_cupos_modificar" id="TX_cantidad_cupos_modificar" readonly>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6 col-lg-offset-3">
											<label>Tipo grupo</label>
											<select class="form-control selectpicker elemento-impulso-colectivo" title="Seleccione una opción" data-live-search="true" id="SL_tipo_grupo_emprende_clan_modificar" name="SL_tipo_grupo_emprende_clan_modificar">
											</select>
										</div>
									</div>
								</div>
								<div class="converge" id="div-modificacion-grupo-converge" style="display: none;">
									<div class="form-row">
										<div class="form-group col-lg-6 col-lg-offset-3">
											<label>Tipo de grupo</label>
											<select class="form-control selectpicker elemento-converge" data-live-search="true" id="SL_tipo_grupo_laboratorio_crea_modificar" name="SL_tipo_grupo_laboratorio_crea_modificar"></select>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6 col-lg-offset-3">
											<label>Institución</label>
											<select class="form-control selectpicker elemento-converge" data-live-search="true" id="SL_institucion_laboratorio_crea_modificar" name="SL_institucion_laboratorio_crea_modificar"></select>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6 col-lg-offset-3">
											<label>Aliado:</label>
											<select class="form-control selectpicker elemento-converge" data-live-search="true" id="SL_aliado_laboratorio_crea_modificar" name="SL_aliado_laboratorio_crea_modificar"></select>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6 col-lg-offset-3">
											<label>Categoria Población</label>
											<select class="form-control selectpicker elemento-converge" data-live-search="true" id="SL_categoria_poblacion_laboratorio_modificar" name="SL_categoria_poblacion_laboratorio_modificar"></select>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6 col-lg-offset-3">
											<label>Subcategoria población:</label>
											<select class="form-control selectpicker elemento-converge" data-live-search="true" id="SL_subcategoria_poblacion_laboratorio_modificar" name="SL_subcategoria_poblacion_laboratorio_modificar"></select>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Convenio</label>
										<select class="form-control selectpicker" title="Seleccione una opción" id="SL_convenio_modificar" name="SL_convenio_modificar" required></select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-6 col-lg-offset-3">
										<label>Observaciones</label>
										<textarea class="form-control" id="TX_observaciones_modificar" name="TX_observaciones_modificar" style="max-width: 100%; min-width: 100%; min-height: 100px;"></textarea>
									</div>
								</div>
								<div class="arte-escuela" id="div-horas-modificacion-grupo-arte-escuela" style="display: none;">
									<div class="form-row">
										<div class="form-group col-lg-6 col-lg-offset-3">
											<label>Grado(s)</label>
											<select class="form-control selectpicker elemento-arte-escuela" title="Selección múltiple" multiple data-live-search="true" id="SL_grados_modificar" name="SL_grados_modificar">
												<option value="Primero">Primero</option>
												<option value="Segundo">Segundo</option>
												<option value="Tercero">Tercero</option>
												<option value="Cuarto">Cuarto</option>
												<option value="Quinto">Quinto</option>
												<option value="Sexto">Sexto</option>
												<option value="Septimo">Séptimo</option>
												<option value="Octavo">Octavo</option>
												<option value="Noveno">Noveno</option>
												<option value="Decimo">Decimo</option>
												<option value="Once">Once</option>
												<option value="Aceleración primeras letras">Aceleración primeras letras</option>
											</select>
										</div>
									</div>

									<div class="form-row">
										<div class="form-group col-lg-6 col-lg-offset-3">
											<label>Número de horas por semana</label>
											<select class="form-control selectpicker elemento-arte-escuela horas" id="SL_numero_horas_modificar" name="SL_numero_horas_modificar" title="Seleccione una opción">
												<option value="2">Dos (02) Horas.</option>
												<option value="4">Cuatro (04) Horas.</option>
											</select>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-lg-6 col-lg-offset-3">
											<label>Número de sesiones por semana</label>
											<select class="form-control selectpicker elemento-arte-escuela" id="SL_numero_sesiones_modificar" name="SL_numero_sesiones_modificar" title="Seleccione una opción"></select>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-lg-offset-3">
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<legend>Horario del grupo</legend>
											</div>
											<div class="alert alert-warning col-lg-12">
												<div class="text-center" role="alert">
													<span class="glyphicon glyphicon glyphicon-alert" aria-hidden="true"></span>
													A continuación podrá seleccionar los días en los cuales se daran clases para el grupo. <b id="b_mensaje_hora_inicio_hora_fin_modificar">Debe indicar unicamente la hora inicio.</b>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="bg-info text-center col-lg-12">
												<div class="col-xs-4 col-md-4">
													<div class="checkbox">
														<label><input type="checkbox" class="checkbox_modificar_dias_clase" data-dia_clase='1' id="CH_modificar_dia_01" name="CH_modificar_dia_clase[]" value="01">Lunes</label>
														<select id="SL_modificar_hora_inicio_dia_01" name="SL_modificar_hora_inicio_dia_01" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
														<select id="SL_modificar_hora_fin_dia_01" name="SL_modificar_hora_fin_dia_01" class="form-control selectpicker" title='Hora fin fin' data-live-search="true" disabled="disabled"></select>
													</div>
												</div>
												<div class="col-xs-4 col-md-4">
													<div class="checkbox">
														<label><input type="checkbox" class="checkbox_modificar_dias_clase" data-dia_clase='2' id="CH_modificar_dia_02" name="CH_modificar_dia_clase[]" value="02">Martes</label>
														<select id="SL_modificar_hora_inicio_dia_02" name="SL_modificar_hora_inicio_dia_02" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
														<select id="SL_modificar_hora_fin_dia_02" name="SL_modificar_hora_fin_dia_02" class="form-control selectpicker" title='Hora de fin' data-live-search="true" disabled="disabled"></select>
													</div>
												</div>
												<div class="col-xs-4 col-md-4">
													<div class="checkbox">
														<label><input type="checkbox" class="checkbox_modificar_dias_clase" data-dia_clase='3' id="CH_modificar_dia_03" name="CH_modificar_dia_clase[]" value="03">Miercoles</label>
														<select id="SL_modificar_hora_inicio_dia_03" name="SL_modificar_hora_inicio_dia_03" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
														<select id="SL_modificar_hora_fin_dia_03" name="SL_modificar_hora_fin_dia_03" class="form-control selectpicker" title='Hora de fin' data-live-search="true" disabled="disabled"></select>
													</div>
												</div>
												<div class="col-xs-4 col-md-4">
													<div class="checkbox">
														<label><input type="checkbox" class="checkbox_modificar_dias_clase" data-dia_clase='4' id="CH_modificar_dia_04" name="CH_modificar_dia_clase[]" value="04">Jueves</label>
														<select id="SL_modificar_hora_inicio_dia_04" name="SL_modificar_hora_inicio_dia_04" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
														<select id="SL_modificar_hora_fin_dia_04" name="SL_modificar_hora_fin_dia_04" class="form-control selectpicker" title='Hora de fin' data-live-search="true" disabled="disabled"></select>
													</div>
												</div>
												<div class="col-xs-4 col-md-4">
													<div class="checkbox">
														<label><input type="checkbox" class="checkbox_modificar_dias_clase" data-dia_clase='5' id="CH_modificar_dia_05" name="CH_modificar_dia_clase[]" value="05">Viernes</label>
														<select id="SL_modificar_hora_inicio_dia_05" name="SL_modificar_hora_inicio_dia_05" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
														<select id="SL_modificar_hora_fin_dia_05" name="SL_modificar_hora_fin_dia_05" class="form-control selectpicker" title='Hora de fin' data-live-search="true" disabled="disabled"></select>
													</div>
												</div>
												<div class="col-xs-4 col-md-4">
													<div class="checkbox">
														<label><input type="checkbox" class="checkbox_modificar_dias_clase" data-dia_clase='6' id="CH_modificar_dia_06" name="CH_modificar_dia_clase[]" value="06">Sabado</label>
														<select id="SL_modificar_hora_inicio_dia_06" name="SL_modificar_hora_inicio_dia_06" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
														<select id="SL_modificar_hora_fin_dia_06" name="SL_modificar_hora_fin_dia_06" class="form-control selectpicker" title='Hora de fin' data-live-search="true" disabled="disabled"></select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-lg-4 col-lg-offset-4">
										<button class="btn btn-block btn-primary" id="BT_guardar_modificar_grupo" type="submit">Modificar</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="tab-pane" id="panel_inactivar_cerrar_grupos" role="tabpanel"><br>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3">
									<label>Línea de atención</label>
									<select class="form-control selectpicker linea-atencion" data-live-search="true" id="SL_linea_atencion_cerrar_grupo" name="SL_linea_atencion_cerrar_grupo"></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3">
									<label>Crea</label>
									<select class="form-control selectpicker" data-live-search="true" id="SL_crea_cerrar_grupo" name="SL_crea_cerrar_grupo"></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row" id="div_grupos_cerrar">
								<div class="table-responsive col-xs-12 col-md-12">
									<table width="100%" style="width: 100%" class="table" id="table_grupos_cerrar">
										<thead></thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="fusion_grupos" role="tabpanel"><br>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3">
									<label>Crea</label>
									<select class="form-control selectpicker" data-live-search="true" title="Seleccione una opción" id="SL_clan_fusion_grupos"></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3">
									<label>Línea de atención</label>
									<select class="form-control selectpicker" data-live-search="true" title="Seleccione una opción" id="SL_linea_atencion_fusion_grupos"></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3">
									<div class="alert alert-info text-center">
										<strong>Tenga en cuenta lo siguiente:</strong> El nuevo grupo tomará los parámetros del grupo uno.
									</div>
								</div>
							</div>	
						</div>						
						<div class="form-group">
							<div class="row">
								<div class="col-lg-3 col-lg-offset-3">
									<label>Grupo uno</label>
									<select class="form-control selectpicker" data-live-search="true" title='Grupo Uno' id="SL_grupo_fusion_uno"></select>
								</div>
								<div class="col-lg-3">
									<label>Grupo dos</label>
									<select class="form-control selectpicker" data-live-search="true" title='Grupo Dos' id="SL_grupo_fusion_dos"></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row" id="div_fusion_grupos">
								<div class="col-lg-6 col-lg-offset-3">
									<label>Justificación</label>
									<textarea id="TX_justificacion_fusion_grupos" placeholder="Justificación fusión de grupos" class="form-control"></textarea>
								</div>	
							</div>	
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6 col-lg-offset-3">
									<button class="btn btn-block btn-primary" type="button" id="BT_fusionar_grupos">Fusionar grupos</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_cerrar_grupo" tabindex="-1" role="dialog" aria-labelledby="label_modal_cerrar_grupo" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="title_modal_cerrar_grupo"></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_razon_cerrar_grupo">Seleccione una razón:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select id="SL_razon_cerrar_grupo" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
						<div class='row'>
							<div class='col-xs-12 col-md-12'>
								<p class="alert alert-warning">Escriba la justificación por la cual se va a cerrar el grupo.</p>
							</div>
						</div>
						<div class='row'>
							<div class='col-xs-12 col-md-3'>
								<label for="TX_justificacion_cerrar_grupo">Justificación</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<textarea class="form-control" id="TX_justificacion_cerrar_grupo" placeholder="¿Por qué se cierra el grupo?"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" id="BT_cerrar_grupo">Cerrar/Inactivar Grupo</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>