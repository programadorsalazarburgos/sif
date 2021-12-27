<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else {
	$Id_Persona= $_SESSION["session_username"];
}
include("../../Controlador/Administracion/C_Asignacion_Actividades.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Traslados de Inventario</title>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" rel="stylesheet">
	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../css/material-desing.css">
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script> 	
	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="../Infraestructura/bootstrap-checkbox-1.4.0/dist/js/bootstrap-checkbox.min.js" defer></script>
	<link rel="stylesheet" type="text/css" href="../LibreriasExternas/datepicker/css/bootstrap-datepicker.css"> 
	<script type="text/javascript" src="../LibreriasExternas/datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../bower_components/dataTables.net-buttons/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="../bower_components/dataTables.net-buttons/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/colreorder/1.4.1/js/dataTables.colReorder.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.colVis.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/animate.css">
	<script type="text/javascript" src="Js/Traslados.js?v=2019.09.16.17"></script>
	<style type="text/css">
		.material-switch > label::before {
			background: #ff4642;
			box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
			border-radius: 8px;
			content: '';
			height: 16px;
			margin-top: -8px;
			margin-left: 0px;
			position: absolute;
			opacity: 0.3;
			transition: all 0.4s ease-in-out;
			width: 45px;
		}
		.material-switch > label::after {
			background: #ff4642;
			border-radius: 16px;
			box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			content: '';
			height: 24px;
			left: 0px;
			margin-top: -8px;
			position: absolute;
			top: -4px;
			transition: all 0.3s ease-in-out;
			width: 24px;
		}
	</style>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Traslados de Inventario <small>Infraestructura</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#usuario_especifico" role="tab">Realizar Traslado</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#usuario_especifico" role="tab">Solicitudes pendientes</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#usuarios_rol" role="tab">Historial</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="usuario_especifico" role="tabpanel">
						<div class="alert alert-success text-justify" role="alert">
							<strong>Utilice los filtros para buscar los elementos que desea trasladar.</strong>
						</div>
						<div class="panel panel-info">
							<div class="panel-body"> 
								<center>
									<form id="FORM_CONSULTA_INVENTARIO" name="CONSULTA_INVENTARIO">
										<div class="row row-centered" style="background-color:rgb(240,243,245)">
											<div style="background-color: #007076; padding-top:1%; padding-bottom:1%" class="col-md-12 col-lg-12 col-xs-12">
												<div class="col-xs-2 col-md-2 col-lg-2 col-centered"><label><p style="color:#fff !important">CREA*:</p></label></div>
												<div class="col-xs-3 col-md-3 col-lg-3 col-centered" style="text-align:left">
													<select id="SL_CREA" name="SL_CREA" multiple="multiple" class="selectpicker" data-live-search="true" data-actions-box="true" title="Seleccione el CREA" required>
														<option value="" selected>Todos</option>
													</select>
												</div>
												<div class="col-xs-2 col-md-2 col-lg-2 col-centered" style="text-align:left">
													<button id="BT_CONTROL_INVENTARIO" name="BT_CONTROL_INVENTARIO" type="button" class="btn-success form-control hidden">EXCEL DE INVENTARIO <span class="far fa-file-alt"></span> <span class="fas fa-download"></span></button>
													<a id="a_download" name="a_download" href="../../src/Infraestructura/Controlador/InventarioCrea.xls" hidden download>DESCARGAR</a>
												</div>
												<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-centered">
													<input type="checkbox" data-off-label="Filtros" data-on-label="Placa" id="CHECKBOX_TIPO_CONSULTA" data-off-active-cls="btn-warning" data-on-active-cls="btn-warning">
												</div>
											</div>
											<div id="div_consultar_inventario">
												<div id="DIV_FILTROS_INVENTARIO">
													<div class="col-xs-12 col-md-12 col-lg-12" style="padding-top:1%">
														<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align:right;">
															<label><p>Elemento:</p></label>
														</div>
														<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="text-align:left">
															<select id="SL_ELEMENTO" name="SL_ELEMENTO" multiple="multiple" class="selectpicker" data-live-search="true" required>
																<option value="" selected>Todos</option>
															</select>
														</div>
														<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align:right;">
															<label><p>Tipo Bien:</p></label>
														</div>
														<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
															<select id="SL_TIPO_BIEN" name="SL_TIPO_BIEN" class="form-control selectpicker" data-live-search="true">
																<option value="">Todos</option>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-md-12 col-lg-12" style="padding-top:1%">
														<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align:right;">
															<label><p>Descripción:</p></label>
														</div>
														<div class="col-xs-4  col-sm-4 col-md-4 col-lg-4" style="text-align:left">
															<textarea id="TX_DESCRIPCION" name="TX_DESCRIPCION" class="form-control" rows="1"></textarea>
														</div>
														<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align:right;">
															<label><p>Dados de Baja:</p></label>
														</div>
														<div class="col-xs-4  col-sm-4 col-md-4 col-lg-4" style="text-align:left">
															<select id="SL_ESTADO_BAJA" name="SL_ESTADO_BAJA" class="form-control selectpicker">
																<option value="" selected>Todos</option>
																<option value="1" selected>NO</option>
																<option value="2">SI</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="DIV_CONSULTA_PLACA" style="padding-top:1%" hidden>
													<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xs-offset-4 col-md-offset-4 col-lg-offset-4" style="text-align:right;">
														<label><p>Placa*:</p></label>
													</div>
													<div class="input-group col-xs-2 col-sm-2 col-md-2 col-lg-2 ">
														<input id="TXT_PLACA" name="TXT_PLACA" class="form-control" type="text" onkeyup="this.value=this.value.replace(/[^\d]+/,'')" maxlength="5">
														<span class="input-group-btn"><input id="BT_SIN_PLACA" type="button" value="S/P" class="btn btn-success form-control"></span>
													</div>
												</div>
												<div class="col-xs-12 col-md-12 col-lg-12" style="padding-top:1%">
													<hr>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xs-offset-4 col-md-offset-4 col-lg-offset-4" style="padding:1%">
														<input class="btn btn-primary form-control" type="submit" value="CONSULTAR">
													</div>
													<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="padding:1%">
														<a id="BT_SELECCIONADOS" class="btn btn-default form-control">
															Ver Seleccionados <span class="badge badge-light" id="cantidad_seleccionados" style="font-size: 14px">0</span>
														</a>
													</div>
												</div>
											</div>
										</div>
									</form>				
								</center>
							</div>
						</div>
						<div class="panel panel-success">
							<table id="tabla-lista-inventario" class="table table-striped table-bordered table-hover display nowrap" style="width:100%">
								<thead>
									<tr class="theader">
										<th>ID</th>
										<th>IdCrea</th>
										<th width="10%">Crea</th>
										<th width="2%">#</th>
										<th>Tipo Bien</th>
										<th width="5%">Placa</th>
										<th width="20%">Elemento</th>
										<th width="20%">Descripcion</th>
										<th>Estado</th>
										<th width="5%">Valor Unt</th>
										<th width="5%">Valor Total</th>
										<th>Donante</th>
										<th width="15%">Opciones</th>
										<th>Observaciones</th>
										<th>Creador</th>
										<th># Traslado</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>   
						</div>
					</div>
					<div class="tab-pane" id="usuarios_rol" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="alert alert-success text-justify" role="alert">
									<strong>Seleccionar rol: </strong> Usando los siguientes seleccionables puede asignar una actividad especifica a <b>TODOS</b> los usuarios que tienen un rol especifico asignado.
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_rol">Seleccione el rol:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control" id="SL_rol"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_modulo">Seleccione un módulo:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control" id="SL_modulo"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_actividad">Seleccione una actividad:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control" id="SL_actividad"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3 col-md-3">
								<a href="#" class="form-control btn btn-warning" id="Bt_mostrar_usuarios_rol_con_actividad" title="Ver Usuarios con esta actividad en su rol">Ver</a>
							</div>
							<div class="col-xs-3 col-xs-offset-2 col-md-3 col-md-offset-2">
								<button type="button" class="form-control btn btn-primary" id="BT_asignar_actividad_rol" title="Asignar actividad a los usuarios">Asignar<span id="span_total_usuarios_rol" class="badge">(00)</span></button>
							</div>
							<div class="col-xs-3 col-xs-offset-1 col-md-3 col-md-offset-1">
								<a href="#" class="form-control btn btn-danger" id="BT_remover_actividad_rol" title="Remover actividad a los usuarios">Remover<span id="span_total_usuarios_rol_actividad" class="badge">(00)</span></a>
							</div>
						</div>
						<div class="row" id="div_table_usuarios_rol_actividad">
							<div class="col-xs-12 col-md-12 table-responsive">
								<table id="table_usuarios_rol_actividad" class="table table-hover">
									<thead>
										<tr>
											<th>Identificación</th>
											<th>Nombre Completo</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-seleccionados" class="modal fade" style="font-size: 14px;"  tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="h4-traslado">SOLICITUD DE TRASLADO</h4>
				</div>
				<div class="modal-body row" style="margin: 10px">
					<div id="cabecera-traslado" style="font-size: 16px; background-color: #007076; color: rgb(255,255,255);"></div>
					<ul class="nav nav-tabs">
						<li style="width: 15em" class="active"><a id="ver-listado" data-toggle="tab" href="#div-tabla-items">Ítems seleccionados</a></li>
						<li style="width: 10em"><a id="ver-agregar-traslado" data-toggle="tab" href="#agregar-traslado">Datos Traslado</a></li>
					</ul>
					<div class="tab-content">
						<div id="div-tabla-items" class="tab-pane fade in active">
							<table id="tabla-items-seleccionados" class="table table-striped table-bordered table-hover" style="width:100%">
								<thead>
									<tr class="theader">
										<th>Placa</th>
										<th>Elemento</th>
										<th>Tipo Bien</th>
										<th>Descripción</th>
										<th>Cantidad</th>
										<th>Estado</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
						<div id="agregar-traslado" class="col-md-8 col-md-offset-2 tab-pane fade">
							<br>
							<form id="FM-TRASLADO" name="FM-TRASLADO">
								<div id="alert-cantidad" class="alert alert-danger" hidden>
									<strong>Atención!</strong> La cantidad no puede ser mayor a los restantes disponibles.
								</div>
								<div class="col-md-12">
									<select id="MODAL_SL_TIPO_TRASLADO" name="MODAL_SL_TIPO_TRASLADO" class="form-control selectpicker" data-live-search="true"" title="Seleccione el tipo de traslado" required>
										<option value="Temporal">Temporal</option>
										<option value="Definitivo">Definitivo</option>
										<option value="Baja">Baja</option>
									</select>
								</div>
								<div class="col-md-12">
									<input id="TXT_ORIGEN" name="TXT_ORIGEN" type="text" readonly value="Origen:" class="form-control">
								</div>
								<div class="col-md-12">
									<input id="ID_ORIGEN" name="ID_ORIGEN" type="text" readonly class="form-control hidden">
								</div>
								<div class="col-md-12">
									<input id="TXT_SOLICITANTE" name="TXT_SOLICITANTE" type="text" readonly value="Solicitante:" class="form-control">
								</div>
								<div><label>Lugar de Destino:</label></div>
								<div class="col-md-12">
									<select id="MODAL_SL_DESTINO" name="MODAL_SL_DESTINO" class="form-control selectpicker" data-live-search="true" title="Seleccione el Destino" required>
									</select>
								</div>
								<div class="col-md-9">
									<input id="TXT_OTRO_DESTINO" name="TXT_OTRO_DESTINO" class="form-control hidden" placeholder="Indique un lugar de destino alternativo" style="resize: vertical;" required>
								</div>
								<div class="col-md-9">
									<textarea id="TXT_TRASLADO" name="TXT_TRASLADO" class="form-control" rows="1" placeholder="Argumente el porqué del traslado (Opcional)" style="resize: vertical;"></textarea>
								</div>
								<div class="col-md-3">
									<input id="TXT_CANTIDAD_TRASLADO" name="TXT_CANTIDAD_TRASLADO" class="form-control" type="number" min="1" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" title="Solo números" placeholder="Cantidad" required>
									<input id="TXT_CANTIDAD_TOTAL" name="TXT_CANTIDAD_TOTAL" class="form-control" readonly hidden>
								</div>
								<div><center><input type="submit" class="btn btn-primary" value="Enviar solicitud"></center></div>
							</form>
						</div>
					</div>
				</div>       
			</div>
		</div>
	</div>
</body>