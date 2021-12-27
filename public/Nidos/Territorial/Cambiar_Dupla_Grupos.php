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
	<title>Cambio de Dupla</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Cambiar_Dupla_Grupos.js?v=2018.1.0.1"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
  <script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<link href="../../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../../css/Nidos.css">

</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Cambiar Grupos de Dupla</h1>
			</div>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#asignacion_territorio" role="tab">Cambio de Grupos</a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="asignacion_territorio" role="tabpanel">
						<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>Asignar grupos a una nueva dupla</h4>
						</div>
					</div>
			<form id="form_cambiar_grupos_Dupla">
						<br>
					<div class="row">
					 <div class="col-xs-12 col-md-12 text-center bg-danger">
							<div class="form-group">
								<label class="col-md-2">Seleccione la Dupla Actual:</label>
								<div class="col-md-10">
									<select class="form-control selectpicker" title="Seleccione una opción" data-live-search="true" name="SL_Duplas" id="SL_Duplas"></select>
								</div>
              </div>
					</div>
				</div>
					<br>
					<div class="row">
					 <div class="col-xs-12 col-md-12 text-center bg-success">
							<div class="form-group">
										<label class="col-md-2">Seleccione la Nueva Dupla:</label>
										<div class="col-md-10">
											<select class="form-control selectpicker" title="Seleccione una opción" data-live-search="true" required name="SL_TDuplas" id="SL_TDuplas"></select>
										</div>
									</div>
						</div>
					</div>
							<br>
  			<div id="div_Consulta_Grupos" style="display: none;">
					<br>
				<H2><center><strong><font color="teal">GRUPOS ACTIVOS DE LA DUPLA</font></strong></center></H2>
  				<table id="table_grupos_dupla" class="table table-responsive table-bordered table-hover"  width="100%">
						<thead>
							<tr>
  								<th class="text-center">ID Grupo</td>
									<th class="text-center">Tipo de Estrategia</td>
									<th class="text-center">Lugar de Atención</td>
									<th class="text-center">Nombre Grupo</td>
									<th class="text-center">Cambiar Grupo</td>
							 </tr>
						</thead>
					  <tbody></tbody>
			 	</table>
				<div class="row">
					<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
						<input class="form-control btn btn-primary" id="BT_cambiar_dupla" type="button" value="CAMBIAR GRUPOS" data-toggle="modal" data-target="#miModalCambiarGrupo">
					</div>
				</div>
      </div>

			<!-- Inicio del modal confirmar asistencia-->
			<div id="miModalCambiarGrupo" class="modal modal-wide fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">CAMBIO DE GRUPOS</h4>
						</div>
						<div class="modal-body">
							<div id="info_grupos">
							</div>
						</div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-success" id="BT_confirmar_asistencia"value="Si" />
							<input type="button" class="btn btn-danger" data-dismiss="modal" id="BT_cancelar_guardado" />
						</div>
					</div>
				</div>
			</div>
			<!--Fin del modal-->

</form>

     	</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>
