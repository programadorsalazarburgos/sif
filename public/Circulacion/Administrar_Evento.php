<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Administrar Evento</title>

	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>	

	<link href="../bower_components/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript" ></script>

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>  

	<script type="text/javascript" src="Js/Administrar_Evento.js?v=2020.07.08"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="text-center panel-title"> ADMINISTRACIÓN DE EVENTOS</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#nuevo_evento" id="nuevo_evento_tab" role="tab">Crear Evento</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#modificar_evento" id="modificar_evento_tab" role="tab">Modificar Evento</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#administrar_artistas_eventos_mi_crea" id="administrar_artistas_eventos_mi_crea_tab" role="tab">Administrar artistas de eventos asociados a mi CREA</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#asignacion_participantes_evento" id="asignacion_participantes_evento_tab" role="tab">Asignar participantes evento distrital</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#registrar_asistencia_evento" id="registrar_asistencia_evento_tab" role="tab">Registrar Asistencia Evento</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="nuevo_evento" role="tabpanel"></div>
					<div class="tab-pane" id="modificar_evento" role="tabpanel"></div>
					<div class="tab-pane" id="administrar_artistas_eventos_mi_crea" role="tabpanel"></div>
					<div class="tab-pane" id="asignacion_participantes_evento" role="tabpanel"></div>
					<div class="tab-pane" id="registrar_asistencia_evento" role="tabpanel"></div>
				</div>
			</div>
		</div>
	</div>
	<div id="modal_agregar_artista_formador" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Agregar artista formador a evento</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="TX_artista_formador_buscar">Documento o nombre del artista</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<div class="input-group">
								<input type="text" id="TX_artista_formador_buscar" placeholder="Documento o nombre del artista" class="mayuscula form-control">
								<span class="input-group-addon btn btn-info" id="BT_buscar_artista_formador">
									<span class="glyphicon glyphicon-search"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-12 table-responsive">
							<table class='table table-striped table-bordered' id='table_nuevo_artista_evento'>
								<thead><tr>
									<th>Identificación</th>
									<th>Nombre</th>
									<th>Asignar</th>
								</tr></thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_formulario_completar_aforo" tabindex="-1" role="dialog" aria-labelledby="label_modal_formulario_completar_aforto" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" id="contenido_modal_formulario_aforo">
				<form id="form_confirmar_aforo_evento">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Confirmar Aforo</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="IN_nna">NNA (Niños, Niñas y Adolescentes)</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<input class="form-control" type="number" name="IN_nna" id="IN_nna" min="0" value="1">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="IN_padres">Padres</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<input class="form-control" type="number" name="IN_padres" id="IN_padres" min="0" value="1">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="IN_publico">Público</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<input type="number" class="form-control" name="IN_publico" id="IN_publico" min="0" value="1">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<input id="BT_submit_confirmar_aforo" type="submit" class="form-control btn btn-primary" value="Confirmar Aforo y Cerrar Evento" />
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>