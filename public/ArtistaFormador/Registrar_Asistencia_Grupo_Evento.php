<?php
	session_start();
	if(!isset($_SESSION["session_username"])) {
		header("location:index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Registrar Asistencia Evento</title>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>  

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

    <script type="text/javascript" src="Js/Registrar_Asistencia_Evento.js?v=2019.09.11"></script> 
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Registrar Asistencia <small>Evento</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#registrar_asistencia_evento" id="nav_registrar_asistencia_evento" role="tab">Nueva asistencia evento mis grupos</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#modificar_asistencia_evento" id="nav_modificar_asistencia_evento" role="tab">Modificar/Eliminar asistencia evento</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="registrar_asistencia_evento" role="tabpanel">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_evento">Evento:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" id="SL_evento" data-live-search="true" title="Evento"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="TX_fecha_asistencia_evento">Fecha sesión en evento:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<div class="input-group date">
								    <input type="text" id="TX_fecha_asistencia_evento" readonly="readonly" class="form-control">
								    <div class="input-group-addon" id="SPAN_fecha_asistencia_evento">
								        <span class="glyphicon glyphicon-calendar"></span>
								    </div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_grupo">Grupo:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" id="SL_grupo" data-live-search="true"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12 table-responsive">
								<div id="div_table_estudiantes_grupo"></div>
							<!--
								<table class="table" id="table_estudiantes_grupo">
									<thead>
										<tr>
											<th>Identificación</th>
											<th>Apellidos</th>
											<th>Nombres</th>
											<th>Asistencia</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							-->
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_horas_sesion_evento">Horas de participación</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" required="required" title="Seleccione una opción" data-live-search="true" id="SL_horas_sesion_evento">
									<option value="1">Una (01)</option>
									<option value="2">Dos (02)</option>
									<option value="3">Tres (03)</option>
									<option value="4">Cuatro (04)</option>
									<option value="5">Cinco (05)</option>
								</select>
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
								<button class="btn btn-success form-control" id="BT_guardar_asistencia_sesion_evento" disabled="disabled">Guardar</button>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="modificar_asistencia_evento" role="tabpanel">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_eventos_registrados">
									Seleccione evento:
								</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select id="SL_eventos_registrados" class="selectpicker form-control" data-live-search="true"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_sesion_evento">
									Seleccione la sesión respectiva al grupo:
								</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select id="SL_sesion_evento" class="selectpicker form-control" data-live-search="true"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12 table-responsive">
								<div id="div_table_estudiantes_grupo_sesion_evento"></div>
							<!--
								<table class="table" id="table_estudiantes_grupo_sesion_evento">
									<thead>
										<tr>
											<th>Identificación</th>
											<th>Apellidos</th>
											<th>Nombres</th>
											<th>Asistencia</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							-->
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_horas_edicion_sesion_evento">Horas de participación:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" required="required" title="Seleccione una opción" data-live-search="true" id="SL_horas_edicion_sesion_evento">
									<option value="1">Una (01)</option>
									<option value="2">Dos (02)</option>
									<option value="3">Tres (03)</option>
									<option value="4">Cuatro (04)</option>
									<option value="5">Cinco (05)</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="TX_observaciones_edicion_sesion_evento">Observaciones:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<textarea class="form-control" id="TX_observaciones_edicion_sesion_evento" placeholder="Observaciones"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3 col-xs-offset-4 col-md-3 col-md-offset-4">
								<button class="eventoClic btn btn-success form-control" id="BT_editar_asistencia_sesion_evento">Guardar Modificación de Sesión</button>
							</div>
							<div class="col-xs-3 col-md-3">
								<button class="eventoClic btn btn-danger form-control" id="BT_eliminar_asistencia_sesion_evento">Eliminar esta sesión</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>