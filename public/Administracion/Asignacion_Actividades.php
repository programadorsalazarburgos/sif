<?php
	session_start();
	if(!isset($_SESSION["session_username"])) {
		header("location:index.php");
	} else {
		$Id_Persona= $_SESSION["session_username"];
	}
	include("../../Controlador/Administracion/C_Asignacion_Actividades.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Asignación De Actividades</title>
<!--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    
  	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  
  	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
  	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 


<!--     <link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script> -->

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 	
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script> 	


	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script> 

    <script type="text/javascript" src="Js/Asignacion_Actividades.js"></script>


</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Asignación de actividades <small>Menú SICREA</small></h1>
			</div>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#usuario_especifico" role="tab">A usuario especifico</a></li>
				<!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#usuarios_rol" role="tab">Usuarios de rol</a></li>-->
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="usuario_especifico" role="tabpanel">
					<div class="alert alert-warning text-justify" role="alert">
						<strong>Buscar usuario: </strong> En el siguiente cuadro de texto puede buscar usando el documento de identidad o los nombres, luego al mostrar los resultados podrá seleccionar unicamente un(01)  usuario para ver y/o cambiar el acceso a las actividades.
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Apellidos Nombres o Documento del usuario" aria-describedby="basic-addon1" id="TB_buscar_usuario">
								<span class="input-group-btn"><button class="btn btn-info" id="BT_buscar"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1">
									<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
								</span>
								<input type="text" class="form-control" disabled="disabled" aria-describedby="basic-addon2" id="TB_nombre_usuario">
							</div>
						</div>
					</div>
					<div id="resultado_busqueda"></div>
					<div id="actividades_usuarios"></div>
				</div>
				<div class="tab-pane" id="usuarios_rol" role="tabpanel">
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<div class="alert alert-success text-justify" role="alert">
								<strong>Seleccionar rol: </strong> Usando los siguientes seleccionables puede asignar una actividad especifica a <b>TODOS</b> los usuarios que tienen un rol especifico asignado.
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_rol">Seleccione el rol:</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<select class="form-control" id="SL_rol"></select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_modulo">Seleccione un módulo:</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<select class="form-control" id="SL_modulo"></select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_actividad">Seleccione una actividad:</label>
						</div>
						<div class="col-xs-12 col-md-9">
							<select class="form-control" id="SL_actividad"></select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3 col-md-3">
							<a href="#" class="form-control btn btn-warning" id="Bt_mostrar_usuarios_rol_con_actividad" title="Ver Usuarios con esta actividad en su rol">Ver</a>
						</div>
						<div class="col-xs-3 col-xs-offset-2 col-md-3 col-md-offset-2">
							<button type="button" class="form-control btn btn-primary" id="BT_asignar_actividad_rol" title="Asignar actividad a los usuarios">Asignar<span id="span_total_usuarios_rol" class="badge">(00)</span></button>
						</div>
						<div class="col-xs-3 col-xs-offset-1 col-md-3 col-md-offset-1">
							<a href="#" class="form-control btn btn-danger" id="BT_remover_actividad_rol" title="Remover actividad a los usuarios">Remover<span id="span_total_usuarios_rol_actividad" class="badge">(00)</span></a>
						</div>
					</div>
					<div class="row" id="div_table_usuarios_rol_actividad">
						<div class="col-xs-12 col-md-12 table-responsive">
							<table id="table_usuarios_rol_actividad" class="table table-hover">
								<thead>
									<tr>
										<th>Identificación</th>
										<th>Nombre Completo</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>