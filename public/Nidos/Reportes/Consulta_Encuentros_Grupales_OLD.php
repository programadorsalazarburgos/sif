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

	<script type="text/javascript" src="Js/Consulta_Encuentros_Grupales.js?v=2018.1.0.2"></script>

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
					<h1>CONSOLIDADOS DE ATENCIONES POR MES</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#consulta_experiencias" role="tab">1. Atenciones por Dupla</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#consolidado_territorio" role="tab">2. Encuentros Grupales por Entorno</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#consolidado_Upz" role="tab">3. Encuentros Grupales por UPZ</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#consolidado_laboratorios" role="tab">4. Laboratorios</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#consolidado_atencion_dupla" role="tab">5. Consolidado Atención por Territorio</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#beneficiarios_atendidos" role="tab">6. Beneficiarios Atendidos</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="consulta_experiencias" role="tabpanel">
						<?php echo "<input type='hidden' id='id_usuario' name='id_usuario' value='".$Id_Persona."'" ?>
						<br><br>
	        <center><h1><font color="teal"><label>EXPERIENCIAS REALIZADAS POR DUPLA</label> </font></h1></center>
						<br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes">Seleccionar el mes del reporte:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes" id="SL_Mes"></select>
							</div>
						</div>
						<br>
						<div id="div_Encuentros" style="display: none;">
							<div class="panel-group" id="acordion_duplas"></div>
						</div>
					</div>

					<div class="tab-pane" id="consolidado_territorio" role="tabpanel">
						<br>
	        <center><h1><font color="teal"><label>ENCUENTROS GRUPALES POR ENTORNO</label> </font></h1></center>
						<br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes_Territorio">Seleccionar el mes del reporte:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes_Territorio" id="SL_Mes_Territorio"></select>
							</div>
						</div>
						<br>
						<div id="div_Encuentros_Territorio" style="display: none;">
							<br><br>
							<div class='col-xs-12 col-md-12' id="div_table_Consolidado_Familiar"></div>
							</div>
					</div>
					<div class="tab-pane" id="consolidado_Upz" role="tabpanel">
						<br>
	        <center><h1><font color="teal"><label>ENCUENTROS GRUPALES POR UPZ (NUEVOS)</label> </font></h1></center>
						<br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes_TerritorioUpz">Seleccionar el mes del reporte:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes_TerritorioUpz" id="SL_Mes_TerritorioUpz"></select>
							</div>
						</div>
						<br>
						<div id="div_Encuentros_TerritorioUpz" style="display: none;">
							<br><br>
							<div class='col-xs-12 col-md-12' id="div_table_Consolidado_Upz"></div>
						</div>
					</div>

					<div class="tab-pane" id="consolidado_laboratorios" role="tabpanel">
					<br>
	         		<center><h1><font color="teal"><label> LABORATORIOS (NUEVOS)</label> </font></h1></center>
					<br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes_Territorio">Seleccionar el mes del reporte:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes_Laboratorio" id="SL_Mes_Laboratorio"></select>
							</div>
						</div>
						<br>
						<div id="div_Laboratorios_Territorio" style="display: none;">
							<br><br>
						  <div class='col-xs-12 col-md-12' id="div_table_consolidado_laboratorios"></div>
						</div>
					</div>

					<div class="tab-pane" id="consolidado_atencion_dupla" role="tabpanel">
					<br>
	         		<center><h1><font color="teal"><label>CONSOLIDADO ATENCIÓN REAL POR TERRITORIO </label> </font></h1></center>
					<br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes_Real_Dupla">Seleccionar el mes del reporte:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes_Real_Dupla" id="SL_Mes_Real_Dupla"></select>
							</div>
						</div>
						<br>
						<div id="div_Atencion_Real_Territorio" style="display: none;">
							<br><br>
						  <div class='col-xs-12 col-md-12' id="div_table_consolidado_atencion_dupla"></div>
						</div>
					</div>

					<div class="tab-pane" id="beneficiarios_atendidos" role="tabpanel">
					<br>
	         		<center><h1><font color="teal"><label>LISTADO DE BENEFICIARIOS ATENDIDOS</label> </font></h1></center>
					<br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes_Real_Dupla">Seleccionar el mes del reporte:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarMes" data-live-search="true" title="Seleccione el Mes"  name="SL_Mes_Beneficiario" id="SL_Mes_Beneficiario"></select>
							</div>
						</div>
						<br>
						<div id="div_Beneficiarios_Atendidos" style="display: none;">
							<br><br>
						  <div class='col-xs-12 col-md-12' id="div_table_beneficiarios_atendidos"></div>
						</div>
					</div>
				</div>
			</body>
</html>
