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
	<title>Reporte FAP</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Reporte_FAP.js?v=2018.1.0.5"></script>

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

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<script src="../../bower_components/pdfmake/build/pdfmake.js" type="text/javascript" ></script>
	<script src="../../bower_components/pdfmake/build/vfs_fonts.js" type="text/javascript" ></script>

	<link rel="stylesheet" type="text/css" href="../../css/Nidos.css">

</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Reporte - Fortalecimiento Artistico Pedagógico</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#registro_beneficiario" role="tab">Consolidado FAP por Mes</a></li>
					<li class="nav-item" ><a id="nav_fortalecimiento_localidad" class="nav-link" data-toggle="tab" href="#fortalecimiento_localidad" role="tab">Fortalecimientos por Localidad</a></li>
					<li class="nav-item" ><a id="nav_consultar_fortalecimiento" class="nav-link" data-toggle="tab" href="#consulta_atenciones" role="tab">Consultar Detalle Fortalecimientos</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="registro_beneficiario" role="tabpanel">
						<br>
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Total de Fortalecimientos por Mes</h4>
							</div>
						</div>
						<br>
						<br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes_Consolidado">Seleccione el Mes de Consulta:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarMes" data-live-search="true" name="SL_Mes_Consolidado" id="SL_Mes_Consolidado" title="Seleccione el Mes"></select>
							</div>
						</div>

						<div id="div_consolidado_fap_mes" style="display: none;">
							<h2><strong><center><font color="teal">CONSOLIDADO MENSUAL FORTALECIMINETOS</font></center></strong></h2>
							<br>
							<div class="table-responsive">
								<table id="table_consolidado_FAP" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="text-center">#</th>
											<th class="text-center">Fecha</th>
											<th class="text-center">Territorio Eaat</th>
											<th class="text-center">EAAT</th>
											<th class="text-center">Nombre FAP</th>
											<th class="text-center">Localidad del FAP</th>
											<th class="text-center">Upz</th>
											<th class="text-center">Barrio</th>
											<th class="text-center">Lugar</th>
											<th class="text-center"># Artistas</th>
											<th class="text-center">Consultar</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="fortalecimiento_localidad" role="tabpanel">

						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Fortalecimientos Artísticos Pedagógicos por Localidad</h4>
							</div>
						</div>
						<br><br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes_Localidad">Seleccione el Mes de Consulta:</label>
							<div class="col-md-4">
								<select class="form-control SeleccionarMes" data-live-search="true" name="SL_Mes_Localidad" id="SL_Mes_Localidad" title="Seleccione el Mes"></select>
							</div>
							<label class="col-md-2" for="SL_Localidad">Seleccione la Localidad:</label>
							<div class="col-md-4">
								<select class="form-control SeleccionarMes" data-live-search="true" name="SL_Localidad" id="SL_Localidad" title="Seleccione la localidad"></select>
							</div>
						</div>
						<br>
						<input class="form-control btn btn-primary" id="BT_Consultar_FAP_Localidad" type="submit" value="Consultar Fortalecimientos">



						<div id="div_fap_mes_localidad" style="display: none;">
							<h2><strong><center><font color="teal">CONSULTA DETALLADA POR ARTISTAS - FORTALECIMINETOS</font></center></strong></h2>
							<br>

							<div class="table-responsive">
								<table id="table_FAP_localidad" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="text-center">Identificación</th>
											<th class="text-center">Nombre Artista</th>
											<th class="text-center">Upz</th>
											<th class="text-center">Lugar</th>
											<th class="text-center">Nombre Fortalecimiento</th>
											<th class="text-center">Fecha</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="consulta_atenciones" role="tabpanel">

						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Fortalecimientos Artísticos Pedagógicos por Territorio</h4>
							</div>
						</div>
						<br>
						<br>
						<div class="row">
							<label class="col-md-2" for="SL_Mes_Detallado">Seleccione el Mes de Consulta:</label>
							<div class="col-md-4">
								<select class="form-control SeleccionarMes" data-live-search="true" name="SL_Mes_Detallado" id="SL_Mes_Detallado" title="Seleccione el Mes"></select>
							</div>
							<label class="col-md-2" for="SL_Territorio">Seleccione el Territorio:</label>
							<div class="col-md-4">
								<select class="form-control SeleccionarMes" data-live-search="true" name="SL_Territorio" id="SL_Territorio" title="Seleccione el Mes"></select>
							</div>
						</div>
						<br>
						<input class="form-control btn btn-primary" id="BT_Consultar_FAP" type="submit" value="Consultar Fortalecimientos">



						<div id="div_detallado_fap_mes" style="display: none;">
							<h2><strong><center><font color="teal">CONSULTA DETALLADA POR ARTISTAS - FORTALECIMINETOS</font></center></strong></h2>
							<br>

							<div class="table-responsive">
								<table id="table_detallado_FAP" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="text-center">Identificación</th>
											<th class="text-center">Nombre Artista</th>
											<th class="text-center">Localidad</th>
											<th class="text-center">Upz</th>
											<th class="text-center">Lugar</th>
											<th class="text-center">Nombre Fortalecimiento</th>
											<th class="text-center">Fecha</th>
										</tr>
									</thead>
									<tbody></tbody>
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
