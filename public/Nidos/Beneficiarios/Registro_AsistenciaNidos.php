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
	<title>Registro de Asistencia Beneficiarios</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="Js/Registro_AsistenciaNidos.js?v=2021.09.15.20"></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet">
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<link href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

	<link href="../../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<script src="../../node_modules/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
	<link href="../../node_modules/datatables.net-fixedcolumns-bs/css/fixedColumns.bootstrap.min.css" rel="stylesheet">

	<link href="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.js" type="text/javascript"></script>
	<script src="../../bower_components/moment/moment.js" type="text/javascript"></script>

	<script src="../../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../../css/Nidos.css">


	<style>
		.popover {
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
					<h1>Registro de Asistencia Beneficiarios</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#registro_beneficiario" role="tab">Registro de Asistencia</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#registro_cifras" role="tab">Registro (PROTECCIÓN DE DATOS)</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_asistencia" role="tab">Consulta de Asistencia</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#modificar_asistencia" role="tab">Modificar Asistencia</a></li>

				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="registro_beneficiario" role="tabpanel">
						<!-- <?php echo "<input type='hidden' id='id_usuario' name='id_usuario' value='" . $Id_Persona . "'" ?> -->
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>Registro de Experiencias.</h4>
							</div>
						</div>
						<br>
						<div class="row">
							<label class="col-md-3" for="SL_Lugar_Atencion">Seleccione lugar de atención y grupo:</label>
							<div class="col-md-9">
								<select class="form-control selectpicker" data-live-search="true" name="SL_Lugar_Atencion" id="SL_Lugar_Atencion" title="Seleccione un lugar de atención"></select>
							</div>
						</div>
						<br>
						<div id="div_registro_asistencia_beneficiarios" style="display: none;">
							<form id="form_nueva_experiencia">
								<div class="col-xs-10 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 bg-success">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Localidad:</label></b>
												<span class="SP_Localidad"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Dupla:</label></b>
												<span class="SP_Codigo_Dupla"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Lugar de atención:</label></b>
												<span class="SP_Lugar_Atencion"></span>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Nombre del grupo:</label></b>
												<span class="SP_Grupo"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Tipo de grupo:</label></b>
												<span class="SP_Tipo_Grupo"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Nivel de Escolaridad:</label></b>
												<span class="SP_Grado"></span>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Artistas:</label></b>
												<span class="SP_Artista"></span><a href="#" id="popover-artistas" class="fa fa-info-circle fa-lg" style="text-decoration: none; "></a><br>
												<a href="#" id="undo" style="color: red; text-decoration: none; display: none;">
													<i class="fa fa-undo"></i>
												</a>
												<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Invitado" data-toggle="modal" data-target="#modal_artistas">Invitado</button>
												<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Cambio" data-toggle="modal" data-target="#modal_artistas">Reemplazo</button>
												<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Suplencia" data-toggle="modal" data-target="#modal_artistas">Suplencia</button>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Gestor:</label></b>
												<span class="SP_Gestor"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">EAAT:</label></b>
												<span class="SP_Eaat"></span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-10 col-md-10 col-lg-10">
									<br>
								</div>
								<table class="table" style="width:100%" id="tabla_encabezado">
									<thead>
										<tr>
											<th>Fecha del Encuentro</th>
											<th colspan="2"> Horario</th>
											<th>Nombre de la experiencia</th>
											<th>Modalidad de atención</th>
											<th># de Adultos Cuidadores</th>
										</tr>
									</thead>
									<tr>
										<td>
											<div class="col-xs-12">
												<div class="input-group date">
													<input type="text" readonly="readonly" class="form-control input-sm calendario" id="TX_Fecha_Encuentro" placeholder="Fecha de la experiencia" style="border-style: solid; border-width: 2px; border-color: #3c763d;">
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
												</div>
											</div>
										</td>
										<td><input type="text" required="required" class="form-control input-sm horainicio" id="TX_Hora_Inicio" name="TX_Hora_Inicio" readonly="readonly" placeholder="Hora de inicio" style="border-style: solid; border-width: 2px; border-color: #3c763d;" /></td>
										<td><input type="text" required="required" class="form-control input-sm horafin" id="TX_Hora_Finalizacion" name="TX_Hora_Finalizacion" readonly="readonly" placeholder="Hora de finalización" style="border-style: solid;border-width: 2px; border-color: #3c763d;"></td>
										<td><input type="text" required="required" class="form-control input-sm mayuscula" placeholder="Nombre Experiencia" id="TX_NomExperiencia" name="TX_NomExperiencia" style="border-style: solid; border-width: 2px; border-color: #3c763d;" /></td>
										<td><select class="form-control selectpicker" id="TX_Modalidad" name="TX_Modalidad" title="Seleccione una opción" required>
												<option value="1">Presencial</option>
												<option value="2">Virtual</option>
												<option value="3">Asincronica</option>
											</select></td>
										<td><input type="text" required="required" class="form-control input-sm numbers" placeholder="# Cuidadores" id="TX_Cuidadores" maxlength="2" name="TX_Cuidadores" style="border-style: solid; border-width: 2px; border-color: #3c763d;" /></td>
									</tr>
								</table>
								<!-- 	</div> -->
								<br>
								<div class="table-responsive" id="div_tabla_asistencia_beneficiarios" style="display: none;">
									<input type="hidden" required="required" id="SP_IdLugar" name="SP_IdLugar">
									<input type="hidden" required="required" id="SP_IdGrupo" name="SP_IdGrupo">
									<input type="hidden" required="required" id="SP_IdDupla" name="SP_IdDupla">
									<div class="row">
										<div class="col-xs-12 col-md-12 text-center bg-info">
											<h4>Listado de beneficiarios</h4>
										</div>
									</div>

									<table id="tabla_asistencia_beneficiarios" class="table table-striped table-bordered table-hover" width="100%">
										<thead>
											<tr>
												<th class="text-center">Identificación</th>
												<th class="text-center">Nombre Beneficiario</th>
												<th class="text-center">Género</th>
												<th class="text-center">Enfoque</th>
												<th class="text-center">Primera atención</th>
												<th class="text-center">Edad</th>
												<th class="text-center">Rango de Edad</th>
												<th class="text-center">Uso de Datos</th>
												<th class="text-center">Asistencia</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>

									<div class="row">
										<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
											<input class="form-control btn btn-primary" id="BT_registrar_asistencia" type="button" value="Registrar Asistencia" data-toggle="modal" data-target="#modal_confirmar_asistencia">
										</div>
									</div>
								</div>
								<!-- Inicio del modal confirmar asistencia-->
								<div id="modal_confirmar_asistencia" class="modal modal-wide fade">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title"></h4>
											</div>
											<div class="modal-body">
												<div id="info_asistencia">
												</div>
											</div>
											<div class="modal-footer">
												<input type="submit" class="btn btn-success" id="BT_confirmar_asistencia" value="Si" />
												<input type="button" class="btn btn-danger" data-dismiss="modal" id="BT_cancelar_guardado" />
											</div>
										</div>
									</div>
								</div>
								<!--Fin del modal-->

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

							</form>
						</div>
					</div>

					<!-- SEGUNDA PESTAÑA PROTECCIÓN DE DATOS -->
					<div class="tab-pane" id="registro_cifras" role="tabpanel">
						<form id="form-beneficiarios-sin-info">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Registro de Atenciones Cifras</h4>
								</div>
							</div>
							<br>
							<div class="row">
								<label class="col-md-3" for="SL_Lugar_Atencion_Proteccion">Seleccione lugar de atención y grupo:</label>
								<div class="col-md-9">
									<select class="form-control selectpicker SL_Grupo" data-live-search="true" name="SL_Lugar_Atencion_Proteccion" id="SL_Lugar_Atencion_Proteccion" title="Seleccione un lugar y grupo"></select>
								</div>
							</div>

							<div id="div_registro_experiencia_proteccion" style="display: none;">
								<br>
								<div class="col-xs-10 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 bg-success">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Localidad:</label></b>
												<span class="SP_Localidad_Proteccion"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Dupla:</label></b>
												<span class="SP_Codigo_Dupla_Proteccion"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Lugar de atención:</label></b>
												<span class="SP_Lugar_Atencion_Proteccion"></span>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Nombre del grupo:</label></b>
												<span class="SP_Grupo_Proteccion"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Tipo de grupo:</label></b>
												<span class="SP_Tipo_Grupo_Proteccion"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Nivel de Escolaridad:</label></b>
												<span class="SP_Grado_Proteccion"></span>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Artistas:</label></b>
												<span class="SP_Artista_Proteccion"></span><a href="#" id="popover-artistas" class="fa fa-info-circle fa-lg" style="text-decoration: none; "></a><br>
												<a href="#" id="undo" style="color: red; text-decoration: none; display: none;">
													<i class="fa fa-undo"></i>
												</a>
												<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Invitado_Proteccion" data-toggle="modal" data-target="#modal_artistas">Invitado</button>
												<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Cambio_Proteccion" data-toggle="modal" data-target="#modal_artistas">Reemplazo</button>
												<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Suplencia_Proteccion" data-toggle="modal" data-target="#modal_artistas">Suplencia</button>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Gestor:</label></b>
												<span class="SP_Gestor_Proteccion"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">EAAT:</label></b>
												<span class="SP_Eaat_Proteccion"></span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-10 col-md-10 col-lg-10">
									<br>
								</div><br>
								<div class="row">
									<div class="col-md-6">
										<input type="text" class="form-control input-sm" id="TX_Dupla_Proteccion" maxlength="2" name="TX_Dupla_Proteccion" />
									</div>
									<div class="col-md-6">
										<input type="text" class="form-control input-sm" id="TX_Lugar_Proteccion" maxlength="2" name="TX_Lugar_Proteccion" />
									</div>
								</div>
								<table class="table" style="width:100%" id="tabla_encabezado">
									<thead>
										<tr>
											<th>Fecha del Encuentro</th>
											<th colspan="2"> Horario</th>
											<th>Nombre de la experiencia</th>
											<th>Modalidad de atención</th>
											<th># de Adultos Cuidadores</th>
										</tr>
									</thead>
									<tr>
										<td>
											<div class="input-group date">
												<input type="text" readonly="readonly" class="form-control input-sm calendario" id="TX_Fecha_Encuentro_Proteccion" placeholder="Fecha de la experiencia" style="border-style: solid; border-width: 2px; border-color: #3c763d;">
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</td>
										<td><input type="text" required="required" class="form-control input-sm horainicio" id="TX_Hora_Inicio_Proteccion" name="TX_Hora_Inicio_Proteccion" readonly="readonly" placeholder="Hora de inicio" style="border-style: solid; border-width: 2px; border-color: #3c763d;" /></td>
										<td><input type="text" required="required" class="form-control input-sm horafin" id="TX_Hora_Finalizacion_Proteccion" name="TX_Hora_Finalizacion_Proteccion" readonly="readonly" placeholder="Hora de finalización" style="border-style: solid;border-width: 2px; border-color: #3c763d;"></td>
										<td><input type="text" required="required" class="form-control input-sm mayuscula" placeholder="Nombre Experiencia" id="TX_NomExperiencia_Proteccion" name="TX_NomExperiencia_Proteccion" style="border-style: solid; border-width: 2px; border-color: #3c763d;" /></td>
										<td><select class="form-control selectpicker" id="TX_Modalidad_cifras" name="TX_Modalidad_cifras" title="Seleccione una opción" required>
												<option value="1">Presencial</option>
												<option value="2">Virtual</option>
											</select></td>
										<td><input type="text" required="required" class="form-control input-sm numbers" placeholder="# Cuidadores" id="TX_Cuidadores_Proteccion" maxlength="2" name="TX_Cuidadores_Proteccion" style="border-style: solid; border-width: 2px; border-color: #3c763d;" /></td>
									</tr>
								</table>

								<h4>
									<font style="background-color:aqua;"><label>Beneficiarios con uso de datos:</label> <label style="color:#FF0000" id="LB_Uso_Datos"></label></font>
								</h4>
							</div>

							<div id="div_registro_cifras" style="display: none;">
								<div class="col-lg-6 col-md-6">
									<div class="panel panel-primary col-lg-11 col-md-11 col-lg-offset-1  col-md-offset-1">
										<div class="panel-heading"><i class="fas fa-2x fa-sort-numeric-down"></i> Beneficiarios atención real</div>
										<div class="panel-body">
											<div class="row" style="background-color:#EAECEE">
												<div class="col-lg-4 col-md-4">
													<h6>Niños de 0 a 3 años, 11 meses</h6>
													<input class="form-control ninos03real" type="number" name="tx-ninos-cero-tres" id="tx-ninos-cero-tres" required="required">
												</div>
												<div class="col-lg-4 col-md-4">
													<h6>Niñas de 0 a 3 años, 11 meses</h6>
													<input class="form-control ninos03real" type="number" name="tx-ninas-cero-tres" id="tx-ninas-cero-tres" required="required">
												</div>
												<div class="col-lg-4 col-md-4" style="text-align: center;">
													<h5><strong>Total de 0 a 3 años</strong></h5>
													<label id="suma-ninos03-real"> </label>
													<input class="beneficiariosreal" type="hidden" name="tx-suma-ninos03-real" id="tx-suma-ninos03-real">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4 col-md-4">
													<h6>Niños de 4 años a 5 años, 11 meses</h6>
													<input class="form-control ninos45real" type="number" name="tx-ninos-tres-seis" id="tx-ninos-tres-seis" required="required">
												</div>
												<div class="col-lg-4 col-md-4">
													<h6>Niñas de 4 años a 5 años, 11 meses</h6>
													<input class="form-control ninos45real" type="number" name="tx-ninas-tres-seis" id="tx-ninas-tres-seis" required="required">
												</div>
												<div class="col-lg-4 col-md-4" style="text-align: center;">
													<h5><strong>Total de 4 a 5 años</strong></h5>
													<label id="suma-ninos45-real"> </label>
													<input class="beneficiariosreal" type="hidden" name="tx-suma-ninos45-real" id="tx-suma-ninos45-real">
												</div>
											</div>
											<div class="row" style="background-color:#EAECEE">
												<div class="col-lg-4 col-md-4">
													<h6>Niños de 6 años a 6 años, 11 meses</h6>
													<input class="form-control ninos6real" type="number" name="tx-ninos-seis-anios" id="tx-ninos-seis-anios" required="required">
												</div>
												<div class="col-lg-4 col-md-4">
													<h6>Niñas de 6 años a 6 años, 11 meses</h6>
													<input class="form-control ninos6real" type="number" name="tx-ninas-seis-anios" id="tx-ninas-seis-anios" required="required">
												</div>
												<div class="col-lg-4 col-md-4" style="text-align: center;">
													<h5><strong>Total 6 años</strong></h5>
													<label id="suma-ninos6-real"> </label>
													<input class="beneficiariosreal" type="hidden" name="tx-suma-ninos6-real" id="tx-suma-ninos6-real">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-8 col-md-8">
													<h6>Mujeres gestantes</h6>
													<input class="form-control gestantereal" type="number" name="tx-mujeres" id="tx-mujeres" required="required">
												</div>
												<div class="col-lg-4 col-md-4" style="text-align: center;">
													<h5><strong>Total gestantes</strong></h5>
													<label id="suma-gestantes-real"> </label>
													<input class="beneficiariosreal" type="hidden" name="tx-suma-gestantes-real" id="tx-suma-gestantes-real">
												</div>
											</div>
											<hr>
											<div class="row" style="background-color:#FBEEE6">
												<div class="col-lg-8 col-md-8" style="text-align: right;">
													<label>Total Beneficairios</label>
												</div>
												<div class="col-lg-4 col-md-4" style="text-align: center;">
													<h2><label id="total-beneficiarios-real"> </label></h2>
													<input type="hidden" name="tx-total-beneficiarios-real" id="tx-total-beneficiarios-real">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="panel panel-danger col-lg-11 col-md-11">
										<div class="panel-heading"><i class="fas fa-2x fa-sort-numeric-down"></i> Beneficiarios Nuevos</div>
										<div class="panel-body">
											<div class="row" style="background-color:#EAECEE">
												<div class="col-lg-4 col-md-4">
													<h6>Niños de 0 a 3 años, 11 meses</h6>
													<input class="form-control  ninos03nuevos" type="number" name="tx-ninos-cero-tres-nuevos" id="tx-ninos-cero-tres-nuevos" required="required">
												</div>
												<div class="col-lg-4 col-md-4">
													<h6>Niñas de 0 a 3 años, 11 meses</h6>
													<input class="form-control  ninos03nuevos" type="number" name="tx-ninas-cero-tres-nuevos" id="tx-ninas-cero-tres-nuevos" required="required">
												</div>
												<div class="col-lg-4 col-md-4" style="text-align: center;">
													<h5><strong>Total de 0 a 3 años</strong></h5>
													<label id="suma-ninos03-nuevos"> </label>
													<input class="beneficiariosnuevos" type="hidden" name="tx-suma-ninos03-nuevos" id="tx-suma-ninos03-nuevos">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-4 col-md-4">
													<h6>Niños de 4 años a 5 años, 11 meses</h6>
													<input class="form-control ninos45nuevos" type="number" name="tx-ninos-tres-seis-nuevos" id="tx-ninos-tres-seis-nuevos" required="required">
												</div>
												<div class="col-lg-4 col-md-4">
													<h6>Niñas de 4 años a 5 años, 11 meses</h6>
													<input class="form-control ninos45nuevos" type="number" name="tx-ninas-tres-seis-nuevos" id="tx-ninas-tres-seis-nuevos" required="required">
												</div>
												<div class="col-lg-4 col-md-4" style="text-align: center;">
													<h5><strong>Total de 4 a 5 años</strong></h5>
													<label id="suma-ninos45-nuevos"> </label>
													<input class="beneficiariosnuevos" type="hidden" name="tx-suma-ninos45-nuevos" id="tx-suma-ninos45-nuevos">
												</div>
											</div>
											<div class="row" style="background-color:#EAECEE">
												<div class="col-lg-4 col-md-4">
													<h6>Niños de 6 años a 6 años, 11 meses</h6>
													<input class="form-control ninos6nuevos" type="number" name="tx-ninos-seis-anios-nuevos" id="tx-ninos-seis-anios-nuevos" required="required">
												</div>
												<div class="col-lg-4 col-md-4">
													<h6>Niñas de 6 años a 6 años, 11 meses</h6>
													<input class="form-control ninos6nuevos" type="number" name="tx-ninas-seis-anios-nuevos" id="tx-ninas-seis-anios-nuevos" required="required">
												</div>
												<div class="col-lg-4 col-md-4" style="text-align: center;">
													<h5><strong>Total 6 años</strong></h5>
													<label id="suma-ninos6-nuevos"> </label>
													<input class="beneficiariosnuevos" type="hidden" name="tx-suma-ninos6-nuevos" id="tx-suma-ninos6-nuevos">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-8 col-md-8">
													<h6>Mujeres gestantes</h6>
													<input class="form-control gestantenuevos" type="number" name="tx-mujeres-nuevos" id="tx-mujeres-nuevos" required="required">
												</div>
												<div class="col-lg-4 col-md-4" style="text-align: center;">
													<h5><strong>Total gestantes</strong></h5>
													<label id="suma-gestantes-nuevos"> </label>
													<input class="beneficiariosnuevos" type="hidden" name="tx-suma-gestantes-nuevos" id="tx-suma-gestantes-nuevos">
												</div>
											</div>
											<hr>
											<div class="row" style="background-color:#FBEEE6">
												<div class="col-lg-8 col-md-8" style="text-align: right;">
													<label>Total Beneficairios Nuevos</label>
												</div>
												<div class="col-lg-4 col-md-4" style="text-align: center;">
													<h2><label id="total-beneficiarios-nuevos"> </label></h2>
													<input type="hidden" name="tx-total-beneficiarios-nuevos" id="tx-total-beneficiarios-nuevos">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="panel panel-primary col-lg-11 col-md-11 col-lg-offset-1  col-md-offset-1">
										<div class="panel-heading"><i class="fa fa-2x fa-users"></i> Beneficiarios con enfoque diferencial Atención real</div>
										<div class="panel-body">
											<div class="row p-t">
												<div class="col-lg-4">
													<h6>Afrodescendiente</h6>
													<input class="form-control enfoque" type="number" name="tx-afro" id="tx-afro" required="required">
												</div>
												<div class="col-lg-4">
													<h6>Rural y campesina</h6>
													<input class="form-control enfoque" type="number" name="tx-rural" id="tx-rural" required="required">
												</div>
												<div class="col-lg-4">
													<h6>Discapacidad</h6>
													<input class="form-control enfoque" type="number" name="tx-discapacidad" id="tx-discapacidad" required="required">
												</div>
											</div>
											<div class="row p-t">
												<div class="col-lg-4">
													<h6>Conflicto armado</h6>
													<input class="form-control enfoque" type="number" name="tx-conflicto" id="tx-conflicto" required="required">
												</div>
												<div class="col-lg-4">
													<h6>Indígena</h6>
													<input class="form-control enfoque" type="number" name="tx-indigena" id="tx-indigena" required="required">
												</div>
												<div class="col-lg-4">
													<h6>Privados de la libertad</h6>
													<input class="form-control enfoque" type="number" name="tx-libertad" id="tx-libertad" required="required">
												</div>
											</div>
											<div class="row p-t">
												<div class="col-lg-4">
													<h6>M. victimas de violencia</h6>
													<input class="form-control enfoque" type="number" name="tx-violencia" id="tx-violencia" required="required">
												</div>
												<div class="col-lg-4">
													<h6>Raizal</h6>
													<input class="form-control enfoque" type="number" name="tx-raizal" id="tx-raizal" required="required">
												</div>
												<div class="col-lg-4">
													<h6>Rom o gitano</h6>
													<input class="form-control enfoque" type="number" name="tx-rom" id="tx-rom" required="required">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="panel panel-danger col-lg-11 col-md-11">
										<div class="panel-heading"><i class="fa fa-2x fa-users"></i> Beneficiarios con enfoque diferencial nuevos</div>
										<div class="panel-body">
											<div class="row p-t">
												<div class="col-lg-4">
													<h6>Afrodescendiente</h6>
													<input class="form-control enfoque_nuevos" type="number" name="tx-afro-nuevos" id="tx-afro-nuevos" required="required">
												</div>
												<div class="col-lg-4">
													<h6>Rural y campesina</h6>
													<input class="form-control enfoque_nuevos" type="number" name="tx-rural-nuevos" id="tx-rural-nuevos" required="required">
												</div>
												<div class="col-lg-4">
													<h6>Discapacidad</h6>
													<input class="form-control enfoque_nuevos" type="number" name="tx-discapacidad-nuevos" id="tx-discapacidad-nuevos" required="required">
												</div>
											</div>
											<div class="row p-t">
												<div class="col-lg-4">
													<h6>Conflicto armado</h6>
													<input class="form-control enfoque_nuevos" type="number" name="tx-conflicto-nuevos" id="tx-conflicto-nuevos" required="required">
												</div>
												<div class="col-lg-4">
													<h6>Indígena</h6>
													<input class="form-control enfoque_nuevos" type="number" name="tx-indigena-nuevos" id="tx-indigena-nuevos" required="required">
												</div>
												<div class="col-lg-4">
													<h6>privados de la libertad</h6>
													<input class="form-control enfoque_nuevos" type="number" name="tx-libertad-nuevos" id="tx-libertad-nuevos" required="required">
												</div>
											</div>
											<div class="row p-t">
												<div class="col-lg-4">
													<h6>M. victimas de violencia</h6>
													<input class="form-control enfoque_nuevos" type="number" name="tx-violencia-nuevos" id="tx-violencia-nuevos" required="required">
												</div>
												<div class="col-lg-4">
													<h6>Raizal</h6>
													<input class="form-control enfoque_nuevos" type="number" name="tx-raizal-nuevos" id="tx-raizal-nuevos" required="required">
												</div>
												<div class="col-lg-4">
													<h6>Rom o gitano</h6>
													<input class="form-control enfoque_nuevos" type="number" name="tx-rom-nuevos" id="tx-rom-nuevos" required="required">
												</div>
											</div>
										</div>
									</div>
								</div>
								 
							<div class="panel panel-default col-lg-8 col-lg-offset-2">
									<div class="panel-heading"><i class="fa fa-2x fa-photo-video"></i> Cargar listado de asistencia</div>
									<div class="panel-body">
										<div class="row p-t">
											<div class="col-lg-4">
												<label>Listado de asistencia</label>
												<input type="file" name="fl-documento" id="fl-documento" runat="server" accept="application/pdf" required="required">
												<p>Archivo PDF - Peso máximo 5MB</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-2 col-md-offset-5">
									<button class="form-control btn btn-primary" id="bt-guardar" type="submit">Guardar Experiencia</button>
								</div>
							</div>
						</form>
					</div>

					<!-- TERCERA PESTAÑA CONSULTA ATENCIONES -->

					<div class="tab-pane" id="consulta_asistencia" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>Reporte evento</h4>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-lg-4 col-lg-offset-2">
								<label for="SL_Territorio">Mes:</label>
								<div class="form-group">
									<select class="form-control selectpicker" name="SL_Mes_Reporte" id="SL_Mes_Reporte" title="Seleccione un Mes"></select>
								</div>
							</div>
							<div class="col-lg-4">
							<label for="SL_Territorio"> </label> 
								<button class="btn btn-block btn-primary" type="button" id="btn-beneficiarios-registrados">Consultar</button>
							</div>
						</div>
						
						<br>
						<div id="div-reporte-evento" style="display: none;">
							<div class="row p-t">
								<div class="col-xs-6 col-md-3 col-lg-3">
									<h4><strong>TOTAL DE ATENCIONES: </strong></h4>
								</div>
								<div class="col-xs-6 col-md-3 col-lg-3">
									<h4><strong><span id="SP_Total_Atenciones"></span></strong></h4>
								</div>								
							</div>

							<div class="row p-t">
								<div class='col-xs-6 col-md-6'>
								<h4><center><b>ANEXOS ENCUENTROS GRUPALES</b></center></h4>
									<table id='table-lugar-atencion' class='table table-striped table-bordered' width='100%' style='font-size: 12px; background-color: #EAF2F8;'>
										<thead>
											<tr>
												<th>Lugar de atención</th>
												<th># de atenciones</th>
												<th>Anexo Soporte</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
								<div class='col-xs-6 col-md-6'>
								<h4><center><b>ANEXOS LABORATORIOS</b></center></h4>
									<table id='table-lugar-laboratorio' class='table table-striped table-bordered' width='100%' style='font-size: 12px; background-color: #FDEDEC;'>
										<thead>
											<tr>
												<th>Lugar de atención</th>
												<th># de atenciones</th>
												<th>Anexo Soporte</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>


							<div class="row">
								<div class='col-xs-12 col-md-12'>
									<table id='table-reporte-experiencias' class='table table-striped table-bordered table-hover' width='100%' style='font-size: 12px;'>
										<thead>
											<tr>
												<th rowspan='2' style='background-color: #fff2cc'>ID</th>
												<th rowspan='2' style='background-color: #fff2cc'>Lugar</th>
												<th rowspan='2' style='background-color: #fff2cc'>Grupo / Nivel Escolaridad</th>
												<th rowspan='2' style='background-color: #fff2cc'>Modalidad</th>
												<th rowspan='2' style='background-color: #fff2cc'>Nombre Experiencia</th>
												<th rowspan='2' style='background-color: #fff2cc'>Fecha</th>
												<th rowspan='2' style='background-color: #fff2cc'>Cuidadores</th>
												<th colspan='12' style='background-color: #5499C7'>
													<center>Beneficiarios atención real</center>
												</th>
												<th colspan='12' style='background-color: #EC7063'>
													<center>Beneficiarios Nuevos</center>
												</th>
												<th rowspan='2' style='background-color: #5D6D7E'>
													<font color: white>Editar/Eliminar</font>
												</th>
											</tr>

											<tr>
												<th style='background-color: #D4E6F1'>Niños 0-3</th>
												<th style='background-color: #D4E6F1'>Niñas 0-3</th>
												<th style='background-color: #7FB3D5'>Total 0 - 3 años</th>
												<th style='background-color: #D4E6F1'>Niños 4-5</th>
												<th style='background-color: #D4E6F1'>Niñas 4-5</th>
												<th style='background-color: #7FB3D5'>Total 4 - 5 años</th>
												<th style='background-color: #D4E6F1'>Niños 6</th>
												<th style='background-color: #D4E6F1'>Niñas 6</th>
												<th style='background-color: #7FB3D5'>Total 6 años</th>
												<th style='background-color: #D4E6F1'>Gestantes</th>
												<th style='background-color: #5499C7'>Total beneficiarios</th>
												<th style='background-color: #45B39D'>Enfoque diferencial</th>

												<th style='background-color: #E6B0AA'>Niños 0-3</th>
												<th style='background-color: #E6B0AA'>Niñas 0-3</th>
												<th style='background-color: #D98880'>Total 0-3 años</th>
												<th style='background-color: #E6B0AA'>Niños 4-6</th>
												<th style='background-color: #E6B0AA'>Niñas 4-6</th>
												<th style='background-color: #D98880'>Total 4-6 años</th>
												<th style='background-color: #E6B0AA'>Niños 6</th>
												<th style='background-color: #E6B0AA'>Niñas 6</th>
												<th style='background-color: #D98880'>Total 6 años</th>
												<th style='background-color: #E6B0AA'>Gestantes</th>
												<th style='background-color: #EC7063'>Total beneficiarios</th>
												<th style='background-color: #F75848'>Enfoque diferencial</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane" id="modificar_asistencia" role="tabpanel">
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
							<div class="col-xs-10 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 bg-success">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Localidad:</label></b>
												<span id="SP_Localidad"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Dupla:</label></b>
												<span id="SP_Codigo_Dupla"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Lugar de atención:</label></b>
												<span id="SP_Direccion"></span>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Nombre del grupo:</label></b>
												<span id="SP_Grupo"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Tipo de grupo:</label></b>
												<span id="SP_Tipo_Grupo"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Nivel de Escolaridad:</label></b>
												<span id="SP_Grado"></span>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Artistas:</label></b>
												<span id="SP_Artista"></span><a href="#" id="popover-artistas" class="fa fa-info-circle fa-lg" style="text-decoration: none; "></a><br>
												<a href="#" id="undo" style="color: red; text-decoration: none; display: none;">
													<i class="fa fa-undo"></i>
												</a>
												<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Invitado" data-toggle="modal" data-target="#modal_artistas">Invitado</button>
												<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Cambio" data-toggle="modal" data-target="#modal_artistas">Reemplazo</button>
												<button type="button" name="button" class="btn btn-success btn-xs" id="BT_Suplencia" data-toggle="modal" data-target="#modal_artistas">Suplencia</button>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">Gestor:</label></b>
												<span id="SP_Gestor"></span>
											</div>
											<div class="col-xs-12 col-md-4 col-lg-4">
												<b><label style="font-size:18px;">EAAT:</label></b>
												<span id="SP_Eaat"></span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-10 col-md-10 col-lg-10">
									<br>
								</div>
								<table class="table" style="width:100%" id="tabla_encabezado">
									<thead>
										<tr>
											<th>Fecha del Encuentro</th>
											<th colspan="2"> Horario</th>
											<th>Nombre de la experiencia</th>
											<th>Modalidad de atención</th>
											<th># de Adultos Cuidadores</th>
										</tr>
									</thead>
									<tr>
										<td>
											<div class="col-xs-12">
												<div class="input-group date">
													<input type="text" readonly="readonly" class="form-control input-sm calendario" id="SP_Fecha_Mod" style="border-style: solid; border-width: 2px; border-color: #3c763d;">
													<span class="input-group-addon">
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
												</div>
											</div>
										</td>
										<td><input type="text" required="required" class="form-control input-sm" id="TX_Hora_Inicio_Mod" name="TX_Hora_Inicio" readonly="readonly"></td>
										<td><input type="text" required="required" class="form-control input-sm" id="TX_Hora_Fin_Mod" name="TX_Hora_Finalizacion" readonly="readonly"></td>
										<td><input type="text" class="form-control mayuscula input-sm" id="TX_Nom_Exp_Mod" name="TX_Nom_Exp_Mod" placeholder="Nombre Experiencia" required="required"></td>
										<td><select class="form-control selectpicker" id="TX_Modalidad_Mod" name="TX_Modalidad_Mod" title="Seleccione una opción" required>
												<option value="1">Presencial</option>
												<option value="2">Virtual</option>
											</select></td>
										<td><input type="text" class="form-control input-sm numbers" id="TX_Cuidadores_Mod" name="TX_Cuidadores_Mod" required="required" maxlength="2"></td>
									</tr>
								</table>
								
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


				</div>
			</div>
		</div>

		<div class="modal modal-wide fade" id="miModalEditarEvento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel" style="text-align: center">EDITAR CIFRAS DE LA EXPERIENCIA</h4>
					</div>


					<div class="modal-body">
						<form id="form_editar_experiencia_div">
							<input type="hidden" id="TX_ID_Experiencia_Editar" name="TX_ID_Experiencia_Editar"><br>

							<div class="panel panel-primary col-lg-5">
								<div class="panel-heading"><i class="fas fa-2x fa-sort-numeric-down"></i> Beneficiarios atención real</div>
								<div class="panel-body">
									<div class="row p-t">
										<div class="col-lg-6">
											<h6>Total</h6>
											<input class="form-control" type="number" name="tx-total-M" id="tx-total-M" required="required">
										</div>
										<div class="col-lg-6">
											<h6>Mujeres gestantes</h6>
											<input class="form-control" type="number" name="tx-mujeres-M" id="tx-mujeres-M" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<h6>Niños</h6>
											<input class="form-control" type="number" name="tx-ninos-M" id="tx-ninos-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Niños de 0 a 3 años</h6>
											<input class="form-control" type="number" name="tx-ninos-cero-tres-M" id="tx-ninos-cero-tres-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Niños de 4 a 6 años</h6>
											<input class="form-control" type="number" name="tx-ninos-tres-seis-M" id="tx-ninos-tres-seis-M" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<h6>Niñas</h6>
											<input class="form-control" type="number" name="tx-ninas-M" id="tx-ninas-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Niñas de 0 a 3 años</h6>
											<input class="form-control" type="number" name="tx-ninas-cero-tres-M" id="tx-ninas-cero-tres-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Niñas de 4 a 6 años</h6>
											<input class="form-control" type="number" name="tx-ninas-tres-seis-M" id="tx-ninas-tres-seis-M" required="required">
										</div>
									</div>
								</div>
							</div>

							<div class="panel panel-danger col-lg-6  col-lg-offset-1">
								<div class="panel-heading"><i class="fas fa-2x fa-sort-numeric-down"></i> Beneficiarios Nuevos</div>
								<div class="panel-body">
									<div class="row p-t">
										<div class="col-lg-6">
											<h6>Total</h6>
											<input class="form-control" type="number" name="tx-total-nuevos-M" id="tx-total-nuevos-M" required="required">
										</div>
										<div class="col-lg-6">
											<h6>Mujeres gestantes</h6>
											<input class="form-control" type="number" name="tx-mujeres-nuevos-M" id="tx-mujeres-nuevos-M" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<h6>Niños</h6>
											<input class="form-control" type="number" name="tx-ninos-nuevos-M" id="tx-ninos-nuevos-M" required="required-nuevos">
										</div>
										<div class="col-lg-4">
											<h6>Niños de 0 a 3 años</h6>
											<input class="form-control" type="number" name="tx-ninos-cero-tres-nuevos-M" id="tx-ninos-cero-tres-nuevos-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Niños de 4 a 6 años</h6>
											<input class="form-control" type="number" name="tx-ninos-tres-seis-nuevos-M" id="tx-ninos-tres-seis-nuevos-M" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<h6>Niñas</h6>
											<input class="form-control" type="number" name="tx-ninas-M" id="tx-ninas-nuevos-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Niñas de 0 a 3 años</h6>
											<input class="form-control" type="number" name="tx-ninas-cero-tres-nuevos-M" id="tx-ninas-cero-tres-nuevos-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Niñas de 4 a 6 años</h6>
											<input class="form-control" type="number" name="tx-ninas-tres-seis-nuevos-M" id="tx-ninas-tres-seis-nuevos-M" required="required">
										</div>
									</div>
								</div>
							</div>

							<div class="panel panel-primary col-lg-5">
								<div class="panel-heading"><i class="fa fa-2x fa-users"></i> Beneficiarios con enfoque diferencial Atención real</div>
								<div class="panel-body">
									<div class="row p-t">
										<div class="col-lg-4">
											<h6>Afrodescendiente</h6>
											<input class="form-control enfoque-M" type="number" name="tx-afro-M" id="tx-afro-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Rural y campesina</h6>
											<input class="form-control enfoque-M" type="number" name="tx-rural-M" id="tx-rural-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Discapacidad</h6>
											<input class="form-control enfoque-M" type="number" name="tx-discapacidad-M" id="tx-discapacidad-M" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<h6>Conflicto armado</h6>
											<input class="form-control enfoque-M" type="number" name="tx-conflicto-M" id="tx-conflicto-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Indígena</h6>
											<input class="form-control enfoque-M" type="number" name="tx-indigena-M" id="tx-indigena-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Privados de la libertad</h6>
											<input class="form-control enfoque-M" type="number" name="tx-libertad-M" id="tx-libertad-M" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<h6>M. victimas de violencia</h6>
											<input class="form-control enfoque-M" type="number" name="tx-violencia-M" id="tx-violencia-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Raizal</h6>
											<input class="form-control enfoque-M" type="number" name="tx-raizal-M" id="tx-raizal-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Rom o gitano</h6>
											<input class="form-control enfoque-M" type="number" name="tx-rom-M" id="tx-rom-M" required="required">
										</div>
									</div>
								</div>
							</div>

							<div class="panel panel-danger col-lg-6  col-lg-offset-1">
								<div class="panel-heading"><i class="fa fa-2x fa-users"></i> Beneficiarios con enfoque diferencial nuevos</div>
								<div class="panel-body">
									<div class="row p-t">
										<div class="col-lg-4">
											<h6>Afrodescendiente</h6>
											<input class="form-control enfoque_nuevos" type="number" name="tx-afro-nuevos-M" id="tx-afro-nuevos-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Rural y campesina</h6>
											<input class="form-control enfoque_nuevos" type="number" name="tx-rural-nuevos-M" id="tx-rural-nuevos-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Discapacidad</h6>
											<input class="form-control enfoque_nuevos" type="number" name="tx-discapacidad-nuevos-M" id="tx-discapacidad-nuevos-M" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<h6>Conflicto armado</h6>
											<input class="form-control enfoque_nuevos" type="number" name="tx-conflicto-nuevos-M" id="tx-conflicto-nuevos-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Indígena</h6>
											<input class="form-control enfoque_nuevos" type="number" name="tx-indigena-nuevos-M" id="tx-indigena-nuevos-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>privados de la libertad</h6>
											<input class="form-control enfoque_nuevos" type="number" name="tx-libertad-nuevos-M" id="tx-libertad-nuevos-M" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<h6>M. victimas de violencia</h6>
											<input class="form-control enfoque_nuevos" type="number" name="tx-violencia-nuevos-M" id="tx-violencia-nuevos-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Raizal</h6>
											<input class="form-control enfoque_nuevos" type="number" name="tx-raizal-nuevos-M" id="tx-raizal-nuevos-M" required="required">
										</div>
										<div class="col-lg-4">
											<h6>Rom o gitano</h6>
											<input class="form-control enfoque_nuevos" type="number" name="tx-rom-nuevos-M" id="tx-rom-nuevos-M" required="required">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<br><br>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br></div>
							</div><br>
							<div class="row" style="text-align: center">
								<div class="form-group">
									<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4" style="text-align: center">
										<input class="form-control btn btn-block btn-success" id="BT_EditarExperiencia" type="submit" value="ACTUALIZAR CIFRAS">
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4" style="text-align: center">
										<button type="button" class="form-control btn btn-block btn-danger" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">CANCELAR</span>
										</button>
									</div>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>


		<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-uso-datos-manual">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="text-align: center;">
					<h3 class="modal-title"><strong>AUTORIZACIÓN DE USO DE DATOS BENEFICIARIO</strong></h3>
					</div>
					<div class="modal-body">
					He validado el archivo <b>"AUTORIZACIÓN USO DE DATOS - Estrategia NIDOS EN CASA (respuestas) 2020"</b> y confirmo que el
					beneficiario <label id="lb_beneficiario"></label> con número de identificación <label id="lb_identificacion"></label> cuenta con la autorización de uso de datos. <br><br>
					Por favor ingrese el número de la fila donde se encuentra la autorización:
					<form id="form-uso-datos-manual">
						<input class="form-control" type="hidden" id="TX_identificacion" required>
						<input class="form-control" type="text" id="TX_uso_datos" required>						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-uso-datos-manual">Cerrar</button>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
					</form>
				</div>
			</div> 
		</div>

</body>

</html>