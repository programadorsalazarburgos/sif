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
	<title>consulta Beneficiarios por Experiencia</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <script type="text/javascript" src="Js/Reporte_Beneficiario_Artista.js?v=2018.1.0.1"></script>

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
				<h1>Consulta de Asistencia por Experiencia</h1>
			</div>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#consulta_asistencia" role="tab">Consulta de Asistencia</a></li>
				<li class="nav-item" ><a id="nav_Consolidado_Mensual" class="nav-link" data-toggle="tab" href="#reporte_mensual" role="tab">Consolidado Mensual</a></li>
				</ul>
			<div class="tab-content">

				<div class="tab-pane active" id="consulta_asistencia" role="tabpanel">
					<?php echo "<input type='hidden' id='id_usuario' name='id_usuario' value='".$Id_Persona."'" ?>
					<br>
					<h2><strong><center><font color="teal">EXPERIENCIAS REGISTRADAS POR GRUPO</font></center></strong></h2>
					<br>
					<div class="row">
						<label class="col-md-2" for="SL_Lugar_Atencion">Seleccione un lugar de atención:</label>
						<div class="col-md-10">
							<select class="form-control selectpicker" data-live-search="true" name="SL_Lugar_Atencion" id="SL_Lugar_Atencion" title="Seleccione un lugar de atención"></select>
						</div>
						<br><br>
					</div>
				   <br>
   				<div id="div_asistencia_experiencia" style="display: none;">

					<div class="table-responsive">
						<table id="table_asistencia_experiencia" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Nombre de la atención</th>
									<th class="text-center">Fecha</th>
									<th class="text-center">Hora</th>
									<th class="text-center">Total de 1er Mes a 3 años</th>
									<th class="text-center">Total de 4 a 6 años</th>
									<th class="text-center">Total Madres Gestantes</th>
									<th class="text-center">Total Asistentes</th>
									<th class="text-center">Consultar</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
      </div>
		</div>

			<div class="tab-pane" id="reporte_mensual" role="tabpanel">

				<h2><strong><center><font color="teal">EXPERIENCIAS REGISTRADAS POR MES</font></center></strong></h2>
				<br>
				<div class="row">
					<label class="col-md-2" for="SL_Mes">Seleccione el Mes:</label>
						<div class="col-md-10">
							<select class="form-control SeleccionarGrupo" data-live-search="true" name="SL_Mes" id="SL_Mes"></select>
						</div>
				</div>
				<input type="hidden" class="form-control" placeholder="Id Dupla" id="SP_IdDupla" name="SP_IdDupla">
				<br>

				<div id="div_reporte_mensual_Dupla" style="display: none;">
    			<br>
					<table class="table" style="width:100%" id="tabla_encabezado">
						<thead>
							<tr>
								<th style="width:15%">Tipo de Dupla</th>
								<th style="width:17%">Código de Dupla</th>
								<th style="width:17%">Artistas</th>
								<th style="width:17%">Territorio</th>
								<th style="width:17%">Gestor Territorial</th>
								<th style="width:17%">EAAT</th>
							</tr>
						</thead>
						<tr>
							<td><strong><span id="SP_TipoDupla"></span></strong></td>
							<td><strong><span id="SP_CodigoDupla"></span></strong></td>
							<td><strong><span id="SP_Artistas"></span></strong></td>
							<td><strong><span id="SP_Territorio"></span></strong></td>
							<td><strong><span id="SP_Gestor"></span></strong></td>
							<td><strong><span id="SP_Eaat"></span></strong></td>
						</tr>
					</table>
<center> <a href="#" id="Generar_Reporte" class="Consultar-Experiencia btn btn-success">GENERAR REPORTE MENSUAL</a></center>
				<div class="table-responsive">
					<table id="table_consolidado_Mensual" class="table table-striped table-bordered table-hover" width="100%">
						<thead>
							<tr>
								<th class="text-center">Lugar de Atención</th>
								<th class="text-center">Nivel</th>
								<th class="text-center">Entidad</th>
								<th class="text-center">Tipo Lugar</th>
								<th class="text-center"># Atenciones</th>
								<th class="text-center">Beneficiarios Nuevos</th>
								<th class="text-center">Total de 1er Mes a 3 años</th>
								<th class="text-center">Total de 4 a 6 años</th>
								<th class="text-center">Total Madres Gestantes</th>
								<th class="text-center">Total Asistentes</th>
						</tr>
						</thead>
						<tbody></tbody>
						<tr>
							<td class="text-center" style="background-color: #D5D8DC" colspan="4"> TOTALES DEL MES</td>
							<td class="text-center" style="background-color: #D5D8DC"><strong><span id="SP_Experiencia"></span></strong></td>
							<td class="text-center" style="background-color: #D5D8DC"><strong><span id="SP_TotalesNuevos"></span></strong></td>
							<td class="text-center" style="background-color: #D5D8DC"><strong><span id="SP_Total0a3"></span></strong></td>
							<td class="text-center" style="background-color: #D5D8DC"><strong><span id="SP_Total4a6"></span></strong></td>
							<td class="text-center" style="background-color: #D5D8DC"><strong><span id="SP_TotalGestantes"></span></strong></td>
							<td class="text-center" style="background-color: #D5D8DC"><strong><span id="SP_Totales"></span></strong></td>
						</tr>
					</table>
				</div>
			</div>


	   </div>




	</div>
</body>
</html>
