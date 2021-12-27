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
	<title>Reporte Mensual Gestión CREA</title>
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

	<script type="text/javascript" src='../LibreriasExternas/pdfmake/pdfmake.min.js'></script>
	<script type="text/javascript" src='../LibreriasExternas/pdfmake/vfs_fonts.js'></script>
    
    <script type="text/javascript" src="Js/Reporte_Mensual_Asignacion.js?v=2021.07.06.0"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Reporte Mensual <small>Gestión CREA</small></h1>
				</div>
			</div>
			<div class="panel-body">
			<div class="row">
					<div class="col-xs-6 col-md-2">
						<label for="SL_anio">Año:</label>
					</div>
					<div class="col-xs-12 col-md-4">
						<select id="SL_anio" class="form-control selectpicker" data-live-search="true">
							<option value="2021" selected="selected">2021</option>
							<option value="2020">2020</option>
							<option value="2019">2019</option>
							<option value="2018">2018</option>
							<option value="2017">2017</option>
						</select>
					</div>
					<div class="col-xs-6 col-md-2">
						<label for="SL_mes">Mes:</label>
					</div>
					<div class="col-xs-12 col-md-4">
						<select id="SL_mes" class="form-control selectpicker" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="table-responsive col-xs-12 col-md-6">
						<h3>Beneficiarios Administrados en el mes</h3>
						<table class="table" id="table_total_beneficiarios_administrados">
							<thead>
								<tr>
									<th>Linea atención</th>
									<th>Asignados</th>
									<th>Removidos</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="table-responsive col-xs-12 col-md-6">
						<h3>Beneficiarios creados en SIF durante el mes</h3>
						<table class="table" id="table_total_beneficiarios_creados">
							<thead>
								<tr>
									<th>SIMAT</th>
									<th>CREAENCASA</th>
									<th>FORMULARIO</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<hr></hr>
					</div>
				</div>
				<div class="row">
					<div class="table-responsive col-xs-8 col-xs-offset-2 col-md-6 col-xs-offset-3">
						<h3>Grupos Administrados en el mes</h3>
						<table class="table" id="table_total_grupos_administrados">
							<thead>
								<tr>
									<th>Linea atención</th>
									<th>Creados</th>
									<th>Cerrados</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
						<button class="button btn-primary form-control" id="BT_generar_reporte">Generar reporte PDF con código de verificación</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_detalle_estudiantes_administrados" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Estudiantes <b id="b_tipo_accion_title_modal"></b> a Grupo</h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered" id="table_estudiantes_administrados">
						<thead>
							<tr>
								<th>Identificacion</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Fecha</th>
								<th>Grupo</th>
								<th>Observaciones</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_detalle_estudiantes_creados" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Estudiantes creados en <b id="b_tipo_accion_title_modal"></b> durante el mes</h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered" id="table_estudiantes_creados">
						<thead>
							<tr>
								<th>Identificacion</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Fecha</th>
								<th>Dirección</th>
								<th>Teléfono</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
</body>