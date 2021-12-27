<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Consultar resultado evaluaciones</title>
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

	<script type="text/javascript" src="Js/Resultado_Evaluaciones.js?v=2018.10.18"></script>

</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="page-header">
						<h1>Consultar Resultado De Evaluaciones <small>Módulo Pedagógico</small></h1>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-6 col-md-4">
							<label for="SL_anio_reporte">Año:</label>
						</div>
						<div class="col-xs-12 col-md-8">
							<select class="selectpicker form-control" id="SL_anio_reporte" name="SL_anio_reporte">
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-4">
							<label for="SL_tipo_reporte">Tipo Reporte:</label>
						</div>
						<div class="col-xs-12 col-md-8">
							<select required="required" class="selectpicker form-control" id="SL_tipo_reporte" name="SL_tipo_reporte">
								<option value="0">Seleccione el reporte que desea ver</option>
								<optgroup label="Reporte Individual">
									<option value="1">Artista Formador Evaluado por estudiantes</option>
									<option value="2">Artista Formador Evaluado por funcionarios</option>
								</optgroup>
								<optgroup label="Reporte completo">
									<option value="4">Todas las evaluaciones realizadas por los estudiantes</option>
									<option value="5">Todas las evaluaciones realizadas a los artistas formadores</option>
								</optgroup>
							</select>
						</div>
					</div>
					<div class="row">
						<div class='col-xs-6 col-md-4'>
							<label id="LB_tipo_evaluacion"></label>
						</div>
						<div class='col-xs-12 col-md-8'>
							<select id="SL_tipo_evaluacion" class="form-control selectpicker" data-live-search="true">
								<option>Seleccione el tipo de reporte</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
							<button class="btn btn-success form-control" id="BT_ver_resultados_evaluaciones">Ver Resultados</button>
						</div>
					</div>
					<hr>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<div class="table-responsive">
								<table class="table" id="table_resultado_evaluacion"></table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>