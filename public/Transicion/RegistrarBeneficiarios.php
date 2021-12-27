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
	<title>Crear Grupo</title>
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

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

    <script type="text/javascript" src="Js/RegistrarBeneficiarios.js?v=2020.3.10"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Asignación de beneficiarios<small> GRUPOS TRANSICIÓN</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#panel_asignacion_beneficiarios" role="tab">Asignación de beneficiarios</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="panel_asignacion_beneficiarios" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>Asignación de beneficiarios</h4>
							</div>
						</div>
					</div>
					<legend>Grupos de transición</legend>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<div class="table-responsive col-xs-12 col-md-12">
								<table class="table" id="table_grupos">
									<thead>
										<tr>
											<th>N°</th>
											<th>Artista CREA</th>
											<th>Artista NIDOS</th>
											<th>Lugar Atención</th>
											<th>Horario</th>
											<th>Estudiantes en grupo</th>
											<th>Opciones</th>
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
	<div class="modal fade" id="modal_agregar_estudiante_grupo" tabindex="-1" role="dialog" aria-labelledby="label_modal_agregar_estudiante_grupo" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="title_modal_agregar_estudiante"></h4>
				</div>
				<div class="modal-body">
					<div row'>
						<div id="div_mensaje" class='col-xs-12 col-md-12 col-lg-12 col-sm-12'>
							<p class="alert alert-info">
								<span id="p_mensaje">Escriba el <i><u>número de documento</u></i> ó el nombre del beneficiario (<i><u>Por lo menos Primer Apellido</u></i>). Para agilizar la consulta suministre el <b>nombre completo</b> del beneficiario.</span>
								<input data-toggle="toggle" data-onstyle="success" id="CH_tipo_consulta_estudiante" name= "CH_tipo_consulta_estudiante" data-offstyle="info" data-width="200" data-on="NOMBRES" data-off="NÚMERO DOCUMENTO" type="checkbox">
							</p>
						</div>
					</div>
					<div class='row'>
						<form action="" method="post" name="form_buscar_estudiante" id="form_buscar_estudiante" class="form_buscar_estudiante" enctype="multipart/form-data">													
							<div id="div_campo_busqueda_documento">
								<div class='col-xs-12 col-md-10 col-md-offset-1'>
									<div class="form-group col-xs-12">
										<div class='input-group'>
											<span class='input-group-addon' id='basic-addon_buscar_esutudiante'><span class='fa fa-user' aria-hidden='true'></span></span>
											<input class='form-control' aria-describedby='basic-addon1' placeholder='Número de Identificación' name='nro_documento' id="nro_documento" type='text'>
										</div>
									</div>
								</div>
							</div>
							<div id="div_campo_busqueda_nombres">
								<div class="col-xs-12 col-md-10 col-md-offset-1">
									<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
										<div class="input-group">
											<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
											<input class="mayuscula tecleable form-control" tabindex="1" placeholder="Primer Apellido" name="apellido1" id="apellido1" type="text"  />
										</div>
									</div>
									<div class="form-group col-xs-12 col-sm-12 col-md-6  col-lg-6">
										<div class="input-group">
											<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
											<input class="mayuscula tecleable form-control" tabindex="1" placeholder="Segundo Apellido" name="apellido2" id="apellido2"  type="text"/>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-md-10 col-md-offset-1">
									<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
										<div class="input-group">
											<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
											<input class="mayuscula tecleable form-control" tabindex="3" placeholder="Primer Nombre" name="nombre1" id="nombre1" type="text"  />
										</div>
									</div>
									<div class="form-group col-xs-12 col-sm-12 col-md-6  col-lg-6">
										<div class="input-group">
											<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
											<input class="mayuscula tecleable form-control" tabindex="4" placeholder="Segundo Nombre" name="nombre2" id="nombre2"  type="text"/>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-md-10 col-md-offset-1">
								<div class="form-group col-xs-12">
									<!--<input type="hidden" name="_METHOD" value="POST" />-->
									<button type="submit" id="BT_buscar_estudiante"  class="btn btn-success col-xs-12">Buscar</button>
								</div>
							</div>
						</form>
					</div>
					<div id="resultado_busqueda_estudiantes">
						<div class='row'>
							<div class='col-xs-12 col-md-12'>
								<div class="table-responsive text-center" id="datos_estudiante">
									<table width="100%" style="width: 100%" class='table table-striped table-bordered table-hover' id='table_resultado_busqueda'>
										<thead>
											<tr>
												<td><strong>Identificación</strong></td>
												<td><strong>Nombre</strong></td>
												<td><strong>Grado</strong></td>
												<td><strong>Colegio</strong></td>
												<td><strong>Opciones</strong></td>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="datos_detallados_estudiante">
						<legend>Datos del Estudiante</legend>
						<div class='row'>
							<div class='col-xs-6 col-md-3'>
								<label for="label_nombre_estudiante">Nombre</label>
							</div>
							<div class='col-xs-6 col-md-9'>
								<b>
									<input class='form-control' type='text' disabled='disabled' id='label_nombre_estudiante' name='label_nombre_estudiante' />
								</b>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="TX_observaciones_asignacion_estudiante">Observaciones:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<textarea class="form-control" id="TX_observaciones_asignacion_estudiante" placeholder="Observaciones"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4"><button id='BT_asignar_estudiante_grupo' class='form-control btn-success'>Asignar Estudiante</button></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
</body>