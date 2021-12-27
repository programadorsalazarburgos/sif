<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Administrar Beneficiario</title>

	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>  

	<link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 

	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
	
	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>  

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >  
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>
	
	<script type="text/javascript" src="../LibreriasExternas/jquery.validate.min.js"></script>	
	<script src="Js/AdministrarBeneficiario.js?v=2021.02.19.4"></script>
	<style type="text/css">
	.divider{
		margin-bottom: 10px;
		padding: 5px;
	}
</style>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de Beneficiarios<small></small></h1>
				</div>
			</div>
			<div class="panel-body">
				<div id="div_busqueda_estudiante">
					<div class="row">
						<div class="col-xs-12 col-md-12 alert alert-warning">
							<p class="text-center">
								<b>Atención. </b>Realice la busqueda del Beneficiario que desea modificar utilizando el número de documento o su nombre.
							</p>
						</div>
					</div>
					<div class='row'>
						<div class='col-xs-12 col-md-12'>
							<p class="alert alert-info">
								<span id="p_mensaje">Escriba el <i><u>número de documento</u></i> ó el nombre del Beneficiario (<i><u>Por lo menos Primer Apellido</u></i>). Para agilizar la consulta suministre el <b>nombre completo</b> del Beneficiario.</span>
								<input data-toggle="toggle" data-onstyle="success" id="CH_tipo_consulta_estudiante" name= "CH_tipo_consulta_estudiante" data-offstyle="info" data-width="200" data-on="NOMBRES" data-off="NÚMERO DOCUMENTO" type="checkbox">
							</p>
						</div>
					</div>
					<div class='row'>
						<div id="div_campo_busqueda_documento">
							<div class='col-xs-12 col-md-10 col-md-offset-1'>
								<div class="form-group col-xs-12">
									<div class='input-group'>
										<span class='input-group-addon' id='basic-addon_buscar_esutudiante'><span class='fa fa-user' aria-hidden='true'></span></span>
										<input class='form-control buscar_beneficiario' aria-describedby='basic-addon1' placeholder='Número de Identificación' name='nro_documento' id="nro_documento" type='text'>
									</div>
								</div>
							</div>
						</div>   
						<div id="div_campo_busqueda_nombres">
							<div class="col-xs-12 col-md-10 col-md-offset-1">
								<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
										<input class="mayuscula buscar_beneficiario tecleable form-control" tabindex="1" placeholder="Primer Apellido" name="apellido1" id="apellido1" type="text"  />
									</div>
								</div>
								<div class="form-group col-xs-12 col-sm-12 col-md-6  col-lg-6">
									<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
										<input class="mayuscula buscar_beneficiario tecleable form-control" tabindex="1" placeholder="Segundo Apellido" name="apellido2" id="apellido2"  type="text"/>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-md-10 col-md-offset-1">
								<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
										<input class="mayuscula buscar_beneficiario tecleable form-control" tabindex="3" placeholder="Primer Nombre" name="nombre1" id="nombre1" type="text"  />
									</div>
								</div>
								<div class="form-group col-xs-12 col-sm-12 col-md-6  col-lg-6">
									<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
										<input class="mayuscula buscar_beneficiario tecleable form-control" tabindex="4" placeholder="Segundo Nombre" name="nombre2" id="nombre2"  type="text"/>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-10 col-md-offset-1">
							<div class="form-group col-xs-12">
								<button type="submit" id="BT_buscar_estudiante"  class="btn btn-success col-xs-12">Buscar</button>
							</div>
						</div>
					</div>
				</div>
				<div id="div_table_estudiante" class="table-responsive">
					<table id="table_estudiante" class="table table-bordered">
						<thead>
							<tr>
								<th>Identificación</th>
								<th>Nombre</th>
								<th>Colegio</th>
								<th>Grado</th>
								<th>Opciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div id="div_datos_estudiante_seleccionado">
					<div class="row form-group">
						<div class="col-xs-12 col-md-12">
							Actualmente esta administrando la información del Beneficiario: <label id="L_Nombre_Estudiante"></label> con número de documento: <label id="L_Numero_Documento"></label>.
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<a href="#" id="BT_buscar_otro_beneficiario" class="btn btn-warning form-control">Clic aquí para cambiar o buscar otro Beneficiario</a>
						</div>
					</div>
				</div>
				<ul class="nav nav-tabs" id="pestanas_acciones_beneficiario" role="tablist">
					<li class="nav-item"><a id="consultar_datos_basicos" class="nav-link" data-toggle="tab" href="#panel_datos_basicos_beneficiario">Datos Básicos (Información personal)</a></li>
					<li class="nav-item"><a id="consultar_detalle_anio" class="nav-link" data-toggle="tab" href="#panel_datos_detalle_anio_beneficiario">Histórico datos adicionales (Por año)</a></li>
					<li class="nav-item"><a id="nav_modificar_estudiante" class="nav-link" data-toggle="tab" href="#panel_modificar_estudiante">Actualizar datos adicionales año <?php echo date("Y")?></a></li>
					<li class="nav-item"><a id="consultar_archivos" class="nav-link" data-toggle="tab" href="#panel_datos_archivos_beneficiario">Histórico Documentos subidos (Por año)</a></li>
					<li class="nav-item"><a id="nav_modificar_documentos" class="nav-link" data-toggle="tab" href="#panel_modificar_documentos">Actualizar documentos año <?php echo date("Y")?></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="panel_modificar_estudiante">
						<div id="div_edicion_estudiante">
							<hr />
							<form id="form_edicion_detalle">
								<div class="panel panel-danger panel-fluid">
									<div class="panel-heading text-center" style="background-color: #227a94 !important;  border-color: #227a94 !important; padding: 3px;">
										<h4>Edición detalle de Beneficiario año <?php echo date("Y")?></h4>
									</div>
									<div class="panel-body">
										<div class="panel-heading text-center divider" style="background-color: #31b0d5 !important;border-color: #1b6d85 !important;">
											<center>Datos Generales</center>
										</div>
										<div class="row form-group">
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_grupo_poblacional">Grupo Poblacional: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione un grupo poblacional" required name="SL_grupo_poblacional" id="SL_grupo_poblacional" class="form-control selectpicker" data-live-search="true"></select>
												<span class="help-block" id="error"></span>
											</div>
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_etnia">Etnia: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione una etnia" required name="SL_etnia" id="SL_etnia" class="form-control selectpicker" data-live-search="true"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_tipo_discapacidad">Tipo de discapacidad: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione un tipo de discapacidad" required name="SL_tipo_discapacidad" id="SL_tipo_discapacidad" class="form-control selectpicker" data-live-search="true"></select>
												<span class="help-block" id="error"></span>
											</div>
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_tipo_poblacion_victima">Tipo Población Victima: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione una tipo de población victima" required name="SL_tipo_poblacion_victima" id="SL_tipo_poblacion_victima" class="form-control selectpicker" data-live-search="true"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_estrato">Estrato: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione un estrato" required name="SL_estrato" id="SL_estrato" class="form-control selectpicker" data-live-search="true">
													<option value="0">0</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
												</select>
												<span class="help-block" id="error"></span>
											</div>
											
										</div>
										<div class="panel-heading text-center divider" style="background-color: #31b0d5 !important;border-color: #1b6d85 !important;">
											<center>Salud</center>
										</div>
										<div class="row form-group">
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_tipo_afiliacion">Tipo Afiliación: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select class="form-control selectpicker" id="SL_tipo_afiliacion" data-live-search="true">
													<option value="">Ninguna</option>
													<option value="1">Contributivo</option>
													<option value="2">Subsidiado</option>
												</select>
												<span class="help-block" id="error"></span>
											</div>
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_eps">EPS: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione una EPS" required="required" name="SL_eps" id="SL_eps" class="form-control selectpicker" data-live-search="true"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_grupo_sanguineo">Grupo Sanguineo: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione un grupo sanguineo" required name="SL_grupo_sanguineo" id="SL_grupo_sanguineo" class="form-control selectpicker" data-live-search="true"></select>
												<span class="help-block" id="error"></span>
											</div>
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="TX_enfermedades">Enfermedades: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<textarea rows = "2" type="text" class="form-control" name="TX_enfermedades" id="TX_enfermedades" placeholder="Enfermedades"></textarea>
											</div>
										</div>
										<div class="panel-heading text-center divider" style="background-color: #31b0d5 !important;border-color: #1b6d85 !important;">
											<center>Infomación Académica</center>
										</div>
										<div class="row form-group">
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_crea">CREA: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione un CREA" required name="SL_crea" id="SL_crea" class="form-control selectpicker" data-live-search="true"></select>
												<span class="help-block" id="error"></span>
											</div>
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_colegio">Colegio: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione un colegio" required name="SL_colegio" id="SL_colegio" class="form-control selectpicker" data-live-search="true"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_jornada">Jornada (Arte en la Escuela): </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione una jornada" name="SL_jornada" id="SL_jornada" class="form-control selectpicker" data-live-search="true"></select>
												<span class="help-block" id="error"></span>
											</div>
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_grado">Grado: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione un grado" name="SL_grado" id="SL_grado" class="form-control selectpicker" data-live-search="true"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="panel-heading text-center divider" style="background-color: #31b0d5 !important;border-color: #1b6d85 !important;">
											<center>Información del Acudiente</center>
										</div>
										<div class="row form-group">
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="TX_nombre_acudiente">Nombre Acudiente: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<input type="text" class="form-control" name="TX_nombre_acudiente" id="TX_nombre_acudiente" placeholder="Nombre Acudiente" />
												<span class="help-block" id="error"></span>
											</div>
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="TX_identificacion_acudiente">Identificación Acudiente: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<input type="text" class="form-control" name="TX_identificacion_acudiente" id="TX_identificacion_acudiente" placeholder="Identificación Acudiente" />
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="TX_telefono_acudiente">Celular ó Teléfono Acudiente: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<input type="text" class="form-control" name="TX_telefono_acudiente" id="TX_telefono_acudiente" placeholder="Telefono Acudiente" />
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="panel-heading text-center divider" style="background-color: #31b0d5 !important;border-color: #1b6d85 !important;">
											<center>Georeferenciación del Beneficiario</center>
										</div>
										<div class="row form-group">
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="SL_localidad">Localidad: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<select title="Seleccione una Localidad" required name="SL_localidad" id="SL_localidad" class="form-control selectpicker" data-live-search="true"></select>
												<span class="help-block" id="error"></span>
											</div>
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="TX_barrio">Barrio: </label>
											</div>
											<div class="col-xs-12 col-md-4">
												<input type="text" class="form-control" name="TX_barrio" id="TX_barrio" placeholder="Barrio" />
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="panel-heading text-center divider" style="background-color: #31b0d5 !important;border-color: #1b6d85 !important;">
											<center>Observaciones del Beneficiario</center>
										</div>
										<div class="row form-group">
											<div class="col-xs-6 col-md-2">
												<label class="control-label" for="TX_observaciones">Observaciones: </label>
											</div>
											<div class="col-xs-12 col-md-10">
												<textarea placeholder="Observaciones" name="TX_observaciones" id="TX_observaciones" class="form-control"></textarea>
												<span class="help-block" id="error"></span>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-3 col-md-offset-3">
										<input type="hidden" id="tipo_operacion" />
										<input type="hidden" id="id_estudiante" name="id_estudiante" />
										<input required="required"  type="submit" id="submit_form_edicion_detalle" class="form-control btn btn-success" value="Guardar Modificación">
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="tab-pane" id="panel_modificar_documentos">
						Hola
					</div>
					<div class="tab-pane" id="panel_datos_basicos_beneficiario" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="container-fluid" id="div_datos_basicos"></div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="panel_datos_archivos_beneficiario" role="tabpanel">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_anio_archivos">Año Archivos del Beneficiario</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" id="SL_anio_archivos"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="container-fluid" id="div_informacion_archivos"></div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="panel_datos_detalle_anio_beneficiario" role="tabpanel">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_anio_detalle_anio">Año Información Detallada</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" id="SL_anio_detalle_anio"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="container-fluid" id="div_informacion_detalle_anio"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<h3>Información Grupos</h3>
								<div class="container-fluid table-responsive" id="div_informacion_grupos">
									<table id="table_grupos_estudiante" class="table table-bordered">
										<thead>
											<tr>
												<th>CREA</th>
												<th>Código Grupo</th>
												<th>Formador</th>
												<th>Fecha Ingreso</th>
												<th>Usuario Ingreso</th>
												<th>Fecha Retiro</th>
												<th>Usuario Retiro</th>
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
	</div>
	<div id="modal_fecha_nacimiento" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Actualizar Fecha</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="TB_fecha_nacimiento">Fecha Nacimiento</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<div class="input-group date">
								<input type="text" id="TB_fecha_nacimiento" readonly="readonly" class="form-control">
								<div class="input-group-addon" id="SPAN_fecha_nacimiento">
									<span class="glyphicon glyphicon-calendar"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" id="BT_actualizar_fecha_nacimiento" data-dismiss="modal">Guardar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
</body>
</html>