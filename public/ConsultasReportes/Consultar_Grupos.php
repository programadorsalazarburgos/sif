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
	<title>Consultar Grupos</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">
	<link type="text/css" href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

	<script type="text/javascript" src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

	<link type="text/css" href="../LibreriasExternas/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
	<script type="text/javascript" src="../LibreriasExternas/bootstrap-toggle/bootstrap-toggle.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../LibreriasExternas/alertifyjs/css/alertify.min.css">
	<script type="text/javascript" src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>

	<script type="text/javascript" src='../LibreriasExternas/pdfmake/pdfmake.min.js'></script>
	<script type="text/javascript" src='../LibreriasExternas/pdfmake/vfs_fonts.js'></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
    <link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="Js/Consultar_Grupos.js?v=2021.07.26.0"></script>
</head>
<style type="text/css">
	.table > thead:first-child > tr:first-child > th:first-child {
    position: absolute;
    display: inline-block;
    background-color: #009f99;
    color: white;
}

.table > tbody > tr > td:first-child {
    position: absolute;
    display: inline-block;
    background-color: #009f99;
    color: white;
}

.table > thead:first-child > tr:first-child > th:nth-child(2) {
    padding-left: 40px;
}

.table > tbody > tr > td:nth-child(2) {
    padding-left: 50px !important;
}
</style>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consulta general de grupos<small> CREA </small></h1>
				</div>
				<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<label for="SL_clan">Seleccione el año:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_Ano" multiple="multiple" class="form-control selectpicker" data-actions-box="true" selectAllText="Seleccionar Todos" deselectAllText="Deselccionar Todos" data-live-search="true">
							<?php for($i=2017;$i<=date("Y");$i++): ?>
							<option value="<?= $i ?>" <?php if($i==date("Y")) echo ' selected'; ?>><?= $i ?></option>							
							<?php endfor; ?>
						</select>
					</div>					
					<div class="col-xs-8 col-md-3">
						<label for="SL_clan">Seleccione el crea:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_clan" multiple="multiple" class="form-control selectpicker" data-actions-box="true" data-deselect-all-text="Ninguno" data-select-all-text="Todos" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12 alert alert-warning">
						<p>
							A continuación va a encontrar todos los grupos, puede usar la celda <b>Filtrar</b> para encontrar los grupos pertenecientes a un Área Artística espcifica, Colegio u otro.
						</p>
						<p>Además puede hacer clic en el boton del número de estudiantes para ver el listado de estudiantes del grupo.</p>
					</div>
				</div>
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#grupos_arte_escuela" role="tab" id="gruposArteEscuela">Arte en la escuela</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#grupos_emprende_clan" role="tab" id="gruposEmprendeClan">Impulso Colectivo</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#grupos_laboratorio_clan" role="tab" id="gruposLaboratorioClan">Converge</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#total_grupos_clan" role="tab" id="consolidadoGrupsClan">Consolidado Grupos CREA</a></li>
					
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="grupos_arte_escuela" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>ARTE EN LA ESCUELA <small>Detalle de grupos</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<table id="table_grupos_arte_escuela" style="width: 100%" class="table table-hover">
										<thead>
											<tr>
												<th class="text-center"><strong>N°</strong></th>
												<th class="text-center"><strong>Estado</strong></th>
												<th class="text-center"><strong>CREA</strong></th>
												<th class="text-center"><strong>Area Artistica</strong></th>
												<th class="text-center"><strong>Modalidad Atención</strong></th>
												<th class="text-center"><strong>Convenio</strong></th>
												<th class="text-center"><strong>Tipo Asignación</strong></th>
												<th class="text-center"><strong>Colegio</strong></th>
												<th class="text-center"><strong>Grado(s)</strong></th>
												<th class="text-center"><strong>Organización</strong></th>
												<th class="text-center"><strong>Artista Formador</strong></th>
												<th class="text-center"><strong>Lugar de Atención</strong></th>
												<th class="text-center"><strong>Fecha Creación</strong></th>
												<th class="text-center"><strong>Usuario Creación</strong></th>
												<th class="text-center"><strong>Horario</strong></th>
												<th class="text-center"><strong>N° Estudiantes Matriculados</strong></th>
												<th class="text-center"><strong>Observaciones</strong></th>
												<th class="text-center"><strong>Fecha Inactivación</strong></th>
												<th class="text-center"><strong>Usuario Inactivación</strong></th>
												<th class="text-center"><strong>Acumulado Atendidos (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Hombres Atendidos (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Mujeres Atendidas (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Atendidos sin Género (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Reportados (Con o Sin asistencia)</strong></th>
												<th class="text-center"><strong>Atendidos Enero</strong></th>
												<th class="text-center"><strong>Total Reportados Enero</strong></th>
												<th class="text-center"><strong>Porcentaje Enero</strong></th>
												<th class="text-center"><strong>Atendidos Febrero</strong></th>
												<th class="text-center"><strong>Total Reportados Febrero</strong></th>
												<th class="text-center"><strong>Porcentaje Febrero</strong></th>
												<th class="text-center"><strong>Atendidos Marzo</strong></th>
												<th class="text-center"><strong>Total Reportados Marzo</strong></th>
												<th class="text-center"><strong>Porcentaje Marzo</strong></th>
												<th class="text-center"><strong>Atendidos Abril</strong></th>
												<th class="text-center"><strong>Total Reportados Abril</strong></th>
												<th class="text-center"><strong>Porcentaje Abril</strong></th>
												<th class="text-center"><strong>Atendidos Mayo</strong></th>
												<th class="text-center"><strong>Total Reportados Mayo</strong></th>
												<th class="text-center"><strong>Porcentaje Mayo</strong></th>
												<th class="text-center"><strong>Atendidos Junio</strong></th>
												<th class="text-center"><strong>Total Reportados Junio</strong></th>
												<th class="text-center"><strong>Porcentaje Junio</strong></th>
												<th class="text-center"><strong>Atendidos Julio</strong></th>
												<th class="text-center"><strong>Total Reportados Julio</strong></th>
												<th class="text-center"><strong>Porcentaje Julio</strong></th>
												<th class="text-center"><strong>Atendidos Agosto</strong></th>
												<th class="text-center"><strong>Total Reportados Agosto</strong></th>
												<th class="text-center"><strong>Porcentaje Agosto</strong></th>
												<th class="text-center"><strong>Atendidos Septiembre</strong></th>
												<th class="text-center"><strong>Total Reportados Septiembre</strong></th>
												<th class="text-center"><strong>Porcentaje Septiembre</strong></th>
												<th class="text-center"><strong>Atendidos Octubre</strong></th>
												<th class="text-center"><strong>Total Reportados Octubre</strong></th>
												<th class="text-center"><strong>Porcentaje Octubre</strong></th>
												<th class="text-center"><strong>Atendidos Noviembre</strong></th>
												<th class="text-center"><strong>Total Reportados Noviembre</strong></th>
												<th class="text-center"><strong>Porcentaje Noviembre</strong></th>
												<th class="text-center"><strong>Atendidos Diciembre</strong></th>
												<th class="text-center"><strong>Total Reportados Diciembre</strong></th>
												<th class="text-center"><strong>Porcentaje Diciembre</strong></th>
												<!-- <th class="text-center"><strong>Caracterización</strong></th>
												<th class="text-center"><strong>Planeación</strong></th>
												<th class="text-center"><strong>Valoración</strong></th> -->
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="grupos_emprende_clan" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>IMPULSO COLECTIVO <small>Detalle Grupos</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<table id="table_grupos_emprende_clan" class="table table-hover" style="width: 100%;">
										<thead>
											<tr>
												<th class="text-center"><strong>N°</strong></th>
												<th class="text-center"><strong>Estado</strong></th>
												<th class="text-center"><strong>CREA</strong></th>
												<th class="text-center"><strong>Area Artistica</strong></th>
												<th class="text-center"><strong>Modalidad Atención</strong></th>
												<th class="text-center"><strong>Convenio</strong></th>
												<th class="text-center"><strong>Tipo Grupo</strong></th>
												<th class="text-center"><strong>Modalidad</strong></th>
												<th class="text-center"><strong>Organización</strong></th>
												<th class="text-center"><strong>Artista Formador</strong></th>
												<th class="text-center"><strong>Fecha Creación</strong></th>
												<th class="text-center"><strong>Usuario Creación</strong></th>
												<th class="text-center"><strong>Horario</strong></th>
												<th class="text-center"><strong>N° Estudiantes Matriculados</strong></th>
												<th class="text-center"><strong>Observaciones</strong></th>
												<th class="text-center"><strong>Fecha Inactivación</strong></th>
												<th class="text-center"><strong>Usuario Inactivación</strong></th>
												<th class="text-center"><strong>Acumulado Atendidos (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Hombres Atendidos (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Mujeres Atendidas (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Atendidos sin Género (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Reportados (Con o Sin asistencia)</strong></th>
												<th class="text-center"><strong>Atendidos Enero</strong></th>
												<th class="text-center"><strong>Total Reportados Enero</strong></th>
												<th class="text-center"><strong>Porcentaje Enero</strong></th>
												<th class="text-center"><strong>Atendidos Febrero</strong></th>
												<th class="text-center"><strong>Total Reportados Febrero</strong></th>
												<th class="text-center"><strong>Porcentaje Febrero</strong></th>
												<th class="text-center"><strong>Atendidos Marzo</strong></th>
												<th class="text-center"><strong>Total Reportados Marzo</strong></th>
												<th class="text-center"><strong>Porcentaje Marzo</strong></th>
												<th class="text-center"><strong>Atendidos Abril</strong></th>
												<th class="text-center"><strong>Total Reportados Abril</strong></th>
												<th class="text-center"><strong>Porcentaje Abril</strong></th>
												<th class="text-center"><strong>Atendidos Mayo</strong></th>
												<th class="text-center"><strong>Total Reportados Mayo</strong></th>
												<th class="text-center"><strong>Porcentaje Mayo</strong></th>
												<th class="text-center"><strong>Atendidos Junio</strong></th>
												<th class="text-center"><strong>Total Reportados Junio</strong></th>
												<th class="text-center"><strong>Porcentaje Junio</strong></th>
												<th class="text-center"><strong>Atendidos Julio</strong></th>
												<th class="text-center"><strong>Total Reportados Julio</strong></th>
												<th class="text-center"><strong>Porcentaje Julio</strong></th>
												<th class="text-center"><strong>Atendidos Agosto</strong></th>
												<th class="text-center"><strong>Total Reportados Agosto</strong></th>
												<th class="text-center"><strong>Porcentaje Agosto</strong></th>
												<th class="text-center"><strong>Atendidos Septiembre</strong></th>
												<th class="text-center"><strong>Total Reportados Septiembre</strong></th>
												<th class="text-center"><strong>Porcentaje Septiembre</strong></th>
												<th class="text-center"><strong>Atendidos Octubre</strong></th>
												<th class="text-center"><strong>Total Reportados Octubre</strong></th>
												<th class="text-center"><strong>Porcentaje Octubre</strong></th>
												<th class="text-center"><strong>Atendidos Noviembre</strong></th>
												<th class="text-center"><strong>Total Reportados Noviembre</strong></th>
												<th class="text-center"><strong>Porcentaje Noviembre</strong></th>
												<th class="text-center"><strong>Atendidos Diciembre</strong></th>
												<th class="text-center"><strong>Total Reportados Diciembre</strong></th>
												<th class="text-center"><strong>Porcentaje Diciembre</strong></th>
												<!-- <th class="text-center"><strong>Caracterización</strong></th>
												<th class="text-center"><strong>Planeación</strong></th>
												<th class="text-center"><strong>Valoración</strong></th> -->
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="grupos_laboratorio_clan" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>CONVERGE <small>Detalle Grupos</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<table id="table_grupos_laboratorio_clan" class="table table-hover" style="width: 100%;">
										<thead>
											<tr>
												<th class="text-center"><strong>N°</strong></th>
												<th class="text-center"><strong>Estado</strong></th>
												<th class="text-center"><strong>CREA</strong></th>
												<th class="text-center"><strong>Localidad del CREA</strong></th>
												<th class="text-center"><strong>Area Artistica</strong></th>
												<th class="text-center"><strong>Modalidad Atención</strong></th>
												<th class="text-center"><strong>Convenio</strong></th>
												<th class="text-center"><strong>Categoria Población</strong></th>
												<th class="text-center"><strong>Subcategoria Población</strong></th>
												<th class="text-center"><strong>Institución</strong></th>
												<th class="text-center"><strong>Aliado</strong></th>
												<th class="text-center"><strong>Lugar de atención</strong></th>
												<th class="text-center"><strong>Localidad Lugar Atención</strong></th>
												<th class="text-center"><strong>Organización</strong></th>
												<th class="text-center"><strong>Artista Formador</strong></th>
												<th class="text-center"><strong>Tipo Grupo</strong></th>
												<th class="text-center"><strong>Fecha Creación</strong></th>
												<th class="text-center"><strong>Usuario Creación</strong></th>
												<th class="text-center"><strong>Horario</strong></th>
												<th class="text-center"><strong>N° Estudiantes Matriculados</strong></th>
												<th class="text-center"><strong>Observaciones</strong></th>
												<th class="text-center"><strong>Fecha Inactivación</strong></th>
												<th class="text-center"><strong>Usuario Inactivación</strong></th>
												<th class="text-center"><strong>Acumulado Atendidos (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Hombres Atendidos (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Mujeres Atendidas (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Atendidos sin Género (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Reportados (Con o Sin asistencia)</strong></th>
												<th class="text-center"><strong>Atendidos Enero</strong></th>
												<th class="text-center"><strong>Total Reportados Enero</strong></th>
												<th class="text-center"><strong>Porcentaje Enero</strong></th>
												<th class="text-center"><strong>Atendidos Febrero</strong></th>
												<th class="text-center"><strong>Total Reportados Febrero</strong></th>
												<th class="text-center"><strong>Porcentaje Febrero</strong></th>
												<th class="text-center"><strong>Atendidos Marzo</strong></th>
												<th class="text-center"><strong>Total Reportados Marzo</strong></th>
												<th class="text-center"><strong>Porcentaje Marzo</strong></th>
												<th class="text-center"><strong>Atendidos Abril</strong></th>
												<th class="text-center"><strong>Total Reportados Abril</strong></th>
												<th class="text-center"><strong>Porcentaje Abril</strong></th>
												<th class="text-center"><strong>Atendidos Mayo</strong></th>
												<th class="text-center"><strong>Total Reportados Mayo</strong></th>
												<th class="text-center"><strong>Porcentaje Mayo</strong></th>
												<th class="text-center"><strong>Atendidos Junio</strong></th>
												<th class="text-center"><strong>Total Reportados Junio</strong></th>
												<th class="text-center"><strong>Porcentaje Junio</strong></th>
												<th class="text-center"><strong>Atendidos Julio</strong></th>
												<th class="text-center"><strong>Total Reportados Julio</strong></th>
												<th class="text-center"><strong>Porcentaje Julio</strong></th>
												<th class="text-center"><strong>Atendidos Agosto</strong></th>
												<th class="text-center"><strong>Total Reportados Agosto</strong></th>
												<th class="text-center"><strong>Porcentaje Agosto</strong></th>
												<th class="text-center"><strong>Atendidos Septiembre</strong></th>
												<th class="text-center"><strong>Total Reportados Septiembre</strong></th>
												<th class="text-center"><strong>Porcentaje Septiembre</strong></th>
												<th class="text-center"><strong>Atendidos Octubre</strong></th>
												<th class="text-center"><strong>Total Reportados Octubre</strong></th>
												<th class="text-center"><strong>Porcentaje Octubre</strong></th>
												<th class="text-center"><strong>Atendidos Noviembre</strong></th>
												<th class="text-center"><strong>Total Reportados Noviembre</strong></th>
												<th class="text-center"><strong>Porcentaje Noviembre</strong></th>
												<th class="text-center"><strong>Atendidos Diciembre</strong></th>
												<th class="text-center"><strong>Total Reportados Diciembre</strong></th>
												<th class="text-center"><strong>Porcentaje Diciembre</strong></th>
												<!-- <th class="text-center"><strong>Caracterización</strong></th>
												<th class="text-center"><strong>Planeación</strong></th>
												<th class="text-center"><strong>Valoración</strong></th> -->
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="total_grupos_clan" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>TOTAL DE GRUPOS POR CREA</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<table id="table_total_grupos_clan" class="table table-hover" style="width: 100%;">
										<thead>
											<tr>
												<th class="text-center"><strong>N°</strong></th>
												<th class="text-center"><strong>Estado</strong></th>
												<th class="text-center"><strong>CREA</strong></th>
												<th class="text-center"><strong>Area Artistica</strong></th>
												<th class="text-center"><strong>Modalidad Atención</strong></th>
												<th class="text-center"><strong>Convenio</strong></th>
												<th class="text-center"><strong>Tipo Grupo</strong></th>
												<th class="text-center"><strong>Institución</strong></th>
												<th class="text-center"><strong>Grado(s)</strong></th>
												<th class="text-center"><strong>Organización</strong></th>
												<th class="text-center"><strong>Artista Formador</strong></th>
												<th class="text-center"><strong>Lugar de atención</strong></th>
												<th class="text-center"><strong>Fecha Creación</strong></th>
												<th class="text-center"><strong>Usuario Creación</strong></th>
												<th class="text-center"><strong>Horario</strong></th>
												<th class="text-center"><strong>N° Estudiantes Matriculados</strong></th>
												<th class="text-center"><strong>Observaciones</strong></th>
												<th class="text-center"><strong>Fecha Inactivación</strong></th>
												<th class="text-center"><strong>Usuario Inactivación</strong></th>			
												<th class="text-center"><strong>Acumulado Atendidos (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Hombres Atendidos (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Mujeres Atendidas (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Atendidos sin Género (Con asistencia)</strong></th>
												<th class="text-center"><strong>Acumulado Reportados (Con o Sin asistencia)</strong></th>
												<th class="text-center"><strong>Atendidos Enero</strong></th>
												<th class="text-center"><strong>Total Reportados Enero</strong></th>
												<th class="text-center"><strong>Porcentaje Enero</strong></th>
												<th class="text-center"><strong>Atendidos Febrero</strong></th>
												<th class="text-center"><strong>Total Reportados Febrero</strong></th>
												<th class="text-center"><strong>Porcentaje Febrero</strong></th>
												<th class="text-center"><strong>Atendidos Marzo</strong></th>
												<th class="text-center"><strong>Total Reportados Marzo</strong></th>
												<th class="text-center"><strong>Porcentaje Marzo</strong></th>
												<th class="text-center"><strong>Atendidos Abril</strong></th>
												<th class="text-center"><strong>Total Reportados Abril</strong></th>
												<th class="text-center"><strong>Porcentaje Abril</strong></th>
												<th class="text-center"><strong>Atendidos Mayo</strong></th>
												<th class="text-center"><strong>Total Reportados Mayo</strong></th>
												<th class="text-center"><strong>Porcentaje Mayo</strong></th>
												<th class="text-center"><strong>Atendidos Junio</strong></th>
												<th class="text-center"><strong>Total Reportados Junio</strong></th>
												<th class="text-center"><strong>Porcentaje Junio</strong></th>
												<th class="text-center"><strong>Atendidos Julio</strong></th>
												<th class="text-center"><strong>Total Reportados Julio</strong></th>
												<th class="text-center"><strong>Porcentaje Julio</strong></th>
												<th class="text-center"><strong>Atendidos Agosto</strong></th>
												<th class="text-center"><strong>Total Reportados Agosto</strong></th>
												<th class="text-center"><strong>Porcentaje Agosto</strong></th>
												<th class="text-center"><strong>Atendidos Septiembre</strong></th>
												<th class="text-center"><strong>Total Reportados Septiembre</strong></th>
												<th class="text-center"><strong>Porcentaje Septiembre</strong></th>
												<th class="text-center"><strong>Atendidos Octubre</strong></th>
												<th class="text-center"><strong>Total Reportados Octubre</strong></th>
												<th class="text-center"><strong>Porcentaje Octubre</strong></th>
												<th class="text-center"><strong>Atendidos Noviembre</strong></th>
												<th class="text-center"><strong>Total Reportados Noviembre</strong></th>
												<th class="text-center"><strong>Porcentaje Noviembre</strong></th>
												<th class="text-center"><strong>Atendidos Diciembre</strong></th>
												<th class="text-center"><strong>Total Reportados Diciembre</strong></th>
												<th class="text-center"><strong>Porcentaje Diciembre</strong></th>
												<!-- <th class="text-center"><strong>Caracterización</strong></th>
												<th class="text-center"><strong>Planeación</strong></th>
												<th class="text-center"><strong>Valoración</strong></th> -->
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
	<div class="modal fade" id="modal_estudiantes_grupo" tabindex="-1" role="dialog" aria-labelledby="label_modal_estudiantes_grupo" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="title_modal_estudiantes_grupo"></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<div class="table-responsive">
								<table class="table table-hover" id="table_listado_estudiantes_grupo">
									<thead>
										<tr>
											<th class="text-center">Identificación</th>
											<th class="text-center">Nombres y apellidos</th>
											<th class="text-center">Teléfonos</th>
											<th class="text-center">Fecha de ingreso</th>
											<th class="text-center">Estado</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" id="BT_confirmar_asignacion_artista_formador_grupo" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_caracterizaciones_grupo_ae" tabindex="-1" role="dialog" aria-labelledby="label_modal_estudiantes_grupo" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="title_modal_caracterizaciones_grupo"></h4>
				</div>
				<div class="modal-body">
					<form id="FORM_Observacion_car_ae">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="alert alert-warning">Recuerde que los formatos de (Caracterización, Planeación, Valoración) del año 2019 no aparecerán aquí sino en el Módulo: <strong>Componente Pedagógico</strong> del menú principal.</div>
								<select id="SL_Caracterizaciones_Grupo_Arte_Escuela" name="SL_Caracterizaciones_Grupo_Arte_Escuela" class="form-control" required>

								</select>
							</div>
						</div>
						<div  class="row">
							<br>
						</div>
						<?php if (isset($_SESSION['session_usertype']) && ($_SESSION['session_usertype'] == '2' || $_SESSION['session_usertype'] == '5' || $_SESSION['session_usertype'] == '15')) {
							?>
							<div class="panel-success">
								<div style="background-color: #def9de;" class="row" id="DIV_Observacion_car_ae" hidden>
									<br>
									<div class="col-md-12">
										<label>Observación
										</label>
									</div>
									<div class="col-md-12">
										<textarea class="form-control" rows="5"  type="" id="TXT_Observacion_car_ae" name="TXT_Observacion_car_ae" placeholder="Observación Sobre la Caracterización"></textarea>
										<br>
									</div>
									<div class="col-md-12">
										<label>Aprobado: </label>
										<input data-toggle="toggle" data-onstyle="success" name= "IN_Estado_car_ae" id="IN_Estado_car_ae" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox"  class="estado_check">
									</div>
									<div class="col-md-12  text-center">
										<button type="submit" id="BT_Observacion_car_ae" class="btn btn-primary" >Guardar Observación y/o Aprobación</button>
									</div>
									<br>
									<div  class="col-md-12">
										<br>
									</div>
								</div>
							</div>
							<?php
						} ?>

						<div  class="row">
							<br>
						</div>
						<div class="modal-footer">
							<button type="button" id="BT_ver_caracterizacion" class="btn btn-primary" >Descargar Caracterización</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_caracterizaciones_grupo_ec" tabindex="-1" role="dialog" aria-labelledby="label_modal_estudiantes_grupo" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="title_modal_caracterizaciones_grupo_ec"></h4>
				</div>
				<div class="modal-body">
					<form id="FORM_Observacion_car_ec">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<select id="SL_Caracterizaciones_Grupo_Emprende_Clan" name="SL_Caracterizaciones_Grupo_Emprende_Clan" class="form-control" required>
								</select>
							</div>
						</div>
						<div  class="row">
							<br>
						</div>
						<?php if (isset($_SESSION['session_usertype']) && ($_SESSION['session_usertype'] == '2' || $_SESSION['session_usertype'] == '5' || $_SESSION['session_usertype'] == '15')) {
							?>
							<div class="panel-success">
								<div style="background-color: #def9de;"  class="row" id="DIV_Observacion_car_ec" hidden>
									<br>
									<div class="col-md-12">
										<label>Observación
										</label>
									</div>
									<div class="col-md-12">
										<textarea class="form-control" rows="5"  type="" id="TXT_Observacion_car_ec" name="TXT_Observacion_car_ec" placeholder="Observación Sobre la Caracterización"></textarea>
										<br>
									</div>
									<div class="col-md-12">
										<label>Aprobado: </label>
										<input data-toggle="toggle" data-onstyle="success" name= "IN_Estado_car_ec" id="IN_Estado_car_ec" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox"  class="estado_check">
									</div>
									<div class="col-md-12  text-center">
										<button type="submit" id="BT_Observacion_car_ec" class="btn btn-primary" >Guardar Observación y/o Aprobación</button>
									</div>
									<br>
									<div  class="col-md-12">
										<br>
									</div>
								</div>
							</div>
							<?php
						} ?>
						<div  class="row">
							<br>
						</div>
						<div class="modal-footer">
							<button type="button" id="BT_ver_caracterizacion_ec" class="btn btn-primary" >Descargar Caracterización</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_caracterizaciones_grupo_lc" tabindex="-1" role="dialog" aria-labelledby="label_modal_estudiantes_grupo" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="title_modal_caracterizaciones_grupo_lc"></h4>
				</div>
				<div class="modal-body">
					<form id="FORM_Observacion_car_lc">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<select id="SL_Caracterizaciones_Grupo_Laboratorio_Clan" name="SL_Caracterizaciones_Grupo_Laboratorio_Clan" class="form-control" required>
								</select>
							</div>
						</div>
						<div  class="row">
							<br>
						</div>
						<?php if (isset($_SESSION['session_usertype']) && ($_SESSION['session_usertype'] == '2' || $_SESSION['session_usertype'] == '5' || $_SESSION['session_usertype'] == '15')) {
							?>
							<div class="panel-success">
								<div style="background-color: #def9de;"  class="row" id="DIV_Observacion_car_lc" hidden>
									<br>
									<div class="col-md-12">
										<label>Observación
										</label>
									</div>
									<div class="col-md-12">
										<textarea class="form-control" rows="5"  type="" id="TXT_Observacion_car_lc" name="TXT_Observacion_car_lc" placeholder="Observación Sobre la Caracterización"></textarea>
										<br>
									</div>
									<div class="col-md-12">
										<label>Aprobado: </label>
										<input data-toggle="toggle" data-onstyle="success" name= "IN_Estado_car_lc" id="IN_Estado_car_lc" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox"  class="estado_check">
									</div>
									<div class="col-md-12  text-center">
										<button type="submit" id="BT_Observacion_car_lc" class="btn btn-primary" >Guardar Observación y/o Aprobación</button>
									</div>
									<br>
									<div  class="col-md-12">
										<br>
									</div>
								</div>
							</div>
							<?php
						} ?>
						<div  class="row">
							<br>
						</div>
						<div class="modal-footer">
							<button type="button" id="BT_ver_caracterizacion_lc" class="btn btn-primary" >Descargar Caracterización</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_planeacion_grupo_ae" tabindex="-1" role="dialog" aria-labelledby="label_modal_estudiantes_grupo" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="title_modal_planeacion_grupo"></h4>
				</div>
				<div class="modal-body">
					<form id="FORM_Observacion_ae">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<select id="SL_Planeacion_Grupo_Arte_Escuela" name="SL_Planeacion_Grupo_Arte_Escuela" class="form-control" required>
								</select>
							</div>
						</div>
						<div  class="row">
							<br>
						</div>
						<?php if (isset($_SESSION['session_usertype']) && ($_SESSION['session_usertype'] == '2' || $_SESSION['session_usertype'] == '5' || $_SESSION['session_usertype'] == '15')) {
							?>

							<div class="panel-success">
								<div style="background-color: #def9de;" class="row" id="DIV_Observacion_ae" hidden>
									<br>
									<div class="col-md-12">
										<label>Observación
										</label>
									</div>
									<div class="col-md-12">
										<textarea class="form-control" rows="5"  type="" id="TXT_Observacion_ae" name="TXT_Observacion_ae" placeholder="Observación Sobre la Planeación"></textarea>
										<br>
									</div>
									<div class="col-md-12">
										<label>Aprobado: </label>
										<input data-toggle="toggle" data-onstyle="success" name= "IN_Estado_pl_ae" id="IN_Estado_pl_ae" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox"  class="estado_check">
									</div>
									<div class="col-md-12  text-center">
										<button type="submit" id="BT_Observacion_ae" class="btn btn-primary" >Guardar Observación y/o Aprobación</button>
									</div>
									<br>
									<div  class="col-md-12">
										<br>
									</div>
								</div>
							</div>
							<?php
						} ?>
						<div  class="row">
							<br>
						</div>
						<div class="modal-footer">
							<button type="button" id="BT_ver_Planeacion_ae" class="btn btn-primary" >Descargar Planeación</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="modal_planeacion_grupo_ec" tabindex="-1" role="dialog" aria-labelledby="label_modal_estudiantes_grupo" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="title_modal_planeacion_grupo_ec"></h4>
				</div>
				<div class="modal-body">
					<form id="FORM_Observacion_ec">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<select id="SL_Planeacion_Grupo_Emprende_Clan" name="SL_Planeacion_Grupo_Emprende_Clan" class="form-control" required>

								</select>
							</div>
						</div>
						<div  class="row">
							<br>
						</div>
						<?php if (isset($_SESSION['session_usertype']) && ($_SESSION['session_usertype'] == '2' || $_SESSION['session_usertype'] == '5' || $_SESSION['session_usertype'] == '15')) {
							?>
							<div class="panel-success">
								<div style="background-color: #def9de;"  class="row" id="DIV_Observacion_ec" hidden>
									<br>
									<div class="col-md-12">
										<label>Observación
										</label>
									</div>
									<div class="col-md-12">
										<textarea class="form-control" rows="5"  type="" id="TXT_Observacion_ec" name="TXT_Observacion_ec" placeholder="Observación Sobre la Planeación"></textarea>
										<br>
									</div>
									<div class="col-md-12">
										<label>Aprobado: </label>
										<input data-toggle="toggle" data-onstyle="success" name= "IN_Estado_pl_ec" id="IN_Estado_pl_ec" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox"  class="estado_check">
									</div>
									<div class="col-md-12  text-center">
										<button type="submit" id="BT_Observacion_ec" class="btn btn-primary" >Guardar Observación y/o Aprobación</button>
									</div>
									<br>
									<div  class="col-md-12">
										<br>
									</div>
								</div>
							</div>
							<?php
						} ?>
						<div  class="row">
							<br>
						</div>
						<div class="modal-footer">
							<button type="button" id="BT_ver_Planeacion_ec" class="btn btn-primary" >Descargar Planeación</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_planeacion_grupo_lc" tabindex="-1" role="dialog" aria-labelledby="label_modal_estudiantes_grupo" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="title_modal_planeacion_grupo_lc"></h4>
				</div>
				<div class="modal-body">
					<form id="FORM_Observacion_lc">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<select id="SL_Planeacion_Grupo_Laboratorio_Clan" name="SL_Planeacion_Grupo_Laboratorio_Clan" class="form-control" required>

								</select>
							</div>
						</div>
						<div  class="row">
							<br>
						</div>
						<?php if (isset($_SESSION['session_usertype']) && ($_SESSION['session_usertype'] == '2' || $_SESSION['session_usertype'] == '5' || $_SESSION['session_usertype'] == '15')) {
							?>
							<div class="panel-success">
								<div style="background-color: #def9de;"  class="row" id="DIV_Observacion_lc" hidden>
									<br>
									<div class="col-md-12">
										<label>Observación
										</label>
									</div>
									<div class="col-md-12">
										<textarea class="form-control" rows="5"  type="" id="TXT_Observacion_lc" name="TXT_Observacion_lc" placeholder="Observación Sobre la Planeación"></textarea>
										<br>
									</div>
									<div class="col-md-12">
										<label>Aprobado: </label>
										<input data-toggle="toggle" data-onstyle="success" name= "IN_Estado_pl_lc" id="IN_Estado_pl_lc" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox"  class="estado_check">
									</div>
									<div class="col-md-12  text-center">
										<button type="submit" id="BT_Observacion_lc" class="btn btn-primary" >Guardar Observación y/o Aprobación</button>
									</div>
									<br>
									<div  class="col-md-12">
										<br>
									</div>
								</div>
							</div>
							<?php
						} ?>
						<div  class="row">
							<br>
						</div>
						<div class="modal-footer">
							<button type="button" id="BT_ver_Planeacion_lc" class="btn btn-primary" >Descargar Planeación</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_valoracion_grupo_ae" tabindex="-1" role="dialog" aria-labelledby="label_modal_estudiantes_grupo" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="title_modal_valoracion_grupo"></h4>
				</div>
				<div class="modal-body">
					<form id="FORM_Observacion_Valoracion_ae">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<select id="SL_Valoracion_Grupo_Arte_Escuela" name="SL_Valoracion_Grupo_Arte_Escuela" class="form-control" required>
								</select>
							</div>
						</div>

						<?php if (isset($_SESSION['session_usertype']) && ($_SESSION['session_usertype'] == '2' || $_SESSION['session_usertype'] == '5' || $_SESSION['session_usertype'] == '15')) {
							?>
							<div class="panel-success">
								<div style="background-color: #def9de;"  class="row" id="DIV_Observacion_Valoracion_ae" hidden>
									<br>
									<div class="col-md-12">
										<label>Observación
										</label>
									</div>
									<div class="col-md-12">
										<textarea class="form-control" rows="5"  type="" id="TXT_Observacion_Valoracion_ae" name="TXT_Observacion_Valoracion_ae" placeholder="Observación Sobre la Planeación"></textarea>
										<br>
									</div>
									<div class="col-md-12">
										<label>Aprobado: </label>
										<input data-toggle="toggle" data-onstyle="success" name= "IN_Estado_val_ae" id="IN_Estado_val_ae" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox"  class="estado_check">
									</div>
									<div class="col-md-12  text-center">
										<button type="submit" id="BT_Observacion_ec" class="btn btn-primary" >Guardar Observación y/o Aprobación</button>
									</div>
									<br>
									<div  class="col-md-12">
										<br>
									</div>
								</div>
							</div>
							<?php
						} ?>
						<div  class="row">
							<br>
						</div>
						<div id="DIV_Anexo_ae" class="text-center row" hidden>

						</div>
						<div  class="row">
							<br>
						</div>
						<div class="modal-footer">
							<button type="button" id="BT_ver_Valoracion_ae" class="btn btn-primary" >Descargar Valoración</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_valoracion_grupo_ec" tabindex="-1" role="dialog" aria-labelledby="label_modal_estudiantes_grupo" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="title_modal_valoracion_grupo_ec"></h4>
				</div>
				<div class="modal-body">
					<form id="FORM_Observacion_Valoracion_ec">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<select id="SL_Valoracion_Grupo_Emprende_Clan" name="SL_Valoracion_Grupo_Emprende_Clan" class="form-control" required>

								</select>
							</div>
						</div>

						<?php if (isset($_SESSION['session_usertype']) && ($_SESSION['session_usertype'] == '2' || $_SESSION['session_usertype'] == '5' || $_SESSION['session_usertype'] == '15')) {
							?>
							<div class="panel-success">
								<div style="background-color: #def9de;"  class="row" id="DIV_Observacion_Valoracion_ec" hidden>
									<br>
									<div class="col-md-12">
										<label>Observación
										</label>
									</div>
									<div class="col-md-12">
										<textarea class="form-control" rows="5"  type="" id="TXT_Observacion_Valoracion_ae" name="TXT_Observacion_Valoracion_ae" placeholder="Observación Sobre la Planeación"></textarea>
										<br>
									</div>
									<div class="col-md-12">
										<label>Aprobado: </label>
										<input data-toggle="toggle" data-onstyle="success" name= "IN_Estado_val_ec" id="IN_Estado_val_ec" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox"  class="estado_check">
									</div>
									<div class="col-md-12  text-center">
										<button type="submit" id="BT_Observacion_ec" class="btn btn-primary" >Guardar Observación y/o Aprobación</button>
									</div>
									<br>
									<div  class="col-md-12">
										<br>
									</div>
								</div>
							</div>
							<?php
						} ?>
						<div  class="row">
							<br>
						</div>
						<div id="DIV_Anexo_ec" class="text-center row" hidden>
						</div>
						<div  class="row">
							<br>
						</div>
						<div class="modal-footer">
							<button type="button" id="BT_ver_Valoracion_ec" class="btn btn-primary" >Descargar Valoración</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
