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
	<title>Consultar Historial Grupos y Formadores Organización</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../LibreriasExternas/alertifyjs/css/alertify.min.css">
	<script type="text/javascript" src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>

	<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

	<script type="text/javascript" src="Js/Consultar_Grupos_Y_Formadores_Organizacion.js?v=4"></script> 
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consultar Historial <small> Grupos y Artistas Formadores</small></h1>
				</div>
				<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_organizacion">Organización</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="form-control selectpicker" data-live-search="true" id="SL_organizacion"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_clan">CREA</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="form-control selectpicker" multiple="multiple" data-actions-box="true" selectAllText="Seleccionar Todos" deselectAllText="Deselccionar Todos" data-live-search="true" id="SL_clan"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
						<button class="btn btn-info form-control" id="BT_cargar_datos">Consultar</button>
					</div>
				</div>
				<div id="resultados_consulta">
					<div class="panel-body">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#tab_historico_grupos_asignados" id="historico_grupos_asignados_nav" role="tab">Historico Grupos Asignados</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_historico_artistas_formadores_asignados" id="historico_artistas_formadores_asignados_nav" role="tab">Historico Artistas Formadores Asignados</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_historico_grupos_asignados" role="tabpanel">
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<h3>Historico de grupos asignados a la organización</h3>
										<div class="table-responsive">
											<table class="table table-hover" id="table_historico_grupos_asignados">
												<thead>
													<tr>
														<th>Grupo</th>
														<th>CREA</th>
														<th>Fecha de asignación</th>
														<th>Quien asginó</th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_historico_artistas_formadores_asignados" role="tabpanel">
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<h3>Historico de artistas formadores asignados a los grups de la organización</h3>
										<div class="table-responsive">
											<table class="table table-hover" id="table_historico_artistas_grupos_asignados">
												<thead>
													<tr>
														<th>Grupo</th>
														<th>CREA</th>
														<th>Colegio</th>
														<th>Artista Formador</th>
														<th>Estado</th>
														<th>Fecha de cierre</th>
														<th>Fecha de asignación</th>
														<th>Quien asginó</th>
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
		</div>
	</div>
</body>