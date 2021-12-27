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
	<title>Reportes circulación</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="Js/Reportes_Circulacion.js"></script>

	<script src="../../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../node_modules/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<link href="../../node_modules/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

	<script src="../../node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<link href="../../node_modules/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

	<script src="../../node_modules/datatables.net-buttons/js/dataTables.buttons.min.js"></script> 
	<script src="../../node_modules/datatables.net-buttons/js/buttons.html5.min.js"></script> 
	<script src="../../node_modules/jszip/dist/jszip.min.js"></script> 

	<script src="../../node_modules/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js"></script> 
	<link href="../../node_modules/datatables.net-fixedcolumns-bs/css/fixedColumns.bootstrap.min.css" rel="stylesheet">

	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>
	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">

	<script src="../../bower_components/pdfmake/build/pdfmake.js" type="text/javascript"></script>
	<script src="../../bower_components/pdfmake/build/vfs_fonts.js" type="text/javascript"></script>

</head>
<body>
	<?php include("../../LibreriasExternas/Analytics/analyticstracking.php"); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Reportes circulación</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#consulta-beneficiarios-registrados-evento" role="tab">Reporte beneficiarios registrados por evento</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#reporte-consolidado-evento" role="tab">Reporte consolidado eventos</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#reporte-consolidado-evento-equipo" role="tab">Reporte consolidado eventos por equipo</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#reporte-consolidado-atenciones-virtuales" role="tab">Reporte consolidado atenciones virtuales</a></li>
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#reporte-pandora" role="tab">Reporte Pandora</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="consulta-beneficiarios-registrados-evento" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Reporte beneficiarios registrados por evento</h4></div>
							</div>
						</div>
						<form id="form-reporte-evento-beneficiarios">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6">
										<label>Mes</label>
										<select class="form-control" id="SL_Mes_Reporte_Beneficiarios" title="Seleccione un mes"></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6 col-xs-offset-1 col-xs-10">
										<label>Evento</label>
										<select class="form-control selectpicker" id="SL_Evento_Consulta_Beneficiarios" title="Seleccione un evento" data-live-search="true"></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-4 col-lg-4">
										<button type="submit" class="btn btn-block btn-primary">Consultar</button>
									</div>
								</div>
							</div>
						</form>
						<div id="div-reporte-evento-beneficiarios" style="display: none;">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-12">
										<table id="tabla-reporte-evento-beneficiarios" class="table table-striped table-bordered table-hover nowrap" style="width: 100%;">
											<thead>
												<tr>
													<th>Nuevo/Antiguo</th>
													<th>Edad</th>
													<th>Rango de edad</th>
													<th>Fecha de nacimiento</th>
													<th>Género</th>
													<th>Enfoque diferencial</th>
													<th>Identificación</th>
													<th>Primer nombre</th>
													<th>Segundo nombre</th>
													<th>Primer apellido</th>
													<th>Segundo apellido</th>
													<th>Tipo identificación</th>
													<th>Nivel</th>
													<th>Estrato</th>
													<th>Lugar de atención</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="reporte-consolidado-evento" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Reporte consolidado eventos</h4></div>
							</div>
						</div>
						<form id="form-reporte-consolidado">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6">
										<label>Mes</label>
										<select class="form-control" id="SL_Mes_Reporte" title="Seleccione un mes"></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-4 col-lg-4">
										<button type="submit" class="btn btn-block btn-primary">Consultar</button>
									</div>
								</div>
							</div>
						</form>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12" id="div-reporte-evento" style="display: none;">
									<div class="row">
										<div class="col-xs-12 col-md-12">
											<table id="tabla-reporte-evento" class="table table-striped table-bordered table-hover" width="100%" style="font-size: 12px;">
												<thead>
													<tr>
														<th rowspan="2" style="background-color: #fff2cc;">Fecha</th>
														<th rowspan="2" style="background-color: #fff2cc;">Evento</th>
														<th rowspan="2" style="background-color: #fff2cc;">Lugar</th>
														<th rowspan="2" style="background-color: #fff2cc;">Equipos asignados</th>
														<th rowspan="2" style="background-color: #fff2cc;">Tipo lugar</th>
														<th rowspan="2" style="background-color: #fff2cc;">Localidad</th>
														<th rowspan="2" style="background-color: #fff2cc;">Upz</th>
														<th rowspan="2" style="background-color: #fff2cc;">Barrio</th>
														<th rowspan="2" style="background-color: #fff2cc;">Modalidad de atención</th>
														<th rowspan="2" style="background-color: #fff2cc;">No artistas</th>
														<th rowspan="2" style="background-color: #fff2cc;">No grupos</th>
														<th rowspan="2" style="background-color: #fff2cc;">No experiencias</th>
														<th rowspan="2" style="background-color: #fff2cc;">No cuidadores</th>
														<th colspan="11" style="background-color: #93c47d;">Beneficiarios nuevos</th>
														<th colspan="18" style="background-color: #93c47d;">Enfoque diferencial beneficiarios nuevos</th>
														<th colspan="11" style="background-color: #ff9900;">Beneficiarios sin información</th>
														<th colspan="11" style="background-color: #d5a6bd;">Beneficiarios reales</th>
														<th colspan="18" style="background-color: #d5a6bd;">Enfoque diferencial beneficiarios reales</th>
														<th colspan="3">Acciones</th>
													</tr>
													<tr>
														<th style="background-color: #b6d7a8;">Niños 1-3</th>
														<th style="background-color: #b6d7a8;">Niñas 1-3</th>
														<th style="background-color: #93c47d;">Total niños 1-3</th>
														<th style="background-color: #b6d7a8;">Niños 4-5</th>
														<th style="background-color: #b6d7a8;">Niñas 4-5</th>
														<th style="background-color: #93c47d;">Total Niños 4-5</th>
														<th style="background-color: #b6d7a8;">Niños fuera de rango</th>
														<th style="background-color: #b6d7a8;">Niñas fuera de rango</th>
														<th style="background-color: #93c47d;">Total Niños fuera de rango</th>
														<th style="background-color: #b6d7a8;">Gestantes</th>
														<th style="background-color: #93c47d;">Total nuevos</th>

														<th style="background-color: #b6d7a8;">Comunidad rural y campesina</th>
														<th style="background-color: #b6d7a8;">Indígena</th>
														<th style="background-color: #b6d7a8;">Afrodescendiente</th>
														<th style="background-color: #b6d7a8;">Rrom</th>
														<th style="background-color: #b6d7a8;">Raizal</th>
														<th style="background-color: #b6d7a8;">Palenquera</th>
														<th style="background-color: #b6d7a8;">Comunidades negras</th>
														<th style="background-color: #b6d7a8;">Población carcelaria</th>
														<th style="background-color: #b6d7a8;">Situación o condición de discapacidad</th>
														<th style="background-color: #b6d7a8;">Personas habitantes de calle</th>
														<th style="background-color: #b6d7a8;">Personas que ejercen actividades sexuales pagadas</th>
														<th style="background-color: #b6d7a8;">Población victima del conflicto</th>
														<th style="background-color: #b6d7a8;">Personas en situación de desplazamiento</th>
														<th style="background-color: #b6d7a8;">Población migrante</th>
														<th style="background-color: #b6d7a8;">Familias ubicadas en zonas de deterioro urbano</th>
														<th style="background-color: #b6d7a8;">Familias en emergencia social y catastrófica</th>
														<th style="background-color: #b6d7a8;">Sectores LGBTIQ</th>
														<th style="background-color: #93c47d;">Total enfoque nuevos</th>

														<th style="background-color: #ffb545;">Niños 1-3</th>
														<th style="background-color: #ffb545;">Niñas 1-3</th>
														<th style="background-color: #ff9900;">Total niños 1-3</th>
														<th style="background-color: #ffb545;">Niños 4-5</th>
														<th style="background-color: #ffb545;">Niñas 4-5</th>
														<th style="background-color: #ff9900;">Total niños 4-5</th>
														<th style="background-color: #ffb545;">Niños mayores a 6</th>
														<th style="background-color: #ffb545;">Niñas mayores a 6</th>
														<th style="background-color: #ff9900;">Total niños mayores a 6</th>
														<th style="background-color: #ffb545;">Gestantes</th>
														<th style="background-color: #ff9900;">Total niños sin información</th>

														<th style="background-color: #ead1dc;">Niños 1-3</th>
														<th style="background-color: #ead1dc;">Niñas 1-3</th>
														<th style="background-color: #d5a6bd;">Total niños 1-3</th>
														<th style="background-color: #ead1dc;">Niños 4-5</th>
														<th style="background-color: #ead1dc;">Niñas 4-5</th>
														<th style="background-color: #d5a6bd;">Total Niños 4-5</th>
														<th style="background-color: #ead1dc;">Niños fuera de rango</th>
														<th style="background-color: #ead1dc;">Niñas fuera de rango</th>
														<th style="background-color: #d5a6bd;">Total Niños fuera de rango</th>
														<th style="background-color: #ead1dc;">Gestantes</th>
														<th style="background-color: #d5a6bd;">Total real</th>

														<th style="background-color: #ead1dc;">Comunidad rural y campesina</th>
														<th style="background-color: #ead1dc;">Indígena</th>
														<th style="background-color: #ead1dc;">Afrodescendiente</th>
														<th style="background-color: #ead1dc;">Rrom</th>
														<th style="background-color: #ead1dc;">Raizal</th>
														<th style="background-color: #ead1dc;">Palenquera</th>
														<th style="background-color: #ead1dc;">Comunidades negras</th>
														<th style="background-color: #ead1dc;">Población carcelaria</th>
														<th style="background-color: #ead1dc;">Situación o condición de discapacidad</th>
														<th style="background-color: #ead1dc;">Personas habitantes de calle</th>
														<th style="background-color: #ead1dc;">Personas que ejercen actividades sexuales pagadas</th>
														<th style="background-color: #ead1dc;">Población victima del conflicto</th>
														<th style="background-color: #ead1dc;">Personas en situación de desplazamiento</th>
														<th style="background-color: #ead1dc;">Población migrante</th>
														<th style="background-color: #ead1dc;">Familias ubicadas en zonas de deterioro urbano</th>
														<th style="background-color: #ead1dc;">Familias en emergencia social y catastrófica</th>
														<th style="background-color: #ead1dc;">Sectores LGBTIQ</th>
														<th style="background-color: #d5a6bd;">Total enfoque real</th>
														
														<th>Observaciones</th>
														<th>Listado de asistencia</th>
														<th>Aprobación</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="reporte-consolidado-evento-equipo" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Reporte consolidado eventos por equipo</h4></div>
							</div>
						</div>
						<form id="form-reporte-pdf">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6">
										<label>Equipo</label>
										<select class="form-control" id="SL_Dupla" title="Seleccione un equipo" required></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6">
										<label>Mes</label>
										<select class="form-control" id="SL_Mes_Reporte_Pdf" title="Seleccione un mes" required></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-4 col-lg-4">
										<button type="submit" class="btn btn-block btn-primary" id="BTN_Reporte_Equipo">Descargar reporte</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="reporte-consolidado-atenciones-virtuales" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Reporte consolidado atenciones virtuales</h4></div>
							</div>
						</div>
						<form id="form-reporte-atenciones-virtuales">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6">
										<label>Mes</label>
										<select class="form-control" id="SL_Mes_Reporte_Atenciones_virtuales" title="Seleccione un mes"></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-4 col-lg-4">
										<button type="submit" class="btn btn-block btn-primary">Consultar</button>
									</div>
								</div>
							</div>
						</form>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12" id="div-reporte-atenciones-virtuales" style="display: none;">
									<table id="tabla-reporte-atenciones-virtuales" class="table table-striped table-bordered table-hover" width="100%" style="font-size: 12px;">
										<thead>
											<tr>
												<th>#</th>
												<th>Fecha atención</th>
												<th>Horario</th>					
												<th>Tipo de atención</th>
												<th>A quién va dirigida</th>
												<th>Localidad</th>
												<th>Upz</th>											
												<th>Barrio</th>
												<th>Dirección</th>					
												<th>Estrato</th>
												<th>Nombre cuidador</th>
												<th>Identificación cuidador</th>
												<th>Correo</th>
												<th>Edad cuidador</th>				
												<th>Parentesco</th>
												<th>Potestad</th>
												<th>Identificación beneficiario</th>	
												<th>Nombre beneficiario</th>
												<th>Fecha nacimiento</th>				
												<th>Edad</th>
												<th>Enfoque</th>
												<th>Institución</th>
												<th>Entidad</th>
												<th>Celular</th>						
												<th>Comentarios</th>
												<th>Autorización</th>
												<th>Formulario</th>					
												<th>Artista comunitario</th>
												<th>Duración llamada</th>			
												<th>Material narrado</th>
												<th>¿Que les parecio la lectura?</th>	
												<th>¿Cómo reacciono tu hij@?</th>
												<th>Observaciones</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>	
							</div>
						</div>
					</div>
					<div class="tab-pane" id="reporte-pandora" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Reporte Pandora</h4></div>
							</div>
						</div>
						<form id="form-reporte-pandora">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-3 col-lg-6">
										<label>Mes</label>
										<select class="form-control" id="SL_Mes_Reporte_Pandora" title="Seleccione un mes"></select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-offset-4 col-lg-4">
										<button type="submit" class="btn btn-block btn-primary">Consultar</button>
									</div>
								</div>
							</div>
						</form>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12" id="div-reporte-pandora" style="display: none;">
									<table id="tabla-reporte-pandora" class="table table-striped table-bordered table-hover" width="100%" style="font-size: 12px;">
										<thead>
											<tr>
												<th rowspan="2" style="background-color: #deeaf6;">Evento</th>
												<th rowspan="2" style="background-color: #deeaf6;">Descripción actividad</th>
												<th rowspan="2" style="background-color: #deeaf6;">Modalidad de la actividad</th>
												<th rowspan="2" style="background-color: #deeaf6;">Dimensión/Proceso</th>
												<th rowspan="2" style="background-color: #deeaf6;">TipologÍa Actividad</th>
												<th rowspan="2" style="background-color: #deeaf6;">NÚmero actividades</th>
												<th rowspan="2" style="background-color: #deeaf6;">Fecha realización de la actividad</th>
												<th rowspan="2" style="background-color: #deeaf6;">Enfoque poblacional diferencial</th>
												<th rowspan="2" style="background-color: #deeaf6;">Lugar de atención</th>
												<th rowspan="2" style="background-color: #deeaf6;">Espacio público</th>
												<th rowspan="2" style="background-color: #deeaf6;">Capacidad/aforo</th>
												<th rowspan="2" style="background-color: #deeaf6;">Localidad</th>
												<th rowspan="2" style="background-color: #deeaf6;">Upz</th>
												<th rowspan="2" style="background-color: #deeaf6;">Barrio</th>
												<th rowspan="2" style="background-color: #deeaf6;">Impacto territorial</th>
												<th rowspan="2" style="background-color: #deeaf6;">Origen iniciativa</th>
												<th rowspan="2" style="background-color: #deeaf6;">Modalidad uso equipamiento</th>
												<th rowspan="2" style="background-color: #deeaf6;">Evento gratuito o Pago</th>
												<th rowspan="2" style="background-color: #deeaf6;">Número de artistas remunerados</th>
												<th rowspan="2" style="background-color: #deeaf6;">Número total de artistas en la actividad</th>
												<th rowspan="2" style="background-color: #deeaf6;">Personas inscritas a la actividad</th>
												<th rowspan="2" style="background-color: #deeaf6;">Mujeres</th>
												<th rowspan="2" style="background-color: #deeaf6;">Hombres</th>
												<th rowspan="2" style="background-color: #deeaf6;">Otro</th>
												<th rowspan="2" style="background-color: #deeaf6;">Total beneficiarios</th>
												<th colspan="6" style="background-color: #8eaadb;">Sectores etarios</th>
												<th colspan="16" style="background-color: #a8d08d;">Sectores sociales</th>
												<th colspan="7" style="background-color: #b4c6e7;">Grupos étnicos</th>
												<th rowspan="2" style="background-color: #fff2cc;">Observaciones</th>
											</tr>
											<tr>
												<th style="background-color: #8eaadb;">Primera Infancia entre 0 y 5 años</th>
												<th style="background-color: #8eaadb;">Infancia y 6-12 años</th>
												<th style="background-color: #8eaadb;">Adolescencia 13-17 años</th>
												<th style="background-color: #8eaadb;">Juventud 18-28 años</th>
												<th style="background-color: #8eaadb;">Personas Adultas 29-59 años</th>
												<th style="background-color: #8eaadb;">Personas Mayores 60 años en adelante</th>
												<th style="background-color: #a8d08d;">Comunidades Campesinas y Rurales</th>
												<th style="background-color: #a8d08d;">Mujeres Gestantes y Lactantes</th>
												<th style="background-color: #a8d08d;">Personas que ejercen actividades sexuales pagadas</th>
												<th style="background-color: #a8d08d;">Personas habitantes de calle</th>
												<th style="background-color: #a8d08d;">Personas con discapacidad</th>
												<th style="background-color: #a8d08d;">Personas privadas de la libertad</th>
												<th style="background-color: #a8d08d;">Profesionales del Sector</th>
												<th style="background-color: #a8d08d;">Sectores LGBTIQ</th>
												<th style="background-color: #a8d08d;">Personas víctimas del conflicto armado</th>
												<th style="background-color: #a8d08d;">Población migrante</th>
												<th style="background-color: #a8d08d;">Personas víctimas de trata</th>
												<th style="background-color: #a8d08d;">Familias En Emergencia Social Y Catastrófica</th>
												<th style="background-color: #a8d08d;">Familias Ubicadas En Zonas De Deterioro Urbano</th>
												<th style="background-color: #a8d08d;">Familias En Situación De Vulnerabilidad</th>
												<th style="background-color: #a8d08d;">Personas En Situación De Desplazamiento</th>
												<th style="background-color: #a8d08d;">Personas Consumidoras De Sustancias Psicoactivas</th>
												<th style="background-color: #b4c6e7;">Pueblo Rrom – Gitano</th>
												<th style="background-color: #b4c6e7;">Pueblo Rrom – Gitano (Prorrom)</th>
												<th style="background-color: #b4c6e7;">Pueblo y/o comunidad indígena</th>
												<th style="background-color: #b4c6e7;">Comunidades negras</th>
												<th style="background-color: #b4c6e7;">Población afrodescendiente</th>
												<th style="background-color: #b4c6e7;">Comunidades palenqueras</th>
												<th style="background-color: #b4c6e7;">Pueblo raizal</th>
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
</body>
</html>