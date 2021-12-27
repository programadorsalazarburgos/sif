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
	<title>Cobertura</title>
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

	<!-- <link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script> -->

    <script type="text/javascript" src="Js/BolsaArtistasZona.js?v=2021.05.03.01"></script>
</head>
<body style="font-family:Arial !important">
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Matriz de asignación <small>Artistas y Grupos</small></h1>
			</div>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#panel_tabla_bolsa" role="tab">Bolsa por zonas</a></li>
				<!-- <li class="nav-item"><a id="nav_consultar_pacto" class="nav-link" data-toggle="tab" href="#panel_consultar_pacto">Consultar Estado De Un Pacto</a></li> -->
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="panel_tabla_bolsa" role="tabpanel">
					<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>Paso 2: Bolsa por zonas por área artística</h4>
						</div>
					</div>
                    <!-- <div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_anio">Seleccione Año:</label>
						</div>
                        <div class="col-xs-12 col-md-9">
                        <select class="form-control" placeholder="Año" id="SL_anio" data-live-search="true" name="SL_anio"></select>
						</div>
					</div> -->
                    <div class="row">
						<div class="col-xs-12 col-md-12 text-center">
                            <div id="div_table_bolsa_artistas" class="table-responsive"></div>
                        </div>
					</div>
                    <!-- <div class="row">
						<div class="col-xs-12 col-md-4 col-md-offset-4">
                            <a href="#" class="btn btn-success form-control" id="BT_guardar">Guardar</a>
                        </div>
					</div> -->
                </div>
			</div>
        </div>
    </div>
</body>
