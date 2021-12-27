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
	<title>Crear Grupo</title>
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

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

    <script type="text/javascript" src="Js/RegistrarAsistencia.js?v=2019.09.18"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Registrar Asistencia<small> GRUPOS TRANSICIÓN</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#panel_asistencia_mis_grupos" role="tab">Asistencia mis grupos</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="panel_asistencia_mis_grupos" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>Registrar Asistencia</h4>
							</div>
						</div>
					</div>
					<legend>Mis grupos de transición</legend>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_grupo">Seleccione el grupo:</label>
						</div>
						<div class="col-xs-6 col-md-9">
							<select id="SL_grupo" class="form-control selectpicker" data-live-search="true"></select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="TB_fecha_sesion">Seleccione la fecha:</label>
						</div>
						<div class="col-xs-6 col-md-9">
							<div class="input-group date">
								<input type="text" id="TB_fecha_sesion" readonly="readonly" class="form-control">
								<div class="input-group-addon" id="SPAN_fecha_sesion">
									<span class="glyphicon glyphicon-calendar"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="TB_horas_sesion">Horas dictadas:</label>
						</div>
						<div class="col-xs-6 col-md-9">
							<input type="number" name="TB_horas_sesion" id="TB_horas_sesion" min="0" max="5" value="0" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="table-responsive">
								<h3>Mayores de 6</h3>
								<div id="div_table_mayores"></div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<h3 >Menores de 6</h3>
							<div class="table-responsive">
								<div id="div_table_menores"></div>
							</div>
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
							<button class="eventoClic btn btn-success form-control" id="BT_guardar_asistencia">Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>