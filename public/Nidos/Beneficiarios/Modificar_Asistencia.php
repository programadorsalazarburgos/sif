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
	<title>Modificar Experiencia</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="Js/Registro_AsistenciaNidos.js?v=2020.11.06.01"></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<link href="../../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<link href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

	<link href="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.js" type="text/javascript"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<script src="../../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>

	<link rel="stylesheet" type="text/css" href="../../css/Nidos.css">

</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Modificar experiencia</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" id="li-modificar-asistencia"><a class="nav-link" data-toggle="tab" href="#modificar-asistencia" role="tab">Modificar experiencia</a></li>
					<li class="nav-item" id="li-eliminar-experiencia"><a class="nav-link" data-toggle="tab" href="#eliminar-experiencia" role="tab">Eliminar experiencia</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="modificar-asistencia" role="tabpanel">
						<br>
						<div class="row" id="div-duplas" style="display: none;">
							<div class="form-group">
								<label class="col-md-2" for="SL_Duplas">Seleccione la Dupla:</label>
								<div class="col-md-10">
									<select class="form-control" data-live-search="true" name="SL_Duplas" id="SL_Duplas" title="Seleccione una dupla"></select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-md-2" for="SL_Grupos">Seleccione Grupo:</label>
								<div class="col-md-10">
									<select class="form-control" data-live-search="true" name="SL_Grupos" id="SL_Grupos" title="Seleccione un grupo"></select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="col-md-2" for="SL_Atenciones">Seleccione Atención:</label>
								<div class="col-md-10">
									<select class="form-control" data-live-search="true" name="SL_Atenciones" id="SL_Atenciones" title="Seleccione una atención"></select>
								</div>
							</div>
						</div>
						<br>
						<div id="div-experiencia" style="display: none;">
							<div class="row">
								<div class="col-xs-12 col-md-12 bg-warning">
									<p><strong>Tenga en cuenta que:</strong></p>
									<ol>
										<li>En el listado aparecerá la <strong>edad y el rango de edad que quedó almacenado</strong> en el momento de guardar la asistencia.</li>
										<li>Los beneficiarios que aparezcan en color <strong>amarillo</strong> indicarán que no tienen registro de asistencia para la fecha seleccionada.</li>
										<li>Para modificar la asistencia de un beneficiario haga clic en el botón correspondiente de la columna asistencia, para guardar los cambios haga clic en el botón <strong>Modificar asistencia</strong> que encontrará al final de la página.</li>
									</ol>
								</div>
							</div>
							<br>
							<form id="form-modificar-asistencia">
								<div class="table-responsive" id="tabla_encabezado">
									<table class="table" style="width:100%" id="tabla_encabezado">
										<thead>
											<tr>
												<th colspan="2">Fecha del Encuentro</th>
												<th>Código de Dupla</th>
												<th>Artistas de la experiencia</th>
												<th>Tipo de Lugar</th>
												<th>Tipo de Estrategia</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="2"><span id="SP_Fecha"></span></td>
												<td><span id="SP_Codigo_Dupla"></span></td>
												<td>
													<span id="SP_Artista"></span>
													<a href="#" id="undo" style="color: red; text-decoration: none; display: none;">
														<i class="fa fa-undo"></i>
													</a><br>
													<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Invitado" data-toggle="modal" data-target="#modal_artistas">Invitado</button>
													<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Cambio" data-toggle="modal" data-target="#modal_artistas">Reemplazo</button>
													<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Suplencia" data-toggle="modal" data-target="#modal_artistas">Suplencia</button>
												</td>
												<td><span id="SP_Lugar"></span></td>
												<td><span id="SP_Estrategia"></span></td>
											</tr>
										</tbody>
										<thead>
											<tr>
												<td style="background: #D3E5EE"><strong>Hora inicio</strong></td>
												<td style="background: #D3E5EE"><strong>Hora Fin</strong></td>
												<th>Nombre de la Experiencia</th>
												<th>Gestor Territorial</th>
												<th>EAAT</th>
												<th>Profesional Responsable</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<input type="text" required="required" class="form-control input-sm" id="TX_Hora_Inicio_Mod" name="TX_Hora_Inicio" readonly="readonly" placeholder="Hora de inicio">
												</td>
												<td>
													<input type="text" required="required" class="form-control input-sm" id="TX_Hora_Fin_Mod" name="TX_Hora_Finalizacion" readonly="readonly" placeholder="Hora de finalización">
												</td>
												<td>
													<input type="text" class="form-control mayuscula input-sm" id="TX_Nom_Exp_Mod" name="TX_Nom_Exp_Mod" placeholder="Nombre Experiencia" required="required">
												</td>
												<td><span id="SP_Gestor"></span></td>
												<td><span id="SP_Eaat"></span></td>
												<td><span id="SP_Responsable"></span></td>
											</tr>
										</tbody>
										<thead>
											<tr>
												<th colspan="2">Nombre Grupo</th>
												<th>Localidad</th>
												<th>Upz</th>
												<th>Lugar</th>
												<th># de Adultos Cuidadores</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="2"><span id="SP_Grupo"></span>/</td>
												<td><span id="SP_Localidad"></span></td>
												<td><span id="SP_Upz"></span></td>
												<td><span id="SP_Direccion"></span></td>
												<td><input type="text" class="form-control input-sm numbers" id="TX_Cuidadores_Mod" name="TX_Cuidadores_Mod" placeholder="Número de cuidadores" required="required" maxlength="2"></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="table-responsive">
									<div class="row">
										<div class="col-xs-12 col-md-12 text-center bg-info">
											<h4>Listado de Asistencia Beneficiarios</h4>
										</div>
									</div>
									<br>
									<table id="tabla-beneficiarios-modificar-asistencia" class="table table-striped table-bordered table-hover" width="100%">
										<thead>
											<tr>
												<th class="text-center">Identificación</th>
												<th class="text-center">Nombre Beneficiario</th>
												<th class="text-center">Género</th>
												<th class="text-center">Enfoque</th>
												<th class="text-center">Edad</th>
												<th class="text-center">Rango de edad</th>
												<th class="text-center">Asistencia</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
								<div class="row">
									<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
										<input class="form-control btn btn-primary" id="BT_modificar_asistencia" type="submit" value="Modificar Asistencia">
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="tab-pane" id="eliminar-experiencia" role="tabpanel">
						<br>
						<form>
							<div class="col-lg-offset-3 col-lg-6">
								<label for="SL_Duplas_Eli">Seleccione la Dupla:</label>
								<div class="form-group">
									<select class="form-control" data-live-search="true" name="SL_Duplas_Eli" id="SL_Duplas_Eli" title="Seleccione una dupla"></select>
								</div>
							</div>
							<div class="col-lg-offset-3 col-lg-6">
								<label for="SL_Grupos_Eli">Seleccione Grupo:</label>
								<div class="form-group">
									<select class="form-control" data-live-search="true" name="SL_Grupos_Eli" id="SL_Grupos_Eli" title="Seleccione un grupo"></select>
								</div>
							</div>
						</form>
						<div class='col-lg-offset-1 col-lg-10 table-responsive' id='div-experiencias-eliminar'></div>
					</div>
				</div>

				<!-- Inicio del modal artistas-->
				<div id="modal_artistas" class="modal modal-wide fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title"><strong></strong></h4>
							</div>
							<div class="modal-body">
								<div id="info_artistas">
									<p id="invitado">
										<span>Desde esta opción puede agregar el artista que ha acompañado la atención del grupo.</span><br><br>
										<select class="form-control selectpicker" data-live-search="true" name="SL_Artista_Invitado" id="SL_Artista_Invitado" title="Seleccione un artista"></select>
										<span class="error" style="display: none; color: red;"></span>
									</p>
									<p id="cambio">
										<span id="artista_remover"></span><br><br>
									</p>
									<p id="suplencia">
										<span>Desde esta opción puede seleccionar los artistas que han realizado la suplencia de la atención.</span><br><br>
										<select class="form-control selectpicker" multiple data-max-options="2" data-live-search="true" name="SL_Artista_Suplencia" id="SL_Artista_Suplencia" title="Seleccione dos artistas"></select>
										<span class="error" style="display: none; color: red;"></span>
									</p>
								</div>
							</div>
							<div class="modal-footer">
								<input type="button" class="btn btn-success" value="Guardar" id="BT_Confirmar_artistas" />
								<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar" />
							</div>
						</div>
					</div>
				</div>
				<!--Fin del modal-->
			</div>
		</div>
	</div>
</body>
</html>
