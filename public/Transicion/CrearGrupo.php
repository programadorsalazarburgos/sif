<?php
	session_start();
	if(!isset($_SESSION["session_username"])) {
		header("location:../index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Crear Grupo</title>
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

    <script type="text/javascript" src="Js/CrearGrupo.js?v=2019.08.27"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Creación de grupos<small> TRANSACCIONALES</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<form id="form_nuevo_grupo">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#panel_crear_grupo" role="tab">Creación De Un Nuevo Grupo</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="panel_crear_grupo" role="tabpanel">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Creación De Grupos Transaccionales</h4>
								</div>
							</div>
						</div>
						<legend>Dupla</legend>
						<div class="row">
							<div class="col-xs-6 col-md-2">
								<label for="SL_artista_crea">Artista CREA:</label>
							</div>
							<div class="col-xs-12 col-md-4">
								<select name="SL_artista_crea" id="SL_artista_crea" class="form-control selectpicker" data-live-search="true"></select>
							</div>
							<div class="col-xs-6 col-md-2">
								<label for="SL_artista_nidos">Artista NIDOS:</label>
							</div>
							<div class="col-xs-12 col-md-4">
								<select name="SL_artista_nidos" id="SL_artista_nidos" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-2">
								<label for="SL_crea">CREA:</label>
							</div>
							<div class="col-xs-12 col-md-10">
								<select name="SL_crea" id="SL_crea" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-2">
								<label for="TX_lugar_atencion">Lugar atención:</label>
							</div>
							<div class="col-xs-12 col-md-10">
								<textarea name="TX_lugar_atencion" required="required" id="TX_lugar_atencion" class="form-control"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-2">
								<label for="TX_observaciones">Observaciones:</label>
							</div>
							<div class="col-xs-12 col-md-10">
								<textarea name="TX_observaciones" id="TX_observaciones" class="form-control"></textarea>
							</div>
						</div>
						<div id="div_horario_clase">
							<legend>Horario del grupo</legend>
							<div class="row bg-info text-center" id="div_dias_clase">
								<div class="col-xs-4 col-md-4">
									<div class="checkbox">
										<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='1' id="CH_dia_01" name="CH_dia_clase[]" value="01">Lunes</label>
										<select id="SL_hora_inicio_dia_01" name="SL_hora_inicio_dia_01" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
										<select id="SL_hora_fin_dia_01" name="SL_hora_fin_dia_01" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
									</div>
								</div>
								<div class="col-xs-4 col-md-4">
									<div class="checkbox">
										<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='2' id="CH_dia_02" name="CH_dia_clase[]" value="02">Martes</label>
										<select id="SL_hora_inicio_dia_02" name="SL_hora_inicio_dia_02" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
										<select id="SL_hora_fin_dia_02" name="SL_hora_fin_dia_02" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
									</div>
								</div>
								<div class="col-xs-4 col-md-4">
									<div class="checkbox">
										<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='3' id="CH_dia_03" name="CH_dia_clase[]" value="03">Miercoles</label>
										<select id="SL_hora_inicio_dia_03" name="SL_hora_inicio_dia_03" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
										<select id="SL_hora_fin_dia_03" name="SL_hora_fin_dia_03" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
									</div>
								</div>
								<div class="col-xs-4 col-md-4">
									<div class="checkbox">
										<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='4' id="CH_dia_04" name="CH_dia_clase[]" value="04">Jueves</label>
										<select id="SL_hora_inicio_dia_04" name="SL_hora_inicio_dia_04" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
										<select id="SL_hora_fin_dia_04" name="SL_hora_fin_dia_04" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
									</div>
								</div>
								<div class="col-xs-4 col-md-4">
									<div class="checkbox">
										<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='5' id="CH_dia_05" name="CH_dia_clase[]" value="05">Viernes</label>
										<select id="SL_hora_inicio_dia_05" name="SL_hora_inicio_dia_05" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
										<select id="SL_hora_fin_dia_05" name="SL_hora_fin_dia_05" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
									</div>
								</div>
								<div class="col-xs-4 col-md-4">
									<div class="checkbox">
										<label><input type="checkbox" class="checkbox_dias_clase" data-dia_clase='6' id="CH_dia_06" name="CH_dia_clase[]" value="06">Sabado</label>
										<select id="SL_hora_inicio_dia_06" name="SL_hora_inicio_dia_06" class="form-control selectpicker" title='Hora de inicio' data-live-search="true" disabled="disabled"></select>
										<select id="SL_hora_fin_dia_06" name="SL_hora_fin_dia_06" class="form-control selectpicker" title="Hora de fin" data-live-search="true" disabled="disabled"></select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input type="submit" class="form-control btn btn-success" value="Crear Grupo">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>