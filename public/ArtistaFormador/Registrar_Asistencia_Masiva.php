<?php
	session_start();
	if(!isset($_SESSION["session_username"])) {
		header("location:index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Registrar Asistencia Masiva</title>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- <link href="../LibreriasExternas/datatable-fixed-columns/jquery.dataTables.min.css" rel="stylesheet">
	<link href="../LibreriasExternas/datatable-fixed-columns/fixedColumns.dataTables.min.css" rel="stylesheet"> -->

	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
	<script src="../bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>

    <link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<!-- <script src="../LibreriasExternas/datatable-fixed-columns/jquery.dataTables.min.js"></script>
	<script src="../LibreriasExternas/datatable-fixed-columns/dataTables.fixedColumns.min.js"></script>   -->

	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>  

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>  

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

    <script type="text/javascript" src="Js/Registrar_Asistencia_Masiva.js?v=2021.03.10.1"></script>
</head>
<!-- <style type="text/css">
	.DTFC_LeftBodyWrapper, .DTFC_RightBodyWrapper {
		top: -12px !important;
	},
	.DTFC_LeftWrapper{
		top: unset !important;
	}
</style> -->
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Registrar Asistencia Masiva<small>Crea En Casa</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#registrar_asistencia_masiva" id="nav_registrar_asistencia_masiva" role="tab">Registrar Asistencia Masiva</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="registrar_asistencia_masiva" role="tabpanel">
					<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_artista_formador">Seleccione el Artista Formador:</label>
							</div>
							<div class="col-xs-6 col-md-9">
								<select id="SL_artista_formador" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
                        <div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_grupo">Seleccione el Grupo:</label>
							</div>
							<div class="col-xs-6 col-md-9">
								<select id="SL_grupo" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_lugar_atencion">Seleccione el Lugar de Atención:</label>
							</div>
							<div class="col-xs-6 col-md-9">
								<select id="SL_lugar_atencion" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
                        <div class="row">
                        	<div class="col-xs-12 col-md-12">
								<div class="alert alert-warning" role="alert">
									<h4 class="alert-heading">¡Tenga en cuenta!</h4>
									Para crear una nueva sesión haga click en el circulo <span class="badge crear_sesion_clase">x</span> correspondiente al día del mes.<br>
									<strong>No es necesario un botón de guardar</strong> ya que al hacer clic en cada elemento se guarda automaticamente los datos.
								</div>
							</div>
                        </div>
                        <div class="row">
                        	<div class="col-xs-12 col-md-12">
								<div id="div_table_beneficiarios_grupo" ></div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- Modal -->
	<div id="uploadModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Subir anexo de la sesión para los talleres realizados por fuera del aula virtual.</h4>
				</div>
				<div class="modal-body">
					<!-- Form -->
					<form method='post' action='' enctype="multipart/form-data">
					Seleccione un archivo : <input type='file' name='file' id='file' class='form-control' accept="application/pdf"><br>
					<input type='button' class='btn btn-info' value='Subir' id='btn_upload'>
					<input type='button' class='btn btn-danger' value='Sin Anexo' data-dismiss="modal">
					</form>
					<div id='preview'></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Bioseguridad-->
	<div id="modal_bioseguridad" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Encuesta Bioseguridad.</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<label for="IN_temperatura">Temperatura</label>
						</div>
						<div class="col-xs-12 col-md-12">
							<input type="number" name="IN_temperatura" id="IN_temperatura" value="36.0" class="form-control" step=".1">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<label for="SL_sintomas">¿ Ha presentado alguno de estos síntomas en las últimas 24 horas? . Si los ha presentado por favor selecciónelos </label>
						</div>
						<div class="col-xs-12 col-md-12">
							<select name="SL_sintomas" id="SL_sintomas" class="form-control selectpicker" multiple="multiple">
								<option value="Fiebre">Fiebre</option>
								<option value="Tos">Tos</option>
								<option value="Cefalea (Dolor de cabeza)">Cefalea (Dolor de cabeza)</option>
								<option value="Dolor de garganta">Dolor de garganta</option>
								<option value="Malestar general">Malestar general</option>
								<option value="Dificultad respiratoria">Dificultad respiratoria</option>
								<option value="Adinamia (Ausencia total de fuerza física)">Adinamia (Ausencia total de fuerza física)</option>
								<option value="Secreciones nasales">Secreciones nasales</option>
								<option value="Diarreas">Diarreas</option>
								<option value="Ninguno">Ninguno</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<label for="SL_contacto_sintomas">¿Ha estado en contacto con alguien que presente los anteriores síntomas en las últimas 24 horas?</label>
						</div>
						<div class="col-xs-12 col-md-12">
							<select name="SL_contacto_sintomas" id="SL_contacto_sintomas" class="form-control selectpicker">
									<option value="sí">Sí</option>
									<option value="no">No</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<button class="btn btn-success form-control" id="BT_bioseguridad">Guardar Encuesta Bioseguridad</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>