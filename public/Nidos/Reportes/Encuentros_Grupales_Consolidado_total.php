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
	<title>Reporte Encuentros Grupales</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Encuentros_Grupales_Consolidado_total.js?v=2018.1.0.2"></script>

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
					<h1>CONSOLIDADO TOTAL - ATENCIONES MENSUALES </h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#consulta_atenciones_territorio" role="tab">1. Consulta Atenciones por Territorio </a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#encuentros_grupales_entorno" role="tab">2. Encuentros Grupales por Entorno</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#encuentros_grupales_upz" role="tab">3. Encuentros Grupales por UPZ</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#laboratorios_intervenciones" role="tab">4. Laboratorios</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#metas_primera_infancia" role="tab">5. Metas Primera Infancia</a></li>
				</ul>
				<div class="tab-content">


					<div class="tab-pane active" id="consulta_atenciones_territorio" role="tabpanel">
						<br>
						<center><h2><font color="teal"><label>CONSULTA ATENCIONES POR TERRITORIO</label> </font></h2></center>
						<br><br>
						<div class="row">
							<label class="col-md-2" for="SL_Territorio">Seleccione el territorio:</label>
							<div class="col-md-3">
							<select class="form-control" data-live-search="true" title="Seleccione el Territorio"  name="SL_Territorio" id="SL_Territorio"></select>
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
						<div class="col-md-6"><input class="form-control btn btn-success" id="BT_Consultar_Atenciones_Territorio" type="submit" value="Consultar Atenciones Territorio"></div>
						<div class="col-md-3"></div>
                  </div>
						<br><br>
						<div id="div_Atenciones_Territorio" style="display: none;">
	           				<div class='col-xs-12 col-md-12' id="div_table_Atenciones_Territorio"></div>
			  			</div>
					</div>

					<div class="tab-pane" id="encuentros_grupales_entorno" role="tabpanel">
						<br>
	               <center><h2><font color="teal"><label>CONSOLIDADO ENCUENTROS GRUPALES POR ENTORNO</label> </font></h2></center>
						<br><br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes">Seleccionar el mes del reporte:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes" id="SL_Mes"></select>
							</div>
						</div>
						<br>
						<div id="div_Encuentros" style="display: none;">
							<div class='col-xs-12 col-md-12' id="div_table_Consolidado_Familiar"></div>

						</div>
					</div>

					<div class="tab-pane" id="encuentros_grupales_upz" role="tabpanel">
						<br>
	               <center><h2><font color="teal"><label>CONSOLIDADO ENCUENTROS GRUPALES POR UPZ</label> </font></h2></center>
						<br><br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes_Territorio">Seleccionar el mes del reporte:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes_Territorio" id="SL_Mes_Territorio"></select>
							</div>
						</div>
						<br>
						<div id="div_Encuentros_Territorio" style="display: none;">
							<br><br>
							<div class='col-xs-12 col-md-12' id="div_table_Consolidado_Upz"></div>

						</div>
					</div>

					<div class="tab-pane" id="laboratorios_intervenciones" role="tabpanel">
						<br>
	               <center><h2><font color="teal"><label>CONSOLIDADO LABORATORIOS</label> </font></h2></center>
						<br><br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes_Laboratorios">Seleccionar el mes del reporte:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes_Laboratorios" id="SL_Mes_Laboratorios"></select>
							</div>
						</div>
						<br>
						<div id="div_Laboratorios_Intervenciones" style="display: none;">
							<br><br>
							<div class='col-xs-12 col-md-12' id="div_table_Consolidado_Laboratorios"></div>

						</div>
					</div>

					<div class="tab-pane" id="metas_primera_infancia" role="tabpanel">
						<br>
								 <center><h2><font color="teal"><label>CONSOLIDADO METAS PRIMERA INFANCIA</label> </font></h2></center>
						<br><br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes_Laboratorios">Seleccionar el mes del reporte:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes_Meta" id="SL_Mes_Meta"></select>
							</div>
						</div>
						<br>
						<div id="div_Metas_Primera_Infancia" style="display: none;">
							<br><br>
							<div class='col-xs-12 col-md-12' id="div_table_Consolidado_Metas"></div>
						</div>
					</div>
				</div>
			</body>
</html>
