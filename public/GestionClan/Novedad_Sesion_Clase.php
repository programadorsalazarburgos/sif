<?php
	session_start();
	if(!isset($_SESSION["session_username"])) {
		header("location:../index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Novedad Sesion Clase</title>
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

    <link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 

    <link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>	
    
    <script type="text/javascript" src="Js/Novedad_Sesion_Clase.js?v=2019.10.07.001"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Novedades Sesiones Clase <small> Grupos</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<div class="alert alert-info">
							<b>Seleccione el Crea y grupo</b> para visualizar el historial de novedades que tiene el grupo ó registrar una nueva novedad.
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_crea">Crea:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<div class="input-group">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-tower"></span>
							</span>
							<select class="form-control selectpicker" data-live-search="true" id="SL_crea"></select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_grupo">Grupo:</label>
					</div>
					<div class="col-xs-12 col-md-9">
					<div class="input-group">
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-education"></span>
							</span>
							<select class="form-control selectpicker" data-live-search="true" id="SL_grupo"></select>
						</div>
					</div>
				</div>
				<ul class="nav nav-pills" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#registrar_novedad" id="registrar_novedad_tab" role="tab">Registrar Novedad</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#historial_novedades" id="historial_novedades_tab" role="tab">Historial/Opciones Novedades</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="registrar_novedad" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="alert alert-success">
									<b>Agregar nueva: </b> Diligenciando las siguientes opciones agregará una novedad al grupo.
								</div>
							</div>
						</div>
						<fieldset>
							<legend>Agregar novedad</legend>
							<div class="row">
								<div class="col-xs-6 col-md-2">
									<label for="SL_artista_formador">Artista Formador:</label>
								</div>
								<div class="col-xs-12 col-md-10">
									<div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-user"></span>
										</span>
										<select class="form-control selectpicker" data-live-search="true" id="SL_artista_formador"></select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-2">
									<label for="SL_novedad">Novedad</label>
								</div>
								<div class="col-xs-12 col-md-4">
									<div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-th-list"></span>
										</span>
										<select id="SL_novedad" class="form-control selectpicker">
										</select>
									</div>
								</div>

								<div class="col-col-xs-6 col-md-2">
									<label for="DA_fecha">Fecha</label>
								</div>
								<div class="col-xs-12 col-md-4">
									<div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<input type="text" id="DA_fecha" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-2">
									<label for="CH_asistencia">Asistencia formador:</label>
								</div>
								<div class="col-xs-12 col-md-4">
									<div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-ok"></span>
										</span>
										<input class="form-control" data-toggle="toggle" data-onstyle="primary" id= "CH_asistencia" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" checked >
									</div>
								</div>								
								<div class="col-xs-6 col-md-2">
									<label for="TX_observacion">Observación</label>
								</div>
								<div class="col-xs-12 col-md-4">
									<div class="input-group">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-font"></span>
										</span>
										<textarea placeholder="Observaciones" id="TX_observacion" class="form-control" cols="4"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
									<button class="btn btn-success form-control" id="BT_guardar_novedad">Guardar</button>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="tab-pane" id="historial_novedades" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="alert alert-warning">
									<b>Novedades registradas: </b> Aquí puede ver el historico de novedades que han sido registradas en el grupo.
								</div>
							</div>
						</div>
						<fieldset>
							<legend>Historial de novedades grupo: <b id="B_historial_nombre_grupo"></b></legend>
							<div class="row">
								<div class="table-responsive col-xs-12 col-md-12">
									<table class="table table-hover" id="table_novedades">
										<thead>
											<tr>
												<th>Fecha</th>
												<th>Formador</th>
												<th>Asistencia</th>
												<th>Novedad</th>
												<th>Observación</th>
												<th>Fecha en que se registró</th>
												<th>Opciones</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_editar_novedad" tabindex="-1" role="dialog" aria-labelledby="label_modal_editar_novedad" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="title_modal_editar_novedad"></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="CH_editar_novedad_asistencia">Asistencia:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								
								<input class="form-control" data-toggle="toggle" data-onstyle="primary" id= "CH_editar_novedad_asistencia" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" checked >
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_editar_novedad_novedad">Novedad:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" data-live-search="true" id="SL_editar_novedad_novedad">
									<option value="0">Ninguna</option>
									<option value="1">Taller Cancelado</option>
									<option value="2">Retraso o llegada tarde</option>
									<option value="3">Remplazo o suplencia</option>
									<option value="4">Incapacidad medica</option>
									<option value="5">Calamidad</option>
									<option value="6">Taller no finalizado</option>
									<option value="7">Salida artistica</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="TX_editar_novedad_observacion">Observación:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<textarea class="form-control" id="TX_editar_novedad_observacion" placeholder="Observaciones"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="row">
							<div class="col-xs-4 col-xs-offset-2 col-md-4 col-md-offset-2">
								<button class="btn btn-success form-control" id="BT_save_editar_novedad">Guardar</button>
							</div>
							<div class="col-xs-4 col-xs-offset-1 col-md-4 col-md-offset-1">
								<button class="btn btn-danger form-control" id="BT_save_eliminar_novedad">Eliminar esta novedad</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>