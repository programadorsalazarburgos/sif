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
	<title>Administración Lugares Circulación</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Solicitud_Eventos_Circulacion.js?v=2020.03.23.4"></script>
	<script type="text/javascript" src="Js/Reporte_PDF.js?v=2020.03.23.4"></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet">
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<link href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

	<link href="../../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<link href="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.js" type="text/javascript"></script>
	<script src="../../bower_components/moment/moment.js" type="text/javascript"></script>

	<script src="../../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js"></script>

	<script src="../../bower_components/pdfmake/build/pdfmake.js" type="text/javascript"></script>
	<script src="../../bower_components/pdfmake/build/vfs_fonts.js" type="text/javascript"></script>
	<script src="../../LibreriasExternas/pdfmake/build/vfs_fonts_nidos.js" type="text/javascript"></script>

</head>

<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Solicitud Evento</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#solicitar_evento" role="tab">Solicitar Evento</a></li>
					<li class="nav-item"><a id="nav_consultar_eventos" class="nav-link" data-toggle="tab" href="#consultar_mis_eventos" role="tab">Consultar mis Eventos</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="solicitar_evento" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Solicitud Eventos Circulación</h4>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-md-2" for="SL_Mes">Seleccione el Mes:</label>
								<div class="col-md-10">
									<select class="form-control Mes" data-live-search="true" name="SL_Mes" id="SL_Mes" title="Seleccione un Mes"></select>
								</div>
							</div>
						</div>
						<fieldset>
							<div class="table-responsive" id="div_oferta_mes" style="display: none;">
								<legend>
									<font color="teal">Listado oferta del mes: </font>
								</legend>
								<table id="tabla_oferta_mensual" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th>Día</th>
											<th>Fecha</th>
											<th>Franja de Atención</th>
											<th>Nombre Evento</th>
											<th>Localidad</th>
											<th>Solicita</th>
											<th>Entidad</th>
											<th>Tipo de Lugar</th>
											<th>Cantidad Equipos</th>
											<th>RESERVAR</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</fieldset>
					</div>
					<div class="tab-pane" id="consultar_mis_eventos" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Consultar Eventos y Confirmarlos</h4>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-md-2" for="SL_Mes_Eventos">Seleccione el Mes:</label>
								<div class="col-md-10">
									<select class="form-control Mes" data-live-search="true" name="SL_Mes_Eventos" id="SL_Mes_Eventos" title="Seleccione un Mes"></select>
								</div>
							</div>
						</div>
						<fieldset>
							<div class="table-responsive" id="div_mis_eventos" style="display: none;">
								<legend>
									<font color="teal">Listado oferta del mes: </font>
								</legend>
								<table id="tabla_mis_eventos_mes" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th>Día</th>
											<th>Fecha</th>
											<th>Franja de Atención</th>
											<th>Nombre Evento</th>
											<th>Localidad</th>
											<th>Solicita</th>
											<th>Entidad</th>
											<th>Tipo de Lugar</th>
											<th>RESERVAR</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="miModalReservar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">RESERVA EVENTO CIRCULACIÓN</h4>
				</div>
				<div class="modal-body">
					<form id="form_reservar_div">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12">
									<p>Por medio de este formulario usted podrá realizar la reserva a un evento del día <label id="fecha"></label></p>
									<!-- <br>
										<label id="disponible"></label> -->
									<input type="text" hidden="hidden" id="TX_ID_Evento_Div" name="TX_ID_Evento_Div">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Nombre Evento:</label>
									<input type="text" class="form-control" id="TX_Evento_Div" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Localidad:</label>
									<select class="form-control selectpicker" data-live-search="true" id="SL_Localidad_Div" title="Seleccione una opción" required></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Entidad dirigida:</label>
									<input type="text" class="form-control" id="TX_Entidad_Div" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Tipo de atención:</label>
									<select class="form-control selectpicker tipo-atencion" id="SL_Tipo_Atencion_Div" title="Seleccione una opción" required>
										<option value="Virtual">Virtual</option>
										<option value="Presencial">Presencial</option>
										<option value="Asincrónica">Asincrónica</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Tipo de Lugar:</label>
									<select class="form-control selectpicker tipo-lugar" data-live-search="true" id="SL_Tipo_Lugar_Div" title="Seleccione una opción" required></select>
								</div>
								<div class="col-md-6">
									<label>Otro, ¿Cuál?:</label>
									<input type="text" id="TX_Otro_Lugar_Div" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Cantidad de Equipos:</label>
									<select class="form-control selectpicker" data-live-search="true" id="SL_Equipos_solicitados" title="Seleccione una opción" required></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>No de Niñas y Niños:</label>
									<input type="number" class="form-control" id="TX_Ninos_Div" required></span>
								</div>
								<div class="col-md-6">
									<label>No de Adultos:</label>
									<input type="number" class="form-control" id="TX_Adultos_Div" required></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4">
									<button class="btn btn-block btn-success" id="BT_reservar" type="submit">Reservar</button>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-4">
									<button type="button" class="btn btn-block btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal modal-wide fade" id="miModalConfirmar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">CONFIRMAR EVENTO CIRCULACIÓN</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-xs-6 col-md-6">
								<label>Quien Solicita el Evento: </label>
								<font color="teal" size="3">
									<label id="Solicita"></label>
								</font>
							</div>
							<div class="col-xs-6 col-md-6">
								<label>Localidad: </label>
								<font color="teal" size="3">
									<label id="localidad"></label>
								</font>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-6 col-md-6">
								<label>Nombre Evento: </label>
								<font color="teal" size="3">
									<label id="NomEvento"></label>
								</font>
							</div>
							<div class="col-xs-6 col-md-6">
								<label>Fecha: </label>
								<font color="teal" size="3">
									<label id="LB_Dia_Evento"></label>
									<label id="LB_Fecha_Evento"></label>
								</font>
								<label>Franja:</label>
								<font color="teal" size="3">
									<label id="LB_Franja_Evento"></label>
								</font>
							</div>
						</div>
					</div>
					<input type="text" hidden="hidden" id="TX_ID_Evento_Confirmar_Div" name="TX_ID_Evento_Confirmar_Div">

					<form id="form_confirmar_evento_div">
						<div class="row">
							<div class="form-group col-lg-4 col-md-4">
								<label>Nombre Evento:</label>
								<input type="text" class="form-control" id="TX_Nombre_Div" required>
							</div>
							<div class="form-group col-lg-4 col-md-4">
								<label>Lugar del Evento:</label>
								<select class="form-control selectpicker" multiple data-live-search="true" id="TX_Lugar_Evento_Div" title="Selección múltiple" required></select>
							</div>
							<div class="form-group col-lg-4 col-md-4">
								<label>Entidad a Quien va Dirigida:</label>
								<input type="text" class="form-control" id="TX_Entidad_Conf_Div" required>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-4 col-md-4">
								<label>Tipo de atención:</label>
								<select class="form-control selectpicker tipo-atencion" id="SL_Tipo_Atencion_Conf_Div" title="Seleccione una opción" required>
									<option value="Virtual">Virtual</option>
									<option value="Presencial">Presencial</option>
									<option value="Asincrónica">Asincrónica</option>
								</select>
							</div>
							<div class="form-group col-lg-4 col-md-4">
								<label>Tipo de lugar:</label>
								<select class="form-control selectpicker tipo-lugar" data-live-search="true" id="SL_Tipo_Lugar_Conf_Div" title="Seleccione una opción" required></select>
							</div>
							<div class="form-group col-lg-4 col-md-4">
								<label>Otro, ¿Cuál?</label>
								<input type="text" class="form-control" id="TX_Otro_Lugar_Conf_Div">
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-3 col-md-4">
								<label>Contacto Lugar (Nombre y Teléfono):</label>
								<input type="text" class="form-control" id="TX_Contacto_Div" required>
							</div>
							<div class="form-group col-lg-3 col-md-4">
								<label>Ubicación:</label>
								<input type="text" class="form-control" id="TX_Ubicacion_Div" required>
							</div>
							<div class="form-group col-lg-6 col-md-4">
								<label>Indicaciones de Llegada:</label>
								<input type="text" class="form-control" id="TX_Indicaciones_Div" required>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-3 col-md-3">
								<label>Linea Atención:</label>
								<select class="form-control selectpicker" multiple data-actions-box="true" id="SL_Linea_Atencion_Div" title="Seleccione una opción" required>
									<option value="1">Entorno Familiar</option>
									<option value="2">Entorno Institucional</option>
									<option value="3">Comunidad</option>
								</select>
							</div>
							<div class="cform-group ol-lg-3 col-md-3">
								<label>Modalidad de Atención:</label>
								<select class="form-control selectpicker" multiple data-actions-box="true" id="SL_Modalidad_Div" title="Seleccione una opción" required></select>
							</div>
							<div class="form-group col-lg-3 col-md-3">
								<label>Gestor Asiste:</label>
								<select class="form-control selectpicker" data-live-search="true" id="SL_Gestor_Asis_Div" title="Seleccione una opción" required>
									<option value="1">SI</option>
									<option value="2">NO</option>
								</select>
							</div>
							<div class="form-group col-lg-3 col-md-3">
								<label>Solicitud Información:</label>
								<select class="form-control selectpicker" data-live-search="true" id="SL_Solicitud_Div" title="Seleccione una opción" required>
									<option value="1">SI</option>
									<option value="2">NO</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-9">
									<label>Propuesta Atención:</label>
									<textarea rows="4" class="form-control" placeholder="Indique Horarios y grupos-niveles de atención" id="TX_Propuesta_Div" required></textarea>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
									<label>Artistas de Apoyo Operativo:</label>
									<textarea rows="4" class="form-control" placeholder="Relacione todos los artistas locales de apoyo" id="TX_Artistas_Div" required></textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<label>Transporte:</label>
									<input type="text" class="form-control" id="TX_Transporte_Div" required>
								</div>
								<div class="col-lg-4 col-md-4">
									<label>Contacto Transporte:</label>
									<input type="text" class="form-control" id="TX_Contacto_Trans_Div" required>
								</div>
								<div class="col-lg-4 col-md-4">
									<label>Hora Llegada Transporte:</label>
									<input type="text" class="form-control" id="TX_Hora_Llegada_Div" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<label>Particularidades del Terreno:</label>
									<input type="text" class="form-control" id="TX_Terreno_Div" required>
								</div>
								<div class="col-lg-4 col-md-4">
									<label>No de Niños y Niñas:</label>
									<input type="number" class="form-control" id="TX_Ninos_Conf" required>
								</div>
								<div class="col-lg-4 col-md-4">
									<label>No de Adultos:</label>
									<input type="number" class="form-control" id="TX_Adultos_Conf" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4">
									<button class="form-control btn btn-block btn-success" id="BT_confirmar" type="submit">Confirmar evento</button>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-4">
									<button type="button" class="form-control btn btn-block btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="miModalLugarA" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">INFORMACIÓN LUGAR DE ATENCIÓN</h4>
				</div>
				<input type="hidden" id="TX_ID_Lugar_Atencion" name="TX_ID_Lugar_Atencion">
				<div class="modal-body">
					<form id="form_creacion_lugar">
						<div class="form-group">
							<div class="row">
								<p>Actualice o registro los datos del lugar de atención del evento que esta registrando.</p>
							</div>
						</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<label>Localidad:</label>
							<select class="form-control selectpicker" data-live-search="true" id="SL_Localidad_Modificar" title="Seleccione una opción" required></select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<label>Upz:</label>
							<select class="form-control selectpicker" data-live-search="true" id="SL_Upz_Modificar" title="Seleccione una opción" required></select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<label>Barrio:</label>
							<input type="text" class="form-control" id="TX_Barrio_Modificar" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<label>Entidad:</label>
							<select class="form-control selectpicker" data-live-search="true" id="SL_Entidad_Modificar" title="Seleccione una opción" required></select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<label>Nombre Lugar:</label>
							<input type="text" class="form-control" id="TX_NombreLugar_Modificar" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12">
							<label>Dirección:</label>
							<input type="text" class="form-control" id="TX_Direccion_Modificar" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4">
							<button class="btn btn-block btn-success" id="BT_Guardar_Lugar" type="submit">Guardar</button>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4">
							<button class="btn btn-block btn-danger" id="BT_Cerrar_Lugar" type="button">Cerrar</button>
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