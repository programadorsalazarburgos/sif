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
	<title>Consultar datos estudiantes Grupo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="Js/Consultar_Datos_Estudiantes_Grupo.js?v=2019.04.23.5.1"></script>

    <link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consultar datos estudiantes grupo <small><?php echo date("Y"); ?> </small></h1>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_crea">Crea (del grupo):</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="form-control selectpicker" data-live-search="true" id="SL_crea"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_grupo">Grupo:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_grupo" multiple="multiple" class="form-control selectpicker" data-actions-box="true" data-deselect-all-text="Ninguno" data-select-all-text="Todos" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_grupo">Area Artistica:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_area" multiple="multiple" class="form-control selectpicker" data-actions-box="true" data-deselect-all-text="Ninguno" data-select-all-text="Todos" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<div class="table-responsive">
							<table id="table_estudiante" style="width: 100%" class="table table-hover">
								<thead>
									<tr>
										<th class="text-center"><strong>Tipo Identificación</strong></th>
										<th class="text-center"><strong>Documento</strong></th>
										<th class="text-center"><strong>Nombres</strong></th>
										<th class="text-center"><strong>Apellidos</strong></th>
										<th class="text-center"><strong>Fecha Nacimiento</strong></th>
										<th class="text-center"><strong>Edad</strong></th>
										<th class="text-center"><strong>Genero</strong></th>
										<th class="text-center"><strong>Correo</strong></th>
										<th class="text-center"><strong>Dirección</strong></th>
										<th class="text-center"><strong>Telefono</strong></th>
										<th class="text-center"><strong>Celular</strong></th>
										<th class="text-center"><strong>CREA (del estudiante)</strong></th>
										<th class="text-center"><strong>Colegio</strong></th>
										<th class="text-center"><strong>Grado</strong></th>
										<th class="text-center"><strong>Jornada</strong></th>
										<th class="text-center"><strong>Nombre Acudiente</strong></th>
										<th class="text-center"><strong>Identificación Acudiente</strong></th>
										<th class="text-center"><strong>Teléfono Acudiente</strong></th>
										<th class="text-center"><strong>Grupo Poblacional</strong></th>
										<th class="text-center"><strong>EPS</strong></th>
										<th class="text-center"><strong>Tipo de afiliación</strong></th>
										<th class="text-center"><strong>RH</strong></th>
										<th class="text-center"><strong>Enfermedades</strong></th>
										<th class="text-center"><strong>Localidad</strong></th>
										<th class="text-center"><strong>Barrio</strong></th>
										<th class="text-center"><strong>Tipo población victima</strong></th>
										<th class="text-center"><strong>Tipo discapacidad</strong></th>
										<th class="text-center"><strong>Etnia</strong></th>
										<th class="text-center"><strong>Estrato</strong></th>
										<th class="text-center"><strong>Grupo</strong></th>
										<th class="text-center"><strong>Area Artistica</strong></th>
										<th class="text-center"><strong>Fecha de Ingreso</strong></th>
										<th class="text-center"><strong>Estado en grupo</strong></th>
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
</body>