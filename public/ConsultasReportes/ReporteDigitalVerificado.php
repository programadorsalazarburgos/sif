<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/material-desing.css">

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >  
	<link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 

	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/jszip/dist/jszip.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>  
	<script src="../bower_components/jquery-validation/dist/jquery.validate.min.js" type="text/javascript" ></script>  
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
	<script src="../bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
	<script src="../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.js"> </script>
	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<script src='../LibreriasExternas/pdfmake/build/pdfmake.js?v=2020.04.20'></script>
	<script src='../LibreriasExternas/pdfmake/build/vfs_fonts.js?v=2020.04.20'></script>

	<script src="Js/ReporteDigitalVerificado.js?v=2021.08.17.2"></script>

	<style type="text/css">
		#nuevo_reporte table {
			width: 825px;
		}
		#nuevo_reporte table th, td {
			border: 1px solid black;
		}
		#nuevo_reporte p {
			width: 825px;
			text-align: left;
		}

		#div_modal_reporte table {
			width: 825px;
		}
		#div_modal_reporte table th, td {
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
					<h1 style="font-size: 45px; text-align: center;">Reporte De Informes De Asistencia Aprobados</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item  active"><a class="nav-link" data-toggle="tab" href="#listado" id="listado_link" role="tab">Listado</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="listado" role="tabpanel">
                        <div class="row" >
							<div class="col-xs-6 col-md-3">
								<label for="SL_usuario">Seleccione Usuario Que Aprueba:</label>
							</div>
                            <div class="col-xs-12 col-md-9">
								<select name="SL_usuario" id="SL_usuario" class="selectpicker form-control" data-live-search="true" title="Seleccione Un Usuario De La Lista"></select>
							</div>
						</div>
                        <div class="row" >
							<div class="col-xs-6 col-md-3">
								<label for="SL_anio_mes">Seleccione Un Periodo De Tiempo:</label>
							</div>
                            <div class="col-xs-12 col-md-9">
								<select name="SL_anio_mes" id="SL_anio_mes" class="selectpicker form-control" data-live-search="true" title="Seleccione Un Periodo De Tiempo De La Lista"></select>
							</div>
						</div>
						<div class="row" >
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
</body>
</html>