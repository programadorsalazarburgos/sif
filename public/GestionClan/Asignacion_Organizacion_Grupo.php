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
    
    <script type="text/javascript" src="Js/Asignacion_Organizacion_Grupo.js?v=2018.09.15"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Grupos activos sin Organización<small> CREA 2018</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-tipo_grupo="arte_escuela" data-toggle="tab" href="#grupos_arte_escuela" role="tab">Arte en la escuela</a></li>
					<li class="nav-item"><a class="nav-link" data-tipo_grupo="emprende_clan" data-toggle="tab" href="#grupos_emprende_clan" role="tab">Impulso Colectivo</a></li>
					<li class="nav-item"><a class="nav-link" data-tipo_grupo="laboratorio_clan" data-toggle="tab" href="#grupos_laboratorio_clan" role="tab">Converge</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="grupos_arte_escuela" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>ARTE EN LA ESCUELA <small>Asignar Organización a grupo</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<table id="table_grupos_arte_escuela" class="table table-hover">
										<thead>
											<tr>
												<th class="text-center"><strong>N°</strong></th>
												<th class="text-center"><strong>CREA</strong></th>
												<th class="text-center"><strong>Horario</strong></th>
												<th class="text-center"><strong>Area Artistica</strong></th>
												<th class="text-center"><strong>Organización</strong></th>
												<th class="text-center"><strong>Formador</strong></th>
												<th class="text-center"><strong>Colegio</strong></th>
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
								<h4>IMPULSO COLECTIVO <small>Asignar Organización a grupo</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<table id="table_grupos_emprende_clan" class="table table-hover">
										<thead>
											<tr>
												<th class="text-center"><strong>N°</strong></th>
												<th class="text-center"><strong>CREA</strong></th>
												<th class="text-center"><strong>Horario</strong></th>
												<th class="text-center"><strong>Area Artistica</strong></th>
												<th class="text-center"><strong>Organización</strong></th>
												<th class="text-center"><strong>Formador</strong></th>
												<th class="text-center"><strong>Modalidad</strong></th>
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
								<h4>CONVERGE <small>Asignar Organización a grupo</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<table id="table_grupos_laboratorio_clan" class="table table-hover">
										<thead>
											<tr>
												<th class="text-center"><strong>N°</strong></th>
												<th class="text-center"><strong>CREA</strong></th>
												<th class="text-center"><strong>Horario</strong></th>
												<th class="text-center"><strong>Area Artistica</strong></th>
												<th class="text-center"><strong>Organización</strong></th>
												<th class="text-center"><strong>Formador</strong></th>
												<th class="text-center"><strong>Lugar Atencion</strong></th>
												<th class="text-center"><strong>Poblacion</strong></th>

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
		<div class="modal fade" id="modal_buscar_organizacion" tabindex="-1" role="dialog" aria-labelledby="label_modal_buscar_organizacion" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="title_modal_buscar_organizacion"></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_organizacion">Organización</label>
							</div>
							<div class='col-xs-12 col-md-9'>
								<select class="form-control selectplicker" id="SL_organizacion" data-live-search="true"></select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
					<button type="button" id="BT_confirmar_asignacion_organizacion_grupo" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>