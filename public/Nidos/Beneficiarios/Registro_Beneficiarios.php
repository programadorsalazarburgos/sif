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
	<title>Administración Lugares NIDOS</title>
	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Registro_Beneficiarios.js?v=2021.08.30.5"></script>

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
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

	<link href="../../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<script src="../../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../../css/Nidos.css">

	<style>
	.popover{
		max-width: 400px !important;
	}
	hr {
		margin-top: 5px;
		margin-bottom: 5px;
		border: 0;
		border-top: 1px solid #333;
	}
	</style>

</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de Beneficiarios</h1>
				</div>
			</div>
			<div class="panel-body">

				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#registro_beneficiario" role="tab">Registrar beneficiario grupo</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#consulta_beneficiario" role="tab">Inactivación beneficiarios grupo</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#beneficiarios_provisional" role="tab" id="documento_provisional">Beneficiarios (DOCUMENTO PROVISIONAL)</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="registro_beneficiario" role="tabpanel">
						<?php echo "<input type='hidden' id='id_usuario' name='id_usuario' value='".$Id_Persona."'" ?>
						<br>
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Registro de beneficiarios.</h4>
							</div>
						</div>
						<br>
						<label class="col-md-3" for="SL_Lugar_Atencion">Seleccione lugar y grupo de atención:</label>
						<div class="col-md-9">
							<select class="form-control selectpicker" data-live-search="true" name="SL_Lugar_Atencion" id="SL_Lugar_Atencion" title="Seleccione un lugar de atención"></select>
						</div>
						<br>
						<div class="row">
						</div>
						<div class="table-responsive" id="div_Registro_Beneficiarios" style="display: none;">
							<form id="form_nueva_experiencia">
								<br>
								<div class="row">
									<div class="bg-warning col-xs-12 col-md-12">
										<p><strong>Tenga en cuenta que:</strong></p>
										<ol>
											<li>Para consultar rápidamente los beneficiarios registrados en el grupo puede hacer clic en el botón <strong>Ver beneficiarios registrados en el grupo.</strong></li>
											<li>Seleccione la opción <strong>Documento provisional</strong> si desconoce el número de documento del beneficiario, posteriormente argumente la razón en la ventana emergente y haga clic en <strong>Guardar</strong>, de esta manera el sistema generará un número de documento provisonal.</li>
											<li>Cuando ingrese un número de documento de un beneficiario existente el sistema le mostrará automáticamente los grupos en los cuales el beneficiario está o ha estado registrado.</li>
										</ol>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-xs-12 col-md-12 text-right">
										<input class="btn btn-info" type="button" id="BT_beneficiarios_grupo" value="Ver beneficiarios registrados en el grupo"  data-toggle="modal" data-target="#modal_ver_beneficiarios_grupo">
									</div>
								</div>
								<input type="hidden" required="required" class="form-control" id="SP_IdGrupo" name="SP_IdGrupo">
								<input type="hidden" required="required" class="form-control" id="SP_IdEntidad" name="SP_IdEntidad">

								<table class="table" style="width:100%" id="tabla_Titulos_Registro">
									<thead>
										<tr>
											<th style="width: 2%; vertical-align: middle;">#</th>
											<th style="width: 20%">No. documento<hr>Tipo documento</th>
											<th style="width: 20%">Primer nombre<hr>Segundo nombre</th>
											<th style="width: 20%">Primer apellido<hr>Segundo apellido</th>
											<th style="width: 18%">Fecha de nacimiento<hr>Género</th>
											<th style="width: 20%">Enfoque diferencial<hr>Estrato</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width: 2%; vertical-align: middle;">1</td>
											<td style="width: 20%">
												<div class="form-group">
													<input type="text" class="form-control identificacion" placeholder="Identificación" id="TX_Identificacion_1" name="TX_Identificacion_1">
													<span class="help-block" id="error"></span>
												</div>
												<div class="form-group tipo-documento">
													<select class="form-control selectpicker " data-live-search="true" id="SL_Tipo_Documento_1" name="SL_Tipo_Documento_1" title="Tipo de documento"></select>
													<span class="help-block" id="error"></span>
												</div>
											</td>
											<td style="width: 20%">
												<div class="form-group">
													<input type="text" class="form-control mayuscula" placeholder="Primer nombre" id="TX_P_Nombre_1" name="TX_P_Nombre_1">
													<span class="help-block" id="error"></span>
												</div>
												<div class="form-group">
													<input type="text" class="form-control mayuscula" placeholder="Segundo nombre" id="TX_S_Nombre_1" name="TX_S_Nombre_1">
													<span class="help-block" id="error"></span>
												</div>
											</td>
											<td style="width: 20%">
												<div class="form-group">
													<input type="text" class="form-control mayuscula" placeholder="Primer apellido" id="TX_P_Apellido_1" name="TX_P_Apellido_1">
													<span class="help-block" id="error"></span>
												</div>
												<div class="form-group">
													<input type="text" class="form-control mayuscula" placeholder="Segundo apellido" id="TX_S_Apellido_1" name="TX_S_Apellido_1">
													<span class="help-block" id="error"></span>
												</div>
											</td>
											<td style="width: 18%">
												<div class="form-group">
													<div class="input-group date">
														<input type="text" readonly="readonly" class="form-control fecha" placeholder="Fecha de nacimiento" id="TX_F_Nacimiento_1" name="TX_F_Nacimiento_1">
														<div class="input-group-addon">
															<span class="glyphicon glyphicon-calendar"></span>
														</div>
													</div>
													<span class="help-block" id="error"></span>
												</div>
												<div class="form-group">
													<select class="form-control selectpicker" data-live-search="true" id="SL_Genero_1" name="SL_Genero_1" title="Género"></select>
													<span class="help-block" id="error"></span>
												</div>
											</td>
											<td style="width: 20%">
												<div class="form-group">
													<select class="form-control selectpicker" data-live-search="true" id="SL_Etnia_1" name="SL_Etnia_1" title="Enfoque diferencial"></select>
													<span class="help-block" id="error"></span>
												</div>
												<div class="form-group">
													<select class="form-control selectpicker" data-live-search="true" id="SL_Ip_1" name="SL_Ip_1" title="Estrato"></select><input type="hidden" class="form-control" id="TX_Existe_1" name="TX_Existe_1">
													<span class="help-block" id="error"></span>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								<a id="btn_Agregar" class="btn btn-primary " Title="Agregar" data-toggle='tooltip'  data-placement="right">Agregar</a>
								<a id="btn_Quitar"  class="btn btn-danger " Title="Quitar" data-toggle='tooltip'  data-placement="right">Quitar</a>
								<div id="summary">

								</div>
								<div class="row">
									<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
										<input class="form-control btn btn-primary" id="BT_guardar_beneficiarios" type="submit" value="Registrar Beneficiarios al Grupo">
									</div>
								</div>
								<br>
							</form>
						</div>
					</div>
					<div class="tab-pane" id="consulta_beneficiario" role="tabpanel">

						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Inactivación de beneficiarios en un grupo.</h4>
							</div>
						</div>
						<br>
						<label class="col-md-3" for="SL_Lugar_Atencion_Consulta">Seleccione lugar y grupo de atención:</label>
						<div class="col-md-9">
							<select class="form-control selectpicker" data-live-search="true" name="SL_Lugar_Atencion_Consulta" id="SL_Lugar_Atencion_Consulta" title="Seleccione un lugar de atención"></select>
						</div>
						<div class="row">
						</div>
						<div class="table-responsive" id="div_Consulta_Beneficiarios" style="display: none;">
							<table id="tabla_inactivar_beneficiario" class="table table-striped table-bordered table-hover"  width="100%">
								<thead>
									<tr>
										<th class="text-center">Identificación</th>
										<th class="text-center">Nombre Beneficiario</th>
										<th class="text-center">Fecha Nacimiento</th>
										<th class="text-center">Género</th>
										<th class="text-center">Enfoque diferencial</th>
										<th class="text-center">Estrato</th>
										<th class="text-center">Opciones</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>

					<div class="tab-pane" id="beneficiarios_provisional" role="tabpanel">
					<br>
								<div class="row">
									<div class="bg-warning col-xs-12 col-md-12">
										<p><strong>CONSULTA BENEFICIARIOS</strong></p>
										<ol>
											<li>En esta consulta aparecen todos los beneficiarios registrados con número de documento provisional en el sistema.</li>
											<li>Por favor ingrese el nombre del beneficairio que desea encontrar en la casilla del buscador</li>
										</ol>
									</div>
								</div>
								<br>

								<table id="tabla_beneficiarios_provisional" class="table table-striped table-bordered table-hover"  width="100%">
								<thead>
									<tr>
										<th class="text-center">Identificación</th>
										<th class="text-center">Tipo documento</th>
										<th class="text-center">Nombre Beneficiario</th>
										<th class="text-center">Fecha Nacimiento</th>
										<th class="text-center">Edad</th>
										<th class="text-center">Género</th>
										<th class="text-center">Enfoque diferencial</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
					
					</div>

					<!-- Inicio del modal para activar e inactivar un beneficiario-->
					<div id="div-modal-activacion" class="modal modal-wide fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
									<h4 class="modal-title"></h4>
								</div>
								<div class="modal-body">
									<form id="form-inactivar-beneficiario" style="display: none;">
									</form>
									<form id="form-activar-beneficiario" style="display: none;">
									</form>
								</div>
								<div class="modal-footer">

								</div>
							</div>
						</div>
					</div>
					<!--Fin del modal-->

					<!-- Inicio del modal Ver beneficiarios registrados en el grupo-->
					<div id="modal_ver_beneficiarios_grupo" class="modal modal-wide fade">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<center><strong><h4 class="modal-title">Beneficiarios registrados en el grupo</h4></strong></center>
								</div>
								<div class="modal-body">
									<div id="info_beneficiarios">
										<table id="tabla_beneficiarios_grupo" class="table table-striped table-bordered table-hover"  width="100%">
											<thead>
												<th><center>Número de identificación</center></th>
												<th><center>Nombre beneficiario</center></th>
												<th><center>Estado</center></th>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
								<div class="modal-footer">
									<input type="button" class="btn btn-success" data-dismiss="modal" value="Ok"/>
								</div>
							</div>
						</div>
					</div>
					<!--Fin del modal-->

					<!-- Inicio del modal observación documento provisional-->
					<div id="modal_observacion_documento_provisional" class="modal modal-wide fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
									<h4 class="modal-title">Observación documento provisional beneficiario</h4>
								</div>
								<div class="modal-body">
									<div id="div-observacion">
									</div>
								</div>
								<div class="modal-footer">
									<input type="button" class="btn btn-success" id="btn-guardar-observacion" value="Guardar"/>
									<input type="button" class="btn btn-danger" id="btn-cancelar-observacion" data-dismiss="modal" value="Cancelar"/>
								</div>
							</div>
						</div>
					</div>
					<!--Fin del modal-->

				</div>
			</body>
			</html>
