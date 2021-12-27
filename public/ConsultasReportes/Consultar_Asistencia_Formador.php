<?php
session_start();
if(!isset($_SESSION["session_username"])) {
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
	<title>Consultar Asistencia Formador</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../LibreriasExternas/alertifyjs/css/alertify.min.css">
	<script type="text/javascript" src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>

	<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Consultar_Asistenica_Formador.js?v=1.0"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Historial asistencia<small> Sesiones clase Artista Formador</small></h1>
				</div>
				<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_clan">Seleccione el crea:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-tower"></span>
							</span>
							<select class="form-control selectpicker" data-live-search="true" id="SL_clan"></select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_grupo">Seleccione el grupo:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-education"></span>
							</span>
							<select class="form-control selectpicker" data-live-search="true" id="SL_grupo"></select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_mes_anio">Seleccione el mes:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
							<select class="form-control selectpicker" id="SL_mes_anio"></select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12 table-responsive">
						<table class="table table-hover" id="table_novedades">
							<thead>
								<tr>
									<th>Fecha</th>
									<th>Formador</th>
									<th>Asistencia</th>
									<th>Novedad</th>
									<th>Observación</th>
									<th>Fecha en que se registró</th>
									<th>Usuario que registró</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>