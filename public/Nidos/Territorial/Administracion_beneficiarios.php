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
	<title>Modificación datos beneficiarios</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Administracion_beneficiarios.js?v=1.7.1.1"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<link href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

	<script src="../../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>

	<script src="../../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

</head>
<body>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de beneficiarios</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#modificacion_datos_beneficiarios" role="tab">Datos beneficiarios</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="modificacion_datos_beneficiarios" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>Búsqueda beneficiario</h4>
							</div>
						</div>
						<br>
						<div class="row">
						</div>
						<div class="col-xs-12 col-md-12 bg-warning">
							<p></p>
							<p><strong>Recuerde que: </strong>Puede buscar a un beneficiario por el número de documento, por los nombres o por los apellidos.</p>
						</div>
						<br>
						<br>
						<br>
						<form id="busqueda_beneficiarios">
							<div class="row">
								<div class="col-xs-12 col-md-12">
									<div class="input-group">
										<input class="form-control" type="text" name="TX_Busqueda_Beneficiario" id="TX_Busqueda_Beneficiario" placeholder="Número de documento, nombres o apellidos">
										<span class="input-group-btn"><button class="btn btn-info" id="BT_Buscar_Beneficiario"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></span>
									</div>
								</div>
							</div>
						</form>
						<br>
						<div class="table-responsive" id="info_basica" style="display: none">
							<table id="table_datos_basicos" class="table table-striped table-bordered table-hover" class="display" style="width:100%">
								<thead>
									<tr>
										<th><center>Identificación</center></th>
										<th><center>Nombre</center></th>
										<th><center>Modificar</center></th>
										<th><center>Histórico</center></th>
										<th><center>Uso de imagen</center></th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<div id="info_detallada" style="display: none">
							<form id="form_modificar_beneficiario">
								<fieldset>
									<legend>
										<div class="col-md-4 col-sm-2 col-xs-2">
											<a href="#" class="regresar" style="color: #333; text-decoration: none;">
												<i class="fas fa-arrow-left fa-2x"><p style="font-size: 12px;">Regresar</p></i>
											</a>
										</div>
										<div class="col-md-4 col-sm-8 col-xs-8 text-center"><br>Datos del beneficiario</div>
									</legend>
									<div class="col-lg-12">
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="TX_Identificacion">Número de identificación</label>
												<input type="text" readonly="readonly" class="form-control" id="TX_Identificacion" name="TX_Identificacion">
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="SL_Tipo_Documento">Tipo de documento</label>
												<select class="form-control selectpicker" data-live-search="true" id="SL_Tipo_Documento" name="SL_Tipo_Documento" title="Tipo de documento"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="TX_P_Nombre">Primer nombre</label>
												<input type="text" class="form-control mayuscula" id="TX_P_Nombre" name="TX_P_Nombre" placeholder="Primer nombre">
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="TX_S_Nombre">Segundo nombre</label>
												<input type="text" class="form-control mayuscula" id="TX_S_Nombre" name="TX_S_Nombre" placeholder="Segundo nombre">
												<span class="help-block" id="error"></span>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="TX_P_Apellido">Primer apellido</label>
												<input type="text" class="form-control mayuscula" id="TX_P_Apellido" name="TX_P_Apellido" placeholder="Primer apellido">
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="TX_S_Apellido">Segundo apellido</label>
												<input type="text" class="form-control mayuscula" id="TX_S_Apellido" name="TX_S_Apellido" placeholder="Segundo apellido">
												<span class="help-block" id="error"></span>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="TX_F_Nacimiento">Fecha de nacimiento</label>
												<div class="input-group date">
													<input type="text" readonly="readonly" class="form-control" id="TX_F_Nacimiento" name="TX_F_Nacimiento" placeholder="Fecha de nacimiento">
													<div class="input-group-addon">
														<span class="glyphicon glyphicon-calendar"></span>
													</div>
												</div>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="SL_Genero">Género</label>
												<select class="form-control selectpicker" data-live-search="true" id="SL_Genero" name="SL_Genero" title="Género"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="SL_Etnia">Enfoque diferencial</label>
												<select class="form-control selectpicker" data-live-search="true" id="SL_Etnia" name="SL_Etnia" title="Enfoque diferencial"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-6 col-md-6">
											<div class="form-group ">
												<label for="SL_Ip">Estrato</label>
												<select class="form-control selectpicker" data-live-search="true" id="SL_Ip" name="SL_Ip" title="Estrato"></select><input type="hidden" class="form-control" id="TX_Existe_1" name="TX_Existe_1">
												<span class="help-block" id="error"></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
											<input class="form-control btn btn-primary" id="btn_modificar_beneficiario" type="submit" value="Modificar datos beneficiario">
										</div>
									</div>
								</fieldset>
							</form>
						</div>
						<div id="div-info-historico" style="display: none">
							<fieldset>
								<legend>
									<div class="col-md-4 col-sm-2 col-xs-2">
										<a href="#" class="regresar" style="color: #333; text-decoration: none;">
											<i class="fas fa-arrow-left fa-2x"><p style="font-size: 12px;">Regresar</p></i>
										</a>
									</div>
									<div class="col-md-4 col-sm-8 col-xs-8 text-center" id="div-p-historico"><br></div>
								</legend>
								<table id="tabla-historico" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th><center>Localidad</center></th>
											<th><center>Lugar de atención</center></th>
											<th><center>Grupo/evento</center></th>
											<th><center>Tipo de grupo</center></th>
											<th><center>Dupla</center></th>
											<th><center>Fecha atención</center></th>
											<th><center>Asistencia</center></th>											
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
