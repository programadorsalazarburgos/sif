<?php
	session_start();
	if(!isset($_SESSION["session_username"])) {
		header("location:index.php");
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Administrar Actividades</title>

  	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  
  	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
  	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 

  	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css?v=1.12.1" rel="stylesheet" type="text/css" >  
  	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>
    

  	<link href="../bower_components/alertifyjs/build/css/alertify.css?v=1" rel="stylesheet" type="text/css" >
  	<script src="../bower_components/alertifyjs/build/alertify.min.js?v=1"></script>
  	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

	<script src="Js/Administrar_Actividades.js?v=2020.04.27" type="text/javascript" ></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Administración de actividades <small>Menú SIF</small></h1>
			</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-3 col-md-3">
					<button class="form-control btn btn-success" data-toggle='modal' data-target='#modal-nueva-actividad'>Crear nueva actividad</button>
				</div>
				<div class="col-xs-3 col-xs-offset-2 col-md-3 col-md-offset-2">
					<button class="form-control btn-warning" data-toggle='modal' data-target='#modal-editar_nombre_actividad'>Editar/Desactivar actividad</button>
				</div>
				<div class="col-xs-3 col-xs-offset-1 col-md-3 col-md-offset-1">
					<button class="form-control btn-info" style="height: auto;" data-toggle='modal' data-target='#modal-usuarios-asociados-actividad'>Usuarios asociados a actividad <b>Individualmente</b></button>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<div class="row">
				<div class="col-xs-12" id="mensaje_operacion"></div>
			</div>
		</div>
	</div>
	<div class='modal fade' role='dialog' id='modal-nueva-actividad'>
		<div class='modal-dialog modal-lg'>
			<!-- Modal content-->
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'>&times;</button>
					<h4 class='modal-title'>Crear nueva Actividad</h4>
				</div>
				<div class='modal-body'>
					<form id="form_nueva_actividad">
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="nombre_nueva_actividad">Nombre:</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<input type="text" required="required" class="form-control" placeholder="Nombre de la Actividad" id="nombre_nueva_actividad" name="nombre">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="pagina_nueva_actividad">Página (URL):</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<input type="text" required="required" class="form-control" placeholder="Página (URL)" id="pagina_nueva_actividad" name="pagina_url">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							Módulo:
						</div>
						<div class="col-xs-12 col-md-9">
							<select class="form-control selectpicker" data-live-search="true" required="required" id="SL_modulo" name="id_modulo"></select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
							<input type="submit" value="Guardar" class="form-control btn btn-success">
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class='modal fade' role='dialog' id='modal-editar_nombre_actividad'>
		<div class='modal-dialog modal-lg'>
			<!-- Modal content-->
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'>&times;</button>
					<h4 class='modal-title'>Editar Actividad</h4>
				</div>
				<div class='modal-body'>
					<form id="form_editar_actividad">
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_actividad_editar">Seleccione actividad:</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<select id="SL_actividad_editar" name="SL_actividad_editar" name="PK_actividad_editar" class="form-control selectpicker" data-live-search="true"></select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<div class="col-xs-12 col-md-12">
								<div class="alert alert-warning">
								  <strong>Modifique</strong> los datos como sea necesario o haga clic en el botón de desactivar para remover la actividad.
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="nombre_actividad_editar">Nombre:</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<input type="text" required="required" class="form-control" placeholder="Nombre de la Actividad" id="nombre_actividad_editar" name="nombre_actividad_editar">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="page_actividad_editar">Página (URL):</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<input type="text" required="required" class="form-control" placeholder="Página (URL)" id="page_actividad_editar" name="page_actividad_editar">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_modulo_actividad_editar">Módulo:</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<select class="form-control selectpicker" data-live-search="true" required="required" id="SL_modulo_actividad_editar" name="SL_modulo_actividad_editar"></select>
						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_modulo_actividad_editar">Mantenimiento:</label>
						</div>					
						<div class="col-xs-12 col-md-9 m-20" style="margin-bottom: 20px;">
							<input id='CH_mantenimiento' data-toggle="toggle" data-onstyle="success" name= "CH_mantenimiento[]" data-on="SI" data-off="NO" type="checkbox" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3 col-xs-offset-2 col-md-3 col-md-offset-2">
							<input type="submit" value="Modificar Actividad" class="form-control btn btn-success">
						</div>
						<div class="col-xs-3 col-xs-offset-2 col-md-3 col-md-offset-2">
							<a href="#" id="BT_desactivar_actividad" class="btn btn-danger form-control">Desactivar Actividad</a>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class='modal fade' role='dialog' id='modal-usuarios-asociados-actividad'>
		<div class='modal-dialog modal-lg'>
			<!-- Modal content-->
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal'>&times;</button>
					<h4 class='modal-title'>Consultar usuarios asociados a actividad de manera <b>individual</b> a su respectivo Rol</h4>
				</div>
				<div class='modal-body'>
					<div class="row">
						<div class="col-xs-6 col-md-4">
							<label for="SL_modulo_uxa">Seleccione el módulo</label>
						</div>
						<div class="col-xs-12 col-md-8">
							<select class="form-control selectpicker" data-live-search="true" id="SL_modulo_uxa"></select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-4">
							<label for="SL_actividad_uxa">Seleccione la actividad</label>
						</div>
						<div class="col-xs-12 col-md-8">
							<select class="form-control selectpicker" data-live-search="true" id="SL_actividad_uxa">
								<option value="0">Seleccione un Módulo</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<button class="form-control btn btn-success" id="BT_consultar_usuarios_actividad">Consultar usuarios</button>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<div class="table-responsive" id="resultado_usuarios_actividad" style="max-height:250px;overflow-y:scroll;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>