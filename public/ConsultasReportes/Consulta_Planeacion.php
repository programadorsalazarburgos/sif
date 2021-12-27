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
	<title>Consultar Grupos</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">
	<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.colVis.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>
	<link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="Js/Consulta_Planeacion.js?v=2021.04.30.0"></script>
</head>
<style type="text/css">
.nav-pills > .active > a, .nav-pills > .active > a:hover {
	background-color: #009f99 !important;
	color: white !important;
}
.nav-pills > li > a{
	color: #009f99 !important;
}
</style>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consulta de Planeacion<small> CREA</small></h1>
				</div>
				<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
			</div>
			<div class="panel-body">
				<div class="row">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#div_generar_reporte" role="tab" id="li_generar_reporte">Generar reporte</a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#div_historico_planeacion" role="tab" id="li_historico_planeacion">Histórico</a></li>
					</ul>
				</div>
				<div class="tab-content">
					<div class="tab-pane active" id="div_generar_reporte" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 alert alert-warning">
								<p>
									<center>En el excel descargado encontrará el acumulado de niños únicos atendidos por el programa CREA en el periodo que seleccione.</center>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-2 col-md-offset-5">
								<select id="SL_YEAR" name="SL_YEAR" class="form-control selectpicker show-menu-arrow" title="SELECCIONE EL AÑO" data-style="btn-success">
								</select>
							</div>
						</div>
						<div class="row">
							<br>
							<div class="col-xs-12 col-md-12">
								<div class="col-xs-12 col-md-1 col-md-offset-5">
									<select id="SL_MES_INICIAL" name="SL_MES_INICIAL" class="form-control selectpicker show-menu-arrow" title="MES INICIAL" data-style="btn-success">
									</select>
								</div>
								<div class="col-xs-12 col-md-1">
									<select id="SL_DIA_INICIAL" name="SL_DIA_INICIAL" class="form-control selectpicker show-menu-arrow" title="DÍA INICIAL" data-style="btn-success">
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<br>
							<div class="col-xs-12 col-md-12">
								<div class="col-xs-12 col-md-1 col-md-offset-5">
									<select id="SL_MES_FINAL" name="SL_MES_FINAL" class="form-control selectpicker show-menu-arrow" title="MES FINAL" data-style="btn-success">
									</select>
								</div>
								<div class="col-xs-12 col-md-1">
									<select id="SL_DIA_FINAL" name="SL_DIA_FINAL" class="form-control selectpicker show-menu-arrow" title="DÍA FINAL" data-style="btn-success">
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<br>
							<div class="col-xs-12 col-md-2 col-md-offset-5">
								<select id="SL_ASISTENCIAS" name="SL_ASISTENCIAS" class="form-control selectpicker show-menu-arrow" title="CANTIDAD ASISTENCIAS" data-style="btn-success">
									<option value="1" selected>1+ ASISTENCIAS</option>
									<option value="2">2+ ASISTENCIAS</option>
									<option value="3">3+ ASISTENCIAS</option>
									<option value="4">4+ ASISTENCIAS</option>
									<option value="5">5+ ASISTENCIAS</option>
									<option value="6">6+ ASISTENCIAS</option>
									<option value="7">7+ ASISTENCIAS</option>
									<option value="8">8+ ASISTENCIAS</option>
									<option value="9">9+ ASISTENCIAS</option>
									<option value="10">10+ ASISTENCIAS</option>
								</select>
							</div>
						</div>
						<div class="row">
							<br>
							<div class="col-xs-12 col-md-2 col-md-offset-5">
								<select id="SL_LINEA_ATENCION" name="SL_LINEA_ATENCION" class="form-control selectpicker show-menu-arrow" title="SELECCIONE LA LÍNEA DE ATENCIÓN" data-style="btn-success">
									<option value="AE" selected>ARTE EN LA ESCUELA</option>
									<option value="IC">IMPULSO COLECTIVO</option>
									<option value="CV">CONVERGE</option>
								</select>
							</div>
						</div>
						<div class="row">
							<br>
							<div class="col-xs-12 col-md-12 text-center">
								<a href="" id="DOWNLOAD_PLANEACION" download><img src="../imagenes/excelicon.png" height="120"></a>
								<a id="download_file" name="download_file" href="" hidden download></a>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="div_historico_planeacion" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<table id="table_historico_planeacion" style="width: 100%" class="table table-hover">
										<thead>
											<tr>
												<th class="text-center"><strong>AÑO</strong></th>
												<th class="text-center"><strong>PERIODO</strong></th>
												<th class="text-center"><strong>LÍNEA DE ATENCIÓN</strong></th>
												<th class="text-center"><strong>FECHA DE GENERACIÓN</strong></th>
												<th class="text-center"><strong>OPCIONES</strong></th>
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
	</div>	
</body>
<div class="modal fade" id="modal_enviando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<img src="../imagenes/enviando.gif" width="100%">      
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</html>