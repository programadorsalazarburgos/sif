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
	<title>Administración Grupos NIDOS</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Administracion_Grupo.js?v=2021.06.04.9"></script>

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

	<script src="../../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>

</head>

<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de grupos Nidos</h1>
				</div>
			</div>
			<div class="panel-body">

				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#creacion_grupos_nidos" role="tab">Creación de Grupos</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_grupos_nidos" role="tab">Consulta de Grupos</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#modificacion_grupos_nidos" role="tab">Modificación de Grupos</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="creacion_grupos_nidos" role="tabpanel">
						<form id="form_nuevo_grupo_nidos">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Creación de Grupos</h4>
								</div>
							</div>
							<div class="row">
							<div class="info-grupo">
							</div>
							<div class="col-xs-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 bg-warning">
							<br>							
							<br>
							<fieldset>
								<legend class="text-center">Datos del grupo</legend>
								<div class="form-group">
									<label class="col-md-4" for="SL_EAtencion">Estrategia de atención:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" title="Seleccione una estrategia de atención" data-live-search="true" name="SL_EAtencion" id="SL_EAtencion"></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="SL_LAtencion">Lugar de atención:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" title="Seleccione un lugar de atención" data-live-search="true" name="SL_LAtencion" id="SL_LAtencion"></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="SL_Nivel">Nivel de escolaridad:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" multiple data-actions-box="true"  data-live-search="true" name="SL_nivel_escolaridad" id="SL_nivel_escolaridad" title="Selección múltiple"></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="TX_nombre">Nombre o código del grupo:</label>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="Nombre del Grupo" id="TX_Nombre_Grupo" name="TX_Nombre_Grupo">
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="SL_Tipo_Grupo">Tipo de grupo:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" title="Seleccione el tipo de grupo" data-live-search="true" name="SL_Tipo_Grupo" id="SL_Tipo_Grupo"></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>								
								<div class="form-group">
									<label class="col-md-4" for="TX_Nombre_Responsable">Maestro(a) o responsable del grupo:</label>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="Responsable del Grupo" id="TX_Nombre_Responsable" name="TX_Nombre_Responsable">
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
										<input class="form-control btn btn-primary" type="submit" value="Guardar Grupo" />
									</div>
								</div>
							</fieldset>
							</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="consulta_grupos_nidos" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>Consulta de Grupos</h4>
							</div>
						</div>
						<div class="info-grupo"></div>
						<div class="row"></div>
						<br>
						<fielset>
							<legend>Listado de grupos</legend>
							<div class="row">
								<div class='col-xs-12 col-md-12'>
									<table id="table_grupos_nidos" class="table table-striped table-bordered table-hover" width="100%">
										<thead>
											<tr>
												<td class="text-center"><strong>Estrategia de atención</strong></td>
												<td class="text-center"><strong>Lugar de atención</strong></td>
												<td class="text-center"><strong>Nombre del grupo</strong></td>
												<td class="text-center"><strong>Tipo de Grupo</strong></td>
												<td class="text-center"><strong>Nivel de Escolaridad</strong></td>
												<td class="text-center"><strong>Maestro(a) o responsable del grupo</strong></td>
												<td class="text-center"><strong>Acciones</strong></td>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
							</fieldset>

					</div>
					<div class="tab-pane" id="modificacion_grupos_nidos" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>Modificación de Grupos</h4>
							</div>
						</div>
						<div class="info-grupo">
						</div>
						<div class="row">
						</div>
						<div class="row">
							<br>
							<label class="col-md-3" for="SL_Lugar_Atencion">Seleccione lugar de atención y grupo:</label>
							<div class="col-md-9">
								<select class="form-control selectpicker" data-live-search="true" name="SL_Lugar_Atencion" id="SL_Lugar_Atencion" title="Seleccione un lugar de atención"></select>
							</div>
							<br>
						</div>
						<div id="div_modificar_grupo_nidos">
							<form id="form_modificar_grupo_nidos">
								<fieldset>
									<br>
									<legend>Datos del grupo</legend>
									<div class="form-group">
										<label class="col-md-3" for="SL_EAtencion_Modificar">Estrategia de atención:</label>
										<div class="col-md-9">
											<select class="form-control selectpicker" data-live-search="true" name="SL_EAtencion_Modificar" id="SL_EAtencion_Modificar"></select>
											<span class="help-block" id="error"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3" for="SL_LAtencion_Modificar">Lugar de atención:</label>
										<div class="col-md-9">
											<select class="form-control selectpicker" data-live-search="true" name="SL_LAtencion_Modificar" id="SL_LAtencion_Modificar"></select>
											<span class="help-block" id="error"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3" for="TX_Nombre_Grupo_Modificar">Nombre o código del grupo:</label>
										<div class="col-md-9">
											<input type="text" class="form-control" placeholder="Nombre del Grupo" id="TX_Nombre_Grupo_Modificar" name="TX_Nombre_Grupo_Modificar">
											<span class="help-block" id="error"></span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3" for="SL_Tipo_Grupo_Modificar">Tipo de grupo:</label>
										<div class="col-md-9">
											<select class="form-control selectpicker" title="Seleccione el tipo de grupo" data-live-search="true" name="SL_Tipo_Grupo_Modificar" id="SL_Tipo_Grupo_Modificar"></select>
											<span class="help-block" id="error"></span>
										</div>
									</div>
									<div class="form-group">
									<label class="col-md-3" for="SL_Nivel_Modificar">Nivel de escolaridad:</label>
									<div class="col-md-9">
										<select class="form-control selectpicker" title="Seleccione el nivel de escolaridad" data-live-search="true" name="SL_nivel_escolaridad_Modificar" id="SL_nivel_escolaridad_Modificar"></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
									<div class="form-group">
										<label class="col-md-3" for="TX_Nombre_Responsable_Modificar">Maestro(a) o responsable del grupo:</label>
										<div class="col-md-9">
											<input type="text" class="form-control" placeholder="Responsable del Grupo" id="TX_Nombre_Responsable_Modificar" name="TX_Nombre_Responsable_Modificar">
											<span class="help-block" id="error"></span>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
											<input class="form-control btn btn-primary" type="submit" value="Modificar grupo" />
										</div>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modalInactivacion" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">INACTIVACIÓN DE GRUPO</h4>
				</div>
				<div class="modal-body">
					<span>¿Esta seguro que desea inactivar el grupo <strong><label id="nombreGrupoI"><label></strong>?</span>
					<input id="idGrupoI" hidden="hidden" value="">
				</div>
				<div class="modal-footer">
					<button type="button" class="confirmar-inactivacion btn btn-success">INACTIVAR</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modalActivacion" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">ACTIVACIÓN DE GRUPO</h4>
				</div>
				<div class="modal-body">
					<span>¿Esta seguro que desea activar nuevamente el grupo <strong><label id="nombreGrupoA"><label></strong>?</span>
					<input id="idGrupoA" hidden="hidden" value="">
				</div>
				<div class="modal-footer text-center">
					<button type="button" class="confirmar-activacion btn btn-success">ACTIVAR</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
</body>

</html>