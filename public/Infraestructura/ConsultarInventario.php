<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else {
	$Id_Persona= $_SESSION["session_username"];
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Consultar Inventario</title>
		<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="../css/Siclan.css" rel="stylesheet" type="text/css">
		<link href="Css/infraestructura.css?v=1.1" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet" type="text/css">
		<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
		<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" type="text/css">
		<link href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"> 
		<link href="../bower_components/jquery-ui/themes/base/jquery-ui.css" rel="Stylesheet" type="text/css">
		<link href="../bower_components/datatables.net-responsive/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
		<link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 
		<link href="../LibreriasExternas/alertifyjs/css/alertify.min.css" rel="stylesheet">
		
		<script src="../bower_components/jquery/dist/jquery.min.js"></script>
		<script src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>
		<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="../bower_components/bootbox.js/bootbox.js"></script>
		<script src="../Infraestructura/bootstrap-checkbox-1.4.0/dist/js/bootstrap-checkbox.min.js" defer></script>
		<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
		<script src="../js/textarea-helper.js"></script>
		<script src="../bower_components/jquery-ui/jquery-ui.js"></script>
		<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
		<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
		<script src="../bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
		<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>
		<script src="../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.js?v=2020.05.21.1"></script>
		<script src="Js/ConsultarInventario.js?v=2021.04.15.2"></script>
	</head>
	<body>
		<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
		<center>
			<br>
			<div class="panel panel-info">
				<div class="panel-heading"> <center>
					<strong><p style="font-size:20px"><span class="glyphicon glyphicon-search"></span> CONSULTA DE INVENTARIO <span class="glyphicon glyphicon-list-alt"></span></p></strong> </center>
				</div>
				<div class="alert alert-success" id="Notificacion_Success" hidden><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
				<div class="alert alert-danger" id="Notificacion_Wrong" hidden><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>El elemento no pudo ser registrado...</div>
				<div class="panel-body"> 
					<center>
						<form id="FORM_CONSULTA_INVENTARIO" name="CONSULTA_INVENTARIO">
							<div class="row row-centered" style="background-color:rgb(240,243,245)">
								<div style="background-color:#007076; padding-top:1%; padding-bottom:1%">
									<div class="col-xs-6 col-md-2 col-lg-2 col-centered" style="text-align:left">
										<select id="SL_PROYECTO" name="SL_PROYECTO" class="selectpicker" data-live-search="true" data-actions-box="true" title="Seleccione el Proyecto" required>
										</select>
									</div>
									<div class="col-xs-6 col-md-3 col-lg-3 col-centered" style="text-align:left">
										<select id="SL_LUGAR" name="SL_LUGAR" multiple="multiple" class="selectpicker" data-live-search="true" data-actions-box="true" title="Seleccione el Lugar" required>
										</select>
									</div>
									<div class="col-xs-2 col-md-2 col-lg-2 col-centered" style="text-align:left">
										<button id="BT_CONTROL_INVENTARIO" name="BT_CONTROL_INVENTARIO" type="button" class="btn-success form-control hidden">INVENTARIO <span class="far fa-file-alt"></span> <span class="fas fa-download"></span></button>
										<a id="a_download" name="a_download" href="../../src/Infraestructura/Controlador/InventarioCrea.xls" hidden download>DESCARGAR</a>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 col-centered">
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
													<option value="" selected>TODOS</option>
												</select>
											</div>
											<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="text-align:right;">
												<label><p>Tipo Bien:</p></label>
											</div>
											<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
												<select id="SL_TIPO_BIEN" name="SL_TIPO_BIEN" class="form-control" data-live-search="true">
													<option value="">TODOS</option>
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
												<select id="SL_ESTADO_BAJA" name="SL_ESTADO_BAJA" class="form-control">
													<option value="" selected>TODOS</option>
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
											<input id="TXT_PLACA" name="TXT_PLACA" class="form-control" type="text" onkeyup="this.value=this.value.replace(/[^\d]+/,'')" maxlength="10">
											<span class="input-group-btn"><input id="BT_SIN_PLACA" type="button" value="S/P" class="btn btn-success form-control"></span>
										</div>
									</div>
									<div class="col-xs-12 col-md-12 col-lg-12" style="padding-top:1%">
										<hr>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xs-offset-4 col-md-offset-4 col-lg-offset-4" style="padding:1%">
											<input id="BT_LIMPIAR" name="BT_LIMPIAR" class="btn btn-warning form-control" type="reset" value="Limpiar">
										</div>
										<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="padding:1%">
											<input class="btn btn-primary form-control" type="submit" value="CONSULTAR">
										</div>
									</div>
								</div>
							</div>
						</form>				
					</center>
				</div>

			</div><!-- Cierra Div del panel -->
			<div class="panel panel-success">
				<table id="tabla-lista-inventario" class="table table-striped table-bordered table-hover display nowrap" style="width:100%">
					<thead>
						<tr class="theader">
							<th>ID</th>
							<th>IdCrea</th>
							<th width="10%">Espacio</th>
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
							<th>IdProyecto</th>
							<th>Tiene R.Fotográfico</th>
							<th>Responsable</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>   
			</div>
		</center>
	</body>
	<div id="modal-editar" class="modal fade" style="font-size: 14px;" tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="h4-edit"></h4>
				</div>
				<div class="modal-body" id="modal_body">      
					<form id="FM_ACTUALIZAR_INVENTARIO" name="FM_ACTUALIZAR_INVENTARIO" class="form-horizontal">
						<div class="panel-heading panel-heading-custom-actualizar">
							<div class="col-xs-6 col-md-6 col-lg-6 col-centered">
								<center>
									<strong><p style="font-size:25px; color: white !important">ACTUALIZACIÓN DE INVENTARIO </p></strong>
								</center>
							</div>
							<div class="col-xs-3 col-md-3 col-lg-3 col-centered">
								<select id="MODAL_SL_PROYECTO" name="MODAL_SL_PROYECTO" class="form-control required" disabled="disabled" required title="Seleccione Espacio">
								</select>
							</div>
							<div class="col-xs-3 col-md-3 col-lg-3 col-centered">
								<select id="MODAL_SL_LUGAR" name="MODAL_SL_LUGAR" class="form-control required" disabled="disabled" required title="Seleccione Espacio">
								</select>
							</div>
							<div class="col-centered">
								<button id="BT_TRASLADO" name="BT_TRASLADO" type="button" class="btn btn-success" title="Traslados"><span class='fa fa-truck fa-2x'></span></button>
							</div>
							<div class="col-centered">
								<button id="BT_ASIGNACIONES" name="BT_ASIGNACIONES" type="button" class="btn btn-success" title="Asignaciones"><span class='fa fa-user-circle fa-2x'></span></button>
							</div>
						</div>
						<div class="panel-body" style="padding: 0px;">
							<center>
								<div class="row row-centered">
									<div id="div_actualizar_inventario">
										<div class="col-xs-6 col-md-6 col-lg-6 custom-border">
											<div class="col-xs-12 col-md-12 col-lg-12" style="padding-top:1%">
												<div id="div_tipo_bien" name="div_tipo_bien">
													<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
														<label><p>Tipo Bien*:</p></label>
													</div>
													<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
														<select id="MODAL_SL_TIPO_BIEN" name="MODAL_SL_TIPO_BIEN" class="form-control required" required title="Seleccione Tipo Bien">
														</select>
													</div>
												</div>
											</div>
											<div class="col-xs-12 col-md-12 col-lg-12" style="padding-top:1%">
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
													<label><p>Cantidad*:</p></label>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<input id="MODAL_TXT_CANTIDAD" name="MODAL_TXT_CANTIDAD" class="form-control required" type="number" min="0" required>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%">
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
													<label><p>Elemento*:</p></label>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<select id="MODAL_SL_ELEMENTO" name="MODAL_SL_ELEMENTO" class="form-control required" required title="Seleccione Elemento">
													</select>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%; padding-bottom:1%; background-color:rgba(0,0,0,0.1)" id="MODAL_DIV_DONANTE" name="MODAL_DIV_DONANTE" hidden>
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
													<label><p>Donante*:</p></label>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<input id="MODAL_TXT_DONANTE" name="MODAL_TXT_DONANTE" class="form-control" placeholder="" type="text" list="modal_donantes">
													<datalist id="modal_donantes">
													</datalist>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
													<label><p>Estado*:</p></label>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding-top: 10px;">
													<select id="MODAL_SL_ESTADO_BIEN" name="MODAL_SL_ESTADO_BIEN" class="form-control required" required title="Seleccione Estado">
													</select>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%">
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
													<label><p>Número de Traslado*:</p></label>
												</div>
												<div class="input-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<input id="MODAL_TXT_NUMERO_TRASLADO" name="MODAL_TXT_NUMERO_TRASLADO" class="form-control required" type="text" onkeyup="this.value=this.value.replace(/[^\d]+/,'')" maxlength="10" required>
													<span class="input-group-btn"><input id="MODAL_BT_SIN_NUMERO_TRASLADO" type="button" value="S/E" class="btn btn-success form-control"></span>
												</div>
											</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 custom-border">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%">
												<label><p>Descripcion*:</p></label>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<textarea id="MODAL_TXT_DESCRIPCION" name="MODAL_TXT_DESCRIPCION" class="form-control required" type="text" rows="3" maxlength="500" required></textarea>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%">
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
													<label><p>Valor Unitario Inicial:</p></label>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<input id="MODAL_TXT_VALOR_INICIAL" name="MODAL_TXT_VALOR_INICIAL" value="0" class="form-control change-event" type="text">
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%">
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
													<label><p>Placa*:</p></label>
												</div>
												<div class="input-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<input id="MODAL_TXT_PLACA" name="MODAL_TXT_PLACA" class="form-control required" type="text" onkeyup="this.value=this.value.replace(/[^\d]+/,'')" maxlength="10" required>
													<span class="input-group-btn"><input id="MODAL_BT_SIN_PLACA" type="button" value="S/P" class="btn btn-success form-control"></span>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 botom-border">
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-md-offset-5" style="padding:1%">
												<input class="btn btn-primary form-control" type="submit" value="GUARDAR">
											</div>
										</div>
									</div>
								</div>

							</center>				
						</div>
					</form>
				</div>       
			</div>

		</div>
	</div>

	<div id="modal-observaciones" class="modal fade" style="font-size: 14px;"  tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="h4-edit">OBSERVACIONES</h4>
				</div>
				<div class="modal-body row" style="margin: 10px">
					<div id="cabecera" style="font-size: 16px; background-color: #007076; color: rgb(255,255,255);"></div>
					<ul class="nav nav-tabs">
						<li style="width: 10em" id="ver-historial" class="active"><a data-toggle="tab" href="#tabla">Historial</a></li>
						<li style="width: 10em" id="ver-agregar"><a data-toggle="tab" href="#agregar-observacion">Agregar</a></li>
					</ul>
					<div class="tab-content">
						<div id="tabla" class="tab-pane fade in active">
							<table id="tabla-observaciones" class="table table-striped table-bordered table-hover" style="width:100%">
								<thead>
									<tr class="theader">
										<th>Observación</th>
										<th>Estado</th>
										<th>Fecha</th>
										<th>Usuario</th>
										<th>Opciones</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
						<div id="agregar-observacion" class="col-md-8 col-md-offset-2 tab-pane fade">
							<br>
							<div><label>Observación:</label></div>
							<form id="FM-OBSERVACION" name="FM-OBSERVACION">
								<textarea id="TXT_OBSERVACION" name="TXT_OBSERVACION" class="form-control" rows="3" required></textarea>
								<br>
								<select id="SL_Estado_Observacion" name="SL_Estado_Observacion" class="form-control selectpicker required" title="Seleccione un estado..." required>
								</select>
								<hr>
								<div><center><input type="submit" class="btn btn-primary" value="Guardar Observación"></center></div>
							</form>
						</div>
					</div>
				</div>
			</div>       
		</div>
	</div>
	<div id="modal-traslados" class="modal fade" style="font-size: 14px;"  tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="h4-traslado">SOLICITUD DE TRASLADO</h4>
				</div>
				<div class="modal-body row" style="margin: 10px">
					<div id="cabecera-traslado" style="font-size: 16px; background-color: #007076; color: rgb(255,255,255);"></div>
					<ul class="nav nav-tabs">
						<li style="width: 10em" class="active"><a id="ver-historial-traslados" data-toggle="tab" href="#div-tabla-traslados">Historial</a></li>
						<li style="width: 10em"><a id="ver-agregar-traslado" data-toggle="tab" href="#agregar-traslado">Solicitar</a></li>
					</ul>
					<div class="tab-content">
						<div id="div-tabla-traslados" class="tab-pane fade in active">
							<table id="tabla-traslados" class="table table-striped table-bordered table-hover" style="width:100%">
								<thead>
									<tr class="theader">
										<th>Tipo</th>
										<th>Origen</th>
										<th>Destino</th>
										<th>#</th>
										<th>Argumento</th>
										<th>Fecha</th>
										<th>Solicitante</th>
										<th>Estado</th>
										<th>Revisión</th>
										<th>Usuario</th>
										<th>Opciones</th>
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
									<select id="MODAL_SL_DESTINO" name="MODAL_SL_DESTINO" class="form-control selectpicker" data-live-search="true"" title="Seleccione el Destino" required>
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
	
	<div class="modal fade" id="modal_observar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<form id="FM-REVISAR" name="FM-REVISAR">
						<textarea id="TXT_OBSERVACION_TRASLADO" name="TXT_OBSERVACION_TRASLADO" class="form-control" rows="5" placeholder="Ingrese su observación aquí." required></textarea>
						<br>
						<hr>
						<div id="div-revision-traslado" class="row">
							<div class="col-md-12">
								<div class="col-md-6">
									<label class="form-control">Aprobar Traslado? </label>
								</div>
								<div class="col-md-1">
									<input id="check-revisar" name="check-revisar" type='checkbox' class='form-control'>
								</div>
							</div>
							<div class="col-md-12">
								<center>
									<input id="BT_GUARDAR_REVISION" name="BT_GUARDAR_REVISION" type="submit" class="btn btn-primary" value="Guardar Revisión">
								</center>
							</div>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="modal_info_complementaria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<form id="FM-INFO_COMPLEMENTARIA" name="FM-INFO_COMPLEMENTARIA">
						<div class="col-md-12">
							<div class="col-md-6" style="text-align: right;">
								<label>Número de Traslado</label>
							</div>
							<div class="col-md-6">
								<input type="number" step="1" id="TXT_NUMERO_TRASLADO" name="TXT_NUMERO_TRASLADO" class="form-control"><br>
							</div>
						</div>
						<div class="col-md-12">
							<div class="col-md-6" style="text-align: right;">
								<label>Fecha de Traslado</label>
							</div>
							<div class="input-group col-lg-6">
								<input class="form-control readonly" name="DT_FECHA_TRASLADO" id="DT_FECHA_TRASLADO" step="1" required>
								<span class="input-group-btn">
									<input class="btn btn-danger" type="button" id="sin-fecha" value="X" title="Desconocida">
								</span>
							</div><br>
							<!-- <input type="text" id="DT_FECHA_TRASLADO" name="DT_FECHA_TRASLADO" class="form-control readonly"><br>							 -->
						</div>
						<div class="col-md-12">
							<div class="col-md-6" style="text-align: right;">
								<label>Consecutivo de Salida</label>
							</div>
							<div class="col-md-6">
								<input type="number" step="1" id="TXT_CONSECUTIVO_SALIDA" name="TXT_CONSECUTIVO_SALIDA" class="form-control"><br>
							</div>
						</div>
						<hr>
						<div><center><input id="BT_ACTUALIZAR_INFO_COMPLEMENTARIA" name="BT_ACTUALIZAR_INFO_COMPLEMENTARIA" type="submit" class="btn btn-primary" value="Actualizar Información"></center></div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div id="modal-asignaciones" class="modal fade" style="font-size: 14px;"  tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="h4-asignacion">ASIGNACIÓN DE INVENTARIO A CONTRATISTAS</h4>
				</div>
				<div class="modal-body row" style="margin: 10px">
					<div id="cabecera-asignacion" style="font-size: 16px; background-color: #007076; color: rgb(255,255,255);"></div>
					<div id="NUEVA_ASIGNACION" name="NUEVA_ASIGNACION" class="col-md-8 col-md-offset-2" style="border-style: inset; padding: 5px; background-color: #ccc; padding: 3%;" hidden>
						<H4>Nueva asignación de Inventario</H4>
						<hr>
						<form id="FM_ASIGNAR_INVENTARIO" name="FM_ASIGNAR_INVENTARIO">
							<div class="col-md-4">
								<select id="SL_CONTRATISTA" name="SL_CONTRATISTA" title="SELECCIONE UN CONTRATISTA" class="selectpicker show-tick form-control" data-live-search="true" required></select>	
							</div>
							<div class="col-md-2">
								<input id="TB_FECHA_RECBE" name="TB_FECHA_RECBE" class="form-control datepicker readonly" required/>
							</div>
							<div class="col-md-2">
								<button id="BT_ASIGNAR_CONTRATISTA" name="BT_ASIGNAR_CONTRATISTA" class="btn-success form-control" type="submit">ASIGNAR</button>
							</div>
						</form>
					</div>
					<div><button class="btn btn-success pull-right" id="BT_NUEVA_ASIGNACION" name="BT_NUEVA_ASIGNACION"><span class="glyphicon glyphicon-plus"></span> Nueva asignación</button></div>
					<div id="div-tabla-asignaciones" class="tab-pane fade in active">
						<table id="tabla-asignaciones" class="table table-striped table-bordered table-hover" style="width:100%">
							<thead>
								<tr class="theader">
									<th>Contratista</th>
									<th>Fecha Recibe</th>
									<th>Fecha Entrega</th>
									<th>Fecha de Asignación</th>
									<th>Usuario</th>
									<th>Opciones</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>       
			</div>
		</div>
	</div>

	<div id="modal-registro-fotografico" class="modal fade" style="font-size: 14px;"  tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content" style="background-color: #2d2f2f;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white">x</button>
					<h4 class="modal-title" id="h4-registro-fotografico" style="color: white;">REGISTRO FOTOGRÁFICO</h4>
					<button class="btn btn-success pull-right" id="BT_SUBIR_FOTOS" name="BT_SUBIR_FOTOS"><span class="glyphicon glyphicon-plus"></span> Subir Registro Fotográfico</button>
				</div>
				<div class="modal-body row" style="margin: 0px; padding: 10px;">
					<div id="cabecera-registro-fotografico" style="font-size: 16px; background-color: #007076; color: rgb(255,255,255);"></div>
					<div id="div_subir_fotos" name="div_subir_fotos" class="col-md-8 col-md-offset-2" hidden>
						<form id="FM_REGISTRO_FOTOGRAFICO" name="FM_REGISTRO_FOTOGRAFICO" enctype="multipart/form-data">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<input type="file" multiple class="btn btn-success filestyle" id="REGISTRO_FOTOGRAFICO_1" name="REGISTRO_FOTOGRAFICO_1[]" data-btnClass='btn-success' runat='server' data-text='Fotografía(s)'>
							</div>
							<div id="div_archivos_adjuntos" name="div_archivos_adjuntos" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="color:white;">
									<h4>Se subirán los siguientes archivos:</h4>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3" style="padding-top: 10px;">
								<button id="BT_GUARDAR_REGISTRO_FOTOGRAFICO" name="BT_GUARDAR_REGISTRO_FOTOGRAFICO" class="btn-success form-control" type="submit">GUARDAR</button>
							</div>
						</form>
					</div>
					<div></div>
					<div id="div-slider-registro-fotografico" name="div-slider-registro-fotografico" class="tab-pane fade in active col-xs-12 col-sm-12 col-md-12 col-lg-12">
					</div>
				</div>       
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal_enviando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<img src="../imagenes/enviando.gif" width="100%">      
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="../bower_components/jszip/dist/jszip.min.js"></script> 
	<script src="../bower_components/pdfmake/build/pdfmake.min.js"></script> 
	<script src="../bower_components/pdfmake/build/vfs_fonts.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	</html>
	<?php }  ?>