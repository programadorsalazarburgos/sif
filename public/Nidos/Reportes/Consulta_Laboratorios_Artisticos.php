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
	<title>Reporte Laboratorios Artísticos</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Consulta_Laboratorios_Artisticos.js?v=2019.08.1"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../../bower_components/jszip/dist/jszip.min.js" type="text/javascript" ></script>
	<script src="../../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

	<link rel="stylesheet" type="text/css" href="../../css/Nidos.css">
	<style>
	.centrar{
		text-align: center;
	}
	</style>

</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>CONSOLIDADO LABORATORIOS ARTÍSTICOS</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#consulta_atenciones_laboratorio" role="tab">1. Consulta Atenciones en Laboratorios </a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#consulta_atenciones_comunidad" role="tab">2. Consulta Atenciones Grupos de Comunidad </a></li>
				</ul>
				<div class="tab-content">

					<div class="tab-pane active" id="consulta_atenciones_laboratorio" role="tabpanel">
						<br>
						<center><h2><font color="teal"><label>ATENCIONES EN LABORATORIOS</label> </font></h2></center>
						<br><br>
						<div class="row">
							<label class="col-md-2" for="SL_Tipo_Laboratorio">Seleccione tipo de consulta:</label>
							<div class="col-md-3">
							<select class="form-control" data-live-search="true" title="Seleccione el Mes"  name="SL_Tipo_Laboratorio" id="SL_Tipo_Laboratorio">
							<option value="1">Atención Real</option><option value="2">Atención Nuevos</option></select>
							</div>
							<div class="col-md-1"></div>
							<label class="col-md-2" for="SL_Mes_Atenciones">Seleccionar el mes del reporte:</label>
							<div class="col-md-3">
							<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes_Atenciones" id="SL_Mes_Atenciones"></select>
							</div>
							<div class="col-md-1"></div>
						</div>
						<br><br>
						<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6"><input class="form-control btn btn-success" id="BT_Consultar_Laboratorios_Mes" type="submit" value="Consultar Laboratorios Artísticos"></div>
						<div class="col-md-3"></div>
                </div>
				 		<br><br>
						<div id="div_Laboratorios_Intervenciones" style="display: none;">
							<br><br>
							<div class='col-xs-12 col-md-12' id="div_table_Consolidado_Laboratorios"></div>

						</div>
				</div>

				<div class="tab-pane" id="consulta_atenciones_comunidad" role="tabpanel">
						<br>
						<center><h2><font color="teal"><label>ATENCIONES EN GRUPOS DE COMUNIDAD</label> </font></h2></center>
						<br><br>
					<div class="row">
							<label class="col-md-2" for="SL_Tipo_Comunidad">Seleccione tipo de consulta:</label>
							<div class="col-md-3">
							<select class="form-control" data-live-search="true" title="Seleccione el Mes"  name="SL_Tipo_Comunidad" id="SL_Tipo_Comunidad">
							<option value="1">Atención Real</option><option value="2">Atención Nuevos</option></select>
							</div>
							<div class="col-md-1"></div>
							<label class="col-md-2" for="SL_Mes_Atenciones">Seleccionar el mes del reporte:</label>
							<div class="col-md-3">
							<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes_Comunidad" id="SL_Mes_Comunidad"></select>
							</div>
							<div class="col-md-1"></div>
						</div>
						<br><br>
						<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6"><input class="form-control btn btn-success" id="BT_Consultar_Grupos_Comunidad" type="submit" value="Consultar Grupos de Comunidad"></div>
						<div class="col-md-3"></div>
                    </div>
						<br><br>
						<div id="div_Grupos_Comunidad" style="display: none;">
	           				<div class='col-xs-12 col-md-12' id="div_table_Grupos_Comunidad"></div>
			  			</div>
				</div>

				</div>
			</body>
</html>
