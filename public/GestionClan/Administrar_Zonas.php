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
	<title>Administración Zonas</title>
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

    <script type="text/javascript" src="Js/Administrar_Zonas.js?v=2020.07.30"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de zonas<small> CREA</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#panel_crear_zona" role="tab">Creación De Una Nueva Zona</a></li>
					<li class="nav-item"><a id="nav_modificar_zona" class="nav-link" data-toggle="tab" href="#panel_modificar_zona">Modificar Zona</a></li>
					<!-- <li class="nav-item"><a id="nav_administrar_artista_avatar" class="nav-link" data-toggle="tab" href="#panel_administrar_artista_avatar">Administrar Artistas Formadores Avatar</a></li> -->
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="panel_crear_zona" role="tabpanel">
						<form id="form_nueva_zona">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Creación De Zonas</h4>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="TX_nombre_zona">Nombre Zona:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<input type="text" class="form-control" name="TX_nombre_zona" id="TX_nombre_zona" placeholder="Nombre Zona" required="required">
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="SL_responsable_zona">Responsable Zona:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select name="SL_responsable_zona" id="SL_responsable_zona" class="form-control selectpicker" data-live-search="true" required="required"></select>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="SL_localidades_zona">Localidades Zona:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select name="SL_localidades_zona" id="SL_localidades_zona" class="form-control selectpicker" data-live-search="true" multiple="multiple" required="required"></select>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="SL_creas_zona">Creas Zona:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select name="SL_creas_zona" id="SL_creas_zona" class="form-control selectpicker" data-live-search="true" multiple="multiple" required="required"></select>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-md-12">
									<hr>
								</div>
							</div>
							<!-- <div id="div_cantidad_artistas_por_area"></div> -->
							<div class="row">
								<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
									<input type="submit" class="btn btn-success form-control" name="BT_guardar_nueva_zona" id="BT_guardar_nueva_zona" value="Guardar">
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="panel_modificar_zona" role="tabpanel">
						<form id="form_modificar_zona">
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="SL_zona_modificar">Zona:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select name="SL_zona_modificar" title="Seleccione una zona" id="SL_zona_modificar" class="form-control selectpicker" data-live-search="true"></select>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-md-12">
									<hr>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="TX_nombre_zona_modificar">Nombre Zona:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<input type="text" class="form-control" name="TX_nombre_zona_modificar" id="TX_nombre_zona_modificar" placeholder="Nombre Zona" required="required">
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="SL_responsable_zona_modificar">Responsable Zona:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select name="SL_responsable_zona_modificar" id="SL_responsable_zona_modificar" class="form-control selectpicker" data-live-search="true" required="required"></select>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="SL_localidades_zona_modificar">Localidades Zona:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select name="SL_localidades_zona_modificar" id="SL_localidades_zona_modificar" class="form-control selectpicker" data-live-search="true" multiple="multiple" required="required"></select>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="SL_creas_zona_modificar">Creas Zona:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select name="SL_creas_zona_modificar" id="SL_creas_zona_modificar" class="form-control selectpicker" data-live-search="true" multiple="multiple" required="required"></select>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-md-12">
									<hr>
								</div>
							</div>
							<div id="div_cantidad_artistas_por_area_modificar"></div>
							<div class="row">
								<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
									<input type="submit" class="btn btn-success form-control" name="BT_guardar_zona_modificar" id="BT_guardar_zona_modificar" value="Guardar">
								</div>
							</div>
						</form>
					</div>
					<!-- <div class="tab-pane" id="panel_administrar_artista_avatar" role="tabpanel">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_zona_artistas">Zona:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select name="SL_zona_artistas_avatar" id="SL_zona_artistas_avatar" required="required" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</body>