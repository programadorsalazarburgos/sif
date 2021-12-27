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

	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>  
<!-- 
	<script src="../bower_components/jszip/dist/jszip.min.js"></script> 
	<script src="../bower_components/jquery-validation/dist/jquery.validate.min.js" type="text/javascript" ></script>  
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
	<script src="../bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
	<script src="../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.js"> </script>
	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<script src='../LibreriasExternas/pdfmake/build/pdfmake.js?v=2019.04.01.010'></script>
	<script src='../LibreriasExternas/pdfmake/build/vfs_fonts.js?v=2019.04.01.010'></script>
 -->
	<script src="Js/Consulta_Reporte_Digital_Mensual.js?v=2019.10.01"></script>

</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid" style="padding-top: 30px">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1 style="font-size: 45px; text-align: center;">CONSULTAR REPORTE DIGITAL MENSUAL</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item  active"><a class="nav-link" data-toggle="tab" href="#listado" id="listado_link" role="tab">Listado</a></li>
				</ul>
				<div class="tab-content">
					<br>
					<br>
					<div class="tab-pane active" id="listado" role="tabpanel">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_periodo">Periodo Informe:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" data-live-search='true' id="SL_periodo"></select>
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
</body>