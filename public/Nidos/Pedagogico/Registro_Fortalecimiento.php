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
	<title>Registro de Fortalecimiento</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Registro_Fortalecimiento.js?v=2019.7.26"></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
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

	<!-- <link href="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.js" type="text/javascript"></script> -->
	<script src="../../bower_components/moment/moment.js" type="text/javascript"></script>

	<script src="../../bower_components/pdfmake/build/pdfmake.js" type="text/javascript" ></script>
	<script src="../../bower_components/pdfmake/build/vfs_fonts.js" type="text/javascript" ></script>

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
					<h1>Formato de Fortalecimiento FAP</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#registro_beneficiario" role="tab">Registro de Fortalecimiento</a></li>
					<li class="nav-item" ><a id="nav_consultar_fortalecimiento" class="nav-link" data-toggle="tab" href="#consulta_atenciones" role="tab">Consultar Fortalecimientos Registrados</a></li>
					<li class="nav-item" ><a id="nav_registro_laboratorio" class="nav-link" data-toggle="tab" href="#registro_laboratorio" role="tab">Registro de Laboratorios</a></li>
				</ul>
				<div class="tab-content">

					<div class="tab-pane active" id="registro_beneficiario" role="tabpanel">

		<div id="div_fortalecimientos_coordinador" style="display: none;">							
				<center><h2><font color="teal"><label>REGISTRO FORTALECIMIENTOS GT Y EAAT</label> </font></h2></center>
				<br>
				<div class="form-group">
					<label class="col-md-2 col-md-offset-1" for="SL_Tipo_Persona">Seleccionar tipo de persona:</label>
					<div class="col-md-4">
					<select class="form-control selectpicker" data-live-search="true" name="SL_Tipo_Persona" id="SL_Tipo_Persona" title="Seleccione tipo equipo">
					<option value="20">GESTORES TERRITORIALES</option>
					<option value="22">EQUIPO ARTISTICO PEDAGÓGICO</option>	
					</select>
					<span class="help-block" id="error"></span>
				</div>
			</div>	

			 <div id="div_equipo_central1">
			 	<center><h2><font color="teal"><label>Ra</label> </font></h2></center>
				<div class="table-responsive">
					<table id="table_equipo_central" class="table table-striped table-bordered table-hover" width="100%">
						<thead>
							<tr>
								<th class="text-center">IDENTIFIACIÓN</th>
								<th class="text-center">NOMBRE COMPLETO</th>
								<th class="text-center">TERRITORIO</th>
								<th class="text-center">ASISTENCIA</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>			 	
			</div>			

 	</div>


		<div id="div_fortalecimientos_eaat" style="display: none;">

					<form id="form_nuevo_fortalecimiento">

						<?php echo "<input type='hidden' id='id_usuario' name='id_usuario' value='".$Id_Persona."'" ?>
						<br><br>
            <div class='form-group'>
							<div class='bg-secondary col-xs-12 col-md-12'>
								<p></p><p>
									<strong>EAAT: </strong><font color="teal"><label class="TX_Eaat" id="TX_Eaat" for="TX_Eaat"></label> </font></p><p>
									<strong>Territorio: </strong><font color="teal"><label id="TX_Territorio" for="TX_Territorio"></label> </font></p>
							</div>
						</div>
						<br><br><br><br>

	                 <div class="col-lg-12">
										<div class="col-lg-3 col-md-3">
											<div class="form-group">
												<label for="SL_Localidad">Localidad:</label>
												<select class="form-control selectpicker" data-live-search="true" name="SL_Localidad" id="SL_Localidad" title="Seleccione el lugar"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-3 col-md-3">
											<div class="form-group">
												<label for="SL_Lugar">Lugar:</label>
												<select class="form-control selectpicker" data-live-search="true" name="SL_Lugar" id="SL_Lugar" title="Seleccione el lugar"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-3 col-md-3">
											<div class="form-group">
												<label for="TX_Evento">Evento:</label>
												<select class="form-control selectpicker" data-live-search="true" name="TX_Evento" id="TX_Evento" title="Seleccione el evento"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-3 col-md-3">
										 <div class="form-group">
											 <label for="SL_Tipo_Documento">Fecha:</label>
											 <input type="text" readonly="readonly" class="form-control input-sm" id="TX_Fecha_Encuentro1"  name="TX_Fecha_Encuentro1" placeholder="Fecha de la experiencia" style="border-style: solid; border-width: 2px; border-color: #3c763d;">
											 <span class="help-block" id="error"></span>
										 </div>
									 </div>
									</div>

								<br><br><br><br>

						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Listado de Artistas.</h4>
							</div>
						</div>

						<table id="table_artistas_territorio" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th class="text-center">Identificación</th>
									<th class="text-center">Nombre Artista Comunitario</th>
									<th class="text-center">Localidad</th>
									<th class="text-center">Dupla</th>
									<th class="text-center">Asistencia</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<div class="row">
								<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
									<input class="form-control btn btn-primary" type="submit" value="Registrar Fortalecimiento"/>
								</div>
							</div>
					</form>
					</div>

				</div>



			 <div class="tab-pane" id="consulta_atenciones" role="tabpanel">
				<center><h2><font color="teal"><label>FORTALECIMIENTOS REGISTRADOS</label> </font></h2></center>
				 <br>
				 <div class="row">
					 <label class="col-md-2" for="SL_Mes_Consolidado">Seleccione el Mes de Consulta:</label>
						 <div class="col-md-10">
							 <select class="form-control SeleccionarMes" data-live-search="true" name="SL_Mes_Consolidado" id="SL_Mes_Consolidado" title="Seleccione el Mes"></select>
						 </div>
				 </div>
				 <br>
			 <div id="div_fortalecimientos_mes" style="display: none;">
				<div class="table-responsive">
					<table id="table_fortalecimientos_territorio" class="table table-striped table-bordered table-hover" width="100%">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Localidad</th>
								<th class="text-center">Upz</th>
								<th class="text-center">Lugar</th>
								<th class="text-center">Nombre Fortalecimiento</th>
								<th class="text-center">Fecha</th>
								<th class="text-center">Artistas Asistentes</th>
								<th class="text-center">Consultar</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>



					<div class="tab-pane" id="registro_laboratorio" role="tabpanel">

					<form id="form_nuevo_laboratorio">
		            <div class='form-group'>
							<div class='bg-secondary col-xs-12 col-md-12'>
								<p></p><p>
									<strong>EAAT: </strong><font color="teal"><label class="TX_Eaat" id="TX_Eaat_LAB" for="TX_Eaat_LAB"></label> </font></p><p>
									<strong>Nombre Laboratorio: </strong><font color="teal"><label id="TX_Nom_Laboratorio" for="TX_Nom_Laboratorio"></label> </font></p>
							</div>
						</div>
						<br><br><br><br>

	                 <div class="col-lg-12">
										<div class="col-lg-3 col-md-3">
											<div class="form-group">
												<label for="SL_Localidad">Localidad:</label>
												<select class="form-control selectpicker" data-live-search="true" name="SL_Localidad_LAB" id="SL_Localidad_LAB" title="Seleccione el lugar"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-3 col-md-3">
											<div class="form-group">
												<label for="SL_Lugar">Lugar:</label>
												<select class="form-control selectpicker" data-live-search="true" name="SL_Lugar_LAB" id="SL_Lugar_LAB" title="Seleccione el lugar"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-3 col-md-3">
											<div class="form-group">
												<label for="TX_Evento">Evento:</label>
												<select class="form-control selectpicker" data-live-search="true" name="TX_Evento_LAB" id="TX_Evento_LAB" title="Seleccione el evento"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-3 col-md-3">
										 <div class="form-group">
											 <label for="SL_Tipo_Documento">Fecha:</label>
											 <input type="text" readonly="readonly" class="form-control input-sm" id="TX_Fecha_Encuentro1_LAB"  name="TX_Fecha_Encuentro1_LAB" placeholder="Fecha de la experiencia" style="border-style: solid; border-width: 2px; border-color: #3c763d;">
											 <span class="help-block" id="error"></span>
										 </div>
									 </div>
									</div>

								<br><br><br><br>

						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Listado de Artistas Laboratorio</h4>
							</div>
						</div>

						<table id="table_artistas_laboratorio" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th class="text-center">Identificación</th>
									<th class="text-center">Nombre Artista Comunitario</th>
									<th class="text-center">Territorio</th>
									<th class="text-center">Dupla</th>
									<th class="text-center">Asistencia</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<div class="row">
								<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
									<input class="form-control btn btn-primary" type="submit" value="Registrar Laboratorio"/>
								</div>
							</div>
					</form>
				</div>



			<!-- Inicio del modal observación documento provisional-->
			<div id="modal_nombre_evento" class="modal modal-wide fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
							<h4 class="modal-title">Nombre del evento realizado</h4>
						</div>
						<div class="modal-body">
							<div id="div-nuevo-evento">
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

			<!-- Inicio del modal observación documento provisional-->
			<div id="modal_nombre_evento_LAB" class="modal modal-wide fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
							<h4 class="modal-title">Nombre del evento realizado</h4>
						</div>
						<div class="modal-body">
							<div id="div-nuevo-evento_LAB">
							</div>
						</div>
						<div class="modal-footer">
							<input type="button" class="btn btn-success" id="btn-guardar-observacion_LAB" value="Guardar"/>
							<input type="button" class="btn btn-danger" id="btn-cancelar-observacion_LAB" data-dismiss="modal" value="Cancelar"/>
						</div>
					</div>
				</div>
			</div>
			<!--Fin del modal-->

    	</div>
  	</div>
	</body>
</html>
