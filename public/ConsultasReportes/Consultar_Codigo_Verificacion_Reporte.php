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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="Js/Consultar_Codigo_Verificacion_Reporte.js?v=2019.11.13"></script>

    <link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<script src='../LibreriasExternas/pdfmake/build/pdfmake.js?v=2019.11.08.001'></script>
	<script src='../LibreriasExternas/pdfmake/build/vfs_fonts.js?v=2019.11.08.001'></script>

</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consultar código de verificación</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#nuevo_reporte_tab" id="reporte_nuevo" role="tab"><b>Nuevo</b> Reporte Digital Mensual</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#reporte_2018" id="2018_tab" role="tab">2018 / 2019</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reporte_2017" id="2017_tab" role="tab">2017</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="nuevo_reporte_tab" role="tabpanel">
						<div class="row">
							<div class="col-xs-8 col-xs-offset-2 col-md-8 col-md-offset-2">
								<h3>Consultar reporte digital mensual según código de verificación</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="TX_codigo_nuevo">Escriba el código:</label>
							</div>
							<div class="col-xs-6 col-md-9">
								<input type="text" class="form-control" id="TX_codigo_nuevo" placeholder="Escriba el código de verficación" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
								<button class="btn btn-primary form-control" id="BT_consultar_nuevo_reporte">Consultar</button>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div id="DIV_resultado_busqueda_nuevo_codigo"></div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="reporte_2018" role="tabpanel">
						<div class="row">
							<div class="col-xs-6 col-xs-offset-4">
								<h3>Consultar códigos de verificación versión anterior para los años <b>2018 y 2019</b></h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="TX_codigo">Escriba el código:</label>
							</div>
							<div class="col-xs-6 col-md-9">
								<input type="text" class="form-control" id="TX_codigo" placeholder="Escriba el código de verficación" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
								<button class="btn btn-primary form-control" id="BT_consultar">Consultar</button>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div id="DIV_resultado_busqueda"></div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="reporte_2017" role="tabpanel">
						<div class="row">
							<div class="col-xs-6 col-xs-offset-4">
								<h3>Consultar códigos de verificación del año <b>2017</b></h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="TX_codigo_2017">Escriba el código:</label>
							</div>
							<div class="col-xs-6 col-md-9">
								<input type="text" class="form-control" id="TX_codigo_2017" placeholder="Escriba el código de verficación" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
								<button class="btn btn-primary form-control" id="BT_consultar_2017">Consultar</button>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<iframe id="frame" src="" width="100%" height="600"></iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
