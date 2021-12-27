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
	<title>Consultar Novedades de Grupos</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">
	<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../LibreriasExternas/alertifyjs/css/alertify.min.css">
	<script type="text/javascript" src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
    <link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="Js/Consultar_Novedades_Grupos.js?v=31.08.2021.01"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consulta de Novedades AF - Grupo por <small> CREA 2017</small></h1>
				</div>
				<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<label for="SL_clan">Seleccione el año:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_Ano" class="form-control selectpicker">
							<?php for($i=2017;$i<=date("Y");$i++): ?>
							<option value="<?= $i ?>" <?php if($i==date("Y")) echo ' selected'; ?>><?= $i ?></option>							
							<?php endfor; ?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_mes">Seleccione el mes:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select id="SL_mes" class="form-control"></select>
					</div>
				</div>
				<div class="row">	  					
					<div class="col-xs-8 col-md-3">
						<label for="SL_clan">Seleccione el CREA:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_clan" multiple="multiple" class="form-control selectpicker" data-actions-box="true" selectAllText="Seleccionar Todos" deselectAllText="Deselccionar Todos" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12 alert alert-warning">
						<p>
							A continuación va a encontrar todas las novedades de Artistas formadores en sesiones de clase buscando por CREA, puede usar la celda <b>Filtrar</b> para encontrar los grupos pertenecientes a un AF en particular, un grupo, tipo de novedad, Área Artística, Colegio entre otro.
						</p>
					</div>
				</div>
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#grupos_arte_escuela" role="tab" id="gruposArteEscuela">Arte en la escuela</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#grupos_emprende_clan" role="tab" id="gruposEmprendeClan">Impulso Colectivo</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#grupos_laboratorio_clan" role="tab" id="gruposLaboratorioClan">Converge</a></li> 
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="grupos_arte_escuela" role="tabpanel">
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
												<th class="text-center"><strong>Grupo</strong></th>
												<th class="text-center"><strong>Crea</strong></th>
												<th class="text-center"><strong>Artista Formador</strong></th>
												<th class="text-center"><strong>Novedad</strong></th>										
												<th class="text-center"><strong>Fecha Sesión</strong></th>
												<th class="text-center"><strong>Asistencia</strong></th>
												<th class="text-center"><strong>Observación</strong></th>
												<th class="text-center"><strong>Area Artistica</strong></th>
												<th class="text-center"><strong>Tipo Grupo</strong></th>
												<th class="text-center"><strong>Colegio</strong></th>
												<th class="text-center"><strong>Organización</strong></th>
												<th class="text-center"><strong>Lugar de Atención</strong></th>							
												<th class="text-center"><strong>Fecha Creación</strong></th>			
												<th class="text-center"><strong>Estado</strong></th>										
												<th class="text-center"><strong>Fecha Cierre</strong></th>		
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
												<th class="text-center"><strong>Grupo</strong></th>
												<th class="text-center"><strong>Crea</strong></th>
												<th class="text-center"><strong>Artista Formador</strong></th>
												<th class="text-center"><strong>Novedad</strong></th>										
												<th class="text-center"><strong>Fecha</strong></th>
												<th class="text-center"><strong>Asistencia</strong></th>
												<th class="text-center"><strong>Observación</strong></th>									
												<th class="text-center"><strong>Area Artistica</strong></th>
												<th class="text-center"><strong>Tipo Grupo</strong></th>
												<th class="text-center"><strong>Modalidad</strong></th>
												<th class="text-center"><strong>Organización</strong></th>
												<th class="text-center"><strong>Fecha Creación</strong></th>			
												<th class="text-center"><strong>Estado</strong></th>		
												<th class="text-center"><strong>Fecha Cierre</strong></th>								
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
								<h4>CONVERGE <small>Detalle Novedades Grupos</small></h4>
							</div> 
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<table id="table_grupos_laboratorio_clan" class="table table-hover" style="width: 100%;">
										<thead>
											<tr>
												<th class="text-center"><strong>Grupo</strong></th>
												<th class="text-center"><strong>Crea</strong></th>
												<th class="text-center"><strong>Artista Formador</strong></th>
												<th class="text-center"><strong>Novedad</strong></th>										
												<th class="text-center"><strong>Fecha</strong></th>
												<th class="text-center"><strong>Asistencia</strong></th>
												<th class="text-center"><strong>Observación</strong></th>									
												<th class="text-center"><strong>Area Artistica</strong></th>
												<th class="text-center"><strong>Lugar de Atención</strong></th>
												<th class="text-center"><strong>Organización</strong></th>
												<th class="text-center"><strong>Fecha Creación</strong></th>			
												<th class="text-center"><strong>Estado</strong></th>		
												<th class="text-center"><strong>Fecha Cierre</strong></th>								
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