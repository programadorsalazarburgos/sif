<?php
session_start();
if (!isset($_SESSION["session_username"])) {
	header("location:../index.php");
} else {
	$Id_Persona = $_SESSION["session_username"];
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Administración Oferta Mensual</title>


	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Oferta_Mensual.js?v=2020.10.26.03"></script>
	<script type="text/javascript" src="Js/Reporte_PDF.js?v=2020.10.26.03"></script>

	<script src="../../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../node_modules/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<link href="../../node_modules/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

	<script src="../../node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<link href="../../node_modules/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

	<script src="../../node_modules/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../../node_modules/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../../node_modules/jszip/dist/jszip.min.js"></script>

	<script src="../../node_modules/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
	<link href="../../node_modules/datatables.net-fixedcolumns-bs/css/fixedColumns.bootstrap.min.css" rel="stylesheet">

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<link href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

	<link href="../../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<link href="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.js" type="text/javascript"></script>
	<script src="../../bower_components/moment/moment.js" type="text/javascript"></script>

	<script src="../../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="../../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js"></script>

	<script src="../../bower_components/pdfmake/build/pdfmake.js" type="text/javascript"></script>
	<script src="../../bower_components/pdfmake/build/vfs_fonts.js" type="text/javascript"></script>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="../../css/Nidos.css">

</head>

<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración Oferta Mensual</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#creacion_lugares" role="tab">Crear oferta para eventos</a></li>
					<li class="nav-item"><a id="nav_consultar_lugares" class="nav-link" data-toggle="tab" href="#consultar_oferta" role="tab">Administrar oferta creada</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="creacion_lugares" role="tabpanel">
						<form id="form_crear_oferta_diaria">
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-md-12 text-center bg-info">
										<h4>Oferta Mensual Eventos</h4>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-md-2" for="SL_Agregar">1. Indique la cantidad de espacios:</label>
									<div class="col-md-10">
										<a id="btn_Agregar" class="btn btn-primary " Title="Agregar" data-toggle='tooltip' data-placement="right">Agregar</a>
										<a id="btn_Quitar" class="btn btn-danger " Title="Quitar" data-toggle='tooltip' data-placement="right">Quitar</a>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="col-md-2" for="SL_Agregar">2. Fecha de programación:</label>
									<div class="col-md-3">
										<div class="input-group date">
											<input type="text" readonly="readonly" class="form-control input-sm" id="TX_Fecha_Encuentro" placeholder="Fecha de la experiencia" style="border-style: solid; border-width: 2px; border-color: #3c763d;">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
									<div class="col-md-7"></div>
								</div>
							</div>
							<div class="form-group">
								<table class="table" style="width:100%" id="tabla_Titulos_Registro">
									<thead>
										<tr>
											<th style="width: 1%; vertical-align: middle;">#</th>
											<th style="width: 33%">Día</th>
											<th style="width: 33%">Fecha</th>
											<th style="width: 33%">Franja</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width: 1%; vertical-align: middle;">1</td>
											<td style="width: 33%">
												<input type="text" class="form-control" placeholder="Día" id="TX_Dia_1" name="TX_Dia_1" required>
											</td>
											<td style="width: 33%">
												<input type="text" class="form-control fecha" placeholder="Fecha" id="TX_Fecha_1" name="TX_Fecha_1" required>
											</td>
											<td style="width: 33%">
												<select class="form-control selectpicker franja" data-live-search="true" name="TX_Franja_1" id="TX_Franja_1" title="Seleccione una opción" required></select>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
										<input class="form-control btn btn-primary" id="BT_guardar_oferta" type="submit" value="Crear oferta para este día">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="consultar_oferta" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Consultar Oferta Mensual</h4>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-md-2" for="SL_Mes">Seleccione el Mes:</label>
								<div class="col-md-10">
									<select class="form-control SeleccionarGrupo" data-live-search="true" name="SL_Mes" id="SL_Mes" title="Seleccione un Mes"></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="table-responsive" id="div_oferta_mes" style="display: none;">
								<table id="tabla_oferta_mensual" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th>Día</th>
											<th>Fecha</th>
											<th>Franja de Atención</th>
											<th>Nombre Evento</th>
											<th>Solicita</th>
											<th>Entidad</th>
											<th>Tipo de atención</th>
											<th>Modalidad Atención</th>
											<th># Equipos Solicitados</th>
											<th>Localidad</th>
											<th>Upz</th>
											<th>Nombre Lugar</th>
											<th>Barrio</th>
											<th>Dirección</th>
											<th>Tipo Lugar</th>
											<th>Otro, cuál</th>
											<th>Contacto Lugar</th>
											<th>Ubicación</th>
											<th>Indicaciones de Llegada</th>
											<th>Gestor Asiste</th>
											<th>Propuesta Atención</th>
											<th>Artistas Apoyo</th>
											<th>Transporte</th>
											<th>Contacto Transporte</th>
											<th>Llegada Transporte</th>
											<th>Particularidades Terreno</th>
											<th>Equipos Asignados</th>
											<th>Ficha Técnica</th>
											<th>Acompañamiento Circulación</th>
											<th>Llegada Artistas</th>
											<th>Hora Montaje</th>
											<th>Hora Montaje Nido</th>
											<th>Hora Inicio Atención</th>
											<th>Hora Finalización</th>
											<th>Hora Desmontaje </th>
											<th>Estado</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal modal-wide fade" id="miModalEditarEvento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">EDITAR INFORMACIÓN EVENTO</h4>
				</div>
				<input type="hidden" id="TX_ID_Evento_Editar" name="TX_ID_Evento_Editar">
				<div class="modal-body">
					<form id="form_editar_evento_div">
						<div class="form-group">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<font color="teal">
									<h4 class="modal-title">Información Solicitante</h4>
								</font>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12"><br></div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<label>Día:</label>
									<select class="form-control selectpicker" data-live-search="true" name="TX_Dia_Editar" id="TX_Dia_Editar" title="Seleccione Opción">
										<option value="Domingo">Domingo</option>
										<option value="Lunes">Lunes</option>
										<option value="Martes">Martes</option>
										<option value="Miércoles">Miércoles</option>
										<option value="Jueves">Jueves</option>
										<option value="Viernes">Viernes</option>
										<option value="Sábado">Sábado</option>
									</select>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<label>Fecha:</label>
									<input type="date" class="form-control" id="TX_Fecha_Editar" name="TX_Fecha_Editar">
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<label>Franja:</label>
									<select class="selectpicker form-control franja" data-live-search="true" name="TX_Franja_Editar" id="TX_Franja_Editar" title="Seleccione una opción"></select>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<label>Nombre Evento:</label>
									<input type="text" class="form-control" id="TX_NomEvento_Editar" name="TX_NomEvento_Editar" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
									<label>Localidad:</label>
									<select class="form-control selectpicker" data-live-search="true" name="TX_Localidad_Editar" id="TX_Localidad_Editar" title="Seleccione una opción" required></select>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<label>Lugar atención:</label>
									<select class="form-control selectpicker" data-live-search="true" multiple name="TX_LAtencion_Editar" id="TX_LAtencion_Editar" title="Selección múltiple" required></select>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
									<label>Tipo de atención:</label>
									<select class="form-control selectpicker tipo-atencion" id="SL_Tipo_atencion_editar" title="Seleccione una opción">
										<option value="Virtual">Virtual</option>
										<option value="Presencial">Presencial</option>
										<option value="Asincrónica">Asincrónica</option>
									</select>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<label>Tipo de Lugar:</label>
									<select class="form-control selectpicker tipo-lugar" data-live-search="true" name="SL_Tipo_Lugar_Editar" id="SL_Tipo_Lugar_Editar" title="Seleccione una opción" required></select>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
									<label>Otro ¿Cuál?:</label>
									<input type="text" class="form-control" id="TX_OtroLugar_Editar" disabled>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
									<label>Entidad Dirigida:</label>
									<input type="text" class="form-control" id="TX_Entidad_Editar" name="TX_Entidad_Editar">
								</div>
								<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
									<label>Linea Atención:</label>
									<select class="form-control selectpicker" multiple data-actions-box="true" name="TX_Lineatencion_Editar" id="TX_Lineatencion_Editar" title="Selección múltiple" required>
										<option value="1">Entorno Familiar</option>
										<option value="2">Entorno Institucional</option>
										<option value="3">Comunidad</option>
									</select>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<label>Modalidad de Atención:</label>
									<select class="form-control selectpicker modalidad-atencion" multiple data-actions-box="true" name="SL_Modalidad_Editar" id="SL_Modalidad_Editar" title="Selección múltiple" required></select>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
									<label>Gestor Asiste:</label>
									<select class="form-control selectpicker" data-live-search="true" name="TX_Gestor_Editar" id="TX_Gestor_Editar" title="Seleccione una opción" required>
										<option value="1">SI</option>
										<option value="2">NO</option>
									</select>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<label>Contacto Lugar:</label>
									<input type="text" class="form-control" id="TX_ContactoL_Editar" name="TX_ContactoL_Editar">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
									<label>Propuesta Atención:</label>
									<textarea rows="4" class="form-control" id="TX_Propuesta_Editar" placeholder="Indique Horarios y grupos-niveles de atención" name="TX_Propuesta_Editar"></textarea>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
									<label>Artistas de Apoyo Operativo:</label>
									<textarea rows="4" class="form-control" placeholder="Propuesta Atención" id="LB_Artistas_Editar" name="LB_Artistas_Editar"></textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<label>Transporte:</label>
									<input type="text" class="form-control" id="TX_Transporte_Editar">
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<label>Contacto Transporte:</label>
									<input type="text" class="form-control" id="TX_ContactoTrans_Editar">
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<label>Llegada Transporte:</label>
									<input type="text" class="form-control" id="TX_LlegadaTrans_Editar">
								</div>

							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<label>Particularidades Terreno:</label>
									<input type="text" class="form-control" id="TX_Particularidades_Editar">
								</div>
								<div class="col-lg-4 col-md-4">
									<label>No de Niñas y Niños:</label>
									<input type="number" class="form-control" id="TX_Ninos_Editar">
								</div>
								<div class="col-lg-4 col-md-4">
									<label>No de Adultos:</label>
									<input type="number" class="form-control" id="TX_Adultos_Editar">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<label>Ubicación:</label>
									<input type="text" class="form-control" id="TX_Ubicacion_Editar" name="TX_Transporte_Editar">
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<label>Indicaciones de Llegada:</label>
									<input type="text" class="form-control" id="TX_Indicaciones_Editar" name="TX_ContactoTrans_Editar">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<font color="teal">
									<h4 class="modal-title">Información Circulación</h4>
								</font>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12"><br></div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Equipo Asignado:</label>
									<select class="form-control selectpicker equipo" multiple data-actions-box="true" data-live-search="true" name="SL_Equipo_Editar" id="SL_Equipo_Editar" title="Selección múltiple"></select>
								</div>
								<div class="col-md-4">
									<label>Visita Técnica:</label>
									<select class="form-control selectpicker" data-live-search="true" name="TX_VisitaTecnica_Editar" id="TX_VisitaTecnica_Editar" title="Seleccione Opción">
										<option value="1">SI</option>
										<option value="2">NO</option>
									</select>
								</div>
								<div class="col-md-4">
									<label>Acompañamiento desde Circulación:</label>
									<input type="text" class="form-control" id="TX_Circulacion_Editar" name="TX_Circulacion_Editar">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Llegada de los Artistas:</label>
									<input type="text" class="form-control" id="TX_LlegadaArtistas_Editar" name="TX_LlegadaArtistas_Editar">
								</div>
								<div class="col-md-4">
									<label>Montaje Experiencia Artística:</label>
									<input type="text" class="form-control" id="TX_HoraMontaje_Editar" name="TX_HoraMontaje_Editar">
								</div>
								<div class="col-md-4">
									<label>Montaje del Nido y/o Experiencia Musical:</label>
									<input type="text" class="form-control" id="TX_MontajeNido_Editar" name="TX_MontajeNido_Editar">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Inicio de Atención:</label>
									<input type="text" class="form-control" id="TX_InicioAtencion_Editar" name="TX_InicioAtencion_Editar">
								</div>
								<div class="col-md-4">
									<label>Finalización de Atención:</label>
									<input type="text" class="form-control" id="TX_FinAtencion_Editar" name="TX_FinAtencion_Editar">
								</div>
								<div class="col-md-4">
									<label>Desmontaje de Experiencia:</label>
									<input type="text" class="form-control" id="TX_Hora_Desmontaje_Editar" name="TX_Hora_Desmontaje_Editar">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row" style="text-align: center">
								<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4" style="text-align: center">
									<input class="form-control btn btn-block btn-success" id="BT_EditarEvento" type="submit" value="EDITAR EVENTO">
								</div>
								<div class="col-xs-6 col-sm-6 col-md-4" style="text-align: center">
									<button type="button" class="form-control btn btn-block btn-danger" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">CANCELAR</span>
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal modal-wide fade" id="miModalAprobar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="form_aprobar_evento_div">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel" style="text-align: center">APROBAR EVENTO CIRCULACIÓN</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-4 col-md-4">
									<label>Fecha del Evento:</label>
									<font color="teal" size="3">
										<label id="LB_Dia_Evento"></label>
										<label id="LB_Fecha_Evento"></label>
									</font>
									<label>Franja</label>
									<font color="teal" size="3">
										<label id="LB_Franja_Evento"></label>
									</font>
								</div>
								<div class="col-xs-4 col-md-4">
									<label>Nombre Evento:</label>
									<font color="teal" size="3">
										<label id="LB_Evento"></label>
									</font>
								</div>
								<div class="col-md-4">
									<label>Localidad:</label>
									<font size="3" color="teal">
										<label id="LB_Localidad"></label>
									</font>
								</div>
							</div>
						</div>
						<input type="text" hidden="hidden" id="TX_ID_Evento_Aprobar_Div" name="TX_ID_Evento_Aprobar_Div">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-4 col-md-4">
									<label>Quien Solicita el Evento:</label>
									<font color="teal" size="3">
										<label id="LB_Solicita"></label>
									</font>
								</div>
								<div class="col-md-4">
									<label>Entidad a Quien va Dirigida:</label>
									<font color="teal" size="3">
										<label id="LB_Entidad"></label>
									</font>
								</div>
								<div class="col-md-4">
									<label>Contacto Lugar:</label>
									<font color="teal" size="3">
										<label id="LB_Contacto"></label>
									</font>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Gestor Asiste:</label>
									<font color="teal" size="3">
										<label id="LB_Gestor"></label>
									</font>
								</div>
								<div class="col-md-4">
									<label>Número de Niños y Niñas:</label>
									<font color="teal" size="3">
										<label id="LB_Ninos"></label>
									</font>
								</div>
								<div class="col-md-4">
									<label>Número de Adultos:</label>
									<font color="teal" size="3">
										<label id="LB_Adultos"></label>
									</font>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3 col-lg-3">
									<label>Lugar atención:</label>
									<select class="form-control selectpicker" data-live-search="true" id="SL_Lugar_Evento_Div" title="Selección múltiple" multiple required></select>
								</div>
								<div class="col-md-3 col-lg-3">
									<label>Tipo de atención:</label>
									<select class="form-control selectpicker tipo-atencion" id="SL_Tipo_Atencion_Div" title="Seleccione una opción" required>
										<option value="Virtual">Virtual</option>
										<option value="Presencial">Presencial</option>
										<option value="Asincrónica">Asincrónica</option>
									</select>
								</div>
								<div class="col-md-3 col-lg-3">
									<label>Tipo de Lugar:</label>
									<select class="form-control selectpicker tipo-lugar" data-live-search="true" id="SL_Tipo_Lugar_Div" title="Seleccione una opción" required></select>
								</div>
								<div class="col-md-3 col-lg-3">
									<label>Otro, ¿Cuál?:</label>
									<input type="text" class="form-control" id="TX_OtroLugar_Div" disabled>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4 col-lg-4">
									<label>Solicitud Información:</label>
									<select class="form-control selectpicker" data-live-search="true" id="SL_Solicitud_Div" title="Seleccione una opción" required>
										<option value="1">SI</option>
										<option value="2">NO</option>
									</select>
								</div>
								<div class="col-md-4 col-lg-4">
									<label>Linea de Atención:</label>
									<select class="form-control selectpicker" multiple data-actions-box="true" id="SL_Linea_Atencion_Div" title="Selección múltiple" required>
										<option value="1">Entorno Familiar</option>
										<option value="2">Entorno Institucional</option>
										<option value="3">Comunidad</option>
									</select>
								</div>

								<div class="col-md-4 col-lg-4">
									<label>Modalidad de Atención:</label>
									<select class="form-control selectpicker modalidad-atencion" multiple data-actions-box="true" id="SL_Modalidad_Div" title="Selección múltiple" required></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-9">
									<label>Propuesta Atención:</label>
									<textarea rows="4" class="form-control" id="TX_Propuesta_Div" required></textarea>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
									<label>Artistas de Apoyo Operativo:</label>
									<textarea rows="4" class="form-control" id="LB_Artistas" name="LB_Artistas" required></textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
									<label>Transporte:</label>
									<input type="text" class="form-control" id="TX_Transporte_Div" required>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
									<label>Contacto Transporte:</label>
									<input type="text" class="form-control" id="TX_Contacto_Trans_Div" required>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
									<label>Hora Llegada Transporte:</label>
									<input type="text" class="form-control" id="TX_Hora_Llegada_Div" required>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
									<label>Particularidades del Espacio:</label>
									<input type="text" class="form-control" id="TX_Terreno_Div" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<label>Ubicación: </label>
									<input type="text" class="form-control" id="TX_Ubicacion_Div">
								</div>
								<div class="col-lg-6 col-md-6">
									<label>Indicaciones de Llegada:</label>
									<input type="text" class="form-control" id="TX_Indicaciones_Div">
								</div>
							</div>
						</div>


						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<font color="teal">
										<h3 class="modal-title" id="myModalLabel" style="text-align: center;">INFORMACIÓN CIRCULACIÓN</h3>
									</font>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Cantidad de Equipos Solicitados:</label>
									<font color="red" size="4">
										<label id="LB_Solicita_Equipos"></label>
									</font>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Equipo Asignado:</label>
									<select class="form-control selectpicker equipo" multiple data-actions-box="true" data-live-search="true" id="SL_Equipo_Div" title="Seleccione una opción" required></select>
								</div>
								<div class="col-md-4">
									<label>Visita Técnica:</label>
									<select class="form-control selectpicker" data-live-search="true" id="SL_Ficha_Tecnica_Div" title="Seleccione una opción" required>
										<option value="1">SI</option>
										<option value="2">NO</option>
									</select>
								</div>
								<div class="col-md-4">
									<label>Acompañamiento desde Circulación:</label>
									<input type="text" class="form-control" id="TX_Acompanamiento_Div" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Llegada de los Artistas:</label>
									<input type="text" class="form-control" id="TX_Llegada_Artistas_Div" required>
								</div>
								<div class="col-md-4">
									<label>Montaje Experiencia Artística:</label>
									<input type="text" class="form-control" id="TX_Hora_Montaje_Div" required>
								</div>
								<div class="col-md-4">
									<label>Montaje del Nido y/o Experiencia Musical:</label>
									<input type="text" class="form-control" id="TX_Montaje_Nido" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Inicio de Atención:</label>
									<input type="text" class="form-control" id="TX_Inicio_Atencion_Div" required>
								</div>
								<div class="col-md-4">
									<label>Finalización de Atención:</label>
									<input type="text" class="form-control" id="TX_Fin_Atencion_Div" required>
								</div>
								<div class="col-md-4">
									<label>Desmontaje de Experiencia:</label>
									<input type="text" class="form-control" id="TX_Hora_Desmontaje_Div" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="form-group">
									<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4">
										<button class="btn btn-block btn-success" id="BT_Aprobar" type="submit">Aprobar evento</button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4">
										<button type="button" class="form-control btn btn-block btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal" id="miModalCancelar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">CANCELAR OFERTA O EVENTO</h4>
				</div>
				<input type="text" hidden="hidden" id="TX_ID_Evento_Cancelar" name="TX_ID_Evento_Cancelar">
				<div class="modal-body">
					<form id="form_cancelar_evento_div">
						¿Esta seguro que desea eliminar la Oferta o Evento creada para el día <label id="LB_Dia"></label> <label id="LB_Fecha"></label> evento <label id="LB_EventoCa"></label> ?
						<br><br>
						<div class="row" style="text-align: center">
							<div class="form-group">
								<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4" style="text-align: center">
									<input class="form-control btn btn-block btn-success" id="BT_Cancelar" type="submit" value="SI">
								</div>
								<div class="col-xs-6 col-sm-6 col-md-4" style="text-align: center">
									<button type="button" class="form-control btn btn-block btn-danger" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">NO</span>
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

</html>