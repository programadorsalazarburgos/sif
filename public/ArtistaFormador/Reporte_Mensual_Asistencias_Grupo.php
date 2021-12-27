<?php
session_start();
if (!isset($_SESSION["session_username"])) {
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/material-desing.css">

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">

	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js"></script>

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../bower_components/jszip/dist/jszip.min.js"></script>
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
	<script src="../bower_components/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<script src="../bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
	<script src="../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.js"> </script>
	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<script src='../LibreriasExternas/pdfmake/build/pdfmake.js?v=2020.04.20'></script>
	<script src='../LibreriasExternas/pdfmake/build/vfs_fonts.js?v=2020.04.20'></script>

	<script src="Js/Reporte_Mensual_Asistencias_Grupo.js?v=2021.09.13.0"></script>

	<style type="text/css">
		#nuevo_reporte table {
			width: 825px;
		}

		#nuevo_reporte table th,
		td {
			border: 1px solid black;
		}

		#nuevo_reporte p {
			width: 825px;
			text-align: left;
		}

		#div_modal_reporte table {
			width: 825px;
		}

		#div_modal_reporte table th,
		td {
			border: 1px solid black;
		}

		#div_modal_reporte p {
			width: 825px;
			text-align: left;
		}
	</style>
</head>

<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid" style="padding-top: 30px">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1 style="font-size: 45px; text-align: center;">REPORTE DE ASISTENCIA MENSUAL CREAsss</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item "><a class="nav-link" data-toggle="tab" href="#nuevo_reporte" role="tab" id="nuevo_reporte_link">Nuevo Reporte Mensual</a></li>
					<li class="nav-item  active"><a class="nav-link" data-toggle="tab" href="#listado" id="listado_link" role="tab">Listado</a></li>
				</ul>
				<div class="tab-content">
					<br>
					<br>
					<div class="tab-pane" id="nuevo_reporte" role="tabpanel">
						<h1>Nueva verificación de asistencias</h1>
						<br>
						<div class="row">
							<div class="col-xs-12 col-lg-3">
								<label for="TX_mes">Mes del reporte:</label>
							</div>
							<div class="col-xs-12 col-lg-9">
								<div class="input-append date" id="TX_mes" data-date="2020-04" data-date-format="yyyy-mm">
									<input class="form-control" type="text" readonly="readonly" name="date">
									<span class="add-on"><i class="icon-th"></i></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-lg-3">
								<label for="SL_grupo">Grupo en que dictaron las sesiones:</label>
							</div>
							<div class="col-xs-12 col-lg-9">
								<select class="form-control selectpicker" data-live-search="true" id="SL_grupo"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-lg-3">
								<label for="SL_organizacion">Organización responsable de las sesiónes:</label>
							</div>
							<div class="col-xs-12 col-lg-9">
								<select class="form-control selectpicker" data-live-search="true" id="SL_organizacion"></select>
							</div>
						</div>
						<div class="row">
							<div id="div_nuevo_reporte" class="col-lg-12 col-xs-12"></div>
						</div>
					</div>
					<div class="tab-pane active" id="listado" role="tabpanel">
						<div class="row">
							<div id="div_filtros" name="div_filtros">
								<div style="padding-top:5px" class="col-xs-2 col-md-2 col-md-offset-3 text-right">
									<label>Año</label>
								</div>
								<div style="padding-top:5px" class="col-xs-4 col-md-4">
									<select id="SL_Year" title="Año" name="SL_Year" class="form-control selectpicker" data-live-search="true">
									</select>
								</div>
								<div style="padding-top:5px" class="col-xs-2 col-md-2 col-md-offset-3 text-right">
									<label>Línea de Atención</label>
								</div>
								<div style="padding-top:5px" class="col-xs-4 col-md-4">
									<select id="SL_Linea_Atencion" title="Línea de Atención" name="SL_Linea_Atencion" class="form-control selectpicker" data-live-search="true">
									</select>
								</div>
								<div style="padding-top:5px" class="col-xs-2 col-md-2 col-md-offset-3 text-right">
									<label>Convenio</label>
								</div>
								<div style="padding-top:5px" class="col-xs-4 col-md-4">
									<select id="SL_Convenio" title="Convenio" name="SL_Convenio" class="form-control selectpicker" data-live-search="true">
									</select>
								</div>
								<div style="padding-top:5px" class="col-xs-2 col-md-2 col-md-offset-3 text-right">
									<label>Colegio</label>
								</div>
								<div style="padding-top:5px" class="col-xs-4 col-md-4">
									<select id="SL_Colegio" title="Colegio" name="SL_Colegio" class="form-control selectpicker" data-live-search="true">
									</select>
								</div>
								<div style="padding-top:5px" class="col-xs-4 col-md-4 col-md-offset-5 text-right">
									<button id="bt_consultar_filtros_generales" class="btn btn-success form-control">Consultar</button>
								</div>
								<div style="padding-top:5px" class="col-xs-2 col-md-2 col-md-offset-3 text-right">
									<label>Artista Formador</label>
								</div>
								<div style="padding-top:5px" class="col-xs-4 col-md-4">
									<select id="SL_artista_formador" title="Artista Formador" name="SL_artista_formador" class="form-control selectpicker" data-live-search="true">
									</select>
								</div>
								<div style="padding-top:5px" class="col-xs-4 col-md-4 col-md-offset-5 text-right">
									<button id="bt_consultar_artista_formador" class="btn btn-success form-control">Consultar</button>
								</div>
							</div>
							<div class="clearfix"></div><br>
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive" id="div_table_listado_informes"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="modal_informe_mensual" data-keyboard="false" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg" role="document" style="width: 900px;">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Datos del informe</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div id="div_modal_reporte" class="col-lg-12 col-xs-12"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<div id="modal_corregir_novedad" data-keyboard="true" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg" role="document" style="width: 450px;">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 id="modal_corregir_novedad_title" class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div id="div_modal_corregir_novedad" class="col-lg-12 col-xs-12"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="cerrar_modal_novedad" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modal_ver_anexos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 id="modal_ver_anexos_title" class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div id="div_modal_ver_anexos" class="col-lg-12 col-xs-12">
							<table id="table_listado_anexos" class="table table-striped table-responsive">
								<thead>
									<tr>
										<th style="width: 20%;">Fecha Sesión</th>
										<th>Anexo</th>
										<th>Observaciones</th>
									</tr>
								</thead>
								<tbody id="tbody_listado_anexos"></tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="cerrar_modal_ver_anexos" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</body>

</html>