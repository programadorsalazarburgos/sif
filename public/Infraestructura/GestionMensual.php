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
	<title>Gestión Mensual - Infraestructura</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Consulta_Con_Grafica_Asignacion_Estudiantes_Grupos.js?v=2020.03.18.0"></script>

	<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

	<!-- Resources -->
	<script src="../LibreriasExternas/amcharts/amcharts/amcharts.js"></script>
	<script src="../LibreriasExternas/amcharts/amcharts/serial.js"></script>
	<script src="../LibreriasExternas/amcharts/amcharts/plugins/export/export.min.js"></script>
	<script src="../LibreriasExternas/ammap/themes/light.js"></script>	  
	<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

	<style type="text/css">
		#div_grafica_asignacion {
			width: 100%;
			height: 700px;
		}

		.amcharts-export-menu-top-right {
			top: 10px;
			right: 0;
		}
		a[href="http://www.amcharts.com/javascript-maps/"],
		a[href="http://www.amcharts.com/javascript-charts/"]
		{ 
		display: none !important;
		}
	</style>

</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading"> 
				<div class="page-header">
					<h1>Gestión Mensual <small>Infraestructura</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-6 col-md-2">
						<label for="SL_tipo_consulta">Consulta:</label>
					</div>
					<div class="col-xs-12 col-md-4">
						<select id="SL_tipo_consulta" class="form-control selectpicker" data-live-search="true">
							<optgroup label="Inventario">
								<option value="registro">Registro de Inventario</option>
								<option value="observaciones">Observaciones de Inventario</option>
							</optgroup>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-2">
						<label for="SL_anio">Año:</label>
					</div>
					<div class="col-xs-12 col-md-4">
						<select id="SL_anio" class="form-control selectpicker" data-live-search="true">
							<option value="2020" selected="selected">2020</option>
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
					<div class="col-xs-12 col-md-12">
						<h4><p id="p_texto_accion" class="alert alert-success text-center"></p></h4>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div id="div_grafica_asignacion"></div>
					</div>
					<div class="table-responsive col-xs-12 col-md-6">
						<table class="table" id="table_detalle_estudiantes_administrados">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
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
					<h4 class="modal-title"><b id="b_tipo_accion_title_modal"></b></h4>
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
								<th>Tipo Grupo</th>
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