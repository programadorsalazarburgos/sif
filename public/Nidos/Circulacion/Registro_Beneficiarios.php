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
	<title>Registro beneficiarios eventos nidos</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="Js/Registro_Beneficiarios.js?v=2021.03.30"></script>

	<script src="../../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../node_modules/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<link href="../../node_modules/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

	<script src="../../node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<link href="../../node_modules/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

	<script src="../../node_modules/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../../node_modules/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../../node_modules/jszip/dist/jszip.min.js"></script>

	<script src="../../node_modules/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
	<link href="../../node_modules/datatables.net-fixedcolumns-bs/css/fixedColumns.bootstrap.min.css" rel="stylesheet">

	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">

	<link href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<script src="../../bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js"></script>

	<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

	<script src="../../bower_components/moment/moment.js" type="text/javascript"></script>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<style type="text/css">
		#datos .form-control {
			font-size: 12px;
		}
	</style>

</head>

<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Registro beneficiarios a eventos</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#programacion-eventos" role="tab">Programaci??n eventos</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#informacion-evento" role="tab">Informaci??n Evento</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#registro_con_info" role="tab">Beneficiarios con informaci??n</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#registro_sin_info" role="tab">Beneficiarios sin informaci??n</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#beneficiarios_evento" role="tab">Consulta beneficiarios registrados por evento</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reporte-evento" role="tab">Reporte consolidado eventos</a></li>
					<!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#beneficiarios-institucion" role="tab">Reporte beneficiarios por instituci??n</a></li> -->
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="programacion-eventos" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Programaci??n eventos</h4>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-offset-3 col-lg-6">
									<label>Mes</label>
									<select class="form-control" name="SL_Mes_Programacion" id="SL_Mes_Programacion" title="Seleccione un mes"></select>
								</div>
							</div>
						</div>
						<div class="table-responsive" id="div_programacion">
							<table id="tabla_programacion" class="table table-bordered nowrap" style="width: 100%;">
								<thead>
									<tr>
										<th>ID</th>
										<th>D??a</th>
										<th>Fecha</th>
										<th>Franja de Atenci??n</th>
										<th>Nombre Evento</th>
										<th>Localidad</th>
										<th>Entidad</th>
										<th>Solicita</th>
										<th>Equipos Asignados</th>
										<th>Modalidad Atenci??n</th>
										<th>Lugar(es) de atenci??n</th>
										<th>Upz</th>
										<th>Barrio</th>
										<th>Direcci??n</th>
										<th>Contacto Lugar</th>
										<th>Propuesta Atenci??n</th>
										<th>Acompa??amiento Circulaci??n</th>
										<th>Llegada Artistas</th>
										<th>Hora Montaje</th>
										<th>Hora Montaje Nido</th>
										<th>Hora Inicio Atenci??n</th>
										<th>Hora Finalizaci??n</th>
										<th>Hora Desmontaje </th>
										<th>Ubicaci??n</th>
										<th>Indicaciones de Llegada</th>
										<th>Particularidades Terreno</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane" id="informacion-evento" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Informaci??n evento</h4>
								</div>
							</div>
						</div>
						<form id="form-informacion-evento">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-6 col-lg-offset-3">
										<label>Mes</label>
										<select class="form-control" name="SL_Mes_Info" id="SL_Mes_Info" title="Seleccione un mes" required></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-6 col-lg-offset-3">
										<label>Evento</label>
										<select class="form-control selectpicker" data-live-search="true" name="SL_Evento_Info" id="SL_Evento_Info" title="Seleccione un evento" required></select>
									</div>
								</div>
							</div>

							<div id="div-informacion-evento" style="display: none;">
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-3 col-lg-6 col-xs-offset-1 col-xs-10 bg-warning datos-evento">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-3 col-lg-offset-3">
											<label>N??mero de artistas</label>
											<input type="number" class="form-control" id="TX_Num_Art" min="0" max="100" placeholder="Ingrese una cantidad" required>
										</div>
										<div class="col-lg-3">
											<label>N??mero de grupos</label>
											<input type="number" class="form-control" id="TX_Num_Grupos" min="0" max="100" placeholder="Ingrese una cantidad" required>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-3 col-lg-offset-3">
											<label>Espacio p??blico</label>
											<select class="form-control selectpicker" id="SL_Espacio_Publico" title="Seleccione una opci??n" required>
												<option value="Si">Si</option>
												<option value="No">No</option>
											</select>
										</div>
										<div class="col-lg-3">
											<label>N??mero de encuentros o experiencias</label>
											<input type="number" class="form-control" id="TX_Num_Exp" min="0" max="100" placeholder="Ingrese una cantidad" required>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-3 col-lg-6">
											<label>Cuidadores</label>
											<input type="number" class="form-control" id="TX_Num_Cuidadores" min="0" max="2000" placeholder="Ingrese una cantidad" required>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-3 col-lg-3">
											<label>Listado de asistencia</label>
											<input type="file" class="form-control" id="TX_Listado_Asistencia" accept="application/pdf" required>
										</div>
										<div class="col-lg-3">
											<label>Listado cargado</label>
											<a href="#" target="_blank" class="" id="BTN_Ver_Listado">Ver</a>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-4 col-lg-4">
											<button class="btn btn-primary btn-block" type="submit" id="BTN_Guardar_Info_Evento">Guardar</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="registro_con_info" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Registro de beneficiarios con informaci??n</h4>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-offset-3 col-lg-6">
									<label>Mes</label>
									<select class="form-control" name="SL_Mes_Beneficiarios" id="SL_Mes_Beneficiarios" title="Seleccione una opci??n"></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-offset-3 col-lg-6">
									<label>Evento</label>
									<select class="form-control selectpicker" data-live-search="true" name="SL_Evento_Beneficiarios" id="SL_Evento_Beneficiarios" title="Seleccione una opci??n"></select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-lg-offset-3 col-lg-6">
									<label>Lugar de atenci??n</label>
									<select class="form-control selectpicker" data-live-search="true" name="SL_Lugar_Atencion_Beneficiarios" id="SL_Lugar_Atencion_Beneficiarios" title="Seleccione una opci??n"></select>
								</div>
							</div>
						</div>

						<div id="div-registro-beneficiarios" style="display: none;">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6 bg-warning datos-evento"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6">
										<div class="form-inline">
											<div class="form-group">
												<input class="form-control" type="file" id="archivo-beneficiarios">
											</div>
											<button class="btn btn-default" type="button" id="btn-cargar-archivo" disabled>Cargar archivo</button>
											<a href="formato_cargue_baneficiarios_circulacion.xlsx" class="btn btn-success">Descargar plantilla</a>
											<a href="https://youtu.be/qqx7MPBpC4E" target="_blank" class="btn btn-info">Video tutorial</a>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<form id="form-beneficiarios-evento">
										<div class="table-responsive">
											<table id="datos" class="table table-sm table-responsive display table-striped table-bordered table-hover" width="100%">
												<thead>
													<tr>
														<th style="width: 1%; vertical-align: middle;">#</th>
														<th>Tipo<br>documento</th>
														<th>N??mero<br>documento</th>
														<th>Fecha de<br>nacimiento</th>
														<th>Primer<br>nombre</th>
														<th>Segundo<br>nombre</th>
														<th>Primer<br>apellido</th>
														<th>Segundo<br>apellido</th>
														<th>G??nero</th>
														<th>Estrato</th>
														<th>Enfoque<br>diferencial</th>
														<th>Nivel</th>
														<th>Rango de edad</th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-offset-4 col-lg-4">
													<button type="submit" class="btn btn-block btn-primary" id="btn-guardar-beneficiarios">Guardar</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="registro_sin_info" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Registro de beneficiarios sin informaci??n</h4>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-offset-3 col-lg-6 col-xs-offset-1 col-xs-10">
									<label>Mes</label>
									<select class="form-control selectpicker" name="SL_Mes_Asistentes" id="SL_Mes_Asistentes" title="Seleccione una opci??n"></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-offset-3 col-lg-6 col-xs-offset-1 col-xs-10">
									<label>Evento</label>
									<select class="form-control selectpicker" data-live-search="true" name="SL_Evento_Asistentes" id="SL_Evento_Asistentes" title="Seleccione una opci??n"></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-offset-3 col-lg-6 col-xs-offset-1 col-xs-10">
									<label>Lugar de atenci??n</label>
									<select class="form-control selectpicker" data-live-search="true" name="SL_Lugar_Atencion_Asistentes" id="SL_Lugar_Atencion_Asistentes" title="Seleccione una opci??n"></select>
								</div>
							</div>
						</div>
						<div id="div-registro-asistentes" style="display: none;">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6 col-xs-offset-1 col-xs-10 bg-warning datos-evento"></div>
								</div>
							</div>
							<form id="form-asistentes-evento">
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-2 col-lg-8">
											<div class="panel panel-success">
												<div class="panel-heading">Ni??os</div>
												<div class="panel-body">
													<div class="form-group">
														<div class="row">
															<div class="col-lg-6">
																<label>Ni??os de 1 mes a 3 a??os</label>
																<input class="form-control" type="number" min="0" id="TX_Ninos_0_3" required>
															</div>
															<div class="col-lg-6">
																<label>Ni??as de 1 mes a 3 a??os</label>
																<input class="form-control" type="number" min="0" id="TX_Ninas_0_3" required>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-lg-6">
																<label>Ni??os de 4 a 5 a??os</label>
																<input class="form-control" type="number" min="0" id="TX_Ninos_4_6" required>
															</div>
															<div class="col-lg-6">
																<label>Ni??as de 4 a 5 a??os</label>
																<input class="form-control" type="number" min="0" id="TX_Ninas_4_6" required>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-lg-6">
																<label>Ni??os de 6 a 10 a??os</label>
																<input class="form-control" type="number" min="0" id="TX_Ninos_6_10" required>
															</div>
															<div class="col-lg-6">
																<label>Ni??as de 6 a 10 a??os</label>
																<input class="form-control" type="number" min="0" id="TX_Ninas_6_10" required>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="row">
															<div class="col-lg-12">
																<label>Madres gestantes</label>
																<input class="form-control" type="number" min="0" id="TX_Madres" required>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-2 col-lg-8">
											<div class="panel panel-success">
												<div class="panel-heading">Comentarios adicionales</div>
												<div class="panel-body">
													<div class="form-group">
														<textarea class="form-control" rows="5" id="TX_Observacion" style="min-width: 100%; min-height: 200px;"></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-4 col-lg-4">
											<button type="submit" class="btn btn-block btn-primary" id="btn-guardar-asistentes">Guardar</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="tab-pane" id="beneficiarios_evento" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Consulta beneficiarios registrados por evento</h4>
								</div>
							</div>
						</div>
						<form id="form-reporte-evento-beneficiarios">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6">
										<label>Mes</label>
										<select class="form-control" name="SL_Mes_Reporte_Beneficiarios" id="SL_Mes_Reporte_Beneficiarios" title="Seleccione un mes"></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6 col-xs-offset-1 col-xs-10">
										<label>Evento</label>
										<select class="form-control selectpicker" name="SL_Evento_Consulta_Beneficiarios" id="SL_Evento_Consulta_Beneficiarios" title="Seleccione un evento"></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-4 col-lg-4">
										<button type="submit" class="btn btn-block btn-primary">Consultar</button>
									</div>
								</div>
							</div>
						</form>
						<div id="div-reporte-evento-beneficiarios" style="display: none;">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6 bg-warning datos-evento">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-12">
										<table id="tabla-reporte-evento-beneficiarios" class="table table-striped table-bordered table-hover nowrap" style="width: 100%;">
											<thead>
												<tr>
													<th>Nuevo/Antiguo</th>
													<th>Edad</th>
													<th>Rango de edad</th>
													<th>Fecha de nacimiento</th>
													<th>G??nero</th>
													<th>Enfoque diferencial</th>
													<th>Identificaci??n</th>
													<th>Primer nombre</th>
													<th>Segundo nombre</th>
													<th>Primer apellido</th>
													<th>Segundo apellido</th>
													<th>Tipo identificaci??n</th>
													<th>Nivel</th>
													<th>Estrato</th>
													<th>Lugar de atenci??n</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="reporte-evento" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Reporte consolidado eventos</h4>
								</div>
							</div>
						</div>
						<form id="form-reporte-consolidado">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6 col-xs-offset-1 col-xs-10">
										<label>Mes</label>
										<select class="form-control selectpicker" name="SL_Mes_Reporte" id="SL_Mes_Reporte" title="Seleccione un mes"></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-4 col-lg-4">
										<button class="btn btn-block btn-primary" type="submit">Consultar</button>
									</div>
								</div>
							</div>
						</form>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12" id="div-reporte-evento" style="display: none;">
									<table id="tabla-reporte-evento" class="table table-striped table-bordered table-hover" width='100%' style='font-size: 14px;'>
										<thead>
											<tr>
												<th rowspan='2' style='background-color: #fff2cc;'>Fecha</th>
												<th rowspan='2' style='background-color: #fff2cc;'>Evento</th>
												<th rowspan='2' style='background-color: #fff2cc;'>Lugar</th>
												<th rowspan='2' style='background-color: #fff2cc;'>Tipo lugar</th>
												<th rowspan='2' style='background-color: #fff2cc;'>Localidad</th>
												<th rowspan='2' style='background-color: #fff2cc;'>Upz</th>
												<th rowspan='2' style='background-color: #fff2cc;'>Barrio</th>
												<th rowspan='2' style='background-color: #fff2cc;'>Modalidad de atenci??n</th>
												<th rowspan='2' style='background-color: #fff2cc;'>No artistas</th>
												<th rowspan='2' style='background-color: #fff2cc;'>No grupos</th>
												<th rowspan='2' style='background-color: #fff2cc;'>No experiencias</th>
												<th rowspan='2' style='background-color: #fff2cc;'>No cuidadores</th>
												<th colspan='11' style='background-color: #93c47d;'>Beneficiarios nuevos</th>
												<th colspan='18' style='background-color: #93c47d;'>Enfoque diferencial beneficiarios nuevos</th>
												<th colspan='11' style='background-color: #ff9900;'>Beneficiarios sin informaci??n</th>
												<th colspan='11' style='background-color: #d5a6bd;'>Beneficiarios reales</th>
												<th colspan='18' style='background-color: #d5a6bd;'>Enfoque diferencial beneficiarios reales</th>
												<th colspan='3'>Acciones</th>
											</tr>
											<tr>
												<th style='background-color: #b6d7a8;'>Ni??os 1-3</th>
												<th style='background-color: #b6d7a8;'>Ni??as 1-3</th>
												<th style='background-color: #93c47d;'>Total ni??os 1-3</th>
												<th style='background-color: #b6d7a8;'>Ni??os 4-5</th>
												<th style='background-color: #b6d7a8;'>Ni??as 4-5</th>
												<th style='background-color: #93c47d;'>Total Ni??os 4-5</th>
												<th style='background-color: #b6d7a8;'>Ni??os fuera de rango</th>
												<th style='background-color: #b6d7a8;'>Ni??as fuera de rango</th>
												<th style='background-color: #93c47d;'>Total Ni??os fuera de rango</th>
												<th style='background-color: #b6d7a8;'>Gestantes</th>
												<th style='background-color: #93c47d;'>Total nuevos</th>

												<th style="background-color: #b6d7a8;">Comunidad rural y campesina</th>
												<th style="background-color: #b6d7a8;">Ind??gena</th>
												<th style="background-color: #b6d7a8;">Afrodescendiente</th>
												<th style="background-color: #b6d7a8;">Rrom</th>
												<th style="background-color: #b6d7a8;">Raizal</th>
												<th style="background-color: #b6d7a8;">Palenquera</th>
												<th style="background-color: #b6d7a8;">Comunidades negras</th>
												<th style="background-color: #b6d7a8;">Poblaci??n carcelaria</th>
												<th style="background-color: #b6d7a8;">Situaci??n o condici??n de discapacidad</th>
												<th style="background-color: #b6d7a8;">Personas habitantes de calle</th>
												<th style="background-color: #b6d7a8;">Personas que ejercen actividades sexuales pagadas</th>
												<th style="background-color: #b6d7a8;">Poblaci??n victima del conflicto</th>
												<th style="background-color: #b6d7a8;">Personas en situaci??n de desplazamiento</th>
												<th style="background-color: #b6d7a8;">Poblaci??n migrante</th>
												<th style="background-color: #b6d7a8;">Familias ubicadas en zonas de deterioro urbano</th>
												<th style="background-color: #b6d7a8;">Familias en emergencia social y catastr??fica</th>
												<th style="background-color: #b6d7a8;">Sectores LGBTIQ</th>
												<th style="background-color: #93c47d;">Total enfoque nuevos</th>

												<th style='background-color: #ffb545;'>Ni??os 1-3</th>
												<th style='background-color: #ffb545;'>Ni??as 1-3</th>
												<th style='background-color: #ff9900;'>Total ni??os 1-3</th>
												<th style='background-color: #ffb545;'>Ni??os 4-5</th>
												<th style='background-color: #ffb545;'>Ni??as 4-5</th>
												<th style='background-color: #ff9900;'>Total ni??os 4-5</th>
												<th style='background-color: #ffb545;'>Ni??os mayores a 6</th>
												<th style='background-color: #ffb545;'>Ni??as mayores a 6</th>
												<th style='background-color: #ff9900;'>Total ni??os mayores a 6</th>
												<th style='background-color: #ffb545;'>Gestantes</th>
												<th style='background-color: #ff9900;'>Total ni??os sin informaci??n</th>

												<th style='background-color: #ead1dc;'>Ni??os 1-3</th>
												<th style='background-color: #ead1dc;'>Ni??as 1-3</th>
												<th style='background-color: #d5a6bd;'>Total ni??os 1-3</th>
												<th style='background-color: #ead1dc;'>Ni??os 4-5</th>
												<th style='background-color: #ead1dc;'>Ni??as 4-5</th>
												<th style='background-color: #d5a6bd;'>Total Ni??os 4-5</th>
												<th style='background-color: #ead1dc;'>Ni??os fuera de rango</th>
												<th style='background-color: #ead1dc;'>Ni??as fuera de rango</th>
												<th style='background-color: #d5a6bd;'>Total Ni??os fuera de rango</th>
												<th style='background-color: #ead1dc;'>Gestantes</th>
												<th style='background-color: #d5a6bd;'>Total real</th>

												<th style="background-color: #ead1dc;">Comunidad rural y campesina</th>
												<th style="background-color: #ead1dc;">Ind??gena</th>
												<th style="background-color: #ead1dc;">Afrodescendiente</th>
												<th style="background-color: #ead1dc;">Rrom</th>
												<th style="background-color: #ead1dc;">Raizal</th>
												<th style="background-color: #ead1dc;">Palenquera</th>
												<th style="background-color: #ead1dc;">Comunidades negras</th>
												<th style="background-color: #ead1dc;">Poblaci??n carcelaria</th>
												<th style="background-color: #ead1dc;">Situaci??n o condici??n de discapacidad</th>
												<th style="background-color: #ead1dc;">Personas habitantes de calle</th>
												<th style="background-color: #ead1dc;">Personas que ejercen actividades sexuales pagadas</th>
												<th style="background-color: #ead1dc;">Poblaci??n victima del conflicto</th>
												<th style="background-color: #ead1dc;">Personas en situaci??n de desplazamiento</th>
												<th style="background-color: #ead1dc;">Poblaci??n migrante</th>
												<th style="background-color: #ead1dc;">Familias ubicadas en zonas de deterioro urbano</th>
												<th style="background-color: #ead1dc;">Familias en emergencia social y catastr??fica</th>
												<th style="background-color: #ead1dc;">Sectores LGBTIQ</th>
												<th style="background-color: #d5a6bd;">Total enfoque real</th>

												<th>Observaciones</th>
												<th>Listado de asistencia</th>
												<th>Aprobaci??n</th>

											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="tab-pane" id="beneficiarios-institucion" role="tabpanel">


						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Registro de beneficiarios con informaci??n</h4></div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-offset-3 col-lg-6">
									<label>Mes</label>
									<select class="form-control"  title="Seleccione un mes"></select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-offset-3 col-lg-6">
									<label>Evento</label>
									<select class="form-control selectpicker" data-live-search="true"  title="Seleccione un evento"></select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-lg-offset-3 col-lg-6">
									<label>Instituci??n</label>
									<select class="form-control selectpicker" data-live-search="true" title="Seleccione un evento"></select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-lg-offset-3 col-lg-6">
									<button class="btn btn-block btn-primary">Consultar</button>

								</div>
							</div>
						</div>




					</div> -->
				</div>
			</div>
		</div>
	</div>
</body>

</html>