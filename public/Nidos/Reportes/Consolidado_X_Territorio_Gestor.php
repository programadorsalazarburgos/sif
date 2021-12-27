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
	<title>Consolidado por Duplas</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Consolidado_X_Territorio_Gestor.js?v=2018.1.0.1"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../../bower_components/jszip/dist/jszip.min.js" type="text/javascript" ></script>
	<script src="../../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Consolidado Información por Duplas</h1>
			</div>
		</div>
		<div class="panel-body">
	<form id="form_nuevo_lugar_nidos">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#creacion_lugares" role="tab">CONSOLIDADO DUPLAS</a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="creacion_lugares" role="tabpanel">
					<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>CONSOLIDADO INFORMACIÓN POR DUPLA</h4>
						</div>
					</div>
					<br>
						<fieldset>
							<div class="panel-group" id="acordion_duplas">

							</div>
						</fieldset>
					</form>
				</div>

			</div>
		</div>
</body>
</html>
