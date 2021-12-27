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
	<title>Consultar Disponibilidad Horario</title>
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

    <script type="text/javascript" src="Js/Consultar_Disponibilidad_Horario.js?v=2019.12.10"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consultar Disponibilidad Horario Artistas<small> CREA</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#panel_consultar" role="tab">Consulta</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="panel_consultar" role="tabpanel">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_zona">Zona:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" data-live-search="true" id="SL_zona"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_area_artistica">Area Artistica:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" multiple="multiple" data-live-search="true" id="SL_area_artistica"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_dias">Días:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" multiple="multiple" data-live-search="true" id="SL_dias">
									<option value="1">Lunes</option>
									<option value="2">Martes</option>
									<option value="3">Miercoles</option>
									<option value="4">Jueves</option>
									<option value="5">Viernes</option>
									<option value="6">Sabado</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-md-offset-4 col-xs-12">
								<button class="btn btn-info form-control" id="BT_consultar">Consultar</button>
							</div>
						</div>
						<div class="row">
							<div class="table">
								<table id="table_consulta" class="table" style="width:100%">
									<thead>
										<tr>
											<th>A</th>
											<th>B</th>
											<th>Artista Formador</th>
											<th>Grupo</th>
											<th>Día</th>
											<th>Hora Inicio</th>
											<th>Hora Fin</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>