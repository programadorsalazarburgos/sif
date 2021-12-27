<?php
session_start();
if (!isset($_SESSION["session_username"])) {
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
	<title>Reporte PANDORA</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Consulta_Pandora_Territorial.js?v=2020.11.26.1"></script>
	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet">
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
	<script src="../../bower_components/jszip/dist/jszip.min.js" type="text/javascript"></script>
	<script src="../../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>

	<script src="../../bower_components/pdfmake/build/pdfmake.js" type="text/javascript"></script>
	<script src="../../bower_components/pdfmake/build/vfs_fonts.js" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" href="../../css/Nidos.css">

	<script src="../../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
</head>

<body>

	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>REPORTE MENSUAL PANDORA - TERRITORIAL</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#experiencias_cifras" role="tab">Revisión de experiencias</a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="experiencias_cifras" role="tabpanel">
						<br>
						<div class="row">
						<div class="col-md-3"><br></div>							
							<div class="col-md-6">
							<label>Seleccione el mes del reporte:</label>
								<select class="form-control" data-live-search="true" name="SL_Mes_Cifras" id="SL_Mes_Cifras"></select>
						</div>
						</div>
						<br>
						<div class="row">
						<div class="col-md-3"><br></div>							
							<div class="col-md-6">
							<input class="form-control btn btn-primary" id="BT_Pandora" type="submit" value="Generar reporte PANDORA">
						</div>
						</div>
						
						<br>
						<div id="div-reporte-evento" style="display: none;">
							<div class="row">
								<div class='col-xs-12 col-md-12'>
									<table id='table-reporte-pandora' class='table table-striped table-bordered table-hover' width='100%' style='font-size: 12px;'>
										<thead>
											<tr>
												<th rowspan='2' style='background-color: #D4E6F1'>Número actividades</th>
												<th rowspan='2' style='background-color: #D4E6F1'>Fecha realización de la actividad</th>
												<th rowspan='2' style='background-color: #D4E6F1'>Lugar de atención</th>
												<th rowspan='2' style='background-color: #D4E6F1'>Capacidad/Aforo</th>
												<th rowspan='2' style='background-color: #D4E6F1'>Localidad</th>
												<th rowspan='2' style='background-color: #D4E6F1'>Upz-Upr</th>
												<th rowspan='2' style='background-color: #D4E6F1'>Barrio</th>
												<th rowspan='2' style='background-color: #D4E6F1'>Número total de artistas en la actividad</th>
												<th rowspan='2' style='background-color: #D4E6F1'>Personas inscritas a la actividad</th>
												<th rowspan='2' style='background-color: #D4E6F1'>Total Mujeres</th>
												<th rowspan='2' style='background-color: #D4E6F1'>Total Hombres</th>
												<th rowspan='2' style='background-color: #D4E6F1'>Total Beneficiarios</th>

												<th colspan='6' style='background-color: #7FB3D5; text-align:center'>SECTORES ETARIOS</th>
												<th colspan='7' style='background-color: #52BE80; text-align:center'>SECTORES SOCIALES</th>
												<th colspan='6' style='background-color: #C39BD3; text-align:center'>GRUPOS ÉTNICOS</th>												
												<th rowspan='2' style='background-color: #7FB3D5'>OBSERVACIONES</th>
											</tr>
											<tr>
												<th style='background-color: #7FB3D5'>Primera Infancia entre 0 y 5 años</th>
												<th style='background-color: #7FB3D5'>Infancia y 6-12 años</th>
												<th style='background-color: #7FB3D5'>Adolescencia 13-17 años</th>
												<th style='background-color: #7FB3D5'>Juventud 18-28 años</th>
												<th style='background-color: #7FB3D5'>Personas Adultas 29-59 años</th>
												<th style='background-color: #7FB3D5'>Personas Mayores 60 años en adelante</th>
												
												<th style='background-color: #52BE80'>Comunidades Campesinas y Rurales</th>
												<th style='background-color: #52BE80'>Mujeres Gestantes</th>
												<th style='background-color: #52BE80'>Personas con discapacidad</th>
												<th style='background-color: #52BE80'>Personas privadas de la libertad</th>
												<th style='background-color: #52BE80'>Personas víctimas del conflicto armado</th>
												<th style='background-color: #52BE80'>Población migrante</th>
												<th style='background-color: #52BE80'>Personas víctimas de trata</th>

												<th style='background-color: #C39BD3'>Pueblo Rrom – Gitano</th>
												<th style='background-color: #C39BD3'>Pueblo y/o comunidad indígena</th>
												<th style='background-color: #C39BD3'>Comunidades negras</th>
												<th style='background-color: #C39BD3'>Población afrodescendiente</th>
												<th style='background-color: #C39BD3'>Comunidades palenqueras</th>
												<th style='background-color: #C39BD3'>Pueblo raizal</th>												
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
</body>

</html>