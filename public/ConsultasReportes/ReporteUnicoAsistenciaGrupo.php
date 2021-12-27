<!DOCTYPE html>
<html>
<head>
	<title>ReporteUnicoAsistenciaGrupo</title>
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

	<script src="../bower_components/jszip/dist/jszip.min.js"></script> 
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>  
	<script src="../bower_components/jquery-validation/dist/jquery.validate.min.js" type="text/javascript" ></script>  
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
	<script src="../bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
	<script src="../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.js"> </script>

	<script src='../LibreriasExternas/pdfmake/build/pdfmake.js?v=2020.04.20'></script>
	<script src='../LibreriasExternas/pdfmake/build/vfs_fonts.js?v=2020.04.20'></script>

	<script src="Js/ReporteUnicoAsistenciaGrupo.js?v=2020.05.18"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid" style="padding-top: 30px">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1 style="font-size: 45px;">Reporte Unico Asistencia Grupo <small> (<a href="https://creaencasa.idartes.gov.co/" target="_blank">CREAENCASA</a>)</small></h1>
				</div>
			</div>
			<div class="panel-body">
			<!--
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_artista_formador">Artista Formador:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_artista_formador" class="selectpicker form-control" data-live-search="true"></select>
					</div>
				</div>
			-->
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_grupo">Grupo:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_grupo" class="selectpicker form-control" data-live-search="true"></select>
					</div>
				</div>
				<!--	
					<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_mes">Mes:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_mes" class="selectpicker form-control" data-live-search="true"></select>
					</div>
				</div>
				-->
				<div class="row" >
					<div class="col-xs-6 col-md-3">
						<label for="TX_mes">Mes del reporte:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="input-append date" id="TX_mes" data-date="2020-04" data-date-format="yyyy-mm">
							<input class="form-control" value="2020-04" type="text" readonly="readonly" name="date" >    
							<span class="add-on"><i class="icon-th"></i></span>
						</div>  
					</div>
				</div> 
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<button class="btn btn-success form-control" id="BT_generar_reporte">Generar Reporte</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>