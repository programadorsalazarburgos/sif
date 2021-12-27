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
	<title>Administración de Colegios - Convenio SED</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="Js/Administrar_Colegios.js?v=2021.06.3.5"></script>
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
	<script src="../../bower_components/jszip/dist/jszip.min.js" type="text/javascript" ></script>
	<script src="../../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

<script src="../../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de Colegios - Convenio SED</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#colegios_sed" role="tab">Administración</a></li>
				</ul>
				<div class="tab-content">

					<div class="tab-pane active" id="colegios_sed" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>Listado colegios</h4>
							</div>
						</div>
						<br><br>
						<div class="row">
							<div class='col-xs-12 col-md-6 col-lg-6'>
							</div>
							<div class='col-xs-12 col-md-6 col-lg-6'>
							<button class="btn btn-block btn-success" id="btn-crear-colegios" data-toggle='modal' data-target='#miModalCrearColegio'>REGISTRAR UN NUEVO COLEGIO</button>
							</div>
						</div>
						<br><br>							
						<div class="row">
							<div class='col-xs-12 col-md-12'>
								<table id="table_lugares_nidos" class="table table-striped table-bordered table-hover"  width="100%">
									<thead>
										<tr>
											<td class="text-center"><strong>Localidad</strong></td>
											<td class="text-center"><strong>Upz</strong></td>
											<td class="text-center"><strong>Dirección</strong></td>
											<td class="text-center"><strong>Colegio</strong></td>
											<td class="text-center"><strong>Acciones</strong></td>
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

	<div class="modal fade" id="miModalCrearColegio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">CREACIÓN DE COLEGIOS - CONVENIO SED</h4>
				</div>
				<div class="modal-body">
				<form id="form_nuevo_lugar_nidos">
								<div class="form-group">
									<label class="col-md-4" for="SL_Localidad">Localidad:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" data-live-search="true" name="SL_Localidad" id="SL_Localidad" title="Seleccione una localidad"></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="SL_Upz">Upz:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" data-live-search="true" name="SL_Upz" id="SL_Upz" title="Seleccione una upz"></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="TX_Barrio">Barrio:</label>
									<div class="col-md-8">
										<input type="text" class="form-control mayuscula" placeholder="Barrio" id="TX_Barrio" name="TX_Barrio">
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="SL_Entidad">Entidad:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" data-live-search="true" name="SL_Entidad" id="SL_Entidad" title="Seleccione una entidad"></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="SL_TLugar">Tipo de Lugar:</label>
									<div class="col-md-8">
										<select class="form-control selectpicker" data-live-search="true" name="SL_TLugar" id="SL_TLugar" title="Seleccione un tipo de lugar"></select>
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="TX_NombreLugar">Nombre del Lugar:</label>
									<div class="col-md-8">
										<input type="text" required="required" class="form-control mayuscula" placeholder="Nombre Lugar" id="TX_NombreLugar" name="TX_NombreLugar">
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="TX_Direccion">Dirección del Lugar:</label>
									<div class="col-md-8">
										<input type="text" class="form-control mayuscula" placeholder="Dirección" id="TX_Direccion" name="TX_Direccion">
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="TX_Telefono">Teléfono del Lugar:</label>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="Teléfono" id="TX_Telefono" name="TX_Telefono">
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="TX_Coordinador">Coordinador(a):</label>
									<div class="col-md-8">
										<input type="text" class="form-control mayuscula" placeholder="Coordinador (A)" id="TX_Coordinador" name="TX_Coordinador">
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="TX_EMail">E-Mail:</label>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="E-Mail" id="TX_EMail" name="TX_EMail">
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4" for="TX_CelularRespon">Celular:</label>
									<div class="col-md-8">
										<input type="text" class="form-control" placeholder="Télefono Responsable" id="TX_CelularRespon" name="TX_CelularRespon">
										<span class="help-block" id="error"></span>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
										<input class="form-control btn btn-primary" id="BT_guardar_lugar" type="submit" value="Guardar Lugar de Atención">
									</div>
								</div>
							</fieldset>
						</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="miModalActivacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">ACTIVACIÓN LUGAR DE ATENCIÓN</h4>
				</div>
				<div class="modal-body">
					<form id="form_modificar_lugar_div">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								Por medio de este formulario usted podrá activar y actualizar los datos del lugar de atención.
								<br>
								<input type="text" hidden="hidden" id="TX_lugar_Modificar_Div" name="TX_lugar_Modificar_Div">
							</div>
						</div>
						<br><br>
						<div class="form-group">
							<label class="col-md-3" for="SL_Localidad_Div">Localidad:</label>
							<div class="col-md-9">
								<select class="form-control selectpicker" data-live-search="true" name="SL_Localidad_Div" id="SL_Localidad_Div"></select>
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="SL_Upz_Div">Upz:</label>
							<div class="col-md-9">
								<select class="form-control selectpicker" data-live-search="true" name="SL_Upz_Div" id="SL_Upz_Div"></select>
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="TX_Barrio">Barrio:</label>
							<div class="col-md-9">
								<input type="text" class="form-control mayuscula" placeholder="Barrio" id="TX_Barrio_Div" name="TX_Barrio_Div">
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="SL_Entidad_Div">Entidad:</label>
							<div class="col-md-9">
								<select class="form-control selectpicker" data-live-search="true" name="SL_Entidad_Div" id="SL_Entidad_Div" title="Seleccione una entidad"></select>
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="SL_TLugar">Tipo de Lugar:</label>
							<div class="col-md-9">
                <select class="form-control selectpicker" data-live-search="true" name="SL_TLugar_Div" id="SL_TLugar_Div" title="Seleccione un tipo lugar"></select>
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="TX_NombreLugar">Nombre:</label>
							<div class="col-md-9">
								<input type="text" required="required" class="form-control mayuscula" placeholder="Nombre Lugar" id="TX_NombreLugar_Div" name="TX_NombreLugar_Div">
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="TX_Direccion">Dirección:</label>
							<div class="col-md-9">
								<input type="text" class="form-control mayuscula" placeholder="Dirección" id="TX_Direccion_Div" name="TX_Direccion_Div">
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="TX_Telefono">Teléfono:</label>
							<div class="col-md-9">
								<input type="text" class="form-control" placeholder="Teléfono" id="TX_Telefono_Div" name="TX_Telefono_Div">
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="TX_Coordinador">Coordinador(a):</label>
							<div class="col-md-9">
								<input type="text" class="form-control mayuscula" placeholder="Coordinador (A)" id="TX_Coordinador_Div" name="TX_Coordinador_Div">
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="TX_EMail">E-Mail:</label>
							<div class="col-md-9">
								<input type="text" class="form-control" placeholder="E-Mail" id="TX_EMail_Div" name="TX_EMail_Div">
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3" for="TX_CelularRespon">Celular:</label>
							<div class="col-md-9">
								<input type="text" class="form-control" placeholder="Télefono Responsable" id="TX_CelularRespon_Div" name="TX_CelularRespon_Div">
								<span class="help-block" id="error"></span>
							</div>
						</div>
						<div class="row" style="text-align: center">
							<div class="form-group">
								<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4"  style="text-align: center">
								<input class="form-control btn btn-block btn-success" id="BT_eliminar_lugar" type="submit" value="ACTIVAR">
							</div>

							<div class="col-xs-6 col-sm-6 col-md-4"  style="text-align: center">
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
</body>
</html>
