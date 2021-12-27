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
	<title>Asignar Artista Formador Grupo</title>
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
    
    <script type="text/javascript" src="Js/Asignacion_Artista_Formador_Grupo.js?v=2020.08.13"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Grupos activos asignados a la organización <small class="title_nombre_organizacion"></small></h1>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_organizacion">Organización:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select class="form-control selectpicker" title="Seleecione una organización" data-live-search="true" name="SL_organizacion" id="SL_organizacion"></select>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_crea">Crea:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select class="form-control selectpicker" data-actions-box="true" title="Seleecione uno o varios creas" data-live-search="true" multiple="multiple" name="SL_crea" id="SL_crea"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_area_artistica">Área Artística:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select class="form-control selectpicker" data-actions-box="true" title="Seleecione una o varias áreas" data-live-search="true" multiple="multiple" name="SL_area_artistica" id="SL_area_artistica"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_colegio">Colegio:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select class="form-control selectpicker" title="Seleecione uno o varios colegios (Vacio si no aplica)" multiple="multiple" data-live-search="true" name="SL_colegio" id="SL_colegio"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12 alert alert-warning">
						<p>Haga clic en cada una de las pestañas correspondientes a las líneas de atención para obtener la información de los grupos.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item" data-tipo_grupo="arte_escuela"><a class="nav-link" data-toggle="tab" href="#grupos_arte_escuela" role="tab">Arte en la escuela</a></li>
							<li class="nav-item" data-tipo_grupo="emprende_clan"><a class="nav-link" data-toggle="tab" href="#grupos_emprende_clan" role="tab">Impulso Colectivo</a></li>
							<li class="nav-item" data-tipo_grupo="laboratorio_clan"><a class="nav-link" data-toggle="tab" href="#grupos_laboratorio_clan" role="tab">Converge</a></li>
						</ul>
					</div>
				</div>
				<div class="container-fluid">
					<div class="tab-content">
						<div class="tab-pane" id="grupos_arte_escuela" role="tabpanel">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>ARTE EN LA ESCUELA <small>Asignar Artista Formador a grupo</small></h4>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-md-12">
									<div class="table-responsive">
										<table id="table_grupos_arte_escuela" class="table table-hover">
											<thead>
												<tr>
													<th class="text-center"><strong>Grupo</strong></th>
													<th class="text-center"><strong>Zona</strong></th>
													<th class="text-center"><strong>CREA</strong></th>
													<th class="text-center"><strong>Area Artistica</strong></th>
													<th class="text-center"><strong>Colegio</strong></th>
													<th class="text-center"><strong>Artista Formador</strong></th>
													<th class="text-center"><strong>Fecha Creación</strong></th>
													<th class="text-center"><strong>Horario</strong></th>
													<th class="text-center"><strong>Observaciones</strong></th>
													<th class="text-center"><strong>Opciones</strong></th>
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
									<h4>IMPULSO COLECTIVO <small>Asignar Artista Formador a grupo</small></h4>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-md-12">
									<div class="table-responsive">
										<table id="table_grupos_emprende_clan" class="table table-hover">
											<thead>
												<tr>
													<th class="text-center"><strong>Grupo</strong></th>
													<th class="text-center"><strong>Zona</strong></th>
													<th class="text-center"><strong>CREA</strong></th>
													<th class="text-center"><strong>Area Artistica</strong></th>
													<th class="text-center"><strong>Modalidad</strong></th>
													<th class="text-center"><strong>Artista Formador</strong></th>
													<th class="text-center"><strong>Fecha Creación</strong></th>
													<th class="text-center"><strong>Horario</strong></th>
													<th class="text-center"><strong>Observaciones</strong></th>
													<th class="text-center"><strong>Opciones</strong></th>
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
									<h4>CONVERGE <small>Asignar Artista Formador a grupo</small></h4>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-md-12">
									<div class="table-responsive">
										<table id="table_grupos_laboratorio_clan" class="table table-hover">
											<thead>
												<tr>
													<th class="text-center"><strong>Grupo</strong></th>
													<th class="text-center"><strong>Zona</strong></th>
													<th class="text-center"><strong>CREA</strong></th>
													<th class="text-center"><strong>Area Artistica</strong></th>
													<th class="text-center"><strong>Lugar atención</strong></th>
													<th class="text-center"><strong>Tipo Población</strong></th>
													<th class="text-center"><strong>Artista Formador</strong></th>
													<th class="text-center"><strong>Fecha Creación</strong></th>
													<th class="text-center"><strong>Horario</strong></th>
													<th class="text-center"><strong>Observaciones</strong></th>
													<th class="text-center"><strong>Opciones</strong></th>
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
		<div class="modal fade" id="modal_buscar_artista_formador" tabindex="-1" role="dialog" aria-labelledby="label_modal_buscar_artista_formador" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="title_modal_buscar_artista_formador"></h4>
					</div>
					<div class="modal-body">
						<div id="div_filtros_artista_clan">
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="SL_area_artistica">Area Artistica:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select class="form-control selectpicker" data-live-search="true" id="SL_area_artistica"></select>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="SL_zona">Zona:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select class="form-control selectpicker" data-live-search="true" id="SL_zona"></select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_artista_formador">Artista Formador: </label>
							</div>
							<div class='col-xs-12 col-md-9'>
								<select class="form-control selectpicker" data-live-search="true" id="SL_artista_formador"></select>
								<?php echo "<input type='hidden' id='id_usuario' value='".$Id_Persona."'>"; ?>
								<input type="hidden" id="tipo_grupo">
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
</body>
</html>
