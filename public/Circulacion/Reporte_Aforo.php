<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Reporte Aforo</title>

	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>	

	<!-- <link href="../bower_components/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript" ></script> -->

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<!-- <link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script> -->

	<!-- <link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/jszip/dist/jszip.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

	<script type="text/javascript" src="Js/Reporte_Aforo.js?v=2019.12.10"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="text-center panel-title"> REPORTE AFORO DE EVENTOS</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#eventos_distritales" id="eventos_distritales_tab" role="tab">Eventos Distritales</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eventos_locales" id="eventos_locales_tab" role="tab">Eventos Locales</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="eventos_distritales" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<div id="div_table_eventos_distritales"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="eventos_locales" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<div id="div_table_eventos_locales"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>