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
	<title>Administración de territorios</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Asignar_Persona_Territorio.js?v=1.7.1.1"></script>

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
	<script src="../../bower_components/jszip/dist/jszip.min.js"  type="text/javascript" ></script>
	<script src="../../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Administración de territorios</h1>
			</div>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#asignacion_territorio" role="tab">Asignación de territorio</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_asignacion_territorios" role="tab">Consulta de asignación</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="asignacion_territorio" role="tabpanel">
						<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>Asignación de territorio por usuario</h4>
						</div>
					</div>
							<br>
							<div class="form-group">
								<label class="col-md-3">Seleccione un usuario:</label>
								<div class="col-md-6">
									<select class="form-control selectpicker" title="Seleccione una opción" data-live-search="true" name="SL_Buscar_Usuario" id="SL_Buscar_Usuario"></select>
								</div>
              </div>
							<br>
							<br>
							<div id="div_informacion_usuario" style="display: none;">
								<fieldset>
									<legend>Datos del usuario</legend>
										<div class="form-group">
											<label class="col-md-3">Identificación:</label>
											<div class="col-md-9">
												<span id="SP_identificacion_usuario" for="SP_identificacion_usuario"></span>
											</div>
										</div>
										<br>
										<div class="form-group">
											<label class="col-md-3">Nombre:</label>
											<div class="col-md-9">
												<span id="SP_nombre_usuario" for="SP_nombre_usuario"></span>
											</div>
										</div>
										<br>
										<div class="form-group">
											<label class="col-md-3">Territorio actual:</label>
											<div class="col-md-9">
												<span id="SP_territorio_actual_usuario" for="SP_territorio_actual_usuario"></span>
											</div>
										</div>
										<br>
										<div class="form-group">
											<label class="col-md-3">Lista de territorios:</label>
											<div class="col-md-6">
												<select class="form-control selectpicker" id="SL_territorios" title="Selccione un territorio" name="SL_territorios"></select>
											</div>
										</div>
										<br>
										<br>
										<div class="form-group">
											<div class="col-md-4 col-md-offset-4"><input type="button" class="form-control btn btn-primary" id="BTN_asignar_territorio"></div>
										</div>
								</fieldset>
							</div>
							<div class="modal fade" id="modal_asignar_territorio" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Confirmación</h4>
										</div>
										<div class="modal-body">
											<span>¿Esta seguro que desea asignar el territorio <label id="nombre_territorio"></label> a <label id="nombre_usuario"></label>?</span>
												<input id="idGrupo" type="hidden" value="">
										</div>
										<div class="modal-footer">
											<button type="button" class="confirmar_asignacion_territorio btn btn-success">Si</button>
											<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
										</div>
									</div>
								</div>
							</div>
				</div>
				<div class="tab-pane" id="consulta_asignacion_territorios" role="tabpanel">
					<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>Consulta de usuarios por territorio</h4>
						</div>
					</div>
					<br>
					<div class="form-group">
						<div class="bg-warning col-xs-12 col-md-12">
							<p><strong>Recuerde que:</strong>
								<ul>
									<li>Puede consultar uno o más territorios seleccionandolos de la lista.</li>
									<li>Puede ordenar los datos utilizando los títulos de la tabla.</li>
									<li>Puede filtrar los datos utilizando el campo de búsqueda.</li>
								</ul>
							</p>
						</div>
					</div>
					<br>
					<br>
					<br>
					<br>
					<br>
						<div class="form-group">
							<label class="col-md-3">Seleccione un territorio:</label>
						<div class="col-md-6">
							<select class="form-control selectpicker" multiple data-actions-box="true" selectAllText='Seleccionar todos' deselectAllText="Quitar Todos" id="SL_territorios_consulta" title="Seleccione una opción" data-live-search="true" name="SL_territorios_consulta"></select>
						</div>
					</div>
					<br>
					<br>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3"><input type="button" class="form-control btn btn-primary" id="BTN_consultar_territorio" value="Consultar"></div>
					</div>
					<br>
					<br>
					<div id="div_usuarios_territorio" style="display: none;">
					<fieldset>
					<table id="tabla_usuarios_territorio" class="table table-striped table-bordered table-hover" width="100%">
						<thead>
								<tr>
									<td class="text-center"><strong>Territorio</strong></td>
									<td class="text-center"><strong>Identificación</strong></td>
									<td class="text-center"><strong>Nombre</strong></td>
									<td class="text-center"><strong>Tipo persona</strong></td>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>
