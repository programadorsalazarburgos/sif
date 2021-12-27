<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else {
	$Id_Persona= $_SESSION["session_username"];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reporte de Casos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" rel="stylesheet">
	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../css/material-desing.css">
	<link href="../bower_components/summernote/dist/summernote.css" rel="stylesheet">
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
	<link rel="stylesheet" type="text/css" href="Css/reporteCasos.css">
	<link href="bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script src="../bower_components/summernote/dist/summernote.min.js"></script>
	<script src="../bower_components/summernote/dist/lang/summernote-es-ES.js"></script>
	<script type="text/javascript" src="Js/ReporteCasos.js?v=2020.03.04.5"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Reporte de Casos<small> - Psicosocial</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a id="nav_reportar_caso" class="nav-link" data-toggle="tab" href="#panel_reportar_caso" role="tab">Reportar Caso</a></li>
					<li class="nav-item"><a id="nav_consultar" class="nav-link" data-toggle="tab" href="#panel_consultar">Casos reportados</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="panel_reportar_caso" role="tabpanel">
						<form id="form_nuevo_reporte_de_caso" style="">
							<div class="row">
								<legend class="col-md-8 col-md-offset-2"> <h3><i class="fas fa-caret-right"></i> <strong>1. DATOS GENERALES</h3></strong></legend>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-1 col-md-offset-2" style="padding-top: 0.5vh">
									<label for="SL_crea" class="pull-right">CREA:</label>
								</div>
								<div class="col-xs-6 col-md-2">
									<select class="form-control selectpicker" title="Seleccione" name="SL_crea" id="SL_crea" data-live-search="true" required="required"></select>
								</div>
								<div class="col-xs-6 col-md-1" style="padding-top: 0.5vh">
									<label for="SL_Grupo" class="pull-right">GRUPO:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<select class="form-control selectpicker" title="Seleccione" name="SL_Grupo" id="SL_Grupo" data-live-search="true" required="required"></select>
								</div>
								<div class="col-xs-6 col-md-1" style="padding-top: 0.5vh">
									<label for="SL_Beneficiario" class="pull-right">BENEFICIARIO:</label>
								</div>
								<div class="col-xs-6 col-md-2">
									<select class="form-control selectpicker" title="Seleccione" name="SL_Beneficiario" id="SL_Beneficiario" data-live-search="true" required="required"></select>
								</div>
							</div>
							<div class="row" style="padding-top: 1vh; padding-bottom: 2vh">
								<div class="col-xs-6 col-md-1 col-md-offset-2" style="padding-top: 0.5vh">
									<label class="pull-right">COLEGIO:</label>
								</div>
								<div class="col-xs-6 col-md-2">
									<select class="form-control selectpicker required" data-live-search="true" name="SL_Colegio" id="SL_Colegio" title="Seleccione">
									</select>
								</div>
								<div class="col-xs-6 col-md-1" style="padding-top: 0.5vh">
									<label class="pull-right">GRADO:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<select class="form-control selectpicker required" data-live-search="true" name="SL_Grado" id="SL_Grado" title="Seleccione">
									</select>
								</div>
								<div class="col-xs-6 col-md-1" style="padding-top: 0.5vh">
									<label class="pull-right">JORNADA:</label>
								</div>
								<div class="col-xs-6 col-md-2">
									<select class="form-control selectpicker required" data-live-search="true" name="SL_Jornada" id="SL_Jornada" title="Seleccione">
									</select>
								</div>
							</div>
							<div class="row">
								<legend class="col-md-8 col-md-offset-2"> <h3><i class="fas fa-caret-right"></i> <strong>2. DATOS DEL BENEFICIARIO</h3></strong></legend>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-1 col-md-offset-2" style="padding-top: 0.5vh">
									<label for="TX_Primer_Apellido" class="pull-right">Primer Apellido:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<input type="text" class="form-control required" name="TX_Primer_Apellido" id="TX_Primer_Apellido" placeholder="P. Apellido" />
								</div>
								<div class="col-xs-6 col-md-1" style="padding-top: 0.5vh">
									<label for="TX_Segundo_Apellido" class="pull-right">Segundo Apellido:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<input type="text" class="form-control" name="TX_Segundo_Apellido" id="TX_Segundo_Apellido" placeholder="S. Apellido" />
								</div>
								<div class="col-xs-6 col-md-1" style="padding-top: 0.5vh">
									<label for="TX_Primer_Nombre" class="pull-right">Primer Nombre:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<input type="text" class="form-control required" name="TX_Primer_Nombre" id="TX_Primer_Nombre" placeholder="P. Nombre" />
								</div>
								<div class="col-xs-6 col-md-1" style="padding-top: 0.5vh">
									<label for="TX_Segundo_Nombre" class="pull-right">Segundo Nombre:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<input type="text" class="form-control" name="TX_Segundo_Nombre" id="TX_Segundo_Nombre" placeholder="S. Nombre" />
								</div>
							</div>
							<div class="row" style="padding-top: 1vh;">
								<div class="col-xs-6 col-md-1 col-md-offset-2" style="padding-top: 0.5vh">
									<label for="TX_Fecha_Nacimiento" class="pull-right">Fecha Nacimiento:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<input type="text" class="form-control required" name="TX_Fecha_Nacimiento" id="TX_Fecha_Nacimiento" placeholder="Seleccione" />
								</div>
								<div class="col-xs-6 col-md-1" style="padding-top: 0.5vh">
									<label for="SL_Tipo_Documento" class="pull-right">Tipo Documento:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<select class="form-control selectpicker required" data-live-search="true" name="SL_Tipo_Documento" id="SL_Tipo_Documento" title="Seleccione">
									</select>
								</div>
								<div class="col-xs-6 col-md-1" style="padding-top: 0.5vh">
									<label for="TX_Documento" class="pull-right">Documento:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<input type="text" class="form-control required" name="TX_Documento" id="TX_Documento" placeholder="# Documento" />
								</div>
								<div class="col-xs-6 col-md-1" style="padding-top: 0.5vh">
									<label for="TX_Barrio" class="pull-right">Barrio:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<input type="text" class="form-control required" name="TX_Barrio" id="TX_Barrio" placeholder="Barrio" />
								</div>
							</div>
							<div class="row" style="padding-top: 1vh; padding-bottom: 2vh;">
								<div class="col-xs-6 col-md-2 col-md-offset-2" style="padding-top: 0.5vh">
									<label for="TX_Direccion" class="pull-right">Dirección de Contacto:</label>
								</div>
								<div class="col-xs-6 col-md-2">
									<input type="text" class="form-control required" name="TX_Direccion" id="TX_Direccion" placeholder="Dirección de Contacto" />
								</div>
								<div class="col-xs-6 col-md-2" style="padding-top: 0.5vh">
									<label for="SL_Localidad" class="pull-right">Localidad:</label>
								</div>
								<div class="col-xs-6 col-md-2">
									<select class="form-control selectpicker required" data-live-search="true" name="SL_Localidad" id="SL_Localidad" title="Seleccione">
									</select>
								</div>
							</div>
							<div class="row">
								<legend class="col-md-8 col-md-offset-2"> <h3><i class="fas fa-caret-right"></i> <strong>3. DATOS DE PROGENITORES, REPRESENTANTE LEGAL Y/O ACUDIENTE DEL BENEFICIARIO</h3></strong></legend>
							</div>
							<div class="row" style="padding-bottom: 2vh;">
								<div class="col-xs-6 col-md-1 col-md-offset-2" style="padding-top: 0.5vh">
									<label for="SL_Parentesco" class="pull-right">Parentesco:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<select class="form-control selectpicker required" data-live-search="true" name="SL_Parentesco" id="SL_Parentesco" title="Seleccione">
									</select>
								</div>
								<div class="col-xs-6 col-md-2" style="padding-top: 0.5vh">
									<label for="TX_Acudiente" class="pull-right">Nombres y Apellidos:</label>
								</div>
								<div class="col-xs-6 col-md-2">
									<input type="text" class="form-control required" name="TX_Acudiente" id="TX_Acudiente" placeholder="Nombre y Apellidos" />
								</div>
								<div class="col-xs-6 col-md-1" style="padding-top: 0.5vh">
									<label for="TX_TELEFONO" class="pull-right">Teléfono:</label>
								</div>
								<div class="col-xs-6 col-md-1">
									<input type="text" class="form-control required" name="TX_Telefono" id="TX_Telefono" placeholder="Telefono" />
								</div>
							</div>
							<div class="row">
								<legend class="col-md-8 col-md-offset-2"> <h3><i class="fas fa-caret-right"></i> <strong>4. ORIGEN DE LA SOLICITUD (QUIEN INFORMA SOBRE LA SITUACIÓN):</h3></strong></legend>
							</div>
							<div class="row">
								<div style="padding-top: 0.5vh; text-align: center; padding-bottom: 2vh;">
									<div class="btn-group btn-group-md" role="group" aria-label="Basic example">
										<button type="button" class="btn btn-secondary origen">DETECCIÓN DIRECTA</button>
										<button type="button" class="btn btn-secondary origen">PARTICIPANTE</button>
										<button type="button" class="btn btn-secondary origen">PARTICIPANTES</button>
										<button type="button" class="btn btn-secondary origen">FAMILIA</button>
										<button type="button" class="btn btn-secondary origen">OTRO</button>
									</div>
								</div>
							</div>
							<div class="row">
								<legend class="col-md-8 col-md-offset-2"> <h3><i class="fas fa-caret-right"></i> <strong>5. DESCRIPCIÓN DE LOS HECHOS</h3></strong></legend>
							</div>
							<div class="row">
								<div class="col-md-8 col-md-offset-2" style="padding-top: 0.5vh; ">
									<textarea id="TX_Descripcion" name="TX_Descripcion" rows="6"></textarea>
								</div>
							</div>
							<div class="row">
								<br>
								<div class="col-lg-2 col-md-2 col-sm-2 col-md-offset-5">
									<label style="margin-top: 8px" class="col-lg-6 text-left" id="label-state-finalizado-1">Sin Finalizar</label>
									<div style="margin-top: 8px; margin-left: 50px;" class="material-switch" data-toggle='tooltip' title="Sin Finalizar / Finalizado" data-placement="bottom" >
										<input  id="input-finalizado-1" name="input-finalizado-1"  class="checkState" type="checkbox"/>
										<label for="input-finalizado-1" class="label-success"></label>
									</div>
								</div>
								<div class="col-lg-5 col-md-5 col-sm-5 text-left">
									<button id="submit-reporte-casos" type="submit" class="btn btn-success btn-lg">Guardar</button>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="panel_consultar" role="tabpanel">
						<div class="row">
							<legend class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <h3><i class="fas fa-caret-right"></i> <strong>CASOS REPORTADOS</h3></strong></legend>
						</div>
						<div class="row">
							<div class="col-xs-3 col-sm-6 col-md-3 col-lg-3 col-md-offset-2 col-lg-offset-2" style="padding-top: 0.5vh">
								<label class="pull-right">AÑO: </label>
							</div>
							<div class="col-xs-9 col-sm-6 col-md-3 col-lg-3">
								<select class="form-control selectpicker" title="Seleccione AÑO" name="SL_Year_Consulta" id="SL_Year_Consulta" data-live-search="true"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table table-responsive">
									<table class="table table-bordered" id="tabla_casos" name="tabla_casos">
										<thead>
											<tr>
												<th>ID</th>
												<th>CREA</th>
												<th>BENEFICIARIO</th>
												<th>LÍNEA DE ATENCIÓN</th>
												<th>GRUPO</th>
												<th>ORIGEN</th>
												<th>USUARIO</th>
												<th>FECHA REGISTRO</th>
												<th>OPCIONES</th>
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
	</div>
	<div id="modal_editar_caso" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				
			</div>
		</div>
	</div>
</div>
</body>
</html>