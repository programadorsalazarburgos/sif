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
	<title>Administrar Colegios CREA</title>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../bower_components/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet" type="text/css">
	
	<script type="text/javascript" src="Js/Administrar_Parametros.js?v=2018.12.05."></script> 
</head>
<style type="text/css">
.swal2-modal .swal2-input {
	text-transform: uppercase;
}
</style>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de Parámetros</h1>
				</div>
			</div>
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active" ><a class="nav-link eventoClic parametros_nav" data-toggle="tab" href="#parametros_tab" id="parametros_nav" role="tab">Parametros y Detalles</a></li>
				<li class="nav-item"><a class="nav-link eventoClic dias_subsanacion_nav" data-toggle="tab" href="#dias_subsanacion_tab" id="dias_subsanacion_nav" role="tab">Días de subsanación</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="parametros_tab" role="tabpanel">
					<div class="panel-body col-md-6 col-md-offset-3">
						<div class="row"> 
							<div class="col-xs-3 col-md-3">
								<label for="SL_PARAMETRO">Seleccione el PARÁMETRO:</label>
							</div>
							<div class="col-xs-9 col-md-9">
								<div class="input-group">
									<select id="SL_PARAMETRO" class="form-control selectpicker" data-actions-box="true" data-live-search="true" title="Elija un PARÁMETRO"></select>
									<span class="input-group-btn">
										<button class="btn btn-success" id="BT_NUEVO_PARAMETRO" name="BT_NUEVO_PARAMETRO"><span class="fas fa-plus-square"></span></button>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<br>
							<div class="col-xs-12 col-md-12">
								<div class="jumbotron">
									<strong>PARAMETROS ASOCIADOS</strong>
									<hr>
									<table id='table_parametro_detalle' name='table_parametro_detalle' class="table table-hover">
										<caption>
											<button class="btn btn-success" onclick="agregar_Fila()" data-toggle="tooltip" title="Añadir parametro!" data-placement="left"><i class="fas fa-plus"></i></button>
											<a href="#" id="BT_Guardar" class="form-control btn btn-success hidden"><i class="fas fa-save"></i> Guardar</a>
										</caption>
										<thead>
											<th class="row-centered">Parámetro</th>
											<th class="row-centered">Valor</th>
											<th class="row-centered">Estado CREA</th>
											<th class="row-centered">Estado NIDOS</th>
											<th class="row-centered">Opciones</th>
										</thead>
										<tbody id="body_table_parametro_detalle" name="body_table_parametro_detalle">
										</tbody>
									</table> 
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="dias_subsanacion_tab" role="tabpanel">
					<div class="panel-body" id="div_administrar_dias_subsanacion">
					</div>
				</div>
			</div>
		</div>
	</div>	
</body>
</html>
