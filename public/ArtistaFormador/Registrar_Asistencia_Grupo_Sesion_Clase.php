<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else {
	$Id_Persona= $_SESSION["session_username"];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Registrar Asistencia Taller</title>

	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bower_components/fontawesome/web-fonts-with-css/css/fontawesome-all.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>	

	<link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
	<script src="../bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/jszip/dist/jszip.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>  

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>
	<script src="../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.js"></script>

	<script type="text/javascript" src="Js/Registrar_Asistencia_Grupo_Sesion_Clase.js?v=2021.09.02.1"></script>
</head>
<style>
	div.tooltip {
    width: 300px;
	font-size: 12px;
	font-family: -webkit-pictograph;
}

div.tooltip-inner {
    max-width: 300px;
	font-size: 12px;
}
</style>
<body style="font-family:-webkit-pictograph !important">
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Registrar Asistencia <small>Artista Formador</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link eventoClic mi_asistencia_tab" data-toggle="tab" href="#mi_asistencia" id="mi_asistencia_tab" role="tab">Asistencia mis grupos</a></li>
					<li class="nav-item"><a class="nav-link eventoClic asistencia_suplente_tab" data-toggle="tab" href="#asistencia_suplente" id="asistencia_suplente_tab" role="tab">Asistencia Suplencia</a></li>
					<li class="nav-item"><a class="nav-link eventoClic modificar_asistencia_tab" data-toggle="tab" href="#modificar_asistencia" id="modificar_asistencia_tab" role="tab">Modificar/Eliminar sesión clase</a></li>
					<li class="nav-item"><a class="nav-link eventoClic anexos_sesiones_clase_tab" data-toggle="tab" href="#anexos_sesiones_clase" id="anexos_sesiones_clase_tab" role="tab">Anexos Sesión Clase <span class='label label-info'>Nuevo</span></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="mi_asistencia" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 alert alert-warning">
								<p>
									A continuación puede seleccionar uno de los grupos que tiene asignados para registrar asistencia.
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
								<label for="SL_grupo">Seleccione el grupo:</label>
							</div>
							<div class="col-xs-6 col-md-4">
								<select id="SL_grupo" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
						<div id="div_detalles_horario_grupo">
							<div class="row">
								<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
									<label for="TB_dias_clase_semana">Horario:</label>
								</div>
								<div class="col-xs-6 col-md-4">
									<input type="text" id="TB_dias_clase_semana" disabled="disabled" class="form-control">
								</div>
							</div>
							<fieldset id="fieldset_registro_asistencia_grupos">
							<form id="form_registro_asistencia" enctype="multipart/form-data">
								<legend style="text-align:center;">Datos de la sesión de clase:</legend>
								<div class="row" style="padding:4px;" id="div_lugar_atencion">
									<div class="col-xs-6 col-md-3 col-md-offset-3" style="text-align: right">
										<label for="SL_LUGAR_ATENCION">Lugar de atención <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title="Lugar de Atención donde se dictó el taller.<br>Debe seleccionar 'REMOTO' si la sesión no fue presencial, cualquiera haya sido el canal virtual utilizado."></i>:</label>
									</div>
									<div class="col-xs-6 col-md-2">
										<select id="SL_LUGAR_ATENCION" class="form-control selectpicker" title="Seleccione el Lugar de Atención"></select>
									</div>
								</div>
								<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-3" style="text-align: right">
										<label for="SL_MODALIDAD_ATENCION">Modalidad de Atención <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title="PRESENCIAL: Cuando el taller haya sido dictado en instalaciones físicas.<br> NO PRESENCIAL: Cuando el taller haya sido dictado de manera REMOTA, cualquiera haya sido el canal virtual utilizado.<br>MIXTO: Cuando en el taller hayan participado beneficiarios de manera PRESENCIAL y REMOTA simultáneamente."></i>:</label>
									</div>
									<div class="col-xs-6 col-md-2">
										<select id="SL_MODALIDAD_ATENCION" class="form-control selectpicker" title="Seleccione la Modalidad de Atención"></select>
									</div>
								</div>
								<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-3" style="text-align: right">
										<label for="SL_TIPO_ATENCION">Tipo Atención <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title="PRESENCIAL: Cuando el taller haya sido dictado en instalaciones físicas.<br> SINCRÓNICA: Corresponde a los talleres realizados de manera REMOTA en el mismo momento, desde cualquier lugar (Google Meet/Zoom/Transmisión en vivo).<br>ASINCRÓNICA: Corresponde a los talleres realizados de manera REMOTA, teniendo en cuenta los espacios, ritmos y horarios de los estudiantes (en diferentes momentos, con material como guías, videos, documentos, que los beneficiarios realizan sin la presencia en vivo del formador)."></i>:</label>
									</div>
									<div class="col-xs-6 col-md-2">
										<select id="SL_TIPO_ATENCION" class="form-control selectpicker" title="Seleccione el Tipo de Atención"></select>
									</div>
								</div>
								<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-3" style="text-align: right">
										<label for="SL_MATERIAL">Material Pedagógico:</label>
									</div>
									<div class="col-xs-6 col-md-2">
										<select id="SL_MATERIAL" class="form-control selectpicker" title="Seleccione el Material Pedagógico">
										</select>
									</div>
								</div>
								<div class="row" style="padding:4px;" id="div_salon">
									<div class="col-xs-6 col-md-3 col-md-offset-3" style="text-align: right">
										<label for="SL_ESPACIO">Espacio/salón:</label>
									</div>
									<div class="col-xs-6 col-md-2">
										<select id="SL_ESPACIO" class="form-control selectpicker" title="Seleccione el Espacio"></select>
									</div>
								</div>
								<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-3" style="text-align: right">
										<label for="TB_fecha_sesion">Fecha de la sesión:</label>
									</div>
									<div class="col-xs-6 col-md-2">
										<div class="input-group date">
											<input type="text" id="TB_fecha_sesion" readonly="readonly" class="form-control">
											<div class="input-group-addon" id="SPAN_fecha_sesion">
												<span class="glyphicon glyphicon-calendar"></span>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-3" style="text-align: right">
										<label for="SL_HORAS_SESION">Horas de la sesión:</label>
									</div>
									<div class="col-xs-6 col-md-2">
										<select type="number" id="SL_HORAS_SESION" class="form-control selectpicker" title="Seleccione la cantidad de Horas">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
										</select>
									</div>									
								</div>
								<div class="row" style="padding:4px;">
									<div id="div_anexo_planilla" class="col-xs-6 col-md-3 col-md-offset-5" style="margin-top: 6px;" data-toggle="tooltip" title="Los archivos subidos reemplazarán los cargados anteriormente para ésta sesión de clase" data-placement="right">
										<div class="alert-danger">Tenga en cuenta que el archivo no debe superar los 50mb.</div>
										<input id="file" multiple name="file" type="file" class="filestyle" accept="application/pdf" data-btnClass="btn-danger" data-buttonBefore="true" runat="server" data-text="&nbspAnexo">
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12 table-responsive">
										<div id="div_table_estudiantes_grupo"></div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-md-3">
										<label for="TX_observaciones">Observaciones:</label>
									</div>
									<div class="col-xs-12 col-md-9">
										<textarea class="form-control" id="TX_observaciones" placeholder="Observaciones"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
										<button class="eventoClic btn btn-success form-control" id="BT_guardar_asistencia_clase">Guardar</button>
									</div>
								</div>
								</form>
							</fieldset>
							<fieldset id="fieldset_registro_asistencia_no_grupo">
								<legend>Datos del taller de clase</legend>
								<div class="row">
									<form id="form_nueva_asistencia_no_grupo_laboratorio_clan" enctype="multipart/form-data">
										<input type="hidden" name="opcion" value="registrar_asistencia_no_grupo_laboratorio">
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<?php echo "<input type='hidden' name='id_usuario' value='".$Id_Persona."' >"; ?>
												<label for="SL_clan_taller_laboratorio_no_grupo">Clan:</label>
											</div>
											<div class="col-xs-12 col-md-9">
												<select required="required" class="form-control" placeholder="Clan" id="SL_clan_taller_laboratorio_no_grupo" name="SL_clan_taller_laboratorio_no_grupo"></select>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<label for="SL_area_artistica_laboratorio_no_grupo">Area Artistica:</label>
											</div>
											<div class="col-xs-12 col-md-9">
												<select required="required" class="form-control" placeholder="Area Artstica" id="SL_area_artistica_laboratorio_no_grupo" name="SL_area_artistica_laboratorio_no_grupo"></select>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<label for="SL_lugar_atencion_laboratorio_no_grupo">Lugar de atención</label>
											</div>
											<div class="col-xs-12 col-md-9">
												<select required="required" class="form-control" placeholder="Area Artstica" id="SL_lugar_atencion_laboratorio_no_grupo" name="SL_lugar_atencion_laboratorio_no_grupo"></select>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<label for="fecha_taller_laboratorio_no_grupo">Fecha:</label>
											</div>
											<div class="col-xs-12 col-md-9">
												<input type="text" required="required" class="form-control" placeholder="Fecha" id="fecha_taller_laboratorio_no_grupo" name="fecha_taller_laboratorio_no_grupo">
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<label for="numero_personas_laboratorio_no_grupo">Número de personas:</label>
											</div>
											<div class="col-xs-12 col-md-9">
												<input type="number" required="required" class="form-control" placeholder="Número de personas" id="numero_personas_laboratorio_no_grupo" name="numero_personas_laboratorio_no_grupo" min="1">
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<label for="archivo_soporte_laboratorio_no_grupo">Archivo soporte:</label>
											</div>
											<div class="col-xs-12 col-md-9">
												<input type="file" required="required" placeholder="Planilla Fisica de asistencia" id="archivo_soporte_laboratorio_no_grupo" name="archivo_soporte_laboratorio_no_grupo" class="form-control" runat="server">
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-3">
												<label for="observaciones_laboratorio_no_grupo">Observaciones:</label>
											</div>
											<div class="col-xs-12 col-md-9">
												<textarea rows="3" class="form-control" placeholder="Observaciones" id="observaciones_laboratorio_no_grupo" name="observaciones_laboratorio_no_grupo"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-md-12">
												<input type="submit" value="Guardar" class="form-control btn btn-success">
											</div>
										</div>
									</form>
								</div>
							</fieldset>
						</div>
					</div>
					<div class="tab-pane" id="asistencia_suplente" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 alert alert-info">
								<p>
									A continuación va a encontrar los artistas formadores que tienen grupos asignados,debe seleccionar el grupo al cual desea subir la asistencia suplencia y proceder a diligenciar los datos.
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
								<label for="SL_organizacion_artista_formador">Organización suplencia:</label>
							</div>
							<div class="col-xs-6 col-md-3">
								<select id="SL_organizacion_artista_formador" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
								<label for="SL_artista_formador_titular">Artista Formador Titular:</label>
							</div>
							<div class="col-xs-6 col-md-3">
								<select id="SL_artista_formador_titular" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
								<label for="SL_grupo_suplente">Grupo a suplir asistencia:</label>
							</div>
							<div class="col-xs-6 col-md-3">
								<select id="SL_grupo_suplente" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
						<div id="div_detalles_horario_grupo_suplencia">
							<div class="row">
								<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
									<label for="TB_dias_clase_semana_suplencia">Horario:</label>
								</div>
								<div class="col-xs-6 col-md-3">
									<input type="text" id="TB_dias_clase_semana_suplencia" disabled="disabled" class="form-control">
								</div>
							</div>
							<fieldset>
								<form id="form_registro_asistencia_suplencia" enctype="multipart/form-data">
								<legend style="text-align:center;">Datos de la sesión de clase:</legend>
								<div class="row" id="div_lugar_atencion">
									<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
										<label for="SL_LUGAR_ATENCION_SUPLENCIA">Lugar de Atención <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title="Lugar de Atención donde se dictó el taller.<br>Debe seleccionar 'REMOTO' si la sesión no fue presencial, cualquiera haya sido el canal virtual utilizado."></i>:</label>
									</div>
									<div class="col-xs-6 col-md-3">
										<select id="SL_LUGAR_ATENCION_SUPLENCIA" class="form-control selectpicker" title="Seleccione el Lugar de Atención"></select>
									</div>
								</div>
								<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
										<label for="SL_MODALIDAD_ATENCION_SUPLENCIA">Modalidad de Atención <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title="PRESENCIAL: Cuando el taller haya sido dictado en instalaciones físicas.<br> NO PRESENCIAL: Cuando el taller haya sido dictado de manera REMOTA, cualquiera haya sido el canal virtual utilizado.<br>MIXTO: Cuando en el taller hayan participado beneficiarios de manera PRESENCIAL y REMOTA simultáneamente."></i>:</label>
									</div>
									<div class="col-xs-6 col-md-3">
										<select id="SL_MODALIDAD_ATENCION_SUPLENCIA" class="form-control selectpicker" title="Seleccione la Modalidad de Atención"></select>
									</div>
								</div>
								<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
										<label for="SL_TIPO_ATENCION_SUPLENCIA">Tipo Atención <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title="PRESENCIAL: Cuando el taller haya sido dictado en instalaciones físicas.<br> SINCRÓNICA: Corresponde a los talleres realizados de manera REMOTA en el mismo momento, desde cualquier lugar (Google Meet/Zoom/Transmisión en vivo).<br>ASINCRÓNICA: Corresponde a los talleres realizados de manera REMOTA, teniendo en cuenta los espacios, ritmos y horarios de los estudiantes (en diferentes momentos, con material como guías, videos, documentos, que los beneficiarios realizan sin la presencia en vivo del formador)."></i>:</label>
									</div>
									<div class="col-xs-6 col-md-3">
										<select id="SL_TIPO_ATENCION_SUPLENCIA" class="form-control selectpicker" title="Seleccione el Tipo de Atención"></select>
									</div>
								</div>
								<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
										<label for="SL_MATERIAL_SUPLENCIA">Material Pedagógico:</label>
									</div>
									<div class="col-xs-6 col-md-3">
										<select id="SL_MATERIAL_SUPLENCIA" class="form-control selectpicker" title="Seleccione el Material Pedagógico">
										</select>
									</div>
								</div>
								<div class="row" id="div_salon">
									<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
										<label for="SL_ESPACIO_SUPLENCIA">Espacio/salón:</label>
									</div>
									<div class="col-xs-6 col-md-3">
										<select id="SL_ESPACIO_SUPLENCIA" class="form-control selectpicker" title="Seleccione el Espacio"></select>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
										<label for="TB_fecha_sesion_suplencia">Fecha de la sesión:</label>
									</div>
									<div class="col-xs-6 col-md-3">
										<div class="input-group date">
											<input type="text" id="TB_fecha_sesion_suplencia" readonly="readonly" class="form-control">
											<div class="input-group-addon" id="SPAN_fecha_sesion_supencia">
												<span class="glyphicon glyphicon-calendar"></span>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
										<label for="SL_HORAS_SESION_SUPLENCIA">Horas de la sesión:</label>
									</div>
									<div class="col-xs-6 col-md-3">
										<select type="number" id="SL_HORAS_SESION_SUPLENCIA" class="form-control selectpicker" title="Seleccione la cantidad de Horas">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
										</select>
									</div>									
								</div>
								<div class="row" style="padding:4px;">
									<div id="div_anexo_planilla" class="col-xs-6 col-md-3 col-md-offset-5" style="margin-top: 6px;" data-toggle="tooltip" title="Los archivos subidos reemplazarán los cargados anteriormente para ésta sesión de clase" data-placement="right">
										<div class="alert-danger">Tenga en cuenta que el archivo no debe superar los 50mb.</div>
										<input id="file_suplencia" multiple name="file_suplencia" type="file" class="filestyle" accept="application/pdf" data-btnClass="btn-danger" data-buttonBefore="true" runat="server" data-text="&nbspAnexo">
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12 table-responsive">
										<div id="div_table_estudiantes_grupo_suplencia"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="TX_observaciones_suplencia">Observaciones:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<textarea class="form-control" id="TX_observaciones_suplencia" placeholder="Observaciones"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
									<button class="eventoClic btn btn-success form-control" id="BT_guardar_asistencia_clase_suplencia">Guardar</button>
								</div>
							</div>
							</form>
						</fieldset>
					</div>
				</div>
				<div class="tab-pane" id="modificar_asistencia" role="tabpanel">
					<div class="row">
						<div class="col-xs-12 col-md-12 alert alert-warning">
							<p>
								A continuación va a encontrar <b>las sesiones registradas en cualquier grupo por usted durante el mes</b>, debe seleccionar el grupo y la fecha de la sesión de clase que desea modificar.
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
							<label for="SL_grupo_modificar">Seleccione el grupo:</label>
						</div>
						<div class="col-xs-6 col-md-3">
							<select id="SL_grupo_modificar" class="form-control selectpicker" data-live-search="true"></select>
						</div>
					</div>
					<fieldset>
						<legend>Datos de la sesión de clase:</legend>
						<div class="row">
							<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
								<label for="SL_fecha_sesion_grupo_modificar">Sesión de clase:</label>
							</div>
							<div class="col-xs-6 col-md-3">
								<select class="form-control selectpicker" data-live-search="true" id="SL_fecha_sesion_grupo_modificar" title="Seleccione una Fecha"></select>
							</div>
						</div>
						<div class="row" id="div_lugar_atencion">
									<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
										<label for="SL_LUGAR_ATENCION_MODIFICAR">Lugar de Atención <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title="Lugar de Atención donde se dictó el taller.<br>Debe seleccionar 'REMOTO' si la sesión no fue presencial, cualquiera haya sido el canal virtual utilizado."></i>:</label>
									</div>
									<div class="col-xs-6 col-md-3">
										<select id="SL_LUGAR_ATENCION_MODIFICAR" class="form-control selectpicker" title="Seleccione el Lugar de Atención"></select>
									</div>
								</div>
						<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
										<label for="SL_MODALIDAD_ATENCION_MODIFICAR">Modalidad de Atención <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title="PRESENCIAL: Cuando el taller haya sido dictado en instalaciones físicas.<br> NO PRESENCIAL: Cuando el taller haya sido dictado de manera REMOTA, cualquiera haya sido el canal virtual utilizado.<br>MIXTO: Cuando en el taller hayan participado beneficiarios de manera PRESENCIAL y REMOTA simultáneamente."></i>:</label>
									</div>
									<div class="col-xs-6 col-md-3">
										<select id="SL_MODALIDAD_ATENCION_MODIFICAR" class="form-control selectpicker" title="Seleccione la Modalidad de Atención"></select>
									</div>
								</div>
								<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
										<label for="SL_TIPO_ATENCION_MODIFICAR">Tipo Atención <i class="far fa-question-circle" style="color:#00adff" data-html="true" data-toggle="tooltip" data-placement="right" title="PRESENCIAL: Cuando el taller haya sido dictado en instalaciones físicas.<br> SINCRÓNICA: Corresponde a los talleres realizados de manera REMOTA en el mismo momento, desde cualquier lugar (Google Meet/Zoom/Transmisión en vivo).<br>ASINCRÓNICA: Corresponde a los talleres realizados de manera REMOTA, teniendo en cuenta los espacios, ritmos y horarios de los estudiantes (en diferentes momentos, con material como guías, videos, documentos, que los beneficiarios realizan sin la presencia en vivo del formador)."></i>:</label>
									</div>
									<div class="col-xs-6 col-md-3">
										<select id="SL_TIPO_ATENCION_MODIFICAR" class="form-control selectpicker" title="Seleccione el Tipo de Atención"></select>
									</div>
								</div>
								<div class="row" style="padding:4px;">
									<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
										<label for="SL_MATERIAL_MODIFICAR">Material Pedagógico:</label>
									</div>
									<div class="col-xs-6 col-md-3">
										<select id="SL_MATERIAL_MODIFICAR" class="form-control selectpicker" title="Seleccione el Material Pedagógico">
										</select>
									</div>
								</div>
						<div class="row" id="div_salon">
							<div class="col-xs-6 col-md-3 col-md-offset-2" style="text-align: right">
								<label for="SL_ESPACIO_MODIFICAR">Seleccione el Espacio/salón:</label>
							</div>
							<div class="col-xs-6 col-md-3">
								<select id="SL_ESPACIO_MODIFICAR" class="form-control selectpicker" title="Seleccione el Espacio"></select>
							</div>
						</div>
						<div class="row" style="padding:4px;">
							<div id="div_anexo_planilla" class="col-xs-6 col-md-3 col-md-offset-5" style="margin-top: 6px;" data-toggle="tooltip" title="Los archivos subidos reemplazarán los cargados anteriormente para ésta sesión de clase" data-placement="right">
								<div class="alert-danger">Tenga en cuenta que el archivo no debe superar los 50mb.</div>
								<button id="BT_subir_anexo_modificar" class="btn btn-danger subir_anexo" title="Subir Anexo"><span class="label label-danger" data-id_sesion_clase="0">Anexos</span></button>
							</div>
						</div>
						<div id="div_datos_sesion_clase_modificar">
							<div class="row">
								<div class="col-xs-12 col-md-12 table-responsive">
									<div id="div_table_estudiantes_sesion_modificar"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="TX_observaciones_modificar_sesion_clase">Observaciones:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<textarea class="form-control" id="TX_observaciones_modificar_sesion_clase" placeholder="Observaciones"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-3 col-xs-offset-4 col-md-3 col-md-offset-4">
									<button class="eventoClic btn btn-success form-control" id="BT_guardar_asistencia_clase_modificar_sesion">Guardar Modificación de Sesión</button>
								</div>
								<div class="col-xs-3 col-md-3">
									<button class="eventoClic btn btn-danger form-control" id="BT_eliminar_sesion_clase">Eliminar esta sesión</button>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="tab-pane" id="anexos_sesiones_clase" role="tabpanel">
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_mes_sesiones_anexo">Mes:</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<select name="SL_mes_sesiones_anexo" id="SL_mes_sesiones_anexo" class="form-control selectpicker"></select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_grupo_anexo">Grupo:</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<select name="SL_grupo_anexo" id="SL_grupo_anexo" class="form-control selectpicker"></select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-12 table-responsive">
							<div id="div_table_anexo"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_get_horas_no_horario" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Horas Dictadas</h4>
				</div>
				<div class="modal-body">
					<p>¿Cuantas horas duró la sesión de clase?</p>
					<input type="number" name="IN_horas_no_horario" id="IN_horas_no_horario" placeholder="horas" value="1" class="form-control" min="1" max="6">
				</div>
				<div class="modal-footer">
					<button type="button" id="set_horas_no_horario" class="btn btn-success">Establecer</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_retirar_estudiante" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Solicitar remover estudiante del grupo</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="alert alert-info col-xs-6 col-md-12">
							<p>Debe seleccionar la razón por la cual solicita retirar el estudiante del grupo.</p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_motivo_retiro_estudiante">Motivo:</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<select id="SL_razon_retiro_estudiante" class="form-control selectpicker" data-live-search="true">
								<option value='No volvió al colegio'>No volvió al colegio</option>
								<option value='Va mal en el colegio no le dan permiso'>Va mal en el colegio no le dan permiso</option>
								<option value='Problemas de salud'>Problemas de salud</option>
								<option value='No le motiva el área en la que se inscribió'>No le motiva el área en la que se inscribió</option>
								<option value='Problemas de convivencia'>Problemas de convivencia</option>
								<option value='Pérdida de año '>Pérdida de año </option>
								<option value='Cambio de grupo '>Cambio de grupo </option>
								<option value='Causa desconocida'>Causa desconocida</option>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="BT_solictar_retiro" class="btn btn-success">Solicitar Retiro</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div id="uploadModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Subir anexo de la sesión para los talleres realizados por fuera del aula virtual.</h4>
		</div>
		<div class="modal-body">
			<!-- Form -->
			<form method='post' action='' enctype="multipart/form-data">
			Seleccione un archivo : <input type='file' name='file_modal' id='file_modal' class='form-control' accept="application/pdf"><br>
			<input type='button' class='btn btn-info' value='Subir' id='btn_upload' name='btn_upload'>
			<input type='button' class='btn btn-danger' value='Sin Anexo' data-dismiss="modal">
			</form>

			<!-- Preview-->
			<div id='preview'></div>
		</div>
	
		</div>

	</div>
</div>
</body>
</html>