<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
}
else {
	$Id_Persona = $_SESSION["session_username"];
	$Id_Rol =	$_SESSION['session_usertype'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Consulta de Gestión - Infraestructura</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet"> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.excelhtml5.min.js"></script> 
	<script src="../bower_components/jszip/dist/jszip.min.js"></script>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

	<!-- Resources -->
	<script src="../LibreriasExternas/amcharts/amcharts/amcharts.js"></script>
	<script src="../LibreriasExternas/amcharts/amcharts/serial.js"></script>
	<script src="../LibreriasExternas/amcharts/amcharts/plugins/export/export.min.js"></script>
	<script src="../LibreriasExternas/ammap/themes/light.js"></script>	  
	<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>
	<script type="text/javascript" src="Js/Consulta_Gestion_Infraestructura.js?v=2020.05.22.3"></script>

	<style type="text/css">
		#div_grafica_total {
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
					<h1>Consulta de Gestión Mensual <small>Infraestructura</small></h1>
					<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'>
					<input type='hidden' id='id_rol' value='<?php echo $Id_Rol; ?>'>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-4 col-lg-offset-4">
					<div class="col-xs-6 col-md-2">
						<label for="SL_tipo_consulta" class="pull-right">Consulta:</label>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-6">
						<select id="SL_tipo_consulta" class="form-control selectpicker" data-live-search="true">
							<optgroup label="Inventario">
								<option value="registros" class="administrador">Registro de Inventario</option>
								<option value="traslados" class="administrador">Traslado de Inventario</option>
								<option value="observaciones" class="auxiliar">Observaciones de Inventario</option>
							</optgroup>
						</select>
					</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-4 col-lg-offset-4">
					<div class="col-xs-6 col-md-2">
						<label for="SL_anio" class="pull-right">Año:</label>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-6">
						<select id="SL_anio" class="form-control selectpicker" data-live-search="true">
							<option value="2021" selected="selected">2021</option>
							<option value="2020">2020</option>
							<option value="2019">2019</option>
							<option value="2018">2018</option>
							<option value="2017">2017</option>
						</select>
					</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-4 col-lg-offset-4">
					<div class="col-xs-6 col-md-2">
						<label for="SL_mes" class="pull-right">Mes:</label>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-6">
						<select id="SL_mes" class="form-control selectpicker" data-live-search="true"></select>
					</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<h4><p id="p_texto_accion" class="alert alert-success text-center"></p></h4>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div id="div_grafica_total"></div>
					</div>
					<div class="table-responsive col-xs-12 col-md-6">
						<table class="table" id="table_total_accion">
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
	<div class="modal fade" id="modal_detalle_inventario_registrado" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><b id="b_tipo_accion_title_modal"></b></h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered" id="table_inventario_registrado">
						<thead>
							<tr>
								<th>LUGAR</th>
								<th>TIPO BIEN</th>
								<th>CANTIDAD</th>
								<th>PLACA</th>
								<th>ELEMENTO</th>
								<th>DESCRIPCIÓN</th>
								<th>REGISTRO</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_detalle_solicitudes_traslado" role="dialog">
		<div class="modal-dialog modal-lg" style="width: 90% !important">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Traslados gestionados <b id="b_tipo_accion_title_modal"></b> durante el mes</h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered" id="table_traslados_inventario">
						<thead>
							<tr>
								<th>PLACA</th>
								<th>DESCRIPCION</th>
								<th>CANTIDAD</th>
								<th>ARGUMENTO</th>
								<th>ORIGEN</th>
								<th>DESTINO</th>
								<th>TIPO</th>
								<th>SOLICITUD</th>
								<th>ESTADO</th>
								<th>TRASLADO SIF</th>
								<th>TRASLADO FÍSICO</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_detalle_observaciones" role="dialog">
		<div class="modal-dialog modal-lg" style="width: 70% !important">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Observaciones realizadas <b id="b_tipo_accion_title_modal"></b> durante el mes</h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered" id="table_observaciones_inventario">
						<thead>
							<tr>
								<th>CREA</th>
								<th>PLACA</th>
								<th>ELEMENTO</th>
								<th>DESCRIPCION</th>
								<th>OBSERVACION</th>
								<th>FECHA</th>
								<th>ESTADO</th>
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